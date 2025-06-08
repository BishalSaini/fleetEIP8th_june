<?php
include "partials/_dbconnect.php";
session_start();

$email = $_SESSION['email'];
$companyname001 = $_SESSION['companyname'];
$enterprise = $_SESSION['enterprise'];
$dashboard_url = '';

if ($enterprise === 'rental') {
    $dashboard_url = 'rental_dashboard.php';
} elseif ($enterprise === 'logistics') {
    $dashboard_url = 'logisticsdashboard.php';
} elseif ($enterprise === 'epc') {
    $dashboard_url = 'epc_dashboard.php';
} elseif ($enterprise === 'admin') {
    $dashboard_url = 'news/admin/dashboard.php';
}

$id = $_GET['id'];
$projectid = $_GET['projectid'];
$sql = "SELECT * FROM `linked_equipment` WHERE id='$id' AND projectid='$projectid' AND companyname='$companyname001'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$existing_filename = $row['wo']; // Fetch existing filename

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['projectinsightlinkequipment'])) {
    // Collect form data
    $project_name = $_POST['project_name'];
    $rental_companyname = $_POST['rental_companyname'];
    $fleet_category = $_POST['fleet_category'];
    $type = $_POST['type'];
    $make = $_POST['make'];
    $model = $_POST['model'];
    $yom = $_POST['yom'];
    $capacity = $_POST['capacity'];
    $unit = $_POST['unit'];
    $wo_start = $_POST['wo_start'];
    $wo_end = $_POST['wo_end'];
    $monthly_rental = $_POST['monthly_rental'];
    $mob = $_POST['mob'];
    $demob = $_POST['demob'];
    $shift = $_POST['shift'];
    $engine_hour = $_POST['engine_hour'];
    $workinghour = $_POST['workinghour'];
    $operator = $_POST['operator'];
    $helper = $_POST['helper'];
    $mob_recovery = $_POST['mob_recovery'];
    $demob_recovery = $_POST['demob_recovery'];
    $editid = $_POST['editid'];
    $linkequipmentprojectid = $_POST['linkequipmentprojectid'];
    $existingwo=$_POST['existingwo'];
    $reg=$_POST['reg'];
    $chassis_no=$_POST['chassis_no'];

    // Initialize filename to update
    $filename_to_update = $existingwo; // Default to existing filename

    // Handle file upload
    if (isset($_FILES['wo']) && $_FILES['wo']['error'] === UPLOAD_ERR_OK) {
        $wo = $_FILES['wo']['name'];
        $temp_file = $_FILES['wo']['tmp_name'];
        $folder3 = 'img/' . basename($wo); 

        move_uploaded_file($temp_file, $folder3);
            $filename_to_update = basename($wo); 
        
    } else {
        $filename_to_update = $existingwo;
    }

    // Update the database with the appropriate filename
    $sql = "UPDATE `linked_equipment` SET 
        `companyname` = '$companyname001', 
        `projectname` = '$project_name', 
        `projectid` = '$linkequipmentprojectid', 
        `rental_name` = '$rental_companyname', 
        `make` = '$make', 
        `model` = '$model', 
        `yom` = '$yom', 
        `wo_start` = '$wo_start', 
        `wo_end` = '$wo_end', 
        `monthly_rental` = '$monthly_rental', 
        `wo` = '$filename_to_update',  
        `category` = '$fleet_category', 
        `type` = '$type', 
        `cap` = '$capacity', 
        `unit` = '$unit', 
        `mob` = '$mob', 
        `demob` = '$demob', 
        `shift` = '$shift', 
        `working_hour` = '$workinghour', 
        `engine_hour` = '$engine_hour', 
        `operator` = '$operator', 
        `helper` = '$helper', 
        `mob_recovery` = '$mob_recovery', 
        `reg` = '$reg', 
        `chassis_no` = '$chassis_no', 
        `demob_recovery` = '$demob_recovery' 
        WHERE `id` = '$editid'";

    if (mysqli_query($conn, $sql)) {
        $_SESSION['success'] = 'Update successful!';
    } else {
        $_SESSION['error'] = 'Update failed: ' . mysqli_error($conn);
    }

    header("Location: projectinsight.php?id=" . urlencode($linkequipmentprojectid));
    exit();
}
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Equipment</title>
    <link rel="stylesheet" href="style.css">
    <script src="main.js"></script>
    <link rel="shortcut icon" href="favicon.jpg" type="image/x-icon">
