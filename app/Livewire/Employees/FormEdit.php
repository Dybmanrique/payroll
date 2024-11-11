<?php

namespace App\Livewire\Employees;

use App\Models\Afp;
use App\Models\BudgetaryObjective;
use App\Models\Group;
use App\Models\IdentityType;
use App\Models\JobPosition;
use App\Models\JudicialDiscount;
use App\Models\Level;
use Livewire\Component;

class FormEdit extends Component
{
    public $employee;

    public $groups, $job_positions, $levels, $afps, $budgetary_objectives, $identity_types;

    //EMPLOYEE ATRIBUTTES
    public
        $identity_number,
        $identity_type_id,
        $birthdate,
        $airhsp_code,
        $remuneration,
        $name,
        $last_name,
        $second_last_name,
        $start_validity,
        $end_validity,
        $bank_account,
        $date_entry,
        $working_hours,
        $essalud,
        $cuarta,
        $ruc,
        $gender,
        $group_id,
        $job_position_id,
        $level_id,
        $pension_system,
        $budgetary_objective_id;

    public $afp_code, $afp_fing, $afp_id;

    public $judicial_name, $judicial_amount, $judicial_discount_type, $judicial_account, $judicial_dni;
    public $judicial_discounts = [];
    public $judicial_edit_mode = false;
    public $judicial_selected = null;

    public function addJudicialDiscount()
    {
        $this->validate([
            'judicial_name' => 'required|string|max:255',
            'judicial_amount' => 'required|numeric|min:0|max:99999',
            'judicial_discount_type' => 'required|string|max:255',
            'judicial_account' => 'nullable|numeric',
            'judicial_dni' => 'nullable|numeric',
        ]);

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
                'employee_id' => $this->employee->id,
            ]);

            $this->reset(['judicial_name', 'judicial_amount', 'judicial_discount_type', 'judicial_account', 'judicial_dni']);
        }

        $this->dispatch('message', code: '200', content: 'Hecho');
        $this->judicial_discounts = JudicialDiscount::where('employee_id', $this->employee->id)->get();
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

    public function deleteJudicial($judicial_discount_id){
        JudicialDiscount::find($judicial_discount_id)->delete();
        $this->dispatch('message', code: '200', content: 'Eliminado');
        $this->judicial_discounts = JudicialDiscount::where('employee_id', $this->employee->id)->get();

    }

    public function save()
    {
        $this->validate([
            'identity_number' => 'required',
            'identity_type_id' => 'required',
            'birthdate' => 'required',
            'airhsp_code' => 'nullable',
            'remuneration' => 'required',
            'name' => 'required',
            'last_name' => 'required',
            'second_last_name' => 'required',
            'start_validity' => 'required',
            'end_validity' => 'required',
            'bank_account' => 'required',
            'date_entry' => 'required',
            'working_hours' => 'required',
            'essalud' => 'required|boolean',
            'cuarta' => 'required|boolean',
            'ruc' => 'nullable',
            'gender' => 'required',
            'group_id' => 'required',
            'job_position_id' => 'required',
            'level_id' => 'required',
            'budgetary_objective_id' => 'required',
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
                'remuneration' => $this->remuneration,
                'name' => $this->name,
                'last_name' => $this->last_name,
                'second_last_name' => $this->second_last_name,
                'start_validity' => $this->start_validity,
                'end_validity' => $this->end_validity,
                'bank_account' => $this->bank_account,
                'date_entry' => $this->date_entry,
                'working_hours' => $this->working_hours,
                'essalud' => $this->essalud,
                'cuarta' => $this->cuarta,
                'ruc' => $this->ruc,
                'gender' => $this->gender,
                'group_id' => $this->group_id,
                'job_position_id' => $this->job_position_id,
                'level_id' => $this->level_id,
                'budgetary_objective_id' => $this->budgetary_objective_id,
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
        $this->groups = Group::all();
        $this->job_positions = JobPosition::all();
        $this->levels = Level::all();
        $this->afps = Afp::all();
        $this->budgetary_objectives = BudgetaryObjective::all();
        $this->identity_types = IdentityType::all();

        $this->identity_number = $this->employee->identity_number;
        $this->identity_type_id = $this->employee->identity_type_id;
        $this->birthdate = $this->employee->birthdate;
        $this->airhsp_code = $this->employee->airhsp_code;
        $this->remuneration = $this->employee->remuneration;
        $this->name = $this->employee->name;
        $this->last_name = $this->employee->last_name;
        $this->second_last_name = $this->employee->second_last_name;
        $this->start_validity = $this->employee->start_validity;
        $this->end_validity = $this->employee->end_validity;
        $this->bank_account = $this->employee->bank_account;
        $this->date_entry = $this->employee->date_entry;
        $this->working_hours = $this->employee->working_hours;
        $this->essalud = $this->employee->essalud;
        $this->cuarta = $this->employee->cuarta;
        $this->ruc = $this->employee->ruc;
        $this->gender = $this->employee->gender;
        $this->group_id = $this->employee->group_id;
        $this->job_position_id = $this->employee->job_position_id;
        $this->level_id = $this->employee->level_id;
        $this->budgetary_objective_id = $this->employee->budgetary_objective_id;
        $this->pension_system = $this->employee->pension_system;

        if ($this->employee->pension_system === 'afp') {
            $this->afp_id = $this->employee->afp_id;
            $this->afp_code = $this->employee->afp_code;
            $this->afp_fing = $this->employee->afp_fing;
        }

        $this->judicial_discounts = JudicialDiscount::where('employee_id', $this->employee->id)->get();
    }

    public function render()
    {
        return view('livewire.employees.form-edit');
    }
}
