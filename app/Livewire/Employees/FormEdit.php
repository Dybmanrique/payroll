<?php

namespace App\Livewire\Employees;

use App\Models\Afp;
use App\Models\BudgetaryObjective;
use App\Models\Contract;
use App\Models\IdentityType;
use App\Models\JobPosition;
use App\Models\JudicialDiscount;
use App\Models\Level;
use Livewire\Component;
use Livewire\Features\SupportPagination\WithoutUrlPagination;
use Livewire\WithPagination;

class FormEdit extends Component
{
    use WithPagination, WithoutUrlPagination;
    public $employee;

    public $job_positions, $levels, $afps, $budgetary_objectives, $identity_types;

    //EMPLOYEE ATRIBUTTES
    public
        $identity_number,
        $identity_type_id,
        $birthdate,
        $airhsp_code,
        $name,
        $last_name,
        $second_last_name,
        $bank_account,
        $date_entry,
        $cuarta,
        $ruc,
        $gender,
        $pension_system;

    public $afp_code, $afp_fing, $afp_id;

    //MODAL JUDICIAL DISCOUNTS ATRIBUTES
    public $judicial_name, $judicial_amount, $judicial_discount_type, $judicial_account, $judicial_dni;
    public $judicial_discounts = [];
    public $judicial_edit_mode = false;
    public $judicial_selected = null;

    //MODAL CONTRACTS ATRIBUTES
    public $remuneration,
        $start_validity,
        $end_validity,
        $job_position_id,
        $level_id,
        $budgetary_objective_id,
        $working_hours;

    // public $contracts = [];
    public $contract_mode = "ADD";
    public $contract_selected = null;

    public function addJudicialDiscount()
    {
        $this->validate([
            'judicial_name' => 'required|string|max:255',
            'judicial_amount' => 'required|numeric|min:0|max:99999',
            'judicial_discount_type' => 'required|string|max:255',
            'judicial_account' => 'nullable|numeric',
            'judicial_dni' => 'nullable|numeric',
        ]);

        if (trim($this->judicial_account) == "") $this->judicial_account = null;
        if (trim($this->judicial_dni) == "") $this->judicial_dni = null;

        if ($this->judicial_edit_mode) {
            $this->judicial_selected->update([
                'name' => $this->judicial_name,
                'amount' => $this->judicial_amount,
                'discount_type' => $this->judicial_discount_type,
                'account' => $this->judicial_account,
                'dni' => $this->judicial_dni,
            ]);
        } else {
            JudicialDiscount::create([
                'name' => $this->judicial_name,
                'amount' => $this->judicial_amount,
                'discount_type' => $this->judicial_discount_type,
                'account' => $this->judicial_account,
                'dni' => $this->judicial_dni,
                'is_deleted' => false,
                'employee_id' => $this->employee->id,
            ]);

            $this->reset(['judicial_name', 'judicial_amount', 'judicial_discount_type', 'judicial_account', 'judicial_dni']);
        }

        $this->dispatch('message', code: '200', content: 'Hecho');
        $this->judicial_discounts = JudicialDiscount::where('employee_id', $this->employee->id)->where('is_deleted', false)->get();
    }

    public function enableJudicialEdition($judicial_discount_id)
    {
        $this->judicial_edit_mode = true;
        $this->judicial_selected = JudicialDiscount::find($judicial_discount_id);
        $this->judicial_name = $this->judicial_selected->name;
        $this->judicial_amount = $this->judicial_selected->amount;
        $this->judicial_discount_type = $this->judicial_selected->discount_type;
        $this->judicial_account = $this->judicial_selected->account;
        $this->judicial_dni = $this->judicial_selected->dni;
    }

    public function deleteJudicial($judicial_discount_id)
    {
        try {
            $judicial = JudicialDiscount::find($judicial_discount_id);
            if (count($judicial->payments) > 0) {
                $judicial->update([
                    'is_deleted' => true,
                ]);
            } else {
                $judicial->delete();
            }
            $this->dispatch('message', code: '200', content: 'Eliminado');
            $this->judicial_discounts = JudicialDiscount::where('employee_id', $this->employee->id)->where('is_deleted', false)->get();
        } catch (\Exception $th) {
            $this->dispatch('message', code: '500', content: 'Algo salió mal');
        }
    }

    public function addContract()
    {
        $this->validate([
            'remuneration' => 'required|numeric|min:0|max:100000',
            'working_hours' => 'required|numeric|min:0|max:1000',
            'start_validity' => 'required|date',
            'end_validity' => 'required|date',
            'level_id' => 'required|numeric',
            'job_position_id' => 'required|numeric',
            'budgetary_objective_id' => 'required|numeric',
        ]);

        switch ($this->contract_mode) {
            case 'ADD':
                Contract::create([
                    'remuneration' => $this->remuneration,
                    'start_validity' => $this->start_validity,
                    'end_validity' => $this->end_validity,
                    'working_hours' => $this->working_hours,
                    'employee_id' => $this->employee->id,
                    'job_position_id' => $this->job_position_id,
                    'level_id' => $this->level_id,
                    'budgetary_objective_id' => $this->budgetary_objective_id,
                ]);

                $this->reset([
                    'remuneration',
                    'start_validity',
                    'end_validity',
                    'working_hours',
                    'job_position_id',
                    'level_id',
                    'budgetary_objective_id'
                ]);
                break;

            case 'EDIT':
                $this->contract_selected->update([
                    'remuneration' => $this->remuneration,
                    'start_validity' => $this->start_validity,
                    'end_validity' => $this->end_validity,
                    'working_hours' => $this->working_hours,
                    'job_position_id' => $this->job_position_id,
                    'level_id' => $this->level_id,
                    'budgetary_objective_id' => $this->budgetary_objective_id,
                ]);

                break;

            default:

                break;
        }

        $this->dispatch('message', code: '200', content: 'Hecho');
        $this->resetPage();
    }

