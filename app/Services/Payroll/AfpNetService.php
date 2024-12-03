<?php

namespace App\Services\Payroll;

use App\Models\Period;

class AfpNetService
{
    protected $type_id_afp = [
        0 => "D.N.I.",
        1 => "C.E.",
        2 => "Carnet Militar y Policial",
        3 => "Libreta Adolecentes Trabajador",
        4 => "Pasaporte",
        5 => "Inexistente/Afilia",
        6 => "P.T.P.",
        7 => "Carné de Relaciones Exteriores",
        8 => "Cedula Identidad de Extranjero",
        9 => "Carné Solicitante de Refugio",
        10 => "C.P.P",
    ];

    public function generateAfpArray(int $period_id) : array
    {
        $afp_net_list = [];
        $count = 0;
        try {
            $period = Period::find($period_id);
            foreach ($period->payments as $payment) {
                if ($payment->afp_discount) {
                    $identity_type = array_search($payment->contract->employee->identity_type->name, $this->type_id_afp);

                    $count++;
                    array_push($afp_net_list, [
                        'employee' => $payment->contract->employee,
                        'afp_atributes' => [
                            $count,
                            $payment->contract->employee->afp_code,
                            ($identity_type !== false) ? ((string) $identity_type) : "0",
                            $payment->contract->employee->identity_number,
                            $payment->contract->employee->last_name,
                            $payment->contract->employee->second_last_name,
                            $payment->contract->employee->name,
                            'S',
                            'N',
                            'N',
                            null,
                            $payment->basic + $payment->refound,
                            "0",
                            "0",
                            "0",
                            "N",
                            null,
                        ]
                    ]);
                }
            }
            return $afp_net_list;
        } catch (\Exception $th) {
            return [];
        }
    }

    public function getTypesId() : array {
        return $this->type_id_afp;
    }

    public function onlyValuesAfpNet($afp_net_list) : array{
        return array_map(fn($item) => $item['afp_atributes'], $afp_net_list);
    }
}
