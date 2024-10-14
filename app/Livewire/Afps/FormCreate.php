<?php

namespace App\Livewire\Afps;

use App\Models\Afp;
use Livewire\Component;

class FormCreate extends Component
{
    public $name, $obligatory_contribution, $life_insurance, $variable_commission;

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'obligatory_contribution' => 'required|numeric|min:0|max:100',
            'life_insurance' => 'required|numeric|min:0|max:100',
            'variable_commission' => 'required|numeric|min:0|max:100',
        ]);
        try {
            Afp::create([
                'name' => $this->name,
                'obligatory_contribution' => $this->obligatory_contribution,
                'life_insurance' => $this->life_insurance,
                'variable_commission' => $this->variable_commission,
            ]);
            $this->reset('name', 'obligatory_contribution', 'life_insurance', 'variable_commission');
            $this->dispatch('message', code: '200', content: 'Se ha creado');
        } catch (\Exception $ex) {
            $this->dispatch('message', code: '500', content: 'No se pudo crear');
        }
    }

    public function render()
    {
        return view('livewire.afps.form-create');
    }
}
