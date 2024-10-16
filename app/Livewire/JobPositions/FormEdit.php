<?php

namespace App\Livewire\JobPositions;

use Livewire\Component;

class FormEdit extends Component
{
    public $job_position;
    public $name;

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
        ]);
        try {
            $this->job_position->update([
                'name' => $this->name,
            ]);
            $this->dispatch('message', code: '200', content: 'Se ha editado');
        } catch (\Exception $ex) {
            $this->dispatch('message', code: '500', content: 'No se pudo crear');
        }
    }

    public function mount(){
        $this->name = $this->job_position->name;
    }

    public function render()
    {
        return view('livewire.job-positions.form-edit');
    }
}
