<?php

namespace App\Livewire\Afps;

use App\Models\Afp;
use Livewire\Component;
use Symfony\Component\DomCrawler\Crawler;

class ComissionUpdate extends Component
{
    public $source_code;
    public $afps_list = [];

    public function viewComissions()
    {
        $this->validate([
            'source_code' => 'required|string'
        ]);
        try {
            $crawler = new Crawler($this->source_code);
            $this->afps_list = $crawler->filter('table table tr')->each(function ($row) {
                $data = $row->filter('td')->each(function ($cell) {
                    return $cell->text();
                });

                return $data;
            });

            /**
             * RESULTS ARRAY
             * 4=HABITAT, 5=INTEGRA, 6=PRIMA, 7=PROFUTURO
             * 0=NAME, 1=COMISIÓN FLUJO, 2=COMISIÓN ANUAL, 3=PRIMA DE SEGUROS, 4=APORTE OBLIGATORIO. 5=REMUNERACIÓN MÁX ASEGURABLE
             */
            foreach ($this->afps_list as $key => $value) {
                if($value[0] !== 'HABITAT' && $value[0] !== 'INTEGRA' && $value[0] !== 'PRIMA' && $value[0] !== 'PROFUTURO'){
                    unset($this->afps_list[$key]);
                }
            }
            $this->afps_list = array_values($this->afps_list);
            // dd($this->afps_list);
        } catch (\Exception $th) {
            $this->dispatch('message', code: '500', content: 'Algo salió mal');
        }
    }

    private function formatPercentage($value)
    {
        // Eliminar el símbolo de porcentaje
        $value = str_replace('%', '', $value);

        // Reemplazar la coma por un punto
        $value = str_replace(',', '.', $value);

        // Convertir a número flotante y retornar el valor formateado
        return (float) $value;
    }

    public function updateComissions()
    {
        try {
            foreach ($this->afps_list as $key => $value) {
                $afp = Afp::where('name', $value['0'])->first();
                if ($afp) {
                    $afp->update([
                        'obligatory_contribution' => $this->formatPercentage($value[4]),
                        'life_insurance' => $this->formatPercentage($value[3]),
                        'variable_commission' => $this->formatPercentage($value[2]),
                    ]);
                }
            }
            $this->reset('source_code', 'afps_list');

            $this->dispatch('message', code: '200', content: 'Se actualizaron las comisiones');
            $this->dispatch('refresh_afps');
        } catch (\Exception $th) {
            $this->dispatch('message', code: '500', content: 'Algo salió mal');
        }
    }

    public function render()
    {
        return view('livewire.afps.comission-update');
    }
}
