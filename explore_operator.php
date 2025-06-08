<?php
include_once 'partials/_dbconnect.php'; 
session_start();
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
  <?php include "style.css" 
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
    <link rel="stylesheet" href="style.css">
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
$snum = $_GET['id'];
$fname = $_GET['fname'];
$lname = $_GET['lname'];
include_once 'partials/_dbconnect.php'; // Include the database connection file
$sql="SELECT * FROM `myoperators` WHERE operator_fname = '$fname' && company_name = '$companyname001'";
$result = mysqli_query($conn,$sql);
if($result){
    while ($row = mysqli_fetch_assoc($result)) { 
        ?>
<form action="" class="addoperator_form">
    <div class="addoperator_container">
        <div class="add_operator"><p>Operator Information</p></div>
        
    <div class="trial1">
    <input type="text" value="<?php echo $row["operator_fname"] ?>" placeholder="" class="input02" readonly>
        <label class="placeholder2">Operator Name</label>
        </div>
        <!-- <div class="trial1">
        <input type="text" value="<?php echo $row["operator_lname"] ?>" placeholder="" class="input02" readonly>
        <label class="placeholder2">Operator Last Name</label>
        </div> -->
        <div class="trial1">
        <input type="text" name="companyname" value="<?php echo $row["company_name"] ?>" placeholder="" class="input02" readonly>
        <label class="placeholder2">Company Name</label>
        </div>

        <div class="outer02">
        <div class="trial1">
        <input type="text" name="fleet_type" value="<?php echo $row["fleet_Type"] ?>" placeholder="" class="input02" readonly>
        <label class="placeholder2">Fleet Type</label>
        </div>
        <div class="trial1">
        <input type="text" name="fleet_capacity"  value="<?php echo $row["cap_metric_ton"] ?>" placeholder="" class="input02" readonly>
        <label class="placeholder2">Capacity In Metric Ton</label>
        </div>
        </div>
        <div class="outer02">
        <div class="trial1">
        <input type="text" name="license" placeholder=""  value="<?php echo $row["driving_license"] ?>" class="input02" readonly>
        <label class="placeholder2">Driving License</label>
        </div>
        <div class="trial1">
        <input type="text" name="license_issueddate"  value="<?php echo $row["issued_date"] ?>" placeholder="" class="input02" readonly>
        <label class="placeholder2">Issued Date</label>
        </div>
        </div>
        <div class="trial1">
        <input type="text" name="aadhar_card"  value="<?php echo $row["aadhar_card"] ?>" placeholder="" class="input02" readonly>
        <label class="placeholder2">Aadhar Card</label>
        </div>
        <div class="trial1">
        <input type="text" name="mobile_no" placeholder=""  value="<?php echo $row["mobile_number"] ?>" class="input02" readonly>
        <label class="placeholder2">Mobile Number</label>
        </div>
        <div class="trial1">
        <input type="text" name="address" placeholder=""  value="<?php echo $row["address"] ?>" class="input02" readonly>
        <label class="placeholder2">Address</label>
        </div>
        <div class="trial1">
        <input type="text" name="pincode" placeholder=""  value="<?php echo $row["pincode"] ?>" class="input02" readonly>
        <label class="placeholder2">Pincode</label>
        </div>
        <div class="outer02">
        <div class="trial1">
        <input type="text" name="reference1" placeholder=""  value="<?php echo $row["reference1"] ?>" class="input02" readonly>
        <label class="placeholder2">Reference 1</label>
        </div>  
        <div class="trial1">
        <input type="text"  placeholder=""  value="<?php echo $row["relation_refernce1"] ?>" class="input02" readonly>
        <label class="placeholder2"> Relation With Reference </label>
        </div> 
        </div> 
        <div class="outer02">
        <div class="trial1">
        <input type="text" name="reference2"  value="<?php echo $row["reference2"] ?>" placeholder="" class="input02" readonly>
        <label class="placeholder2">Reference 2</label>
        </div> 
        <div class="trial1">
        <input type="text" name="reference2"  value="<?php echo $row["relation_refernce2"] ?>" placeholder="" class="input02" readonly>
        <label class="placeholder2"> Relation With Reference </label>
        </div> 
        </div>
        <div class="outer02">
        <div class="trial1">
        <input type="text" name="crnt_company" value="<?php echo $row["current_company"] ?>" placeholder="" class="input02" readonly>
        <label class="placeholder2">Current Company</label>
        </div> 
        <div class="trial1">
        <input type="text" name="strt_date" placeholder="" value="<?php echo $row["startdate_crnt_company"] ?>" class="input02" readonly>
        <label class="placeholder2">Started From</label>
        </div> 
    </div>
    <div class="outer02">
        <div class="trial1">
        <input type="text" name="previous_company" placeholder=""value="<?php echo $row["previous_company"] ?>" class="input02" readonly>
        <label class="placeholder2">Previous Company</label>
        </div> 
        <div class="trial1">
        <input type="text" name="strt_date_previous_company" placeholder="" value="<?php echo $row["startdate_previous_company"] ?>" class="input02" readonly>
        <label class="placeholder2">Started From</label>
        </div>
        <div class="trial1">
        <input type="text" name="end_date_previous_company" placeholder=""value="<?php echo $row["enddate_previous_company"] ?>" class="input02" readonly>
        <label class="placeholder2">End Date</label>
        </div>
    </div>
    <div class="trial1">
        <input type="text"  placeholder="" value="<?php echo $row["skill_set"] ?>" class="input02" readonly>
        <label class="placeholder2">Skill Set</label>
    </div>
    <div class="trial1">
        <input type="text"  placeholder="" value="<?php echo $row["language"] ?>" class="input02" readonly>
        <label class="placeholder2">Language</label>
    </div>
    <div class="trial1">
        <input type="text"  placeholder="" value="<?php echo $row["driving_asset_code"] ?>" class="input02" readonly>
        <label class="placeholder2">Driving Asset Code</label>
    </div>
    <br>
    <br>
    </form>






<?php
    }
}
?>
</body>
</html>