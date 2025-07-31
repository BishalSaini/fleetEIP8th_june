<?php
session_start();
$_SESSION['loggedin'] = true;
$companyname001=$_SESSION['companyname'];
$enterprise=$_SESSION['enterprise'];

include_once 'partials/_dbconnect.php'; // Include the database connection file

// Handle status toggle POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['toggle_status']) && isset($_POST['fleet_snum']) && isset($_POST['new_status'])) {
    $fleet_snum = intval($_POST['fleet_snum']);
    $new_status = ($_POST['new_status'] === 'Working') ? 'Working' : 'Idle';
    $anchor = isset($_POST['anchor']) ? preg_replace('/[^a-zA-Z0-9_\-]/', '', $_POST['anchor']) : '';
    $update_status_sql = "UPDATE fleet1 SET status='$new_status' WHERE snum=$fleet_snum AND companyname='$companyname001'";
    mysqli_query($conn, $update_status_sql);
    header("Location: viewfleet2.php" . ($anchor ? "#$anchor" : ""));
    exit();
}

$showAlert=false;
$showAlert2=false;
$showError=false;
$showAlert_addfleet=false;
$showError_addfleet=false;
$enterprise = $_SESSION['enterprise'] ?? null;

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


$sql_max_ref_no = "SELECT MAX(assetcode) AS max_ref_no FROM `fleet1` WHERE companyname = '$companyname001'";
$result_max_ref_no = mysqli_query($conn, $sql_max_ref_no);
$row_max_ref_no = mysqli_fetch_assoc($result_max_ref_no);
$next_ref_no = ($row_max_ref_no['max_ref_no'] === null) ? 1 : $row_max_ref_no['max_ref_no'] + 1;



// Fetch fleet statistics based on company name
$query = "SELECT status, COUNT(*) AS count FROM `fleet1` WHERE companyname='$companyname001' GROUP BY status";
$getData = $conn->query($query);
?>
<?php
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['craneaddsubmit']))
{
    include 'partials/_dbconnect.php';
    $make = $_POST["make"];
    $other_make = $_POST['other_make'];
    $category = $_POST['fleet_category'];
    $type = $_POST["type"];
    $model = $_POST["model"];
    $assetcode = $_POST["assetcode"];
    $companyname = $_POST["companyname"];
    $yom = $_POST["yom"];
    $capacity = $_POST["capacity"];
    $unit =$_POST['unit'];
    $registration = $_POST["registration"];
    $chassis = isset($_POST["chassis_make"]) ? $_POST["chassis_make"] : null;
    $other_chassis_make = $_POST['new_chassis_maker'];
    $boomLength = $_POST["boomLength"];
    $jibLength = $_POST["jibLength"];
    $luffingLength = $_POST["luffingLength"];
    $statuss = $_POST["status"];

    $kealy=$_POST['kealy']?? null;
    $pipeline=$_POST['pipeline'];
    $silos_no=$_POST['silos_no']?? null;
    $cement_silos=$_POST['cement_silos'];
    $flyash_silos=$_POST['flyash_silos'];
    $cement_silos_qty=$_POST['cement_silos_qty'];
    $flyash_silos_qty=$_POST['flyash_silos_qty'];
    $chiller_available=$_POST['chiller_available'] ?? null;
    $height_meter=$_POST['height_meter'];
    $total_height=$_POST['total_height'];
    $free_standing_height=$_POST['free_standing_height'];
    $tipload=$_POST['tipload'];
    $model_no=$_POST['model_no'];
    $fuelEficiency=$_POST['fuelEficiency'];
    $fuelUnit=$_POST['fuelUnit'];
    $adblue=$_POST['adblue'];
    $equipmentLocation=$_POST['equipmentLocation'];

    $registrationdd=$_POST['registrationdd'] ?? '';
    $bedlength=$_POST['bedlength'];
    $workingclientname = !empty($_POST['workingNewClient']) ? $_POST['workingNewClient'] : $_POST['workingClient'];
    $workorderRecieved = !empty($workingclientname) ? "yes" : '';

    if(!empty($_POST['workingNewClient'])){
        $sql="INSERT INTO `rentalclient_basicdetail`(`companyname`, `clientname`)
         VALUES ('$companyname001','$workingclientname')";

        $result=mysqli_query($conn,$sql);
        
    }

    $sql_exist="SELECT * FROM `oem_fleet` WHERE fleet_category='$category' and fleet_Type='$type' and make='$make' and model='$model'";
    $result_exist= mysqli_query($conn , $sql_exist);
    $row=mysqli_fetch_assoc($result_exist);
    if($row){
        $sql = "INSERT INTO `fleet1` (`equipmentLocation`,`fuelUnit`,`adblue`,`fuelEficiency`,`workorder`,`client_name`,`bedlength`,`registrationdd`,`kealy_length`, `pipelength_length`, `silos_no`, `cement_silos`, `flyash_silos`, `cement_silos_qty`, `flyash_silos_qty`, `chiller_available`, `model_no`, `height`, `total_height`, `free_standing_height`, `tip_load`,`make`, `other_make`, `category`, `sub_type`, `model`, `assetcode`, `companyname`, `yom`, `capacity`, `unit`, `registration`, `chassis`, `other_chassis`,  `boom_length`, `jib_length`, `luffing_length`, `status`,`diesel_tank_capacity`,`hydraulic_oil_tank`,`engine_oil_capacity`,`engine_oil_grade`,`hydraulic_oil_grade`) 
    VALUES ('$equipmentLocation','$fuelUnit','$adblue','$fuelEficiency','$workorderRecieved','$workingclientname','$bedlength','$registrationdd','$kealy','$pipeline','$silos_no','$cement_silos','$flyash_silos','$cement_silos_qty','$flyash_silos_qty','$chiller_available','$model_no','$height_meter','$total_height','$free_standing_height','$tipload','$make', '$other_make', '$category', '$type', '$model', '$assetcode', '$companyname', '$yom', '$capacity', '$unit', '$registration', '$chassis', '$other_chassis_make', '$boomLength', '$jibLength', '$luffingLength', '$statuss', '" . $row['diesel_tank_cap'] . "','" . $row['hydraulic_oil_tank'] . "','" . $row['engine_oil_cap'] . "','" . $row['engine_oil_grade'] . "','" . $row['hydraulic_oil_grade'] . "')";
            $result = mysqli_query($conn , $sql);
            if($result){
                $showAlert=true;
            }
            
    }
else{
    $sql = "INSERT INTO `fleet1` (`equipmentLocation`,`fuelUnit`,`adblue`,`fuelEficiency`,`workorder`,`client_name`,`bedlength`,`registrationdd`,`kealy_length`, `pipelength_length`, `silos_no`, `cement_silos`, `flyash_silos`, `cement_silos_qty`, `flyash_silos_qty`, `chiller_available`, `model_no`, `height`, `total_height`, `free_standing_height`, `tip_load`,`make`, `other_make`, `category`, `sub_type`, `model`, `assetcode`, `companyname`, `yom`, `capacity`, `unit`, `registration`, `chassis`, `other_chassis`,  `boom_length`, `jib_length`, `luffing_length`, `status`) 
    VALUES ('$equipmentLocation','$fuelUnit','$adblue','$fuelEficiency','$workorderRecieved','$workingclientname','$bedlength','$registrationdd','$kealy','$pipeline','$silos_no','$cement_silos','$flyash_silos','$cement_silos_qty','$flyash_silos_qty','$chiller_available','$model_no','$height_meter','$total_height','$free_standing_height','$tipload','$make', '$other_make', '$category', '$type', '$model', '$assetcode', '$companyname', '$yom', '$capacity', '$unit', '$registration', '$chassis', '$other_chassis_make',  '$boomLength', '$jibLength', '$luffingLength', '$statuss')";    $result = mysqli_query($conn , $sql);
    if($result){
        $showAlert_addfleet=true;
    }
    else{
        $showError_addfleet=true;
    }

}
}
?>

