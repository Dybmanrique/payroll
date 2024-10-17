<?php

namespace App\Livewire\Employees;

use App\Models\Afp;
use App\Models\BudgetaryObjective;
use App\Models\Group;
use App\Models\JobPosition;
use App\Models\Level;
use Livewire\Component;

class FormEdit extends Component
{
    public $employee;

    public $groups, $job_positions, $levels, $afps, $budgetary_objectives;

    //EMPLOYEE ATRIBUTTES
    public 
    $dni,
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
    $ruc,
    $gender,
    $group_id,
    $job_position_id,
    $level_id,
    $pension_system,
    $budgetary_objective_id;

    public $afp_code, $afp_fing, $afp_id;

    public function save()
    {
        $this->validate([
            'dni' => 'required',
            'birthdate' => 'required',
            'airhsp_code' => 'required',
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
            'ruc' => 'required',
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
                'dni' => $this->dni,
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
                'ruc' => $this->ruc,
                'gender' => $this->gender,
                'group_id' => $this->group_id,
                'job_position_id' => $this->job_position_id,
                'level_id' => $this->level_id,
                'budgetary_objective_id' => $this->budgetary_objective_id,
                'pension_system' => $this->pension_system,
            ]);

            if ($has_afp) {
                $this->employee->afps()->detach();
                $this->employee->afps()->attach($this->afp_id, ['afp_code' => $this->afp_code, 'afp_fing' => $this->afp_fing]);
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

        $this->dni = $this->employee->dni;
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
        $this->ruc = $this->employee->ruc;
        $this->gender = $this->employee->gender;
        $this->group_id = $this->employee->group_id;
        $this->job_position_id = $this->employee->job_position_id;
        $this->level_id = $this->employee->level_id;
        $this->budgetary_objective_id = $this->employee->budgetary_objective_id;
        $this->pension_system = $this->employee->pension_system;

        if ($this->employee->pension_system === 'afp') {
            if ($afp = $this->employee->afps()->first()) {
                $this->afp_id = $afp->id;
                $this->afp_code = $afp->pivot->afp_code;
                $this->afp_fing = $afp->pivot->afp_fing;
            }
        }
    }

    public function render()
    {
        return view('livewire.employees.form-edit');
    }
}