</head>
<body>
<div class="navbar1">
    <div class="logo_fleet">
    <img src="logo_fe.png" alt="FLEET EIP" onclick="window.location.href='<?php echo $dashboard_url  ?>'">
</div>

        <div class="iconcontainer">
        <ul>
      <li><a href="<?php echo $dashboard_url ?>">Dashboard</a></li>
            <!-- <li><a href="news/">News</a></li> -->
    
        <li><a href="logout.php">Log Out</a></li></ul>
        </div>
    </div>
    <form action="viewhiredequipment.php" method="POST" autocomplete="off" class="outerform" enctype="multipart/form-data" id="">
<div class="linkequipmentinner">
    <p class="headingpara">Link Equipment</p>

    
    <input type="hidden" name="existingwo" value="<?php echo $existing_filename ;?>">
    <input type="hidden" name="linkequipmentprojectid" value="<?php echo $projectid ;?>">
    <div class="trial1">
        <input type="text" placeholder="" name="project_name" value="<?php echo $row['projectname'] ?>" class="input02" readonly>
        <label for="" class="placeholder2">Project Name</label>
    </div>
    <div class="trial1">
        <input type="text" id="autocomplete-input" placeholder="" value="<?php echo $row['rental_name'] ?>" name="rental_companyname" class="input02">
        <label for="" class="placeholder2">Rental Name</label>
        <div id="suggestions" class="suggestions"></div>

    </div> 
    <input type="hidden" name="editid" value="<?php echo $id; ?>">
    <div class="outer02">
        <div class="trial1">
        <select class="input02" name="fleet_category" id="oem_fleet_type" onchange="purchase_option()" required>
            <option value="" disabled selected>Select Fleet Category</option>
            <option <?php if($row['category'] === 'Aerial Work Platform') echo 'selected'; ?> value="Aerial Work Platform">Aerial Work Platform</option>
<option <?php if($row['category'] === 'Concrete Equipment') echo 'selected'; ?> value="Concrete Equipment">Concrete Equipment</option>
<option <?php if($row['category'] === 'EarthMovers and Road Equipments') echo 'selected'; ?> value="EarthMovers and Road Equipments">EarthMovers and Road Equipments</option>
<option <?php if($row['category'] === 'Ground Engineering Equipments') echo 'selected'; ?> value="Ground Engineering Equipments">Ground Engineering Equipments</option>
<option <?php if($row['category'] === 'Trailor and Truck') echo 'selected'; ?> value="Trailor and Truck">Trailor and Truck</option>
<option <?php if($row['category'] === 'Generator and Lighting') echo 'selected'; ?> value="Generator and Lighting">Generator and Lighting</option>
        </select>
        </div>
        <div class="trial1">
        <select class="input02" name="type" id="fleet_sub_type" onchange="crawler_options()" required>
            <option value="" disabled selected>Select Fleet Type</option>
            <option <?php if($row['type'] === 'Self Propelled Articulated Boomlift') echo 'selected'; ?> value="Self Propelled Articulated Boomlift" class="awp_options" id="aerial_work_platform_option1">Self Propelled Articulated Boomlift</option>
<option <?php if($row['type'] === 'Scissor Lift Diesel') echo 'selected'; ?> value="Scissor Lift Diesel" class="awp_options" id="aerial_work_platform_option2">Scissor Lift Diesel</option>
<option <?php if($row['type'] === 'Scissor Lift Electric') echo 'selected'; ?> value="Scissor Lift Electric" class="awp_options" id="aerial_work_platform_option3">Scissor Lift Electric</option>
<option <?php if($row['type'] === 'Spider Lift') echo 'selected'; ?> value="Spider Lift" class="awp_options" id="aerial_work_platform_option4">Spider Lift</option>
<option <?php if($row['type'] === 'Self Propelled Straight Boomlift') echo 'selected'; ?> value="Self Propelled Straight Boomlift" class="awp_options" id="aerial_work_platform_option5">Self Propelled Straight Boomlift</option>
<option <?php if($row['type'] === 'Truck Mounted Articulated Boomlift') echo 'selected'; ?> value="Truck Mounted Articulated Boomlift" class="awp_options" id="aerial_work_platform_option6">Truck Mounted Articulated Boomlift</option>
<option <?php if($row['type'] === 'Truck Mounted Straight Boomlift') echo 'selected'; ?> value="Truck Mounted Straight Boomlift" class="awp_options" id="aerial_work_platform_option7">Truck Mounted Straight Boomlift</option>

