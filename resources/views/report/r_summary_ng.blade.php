<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        .chart-container {
            position: relative;
            height: 40vh;
            width: 100%;
            border: 1px solid black;
            margin-top: 3vh;
            margin-bottom: 3vh;
        }

        table {
            border-collapse: collapse;
            width: 100%;
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

        .red {
            color: red;
        }
    </style>
</head>
@if ($record === 0)

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
    <div class="chart-container">
        <canvas id="myChart1"></canvas>
    </div>
    <table>
        <thead>
            <tr>
                <td width="150" class="center bold" rowspan="2">
                    <h3>DATA</h3>
                </td>
                <td class="center bold" colspan="{{count($data)}}">TANGGAL</td>
                <td width="150" class="center bold" rowspan="2">
                    <h3>TOTAL</h3>
                </td>
            </tr>
            <tr>
                @foreach($data as $date)
                <td class="center date-packing bold" data-date="{{date('d',strtotime($date['date_packing']))}}" width="50">{{date("d",strtotime($date['date_packing']))}}</td>
                @endforeach
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>TOTAL</td>
                @foreach($data as $key => $total)
                <td class="right qtysum sum{{$key}}">{{number_format($total['total_fg'] + $total['total_ng'],0,".",".")}}</td>
                @endforeach
                <td>
                    <div class="right amount total_fg" id="qtytotal"></div>
                </td>
            </tr>
            <tr>
                <td>OK</td>
                @foreach($data as $key => $ok)
                <td class="right okcolect qtysum sum{{$key}}">{{number_format($ok['total_fg'],0,".",".")}}</td>
                @endforeach
                <td>
                    <div class="right amount" id="qtytotal"></div>
                </td>
            </tr>
            <tr>
                <td>SA OK</td>
                @foreach($data as $key => $SA)
                <td class="right qtysum sum{{$key}}">0</td>
                @endforeach
                <td>
                    <div class="right amount" id="qtytotal"></div>
                </td>
            </tr>
            <tr>
                <td>NG</td>
                @foreach($data as $key => $ng)
                <td class="right ngcolect qtysum sum{{$key}}" id="ng">{{$ng['total_ng']}}</td>
                @endforeach
                <td>
                    <div class="right amount total_ng" id="qtytotal"></div>
                </td>
            </tr>
            <tr>
                <td>TARGET</td>
                @foreach($data as $key => $ng)
                <td class="right qtysum sum{{$key}}">2%</td>
                @endforeach
                <td>
                    <div class="right">2%</div>
                </td>
            </tr>
            <tr>
                <td>persenNG</td>
                @foreach($data as $key => $ng)
                @if($ng['total_fg'] != 0)
                <td class="right nggcolect amountt">{{round(($ng['total_ng'] / ($ng['total_fg'] + $ng['total_ng']))*100,2)."%"}}</td>
                @else
                <td class="right nggcolect amountt">0%</td>
                @endif
                @endforeach
                <td class="right">
                    <div id="persenNg"></div>
                </td>
            </tr>
            <tr>
                <td style="height: 0.1%;" colspan="{{2 + count($data)}}"></td>
            </tr>
            <tr>
                <td>Over Paint</td>
                @foreach($data as $key => $ng)
                @if($ng['over_paint'] == null)
                <td class="right qtysum sum{{$key}}">0</td>
                @else
                <td class="red right qtysum sum{{$key}}">{{$ng['over_paint']}}</td>
                @endif
                @endforeach
                <td>
                    <div data-ng="Over Paint" class="right ngsum" id="qtytotal"></div>
                </td>
            </tr>
            <tr>
                <td>Bintik / Pin Hole</td>
                @foreach($data as $key => $ng)
                @if($ng['bintik_or_pin_hole'] == null)
                <td class="right qtysum sum{{$key}}">0</td>
                @else
                <td class="red right qtysum sum{{$key}}">{{$ng['bintik_or_pin_hole']}}</td>
                @endif
                @endforeach
                <td>
                    <div data-ng="Bintik / Pin Hole" class="right ngsum" id="qtytotal"></div>
                </td>
            </tr>
            <tr>
                <td>Minyak / Map</td>
                @foreach($data as $key => $ng)
                @if($ng['minyak_or_map'] == null)
                <td class="right qtysum sum{{$key}}">0</td>
                @else
                <td class="red right qtysum sum{{$key}}">{{$ng['minyak_or_map']}}</td>
                @endif
                @endforeach
                <td>
                    <div data-ng="Minyak / Map" class="right ngsum" id="qtytotal"></div>
                </td>
            </tr>
            <tr>
                <td>Cotton</td>
                @foreach($data as $key => $ng)
                @if($ng['cotton'] == null)
                <td class="right qtysum sum{{$key}}">0</td>
                @else
                <td class="red right qtysum sum{{$key}}">{{$ng['cotton']}}</td>
                @endif
                @endforeach
                <td>
                    <div data-ng="Cotton" class="right ngsum" id="qtytotal"></div>
                </td>
            </tr>
            <tr>
                <td>No Paint / Tipis</td>
                @foreach($data as $key => $ng)
                @if($ng['no_paint_or_tipis'] == null)
                <td class="right qtysum sum{{$key}}">0</td>
                @else
                <td class="red right qtysum sum{{$key}}">{{$ng['no_paint_or_tipis']}}</td>
                @endif
                @endforeach
                <td>
                    <div data-ng="No Paint / Tipis" class="right ngsum" id="qtytotal"></div>
                </td>
            </tr>
            <tr>
                <td>Scratch</td>
                @foreach($data as $key => $ng)
                @if($ng['scratch'] == null)
                <td class="right qtysum sum{{$key}}">0</td>
                @else
                <td class="red right qtysum sum{{$key}}">{{$ng['scratch']}}</td>
                @endif
                @endforeach
                <td>
                    <div data-ng="Scratch" class="right ngsum" id="qtytotal"></div>
                </td>
            </tr>
            <tr>
                <td>Air Pocket</td>
                @foreach($data as $key => $ng)
                @if($ng['air_pocket'] == null)
                <td class="right qtysum sum{{$key}}">0</td>
                @else
                <td class="red right qtysum sum{{$key}}">{{$ng['air_pocket']}}</td>
                @endif
                @endforeach
                <td>
                    <div data-ng="Air Pocket" class="right ngsum" id="qtytotal"></div>
                </td>
            </tr>
            <tr>
                <td>Kulit Jeruk</td>
                @foreach($data as $key => $ng)
                @if($ng['kulit_jeruk'] == null)
                <td class="right qtysum sum{{$key}}">0</td>
                @else
                <td class="red right qtysum sum{{$key}}">{{$ng['kulit_jeruk']}}</td>
                @endif
                @endforeach
                <td>
                    <div data-ng="Kulit Jeruk" class="right ngsum" id="qtytotal"></div>
                </td>
            </tr>
            <tr>
                <td>Kasar</td>
                @foreach($data as $key => $ng)
                @if($ng['kasar'] == null)
                <td class="right qtysum sum{{$key}}">0</td>
                @else
                <td class="red right qtysum sum{{$key}}">{{$ng['kasar']}}</td>
                @endif
                @endforeach
                <td>
                    <div data-ng="Kasar" class="right ngsum" id="qtytotal"></div>
                </td>
            </tr>
            <tr>
                <td>Karat</td>
                @foreach($data as $key => $ng)
                @if($ng['karat'] == null)
                <td class="right qtysum sum{{$key}}">0</td>
                @else
                <td class="red right qtysum sum{{$key}}">{{$ng['karat']}}</td>
                @endif
                @endforeach
                <td>
                    <div data-ng="Karat" class="right ngsum" id="qtytotal"></div>
                </td>
            </tr>
            <tr>
                <td>Water Over</td>
                @foreach($data as $key => $ng)
                @if($ng['water_over'] == null)
                <td class="right qtysum sum{{$key}}">0</td>
                @else
                <td class="red right qtysum sum{{$key}}">{{$ng['water_over']}}</td>
                @endif
                @endforeach
                <td>
                    <div data-ng="Water Over" class="right ngsum" id="qtytotal"></div>
                </td>
            </tr>
            <tr>
                <td>Minyak Kering</td>
                @foreach($data as $key => $ng)
                @if($ng['minyak_kering'] == null)
                <td class="right qtysum sum{{$key}}">0</td>
                @else
                <td class="red right qtysum sum{{$key}}">{{$ng['minyak_kering']}}</td>
                @endif
                @endforeach
                <td>
                    <div data-ng="Minyak Kering" class="right ngsum" id="qtytotal"></div>
                </td>
            </tr>
            <tr>
                <td>Dented</td>
                @foreach($data as $key => $ng)
                @if($ng['dented'] == null)
                <td class="right qtysum sum{{$key}}">0</td>
                @else
                <td class="red right qtysum sum{{$key}}">{{$ng['dented']}}</td>
                @endif
                @endforeach
                <td>
                    <div data-ng="Dented" class="right ngsum" id="qtytotal"></div>
                </td>
            </tr>
            <tr>
                <td>Keropos</td>
                @foreach($data as $key => $ng)
                @if($ng['keropos'] == null)
                <td class="right qtysum sum{{$key}}">0</td>
                @else
                <td class="red right qtysum sum{{$key}}">{{$ng['keropos']}}</td>
                @endif
                @endforeach
                <td>
                    <div data-ng="Keropos" class="right ngsum" id="qtytotal"></div>
                </td>
            </tr>
            <tr>
                <td>Nempel Jig</td>
                @foreach($data as $key => $ng)
                @if($ng['nempel_jig'] == null)
                <td class="right qtysum sum{{$key}}">0</td>
                @else
                <td class="red right qtysum sum{{$key}}">{{$ng['nempel_jig']}}</td>
                @endif
                @endforeach
                <td>
                    <div data-ng="Nempel Jig" class="right ngsum" id="qtytotal"></div>
                </td>
            </tr>
            <tr>
                <td>Lainnya</td>
                @foreach($data as $key => $ng)
                @if($ng['lainnya'] == null)
                <td class="right qtysum sum{{$key}}">0</td>
                @else
                <td class="red right qtysum sum{{$key}}">{{$ng['lainnya']}}</td>
                @endif
                @endforeach
                <td>
                    <div data-ng="Lainnya" class="right ngsum" id="qtytotal"></div>
                </td>
            </tr>
        </tbody>
    </table>
    <div class="chart-container">
        <canvas id="myChart"></canvas>
    </div>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js/dist/chart.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/2.2.0/chartjs-plugin-datalabels.min.js" integrity="sha512-JPcRR8yFa8mmCsfrw4TNte1ZvF1e3+1SdGMslZvmrzDYxS69J7J49vkFL8u6u8PlPJK+H3voElBtUCzaXj+6ig==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="assets/css/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="assets/js/autonumeric/autoNumeric.min.js"></script>
    <script>
        $(document).ready(function() {
            $('tr').each(function() {
                var totmarks = 0;
                $(this).find('.qtysum').each(function() {
                    var marks = $(this).text().replaceAll(".", "");
                    if (marks.length !== 0) {
                        totmarks += parseFloat(marks);

                    }
                });
                //var price = $(this).find('.price').text();
                $(this).find('#qtytotal').html(totmarks.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
                //console.log(totmarks);

            });
            //hitung persenNg
            var total_fg = document.getElementsByClassName("total_fg")[0].innerHTML;
            var total_ng = document.getElementsByClassName("total_ng")[0].innerHTML;

            $('#persenNg').html(((total_ng.replaceAll(".", "") / total_fg.replaceAll(".", "")) * 100).toFixed(2) + "%")
            console.log();
            //end
            //total
            var sum = 0;
            $(".amountt").each(function() {
                sum += parseFloat($(this).text());
            });

            var tamount = 0;
            $('.qtysum').each(function() {
                tamount += parseFloat($(this).text().replace(/\D/g, ""));
            });
            // console.log(tamount);
            $('#total').html((sum).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") + "%");

            //ngsum
            const ngsum = [];
            $(".ngsum").each(function() {
                //ngsum += parseFloat($(this).text());
                var obj = {};
                obj['type'] = $(this).data('ng');
                obj['qty'] = parseFloat(($(this).text()).replace('.', ''));
                ngsum.push(obj)
            });
            //sort array
            ngsum.sort((a, b) => (a.qty < b.qty ? 1 : -1));

            const labell = ['Over Paint', 'Bintik / Pin Hole', 'Minyak / Map', 'Cotton', 'No Paint / Tipis', 'Scratch', 'Air Pocket', 'Kulit Jeruk', 'Kasar', 'Karat', 'Water Over', 'Minyak Kering', 'Dented', 'Keropos', 'Nempel Jig', 'Lainnya']
            //maptype
            const type = ngsum.map(function(ng) {
                return ng.type;
            });
            //maptype
            const qtys = ngsum.map(function(ng) {
                return ng.qty;
            });
            //console.log(ngsum);




            //total sum
            const reduceArray = (sum, qty) => sum + qty;
            const totalsum = qtys.reduce(reduceArray);
            //console.log(totalsum);

            //cummulativeSum
            const cummulativeSum = (
                (sum) => (qty) =>
                (sum += qty)
            )(0);
            const cummulativeQtys = qtys.map(cummulativeSum);
            //console.log(cummulativeQtys);

            //map array + cummulative into %

            const percentageQtys = cummulativeQtys.map((value) => {
                const values = parseFloat((value / totalsum) * 100).toFixed(1);
                return values;
            });
            //console.log(percentageQtys);

            //cart pareto
            const data = {
                labels: type,

                datasets: [{
                        label: "Pareto",
                        data: percentageQtys,
                        backgroundColor: "rgba(255, 26, 104, 0.2)",
                        borderColor: "rgba(255, 26, 104, 1)",
                        yAxisID: "percentageAxis",
                    },
                    {
                        label: "Type NG",
                        data: qtys,
                        backgroundColor: "rgba(54, 162, 235, 0.2)",
                        borderColor: "rgba(54, 162, 235, 1)",
                        borderWidth: 1,
                        type: "bar",
                        barPercentage: 1,
                        categoryPercentage: 1,
                    },
                ],
            };

            // config
            const config = {
                type: "line",
                data,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        tooltip: {
                            yAlign: "bottom",
                        },
                        title: {
                            display: true,
                            text: 'PARETO NG',
                            font: {
                                size: 18
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                display: false,
                            },
                        },
                        percentageAxis: {
                            type: "linear",
                            position: "right",
                            beginAtZero: true,
                            min: 0,
                            max: 100,
                            ticks: {
                                callback: function(value, index, values) {
                                    return value + "%";
                                },
                            },
                        },
                    },
                },
            };
            // render init block
            const myChart = new Chart(document.getElementById("myChart"), config);



            //datecolect
            const date = [];
            $(".date-packing").each(function() {
                //ngsum += parseFloat($(this).text());
                date.push($(this).data('date'))
            });
            //okcolect
            const ok = [];
            $(".okcolect").each(function() {
                ok.push(parseFloat($(this).text().replace(/\D/g, "")));
            });
            //ngcolect
            const ng = [];
            $(".ngcolect").each(function() {
                ng.push(parseFloat($(this).text().replace(/\D/g, "")));
            });
            //nggcolect
            const ngg = [];
            const target = [];
            $(".nggcolect").each(function() {
                ngg.push(parseFloat($(this).text()));
                // ngg.push(1.4);
                target.push(2);
            });
            //console.log(ng)
            //cart ng
            const dataa = {
                labels: date,

                datasets: [{
                        label: "persenNG",
                        data: ngg,
                        backgroundColor: "rgba(255, 26, 104, 0.2)",
                        borderColor: "rgba(255, 26, 104, 1)",
                        yAxisID: "percentageAxis2",
                    },
                    {
                        label: "Target",
                        data: target,
                        borderColor: "red",
                        fill: false,
                        yAxisID: "percentageAxis2",

                    },
                    {
                        label: "OK",
                        data: ok,
                        backgroundColor: "rgba(54, 162, 235, 0.2)",
                        borderColor: "rgba(54, 162, 235, 1)",
                        borderWidth: 1,
                        type: "bar",
                        barPercentage: 1,
                        categoryPercentage: 1,
                    },
                    {
                        label: "NG",
                        data: ng,
                        backgroundColor: "rgba(245, 195, 39, 0.2)",
                        borderColor: "rgba(245, 195, 39, 1)",
                        borderWidth: 1,
                        type: "bar",
                        barPercentage: 1,
                        categoryPercentage: 1,
                    },
                ],
            };
            const paddingLegend = {
                beforeInit(chart) {
                    // Get reference to the original fit function
                    const originalFit = chart.legend.fit;

                    // Override the fit function
                    chart.legend.fit = function fit() {
                        // Call original function and bind scope in order to use `this` correctly inside it
                        originalFit.bind(chart.legend)();
                        // Change the height as suggested in another answers
                        this.height += 25;
                    }
                },
            }

            // config
            const configg = {
                type: "line",
                data: dataa,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        tooltip: {
                            yAlign: "bottom",
                        },
                        title: {
                            display: true,
                            text: 'GRAFIK NG HARIAN',
                            font: {
                                size: 24
                            }
                        },
                        datalabels: {
                            anchor: 'end',
                            align: 'end',
                            font: {
                                weight: 'bold',
                            },
                            offset: 5,
                            formatter: (value, context) => context.datasetIndex === 0 ? value + " %" : ''
                        }
                    },
                    scales: {
                        x: {
                            stacked: true,
                        },
                        y: {
                            stacked: true,
                            beginAtZero: true,
                            grid: {
                                display: false,
                            },
                        },
                        percentageAxis1: {
                            id: 'percentageAxis1',
                            type: "linear",
                            position: "right",
                            beginAtZero: true,
                            ticks: {
                                callback: function(value, index, values) {
                                    return value + "%";
                                },
                            },
                        },
                        percentageAxis2: {
                            id: 'percentageAxis2',
                            type: "linear",
                            position: "right",
                            beginAtZero: true,
                            ticks: {
                                callback: function(value, index, values) {
                                    return value + "%";
                                },
                            },
                            display: false
                        },
                    },
                },
                // plugins: [ChartDataLabels, statusTracker]
                plugins: [ChartDataLabels, paddingLegend]
            };
            // render init block
            const myChartt = new Chart(document.getElementById("myChart1"), configg);

        })
    </script>
</body>
@endif

</html>