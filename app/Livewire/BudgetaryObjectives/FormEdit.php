<?php

namespace App\Livewire\BudgetaryObjectives;

use Livewire\Component;

class FormEdit extends Component
{
    public $budgetary_objective;
    public $pneumonic, $function, $program, $subprogram,
        $program_p, $act_proy, $component, $cas_classifier, $essalud_classifier, $name;


    public function mount(){
        $this->pneumonic = $this->budgetary_objective->pneumonic;
        $this->function = $this->budgetary_objective->function;
        $this->program = $this->budgetary_objective->program;
        $this->subprogram = $this->budgetary_objective->subprogram;
        $this->program_p = $this->budgetary_objective->program_p;
        $this->act_proy = $this->budgetary_objective->act_proy;
        $this->component = $this->budgetary_objective->component;
        $this->cas_classifier = $this->budgetary_objective->cas_classifier;
        $this->essalud_classifier = $this->budgetary_objective->essalud_classifier;
        $this->name = $this->budgetary_objective->name;
    }

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
            $this->budgetary_objective->update([
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
    
            $this->dispatch('message', code: '200', content: 'Se ha editado');
        } catch (\Exception $th) {
            $this->dispatch('message', code: '500', content: 'No se pudo crear');
        }        
    }

    public function render()
    {
        return view('livewire.budgetary-objectives.form-edit');
    }
}
