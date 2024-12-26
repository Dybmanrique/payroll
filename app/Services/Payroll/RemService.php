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

    public function generateTemplateRem(Period $period): array
    {
        try {
            define("INGRESOS", 1);
            define("DESCUENTOS", 2);
            define("APORTACIONES", 3);

            define("CAS", 4);
            define("PAYROLL_TYPE_ACTIVO", "01");
            define("PAYROLL_CLASS_CAS", "03");

            define("ONP_COMISSION", 0.13);
            define("ESSALUD", 0.09);
            define("WORKING_HOURS", 8);
            define("WORKING_MINUTES", 480);

            $formulario_code = "0601";
            $year_process = $period->payroll->year;
            $mounth_process = $period->mounth;
            $ruc = Setting::where('key', 'ruc')->value('value');
            $extension = ".rem";

            $name = "{$formulario_code}{$year_process}{$mounth_process}{$ruc}{$extension}";

            $body = "";
            foreach ($period->payments as $key => $payment) {
                $identity_document_type = array_search($payment->contract->employee->identity_type->name, $this->type_id_rem);
                $employee = $payment->contract->employee;
                $airhsp_record_type = CAS;

                //HONORARIOS
                $body .= implode("|", [$identity_document_type, $employee->identity_number, '2039', $payment->total_remuneration, $payment->total_remuneration . "\n"]);

                //ONP
                if ($payment->onp_discount !== null) {
                    $body .= implode("|", [$identity_document_type, $employee->identity_number, '0607', $payment->total_remuneration, $payment->onp_discount . "\n"]);
                }

                //AFP
                if ($payment->afp_discount !== null) {
                    //AFP AP OBLIG
                    $body .= implode("|", [$identity_document_type, $employee->identity_number, '0608', $payment->total_remuneration, $payment->obligatory_afp . "\n"]);

                    //AFP SEGURO
                    $body .= implode("|", [$identity_document_type, $employee->identity_number, '0606', $payment->total_remuneration, $payment->life_insurance_afp . "\n"]);

                    //AFP COM VAR
                    $body .= implode("|", [$identity_document_type, $employee->identity_number, '0601', $payment->total_remuneration, $payment->variable_afp . "\n"]);
                }

                //CUARTA CATEGORÍA
                if ($payment->cuarta !== null) {
                    $body .= implode("|", [$identity_document_type, $employee->identity_number, '0618', $payment->total_remuneration, $payment->cuarta . "\n"]);
                }

                //FALTAS Y TARDANZAS
                if ($payment->fines_discount !== null) {
                    //0704	TARDANZAS
                    //0705	INASISTENCIAS
                    $body .= implode("|", [$identity_document_type, $employee->identity_number, '0704', $payment->total_remuneration, $payment->fines_discount . "\n"]);
                }

                //DESCUENTO JUDICIAL
                if ($payment->judicial !== null) {
                    $body .= implode("|", [$identity_document_type, $employee->identity_number, '0703', $payment->total_remuneration, $payment->judicial . "\n"]);
                }

                //ESSALUD
                if ($payment->essalud !== null) {
                    $body .= implode("|", [$identity_document_type, $employee->identity_number, '0804', $payment->total_remuneration, $payment->essalud . "\n"]);
                }
            }

            return ['name' => $name, 'content' => $body];
        } catch (\Exception $th) {
            return ['name' => "error", 'content' => "No se pudo generar"];
        }
    }
}
