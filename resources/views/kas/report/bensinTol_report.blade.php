<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        table {
            border: 1pt solid black !important;
            border-collapse: collapse;
            width: 100% !important;
            white-space: nowrap !important
        }

        tr,
        td,
        th {
            border: 1pt solid black !important;
            height: 15pt;
            padding-left: 3px;

        }

        .right {
            text-align: right;
        }

        .ungu {
            background-color: #B1A0C7;
        }

        .emas {
            background-color: #C4BD97
        }

        .putih {
            background-color: #F2F2F2
        }

        .kuning {
            background-color: #FFFF00
        }

        .button {
            margin-bottom: 1rem;
            color: #fff;
            background-color: #6c757d;
            cursor: pointer;
            box-shadow: none;
            display: inline-block;
            font-weight: 400;
            text-align: center;
            vertical-align: middle;
            user-select: none;
            border: 1px solid transparent;
            padding: .375rem .75rem;
            font-size: 1rem;
            line-height: 1.5;
            border-radius: .25rem;
            transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        }
    </style>
    <script src="https://unpkg.com/xlsx/dist/xlsx.full.min.js"></script>
</head>

<body>
    <button class="button" id="exportButton">Export to Excel</button>
    <table id="tableId">
        <thead>
            <tr class="ungu">
                <th colspan="10">Laporan Uang Bensin & Tol</th>
            </tr>
            <tr class="emas">
                <th>Tanggal</th>
                <th>Uraian</th>
                <th>Customer</th>
                <th>Driver</th>
                <th>No. POL</th>
                <th>Keterangan</th>
                <th>Debit</th>
                <th>Kredit</th>
                <th>Saldo</th>
                <th>Akun</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pettyCashEntries as $key => $entry)
            <tr class="putih">
                <td class="right">{{ date("d-M-Y H:i", strtotime($entry->date)) }}</td>
                <td>{{ $entry->uraian }}</td>
                <td>
                    @if ($entry->customers != null)
                    {{$entry->customers->code}}
                    @elseif ($entry->cust_id === "0")
                    OTHERS
                    @endif
                </td>
                <td>{{ $entry->drivers != null?$entry->drivers->name:"" }}</td>
                <td>{{ $entry->cars != null?$entry->cars->nopol:"" }}</td>
                <td>{{ $entry->keterangan }}</td>
                <td class="right sumDeb{{$key}}">{{ number_format($entry->debit,0,',',',') }}</td>
                <td class="right sumKred{{$key}}">{{ number_format($entry->kredit,0,',',',') }}</td>
                <td class="right">{{ number_format($saldoPerRecord[$entry->id],0,',',',') }}</td>
                <td>{{ $entry->jenisPengeluaran->keterangan }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="kuning">
                <th class="right" colspan="6">Total</th>
                <th class="right" id="totDeb"></th>
                <th class="right" id="totKred"></th>
                <th class="right" id="totSaldo"></th>
                <th></th>
            </tr>
        </tfoot>
    </table>
    <script src="assets/css/jquery/jquery.min.js"></script>
    <script src="assets/js/exportExcel.js"></script>
    <script>
        $(document).ready(function() {
            var totDeb = 0;
            var totKred = 0;

            for (let i = 0; i < "{{count($pettyCashEntries)}}"; i++) {
                $(".sumDeb" + i).each(function() {
                    totDeb += parseInt($(this).text().replace(/,/g, ''));
                });
                // console.log(totDeb);
                $('#totDeb').html((totDeb).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                //total Kredit
                $(".sumKred" + i).each(function() {
                    totKred += parseInt($(this).text().replace(/,/g, ''));
                });
                // console.log(totKred);
                $('#totKred').html((totKred).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
            }
            //total Saldo
            var totSaldo = parseInt($('#totDeb').text().replace(/,/g, '')) - parseInt($('#totKred').text().replace(/,/g, ''));
            $('#totSaldo').html((totSaldo).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","))
        })
    </script>

</body>

</html>