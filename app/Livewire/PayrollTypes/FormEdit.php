<?php

namespace App\Livewire\PayrollTypes;

use Livewire\Component;

class FormEdit extends Component
{
    public $payroll_type;
    public $name;

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
        ]);
        try {
            $this->payroll_type->update([
                'name' => $this->name,
            ]);
            $this->dispatch('message', code: '200', content: 'Se ha editado');
        } catch (\Exception $ex) {
            $this->dispatch('message', code: '500', content: 'No se pudo crear');
        }
    }

    public function mount(){
        $this->name = $this->payroll_type->name;
    }

    public function render()
    {
        return view('livewire.payroll-types.form-edit');
    }
}
