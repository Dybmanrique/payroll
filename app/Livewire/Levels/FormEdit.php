<?php

namespace App\Livewire\Levels;

use Livewire\Component;

class FormEdit extends Component
{
    public $level;
    public $name;

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
        ]);
        try {
            $this->level->update([
                'name' => $this->name,
            ]);
            $this->dispatch('message', code: '200', content: 'Se ha editado');
        } catch (\Exception $ex) {
            $this->dispatch('message', code: '500', content: 'No se pudo crear');
        }
    }

    public function mount(){
        $this->name = $this->level->name;
    }

    public function render()
    {
        return view('livewire.levels.form-edit');
    }
}
