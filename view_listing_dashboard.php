<?php
session_start();
$email = $_SESSION["email"];
$companyname001 = $_SESSION['companyname'];
$enterprise=$_SESSION['enterprise'];
$dashboard_url = '';
if ($enterprise === 'rental') {
    $dashboard_url = 'rental_dashboard.php';
} elseif ($enterprise === 'logistics') {
    $dashboard_url = 'logisticsdashboard.php';
} 
elseif ($enterprise === 'epc') {
    $dashboard_url = 'epc_dashboard.php';
} 
else {
    $dashboard_url = '';
}
$enterprise=$_SESSION['enterprise'];
$dashboard_url = '';
if ($enterprise === 'rental') {
    $dashboard_url = 'rental_dashboard.php';
} elseif ($enterprise === 'logistics') {
    $dashboard_url = 'logisticsdashboard.php';
} 
elseif ($enterprise === 'epc') {
    $dashboard_url = 'epc_dashboard.php';
} 
else {
    $dashboard_url = '';
}


?>

<style>
  <?php include "style.css" 
  ?>
</style>
<?php
include 'partials/_dbconnect.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">      <link rel="icon" href="favicon.jpg" type="image/x-icon">

    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <link rel="stylesheet" href="tiles.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>

   <link rel="stylesheet" href="style.css">
    <title>Document</title>
    <style>
        .center-block {
            height: 300px;
            /* border: 2px solid blue; */
        } 

    </style>
</head>
<body>
    <div class="navbar1">
    <div class="logo_fleet">
    <img src="logo_fe.png" alt="FLEET EIP" onclick="window.location.href='<?php echo $dashboard_url ?>'">
</div>

        <div class="iconcontainer">
        <ul>
        <li><a href="<?php echo $dashboard_url ?>">Dashboard</a></li>
            <li><a href="news/">News</a></li>
            <li><a href="logout.php">Log Out</a></li></ul>
        </div>
    </div>
<!--     <div class="outercard">
            <div class="card_container_purchase">
            <div class="button-52" onclick="location.href='view_listing.php'" >Active Listings</div>
            <div class="button-52" onclick="location.href='viewsold.php'" >Sold Listings</div>
        </div>  --> 
       
        
  <div class="newtilecontainer">
<article class="article-wrapper" onclick="location.href='view_listing.php'">
  <div class="rounded-lg container-project1 lis">
    </div>
    <div class="project-info">
      <div class="flex-pr">
        <div class="project-title text-nowrap">Active Listings</div>
          <div class="project-hover">
            <svg style="color: black;" xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" color="black" stroke-linejoin="round" stroke-linecap="round" viewBox="0 0 24 24" stroke-width="2" fill="none" stroke="currentColor"><line y2="12" x2="19" y1="12" x1="5"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
            </div>
          </div>
         <div class="types">
          <!--   <span style="background-color: rgba(165, 96, 247, 0.43); color: rgb(85, 27, 177);" class="project-type">• Add Clients</span>
             <span class="project-type">• Manage Clients</span>  -->
        </div>
    </div>
</article>

<article class="article-wrapper" onclick="location.href='viewsold.php'" >
  <div class="rounded-lg container-project1 lis">
    </div>
    <div class="project-info">
      <div class="flex-pr">
        <div class="project-title text-nowrap">Sold Listings</div>
          <div class="project-hover">
            <svg style="color: black;" xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" color="black" stroke-linejoin="round" stroke-linecap="round" viewBox="0 0 24 24" stroke-width="2" fill="none" stroke="currentColor"><line y2="12" x2="19" y1="12" x1="5"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
            </div>
          </div>
           <div class="types">
            <!-- <span style="background-color: rgba(165, 96, 247, 0.43); color: rgb(85, 27, 177);" class="project-type"> • Manage Bills </span>
             <span class="project-type"> • Generate Bills </span> -->
        </div> 
    </div>
</article>
</div> 
<br> 
<br>

    <div class="chartdatacontainer_sellingfleet"   >
    <div class="container123" style="width: 40%; height: 300px;">
            <div id="container" class="center-block"></div>
        </div>

        <div class="containernew" style="width: 40%; height: 300px;">
            <div id="containernew" class="center-block"></div>
        </div>


    </div>

    <?php
    include 'partials/_dbconnect.php';

    $query = "SELECT sold_platform, COUNT(*) as count FROM `sold` where companyname='$companyname001' GROUP BY sold_platform ";
    $getData = $conn->query($query);

    
    $query1 = "SELECT companyname, COUNT(*) as count FROM `images`  where companyname='$companyname001' GROUP BY companyname ";
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