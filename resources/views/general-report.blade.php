<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte General</title>
</head>
<style>
    @page {
        margin: 2cm; /* Ajustar los márgenes aquí */
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

    .text-lg{
        font-size: 25px;
    }
</style>

<body>

    <table class="w-full">
        <tr>
            <td class="corner"><img src="{{ public_path('img/asuncion.jpg') }}" alt=""></td>
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
                        <td>: Octuber 2024</td>
                    </tr>
                    <tr>
                        <td class="text-bold">N° PLANILLA</td>
                        <td>: 0001</td>
                    </tr>
                </table>
            </td>
            <td style="width: 250px">
                <table>
                    <tr>
                        <td class="text-bold">TIPO DE PLANILLA</td>
                        <td>: CAS</td>
                    </tr>
                    <tr>
                        <td class="text-bold">ESTABLECIMIENTO</td>
                        <td>: UGEL - Asunción</td>
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
                            <td>TOTAL: </td>
                            <td class="text-right">1000.00</td>
                        </tr>
                    </table>
                </div>
            </td>
            <td style="vertical-align: top">
                <div class="border text-center text-bold" style="border-bottom: none; padding: 3px;">
                    DESCUENTOS
                </div>
                <div class="border" style="min-height: 100px;">
                    <table class="w-full">
                        <tr>
                            <td>TOTAL: </td>
                            <td class="text-right">1000.00</td>
                        </tr>
                    </table>
                </div>
            </td>
            <td style="vertical-align: top">
                <div class="border text-center text-bold" style="border-bottom: none; padding: 3px;">
                    APORTES
                </div>
                <div class="border" style="min-height: 100px;">
                    <table class="w-full">
                        <tr>
                            <td>TOTAL: </td>
                            <td class="text-right">1000.00</td>
                        </tr>
                    </table>
                </div>
            </td>
            <td style="vertical-align: top">
                <div class="border text-center text-bold" style="border-bottom: none; padding: 3px;">
                    NETO
                </div>
                <div class="border" style="min-height: 100px;">
                    <table class="w-full">
                        <tr>
                            <td>TOTAL: </td>
                            <td class="text-right">1000.00</td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </table>
</body>

</html>
