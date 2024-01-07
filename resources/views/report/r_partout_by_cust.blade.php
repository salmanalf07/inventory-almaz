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
                <td colspan="2">
                    <img src="./img/tt_invoice.jpg" width="300" alt="">
                </td>
                <td class="center bold" style="font-size:20pt" colspan="{{ count($datdetail[0]['uniqe']) + 4 }}">
                    SUMMARY PLAN INVOICE BY SURAT JALAN
                </td>
            </tr>
            <tr>
                <td colspan="2" class="bold border-right">PERIODE</td>
                <td colspan="{{ count($datdetail[0]['uniqe']) + 4 }}" class="bold">: {{$date}}</td>
            </tr>
            <tr>
                <td colspan="{{ count($datdetail[0]['uniqe']) + 6 }}"></td>
            </tr>
            <tr class="bold">
                <td class="center" rowspan="2">NO</td>
                <td class="center" rowspan="2">CUSTOMER</td>
                <td class="center" colspan="{{ count($datdetail[0]['uniqe']) }}">TANGGAL</td>
                <td class="center" rowspan="2">TOTAL SA</td>
                <td class="center" rowspan="2">TOTAL QTY</td>
                <td class="center" rowspan="2">GRAND TOTAL</td>
                <td class="center" rowspan="2">KETERANGAN</td>
            </tr>

            <tr>
                <?php foreach (collect($datdetail[0]['uniqe'])->sortBy($tanggal) as $att) { ?>
                    <td class="center bold">
                        @if ($tanggal == "month")
                        <?php echo date('M-Y', strtotime($att[$tanggal])); ?>
                        @else
                        <?php echo date('d', strtotime($att[$tanggal])); ?>
                        @endif
                    </td>
                <?php } ?>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;
            $ur = array();
            foreach ($datdetail as $datdetaill) { ?>
                <tr>
                    <td class="center">
                        {{$no++}}
                    </td>
                    <td>
                        <?php echo $datdetaill['cust_id']; ?>
                    </td>
                    <?php foreach (collect($datdetaill['uniqe'])->sortBy($tanggal) as $key => $sj) {
                        $ur[$key] = date('M-Y', strtotime($sj[$tanggal]));
                        if ($tanggal == "month") {
                            $ur[$key] = date('M-Y', strtotime($sj[$tanggal]));
                        } else {
                            $ur[$key] = date('d', strtotime($sj[$tanggal]));
                        }
                        if (isset($sj['real'])) { ?>
                            <td class="right qtysum sum{{$key}}">{{ number_format($sj['real'][0]['total'],0,",",",") }}</td>
                            <td style="display: none;" class="right sasum sadm{{$key}}">{{number_format((float)$sj['real'][0]['sadm'], 2, '.', '') }}</td>
                            <td style="display: none;" class="right sumqty qtydm{{$key}}">{{$sj['real'][0]['qty']}}</td>
                        <?php } else { ?>
                            <td class="right qtysum sum{{$key}}"></td>
                            <td style="display: none;" class="right sasum sadm{{$key}}"></td>
                            <td style="display: none;" class="right sumqty qtydm{{$key}}"></td>
                    <?php }
                    } ?>
                    <td class="right">
                        <div class="amountsa" id="satotal"></div>
                    </td>
                    <td class="right">
                        <div class="amountqty" id="totalqty"></div>
                    </td>
                    <td class="right">
                        <div class="amount" id="qtytotal"></div>
                    </td>
                    <td class="right price">
                    </td>
                </tr>
            <?php } ?>

            <tr>
                <td class="bold" style="text-align: right;padding-right:10px" colspan="2">TOTAL</td>
                <?php
                foreach (collect($datdetaill['uniqe'])->sortBy('date') as $keyy => $tot) { ?>
                    <td class="right bold">
                        <div id="totall{{$keyy}}"></div>
                    </td>
                <?php }
                ?>
                <td class="right bold">
                    <div id="grandsa"></div>
                </td>
                <td class="right bold">
                    <div id="grandqty"></div>
                </td>
                <td class="right bold">
                    <div id="total"></div>
                </td>
                <td class="border-right border-bottom"></td>
            </tr>

        </tbody>

    </table>
    </hr>
    <p id="time_stamp"></p>


    <script src="assets/css/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="assets/js/autonumeric/autoNumeric.min.js"></script>
    <script>
        $(document).ready(function() {
            $('tr').each(function() {
                var totmarks = 0;
                $(this).find('.qtysum').each(function() {
                    var marks = $(this).text().replaceAll(",", "");
                    if (marks.length !== 0) {
                        totmarks += parseFloat(marks);

                    }
                });
                $(this).find('#qtytotal').html(totmarks.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                var totmarkss = 0;
                $(this).find('.sasum').each(function() {
                    var markss = $(this).text();
                    if (markss.length !== 0) {
                        totmarkss += parseFloat(markss);

                    }
                });
                $(this).find('#satotal').html(totmarkss.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
                var totmarksss = 0;
                $(this).find('.sumqty').each(function() {
                    var marksss = $(this).text();
                    if (marksss.length !== 0) {
                        totmarksss += parseFloat(marksss);

                    }
                });
                $(this).find('#totalqty').html(totmarksss.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                //console.log(totmarks);

            });
            //total
            var sum = 0;
            $(".amount").each(function() {
                sum += parseFloat($(this).text().replace(/\D/g, ""));
            });

            var tamount = 0;
            $('.qtysum').each(function() {
                tamount += parseFloat($(this).text().replace(/\D/g, ""));
            });
            //console.log(tamount);
            $('#total').html((sum).toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));

            //total SA
            var sumSA = 0;
            $(".amountsa").each(function() {
                sumSA += parseFloat($(this).text().replaceAll(",", ""));
            });
            $('#grandsa').html((sumSA).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
            //total qty
            var sumqty = 0;
            $(".amountqty").each(function() {
                sumqty += parseFloat($(this).text().replace(/\D/g, ""));
            });
            //console.log(tamount);
            $('#grandqty').html((sumqty).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));



            var users = <?php echo json_encode($ur); ?>;
            Object.keys(users).forEach(function(k) {
                //console.log(k + ' - ' + users[k]);
                var totday = 0;
                $('.sum' + k).each(function() {
                    var markss = $(this).text().replaceAll(",", "");
                    if (markss.length !== 0) {
                        totday += parseFloat(markss);
                    }
                });
                $('#totall' + k).html((totday).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
            });

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