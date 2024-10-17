<?php

namespace App\Livewire\FundingResources;

use App\Models\FundingResource;
use Livewire\Component;

class FormCreate extends Component
{
    public $name, $code;

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|numeric|digits_between:1,5',
        ]);
        try {
            FundingResource::create([
                'name' => $this->name,
                'code' => $this->code,
            ]);
            $this->reset('name','code');
            $this->dispatch('message', code: '200', content: 'Se ha creado');
        } catch (\Exception $ex) {
            $this->dispatch('message', code: '500', content: 'No se pudo crear');
        }
    }

    public function render()
    {
        return view('livewire.funding-resources.form-create');
    }
}
