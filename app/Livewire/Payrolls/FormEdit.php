<?php

namespace App\Livewire\Payrolls;

use App\Exports\AfpNetExport;
use App\Models\Contract;
use App\Models\Employee;
use App\Models\FundingResource;
use App\Models\Group;
use App\Models\Payment;
use App\Models\PayrollType;
use App\Models\Period;
use App\Models\Setting;
use App\Services\Payroll\AfpNetService;
use App\Services\Payroll\JorService;
use App\Services\Payroll\PaymentService;
use Carbon\Carbon;
use Livewire\Component;

class FormEdit extends Component
{
    public $payroll;

    public $payroll_types, $funding_resources, $employees, $groups;

    public $number, $year, $payroll_type_id, $funding_resource_id;

    public $modal_employee_id, $modal_group_id;

    public $periods = [1 => 'ENERO', 2 => 'FEBRERO', 3 => 'MARZO', 4 => 'ABRIL', 5 => 'MAYO', 6 => 'JUNIO', 7 => 'JULIO', 8 => 'AGOSTO', 9 => 'SETIEMBRE', 10 => 'OCTUBRE', 11 => 'NOVIEMBRE', 12 => 'DICIEMBRE'];
    public $periods_payroll;
    public $selected_period;

    public $payments_list = [];

    public function addPeriod($mounth)
    {
        if (count($this->payroll->periods->where('mounth', $mounth)) >= 1) {
            $this->dispatch('message', code: '500', content: "El periodo de {$this->periods[$mounth]} ya está incluido");
            return;
        }
        $this->payroll->periods()->create([
            'mounth' => $mounth
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
            $this->dispatch('message', code: '500', content: 'Algo salió mal');
        }
    }

    public $employee_target = null;
    public function searchContracts($employee_id)
    {
        try {
            $this->employee_target = Employee::find($employee_id);
        } catch (\Exception $th) {
            $this->dispatch('message', code: '500', content: 'Algo salió mal');
        }
    }

    public $employees_group_list = [];
    public function searchContractsGroup($group_id)
    {
        $this->employees_group_list = [];
        if ($group_id === "" || $group_id === null) {
            return;
        }
        try {
            $group = Group::findOrFail($group_id);
            $this->employees_group_list = $group->employees;
        } catch (\Exception $th) {
            $this->dispatch('message', code: '500', content: 'Algo salió mal');
        }
    }

    public function addContract($contract_id)
    {
        if ($this->theContractIsIncluded($contract_id)) {
            $this->dispatch('message', code: '500', content: 'Ya está incluido');
            return;
        }
        $contract = Contract::find($contract_id);
        Payment::create([
            'basic' => $contract->remuneration,
            'contract_id' => $contract->id,
            'period_id' => $this->selected_period,
        ]);

        $this->payments_list = Payment::where('period_id', $this->selected_period)->get();
        $this->dispatch('message', code: '200', content: 'Se agregó');
    }

    private function theContractIsIncluded($contract_id)
    {
        foreach ($this->payments_list as $payment) {
            if ($payment->contract->id == intval($contract_id)) {
                return true;
            }
        }
        return false;
    }

    public function deleteContract($contract_id)
    {
        try {
            Payment::find($contract_id)->delete();
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

    public $afp_net_list = [];
    public $type_id_afp = [];
    public function prepare_afp_net()
    {
        $this->afp_net_list = $this->afp_net_service->generateAfpArray($this->selected_period);
    }

    public function changeValueAfp($index, $row, $value)
    {
        $this->afp_net_list[$index]['afp_atributes'][$row] = $value;
    }

    public function exportAfpNet()
    {
        try {
            return (new AfpNetExport)->forList($this->afp_net_service->onlyValuesAfpNet($this->afp_net_list))->download('afp_net.xlsx');
        } catch (\Exception $th) {
            $this->dispatch('message', code: '500', content: 'Algo salió mal');
        }
    }

    public $jor_list = [];
    protected $type_id_jor;

    public function prepare_jor()
    {
        $this->jor_list = $this->jor_service->generateJorArray($this->selected_period);
    }

    public function changeValueJor($index, $row, $value)
    {
        $this->jor_list[$index]['jor_atributes'][$row] = $value;
    }

    public function exportJor()
    {
        try {
            $fileName = $this->jor_service->generateFileName($this->selected_period);
            $content = $this->jor_service->onlyValuesJor($this->jor_list);

            return response()->streamDownload(function () use ($content) {
                echo $content;
            }, $fileName, ['Content-Type' => 'text/plain']);
        } catch (\Exception $th) {
            $this->dispatch('message', code: '500', content: 'Algo salió mal');
        }
    }

    public function export_rem()
    {
        return redirect()->route('payrolls.rem', Period::find($this->selected_period));
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
        return redirect()->route('payrolls.mcpp', Period::find($this->selected_period));
    }

    public function calculate()
    {
        if ($this->payment_service->calculate($this->selected_period)) {
            $this->payments_list = Payment::where('period_id', $this->selected_period)->get();
            $this->dispatch('message', code: '200', content: 'Se realizaron los calculos');
        } else {
            $this->dispatch('message', code: '500', content: 'Algo salió mal');
        }
    }

    public function mount()
    {
        $this->type_id_afp = $this->afp_net_service->getTypesId();
        $this->type_id_jor = $this->jor_service->getTypesId();
        $this->payroll_types = PayrollType::all();
        $this->funding_resources = FundingResource::all();
        $this->employees = Employee::all();
        $this->groups = Group::all();
        $this->periods_payroll = Period::where('payroll_id', $this->payroll->id)->orderBy('mounth')->get();

        $this->number = $this->payroll->number;
        $this->year = $this->payroll->year;
        $this->payroll_type_id = $this->payroll->payroll_type_id;
        $this->funding_resource_id = $this->payroll->funding_resource_id;
    }

    protected $payment_service;
    protected $afp_net_service;
    protected $jor_service;
    public function __construct()
    {
        $this->payment_service = new PaymentService;
        $this->afp_net_service = new AfpNetService;
        $this->jor_service = new JorService;
    }

    public function render()
    {
        return view('livewire.payrolls.form-edit');
    }
}
