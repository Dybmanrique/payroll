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
</style>

<body>

    <table class="w-full">
        <tr>
            <td class="corner"><img src="{{ public_path('img/asuncion.jpg') }}" alt=""></td>
            <td>
                <div class="text-bold text-center text-lg">PLANILLA DE REMUNERACIONES</div>
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
            <td>: [{{ $period->payroll->funding_resource->code }}] {{ $period->payroll->funding_resource->name }}</td>
        </tr>
    </table>

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
                    $total_net_pay += $payment->net_pay;
                @endphp
                <tr class="row">
                    <td class="cel cel-middle text-center text-bold">
                        {{ sprintf("%05d", $payment->contract->employee_id) }}
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
                                <td class="text-bold">BÁSICO</td>
                                <td class="text-right">{{ $payment->basic }}</td>
                            </tr>
                            @if ($payment->aguinaldo)
                                <tr>
                                    <td class="text-bold">AGUINALDO</td>
                                    <td class="text-right">{{ $payment->aguinaldo }}</td>
                                </tr>
                            @endif
                            @if ($payment->refound)
                                <tr>
                                    <td class="text-bold">REINTEGRO</td>
                                    <td class="text-right">{{ $payment->refound }}</td>
                                </tr>
                            @endif
                            <tr>
                                <td class="text-bold">TOTAL</td>
                                <td class="text-right text-bold">{{ $payment->total_remuneration }}</td>
                            </tr>
                        </table>
                    </td>
                    <td class="cel cel-top">
                        <table class="w-full">
                            @if ($payment->onp_discount)
                                <tr>
                                    <td class="text-bold">ONP</td>
                                    <td class="text-right">{{ $payment->onp_discount }}</td>
                                </tr>
                            @endif
                            @if ($payment->afp_discount)
                                <tr>
                                    <td class="text-bold">AFP-JUB</td>
                                    <td class="text-right">{{ $payment->obligatory_afp }}</td>
                                </tr>
                                <tr>
                                    <td class="text-bold">AFP-C-V</td>
                                    <td class="text-right">{{ $payment->variable_afp }}</td>
                                </tr>
                                <tr>
                                    <td class="text-bold">AFP-INVA</td>
                                    <td class="text-right">{{ $payment->life_insurance_afp }}</td>
                                </tr>
                            @endif
                            @if ($payment->judicial)
                                <tr>
                                    <td class="text-bold">D. JUDICIAL</td>
                                    <td class="text-right">{{ $payment->judicial }}</td>
                                </tr>
                            @endif
                            @if ($payment->others)
                                <tr>
                                    <td class="text-bold">OTROS</td>
                                    <td class="text-right">{{ $payment->others }}</td>
                                </tr>
                            @endif
                            <tr>
                                <td class="text-bold">TOTAL</td>
                                <td class="text-right text-bold">{{ $payment->total_discount }}</td>
                            </tr>
                        </table>
                    </td>
                    <td class="cel cel-top">
                        <table class="w-full">
                            <tr>
                                <td class="text-bold">ESSALUD</td>
                                <td class="text-right text-bold">{{ $payment->essalud }}</td>
                            </tr>
                        </table>
                    </td>
                    <td class="cel cel-top">
                        <table class="w-full">
                            <tr>
                                <td class="text-bold">TOTAL</td>
                                <td class="text-right text-bold">{{ $payment->net_pay }}</td>
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
                            <td class="text-bold">BÁSICO</td>
                            <td class="text-right">{{ number_format($total_basic, 2, '.', '') }}</td>
                        </tr>
                        <tr>
                            <td class="text-bold">AGUINALDO</td>
                            <td class="text-right">{{ number_format($total_aguinaldo, 2, '.', '') }}</td>
                        </tr>
                        <tr>
                            <td class="text-bold">REINTEGRO</td>
                            <td class="text-right">{{ number_format($total_refound, 2, '.', '') }}</td>
                        </tr>
                        <tr>
                            <td class="text-bold">TOTAL</td>
                            <td class="text-right text-bold">{{ number_format($total_remuneration, 2, '.', '') }}</td>
                        </tr>
                    </table>
                </td>
                <td class="cel cel-top">
                    <table class="w-full">
                        <tr>
                            <td class="text-bold">ONP</td>
                            <td class="text-right">{{ number_format($total_onp, 2, '.', '') }}</td>
                        </tr>
                        <tr>
                            <td class="text-bold">AFP-JUB</td>
                            <td class="text-right">{{ number_format($total_afp_jub, 2, '.', '') }}</td>
                        </tr>
                        <tr>
                            <td class="text-bold">AFP-C-V</td>
                            <td class="text-right">{{ number_format($total_afp_c_v, 2, '.', '') }}</td>
                        </tr>
                        <tr>
                            <td class="text-bold">AFP-INVA</td>
                            <td class="text-right">{{ number_format($total_afp_inva, 2, '.', '') }}</td>
                        </tr>
                        <tr>
                            <td class="text-bold">D. JUDICIAL</td>
                            <td class="text-right">{{ number_format($total_judicial, 2, '.', '') }}</td>
                        </tr>
                        <tr>
                            <td class="text-bold">TOTAL</td>
                            <td class="text-right text-bold">{{ number_format($total_discount, 2, '.', '') }}</td>
                        </tr>
                    </table>
                </td>
                <td class="cel cel-top">
                    <table class="w-full">
                        <tr>
                            <td class="text-bold">ESSALUD</td>
                            <td class="text-right text-bold">{{ number_format($total_essalud, 2, '.', '') }}</td>
                        </tr>
                    </table>
                </td>
                <td class="cel cel-top">
                    <table class="w-full">
                        <tr>
                            <td class="text-bold">NETO</td>
                            <td class="text-right text-bold">{{ number_format($total_net_pay, 2, '.', '') }}</td>
                        </tr>
                    </table>
                </td>
                <td class="cel cel-top"></td>
            </tr>
        </tfoot>
    </table>
</body>

</html>
