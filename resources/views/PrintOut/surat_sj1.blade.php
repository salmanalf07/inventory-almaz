<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            font-family: Arial;
        }

        table {
            border: 1pt solid black !important;
            border-collapse: collapse;
        }

        tr,
        td {
            border: 1pt solid black !important;
            height: 15pt !important;
            padding-left: 3px !important;
            padding-right: 1px !important;
            padding-top: 1px !important;
            padding-bottom: 1px !important;

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
            font-family: Arial;
        }

        @media print {

            table {
                width: 100% !important;
            }

            tr,
            td {
                border: 1pt solid black !important;
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
                font-family: Arial;
            }

            @page {
                margin: 0;
                /* margin-top: 0;
                margin-bottom: 0; */
            }
        }
    </style>
</head>

<body>
    <table style="width: 80%;" align="center">
        <tr>
            <td style="width: 0.5%;" class="border-left border-top"></td>
            <td style="width: 0.5%;" class="border-left border-top"></td>
            <td style="width: 7%;" class="border-left border-top"></td>
            <td style="width: 23%;" class="border-left border-top"></td>
            <td style="width: 8%;" class="border-left border-top"></td>
            <td style="width: 7%;" class="border-left border-top"></td>
            <td style="width: 13%;" class="border-left border-top"></td>
            <td style="width: 13%;" class="border-left border-top"></td>
            <td style="width: 1%;" class="border-left border-top"></td>
            <td style="width: 6%;" class="border-left border-top"></td>
            <td style="width: 4%;" class="border-left border-top"></td>
            <td style="width: 15%;" class="border-left border-right border-top"></td>
        </tr>
        <tr>
            <td colspan="2" class="border-right" rowspan="2" class="center"><img src="./img/almaz.png" width="80"></td>
            <td colspan="4" class="border-left border-bottom">
                <h1>PT. ALMAS DAYA SINERGI</h1>
            </td>
            <td colspan="6" class="border-bottom">Head Office:</td>
        </tr>
        <tr>
            <td colspan="4" class="border-top">SPECIALIS METAL SURFACE TREATMENT</td>
            <td colspan="6" class="border-top">Jl. Raya Serang Setu KM 1,5. No.99 Kel. Sukadami, Kec. Cikarang Selatan, Kab. Bekasi 17530</td>
        </tr>
        <tr>
            <td colspan="5" style="height:30pt">SURAT JALAN PENGIRIMAN BARANG, KEPADA ;</td>
            <td colspan="2" class="center border-right bold">NO :</td>
            <!-- <td colspan="5" class="bold">000984 . SJ . ADS . 12 . 21 . RAB</td> -->
            <td colspan="5" class="bold">{{sprintf('%04d', $data->nosj)." . SJ . ADS . ". date("m", strtotime($data->created_at)) . " . " . date("d", strtotime($data->created_at))." . ". $data->customer->code}}</td>
        </tr>
        <tr>
            <td colspan="6" class="border-bottom">
                <h2>{{$data->customer->name}}</h2>
            </td>
            <td class="border-right" colspan="2">TANGGAL</td>
            <td class="center border-right">:</td>
            <td colspan="3">{{$datee}}</td>
        </tr>
        <tr>
            <td colspan="6" rowspan="3">{{$data->customer->address}}</td>
            <td class="border-right" colspan="2">NO. PO</td>
            <td class="center border-right">:</td>
            <td colspan="3">
                @if(isset($data->order->no_po))
                {{$data->order->no_po}}
                @endif
            </td>
        </tr>
        <tr>
            <td class="border-right" colspan="2">NO. POL / JENIS KENDARAAN</td>
            <td class="center border-right">:</td>
            <td colspan="3">{{$data->car->nopol}}</td>
        </tr>
        <tr>
            <td class="border-right" colspan="2">NAMA PENGIRIM / DRIVER</td>
            <td class="center border-right">:</td>
            <td colspan="3">{{$data->driver->name}}</td>
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
                <td class="center padding-no @if($i != 9)border-bottom @endif">{{$i+1}}</td>
                <td class="center padding-no @if($i != 9)border-bottom @endif" colspan="2">
                    @if(isset($data->detailsj[$i]->part->part_no))
                    {{$data->detailsj[$i]->part->part_no}}
                    @endif
                </td>
                <td class="center @if($i != 9)border-bottom @endif" colspan="2">
                    @if(isset($data->detailsj[$i]->part->part_name))
                    {{$data->detailsj[$i]->part->part_name}}
                    @endif
                </td>
                <td class="center @if($i != 9)border-bottom @endif">
                    @if(isset($data->detailsj[$i]->qty))
                    Pcs
                    @endif
                </td>
                <td class="center @if($i != 9)border-bottom @endif">
                    @if(isset($data->detailsj[$i]->qty))
                    {{$data->detailsj[$i]->qty}}
                    @endif
                </td>
                <td class="center @if($i != 9)border-bottom @endif">
                    @if(isset($data->detailsj[$i]->type_pack))
                    {{$data->detailsj[$i]->type_pack}}
                    @endif
                </td>
                <td class="center @if($i != 9)border-bottom @endif" colspan="3">
                    @if(isset($data->detailsj[$i]->qty_pack))
                    {{$data->detailsj[$i]->qty_pack}}
                    @endif
                </td>
                <td class="@if($i != 9)border-bottom @endif"></td>
            </tr>

        <?php } ?>
        <tr>
            <td colspan="12" style="padding:0px"></td>
        </tr>
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
            <td colspan="12">Keterangan : Putih/Asli = Tagihan, Merah = Tagihan, Kuning = Arsip, Hijau & Biru = Penerimaan (Customer), Putih/Copy = Security (Pengiriman)
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

</html>