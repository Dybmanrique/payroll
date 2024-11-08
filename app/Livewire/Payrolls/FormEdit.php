<?php

namespace App\Livewire\Payrolls;

use App\Models\Employee;
use App\Models\FundingResource;
use App\Models\Group;
use App\Models\Payment;
use App\Models\PayrollType;
use App\Models\Period;
use Livewire\Component;

class FormEdit extends Component
{
    public $payroll;

    public $payroll_types, $funding_resources, $employees, $groups;

    public $number, $year, $payroll_type_id, $funding_resource_id;

    public $modal_employee_id, $modal_group_id, $modal_period_id;

    public $periods = [1 => 'ENERO', 2 => 'FEBRERO', 3 => 'MARZO', 4 => 'ABRIL', 5 => 'MAYO', 6 => 'JUNIO', 7 => 'JULIO', 8 => 'AGOSTO', 9 => 'SETIEMBRE', 10 => 'OCTUBRE', 11 => 'NOVIEMBRE', 12 => 'DICIEMBRE'];
    public $periods_payroll;
    public $selected_period;

    public $payments_list = [];

    public function addPeriod()
    {
        if (count($this->payroll->periods->where('mounth', $this->modal_period_id)) >= 1) {
            $this->dispatch('message', code: '500', content: "El periodo de {$this->periods[$this->modal_period_id]} ya está incluido");
            return;
        }
        $this->payroll->periods()->create([
            'mounth' => $this->modal_period_id
        ]);
        $this->periods_payroll = Period::where('payroll_id', $this->payroll->id)->orderBy('mounth')->get();

        $this->dispatch('message', code: '200', content: 'Hecho');
    }

    public function searchEmployees()
    {
        $this->validate([
            'selected_period' => 'required|numeric'
        ]);
        $this->payments_list = [];
        if (!Period::find($this->selected_period)) {
            $this->payments_list = [];
            return;
        }
        $this->payments_list = Payment::where('period_id', $this->selected_period)->get();
    }

    public function deletePeriod()
    {
        $this->validate([
            'selected_period' => 'required|numeric'
        ]);
        try {
            Period::find($this->selected_period)->delete();
            $this->selected_period = "";
            $this->payments_list = [];
            $this->periods_payroll = Period::where('payroll_id', $this->payroll->id)->orderBy('mounth')->get();
            $this->dispatch('message', code: '200', content: 'Se eliminó el periodo');
        } catch (\Exception $th) {
            $this->dispatch('message', code: '200', content: 'Algo salió mal');
        }
    }

    public function addGroup()
    {
        try {
            $employees_group = Employee::where('group_id', $this->modal_group_id)->get();

            foreach ($employees_group as $employee) {
                if (!$this->theEmployeeIsIncluded($employee->id)) {
                    Payment::create([
                        'basic' => $employee->remuneration,
                        'employee_id' => $employee->id,
                        'period_id' => $this->selected_period,
                    ]);
                }
            }
            $this->payments_list = Payment::where('period_id', $this->selected_period)->get();
            $this->dispatch('message', code: '200', content: 'Se incluyó al grupo');
        } catch (\Exception $th) {
            $this->dispatch('message', code: '500', content: 'Algo salió mal');
        }
    }
    public function addEmployee()
    {
        if ($this->theEmployeeIsIncluded($this->modal_employee_id)) {
            $this->dispatch('message', code: '500', content: 'Ya está incluido');
            return;
        }
        $employee = Employee::find($this->modal_employee_id);
        Payment::create([
            'basic' => $employee->remuneration,
            'employee_id' => $employee->id,
            'period_id' => $this->selected_period,
        ]);

        $this->payments_list = Payment::where('period_id', $this->selected_period)->get();
        $this->dispatch('message', code: '200', content: 'Se agregó');
    }

    private function theEmployeeIsIncluded($employee_id)
    {
        foreach ($this->payments_list as $payment) {
            if ($payment->employee->id == intval($employee_id)) {
                return true;
            }
        }
        return false;
    }

    public function deleteEmployee($employee_id)
    {
        try {
            Payment::find($employee_id)->delete();
            $this->payments_list = Payment::where('period_id', $this->selected_period)->get();
            $this->dispatch('message', code: '200', content: 'Se eliminó correctamente');
        } catch (\Exception $th) {
            $this->dispatch('message', code: '500', content: 'Algo salió mal');
        }
    }

