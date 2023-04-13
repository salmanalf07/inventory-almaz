<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tanda Terima Invoice</title>
    <style>
        body {
            font-family: Calibri !important;
            font-size: 11pt !important;
        }

        table {
            width: 100% !important;
            border-collapse: collapse;
        }

        tr,
        td {
            /* border: 1pt solid black !important; */
            height: 15pt !important;
            padding-left: 3px !important;
            padding-right: 1px !important;
            padding-top: 0px !important;
            padding-bottom: 0px !important;

        }

        .border-bottom {
            border-bottom: hidden !important;
        }

        .border-top {
            border-top: hidden !important;
        }

        .border-right {
            border-right: hidden !important;
        }

        .border-left {
            border-left: hidden !important;
        }

        .center {
            text-align: center;
        }

        .bold {
            font-weight: bold;
        }

        @page {
            margin-top: 0;
            margin-bottom: 0;
        }
    </style>
</head>

<body>
    <?php
    $angka = round($data->total_harga, 2);
    $angka_format = number_format($angka, 2, '.', ',');
    if (strpos($angka_format, '.00') !== false) {
        $angka_format = number_format(floor($angka), 0, '.', ',');
    }
    ?>
    <table style="width: 100%;" align="center">
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="5">
                <img src="./img/tt_invoice.jpg" width="400" alt="">
            </td>
        </tr>
        <tr>
            <td colspan="5">
                <hr style="width: 100%;" size="3" color="black">
            </td>
        </tr>
        <tr>
            <td colspan="5" class="center bold" style="text-decoration: underline;padding-bottom:20px !important; font-size: 16pt !important;">
                OFFICIAL RECEIPT
            </td>
        </tr>
        <tr>
            <td colspan="2">
                Have Received Document from
            </td>
            <td>:</td>
            <td colspan="2">
                PT. ALMAS DAYA SINERGI
            </td>
        </tr>
        <tr>
            <td colspan="2">
                Regarding
            </td>
            <td>:</td>
            <td colspan="2">
                INVOICE NO. : {{$data->no_invoice}}
            </td>
        </tr>
        <tr>
            <td colspan="3" rowspan="2">
            </td>
            <td colspan="2">
                SJ TGL : {{date("F Y",strtotime($data->date_inv))}}
            </td>
        </tr>
        <tr>
            <td colspan="2">
                FAKTUR PAJAK NO.: {{$data->no_faktur}}
            </td>
        </tr>
        <tr>
            <td colspan="2">
                Amount
            </td>
            <td>:</td>
            <td colspan="2" class="bold">
                Rp. {{$angka_format}}
            </td>
        </tr>
        <tr>
            <td colspan="2">
                For
            </td>
            <td>:</td>
            <td colspan="2">
                {{$data->customer->name}}
            </td>
        </tr>
        <tr>
            <td colspan="2">
                Date
            </td>
            <td>:</td>
            <td colspan="2">
                {{date("d-M-Y",strtotime($data->date_inv))}}
            </td>
        </tr>
        <tr>
            <td colspan="5" style="height: 30pt !important;"></td>
        </tr>
        <tr>
            <td class="center">
                Sender,
            </td>
            <td colspan="3"></td>
            <td class="center">
                Receiver,
            </td>
        </tr>
        <tr>
            <td style="height: 50pt !important;" colspan="5"></td>
        </tr>
        <tr>
            <td class="center">
                PT. ALMAS DAYA SINERGI
            </td>
            <td colspan="3"></td>
            <td class="center">
                {{$data->customer->name}}
            </td>
        </tr>
    </table>
    <table style="width: 100%;" align="center">
        <tr>
            <td style="height: 30pt !important;"></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="5">
                <img src="./img/tt_invoice.jpg" width="400" alt="">
            </td>
        </tr>
        <tr>
            <td colspan="5">
                <hr style="width: 100%;" size="3" color="black">
            </td>
        </tr>
        <tr>
            <td colspan="5" class="center bold" style="text-decoration: underline;padding-bottom:20px !important; font-size: 16pt !important;">
                OFFICIAL RECEIPT
            </td>
        </tr>
        <tr>
            <td colspan="2">
                Have Received Document from
            </td>
            <td>:</td>
            <td colspan="2">
                PT. ALMAS DAYA SINERGI
            </td>
        </tr>
        <tr>
            <td colspan="2">
                Regarding
            </td>
            <td>:</td>
            <td colspan="2">
                INVOICE NO. : {{$data->no_invoice}}
            </td>
        </tr>
        <tr>
            <td colspan="3" rowspan="2">
            </td>
            <td colspan="2">
                SJ TGL : {{date("F Y",strtotime($data->date_inv))}}
            </td>
        </tr>
        <tr>
            <td colspan="2">
                FAKTUR PAJAK NO.: {{$data->no_faktur}}
            </td>
        </tr>
        <tr>
            <td colspan="2">
                Amount
            </td>
            <td>:</td>
            <td colspan="2" class="bold">
                Rp. {{$angka_format}}
            </td>
        </tr>
        <tr>
            <td colspan="2">
                For
            </td>
            <td>:</td>
            <td colspan="2">
                {{$data->customer->name}}
            </td>
        </tr>
        <tr>
            <td colspan="2">
                Date
            </td>
            <td>:</td>
            <td colspan="2">
                {{date("d-M-Y",strtotime($data->date_inv))}}
            </td>
        </tr>
        <tr>
            <td colspan="5" style="height: 30pt !important;"></td>
        </tr>
        <tr>
            <td class="center">
                Sender,
            </td>
            <td colspan="3"></td>
            <td class="center">
                Receiver,
            </td>
        </tr>
        <tr>
            <td style="height: 50pt !important;" colspan="5"></td>
        </tr>
        <tr>
            <td class="center">
                PT. ALMAS DAYA SINERGI
            </td>
            <td colspan="3"></td>
            <td class="center">
                {{$data->customer->name}}
            </td>
        </tr>
    </table>
</body>
<script>
    setTimeout(function() {
        window.print();
    }, 500);
    window.onfocus = function() {
        setTimeout(function() {
            window.close();
        }, 500);
    }
</script>

</html>