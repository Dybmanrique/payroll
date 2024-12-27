<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Group;
use App\Models\Payment;
use App\Models\Payroll;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{

    public function index()
    {
        $users = User::count();
        $groups = Group::count();
        $employees = Employee::count();
        $current_payrolls = Payroll::whereYear('created_at', now()->year)->count();

        return view('dashboard', compact('users', 'groups', 'employees', 'current_payrolls'));
    }

    public function get_statistics_payments()
    {
        // Fecha de inicio (hace 12 meses)
        $start_date = Carbon::now()->subMonths(12)->startOfMonth();

        $payments = Payment::selectRaw(
            'YEAR(created_at) as year, 
         MONTH(created_at) as month, 
         SUM(total_remuneration) as total_remuneration, 
         SUM(total_discount) as total_discount,
         SUM(total_contribution) as total_contribution,
         SUM(net_pay) as net_pay,
         SUM(afp_discount) as afp_discount,
         SUM(onp_discount) as onp_discount',
        )
            ->where('created_at', '>=', $start_date)
            ->groupByRaw('YEAR(created_at), MONTH(created_at)')
            ->orderByRaw('YEAR(created_at), MONTH(created_at)')
            ->get();

        $result = [];
        $periods = config('periods_spanish');

        foreach ($payments as $payment_mount) {
            $result[] = [
                'period' => $periods[$payment_mount->month] . ' ' . $payment_mount->year,
                'total_remuneration' => $payment_mount->total_remuneration ?? 0.00,
                'total_discount' => $payment_mount->total_discount ?? 0.00,
                'total_contribution' => $payment_mount->total_contribution ?? 0.00,
                'net_pay' => $payment_mount->net_pay ?? 0.00,
                'afp_discount' => $payment_mount->afp_discount ?? 0.00,
                'onp_discount' => $payment_mount->onp_discount ?? 0.00,
            ];
        }

        return response()->json($result);
    }
}
