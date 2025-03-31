<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Payment;

class CheckBallotsController extends Controller
{
    public function generate_payment_slip(Payment $payment)
    {
        $user = auth('worker')->user();

        // Verificar si el pago pertenece al empleado autenticado
        if ($payment->contract->employee_id !== $user->id) {
            abort(403, 'No tienes permiso para acceder aquí.');
        }
        try {
            $periods = config('periods_spanish');
            $pdf = Pdf::loadView('admin.reports-templates.payment-slip', ['payment' => $payment, 'periods' => $periods])->setPaper('a4');
            return $pdf->stream();
        } catch (\Exception $ex) {
            abort(500, 'No se pudo generar la boleta de pago.');
        }
    }
}
