<?php

namespace App\Livewire\Payrolls;

use App\Models\Employee;
use App\Models\FundingResource;
use App\Models\Group;
use App\Models\PayrollType;
use Livewire\Component;

class FormEdit extends Component
{
    public $payroll;

    public $payroll_types, $funding_resources, $employees, $groups;

    public $number, $period, $processing_date, $payroll_type_id, $funding_resource_id;

    public $modal_employee_id, $modal_group_id;

    public $employees_list = [];

    public function addGroup()
    {
        $employees_group = Employee::where('group_id', $this->modal_group_id)->get();

        foreach ($employees_group as $employee) {
            if (!$this->theEmployeeIsIncluded($employee->id)) {
                array_push($this->employees_list, $employee);
            }
        }
    }
    public function addEmployee()
    {
        if ($this->theEmployeeIsIncluded($this->modal_employee_id)) {
            $this->dispatch('message', code: '500', content: 'Ya está incluido');
            return;
        }
        $employee = Employee::find($this->modal_employee_id);
        array_push($this->employees_list, $employee);
    }

    private function theEmployeeIsIncluded($employee_id)
    {
        foreach ($this->employees_list as $employee) {
            if ($employee->id == intval($employee_id)) {
                return true;
            }
        }
        return false;
    }

    public function deleteEmployee($employee_id)
    {
        foreach ($this->employees_list as $key => $employee) {
            if ($employee->id == $employee_id) {
                unset($this->employees_list[$key]);
                // Método para re-indexar array
                $this->employees_list = array_values($this->employees_list);
                break;
            }
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

        if (count($this->employees_list) < 1) {
            $this->dispatch('message', code: '500', content: 'Agrege al menos un empleado');
            return;
        }

        try {
            $this->payroll->update([
                'number' => $this->number,
                'period' => $this->period,
                'processing_date' => $this->processing_date,
                'payroll_type_id' => $this->payroll_type_id,
                'funding_resource_id' => $this->funding_resource_id,
            ]);

            $ids_employees = collect($this->employees_list)->pluck('id')->toArray();
            $this->payroll->employees()->sync($ids_employees);

            $this->dispatch('message', code: '200', content: 'Se ha editado');
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

        $this->number = $this->payroll->number;
        $this->period=$this->payroll->period;
        $this->processing_date=$this->payroll->processing_date;
        $this->payroll_type_id=$this->payroll->payroll_type_id;
        $this->funding_resource_id=$this->payroll->funding_resource_id;

        foreach ($this->payroll->employees as $employee) {
            array_push($this->employees_list, $employee);
        }
    }

    public function render()
    {
        return view('livewire.payrolls.form-edit');
    }
}
