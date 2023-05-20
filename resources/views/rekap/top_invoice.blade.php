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

        @media print {
            .headercolor {
                print-color-adjust: exact;
                -webkit-print-color-adjust: exact;
                background-color: #DDEBF7 !important;
            }
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
    <table class="table-responsive table-condensed table-striped table-hover table-bordered">
        <thead>

            <tr>
                <td colspan="3">
                    <img src="./img/tt_invoice.jpg" width="300" alt="">
                </td>
                <td class="center bold" style="font-size:20pt" colspan="{{ count($datdetail[0]['uniqe']) + 4 }}">
                    REKAP TOP INVOICE
                </td>
            </tr>
            <tr>
                <td colspan="2" class="bold border-right">PERIODE</td>
                <td colspan="{{ count($datdetail[0]['uniqe']) + 4 }}" class="bold">: {{$date}}</td>
            </tr>
            <tr class="bold headercolor" style="background-color: #DDEBF7">
                <td class="center" width="20" rowspan="2">NO</td>
                <td class="center" width="180" rowspan="2">NAMA CUSTOMER</td>
                <td class="center" colspan="{{ count($datdetail[0]['uniqe']) }}">TANGGAL</td>
                <td class="center" rowspan="2">GRAND TOTAL</td>
            </tr>

            <tr class="headercolor" style="background-color: #DDEBF7">
                <?php foreach ($datdetail[0]['uniqe'] as $att) { ?>
                    <td class="center bold">
                        <?php echo date('d-m-Y', strtotime($att['date'])); ?>
                    </td>
                <?php } ?>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;
            foreach ($datdetail as  $datdetaill) {
            ?>
                <tr>
                    <td class="center">
                        {{ $no++ }}
                    </td>
                    <td>
                        <?php echo $datdetaill['customer']; ?>
                    </td>
                    <?php foreach ($datdetaill['uniqe'] as $key => $sj) {
                        if (isset($sj['inv_real'])) { ?>
                            <td class="center qtysum sum{{$key}}">{{ number_format($sj['inv_real'][0]['total'],0,',',',')}}</td>
                        <?php } else { ?>
                            <td style="color:white" class="center qtysum sum{{$key}}">0</td>
                    <?php }
                    } ?>
                    <td class="right amount" id="qtytotal"></td>
                </tr>
            <?php } ?>

            <tr>
                <td class="bold" style="text-align: right;padding-right:10px" colspan="2">GRAND TOTAL</td>
                <?php foreach ($datdetaill['uniqe'] as $keyy => $sj) { ?>
                    <td class="center" id="total{{$keyy}}"></td>
                <?php } ?>
                <td class="bold">
                    <nav class="container">
                        <div>Rp</div>
                        <div id="total"></div>
                    </nav>
                </td>
            </tr>

        </tbody>

    </table>


    <script src="assets/css/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="assets/js/autonumeric/autoNumeric.min.js"></script>
    <script>
        $(document).ready(function() {
            $('tr').each(function() {
                var totmarks = 0;
                $(this).find('.qtysum').each(function() {
                    var marks = $(this).text().replace(/,/g, "");
                    if (marks.length !== 0) {
                        totmarks += parseFloat(marks);

                    }
                });
                var price = $(this).find('.price').text();
                $(this).find('#qtytotal').html(totmarks.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                $(this).find('#amount').html((price.replace(",", "") * totmarks).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));

            });
            //total
            var sum = 0;
            $(".amount").each(function() {
                sum += parseFloat($(this).text().replace(/,/g, ""));
            });
            $('#total').html((sum).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));

            for (let i = 0; i < "{{count($datdetaill['uniqe'])}}"; i++) {
                var sum = 0;
                $(".sum" + i).each(function() {
                    sum += parseFloat($(this).text().replace(/,/g, ""));
                });
                // console.log(sum);
                $('#total' + i).html((sum).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));

            }

        })
    </script>
</body>
@endif

</html>