<style>
  <?php include "style.css" 
  ?>
</style>
<?php
$sql_notification_count_expiry="SELECT COUNT(sno) AS total_notification FROM `insaurance_notification` where company_name='$companyname001'";
$result_count=mysqli_query($conn,$sql_notification_count_expiry);
$row_count_noti= mysqli_fetch_assoc($result_count);
$count_of_notification=$row_count_noti['total_notification']
?>

<?php
include_once 'partials/_dbconnect.php'; // Include the database connection file

$noti_check = "SELECT COUNT(snum) AS total FROM `fleet1` WHERE companyname='akash'";
$result = mysqli_query($conn, $noti_check);

$row = mysqli_fetch_assoc($result);
$total_count = $row['total'];
?>

<?php
$sql_noti="SELECT * FROM `insaurance_notification` WHERE `company_name`='$companyname001'";
$result_noti=mysqli_query($conn,$sql_noti);
?>
<?php
if(isset($_SESSION['message']))
{
    $showAlert=true;
    unset($_SESSION['message']);
}
if(isset($_SESSION['success']))
{
    $showAlert2=true;
    unset($_SESSION['success']);
}
else if (isset($_SESSION['error_message'])){
    $showError=true;
    unset($_SESSION['error_message']);
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">      <link rel="icon" href="favicon.jpg" type="image/x-icon">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Fleet</title>
    <script src="main.js"></script>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="tiles.css">
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.3/css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.4/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <style>
        .center-block {
            width: 100%;
            height: 300px;
        }
        .generate-btn{
            border:none;
            background-color:white;
            margin-top:70px;
        }
        .project-info{
            height:50px!important;
        }
    </style>
    <script>
function confirmStatusChange(event) {
    if (!confirm('Are you sure you want to change the status of this fleet?')) {
        event.preventDefault();
        return false;
    }
    return true;
}

// Highcharts chart for Working/Idle assets
window.addEventListener('DOMContentLoaded', function() {
    Highcharts.chart('container', {
        credits: { enabled: false },
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: 'Fleet Status Distribution'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.y}</b>',
            valueSuffix: ' Assets'
        },
        accessibility: {
            point: { valueSuffix: ' Assets' }
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: { enabled: true, format: '{point.name}: {point.y}' },
                showInLegend: true
            }
        },
        series: [{
            name: 'Count',
            colorByPoint: true,
            data: [
                <?php
                // Query for working and idle assets count
                $sql_status_count = "SELECT status, COUNT(*) AS count FROM fleet1 WHERE companyname='$companyname001' GROUP BY status";
                $result_status_count = mysqli_query($conn, $sql_status_count);
                $data = '';
                if ($result_status_count) {
                    while ($row_status = mysqli_fetch_assoc($result_status_count)) {
                        $data .= '{ name: "' . htmlspecialchars($row_status['status']) . '", y: ' . intval($row_status['count']) . ' },';
                    }
                }
                echo rtrim($data, ',');
                ?>
            ]
        }]
    });
});
</script>
</head>
<body>
    <!-- Navbar section -->
        <div class="navbar1">

    <div class="logo_fleet">
    <img src="logo_fe.png" alt="FLEET EIP" onclick="window.location.href='<?php echo $dashboard_url  ?>'">
</div>
        <div class="iconcontainer">
            <ul>
            <li><a href="<?php echo $dashboard_url ?>">Dashboard</a></li>
                <li><a href="news/">News</a></li>
                <li><a href="logout.php">Logout</a></li>
                <!-- <li><a href="logout.php" >Alerts</a></li> -->
                <li <?php if($count_of_notification == 0) echo 'style="display: none;"' ?>><div class="alerts" onclick="expirynotification()" ><?php echo $count_of_notification ?> Alerts</div></li>

                <!-- <li><a onclick="expirynotification()" id="alerticon" class="notification-icon"><i class="fa-regular fa-bell"></i></a></li> -->
               



                

            </ul>
        </div>
    </div> 
    <?php