<option <?php if($row['type'] === 'Batching Plant') echo 'selected'; ?> value="Batching Plant" class="cq_options" id="concrete_equipment_option1">Batching Plant</option>
<option <?php if($row['type'] === 'Self Loading Mixer') echo 'selected'; ?> value="Self Loading Mixer" class="cq_options" id="">Self Loading Mixer</option>
<option <?php if($row['type'] === 'Concrete Boom Placer') echo 'selected'; ?> value="Concrete Boom Placer" class="cq_options" id="concrete_equipment_option2">Concrete Boom Placer</option>
<option <?php if($row['type'] === 'Concrete Pump') echo 'selected'; ?> value="Concrete Pump" class="cq_options" id="concrete_equipment_option3">Concrete Pump</option>
<option <?php if($row['type'] === 'Moli Pump') echo 'selected'; ?> value="Moli Pump" class="cq_options" id="concrete_equipment_option4">Moli Pump</option>
<option <?php if($row['type'] === 'Mobile Batching Plant') echo 'selected'; ?> value="Mobile Batching Plant" class="cq_options" id="concrete_equipment_option5">Mobile Batching Plant</option>
<option <?php if($row['type'] === 'Static Boom Placer') echo 'selected'; ?> value="Static Boom Placer" class="cq_options" id="concrete_equipment_option6">Static Boom Placer</option>
<option <?php if($row['type'] === 'Transit Mixer') echo 'selected'; ?> value="Transit Mixer" class="cq_options" id="concrete_equipment_option7">Transit Mixer</option>

<option <?php if($row['type'] === 'Baby Roller') echo 'selected'; ?> value="Baby Roller" class="earthmover_options" id="earthmovers_option1">Baby Roller</option>
<option <?php if($row['type'] === 'Backhoe Loader') echo 'selected'; ?> value="Backhoe Loader" class="earthmover_options" id="earthmovers_option2">Backhoe Loader</option>
<option <?php if($row['type'] === 'Bulldozer') echo 'selected'; ?> value="Bulldozer" class="earthmover_options" id="earthmovers_option3">Bulldozer</option>
<option <?php if($row['type'] === 'Excavator') echo 'selected'; ?> value="Excavator" class="earthmover_options" id="earthmovers_option4">Excavator</option>
<option <?php if($row['type'] === 'Milling Machine') echo 'selected'; ?> value="Milling Machine" class="earthmover_options" id="earthmovers_option5">Milling Machine</option>
<option <?php if($row['type'] === 'Motor Grader') echo 'selected'; ?> value="Motor Grader" class="earthmover_options" id="earthmovers_option6">Motor Grader</option>
<option <?php if($row['type'] === 'Pneumatic Tyre Roller') echo 'selected'; ?> value="Pneumatic Tyre Roller" class="earthmover_options" id="earthmovers_option7">Pneumatic Tyre Roller</option>
<option <?php if($row['type'] === 'Single Drum Roller') echo 'selected'; ?> value="Single Drum Roller" class="earthmover_options" id="earthmovers_option8">Single Drum Roller</option>
<option <?php if($row['type'] === 'Skid Loader') echo 'selected'; ?> value="Skid Loader" class="earthmover_options" id="earthmovers_option9">Skid Loader</option>
<option <?php if($row['type'] === 'Slip Form Paver') echo 'selected'; ?> value="Slip Form Paver" class="earthmover_options" id="earthmovers_option10">Slip Form Paver</option>
<option <?php if($row['type'] === 'Soil Compactor') echo 'selected'; ?> value="Soil Compactor" class="earthmover_options" id="earthmovers_option11">Soil Compactor</option>
<option <?php if($row['type'] === 'Tandem Roller') echo 'selected'; ?> value="Tandem Roller" class="earthmover_options" id="earthmovers_option12">Tandem Roller</option>
<option <?php if($row['type'] === 'Vibratory Roller') echo 'selected'; ?> value="Vibratory Roller" class="earthmover_options" id="earthmovers_option13">Vibratory Roller</option>
<option <?php if($row['type'] === 'Wheeled Excavator') echo 'selected'; ?> value="Wheeled Excavator" class="earthmover_options" id="earthmovers_option14">Wheeled Excavator</option>
<option <?php if($row['type'] === 'Wheeled Loader') echo 'selected'; ?> value="Wheeled Loader" class="earthmover_options" id="earthmovers_option15">Wheeled Loader</option>

