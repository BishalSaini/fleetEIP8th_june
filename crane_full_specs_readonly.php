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
<form action="crane_fullspecs.php" method="POST" class="oemaddfleet" autocomplete="off" >
    <div class="oemfleet-container">
        <div class="add_fleet_heading">
        <p>View Fleet</p>
        </div>
        <input hidden type="text" placeholder="id" name="editid" value="<?php echo $row['sno']; ?> ">
        
<div class="trial1">
    <input type="text" placeholder="" class="input02" value="<?php echo$row['make'] ?>" readonly>
    <label class="placeholder2">Fleet Make</label>
</div>

<?php
$divStyle = empty($row['other_make_brand']) ? 'style="display:none"' : '';
?>

<div class="trial1"  <?php echo $divStyle; ?> >
    <input type="text" placeholder="" value="<?php echo $row['other_make_brand']; ?>" name="other_make" class="input02" readonly>
    <label class="placeholder2">Specify Other Brand</label>
</div>
        
<div class="trial1">
    <input type="text" placeholder="" class="input02" value="<?php echo$row['fleet_category'] ?>" readonly>
    <label class="placeholder2">Fleet Category</label>
</div>
        <div class="trial1">
            <input type="text" placeholder="" value="<?php echo $row['fleet_type'] ?>" class="input02" readonly>
            <label class="placeholder2">Fleet Type</label>
        </div>
        <div class="trial1">
        <input type="text" placeholder="" value="<?php echo $row['model'] ?>" class="input02" name="model"  readonly>
        <label class="placeholder2">Model</label>
        </div>
        <div class="capacity" class="input02" >
        <div class="trial1">
        <input class="input02" type="text" value="<?php echo $row['capacity'] ?>" name="capacity" placeholder="" readonly>
        <label class="placeholder2">Capacity</label>
        </div>
        <div class="trial1">
    <input type="text" placeholder="" class="input02" value="<?php echo$row['unit'] ?>" readonly>
    <!-- <label class="placeholder2">Fleet Category</label> -->
        </div>

        </div>
        <div class="trial1">
        <input type="text"id="counter_weight_input" value="<?php echo $row['counter_weight'] ?>" name="counter_weight" placeholder="" class="input02" readonly >
        <label class="placeholder2">Counter Weight</label>
        </div>
        <div class="trial1">
    <input type="text" placeholder="" class="input02" value="<?php echo$row['superlift_counter_weight'] ?>" readonly>
    <label class="placeholder2">Superlift Counter Weight</label>
</div>

        <?php
$divStyle1 = empty($row['superlift_weight_input']) ? 'style="display:none"' : '';
?>

<div class="trial1"    <?php echo $divStyle1; ?>>
    <input type="text" name="superlift_weight" value="<?php echo $row['superlift_weight_input']; ?>" class="input02" placeholder="" readonly>
    <label class="placeholder2">Superlift Weight</label>
</div>
        <div class="trial1">
        <input type="text" class="input02" value="<?php echo $row['engine_make'] ?>" name="engine_make" placeholder="" readonly>
        <label class="placeholder2">Engine Make</label>
        </div>
        <div class="trial1">
    <input type="text" placeholder="" class="input02" value="<?php echo$row['chassis_make'] ?>" readonly>
    <label class="placeholder2">Chassis Make</label>
</div>
        <?php
$divStyle2 = empty($row['chassis_make_other']) ? 'style="display:none"' : '';
?>

<div class="trial1"  <?php echo $divStyle2; ?>>
    <input type="text" name="new_chassis_maker" placeholder="" value="<?php echo $row['chassis_make_other']; ?>" class="input02" readonly >
    <label class="placeholder2">Specify Other Chassis Make</label>
</div>
<div class="trial1">
    <input type="text" placeholder="" class="input02" value="<?php echo$row['boom_section'] ?>" readonly>
    <label class="placeholder2">Boom Section</label>
</div>
        <div class="trial1">
        <input type="text" name="companyname" value="<?php echo $row['companyname'] ?>" placeholder="" class="input02" readonly >
        <label class="placeholder2">Company name</label>
        </div>
        <!-- <div class="fourthrow" id="oem_addfleet_jib"> -->
        <?php
$boomLengthStyle = empty($row['boom_length']) ? 'style="display:none"' : '';
$jibLengthStyle = empty($row['jib_length']) ? 'style="display:none"' : '';
$luffingLengthStyle = empty($row['luffing_length']) ? 'style="display:none"' : '';
?>