if($showAlert){
    echo '<label>
    <input type="checkbox" class="alertCheckbox" autocomplete="off" />
    <div class="alert notice">
        <span class="alertClose">X</span>
        <span class="alertText">Fleet Edited Successfully<br class="clear"/></span>
    </div>
    </label>';
}
if($showAlert2){
    echo '<label>
    <input type="checkbox" class="alertCheckbox" autocomplete="off" />
    <div class="alert notice">
        <span class="alertClose">X</span>
        <span class="alertText">Success<br class="clear"/></span>
    </div>
    </label>';
}
if($showError){
    echo '<label>
    <input type="checkbox" class="alertCheckbox" autocomplete="off" />
    <div class="alert error">
        <span class="alertClose">X</span>
        <span class="alertText">Something Went Wrong<br class="clear"/></span>
    </div>
    </label>';
}
if($showAlert_addfleet){
    echo  '<label>
    <input type="checkbox" class="alertCheckbox" autocomplete="off" />
    <div class="alert notice">
      <span class="alertClose">X</span>
      <span class="alertText_addfleet"><b>Success!</b>Fleet Added Successfully
          <br class="clear"/></span>
    </div>
  </label>';
 }
 if($showError_addfleet){
    echo '<label>
    <input type="checkbox" class="alertCheckbox" autocomplete="off" />
    <div class="alert error">
      <span class="alertClose">X</span>
      <span class="alertText">Something Went Wrong
          <br class="clear"/></span>
    </div>
  </label>';
 }
  
?>
<div class="add_fleet_btn_new">
<button class="generate-btn"> 
    <article class="article-wrapper" onclick="addfleetnew()" > 
  <div class="rounded-lg container-projectss ">
    </div>
    <div class="project-info">
      <div class="flex-pr">
        <div class="project-title text-nowrap">Add Equipment</div>
          <div class="project-hover">
            <svg style="color: black;" xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" color="black" stroke-linejoin="round" stroke-linecap="round" viewBox="0 0 24 24" stroke-width="2" fill="none" stroke="currentColor"><line y2="12" x2="19" y1="12" x1="5"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
            </div>
          </div>
          <div class="types">
        </div>
    </div>
</article>
    </button>

