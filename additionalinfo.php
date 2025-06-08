<?php
session_start();
$email = $_SESSION['email'];
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

?>
<style>
<?php include "style.css" ?>
</style>
<script>
    <?php include "main.js" ?>
</script>
<?php
// Include the database connection file
include 'partials/_dbconnect.php';
// session_start();
$companyname = $_SESSION['companyname'];

// Query to retrieve asset codes from the database
$sql_fname = "SELECT  operator_fname FROM myoperators WHERE company_name = '$companyname'";
$result_fname = mysqli_query($conn, $sql_fname);

?>
<?php
// Include the database connection file
include 'partials/_dbconnect.php';
$companyname = $_SESSION['companyname'];

// Query to retrieve asset codes from the database
?>
<?php 
include "partials/_dbconnect.php";
$sql_client_name="SELECT * FROM `billing_clients` where added_by='$companyname'";
$result_clients=mysqli_query($conn, $sql_client_name);


?>



<?php
if($_SERVER["REQUEST_METHOD"] == "POST")
{
include 'partials/_dbconnect.php';
// $assetcode12 = $_POST["assetcode"];
$currentrental1 = $_POST["crnt-rental"];
$expectedrental1 = $_POST["exp-rental"];
$workorder1 = $_POST["workorder"];
$workorder_valid1 = $_POST["workorder-validity"];
$rc_valid1 = $_POST["rc-validity"];
$fc_valid1 = $_POST["fc-validity"];
$np_valid1 = $_POST["np-validity"];
$insaurance1 = $_POST["insaurance"];
$operator_fname1 = $_POST["operator-fname"];
$operator_lname1 = $_POST["operator-lname"];
$existSql = "SELECT * FROM `fleet1` WHERE companyname = '$companyname001'";
$result = mysqli_query($conn, $existSql);
$sql="INSERT INTO `fleet1` (`current_rental`, `expected_rental`, `workorder`, `rc_valid`, `fc_valid`, `insaurance_valid`, `np_valid`, `operator_fname`, `operator_lname`)
VALUES('$currentrental1', '$expectedrental1', '$workorder1', '$rc_valid1','$fc_valid1','$insaurance1','$np_valid1','$operator_fname1','$operator_lname1')";
$result = mysqli_query($conn, $sql);
}
?>
<!DOCTYPE html>
<link rel="icon" href="favicon.jpg" type="image/x-icon">
<html>
<head>
    <!-- <link rel="stylesheet" href="style.css"> -->
    <title>Edit Fleet</title>
    <!-- <script src="main.js"></script> -->
</head>
<body onload="client_nameadd()">
    <div class="navbar1">
    <div class="logo_fleet">
    <img src="logo_fe.png" alt="FLEET EIP" onclick="window.location.href='<?php echo $dashboard_url  ?>'">
</div>

        <div class="iconcontainer">
        <ul>
      <li><a href="<?php echo $dashboard_url ?>">Dashboard</a></li>
            <li><a href="news/">News</a></li>
            <!-- <li><a href="contact_us.php">Contact Us</a></li> -->
            <li><a href="logout.php">Log Out</a></li></ul>
        </div>
