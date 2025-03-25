<?php

namespace App\Services\Payroll;

use App\Models\Period;

class McppService
{
    public static function generateMcppArray(int $period_id): array
    {
        try {
            $header = [];
            $mcpp_list = [];
            $mcpp = [];

            $period = Period::find($period_id);
            $mcpp_concepts = config('mcpp_concepts');
            $concepts_types =  $mcpp_concepts['TIPO_CONCEPTO']['BY_NAME'];
            $airhsp_concepts_codes =  $mcpp_concepts['CONCEPTOS']['BY_NAME'];
            $airhsp_record_type = $mcpp_concepts['CODIGOS_TIPO_REGISTRO']['BY_NAME']['CAS'];

            $total_income = 0;
            $total_discounts = 0;
            $total_contributions = 0;

            $executing_unit = "001479";
            $year_process = $period->payroll->year;
            $mounth_process = sprintf('%02d', $period->mounth);
            $payroll_type = $mcpp_concepts['CODIGOS_TIPO_PLANILLA']['BY_NAME']['ACTIVO'];
            $payroll_class = $mcpp_concepts['CODIGOS_CLASE_PLANILLA']['BY_NAME']['CAS'];
            $correlative = $period->payroll->number;

            foreach ($period->payments as $payment) {
                $identity_document_type = $payment->contract->employee->identity_type->code;
                $employee = $payment->contract->employee;


                $mcpp_item = [];
                //HONORARIOS
                array_push($mcpp_item, [$identity_document_type, $employee->identity_number, $period->payroll->funding_resource->code, $concepts_types['INGRESOS'], $airhsp_concepts_codes['HONORARIOS'], "HONORARIOS", $payment->total_remuneration, $airhsp_record_type, $employee->airhsp_code]);

                //ONP
                if ($payment->onp_discount !== null) {
                    array_push($mcpp_item, [$identity_document_type, $employee->identity_number, $period->payroll->funding_resource->code, $concepts_types['DESCUENTOS'], $airhsp_concepts_codes['ONP'], "S.N.P. 19990 - SUNAT", $payment->onp_discount, $airhsp_record_type, $employee->airhsp_code]);
                }

                //AFP
                if ($payment->afp_discount !== null) {
                    //AFP AP OBLIG
                    array_push($mcpp_item, [$identity_document_type, $employee->identity_number, $period->payroll->funding_resource->code, $concepts_types['DESCUENTOS'], $airhsp_concepts_codes['AFP AP OBLIG'], "SISTEMA PRIVADO DE P", $payment->obligatory_afp, $airhsp_record_type, $employee->airhsp_code]);

                    //AFP SEGURO
                    array_push($mcpp_item, [$identity_document_type, $employee->identity_number, $period->payroll->funding_resource->code, $concepts_types['DESCUENTOS'], $airhsp_concepts_codes['AFP SEGURO'], "SEGURO - AFP", $payment->life_insurance_afp, $airhsp_record_type, $employee->airhsp_code]);
                    
                    //AFP COM VAR
                    if($payment->variable_afp){
                        array_push($mcpp_item, [$identity_document_type, $employee->identity_number, $period->payroll->funding_resource->code, $concepts_types['DESCUENTOS'], $airhsp_concepts_codes['AFP COM VAR'], "COM.VARIABLE-AFP", $payment->variable_afp, $airhsp_record_type, $employee->airhsp_code]);
                    }
                }

                //CUARTA CATEGORÍA
                if ($payment->cuarta !== null) {
                    array_push($mcpp_item, [$identity_document_type, $employee->identity_number, $period->payroll->funding_resource->code, $concepts_types['DESCUENTOS'], $airhsp_concepts_codes['CUARTA CATEGORÍA'], "CUARTA CATEGORIA", $payment->cuarta, $airhsp_record_type, $employee->airhsp_code]);
                }

                //FALTAS Y TARDANZAS
                if ($payment->fines_discount !== null) {
                    array_push($mcpp_item, [$identity_document_type, $employee->identity_number, $period->payroll->funding_resource->code, $concepts_types['DESCUENTOS'], $airhsp_concepts_codes['FALTAS Y TARDANZAS'], "FALTAS Y TARDANZAS", $payment->fines_discount, $airhsp_record_type, $employee->airhsp_code]);
                }

                //DESCUENTO JUDICIAL
                if ($payment->judicial !== null) {
                    array_push($mcpp_item, [$identity_document_type, $employee->identity_number, $period->payroll->funding_resource->code, $concepts_types['DESCUENTOS'], $airhsp_concepts_codes['DESCUENTO JUDICIAL'], "DESCUENTO JUDICIAL", $payment->judicial, $airhsp_record_type, $employee->airhsp_code]);
                }

                //ESSALUD
                if ($payment->essalud !== null) {
                    array_push($mcpp_item, [$identity_document_type, $employee->identity_number, $period->payroll->funding_resource->code, $concepts_types['APORTACIONES'], $airhsp_concepts_codes['ESSALUD'], "ESSALUD", $payment->essalud, $airhsp_record_type, $employee->airhsp_code]);
                }

                $total_income += $payment->total_remuneration;
                $total_discounts += $payment->total_discount;
                $total_contributions += $payment->essalud;

                array_push($mcpp_list, [
                    'employee' => $payment->contract->employee,
                    'mcpp_items' => $mcpp_item
                ]);
            }

            $count_rows = 0;

            foreach ($mcpp_list as $item) {
                $count_rows += count($item['mcpp_items']);
            }

            $total_income = number_format($total_income, 2, '.', '');
            $total_discounts = number_format($total_discounts, 2, '.', '');
            $total_contributions = number_format($total_contributions, 2, '.', '');

            $header = [$executing_unit, $year_process, $mounth_process, $payroll_type, $payroll_class, $correlative, $count_rows, $total_income, $total_discounts, $total_contributions];
            $mcpp['header'] = $header;
            $mcpp['mcpp_list'] = $mcpp_list;

            return $mcpp;
        } catch (\Exception $th) {
            return [];
        }
    }

    public static function generateFileName($period_id, $correlative): string
    {
        $mcpp_concepts = config('mcpp_concepts');
        $period = Period::find($period_id);
        $executing_unit = "001479";
        $year_process = $period->payroll->year;
        $mounth_process = sprintf('%02d', $period->mounth);
        $payroll_type = $mcpp_concepts['CODIGOS_TIPO_PLANILLA']['BY_NAME']['ACTIVO'];
        $payroll_class = $mcpp_concepts['CODIGOS_CLASE_PLANILLA']['BY_NAME']['CAS'];
        // $correlative = $period->payroll->number;
        $extension = ".txt";

        return "PLL{$executing_unit}{$year_process}{$mounth_process}{$payroll_type}{$payroll_class}{$correlative}{$extension}";
    }

    public static function onlyValuesMcpp($mcpp_list): string
    {
        $content = "";
        $mcpp_items = array_map(fn($item) => $item['mcpp_items'], $mcpp_list);
        foreach ($mcpp_items as $items) {
            foreach ($items as $item) {
                $content .= implode('|', $item) . "\n";
            }
        }
        return $content;
    }
}