</div>
<!-- <button onclick="addfleetnew()" class="new_add">Add Fleet</button> -->
<div class="modal_new_fleetadd" id="newfleet_btn_add">
<form action="viewfleet2.php" method="POST" autocomplete="off" class="addcraneform">
    <div class="formcontainer">
        <div class="add-fleet"><p class="add_rental_fleet">Add Your Fleet</p><i onclick="window.location.href = 'viewfleet2.php';" class="fa-solid fa-xmark"></i></div>
        <div class="trial1" style="display:none;">
        <input type="text" name="companyname" placeholder="" value="<?php echo$companyname001 ?>" class="input02" readonly>
        <label class="placeholder2">Company Name</label>
        </div>

        <div class="outer02">
        <div class="trial1">
        <select class="input02" name="fleet_category" id="oem_fleet_type" onchange="purchase_option()" required>
            <option value="" disabled selected>Select Fleet Category</option>
            <option value="Aerial Work Platform">Aerial Work Platform</option>
            <option value="Concrete Equipment">Concrete Equipment</option>
            <option value="EarthMovers and Road Equipments">EarthMovers and Road Equipments</option>
            <option value="Material Handling Equipments">Material Handling Equipments</option>
            <option value="Ground Engineering Equipments">Ground Engineering Equipments</option>
            <option value="Trailor and Truck">Trailor and Truck</option>
            <option value="Generator and Lighting">Generator and Lighting</option>
        </select>
        </div>
        <div class="trial1">
        <select class="input02" name="type" id="fleet_sub_type" onchange="crawler_options()" required>
            <option value="" disabled selected>Select Fleet Type</option>
            <option value="Self Propelled Articulated Boomlift"class="awp_options"  id="aerial_work_platform_option1">Self Propelled Articulated Boomlift</option>
            <option value="Scissor Lift Diesel" class="awp_options" id="aerial_work_platform_option2">Scissor Lift Diesel</option>
            <option value="Scissor Lift Electric"class="awp_options"  id="aerial_work_platform_option3">Scissor Lift Electric</option>
            <option value="Spider Lift"class="awp_options"  id="aerial_work_platform_option4">Spider Lift</option>
            <option value="Self Propelled Straight Boomlift"class="awp_options"  id="aerial_work_platform_option5">Self Propelled Straight Boomlift</option>
            <option value="Truck Mounted Articulated Boomlift"class="awp_options"  id="aerial_work_platform_option6">Truck Mounted Articulated Boomlift</option>
            <option value="Truck Mounted Straight Boomlift"class="awp_options"  id="aerial_work_platform_option7">Truck Mounted Straight Boomlift</option>
            <option value="Batching Plant"class="cq_options" id="concrete_equipment_option1">Batching Plant</option>
            <option value="Self Loading Mixer"class="cq_options" id="">Self Loading Mixer</option>
            <option value="Concrete Boom Placer"class="cq_options" id="concrete_equipment_option2">Concrete Boom Placer</option>
            <option value="Concrete Pump"class="cq_options" id="concrete_equipment_option3">Concrete Pump</option>
            <option value="Moli Pump"class="cq_options" id="concrete_equipment_option4">Moli Pump</option>
            <option value="Mobile Batching Plant"class="cq_options" id="concrete_equipment_option5">Mobile Batching Plant</option>
            <option value="Static Boom Placer"class="cq_options" id="concrete_equipment_option6">Static Boom Placer</option>
            <option value="Transit Mixer"class="cq_options" id="concrete_equipment_option7">Transit Mixer</option>
            <option value="Shotcrete Machine"class="cq_options" id="concrete_equipment_option7">Shotcrete Machine</option>
            <option value="Baby Roller" class="earthmover_options" id="earthmovers_option1">Baby Roller</option>
            <option value="Backhoe Loader" class="earthmover_options" id="earthmovers_option2">Backhoe Loader</option>
            <option value="Bulldozer" class="earthmover_options" id="earthmovers_option3">Bulldozer</option>
            <option value="Excavator" class="earthmover_options" id="earthmovers_option4">Excavator</option>
            <option value="Milling Machine" class="earthmover_options" id="earthmovers_option5">Milling Machine</option>
            <option value="Motor Grader" class="earthmover_options" id="earthmovers_option6">Motor Grader</option>
            <option value="Pneumatic Tyre Roller" class="earthmover_options" id="earthmovers_option7">Pneumatic Tyre Roller</option>
            <option value="Single Drum Roller" class="earthmover_options" id="earthmovers_option8">Single Drum Roller</option>
            <option value="Skid Loader" class="earthmover_options" id="earthmovers_option9">Skid Loader</option>
            <option value="Slip Form Paver" class="earthmover_options" id="earthmovers_option10">Slip Form Paver</option>
            <option value="Soil Compactor" class="earthmover_options" id="earthmovers_option11">Soil Compactor</option>
            <option value="Tandem Roller" class="earthmover_options" id="earthmovers_option12">Tandem Roller</option>
            <option value="Vibratory Roller" class="earthmover_options" id="earthmovers_option13">Vibratory Roller</option>
            <option value="Wheeled Excavator" class="earthmover_options" id="earthmovers_option14">Wheeled Excavator</option>
            <option value="Wheeled Loader" class="earthmover_options" id="earthmovers_option15">Wheeled Loader</option>
            <option id="mhe_option1"  class="mhe_options" value="Fixed Tower Crane">Fixed Tower Crane</option>
            <option id="mhe_option2" class="mhe_options" value="Fork Lift Diesel">Fork Lift Diesel</option>
            <option id="mhe_option3" class="mhe_options" value="Fork Lift Electric">Fork Lift Electric</option>
            <option id="mhe_option4" class="mhe_options" value="Hammerhead Tower Crane">Hammerhead Tower Crane</option>
            <option id="mhe_option5" class="mhe_options" value="Hydraulic Crawler Crane">Hydraulic Crawler Crane</option>
            <option id="mhe_option6" class="mhe_options" value="Luffing Jib Tower Crane">Luffing Jib Tower Crane</option>
            <option id="mhe_option7" class="mhe_options" value="Mechanical Crawler Crane">Mechanical Crawler Crane</option>
            <option id="mhe_option8" class="mhe_options" value="Pick and Carry Crane">Pick and Carry Crane</option>
            <option id="mhe_option9" class="mhe_options" value="Reach Stacker">Reach Stacker</option>
            <option id="mhe_option10" class="mhe_options" value="Rough Terrain Crane">Rough Terrain Crane</option>
            <option id="mhe_option11" class="mhe_options" value="Telehandler">Telehandler</option>
            <option id="mhe_option12" class="mhe_options" value="Telescopic Crawler Crane">Telescopic Crawler Crane</option>
            <option id="mhe_option13" class="mhe_options" value="Telescopic Mobile Crane">Telescopic Mobile Crane</option>
            <option id="mhe_option14" class="mhe_options" value="All Terrain Mobile Crane">All Terrain Mobile Crane</option>
            <option id="mhe_option15" class="mhe_options" value="Self Loading Truck Crane">Self Loading Truck Crane</option>

            <option id="ground_engineering_equipment_option1" class="gee_options" value="Hydraulic Drilling Rig">Hydraulic Drilling Rig</option>
            <option id="ground_engineering_equipment_option2" class="gee_options" value="Rotary Drilling Rig">Rotary Drilling Rig</option>
            <option id="ground_engineering_equipment_option3" class="gee_options" value="Vibro Hammer">Vibro Hammer</option>
            <option  id="trailor_option1" class="trailor_options" value="Dumper">Dumper</option>
            <option  id="trailor_option2" class="trailor_options" value="Truck">Truck</option>
            <option  id="trailor_option3" class="trailor_options" value="Water Tanker">Water Tanker</option>
            <option id="trailor_option4"  class="trailor_options" value="Low Bed">Low Bed</option>
            <option id="trailor_option5"  class="trailor_options" value="Semi Low Bed">Semi Low Bed</option>
            <option  id="trailor_option6" class="trailor_options" value="Flatbed">Flatbed</option>
            <option  id="trailor_option7" class="trailor_options" value="Hydraulic Axle">Hydraulic Axle</option>
            <option id="generator_option1" class="generator_options" value="Silent Diesel Generator">Silent Diesel Generator</option>
            <option id="generator_option2" class="generator_options" value="Mobile Light Tower">Mobile Light Tower</option>
            <option id="generator_option3" class="generator_options" value="Diesel Generator">Diesel Generator</option>
        </select>
        </div>
        </div>
        <div class="outer02">
        <div class="trial1">
        <input type="text" class="input02" value="<?php echo $next_ref_no ?>" placeholder="" name="assetcode" required>
        <label class="placeholder2">Asset Code</label>
        </div>
        <div class="trial1">
        <select class="input02" name="make" id="crane_make_retnal" onchange="rental_addfleet()" required> 
            <option value="" disabled selected>Fleet Make</option>
  <option value="ACE">ACE</option>
  <option value="Ajax Fiori">Ajax Fiori</option>
  <option value="AMW">AMW</option>
  <option value="Apollo">Apollo</option>
  <option value="Aquarius">Aquarius</option>
  <option value="Ashok Leyland">Ashok Leyland</option>
  <option value="Atlas Copco">Atlas Copco</option>
  <option value="Belaz">Belaz</option>
  <option value="Bemi">Bemi</option>
  <option value="BEML">BEML</option>
  <option value="Bharat Benz">Bharat Benz</option>
  <option value="Bob Cat">Bob Cat</option>
  <option value="Bull">Bull</option>
  <option value="Bauer">Bauer</option>
  <option value="BMS">BMS</option>
  <option value="Bomag">Bomag</option>
  <option value="Case">Case</option>
  <option value="Cat">Cat</option>
  <option value="Cranex">Cranex</option>
  <option value="Casagrande">Casagrande</option>
  <option value="Coles">Coles</option>
  <option value="CHS">CHS</option>
    <option value="Doosan">Doosan</option>
    <option value="Dynapac">Dynapac</option>
    <option value="Demag">Demag</option>
    <option value="Eicher">Eicher</option>
    <option value="Escorts">Escorts</option>
    <option value="Fuwa">Fuwa</option>
    <option value="Fushan">Fushan</option>
    <option value="Genie">Genie</option>
    <option value="Godrej">Godrej</option>
    <option value="Grove">Grove</option>
    <option value="HAMM AG">HAMM AG</option>
    <option value="Haulott">Haulott</option>
    <option value="Hidromek">Hidromek</option>
    <option value="Hydrolift">Hydrolift</option>
    <option value="Hyundai">Hyundai</option>
    <option value="Hidrocon">Hidrocon</option>
    <option value="Ingersoll Rand">Ingersoll Rand</option>
    <option value="Isuzu">Isuzu</option>
    <option value="IHI">IHI</option>
    <option value="JCB">JCB</option>
    <option value="JLG">JLG</option>
    <option value="Jaypee">Jaypee</option>
    <option value="Jinwoo">Jinwoo</option>
    <option value="John Deere">John Deere</option>
    <option value="Jackson">Jackson</option>
    <option value="Kamaz">Kamaz</option>
    <option value="Kato">Kato</option>
    <option value="Kobelco">Kobelco</option>
    <option value="Komatsu">Komatsu</option>
    <option value="Konecranes">Konecranes</option>
    <option value="Kubota">Kubota</option>
    <option value="KYB Conmat">KYB Conmat</option>
    <option value="Krupp">Krupp</option>
    <option value="Kirloskar">Kirloskar</option>
    <option value="Kohler">Kohler</option>
    <option value="L&T">L&T</option>
    <option value="Leeboy">Leeboy</option>
    <option value="LGMG">LGMG</option>
    <option value="Liebherr">Liebherr</option>
    <option value="Link-Belt">Link-Belt</option>
    <option value="Liugong">Liugong</option>
    <option value="Lorain">Lorain</option>
    <option value="Mahindra">Mahindra</option>
    <option value="Magni">Maqni</option>
    <option value="Manitou">Manitou</option>
    <option value="Maintowoc">Maintowoc</option>
    <option value="Marion">Marion</option>
    <option value="MAIT">MAIT</option>
    <option value="Marchetti">Marchetti</option>
    <option value="Noble Lift">Noble Lift</option>
    <option value="New Holland">New Holland</option>
    <option value="Palfinger">Palfinger</option>
    <option value="Potain">Potain</option>
    <option value="Putzmeister">Putzmeister</option>
    <option value="P&H">P&H</option>
    <option value="Pinguely">Pinguely</option>
    <option value="PTC">PTC</option>
    <option value="Reva">Reva</option>
    <option value="Sany">Sany</option>
    <option value="Scania">Scania</option>
    <option value="Schwing Stetter">Schwing Stetter</option>
    <option value="SDLG">SDLG</option>
    <option value="Sennebogen">Sennebogen</option>
    <option value="Shuttle Lift">Shuttle Lift</option>
    <option value="Skyjack">Skyjack</option>
    <option value="Snorkel">Snorkel</option>
    <option value="Soilmec">Soilmec</option>
    <option value="Socma">Socma</option>

    <option value="Socma">Socma</option>
    <option value="Sunward">Sunward</option>
    <option value="Tadano">Tadano</option>
    <option value="Tata Hitachi">Tata Hitachi</option>
    <option value="TATA">TATA</option>
    <option value="Terex">Terex</option>
    <option value="TIL">TIL</option>
    <option value="Toyota">Toyota</option>
    <option value="Teupen">Teupen</option>
    <option value="Unicon">Unicon</option>
    <option value="URB Engineering">URB Engineering</option>
    <option value="Universal Construction">Universal Construction</option>
    <option value="Unipave">Unipave</option>
    <option value="Vogele">Vogele</option>
    <option value="Volvo">Volvo</option>
    <option value="Wirtgen Group">Wirtgen Group</option>
    <option value="XCMG Group">XCMG Group</option>
    <option value="XGMA">XGMA</option>
    <option value="Yanmar">Yanmar</option>
    <option value="Zoomlion">Zoomlion</option>
    <option value="ZPMC">ZPMC</option>
    <option value="Others">Others</option>
