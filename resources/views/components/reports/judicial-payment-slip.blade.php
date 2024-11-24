<div>
    <table class="w-full">
        <tr>
            <td class="corner"><img class="logo" src="{{ public_path('img/asuncion.jpg') }}" alt=""></td>
            <td class="text-bold text-center">
                <ul style="list-style-type: none; margin: 0px;">
                    <li class="text-lg">BOLETA DE ASIGNACIÓN JUDICIAL</li>
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
                        <td>: {{ $periods[$payment->period->mounth] }} {{ $payment->period->payroll->year }}<</td>
                    </tr>
                    <tr>
                        <td class="text-bold">RAZÓN</td>
                        <td>: {{ $judicial->name }}</td>
                    </tr>
                </table>
            </td>
            <td style="width: 200px">
                <table>
                    <tr>
                        <td class="text-bold">BOLETA</td>
                        <td>: PJ{{ $payment->period->payroll->year }}{{ sprintf("%02d", $payment->period->mounth) }}-{{ sprintf("%04d", $judicial->id) }}</td>
                    </tr>
                    <tr>
                        <td class="text-bold">CÓDIGO</td>
                        <td>: {{ $payment->contract->employee->identity_number }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <table class="w-full" style="table-layout: fixed;">
        <tr>
            <td style="vertical-align: top" colspan="3">
                <div class="border text-center text-bold" style="border-bottom: none; padding: 3px;">
                    DESCUENTO
                </div>
                <div class="border" style="min-height: 50px;">
                    <table class="w-full">
                        <tr>
                            <td>Descuento judicial: </td>
                            <td class="text-right">{{ $judicial->pivot->amount }}</td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td style="vertical-align: top">
                <div class="border">
                    <table class="w-full">
                        <tr>
                            <td>NETO: </td>
                            <td class="text-right" style="border-top: 1px solid; border-bottom: 4px double;">
                                {{ $judicial->pivot->amount }}</td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </table>
    <table class="w-full" style="margin-top: 100px">
        <tr>
            <td></td>
            <td style="vertical-align: top; width: 250px">
                <div class="text-center" style="border-top: 1px solid">
                    V° B° <br>
                </div>
            </td>
            <td></td>
            <td style="vertical-align: top; width: 250px">
                <div class="text-center" style="border-top: 1px solid">
                    Recibí conforme <br>
                    DNI: {{ $judicial->dni }}
                </div>
            </td>
            <td></td>
        </tr>
    </table>
</div>