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
    </style>
</head>

<body>
    <table class="table-responsive table-condensed table-striped table-hover table-bordered">
        <thead>
            <?php
            // foreach ($dat as $key => $value) {
            //     $obj[] = $value->nosj;
            // }
            $ar = array();
            $arr = array();
            $arrr = array();
            foreach ($data as $att) {
                $ar[] = $att->DetailSJ;
                $arr[] = $att->part;
                $arrr[] = $att;
                $unique_data = array_unique($ar);
                $unique_dataa = array_unique($arr);
                $unique_dataaa = array_unique($arrr);
            } ?>
            <tr>
                <td colspan="2" rowspan="2">
                    <img src="./img/tt_invoice.jpg" width="300" alt="">
                </td>
                <td class="center bold" style="font-size:20pt" colspan="{{count($unique_data)+5}}">
                    REKAP DELIVERY & TAGIHAN ED-COATING
                </td>
            </tr>
            <tr>
                <td class="center bold" style="font-size: 18pt;" colspan="{{count($unique_data)+5}}">{{$invoice->customer['name']}}</td>
            </tr>
            <tr>
                <td colspan="2" class="bold border-right">PERIODE</td>
                <td colspan="{{count($unique_data)+5}}" class="bold">: <?php
                                                                        echo date('F Y', strtotime($invoice->date_inv)); ?></td>
            </tr>
            <tr>
                <td colspan="2" class="bold border-right">NO PO</td>
                <td colspan="{{count($unique_data)+5}}" class="bold">: {{$invoice->order['no_po']}}</td>
            </tr>
            <tr>
                <td colspan="2" class="bold border-right">JASA PROSES</td>
                <td colspan="{{count($unique_data)+5}}" class="bold">: ED-COATING</td>
            </tr>
            <tr class="bold">
                <td class="center" rowspan="3">NO</td>
                <td class="center" rowspan="3">NAMA PART</td>
                <td class="center" rowspan="3">NO PART</td>
                <td class="center" colspan="{{count($unique_data)}}">SURAT JALAN</td>
                <td class="center" rowspan="3">TOTAL QTY</td>
                <td class="center" rowspan="3">PRICE</td>
                <td class="center" rowspan="3">TOTAL AMOUNT</td>
                <td class="center" rowspan="3">KETERANGAN</td>
            </tr>

            <tr>
                <?php foreach ($unique_data as $att) { ?>
                    <td class="center bold">
                        <?php echo date('d', strtotime($att->date_sj)); ?>
                    </td>
                <?php } ?>
            </tr>
            <tr>
                <?php foreach ($unique_data as $att) { ?>
                    <td class="center bold">
                        <?php echo $att->nosj; ?>
                    </td>
                <?php } ?>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;
            for ($c = 0; $c < count($datdetail); $c++) { ?>
                <tr>
                    <td class="center">
                        {{$c+1}}
                    </td>
                    <td>
                        <?php echo $datdetail[$c]['part_name']; ?>
                    </td>
                    <td class="center">
                        <?php echo $datdetail[$c]['part_no']; ?>
                    </td>
                    <?php for ($d = 0; $d < count($datdetail[$c]['uniqe']); $d++) {
                        if (isset($datdetail[$c]['uniqe'][$d]['sj_real'])) {
                    ?>
                            <td class="center qtysum">{{$datdetail[$c]['uniqe'][$d]['sj_real'][0]['qty']}}</td>
                        <?php } else {
                        ?>
                            <td class="center qtysum"></td>
                    <?php
                        }
                    } ?>
                    <td class="center" id="qtytotal"></td>
                    <td class="center price">
                        Rp <?php echo number_format($datdetail[$c]['price'], 0, ',', '.'); ?>
                    </td>
                    <td class="center" id="amount">
                    </td>
                    <td class="center">
                        Jasa Proses EDP
                    </td>
                </tr>
            <?php } ?>
            <tr>
                <td colspan="{{count($unique_data)+6}}"></td>
                <td class="border-right border-bottom" rowspan="5"></td>
            </tr>

            <tr>
                <td class="center bold" colspan="{{count($unique_data)+5}}">TOTAL</td>
                <td class="center bold">Rp {{number_format($invoice->harga_jual, 0, ',', '.')}}</td>
            </tr>
            <tr>
                <td class="center bold" colspan="{{count($unique_data)+5}}">PPN 10%</td>
                <td class="center bold">Rp {{number_format($invoice->ppn, 0, ',', '.')}}</td>
            </tr>
            <tr>
                <td class="center bold" colspan="{{count($unique_data)+5}}">PPH 23 2%</td>
                <td class="center bold">Rp {{number_format($invoice->pph, 0, ',', '.')}}</td>
            </tr>
            <tr>
                <td class="center bold" colspan="{{count($unique_data)+5}}">Grand Total</td>
                <td class="center bold">Rp {{number_format($invoice->total_harga, 0, ',', '.')}}</td>
            </tr>
            <tr>
                <td class="border-left border-right border-bottom" colspan="{{count($unique_data)+3}}" class=""></td>
                <td colspan="2" class=" border-right"></td>
                <td class="border-right"></td>
                <td class="border-right"></td>
            </tr>
            <tr class="center">
                <td class="border-left border-bottom" colspan="{{count($unique_data)+3}}" class=""></td>
                <td colspan="4">Bekasi, <?php echo date('d F Y', strtotime($invoice->date_inv)); ?></td>
            </tr>
            <tr class="center">
                <td class="border-left border-bottom" colspan="{{count($unique_data)+3}}" class=""></td>
                <td colspan="2">Dibuat</td>
                <td>Diperiksa</td>
                <td>Diketahui</td>
            </tr>
            <tr style="height:80px">
                <td class="border-left border-bottom" colspan="{{count($unique_data)+3}}"></td>
                <td colspan="2"></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="border-left border-bottom" colspan="{{count($unique_data)+3}}" class=""></td>
                <td colspan="2"></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="border-left border-bottom" colspan="{{count($unique_data)+3}}" class=""></td>
                <td colspan="2"></td>
                <td></td>
                <td></td>
            </tr>

        </tbody>

    </table>

    <!-- <td class="center qtysum"><?php //echo $att->qty; 
                                    ?></td> -->
    <?php //} else { 
    ?>
    <!-- <td>-</td> -->
    <?php //}
    // }
    //} 
    ?>

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
                $(this).find('#amount').html('Rp ' + (price.replace(/\D/g, "") * totmarks).toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
            });
        })
    </script>
</body>

</html>