<?php

namespace App\Livewire\Groups;

use Livewire\Component;

class FormEdit extends Component
{
    public $group;
    public $name;

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
        ]);
        try {
            $this->group->update([
                'name' => $this->name,
            ]);
            $this->dispatch('message', code: '200', content: 'Se ha editado');
        } catch (\Exception $ex) {
            $this->dispatch('message', code: '500', content: 'No se pudo crear');
        }
    }

    public function mount(){
        $this->name = $this->group->name;
    }

    public function render()
    {
        return view('livewire.groups.form-edit');
    }
}
