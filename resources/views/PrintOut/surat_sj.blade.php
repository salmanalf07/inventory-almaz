<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif !important;
            font-size: 10.5px !important;
            /* font-weight: bolder; */
            font-weight: 400;
        }

        /* .font {
            font-family: DejaVu Sans;
        } */

        .f8 {
            font-size: 10.5px !important;
        }

        .f10 {
            font-size: 12px !important;
        }

        .f12 {
            font-size: 12pt !important;
        }

        table {

            width: 100% !important;
            border: 1px solid black !important;
            border-collapse: collapse;
        }

        tr,
        td {
            border: 0.5px solid black !important;
            height: 14pt !important;
            padding-left: 3px !important;
            padding-right: 1px !important;
            padding-top: 0px !important;
            padding-bottom: 0px !important;

        }

        .h-50 {
            height: 50pt !important;
        }

        h1,
        h2,
        h3,
        h4,
        h5 {
            margin: 0px !important;
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

        .padding-no {
            padding: 0px;
        }

        .top-border {
            border-left: hidden !important;
            border-top: hidden !important;
            border-right: hidden !important;
        }

        .bold {
            font-weight: bold;
        }

        @page {
            /* margin-top: 0;
            margin-bottom: 0; */
            margin-left: 30px;
            margin-right: 30px;
            margin-top: 15px;
            margin-bottom: 0px;
        }

        @media print {
            table {
                width: 100% !important;
            }

            tr,
            td {
                border: 0.5px solid black !important;
                height: 15pt !important;
                padding-left: 3px !important;
                padding-right: 1px !important;
                padding-top: 0px !important;
                padding-bottom: 0px !important;

            }

            h1,
            h2,
            h3,
            h4,
            h5 {
                margin: 0px !important;
            }

            body {
                font-size: 8pt !important;
            }

            @page {
                margin-top: 10px;
                margin-bottom: 0;
                margin-right: 5px;
            }
        }
    </style>
</head>

<body>
    <table style="width: 100%;" align="center">
        <tr>
            <td style="width: 5%;" class="border-left border-top"></td>
            <td style="width: 5%;" class="border-left border-top"></td>
            <td style="width: 7%;" class="border-left border-top"></td>
            <td style="width: 26%;" class="border-left border-top"></td>
            <td style="width: 5%;" class="border-left border-top"></td>
            <td style="width: 7%;" class="border-left border-top"></td>
            <td style="width: 10%;" class="border-left border-top"></td>
            <td style="width: 15%;" class="border-left border-top"></td>
            <td style="width: 1%;" class="border-left border-top"></td>
            <td style="width: 6%;" class="border-left border-top"></td>
            <td style="width: 4%;" class="border-left border-top"></td>
            <td style="width: 13%;" class="border-left border-right border-top"></td>
        </tr>
        <tr>
            <td colspan="2" rowspan="2" class="center"><img src="./img/almaz.jpg" width="65"></td>
            <td colspan="4" class="border-left border-bottom">
                <h1>PT. ALMAS DAYA SINERGI</h1>
            </td>
            <td colspan="6" class="border-left border-bottom">Head Office:</td>
        </tr>
        <tr>
            <td colspan="4" class="border-left border-top">SPECIALIS METAL SURFACE TREATMENT</td>
            <td colspan="6" class="border-left border-top">Jl. Raya Serang Setu KM 1,5. No.99 Kel. Sukadami, Kec. Cikarang Selatan, Kab. Bekasi 17530</td>
        </tr>
        <tr>
            <td colspan="5">SURAT JALAN PENGIRIMAN BARANG, KEPADA ;</td>
            <td colspan="2" class="center border-right bold">NO :</td>
            <!-- <td colspan="5" class="bold">000984 . SJ . ADS . 12 . 21 . RAB</td> -->
            <td colspan="5" class="f10 bold">{{sprintf('%04d', $data->nosj)." . SJ . ADS . ". date("m", strtotime($data->created_at)) . " . " . date("y", strtotime($data->created_at))." . ". $data->customer->code}}</td>
        </tr>
        <tr>
            <td colspan="6" class="border-bottom">
                <h2>{{$data->customer->name}}</h2>
            </td>
            <td class="border-right">TANGGAL</td>
            <td class="f10" colspan="5">: {{$datee}}</td>
        </tr>
        <tr>
            <td colspan="6" rowspan="3">{{$data->customer->address}}</td>
            <td class="border-right">NO. PO</td>
            <td class="f10" colspan="5">
                : @if(isset($data->order->no_po))
                {{$data->order->no_po}}
                @endif
            </td>
        </tr>
        <tr>
            <td class="border-right">NO. POL</td>
            <td class="f10" colspan="5">: {{$data->car->nopol}}</td>
        </tr>
        <tr>
            <td class="border-right">DRIVER</td>
            <td class="f10" colspan="5">: {{$data->driver->name}}</td>
        </tr>
        <tr>
            <td class="center">NO</td>
            <td colspan="2" class="center">KODE BARANG</td>
            <td colspan="2" class="center">NAMA BARANG</td>
            <td class="center">SATUAN</td>
            <td class="center">JUMLAH BARANG</td>
            <td class="center">JENIS KEMASAN</td>
            <td colspan="3" class="center">JUMLAH KEMASAN</td>
            <td class="center">KETERANGAN</td>
        </tr>
        <?php for ($i = 0; $i < 10; $i++) { ?>
            <tr>
                <td class="center padding-no @if($i != 9)border-bottom @endif">
                    @if(isset($data->detailsj[$i]->part->part_no))
                    {{$i+1}}
                    @endif
                </td>
                <td class="center padding-no @if($i != 9)border-bottom @endif border-left" colspan="2">
                    @if(isset($data->detailsj[$i]->part->part_no))
                    {{$data->detailsj[$i]->part->part_no}}
                    @endif
                </td>
                <td class="center @if($i != 9)border-bottom @endif border-left" colspan="2">
                    @if(isset($data->detailsj[$i]->part->part_name))
                    {{$data->detailsj[$i]->part->part_name}}
                    @endif
                </td>
                <td class="center @if($i != 9)border-bottom @endif border-left">
                    @if(isset($data->detailsj[$i]->qty))
                    Pcs
                    @endif
                </td>
                <td class="center @if($i != 9)border-bottom @endif border-left" style="font-size: 12px !important;">
                    @if(isset($data->detailsj[$i]->qty))
                    {{$data->detailsj[$i]->qty}}
                    @endif
                </td>
                <td class="center @if($i != 9)border-bottom @endif border-left">
                    @if(isset($data->detailsj[$i]->type_pack))
                    {{$data->detailsj[$i]->type_pack}}
                    @endif
                </td>
                <td class="center @if($i != 9)border-bottom @endif border-left" colspan="3">
                    @if(isset($data->detailsj[$i]->qty_pack))
                    {{$data->detailsj[$i]->qty_pack}}
                    @endif
                </td>
                <td class="@if($i != 9)border-bottom @endif border-left">
                    @if(isset($data->detailsj[$i]->keterangan))
                    {{$data->detailsj[$i]->keterangan}}
                    @endif
                </td>
            </tr>

        <?php } ?>
        <tr>
            <td colspan="3" class="center">DIBUAT</td>
            <td class="center">DRIVER</td>
            <td colspan="3" class="center">SECURITY</td>
            <td colspan="3" class="center">DITERIMA</td>
            <td colspan="2" class="center">SECURITY</td>
        </tr>
        <tr>
            <td colspan="3" class="h-50"></td>
            <td></td>
            <td colspan="3"></td>
            <td colspan="3"></td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td colspan="12" style="font-weight: bold;">Keterangan: Putih/Asli= Tagihan, Merah = Tagihan, Kuning = Arsip, Hijau & Biru = Penerimaan (Customer), Putih/Copy = Security (Pengiriman)
            </td>
        </tr>
    </table>
</body>
<script>
    // setTimeout(function() {
    //     window.print();
    // }, 500);
    // window.onfocus = function() {
    //     setTimeout(function() {
    //         window.location = "{{ url('/sj') }}";
    //     }, 500);
    // }
</script>
<!-- <script type="text/javascript">
    try {
        this.print();
    } catch (e) {
        window.onload = window.print;
    }
</script> -->

</html>