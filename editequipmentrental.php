<?php
session_start();
$showAlert=false;
$showError=false;
// $email = $_SESSION["email"];
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
elseif ($enterprise === 'admin') {
    $dashboard_url = 'news/admin/dashboard.php';
} 


else {
    $dashboard_url = '';
}

if(isset($_SESSION['success'])){
    $showAlert=true;
    unset($_SESSION['success']);
}
else if(isset($_SESSION['error'])){
    $showError=true;
    unset($_SESSION['error']);
}

include 'partials/_dbconnect.php';

$id=$_GET['id'];
$sql_epc="SELECT * FROM  `req_by_epc` WHERE id='$id'";
$result=mysqli_query($conn,$sql_epc);
$row=mysqli_fetch_assoc($result);

if(isset($_GET['projectid'])){
    $projectid=$_GET['projectid'];
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include "partials/_dbconnect.php";

    $project_code = $_POST['project_code'];
    $project_type = $_POST['project_type'];
    $tentative_date = $_POST['tentative_date'];
    $fleet_category = $_POST['fleet_category'];
    $type = $_POST['type'];
    $equipment_capacity = $_POST['equipment_capacity'];
    $boom_combination = $_POST['boom_combination'];
    $working_shift = $_POST['working_shift'];
    $fuel_scope = $_POST['fuel_scope'];
    $accomodation_scope = $_POST['accomodation_scope'];
    $duration_month = $_POST['duration_month'];
    $state = $_POST['state'];
    $district = $_POST['district'];
    $engine_hour = $_POST['engine_hour'];
    $contact_person = $_POST['contact_person'];
    $epc_number = $_POST['epc_number'];
    $notes = $_POST['notes'];
    $unit = $_POST['unit'];
    $editid = $_POST['editid'];



    $reqvalid=$_POST['reqvalid'];
    $working_days=$_POST['working_days'];
    $adbluescope=$_POST['adbluescope'];
    $demob_recovery=$_POST['demob_recovery'];
    $mob_recovery=$_POST['mob_recovery'];
    $advance=$_POST['advance'];
    $advfor=$_POST['advfor'];
    $creditterm=$_POST['creditterm'];

    $epc_email=$_POST['epc_email'];
    

    $sql_edit = "UPDATE `req_by_epc` SET 
        `equipment_type` = '$type',
        `epc_email` = '$epc_email',
        `equipment_capacity` = '$equipment_capacity',
        `boom_combination` = '$boom_combination',
        `project_type` = '$project_type',
        `duration_month` = '$duration_month',
        `state` = '$state',
        `district` = '$district',
        `working_shift` = '$working_shift',
        `tentative_date` = '$tentative_date',
        `epc_number` = '$epc_number',
        `fleet_category` = '$fleet_category',
        `contact_person` = '$contact_person',
        `engine_hour` = '$engine_hour',
        `notes` = '$notes',
        `unit` = '$unit',
        `project_code` = '$project_code',
        `fuel_scope` = '$fuel_scope',
        `accomodation_scope` = '$accomodation_scope' ,
        `reqvalid`='$reqvalid',
        `working_days`='$working_days',`adblue_scope`='$adbluescope',
        `mobilisation_recovery`='$mob_recovery',`demobilisation_recovery`='$demob_recovery',
        `advance`='$advance',`adv_for`='$advfor',`credit_term`='$creditterm'
        WHERE id = '$editid'";

    $edit_result = mysqli_query($conn, $sql_edit);

    if ($edit_result) {
        session_start();
        $_SESSION['success']='success';
        header("Location:editequipmentrental.php?id=" .urldecode($editid));

    } 
    else {
        session_start();
        $_SESSION['error']='success';
        header("Location:editequipmentrental.php?id=" .urldecode($editid));
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">      <link rel="icon" href="favicon.jpg" type="image/x-icon">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="tiles.css">
    <script src="main.js"defer></script>
    <title>Requirement</title>
</head>
<body>
    <div class="navbar1">
    <div class="logo_fleet">
    <img src="logo_fe.png" alt="FLEET EIP" onclick="window.location.href='<?php echo $dashboard_url  ?>'">
</div>

        <div class="iconcontainer">
        <ul>
            <li><a href="<?php echo $dashboard_url ?>">Dashboard</a></li>
            <li><a href="view_news_epc.php">News</a></li>
            
            <li><a href="logout.php">Log Out</a></li></ul>
        </div>
    </div> 
    <?php
if ($showAlert) {
    echo  '<label>
    <input type="checkbox" class="alertCheckbox" autocomplete="off" />
    <div class="alert notice">
      <span class="alertClose">X</span>
      <span class="alertText_addfleet"><b>Success! 
          <br class="clear"/></span>
    </div>
  </label>';
}
if ($showError) {
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

<!-- <div class="add_fleet_btn_new"  id="view_quotesadmin">
<button class="generate-btn"> 
    <article class="article-wrapper" id="viewquotesadminbutton" onclick="window.location.href='viewquotesepc.php?id=<?php echo $id; ?>'" > 
  <div class="rounded-lg container-projectss ">
    </div>
    <div class="project-info">
      <div class="flex-pr">
        <div class="project-title text-nowrap">View Quotes</div>
          <div class="project-hover">
            <svg style="color: black;" xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" color="black" stroke-linejoin="round" stroke-linecap="round" viewBox="0 0 24 24" stroke-width="2" fill="none" stroke="currentColor"><line y2="12" x2="19" y1="12" x1="5"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
            </div>
          </div>
          <div class="types">
        </div>
    </div>
</article>
    </button>

</div> -->


    <form action="editequipmentrental.php" method="POST" class="epc_req1" autocomplete="off">
    <div class="epc_red_div" id="adminpanelepcreq">
        <p class="headingpara">Edit Requirement</p>
        <!-- <div class="epc_req_heading"><h2>View/Edit Your Requirement</h2></div> -->
        <div class="trial1 hideit">
                <input type="text" class="input02" name="epc_name" value="<?php echo $row['epc_name'] ?>" placeholder="" >
                <label for="" class="placeholder2">Company Name</label>
            </div>
        <div class="trial1">
                <input type="text" class="input02" name="contact_person" value="<?php echo $row['contact_person'] ?>" placeholder="" >
                <label for="" class="placeholder2">Contact Person</label>
            </div>

        <div class="outer02">
            <div class="trial1">
                <input type="text" class="input02" name="epc_email" value="<?php echo $row['epc_email'] ?>" placeholder="" >
                <label for="" class="placeholder2">Email</label>
            </div>
            <div class="trial1">
                <input type="text" class="input02" name="epc_number" value="<?php echo $row['epc_number'] ?>" placeholder="" >
                <label for="" class="placeholder2">Contact Number</label>
            </div>
           
        </div>

        <div class="outer02">
        <div class="trial1 <?php if (empty($row['project_code'])) { echo 'hideit'; } ?>">
        <input type="text" placeholder="" value="<?php echo $row['project_code'] ?>" name="project_code" class="input02" >
                <label for="" class="placeholder2">Project Code</label>
            </div>
            <input type="hidden" name="editid" value="<?php echo $id; ?>">
<div class="trial1">
<select class="input02" name="project_type" id="">
            <option value="" disabled selected>Choose Project Type</option>
            <option <?php if($row['project_type']==='Urban Infra'){ echo 'selected';} ?> value="Urban Infra">Project Type: Urban Infra</option>
            <option <?php if($row['project_type']==='PipeLine'){ echo 'selected';} ?> value="PipeLine">Project Type: PipeLine</option>
            <option <?php if($row['project_type']==='Marine'){ echo 'selected';} ?> value="Marine">Project Type: Marine</option>
            <option <?php if($row['project_type']==='Road'){ echo 'selected';} ?> value="Road">Project Type: Road</option>
            <option <?php if($row['project_type']==='Bridge And Metro'){ echo 'selected';} ?> value="Bridge And Metro">Project Type: Bridge And Metro</option>
            <option <?php if($row['project_type']==='Plant'){ echo 'selected';} ?> value="Plant">Project Type: Plant</option>
            <option <?php if($row['project_type']==='Refinery'){ echo 'selected';} ?> value="Refinery">Project Type: Refinery</option>
            <option <?php if($row['project_type']==='Others'){ echo 'selected';} ?> value="Others">Project Type: Others</option>
        </select>
    <!-- <input type="text" placeholder="" value="<?php echo $row['project_type'] ?>" name="" class="input02" >
    <label for="" class="placeholder2">Project Type</label> -->
</div>
<div class="trial1">
    <input type="date" placeholder="" name="tentative_date" value="<?php echo $row['tentative_date'] ?>" class="input02" >
    <label for="" class="placeholder2">Required At Site</label>
</div>
<div class="trial1">
    <input type="date" placeholder="" name="reqvalid" value="<?php echo $row['reqvalid'] ?>" class="input02" >
    <label for="" class="placeholder2">Valid Till</label>
</div>
        </div>
        <div class="outer02">
            <div class="trial1">
                <!-- <input type="text" placeholder="" value="<?php echo $row['fleet_category'] ?>" class="input02" >
                <label for="" class="placeholder2">Equipment Category</label> -->
                <select class="input02" name="fleet_category" id="oem_fleet_type" onchange="purchase_option()" required>
            <option value="" disabled selected>Select Fleet Category</option>
            <option <?php if($row['fleet_category']==='Aerial Work Platform'){ echo 'selected';} ?> value="Aerial Work Platform">Aerial Work Platform</option>
            <option <?php if($row['fleet_category']==='Concrete Equipment'){ echo 'selected';} ?> value="Concrete Equipment">Concrete Equipment</option>
            <option <?php if($row['fleet_category']==='EarthMovers and Road Equipments'){ echo 'selected';} ?> value="EarthMovers and Road Equipments">EarthMovers and Road Equipments</option>
            <option <?php if($row['fleet_category']==='Material Handling Equipments'){ echo 'selected';} ?> value="Material Handling Equipments">Material Handling Equipments</option>
            <option <?php if($row['fleet_category']==='Ground Engineering Equipments'){ echo 'selected';} ?> value="Ground Engineering Equipments">Ground Engineering Equipments</option>
            <option <?php if($row['fleet_category']==='Trailor and Truck'){ echo 'selected';} ?> value="Trailor and Truck">Trailor and Truck</option>
            <option <?php if($row['fleet_category']==='Generator and Lighting'){ echo 'selected';} ?> value="Generator and Lighting">Generator and Lighting</option>
        </select>

            </div>
            <div class="trial1">
                <!-- <input type="text" placeholder="" value="<?php echo $row['equipment_type'] ?>" class="input02" >
                <label for="" class="placeholder2">Equipment Type</label> -->
                <select class="input02" name="type" id="fleet_sub_type" onchange="crawler_options()" required>
            <option value="" disabled selected>Select Fleet Type</option>
            <option <?php if($row['equipment_type'] === 'Self Propelled Articulated Boomlift') echo 'selected'; ?> value="Self Propelled Articulated Boomlift" class="awp_options">Self Propelled Articulated Boomlift</option>
    <option <?php if($row['equipment_type'] === 'Scissor Lift Diesel') echo 'selected'; ?> value="Scissor Lift Diesel" class="awp_options">Scissor Lift Diesel</option>
    <option <?php if($row['equipment_type'] === 'Scissor Lift Electric') echo 'selected'; ?> value="Scissor Lift Electric" class="awp_options">Scissor Lift Electric</option>
    <option <?php if($row['equipment_type'] === 'Spider Lift') echo 'selected'; ?> value="Spider Lift" class="awp_options">Spider Lift</option>
    <option <?php if($row['equipment_type'] === 'Self Propelled Straight Boomlift') echo 'selected'; ?> value="Self Propelled Straight Boomlift" class="awp_options">Self Propelled Straight Boomlift</option>
    <option <?php if($row['equipment_type'] === 'Truck Mounted Articulated Boomlift') echo 'selected'; ?> value="Truck Mounted Articulated Boomlift" class="awp_options">Truck Mounted Articulated Boomlift</option>
    <option <?php if($row['equipment_type'] === 'Truck Mounted Straight Boomlift') echo 'selected'; ?> value="Truck Mounted Straight Boomlift" class="awp_options">Truck Mounted Straight Boomlift</option>

    <!-- Concrete Equipment -->
    <option <?php if($row['equipment_type'] === 'Batching Plant') echo 'selected'; ?> value="Batching Plant" class="cq_options">Batching Plant</option>
    <option <?php if($row['equipment_type'] === 'Self Loading Mixer') echo 'selected'; ?> value="Self Loading Mixer" class="cq_options">Self Loading Mixer</option>
    <option <?php if($row['equipment_type'] === 'Concrete Boom Placer') echo 'selected'; ?> value="Concrete Boom Placer" class="cq_options">Concrete Boom Placer</option>
    <option <?php if($row['equipment_type'] === 'Concrete Pump') echo 'selected'; ?> value="Concrete Pump" class="cq_options">Concrete Pump</option>
    <option <?php if($row['equipment_type'] === 'Moli Pump') echo 'selected'; ?> value="Moli Pump" class="cq_options">Moli Pump</option>
    <option <?php if($row['equipment_type'] === 'Mobile Batching Plant') echo 'selected'; ?> value="Mobile Batching Plant" class="cq_options">Mobile Batching Plant</option>
    <option <?php if($row['equipment_type'] === 'Static Boom Placer') echo 'selected'; ?> value="Static Boom Placer" class="cq_options">Static Boom Placer</option>
    <option <?php if($row['equipment_type'] === 'Transit Mixer') echo 'selected'; ?> value="Transit Mixer" class="cq_options">Transit Mixer</option>

    <!-- Earthmovers -->
    <option <?php if($row['equipment_type'] === 'Baby Roller') echo 'selected'; ?> value="Baby Roller" class="earthmover_options">Baby Roller</option>
    <option <?php if($row['equipment_type'] === 'Backhoe Loader') echo 'selected'; ?> value="Backhoe Loader" class="earthmover_options">Backhoe Loader</option>
    <option <?php if($row['equipment_type'] === 'Bulldozer') echo 'selected'; ?> value="Bulldozer" class="earthmover_options">Bulldozer</option>
    <option <?php if($row['equipment_type'] === 'Excavator') echo 'selected'; ?> value="Excavator" class="earthmover_options">Excavator</option>
    <option <?php if($row['equipment_type'] === 'Milling Machine') echo 'selected'; ?> value="Milling Machine" class="earthmover_options">Milling Machine</option>
    <option <?php if($row['equipment_type'] === 'Motor Grader') echo 'selected'; ?> value="Motor Grader" class="earthmover_options">Motor Grader</option>
    <option <?php if($row['equipment_type'] === 'Pneumatic Tyre Roller') echo 'selected'; ?> value="Pneumatic Tyre Roller" class="earthmover_options">Pneumatic Tyre Roller</option>
    <option <?php if($row['equipment_type'] === 'Single Drum Roller') echo 'selected'; ?> value="Single Drum Roller" class="earthmover_options">Single Drum Roller</option>
    <option <?php if($row['equipment_type'] === 'Skid Loader') echo 'selected'; ?> value="Skid Loader" class="earthmover_options">Skid Loader</option>
    <option <?php if($row['equipment_type'] === 'Slip Form Paver') echo 'selected'; ?> value="Slip Form Paver" class="earthmover_options">Slip Form Paver</option>
    <option <?php if($row['equipment_type'] === 'Soil Compactor') echo 'selected'; ?> value="Soil Compactor" class="earthmover_options">Soil Compactor</option>
    <option <?php if($row['equipment_type'] === 'Tandem Roller') echo 'selected'; ?> value="Tandem Roller" class="earthmover_options">Tandem Roller</option>
    <option <?php if($row['equipment_type'] === 'Vibratory Roller') echo 'selected'; ?> value="Vibratory Roller" class="earthmover_options">Vibratory Roller</option>
    <option <?php if($row['equipment_type'] === 'Wheeled Excavator') echo 'selected'; ?> value="Wheeled Excavator" class="earthmover_options">Wheeled Excavator</option>
    <option <?php if($row['equipment_type'] === 'Wheeled Loader') echo 'selected'; ?> value="Wheeled Loader" class="earthmover_options">Wheeled Loader</option>

    <!-- Material Handling Equipment (MHE) -->
    <option <?php if($row['equipment_type'] === 'Fixed Tower Crane') echo 'selected'; ?> value="Fixed Tower Crane" class="mhe_options">Fixed Tower Crane</option>
    <option <?php if($row['equipment_type'] === 'Fork Lift Diesel') echo 'selected'; ?> value="Fork Lift Diesel" class="mhe_options">Fork Lift Diesel</option>
    <option <?php if($row['equipment_type'] === 'Fork Lift Electric') echo 'selected'; ?> value="Fork Lift Electric" class="mhe_options">Fork Lift Electric</option>
    <option <?php if($row['equipment_type'] === 'Hammerhead Tower Crane') echo 'selected'; ?> value="Hammerhead Tower Crane" class="mhe_options">Hammerhead Tower Crane</option>
    <option <?php if($row['equipment_type'] === 'Hydraulic Crawler Crane') echo 'selected'; ?> value="Hydraulic Crawler Crane" class="mhe_options">Hydraulic Crawler Crane</option>
    <option <?php if($row['equipment_type'] === 'Luffing Jib Tower Crane') echo 'selected'; ?> value="Luffing Jib Tower Crane" class="mhe_options">Luffing Jib Tower Crane</option>
    <option <?php if($row['equipment_type'] === 'Mechanical Crawler Crane') echo 'selected'; ?> value="Mechanical Crawler Crane" class="mhe_options">Mechanical Crawler Crane</option>
    <option <?php if($row['equipment_type'] === 'Pick and Carry Crane') echo 'selected'; ?> value="Pick and Carry Crane" class="mhe_options">Pick and Carry Crane</option>
    <option <?php if($row['equipment_type'] === 'Reach Stacker') echo 'selected'; ?> value="Reach Stacker" class="mhe_options">Reach Stacker</option>
    <option <?php if($row['equipment_type'] === 'Rough Terrain Crane') echo 'selected'; ?> value="Rough Terrain Crane" class="mhe_options">Rough Terrain Crane</option>
    <option <?php if($row['equipment_type'] === 'Telehandler') echo 'selected'; ?> value="Telehandler" class="mhe_options">Telehandler</option>
    <option <?php if($row['equipment_type'] === 'Telescopic Crawler Crane') echo 'selected'; ?> value="Telescopic Crawler Crane" class="mhe_options">Telescopic Crawler Crane</option>
    <option <?php if($row['equipment_type'] === 'Telescopic Mobile Crane') echo 'selected'; ?> value="Telescopic Mobile Crane" class="mhe_options">Telescopic Mobile Crane</option>
    <option <?php if($row['equipment_type'] === 'All Terrain Mobile Crane') echo 'selected'; ?> value="All Terrain Mobile Crane" class="mhe_options">All Terrain Mobile Crane</option>
    <option <?php if($row['equipment_type'] === 'Self Loading Truck Crane') echo 'selected'; ?> value="Self Loading Truck Crane" class="mhe_options">Self Loading Truck Crane</option>

    <!-- Ground Engineering Equipment -->
    <option <?php if($row['equipment_type'] === 'Hydraulic Drilling Rig') echo 'selected'; ?> value="Hydraulic Drilling Rig" class="gee_options">Hydraulic Drilling Rig</option>
    <option <?php if($row['equipment_type'] === 'Rotary Drilling Rig') echo 'selected'; ?> value="Rotary Drilling Rig" class="gee_options">Rotary Drilling Rig</option>
    <option <?php if($row['equipment_type'] === 'Vibro Hammer') echo 'selected'; ?> value="Vibro Hammer" class="gee_options">Vibro Hammer</option>

    <!-- Trailers -->
    <option <?php if($row['equipment_type'] === 'Dumper') echo 'selected'; ?> value="Dumper" class="trailor_options">Dumper</option>
    <option <?php if($row['equipment_type'] === 'Truck') echo 'selected'; ?> value="Truck" class="trailor_options">Truck</option>
    <option <?php if($row['equipment_type'] === 'Water Tanker') echo 'selected'; ?> value="Water Tanker" class="trailor_options">Water Tanker</option>
    <option <?php if($row['equipment_type'] === 'Low Bed') echo 'selected'; ?> value="Low Bed" class="trailor_options">Low Bed</option>
    <option <?php if($row['equipment_type'] === 'Semi Low Bed') echo 'selected'; ?> value="Semi Low Bed" class="trailor_options">Semi Low Bed</option>
    <option <?php if($row['equipment_type'] === 'Flatbed') echo 'selected'; ?> value="Flatbed" class="trailor_options">Flatbed</option>
    <option <?php if($row['equipment_type'] === 'Hydraulic Axle') echo 'selected'; ?> value="Hydraulic Axle" class="trailor_options">Hydraulic Axle</option>

    <!-- Generators -->
    <option <?php if($row['equipment_type'] === 'Silent Diesel Generator') echo 'selected'; ?> value="Silent Diesel Generator" class="generator_options">Silent Diesel Generator</option>
    <option <?php if($row['equipment_type'] === 'Mobile Light Tower') echo 'selected'; ?> value="Mobile Light Tower" class="generator_options">Mobile Light Tower</option>
    <option <?php if($row['equipment_type'] === 'Diesel Generator') echo 'selected'; ?> value="Diesel Generator" class="generator_options">Diesel Generator</option>
        </select>

            </div>
        </div>
        <div class="outer02">
            <div class="trial1">
                <input type="text" placeholder="" name="equipment_capacity" value="<?php echo $row['equipment_capacity'] ?>" class="input02" >
                <label for="" class="placeholder2">Equipment Capacity</label>
            </div>
            <div class="trial1">
                <!-- <input type="text" placeholder="" value="<?php echo $row['unit'] ?>" class="input02" >
                <label for="" class="placeholder2">Unit</label> -->
                <select name="unit" id="" class="input02">
                <option <?php if($row['unit']==='Ton'){ echo 'selected';} ?> value="Ton">Ton</option>
                <option <?php if($row['unit']==='Kgs'){ echo 'selected';} ?> value="Kgs">Kgs</option>
                <option <?php if($row['unit']==='KnM'){ echo 'selected';} ?> value="KnM">KnM</option>
                <option <?php if($row['unit']==='Meter'){ echo 'selected';} ?> value="Meter">Meter</option>
                <option <?php if($row['unit']==='M³'){ echo 'selected';} ?> value="M³">M³</option>

                </select>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" name="boom_combination" value="<?php echo $row['boom_combination'] ?>" class="input02" >
                <label for="" class="placeholder2">Boom Combination</label>
            </div>
        </div>
        <div class="outer02">
        <div class="trial1">
                <select name="working_shift" id="working_shift_dd" onchange="engine_hour_input()" class="input02">
                <option value="" disabled selected> Select Working shift</option>
                <option <?php if($row['working_shift']==='Single'){ echo 'selected';} ?> value="Single">Single Shift</option>
                <option <?php if($row['working_shift']==='Double'){ echo 'selected';} ?> value="Double">Double Shift</option>
                <option <?php if($row['working_shift']==='Flexi Single'){ echo 'selected';} ?> value="Flexi Single">Flexi Single Shift</option>

                </select>
            </div>
            <div class="trial1" id="engine_hour_dd">
                <select name="engine_hour"  class="input02">
                    <option value="" disabled selected>Choose Engine Hour</option>
                    <option <?php if($row['engine_hour']==='260'){ echo 'selected';} ?> value="260">260</option>
                    <option <?php if($row['engine_hour']==='280'){ echo 'selected';} ?> value="280">280</option>
                    <option <?php if($row['engine_hour']==='300'){ echo 'selected';} ?> value="300">300</option>
                    <option <?php if($row['engine_hour']==='312'){ echo 'selected';} ?> value="312">312</option>
                    <option <?php if($row['engine_hour']==='416'){ echo 'selected';} ?> value="416">416</option>
                    <option <?php if($row['engine_hour']==='572'){ echo 'selected';} ?> value="572">572</option>
                </select>
            </div>

            <select name="working_days" id="" class="input02">
                <option value=""disabled selected>Working days</option>
                <option <?php if($row['working_days']==='7'){echo 'selected';} ?> value="7">7 Days/Month</option>
                <option <?php if($row['working_days']==='10'){echo 'selected';} ?> value="10">10 Days/Month</option>
                <option <?php if($row['working_days']==='15'){echo 'selected';} ?> value="15">15 Days/Month</option>
                <option <?php if($row['working_days']==='26'){echo 'selected';} ?> value="26" >26 Days/Month</option>
                <option <?php if($row['working_days']==='28'){echo 'selected';} ?> value="28">28 Days/Month</option>
                <option <?php if($row['working_days']==='30'){echo 'selected';} ?> value="30">30 Days/Month</option>

            </select>

        </div>
        <div class="outer02">
            <div class="trial1">
                <!-- <input type="text" class="input02" name="fuel_scope" value="<?php echo $row['fuel_scope'] ?>" placeholder="" >
                <label for="" class="placeholder2">Fuel In Scope Of</label> -->
                <select name="fuel_scope" id="" class="input02">
                <option value=""disabled>Fuel In Scope Of?</option>
                <option <?php if($row['fuel_scope']==='EPC Scope'){ echo 'selected';} ?> value="EPC Scope">Fuel: EPC Scope</option>
                <option <?php if($row['fuel_scope']==='Service Provider'){ echo 'selected';} ?> value="Service Provider">Fuel: Service Provider</option>
                </select>

            </div>
            <select name="adbluescope" id="adbluescope" class="input02">
                <option value="disabled selected">⁠Adblue scope</option>
                <option <?php if($row['adblue_scope']==='EPC Scope'){ echo 'selected';} ?> value="EPC Scope">Adblue: EPC Scope</option>
                <option <?php if($row['adblue_scope']==='Service Provider'){ echo 'selected';} ?> value="Service Provider">Adblue: Service Provider</option>

            </select>

            <div class="trial1">
                <!-- <input type="text" class="input02" name="accomodation_scope" value="<?php echo $row['accomodation_scope'] ?>" placeholder="" >
                <label for="" class="placeholder2">Accomodation In Scope Of</label> -->
                <select name="accomodation_scope" id="" class="input02">
                <option value=""disabled>Accomodation Scope </option>

                    <option <?php if($row['accomodation_scope']===''){ echo 'selected';} ?> value="EPC Scope">Accom: EPC Scope</option>
                    <option <?php if($row['accomodation_scope']===''){ echo 'selected';} ?> value="Service Provider">Accom: Service Provider</option>

                </select>
            </div>
        </div>
        <div class="outer02">
            <select name="demob_recovery" id="" class="input02">
                <option value=""disabled selected>Mobilisation recovery</option>
                <option <?php if($row['mobilisation_recovery']==='Not Applicable'){ echo 'selected';} ?> value="Not Applicable">Not Applicable</option>
                <option <?php if($row['mobilisation_recovery']==='3 Months'){ echo 'selected';} ?> value="3 Months">Mob Recovery: 3 Months</option>
                <option <?php if($row['mobilisation_recovery']==='6 Months'){ echo 'selected';} ?> value="6 Months">Mob Recovery: 6 Months</option>
                <option <?php if($row['mobilisation_recovery']==='9 Months'){ echo 'selected';} ?> value="9 Months">Mob Recovery: 9 Months</option>
                <option <?php if($row['mobilisation_recovery']==='12 Months'){ echo 'selected';} ?> value="12 Months">Mob Recovery: 12 Months</option>
            </select>
            <select name="mob_recovery" id="" class="input02">
                <option value=""disabled selected>Demobilisation recovery</option>
                <option <?php if($row['demobilisation_recovery']==='Not Applicable'){ echo 'selected';} ?> value="Not Applicable">DeMob Recovery: Not Applicable</option>
                <option <?php if($row['demobilisation_recovery']==='3 Months'){ echo 'selected';} ?> value="3 Months">DeMob Recovery: 3 Months</option>
                <option <?php if($row['demobilisation_recovery']==='6 Months'){ echo 'selected';} ?> value="6 Months">DeMob Recovery: 6 Months</option>
                <option <?php if($row['demobilisation_recovery']==='9 Months'){ echo 'selected';} ?> value="9 Months">DeMob Recovery: 9 Months</option>
                <option <?php if($row['demobilisation_recovery']==='12 Months'){ echo 'selected';} ?> value="12 Months">DeMob Recovery: 12 Months</option>
            </select>
        </div>
        <div class="outer02">
            <select name="advance" id="advanceapplicable" class="input02" onchange="advancefordd()">
                <option value=""disabled selected>Advance </option>
                <option <?php if($row['advance']==='Applicable'){ echo 'selected';} ?> value="Applicable">Advance Applicable</option>
                <option <?php if($row['advance']==='Not Applicable'){ echo 'selected';} ?> value="Not Applicable">Advance Not Applicable</option>

            </select>
            <select name="advfor" id="advancefor" class="input02">
                <option value=""disabled selected>Advance For</option>
                <option <?php if($row['adv_for']==='Transportation'){ echo 'selected';} ?> value="Transportation">Adv For Transportation</option>
                <option <?php if($row['adv_for']==='Rental'){ echo 'selected';} ?> value="Rental">Adv For Rental</option>
                <option <?php if($row['adv_for']==='Rental + Transportation'){ echo 'selected';} ?> value="Rental + Transportation">Adv For Rental + Transportation</option>
            </select>
            <select name="creditterm" id="" class="input02">
                <option value=""disabled selected>Credit Term</option>
                <option <?php if($row['credit_term']==='7 Days'){ echo 'selected';} ?> value="7 Days">Credit :7 Days</option>
                <option <?php if($row['credit_term']==='10 Days'){ echo 'selected';} ?> value="10 Days">Credit :10 Days</option>
                <option <?php if($row['credit_term']==='15 Days'){ echo 'selected';} ?> value="15 Days">Credit :15 Days</option>
                <option <?php if($row['credit_term']==='30 Days'){ echo 'selected';} ?> value="30 Days">Credit :30 Days</option>
                <option <?php if($row['credit_term']==='45 Days'){ echo 'selected';} ?> value="45 Days">Credit :45 Days</option>
                <option <?php if($row['credit_term']==='60 Days'){ echo 'selected';} ?> value="60 Days">Credit :60 Days</option>
                <option <?php if($row['credit_term']==='90 Days'){ echo 'selected';} ?> value="90 Days">Credit :90 Days</option>
            </select>
        </div>


        <div class="outer02">
            <div class="trial1">
                <input type="number" class="input02" name="duration_month" value="<?php echo $row['duration_month'] ?>" placeholder="" >
                <label for="" class="placeholder2">Duration In Month</label>
            </div>
            <div class="trial1">
                <!-- <input type="text" class="input02" name="state" value="<?php echo $row['state'] ?>" placeholder="" >
                <label for="" class="placeholder2">Project State</label> -->
            <select class="input02" name="state" id="state">
                <option value="" disabled >Project State</option>
                <option <?php if($row['state']==='Arunachal Pradesh'){ echo 'selected';} ?> value="Arunachal Pradesh">Arunachal Pradesh</option>
                <option value="Andhra Pradesh">Andhra Pradesh</option>
                <option value="Assam">Assam</option>
                <option value="Bihar">Bihar</option>
                <option value="Chandigarh">Chandigarh</option>
                <option value="Chhattisgarh">Chhattisgarh</option>
                <option value="Dadar and Nagar Haveli">Dadar and Nagar Haveli</option>
                <option value="Daman and Diu">Daman and Diu</option>
                <option value="Delhi">Delhi</option>
                <option value="Lakshadweep">Lakshadweep</option>
                <option value="Puducherry">Puducherry</option>
                <option value="Goa">Goa</option>
                <option value="Gujarat">Gujarat</option>
                <option value="Haryana">Haryana</option>
                <option value="Himachal Pradesh">Himachal Pradesh</option>
                <option value="Jammu and Kashmir">Jammu and Kashmir</option>
                <option value="Jharkhand">Jharkhand</option>
                <option value="Karnataka">Karnataka</option>
                <option value="Kerala">Kerala</option>
                <option value="Madhya Pradesh">Madhya Pradesh</option>
                <option value="Maharashtra">Maharashtra</option>
                <option value="Manipur">Manipur</option>
                <option value="Meghalaya">Meghalaya</option>
                <option value="Mizoram">Mizoram</option>
                <option value="Nagaland">Nagaland</option>
                <option value="Odisha">Odisha</option>
                <option value="Punjab">Punjab</option>
                <option value="Rajasthan">Rajasthan</option>
                <option value="Sikkim">Sikkim</option>
                <option value="Tamil Nadu">Tamil Nadu</option>
                <option value="Telangana">Telangana</option>
                <option value="Tripura">Tripura</option>
                <option value="Uttar Pradesh">Uttar Pradesh</option>
                <option value="Uttarakhand">Uttarakhand</option>
                <option value="West Bengal">West Bengal</option>
            </select>
            </div>

            <div class="trial1">
                <input type="text" class="input02" name="district" value="<?php echo $row['district'] ?>" placeholder="" >
                <label for="" class="placeholder2">Project District</label>
            </div>
        </div>
        <div class="trial1">
    <textarea placeholder="" name="notes" class="input02" ><?php echo $row['notes']; ?></textarea>
    <label class="placeholder2">Notes For Vendor</label>
</div>
    <button type="submit" class="epc-button">Submit</button>
    </div>
        <br><br>
        

</body>
<script>
    document.addEventListener('DOMContentLoaded', function() {

    const oem_fleet_type=document.getElementById("oem_fleet_type");
    if(oem_fleet_type.value !==''){
        purchase_option();
    }
    
    
    
    })
    document.addEventListener('DOMContentLoaded', function() {

        const advanceapplicable=document.getElementById("advanceapplicable");
    if(advanceapplicable.value !==''){
        advancefordd();
    }
    
    
    })

    document.addEventListener('DOMContentLoaded', function() {

const working_shift_dd=document.getElementById("working_shift_dd");
if(working_shift_dd.value !==''){
        engine_hour_input();
    }
    
    
    })

</script>
</html>