</select>
</div>

        <div class="trial1">
        <input type="text" class="input02" placeholder="" name="model" required>
        <label class="placeholder2">Model</label>
        </div>
        


        
        </div>
        <div class="trial1" id="othermake01">
        <input type="text" placeholder="" name="other_make" id="" class="input02" >
        <label class="placeholder2">Specify Other Make</label>
        </div>

        
        <div class="cap_container">
        <div class="trial1">
    <input type="month" name="yom" placeholder="" class="input02" required>
    <label class="placeholder2">YOM</label>
</div>

        <!-- <div class="trial1">
        <input type="text" class="input02" placeholder="" name="oemfuel" required>
        <label class="placeholder2">OEM Fuel Norms</label>
        </div>
        <div class="trial1" id="addfleetunitdd2">
            <select name="oemfuelunit"  class="input02">
                <option value=""disabled selected>Fuel Unit</option>
                <option value="">Per Hour</option>
                <option value="">Per Kmr</option>
            </select>
        </div> -->
        
        <div class="trial1">
        <input type="text" name="capacity" placeholder="" class="input02" required>
        <label class="placeholder2">Capacity</label>
        </div>
        <div class="trial1" id="addfleetunitdd">
            <select name="unit" id="" class="input02" required>
            <option value="" disabled selected> Unit</option>
                <option value="Ton">Ton</option>
                <option value="Kgs">Kgs</option>
                <option value="KnM">KnM</option>
                <option value="Meter">Meter</option>
                <option value="M³">M³</option> 
                 <option value="HP">HP (Horse Power)</option>
            </select>
        </div>
        </div>
        <div class="outer02" id="reg_container">
            <div class="trial1">
                <select class="input02" name="registrationdd" id="regestration_dd" onchange="reg_input()">
                    <option value=""disabled selected>Registration ?</option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                </select>
            </div>

        </div>
        <div class="trial1" id="registration_rental">
        <input type="text"  name="registration"  placeholder="" class="input02">
        <label class="placeholder2">Registration</label>
        </div>


        <div class="outer02" id="chassis_make_rental_outer" >
        <div class="trial1" >
        <select name="chassis_make" class="input02 chassis_makedd" id="chassis_make_rental" onchange="chassis_make_rental1()" >
            <option value="">Choose Chassis Make</option>
            <option value="AWM">AWM</option>
            <option value="Eicher">Eicher</option>
            <option value="TATA">TATA</option>
            <option value="Bharat Benz">Bharat Benz</option>
            <option value="Ashok Leyland">Ashok Leyland</option>
            <option value="Volvo">Volvo</option>
            <option value="Other">Other</option>
        </select>
        </div>
        <div class="trial1" id="model_number">
            <input type="text" name="model_no" placeholder="" class="input02">
            <label for="" class="placeholder2">Model No</label>
        </div>
        </div>
        <div class="trial1" id="otherchassis">
        <input type="text" name="new_chassis_maker" placeholder=""   class=" input02" >
        <label class="placeholder2">Specify Other Chassis Make</label>
        </div>
        <div class="trial1" id="forklift_height">
            <input type="number" name="height_meter" placeholder="" class="input02">
            <label for="" class="placeholder2">Height/Meter</label>
        </div>
        <div class="outer02" id="tower_crane">
            <div class="trial1">
                <input type="number" name="total_height" id="total_height_input"  placeholder="" class="input02">
                <label for="" class="placeholder2 tip_load_in_tons">Total Height In Mtr</label>
            </div>
            <div class="trial1">
                <input type="number" name="free_standing_height" id="free_standing_height"  placeholder="" class="input02">
                <label for="" id="" class="placeholder2 tip_load_in_tons">Free Standing Height</label>
            </div>
            <div class="trial1">
                <input type="number" name="tipload" id="tip_load_height" placeholder="" class="input02">
                <label for=""  class="placeholder2 tip_load_in_tons">Tip Load In Tons</label>
            </div>


        </div>
        <!-- <div class="trial1">
            <input type="text" name="chassis_number" placeholder="" class="input02">
            <label for="" class="placeholder2">Chassis Number</label>
        </div>
        <div class="trial1">
        <input type="text" name="engine" placeholder="" class="input02" >
        <label class="placeholder2">Engine Make</label>
        </div> -->
        <!-- <div class="length_outercontainer" id="length_outer"> -->
                    <div class="trial1" id="bedlengthdiv">
                <input type="number" step="0.1" placeholder="" name="bedlength" id="bedlengthinput" class="input02">
                <label for="" class="placeholder2">Bed Length In Feet</label>
            </div>
            <div class="outer02">
            <div class="trial1" id="fuelefficiency">
            <input type="number" step="0.1" placeholder="" name="fuelEficiency" class="input02">
            <label for="" class="placeholder2">Fuel Eficiency</label>
            </div>
            <select name="fuelUnit" id="" class="input02">
                <option value=""disabled selected>Unit</option>
                <option value="ltrs/hour">ltrs/hour</option>
                <option value="kms/ltrs">kms/ltrs</option>
            </select>

            </div>
            <div class="outer02" id="length_container">
        <div class="trial1" id="boom_input" >
            <input type="number" name="boomLength"  placeholder="" class=" input02" >
            <label class="placeholder2">Boom Length</label>
        </div>    
        <div class="trial1" id="jib_input">
            <input type="number" name="jibLength"  placeholder="" class="input02 " >
            <label class="placeholder2">Jib Length</label>
        </div>
        <div class="trial1" id="luffing_input">
            <input type="number" name="luffingLength"  placeholder="" class=" input02" >
            <label class="placeholder2">Luffing Length</label>
        </div>
        </div>
        <div class="trial1" id="kealy_length">
            <input type="text" name='kealy' placeholder="" class="input02">
            <label for="" class="placeholder2">Kealy Length</label>
        </div>
        <div class="trial1" id="pipelength">
            <input type="text" name='pipeline' placeholder="" class="input02">
            <label for="" class="placeholder2">Pipeline Length</label>
        </div>
        <div class="outer02" id="silos_container">
            <div class="trial1">
                <select name="silos_no" id="" class="input02">
                    <option value=""disabled selected>Silos No</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </div>
            <div class="trial1">
                <input type="text" name="cement_silos" placeholder="" class="input02">
                <label for="" class="placeholder2">Cement Silos No</label>
            </div>
            <div class="trial1">
                <input type="text" name="flyash_silos" placeholder="" class="input02">
                <label for="" class="placeholder2">Flyash Silos No</label>
            </div>

        </div>
        <div class="outer02" id="silos_qty_container">
        <div class="trial1">
                <input type="text" name="cement_silos_qty" placeholder="" class="input02">
                <label for="" class="placeholder2">Cement Silos Qty</label>
            </div>
            <div class="trial1">
                <input type="text" name="flyash_silos_qty" placeholder="" class="input02">
                <label for="" class="placeholder2">Flyash Silos Qty</label>
            </div>
                <div class="trial1">
                    <select name="chiller_available" id="" class="input02"> 
                        <option value=""disable selected>Chiller?</option>
                        <option value="Yes">Available</option>
                        <option value="No">Not Available</option>
                    </select>
                </div>

        </div>
        <div class="trial1">
            <input type="text" placeholder="" name="equipmentLocation" class="input02" required>
            <label for="" class="placeholder2">Equipment Location</label>
        </div>
        <div class="outer02">
        <div class="trial1">
            <!-- <input type="text" placeholder="" name="" class="input02">
            <label for="" class="placeholder2">Adblue</label> -->
            <select name="adblue" id="" class="input02">
                <option value=""disabled selected>Adblue?</option>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
            </select>
        </div>
        <div class="trial1">
        <select class="input02" id="currentstatusdd" name="status" required onchange="showclientname()">
            <option value="" disabled selected>Choose Current Status</option>
            <option value="Working">Working</option>
            <option value="Idle">Idle</option>
            <!-- <option value="Not in use">Not in use</option> -->
        </select>
        </div>
        </div>
        <div class="trial1" id="clientnamediv">
    <!-- Input field for autocomplete -->
     
    <input type="text" id="clientname" name="workingClient" class="input02" placeholder="Client Name" onkeyup="filterClients()" autocomplete="off">
    
    <!-- Div to show suggestions -->
    <div id="clientList" class="autocomplete-suggestions"></div>
