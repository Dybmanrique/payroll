<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planilla</title>
</head>
<style>
    /* @page {
        margin: 2cm;
    } */

    body {
        margin: 0;
        padding: 0;
        font-size: 12px
    }

    .w-full {
        width: 100%;
    }

    .h-full {
        height: 100%;
    }

    .space {
        width: 80px;
    }

    .corner {
        width: 100px;
    }

    .text-bold {
        font-weight: 700;
    }

    .text-right {
        text-align: right;
    }

    .text-center {
        text-align: center;
    }

    .border {
        border: solid 1px;
    }

    .m-0 {
        margin: 0px;
    }

    .p-0 {
        padding: 0px;
    }

    .align-top {
        vertical-align: top;
    }

    .text-lg {
        font-size: 25px;
    }

    .text-md {
        font-size: 18px;
    }

    .table {
        border: 1px solid;
        border-collapse: collapse;
    }

    .table thead tr {
        background-color: #3E3D5F;
        color: #ffffff;
    }

    .table tfoot tr {
        background-color: #3E3D5F;
        color: #ffffff;
    }

    .table thead tr th {
        border-color: black;
        font-size: 12px;
        height: 20px;
    }

    .table tfoot tr td {
        border-color: black;
    }

    .row:nth-of-type(even) {
        background-color: #f3f3f3;
    }

    .cel {
        border: 1px solid;
    }

    .cel-top {
        vertical-align: top;
    }

    .cel-middle {
        vertical-align: middle;
    }

    .details-table tr td {
        vertical-align: top;
    }

    .text-nowrap {
        white-space: nowrap;
    }

    .logo {
        width: 100px;
    }
</style>

