<?php
include 'partials/_dbconnect.php';
?>

<?php
$id = $_GET['id'];
$sql="SELECT * FROM `oem_fleet` WHERE `sno` ='$id'";
$result=mysqli_query($conn , $sql);
$row=mysqli_fetch_assoc($result);
?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
include 'partials/_dbconnect.php';

    $id_edit=$_POST['editid'];
    $make = $_POST["make"];
    $model = $_POST["model"];
    $other_make = $_POST["other_make"];
    $fleet_type = $_POST["fleet_type"];
    $fleet_sub_type = $_POST["fleet_sub_type"];
    $capacity = $_POST["capacity"];
    $cap = $_POST["unit"];
    $counter_weight = $_POST["counter_weight"];
    $superlift = $_POST["superlift"];
    $superlift_weight = $_POST["superlift_weight"];
    $engine_make = $_POST["engine_make"];
    $new_chassis_maker = $_POST["new_chassis_maker"];
    $boom_section = $_POST["boom_section"];
    $boomLength = $_POST["boomLength"];
    $jibLength = $_POST["jibLength"];
    $luffingLength = $_POST["luffingLength"];
    $dieselTankCap = $_POST["dieselTankCap"];
    $hydraulicOilTank = $_POST["hydraulicOilTank"];
    $engineOilCapacity = $_POST["engineOilCapacity"];
    $hydraulicOilGrade = $_POST["hydraulicOilGrade"];
    $engineOilGrade = $_POST["engineOilGrade"];
    $wire_rope_length = $_POST["wire_rope_length"];
    $wire_rope_diameter = $_POST["wire_rope_diameter"];
    $auxilary_wire = $_POST["auxilary_wire"];
    $auxilary_wire_diameter = $_POST["auxilary_wire_diameter"];
    $chassis_make = $_POST["chassis_make"];
    $length =$_POST['length'];
    $width=$_POST['width'];
    $height=$_POST['height'];
    $weight=$_POST['weight'];