</div>
<div class="trial1" id="newclientdiv">
    <!-- New client input, hidden initially -->
    <input type="text" id="newClient" name="workingNewClient" class="input02" style="display: none;" autocomplete="off">
    <label for="" class="placeholder2">New Client Name</label>
    </div>

    <?php 
    $existingclient = "SELECT * FROM `rentalclient_basicdetail` WHERE companyname='$companyname001' ORDER BY clientname ASC";
    $resultclient = mysqli_query($conn, $existingclient);

    // Collect client names into a PHP array
    $clientnames = [];
    if (mysqli_num_rows($resultclient) > 0) {
        while ($rowclient = mysqli_fetch_assoc($resultclient)) {
            $clientnames[] = $rowclient['clientname'];
        }
    }

    // Pass the client names to JavaScript
    echo "<script>var clientNames = " . json_encode($clientnames) . ";</script>";
    ?>
        <button type="SUBMIT" name="craneaddsubmit" class="crane-submit" >Add Fleet</button>
        
<br>
    </div> 

    </form>  

</div>


<div class="chart_outer_cont">
    <div class="chartcontainer">
    <div class="container1234" style="margin-top: 5px;">
        <div id="container" class="center-block">
        </div>
    </div>
    <?php
$sql_working_assets = "SELECT category, COUNT(*) AS working_asset_count 
FROM fleet1 
WHERE companyname='$companyname001' 
AND status='Working' 
GROUP BY category";
    $result02 = mysqli_query($conn, $sql_working_assets);
    ?>
    <table class="idle_table">
        <tr>
            <th> Working Assets</th>
        </tr>
        
        <?php
            while ($row = mysqli_fetch_assoc($result02)) {
                echo '<tr style="margin-top: 5px;">'; // Add top margin style to table rows
            echo '<td style="font-weight: 100;">'; // Add inline style for bold text
            // echo '➼ <b>Assetcode:</b> ' . $row['assetcode'];
            // echo '</td>';
            // echo '</tr>';
            echo '◍ '. $row["category"] . " - " . $row["working_asset_count"] . "<br>";
        }
        ?>
    </table>
    <?php
