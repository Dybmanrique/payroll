<?php

namespace App\Services\Payroll;

use App\Models\Period;

class McppService
{
    public function generateTemplateMcpp(Period $period): array
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

            $executing_unit = "001479";
            $year_process = $period->payroll->year;
            $mounth_process = sprintf('%02d', $period->mounth);
            $payroll_type = PAYROLL_TYPE_ACTIVO;
            $payroll_class = PAYROLL_CLASS_CAS;
            $correlative = $period->payroll->number;
            $extension = ".txt";

            $name = "PLL{$executing_unit}{$period->payroll->year}{$mounth_process}{$payroll_type}{$payroll_class}{$correlative}{$extension}";

            $total_income = 0;
            $total_discounts = 0;
            $total_contributions = 0;

            $body = "";
            foreach ($period->payments as $key => $payment) {
                $identity_document_type = $payment->contract->employee->identity_type->code;
                $employee = $payment->contract->employee;
                $airhsp_record_type = CAS;

                //HONORARIOS
                $body .= implode("|", [$identity_document_type, $employee->identity_number, $period->payroll->funding_resource->code, INGRESOS, "0077", "HONORARIOS", $payment->total_remuneration, $airhsp_record_type, $employee->airhsp_code . "\n"]);


                //ONP
                if ($payment->onp_discount !== null) {
                    $body .= implode("|", [$identity_document_type, $employee->identity_number, $period->payroll->funding_resource->code, DESCUENTOS, "0001", "S.N.P. 19990 - SUNAT", $payment->onp_discount, $airhsp_record_type, $employee->airhsp_code . "\n"]);
                }

                //AFP
                if ($payment->afp_discount !== null) {
                    //AFP AP OBLIG
                    $body .= implode("|", [$identity_document_type, $employee->identity_number, $period->payroll->funding_resource->code, DESCUENTOS, "0002", "SISTEMA PRIVADO DE P", $payment->obligatory_afp, $airhsp_record_type, $employee->airhsp_code . "\n"]);

                    //AFP SEGURO
                    $body .= implode("|", [$identity_document_type, $employee->identity_number, $period->payroll->funding_resource->code, DESCUENTOS, "0004", "SEGURO - AFP", $payment->life_insurance_afp, $airhsp_record_type, $employee->airhsp_code . "\n"]);

                    //AFP COM VAR
                    $body .= implode("|", [$identity_document_type, $employee->identity_number, $period->payroll->funding_resource->code, DESCUENTOS, "0005", "COM.VARIABLE-AFP", $payment->variable_afp, $airhsp_record_type, $employee->airhsp_code . "\n"]);
                }

                //CUARTA CATEGORÍA
                if ($payment->cuarta !== null) {
                    $body .= implode("|", [$identity_document_type, $employee->identity_number, $period->payroll->funding_resource->code, DESCUENTOS, "0007", "CUARTA CATEGORIA", $payment->cuarta, $airhsp_record_type, $employee->airhsp_code . "\n"]);
                }

                //FALTAS Y TARDANZAS
                if ($payment->fines_discount !== null) {
                    $body .= implode("|", [$identity_document_type, $employee->identity_number, $period->payroll->funding_resource->code, DESCUENTOS, "0009", "FALTAS Y TARDANZAS", $payment->fines_discount, $airhsp_record_type, $employee->airhsp_code . "\n"]);
                }

                //DESCUENTO JUDICIAL
                if ($payment->judicial !== null) {
                    $body .= implode("|", [$identity_document_type, $employee->identity_number, $period->payroll->funding_resource->code, DESCUENTOS, "0008", "DESCUENTO JUDICIAL", $payment->judicial, $airhsp_record_type, $employee->airhsp_code . "\n"]);
                }

                //ESSALUD
                if ($payment->essalud !== null) {
                    $body .= implode("|", [$identity_document_type, $employee->identity_number, $period->payroll->funding_resource->code, APORTACIONES, "0007", "ESSALUD", $payment->essalud, $airhsp_record_type, $employee->airhsp_code . "\n"]);
                }

                $total_income += $payment->total_remuneration;
                $total_discounts += $payment->total_discount;
                $total_contributions += $payment->essalud;
            }

            $count_rows = substr_count($body, "\n");
            $total_income = number_format($total_income, 2, '.', '');
            $total_discounts = number_format($total_discounts, 2, '.', '');
            $total_contributions = number_format($total_contributions, 2, '.', '');

            //FIRST ROW
            $header = "{$executing_unit}|{$year_process}|{$mounth_process}|{$payroll_type}|{$payroll_class}|{$correlative}|{$count_rows}|{$total_income}|{$total_discounts}|{$total_contributions}";
            $content = "{$header}\n{$body}";

            return ['name' => $name, 'content' => $content];
        } catch (\Exception $th) {
            return ['name' => "error", 'content' => "No se pudo generar"];
        }
    }
}
