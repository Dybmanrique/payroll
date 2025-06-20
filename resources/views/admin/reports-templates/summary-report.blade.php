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
        font-size: 14px;
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
                <div class="text-bold text-center text-lg">RESUMEN DE PLANILLA</div>
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

    @php
        $total_final_basic = 0;
        $total_final_aguinaldo = 0;
        $total_final_refound = 0;
        $total_final_remuneration = 0;

        $total_final_onp = 0;
        $total_final_afp_jub = 0;
        $total_final_afp_c_v = 0;
        $total_final_afp_inva = 0;
        $total_final_judicial = 0;
        $total_final_others = 0;
        $total_final_discount = 0;

        $total_final_essalud = 0;
        $total_final_contribution = 0;

        $total_final_net_pay = 0;
    @endphp
    @foreach ($results as $result)
        <div style="margin-top: 20px; margin-left: 3px;" class="text-md"><span class="text-bold">FINALIDAD:</span>
            {{ $result->budgetary_objective->name }}</div>
        <table style="margin-bottom: 10px">
            <tr>
                <td class="text-bold">PROGRAMA PRESUPUESTAL</td>
                <td>: {{ $result->budgetary_objective->programa_pptal }}</td>
            </tr>
            <tr>
                <td class="text-bold">PRODUCTO/PROYECTO</td>
                <td>: {{ $result->budgetary_objective->producto_proyecto }}</td>
            </tr>
            <tr>
                <td class="text-bold">ACTIVIDAD/OBRA/INVERSIÓN</td>
                <td>: {{ $result->budgetary_objective->activ_obra_accinv }}</td>
            </tr>
            <tr>
                <td class="text-bold">FUNCIÓN</td>
                <td>: {{ $result->budgetary_objective->funcion }}</td>
            </tr>
            <tr>
                <td class="text-bold">DIVISIÓN FUNCIONAL</td>
                <td>: {{ $result->budgetary_objective->division_fn }}</td>
            </tr>
            <tr>
                <td class="text-bold">GRUPO FUNCIONAL</td>
                <td>: {{ $result->budgetary_objective->grupo_fn }}</td>
            </tr>
            <tr>
                <td class="text-bold">SECUENCIA FUNCIONAL</td>
                <td>: {{ $result->budgetary_objective->sec_func }}</td>
            </tr>
        </table>

        <table class="w-full table">
            <thead>
                <tr>
                    <th class="cel text-bold" style="width: 35px" rowspan="2">COD</th>
                    <th class="cel text-bold" style="width: 350px" rowspan="2">DATOS</th>
                    <th class="cel text-bold" colspan="2">CAS ({{ $result->budgetary_objective->cas_classifier }})
                    </th>
                    @if ($period->mounth === 7 || $period->mounth === 12)
                        <th class="cel text-bold" style="width: 125px" rowspan="2">AGUINALDO
                            ({{ $result->budgetary_objective->aguinaldo_classifier }})</th>
                    @endif
                    <th class="cel text-bold" style="width: 130px" rowspan="2">ESSALUD
                        ({{ $result->budgetary_objective->essalud_classifier }})</th>
                </tr>
                <tr>
                    <th class="cel text-bold" style="width: 150px">INGRESOS</th>
                    <th class="cel text-bold" style="width: 150px">DESCUENTOS</th>
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
                    $total_fines_discount = 0;
                    $total_discount = 0;

                    $total_essalud = 0;
                    $total_contribution = 0;

                    $total_net_pay = 0;
                @endphp
                @foreach ($result->payments as $payment)
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
                        $total_fines_discount += $payment->fines_discount;
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
                                    <td>:
                                        {{ $payment->contract->employee->last_name }}
                                        {{ $payment->contract->employee->second_last_name }}
                                        {{ $payment->contract->employee->name }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-bold">IDENTIFICACIÓN</td>
                                    <td>: ({{ $payment->contract->employee->identity_type->name }})
                                        {{ $payment->contract->employee->identity_number }}</td>
                                </tr>
                            </table>
                        </td>
                        <td class="cel cel-top">
                            <table class="w-full">
                                <tr>
                                    <td>BÁSICO</td>
                                    <td class="text-right">{{ number_format($payment->basic, 2) }}</td>
                                </tr>
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
                                    @if ($payment->variable_afp)
                                    <tr>
                                        <td>AFP-C-V</td>
                                        <td class="text-right">{{ number_format($payment->variable_afp, 2) }}</td>
                                    </tr>
                                    @endif
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
                                @if ($payment->fines_discount)
                                    <tr>
                                        <td>FALTAS Y/O TARDANZAS</td>
                                        <td class="text-right">{{ number_format($payment->fines_discount, 2) }}</td>
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
                        @if ($period->mounth === 7 || $period->mounth === 12)
                            <td class="cel cel-top">
                                <table class="w-full">
                                    <tr>
                                        <td class="text-bold">TOTAL</td>
                                        <td class="text-right text-bold">{{ number_format($payment->aguinaldo, 2) ?? '-' }}</td>
                                    </tr>
                                </table>
                            </td>
                        @endif
                        <td class="cel cel-top">
                            <table class="w-full">
                                <tr>
                                    <td class="text-bold">TOTAL</td>
                                    <td class="text-right text-bold">{{ number_format($payment->essalud, 2) }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                @endforeach

            </tbody>
            <tfoot>
                <tr>
                    <td class="cel cel-middle text-center text-bold" colspan="2" rowspan="2">TOTAL</td>
                    <td class="cel cel-top">
                        <table class="w-full">
                            <tr>
                                <td>BÁSICO</td>
                                <td class="text-right">{{ number_format($total_basic, 2) }}</td>
                            </tr>
                            @if ($total_refound > 0)
                                <tr>
                                    <td>REINTEGRO</td>
                                    <td class="text-right">{{ number_format($total_refound, 2) }}</td>
                                </tr>
                            @endif
                            <tr>
                                <td class="text-bold">TOTAL</td>
                                <td class="text-right text-bold">
                                    {{ number_format($total_basic + $total_refound, 2) }}
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
                            @if ($total_afp_c_v)
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
                            @if ($total_fines_discount > 0)
                                <tr>
                                    <td>FALTAS Y/O TARDANZAS</td>
                                    <td class="text-right">{{ number_format($total_fines_discount, 2) }}</td>
                                </tr>
                            @endif
                            <tr>
                                <td class="text-bold">TOTAL</td>
                                <td class="text-right text-bold">{{ number_format($total_discount, 2) }}</td>
                            </tr>
                        </table>
                    </td>
                    @if ($period->mounth === 7 || $period->mounth === 12)
                        <td class="cel cel-top">
                            <table class="w-full">
                                <tr>
                                    <td class="text-bold">TOTAL</td>
                                    <td class="text-right text-bold">{{ number_format($total_aguinaldo, 2) }}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    @endif
                    <td class="cel cel-top">
                        <table class="w-full">
                            <tr>
                                <td class="text-bold">TOTAL</td>
                                <td class="text-right text-bold">
                                    {{ number_format($total_essalud, 2) }}
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="{{ $period->mounth === 7 || $period->mounth === 12 ? '4' : '3' }}">
                        <table class="w-full">
                            @if ($period->mounth === 7 || $period->mounth === 12)
                            <tr>
                                <td class="text-bold">INGRESOS + AGUINALDO</td>
                                <td class="text-right text-bold">
                                    {{ number_format($total_remuneration, 2) }}
                                </td>
                            </tr>
                            @endif
                            <tr>
                                <td class="text-bold">TOTAL SECCIÓN</td>
                                <td class="text-right text-bold">
                                    {{ number_format($total_essalud + $total_remuneration, 2) }}
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </tfoot>
        </table>
        @if (!$loop->last)
            <div style="page-break-after:always;"></div> <!-- SALTO DE PÁG.-->
        @endif
        @php
            $total_final_basic += $total_basic;
            $total_final_aguinaldo += $total_aguinaldo;
            $total_final_refound += $total_refound;
            $total_final_remuneration += $total_remuneration;

            $total_final_onp += $total_onp;
            $total_final_afp_jub += $total_afp_jub;
            $total_final_afp_c_v += $total_afp_c_v;
            $total_final_afp_inva += $total_afp_inva;
            $total_final_judicial += $total_judicial;
            $total_final_others += $total_others;
            $total_final_discount += $total_discount;

            $total_final_essalud += $total_essalud;
            $total_final_contribution += $total_contribution;

            $total_final_net_pay += $total_net_pay;
        @endphp
    @endforeach
    <!-- FIN SECCIÓN -->

    <!-- SECCIÓN FINAL -->
    <div style="page-break-after:always;"></div> <!-- SALTO DE PÁG.-->
    <hr style="margin-bottom: 1px solid">
    <div style="margin-top: 10px; margin-bottom: 10px;" class="text-bold text-md text-center">SUMA FINAL DE LAS SECCIONES</div>
    <hr style="margin-bottom: 1px solid">
    <table class="w-full table">
        <thead>
            <tr>
                <th class="cel text-bold" style="width: 100px" rowspan="4" colspan="2">TOTAL</th>
                <th class="cel text-bold" colspan="2">CAS</th>
                @if ($period->mounth === 7 || $period->mounth === 12)
                    <th class="cel text-bold" rowspan="2">AGUINALDO</th>
                @endif
                <th class="cel text-bold" rowspan="2">ESSALUD</th>
            </tr>
            <tr>
                <th class="cel text-bold">INGRESOS</th>
                <th class="cel text-bold">DESCUENTOS</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                {{-- <td class="cel cel-middle text-center text-bold" colspan="2" rowspan="2">TOTAL</td> --}}
                <td class="cel cel-top">
                    <table class="w-full">
                        <tr>
                            <td>BÁSICO</td>
                            <td class="text-right">{{ number_format($total_final_basic, 2) }}</td>
                        </tr>
                        @if ($total_final_refound > 0)
                            <tr>
                                <td>REINTEGRO</td>
                                <td class="text-right">{{ number_format($total_final_refound, 2) }}</td>
                            </tr>
                        @endif
                        <tr>
                            <td class="text-bold">TOTAL</td>
                            <td class="text-right text-bold">
                                {{ number_format($total_final_basic + $total_final_refound, 2) }}
                            </td>
                        </tr>
                    </table>
                </td>
                <td class="cel cel-top">
                    <table class="w-full">
                        @if ($total_final_onp > 0)
                            <tr>
                                <td>ONP</td>
                                <td class="text-right">{{ number_format($total_final_onp, 2) }}</td>
                            </tr>
                        @endif
                        @if ($total_final_afp_jub > 0)
                            <tr>
                                <td>AFP-JUB</td>
                                <td class="text-right">{{ number_format($total_final_afp_jub, 2) }}</td>
                            </tr>
                        @endif
                        @if ($total_final_afp_c_v)
                            <tr>
                                <td>AFP-C-V</td>
                                <td class="text-right">{{ number_format($total_final_afp_c_v, 2) }}</td>
                            </tr>
                        @endif
                        @if ($total_final_afp_inva > 0)
                            <tr>
                                <td>AFP-INVA</td>
                                <td class="text-right">{{ number_format($total_final_afp_inva, 2) }}</td>
                            </tr>
                        @endif
                        @if ($total_final_judicial > 0)
                            <tr>
                                <td>D. JUDICIAL</td>
                                <td class="text-right">{{ number_format($total_final_judicial, 2) }}</td>
                            </tr>
                        @endif
                        @if ($total_final_others > 0)
                            <tr>
                                <td>OTROS</td>
                                <td class="text-right">{{ number_format($total_final_others, 2) }}</td>
                            </tr>
                        @endif
                        <tr>
                            <td class="text-bold">TOTAL</td>
                            <td class="text-right text-bold">{{ number_format($total_final_discount, 2) }}
                            </td>
                        </tr>
                    </table>
                </td>
                @if ($period->mounth === 7 || $period->mounth === 12)
                    <td class="cel cel-top">
                        <table class="w-full">
                            <tr>
                                <td class="text-bold">TOTAL</td>
                                <td class="text-right text-bold">
                                    {{ number_format($total_final_aguinaldo, 2) }}
                                </td>
                            </tr>
                        </table>
                    </td>
                @endif
                <td class="cel cel-top">
                    <table class="w-full">
                        <tr>
                            <td class="text-bold">TOTAL</td>
                            <td class="text-right text-bold">
                                {{ number_format($total_final_essalud, 2) }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="{{ $period->mounth === 7 || $period->mounth === 12 ? '4' : '3' }}">
                    <table class="w-full">
                        @if ($period->mounth === 7 || $period->mounth === 12)
                            <tr>
                                <td class="text-bold">INGRESOS + AGUINALDO</td>
                                <td class="text-right text-bold">
                                    {{ number_format($total_final_remuneration, 2) }}
                                </td>
                            </tr>
                        @endif
                        <tr>
                            <td class="text-bold">TOTAL FINAL</td>
                            <td class="text-right text-bold">
                                {{ number_format($total_final_essalud + $total_final_remuneration, 2) }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
    <!-- FIN SECCIÓN FINAL -->
</body>

</html>
