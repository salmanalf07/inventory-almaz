<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        table {
            border: 1pt solid black !important;
            border-collapse: collapse;
            width: 100% !important;
            white-space: nowrap !important
        }

        tr,
        td {
            border: 1pt solid black !important;
            height: 15pt;
            padding-left: 3px;

        }

        .center {
            text-align: center;
        }

        .right {
            text-align: right;
        }

        .bold {
            font-weight: bold;
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

        .no-border {
            border: hidden !important;
        }

        @page {
            margin-top: 5px;
            margin-bottom: 0;
            margin-left: 0;
            margin-right: 0;
        }

        .container {
            display: flex;
            justify-content: space-between;
        }
    </style>
</head>

@if (count($datdetail) === 0)

<body>
    <style>
        body {
            background-color: #89a6fa;
        }

        .center {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
        }
    </style>
    <div class="center">
        <p style="font-size: 40pt;margin:0">Opsss...............</p>
        <p>Data Kosong</p>
    </div>
</body>
@else

<body>
    <?php
    function tanggal_indonesia($tanggal, $periode)
    {

        $bulan = array(
            1 =>       'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );

        $var = explode('-', $tanggal);

        if ($periode == "periode") {
            return $bulan[(int)$var[1]] . ' ' . $var[0];
        } else {
            return $var[2] . ' ' . $bulan[(int)$var[1]] . ' ' . $var[0];
        }
        // var 0 = tanggal
        // var 1 = bulan
        // var 2 = tahun
    }
    ?>
    <table id="tabtab" class="table-responsive table-condensed table-striped table-hover table-bordered">
        <thead>
            <tr>
                <td class="bold center">CUST</td>
                <td class="bold center">PO</td>
                <td class="bold center">POTENSI INV BY SJ</td>
                <td class="bold center">INVOICE TERCETAK</td>
                <td class="bold center">SUDAH REKAP</td>
                <td class="bold center">% INVOICE TERCETAK</td>
            </tr>
        </thead>
        <tbody>
            @foreach($datdetail as $data)
            <tr>
                <td>{{$data['code']}}</td>
                @if($data['PO']['no_po'] == null)
                <td>BLANK (NO PO)</td>
                @else
                <td>{{$data['PO']['no_po']}}</td>
                @endif
                <td class="right sum1">{{number_format($data['INV']['total']+$data['PO']['total'],0,".",".")}}</td>
                <td class="right sum2">{{number_format($data['INV']['total'],0,".",".")}}</td>
                <td class="right sum3">{{number_format($data['PO']['total'],0,".",".")}}</td>
                <td class="right sum4">{{number_format($data['PO']['total'] == 0 ? 0 : ($data['INV']['total']/($data['INV']['total']+$data['PO']['total']))*100,1) . " %"}}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2" class="bold right">TOTAL</td>
                <td class="bold right" id="total1"></td>
                <td class="bold right" id="total2"></td>
                <td class="bold right" id="total3"></td>
                <td class="bold right" id="total4"></td>
            </tr>
        </tfoot>

    </table>
    </hr>
    <p id="time_stamp"></p>


    <script src="assets/css/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="assets/js/autonumeric/autoNumeric.min.js"></script>
    <script>
        $(document).ready(function() {
            for (let i = 1; i <= 3; i++) {
                var totday = 0;
                $('.sum' + i).each(function() {
                    var markss = $(this).text().replaceAll(".", "");
                    if (markss.length !== 0) {
                        totday += parseFloat(markss);
                    }
                });
                $('#total' + i).html((totday).toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));

            }
            var total1 = parseFloat($('#total1').text().replaceAll(".", ""));
            var total2 = parseFloat($('#total2').text().replaceAll(".", ""));
            $('#total4').text(((total2 / total1) * 100).toFixed(2) + " %");
            // Creating a timestamp
            var timestamp = Date.now();
            // Converting it back to human-readable date and time
            var d = new Date(timestamp);
            //document.write(d);
            $('#time_stamp').html("Created_at : " + d);

        })
    </script>
</body>
@endif

</html>