</div> 

    <?php
    // Include the database connection file
    require_once('partials/_dbconnect.php');

    // Get the record ID from the URL parameter
    $editId = $_GET['id'];
    // echo $editId;

    // Retrieve data based on the ID
    $query = "SELECT * FROM `fleet1` WHERE snum ='$editId'";
    $result = mysqli_query($conn, $query);
    $row_info = mysqli_fetch_assoc($result);

    if (!$row_info) {
        echo "<p>Record not found.</p>";
    } else {
        ?>
        
        







        <form action="update.php? assetcode=<?php echo $editId; ?>" method="POST" autocomplete="off" class="addcraneform">
    <div class="formcontainer">
        <div class="add-fleet"><h2 class="additional_info_heading">Edit Fleet</h2></div>
        <div class="firstrow">
        <div class="trial1">
        <input type="text" class="input02" placeholder="" value="<?php echo $row_info['assetcode']; ?>" name="assetcode">
        <label class="placeholder2">AssetCode</label>
        </div>
        <div class="trial1">
        <select class="input02" name="make" id="crane_make_retnal" onchange="rental_addfleet()" required> 
            <option value="" disabled selected>Choose Fleet Make</option>
  <option <?php if($row_info['make'] === 'Ace'){echo 'selected';} ?> value="ACE">ACE</option>
  <option <?php if($row_info['make'] === 'Ajax Fiori'){echo 'selected';} ?>  value="Ajax Fiori">Ajax Fiori</option>
  <option <?php if($row_info['make'] === 'AMW'){echo 'selected';} ?> value="AMW">AMW</option>
  <option <?php if($row_info['make'] === 'Apollo'){echo 'selected';} ?> value="Apollo">Apollo</option>
  <option <?php if($row_info['make'] === 'Aquarius'){echo 'selected';} ?> value="Aquarius">Aquarius</option>
  <option <?php if($row_info['make'] === 'Ashok Leyland'){echo 'selected';} ?> value="Ashok Leyland">Ashok Leyland</option>
  <option <?php if($row_info['make'] === 'Atlas Copco'){echo 'selected';} ?> value="Atlas Copco">Atlas Copco</option>
  <option <?php if($row_info['make'] === 'Belaz'){echo 'selected';} ?> value="Belaz">Belaz</option>
  <option <?php if($row_info['make'] === 'Bemi'){echo 'selected';} ?> value="Bemi">Bemi</option>
  <option <?php if($row_info['make'] === 'BEML'){echo 'selected';} ?> value="BEML">BEML</option>
  <option <?php if($row_info['make'] === 'Bharat Benz'){echo 'selected';} ?> value="Bharat Benz">Bharat Benz</option>
  <option <?php if($row_info['make'] === 'Bob Cat'){echo 'selected';} ?> value="Bob Cat">Bob Cat</option>
  <option <?php if($row_info['make'] === 'Bull'){echo 'selected';} ?> value="Bull">Bull</option>
  <option <?php if($row_info['make'] === 'Bauer'){echo 'selected';} ?> value="Bauer">Bauer</option>
  <option <?php if($row_info['make'] === 'BMS'){echo 'selected';} ?> value="BMS">BMS</option>
  <option <?php if($row_info['make'] === 'Bomag'){echo 'selected';} ?> value="Bomag">Bomag</option>
  <option <?php if($row_info['make'] === 'Case'){echo 'selected';} ?> value="Case">Case</option>
  <option <?php if($row_info['make'] === 'Cat'){echo 'selected';} ?> value="Cat">Cat</option>
  <option <?php if($row_info['make'] === 'Cranex'){echo 'selected';} ?> value="Cranex">Cranex</option>
  <option <?php if($row_info['make'] === 'Casagrande'){echo 'selected';} ?> value="Casagrande">Casagrande</option>
  <option <?php if($row_info['make'] === 'Coles'){echo 'selected';} ?> value="Coles">Coles</option>
  <option <?php if($row_info['make'] === 'CHS'){echo 'selected';} ?> value="CHS">CHS</option>
    <option <?php if($row_info['make'] === 'Doosan'){echo 'selected';} ?> value="Doosan">Doosan</option>
    <option <?php if($row_info['make'] === 'Dynapac'){echo 'selected';} ?> value="Dynapac">Dynapac</option>
    <option <?php if($row_info['make'] === 'Demag'){echo 'selected';} ?> value="Demag">Demag</option>
    <option <?php if($row_info['make'] === 'Eicher'){echo 'selected';} ?> value="Eicher">Eicher</option>
    <option <?php if($row_info['make'] === 'Escorts'){echo 'selected';} ?> value="Escorts">Escorts</option>
    <option <?php if($row_info['make'] === 'Fuwa'){echo 'selected';} ?> value="Fuwa">Fuwa</option>
    <option <?php if($row_info['make'] === 'Fushan'){echo 'selected';} ?> value="Fushan">Fushan</option>
    <option <?php if($row_info['make'] === 'Genie'){echo 'selected';} ?> value="Genie">Genie</option>
    <option <?php if($row_info['make'] === 'Godrej'){echo 'selected';} ?> value="Godrej">Godrej</option>
    <option <?php if($row_info['make'] === 'Grove'){echo 'selected';} ?> value="Grove">Grove</option>
    <option <?php if($row_info['make'] === 'Hamm AG'){echo 'selected';} ?> value="Hamm AG">Hamm AG</option>
    <option <?php if($row_info['make'] === 'Haulott'){echo 'selected';} ?> value="Haulott">Haulott</option>
    <option <?php if($row_info['make'] === 'Hidromek'){echo 'selected';} ?> value="Hidromek">Hidromek</option>
    <option <?php if($row_info['make'] === 'Hydrolift'){echo 'selected';} ?> value="Hydrolift">Hydrolift</option>
    <option <?php if($row_info['make'] === 'Hyundai'){echo 'selected';} ?> value="Hyundai">Hyundai</option>
    <option <?php if($row_info['make'] === 'Hidrocon'){echo 'selected';} ?> value="Hidrocon">Hidrocon</option>
    <option <?php if($row_info['make'] === 'Ingersoll Rand'){echo 'selected';} ?> value="Ingersoll Rand">Ingersoll Rand</option>
    <option <?php if($row_info['make'] === 'Isuzu'){echo 'selected';} ?> value="Isuzu">Isuzu</option>
    <option <?php if($row_info['make'] === 'IHI'){echo 'selected';} ?> value="IHI">IHI</option>
    <option <?php if($row_info['make'] === 'JCB'){echo 'selected';} ?> value="JCB">JCB</option>
    <option <?php if($row_info['make'] === 'JLG'){echo 'selected';} ?> value="JLG">JLG</option>
    <option <?php if($row_info['make'] === 'Jaypee'){echo 'selected';} ?> value="Jaypee">Jaypee</option>
    <option <?php if($row_info['make'] === 'Jinwoo'){echo 'selected';} ?> value="Jinwoo">Jinwoo</option>
    <option <?php if($row_info['make'] === 'John Deere'){echo 'selected';} ?> value="John Deere">John Deere</option>
    <option <?php if($row_info['make'] === 'Jackson'){echo 'selected';} ?> value="Jackson">Jackson</option>
    <option <?php if($row_info['make'] === 'Kamaz'){echo 'selected';} ?> value="Kamaz">Kamaz</option>
    <option <?php if($row_info['make'] === 'Kato'){echo 'selected';} ?> value="Kato">Kato</option>
    <option <?php if($row_info['make'] === 'Kobelco'){echo 'selected';} ?> value="Kobelco">Kobelco</option>
    <option <?php if($row_info['make'] === 'Komatsu'){echo 'selected';} ?> value="Komatsu">Komatsu</option>
    <option <?php if($row_info['make'] === 'Konecranes'){echo 'selected';} ?> value="Konecranes">Konecranes</option>
    <option <?php if($row_info['make'] === 'Kubota'){echo 'selected';} ?> value="Kubota">Kubota</option>
    <option <?php if($row_info['make'] === 'KYB Conmat'){echo 'selected';} ?> value="KYB Conmat">KYB Conmat</option>
    <option <?php if($row_info['make'] === 'Krupp'){echo 'selected';} ?> value="Krupp">Krupp</option>
    <option <?php if($row_info['make'] === 'Kirloskar'){echo 'selected';} ?> value="Kirloskar">Kirloskar</option>
    <option <?php if($row_info['make'] === 'Kohler'){echo 'selected';} ?> value="Kohler">Kohler</option>
    <option <?php if($row_info['make'] === 'L&T'){echo 'selected';} ?> value="L&T">L&T</option>
    <option <?php if($row_info['make'] === 'Leeboy'){echo 'selected';} ?> value="Leeboy">Leeboy</option>
    <option <?php if($row_info['make'] === 'LGMG'){echo 'selected';} ?> value="LGMG">LGMG</option>
    <option <?php if($row_info['make'] === 'Liebherr'){echo 'selected';} ?> value="Liebherr">Liebherr</option>
    <option <?php if($row_info['make'] === 'Link-Belt'){echo 'selected';} ?> value="Link-Belt">Link-Belt</option>
    <option <?php if($row_info['make'] === 'Liugong'){echo 'selected';} ?> value="Liugong">Liugong</option>
    <option <?php if($row_info['make'] === 'Lorain'){echo 'selected';} ?> value="Lorain">Lorain</option>
    <option <?php if($row_info['make'] === 'Mahindra'){echo 'selected';} ?> value="Mahindra">Mahindra</option>
    <option <?php if($row_info['make'] === 'Manitou'){echo 'selected';} ?> value="Manitou">Manitou</option>
    <option <?php if($row_info['make'] === 'Maintowoc'){echo 'selected';} ?> value="Maintowoc">Maintowoc</option>
    <option <?php if($row_info['make'] === 'Marion'){echo 'selected';} ?> value="Marion">Marion</option>
    <option <?php if($row_info['make'] === 'MAIT'){echo 'selected';} ?> value="MAIT">MAIT</option>
    <option <?php if($row_info['make'] === 'Marchetti'){echo 'selected';} ?> value="Marchetti">Marchetti</option>
    <option <?php if($row_info['make'] === 'Noble Lift'){echo 'selected';} ?> value="Noble Lift">Noble Lift</option>
    <option <?php if($row_info['make'] === 'New Holland'){echo 'selected';} ?> value="New Holland">New Holland</option>
    <option <?php if($row_info['make'] === 'Palfinger'){echo 'selected';} ?> value="Palfinger">Palfinger</option>
    <option <?php if($row_info['make'] === 'Potain'){echo 'selected';} ?> value="Potain">Potain</option>
    <option <?php if($row_info['make'] === 'Putzmeister'){echo 'selected';} ?> value="Putzmeister">Putzmeister</option>
    <option <?php if($row_info['make'] === 'P&H'){echo 'selected';} ?> value="P&H">P&H</option>
    <option <?php if($row_info['make'] === 'Pinguely'){echo 'selected';} ?> value="Pinguely">Pinguely</option>
    <option <?php if($row_info['make'] === 'PTC'){echo 'selected';} ?> value="PTC">PTC</option>
    <option <?php if($row_info['make'] === 'Reva'){echo 'selected';} ?> value="Reva">Reva</option>
    <option <?php if($row_info['make'] === 'Sany'){echo 'selected';} ?> value="Sany">Sany</option>
    <option <?php if($row_info['make'] === 'Scania'){echo 'selected';} ?> value="Scania">Scania</option>
    <option <?php if($row_info['make'] === 'Schwing Stetter'){echo 'selected';} ?> value="Schwing Stetter">Schwing Stetter</option>
    <option <?php if($row_info['make'] === 'SDLG'){echo 'selected';} ?> value="SDLG">SDLG</option>
    <option <?php if($row_info['make'] === 'Sennebogen'){echo 'selected';} ?> value="Sennebogen">Sennebogen</option>
    <option <?php if($row_info['make'] === 'Skyjack'){echo 'selected';} ?> value="Skyjack">Skyjack</option>
    <option <?php if($row_info['make'] === 'Snorkel'){echo 'selected';} ?> value="Snorkel">Snorkel</option>
    <option <?php if($row_info['make'] === 'Soilmec'){echo 'selected';} ?> value="Soilmec">Soilmec</option>
    <option <?php if($row_info['make'] === 'Sunward'){echo 'selected';} ?> value="Sunward">Sunward</option>
    <option <?php if($row_info['make'] === 'Tadano'){echo 'selected';} ?> value="Tadano">Tadano</option>
    <option <?php if($row_info['make'] === 'Tata Hitachi'){echo 'selected';} ?> value="Tata Hitachi">Tata Hitachi</option>
    <option <?php if($row_info['make'] === 'TATA'){echo 'selected';} ?> value="TATA">TATA</option>
    <option <?php if($row_info['make'] === 'Terex'){echo 'selected';} ?> value="Terex">Terex</option>
    <option <?php if($row_info['make'] === 'TIL'){echo 'selected';} ?> value="TIL">TIL</option>
    <option <?php if($row_info['make'] === 'Toyota'){echo 'selected';} ?> value="Toyota">Toyota</option>
    <option <?php if($row_info['make'] === 'Teupen'){echo 'selected';} ?> value="Teupen">Teupen</option>
    <option <?php if($row_info['make'] === 'Unicon'){echo 'selected';} ?> value="Unicon">Unicon</option>
    <option <?php if($row_info['make'] === 'Urb Engineering'){echo 'selected';} ?> value="Urb Engineering">Urb Engineering</option>
    <option <?php if($row_info['make'] === 'Universal Construction'){echo 'selected';} ?> value="Universal Construction">Universal Construction</option>
    <option <?php if($row_info['make'] === 'Unipave'){echo 'selected';} ?> value="Unipave">Unipave</option>
    <option <?php if($row_info['make'] === 'Vogele'){echo 'selected';} ?> value="Vogele">Vogele</option>
    <option <?php if($row_info['make'] === 'Volvo'){echo 'selected';} ?> value="Volvo">Volvo</option>
    <option <?php if($row_info['make'] === 'Wirtgen Group'){echo 'selected';} ?> value="Wirtgen Group">Wirtgen Group</option>
    <option <?php if($row_info['make'] === 'XCMG Group'){echo 'selected';} ?> value="XCMG Group">XCMG Group</option>
    <option <?php if($row_info['make'] === 'XGMA'){echo 'selected';} ?> value="XGMA">XGMA</option>
    <option <?php if($row_info['make'] === 'Yanmar'){echo 'selected';} ?> value="Yanmar">Yanmar</option>
    <option <?php if($row_info['make'] === 'Zoomlion'){echo 'selected';} ?> value="Zoomlion">Zoomlion</option>
    <option <?php if($row_info['make'] === 'ZPMC'){echo 'selected';} ?> value="ZPMC">ZPMC</option>
    <option <?php if($row_info['make'] === 'Others'){echo 'selected';} ?> value="Others">Others</option>
</select>
</div>

<div class="trial1">
        <input type="text" class="input02" placeholder="" value="<?php echo $row_info['model']; ?>" name="model">
        <label class="placeholder2">model</label>
        </div>
    </div>
    <div class="trial1" id="othermake01">
        <input type="text" placeholder="" name="other_make" id="" class="input02" >
        <label class="placeholder2">Specify Other Make</label>
        </div>
        <input type="text" value="<?php echo $row_info['snum']; ?>" name="id" hidden>
        <div class="secondrow">
            <div class="trial1">
                <input type="text" placeholder="" value="<?php echo $row_info['category'] ?>" class="input02" readonly>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" value="<?php echo $row_info['sub_type'] ?>" class="input02" readonly>
            </div>
        </div>
        
        
        <div class="thirdrow">
            <div class="trial1">
            <input type="text" name="yom" value="<?php echo $row_info['yom']; ?>"  placeholder="" class="input02">
            <label class="placeholder2">YOM</label>
            </div>
            <div class="trial1">
            <input type="text" name="capacity" value="<?php echo $row_info['capacity'] ?>" placeholder="" class="input02">
            <label class="placeholder2">Capacity</label>
            </div>
            <div class="trial1">
                <select name="unit" id="" class="input02" placeholder>
                <option value="" disabled selected>Select Capacity Unit</option>
                <option value="Ton" <?php if($row_info['unit']==='Ton'){ echo 'selected';} ?>>Ton</option>
                <option value="Meter" <?php if($row_info['unit']==='Meter'){ echo 'selected';} ?>>Meter</option>
                <option value="m^3" <?php if($row_info['unit']==='m^3'){ echo 'selected';} ?>>M³</option>
                </select>
            </div>
            </div>
            <?php
            $registrationStyle = empty($row_info['registration']) ? 'style="display:none"' : '';
            ?>
            <div class="trial1" <?php echo $registrationStyle ?> >
            <input type="text" name="registration" value="<?php echo $row_info['registration']; ?>" placeholder="" class="input02">
            <label class="placeholder2">Registration</label>
            </div>
            <div class="trial1">
            <input type="text" name="chassis" value="<?php echo $row_info['chassis']; ?>" placeholder="" class="input02">
            <label class="placeholder2">Chassis Make</label>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" name="chassis_number" value="<?php echo $row_info["chassis_number"] ?>" class="input02">
                <label for="" class="placeholder2">Chassis Number</label>
            </div>
            <div class="trial1">
            <input type="text" name="engine" value="<?php echo $row_info['engine']; ?>" placeholder="" class="input02">
            <label class="placeholder2">Engine Make</label>
            </div>
            <?php
            $boomLengthStyle = empty($row_info['boom_length']) ? 'style="display:none"' : '';
            $jibLengthStyle = empty($row_info['jib_length']) ? 'style="display:none"' : '';
            $luffingLengthStyle = empty($row_info['luffing_length']) ? 'style="display:none"' : '';
            ?>
            <div class="trial1" <?php echo $boomLengthStyle; ?> >
            <input type="text" name="boomLength" value="<?php echo $row_info['boom_length']; ?>" id="" placeholder="" class="  input02">
            <label class="placeholder2">Boom Length</label>

            </div>
            <div class="trial1" <?php echo $jibLengthStyle; ?> >
            <input type="text" name="jibLength" value="<?php echo $row_info['jib_length']; ?>" id="" placeholder="" class=" input02 ">
            <label class="placeholder2">Jib Length</label>
            </div>
            <div class="trial1" <?php echo $luffingLengthStyle; ?> >
                <input type="text" name="luffingLength" value="<?php echo $row_info['luffing_length']; ?>" id="" placeholder="" class=" input02">
                <label class="placeholder2">Luffing Length</label>
            </div>        

            
            <div class="trial1">
            <input type="text" name="dieselTankCap" value="<?php echo $row_info['diesel_tank_capacity']; ?>" placeholder="" class="input02" readonly>
            <label class="placeholder2">Diesel Tank Capacity</label>
            </div>
            <div class="hydraulic_outer">
            <div class="trial1">
            <input type="text" name="hydraulicOilTank" value="<?php echo $row_info['hydraulic_oil_tank']; ?>" placeholder="" class="input02" readonly>
            <label class="placeholder2">Hydraulic oil tank</label>
            </div>
            <div class="trial1">
            <input type="text" name="hydraulicOilGrade" value="<?php echo $row_info['hydraulic_oil_grade']; ?>" placeholder="" class="input02" readonly>
            <label class="placeholder2">Hydraulic oil grade</label>
            </div>
            </div>
            <div class="hydraulic_outer">
            <div class="trial1">
            <input type="text" name="engineOilCapacity" value="<?php echo $row_info['engine_oil_capacity']; ?>" placeholder="" class="input02" readonly>
            <label class="placeholder2">Engine oil Capacity</label>
            </div>
            <div class="trial1">
            <input type="text" name="engineOilGrade" value="<?php echo $row_info['engine_oil_grade']; ?>" placeholder="" class="input02" readonly>
            <label class="placeholder2">Engine oil Grade</label>
            </div>
            </div>
            <select name="status" class="craneforminput selectoption" >
                <option value="" disabled selected>Choose Current Status</option>
                <option value="Working" <?php if ($row_info['status'] === 'Working') echo 'selected'; ?>>Working</option>
                <option value="Idle" <?php if ($row_info['status'] === 'Idle') echo 'selected'; ?>>Idle</option>
                <option value="Non working-breakdown" <?php if ($row_info['status'] === 'Non working-breakdown') echo 'selected'; ?>>Non working-breakdown</option>
                <option value="Not in use" <?php if ($row_info['status'] === 'Not in use') echo 'selected'; ?> >Not in use</option>
                <option value="Scrap"  >Scrap</option>
            </select>
        <select class="craneforminput selectoption"  onchange="client_nameadd()" id="workorder_DROPDOWN" name="workorder" >
            <option value="" disabled selected>Work Order Recieved ?</option>
            <option value="yes" <?php if ($row_info['workorder'] === 'yes') echo 'selected'; ?>>Yes</option>
            <option value="no" <?php if ($row_info['workorder'] === 'no') echo 'selected'; ?>>No</option>
        </select>
        <div class="outerclient" id="outerclient1">
        <div class="client_conti">
        <a href="add_bill_client.php" class="client_list">If Client not in list add them here</a>
        <div class="trial1">
            <select name="client_name" id="" class="input02">
                <option value=""disabled selected>Choose Client Equipment Working At</option>
                <?php while($row_client=mysqli_fetch_assoc($result_clients)){
                    ?>
                <option value="<?php echo $row_client['name'] ?>" <?php if($row_info['client_name']=== $row_client['name']){ echo 'selected';} ?>><?php echo $row_client['name'] ?></option>


                <?php    
                } ?>
            </select>
        </div>
        <div class="trial1" id="wo_validity">  
        <input class="input02" type="date"   name="workorder_validity" value="<?php echo $row_info['workorder_valid']; ?>" placeholder="">
        <label class="placeholder2">Work Order Validity</label>
        </div>

        </div>
        <div class="out_cont">
            <div class="outer02">
                <div class="trial1">
                    <input type="text" name="working_days_month" value="<?php echo $row_info['working_days_in_month'] ?>" placeholder="" class="input02">
                    <label for="" class="placeholder2">Working Days In Month</label>
                </div>
                <div class="trial1">
                    <select name="sunday_condition" id="" class="input02">
                        <option value="" disabled selected>Condition</option>
                        <option value="Including Sunday" <?php if($row_info['condition_sundays']==='Including Sunday'){ echo 'selected';} ?>>Including Sundays</option>
                        <option value="Excluding Sunday" <?php if($row_info['condition_sundays']==='Excluding Sunday'){ echo 'selected';} ?>>Excluding Sundays</option>
                    </select>
                </div>
                <div class="trial1">
                    <input type="text" placeholder="" value="<?php echo $row_info['fuel_norms'] ;?>" name="fuel_condition" class="input02">
                    <label for="" class="placeholder2">Fuel Norms Acc LOI</label>
                </div>
            </div>
        </div>
                <div class="out_cont">
        <div class="outer02" >
            <div class="trial1">
                <input type="text" placeholder="" value="<?php echo $row_info['project_name'] ?>" name="project_name" class="input02">
                <label for="" class="placeholder2">Project Name</label>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" value="<?php echo $row_info['project_location'] ?>" name="project_location" class="input02">
                <label for="" class="placeholder2">Project Location</label>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" name="hour_shift" value="<?php echo $row_info['hour_shift'] ?>" class="input02">
                <label for="" class="placeholder2">Shift Working Hours</label>
            </div>
            </div>
        </div>

        <div class="out_cont">
        <div class="outer02" >
            <div class="trial1">
                <input type="text" placeholder="" value="<?php echo $row_info['rental_charges_wo'] ?>"  name="rental_charges_wo" class="input02">
                <label for="" class="placeholder2">Rental Charges</label>
            </div>
            <div class="trial1">
                <select name="shift_wo" id="" class="input02">
                    <option value=""disabled selected>Select Shift</option>
                    <option value="Single" <?php if($row_info['shift_wo']==='Single'){ echo 'selected';} ?>>Single Shift</option>
                    <option value="Double" <?php if($row_info['shift_wo']==='Double'){ echo 'selected';} ?>>Double Shift</option>
                </select>
        </div>
            <div class="trial1">
                <select name="ot_charges" id="" class="input02">
                    <option value=""disabled selected>OT Charges</option>
                    <option value="10"<?php if($row_info['ot_charges']==='10'){ echo 'selected';} ?> >10% pro-rata</option>
                    <option value="20" <?php if($row_info['ot_charges']==='20'){ echo 'selected';} ?>>20% pro-rata</option>
                    <option value="30" <?php if($row_info['ot_charges']==='30'){ echo 'selected';} ?>>30% pro-rata</option>
                    <option value="40" <?php if($row_info['ot_charges']==='40'){ echo 'selected';} ?>>40% pro-rata</option>
                    <option value="50" <?php if($row_info['ot_charges']==='50'){ echo 'selected';} ?>>50% pro-rata</option>
                    <option value="60" <?php if($row_info['ot_charges']==='60'){ echo 'selected';} ?>>60% pro-rata</option>
                    <option value="70" <?php if($row_info['ot_charges']==='70'){ echo 'selected';} ?>>70% pro-rata</option>
                    <option value="80" <?php if($row_info['ot_charges']==='80'){ echo 'selected';} ?>>80% pro-rata</option>
                    <option value="90" <?php if($row_info['ot_charges']==='90'){ echo 'selected';} ?>>90% pro-rata</option>
                    <option value="100" <?php if($row_info['ot_charges']==='100'){ echo 'selected';} ?>>100% pro-rata</option>
                </select>
            </div>

            </div>
        </div>

</div>
        
        <div class="fourthrow">
        <div class="trial1">
        <input class="input02" type="date" name="rc_validity" value="<?php echo $row_info['rc_valid']; ?>" placeholder="">
        <label class="placeholder2">RC-Validity</label>
        </div>
        <div class="trial1">
        <input class="input02" type="date"  name="fc_validity" value="<?php echo $row_info['fc_valid']; ?>" placeholder="">
        <label class="placeholder2">FC-Validity</label>
        </div>
        </div>
        <div class="fourthrow">
        <div class="trial1">
            <input class="input02" type="date"  name="insaurance" value="<?php echo $row_info['insaurance_valid']; ?>" placeholder="">
            <label class="placeholder2">Insaurance-Validity</label>
        </div>
        <div class="trial1">
            <input class="input02" type="date"  name="np_validity" value="<?php echo $row_info['np_valid']; ?>" placeholder="">
            <label class="placeholder2">NP-Validity</label>
        </div>
        </div> 
        <div class="trial1">
            <h6 class="addoperator_ifnot">If Your operator is not in the options please add it in <a href="addoperator.php">Add Operator</a></h6>
        </div>
        <!-- <div class="fourthrow"> -->
        <div class="trial1">
            <select class="input02" type="text" name="operator-fname"  placeholder="" >
                <option value="" disabled selected>Choose Operator Name</option>
                <?php while($row_fname=mysqli_fetch_assoc($result_fname)){
?>
        <option value="<?php echo $row_fname['operator_fname'] ?>" <?php if ($row_info['operator_fname'] === $row_fname['operator_fname']) {echo 'selected';} ?>><?php echo $row_fname['operator_fname'] ?></option>

  <?php
              } ?>
        
                </select>
<br>
        <button type="submit" class="crane-submit" >Update Fleet</button>
        <br>
        
            
    </div> 
    </form> 
        <?php
    }
    ?>
    

    <script>  
    function client_nameadd() {
    const workorder = document.getElementById("workorder_DROPDOWN");
    const outerclient12 = document.getElementById("outerclient1");
    
    if (workorder.value === 'yes') {
        outerclient12.style.display = "block";
    } else {
        outerclient12.style.display = "none";
    }
}
    

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