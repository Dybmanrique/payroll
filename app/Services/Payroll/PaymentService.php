<?php

namespace App\Services\Payroll;

use App\Models\Period;
use App\Models\Setting;

class PaymentService
{
    public function calculate(int $period_id) : bool
    {
        define("ONP_COMISSION", ((float) Setting::where('key', 'onp_percent')->first()->value) / 100);
        define("ESSALUD", ((float) Setting::where('key', 'essalud_percent')->first()->value) / 100);
        define("CUARTA", 0.08);
        define("WORKING_HOURS", ((int) Setting::where('key', 'working_hours')->first()->value));
        define("WORKING_MINUTES", ((int) Setting::where('key', 'working_hours')->first()->value) * 60);
        define("UIT", ((float) Setting::where('key', 'uit')->first()->value));
        define("MAX_AMOUNT_ESSALUD", ((float) Setting::where('key', 'max_amount_essalud_percent')->first()->value) / 100);

        try {
            $period = Period::find($period_id);
            foreach ($period->payments as $key => $payment) {
                $employee = $payment->contract->employee;
                $payment->onp_discount = $payment->afp_discount = $payment->essalud = null;

                $payment->afp_id = null;
                if ($employee->pension_system === 'afp') {
                    $payment->obligatory_afp = ($payment->basic + $payment->refound) * ($employee->afp->obligatory_contribution / 100);
                    $payment->life_insurance_afp = ($payment->basic + $payment->refound) * ($employee->afp->life_insurance / 100);
                    $payment->variable_afp = ($payment->basic + $payment->refound) * ($employee->afp->variable_commission / 100);

                    $payment->afp_discount = $payment->obligatory_afp + $payment->life_insurance_afp + $payment->variable_afp;
                    $payment->afp_id = $payment->contract->employee->afp_id;
                }
                if ($employee->pension_system === 'onp') {
                    $payment->onp_discount = ($payment->basic + $payment->refound) * ONP_COMISSION;
                }

                if (($payment->basic + $payment->refound) < UIT * MAX_AMOUNT_ESSALUD) {
                    $payment->essalud = ($payment->basic + $payment->refound) * ESSALUD;
                } else {
                    $payment->essalud = (UIT * MAX_AMOUNT_ESSALUD) * ESSALUD;
                }

                if ($employee->cuarta) {
                    $payment->cuarta = ($payment->basic + $payment->refound) * CUARTA;
                }

                $total_judicial_discount = 0;
                $payment->judicial_discounts()->detach();
                foreach ($employee->judicial_discounts()->where('is_deleted', false)->get() as $key => $judicial_discount) {
                    if ($judicial_discount->discount_type === 'fijo') {
                        $payment->judicial_discounts()->attach($judicial_discount->id, ['amount' => $judicial_discount->amount]);
                        $total_judicial_discount += $judicial_discount->amount;
                    } else if ($judicial_discount->discount_type === 'porcentaje_total') {
                        $payment->judicial_discounts()->attach($judicial_discount->id, ['amount' => ($payment->basic + $payment->refound) * ($judicial_discount->amount / 100)]);
                        $total_judicial_discount += ($payment->basic + $payment->refound) * ($judicial_discount->amount / 100);
                    }
                }

                $payment->judicial = ($total_judicial_discount === 0) ? null : $total_judicial_discount;

                $days_discount = ($payment->basic / $payment->days) * $payment->days_discount;
                $hours_discount = ($payment->basic / $payment->days / WORKING_HOURS) * $payment->hours_discount;
                $minutes_discount = ($payment->basic / $payment->days / WORKING_MINUTES) * $payment->minutes_discount;
                $payment->fines_discount = $days_discount + $hours_discount + $minutes_discount;
                if ($payment->fines_discount === 0.00) $payment->fines_discount = null;

                $payment->total_remuneration = $payment->basic + $payment->refound + $payment->aguinaldo;
                $payment->total_discount = $payment->afp_discount + $payment->onp_discount + $payment->fines_discount + $payment->cuarta + $payment->judicial;
                $payment->total_contribution = $payment->essalud;

                $payment->net_pay = $payment->total_remuneration - $payment->total_discount;
                $payment->save();
            }

            return true;
        } catch (\Exception $th) {
            return false;
        }
    }
}