<div class="trial1" <?php echo $boomLengthStyle; ?>>
    <input type="text" name="boomLength" value="<?php echo $row['boom_length']; ?>" placeholder="" class="input02" readonly>
    <label class="placeholder2">Boom length In Meter</label>
</div>

<div class="trial1"   <?php echo $jibLengthStyle; ?>>
    <input type="text" name="jibLength" placeholder="" value="<?php echo $row['jib_length']; ?>" class="input02"readonly>
    <label class="placeholder2">Jib length</label>
</div>

<div class="trial1" <?php echo $luffingLengthStyle; ?>>
    <input type="text" name="luffingLength" placeholder="" value="<?php echo $row['luffing_length']; ?>" class="input02" readonly>
    <label class="placeholder2">Luffing length</label>
</div>
        <!-- </div> -->
        <div class="trial1">
        <input type="text" name="dieselTankCap" placeholder="" value="<?php echo $row['diesel_tank_cap'] ?>" class="input02" readonly>
        <label class="placeholder2">Diesel tank capacity</label>
        </div>

        <div class="capacity" class="input02" >
            <div class="trial1">
        <input type="text" name="hydraulicOilTank" value="<?php echo $row['hydraulic_oil_tank'] ?>" placeholder="" class="input02" readonly>
        <label class="placeholder2">Hydraulic oil tank</label>
            </div>
            <div class="trial1">   
        <input type="text" name="hydraulicOilGrade" placeholder="" value="<?php echo $row['hydraulic_oil_grade'] ?>" class="input02" readonly>
        <label class="placeholder2">Hydraulic oil grade</label>
            </div>
        </div>
        <div class="capacity" class="input02" >
        <div class="trial1"> 
        <input type="text" name="engineOilCapacity" placeholder="" value="<?php echo $row['engine_oil_cap'] ?>" class="input02" readonly>
        <label class="placeholder2">Engine oil capacity</label>
        </div>
        <div class="trial1"> 
        <input type="text" name="engineOilGrade" placeholder="" value="<?php echo $row['engine_oil_grade'] ?>" class="input02" readonly>
        <label class="placeholder2">Engine oil grade</label>
        </div>
        </div>
        <div class="capacity" class="input02" >
        <div class="trial1">   
        <input type="text" name="wire_rope_length" value="<?php echo $row['wire_rope'] ?>" placeholder="" class="input02" readonly>
        <label class="placeholder2">Wire Rope Length</label>
        </div>
        <div class="trial1">   
        <input type="text" name="wire_rope_diameter" placeholder="" value="<?php echo $row['wire_rop_dia'] ?>" class="input02" readonly>
        <label class="placeholder2">Wire Rope Diameter</label>
        </div>
        </div>
        <div class="capacity" class="input02" >
        <div class="trial1">      
        <input type="text" name="auxilary_wire" placeholder="" value="<?php echo $row['auxilary_wire_rop'] ?>" class="input02" readonly>
        <label class="placeholder2">Auxilary Wire Rope Length</label>
        </div>
        <div class="trial1">      
        <input type="text" name="auxilary_wire_diameter" placeholder="" value="<?php echo $row['auxilary_wire_rop_dia'] ?>" class="input02" readonly>
        <label class="placeholder2">Auxilary Wire Rope Diameter</label>
        </div>
        </div>
        <div class="trial1">
            <p class="dimensions">Transportation Dimensions -</p>
        </div>
        <div class="fourthrow">
        <div class="trial1">
            <input type="text" placeholder="" value="<?php echo $row['transport_length'] ?>" name="length" class="input02" readonly>
            <label class="placeholder2">Length</label>
        </div>
        <div class="trial1">
            <input type="text" placeholder="" value="<?php echo $row['transport_width'] ?>" name="width" class="input02" readonly>
            <label class="placeholder2">Width</label>
        </div>
        <div class="trial1">
            <input type="text" placeholder="" value="<?php echo $row['transport_height'] ?>" name="height" class="input02" readonly>
            <label class="placeholder2">Height</label>
        </div>
        <div class="trial1">
            <input type="text" placeholder="" value="<?php echo $row['transport_weight'] ?>" name="weight" class="input02"readonly>
            <label class="placeholder2">Weight In Ton</label>
        </div>
        </div>
        <!-- <button type="submit" class="epc-button">Update Fleet</button> -->
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