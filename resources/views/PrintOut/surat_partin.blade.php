<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            font-family: sans-serif;
        }

        table {
            border: 1pt solid black !important;
            border-collapse: collapse;
        }

        tr,
        td {
            border: 1pt solid black !important;
            height: 15pt;
            padding-left: 3px;

        }

        h1,
        h2,
        h3,
        h4,
        h5 {
            margin: 0px;
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

        @media print {
            table {
                width: 95% !important;
            }

            body {
                font-size: 8pt;
            }
        }
    </style>
</head>

<body>
    <table style="width: 80%;" align="center">
        <tr>
            <td style="width: 0.5%;" class="border-left border-top"></td>
            <td style="width: 0.5%;" class="border-left border-top"></td>
            <td style="width: 10%;" class="border-left border-top"></td>
            <td style="width: 26%;" class="border-left border-top"></td>
            <td style="width: 8%;" class="border-left border-top"></td>
            <td style="width: 7%;" class="border-left border-top"></td>
            <td style="width: 10%;" class="border-left border-top"></td>
            <td style="width: 10%;" class="border-left border-top"></td>
            <td style="width: 1%;" class="border-left border-top"></td>
            <td style="width: 6%;" class="border-left border-top"></td>
            <td style="width: 4%;" class="border-left border-top"></td>
            <td style="width: 15%;" class="border-left border-right border-top"></td>
        </tr>
        <tr>
            <td colspan="2" class="border-right" rowspan="2" class="center"><img src="../img/almaz.jpg" width="80"></td>
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
            <td colspan="5" style="height:30pt">SURAT TERIMA BARANG, DARI :</td>
            <td colspan="2" class="center border-right bold">NO :</td>
            <!-- <td colspan="5" class="bold">000984 . SJ . ADS . 12 . 21 . RAB</td> -->
            <td colspan="5" class="bold">{{sprintf('%04d', $data->no_part_in)." . STT . ADS . ". date("d", strtotime($data->created_at)) . " . " . date("m", strtotime($data->created_at))." . ".date("y", strtotime($data->created_at))." . ". $data->customer->code}}</td>
        </tr>
        <tr>
            <td colspan="6" class="border-bottom">
                <h2>{{$data->customer->name}}</h2>
            </td>
            <td class="border-right" colspan="2">TANGGAL</td>
            <td class="center border-right">:</td>
            <td colspan="3">{{$data->date_in}}</td>
        </tr>
        <tr>
            <td colspan="6" rowspan="2">{{$data->customer->address}}</td>
            <td class="border-right" colspan="2">NO. PO</td>
            <td class="center border-right">:</td>
            <td colspan="3">{{$data->order->no_po}}</td>
        </tr>
        <tr>
            <td class="border-right" colspan="2">NO SJ CUSTOMER</td>
            <td class="center border-right">:</td>
            <td colspan="3">{{$data->no_sj_cust}}</td>
        </tr>
        <tr>
            <td class="center">NO</td>
            <td colspan="2" class="center">KODE BARANG</td>
            <td colspan="2" class="center">NAMA BARANG</td>
            <td class="center">SATUAN</td>
            <td class="center">JUMLAH BARANG</td>
            <td class="center">JENIS KEMASAN</td>
            <td colspan="3" class="center">CEK RESULT</td>
            <td class="center">KETERANGAN</td>
        </tr>
        <tr>
            <td class="center">1</td>
            <td class="center" colspan="2">
                @if(isset($data->detailpartin[0]->parts->part_no))
                {{$data->detailpartin[0]->parts->part_no}}
                @endif
            </td>
            <td class="center" colspan="2">
                @if(isset($data->detailpartin[0]->parts->part_name))
                {{$data->detailpartin[0]->parts->part_name}}
                @endif
            </td>
            <td class="center"></td>
            <td class="center">
                @if(isset($data->detailpartin[0]->qty))
                {{$data->detailpartin[0]->qty}}
                @endif
            </td>
            <td class="center"></td>
            <td class="center" colspan="3"></td>
        </tr>
        <tr>
            <td class="center">2</td>
            <td class="center" colspan="2">
                @if(isset($data->detailpartin[1]->parts->part_no))
                {{$data->detailpartin[1]->parts->part_no}}
                @endif
            </td>
            <td class="center" colspan="2">
                @if(isset($data->detailpartin[1]->parts->part_name))
                {{$data->detailpartin[1]->parts->part_name}}
                @endif
            </td>
            <td class="center"></td>
            <td class="center">
                @if(isset($data->detailpartin[1]->qty))
                {{$data->detailpartin[1]->qty}}
                @endif
            </td>
            <td class="center"></td>
            <td class="center" colspan="3"></td>
        </tr>
        <tr>
            <td class="center">3</td>
            <td class="center" colspan="2">
                @if(isset($data->detailpartin[2]->parts->part_no))
                {{$data->detailpartin[2]->parts->part_no}}
                @endif
            </td>
            <td class="center" colspan="2">
                @if(isset($data->detailpartin[2]->parts->part_name))
                {{$data->detailpartin[2]->parts->part_name}}
                @endif
            </td>
            <td class="center"></td>
            <td class="center">
                @if(isset($data->detailpartin[2]->qty))
                {{$data->detailpartin[2]->qty}}
                @endif
            </td>
            <td class="center"></td>
            <td class="center" colspan="3"></td>
        </tr>
        <tr>
            <td class="center">4</td>
            <td class="center" colspan="2">
                @if(isset($data->detailpartin[3]->parts->part_no))
                {{$data->detailpartin[3]->parts->part_no}}
                @endif
            </td>
            <td class="center" colspan="2">
                @if(isset($data->detailpartin[3]->parts->part_name))
                {{$data->detailpartin[3]->parts->part_name}}
                @endif
            </td>
            <td class="center"></td>
            <td class="center">
                @if(isset($data->detailpartin[3]->qty))
                {{$data->detailpartin[3]->qty}}
                @endif
            </td>
            <td class="center"></td>
            <td class="center" colspan="3"></td>
        </tr>
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
            <td colspan="3" style="height: 50pt;"></td>
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
    //     window.print()
    // }, 1000);
    // window.onafterprint = function() {
    //     history.back();
    //     location.reload();
    // }
    setTimeout(function() {
        window.print();
    }, 500);
    window.onfocus = function() {
        setTimeout(function() {
            window.location = "{{ url('/partin') }}";
        }, 500);
    }
</script>

</html>