<div>
    <table class="w-full">
        <tr>
            <td class="corner"><img class="logo" src="{{ public_path('img/asuncion.jpg') }}" alt=""></td>
            <td class="text-bold text-center">
                <ul style="list-style-type: none; margin: 0px;">
                    <li class="text-lg">BOLETA DE PAGO</li>
                    <li>CONTRATO DE ADMINISTRATIVO POR SERVICIO</li>
                    <li>D.L. 1057</li>
                </ul>

            </td>
            <td class="text-right corner">RUC: 20571443784</td>
        </tr>
    </table>

    <hr>
    <table class="w-full">
        <tr>
            <td>
                <table>
                    <tr>
                        <td class="text-bold">PERIODO</td>
                        <td>: {{ $periods[$payment->period->mounth] }} {{ $payment->period->payroll->year }}</td>
                    </tr>
                    <tr>
                        <td class="text-bold">APELLIDOS Y NOMRBES</td>
                        <td>: {{ $payment->contract->employee->last_name }} {{ $payment->contract->employee->second_last_name }}
                            {{ $payment->contract->employee->name }}</td>
                    </tr>
                    <tr>
                        <td class="text-bold">CARGO</td>
                        <td>: {{ $payment->contract->job_position->name }}</td>
                    </tr>
                    <tr>
                        <td class="text-bold">ESTABLECIMIENTO</td>
                        <td>: UGEL - Asunción</td>
                    </tr>
                </table>
            </td>
            <td style="width: 200px">
                <table>
                    <tr>
                        <td class="text-bold">BOLETA</td>
                        <td>: {{ $payment->period->payroll->year }}{{ sprintf("%02d", $payment->period->mounth) }}-{{ sprintf("%04d", $payment->contract->employee->id) }}</td>
                    </tr>
                    <tr>
                        <td class="text-bold">CÓDIGO</td>
                        <td>: {{ $payment->contract->employee->identity_number }}</td>
                    </tr>
                    <tr>
                        <td class="text-bold">ESSALUD</td>
                        <td>: {{ $payment->essalud ? 'SI' : 'NO' }}</td>
                    </tr>
                    <tr>
                        <td class="text-bold">SIS. PENSIÓN</td>
                        <td>: {{ $payment->onp_discount ? 'ONP' : 'AFP' }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <hr>

    <table class="w-full" style="table-layout: fixed;">
        <tr>
            <td style="vertical-align: top">
                <div class="border text-center text-bold" style="border-bottom: none; padding: 3px;">
                    INGRESOS
                </div>
                <div class="border" style="min-height: 100px;">
                    <table class="w-full">
                        <tr>
                            <td>Monto mensual: </td>
                            <td class="text-right">{{ number_format($payment->basic, 2) }}</td>
                        </tr>
                        @if ($payment->refound)
                            <tr>
                                <td>Reintegro: </td>
                                <td class="text-right">{{ number_format($payment->refound, 2) }}</td>
                            </tr>
                        @endif
                        @if ($payment->aguinaldo)
                            <tr>
                                <td>Gratificación: </td>
                                <td class="text-right">{{ number_format($payment->aguinaldo,2) }}</td>
                            </tr>
                        @endif
                    </table>
                </div>
            </td>
            <td rowspan="2" style="vertical-align: top">
                <div class="border text-center text-bold" style="border-bottom: none; padding: 3px;">
                    DESCUENTOS
                </div>
                <div class="border" style="min-height: 200px;">
                    <table class="w-full">
                        @if ($payment->onp_discount)
                            <tr>
                                <td>D.L. 19990: </td>
                                <td class="text-right">{{ number_format($payment->onp_discount, 2) }}</td>
                            </tr>
                        @endif
                        @if ($payment->afp_discount)
                            <tr>
                                <td>AFP - Jubilación: </td>
                                <td class="text-right">{{ number_format($payment->obligatory_afp, 2) }}</td>
                            </tr>
                            <tr>
                                <td>AFP - Comisión variable: </td>
                                <td class="text-right">{{ number_format($payment->variable_afp, 2) }}</td>
                            </tr>
                            <tr>
                                <td>AFP - Invalidez: </td>
                                <td class="text-right">{{ number_format($payment->life_insurance_afp, 2) }}</td>
                            </tr>
                        @endif
                        @if ($payment->cuarta)
                            <tr>
                                <td>Desc. 4ta Categoría: </td>
                                <td class="text-right">{{ number_format($payment->cuarta, 2) }}</td>
                            </tr>
                        @endif
                        @if ($payment->fines_discount)
                            <tr>
                                <td>Multas: </td>
                                <td class="text-right">{{ number_format($payment->fines_discount) }}</td>
                            </tr>
                        @endif
                        @if ($payment->judicial)
                            <tr>
                                <td>Descuento judicial: </td>
                                <td class="text-right">{{ number_format($payment->judicial, 2) }}</td>
                            </tr>
                        @endif
                    </table>
                </div>
            </td>
            <td style="vertical-align: top">
                <div class="border text-center text-bold" style="border-bottom: none; padding: 3px;">
                    APORTES
                </div>
                <div class="border" style="min-height: 100px;">
                    <table class="w-full">
                        @if ($payment->essalud)
                            <tr>
                                <td>Essalud (9%): </td>
                                <td class="text-right">{{ number_format($payment->essalud, 2) }}</td>
                            </tr>
                        @endif
                        <tr>
                            <td>TOTAL APORTE: </td>
                            <td class="text-right">{{ number_format($payment->total_contribution, 2) ?? '0.00' }}</td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
        <tr>
            <td></td>
            <td style="vertical-align: top">
                <div class="border" style="min-height: 94px;">
                    <table class="w-full">
                        <tr>
                            <td>TOTAL INGRESO: </td>
                            <td class="text-right">{{ number_format($payment->total_remuneration, 2) }}</td>
                        </tr>
                        <tr>
                            <td>DESCUENTO: </td>
                            <td class="text-right">{{ number_format($payment->total_discount, 2) }}</td>
                        </tr>
                        <tr class="text-bold">
                            <td>NETO A PAGAR: </td>
                            <td class="text-right" style="border-top: 1px solid; border-bottom: 4px double;">
                                {{ number_format($payment->net_pay, 2) }}</td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </table>
</div>