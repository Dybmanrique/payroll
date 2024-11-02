<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Payment;
use App\Models\Payroll;
use App\Models\Period;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PayrollController extends Controller
{
    public function index()
    {
        return view('admin.payrolls.index');
    }
    public function data()
    {
        return Payroll::with('payroll_type')->orderByDesc('id')->get();
    }

    public function create()
    {
        return view('admin.payrolls.create');
    }

    public function edit(Payroll $payroll)
    {
        return view('admin.payrolls.edit', compact('payroll'));
    }

    public function destroy(Request $request)
    {
        try {
            Payroll::find($request->id)->delete();
            return response()->json([
                'message' => 'Eliminado correctamente',
                'code' => '200'
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                'message' => 'No se puede eliminar',
                'code' => '500'
            ]);
        }
    }
    public function view(Request $request)
    {
        try {
            $payroll = Payroll::findOrFail($request->id);
            $payroll->employees;
            return response()->json([
                'content' => $payroll,
                'code' => '200'
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                'content' => 'Algo salió mal',
                'code' => '500'
            ]);
        }
    }

    public function mcpp(Period $period)
    {
        define("INGRESOS", 1);
        define("DESCUENTOS", 2);
        define("APORTACIONES", 3);

        define("CONTRATO_ADMINISTRATIVO_DE_SERVICIOS", 4);

        define("ONP_COMISSION", 0.13);
        define("ESSALUD", 0.09);
        define("WORKING_HOURS", 8);
        define("WORKING_MINUTES", 480);

        try {
            $prefix = "PLL";
            $executing_unit = "001479";
            $year_process = "2024";
            $mounth_process = $period->mounth;
            $payroll_type = "01";
            $payroll_class = "03";
            $correlative = "0001";
            $extension = ".txt";

            $name = "{$prefix}{$executing_unit}{$year_process}{$mounth_process}{$payroll_type}{$payroll_class}{$correlative}{$extension}";

            $total_income = 0;
            $total_discounts = 0;
            $total_contributions = 0;

            $body = "";
            foreach ($period->payments as $key => $payment) {
                $identity_document_type = "2";
                $identity_document_number = $payment->employee->dni;
                $funding_resource = $period->payroll->funding_resource->code;

                //HONORARIOS
                $airhsp_concept = INGRESOS;
                $airhsp_concept_code = "0077";
                $description = "HONORARIOS";
                $amount = $payment->total_remuneration;
                $airhsp_record_type = CONTRATO_ADMINISTRATIVO_DE_SERVICIOS;
                $airhsp_code_employee = $payment->employee->airhsp_code;
                $body .= "{$identity_document_type}|{$identity_document_number}|{$funding_resource}|{$airhsp_concept}|{$airhsp_concept_code}|{$description}|{$amount}|{$airhsp_record_type}|{$airhsp_code_employee}\n";

                //ONP
                if ($payment->onp_discount !== null) {
                    $airhsp_concept = DESCUENTOS;
                    $airhsp_concept_code = "0001";
                    $description = "S.N.P. 19990 - SUNAT";
                    $amount = $payment->onp_discount;
                    $body .= "{$identity_document_type}|{$identity_document_number}|{$funding_resource}|{$airhsp_concept}|{$airhsp_concept_code}|{$description}|{$amount}|{$airhsp_record_type}|{$airhsp_code_employee}\n";
                }

                //AFP
                if ($payment->afp_discount !== null) {
                    $airhsp_concept = DESCUENTOS;

                    //AFP AP OBLIG
                    $airhsp_concept_code = "0002";
                    $description = "SISTEMA PRIVADO DE P";
                    $amount = $payment->obligatory_afp;
                    $body .= "{$identity_document_type}|{$identity_document_number}|{$funding_resource}|{$airhsp_concept}|{$airhsp_concept_code}|{$description}|{$amount}|{$airhsp_record_type}|{$airhsp_code_employee}\n";

                    //AFP SEGURO
                    $airhsp_concept_code = "0004";
                    $description = "SEGURO - AFP";
                    $amount = $payment->life_insurance_afp;
                    $body .= "{$identity_document_type}|{$identity_document_number}|{$funding_resource}|{$airhsp_concept}|{$airhsp_concept_code}|{$description}|{$amount}|{$airhsp_record_type}|{$airhsp_code_employee}\n";

                    //AFP COM VAR
                    $airhsp_concept_code = "0005";
                    $description = "COM.VARIABLE-AFP";
                    $amount = $payment->variable_afp;
                    $body .= "{$identity_document_type}|{$identity_document_number}|{$funding_resource}|{$airhsp_concept}|{$airhsp_concept_code}|{$description}|{$amount}|{$airhsp_record_type}|{$airhsp_code_employee}\n";
                }

                //FALTAS Y TARDANZAS
                if ($payment->fines_discount !== null) {
                    $airhsp_concept = DESCUENTOS;
                    $airhsp_concept_code = "0009";
                    $description = "FALTAS Y TARDANZAS";
                    $amount = $payment->fines_discount;
                    $body .= "{$identity_document_type}|{$identity_document_number}|{$funding_resource}|{$airhsp_concept}|{$airhsp_concept_code}|{$description}|{$amount}|{$airhsp_record_type}|{$airhsp_code_employee}\n";
                }

                //ESSALUD
                if ($payment->essalud !== null) {
                    $airhsp_concept_code = "0007";
                    $description = "ESSALUD";
                    $amount = $payment->essalud;
                    $body .= "{$identity_document_type}|{$identity_document_number}|{$funding_resource}|{$airhsp_concept}|{$airhsp_concept_code}|{$description}|{$amount}|{$airhsp_record_type}|{$airhsp_code_employee}\n";
                }

                //CUARTA CATEGORÍA
                if ($payment->cuarta !== null) {
                    $airhsp_concept_code = "0007";
                    $description = "CUARTA CATEGORIA";
                    $amount = $payment->cuarta;
                    $body .= "{$identity_document_type}|{$identity_document_number}|{$funding_resource}|{$airhsp_concept}|{$airhsp_concept_code}|{$description}|{$amount}|{$airhsp_record_type}|{$airhsp_code_employee}\n";
                }

                $total_income += $payment->total_remuneration;
                $total_discounts += $payment->total_discount;
                $total_contributions += $payment->essalud;
            }

            $count_rows = substr_count($body, "\n");
            $total_income = number_format($total_income, 2, '.', '');
            $total_discounts += number_format($total_discounts, 2, '.', '');
            $total_contributions = number_format($total_contributions, 2, '.', '');

            //FIRST ROW
            $header = "{$executing_unit}|{$year_process}|{$mounth_process}|{$payroll_type}|{$payroll_class}|{$correlative}|{$count_rows}|{$total_income}|{$total_discounts}|{$total_contributions}";
            $content = "{$header}\n{$body}";

            // Crear y devolver el archivo como descarga
            return response($content)
                ->header('Content-Type', 'text/plain')
                ->header('Content-Disposition', 'attachment; filename="' . $name . '"');
        } catch (\Exception $ex) {
            dd('algo salió mal');
        }
    }

    public function generate_payment_slip(Payment $payment)
    {
        $periods = [1 => 'ENERO', 2 => 'FEBRERO', 3 => 'MARZO', 4 => 'ABRIL', 5 => 'MAYO', 6 => 'JUNIO', 7 => 'JULIO', 8 => 'AGOSTO', 9 => 'SETIEMBRE', 10 => 'OCTUBRE', 11 => 'NOVIEMBRE', 12 => 'DICIEMBRE'];
        $pdf = Pdf::loadView('admin.reports-templates.payment-slip', ['payment' => $payment, 'periods' => $periods])->setPaper('a4');
        return $pdf->stream();
    }
    public function generate_payment_slips_period(Period $period)
    {
        $periods = [1 => 'ENERO', 2 => 'FEBRERO', 3 => 'MARZO', 4 => 'ABRIL', 5 => 'MAYO', 6 => 'JUNIO', 7 => 'JULIO', 8 => 'AGOSTO', 9 => 'SETIEMBRE', 10 => 'OCTUBRE', 11 => 'NOVIEMBRE', 12 => 'DICIEMBRE'];
        $pdf = Pdf::loadView('admin.reports-templates.payment-slips-period', ['period' => $period, 'periods' => $periods])->setPaper('a4');
        return $pdf->stream();
    }
}