$sql_update="UPDATE `oem_fleet` SET `chassis_make_other`='$new_chassis_maker', `other_make_brand`='$other_make' ,  `make` = '$make', `model` = '$model', `fleet_category` = '$fleet_type', `capacity` = '$capacity', `unit` = '$cap', `counter_weight` = '$counter_weight', `superlift_counter_weight` = ' $superlift', `engine_make` = '$engine_make', `boom_section` = '$boom_section', `boom_length` = '$boomLength', `jib_length` = '$jibLength', `luffing_length` = '$luffingLength', `diesel_tank_cap` = '$dieselTankCap', `hydraulic_oil_tank` = '$hydraulicOilTank', `hydraulic_oil_grade` = '$hydraulicOilGrade', `engine_oil_cap` = '$engineOilCapacity', `engine_oil_grade` = '$engineOilGrade', `wire_rope` = '$wire_rope_length', `wire_rop_dia` = '$wire_rope_diameter', `auxilary_wire_rop` = '$auxilary_wire', `auxilary_wire_rop_dia` = '$auxilary_wire_diameter', `superlift_weight_input` = '$superlift_weight', `chassis_make` = '$chassis_make', `transport_length` = '$length', `transport_width` = '$width', `transport_height` = '$height', `transport_weight` = '$weight' where `sno`='$id_edit'";
$result_update=mysqli_query($conn,$sql_update);
if($result_update){
    header("location:viewfleet.php");
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">      <link rel="icon" href="favicon.jpg" type="image/x-icon">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
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
            <li><a href="oem_dashboard.php">Dashboard</a></li>
            <li><a href="news/">News</a></li>

            <li><a href="logout.php">Log Out</a></li></ul>
        </div>
</div> 
<form action="crane_fullspecs.php" method="POST" class="oemaddfleet" autocomplete="off">
    <div class="oemfleet-container">
        <div class="add_fleet_heading">
        <p>View And Edit Fleet</p>
        </div>
        <input hidden type="text" placeholder="id" name="editid" value="<?php echo $row['sno']; ?> ">
        <div class="trial1">
        <select class="input02" name="make" > 
            <option value="" disabled selected>Choose Fleet Make</option>
  <option <?php if($row['make'] === 'ACE'){echo 'selected';} ?>  value="ACE">ACE</option>
  <option <?php if($row['make'] === 'Ajax Fiori'){echo 'selected' ;}?>  value="Ajax Fiori">Ajax Fiori</option>
  <option <?php if($row['make'] === 'AMW'){echo 'selected';} ?>  value="AMW">AMW</option>
  <option <?php if($row['make'] === 'Apollo'){echo 'selected';} ?>  value="Apollo">Apollo</option>
  <option <?php if($row['make'] === 'Aquarius'){echo 'selected';} ?>  value="Aquarius">Aquarius</option>
  <option <?php if($row['make'] === 'Ashok Leyland'){echo 'selected';}?>  value="Ashok Leyland">Ashok Leyland</option>
  <option <?php if($row['make'] === 'Atlas Copco'){echo 'selected';} ?> value="Atlas Copco">Atlas Copco</option>
  <option <?php if($row['make'] === 'Belaz'){echo 'selected';} ?>  value="Belaz">Belaz</option>
  <option <?php if($row['make'] === 'Bemi'){echo 'selected';} ?>  value="Bemi">Bemi</option>
  <option <?php if($row['make'] === 'BEML'){echo 'selected';} ?>  value="BEML">BEML</option>
  <option <?php if($row['make'] === 'Bharat Benz'){echo 'selected';} ?>  value="Bharat Benz">Bharat Benz</option>
  <option <?php if($row['make'] === 'Bob Cat'){echo 'selected';} ?> value="Bob Cat">Bob Cat</option>
  <option <?php if($row['make'] === 'Bull'){echo 'selected';} ?>  value="Bull">Bull</option>
  <option <?php if($row['make'] === 'Bauer'){echo 'selected';} ?>  value="Bauer">Bauer</option>
  <option <?php if($row['make'] === 'BMS'){echo 'selected';} ?>  value="BMS">BMS</option>
  <option <?php if($row['make'] === 'Bomag'){echo 'selected';} ?>  value="Bomag">Bomag</option>
  <option <?php if($row['make'] === 'Case'){echo 'selected';} ?>  value="Case">Case</option>
  <option <?php if($row['make'] === 'Cat'){echo 'selected';} ?>  value="Cat">Cat</option>
  <option <?php if($row['make'] === 'Cranex'){echo 'selected';} ?>  value="Cranex">Cranex</option>
  <option <?php if($row['make'] === 'Casagrande'){echo 'selected';} ?>  value="Casagrande">Casagrande</option>
  <option <?php if($row['make'] === 'Coles'){echo 'selected';} ?>  value="Coles">Coles</option>
  <option <?php if($row['make'] === 'CHS'){echo 'selected';} ?>  value="CHS">CHS</option>
    <option <?php if($row['make'] === 'Doosan'){echo 'selected';} ?> value="Doosan">Doosan</option>
    <option <?php if($row['make'] === 'Dynapac'){echo 'selected';} ?> value="Dynapac">Dynapac</option>
    <option <?php if($row['make'] === 'Demag'){echo 'selected';} ?> value="Demag">Demag</option>
    <option <?php if($row['make'] === 'Eicher'){echo 'selected';} ?> value="Eicher">Eicher</option>
    <option <?php if($row['make'] === 'Escorts'){echo 'selected';} ?> value="Escorts">Escorts</option>
    <option <?php if($row['make'] === 'Fuwa'){echo 'selected';} ?> value="Fuwa">Fuwa</option>
    <option <?php if($row['make'] === 'Fushan'){echo 'selected';} ?> value="Fushan">Fushan</option>
    <option <?php if($row['make'] === 'Genie'){echo 'selected';} ?> value="Genie">Genie</option>
    <option <?php if($row['make'] === 'Godrej'){echo 'selected';} ?> value="Godrej">Godrej</option>
    <option <?php if($row['make'] === 'Grove'){echo 'selected';} ?> value="Grove">Grove</option>
    <option <?php if($row['make'] === 'Hamm AG'){echo 'selected';}?> value="Hamm AG">Hamm AG</option>
    <option <?php if($row['make'] === 'Haulott'){echo 'selected';} ?> value="Haulott">Haulott</option>
    <option <?php if($row['make'] === 'Hidromek'){echo 'selected';} ?> value="Hidromek">Hidromek</option>
    <option <?php if($row['make'] === 'Hydrolift'){echo 'selected';} ?> value="Hydrolift">Hydrolift</option>
    <option <?php if($row['make'] === 'Hyundai'){echo 'selected';} ?> value="Hyundai">Hyundai</option>
    <option <?php if($row['make'] === 'Hidrocon'){echo 'selected';} ?> value="Hidrocon">Hidrocon</option>
    <option <?php if($row['make'] === 'Ingersoll Rand'){echo 'selected';} ?>value="Ingersoll Rand">Ingersoll Rand</option>
    <option <?php if($row['make'] === 'Isuzu'){echo 'selected';} ?> value="Isuzu">Isuzu</option>
    <option <?php if($row['make'] === 'IHI'){echo 'selected';} ?> value="IHI">IHI</option>
    <option <?php if($row['make'] === 'JCB'){echo 'selected';} ?> value="JCB">JCB</option>
    <option <?php if($row['make'] === 'JLG'){echo 'selected';} ?> value="JLG">JLG</option>
    <option <?php if($row['make'] === 'Jaypee'){echo 'selected';} ?> value="Jaypee">Jaypee</option>
    <option <?php if($row['make'] === 'Jinwoo'){echo 'selected';} ?> value="Jinwoo">Jinwoo</option>
    <option <?php if($row['make'] === 'John Deere'){echo 'selected';} ?>value="John Deere">John Deere</option>
    <option <?php if($row['make'] === 'Jackson'){echo 'selected';} ?> value="Jackson">Jackson</option>
    <option <?php if($row['make'] === 'Kamaz'){echo 'selected';} ?> value="Kamaz">Kamaz</option>
    <option <?php if($row['make'] === 'Kato'){echo 'selected';} ?> value="Kato">Kato</option>
    <option <?php if($row['make'] === 'Kobelco'){echo 'selected';} ?> value="Kobelco">Kobelco</option>
    <option <?php if($row['make'] === 'Komatsu'){echo 'selected';} ?> value="Komatsu">Komatsu</option>
    <option <?php if($row['make'] === 'Konecranes'){echo 'selected';} ?> value="Konecranes">Konecranes</option>
    <option <?php if($row['make'] === 'Kubota'){echo 'selected';} ?> value="Kubota">Kubota</option>
    <option <?php if($row['make'] === 'KYB Conmat'){echo 'selected';}?> value="KYB Conmat">KYB Conmat</option>
    <option <?php if($row['make'] === 'Krupp'){echo 'selected';} ?> value="Krupp">Krupp</option>
    <option <?php if($row['make'] === 'Kirloskar'){echo 'selected';} ?> value="Kirloskar">Kirloskar</option>
    <option <?php if($row['make'] === 'Kohler'){echo 'selected';} ?> value="Kohler">Kohler</option>
    <option <?php if($row['make'] === 'L&T'){echo 'selected';} ?> value="L&T">L&T</option>
    <option <?php if($row['make'] === 'Leeboy'){echo 'selected';} ?> value="Leeboy">Leeboy</option>
    <option <?php if($row['make'] === 'LGMG'){echo 'selected';} ?> value="LGMG">LGMG</option>
    <option <?php if($row['make'] === 'Liebherr'){echo 'selected';} ?> value="Liebherr">Liebherr</option>
    <option <?php if($row['make'] === 'Link-Belt'){echo 'selected';}?> value="Link-Belt">Link-Belt</option>
    <option <?php if($row['make'] === 'Liugong'){echo 'selected';} ?> value="Liugong">Liugong</option>
    <option <?php if($row['make'] === 'Lorain'){echo 'selected';} ?> value="Lorain">Lorain</option>
    <option <?php if($row['make'] === 'Mahindra'){echo 'selected';} ?> value="Mahindra">Mahindra</option>
    <option <?php if($row['make'] === 'Manitou'){echo 'selected';} ?> value="Manitou">Manitou</option>
    <option <?php if($row['make'] === 'Maintowoc'){echo 'selected';} ?> value="Maintowoc">Maintowoc</option>
    <option <?php if($row['make'] === 'Marion'){echo 'selected';} ?> value="Marion">Marion</option>
    <option <?php if($row['make'] === 'MAIT'){echo 'selected';} ?> value="MAIT">MAIT</option>
    <option <?php if($row['make'] === 'Marchetti'){echo 'selected';} ?> value="Marchetti">Marchetti</option>
    <option <?php if($row['make'] === 'Noble Lift'){echo 'selected';} ?>value="Noble Lift">Noble Lift</option>
    <option <?php if($row['make'] === 'New Holland'){echo 'selected';}?> value="New Holland">New Holland</option>
    <option <?php if($row['make'] === 'Palfinger'){echo 'selected';} ?> value="Palfinger">Palfinger</option>
    <option <?php if($row['make'] === 'Potain'){echo 'selected';} ?> value="Potain">Potain</option>
    <option <?php if($row['make'] === 'Putzmeister'){echo 'selected';} ?> value="Putzmeister">Putzmeister</option>
    <option <?php if($row['make'] === 'P&H'){echo 'selected';} ?>value="P&H">P&H</option>
    <option <?php if($row['make'] === 'Pinguely'){echo 'selected';} ?> value="Pinguely">Pinguely</option>
    <option <?php if($row['make'] === 'PTC'){echo 'selected';} ?> value="PTC">PTC</option>
    <option <?php if($row['make'] === 'Reva'){echo 'selected';} ?> value="Reva">Reva</option>
    <option <?php if($row['make'] === 'Sany'){echo 'selected';} ?> value="Sany">Sany</option>
    <option <?php if($row['make'] === 'Scania'){echo 'selected';} ?> value="Scania">Scania</option>
    <option <?php if($row['make'] === 'Schwing Stetter'){echo 'selected';}?> value="Schwing Stetter">Schwing Stetter</option>
    <option <?php if($row['make'] === 'SDLG'){echo 'selected';} ?> value="SDLG">SDLG</option>
    <option <?php if($row['make'] === 'Sennebogen'){echo 'selected';} ?> value="Sennebogen">Sennebogen</option>
    <option <?php if($row['make'] === 'Skyjack'){echo 'selected';} ?> value="Skyjack">Skyjack</option>
    <option <?php if($row['make'] === 'Snorkel'){echo 'selected';} ?> value="Snorkel">Snorkel</option>
    <option <?php if($row['make'] === 'Soilmec'){echo 'selected';} ?> value="Soilmec">Soilmec</option>
    <option <?php if($row['make'] === 'Sunward'){echo 'selected';} ?> value="Sunward">Sunward</option>
    <option <?php if($row['make'] === 'Tadano'){echo 'selected';} ?> value="Tadano">Tadano</option>
    <option <?php if($row['make'] === 'Tata Hitachi'){echo 'selected';}?> value="Tata Hitachi">Tata Hitachi</option>
    <option <?php if($row['make'] === 'TATA'){echo 'selected';} ?> value="TATA">TATA</option>
    <option <?php if($row['make'] === 'Terex'){echo 'selected';} ?> value="Terex">Terex</option>
    <option <?php if($row['make'] === 'TIL'){echo 'selected';} ?> value="TIL">TIL</option>
    <option <?php if($row['make'] === 'Toyota'){echo 'selected';} ?> value="Toyota">Toyota</option>
    <option <?php if($row['make'] === 'Teupen'){echo 'selected';} ?> value="Teupen">Teupen</option>
    <option <?php if($row['make'] === 'Unicon'){echo 'selected';} ?> value="Unicon">Unicon</option>
    <option <?php if($row['make'] === 'Urb Engineering'){echo 'selected';}?> value="Urb Engineering">Urb Engineering</option>
    <option <?php if($row['make'] === 'Universal Construction'){echo 'selected';}?> value="Universal Construction">Universal Construction</option>
    <option <?php if($row['make'] === 'Unipave'){echo 'selected';} ?> value="Unipave">Unipave</option>
    <option <?php if($row['make'] === 'Vogele'){echo 'selected';} ?> value="Vogele">Vogele</option>
    <option <?php if($row['make'] === 'Volvo'){echo 'selected';} ?> value="Volvo">Volvo</option>
    <option <?php if($row['make'] === 'Wirtgen Group'){echo 'selected';}?> value="Wirtgen Group">Wirtgen Group</option>
    <option <?php if($row['make'] === 'XCMG Group'){echo 'selected';}?> value="XCMG Group">XCMG Group</option>
    <option <?php if($row['make'] === 'XGMA'){echo 'selected';} ?> value="XGMA">XGMA</option>
    <option <?php if($row['make'] === 'Yanmar'){echo 'selected';} ?> value="Yanmar">Yanmar</option>
    <option <?php if($row['make'] === 'Zoomlion'){echo 'selected';} ?> value="Zoomlion">Zoomlion</option>
    <option <?php if($row['make'] === 'ZPMC'){echo 'selected';} ?> value="ZPMC">ZPMC</option>
    <option <?php if($row['make'] === 'Others'){echo 'selected';} ?> value="Others">Others</option>
</select>
</div>

<?php
$divStyle = empty($row['other_make_brand']) ? 'style="display:none"' : '';
?>

<div class="trial1"  <?php echo $divStyle; ?> >
    <input type="text" placeholder="" value="<?php echo $row['other_make_brand']; ?>" name="other_make" class="input02" >
    <label class="placeholder2">Specify Other Brand</label>
</div>
        
<div class="trial1">
    <select class="input02" name="fleet_type" id="oem_fleet_type" onchange="purchase_option()">
        <option value="" disabled selected>Select Fleet Category</option>
        <option value="Aerial Work Platform" <?php if($row['fleet_category'] === "Aerial Work Platform"){echo 'selected';} ?>>Aerial Work Platform</option>
        <option value="Concrete Equipment" <?php if($row['fleet_category'] === "Concrete Equipment"){echo 'selected';} ?>>Concrete Equipment</option>
        <option value="EarthMovers and Road Equipments" <?php if($row['fleet_category'] === "EarthMovers and Road Equipments"){echo 'selected';} ?>>EarthMovers and Road Equipments</option>
        <option value="Material Handling Equipments" <?php if($row['fleet_category'] === 'Material Handling Equipments'){echo 'selected';} ?>>Material Handling Equipments</option>
        <option value="Ground Engineering Equipments" <?php if($row['fleet_category'] === 'Ground Engineering Equipments'){echo 'selected';} ?>>Ground Engineering Equipments</option>
        <option value="Trailor and Truck" <?php if($row['fleet_category'] === 'Trailor and Truck'){echo 'selected';} ?>>Trailor and Truck</option>
        <option value="Generator and Lighting" <?php if($row['fleet_category'] === 'Generator and Lighting'){echo 'selected';} ?>>Generator and Lighting</option>
    </select>
</div>
        <div class="trial1">
        <select class="input02" name="fleet_sub_type" id="sub_type_oemaddfleet" >
            <option value="" disabled selected>Select Fleet Type</option>
            <option <?php if($row['fleet_type']=== 'Self Propelled Articulated Boomlift'){echo 'selected';}?> value="Self Propelled Articulated Boomlift"class="awp_options"  id="aerial_work_platform_option1">Self Propelled Articulated Boomlift</option>
            <option <?php if($row['fleet_type']=== 'Scissor Lift Diesel'){echo 'selected';}?> value="Scissor Lift Diesel" class="awp_options" id="aerial_work_platform_option2">Scissor Lift Diesel</option>
            <option <?php if($row['fleet_type']=== 'Scissor Lift Electric'){echo 'selected';}?> value="Scissor Lift Electric"class="awp_options"  id="aerial_work_platform_option3">Scissor Lift Electric</option>
            <option <?php if($row['fleet_type']=== 'Spider Lift'){echo 'selected';} ?> value="Spider Lift"class="awp_options"  id="aerial_work_platform_option4">Spider Lift</option>
            <option <?php if($row['fleet_type']=== 'Self Propelled Straight Boomlift'){echo 'selected';}?> value="Self Propelled Straight Boomlift"class="awp_options"  id="aerial_work_platform_option5">Self Propelled Straight Boomlift</option>
            <option <?php if($row['fleet_type']=== 'Truck Mounted Articulated Boomlift'){echo 'selected';}?> value="Truck Mounted Articulated Boomlift"class="awp_options"  id="aerial_work_platform_option6">Truck Mounted Articulated Boomlift</option>
            <option <?php if($row['fleet_type']=== 'Truck Mounted Straight Boomlift'){echo 'selected';}?> value="Truck Mounted Straight Boomlift"class="awp_options"  id="aerial_work_platform_option7">Truck Mounted Straight Boomlift</option>
            <option <?php if($row['fleet_type']=== 'Batching Plant'){echo 'selected';} ?> value="Batching Plant"class="cq_options" id="concrete_equipment_option1">Batching Plant</option>
            <option <?php if($row['fleet_type']=== 'Self Loading Mixer'){echo 'selected';} ?> value="Self Loading Mixer"class="cq_options" id="">Self Loading Mixer</option>
            <option <?php if($row['fleet_type']=== 'Concrete Boom Placer'){echo 'selected';}?> value="Concrete Boom Placer"class="cq_options" id="concrete_equipment_option2">Concrete Boom Placer</option>
            <option <?php if($row['fleet_type']=== 'Concrete Pump'){echo 'selected';} ?> value="Concrete Pump"class="cq_options" id="concrete_equipment_option3">Concrete Pump</option>
            <option <?php if($row['fleet_type']=== 'Moli Pump'){echo 'selected';} ?> value="Moli Pump"class="cq_options" id="concrete_equipment_option4">Moli Pump</option>
            <option <?php if($row['fleet_type']=== 'Mobile Batching Plant'){echo 'selected';}?> value="Mobile Batching Plant"class="cq_options" id="concrete_equipment_option5">Mobile Batching Plant</option>
            <option <?php if($row['fleet_type']=== 'Static Boom Placer'){echo 'selected';}?> value="Static Boom Placer"class="cq_options" id="concrete_equipment_option6">Static Boom Placer</option>
            <option <?php if($row['fleet_type']=== 'Transit Mixer'){echo 'selected';} ?> value="Transit Mixer"class="cq_options" id="concrete_equipment_option7">Transit Mixer</option>
            <option <?php if($row['fleet_type']=== 'Baby Roller'){echo 'selected';} ?> value="Baby Roller" class="earthmover_options" id="earthmovers_option1">Baby Roller</option>
            <option <?php if($row['fleet_type']=== 'Backhoe Loader'){echo 'selected';} ?> value="Backhoe Loader" class="earthmover_options" id="earthmovers_option2">Backhoe Loader</option>
            <option <?php if($row['fleet_type']=== 'Bulldozer'){echo 'selected';} ?> value value="Bulldozer" class="earthmover_options" id="earthmovers_option3">Bulldozer</option>
            <option <?php if($row['fleet_type']=== 'Excavator'){echo 'selected';} ?> value value="Excavator" class="earthmover_options" id="earthmovers_option4">Excavator</option>
            <option <?php if($row['fleet_type']=== 'Milling Machine'){echo 'selected';} ?> value="Milling Machine" class="earthmover_options" id="earthmovers_option5">Milling Machine</option>
            <option <?php if($row['fleet_type']=== 'Motor Grader'){echo 'selected';} ?> value="Motor Grader" class="earthmover_options" id="earthmovers_option6">Motor Grader</option>
            <option <?php if($row['fleet_type']=== 'Pneumatic Tyre Roller'){echo 'selected';}?> value="Pneumatic Tyre Roller" class="earthmover_options" id="earthmovers_option7">Pneumatic Tyre Roller</option>
            <option <?php if($row['fleet_type']=== 'Single Drum Roller'){echo 'selected';}?> value="Single Drum Roller" class="earthmover_options" id="earthmovers_option8">Single Drum Roller</option>
            <option <?php if($row['fleet_type']=== 'Skid Loader'){echo 'selected';} ?> value="Skid Loader" class="earthmover_options" id="earthmovers_option9">Skid Loader</option>
            <option <?php if($row['fleet_type']=== 'Slip Form Paver'){echo 'selected';} ?> value="Slip Form Paver" class="earthmover_options" id="earthmovers_option10">Slip Form Paver</option>
            <option <?php if($row['fleet_type']=== 'Soil Compactor'){echo 'selected';} ?> value="Soil Compactor" class="earthmover_options" id="earthmovers_option11">Soil Compactor</option>
            <option <?php if($row['fleet_type']=== 'Tandem Roller'){echo 'selected';} ?> value="Tandem Roller" class="earthmover_options" id="earthmovers_option12">Tandem Roller</option>
            <option <?php if($row['fleet_type']=== 'Vibratory Roller'){echo 'selected';} ?> value="Vibratory Roller" class="earthmover_options" id="earthmovers_option13">Vibratory Roller</option>
            <option <?php if($row['fleet_type']=== 'Wheeled Excavator'){echo 'selected';} ?> value="Wheeled Excavator" class="earthmover_options" id="earthmovers_option14">Wheeled Excavator</option>
            <option <?php if($row['fleet_type']=== 'Wheeled Loader'){echo 'selected';} ?> value="Wheeled Loader" class="earthmover_options" id="earthmovers_option15">Wheeled Loader</option>
            <option <?php if($row['fleet_type']==='Fixed Tower Crane'){ echo 'selected';} ?> id="mhe_option1"  class="mhe_options" value="Fixed Tower Crane">Fixed Tower Crane</option>
            <option <?php if($row['fleet_type']==='Fork Lift Diesel'){ echo 'selected';} ?> id="mhe_option2" class="mhe_options" value="Fork Lift Diesel">Fork Lift Diesel</option>
            <option <?php if($row['fleet_type']==='Fork Lift Electric'){ echo 'selected';} ?> id="mhe_option3" class="mhe_options" value="Fork Lift Electric">Fork Lift Electric</option>
            <option <?php if($row['fleet_type']==='Hammerhead Tower Crane'){ echo 'selected';} ?> id="mhe_option4" class="mhe_options" value="Hammerhead Tower Crane">Hammerhead Tower Crane</option>
            <option <?php if($row['fleet_type']==='Hydraulic Crawler Crane'){ echo 'selected';} ?> id="mhe_option5" class="mhe_options" value="Hydraulic Crawler Crane">Hydraulic Crawler Crane</option>
            <option <?php if($row['fleet_type']==='Luffing Jib Tower Crane'){ echo 'selected';}?> id="mhe_option6" class="mhe_options" value="Luffing Jib Tower Crane">Luffing Jib Tower Crane</option>
            <option <?php if($row['fleet_type']==='Mechanical Crawler Crane'){ echo 'selected';} ?> id="mhe_option7" class="mhe_options" value="Mechanical Crawler Crane">Mechanical Crawler Crane</option>
            <option <?php if($row['fleet_type']==='Pick and Carry Crane'){ echo 'selected';}?> id="mhe_option8" class="mhe_options" value="Pick and Carry Crane">Pick and Carry Crane</option>
            <option <?php if($row['fleet_type']==='Reach Stacker'){ echo 'selected';} ?> value id="mhe_option9" class="mhe_options" value="Reach Stacker">Reach Stacker</option>
            <option <?php if($row['fleet_type']==='Rough Terrain Crane'){echo 'selected';} ?> id="mhe_option10" class="mhe_options" value="Rough Terrain Crane">Rough Terrain Crane</option>
            <option <?php if($row['fleet_type']==='Telehandler'){echo 'selected';} ?> value=" id="mhe_option11" class="mhe_options" value="Telehandler">Telehandler</option>
            <option <?php if($row['fleet_type']==='Telescopic Crawler Crane'){echo 'selected';} ?> id="mhe_option12" class="mhe_options" value="Telescopic Crawler Crane">Telescopic Crawler Crane</option>
            <option <?php if($row['fleet_type']==='Telescopic Mobile Crane'){echo 'selected';} ?> id="mhe_option13" class="mhe_options" value="Telescopic Mobile Crane">Telescopic Mobile Crane</option>
            <option <?php if($row['fleet_type']==='All Terrain Mobile Crane'){echo 'selected';} ?> id="mhe_option14" class="mhe_options" value="All Terrain Mobile Crane">All Terrain Mobile Crane</option>
            <option <?php if($row['fleet_type']==='Self Loading Truck Crane'){echo 'selected';} ?>id="mhe_option15" class="mhe_options" value="Self Loading Truck Crane">Self Loading Truck Crane</option>

            <option id="ground_engineering_equipment_option1" <?php if($row['fleet_type']=== 'Hydraulic Drilling Rig') {echo 'selected';} ?> class="gee_options" value="Hydraulic Drilling Rig">Hydraulic Drilling Rig</option>
            <option id="ground_engineering_equipment_option2" <?php if($row['fleet_type']=== 'Rotary Drilling Rig'){echo 'selected';} ?> class="gee_options" value="Rotary Drilling Rig">Rotary Drilling Rig</option>
            <option id="ground_engineering_equipment_option3" <?php if($row['fleet_type']=== 'Vibro Hammer'){echo 'selected';} ?> class="gee_options" value="Vibro Hammer">Vibro Hammer</option>
            <option id="trailor_option1" <?php if($row['fleet_type']==='Dumper'){echo 'selected';} ?>  class="trailor_options" value="Dumper">Dumper</option>
            <option id="trailor_option2" <?php if($row['fleet_type']==='Truck'){echo 'selected';} ?>  class="trailor_options" value="Truck">Truck</option>
            <option id="trailor_option3" <?php if($row['fleet_type']==='Water Tanker'){echo 'selected';} ?> class="trailor_options" value="Water Tanker">Water Tanker</option>
            <option id="trailor_option4"  <?php if($row['fleet_type']==='Low Bed'){echo 'selected';}?>  class="trailor_options" value="Low Bed">Low Bed</option>
            <option id="trailor_option5"  <?php if($row['fleet_type']==='Semi Low Bed'){echo 'selected';}?> class="trailor_options" value="Semi Low Bed">Semi Low Bed</option>
            <option id="trailor_option6" <?php if($row['fleet_type']==='Flatbed'){echo 'selected';} ?>  class="trailor_options" value="Flatbed">Flatbed</option>
            <option id="trailor_option7" <?php if($row['fleet_type']==='Hydraulic Axle'){echo 'selected';}?>  class="trailor_options" value="Hydraulic Axle">Hydraulic Axle</option>
            <option id="generator_option1" <?php if($row['fleet_type']==='Silent Diesel Generator'){echo 'selected';}?> class="generator_options" value="Silent Diesel Generator">Silent Diesel Generator</option>
            <option id="generator_option2" <?php if($row['fleet_type']==='Mobile Light Tower'){echo 'selected';}?> class="generator_options" value="Mobile Light Tower">Mobile Light Tower</option>
            <option id="generator_option3" <?php if($row['fleet_type']==='Diesel Generator'){echo 'selected';} ?> class="generator_options" value="Diesel Generator">Diesel Generator</option>
        </select>
        </div>
        <div class="trial1">
        <input type="text" placeholder="" value="<?php echo $row['model'] ?>" class="input02" name="model" >
        <label class="placeholder2">Model</label>
        </div>
        <div class="capacity" class="input02" >
        <div class="trial1">
        <input class="input02" type="text" value="<?php echo $row['capacity'] ?>" name="capacity" placeholder="" >
        <label class="placeholder2">Capacity</label>
        </div>
        <div class="trial1">
        <select class="input02" name="unit" id="" >
            <option value="ton" <?php if($row['unit']==='ton'){echo 'selected';} ?>>Ton</option>
            <option value="meter" <?php if($row['unit']==='meter'){echo 'selected';} ?>>Meter</option>
            <option class="unit"value="m^3" <?php if($row['unit']==='m^3'){echo 'selected';} ?>>m³</option>
        </select>
        </div>
        </div>
        <div class="trial1">
        <input type="text"id="counter_weight_input" value="<?php echo $row['counter_weight'] ?>" name="counter_weight" placeholder="" class="input02" >
        <label class="placeholder2">Counter Weight</label>
        </div>
        <div class="trial1">
        <select name="superlift" class="input02">
    <option value="" disabled selected>SuperLift Counter Weight?</option>
    <option value="yes" <?php if($row['superlift_counter_weight']==='yes'){ echo 'selected';} ?>>Yes</option>
    <option value="no" <?php if($row['superlift_counter_weight']==='no'){ echo 'selected';} ?> >No</option>
</select>
        </div>
        <?php
$divStyle1 = empty($row['superlift_weight_input']) ? 'style="display:none"' : '';
?>

<div class="trial1"    <?php echo $divStyle1; ?>>
    <input type="text" name="superlift_weight" value="<?php echo $row['superlift_weight_input']; ?>" class="input02" placeholder="" "">
    <label class="placeholder2">Superlift Weight</label>
</div>
        <div class="trial1">
        <input type="text" class="input02" value="<?php echo $row['engine_make'] ?>" name="engine_make" placeholder="" "" >
        <label class="placeholder2">Engine Make</label>
        </div>
        <div class="trial1">
        <select name="chassis_make" class="input02 " id="chassis_make_oem"   >
            <option value="">Choose Chassis Make</option>
            <option value="AWM" <?php if($row['chassis_make']==='AWM'){echo 'selected';} ?>>AWM</option>
            <option value="Eicher" <?php if($row['chassis_make']==='Eicher'){echo 'selected';} ?>>Eicher</option>
            <option value="TATA" <?php if($row['chassis_make']==='TATA'){echo 'selected';} ?>>TATA</option>
            <option value="Bharat Benz" <?php if($row['chassis_make']==='Bharat Benz'){echo 'selected';} ?>>Bharat Benz</option>
            <option value="Ashok Leyland" <?php if($row['chassis_make']==='Ashok Leyland'){echo 'selected';} ?>>Ashok Leyland</option>
            <option value="Volvo" <?php if($row['chassis_make']==='Volvo'){echo 'selected';} ?>>Volvo</option>
            <option value="Other" <?php if($row['chassis_make']==='Other'){echo 'selected';} ?>>Other</option>
        </select>
        </div>
        <?php
$divStyle2 = empty($row['chassis_make_other']) ? 'style="display:none"' : '';
?>

<div class="trial1"  <?php echo $divStyle2; ?>>
    <input type="text" name="new_chassis_maker" placeholder="" value="<?php echo $row['chassis_make_other']; ?>" class="input02" >
    <label class="placeholder2">Specify Other Chassis Make</label>
</div>
        <div class="trial1">
        <select  class="input02" name="boom_section" id="" "">
            <option value="disabled selected">Boom Section Value</option>
            <option value="1" <?php if($row['boom_section']==='1'){echo 'selected';} ?>>1</option>
            <option value="2" <?php if($row['boom_section']==='2'){echo 'selected';} ?>>2</option>
            <option value="3" <?php if($row['boom_section']==='3'){echo 'selected';} ?>>3</option>
            <option value="4" <?php if($row['boom_section']==='4'){echo 'selected';} ?>>4</option>
            <option value="5" <?php if($row['boom_section']==='5'){echo 'selected';} ?>>5</option>
            <option value="6" <?php if($row['boom_section']==='6'){echo 'selected';} ?>>6</option>
            <option value="7" <?php if($row['boom_section']==='7'){echo 'selected';} ?>>7</option>
            <option value="8" <?php if($row['boom_section']==='8'){echo 'selected';} ?>>8</option>
            <option value="9" <?php if($row['boom_section']==='9'){echo 'selected';} ?>>9</option>
            <option value="10" <?php if($row['boom_section']==='10'){echo 'selected';} ?>>10</option>

        </select>
        </div>
        <div class="trial1">
        <input type="text" name="companyname" value="<?php echo $row['companyname'] ?>" placeholder="" class="input02" value="<?php echo $companyname; ?>" "" >
        <label class="placeholder2">Company name</label>
        </div>
        <!-- <div class="fourthrow" id="oem_addfleet_jib"> -->
        <?php
$boomLengthStyle = empty($row['boom_length']) ? 'style="display:none"' : '';
$jibLengthStyle = empty($row['jib_length']) ? 'style="display:none"' : '';
$luffingLengthStyle = empty($row['luffing_length']) ? 'style="display:none"' : '';
?>

<div class="trial1" <?php echo $boomLengthStyle; ?>>
    <input type="text" name="boomLength" value="<?php echo $row['boom_length']; ?>" placeholder="" class="input02" "">
    <label class="placeholder2">Boom length In Meter</label>
</div>

<div class="trial1"   <?php echo $jibLengthStyle; ?>>
    <input type="text" name="jibLength" placeholder="" value="<?php echo $row['jib_length']; ?>" class="input02" "">
    <label class="placeholder2">Jib length</label>
</div>

<div class="trial1" <?php echo $luffingLengthStyle; ?>>
    <input type="text" name="luffingLength" placeholder="" value="<?php echo $row['luffing_length']; ?>" class="input02" "">
    <label class="placeholder2">Luffing length</label>
</div>
        <!-- </div> -->
        <div class="trial1">
        <input type="text" name="dieselTankCap" placeholder="" value="<?php echo $row['diesel_tank_cap'] ?>" class="input02" "">
        <label class="placeholder2">Diesel tank capacity</label>
        </div>

        <div class="capacity" class="input02" >
            <div class="trial1">
        <input type="text" name="hydraulicOilTank" value="<?php echo $row['hydraulic_oil_tank'] ?>" placeholder="" class="input02" "">
        <label class="placeholder2">Hydraulic oil tank</label>
            </div>
            <div class="trial1">   
        <input type="text" name="hydraulicOilGrade" placeholder="" value="<?php echo $row['hydraulic_oil_grade'] ?>" class="input02" "">
        <label class="placeholder2">Hydraulic oil grade</label>
            </div>
        </div>
        <div class="capacity" class="input02" >
        <div class="trial1"> 
        <input type="text" name="engineOilCapacity" placeholder="" value="<?php echo $row['engine_oil_cap'] ?>" class="input02" "">
        <label class="placeholder2">Engine oil capacity</label>
        </div>
        <div class="trial1"> 
        <input type="text" name="engineOilGrade" placeholder="" value="<?php echo $row['engine_oil_grade'] ?>" class="input02" "">
        <label class="placeholder2">Engine oil grade</label>
        </div>
        </div>
        <div class="capacity" class="input02" >
        <div class="trial1">   
        <input type="text" name="wire_rope_length" value="<?php echo $row['wire_rope'] ?>" placeholder="" class="input02" "">
        <label class="placeholder2">Wire Rope Length</label>
        </div>
        <div class="trial1">   
        <input type="text" name="wire_rope_diameter" placeholder="" value="<?php echo $row['wire_rop_dia'] ?>" class="input02" "">
        <label class="placeholder2">Wire Rope Diameter</label>
        </div>
        </div>
        <div class="capacity" class="input02" >
        <div class="trial1">      
        <input type="text" name="auxilary_wire" placeholder="" value="<?php echo $row['auxilary_wire_rop'] ?>" class="input02" "">
        <label class="placeholder2">Auxilary Wire Rope Length</label>
        </div>
        <div class="trial1">      
        <input type="text" name="auxilary_wire_diameter" placeholder="" value="<?php echo $row['auxilary_wire_rop_dia'] ?>" class="input02" "">
        <label class="placeholder2">Auxilary Wire Rope Diameter</label>
        </div>
        </div>
        <div class="trial1">
            <p class="dimensions">Transportation Dimensions -</p>
        </div>
        <div class="fourthrow">
        <div class="trial1">
            <input type="text" placeholder="" value="<?php echo $row['transport_length'] ?>" name="length" class="input02" "">
            <label class="placeholder2">Length</label>
        </div>
        <div class="trial1">
            <input type="text" placeholder="" value="<?php echo $row['transport_width'] ?>" name="width" class="input02" "">
            <label class="placeholder2">Width</label>
        </div>
        <div class="trial1">
            <input type="text" placeholder="" value="<?php echo $row['transport_height'] ?>" name="height" class="input02" "">
            <label class="placeholder2">Height</label>
        </div>
        <div class="trial1">
            <input type="text" placeholder="" value="<?php echo $row['transport_weight'] ?>" name="weight" class="input02" "">
            <label class="placeholder2">Weight In Ton</label>
        </div>
        </div>
        <button type="submit" class="epc-button">Update Fleet</button>
        <br>
    </div>
</form>
<br>
<script>


function purchase_option() {
    const options = document.getElementsByClassName('awp_options');
    const options1 = document.getElementsByClassName('cq_options');
    const options2 = document.getElementsByClassName('earthmover_options');
    const options3 = document.getElementsByClassName('mhe_options');
    const options4 = document.getElementsByClassName('gee_options');
    const options5 = document.getElementsByClassName('trailor_options');
    const options6 = document.getElementsByClassName('generator_options');

    const first_select = document.getElementById('oem_fleet_type');

    // Set the display style for all elements at once
    const displayStyle = (first_select.value === "Aerial Work Platform") ? "block" : "none";
    Array.from(options).forEach(option => option.style.display = displayStyle);

    const displayStyle1 = (first_select.value === "Concrete Equipment") ? "block" : "none";
    Array.from(options1).forEach(option => option.style.display = displayStyle1);

    const displayStyle2 = (first_select.value === "EarthMovers and Road Equipments") ? "block" : "none";
    Array.from(options2).forEach(option => option.style.display = displayStyle2);

    const displayStyle3 = (first_select.value === "Material Handling Equipments") ? "block" : "none";
    Array.from(options3).forEach(option => option.style.display = displayStyle3);

    const displayStyle4 = (first_select.value === "Ground Engineering Equipments") ? "block" : "none";
    Array.from(options4).forEach(option => option.style.display = displayStyle4);

    const displayStyle5 = (first_select.value === "Trailor and Truck") ? "block" : "none";
    Array.from(options5).forEach(option => option.style.display = displayStyle5);

    const displayStyle6 = (first_select.value === "Generator and Lighting") ? "block" : "none";
    Array.from(options6).forEach(option => option.style.display = displayStyle6);


}
</script>
</body>
</html>