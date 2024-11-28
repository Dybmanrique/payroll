<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte General</title>
</head>
<style>
    @page {
        margin: 2cm;
        /* Ajustar los márgenes aquí */
    }

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
        width: 180px;
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

    .logo {
        width: 100px;
    }
</style>

<body>

    <table class="w-full">
        <tr>
            <td class="corner"><img class="logo" src="{{ public_path('img/asuncion.jpg') }}" alt=""></td>
            <td class="text-bold text-center text-lg">
                REPORTE GENERAL
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
                        <td>: {{ $periods[$period->mounth] }} {{ $period->payroll->year }}</td>
                    </tr>
                    <tr>
                        <td class="text-bold">N° PLANILLA</td>
                        <td>: {{ $period->payroll->number }}-{{ $period->payroll->year }}</td>
                    </tr>
                </table>
            </td>
            <td style="width: 250px">
                <table>
                    <tr>
                        <td class="text-bold">TIPO DE PLANILLA</td>
                        <td>: {{ $period->payroll->payroll_type->name }}</td>
                    </tr>
                    <tr>
                        <td class="text-bold">ESTABLECIMIENTO</td>
                        <td>: UGEL - Asunción</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    @php
        $total_final_basic = 0;
        $total_final_refound = 0;
        $total_final_discount = 0;
        $total_final_remuneration = 0;
        $total_final_net_pay = 0;
        $total_final_aguinaldo = 0;
        $total_final_essalud = 0;
    @endphp
    @foreach ($results as $result)
        @php
            $total_final_basic += $result->total_basic;
            $total_final_refound += $result->total_refound;
            $total_final_discount += $result->total_discount;
            $total_final_remuneration += $result->total_remuneration;
            $total_final_net_pay += $result->total_net_pay;
            $total_final_aguinaldo += $result->total_aguinaldo;
            $total_final_essalud += $result->total_essalud;
        @endphp
        <div style="margin-top: 30px; margin-left: 3px;" class="text-md"><span class="text-bold">FINALIDAD:</span>
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
        <table class="w-full" style="table-layout: fixed;">
            <tr>
                <td style="vertical-align: top">
                    <div class="border text-center text-bold" style="border-bottom: none; padding: 3px;">
                        CAS ({{ $result->budgetary_objective->cas_classifier }})
                    </div>
                    <div class="border" style="min-height: 100px;">
                        <table class="w-full">
                            <tr>
                                <td>INGRESOS: </td>
                                <td class="text-right">
                                    {{ number_format($result->total_basic + $result->total_refound, 2, '.', '') }}</td>
                            </tr>
                            <tr>
                                <td>DESCUENTOS: </td>
                                <td class="text-right">{{ $result->total_discount }}</td>
                            </tr>
                            <tr>
                                <td>NETOS: </td>
                                <td class="text-right">
                                    {{ number_format($result->total_basic + $result->total_refound - $result->total_discount, 2, '.', '') }}
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>
                @if ($period->mounth == 7 || $period->mounth == 12)
                    <td style="vertical-align: top">
                        <div class="border text-center text-bold" style="border-bottom: none; padding: 3px;">
                            AGUINALDO ({{ $result->budgetary_objective->aguinaldo_classifier }})
                        </div>
                        <div class="border" style="min-height: 100px;">
                            <table class="w-full">
                                <tr>
                                    <td>TOTAL: </td>
                                    <td class="text-right">{{ $result->total_aguinaldo ?? 'No aplicable' }}</td>
                                </tr>
                            </table>
                        </div>
                    </td>
                @endif
                <td style="vertical-align: top">
                    <div class="border text-center text-bold" style="border-bottom: none; padding: 3px;">
                        ESSALUD ({{ $result->budgetary_objective->essalud_classifier }})
                    </div>
                    <div class="border" style="min-height: 100px;">
                        <table class="w-full">
                            <tr>
                                <td>TOTAL: </td>
                                <td class="text-right">{{ $result->total_essalud }}</td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
            <tr>
                <td style="vertical-align: top"
                    colspan="{{ $period->mounth == 7 || $period->mounth == 12 ? '3' : '2' }}">
                    <div class="border text-center text-bold" style="border-bottom: none; padding: 3px;">
                        NETO
                    </div>
                    <div class="border" style="min-height: 100px;">
                        <table class="w-full">
                            <tr>
                                <td>TOTAL INGRESOS: </td>
                                <td class="text-right">{{ $result->total_remuneration }}</td>
                            </tr>
                            <tr>
                                <td>TOTAL DESCUENTOS: </td>
                                <td class="text-right">{{ $result->total_discount }}</td>
                            </tr>
                            <tr>
                                <td>TOTAL APORTES: </td>
                                <td class="text-right">{{ $result->total_essalud }}</td>
                            </tr>
                            <tr>
                                <td>TOTAL FINAL: </td>
                                <td class="text-right">
                                    {{ number_format($result->total_essalud + $result->total_remuneration, 2, '.', '') }}
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
        </table>
        @if (!$loop->last)
            <div style="page-break-after:always;"></div> <!-- SALTO DE PÁG.-->
        @endif
    @endforeach
    <div style="page-break-after:always;"></div> <!-- SALTO DE PÁG.-->
    <div class="text-bold text-md">SUMA TOTAL DE SECCIONES</div>
    <table class="w-full text-bold" style="table-layout: fixed;">
        <tr>
            <td style="vertical-align: top">
                <div class="border text-center text-bold" style="border-bottom: none; padding: 3px;">
                    CAS
                </div>
                <div class="border" style="min-height: 100px;">
                    <table class="w-full">
                        <tr>
                            <td>INGRESOS: </td>
                            <td class="text-right">
                                {{ number_format($total_final_basic + $total_final_refound, 2, '.', '') }}</td>
                        </tr>
                        <tr>
                            <td>DESCUENTOS: </td>
                            <td class="text-right">{{ $total_final_discount }}</td>
                        </tr>
                        <tr>
                            <td>NETOS: </td>
                            <td class="text-right">
                                {{ number_format($total_final_basic + $total_final_refound - $total_final_discount, 2, '.', '') }}
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
            @if ($period->mounth == 7 || $period->mounth == 12)
                <td style="vertical-align: top">
                    <div class="border text-center text-bold" style="border-bottom: none; padding: 3px;">
                        AGUINALDO
                    </div>
                    <div class="border" style="min-height: 100px;">
                        <table class="w-full">
                            <tr>
                                <td>TOTAL: </td>
                                <td class="text-right">{{ $total_final_aguinaldo ?? 'No aplicable' }}</td>
                            </tr>
                        </table>
                    </div>
                </td>
            @endif
            <td style="vertical-align: top">
                <div class="border text-center text-bold" style="border-bottom: none; padding: 3px;">
                    ESSALUD
                </div>
                <div class="border" style="min-height: 100px;">
                    <table class="w-full">
                        <tr>
                            <td>TOTAL: </td>
                            <td class="text-right">{{ $total_final_essalud }}</td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top"
                colspan="{{ $period->mounth == 7 || $period->mounth == 12 ? '3' : '2' }}">
                <div class="border text-center text-bold" style="border-bottom: none; padding: 3px;">
                    NETO
                </div>
                <div class="border" style="min-height: 100px;">
                    <table class="w-full">
                        <tr>
                            <td>TOTAL INGRESOS: </td>
                            <td class="text-right">{{ $total_final_remuneration }}</td>
                        </tr>
                        <tr>
                            <td>TOTAL DESCUENTOS: </td>
                            <td class="text-right">{{ $total_final_discount }}</td>
                        </tr>
                        <tr>
                            <td>TOTAL APORTES: </td>
                            <td class="text-right">{{ $total_final_essalud }}</td>
                        </tr>
                        <tr>
                            <td>TOTAL FINAL: </td>
                            <td class="text-right">
                                {{ number_format($total_final_essalud + $total_final_remuneration, 2, '.', '') }}
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </table>
</body>

</html>
