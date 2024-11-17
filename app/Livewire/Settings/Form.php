<?php

namespace App\Livewire\Settings;

use App\Models\Setting;
use Livewire\Component;

class Form extends Component
{
    public $institution_name, $ruc, $airhsp_code, $essalud_percent, $onp_percent, $working_hours, $uit,$max_amount_essalud_percent;

    public function save(){
        $this->validate([
            'institution_name' => 'required|string|max:255',
            'ruc' => 'required|numeric|digits:11',
            'airhsp_code' => 'required|numeric|digits:6',
            'uit' => 'required|numeric|min:0|max:10000',
            'max_amount_essalud_percent' => 'required|numeric|min:0|max:100',
            'essalud_percent' => 'required|numeric|min:0|max:100',
            'onp_percent' => 'required|numeric|min:0|max:100',
            'working_hours' => 'required|numeric|max:20',
        ]);
        try {
            Setting::where('key', 'institution_name')->first()->update(['value' => $this->institution_name]);
            Setting::where('key', 'ruc')->first()->update(['value' => $this->ruc]);
            Setting::where('key', 'airhsp_code')->first()->update(['value' => $this->airhsp_code]);
            Setting::where('key', 'uit')->first()->update(['value' => $this->uit]);
            Setting::where('key', 'max_amount_essalud_percent')->first()->update(['value' => $this->max_amount_essalud_percent]);
            Setting::where('key', 'essalud_percent')->first()->update(['value' => $this->essalud_percent]);
            Setting::where('key', 'onp_percent')->first()->update(['value' => $this->onp_percent]);
            Setting::where('key', 'working_hours')->first()->update(['value' => $this->working_hours]);    
            $this->dispatch('message', code: '200', content: 'Se actualizaron los datos');
        } catch (\Exception $th) {
            $this->dispatch('message', code: '500', content: 'Algo salió mal');
        }
    }

    public function mount(){
        $this->institution_name = Setting::where('key', 'institution_name')->first()->value;
        $this->ruc = Setting::where('key', 'ruc')->first()->value;
        $this->airhsp_code = Setting::where('key', 'airhsp_code')->first()->value;
        $this->uit = Setting::where('key', 'uit')->first()->value;
        $this->max_amount_essalud_percent = Setting::where('key', 'max_amount_essalud_percent')->first()->value;
        $this->essalud_percent = Setting::where('key', 'essalud_percent')->first()->value;
        $this->onp_percent = Setting::where('key', 'onp_percent')->first()->value;
        $this->working_hours = Setting::where('key', 'working_hours')->first()->value;
    }

    public function render()
    {
        return view('livewire.settings.form');
    }
}
