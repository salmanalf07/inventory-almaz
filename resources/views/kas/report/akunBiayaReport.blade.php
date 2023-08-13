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

        .text-end {
            text-align: right;
        }

        .color-gray {
            background-color: gray;
        }
    </style>
</head>

<body>
    <table>
        <thead>
            <tr>
                <th class="color-gray" style="width: 30%;">Biaya Umum dan Administrasi</th>
                @foreach($datdetail[0]['data'] as $data)
                <th class="color-gray">{{date('F', mktime(0, 0, 0, $data['bulan'], 1))}} {{$data['tahun']}}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach(collect($biayaUmum)->sortBy('noUrut') as $jenis)
            <?php $no = 0 ?>
            <tr>
                <td>{{$jenis->keterangan}}</td>
                @php
                $found = false; // Variabel bantu untuk menandai rekord yang cocok
                @endphp

                @foreach($datdetail as $dataa)
                @if($dataa['pengeluaran'] == $jenis->id)
                @php
                $found = true; // Set variabel bantu menjadi true jika ada rekord yang cocok
                @endphp

                @foreach($dataa['data'] as $dataaa)
                <td class="text-end sum{{$no}}">{{number_format($dataaa['total'],0,',','.')}}</td>
                <?php $no++ ?>
                @endforeach
                @endif
                @endforeach

                @if(!$found)
                @foreach($datdetail[0]['data'] as $data)
                <td class="text-end">0</td>
                @endforeach
                @endif
            </tr>
            @endforeach
            <tr>
                <td colspan="{{count($datdetail[0]['data']) + 1}}"></td>
            </tr>
            <tr>
                <th class="color-gray">Biaya Operasional dan Pemeliharaan</th>
                @foreach($datdetail[0]['data'] as $data)
                <th class="color-gray"></th>
                @endforeach
            </tr>
            @foreach(collect($biayaOpr)->sortBy('noUrut') as $jeniss)
            <?php $noo = 0 ?>
            <tr>
                <td>{{$jeniss->keterangan}}</td>
                @php
                $found = false; // Variabel bantu untuk menandai rekord yang cocok
                @endphp

                @foreach($datdetail as $dataa)
                @if($dataa['pengeluaran'] == $jeniss->id)
                @php
                $found = true; // Set variabel bantu menjadi true jika ada rekord yang cocok
                @endphp
                @foreach($dataa['data'] as $dataaa)
                <td class="text-end sum{{$noo}}">{{number_format($dataaa['total'],0,',','.')}}</td>
                <?php $noo++ ?>
                @endforeach
                @endif
                @endforeach

                @if(!$found)
                @foreach($datdetail[0]['data'] as $data)
                <td class="text-end">0</td>
                @endforeach
                @endif
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <?php $nooo = 0 ?>
            <tr>
                <th>
                    Total
                </th>
                @foreach($datdetail[0]['data'] as $data)
                <th class="text-end" id="total{{$nooo}}"></th>
                <?php $nooo++ ?>
                @endforeach
            </tr>
        </tfoot>

    </table>
    <script src="assets/css/jquery/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            for (let i = 0; i < "{{count($datdetail[0]['data'])}}"; i++) {
                var sum = 0;
                $(".sum" + i).each(function() {
                    sum += parseFloat($(this).text().replaceAll(".", ""));
                });
                console.log(sum);
                $('#total' + i).html((sum).toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));

            }

        })
    </script>
</body>

</html>