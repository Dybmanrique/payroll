<?php

namespace App\Livewire\Afps;

use Livewire\Component;

class FormEdit extends Component
{
    public $afp;
    public $name, $obligatory_contribution, $life_insurance, $variable_commission;
    
    public function mount(){
        $this->name = $this->afp->name;
        $this->obligatory_contribution = $this->afp->obligatory_contribution;
        $this->life_insurance = $this->afp->life_insurance;
        $this->variable_commission = $this->afp->variable_commission;
    }

    public function save(){
        $this->validate([
            'name' => 'required|string|max:255',
            'obligatory_contribution' => 'required|numeric|min:0|max:100',
            'life_insurance' => 'required|numeric|min:0|max:100',
            'variable_commission' => 'required|numeric|min:0|max:100',
        ]);

        $this->afp->update([
            'name' => $this->name,
            'obligatory_contribution' => $this->obligatory_contribution,
            'life_insurance' => $this->life_insurance,
            'variable_commission' => $this->variable_commission,
        ]);
        
        $this->dispatch('message', code: '200', content: 'Se ha editado');
    }

    public function render()
    {
        return view('livewire.afps.form-edit');
    }
}
