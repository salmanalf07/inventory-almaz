<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$judul}}</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100% !important;
            font-size: 8pt;
        }

        tr,
        td,
        th {
            border: 1pt solid black !important;
            height: 15pt;
            padding-left: 3px;

        }

        .text-left {
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .no-left {
            border-left: 0px !important;
        }

        .no-right {
            border-right: 0px !important;
        }

        .no-top {
            border-top: 0px !important;
        }

        .no-bottom {
            border-bottom: 0px !important;
        }

        .no-border {
            border: 0px !important;
        }

        @media print {
            .button {
                display: none;
            }
        }
    </style>
    <script src="https://unpkg.com/xlsx/dist/xlsx.full.min.js"></script>
</head>

<body>
    <button class="button" id="exportButton">Export to Excel</button>
    <table class="no-border" id="tableId">
        <thead>
            <tr class="no-border">
                <th class="no-border" colspan="8" rowspan="2"></th>
                <th class="text-left no-border">Bulan</th>
                <th class="no-border text-left" colspan="2">:</th>
                <th class="no-border text-left">Shift</th>
                <th class="no-border text-left" colspan="4">: 1 | 2 | 3</th>
            </tr>
            <tr class="no-border">
                <th class="text-left no-border">Tanggal</th>
                <th class="no-border text-left" colspan="2">:</th>
                <th class="no-border" colspan="4"></th>
            </tr>
            <tr>
                <th colspan="6">PT. ALMAS DAYA SINERGI</th>
                <th colspan="5" style="background-color: #e8d046;">PLANNING PRODUKSI</th>
                <th colspan="3" style="background-color: #2592f7;">PENCAPAIAN</th>
            </tr>
            <tr>
                <th style="width: 2%;">No</th>
                <th style="width: 7%;">Date</th>
                <th style="width: 5%;">Customer</th>
                <th style="width: 23%;">Part Name</th>
                <th style="width: 8%;">Type</th>
                <th style="width: 8%;">Qty</th>
                <th style="background-color: #e6d787;width: 6%;">Standard Qty / Hanger</th>
                <th style="background-color: #e6d787;width: 6%;">Plan Produksi (pcs)</th>
                <th style="background-color: #e6d787;width: 6%;">Pending (Pcs)</th>
                <th style="background-color: #e6d787;width: 6%;">Kebutuhan Hanger</th>
                <th style="background-color: #e6d787;width: 8%;">Keterangan</th>
                <th style="background-color: #6fb6f7;width: 6%;">Actual Produksi (pcs)</th>
                <th style="background-color: #6fb6f7;width: 6%;">Total Hanger</th>
                <th style="background-color: #6fb6f7;width: 8%;">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            ?>
            @foreach ($data as $partIn)
            <tr>
                <td class="text-center">{{$no}}</td>
                <td class="text-center">{{date("d-m-Y", strTotime($partIn->partIn->date_in))}}</td>
                <td class="text-center">{{$partIn->parts->customer->code}}</td>
                <td>{{$partIn->parts->name_local}}</td>
                <td>{{$partIn->type}}</td>
                <td class="text-right">{{number_format($partIn->qty, 0, ',', '.')}}</td>
                <td class="text-right">{{number_format($partIn->parts->qty_hanger, 0, ',', '.')}}</td>
                <td></td>
                <td></td>
                <td class="text-right">{{$partIn->parts->qty_hanger ? number_format(ceil($partIn->qty / $partIn->parts->qty_hanger), 0, ',', '.'):""}}</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <?php $no++ ?>
            @endforeach
        </tbody>
    </table>
    <script src="assets/css/jquery/jquery.min.js"></script>
    <script src="assets/js/exportExcel.js"></script>
</body>

</html>