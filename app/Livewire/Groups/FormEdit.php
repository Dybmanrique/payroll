<?php

namespace App\Livewire\Groups;

use App\Models\Employee;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class FormEdit extends Component
{
    public $group;
    public $name, $employee_id;
    public $employees_group;

    public $employees;

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
        ]);
        try {
            $this->group->update([
                'name' => $this->name,
            ]);
            $this->dispatch('message', code: '200', content: 'Se ha editado');
        } catch (\Exception $ex) {
            $this->dispatch('message', code: '500', content: 'No se pudo crear');
        }
    }

    private function getEmployeesGroup($group_id){
        return DB::table('employees')
        ->join('group_employee', 'employees.id', '=', 'group_employee.employee_id')
        ->join('identity_types', 'employees.identity_type_id', '=', 'identity_types.id')
        ->where('group_employee.group_id', $this->group->id)
        ->select('employees.id', 'employees.identity_number', 'employees.name', 'employees.last_name', 'employees.second_last_name', 'identity_types.name as identity_type')
        ->get();
    }

    private function isEmployeeIncluded($employee_id)
    {
        foreach ($this->group->employees as $employee) {
            if ($employee->id === (int) $employee_id)
                return true;
        }
        return false;
    }

    public function addEmployee()
    {
        $this->validate([
            'employee_id' => 'required|numeric|min:0',
        ]);

        if ($this->isEmployeeIncluded($this->employee_id)) {
            $this->dispatch('message', code: '500', content: 'El empleado ya está incluido');
            return;
        }

        $this->group->employees()->attach($this->employee_id);
        $this->employees_group = $this->getEmployeesGroup($this->group->id);
        $this->dispatch('message', code: '200', content: 'Se ha agregado');
        try {
        } catch (\Exception $ex) {
            $this->dispatch('message', code: '500', content: 'Algo salió mal');
        }
    }

    public function removeEmployee($employee_id)
    {
        try {
            $this->group->employees()->detach($employee_id);
            $this->employees_group = $this->getEmployeesGroup($this->group->id);
            $this->dispatch('message', code: '200', content: 'Se ha quitado');
        } catch (\Exception $ex) {
            $this->dispatch('message', code: '500', content: 'Algo salió mal');
        }
    }

    public function mount()
    {
        $this->name = $this->group->name;
        $this->employees = Employee::all();
        $this->employees_group = $this->getEmployeesGroup($this->group->id);
    }

    public function render()
    {
        return view('livewire.groups.form-edit',);
    }
}
