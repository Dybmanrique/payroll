<?php

namespace App\Livewire\Employees;

use App\Models\Employee;
use App\Models\Group;
use App\Models\JobPosition;
use App\Models\Level;
use Livewire\Component;

class FormCreate extends Component
{
    public $groups, $job_positions, $levels;

    public $dni, $birthdate, $airhsp_code, $name, $last_name, $second_last_name, $start_validity, $end_validity,
        $bank_account, $date_entry, $working_hours, $essalud, $ruc, $gender, $group_id, $job_position_id, $level_id;

    public $onp = true;

    public $pension_system;

    public function save()
    {
        $this->validate([
            'dni' => 'required',
            'birthdate' => 'required',
            'airhsp_code' => 'required',
            'name' => 'required',
            'last_name' => 'required',
            'second_last_name' => 'required',
            'start_validity' => 'required',
            'end_validity' => 'required',
            'bank_account' => 'required',
            'date_entry' => 'required',
            'working_hours' => 'required',
            'essalud' => 'required',
            'ruc' => 'required',
            'gender' => 'required',
            'group_id' => 'required',
            'job_position_id' => 'required',
            'level_id' => 'required',
        ]);

        if ($this->pension_system == 'afp') {
            $this->onp = false;
        }

        try {
            Employee::create([
                'dni' => $this->dni,
                'birthdate' => $this->birthdate,
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
                'ruc' => $this->ruc,
                'gender' => $this->gender,
                'group_id' => $this->group_id,
                'job_position_id' => $this->job_position_id,
                'level_id' => $this->level_id,
                'onp' => $this->onp,
            ]);
    
            $this->reset('dni',
            'birthdate',
            'airhsp_code',
            'name',
            'last_name',
            'second_last_name',
            'start_validity',
            'end_validity',
            'bank_account',
            'date_entry',
            'working_hours',
            'essalud',
            'ruc',
            'gender',
            'group_id',
            'job_position_id',
            'level_id',);
            $this->dispatch('message', code: '200', content: 'Se ha creado');
        } catch (\Exception $th) {
            $this->dispatch('message', code: '500', content: 'Algo salió mal');
        }
    }

    public function mount()
    {
        $this->groups = Group::all();
        $this->job_positions = JobPosition::all();
        $this->levels = Level::all();
    }

    public function render()
    {
        return view('livewire.employees.form-create');
    }
}
