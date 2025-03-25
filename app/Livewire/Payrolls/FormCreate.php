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

    public $number, $year, $payroll_type_id, $funding_resource_id, $name;

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'number' => 'required|numeric|digits:4',
            'year' => 'required|numeric|digits:4',
            'payroll_type_id' => 'required|numeric',
            'funding_resource_id' => 'required|numeric',
        ]);

        try {
            $payroll = Payroll::create([
                'name' => $this->name,
                'number' => $this->number,
                'year' => $this->year,
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
        $lastDocument = Payroll::where('year', $currentYear)
            ->orderBy('id', 'desc')
            ->first();

        $number = $lastDocument ? intval(substr($lastDocument->number, 0, 4)) + 1 : 1;
        $formattedNumber = str_pad($number, 4, '0', STR_PAD_LEFT);

        return $formattedNumber;
    }

    public function mount()
    {
        $this->payroll_types = PayrollType::all();
        $this->funding_resources = FundingResource::all();

        $this->number = $this->generateNewNumber();
        $this->year = date('Y');
    }

    public function render()
    {
        return view('livewire.payrolls.form-create');
    }
}
