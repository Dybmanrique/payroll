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

    .table tfoot tr td{
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
            <tr class="row">
                <td class="cel cel-middle text-center text-bold">0001</td>
                <td class="cel cel-top">
                    <table class="details-table">
                        <tr>
                            <td class="text-bold">EMPLEADO</td>
                            <td>: MARISA NURINARDA RAMIREZ SAN BARTOLOME</td>
                        </tr>
                        <tr>
                            <td class="text-bold">DNI</td>
                            <td>: 72515227</td>
                        </tr>
                        <tr>
                            <td class="text-bold">CUENTA</td>
                            <td>: 65561651561</td>
                        </tr>
                        <tr>
                            <td class="text-nowrap text-bold">SIS. PENSIÓN</td>
                            <td>: AFP (INTEGRA)</td>
                        </tr>
                        <tr>
                            <td class="text-bold">RUC</td>
                            <td>: 20725152270</td>
                        </tr>
                        <tr>
                            <td class="text-bold">DÍAS</td>
                            <td>: 30</td>
                        </tr>
                        <tr>
                            <td class="text-bold">CARGO</td>
                            <td>: ESPECIALISTA DE INVESTIGACIÓN EN PERSONAL DE VIGILANCIA</td>
                        </tr>
                    </table>
                </td>
                <td class="cel cel-top">
                    <table>
                        <tr>
                            <td class="text-bold">BÁSICO</td>
                            <td>: 1000.00</td>
                        </tr>
                        <tr>
                            <td class="text-bold">AGUINALDO</td>
                            <td>: 1000.00</td>
                        </tr>
                        <tr>
                            <td class="text-bold">REINTEGRO</td>
                            <td>: 1000.00</td>
                        </tr>
                        <tr>
                            <td class="text-bold">TOTAL</td>
                            <td>: 1000.00</td>
                        </tr>
                    </table>
                </td>
                <td class="cel cel-top">
                    <table>
                        <tr>
                            <td class="text-bold">ONP</td>
                            <td>: 1000.00</td>
                        </tr>
                        <tr>
                            <td class="text-bold">AFP-JUB</td>
                            <td>: 1000.00</td>
                        </tr>
                        <tr>
                            <td class="text-bold">AFP-C-V</td>
                            <td>: 1000.00</td>
                        </tr>
                        <tr>
                            <td class="text-bold">AFP-INVA</td>
                            <td>: 1000.00</td>
                        </tr>
                        <tr>
                            <td class="text-bold">D. JUDICIAL</td>
                            <td>: 1000.00</td>
                        </tr>
                        <tr>
                            <td class="text-bold">TOTAL</td>
                            <td>: 1000.00</td>
                        </tr>
                    </table>
                </td>
                <td class="cel cel-top">
                    <table>
                        <tr>
                            <td class="text-bold">ESSALUD</td>
                            <td>: 1000.00</td>
                        </tr>
                    </table>
                </td>
                <td class="cel cel-top">
                    <table>
                        <tr>
                            <td class="text-bold">TOTAL</td>
                            <td>: 1000.00</td>
                        </tr>
                    </table>
                </td>
                <td class="cel cel-top"></td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td class="cel cel-middle text-center text-bold" colspan="2">TOTAL</td>
                <td class="cel cel-top">
                    <table>
                        <tr>
                            <td class="text-bold">BÁSICO</td>
                            <td>: 1000000.00</td>
                        </tr>
                        <tr>
                            <td class="text-bold">AGUINALDO</td>
                            <td>: 100000.00</td>
                        </tr>
                        <tr>
                            <td class="text-bold">REINTEGRO</td>
                            <td>: 1000.00</td>
                        </tr>
                        <tr>
                            <td class="text-bold">TOTAL</td>
                            <td>: 1000.00</td>
                        </tr>
                    </table>
                </td>
                <td class="cel cel-top">
                    <table>
                        <tr>
                            <td class="text-bold">ONP</td>
                            <td>: 1000.00</td>
                        </tr>
                        <tr>
                            <td class="text-bold">AFP-JUB</td>
                            <td>: 1000.00</td>
                        </tr>
                        <tr>
                            <td class="text-bold">AFP-C-V</td>
                            <td>: 1000.00</td>
                        </tr>
                        <tr>
                            <td class="text-bold">AFP-INVA</td>
                            <td>: 1000.00</td>
                        </tr>
                        <tr>
                            <td class="text-bold">D. JUDICIAL</td>
                            <td>: 1000000.00</td>
                        </tr>
                        <tr>
                            <td class="text-bold">TOTAL</td>
                            <td>: 1000.00</td>
                        </tr>
                    </table>
                </td>
                <td class="cel cel-top">
                    <table>
                        <tr>
                            <td class="text-bold">ESSALUD</td>
                            <td>: 1000000.00</td>
                        </tr>
                    </table>
                </td>
                <td class="cel cel-top">
                    <table>
                        <tr>
                            <td class="text-bold">TOTAL</td>
                            <td>: 1000000.00</td>
                        </tr>
                    </table>
                </td>
                <td class="cel cel-top"></td>
            </tr>
        </tfoot>
    </table>

</body>

</html>
