<?php

namespace App\Livewire\BudgetaryObjectives;

use Livewire\Component;

class FormEdit extends Component
{
    public $budgetary_objective;
    public
        $programa_pptal,
        $producto_proyecto,
        $activ_obra_accinv,
        $funcion,
        $division_fn,
        $grupo_fn,
        $sec_func,
        $cas_classifier,
        $essalud_classifier,
        $aguinaldo_classifier,
        $name;


    public function mount(){
        $this->programa_pptal = $this->budgetary_objective->programa_pptal;
        $this->producto_proyecto = $this->budgetary_objective->producto_proyecto;
        $this->activ_obra_accinv = $this->budgetary_objective->activ_obra_accinv;
        $this->funcion = $this->budgetary_objective->funcion;
        $this->division_fn = $this->budgetary_objective->division_fn;
        $this->grupo_fn = $this->budgetary_objective->grupo_fn;
        $this->sec_func = $this->budgetary_objective->sec_func;
        $this->cas_classifier = $this->budgetary_objective->cas_classifier;
        $this->essalud_classifier = $this->budgetary_objective->essalud_classifier;
        $this->aguinaldo_classifier = $this->budgetary_objective->aguinaldo_classifier;
        $this->name = $this->budgetary_objective->name;
    }

    public function save()
    {
        $this->validate([
            'programa_pptal' => 'required|numeric|digits:4',
            'producto_proyecto' => 'required|numeric|digits:7',
            'activ_obra_accinv' => 'required|numeric|digits:7',
            'funcion' => 'required|numeric|digits:2',
            'division_fn' => 'required|numeric|digits:3',
            'grupo_fn' => 'required|numeric|digits:4',
            'sec_func' => 'required|numeric|max:99',
            'cas_classifier' => 'nullable|string|max:20',
            'essalud_classifier' => 'nullable|string|max:20',
            'aguinaldo_classifier' => 'nullable|string|max:20',
            'name' => 'required|string|max:300',
        ]);
        try {
            $this->budgetary_objective->update([
                'programa_pptal' => $this->programa_pptal,
                'producto_proyecto' => $this->producto_proyecto,
                'activ_obra_accinv' => $this->activ_obra_accinv,
                'funcion' => $this->funcion,
                'division_fn' => $this->division_fn,
                'grupo_fn' => $this->grupo_fn,
                'sec_func' => $this->sec_func,
                'cas_classifier' => $this->cas_classifier,
                'essalud_classifier' => $this->essalud_classifier,
                'aguinaldo_classifier' => $this->aguinaldo_classifier,
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