    public function changeValuePayment($payment_id, $field, $value)
    {
        try {
            $payment = Payment::find($payment_id);
            if ($payment) {
                $payment->update([
                    $field => $value,
                ]);
            }
            $this->dispatch('message_toastr', code: '200', content: 'Se actualizó el valor');
        } catch (\Exception $th) {
            $this->dispatch('message', code: '500', content: 'Ocurrió un error inesperado');
        }
    }

    private function has_employees()
    {
        return (count($this->payments_list) >= 1);
    }

    public function save()
    {
        $this->validate([
            'number' => 'required|numeric|digits:4',
            'year' => 'required|numeric|digits:4',
            'payroll_type_id' => 'required|numeric',
            'funding_resource_id' => 'required|numeric',
        ]);

        try {
            $this->payroll->update([
                'number' => $this->number,
                'year' => $this->year,
                'payroll_type_id' => $this->payroll_type_id,
                'funding_resource_id' => $this->funding_resource_id,
            ]);

            $this->dispatch('message', code: '200', content: 'Se ha actualizaron los datos generales');
        } catch (\Exception $ex) {
            $this->dispatch('message', code: '500', content: 'No se pudo crear');
        }
    }

    public function mcpp()
    {
        if (!$this->has_employees()) {
            return;
        }
        return redirect()->route('payrolls.mcpp', Period::find($this->selected_period));
    }

    public function calculate()
    {
        if (!$this->has_employees()) {
            return;
        }
        define("ONP_COMISSION", 0.13);
        define("ESSALUD", 0.09);
        define("CUARTA", 0.08);
        define("WORKING_HOURS", 8);
        define("WORKING_MINUTES", 480);

        try {
            $year = Period::find($this->selected_period);
            foreach ($year->payments as $key => $payment) {
                $employee = $payment->employee;
                $payment->onp_discount = $payment->afp_discount = $payment->essalud = null;

                if ($employee->pension_system === 'afp') {
                    $payment->obligatory_afp = ($payment->basic + $payment->refound) * ($employee->afp->obligatory_contribution / 100);
                    $payment->life_insurance_afp = ($payment->basic + $payment->refound) * ($employee->afp->life_insurance / 100);
                    $payment->variable_afp = ($payment->basic + $payment->refound) * ($employee->afp->variable_commission / 100);

                    $payment->afp_discount = $payment->obligatory_afp + $payment->life_insurance_afp + $payment->variable_afp;
                }
                if ($employee->pension_system === 'onp') {
                    $payment->onp_discount = ($payment->basic + $payment->refound) * ONP_COMISSION;
                }
                if ($employee->essalud) {
                    $payment->essalud = ($payment->basic + $payment->refound) * ESSALUD;
                }
                if ($employee->cuarta) {
                    $payment->cuarta = ($payment->basic + $payment->refound) * CUARTA;
                }
                $days_discount = ($payment->basic / $payment->days) * $payment->days_discount;
                $hours_discount = ($payment->basic / $payment->days / WORKING_HOURS) * $payment->hours_discount;
                $minutes_discount = ($payment->basic / $payment->days / WORKING_MINUTES) * $payment->minutes_discount;
                $payment->fines_discount = $days_discount + $hours_discount + $minutes_discount;
                if ($payment->fines_discount === 0.00) $payment->fines_discount = null;

                $payment->total_remuneration = $payment->basic + $payment->refound + $payment->aguinaldo;
                $payment->total_discount = $payment->afp_discount + $payment->onp_discount + $payment->fines_discount + $payment->cuarta;

                $payment->net_pay = $payment->total_remuneration - $payment->total_discount;
                $payment->save();
            }

            $this->payments_list = Payment::where('period_id', $this->selected_period)->get();
            $this->dispatch('message', code: '200', content: 'Se realizaron los calculos');
        } catch (\Exception $th) {
            $this->dispatch('message', code: '500', content: 'Algo salió mal');
        }
    }

    public function mount()
    {
        $this->payroll_types = PayrollType::all();
        $this->funding_resources = FundingResource::all();
        $this->employees = Employee::all();
        $this->groups = Group::where('name', '!=', 'Ninguno')->get();
        $this->periods_payroll = Period::where('payroll_id', $this->payroll->id)->orderBy('mounth')->get();

        $this->number = $this->payroll->number;
        $this->year = $this->payroll->year;
        $this->payroll_type_id = $this->payroll->payroll_type_id;
        $this->funding_resource_id = $this->payroll->funding_resource_id;
    }

    public function render()
    {
        return view('livewire.payrolls.form-edit');
    }
}
