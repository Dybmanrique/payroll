<?php

namespace App\Livewire\JobPositions;

use App\Models\JobPosition;
use Livewire\Component;

class FormCreate extends Component
{
    public $name;

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
        ]);
        try {
            JobPosition::create([
                'name' => $this->name,
            ]);
            $this->reset('name');
            $this->dispatch('message', code: '200', content: 'Se ha creado');
        } catch (\Exception $ex) {
            $this->dispatch('message', code: '500', content: 'No se pudo crear');
        }
    }

    public function render()
    {
        return view('livewire.job-positions.form-create');
    }
}
