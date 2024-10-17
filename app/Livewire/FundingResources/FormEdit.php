<?php

namespace App\Livewire\FundingResources;

use Livewire\Component;

class FormEdit extends Component
{
    public $funding_resource;
    public $name,$code;

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|numeric|digits_between:1,5',
        ]);
        try {
            $this->funding_resource->update([
                'name' => $this->name,
                'code' => $this->code,
            ]);
            $this->dispatch('message', code: '200', content: 'Se ha editado');
        } catch (\Exception $ex) {
            $this->dispatch('message', code: '500', content: 'No se pudo crear');
        }
    }

    public function mount(){
        $this->name = $this->funding_resource->name;
        $this->code = $this->funding_resource->code;
    }

    public function render()
    {
        return view('livewire.funding-resources.form-edit');
    }
}
