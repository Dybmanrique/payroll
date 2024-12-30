<?php

namespace App\Livewire\IdentityTypes;

use Livewire\Component;

class FormEdit extends Component
{
    public $identity_type;
    public $code;
    public $name;
    public $description;

    public function save()
    {
        $this->validate([
            'code' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1255',
        ]);
        try {
            $this->identity_type->update([
                'code' => $this->code,
                'name' => $this->name,
                'description' => $this->description,
            ]);
            $this->dispatch('message', code: '200', content: 'Se ha editado');
        } catch (\Exception $ex) {
            $this->dispatch('message', code: '500', content: 'No se pudo crear');
        }
    }

    public function mount(){
        $this->code = $this->identity_type->code;
        $this->name = $this->identity_type->name;
        $this->description = $this->identity_type->description;
    }

    public function render()
    {
        return view('livewire.identity-types.form-edit');
    }
}
