<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Payroll;
use App\Models\Period;
use App\Services\Payroll\JorService;
use App\Services\Payroll\McppService;
use App\Services\Payroll\ReportService;
use App\Services\Payroll\RemService;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class PayrollController extends Controller implements HasMiddleware
{
    private $mcpp_service;
    private $report_service;
    private $jor_service;
    private $rem_service;

    public function __construct()
    {
        $this->mcpp_service = new McppService;
        $this->report_service = new ReportService;
        $this->jor_service = new JorService;
        $this->rem_service = new RemService;
    }

    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        return [
            'web',
            new Middleware('can:payrolls.index', only: ['index','data']),
            new Middleware('can:payrolls.create', only: ['create']),
            new Middleware('can:payrolls.edit', only: ['edit']),
            new Middleware('can:payrolls.delete', only: ['destroy']),
        ];
    }

    public function index()
    {
        return view('admin.payrolls.index');
    }

    public function data()
    {
        return Payroll::with('payroll_type')->orderByDesc('id')->get();
    }

    public function get_permissions()
    {
        /** @var User $user */
        $user = Auth::user();
        $can_index = $user->can('payrolls.index');
        $can_create = $user->can('payrolls.create');
        $can_edit = $user->can('payrolls.edit');
        $can_delete = $user->can('payrolls.delete');

        return response()->json([
            'can_index' => $can_index,
            'can_create' => $can_create,
            'can_edit' => $can_edit,
            'can_delete' => $can_delete,
        ]);
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
            return response()->json(['message' => 'Eliminado correctamente', 'code' => '200']);
        } catch (\Exception $ex) {
            return response()->json([ 'message' => 'No se puede eliminar, recuerde que tiene que eliminar todos los periodos asociados para poder eliminar una planilla.', 'code' => '500']);
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
        $results = $this->report_service->generateArrayGeneralReport($period);
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
        $results = $this->report_service->generateArraySummaryReport($period);
        $pdf = Pdf::loadView('admin.reports-templates.summary-report', ['period' => $period, 'periods' => $periods, 'results' => $results])->setPaper('a4', 'landscape');
        return $pdf->stream();
    }
}