<body>
    <!-- SECCION DE PLANILLAS -->
    <table class="w-full">
        <tr>
            <td class="corner"><img class="logo" src="{{ public_path('img/asuncion.jpg') }}" alt=""></td>
            <td>
                <div class="text-bold text-center text-lg">PLANILLA DE REMUNERACIONES</div>
                <div class="text-center">D.L. 1057 CONTRATO ADMINISTRATIVO DE SERVICIOS</div>
            </td>
            <td class="text-right corner"></td>
        </tr>
    </table>

    <hr>
    <table class="w-full">
        <tr>
            <td>
                <table>
                    <tr>
                        <td class="text-bold">N° PLANILLA</td>
                        <td>: {{ $period->payroll->number }}-{{ $period->payroll->year }}</td>
                    </tr>
                    <tr>
                        <td class="text-bold">PERIODO</td>
                        <td>: {{ $periods[$period->mounth] }} {{ $period->payroll->year }}</td>
                    </tr>
                </table>
            </td>
            <td style="width: 500px">
                <table>
                    <tr>
                        <td class="text-bold">ESTABLECIMIENTO</td>
                        <td>: UGEL - ASUNCIÓN</td>
                    </tr>
                    <tr>
                        <td class="text-bold">F. FINANCIAMIENTO</td>
                        <td>: [{{ $period->payroll->funding_resource->code }}]
                            {{ $period->payroll->funding_resource->name }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <hr>

    <table class="w-full table">
        <thead>
            <tr>
                <th class="cel text-bold" style="width: 35px">COD</th>
                <th class="cel text-bold" style="width: 350px">DATOS</th>
                <th class="cel text-bold" style="width: 150px">INGRESOS</th>
                <th class="cel text-bold" style="width: 150px">DESCUENTOS</th>
                <th class="cel text-bold" style="width: 130px">APORTES</th>
                <th class="cel text-bold" style="width: 125px">NETO</th>
                <th class="cel text-bold">FIRMA</th>
            </tr>
        </thead>
        <tbody>
            @php
                $total_basic = 0;
                $total_aguinaldo = 0;
                $total_refound = 0;
                $total_remuneration = 0;

                $total_onp = 0;
                $total_afp_jub = 0;
                $total_afp_c_v = 0;
                $total_afp_inva = 0;
                $total_judicial = 0;
                $total_others = 0;
                $total_discount = 0;

                $total_essalud = 0;
                $total_contribution = 0;

                $total_net_pay = 0;
            @endphp
            @foreach ($period->payments as $payment)
                @php
                    $total_basic += $payment->basic;
                    $total_aguinaldo += $payment->aguinaldo;
                    $total_refound += $payment->refound;
                    $total_remuneration += $payment->total_remuneration;

                    $total_onp += $payment->onp_discount;
                    $total_afp_jub += $payment->obligatory_afp;
                    $total_afp_c_v += $payment->variable_afp;
                    $total_afp_inva += $payment->life_insurance_afp;
                    $total_judicial += $payment->judicial;
                    $total_others += $payment->others;
                    $total_discount += $payment->total_discount;

                    $total_essalud += $payment->essalud;
                    $total_contribution += $payment->total_contribution;

                    $total_net_pay += $payment->net_pay;
                @endphp
                <tr class="row">
                    <td class="cel cel-middle text-center text-bold">
                        {{ sprintf('%05d', $payment->contract->employee_id) }}
                    </td>
                    <td class="cel cel-top">
                        <table class="details-table">
                            <tr>
                                <td class="text-bold">EMPLEADO</td>
                                <td>: {{ $payment->contract->employee->name }}
                                    {{ $payment->contract->employee->last_name }}
                                    {{ $payment->contract->employee->second_last_name }}</td>
                            </tr>
                            <tr>
                                <td class="text-bold">IDENTIFICACIÓN</td>
                                <td>: ({{ $payment->contract->employee->identity_type->name }})
                                    {{ $payment->contract->employee->identity_number }}</td>
                            </tr>
                            <tr>
                                <td class="text-bold">CUENTA</td>
                                <td>: {{ $payment->contract->employee->bank_account }}</td>
                            </tr>
                            <tr>
                                <td class="text-nowrap text-bold">SIS. PENSIÓN</td>
                                <td style="text-transform: uppercase">:
                                    {{ $payment->contract->employee->pension_system }}
                                    {{ $payment->contract->employee->pension_system === 'afp' ? "{$payment->afp->name}" : '' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-bold">RUC</td>
                                <td>: {{ $payment->contract->employee->ruc ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="text-bold">DÍAS</td>
                                <td>: {{ $payment->days }}</td>
                            </tr>
                            <tr>
                                <td class="text-bold">CARGO</td>
                                <td>: {{ $payment->contract->job_position->name }}</td>
                            </tr>
                        </table>
                    </td>
                    <td class="cel cel-top">
                        <table class="w-full">
                            <tr>
                                <td>BÁSICO</td>
                                <td class="text-right">{{ number_format($payment->basic, 2) }}</td>
                            </tr>
                            @if ($payment->aguinaldo)
                                <tr>
                                    <td>AGUINALDO</td>
                                    <td class="text-right">{{ number_format($payment->aguinaldo, 2) }}</td>
                                </tr>
                            @endif
                            @if ($payment->refound)
                                <tr>
                                    <td>REINTEGRO</td>
                                    <td class="text-right">{{ number_format($payment->refound, 2) }}</td>
                                </tr>
                            @endif
                            <tr>
                                <td class="text-bold">TOTAL</td>
                                <td class="text-right text-bold">{{ number_format($payment->total_remuneration, 2) }}</td>
                            </tr>
                        </table>
                    </td>
                    <td class="cel cel-top">
                        <table class="w-full">
                            @if ($payment->onp_discount)
                                <tr>
                                    <td>ONP</td>
                                    <td class="text-right">{{ number_format($payment->onp_discount, 2) }}</td>
                                </tr>
                            @endif
                            @if ($payment->afp_discount)
                                <tr>
                                    <td>AFP-JUB</td>
                                    <td class="text-right">{{ number_format($payment->obligatory_afp, 2) }}</td>
                                </tr>
                                <tr>
                                    <td>AFP-C-V</td>
                                    <td class="text-right">{{ number_format($payment->variable_afp, 2) }}</td>
                                </tr>
                                <tr>
                                    <td>AFP-INVA</td>
                                    <td class="text-right">{{ number_format($payment->life_insurance_afp, 2) }}</td>
                                </tr>
                            @endif
                            @if ($payment->judicial)
                                <tr>
                                    <td>D. JUDICIAL</td>
                                    <td class="text-right">{{ number_format($payment->judicial, 2) }}</td>
                                </tr>
                            @endif
                            @if ($payment->others)
                                <tr>
                                    <td>OTROS</td>
                                    <td class="text-right">{{ number_format($payment->others, 2) }}</td>
                                </tr>
                            @endif
                            <tr>
                                <td class="text-bold">TOTAL</td>
                                <td class="text-right text-bold">{{ number_format($payment->total_discount, 2) }}</td>
                            </tr>
                        </table>
                    </td>
                    <td class="cel cel-top">
                        <table class="w-full">
                            <tr>
                                <td>ESSALUD</td>
                                <td class="text-right">{{ number_format($payment->essalud, 2) }}</td>
                            </tr>
                            <tr>
                                <td class="text-bold">TOTAL</td>
                                <td class="text-right text-bold">{{ number_format($payment->total_contribution, 2) }}</td>
                            </tr>
                        </table>
                    </td>
                    <td class="cel cel-top">
                        <table class="w-full">
                            <tr>
                                <td class="text-bold">TOTAL</td>
                                <td class="text-right text-bold">{{ number_format($payment->net_pay, 2) }}</td>
                            </tr>
                        </table>
                    </td>
                    <td class="cel cel-top"></td>
                </tr>
            @endforeach

        </tbody>
        <tfoot>
            <tr>
                <td class="cel cel-middle text-center text-bold" colspan="2">TOTAL</td>
                <td class="cel cel-top">
                    <table class="w-full">
                        <tr>
                            <td>BÁSICO</td>
                            <td class="text-right">{{ number_format($total_basic, 2) }}</td>
                        </tr>
                        @if ($total_aguinaldo > 0)
                            <tr>
                                <td>AGUINALDO</td>
                                <td class="text-right">{{ number_format($total_aguinaldo, 2) }}</td>
                            </tr>
                        @endif
                        @if ($total_refound > 0)
                            <tr>
                                <td>REINTEGRO</td>
                                <td class="text-right">{{ number_format($total_refound, 2) }}</td>
                            </tr>
                        @endif
                        <tr>
                            <td class="text-bold">TOTAL</td>
                            <td class="text-right text-bold">{{ number_format($total_remuneration, 2) }}
                            </td>
                        </tr>
                    </table>
                </td>
                <td class="cel cel-top">
                    <table class="w-full">
                        @if ($total_onp > 0)
                            <tr>
                                <td>ONP</td>
                                <td class="text-right">{{ number_format($total_onp, 2) }}</td>
                            </tr>
                        @endif
                        @if ($total_afp_jub > 0)
                            <tr>
                                <td>AFP-JUB</td>
                                <td class="text-right">{{ number_format($total_afp_jub, 2) }}</td>
                            </tr>
                        @endif
                        @if ($total_afp_c_v > 0)
                            <tr>
                                <td>AFP-C-V</td>
                                <td class="text-right">{{ number_format($total_afp_c_v, 2) }}</td>
                            </tr>
                        @endif
                        @if ($total_afp_inva > 0)
                            <tr>
                                <td>AFP-INVA</td>
                                <td class="text-right">{{ number_format($total_afp_inva, 2) }}</td>
                            </tr>
                        @endif
                        @if ($total_judicial > 0)
                            <tr>
                                <td>D. JUDICIAL</td>
                                <td class="text-right">{{ number_format($total_judicial, 2) }}</td>
                            </tr>
                        @endif
                        @if ($total_others > 0)
                            <tr>
                                <td>OTROS</td>
                                <td class="text-right">{{ number_format($total_others, 2) }}</td>
                            </tr>
                        @endif
                        <tr>
                            <td class="text-bold">TOTAL</td>
                            <td class="text-right text-bold">{{ number_format($total_discount, 2) }}</td>
                        </tr>
                    </table>
                </td>
                <td class="cel cel-top">
                    <table class="w-full">
                        <tr>
                            <td>ESSALUD</td>
                            <td class="text-right">{{ number_format($total_essalud, 2) }}</td>
                        </tr>
                        <tr>
                            <td class="text-bold">TOTAL</td>
                            <td class="text-right text-bold">{{ number_format($total_contribution, 2) }}</td>
                        </tr>
                    </table>
                </td>
                <td class="cel cel-top">
                    <table class="w-full">
                        <tr>
                            <td class="text-bold">NETO</td>
                            <td class="text-right text-bold">{{ number_format($total_net_pay, 2) }}</td>
                        </tr>
                    </table>
                </td>
                <td class="cel cel-top"></td>
            </tr>
        </tfoot>
    </table>
    <!-- FIN SECCIÓN -->

    <!-- SECCIÓN JUDICIAL -->
    @php
        $has_judicial_discounts = false;
        foreach ($period->payments as $payment) {
            if (count($payment->judicial_discounts) > 0) {
                $has_judicial_discounts = true;
                break;
            }
        }
    @endphp

    @if ($has_judicial_discounts)
        <div style="page-break-after:always;"></div> <!-- SALTO DE PÁG.-->
        <table class="w-full">
            <tr>
                <td class="corner"><img class="logo" src="{{ public_path('img/asuncion.jpg') }}" alt="">
                </td>
                <td>
                    <div class="text-bold text-center text-lg">PLANILLA DE REMUNERACIONES</div>
                    <div class="text-center text-md text-bold">DESCUENTO JUDICIAL - DEMANDANTE</div>
                    <div class="text-center">D.L. 1057 CONTRATO ADMINISTRATIVO DE SERVICIOS</div>
                </td>
                <td class="text-right corner"></td>
            </tr>
        </table>

        <table>
            <tr>
                <td class="text-bold">N° PLANILLA</td>
                <td>: {{ $period->payroll->number }}-{{ $period->payroll->year }}</td>
            </tr>
            <tr>
                <td class="text-bold">PERIODO</td>
                <td>: {{ $periods[$period->mounth] }} {{ $period->payroll->year }}</td>
            </tr>
            <tr>
                <td class="text-bold">ESTABLECIMIENTO</td>
                <td>: UGEL - ASUNCIÓN</td>
            </tr>
            <tr>
                <td class="text-bold">F. FINANCIAMIENTO</td>
                <td>: [{{ $period->payroll->funding_resource->code }}] {{ $period->payroll->funding_resource->name }}
                </td>
            </tr>
        </table>

        <table class="w-full table">
            <thead>
                <tr>
                    <th class="cel text-bold" style="width: 35px">COD</th>
                    <th class="cel text-bold" style="width: 550px">DATOS</th>
                    <th class="cel text-bold" style="width: 200px">DESCUENTO JUDICIAL</th>
                    <th class="cel text-bold">FIRMA</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($period->payments as $payment)
                    @foreach ($payment->judicial_discounts as $judicial_discount)
                        <tr class="row">
                            <td class="cel cel-middle text-center text-bold">
                                {{ sprintf('%05d', $judicial_discount->id) }}
                            </td>
                            <td class="cel cel-top">
                                <table class="details-table">
                                    <tr>
                                        <td class="text-bold">RAZÓN</td>
                                        <td>: {{ $judicial_discount->name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-bold">CUENTA JUDICIAL</td>
                                        <td>: {{ $judicial_discount->account ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-bold">DNI JUDICIAL</td>
                                        <td>: {{ $judicial_discount->dni }}</td>
                                    </tr>
                                </table>
                            </td>
                            <td class="cel cel-top">
                                <table class="w-full">
                                    <tr>
                                        <td>TOTAL</td>
                                        <td class="text-right">{{ $judicial_discount->pivot->amount }}</td>
                                    </tr>
                                </table>
                            </td>
                            <td class="cel cel-top"></td>
                        </tr>
                    @endforeach
                @endforeach

            </tbody>
            <tfoot>
                <tr>
                    <td class="cel cel-middle text-center text-bold" colspan="2"></td>
                    <td class="cel cel-top">
                        <table class="w-full">
                            <tr>
                                <td class="text-bold">TOTAL</td>
                                <td class="text-right text-bold">{{ number_format($total_judicial, 2, '.', '') }}
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td class="cel cel-top"></td>
                </tr>
            </tfoot>
        </table>
    @endif
    <!-- FIN SECCIÓN -->

</body>

</html>