    public function changeContractMode($contract_id, $mode = 'EDIT')
    {
        $this->contract_mode = $mode;
        $this->contract_selected = Contract::find($contract_id);

        $this->remuneration = $this->contract_selected->remuneration;
        $this->start_validity = $this->contract_selected->start_validity;
        $this->end_validity = $this->contract_selected->end_validity;
        $this->working_hours = $this->contract_selected->working_hours;
        $this->job_position_id = $this->contract_selected->job_position_id;
        $this->level_id = $this->contract_selected->level_id;
        $this->budgetary_objective_id = $this->contract_selected->budgetary_objective_id;
        $this->dispatch('set_meta', value: $this->contract_selected->budgetary_objective_id);
    }

    public function deleteContract($contract_id)
    {
        Contract::find($contract_id)->delete();
        $this->dispatch('message', code: '200', content: 'Eliminado');
        $this->resetPage();
        // $this->contracts = Contract::where('employee_id', $this->employee->id)->get();
    }

    public function save()
    {
        $this->validate([
            'identity_number' => 'required',
            'identity_type_id' => 'required',
            'birthdate' => 'required',
            'airhsp_code' => 'nullable',
            'name' => 'required',
            'last_name' => 'required',
            'second_last_name' => 'required',
            'bank_account' => 'required',
            'date_entry' => 'required',
            'cuarta' => 'required|boolean',
            'ruc' => 'nullable',
            'gender' => 'required',
            'pension_system' => 'required',
        ]);

        $has_afp = ($this->pension_system === 'afp');

        if ($has_afp) {
            $this->validate([
                'afp_id' => 'required',
                'afp_code' => 'required',
                'afp_fing' => 'required',
            ]);
        }

        try {
            $this->employee->update([
                'identity_number' => $this->identity_number,
                'identity_type_id' => $this->identity_type_id,
                'birthdate' => $this->birthdate,
                'airhsp_code' => $this->airhsp_code,
                'name' => $this->name,
                'last_name' => $this->last_name,
                'second_last_name' => $this->second_last_name,
                'bank_account' => $this->bank_account,
                'date_entry' => $this->date_entry,
                'cuarta' => $this->cuarta,
                'ruc' => $this->ruc,
                'gender' => $this->gender,
                'pension_system' => $this->pension_system,
            ]);

            if ($has_afp) {
                $this->employee->update([
                    'afp_id' => $this->afp_id,
                    'afp_code' => $this->afp_code,
                    'afp_fing' => $this->afp_fing,
                ]);
            } else {
                $this->employee->update([
                    'afp_id' => null,
                    'afp_code' => null,
                    'afp_fing' => null,
                ]);
            }

            $this->dispatch('message', code: '200', content: 'Se ha editado');
        } catch (\Exception $th) {
            $this->dispatch('message', code: '500', content: 'Algo salió mal');
        }
    }

    public function mount()
    {
        $this->job_positions = JobPosition::all();
        $this->levels = Level::all();
        $this->afps = Afp::all();
        $this->budgetary_objectives = BudgetaryObjective::all();
        $this->identity_types = IdentityType::all();

        $this->identity_number = $this->employee->identity_number;
        $this->identity_type_id = $this->employee->identity_type_id;
        $this->birthdate = $this->employee->birthdate;
        $this->airhsp_code = $this->employee->airhsp_code;
        $this->name = $this->employee->name;
        $this->last_name = $this->employee->last_name;
        $this->second_last_name = $this->employee->second_last_name;
        $this->bank_account = $this->employee->bank_account;
        $this->date_entry = $this->employee->date_entry;
        $this->cuarta = $this->employee->cuarta;
        $this->ruc = $this->employee->ruc;
        $this->gender = $this->employee->gender;
        $this->pension_system = $this->employee->pension_system;

        if ($this->employee->pension_system === 'afp') {
            $this->afp_id = $this->employee->afp_id;
            $this->afp_code = $this->employee->afp_code;
            $this->afp_fing = $this->employee->afp_fing;
        }

        $this->judicial_discounts = JudicialDiscount::where('employee_id', $this->employee->id)->where('is_deleted', false)->get();
        // $this->contracts = Contract::where('employee_id', $this->employee->id)->get();
    }

    public function render()
    {
        return view('livewire.employees.form-edit', [
            'contracts' => Contract::where('employee_id', $this->employee->id)->orderByDesc('id')->paginate(4),
        ]);
    }
}
