<?php

namespace App\Livewire\Employees;

use App\Models\Afp;
use App\Models\BudgetaryObjective;
use App\Models\Employee;
use App\Models\Group;
use App\Models\IdentityType;
use App\Models\JobPosition;
use App\Models\Level;
use Livewire\Component;

class FormCreate extends Component
{
    public $groups, $job_positions, $levels, $afps, $budgetary_objectives, $identity_types;

    //EMPLOYEE ATRIBUTTES
    public 
    $identity_number,
    $identity_type_id,
    $birthdate,
    $remuneration,
    $airhsp_code,
    $name, 
    $last_name, 
    $second_last_name, 
    $start_validity, 
    $end_validity,
    $bank_account,
    $date_entry,
    $working_hours, 
    $essalud=0,
    $cuarta=0,
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
            'identity_number' => 'required',
            'birthdate' => 'required',
            'remuneration' => 'required',
            'airhsp_code' => 'nullable',
            'name' => 'required',
            'last_name' => 'required',
            'second_last_name' => 'required',
            'start_validity' => 'required',
            'end_validity' => 'required',
            'bank_account' => 'required',
            'date_entry' => 'required',
            'working_hours' => 'required',
            'essalud' => 'required',
            'cuarta' => 'required',
            'ruc' => 'nullable',
            'gender' => 'required',
            'group_id' => 'required',
            'job_position_id' => 'required',
            'level_id' => 'required',
            'budgetary_objective_id' => 'required',
            'pension_system' => 'required',
        ]);

        if($this->pension_system === 'afp'){
            $this->validate([
                'afp_id' => 'required',
                'afp_code' => 'required',
                'afp_fing' => 'required',
            ]);
        }

        try {
            $employee = Employee::create([
                'identity_number' => $this->identity_number,
                'identity_type_id' => $this->identity_type_id,
                'birthdate' => $this->birthdate,
                'remuneration' => $this->remuneration,
                'airhsp_code' => $this->airhsp_code,
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
    
            if ($this->pension_system==='afp') {
                $employee->update([
                    'afp_id'=>$this->afp_id,
                    'afp_code'=>$this->afp_code,
                    'afp_fing'=>$this->afp_fing,
                ]);
            }
    
            $this->reset('identity_number',
            'birthdate',
            'airhsp_code',
            'remuneration',
            'name',
            'last_name',
            'second_last_name',
            'start_validity',
            'end_validity',
            'bank_account',
            'date_entry',
            'working_hours',
            'ruc',
            'gender',
            'group_id',
            'job_position_id',
            'level_id',
            'budgetary_objective_id',
            'pension_system',
            'afp_code',
            'afp_fing',
            'afp_id');
            $this->essalud = false;
            $this->cuarta = false;
            $this->identity_type_id = 1;
            $this->dispatch('message', code: '200', content: 'Se ha creado');
            $this->dispatch('hide_afp');
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
        $this->identity_type_id = 1;
    }

    public function render()
    {
        return view('livewire.employees.form-create');
    }
}
