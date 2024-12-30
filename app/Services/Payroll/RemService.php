<?php

namespace App\Services\Payroll;

use App\Models\Period;
use App\Models\Setting;

class RemService
{
    protected $type_id_rem = [
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

    protected $rem_codes = [
        '2039' => 'HONORARIOS',
        '0607' => 'ONP',
        '0608' => 'AFP AP OBLIG',
        '0606' => 'AFP SEGURO',
        '0601' => 'AFP COM VAR',
        '0618' => 'CUARTA CATEGORÍA',
        '0704' => 'TARDANZAS',
        '0705' => 'INASISTENCIAS',
        '0703' => 'DESCUENTO JUDICIAL',
        '0804' => 'ESSALUD',
    ];

    public function getRemCodes(): array
    {
        return $this->rem_codes;
    }

    public function generateRemArray(int $period_id): array
    {
        $rem_list = [];
        try {
            $period = Period::find($period_id);
            foreach ($period->payments as $payment) {
                $identity_document_type = array_search($payment->contract->employee->identity_type->name, $this->type_id_rem);
                $employee = $payment->contract->employee;
                $rem_item = [];
                //HONORARIOS
                array_push($rem_item, [$identity_document_type, $employee->identity_number, '2039', $payment->total_remuneration, $payment->total_remuneration]);
                //ONP
                if ($payment->onp_discount !== null) {
                    array_push($rem_item, [$identity_document_type, $employee->identity_number, '0607', $payment->total_remuneration, $payment->onp_discount]);
                }

                //AFP
                if ($payment->afp_discount !== null) {
                    //AFP AP OBLIG
                    array_push($rem_item, [$identity_document_type, $employee->identity_number, '0608', $payment->total_remuneration, $payment->obligatory_afp]);

                    //AFP SEGURO
                    array_push($rem_item, [$identity_document_type, $employee->identity_number, '0606', $payment->total_remuneration, $payment->life_insurance_afp]);

                    //AFP COM VAR
                    array_push($rem_item, [$identity_document_type, $employee->identity_number, '0601', $payment->total_remuneration, $payment->variable_afp]);
                }

                //CUARTA CATEGORÍA
                if ($payment->cuarta !== null) {
                    array_push($rem_item, [$identity_document_type, $employee->identity_number, '0618', $payment->total_remuneration, $payment->cuarta]);
                }

                //FALTAS Y TARDANZAS
                if ($payment->fines_discount !== null) {
                    //0705	INASISTENCIAS -- 0704	TARDANZAS
                    if($payment->days_discount !== null){
                        array_push($rem_item, [$identity_document_type, $employee->identity_number, '0705', $payment->total_remuneration, $payment->fines_discount]);
                    } else {
                        array_push($rem_item, [$identity_document_type, $employee->identity_number, '0704', $payment->total_remuneration, $payment->fines_discount]);
                    }
                }

                //DESCUENTO JUDICIAL
                if ($payment->judicial !== null) {
                    array_push($rem_item, [$identity_document_type, $employee->identity_number, '0703', $payment->total_remuneration, $payment->judicial]);
                }

                //ESSALUD
                if ($payment->essalud !== null) {
                    array_push($rem_item, [$identity_document_type, $employee->identity_number, '0804', $payment->total_remuneration, $payment->essalud]);
                }

                array_push($rem_list, [
                    'employee' => $payment->contract->employee,
                    'rem_items' => $rem_item
                ]);
            }
            return $rem_list;
        } catch (\Exception $th) {
            return [];
        }
    }

    public function generateFileName($period_id): string
    {
        $period = Period::find($period_id);
        $ruc = Setting::where('key', 'ruc')->value('value');
        $formulario_code = '0601';
        $mounth = sprintf('%02d', $period->mounth);

        return "{$formulario_code}{$period->payroll->year}{$mounth}{$ruc}.rem";
    }

    public function onlyValuesRem($rem_list): string
    {
        $content = "";
        $rem_items = array_map(fn($item) => $item['rem_items'], $rem_list);
        foreach ($rem_items as $items) {
            foreach ($items as $item) {
                $content .= implode('|', $item) . "\n";
            }
        }
        return $content;
    }
}