$sql_idle_assets = "SELECT category, COUNT(*) AS working_asset_count 
FROM fleet1 
WHERE companyname='$companyname001' 
AND status='Idle' 
GROUP BY category";
    $result_idle = mysqli_query($conn, $sql_idle_assets);
    ?>
    <table class="idle_table01">
        <tr>
            <th> Idle Assets</th>
        </tr>
        
        <?php
        while ($row = mysqli_fetch_assoc($result_idle)) {
            echo '<tr style="margin-top: 5px;">'; // Add top margin style to table rows
            echo '<td style="font-weight: 100;">'; // Add inline style for bold text
            echo '◍ '. $row["category"] . " - " . $row["working_asset_count"] . "<br>";
            echo '</td>';
            echo '</tr>';
        }
        ?>
    </table>
</div>   </div>

<div class="filters">
    <p>Apply Filter :</p>
    <form action="filterpreview.php" method="GET">
        <select name="filtertype" id="filterselect" class="filter_button" required>
            <option value="" disabled selected>Select Filter</option>
            <option value="Idle">Idle Equipment</option>
            <option value="Working">Working Equipment</option>
        </select>
        <button  class="filter_button" id="submitfilter">Submit</button>
    </form>
</div>

    <table class="members_table" id="members_tablecontent">
    <?php
    // Fetch fleet information
    $result = mysqli_query($conn, "SELECT * FROM fleet1 WHERE companyname='$companyname001' ORDER BY category, assetcode DESC");

    // Array to hold grouped fleet data
    $groupedFleet = array();

    // Group the results by fleet_category
    while ($row = mysqli_fetch_assoc($result)) {
        $category = $row['category'];
        if (!isset($groupedFleet[$category])) {
            $groupedFleet[$category] = array();
        }
        $groupedFleet[$category][] = $row;
    }

    // Display the grouped fleet data
    foreach ($groupedFleet as $category => $fleets) {
        echo '<tr><td ><h2 class="categoryheading">' . htmlspecialchars($category) . '</h2></td></tr>'; // Print the category heading
        
        $loop_count = 0; // Counter for items in the row
        echo '<tr>'; // Start a new row

        $categoryShortForms = array(
            'Aerial Work Platform' => 'AWP',
            'Concrete Equipment' => 'CE',
            'EarthMovers and Road Equipments' => 'EM',
            'Material Handling Equipments' => 'MHE',
            'Ground Engineering Equipments' => 'GEE',
            'Trailor and Truck' => 'T&T',
            'Generator and Lighting' => 'GL'
        );
        
        $loop_count = 0;
        foreach ($fleets as $row) {
            // Determine the short form based on the category
            $categoryShortForm = isset($categoryShortForms[$row['category']]) ? $categoryShortForms[$row['category']] : 'Unknown';
        
            if ($loop_count > 0 && $loop_count % 4 == 0) {
                echo '</tr><tr>'; // Close current row and start a new row
            }
            $anchorId = 'fleet_' . htmlspecialchars($row['snum']);
            echo '<td>';
            echo '<div class="viewfleet_outer" id="' . $anchorId . '">';
            echo '<div class="fleetcard">';
            // Print the category short form
            echo $categoryShortForm . '-' . htmlspecialchars($row['assetcode']);
        
            echo '</div>';
        
            echo '<div class="content">';
            echo '<p>‣ Assetcode: ' . htmlspecialchars($row['assetcode']) . '</p>';
            echo '<p>‣ Make: ' . htmlspecialchars($row['make']) . '</p>';
            echo '<p>‣ Model: ' . htmlspecialchars($row['model']) . '</p>';
            echo '<p>‣ Registration: ' . htmlspecialchars($row['registration']) . '</p>';
            echo '<p>‣ Operator: <a class="operator_fullinfo" href="explore_operator.php?id=' . htmlspecialchars($row['snum']) . '&fname=' . htmlspecialchars($row['operator_fname']) . '">' . htmlspecialchars($row['operator_fname']) . '</a></p>';
            echo '<p>‣ Status: <span class="fleet-status-label">' . htmlspecialchars($row['status']) . '</span></p>';
            // echo '<p>‣ Status button ex: ' . htmlspecialchars($row['status']) . '</p>';
            echo '</div>';
        
            echo '<div class="viewfleet2_btncontainer">';
            echo '<a href="edit_fleetnew.php?id=' . htmlspecialchars($row['snum']) . '">';
            echo '<i title="View & Edit" class="bi bi-pen"></i>';
            echo '</a>';
            echo '<a href="delete.php?id=' . htmlspecialchars($row['snum']) . '" onclick="return confirm(\'Are you sure you want to delete this?\');" >';
            echo '<i title="Delete" class="bi bi-trash"></i>';
            echo '</a>';
            echo '<a href="logsheet.php?id=' . htmlspecialchars($row['snum']) . '" ';
            echo '<i title="Generate Logsheet" class="bi bi-file-earmark-text"></i>';
            echo '</a>';
            echo '<a ' . (empty($row['loadchart']) ? 'hidden' : '') . ' href="img/' . htmlspecialchars($row['loadchart']) . '" target="_blank">';
            echo '<i title="View & Download Load Chart" class="bi bi-download"></i>';
            echo '</a>';
            // Add status toggle button
            $toggleTo = ($row['status'] === 'Idle') ? 'Working' : 'Idle';
            $toggleLabel = ($row['status'] === 'Idle') ? 'Set Working' : 'Set Idle';
            echo '<form method="POST" action="viewfleet2.php" style="display:inline;margin-left:8px;">';
            echo '<input type="hidden" name="fleet_snum" value="' . htmlspecialchars($row['snum']) . '">';
            echo '<input type="hidden" name="new_status" value="' . $toggleTo . '">';
            echo '<input type="hidden" name="anchor" value="' . $anchorId . '">';
            echo '<button type="submit" name="toggle_status" title="Toggle Status" style="background:none;border:none;cursor:pointer;padding:0;" onclick="return confirmStatusChange(event);">';
            echo ($row['status'] === 'Idle')
                ? '<i class="fa-solid fa-toggle-off" style="color:#888;font-size:1.3em;"></i>'
                : '<i class="fa-solid fa-toggle-on" style="color:#28a745;font-size:1.3em;"></i>';
            echo '</button>';
            echo '</form>';
            echo '</div>'; 
        
            echo '</div>'; // Close viewfleet_outer
            echo '</td>'; // Close table cell
            $loop_count++;
        }
        
        // Close the last row if it's not already closed
        if ($loop_count % 4 != 0) {
            echo '</tr>'; // Close the row if there are less than 4 items
        }}
        ?>
        </table>
    <div class="notification_background" id="notification_bg">
    <div class="noti_outer">
    <!-- <button>close all</button> -->
    <div class="closeall" onclick="close_all_notification('<?php echo $companyname001 ?>')"><i class="fa-solid fa-xmark cross_symbol"></i>  Close All</div>