<option <?php if($row['type'] === 'Fixed Tower Crane') echo 'selected'; ?> id="mhe_option1" class="mhe_options" value="Fixed Tower Crane">Fixed Tower Crane</option>
<option <?php if($row['type'] === 'Fork Lift Diesel') echo 'selected'; ?> id="mhe_option2" class="mhe_options" value="Fork Lift Diesel">Fork Lift Diesel</option>
<option <?php if($row['type'] === 'Fork Lift Electric') echo 'selected'; ?> id="mhe_option3" class="mhe_options" value="Fork Lift Electric">Fork Lift Electric</option>
<option <?php if($row['type'] === 'Hammerhead Tower Crane') echo 'selected'; ?> id="mhe_option4" class="mhe_options" value="Hammerhead Tower Crane">Hammerhead Tower Crane</option>
<option <?php if($row['type'] === 'Hydraulic Crawler Crane') echo 'selected'; ?> id="mhe_option5" class="mhe_options" value="Hydraulic Crawler Crane">Hydraulic Crawler Crane</option>
<option <?php if($row['type'] === 'Luffing Jib Tower Crane') echo 'selected'; ?> id="mhe_option6" class="mhe_options" value="Luffing Jib Tower Crane">Luffing Jib Tower Crane</option>
<option <?php if($row['type'] === 'Mechanical Crawler Crane') echo 'selected'; ?> id="mhe_option7" class="mhe_options" value="Mechanical Crawler Crane">Mechanical Crawler Crane</option>
<option <?php if($row['type'] === 'Pick and Carry Crane') echo 'selected'; ?> id="mhe_option8" class="mhe_options" value="Pick and Carry Crane">Pick and Carry Crane</option>
<option <?php if($row['type'] === 'Reach Stacker') echo 'selected'; ?> id="mhe_option9" class="mhe_options" value="Reach Stacker">Reach Stacker</option>
<option <?php if($row['type'] === 'Rough Terrain Crane') echo 'selected'; ?> id="mhe_option10" class="mhe_options" value="Rough Terrain Crane">Rough Terrain Crane</option>
<option <?php if($row['type'] === 'Telehandler') echo 'selected'; ?> id="mhe_option11" class="mhe_options" value="Telehandler">Telehandler</option>
<option <?php if($row['type'] === 'Telescopic Crawler Crane') echo 'selected'; ?> id="mhe_option12" class="mhe_options" value="Telescopic Crawler Crane">Telescopic Crawler Crane</option>
<option <?php if($row['type'] === 'Telescopic Mobile Crane') echo 'selected'; ?> id="mhe_option13" class="mhe_options" value="Telescopic Mobile Crane">Telescopic Mobile Crane</option>
<option <?php if($row['type'] === 'All Terrain Mobile Crane') echo 'selected'; ?> id="mhe_option14" class="mhe_options" value="All Terrain Mobile Crane">All Terrain Mobile Crane</option>
<option <?php if($row['type'] === 'Self Loading Truck Crane') echo 'selected'; ?> id="mhe_option15" class="mhe_options" value="Self Loading Truck Crane">Self Loading Truck Crane</option>

