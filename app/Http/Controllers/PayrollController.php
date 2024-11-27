<?php

namespace App\Http\Controllers;

use App\Models\BudgetaryObjective;
use App\Models\Employee;
use App\Models\Payment;
use App\Models\Payroll;
use App\Models\Period;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

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
                'message' => 'No se puede eliminar, recuerde que tiene que eliminar todos los periodos asociados para poder eliminar una planilla.',
                'code' => '500'
            ]);
        }
    }

    public function mcpp(Period $period)
    {
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
        $mounth_process = $period->mounth;
        $payroll_type = PAYROLL_TYPE_ACTIVO;
        $payroll_class = PAYROLL_CLASS_CAS;
        $correlative = $period->payroll->number;
        $extension = ".txt";

        $name = "PLL{$executing_unit}{$period->payroll->year}{$period->mounth}{$payroll_type}{$payroll_class}{$correlative}{$extension}";

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

        // GENERATE AND RESPONSE FILE
        return response($content)
            ->header('Content-Type', 'text/plain')
            ->header('Content-Disposition', 'attachment; filename="' . $name . '"');
        try {
        } catch (\Exception $ex) {
            dd('algo salió mal');
        }
    }

    public function generate_payment_slip(Payment $payment)
    {
        $periods = config('periods_spanish');
        $pdf = Pdf::loadView('admin.reports-templates.payment-slip', ['payment' => $payment, 'periods' => $periods])->setPaper('a4');
        return $pdf->stream();
    }
    public function generate_payment_slips_period(Period $period)
    {
        $periods = config('periods_spanish');
        $pdf = Pdf::loadView('admin.reports-templates.payment-slips-period', ['period' => $period, 'periods' => $periods])->setPaper('a4');
        return $pdf->stream();
    }
    public function general_report(Period $period)
    {
        $periods = config('periods_spanish');

        $payments = $period->payments()->with('contract')->get();

        $payments_classified = collect($payments)->groupBy('contract.budgetary_objective_id');

        $results = [];
        foreach ($payments_classified as $budgetary_objective_id => $payments) {
            $total_basic = 0;
            $total_refound = 0;
            $total_discount = 0;
            $total_remuneration = 0;
            $total_net_pay = 0;
            $total_aguinaldo = 0;
            $total_essalud = 0;

            foreach ($payments as $payment) {
                $total_basic += $payment->basic;
                $total_refound += $payment->refound;
                $total_discount += $payment->total_discount;
                $total_remuneration += $payment->total_remuneration;
                $total_net_pay += $payment->net_pay;
                $total_aguinaldo += $payment->aguinaldo;
                $total_essalud += $payment->essalud;
            }
            $objeto = new \stdClass();
            $objeto->budgetary_objective = BudgetaryObjective::find($budgetary_objective_id);
            $objeto->total_basic = $total_basic;
            $objeto->total_refound = $total_refound;
            $objeto->total_discount = $total_discount;
            $objeto->total_remuneration = $total_remuneration;
            $objeto->total_net_pay = $total_net_pay;
            $objeto->total_aguinaldo = $total_aguinaldo;
            $objeto->total_essalud = $total_essalud;
            array_push($results, $objeto);
        }

        $pdf = Pdf::loadView('admin.reports-templates.general-report', ['period' => $period, 'periods' => $periods, 'results' => $results])->setPaper('a4');
        return $pdf->stream();
    }
    public function payroll_report(Period $period)
    {
        $periods = config('periods_spanish');
        $pdf = Pdf::loadView('admin.reports-templates.payroll', ['period' => $period, 'periods' => $periods])->setPaper('a4', 'landscape');
        return $pdf->stream();
    }
    public function payroll_summary(Period $period)
    {
        $periods = config('periods_spanish');

        $payments = $period->payments()->with('contract')->get();

        $payments_classified = collect($payments)->groupBy('contract.budgetary_objective_id');

        $results = [];
        foreach ($payments_classified as $budgetary_objective_id => $payments) {
            
            $objeto = new \stdClass();
            $objeto->budgetary_objective = BudgetaryObjective::find($budgetary_objective_id);
            $objeto->payments = $payments;
            array_push($results, $objeto);
        }

        $pdf = Pdf::loadView('admin.reports-templates.summary-report', ['period' => $period, 'periods' => $periods, 'results' => $results])->setPaper('a4','landscape');
        return $pdf->stream();
    }
}
