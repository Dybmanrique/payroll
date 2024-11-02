<?php

namespace App\Livewire\PayrollTypes;

use App\Models\PayrollType;
use Livewire\Component;

class FormCreate extends Component
{
    public $name, $description;

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);
        try {
            PayrollType::create([
                'name' => $this->name,
                'description' => $this->description,
            ]);
            $this->reset('name','description');
            $this->dispatch('message', code: '200', content: 'Se ha creado');
        } catch (\Exception $ex) {
            $this->dispatch('message', code: '500', content: 'No se pudo crear');
        }
    }

    public function render()
    {
        return view('livewire.payroll-types.form-create');
    }
}
