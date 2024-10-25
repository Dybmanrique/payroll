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

    public $number, $period, $processing_date, $payroll_type_id, $funding_resource_id;

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
        $this->dispatch('closeModalPeriod');
        $this->dispatch('message', code: '200', content: 'Hecho');
    }

    public function searchEmployees()
    {
        $this->payments_list = [];
        if (!Period::find($this->selected_period)) {
            $this->payments_list = [];
            return;
        }
        $this->payments_list = Payment::where('period_id', $this->selected_period)->get();
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
        Payment::find($employee_id)->delete();
        $this->payments_list = Payment::where('period_id', $this->selected_period)->get();
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
            $this->dispatch('message', code: '200', content: 'Se actualizó el valor');
        } catch (\Exception $th) {
            $this->dispatch('message', code: '500', content: 'Ocurrió un error inesperado');
        }
    }

    public function save()
    {
        $this->validate([
            'number' => 'required|string|max:255',
            'period' => 'required|string|max:255',
            'processing_date' => 'required|date',
            'payroll_type_id' => 'required|numeric',
            'funding_resource_id' => 'required|numeric',
        ]);

        // if (count($this->payments_list) < 1) {
        //     $this->dispatch('message', code: '500', content: 'Agrege al menos un empleado');
        //     return;
        // }

        try {
            $this->payroll->update([
                'number' => $this->number,
                'period' => $this->period,
                'processing_date' => $this->processing_date,
                'payroll_type_id' => $this->payroll_type_id,
                'funding_resource_id' => $this->funding_resource_id,
            ]);

            // $ids_employees = collect($this->payments_list)->pluck('id')->toArray();
            // $this->payroll->employees()->sync($ids_employees);

            $this->dispatch('message', code: '200', content: 'Se ha actualizaron los datos generales');
        } catch (\Exception $ex) {
            $this->dispatch('message', code: '500', content: 'No se pudo crear');
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
        $this->period = $this->payroll->period;
        $this->processing_date = $this->payroll->processing_date;
        $this->payroll_type_id = $this->payroll->payroll_type_id;
        $this->funding_resource_id = $this->payroll->funding_resource_id;

        // foreach ($this->payroll->employees as $employee) {
        //     array_push($this->payments_list, $employee);
        // }
    }

    public function render()
    {
        return view('livewire.payrolls.form-edit');
    }
}
