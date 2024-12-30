<?php

namespace App\Livewire\IdentityTypes;

use App\Models\IdentityType;
use Livewire\Component;

class FormCreate extends Component
{
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
            IdentityType::create([
                'code' => $this->code,
                'name' => $this->name,
                'description' => $this->description,
            ]);
            $this->reset('code','name','description');
            $this->dispatch('message', code: '200', content: 'Se ha creado');
        } catch (\Exception $ex) {
            $this->dispatch('message', code: '500', content: 'No se pudo crear');
        }
    }

    public function render()
    {
        return view('livewire.identity-types.form-create');
    }
}
