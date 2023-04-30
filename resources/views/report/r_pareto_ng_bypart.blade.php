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
        <canvas id="myChart"></canvas>
    </div>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js/dist/chart.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/2.2.0/chartjs-plugin-datalabels.min.js" integrity="sha512-JPcRR8yFa8mmCsfrw4TNte1ZvF1e3+1SdGMslZvmrzDYxS69J7J49vkFL8u6u8PlPJK+H3voElBtUCzaXj+6ig==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="assets/css/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="assets/js/autonumeric/autoNumeric.min.js"></script>
    <script>
        $(document).ready(function() {
            const datta = [];
            <?php foreach ($data as $item) { ?>
                var obj = {};
                obj['part_name'] = "<?php echo $item['name_local'] ?>";
                obj['qtyNg'] = parseInt(<?php echo $item['qty_ng'] ?>);
                datta.push(obj);
            <?php } ?>

            console.log(datta);
            //sort array
            datta.sort((a, b) => (a.qtyNg < b.qtyNg ? 1 : -1));

            //maptype
            const type = datta.map(function(ng) {
                return ng.part_name;
            });
            //maptype
            const qtys = datta.map(function(ng) {
                return ng.qtyNg;
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
                        label: "Qty NG",
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

            //convert text
            const text = "{{$typeNg}}";
            const convertedText = text.toUpperCase().replaceAll("_", " ");
            //end
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
                            text: 'PARETO NG ' + convertedText + ' BY PART',
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

        })
    </script>
</body>
@endif

</html>