<?php
while($row_noti_content = mysqli_fetch_assoc($result_noti) ){
    ?>
    <div class="noti_container">

        <div class="noti_content_main">
        <div class="content_holder">


        <?php 
echo $row_noti_content['document_expiring'] . " for Asset Code: " . $row_noti_content['asset_code'] . "<br>";
echo "Expires in " . $row_noti_content['days_left'] . " days" . "<br>";
?>
        </div>
<a onclick="del_notification(<?php echo $row_noti_content['sno']; ?>)" id="del_notification"><i class="fa-solid fa-xmark"></i></a>          


        </div>
    </div>
    
    <?php
}

?>
            </div>  
            </div> 

    <!-- JavaScript code for displaying the Highcharts pie chart -->
    <script>
// Filter the client names based on user input
function filterClients() {
    let input = document.getElementById('clientname').value.toLowerCase();
    let clientList = document.getElementById('clientList');
    let newClientInput = document.getElementById('newClient');
    let clientNameInput = document.getElementById('clientname');
    
    // Clear previous suggestions
    clientList.innerHTML = '';

    // Show suggestions only if user has typed at least 2 characters
    if (input.length >= 2) {
        // Filter client names based on user input
        let filteredClients = clientNames.filter(client => client.toLowerCase().includes(input));

        // If there are matches, show the list
        if (filteredClients.length > 0) {
            clientList.style.display = 'block';  // Show the suggestion list
            filteredClients.forEach(client => {
                let div = document.createElement('div');
                div.classList.add('autocomplete-item');
                div.textContent = client;

                // When an option is clicked, set it to the input field
                div.addEventListener('click', function () {
                    document.getElementById('clientname').value = client;
                    clientList.innerHTML = '';  // Clear suggestions after selection
                    clientList.style.display = 'none';  // Hide the suggestion list after selection
                    newClientInput.style.display = 'none'; // Hide the new client input field
                });

                clientList.appendChild(div);
            });
        } else {
            // If no matches, show a "no results" message and make the new client input visible
            clientList.style.display = 'block';
            clientList.innerHTML = '<div id="noClientFound" class="autocomplete-item" onclick="showNewClientInput()">No clients found</div>';
            newClientInput.style.display = 'none'; // Hide new input by default
        }
    } else {
        // If input length is less than 2, hide the suggestion list
        clientList.style.display = 'none';
        newClientInput.style.display = 'none'; // Hide new input field if nothing is typed
    }
}

// Show the new client input when "No clients found" is clicked
function showNewClientInput() {
    let clientNameInput = document.getElementById('clientname');
    let newClientInput = document.getElementById('newClient');
    let clientnamediv = document.getElementById('clientnamediv');
    let newclientdiv = document.getElementById('newclientdiv');

    // Hide the original client name input
    clientnamediv.style.display = 'none';

    // Show the new client input
    newclientdiv.style.display = 'block';

    newClientInput.style.display = 'block';

    // Clear the original input field as well
    clientNameInput.value = '';
}
</script>
<script src="main.js"></script>
</body>
</html>