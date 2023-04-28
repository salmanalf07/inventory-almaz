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

        .vertical-text {
            writing-mode: vertical-lr;
            text-orientation: upright;
        }

        .loss-color {
            background-color: #C6E0B4;
        }

        .detail-color {
            background-color: #E2EFDA;
        }

        .value-color {
            background-color: #E7E6E6;
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
                <td style="background-color: #FFD966;" class="center bold" colspan="2" rowspan="2">
                    <h3>DATA</h3>
                </td>
                <td style="background-color: #FFD966;" class="center bold" colspan="{{count($data)}}">TANGGAL</td>
                <td style="background-color: #FFD966;" width="150" class="center bold" rowspan="2">
                    <h3>TOTAL</h3>
                </td>
            </tr>
            <tr>
                @foreach($data as $date)
                <td class="center date-packing bold" data-date="{{date('d',strtotime($date['date_production']))}}" width="50">{{date("d",strtotime($date['date_production']))}}</td>
                @endforeach
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="2" class="value-color">Jam kerja normal</td>
                @foreach($data as $key => $hours)
                <td class="right qtysum">{{$hours['work_hours']}}</td>
                @endforeach
                <td>
                    <div class="right amount" id="qtytotal"></div>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="value-color">Jam kerja actual</td>
                @foreach($data as $key => $hours)
                <td class="right qtysum">{{round(abs(strtotime($hours['hour_actual_st'])-strtotime($hours['hour_actual_en']))/3600,2)}}</td>
                @endforeach
                <td>
                    <div class="right amount" id="qtytotal"></div>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="value-color">Over time</td>
                @foreach($data as $key => $hours)
                <td class="right qtysum">{{round(abs(strtotime($hours['hour_actual_st'])-strtotime($hours['hour_actual_en']))/3600,2)-$hours['work_hours']}}</td>
                @endforeach
                <td>
                    <div class="right amount" id="qtytotal"></div>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="value-color">Kapasitas normal</td>
                @foreach($data as $key => $capacity)
                <td class="right qtysum">{{$capacity['normal_capacity']}}</td>
                @endforeach
                <td>
                    <div class="right amount" id="qtytotal"></div>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="value-color">Kapasitas over time</td>
                @foreach($data as $key => $hours)
                <td class="right qtysum">{{(round(abs(strtotime($hours['hour_actual_st'])-strtotime($hours['hour_actual_en']))/3600,2)-$hours['work_hours']) * 6}}</td>
                @endforeach
                <td>
                    <div class="right amount" id="qtytotal"></div>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="value-color">Kapasitas total</td>
                @foreach($data as $key => $hours)
                <td class="right qtysum">{{($hours['normal_capacity']+(round(abs(strtotime($hours['hour_actual_st'])-strtotime($hours['hour_actual_en']))/3600,2)-$hours['work_hours']) * 6)}}</td>
                @endforeach
                <td>
                    <div class="right amount normal_capacity" id="qtytotal"></div>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="value-color">Out put normal</td>
                @foreach($data as $key => $capacity)
                <td class="right qtysum">{{$capacity['output_act']}}</td>
                @endforeach
                <td>
                    <div class="right amount" id="qtytotal"></div>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="value-color">Out put over time</td>
                @foreach($data as $key => $hours)
                <td class="right qtysum"></td>
                @endforeach
                <td>
                    <div class="right amount" id="qtytotal"></div>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="value-color">Output total</td>
                @foreach($data as $key => $capacity)
                <td class="right qtysum ouputtot">{{$capacity['output_act']}}</td>
                @endforeach
                <td>
                    <div class="right amount output_act" id="qtytotal"></div>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="value-color">Lost Hanger</td>
                @foreach($data as $key => $hours)
                <td class="right qtysum losthanger">{{(($hours['normal_capacity'] + (round(abs(strtotime($hours['hour_actual_st'])-strtotime($hours['hour_actual_en']))/3600,2)-$hours['work_hours']) * 6) - $hours['output_act'])}}</td>
                @endforeach
                <td>
                    <div class="right amount" id="qtytotal"></div>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="value-color">Target</td>
                @foreach($data as $key => $target)
                <td style="background-color: #FFD966;" class="right">{{$target['target']}}%</td>
                @endforeach
                <td style="background-color: #FFD966;">
                    <div class="right">{{$target['target']}}%</div>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="value-color">Produktifitas %</td>
                @foreach($data as $key => $hours)
                @if($hours['output_act'] != 0)
                <td style="background-color: #FFF2CC;" class="right lostthanger amountt">{{round(($hours['output_act'] / ($hours['normal_capacity'] + (round(abs(strtotime($hours['hour_actual_st'])-strtotime($hours['hour_actual_en']))/3600,2)-$hours['work_hours']) * 6)) * 100,1)}}%</td>
                @else
                <td style="background-color: #FFF2CC;" class="right lostthanger amountt">0%</td>
                @endif
                @endforeach
                <td style="background-color: #FFF2CC;" class="right">
                    <div id="produktifitas"></div>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="value-color">Surface area</td>
                @foreach($data as $key => $hours)
                <td style="background-color: #FFF2CC;" class="right qtysum"></td>
                @endforeach
                <td style="background-color: #FFF2CC;">
                    <div class="right amount" id="qtytotal"></div>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="value-color">Qty (pcs)</td>
                @foreach($data as $key => $qty_in)
                <td style="background-color: #FFF2CC;" class="right qtypcs">{{number_format($qty_in['qty_in'],0,".",".")}}</td>
                @endforeach
                <td style="background-color: #FFF2CC;">
                    <div class="right amount" id="pcstotal"></div>
                </td>
            </tr>
            <tr>
                <td rowspan="9" class="vertical-text loss-color" style="width:1%">Loss</td>
                <td class="detail-color" style="width:20%">Hanger rusak</td>
                @foreach($data as $key => $hanger_rusak)
                @if($hanger_rusak['hanger_rusak'] != 0)
                <td class="right qtysum value-color">{{$hanger_rusak['hanger_rusak']}}</td>
                @else
                <td class="right qtysum value-color">0</td>
                @endif
                @endforeach
                <td>
                    <div data-loss="Hanger rusak" class="right amount value-color losssum" id="qtytotal"></div>
                </td>
            </tr>
            <tr>
                <td class="detail-color">Tidak racking</td>
                @foreach($data as $key => $tidak_racking)
                @if($hanger_rusak['hanger_rusak'] != 0)
                <td class="right qtysum value-color">{{$hanger_rusak['hanger_rusak']}}</td>
                @else
                <td class="right qtysum value-color">0</td>
                @endif
                @endforeach
                <td>
                    <div data-loss="Tidak racking" class="right amount value-color losssum" id="qtytotal"></div>
                </td>
            </tr>
            <tr>
                <td class="detail-color">Keteter</td>
                @foreach($data as $key => $keteter)
                @if($keteter['keteter'] != 0)
                <td class="right qtysum value-color">{{$keteter['keteter']}}</td>
                @else
                <td class="right qtysum value-color">0</td>
                @endif
                @endforeach
                <td>
                    <div data-loss="Keteter" class="right amount value-color losssum" id="qtytotal"></div>
                </td>
            </tr>
            <tr>
                <td class="detail-color">Tidak ada barang</td>
                @foreach($data as $key => $tidak_ada_barang)
                @if($tidak_ada_barang['tidak_ada_barang'] != 0)
                <td class="right qtysum value-color">{{$tidak_ada_barang['tidak_ada_barang']}}</td>
                @else
                <td class="right qtysum value-color">0</td>
                @endif
                @endforeach
                <td>
                    <div data-loss="Tidak ada barang" class="right amount value-color losssum" id="qtytotal"></div>
                </td>
            </tr>
            <tr>
                <td class="detail-color">Trouble mesin</td>
                @foreach($data as $key => $trouble_mesin)
                @if($trouble_mesin['trouble_mesin'] != 0)
                <td class="right qtysum value-color">{{$trouble_mesin['trouble_mesin']}}</td>
                @else
                <td class="right qtysum value-color">0</td>
                @endif
                @endforeach
                <td>
                    <div data-loss="Trouble mesin" class="right amount value-color losssum" id="qtytotal"></div>
                </td>
            </tr>
            <tr>
                <td class="detail-color">Trouble chemical</td>
                @foreach($data as $key => $trouble_chemical)
                @if($trouble_chemical['trouble_chemical'] != 0)
                <td class="right qtysum value-color">{{$trouble_chemical['trouble_chemical']}}</td>
                @else
                <td class="right qtysum value-color">0</td>
                @endif
                @endforeach
                <td>
                    <div data-loss="Trouble chemical" class="right amount value-color losssum" id="qtytotal"></div>
                </td>
            </tr>
            <tr>
                <td class="detail-color">Trouble utility</td>
                @foreach($data as $key => $trouble_utility)
                @if($trouble_utility['trouble_utility'] != 0)
                <td class="right qtysum value-color">{{$trouble_utility['trouble_utility']}}</td>
                @else
                <td class="right qtysum value-color">0</td>
                @endif
                @endforeach
                <td>
                    <div data-loss="Trouble utility" class="right amount value-color losssum" id="qtytotal"></div>
                </td>
            </tr>
            <tr>
                <td class="detail-color">Trouble NG</td>
                @foreach($data as $key => $trouble_ng)
                @if($trouble_ng['trouble_ng'] != 0)
                <td class="right qtysum value-color">{{$trouble_ng['trouble_ng']}}</td>
                @else
                <td class="right qtysum value-color">0</td>
                @endif
                @endforeach
                <td>
                    <div data-loss="Trouble NG" class="right amount value-color losssum" id="qtytotal"></div>
                </td>
            </tr>
            <tr>
                <td class="detail-color">Mati lampu</td>
                @foreach($data as $key => $mati_lampu)
                @if($mati_lampu['mati_lampu'] != 0)
                <td class="right qtysum value-color">{{$mati_lampu['mati_lampu']}}</td>
                @else
                <td class="right qtysum value-color">0</td>
                @endif
                @endforeach
                <td>
                    <div class="right amount value-color" id="qtytotal"></div>
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
                    var marks = $(this).text();
                    if (marks.length !== 0) {
                        totmarks += parseFloat(marks);

                    }
                });
                //var price = $(this).find('.price').text();
                $(this).find('#qtytotal').html((Math.round(totmarks * 100) / 100).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                //console.log(Math.round(totmarks * 100) / 100);
                var totmarkss = 0;
                $(this).find('.qtypcs').each(function() {
                    var markss = $(this).text().replace('.', '');
                    if (markss.length !== 0) {
                        totmarkss += parseFloat(markss);

                    }
                });
                //var price = $(this).find('.price').text();
                $(this).find('#pcstotal').html(totmarkss.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));

            });

            //fungsi untuk sum produktifitas
            var output_act = document.getElementsByClassName("output_act")[0].innerHTML;
            var normal_capacity = document.getElementsByClassName("normal_capacity")[0].innerHTML;

            $('#produktifitas').html(((output_act.replaceAll(",", "") / normal_capacity.replaceAll(",", "")) * 100).toFixed(2) + "%");

            //console.log(normal_capacity);
            //end fungsi

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
            $(".losssum").each(function() {
                //ngsum += parseFloat($(this).text());
                var obj = {};
                obj['type'] = $(this).data('loss');
                obj['qty'] = parseFloat($(this).text());
                ngsum.push(obj)
            });
            //sort array
            ngsum.sort((a, b) => (a.qty < b.qty ? 1 : -1));

            const labell = ['Hanger rusak', 'Tidak racking', 'Keteter', 'Tidak ada barang', 'Trouble mesin', 'Trouble chemical', 'Trouble utility', 'Trouble NG']
            //maptype
            const type = ngsum.map(function(ng) {
                return ng.type;
            });
            //maptype
            const qtys = ngsum.map(function(ng) {
                return ng.qty;
            });
            //console.log(type);




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
            //   console.log(percentageQtys);

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
                        label: "Type LOSS",
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
                            text: 'PARETO LOSS',
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
            $(".ouputtot").each(function() {
                ok.push(parseFloat($(this).text().replace(/\D/g, "")));
            });
            //ngcolect
            const ng = [];
            $(".losthanger").each(function() {
                ng.push(parseFloat($(this).text()));
            });
            //nggcolect
            const ngg = [];
            const target = [];
            $(".lostthanger").each(function() {
                ngg.push(parseFloat($(this).text()));
                // ngg.push(1.4);
                target.push(98);
            });
            //console.log(ng)
            //cart ng
            const dataa = {
                labels: date,

                datasets: [{
                        label: "Produktifitas %",
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
                        label: "Output total",
                        data: ok,
                        backgroundColor: "rgba(54, 162, 235, 0.2)",
                        borderColor: "rgba(54, 162, 235, 1)",
                        borderWidth: 1,
                        type: "bar",
                        barPercentage: 1,
                        categoryPercentage: 1,
                    },
                    {
                        label: "Lost Hanger",
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
                            text: 'GRAFIK PRODUKTIFITAS HARIAN',
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
                            // display: false
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