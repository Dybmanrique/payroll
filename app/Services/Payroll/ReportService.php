<?php

namespace App\Services\Payroll;

use App\Models\BudgetaryObjective;
use App\Models\Period;

class ReportService
{
    public function generateArrayGeneralReport(Period $period): array
    {
        try {
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
            return $results;
        } catch (\Exception $th) {
            return [];
        }
    }
    public function generateArraySummaryReport(Period $period): array
    {
        try {
            $payments = $period->payments()->with('contract')->get();

            $payments_classified = collect($payments)->groupBy('contract.budgetary_objective_id');

            $results = [];
            foreach ($payments_classified as $budgetary_objective_id => $payments) {

                $objeto = new \stdClass();
                $objeto->budgetary_objective = BudgetaryObjective::find($budgetary_objective_id);
                $objeto->payments = $payments;
                array_push($results, $objeto);
            }
            return $results;
        } catch (\Exception $th) {
            return [];
        }
    }
}