<option <?php if($row['type'] === 'Hydraulic Drilling Rig') echo 'selected'; ?> id="ground_engineering_equipment_option1" class="gee_options" value="Hydraulic Drilling Rig">Hydraulic Drilling Rig</option>
<option <?php if($row['type'] === 'Rotary Drilling Rig') echo 'selected'; ?> id="ground_engineering_equipment_option2" class="gee_options" value="Rotary Drilling Rig">Rotary Drilling Rig</option>
<option <?php if($row['type'] === 'Vibro Hammer') echo 'selected'; ?> id="ground_engineering_equipment_option3" class="gee_options" value="Vibro Hammer">Vibro Hammer</option>

<option <?php if($row['type'] === 'Dumper') echo 'selected'; ?> id="trailor_option1" class="trailor_options" value="Dumper">Dumper</option>
<option <?php if($row['type'] === 'Truck') echo 'selected'; ?> id="trailor_option2" class="trailor_options" value="Truck">Truck</option>
<option <?php if($row['type'] === 'Water Tanker') echo 'selected'; ?> id="trailor_option3" class="trailor_options" value="Water Tanker">Water Tanker</option>
<option <?php if($row['type'] === 'Low Bed') echo 'selected'; ?> id="trailor_option4" class="trailor_options" value="Low Bed">Low Bed</option>
<option <?php if($row['type'] === 'Semi Low Bed') echo 'selected'; ?> id="trailor_option5" class="trailor_options" value="Semi Low Bed">Semi Low Bed</option>
<option <?php if($row['type'] === 'Flatbed') echo 'selected'; ?> id="trailor_option6" class="trailor_options" value="Flatbed">Flatbed</option>
<option <?php if($row['type'] === 'Hydraulic Axle') echo 'selected'; ?> id="trailor_option7" class="trailor_options" value="Hydraulic Axle">Hydraulic Axle</option>

