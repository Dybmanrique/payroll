<div>
    <table class="w-full">
        <tr>
            <td class="corner"><img src="{{ public_path('img/asuncion.jpg') }}" alt=""></td>
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

    <table class="w-full">
        <tr>
            <td>
                <table>
                    <tr>
                        <td class="text-bold">PERIODO</td>
                        <td>: {{ $periods[$payment->period->mounth] }} 2024</td>
                    </tr>
                    <tr>
                        <td class="text-bold">APELLIDOS Y NOMRBES</td>
                        <td>: {{ $payment->employee->last_name }} {{ $payment->employee->second_last_name }}
                            {{ $payment->employee->name }}</td>
                    </tr>
                    <tr>
                        <td class="text-bold">CARGO</td>
                        <td>: {{ $payment->employee->job_position->name }}</td>
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
                        <td>: {{ $payment->period->payroll->year }}{{ sprintf("%02d", $payment->period->mounth) }}-{{ sprintf("%03d", $payment->id) }}</td>
                    </tr>
                    <tr>
                        <td class="text-bold">CÓDIGO</td>
                        <td>: {{ $payment->employee->identity_number }}</td>
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
                            <td class="text-right">{{ $payment->basic }}</td>
                        </tr>
                        @if ($payment->refound)
                            <tr>
                                <td>Reintegro: </td>
                                <td class="text-right">{{ $payment->refound }}</td>
                            </tr>
                        @endif
                        @if ($payment->aguinaldo)
                            <tr>
                                <td>Gratificación: </td>
                                <td class="text-right">{{ $payment->aguinaldo }}</td>
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
                                <td class="text-right">{{ $payment->onp_discount }}</td>
                            </tr>
                        @endif
                        @if ($payment->afp_discount)
                            <tr>
                                <td>AFP - Jubilación: </td>
                                <td class="text-right">{{ $payment->obligatory_afp }}</td>
                            </tr>
                            <tr>
                                <td>AFP - Comisión variable: </td>
                                <td class="text-right">{{ $payment->variable_afp }}</td>
                            </tr>
                            <tr>
                                <td>AFP - Invalidez: </td>
                                <td class="text-right">{{ $payment->life_insurance_afp }}</td>
                            </tr>
                        @endif
                        @if ($payment->cuarta)
                            <tr>
                                <td>Desc. 4ta Categoría: </td>
                                <td class="text-right">{{ $payment->cuarta }}</td>
                            </tr>
                        @endif
                        @if ($payment->fines_discount)
                            <tr>
                                <td>Multas: </td>
                                <td class="text-right">{{ $payment->fines_discount }}</td>
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
                                <td class="text-right">{{ $payment->essalud }}</td>
                            </tr>
                        @endif
                        <tr>
                            <td>TOTAL APORTE: </td>
                            <td class="text-right">{{ $payment->essalud ?? '0.00' }}</td>
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
                            <td class="text-right">{{ $payment->total_remuneration }}</td>
                        </tr>
                        <tr>
                            <td>DESCUENTO: </td>
                            <td class="text-right">{{ $payment->total_discount }}</td>
                        </tr>
                        <tr>
                            <td>NETO A PAGAR: </td>
                            <td class="text-right" style="border-top: 1px solid; border-bottom: 4px double;">
                                {{ $payment->net_pay }}</td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </table>
</div>