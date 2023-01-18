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
    <table class="table-responsive table-condensed table-striped table-hover table-bordered">
        <thead>

            <tr>
                <td colspan="2" rowspan="2">
                    <img src="./img/tt_invoice.jpg" width="300" alt="">
                </td>
                <td class="center bold" style="font-size:20pt" colspan="{{ count($datdetail[0]['uniqe']) + 5 }}">
                    REKAP DELIVERY & TAGIHAN ED-COATING
                </td>
            </tr>
            <tr>
                <td class="center bold" style="font-size: 18pt;" colspan="{{ count($datdetail[0]['uniqe']) + 5 }}">
                    {{ $dat[0]->customer['name'] }}
                </td>
            </tr>
            <tr>
                <td colspan="2" class="bold border-right">PERIODE</td>
                <td colspan="{{ count($datdetail[0]['uniqe']) + 5 }}" class="bold">: <?php echo strtoupper(tanggal_indonesia($datdetail[0]['uniqe'][0]['date_sj'], 'periode')); ?></td>
            </tr>
            <tr>
                <td colspan="2" class="bold border-right">NO PO</td>

                <td colspan="{{ count($datdetail[0]['uniqe']) + 5 }}" class="bold">: <?php if ($po != "#") {
                                                                                            echo $po->no_po;
                                                                                        } ?></td>
            </tr>
            <tr>
                <td colspan="2" class="bold border-right">JASA PROSES</td>
                <td colspan="{{ count($datdetail[0]['uniqe']) + 5 }}" class="bold">: ED-COATING</td>
            </tr>
            <tr class="bold headercolor" style="background-color: #DDEBF7">
                <td class="center" rowspan="3">NO</td>
                <td class="center" rowspan="3">NAMA PART</td>
                <td class="center" rowspan="3">NO PART</td>
                <td class="center" colspan="{{ count($datdetail[0]['uniqe']) }}">SURAT JALAN</td>
                <td class="center" rowspan="3">TOTAL QTY</td>
                <td class="center" rowspan="3">PRICE</td>
                <td class="center" rowspan="3">TOTAL AMOUNT</td>
                <td class="center" rowspan="3">KETERANGAN</td>
            </tr>

            <tr class="headercolor" style="background-color: #DDEBF7">
                <?php foreach (collect($datdetail[0]['uniqe'])->sortBy('nosj') as $att) { ?>
                    <td class="center bold">
                        <?php echo date('d', strtotime($att['date_sj'])); ?>
                    </td>
                <?php } ?>
            </tr>
            <tr class="headercolor" style="background-color: #DDEBF7">
                <?php foreach (collect($datdetail[0]['uniqe'])->sortBy('nosj') as $att) { ?>
                    <td class="center bold">
                        <?php echo $att['nosj']; ?>
                    </td>
                <?php } ?>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;
            for ($c = 0; $c < count($datdetail); $c++) { ?>
                <tr>
                    <td class="center">
                        {{ $c + 1 }}
                    </td>
                    <td>
                        <?php echo $datdetail[$c]['name_local']; ?>
                    </td>
                    <td class="center">
                        <?php echo $datdetail[$c]['part_no']; ?>
                    </td>
                    <?php foreach (collect($datdetail[$c]['uniqe'])->sortBy('nosj') as $sj) {
                        if (isset($sj['sj_real'])) { ?>
                            <td class="center qtysum">{{ $sj['sj_real'][0]['qty'] }}</td>
                        <?php } else { ?>
                            <td class="center qtysum"></td>
                    <?php }
                    } ?>
                    <td class="center" id="qtytotal"></td>
                    <td class="right price">
                        <nav class="container">
                            <div>Rp</div>
                            <div><?php echo number_format($datdetail[$c]['price'], 0, ',', '.'); ?></div>
                        </nav>
                    </td>
                    <td class="right amount">
                        <nav class="container">
                            <div>Rp</div>
                            <div id="amount"></div>
                        </nav>
                    </td>
                    <td class="center">
                        Jasa Proses EDP
                    </td>
                </tr>
            <?php } ?>

            <tr>
                <td class="bold" style="text-align: right;padding-right:10px" colspan="{{ count($datdetail[0]['uniqe']) + 5 }}">TOTAL</td>
                <td class="bold">
                    <nav class="container">
                        <div>Rp</div>
                        <div id="total"></div>
                    </nav>
                </td>
                <td class="border-right border-bottom" rowspan="4"></td>
            </tr>
            <tr>
                <td class="bold" style="text-align: right;padding-right:10px" colspan="{{ count($datdetail[0]['uniqe']) + 5 }}">PPN {{$pajak->ppn}}%</td>
                <td class="bold">
                    <nav class="container">
                        <div>Rp</div>
                        <div id="ppn"></div>
                    </nav>
                </td>
            </tr>
            <tr>
                <td class="bold" style="text-align: right;padding-right:10px" colspan="{{ count($datdetail[0]['uniqe']) + 5 }}">PPH 23 {{$pajak->pph}}%</td>
                <td class="bold">
                    <nav class="container">
                        <div>Rp</div>
                        <div id="pph"></div>
                    </nav>
                </td>
            </tr>
            <tr>
                <td class="bold" style="text-align: right;padding-right:10px" colspan="{{ count($datdetail[0]['uniqe']) + 5 }}">Grand Total</td>
                <td class="bold">
                    <nav class="container">
                        <div>Rp</div>
                        <div id="grand_total"></div>
                    </nav>
                </td>
            </tr>
            <tr>
                <td class="border-left border-right border-bottom" colspan="{{ count($datdetail[0]['uniqe']) + 3 }}" class=""></td>
                <td colspan="2" class=" border-right"></td>
                <td class="border-right"></td>
                <td class="border-right"></td>
            </tr>
            <tr class="center">
                <td class="border-left border-bottom" colspan="{{ count($datdetail[0]['uniqe']) + 3 }}" class="">
                </td>
                <?php
                $date_sj = array();

                foreach ($datdetail[0]['uniqe'] as $g => $f) {
                    // use the key $g in the $date_sj array
                    $date_sj[$g] = $f['date_sj'];
                }
                $maxdate = max($date_sj);
                $product_key = array_search($maxdate, $date_sj);
                // return $datdetail[0]['uniqe'][$product_key]['date_sj'];
                ?>
                <td colspan="4">Bekasi, <?php echo tanggal_indonesia($datdetail[0]['uniqe'][$product_key]['date_sj'], 'ttd'); ?></td>
            </tr>
            <tr class="center">
                <td class="border-left border-bottom" colspan="{{ count($datdetail[0]['uniqe']) + 3 }}" class="">
                </td>
                <td colspan="2">Dibuat</td>
                <td>Diperiksa</td>
                <td>Diketahui</td>
            </tr>
            <tr style="height:80px">
                <td class="border-left border-bottom" colspan="{{ count($datdetail[0]['uniqe']) + 3 }}"></td>
                <td colspan="2"></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="border-left border-bottom" colspan="{{ count($datdetail[0]['uniqe']) + 3 }}" class="">
                </td>
                <td colspan="2"></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="border-left border-bottom" colspan="{{ count($datdetail[0]['uniqe']) + 3 }}" class="">
                </td>
                <td colspan="2"></td>
                <td></td>
                <td></td>
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
                    var marks = $(this).text();
                    if (marks.length !== 0) {
                        totmarks += parseFloat(marks);

                    }
                });
                var price = $(this).find('.price').text();
                $(this).find('#qtytotal').html(totmarks.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
                $(this).find('#amount').html((price.replace(/\D/g, "") * totmarks).toString()
                    .replace(/\B(?=(\d{3})+(?!\d))/g, "."));

            });
            //total
            var sum = 0;
            $(".amount").each(function() {
                sum += parseFloat($(this).text().replace(/\D/g, ""));
            });
            $('#total').html((sum).toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
            //ppn
            var ppn = "{{ $dat[0]->customer['ppn'] }}";
            if (ppn === "Y") {
                var ppn_val = Math.round(sum * ('{{$pajak->ppn}}' / 100));
                $('#ppn').html((ppn_val).toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
            } else {
                var ppn_val = 0;
            }
            //pph
            var pph = "{{ $dat[0]->customer['pph'] }}";
            if (pph === "Y") {
                var pph_val = Math.round(sum * ('{{$pajak->pph}}' / 100));
                $('#pph').html((pph_val).toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
            } else {
                var pph_val = 0;
            }
            //grand total
            $('#grand_total').html((sum + ppn_val - pph_val).toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));

        })
    </script>
</body>
@endif

</html>