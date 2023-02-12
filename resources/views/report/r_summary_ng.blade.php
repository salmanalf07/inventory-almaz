<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        table {
            border-collapse: collapse;
        }

        tr td {
            border: 1px solid black
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
    </style>
</head>

<body>
    <table>
        <thead>
            <tr>
                <td class="center bold" rowspan="2">
                    <h3>DATA</h3>
                </td>
                <td class="center bold" colspan="{{count($data)}}">TANGGAL</td>
                <td class="center bold" rowspan="2">
                    <h3>TOTAL</h3>
                </td>
            </tr>
            <tr>
                @foreach($data as $date)
                <td class="center">{{date("d",strtotime($date->date_transaction))}}</td>
                @endforeach
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Total</td>
                @foreach($data as $total)
                <td>{{$total->total}}</td>
                @endforeach
            </tr>
            <tr>
                <td>OK</td>
                @foreach($data as $ok)
                <td>{{$ok->total - $ok->NG}}</td>
                @endforeach
            </tr>
            <tr>
                <td>SA OK</td>
                @foreach($data as $SA)
                <td>0</td>
                @endforeach
            </tr>
            <tr>
                <td>NG</td>
                @foreach($data as $ng)
                <td>{{$ng->NG}}</td>
                @endforeach
            </tr>
            <tr>
                <td>TARGET</td>
                @foreach($data as $ng)
                <td>1%</td>
                @endforeach
            </tr>
            <tr>
                <td>%NG</td>
                @foreach($data as $ng)
                <td>{{round(($ng->NG / $ng->total),2)."%"}}</td>
                @endforeach
            </tr>
            <tr>
                <td style="height: 0.1%;" colspan="{{1 + count($data)}}"></td>
            </tr>
            <tr>
                <td>Over Paint</td>
                @foreach($data as $ng)
                @if($ng->over_paint == null)
                <td>0</td>
                @else
                <td>{{$ng->over_paint}}</td>
                @endif
                @endforeach
            </tr>
            <tr>
                <td>Bintik / Pin Hole</td>
                @foreach($data as $ng)
                @if($ng->bintik_or_pin_hole == null)
                <td>0</td>
                @else
                <td>{{$ng->bintik_or_pin_hole}}</td>
                @endif
                @endforeach
            </tr>
            <tr>
                <td>Minyak / Map</td>
                @foreach($data as $ng)
                @if($ng->minyak_or_map == null)
                <td>0</td>
                @else
                <td>{{$ng->minyak_or_map}}</td>
                @endif
                @endforeach
            </tr>
            <tr>
                <td>Cotton</td>
                @foreach($data as $ng)
                @if($ng->cotton == null)
                <td>0</td>
                @else
                <td>{{$ng->cotton}}</td>
                @endif
                @endforeach
            </tr>
            <tr>
                <td>No Paint / Tipis</td>
                @foreach($data as $ng)
                @if($ng->no_paint_or_tipis == null)
                <td>0</td>
                @else
                <td>{{$ng->no_paint_or_tipis}}</td>
                @endif
                @endforeach
            </tr>
            <tr>
                <td>Scratch</td>
                @foreach($data as $ng)
                @if($ng->scratch == null)
                <td>0</td>
                @else
                <td>{{$ng->scratch}}</td>
                @endif
                @endforeach
            </tr>
            <tr>
                <td>Air Pocket</td>
                @foreach($data as $ng)
                @if($ng->air_pocket == null)
                <td>0</td>
                @else
                <td>{{$ng->air_pocket}}</td>
                @endif
                @endforeach
            </tr>
            <tr>
                <td>Kulit Jeruk</td>
                @foreach($data as $ng)
                @if($ng->kulit_jeruk == null)
                <td>0</td>
                @else
                <td>{{$ng->kulit_jeruk}}</td>
                @endif
                @endforeach
            </tr>
            <tr>
                <td>Kasar</td>
                @foreach($data as $ng)
                @if($ng->kasar == null)
                <td>0</td>
                @else
                <td>{{$ng->kasar}}</td>
                @endif
                @endforeach
            </tr>
            <tr>
                <td>Karat</td>
                @foreach($data as $ng)
                @if($ng->karat == null)
                <td>0</td>
                @else
                <td>{{$ng->karat}}</td>
                @endif
                @endforeach
            </tr>
            <tr>
                <td>Water Over</td>
                @foreach($data as $ng)
                @if($ng->water_over == null)
                <td>0</td>
                @else
                <td>{{$ng->water_over}}</td>
                @endif
                @endforeach
            </tr>
            <tr>
                <td>Minyak Kering</td>
                @foreach($data as $ng)
                @if($ng->minyak_kering == null)
                <td>0</td>
                @else
                <td>{{$ng->minyak_kering}}</td>
                @endif
                @endforeach
            </tr>
            <tr>
                <td>Dented</td>
                @foreach($data as $ng)
                @if($ng->dented == null)
                <td>0</td>
                @else
                <td>{{$ng->dented}}</td>
                @endif
                @endforeach
            </tr>
            <tr>
                <td>Keropos</td>
                @foreach($data as $ng)
                @if($ng->keropos == null)
                <td>0</td>
                @else
                <td>{{$ng->keropos}}</td>
                @endif
                @endforeach
            </tr>
            <tr>
                <td>Nempel Jig</td>
                @foreach($data as $ng)
                @if($ng->nempel_jig == null)
                <td>0</td>
                @else
                <td>{{$ng->nempel_jig}}</td>
                @endif
                @endforeach
            </tr>
            <tr>
                <td>Lainnya</td>
                @foreach($data as $ng)
                @if($ng->lainnya == null)
                <td>0</td>
                @else
                <td>{{$ng->lainnya}}</td>
                @endif
                @endforeach
            </tr>
        </tbody>
    </table>
</body>

</html>