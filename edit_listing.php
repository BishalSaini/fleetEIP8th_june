<?php
session_start();
$email = $_SESSION['email'];
?>
<?php 
$showError=false;
$showAlert=false;
if(isset($_SESSION['success'])){
    $showAlert=true;
    unset($_SESSION['success']);
}
else if(isset($_SESSION['error'])){
    $showError=true;
    unset($_SESSION['error']);
}

?>
<style>
<?php 
include "style.css" 
?>
</style>
<script>
    <?php include "main.js" ?>
    </script>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">      <link rel="icon" href="favicon.jpg" type="image/x-icon">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="main.js"></script>
    <title>Document</title>
</head>
<body>
    <div class="navbar1">
    <div class="logo_fleet">
    <img src="logo_fe.png" alt="FLEET EIP" onclick="window.location.href='<?php echo $dashboard_url  ?>'">
</div>

        <div class="iconcontainer">
        <ul>
      <li><a href="<?php echo $dashboard_url ?>">Dashboard</a></li>
            <li><a href="news/">News</a></li>
            <li><a href="logout.php">Log Out</a></li></ul>
        </div>
</div>
<?php 
if($showAlert){
    echo '<label>
    <input type="checkbox" class="alertCheckbox" autocomplete="off" />
    <div class="alert notice">
        <span class="alertClose">X</span>
        <span class="alertText">Equipment Edited Successfully<br class="clear"/></span>
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


?>
<?php
include('partials/_dbconnect.php');
$listing_edit_id = $_GET['id'];
$query = "SELECT * FROM `images` WHERE id ='$listing_edit_id'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
if ($row) {
    ?>
    <form action="newtrial.php"  method="post" class="edit_listing_form" enctype="multipart/form-data">
        <div class="edit_listinghead"><p>Edit Your Listing</p></div>
        <div class="innerlisting_edit_form">
            <input name="id" type="text" value="<?php echo $row['id']; ?> " hidden >
            <div class="outer02">
            <div class="trial1">
        <select class="input02"  name="fleet_category" id="oem_fleet_type" onchange="purchase_option()" required>
        <option value="" disabled selected>Select Fleet Category</option>
        <option <?php if($row['category'] === 'Aerial Work Platform'){ echo 'selected';} ?> value="Aerial Work Platform">Aerial Work Platform</option>
<option <?php if($row['category'] === 'Concrete Equipment'){ echo 'selected';} ?> value="Concrete Equipment">Concrete Equipment</option>
<option <?php if($row['category'] === 'EarthMovers and Road Equipments'){ echo 'selected';} ?> value="EarthMovers and Road Equipments">EarthMovers and Road Equipments</option>
<option <?php if($row['category'] === 'Material Handling Equipments'){ echo 'selected';} ?> value="Material Handling Equipments">Material Handling Equipments</option>
<option <?php if($row['category'] === 'Ground Engineering Equipments'){ echo 'selected';} ?> value="Ground Engineering Equipments">Ground Engineering Equipments</option>
<option <?php if($row['category'] === 'Trailor and Truck'){ echo 'selected';} ?> value="Trailor and Truck">Trailor and Truck</option>
<option <?php if($row['category'] === 'Generator and Lighting'){ echo 'selected';} ?> value="Generator and Lighting">Generator and Lighting</option>
        </select>
        </div>
        <div class="trial1">
        <select class="input02" name="type" id="fleet_sub_type" onchange="crawler_options()" required>
            <option value="" disabled selected>Select Fleet Type</option>
            <option <?php if($row['sub_type']=== 'Self Propelled Articulated Boomlift'){echo 'selected';} ?> value="Self Propelled Articulated Boomlift"class="awp_options"  id="aerial_work_platform_option1">Self Propelled Articulated Boomlift</option>
            <option <?php if($row['sub_type']=== 'Scissor Lift Diesel'){echo 'selected';} ?> value="Scissor Lift Diesel" class="awp_options" id="aerial_work_platform_option2">Scissor Lift Diesel</option>
            <option <?php if($row['sub_type']=== 'Scissor Lift Electric'){echo 'selected';} ?> value="Scissor Lift Electric"class="awp_options"  id="aerial_work_platform_option3">Scissor Lift Electric</option>
            <option <?php if($row['sub_type']=== 'Spider Lift'){echo 'selected';} ?> value="Spider Lift"class="awp_options"  id="aerial_work_platform_option4">Spider Lift</option>
            <option <?php if($row['sub_type']=== 'Self Propelled Straight Boomlift'){echo 'selected';} ?> value="Self Propelled Straight Boomlift"class="awp_options"  id="aerial_work_platform_option5">Self Propelled Straight Boomlift</option>
            <option <?php if($row['sub_type']=== 'Truck Mounted Articulated Boomlift'){echo 'selected';} ?> value="Truck Mounted Articulated Boomlift"class="awp_options"  id="aerial_work_platform_option6">Truck Mounted Articulated Boomlift</option>
            <option <?php if($row['sub_type']=== 'Truck Mounted Straight Boomlift'){echo 'selected';} ?> value="Truck Mounted Straight Boomlift"class="awp_options"  id="aerial_work_platform_option7">Truck Mounted Straight Boomlift</option>
            <option <?php if($row['sub_type']=== 'Batching Plant'){echo 'selected';} ?> value="Batching Plant"class="cq_options" id="concrete_equipment_option1">Batching Plant</option>
            <option <?php if($row['sub_type']=== 'Self Loading Mixer'){echo 'selected';} ?> value="Self Loading Mixer"class="cq_options" id="">Self Loading Mixer</option>
            <option <?php if($row['sub_type']=== 'Concrete Boom Placer'){echo 'selected';} ?> value="Concrete Boom Placer"class="cq_options" id="concrete_equipment_option2">Concrete Boom Placer</option>
            <option <?php if($row['sub_type']=== 'Concrete Pump'){echo 'selected';} ?> value="Concrete Pump"class="cq_options" id="concrete_equipment_option3">Concrete Pump</option>
            <option <?php if($row['sub_type']=== 'Moli Pump'){echo 'selected';} ?> value="Moli Pump"class="cq_options" id="concrete_equipment_option4">Moli Pump</option>
            <option <?php if($row['sub_type']=== 'Mobile Batching Plant'){echo 'selected';} ?> value="Mobile Batching Plant"class="cq_options" id="concrete_equipment_option5">Mobile Batching Plant</option>
            <option <?php if($row['sub_type']=== 'Static Boom Placer'){echo 'selected';} ?> value="Static Boom Placer"class="cq_options" id="concrete_equipment_option6">Static Boom Placer</option>
            <option <?php if($row['sub_type']=== 'Transit Mixer'){echo 'selected';} ?> value="Transit Mixer"class="cq_options" id="concrete_equipment_option7">Transit Mixer</option>
            <option <?php if($row['sub_type']=== 'Baby Roller'){echo 'selected';} ?> value="Baby Roller" class="earthmover_options" id="earthmovers_option1">Baby Roller</option>
            <option <?php if($row['sub_type']=== 'Backhoe Loader'){echo 'selected';} ?> value="Backhoe Loader" class="earthmover_options" id="earthmovers_option2">Backhoe Loader</option>
            <option <?php if($row['sub_type']=== 'Bulldozer'){echo 'selected';} ?> value="Bulldozer" class="earthmover_options" id="earthmovers_option3">Bulldozer</option>
            <option <?php if($row['sub_type']=== 'Excavator'){echo 'selected';} ?> value="Excavator" class="earthmover_options" id="earthmovers_option4">Excavator</option>
            <option <?php if($row['sub_type']=== 'Milling Machine'){echo 'selected';} ?> value="Milling Machine" class="earthmover_options" id="earthmovers_option5">Milling Machine</option>
            <option <?php if($row['sub_type']=== 'Motor Grader'){echo 'selected';} ?> value="Motor Grader" class="earthmover_options" id="earthmovers_option6">Motor Grader</option>
            <option <?php if($row['sub_type']=== 'Pneumatic Tyre Roller'){echo 'selected';} ?> value="Pneumatic Tyre Roller" class="earthmover_options" id="earthmovers_option7">Pneumatic Tyre Roller</option>
            <option <?php if($row['sub_type']=== 'Single Drum Roller'){echo 'selected';} ?> value="Single Drum Roller" class="earthmover_options" id="earthmovers_option8">Single Drum Roller</option>
            <option <?php if($row['sub_type']=== 'Skid Loader'){echo 'selected';} ?> value="Skid Loader" class="earthmover_options" id="earthmovers_option9">Skid Loader</option>
            <option <?php if($row['sub_type']=== 'Slip Form Paver'){echo 'selected';} ?> value="Slip Form Paver" class="earthmover_options" id="earthmovers_option10">Slip Form Paver</option>
            <option <?php if($row['sub_type']=== 'Soil Compactor'){echo 'selected';} ?> value="Soil Compactor" class="earthmover_options" id="earthmovers_option11">Soil Compactor</option>
            <option <?php if($row['sub_type']=== 'Tandem Roller'){echo 'selected';} ?> value="Tandem Roller" class="earthmover_options" id="earthmovers_option12">Tandem Roller</option>
            <option <?php if($row['sub_type']=== 'Vibratory Roller'){echo 'selected';} ?> value="Vibratory Roller" class="earthmover_options" id="earthmovers_option13">Vibratory Roller</option>
            <option <?php if($row['sub_type']=== 'Wheeled Excavator'){echo 'selected';} ?> value="Wheeled Excavator" class="earthmover_options" id="earthmovers_option14">Wheeled Excavator</option>
            <option <?php if($row['sub_type']=== 'Wheeled Loader'){echo 'selected';} ?> value="Wheeled Loader" class="earthmover_options" id="earthmovers_option15">Wheeled Loader</option>
            <option id="mhe_option1"  class="mhe_options"<?php if($row['sub_type']==='Fixed Tower Crane'){ echo 'selected';} ?> value="Fixed Tower Crane">Fixed Tower Crane</option>
            <option id="mhe_option2" class="mhe_options" <?php if($row['sub_type']==='Fork Lift Diesel'){ echo 'selected';} ?> value="Fork Lift Diesel">Fork Lift Diesel</option>
            <option id="mhe_option3" class="mhe_options" <?php if($row['sub_type']==='Fork Lift Electric'){ echo 'selected';} ?> value="Fork Lift Electric">Fork Lift Electric</option>
            <option id="mhe_option4" class="mhe_options" <?php if($row['sub_type']==='Hammerhead Tower Crane'){ echo 'selected';} ?> value="Hammerhead Tower Crane">Hammerhead Tower Crane</option>
            <option id="mhe_option5" class="mhe_options" <?php if($row['sub_type']==='Hydraulic Crawler Crane'){ echo 'selected';} ?> value="Hydraulic Crawler Crane">Hydraulic Crawler Crane</option>
            <option id="mhe_option6" class="mhe_options" <?php if($row['sub_type']==='Luffing Jib Tower Crane'){ echo 'selected';} ?> value="Luffing Jib Tower Crane">Luffing Jib Tower Crane</option>
            <option id="mhe_option7" class="mhe_options" <?php if($row['sub_type']==='Mechanical Crawler Crane'){ echo 'selected';} ?> value="Mechanical Crawler Crane">Mechanical Crawler Crane</option>
            <option id="mhe_option8" class="mhe_options" <?php if($row['sub_type']==='Pick and Carry Crane'){ echo 'selected';} ?> value="Pick and Carry Crane">Pick and Carry Crane</option>
            <option id="mhe_option9" class="mhe_options" <?php if($row['sub_type']==='Reach Stacker'){ echo 'selected';} ?> value="Reach Stacker">Reach Stacker</option>
            <option id="mhe_option10" class="mhe_options" <?php if($row['sub_type']==='Rough Terrain Crane'){echo 'selected';} ?> value="Rough Terrain Crane">Rough Terrain Crane</option>
            <option id="mhe_option11" class="mhe_options" <?php if($row['sub_type']==='Telehandler'){echo 'selected';} ?> value="Telehandler">Telehandler</option>
            <option id="mhe_option12" class="mhe_options" <?php if($row['sub_type']==='Telescopic Crawler Crane'){echo 'selected';} ?> value="Telescopic Crawler Crane">Telescopic Crawler Crane</option>
            <option id="mhe_option13" class="mhe_options" <?php if($row['sub_type']==='Telescopic Mobile Crane'){echo 'selected';} ?> value="Telescopic Mobile Crane">Telescopic Mobile Crane</option>
            <option id="mhe_option14" class="mhe_options" <?php if($row['sub_type']==='All Terrain Mobile Crane'){echo 'selected';} ?> value="All Terrain Mobile Crane">All Terrain Mobile Crane</option>
            <option id="mhe_option15" class="mhe_options" <?php if($row['sub_type']==='Self Loading Truck Crane'){echo 'selected';} ?> value="Self Loading Truck Crane">Self Loading Truck Crane</option>

            <option id="ground_engineering_equipment_option1" class="gee_options" <?php if($row['sub_type']=== 'Hydraulic Drilling Rig') {echo 'selected';} ?>  value="Hydraulic Drilling Rig">Hydraulic Drilling Rig</option>
            <option id="ground_engineering_equipment_option2" class="gee_options" <?php if($row['sub_type']=== 'Rotary Drilling Rig'){echo 'selected';} ?> value="Rotary Drilling Rig">Rotary Drilling Rig</option>
            <option id="ground_engineering_equipment_option3" class="gee_options" <?php if($row['sub_type']=== 'Vibro Hammer'){echo 'selected';} ?> value="Vibro Hammer">Vibro Hammer</option>
            <option  id="trailor_option1" class="trailor_options" <?php if($row['sub_type']==='Dumper'){echo 'selected';} ?> value="Dumper">Dumper</option>
            <option  id="trailor_option2" class="trailor_options" <?php if($row['sub_type']==='Truck'){echo 'selected';} ?> value="Truck">Truck</option>
            <option  id="trailor_option3" class="trailor_options" <?php if($row['sub_type']==='Water Tanker'){echo 'selected';} ?> value="Water Tanker">Water Tanker</option>
            <option id="trailor_option4"  class="trailor_options" <?php if($row['sub_type']==='Low Bed'){echo 'selected';} ?> value="Low Bed">Low Bed</option>
            <option id="trailor_option5"  class="trailor_options" <?php if($row['sub_type']==='Semi Low Bed'){echo 'selected';} ?> value="Semi Low Bed">Semi Low Bed</option>
            <option  id="trailor_option6" class="trailor_options" <?php if($row['sub_type']==='Flatbed'){echo 'selected';} ?> value="Flatbed">Flatbed</option>
            <option  id="trailor_option7" class="trailor_options" <?php if($row['sub_type']==='Hydraulic Axle'){echo 'selected';} ?> value="Hydraulic Axle">Hydraulic Axle</option>
            <option id="generator_option1" class="generator_options" <?php if($row['sub_type']==='Silent Diesel Generator'){echo 'selected';} ?> value="Silent Diesel Generator">Silent Diesel Generator</option>
            <option id="generator_option2" class="generator_options" <?php if($row['sub_type']==='Mobile Light Tower'){echo 'selected';} ?> value="Mobile Light Tower">Mobile Light Tower</option>
            <option id="generator_option3" class="generator_options" <?php if($row['sub_type']==='Diesel Generator'){echo 'selected';} ?> value="Diesel Generator">Diesel Generator</option>
        </select>
        </div>
        </div>
        <div class="outer02">
		<div class="trial1">
        <select class="input02" name="make" id="crane_make_retnal" onchange="rental_addfleet()" required> 
            <option value="" disabled selected>Fleet Make</option>
            <option <?php if($row['make'] === 'ACE') { echo 'selected'; } ?> value="ACE">ACE</option>
<option <?php if($row['make'] === 'Ajax Fiori') { echo 'selected'; } ?> value="Ajax Fiori">Ajax Fiori</option>
<option <?php if($row['make'] === 'AMW') { echo 'selected'; } ?> value="AMW">AMW</option>
<option <?php if($row['make'] === 'Apollo') { echo 'selected'; } ?> value="Apollo">Apollo</option>
<option <?php if($row['make'] === 'Aquarius') { echo 'selected'; } ?> value="Aquarius">Aquarius</option>
<option <?php if($row['make'] === 'Ashok Leyland') { echo 'selected'; } ?> value="Ashok Leyland">Ashok Leyland</option>
<option <?php if($row['make'] === 'Atlas Copco') { echo 'selected'; } ?> value="Atlas Copco">Atlas Copco</option>
<option <?php if($row['make'] === 'Belaz') { echo 'selected'; } ?> value="Belaz">Belaz</option>
<option <?php if($row['make'] === 'Bemi') { echo 'selected'; } ?> value="Bemi">Bemi</option>
<option <?php if($row['make'] === 'BEML') { echo 'selected'; } ?> value="BEML">BEML</option>
<option <?php if($row['make'] === 'Bharat Benz') { echo 'selected'; } ?> value="Bharat Benz">Bharat Benz</option>
<option <?php if($row['make'] === 'Bob Cat') { echo 'selected'; } ?> value="Bob Cat">Bob Cat</option>
<option <?php if($row['make'] === 'Bull') { echo 'selected'; } ?> value="Bull">Bull</option>
<option <?php if($row['make'] === 'Bauer') { echo 'selected'; } ?> value="Bauer">Bauer</option>
<option <?php if($row['make'] === 'BMS') { echo 'selected'; } ?> value="BMS">BMS</option>
<option <?php if($row['make'] === 'Bomag') { echo 'selected'; } ?> value="Bomag">Bomag</option>
<option <?php if($row['make'] === 'Case') { echo 'selected'; } ?> value="Case">Case</option>
<option <?php if($row['make'] === 'Cat') { echo 'selected'; } ?> value="Cat">Cat</option>
<option <?php if($row['make'] === 'Cranex') { echo 'selected'; } ?> value="Cranex">Cranex</option>
<option <?php if($row['make'] === 'Casagrande') { echo 'selected'; } ?> value="Casagrande">Casagrande</option>
<option <?php if($row['make'] === 'Coles') { echo 'selected'; } ?> value="Coles">Coles</option>
<option <?php if($row['make'] === 'CHS') { echo 'selected'; } ?> value="CHS">CHS</option>
<option <?php if($row['make'] === 'Doosan') { echo 'selected'; } ?> value="Doosan">Doosan</option>
<option <?php if($row['make'] === 'Dynapac') { echo 'selected'; } ?> value="Dynapac">Dynapac</option>
<option <?php if($row['make'] === 'Demag') { echo 'selected'; } ?> value="Demag">Demag</option>
<option <?php if($row['make'] === 'Eicher') { echo 'selected'; } ?> value="Eicher">Eicher</option>
<option <?php if($row['make'] === 'Escorts') { echo 'selected'; } ?> value="Escorts">Escorts</option>
<option <?php if($row['make'] === 'Fuwa') { echo 'selected'; } ?> value="Fuwa">Fuwa</option>
<option <?php if($row['make'] === 'Fushan') { echo 'selected'; } ?> value="Fushan">Fushan</option>
<option <?php if($row['make'] === 'Genie') { echo 'selected'; } ?> value="Genie">Genie</option>
<option <?php if($row['make'] === 'Godrej') { echo 'selected'; } ?> value="Godrej">Godrej</option>
<option <?php if($row['make'] === 'Grove') { echo 'selected'; } ?> value="Grove">Grove</option>
<option <?php if($row['make'] === 'HAMM AG') { echo 'selected'; } ?> value="HAMM AG">HAMM AG</option>
<option <?php if($row['make'] === 'Haulott') { echo 'selected'; } ?> value="Haulott">Haulott</option>
<option <?php if($row['make'] === 'Hidromek') { echo 'selected'; } ?> value="Hidromek">Hidromek</option>
<option <?php if($row['make'] === 'Hydrolift') { echo 'selected'; } ?> value="Hydrolift">Hydrolift</option>
<option <?php if($row['make'] === 'Hyundai') { echo 'selected'; } ?> value="Hyundai">Hyundai</option>
<option <?php if($row['make'] === 'Hidrocon') { echo 'selected'; } ?> value="Hidrocon">Hidrocon</option>
<option <?php if($row['make'] === 'Ingersoll Rand') { echo 'selected'; } ?> value="Ingersoll Rand">Ingersoll Rand</option>
<option <?php if($row['make'] === 'Isuzu') { echo 'selected'; } ?> value="Isuzu">Isuzu</option>
<option <?php if($row['make'] === 'IHI') { echo 'selected'; } ?> value="IHI">IHI</option>
<option <?php if($row['make'] === 'JCB') { echo 'selected'; } ?> value="JCB">JCB</option>
<option <?php if($row['make'] === 'JLG') { echo 'selected'; } ?> value="JLG">JLG</option>
<option <?php if($row['make'] === 'Jaypee') { echo 'selected'; } ?> value="Jaypee">Jaypee</option>
<option <?php if($row['make'] === 'Jinwoo') { echo 'selected'; } ?> value="Jinwoo">Jinwoo</option>
<option <?php if($row['make'] === 'John Deere') { echo 'selected'; } ?> value="John Deere">John Deere</option>
<option <?php if($row['make'] === 'Jackson') { echo 'selected'; } ?> value="Jackson">Jackson</option>
<option <?php if($row['make'] === 'Kamaz') { echo 'selected'; } ?> value="Kamaz">Kamaz</option>
<option <?php if($row['make'] === 'Kato') { echo 'selected'; } ?> value="Kato">Kato</option>
<option <?php if($row['make'] === 'Kobelco') { echo 'selected'; } ?> value="Kobelco">Kobelco</option>
<option <?php if($row['make'] === 'Komatsu') { echo 'selected'; } ?> value="Komatsu">Komatsu</option>
<option <?php if($row['make'] === 'Konecranes') { echo 'selected'; } ?> value="Konecranes">Konecranes</option>
<option <?php if($row['make'] === 'Kubota') { echo 'selected'; } ?> value="Kubota">Kubota</option>
<option <?php if($row['make'] === 'KYB Conmat') { echo 'selected'; } ?> value="KYB Conmat">KYB Conmat</option>
<option <?php if($row['make'] === 'Krupp') { echo 'selected'; } ?> value="Krupp">Krupp</option>
<option <?php if($row['make'] === 'Kirloskar') { echo 'selected'; } ?> value="Kirloskar">Kirloskar</option>
<option <?php if($row['make'] === 'Kohler') { echo 'selected'; } ?> value="Kohler">Kohler</option>
<option <?php if($row['make'] === 'L&T') { echo 'selected'; } ?> value="L&T">L&T</option>
<option <?php if($row['make'] === 'Leeboy') { echo 'selected'; } ?> value="Leeboy">Leeboy</option>
<option <?php if($row['make'] === 'LGMG') { echo 'selected'; } ?> value="LGMG">LGMG</option>
<option <?php if($row['make'] === 'Liebherr') { echo 'selected'; } ?> value="Liebherr">Liebherr</option>
<option <?php if($row['make'] === 'Link-Belt') { echo 'selected'; } ?> value="Link-Belt">Link-Belt</option>
<option <?php if($row['make'] === 'Liugong') { echo 'selected'; } ?> value="Liugong">Liugong</option>
<option <?php if($row['make'] === 'Lorain') { echo 'selected'; } ?> value="Lorain">Lorain</option>
<option <?php if($row['make'] === 'Mahindra') { echo 'selected'; } ?> value="Mahindra">Mahindra</option>
<option <?php if($row['make'] === 'Magni') { echo 'selected'; } ?> value="Magni">Magni</option>
<option <?php if($row['make'] === 'Manitou') { echo 'selected'; } ?> value="Manitou">Manitou</option>
<option <?php if($row['make'] === 'Maintowoc') { echo 'selected'; } ?> value="Maintowoc">Maintowoc</option>
<option <?php if($row['make'] === 'Marion') { echo 'selected'; } ?> value="Marion">Marion</option>
<option <?php if($row['make'] === 'MAIT') { echo 'selected'; } ?> value="MAIT">MAIT</option>
<option <?php if($row['make'] === 'Marchetti') { echo 'selected'; } ?> value="Marchetti">Marchetti</option>
<option <?php if($row['make'] === 'Noble Lift') { echo 'selected'; } ?> value="Noble Lift">Noble Lift</option>
<option <?php if($row['make'] === 'New Holland') { echo 'selected'; } ?> value="New Holland">New Holland</option>
<option <?php if($row['make'] === 'Palfinger') { echo 'selected'; } ?> value="Palfinger">Palfinger</option>
<option <?php if($row['make'] === 'Potain') { echo 'selected'; } ?> value="Potain">Potain</option>
<option <?php if($row['make'] === 'Putzmeister') { echo 'selected'; } ?> value="Putzmeister">Putzmeister</option>
<option <?php if($row['make'] === 'P&H') { echo 'selected'; } ?> value="P&H">P&H</option>
<option <?php if($row['make'] === 'Pinguely') { echo 'selected'; } ?> value="Pinguely">Pinguely</option>
<option <?php if($row['make'] === 'PTC') { echo 'selected'; } ?> value="PTC">PTC</option>
<option <?php if($row['make'] === 'Reva') { echo 'selected'; } ?> value="Reva">Reva</option>
<option <?php if($row['make'] === 'Sany') { echo 'selected'; } ?> value="Sany">Sany</option>
<option <?php if($row['make'] === 'Scania') { echo 'selected'; } ?> value="Scania">Scania</option>
<option <?php if($row['make'] === 'Schwing Stetter') { echo 'selected'; } ?> value="Schwing Stetter">Schwing Stetter</option>
<option <?php if($row['make'] === 'SDLG') { echo 'selected'; } ?> value="SDLG">SDLG</option>
<option <?php if($row['make'] === 'Sennebogen') { echo 'selected'; } ?> value="Sennebogen">Sennebogen</option>
<option <?php if($row['make'] === 'Shuttle Lift') { echo 'selected'; } ?> value="Shuttle Lift">Shuttle Lift</option>
<option <?php if($row['make'] === 'Skyjack') { echo 'selected'; } ?> value="Skyjack">Skyjack</option>
<option <?php if($row['make'] === 'Snorkel') { echo 'selected'; } ?> value="Snorkel">Snorkel</option>
<option <?php if($row['make'] === 'Soilmec') { echo 'selected'; } ?> value="Soilmec">Soilmec</option>
<option <?php if($row['make'] === 'Sunward') { echo 'selected'; } ?> value="Sunward">Sunward</option>
<option <?php if($row['make'] === 'Tadano') { echo 'selected'; } ?> value="Tadano">Tadano</option>
<option <?php if($row['make'] === 'Tata Hitachi') { echo 'selected'; } ?> value="Tata Hitachi">Tata Hitachi</option>
<option <?php if($row['make'] === 'TATA') { echo 'selected'; } ?> value="TATA">TATA</option>
<option <?php if($row['make'] === 'Terex') { echo 'selected'; } ?> value="Terex">Terex</option>
<option <?php if($row['make'] === 'TIL') { echo 'selected'; } ?> value="TIL">TIL</option>
<option <?php if($row['make'] === 'Toyota') { echo 'selected'; } ?> value="Toyota">Toyota</option>
<option <?php if($row['make'] === 'Teupen') { echo 'selected'; } ?> value="Teupen">Teupen</option>
<option <?php if($row['make'] === 'Unicon') { echo 'selected'; } ?> value="Unicon">Unicon</option>
<option <?php if($row['make'] === 'URB Engineering') { echo 'selected'; } ?> value="URB Engineering">URB Engineering</option>
<option <?php if($row['make'] === 'Universal Construction') { echo 'selected'; } ?> value="Universal Construction">Universal Construction</option>
<option <?php if($row['make'] === 'Unipave') { echo 'selected'; } ?> value="Unipave">Unipave</option>
<option <?php if($row['make'] === 'Vogele') { echo 'selected'; } ?> value="Vogele">Vogele</option>
<option <?php if($row['make'] === 'Volvo') { echo 'selected'; } ?> value="Volvo">Volvo</option>
<option <?php if($row['make'] === 'Wirtgen Group') { echo 'selected'; } ?> value="Wirtgen Group">Wirtgen Group</option>
<option <?php if($row['make'] === 'XCMG Group') { echo 'selected'; } ?> value="XCMG Group">XCMG Group</option>
<option <?php if($row['make'] === 'XGMA') { echo 'selected'; } ?> value="XGMA">XGMA</option>
<option <?php if($row['make'] === 'Yanmar') { echo 'selected'; } ?> value="Yanmar">Yanmar</option>
<option <?php if($row['make'] === 'Zoomlion') { echo 'selected'; } ?> value="Zoomlion">Zoomlion</option>
<option <?php if($row['make'] === 'ZPMC') { echo 'selected'; } ?> value="ZPMC">ZPMC</option>
<option <?php if($row['make'] === 'Others') { echo 'selected'; } ?> value="Others">Others</option>
</select>
		</div>
		<div class="trial1">
		<input type="text" class="input02" placeholder="" value="<?php echo $row['model']; ?>" name="model">
		<label class="placeholder2">Model</label>
		</div>
        <div class="trial1">
		<input type="text" class="input02" placeholder="" value="<?php echo $row['yom']; ?>" name=yom>
		<label class="placeholder2">YOM</label>
		</div>

        </div>
        <div class="outer02">
		<div class="trial1">
		<input type="text" class="input02" placeholder="" value="<?php echo $row['capacity']; ?>" name="capacity">
		<label class="placeholder2">Capacity</label>
		</div>
        <div class="trial1">
            <select name="unit" id="" class="input02">
                <option value=""disabled selected>Unit</option>
                <option <?php if($row['unit']==='Ton'){ echo 'selected';} ?> value="Ton">Ton</option>
                <option <?php if($row['unit']==='Kgs'){ echo 'selected';} ?> value="Kgs">Kgs</option>
                <option <?php if($row['unit']==='KnM'){ echo 'selected';} ?> value="KnM">KnM</option>
                <option <?php if($row['unit']==='Meter'){ echo 'selected';} ?> value="Meter">Meter</option>
                <option <?php if($row['unit']==='M³'){ echo 'selected';} ?> value="M³">M³</option>

            </select>
        </div>
		<div class="trial1">
		<input type="text" class="input02" placeholder="" value="<?php echo $row['location']; ?>" name="location">
		<label class="placeholder2">Location</label>
		</div>
        </div>
        <div class="outer02">
		<div class="trial1">
		<input type="text" class="input02" placeholder="" value="<?php echo $row['kmr'] ?>" name="kmr">
		<label class="placeholder2">KMR</label>
		</div><div class="trial1">
		<input type="text" class="input02" value="<?php echo $row['hmr'] ?>" placeholder="" name="hmr">
		<label class="placeholder2">HMR</label>
		</div>
</div>
<div class="trial1" <?php if(empty($row['registration'])){ echo 'style="display:none;"'; } ?>>
        <input type="text"  name="registration" value="<?php echo $row['registration'] ?>"  placeholder="" class="input02">
        <label class="placeholder2">Registration</label>
        </div>


        <div class="outer02" id="chassis_make_rental_outer" >
        <div class="trial1" >
        <select name="chassis_make" class="input02 chassis_makedd" id="chassis_make_rental" onchange="chassis_make_rental1()" >
            <option value="">Choose Chassis Make</option>
            <option <?php if($row['chassis_make']==='AWM'){ echo 'selected';} ?> value="AWM">AWM</option>
            <option <?php if($row['chassis_make']==='Eicher'){ echo 'selected';} ?> value="Eicher">Eicher</option>
            <option <?php if($row['chassis_make']==='TATA'){ echo 'selected';} ?> value="TATA">TATA</option>
            <option <?php if($row['chassis_make']==='Bharat Benz'){ echo 'selected';} ?> value="Bharat Benz">Bharat Benz</option>
            <option <?php if($row['chassis_make']==='Ashok Leyland'){ echo 'selected';} ?> value="Ashok Leyland">Ashok Leyland</option>
            <option <?php if($row['chassis_make']==='Volvo'){ echo 'selected';} ?> value="Volvo">Volvo</option>
            <option <?php if($row['chassis_make']==='Other'){ echo 'selected';} ?> value="Other">Other</option>
        </select>
        </div>
        <div class="trial1" id="model_number">
            <input type="text" name="model_no" placeholder="" value="<?php echo $row['model_no'] ?>" class="input02">
            <label for="" class="placeholder2">Model No</label>
        </div>
        </div>
        <!-- <div class="trial1" id="otherchassis">
        <input type="text" name="new_chassis_maker" placeholder=""   class=" input02" >
        <label class="placeholder2">Specify Other Chassis Make</label>
        </div> -->
        <div class="trial1" id="forklift_height">
            <input type="number" name="height_meter" value="<?php echo $row['height_meter'] ?>" placeholder="" class="input02">
            <label for="" class="placeholder2">Height/Meter</label>
        </div>
        <div class="outer02" id="tower_crane">
            <div class="trial1">
                <input type="number" name="total_height" value="<?php echo $row['total_height'] ?>" id="total_height_input"  placeholder="" class="input02">
                <label for="" class="placeholder2 tip_load_in_tons">Total Height In Mtr</label>
            </div>
            <div class="trial1">
                <input type="number" name="free_standing_height" value="<?php echo $row['free_standing_height'] ?>" id="free_standing_height"  placeholder="" class="input02">
                <label for="" id="" class="placeholder2 tip_load_in_tons">Free Standing Height</label>
            </div>
            <div class="trial1">
                <input type="number" name="tipload" id="tip_load_height" value="<?php echo $row['tip_load'] ?>" placeholder="" class="input02">
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
            <div class="outer02" id="length_container">
        <div class="trial1" id="boom_input" >
            <input type="number" name="boom_length" value="<?php echo $row['boomlength'] ?>"  placeholder="" class=" input02" >
            <label class="placeholder2">Boom Length</label>
        </div>    
        <div class="trial1" id="jib_input">
            <input type="number" name="jib_length" value="<?php echo $row['jiblength'] ?>" placeholder="" class="input02 " >
            <label class="placeholder2">Jib Length</label>
        </div>
        <div class="trial1" id="luffing_input">
            <input type="number" name="luffing_length" value="<?php echo $row['luffinglength'] ?>" placeholder="" class=" input02" >
            <label class="placeholder2">Luffing Length</label>
        </div>
        </div>
        <div class="trial1" id="kealy_length">
            <input type="text" name='kealy' value="<?php echo $row['kaely'] ?>" placeholder="" class="input02">
            <label for="" class="placeholder2">Kealy Length</label>
        </div>
        <div class="trial1" id="pipelength">
            <input type="text" name='pipeline' value="<?php echo $row['pipeline'] ?>" placeholder="" class="input02">
            <label for="" class="placeholder2">Pipeline Length</label>
        </div>
        <div class="outer02" id="silos_container">
            <div class="trial1">
                <select name="silos_no" id="" class="input02">
                    <option value=""disabled selected>Silos No</option>
                    <option <?php if($row['silos_no']==='1'){ echo 'selected';} ?> value="1">1</option>
                    <option <?php if($row['silos_no']==='2'){ echo 'selected';} ?> value="2">2</option>
                    <option <?php if($row['silos_no']==='3'){ echo 'selected';} ?> value="3">3</option>
                    <option <?php if($row['silos_no']==='4'){ echo 'selected';} ?> value="4">4</option>
                    <option <?php if($row['silos_no']==='5'){ echo 'selected';} ?> value="5">5</option>
                </select>
            </div>
            <div class="trial1">
                <input type="text" name="cement_silos" value="<?php echo $row['cmnt_silos'] ?>" placeholder="" class="input02">
                <label for="" class="placeholder2">Cement Silos No</label>
            </div>
            <div class="trial1">
                <input type="text" value="<?php echo $row['flyash_silos'] ?>" name="flyash_silos" placeholder="" class="input02">
                <label for="" class="placeholder2">Flyash Silos No</label>
            </div>

        </div>
        <div class="outer02" id="silos_qty_container">
        <div class="trial1">
                <input type="text" value="<?php echo $row['cmnt_silos_qty'] ?>" name="cement_silos_qty" placeholder="" class="input02">
                <label for="" class="placeholder2">Cement Silos Qty</label>
            </div>
            <div class="trial1">
                <input type="text" value="<?php echo $row['flyash_silos_qty'] ?>" name="flyash_silos_qty" placeholder="" class="input02">
                <label for="" class="placeholder2">Flyash Silos Qty</label>
            </div>
                <div class="trial1">
                    <select name="chiller_available" id="" class="input02"> 
                        <option value=""disable selected>Chiller?</option>
                        <option <?php if($row['chiller']==='Yes'){ echo 'selected';} ?> value="Yes">Available</option>
                        <option <?php if($row['chiller']==='No'){ echo 'selected';} ?> value="No">Not Available</option>
                    </select>
                </div>

        </div>


        <div class="outer02">
		<div class="trial1">
		<input type="text" class="input02" placeholder="" value="<?php echo $row['price']; ?>" name="price">
		<label class="placeholder2">Price </label>
		</div>
        <div class="trial1">
		<input type="text" class="input02" placeholder="" value="<?php echo $row['contact_no']; ?>" name="contact_no">
		<label class="placeholder2">Contact Number</label>
		</div>
        </div>
        <div class="trial1">
		<textarea type="text" class="input02" placeholder=""  name="crane_desc"><?php echo $row['description']; ?></textarea>
		<label class="placeholder2">Crane Description</label>
		</div>

        <?php
        echo '<div class="trial123">';
        echo '<h4> Uploaded Images</h4>';
        echo "<img class='first_img input02' src='img/" . $row['front_pic'] . "' >";   
        echo "<img class='first_img input02' src='img/" . $row['left_side_pic'] . "' >";   
        echo "<img class='first_img input02' src='img/" . $row['right_side_pic'] . "' >";   
        echo'</div>';                        
        ?>
        <!-- <div class="trial1">
            <select name="" id="edit_uploaded_images" class="input02" onchange="showPhoto()">
                <option value="" disabled selected>Do You Want To Edit the pictures uploaded</option>
                <option value="yes">Yes</option>
                <option value="no">No</option>
            </select>
        </div> -->
        <div class="trial1" id="picture1" >
        <input type="file" class="input02" name="my_image" >
        <label class="placeholder2">Front Picture</label>
        </div>
		<div class="trial1" id="picture2">
		<input type="file" class="input02" name="my_image2">
		<label class="placeholder2">Left Side Picture</label>
        </div>
		<div class="trial1" id="picture3">
		<input type="file" class="input02"  name="my_image3">
		<label class="placeholder2">Right Side Picture</label>
		</div> 
        <input type="submit" class="epc-button" name="submit" value="Edit">
        <br>

        </div>
    </form>
 <?php   
} 
?>





    

</body>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Check if oem_fleet_type1 is not empty and call seco_equip()
    var oem_fleet_type = document.getElementById('oem_fleet_type');
    if (oem_fleet_type.value !== '') {
        purchase_option();
    }
});

document.addEventListener('DOMContentLoaded', function() {
    // Check if oem_fleet_type1 is not empty and call seco_equip()
    var fleet_sub_type = document.getElementById('fleet_sub_type');
    if (fleet_sub_type.value !== '') {
        crawler_options();
    }
});


</script>
</html>