<option <?php if($row['type'] === 'Silent Diesel Generator') echo 'selected'; ?> id="generator_option1" class="generator_options" value="Silent Diesel Generator">Silent Diesel Generator</option>
<option <?php if($row['type'] === 'Mobile Light Tower') echo 'selected'; ?> id="generator_option2" class="generator_options" value="Mobile Light Tower">Mobile Light Tower</option>
<option <?php if($row['type'] === 'Diesel Generator') echo 'selected'; ?> id="generator_option3" class="generator_options" value="Diesel Generator">Diesel Generator</option>
        </select>
        </div>
    </div>


    <div class="outer02">
        <div class="trial1">
            <input type="text" name="make" value="<?php echo $row['make'] ?>" placeholder="" class="input02">
            <label for="" class="placeholder2">Equipment Make</label>
        </div>
        <div class="trial1">
            <input type="text" name="model" value="<?php echo $row['model'] ?>" placeholder="" class="input02">
            <label for="" class="placeholder2">Model</label>
        </div>
    

    </div>
    <div class="outer02">
    <div class="trial1">
            <input type="month" name="yom" value="<?php echo $row['yom'] ?>" placeholder="" class="input02">
            <label for="" class="placeholder2">YOM</label>
        </div>
        <div class="trial1">
            <input type="number" name="capacity" value="<?php echo $row['cap'] ?>" placeholder="" class="input02">
            <label for="" class="placeholder2">Capacity</label>
        </div>
        <select name="unit" id="projectinsightunit" class="input02">
                <option value=""disabled selected>Unit</option>
                <option <?php if($row['unit']==='Ton'){echo 'selected';} ?> value="Ton">Ton</option>
                <option <?php if($row['unit']==='Kgs'){echo 'selected';} ?> value="Kgs">Kgs</option>
                <option <?php if($row['unit']==='KnM'){echo 'selected';} ?> value="KnM">KnM</option>
                <option <?php if($row['unit']==='Meter'){echo 'selected';} ?> value="Meter">Meter</option>
                <option <?php if($row['unit']==='M³'){echo 'selected';} ?> value="M³">M³</option>
            </select>


    </div>
        <div class="outer02">
            <div class="trial1">
                <input type="date" placeholder="" value="<?php echo $row['wo_start'] ?>" name="wo_start" class="input02">
                <label for="" class="placeholder2">Work Order Start Date</label>
            </div>
            <div class="trial1">
                <input type="date" placeholder="" value="<?php echo $row['wo_end'] ?>" name="wo_end" class="input02">
                <label for="" class="placeholder2">Work Order End Date</label>
            </div>
        </div>
    <div class="outer02">
    <div class="trial1">
            <input type="text" placeholder="" value="<?php echo $row['monthly_rental'] ?>" name="monthly_rental" class="input02">
            <label for="" class="placeholder2">Monthly Rental</label>
        </div>
        <div class="trial1">
            <input type="text" placeholder="" value="<?php echo $row['mob'] ?>" name="mob" class="input02">
            <label for="" class="placeholder2">MOB</label>
        </div>
        <div class="trial1">
            <input type="text" placeholder="" value="<?php echo $row['demob'] ?>" name="demob" class="input02">
            <label for="" class="placeholder2">DeMOB</label>
        </div>


    </div>
    <div class="outer02">
        <select name="shift" id="projectinsightshiftdd" class="input02" onchange="projectinsightshift()">
            <option value=""disabled selected>Working Shift</option>
            <option <?php if($row['shift']==='Single Shift'){echo 'selected';} ?> value="Single Shift">Single Shift</option>
            <option <?php if($row['shift']==='Double Shift'){echo 'selected';} ?> value="Double Shift">Double Shift</option>
            <option <?php if($row['shift']==='Flexi Shift'){echo 'selected';} ?> value="Flexi Shift">Flexi Shift</option>
            </select>
        <select name="engine_hour" id="projectinsightenginehour" class="input02">
            <option value=""disabled selected>Engine Hours</option>
            <option <?php if($row['engine_hours']==='200'){echo 'selected';} ?> value="200">Engine Hours: 200 Hours</option>
            <option <?php if($row['engine_hours']==='208'){echo 'selected';} ?> value="208">Engine Hours: 208 Hours</option>
            <option <?php if($row['engine_hours']==='260'){echo 'selected';} ?> value="260">Engine Hours: 260 Hours</option>
            <option <?php if($row['engine_hours']==='270'){echo 'selected';} ?> value="270">Engine Hours: 270 Hours</option>
            <option <?php if($row['engine_hours']==='280'){echo 'selected';} ?> value="280">Engine Hours: 280 Hours</option>
            <option <?php if($row['engine_hours']==='300'){echo 'selected';} ?> value="300">Engine Hours: 300 Hours</option>
            <option <?php if($row['engine_hours']==='312'){echo 'selected';} ?> value="312">Engine Hours: 312 Hours</option>
            <option <?php if($row['engine_hours']==='360'){echo 'selected';} ?> value="360">Engine Hours: 360 Hours</option>
            <option <?php if($row['engine_hours']==='400'){echo 'selected';} ?> value="400">Engine Hours: 400 Hours</option>
            <option <?php if($row['engine_hours']==='416'){echo 'selected';} ?> value="416">Engine Hours: 416 Hours</option>
            <option <?php if($row['engine_hours']==='460'){echo 'selected';} ?> value="460">Engine Hours: 460 Hours</option>
            <option <?php if($row['engine_hours']==='572'){echo 'selected';} ?> value="572">Engine Hours: 572 Hours</option>
            <option <?php if($row['engine_hours']==='672'){echo 'selected';} ?> value="672">Engine Hours: 672 Hours</option>
            <option <?php if($row['engine_hours']==='720'){echo 'selected';} ?> value="720">Engine Hours: 720 Hours</option>
        </select>
        <select name="workinghour" id="projectinsightworkinghour" class="input02">
                    <option value=""disabled selected>Working Hours</option>
                <option value="8">8 Hours</option>
                <option <?php if($row['working_hour']==='10'){echo 'selected';} ?> value="10">10 Hours</option>
                <option <?php if($row['working_hour']==='12'){echo 'selected';} ?> value="12">12 Hours</option>
                <option <?php if($row['working_hour']==='14'){echo 'selected';} ?> value="14">14 Hours</option>
                <option <?php if($row['working_hour']==='16'){echo 'selected';} ?> value="16">16 Hours</option>

                </select>

    </div>
    <div class="outer02">
        <select name="operator" id="" class="input02">
            <option value=""disabled selected>Operator Count</option>
            <option <?php if($row['operator']==='Not Applicable'){echo 'selected';} ?> value="Not Applicable">Not Applicable</option>
            <option <?php if($row['operator']==='1'){echo 'selected';} ?> value="1">1 Operator</option>
            <option <?php if($row['operator']==='2'){echo 'selected';} ?> value="2">2 Operator</option>
            <option <?php if($row['operator']==='3'){echo 'selected';} ?> value="3">3 Operator</option>
        </select>
        <select name="helper" id="" class="input02">
            <option value=""disabled selected>Helper Count</option>
            <option <?php if($row['helper']==='Not Applicable'){echo 'selected';} ?> value="Not Applicable">Not Applicable</option>
            <option <?php if($row['helper']==='1'){echo 'selected';} ?> value="1">1 Helper</option>
            <option <?php if($row['helper']==='2'){echo 'selected';} ?> value="2">2 Helper</option>
            <option <?php if($row['helper']==='3'){echo 'selected';} ?> value="3">3 Helper</option>
        </select>
    </div>
    <div class="outer02">
            <select name="mob_recovery" id="" class="input02">
                <option value=""disabled selected>Mobilisation recovery</option>
                <option <?php if($row['mob_recovery']==='Not Applicable'){echo 'selected';} ?> value="Not Applicable">Mob Recovery : Not Applicable</option>
                <option <?php if($row['mob_recovery']==='3 Months'){echo 'selected';} ?> value="3 Months">Mob Recovery : 3 Months</option>
                <option <?php if($row['mob_recovery']==='6 Months'){echo 'selected';} ?> value="6 Months">Mob Recovery : 6 Months</option>
                <option <?php if($row['mob_recovery']==='9 Months'){echo 'selected';} ?> value="9 Months">Mob Recovery : 9 Months</option>
                <option <?php if($row['mob_recovery']==='12 Months'){echo 'selected';} ?> value="12 Months">Mob Recovery : 12 Months</option>
            </select>
            <select name="demob_recovery" id="" class="input02">
                <option value=""disabled selected>Demobilisation recovery</option>
                <option <?php if($row['demob_recovery']==='Not Applicable'){echo 'selected';} ?> value="Not Applicable">DeMob Recovery : Not Applicable</option>
                <option <?php if($row['demob_recovery']==='3 Months'){echo 'selected';} ?>  value="3 Months">DeMob Recovery : 3 Months</option>
                <option <?php if($row['demob_recovery']==='6 Months'){echo 'selected';} ?>  value="6 Months">DeMob Recovery : 6 Months</option>
                <option <?php if($row['demob_recovery']==='9 Months'){echo 'selected';} ?>  value="9 Months">DeMob Recovery : 9 Months</option>
                <option <?php if($row['demob_recovery']==='12 Months'){echo 'selected';} ?>  value="12 Months">DeMob Recovery : 12 Months</option>
            </select>
        </div>
        <div class="trial1 <?php if(empty($row['reg'])){echo 'hideit';} ?>" >
        <input type="text" placeholder="" value="<?php echo $row['reg'] ?>" name="reg" class="input02">
        <label for="" class="placeholder2">Registration Number</label>
    </div>
    <div class="trial1 <?php if(empty($row['chassis_no'])){echo 'hideit';} ?>" >
        <input type="text" placeholder=""  value="<?php echo $row['chassis_no'] ?>" name="chassis_no" class="input02">
        <label for="" class="placeholder2">Chassis Number</label>
    </div>

        <div class="trial1">
            <input type="file" name="wo" value="" placeholder="" class="input02">
            <?php if (!empty($existing_filename)): ?>
        <p class="terms_condition">Current File: <?php echo htmlspecialchars($existing_filename); ?></p>
    <?php endif; ?>
            <label for="" class="placeholder2">Upload Work Order</label>
        </div>
    <button class="epc-button" name="projectinsightlinkequipment">Submit</button>
</div>
</form>





</body>
<script>
    document.addEventListener('DOMContentLoaded', function() {
    // Check if oem_fleet_type7 is not empty and call seco_equip_2()
    var projectinsightshiftdd = document.getElementById('projectinsightshiftdd');
    if (projectinsightshiftdd.value !== '') {
        projectinsightshift();
    }
});

</script>
</html>