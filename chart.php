<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">      <link rel="icon" href="favicon.jpg" type="image/x-icon">

    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <title>Chart</title>
    <style>
        .center-block {
            height: 300px;
            border: 2px solid blue;
        }
    </style>
</head>
<body>
    <div class="chartdatacontainer" style="width: 80%; display:flex;justify-content:spaced-evenly;align-items:center;border:2px solid red;"  >
    <div class="container" style="width: 40%; height: 300px;">
            <div id="container" class="center-block"></div>
        </div>

        <div class="containernew" style="width: 40%; height: 300px;">
            <div id="containernew" class="center-block"></div>
        </div>


    </div>

    <?php
    include 'partials/_dbconnect.php';

    $query = "SELECT sold_platform, COUNT(*) as count FROM `sold` GROUP BY sold_platform ";
    $getData = $conn->query($query);

    
    $query1 = "SELECT companyname, COUNT(*) as count FROM `images` GROUP BY companyname ";
    $getData1 = $conn->query($query1);
    ?>

    

    <script>
        // Build the chart
        Highcharts.chart('container', {
            credits: {
                enabled: false
            },
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: 'Sold Through Statistics:'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.y}</b>',
                valueSuffix: ' Sold'
            },
            accessibility: {
                point: {
                    valueSuffix: 'Sold'
                }
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: true
                }
            },
            series: [{
                name: 'Count',
                colorByPoint: true,
                data: [
                    <?php
                    $data = '';
                    if ($getData->num_rows > 0) {
                        while ($row = $getData->fetch_assoc()) {
                            $data .= '{ name: "' . $row['sold_platform'] . '", y: ' . $row['count'] . ' },';
                        }
                    }
                    echo $data;
                    ?>
                ]
            }]
        });

        
    // Build the chart
    Highcharts.chart('containernew', {
        credits: {
                enabled: false
            },
        chart: {
            type: 'bar'
        },
        title: {
            text: 'Listing Statistics'
        },
        xAxis: {
            type: 'category',
            title: {
                text: ''
            }
        },
        yAxis: {
            title: {
                text: 'Count'
            },
            min: 0,
            tickInterval: 1
        },
        series: [{
            name: 'Active Listings',
            data: [
                <?php
                if ($getData1->num_rows > 0) {
                    while ($row = $getData1->fetch_assoc()) {
                        echo "['" . $row['companyname'] . "', " . $row['count'] . "],";
                    }
                }
                ?>
            ]
        }]
    });        
    </script>
</body>
</html>