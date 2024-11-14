<?php

namespace App\Livewire\BudgetaryObjectives;

use App\Models\BudgetaryObjective;
use Livewire\Component;

class FormCreate extends Component
{


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
        $name,
        $year;

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
            'year' => 'required|numeric|digits:4',
        ]);
        try {
            BudgetaryObjective::create([
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
                'year' => $this->year,
            ]);

            $this->reset(
                'programa_pptal',
                'producto_proyecto',
                'activ_obra_accinv',
                'funcion',
                'division_fn',
                'grupo_fn',
                'sec_func',
                'cas_classifier',
                'essalud_classifier',
                'aguinaldo_classifier',
                'name',
                'year',
            );
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
