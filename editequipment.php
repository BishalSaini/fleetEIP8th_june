<?php
include "partials/_dbconnect.php";
session_start();
$companyname001=$_SESSION['companyname'];
$editid=$_GET['id'];
$sql="SELECT * FROM `adminfleet` where id=$editid and added_by='$companyname001'";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_assoc($result);
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
$showAlert = false;
$showError = false;

if(isset($_SESSION['success'])){
    $showAlert=true;
    unset($_SESSION['success']);
}
else if(isset($_SESSION['error'])){
    $showError=true;
    unset($_SESSION['error']);
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include "partials/_dbconnect.php";

    // Retrieve the necessary POST variables
    $id = $_POST['id']; // Assuming you have an 'id' field to identify the record
    $fleet_category = $_POST['fleet_category'];
    $type = $_POST['type'];
    $make = $_POST['make'];
    $model = $_POST['model'];
    $cap = $_POST['cap'];
    $unit = $_POST['unit'];
    $radiuscap = $_POST['radiuscap'];
    $radius = $_POST['radius'];
    $launchyear = $_POST['launchyear'];
    $basicmainboom = $_POST['basicmainboom'];
    $fixedjib = $_POST['fixedjib'];
    $luffing = $_POST['luffing'];
    $boomcombination = $_POST['boomcombination'];
    $boom_flyjib_mainboom = $_POST['boom_flyjib_mainboom'];
    $boom_flyjib_flyjib = $_POST['boom_flyjib_flyjib'];
    $boom_luffer_mainboom = $_POST['boom_luffer_mainboom'];
    $boom_luffer_luffingjib = $_POST['boom_luffer_luffingjib'];
    $fueltank = $_POST['fueltank'];
    $hydraulictank = $_POST['hydraulictank'];
    $enginemake = $_POST['enginemake'];
    $enginemodel = $_POST['enginemodel'];
    $cw1desc = $_POST['cw1desc'];
    $cw1cap = $_POST['cw1cap'];
    $cw1nos = $_POST['cw1nos'];
    $cw2desc = $_POST['cw2desc'];
    $cw2cap = $_POST['cw2cap'];
    $cw2nos = $_POST['cw2nos'];
    $cw3desc = $_POST['cw3desc'];
    $cw3cap = $_POST['cw3cap'];
    $cw3nos = $_POST['cw3nos'];
    $cw4desc = $_POST['cw4desc'];
    $cw4cap = $_POST['cw4cap'];
    $cw4nos = $_POST['cw4nos'];
    $cw5desc = $_POST['cw5desc'];
    $cw5cap = $_POST['cw5cap'];
    $cw5nos = $_POST['cw5nos'];
    $cw6desc = $_POST['cw6desc'];
    $cw6cap = $_POST['cw6cap'];
    $cw6nos = $_POST['cw6nos'];
    $hook1 = $_POST['hook1'];
    $hook2 = $_POST['hook2'];
    $hook3 = $_POST['hook3'];
    $hook4 = $_POST['hook4'];
    $hook5 = $_POST['hook5'];
    $hook6 = $_POST['hook6'];
    $cabin_dimension = $_POST['cabin_dimension'];
    $cabinweight = $_POST['cabinweight'];
    $cabinunit = $_POST['cabinunit'];
    $cabintrailor = $_POST['cabintrailor'];
    $mainwinchlength = $_POST['mainwinchlength'];
    $mainwinchdia = $_POST['mainwinchdia'];
    $secondwinchlength = $_POST['secondwinchlength'];
    $secondwinchdia = $_POST['secondwinchdia'];
    $auxiwinchlength = $_POST['auxiwinchlength'];
    $auxiwinchdia = $_POST['auxiwinchdia'];
    $currentstatus = $_POST['currentstatus'];

    $height=$_POST['height'];
    $luffer_available=$_POST['luffer_available'];
    $flyjib_available=$_POST['flyjib_available'];

    $existingloadchart=$_POST['existingloadchart'];
    $existingimage=$_POST['existingimage'];

    if(isset($_POST['loadchart']) && !empty($_POST['loadchart'])){
        $loadchart = $_FILES['loadchart']['name'];
        $temp_file_path = $_FILES['loadchart']['tmp_name'];
        $random_string = bin2hex(random_bytes(8)); // Generates an 8-byte random string
        $uniqueloadchartname = $random_string . '_' . $loadchart;
        $folder1 = 'img/' . $uniqueloadchartname;
        move_uploaded_file($temp_file_path, $folder1);
        
    }
    else{
        $uniqueloadchartname = $existingloadchart;
    }


    // Update query
    $updatedata = "UPDATE adminfleet SET 
        fleet_category = '$fleet_category',
        `height` = '$height', `flyjib_available` = '$flyjib_available', `luffer_available` = '$luffer_available',
        `loadchart` = '$uniqueloadchartname',
        type = '$type',
        make = '$make',
        model = '$model',
        cap = '$cap',
        unit = '$unit',
        radiuscap = '$radiuscap',
        radius = '$radius',
        launchyear = '$launchyear',
        basicmainboom = '$basicmainboom',
        fixedjib = '$fixedjib',
        luffing = '$luffing',
        boomcombination = '$boomcombination',
        boom_flyjib_mainboom = '$boom_flyjib_mainboom',
        boom_flyjib_flyjib = '$boom_flyjib_flyjib',
        boom_luffer_mainboom = '$boom_luffer_mainboom',
        boom_luffer_luffingjib = '$boom_luffer_luffingjib',
        fueltank = '$fueltank',
        hydraulictank = '$hydraulictank',
        enginemake = '$enginemake',
        enginemodel = '$enginemodel',
        cw1desc = '$cw1desc',
        cw1cap = '$cw1cap',
        cw1nos = '$cw1nos',
        cw2desc = '$cw2desc',
        cw2cap = '$cw2cap',
        cw2nos = '$cw2nos',
        cw3desc = '$cw3desc',
        cw3cap = '$cw3cap',
        cw3nos = '$cw3nos',
        cw4desc = '$cw4desc',
        cw4cap = '$cw4cap',
        cw4nos = '$cw4nos',
        cw5desc = '$cw5desc',
        cw5cap = '$cw5cap',
        cw5nos = '$cw5nos',
        cw6desc = '$cw6desc',
        cw6cap = '$cw6cap',
        cw6nos = '$cw6nos',
        hook1 = '$hook1',
        hook2 = '$hook2',
        hook3 = '$hook3',
        hook4 = '$hook4',
        hook5 = '$hook5',
        hook6 = '$hook6',
        cabin_dimension = '$cabin_dimension',
        cabinweight = '$cabinweight',
        cabinunit = '$cabinunit',
        cabintrailor = '$cabintrailor',
        mainwinchlength = '$mainwinchlength',
        mainwinchdia = '$mainwinchdia',
        secondwinchlength = '$secondwinchlength',
        secondwinchdia = '$secondwinchdia',
        auxiwinchlength = '$auxiwinchlength',
        auxiwinchdia = '$auxiwinchdia',
        current_status = '$currentstatus'
    WHERE id = '$id'"; // Ensure this ID corresponds to the record you want to update

    $resultupdate = mysqli_query($conn, $updatedata);
    if ($resultupdate) {
        session_start();
        $_SESSION['success']='true';
    } else {
        session_start();
        $_SESSION['error']='true';
    }
    header("Location: editequipment.php?id=" . urlencode($id));
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Equipment</title>
    <script src="main.js"defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <link rel="stylesheet" href="style.css">
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
    <?php
    if($showAlert){
        echo  '<label>
        <input type="checkbox" class="alertCheckbox" autocomplete="off" />
        <div class="alert notice">
          <span class="alertClose">X</span>
          <span class="alertText_addfleet"><b>Success!</b>
              <br class="clear"/></span>
        </div>
      </label>';
    }
    if($showError){
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
 
    <form action="editequipment.php?id='<?php echo $editid; ?>'" method="POST" autocomplete="off" enctype="multipart/form-data"  class="outerform">
        <div class="equipdatainner">
            <p class="headingpara">View/Edit Equipment</p>
            <input type="hidden" value="<?php echo $editid; ?>" name="id">
            <input type="hidden" value="<?php echo $row['loadchart']; ?>" name="existingloadchart">
            <input type="hidden" value="<?php echo $row['image']; ?>" name="existingimage">
            <div class="outer02">
        <div class="trial1">
        <select class="input02" name="fleet_category" id="oem_fleet_type" onchange="purchase_option()" required>
            <option value="" disabled selected>Select Fleet Category</option>
            <option <?php if($row['fleet_category'] === 'Aerial Work Platform') { echo 'selected'; } ?> value="Aerial Work Platform">Aerial Work Platform</option>
<option <?php if($row['fleet_category'] === 'Concrete Equipment') { echo 'selected'; } ?> value="Concrete Equipment">Concrete Equipment</option>
<option <?php if($row['fleet_category'] === 'EarthMovers and Road Equipments') { echo 'selected'; } ?> value="EarthMovers and Road Equipments">EarthMovers and Road Equipments</option>
<option <?php if($row['fleet_category'] === 'Material Handling Equipments') { echo 'selected'; } ?> value="Material Handling Equipments">Material Handling Equipments</option>
<option <?php if($row['fleet_category'] === 'Ground Engineering Equipments') { echo 'selected'; } ?> value="Ground Engineering Equipments">Ground Engineering Equipments</option>
<option <?php if($row['fleet_category'] === 'Trailor and Truck') { echo 'selected'; } ?> value="Trailor and Truck">Trailor and Truck</option>
<option <?php if($row['fleet_category'] === 'Generator and Lighting') { echo 'selected'; } ?> value="Generator and Lighting">Generator and Lighting</option>
        </select>
        </div>
        <div class="trial1">
        <select class="input02" name="type" id="fleet_sub_type" onchange="crawler_options()" required>
            <option value="" disabled selected>Select Fleet Type</option>
            <option value="Self Propelled Articulated Boomlift" class="awp_options" id="aerial_work_platform_option1" <?php if($row['type'] === 'Self Propelled Articulated Boomlift') echo 'selected'; ?>>Self Propelled Articulated Boomlift</option>
<option value="Scissor Lift Diesel" class="awp_options" id="aerial_work_platform_option2" <?php if($row['type'] === 'Scissor Lift Diesel') echo 'selected'; ?>>Scissor Lift Diesel</option>
<option value="Scissor Lift Electric" class="awp_options" id="aerial_work_platform_option3" <?php if($row['type'] === 'Scissor Lift Electric') echo 'selected'; ?>>Scissor Lift Electric</option>
<option value="Spider Lift" class="awp_options" id="aerial_work_platform_option4" <?php if($row['type'] === 'Spider Lift') echo 'selected'; ?>>Spider Lift</option>
<option value="Self Propelled Straight Boomlift" class="awp_options" id="aerial_work_platform_option5" <?php if($row['type'] === 'Self Propelled Straight Boomlift') echo 'selected'; ?>>Self Propelled Straight Boomlift</option>
<option value="Truck Mounted Articulated Boomlift" class="awp_options" id="aerial_work_platform_option6" <?php if($row['type'] === 'Truck Mounted Articulated Boomlift') echo 'selected'; ?>>Truck Mounted Articulated Boomlift</option>
<option value="Truck Mounted Straight Boomlift" class="awp_options" id="aerial_work_platform_option7" <?php if($row['type'] === 'Truck Mounted Straight Boomlift') echo 'selected'; ?>>Truck Mounted Straight Boomlift</option>
<option value="Batching Plant" class="cq_options" id="concrete_equipment_option1" <?php if($row['type'] === 'Batching Plant') echo 'selected'; ?>>Batching Plant</option>
<option value="Self Loading Mixer" class="cq_options" id="" <?php if($row['type'] === 'Self Loading Mixer') echo 'selected'; ?>>Self Loading Mixer</option>
<option value="Concrete Boom Placer" class="cq_options" id="concrete_equipment_option2" <?php if($row['type'] === 'Concrete Boom Placer') echo 'selected'; ?>>Concrete Boom Placer</option>
<option value="Concrete Pump" class="cq_options" id="concrete_equipment_option3" <?php if($row['type'] === 'Concrete Pump') echo 'selected'; ?>>Concrete Pump</option>
<option value="Moli Pump" class="cq_options" id="concrete_equipment_option4" <?php if($row['type'] === 'Moli Pump') echo 'selected'; ?>>Moli Pump</option>
<option value="Mobile Batching Plant" class="cq_options" id="concrete_equipment_option5" <?php if($row['type'] === 'Mobile Batching Plant') echo 'selected'; ?>>Mobile Batching Plant</option>
<option value="Static Boom Placer" class="cq_options" id="concrete_equipment_option6" <?php if($row['type'] === 'Static Boom Placer') echo 'selected'; ?>>Static Boom Placer</option>
<option value="Transit Mixer" class="cq_options" id="concrete_equipment_option7" <?php if($row['type'] === 'Transit Mixer') echo 'selected'; ?>>Transit Mixer</option>
<option value="Shotcrete Machine" class="cq_options" id="concrete_equipment_option8" <?php if($row['type'] === 'Shotcrete Machine') echo 'selected'; ?>>Shotcrete Machine</option>
<option value="Baby Roller" class="earthmover_options" id="earthmovers_option1" <?php if($row['type'] === 'Baby Roller') echo 'selected'; ?>>Baby Roller</option>
<option value="Backhoe Loader" class="earthmover_options" id="earthmovers_option2" <?php if($row['type'] === 'Backhoe Loader') echo 'selected'; ?>>Backhoe Loader</option>
<option value="Bulldozer" class="earthmover_options" id="earthmovers_option3" <?php if($row['type'] === 'Bulldozer') echo 'selected'; ?>>Bulldozer</option>
<option value="Excavator" class="earthmover_options" id="earthmovers_option4" <?php if($row['type'] === 'Excavator') echo 'selected'; ?>>Excavator</option>
<option value="Milling Machine" class="earthmover_options" id="earthmovers_option5" <?php if($row['type'] === 'Milling Machine') echo 'selected'; ?>>Milling Machine</option>
<option value="Motor Grader" class="earthmover_options" id="earthmovers_option6" <?php if($row['type'] === 'Motor Grader') echo 'selected'; ?>>Motor Grader</option>
<option value="Pneumatic Tyre Roller" class="earthmover_options" id="earthmovers_option7" <?php if($row['type'] === 'Pneumatic Tyre Roller') echo 'selected'; ?>>Pneumatic Tyre Roller</option>
<option value="Single Drum Roller" class="earthmover_options" id="earthmovers_option8" <?php if($row['type'] === 'Single Drum Roller') echo 'selected'; ?>>Single Drum Roller</option>
<option value="Skid Loader" class="earthmover_options" id="earthmovers_option9" <?php if($row['type'] === 'Skid Loader') echo 'selected'; ?>>Skid Loader</option>
<option value="Slip Form Paver" class="earthmover_options" id="earthmovers_option10" <?php if($row['type'] === 'Slip Form Paver') echo 'selected'; ?>>Slip Form Paver</option>
<option value="Soil Compactor" class="earthmover_options" id="earthmovers_option11" <?php if($row['type'] === 'Soil Compactor') echo 'selected'; ?>>Soil Compactor</option>
<option value="Tandem Roller" class="earthmover_options" id="earthmovers_option12" <?php if($row['type'] === 'Tandem Roller') echo 'selected'; ?>>Tandem Roller</option>
<option value="Vibratory Roller" class="earthmover_options" id="earthmovers_option13" <?php if($row['type'] === 'Vibratory Roller') echo 'selected'; ?>>Vibratory Roller</option>
<option value="Wheeled Excavator" class="earthmover_options" id="earthmovers_option14" <?php if($row['type'] === 'Wheeled Excavator') echo 'selected'; ?>>Wheeled Excavator</option>
<option value="Wheeled Loader" class="earthmover_options" id="earthmovers_option15" <?php if($row['type'] === 'Wheeled Loader') echo 'selected'; ?>>Wheeled Loader</option>
<option id="mhe_option1" class="mhe_options" value="Fixed Tower Crane" <?php if($row['type'] === 'Fixed Tower Crane') echo 'selected'; ?>>Fixed Tower Crane</option>
<option id="mhe_option2" class="mhe_options" value="Fork Lift Diesel" <?php if($row['type'] === 'Fork Lift Diesel') echo 'selected'; ?>>Fork Lift Diesel</option>
<option id="mhe_option3" class="mhe_options" value="Fork Lift Electric" <?php if($row['type'] === 'Fork Lift Electric') echo 'selected'; ?>>Fork Lift Electric</option>
<option id="mhe_option4" class="mhe_options" value="Hammerhead Tower Crane" <?php if($row['type'] === 'Hammerhead Tower Crane') echo 'selected'; ?>>Hammerhead Tower Crane</option>
<option id="mhe_option5" class="mhe_options" value="Hydraulic Crawler Crane" <?php if($row['type'] === 'Hydraulic Crawler Crane') echo 'selected'; ?>>Hydraulic Crawler Crane</option>
<option id="mhe_option6" class="mhe_options" value="Luffing Jib Tower Crane" <?php if($row['type'] === 'Luffing Jib Tower Crane') echo 'selected'; ?>>Luffing Jib Tower Crane</option>
<option id="mhe_option7" class="mhe_options" value="Mechanical Crawler Crane" <?php if($row['type'] === 'Mechanical Crawler Crane') echo 'selected'; ?>>Mechanical Crawler Crane</option>
<option id="mhe_option8" class="mhe_options" value="Pick and Carry Crane" <?php if($row['type'] === 'Pick and Carry Crane') echo 'selected'; ?>>Pick and Carry Crane</option>
<option id="mhe_option9" class="mhe_options" value="Reach Stacker" <?php if($row['type'] === 'Reach Stacker') echo 'selected'; ?>>Reach Stacker</option>
<option id="mhe_option10" class="mhe_options" value="Rough Terrain Crane" <?php if($row['type'] === 'Rough Terrain Crane') echo 'selected'; ?>>Rough Terrain Crane</option>
<option id="mhe_option11" class="mhe_options" value="Telehandler" <?php if($row['type'] === 'Telehandler') echo 'selected'; ?>>Telehandler</option>
<option id="mhe_option12" class="mhe_options" value="Telescopic Crawler Crane" <?php if($row['type'] === 'Telescopic Crawler Crane') echo 'selected'; ?>>Telescopic Crawler Crane</option>
<option id="mhe_option13" class="mhe_options" value="Telescopic Mobile Crane" <?php if($row['type'] === 'Telescopic Mobile Crane') echo 'selected'; ?>>Telescopic Mobile Crane</option>
<option id="mhe_option14" class="mhe_options" value="All Terrain Mobile Crane" <?php if($row['type'] === 'All Terrain Mobile Crane') echo 'selected'; ?>>All Terrain Mobile Crane</option>
<option id="mhe_option15" class="mhe_options" value="Self Loading Truck Crane" <?php if($row['type'] === 'Self Loading Truck Crane') echo 'selected'; ?>>Self Loading Truck Crane</option>

<option id="ground_engineering_equipment_option1" class="gee_options" value="Hydraulic Drilling Rig" <?php if($row['type'] === 'Hydraulic Drilling Rig') echo 'selected'; ?>>Hydraulic Drilling Rig</option>
<option id="ground_engineering_equipment_option2" class="gee_options" value="Rotary Drilling Rig" <?php if($row['type'] === 'Rotary Drilling Rig') echo 'selected'; ?>>Rotary Drilling Rig</option>
<option id="ground_engineering_equipment_option3" class="gee_options" value="Vibro Hammer" <?php if($row['type'] === 'Vibro Hammer') echo 'selected'; ?>>Vibro Hammer</option>
<option id="trailor_option1" class="trailor_options" value="Dumper" <?php if($row['type'] === 'Dumper') echo 'selected'; ?>>Dumper</option>
<option id="trailor_option2" class="trailor_options" value="Truck" <?php if($row['type'] === 'Truck') echo 'selected'; ?>>Truck</option>
<option id="trailor_option3" class="trailor_options" value="Water Tanker" <?php if($row['type'] === 'Water Tanker') echo 'selected'; ?>>Water Tanker</option>
<option id="trailor_option4" class="trailor_options" value="Low Bed" <?php if($row['type'] === 'Low Bed') echo 'selected'; ?>>Low Bed</option>
<option id="trailor_option5" class="trailor_options" value="Semi Low Bed" <?php if($row['type'] === 'Semi Low Bed') echo 'selected'; ?>>Semi Low Bed</option>
<option id="trailor_option6" class="trailor_options" value="Flatbed" <?php if($row['type'] === 'Flatbed') echo 'selected'; ?>>Flatbed</option>
<option id="trailor_option7" class="trailor_options" value="Hydraulic Axle" <?php if($row['type'] === 'Hydraulic Axle') echo 'selected'; ?>>Hydraulic Axle</option>
<option id="generator_option1" class="generator_options" value="Silent Diesel Generator" <?php if($row['type'] === 'Silent Diesel Generator') echo 'selected'; ?>>Silent Diesel Generator</option>
<option id="generator_option2" class="generator_options" value="Mobile Light Tower" <?php if($row['type'] === 'Mobile Light Tower') echo 'selected'; ?>>Mobile Light Tower</option>
<option id="generator_option3" class="generator_options" value="Diesel Generator" <?php if($row['type'] === 'Diesel Generator') echo 'selected'; ?>>Diesel Generator</option>
        </select>
        </div>
        </div>

            <div class="outer02">
            <div class="trial1">
                <select name="make" id="" class="input02">
                    <option value=""disabled selected>Equipment Make</option>
                    <option value="ACE" <?php if($row['make'] === 'ACE') echo 'selected'; ?>>ACE</option>
<option value="Ajax Fiori" <?php if($row['make'] === 'Ajax Fiori') echo 'selected'; ?>>Ajax Fiori</option>
<option value="AMW" <?php if($row['make'] === 'AMW') echo 'selected'; ?>>AMW</option>
<option value="Apollo" <?php if($row['make'] === 'Apollo') echo 'selected'; ?>>Apollo</option>
<option value="Aquarius" <?php if($row['make'] === 'Aquarius') echo 'selected'; ?>>Aquarius</option>
<option value="Ashok Leyland" <?php if($row['make'] === 'Ashok Leyland') echo 'selected'; ?>>Ashok Leyland</option>
<option value="Atlas Copco" <?php if($row['make'] === 'Atlas Copco') echo 'selected'; ?>>Atlas Copco</option>
<option value="Belaz" <?php if($row['make'] === 'Belaz') echo 'selected'; ?>>Belaz</option>
<option value="Bemi" <?php if($row['make'] === 'Bemi') echo 'selected'; ?>>Bemi</option>
<option value="BEML" <?php if($row['make'] === 'BEML') echo 'selected'; ?>>BEML</option>
<option value="Bharat Benz" <?php if($row['make'] === 'Bharat Benz') echo 'selected'; ?>>Bharat Benz</option>
<option value="Bob Cat" <?php if($row['make'] === 'Bob Cat') echo 'selected'; ?>>Bob Cat</option>
<option value="Bull" <?php if($row['make'] === 'Bull') echo 'selected'; ?>>Bull</option>
<option value="Bauer" <?php if($row['make'] === 'Bauer') echo 'selected'; ?>>Bauer</option>
<option value="BMS" <?php if($row['make'] === 'BMS') echo 'selected'; ?>>BMS</option>
<option value="Bomag" <?php if($row['make'] === 'Bomag') echo 'selected'; ?>>Bomag</option>
<option value="Case" <?php if($row['make'] === 'Case') echo 'selected'; ?>>Case</option>
<option value="Cat" <?php if($row['make'] === 'Cat') echo 'selected'; ?>>Cat</option>
<option value="Cranex" <?php if($row['make'] === 'Cranex') echo 'selected'; ?>>Cranex</option>
<option value="Casagrande" <?php if($row['make'] === 'Casagrande') echo 'selected'; ?>>Casagrande</option>
<option value="Coles" <?php if($row['make'] === 'Coles') echo 'selected'; ?>>Coles</option>
<option value="CHS" <?php if($row['make'] === 'CHS') echo 'selected'; ?>>CHS</option>
<option value="Doosan" <?php if($row['make'] === 'Doosan') echo 'selected'; ?>>Doosan</option>
<option value="Dynapac" <?php if($row['make'] === 'Dynapac') echo 'selected'; ?>>Dynapac</option>
<option value="Demag" <?php if($row['make'] === 'Demag') echo 'selected'; ?>>Demag</option>
<option value="Eicher" <?php if($row['make'] === 'Eicher') echo 'selected'; ?>>Eicher</option>
<option value="Escorts" <?php if($row['make'] === 'Escorts') echo 'selected'; ?>>Escorts</option>
<option value="Fuwa" <?php if($row['make'] === 'Fuwa') echo 'selected'; ?>>Fuwa</option>
<option value="Fushan" <?php if($row['make'] === 'Fushan') echo 'selected'; ?>>Fushan</option>
<option value="Genie" <?php if($row['make'] === 'Genie') echo 'selected'; ?>>Genie</option>
<option value="Godrej" <?php if($row['make'] === 'Godrej') echo 'selected'; ?>>Godrej</option>
<option value="Grove" <?php if($row['make'] === 'Grove') echo 'selected'; ?>>Grove</option>
<option value="HAMM AG" <?php if($row['make'] === 'HAMM AG') echo 'selected'; ?>>HAMM AG</option>
<option value="Haulott" <?php if($row['make'] === 'Haulott') echo 'selected'; ?>>Haulott</option>
<option value="Hidromek" <?php if($row['make'] === 'Hidromek') echo 'selected'; ?>>Hidromek</option>
<option value="Hydrolift" <?php if($row['make'] === 'Hydrolift') echo 'selected'; ?>>Hydrolift</option>
<option value="Hyundai" <?php if($row['make'] === 'Hyundai') echo 'selected'; ?>>Hyundai</option>
<option value="Hidrocon" <?php if($row['make'] === 'Hidrocon') echo 'selected'; ?>>Hidrocon</option>
<option value="Ingersoll Rand" <?php if($row['make'] === 'Ingersoll Rand') echo 'selected'; ?>>Ingersoll Rand</option>
<option value="Isuzu" <?php if($row['make'] === 'Isuzu') echo 'selected'; ?>>Isuzu</option>
<option value="IHI" <?php if($row['make'] === 'IHI') echo 'selected'; ?>>IHI</option>
<option value="JCB" <?php if($row['make'] === 'JCB') echo 'selected'; ?>>JCB</option>
<option value="JLG" <?php if($row['make'] === 'JLG') echo 'selected'; ?>>JLG</option>
<option value="Jaypee" <?php if($row['make'] === 'Jaypee') echo 'selected'; ?>>Jaypee</option>
<option value="Jinwoo" <?php if($row['make'] === 'Jinwoo') echo 'selected'; ?>>Jinwoo</option>
<option value="John Deere" <?php if($row['make'] === 'John Deere') echo 'selected'; ?>>John Deere</option>
<option value="Jackson" <?php if($row['make'] === 'Jackson') echo 'selected'; ?>>Jackson</option>
<option value="Kamaz" <?php if($row['make'] === 'Kamaz') echo 'selected'; ?>>Kamaz</option>
<option value="Kato" <?php if($row['make'] === 'Kato') echo 'selected'; ?>>Kato</option>
<option value="Kobelco" <?php if($row['make'] === 'Kobelco') echo 'selected'; ?>>Kobelco</option>
<option value="Komatsu" <?php if($row['make'] === 'Komatsu') echo 'selected'; ?>>Komatsu</option>
<option value="Konecranes" <?php if($row['make'] === 'Konecranes') echo 'selected'; ?>>Konecranes</option>
<option value="Kubota" <?php if($row['make'] === 'Kubota') echo 'selected'; ?>>Kubota</option>
<option value="KYB Conmat" <?php if($row['make'] === 'KYB Conmat') echo 'selected'; ?>>KYB Conmat</option>
<option value="Krupp" <?php if($row['make'] === 'Krupp') echo 'selected'; ?>>Krupp</option>
<option value="Kirloskar" <?php if($row['make'] === 'Kirloskar') echo 'selected'; ?>>Kirloskar</option>
<option value="Kohler" <?php if($row['make'] === 'Kohler') echo 'selected'; ?>>Kohler</option>
<option value="L&T" <?php if($row['make'] === 'L&T') echo 'selected'; ?>>L&T</option>
<option value="Leeboy" <?php if($row['make'] === 'Leeboy') echo 'selected'; ?>>Leeboy</option>
<option value="LGMG" <?php if($row['make'] === 'LGMG') echo 'selected'; ?>>LGMG</option>
<option value="Liebherr" <?php if($row['make'] === 'Liebherr') echo 'selected'; ?>>Liebherr</option>
<option value="Link-Belt" <?php if($row['make'] === 'Link-Belt') echo 'selected'; ?>>Link-Belt</option>
<option value="Liugong" <?php if($row['make'] === 'Liugong') echo 'selected'; ?>>Liugong</option>
<option value="Lorain" <?php if($row['make'] === 'Lorain') echo 'selected'; ?>>Lorain</option>
<option value="Mahindra" <?php if($row['make'] === 'Mahindra') echo 'selected'; ?>>Mahindra</option>
<option value="Magni" <?php if($row['make'] === 'Maqni') echo 'selected'; ?>>Maqni</option>
<option value="Manitou" <?php if($row['make'] === 'Manitou') echo 'selected'; ?>>Manitou</option>
<option value="Maintowoc" <?php if($row['make'] === 'Maintowoc') echo 'selected'; ?>>Maintowoc</option>
<option value="Marion" <?php if($row['make'] === 'Marion') echo 'selected'; ?>>Marion</option>
<option value="MAIT" <?php if($row['make'] === 'MAIT') echo 'selected'; ?>>MAIT</option>
<option value="Marchetti" <?php if($row['make'] === 'Marchetti') echo 'selected'; ?>>Marchetti</option>
<option value="Noble Lift" <?php if($row['make'] === 'Noble Lift') echo 'selected'; ?>>Noble Lift</option>
<option value="New Holland" <?php if($row['make'] === 'New Holland') echo 'selected'; ?>>New Holland</option>
<option value="Palfinger" <?php if($row['make'] === 'Palfinger') echo 'selected'; ?>>Palfinger</option>
<option value="Potain" <?php if($row['make'] === 'Potain') echo 'selected'; ?>>Potain</option>
<option value="Putzmeister" <?php if($row['make'] === 'Putzmeister') echo 'selected'; ?>>Putzmeister</option>
<option value="P&H" <?php if($row['make'] === 'P&H') echo 'selected'; ?>>P&H</option>
<option value="Pinguely" <?php if($row['make'] === 'Pinguely') echo 'selected'; ?>>Pinguely</option>
<option value="PTC" <?php if($row['make'] === 'PTC') echo 'selected'; ?>>PTC</option>
<option value="Reva" <?php if($row['make'] === 'Reva') echo 'selected'; ?>>Reva</option>
<option value="Sany" <?php if($row['make'] === 'Sany') echo 'selected'; ?>>Sany</option>
<option value="Scania" <?php if($row['make'] === 'Scania') echo 'selected'; ?>>Scania</option>
<option value="Schwing Stetter" <?php if($row['make'] === 'Schwing Stetter') echo 'selected'; ?>>Schwing Stetter</option>
<option value="SDLG" <?php if($row['make'] === 'SDLG') echo 'selected'; ?>>SDLG</option>
<option value="Sennebogen" <?php if($row['make'] === 'Sennebogen') echo 'selected'; ?>>Sennebogen</option>
<option value="Shuttle Lift" <?php if($row['make'] === 'Shuttle Lift') echo 'selected'; ?>>Shuttle Lift</option>
<option value="Skyjack" <?php if($row['make'] === 'Skyjack') echo 'selected'; ?>>Skyjack</option>
<option value="Snorkel" <?php if($row['make'] === 'Snorkel') echo 'selected'; ?>>Snorkel</option>
<option value="Soilmec" <?php if($row['make'] === 'Soilmec') echo 'selected'; ?>>Soilmec</option>
<option value="Socma" <?php if($row['make'] === 'Socma') echo 'selected'; ?>>Socma</option>
<option value="Sunward" <?php if($row['make'] === 'Sunward') echo 'selected'; ?>>Sunward</option>
<option value="Tadano" <?php if($row['make'] === 'Tadano') echo 'selected'; ?>>Tadano</option>
<option value="Tata Hitachi" <?php if($row['make'] === 'Tata Hitachi') echo 'selected'; ?>>Tata Hitachi</option>
<option value="TATA" <?php if($row['make'] === 'TATA') echo 'selected'; ?>>TATA</option>
<option value="Terex" <?php if($row['make'] === 'Terex') echo 'selected'; ?>>Terex</option>
<option value="TIL" <?php if($row['make'] === 'TIL') echo 'selected'; ?>>TIL</option>
<option value="Toyota" <?php if($row['make'] === 'Toyota') echo 'selected'; ?>>Toyota</option>
<option value="Teupen" <?php if($row['make'] === 'Teupen') echo 'selected'; ?>>Teupen</option>
<option value="Unicon" <?php if($row['make'] === 'Unicon') echo 'selected'; ?>>Unicon</option>
<option value="URB Engineering" <?php if($row['make'] === 'URB Engineering') echo 'selected'; ?>>URB Engineering</option>
<option value="Universal Construction" <?php if($row['make'] === 'Universal Construction') echo 'selected'; ?>>Universal Construction</option>
<option value="Unipave" <?php if($row['make'] === 'Unipave') echo 'selected'; ?>>Unipave</option>
<option value="Vogele" <?php if($row['make'] === 'Vogele') echo 'selected'; ?>>Vogele</option>
<option value="Volvo" <?php if($row['make'] === 'Volvo') echo 'selected'; ?>>Volvo</option>
<option value="Wirtgen Group" <?php if($row['make'] === 'Wirtgen Group') echo 'selected'; ?>>Wirtgen Group</option>
<option value="XCMG Group" <?php if($row['make'] === 'XCMG Group') echo 'selected'; ?>>XCMG Group</option>
<option value="XGMA" <?php if($row['make'] === 'XGMA') echo 'selected'; ?>>XGMA</option>
<option value="Yanmar" <?php if($row['make'] === 'Yanmar') echo 'selected'; ?>>Yanmar</option>
<option value="Zoomlion" <?php if($row['make'] === 'Zoomlion') echo 'selected'; ?>>Zoomlion</option>
<option value="ZPMC" <?php if($row['make'] === 'ZPMC') echo 'selected'; ?>>ZPMC</option>
<option value="Others" <?php if($row['make'] === 'Others') echo 'selected'; ?>>Others</option>
</select>

            </div>
            <div class="trial1">
                <input type="text" name="model" value="<?php echo $row['model'] ?>" placeholder="" class="input02">
                <label for="" class="placeholder2">Model</label>
            </div>

            </div>
            <div class="outer02">
            <div class="trial1">
                <input type="text" name="cap" value="<?php echo $row['cap'] ?>" placeholder="" class="input02">
                <label for="" class="placeholder2">Capacity</label>
            </div>
            <div class="trial1">
            <select name="unit" id="" class="input02" required>
            <option value="" disabled selected> Unit</option>
            <option value="Ton" <?php if($row['unit'] === 'Ton') echo 'selected'; ?>>Ton</option>
<option value="Kgs" <?php if($row['unit'] === 'Kgs') echo 'selected'; ?>>Kgs</option>
<option value="KnM" <?php if($row['unit'] === 'KnM') echo 'selected'; ?>>KnM</option>
<option value="Meter" <?php if($row['unit'] === 'Meter') echo 'selected'; ?>>Meter</option>
<option value="M³" <?php if($row['unit'] === 'M³') echo 'selected'; ?>>M³</option>
            </select>
            </div>
            </div>
            <p class="meterdescription">Equipment Lifting Capacity At Certain Height & Radius </p>
            <div class="outer02">
            <div class="trial1">
                    <input type="text" placeholder="" value="<?php echo $row['height'] ?>" name="height" class="input02">
                    <label for="" class="placeholder2">At Height In Meter</label>
                </div>
                <div class="trial1">
                    <input type="text" placeholder=""  value="<?php echo $row['radius'] ?>" name="radius" class="input02">
                    <label for="" class="placeholder2">At Radius In Meter</label>
                </div>

                <div class="trial1">
                    <input type="text" placeholder="" value="<?php echo $row['radiuscap'] ?>" name="radiuscap" class="input02">
                    <label for="" class="placeholder2">Capacity In Ton</label>
                </div>

            </div>
            <div class="trial1">
                <input type="number" placeholder=""  value="<?php echo $row['launchyear'] ?>" name="launchyear"  class="input02">
                <label for="" class="placeholder2">Launch Year</label>
            </div>
            <p class="meterdescription">Boom Combination:</p>
            <div class="outer02">
                <div class="trial1">
                <input type="text" name="basicmainboom"  value="<?php echo $row['basicmainboom'] ?>" placeholder="" class="input02">
                <label for="" class="placeholder2">Basic Main Boom </label>

                </div>
                <div class="trial1">
                    <input type="text" name="fixedjib"  value="<?php echo $row['fixedjib'] ?>" placeholder="" class="input02">
                    <label for="" class="placeholder2">Fixed Jib</label>
                </div>
                <div class="trial1">
                    <input type="text" name="luffing"  value="<?php echo $row['luffing'] ?>" placeholder="" class="input02">
                    <label for="" class="placeholder2">Luffing Jib</label>
                </div>
            </div>
            <p class="meterdescription" id="">Boom + Flyjib :</p>

            <div class="trial1">
                <select name="flyjib_available" id="flyjib_availability" onchange="flyjibinputinfo()" class="input02">
                        <option value=""disabled selected>Flyjib Availability</option>
                        <option <?php if($row['flyjib_available']==='Yes'){echo 'selected';} ?> value="Yes">Flyjib Availability :Yes</option>
                        <option <?php if($row['flyjib_available']==='No'){echo 'selected';} ?> value="No">Flyjib Availability :No</option>
                    </select>

                </div>

                <div class="outer02" id="jibheadingcontent">
                    <div class="trial1">
                        <input type="text" name="boom_flyjib_mainboom"  value="<?php echo $row['boom_flyjib_mainboom'] ?>" placeholder="" class="input02">
                        <label for="" class="placeholder2">Main Boom</label>
                    </div>
                     <input readonly type="text" id="plusiconinput" class="input02" value="<?php echo '+' ?>">
                    <div class="trial1">
                        <input type="text" name="boom_flyjib_flyjib"  value="<?php echo $row['boom_flyjib_flyjib'] ?>" placeholder="" class="input02">
                        <label for="" class="placeholder2">Fly Jib</label>
                    </div>

                </div>

                <p class="meterdescription" id="">Boom + Luffer :</p>

                <div class="trial1">
                <select name="luffer_available" id="luffer_availability" onchange="lufferinputinfo()" class="input02">
                        <option value=""disabled selected>Luffer Availability</option>
                        <option <?php if($row['luffer_available']==='Yes'){echo 'selected';} ?> value="Yes">Luffer Availability: Yes</option>
                        <option <?php if($row['luffer_available']==='No'){echo 'selected';} ?> value="No">Luffer Availability: No</option>
                    </select>

                </div>


                <div class="outer02" id="lufferheadingcontent">
                    <div class="trial1">
                        <input type="text" name="boom_luffer_mainboom"  value="<?php echo $row['boom_luffer_mainboom'] ?>" placeholder="" class="input02">
                        <label for="" class="placeholder2">Main Boom</label>
                    </div>
                     <input readonly type="text" id="plusiconinput" class="input02" value="<?php echo '+' ?>">
                    <div class="trial1">
                        <input type="text" name="boom_luffer_luffingjib"  value="<?php echo $row['boom_luffer_luffingjib'] ?>" placeholder="" class="input02">
                        <label for="" class="placeholder2">Luffing Jib</label>
                    </div>

                </div>
                <br>
                <div class="outer02">
                    <div class="trial1">
                        <input type="text" placeholder="" value="<?php echo $row['fueltank'] ?>" name="fueltank" class="input02">
                        <label for="" class="placeholder2">Fuel Tank</label>
                    </div>
                    <div class="trial1">
                        <input type="text" placeholder="" value="<?php echo $row['hydraulictank'] ?>" name="hydraulictank" class="input02">
                        <label for="" class="placeholder2">Hydraulic Tank</label>
                    </div>
                </div>
                <div class="outer02">
                    <div class="trial1">
                        <input type="text" placeholder="" value="<?php echo $row['enginemake'] ?>" name="enginemake" class="input02">
                        <label for="" class="placeholder2">Engine Make</label>
                    </div>
                    <div class="trial1">
                        <input type="text" placeholder="" value="<?php echo $row['enginemodel'] ?>" name="enginemodel" class="input02">
                        <label for="" class="placeholder2">Engine Model</label>
                    </div>
                </div>
                <div class="outer02">
    <div class="trial1">
        <textarea type="text" id="cw1descid" name="cw1desc" placeholder="" value="" class="input02"><?php echo $row['cw1desc'] ?></textarea>
        <label for="" class="placeholder2">CW plate description</label>
    </div>
    <div class="trial1">
        <input type="number" step="0.1" name="cw1cap" value="<?php echo $row['cw1cap'] ?>" placeholder="" class="input02">
        <label for="" class="placeholder2">Capacity In Ton</label>
    </div>
    <div class="trial1">
        <input type="number" step="0.1" name="cw1nos" value="<?php echo $row['cw1nos'] ?>" placeholder="" class="input02">
        <label for="" class="placeholder2">Nos</label>
    </div>
    <div class="trial1 abcd" id="icon1">
            <i class="fa-solid fa-plus" onclick="showcw2()"></i>
            </div>
</div>

                <div class="outer02" id="cw2">
                    <div class="trial1">
                    <textarea type="text" id="cw2descid" name="cw2desc" placeholder="" value="" class="input02"><?php echo $row['cw2desc'] ?></textarea>
                    <label for="" class="placeholder2">CW plate description</label>

                    </div>
                    <div class="trial1">
                    <input type="number" step="0.1" name="cw2cap" value="<?php echo $row['cw2cap'] ?>" placeholder=""  class="input02">
                    <label for="" class="placeholder2">Capacity In Ton</label>

                    </div>
                    <div class="trial1">
                    <input type="number" step="0.1" name="cw2nos" value="<?php echo $row['cw2nos'] ?>" placeholder=""  class="input02">
                    <label for="" class="placeholder2">Nos</label>

                    </div>
                    <div class="trial1 abcd" id="icon2">
            <i class="fa-solid fa-plus" onclick="showcw3()"></i>
            </div>


                </div>

                <div class="outer02" id="cw3">
                    <div class="trial1">
                    <textarea type="text" id="cw3descid" name="cw3desc" placeholder="" value=""  class="input02"><?php echo $row['cw3desc'] ?></textarea>
                    <label for="" class="placeholder2">CW plate description</label>

                    </div>
                    <div class="trial1">
                    <input type="number" step="0.1" name="cw3cap" placeholder="" value="<?php echo $row['cw3cap'] ?>"  class="input02">
                    <label for="" class="placeholder2">Capacity In Ton</label>

                    </div>
                    <div class="trial1">
                    <input type="number" step="0.1" name="cw3nos" value="<?php echo $row['cw3nos'] ?>"  placeholder=""  class="input02">
                    <label for="" class="placeholder2">Nos</label>

                    </div>
                    <div class="trial1 abcd" id="icon3">
            <i class="fa-solid fa-plus" onclick="showcw4()"></i>
            </div>


                </div>

                <div class="outer02" id="cw4">
                    <div class="trial1">
                    <textarea type="text" name="cw4desc" id="cw4descid" placeholder="" value=""  class="input02"><?php echo $row['cw4desc'] ?></textarea>
                    <label for="" class="placeholder2">CW plate description</label>

                    </div>
                    <div class="trial1">
                    <input type="number" step="0.1" name="cw4cap" value="<?php echo $row['cw4cap'] ?>" placeholder=""  class="input02">
                    <label for="" class="placeholder2">Capacity In Ton</label>

                    </div>
                    <div class="trial1">
                    <input type="number" step="0.1" name="cw4nos" value="<?php echo $row['cw4nos'] ?>" placeholder=""  class="input02">
                    <label for="" class="placeholder2">Nos</label>

                    </div>
                    <div class="trial1 abcd" id="icon4">
            <i class="fa-solid fa-plus" onclick="showcw5()"></i>
            </div>


                </div>

                <div class="outer02" id="cw5">
                    <div class="trial1">
                    <textarea type="text" name="cw5desc" id="cw5descid" placeholder="" value=""  class="input02"><?php echo $row['cw5desc'] ?></textarea>
                    <label for="" class="placeholder2">CW plate description</label>

                    </div>
                    <div class="trial1">
                    <input type="number" step="0.1" name="cw5cap" placeholder="" value="<?php echo $row['cw5cap'] ?>" class="input02">
                    <label for="" class="placeholder2">Capacity In Ton</label>

                    </div>
                    <div class="trial1">
                    <input type="number" step="0.1" name="cw5nos" value="<?php echo $row['cw5nos'] ?>" placeholder=""  class="input02">
                    <label for="" class="placeholder2">Nos</label>

                    </div>
                    <div class="trial1 abcd" id="icon5">
            <i class="fa-solid fa-plus" onclick="showcw6()"></i>
            </div>


                </div>

                <div class="outer02" id="cw6">
                    <div class="trial1">
                    <textarea type="text" name="cw6desc" id="cw6descid" placeholder="" value=""  class="input02"><?php echo $row['cw6desc'] ?></textarea>
                    <label for="" class="placeholder2">CW plate description</label>

                    </div>
                    <div class="trial1">
                    <input type="number" step="0.1" name="cw6cap" value="<?php echo $row['cw6cap'] ?>" placeholder=""  class="input02">
                    <label for="" class="placeholder2">Capacity In Ton</label>

                    </div>
                    <div class="trial1">
                    <input type="number" step="0.1" name="cw6nos" value="<?php echo $row['cw6nos'] ?>" placeholder=""  class="input02">
                    <label for="" class="placeholder2">Nos</label>

                    </div>

                </div>
                <p class="meterdescription">Hook blocks as per load chart</p>
                <div class="outer02">
                <div class="trial1" id="hbinput">
                    <input type="number" step="0.1" name="hook1" value="<?php echo $row['hook1'] ?>" placeholder="" class="input02">
                    <label for="" class="placeholder2">Hook Block Capacity In Ton</label>
                </div>
                <div class="trial1 abcd" id="hbicon1">
            <i class="fa-solid fa-plus" onclick="showhb2()"></i>
            </div>


                </div>                
                <div class="outer02" id="hb2">
                <div class="trial1" id="hbinput">
                    <input type="number" step="0.1" name="hook2" value="<?php echo $row['hook2'] ?>" placeholder="" class="input02">
                    <label for="" class="placeholder2">Hook Block Capacity In Ton</label>
                </div>
                <div class="trial1 abcd" id="hbicon2">
            <i class="fa-solid fa-plus" onclick="showhb3()"></i>
            </div>


                </div>                
                <div class="outer02" id="hb3">
                <div class="trial1" id="hbinput">
                    <input type="number" step="0.1" name="hook3" placeholder="" value="<?php echo $row['hook3'] ?>" class="input02">
                    <label for="" class="placeholder2">Hook Block Capacity In Ton</label>
                </div>
                <div class="trial1 abcd" id="hbicon3">
            <i class="fa-solid fa-plus" onclick="showhb4()"></i>
            </div>


                </div>                
                <div class="outer02" id="hb4">
                <div class="trial1" id="hbinput">
                    <input type="number" step="0.1" name="hook4" placeholder="" value="<?php echo $row['hook4'] ?>" class="input02">
                    <label for="" class="placeholder2">Hook Block Capacity In Ton</label>
                </div>
                <div class="trial1 abcd" id="hbicon4">
            <i class="fa-solid fa-plus" onclick="showhb5()"></i>
            </div>


                </div>                
                <div class="outer02" id="hb5">
                <div class="trial1" id="hbinput">
                    <input type="number" step="0.1" name="hook5" placeholder="" value="<?php echo $row['hook5'] ?>" class="input02">
                    <label for="" class="placeholder2">Hook Block Capacity In Ton</label>
                </div>
                <div class="trial1 abcd" id="hbicon5">
            <i class="fa-solid fa-plus" onclick="showhb6()"></i>
            </div>


                </div>                
                <div class="outer02" id="hb6">
                <div class="trial1" id="hbinput">
                    <input type="number" step="0.1" name="hook6" value="<?php echo $row['hook6'] ?>" placeholder="" class="input02">
                    <label for="" class="placeholder2">Hook Block Capacity In Ton</label>
                </div>


                </div> 
                <p class="meterdescription">Cabin Section :</p>               
                <div class="trial1">
                    <input type="text" name="cabin_dimension" value="<?php echo $row['cabin_dimension'] ?>" placeholder="" class="input02">
                    <label for="" class="placeholder2">Main Cabin Dimension</label>
                </div>
                <div class="outer02">
                    <div class="trial1">
                    <input type="text" placeholder="" value="<?php echo $row['cabinweight'] ?>" name="cabinweight" class="input02">
                    <label for="" class="placeholder2">Cabin Weight </label>

                    </div>
                    <div class="trial1" id="cabinweightunit">
                        <select name="cabinunit" id="" class="input02">
                        <option value="" disabled selected>Unit</option>
<option value="kg" <?php if($row['cabinunit'] === 'kg') echo 'selected'; ?>>Kg</option>
<option value="Ton" <?php if($row['cabinunit'] === 'Ton') echo 'selected'; ?>>Ton</option>
                        </select>
                    </div>

                    <div class="trial1">
                        <select name="cabintrailor" id="" class="input02">
                        <option value="" disabled selected>Suitable Trailor Type</option>
<option value="Axle" <?php if($row['cabintrailor'] === 'Axle') echo 'selected'; ?>>Axle</option>
<option value="LBT" <?php if($row['cabintrailor'] === 'LBT') echo 'selected'; ?>>LBT</option>
<option value="SLBT" <?php if($row['cabintrailor'] === 'SLBT') echo 'selected'; ?>>SLBT</option>
<option value="HBT" <?php if($row['cabintrailor'] === 'HBT') echo 'selected'; ?>>HBT</option>
<option value="Lorry" <?php if($row['cabintrailor'] === 'Lorry') echo 'selected'; ?>>Lorry</option>
                        </select>
                    </div>
                </div>
<p class="meterdescription">Main winch wire rope</p>
<div class="outer02">
    <div class="trial1">
        <input type="text" name="mainwinchlength" value="<?php echo $row['mainwinchlength'] ?>" placeholder="" class="input02">
        <label for="" class="placeholder2">Length/Mtrs</label>
    </div>
    <div class="trial1">
        <input type="text" name="mainwinchdia" value="<?php echo $row['mainwinchdia'] ?>" placeholder="" class="input02">
        <label for="" class="placeholder2">Dia/mm</label>
    </div>
</div>
<p class="meterdescription">Second winch wire rope</p>
<div class="outer02">
    <div class="trial1">
        <input type="text" name="secondwinchlength" value="<?php echo $row['secondwinchlength'] ?>" placeholder="" class="input02">
        <label for="" class="placeholder2">Length/Mtrs</label>
    </div>
    <div class="trial1">
        <input type="text" name="secondwinchdia" value="<?php echo $row['secondwinchdia'] ?>" placeholder="" class="input02">
        <label for="" class="placeholder2">Dia/mm</label>
    </div>
</div>
<p class="meterdescription">Auxilary winch wire rope</p>
<div class="outer02">
    <div class="trial1">
        <input type="text" name="auxiwinchlength" value="<?php echo $row['auxiwinchlength'] ?>" placeholder="" class="input02">
        <label for="" class="placeholder2">Length/Mtrs</label>
    </div>
    <div class="trial1">
        <input type="text" name="auxiwinchdia" value="<?php echo $row['auxiwinchdia'] ?>" placeholder="" class="input02">
        <label for="" class="placeholder2">Dia/mm</label>
    </div>
</div>
<div class="trial1">
    <select name="currentstatus" id="" class="input02">
        <option value=""disabled selected>Current Status</option>
        <option <?php if($row['current_status'] === 'In Production') { echo 'selected'; } ?> value="In Production">Current Status: In Production</option>
<option <?php if($row['current_status'] === 'Discontinued') { echo 'selected'; } ?> value="discontinued">Current Status: Discontinued</option>
<option <?php if($row['current_status'] === 'Limited Production') { echo 'selected'; } ?> value="limited Production">Current Status: Limited Production</option>
<option <?php if($row['current_status'] === 'Special Editions or Limited Runs') { echo 'selected'; } ?> value="special Edition">Current Status: Special Editions or Limited Runs</option>
    </select>
</div>
<div class="trial1">
    <input type="file" name="loadchart" class="input02">
    <label for="" class="placeholder2">Upload Load Chart</label>
</div>
<p class="meterdescription">Current Load Chart: <?php echo $row['loadchart'] ?></p>
<div class="trial1">
    <input type="file" name="image" class="input02">
    <label for="" class="placeholder2">Upload Image</label>
</div>
<p class="meterdescription">Current Image: <?php echo $row['image'] ?></p>

<img id="equipmentimageuploaded" src="img/<?php echo $row['image']; ?>" alt="">

                <button class="epc-button">Submit</button>


        </div>

    </form>

</body>
<script>
    document.addEventListener('DOMContentLoaded', function() {
    // Check if oem_fleet_type7 is not empty and call seco_equip_2()
    var cw2descid = document.getElementById('cw2descid');
    if (cw2descid.value !== '') {
        showcw2();
    }
});
    document.addEventListener('DOMContentLoaded', function() {
    // Check if oem_fleet_type7 is not empty and call seco_equip_2()
    var cw3descid = document.getElementById('cw3descid');
    if (cw3descid.value !== '') {
        showcw3();
    }
});

    document.addEventListener('DOMContentLoaded', function() {
    // Check if oem_fleet_type7 is not empty and call seco_equip_2()
    var cw4descid = document.getElementById('cw4descid');
    if (cw4descid.value !== '') {
        showcw4();
    }
});

    document.addEventListener('DOMContentLoaded', function() {
    // Check if oem_fleet_type7 is not empty and call seco_equip_2()
    var cw5descid = document.getElementById('cw5descid');
    if (cw5descid.value !== '') {
        showcw5();
    }
});
    document.addEventListener('DOMContentLoaded', function() {
    // Check if oem_fleet_type7 is not empty and call seco_equip_2()
    var cw6descid = document.getElementById('cw6descid');
    if (cw6descid.value !== '') {
        showcw6();
    }
});


// hookblock

document.addEventListener('DOMContentLoaded', function() {
    // Check if oem_fleet_type7 is not empty and call seco_equip_2()
    var hook2 = document.querySelector('input[name="hook2"]');
    
    if (hook2.value !== '') {
        showhb2();
    }
});

document.addEventListener('DOMContentLoaded', function() {
    // Check if oem_fleet_type7 is not empty and call seco_equip_2()
    var flyjib_availability = document.getElementById('flyjib_availability');
    if (flyjib_availability.value !== '') {
        flyjibinputinfo();
    }
});

document.addEventListener('DOMContentLoaded', function() {
    // Check if oem_fleet_type7 is not empty and call seco_equip_2()
    var luffer_availability = document.getElementById('luffer_availability');
    if (luffer_availability.value !== '') {
        lufferinputinfo();
    }
});

document.addEventListener('DOMContentLoaded', function() {
    // Check if oem_fleet_type7 is not empty and call seco_equip_2()
    var hook2 = document.querySelector('input[name="hook3"]');
    
    if (hook2.value !== '') {
        showhb3();
    }
});

document.addEventListener('DOMContentLoaded', function() {
    // Check if oem_fleet_type7 is not empty and call seco_equip_2()
    var hook4 = document.querySelector('input[name="hook4"]');
    
    if (hook4.value !== '') {
        showhb4();
    }
});

document.addEventListener('DOMContentLoaded', function() {
    // Check if oem_fleet_type7 is not empty and call seco_equip_2()
    var hook5 = document.querySelector('input[name="hook5"]');
    
    if (hook5.value !== '') {
        showhb5();
    }
});

document.addEventListener('DOMContentLoaded', function() {
    // Check if oem_fleet_type7 is not empty and call seco_equip_2()
    var hook6 = document.querySelector('input[name="hook6"]');
    
    if (hook6.value !== '') {
        showhb6();
    }
});




</script>
</html>