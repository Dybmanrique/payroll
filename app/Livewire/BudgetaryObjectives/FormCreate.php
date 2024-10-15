<?php

namespace App\Livewire\BudgetaryObjectives;

use App\Models\BudgetaryObjective;
use Livewire\Component;

class FormCreate extends Component
{
    public $pneumonic, $function, $program, $subprogram,
        $program_p, $act_proy, $component, $cas_classifier, $essalud_classifier, $name;

    public function save()
    {
        $this->validate([
            'pneumonic' => 'required|string|max:255',
            'function' => 'required|string|max:255',
            'program' => 'required|string|max:255',
            'subprogram' => 'required|string|max:255',
            'program_p' => 'required|string|max:255',
            'act_proy' => 'required|string|max:255',
            'component' => 'required|string|max:255',
            'cas_classifier' => 'required|string|max:255',
            'essalud_classifier' => 'required|string|max:255',
            'name' => 'required|string|max:255',
        ]);
        try {
            BudgetaryObjective::create([
                'pneumonic' => $this->pneumonic,
                'function' => $this->function,
                'program' => $this->program,
                'subprogram' => $this->subprogram,
                'program_p' => $this->program_p,
                'act_proy' => $this->act_proy,
                'component' => $this->component,
                'cas_classifier' => $this->cas_classifier,
                'essalud_classifier' => $this->essalud_classifier,
                'name' => $this->name,
            ]);
    
            $this->reset('name', 'pneumonic', 'function', 'program','subprogram','program_p', 'act_proy', 'component', 'cas_classifier', 'essalud_classifier');
            $this->dispatch('message', code: '200', content: 'Se ha creado');
        } catch (\Exception $th) {
            $this->dispatch('message', code: '500', content: 'No se pudo crear');
        }        
    }

    public function render()
    {
        return view('livewire.budgetary-objectives.form-create');
    }
}
