<?php

namespace App\Services\Payroll;

use App\Models\Period;
use Illuminate\Support\Facades\Response;

class JorService
{
    protected $type_id_jor = [
        "01" => "D.N.I.",
        "02" => "C.E.",
        "00" => "Carnet Militar y Policial",
        "00" => "Libreta Adolecentes Trabajador",
        "07" => "Pasaporte",
        "00" => "Inexistente/Afilia",
        "23" => "P.T.P.",
        "00" => "Carné de Relaciones Exteriores",
        "24" => "Cedula Identidad de Extranjero",
        "09" => "Carné Solicitante de Refugio",
        "26" => "C.P.P",
    ];

    public function generateJorArray(int $period_id): array
    {
        $jor_list = [];
        try {
            $period = Period::find($period_id);
            foreach ($period->payments as $payment) {
                $identity_type = array_search($payment->contract->employee->identity_type->name, $this->type_id_jor);
                $weekly_multiplier = 4.2;
                array_push($jor_list, [
                    'employee' => $payment->contract->employee,
                    'jor_atributes' => [
                        ($identity_type !== false) ? ((string) $identity_type) : "0",
                        $payment->contract->employee->identity_number,
                        $payment->contract->working_hours * $weekly_multiplier,
                        "0",
                        "0",
                        "0",
                    ]
                ]);
            }
            return $jor_list;
        } catch (\Exception $th) {
            return [];
        }
    }

    public function getTypesId(): array
    {
        return $this->type_id_jor;
    }

    public function onlyValuesAfpNet($jor_list): array
    {
        return array_map(fn($item) => $item['jor_atributes'], $jor_list);
    }

    public function prepareTemplateJor($jor_list) : string
    {
        try {
            // Contenido del archivo de texto
            $content = "";
    
            $data = array_map(fn($item) => $item['jor_atributes'], $jor_list);
    
            foreach ($data as $row) {
                $content .= implode('|', $row) . "\n";
            }
    
            // Generar la respuesta de descarga
            return $content;
        } catch (\Exception $th) {
            return "";
        }
    }
}
