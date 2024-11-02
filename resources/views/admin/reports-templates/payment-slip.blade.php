<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boleta</title>
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
        width: 140px;
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
</style>

<body>

    <x-reports.payment-slip :payment="$payment" :periods="$periods"></x-reports.payment-slip>
</body>

</html>
