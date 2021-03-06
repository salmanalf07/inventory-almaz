<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TAX INVOICE</title>
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
        td,
        th {
            border: 1pt solid black !important;
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

        .no-border {
            border: hidden !important;
        }

        .center {
            text-align: center !important;
        }

        .bold {
            font-weight: bold !important;
        }

        @page {
            margin-top: 10px;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <table style="width: 100%;" align="center">
        <tr>
            <td class="no-border" style="width: 5%;"></td>
            <td class="no-border" style="width: 17%;"></td>
            <td class="no-border" style="width: 3%;"></td>
            <td class="no-border" style="width: 15%;"></td>
            <td class="no-border" style="width: 10%;"></td>
            <td class="no-border" style="width: 5%;"></td>
            <td class="no-border" style="width: 10%;"></td>
            <td class="no-border" style="width: 5%;"></td>
            <td class="no-border" style="width: 15%;"></td>
            <td class="no-border" style="width: 15%;"></td>
        </tr>
        <tr>
            <td colspan="10" class="no-border">
                <img src="./img/tt_invoice.jpg" width="400" alt="">
            </td>
        </tr>
        <tr>
            <td colspan="10" class="center no-border bold" style="font-size:20pt; padding-bottom:10px !important">
                TAX INVOICE
            </td>
        </tr>
        <tr>
            <td colspan="2" class="no-border">
                No. Invoice
            </td>
            <td class="no-border center">:</td>
            <td colspan="7" class="no-border">
                {{$data->no_invoice}}
            </td>
        </tr>
        <tr>
            <td colspan="2" class="no-border">
                No. PO
            </td>
            <td class="no-border center">:</td>
            <td colspan="7" class="no-border">
                <?php
                if ($data->order_id) {
                    echo $data->order['no_po'];
                }
                ?>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="no-border">
                Date
            </td>
            <td class="no-border center">:</td>
            <td colspan="7" class="no-border">
                {{date("d-M-Y",strtotime($date_cetak))}}
            </td>
        </tr>
        <tr>
            <td colspan="2" class="no-border">
                Delivery Date
            </td>
            <td class="no-border center">:</td>
            <td colspan="7" class="no-border">
                {{date("F Y",strtotime($date_cetak))}}
            </td>
        </tr>
        <tr>
            <td class="border-right border-left border-top"></td>
            <td colspan="4" class="no-border"></td>
            <td class="border-left border-right border-top"></td>
            <td colspan="4" class="border-bottom border-top border-right"></td>
        </tr>
        <tr>
            <td class="border-right border-bottom">To :</td>
            <td colspan="4" class="no-border">{{$data->customer->name}}</td>
            <td class="border-bottom border-left"></td>
            <td colspan="4" class="border-bottom border-top border-right"></td>
        </tr>
        <tr>
            <td class="no-border"></td>
            <td colspan="4" class="no-border">{{$data->customer->address}}</td>
            <td colspan="5" class="no-border"></td>
        </tr>
        <tr>
            <td class="border-right border-top"></td>
            <td colspan="4" class="no-border">NPWP : {{$data->customer->npwp}}</td>
            <td class="border-top border-left"></td>
            <td colspan="4" class="border-bottom border-top border-right"></td>
        </tr>
        <tr style="height: 28pt !important;">
            <td class="border-right border-left"></td>
            <td colspan="4" class="border-top border-left border-right"></td>
            <td class="border-right"></td>
            <td colspan="4" class="border-top border-right"></td>
        </tr>

        <tr>
            <th>No</th>
            <th>No Part</th>
            <th colspan="4">Nama Part</th>
            <th colspan="2">Jumlah</th>
            <th>Harga Satuan</th>
            <th>Harga Jual</th>
        </tr>
        <?php for ($i = 0; $i < count($data->detailinvoice); $i++) { ?>
            <tr class="center">
                <td>
                    @if(isset($data->detailinvoice[$i]->parts->part_no))
                    {{$i+1}}
                    @endif
                </td>
                <td style="white-space: nowrap !important; ">
                    @if(isset($data->detailinvoice[$i]->parts->part_no))
                    {{$data->detailinvoice[$i]->parts->part_no}}
                    @endif
                </td>
                <td colspan="4">
                    @if(isset($data->detailinvoice[$i]->parts->part_name))
                    {{$data->detailinvoice[$i]->parts->part_name}}
                    @endif
                </td>
                <td colspan="2">
                    @if(isset($data->detailinvoice[$i]->qty))
                    {{number_format($data->detailinvoice[$i]->qty,0,',','.')}}
                    Pcs
                    @endif
                </td>
                <td>
                    @if(isset($data->detailinvoice[$i]->parts->price))
                    @if($data->detailinvoice[$i]->total_price / $data->detailinvoice[$i]->qty == $data->detailinvoice[$i]->parts->price)
                    {{number_format($data->detailinvoice[$i]->parts->price,0,',','.')}}
                    @else
                    {{$data->detailinvoice[$i]->total_price / $data->detailinvoice[$i]->qty}}
                    @endif
                    @endif
                </td>
                <td>
                    @if(isset($data->detailinvoice[$i]->total_price))
                    {{number_format($data->detailinvoice[$i]->total_price,0,',','.')}}
                    @endif
                </td>
            </tr>
        <?php } ?>
        <tr>
            <td></td>
            <td></td>
            <td colspan="4"></td>
            <td colspan="2"></td>
            <td></td>
            <td></td>
        </tr>
        <tr class="bold">
            <td colspan="8" class="border-bottom border-left">
                KINDLY REMITTANCE PAYMENT TO :
            </td>
            <td class="center">Harga Jual</td>
            <td class="center">
                <?php
                $harga_jual = $data->harga_jual;
                echo number_format($harga_jual, 0, ',', '.');
                ?>
            </td>
        </tr>
        <tr class="bold">
            <td colspan="2" class="border-left border-bottom">
                Name
            </td>
            <td class="center border-left border-right border-bottom">:</td>
            <td colspan="5" class="border-bottom">
                PT. ALMAS DAYA SINERGI
            </td>
            <td class="center">PPN ({{$pajak->ppn}}%)</td>
            <td class="center">
                {{number_format($data->ppn, 0, ',', '.');}}
            </td>
        </tr>
        <tr class="bold border-left">
            <td colspan="2" class="border-left border-bottom">
                Bank Name
            </td>
            <td class="center border-left border-right border-bottom">:</td>
            <td colspan="5" class="border-bottom">
                MANDIRI
            </td>
            <td class="center">PPh 23 ({{$pajak->pph}}%)</td>
            <td class="center">
                {{number_format($data->pph, 0, ',', '.')}}
            </td>
        </tr>
        <tr class="bold">
            <td colspan="2" class="border-left border-bottom">
                Account No.
            </td>
            <td class="center border-left border-right border-bottom">:</td>
            <td colspan="5" class="border-left border-bottom">
                1560015615687
            </td>
            <td class="center">Total Harga Jual</td>
            <td class="center">
                <?php
                $total_harga = $harga_jual + $data->ppn - $data->pph;
                echo number_format($total_harga, 0, ',', '.');
                ?>
            </td>
        </tr>
        <tr>
            <td colspan="3" style="height: 110pt !important;" class="border-left border-right"></td>
            <td colspan="7" class="border-left border-right"></td>
        </tr>
        <tr>
            <td colspan="3" class="border-left border-bottom center">Authorised Signature</td>
            <td colspan="7" class="no-border"></td>
        </tr>
        <tr>
            <td colspan="10" style="height: 38pt !important;" class="border-left border-right"></td>
        </tr>
        <tr>
            <td colspan="10" class="border-left border-right center" style="font-size: 8pt;">Kantor Pusat : Jl. Raya Serang Setu Km 1,5 / No. 99 Sukadami, Cikarang Selatan, Bekasi 17530 ( Telp / Fax : 021 ??? 22180714)</td>
        </tr>
        <tr>
            <td colspan="10" class="no-border center" style="font-size: 8pt;">Kantor Cabang : Jl. Brigjend Katamso No.47, Muara Teweh 73811, Kalimantan Tengah</td>
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