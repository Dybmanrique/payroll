<?php

namespace App\Http\Controllers;

use App\Models\BudgetaryObjective;
use App\Models\Employee;
use App\Models\Payment;
use App\Models\Payroll;
use App\Models\Period;
use App\Services\Payroll\McppService;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class PayrollController extends Controller
{
    private $mcpp_service;
    public function __construct()
    {
        $this->mcpp_service = new McppService;
    }
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
        $result = $this->mcpp_service->generateTemplateMcpp($period);
        return response($result['content'])
            ->header('Content-Type', 'text/plain')
            ->header('Content-Disposition', 'attachment; filename="' . $result['name'] . '"');
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
