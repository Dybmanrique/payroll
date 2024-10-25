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

    public function save()
    {
        $this->validate([
            'number' => 'required|string|max:255',
            'period' => 'required|string|max:255',
            'processing_date' => 'required|date',
            'payroll_type_id' => 'required|numeric',
            'funding_resource_id' => 'required|numeric',
        ]);

        try {
            $payroll = Payroll::create([
                'number' => $this->number,
                'period' => $this->period,
                'processing_date' => $this->processing_date,
                'payroll_type_id' => $this->payroll_type_id,
                'funding_resource_id' => $this->funding_resource_id,
            ]);

            $this->dispatch('message', code: '200', content: 'Se ha creado, redireccionando...');
            return redirect()->route('payrolls.edit', $payroll);
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
