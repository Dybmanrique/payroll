<?php

namespace App\Livewire\Payrolls;

use App\Models\Employee;
use App\Models\FundingResource;
use App\Models\Group;
use App\Models\Payroll;
use App\Models\PayrollType;
use Livewire\Component;

class FormCreate extends Component
{
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
                // Método para re-indexar
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
        
        if(count($this->employees_list)<1){
            $this->dispatch('message', code: '500', content: 'Agrege al menos un empleado');
            return;
        }

        try {
            $payroll = Payroll::create([
                'number' => $this->number,
                'period' => $this->period,
                'processing_date' => $this->processing_date,
                'payroll_type_id' => $this->payroll_type_id,
                'funding_resource_id' => $this->funding_resource_id,
            ]);
    
            $ids_employees = collect($this->employees_list)->pluck('id')->toArray();
            $payroll->employees()->attach($ids_employees);
    
            $this->reset('number', 'payroll_type_id', 'funding_resource_id');
            $this->employees_list = [];
            $this->number = $this->generateNewNumber();
            $this->dispatch('message', code: '200', content: 'Se ha creado');
        } catch (\Exception $ex) {
            $this->dispatch('message', code: '500', content: 'No se pudo crear');
        }
    }

    private function generateNewNumber(): string
    {
        $currentYear = date('Y');
        $lastDocument = Payroll::whereYear('created_at', $currentYear)
            ->orderBy('id', 'desc')
            ->first();

        $number = $lastDocument ? intval(substr($lastDocument->number, 0, 3)) + 1 : 1;
        $formattedNumber = str_pad($number, 3, '0', STR_PAD_LEFT);

        return "{$formattedNumber}-{$currentYear}";
    }

    private function generatePeriod(): string
    {
        $currentYear = date('Y');
        $currentMount = date('m');

        return "{$currentYear}{$currentMount}";
    }

    public function mount()
    {
        $this->payroll_types = PayrollType::all();
        $this->funding_resources = FundingResource::all();
        $this->employees = Employee::all();
        $this->groups = Group::where('name', '!=', 'Ninguno')->get();

        $this->processing_date = date('Y-m-d');
        $this->number = $this->generateNewNumber();
        $this->period = $this->generatePeriod();
    }

    public function render()
    {
        return view('livewire.payrolls.form-create');
    }
}
