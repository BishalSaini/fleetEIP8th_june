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
include 'partials/_dbconnect.php';

$reqid=$_GET['id'];

$sql = "SELECT * FROM `notinterested_rental` WHERE `rental_name` = '$companyname001' and id='$reqid' ";
$result = mysqli_query($conn, $sql);
$row=mysqli_fetch_assoc($result);
?>
<style>
    <?php include "style.css"; ?>
  </style>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">      <link rel="icon" href="favicon.jpg" type="image/x-icon">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Regretted</title>
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
<form action="" class="not_interested_form">
    <div class="notinterested_container">
        <div class="notinterestedhead"><p>Regretted Leads</p></div>
        <div class="outer02">
<div class="trial1">
    <input type="text" placeholder="" value="<?php echo $row['equipment_type']; ?>" class="input02" readonly>
    <label class="placeholder2">Equipment Type</label>
</div>
<div class="trial1">
    <input type="text" placeholder="" value="<?php echo $row['equipment_capacity']; ?>"  class="input02" readonly>
    <label class="placeholder2">Equipment Capacity</label>
</div>
<div class="trial1">
    <input type="text" placeholder="" value="<?php echo $row['boom_combination']; ?>" class="input02" readonly>
    <label class="placeholder2">Boom Combination</label>
</div>

</div>
<div class="outer02">
<div class="trial1">
    <input type="text" placeholder="" value="<?php echo $row['project_type']; ?>" class="input02" readonly>
    <label class="placeholder2">Project Type</label>
</div>

<div class="trial1">
    <input type="text" placeholder="" value="<?php echo $row['district']; ?>" class="input02" readonly>
    <label class="placeholder2">District</label>
</div>
<div class="trial1">
    <input type="text" placeholder="" value="<?php echo $row['state']; ?>" class="input02" readonly>
    <label class="placeholder2">State</label>
</div>
</div>
<div class="outer02">
<div class="trial1">
<input type="text" placeholder="" value="<?php echo htmlspecialchars($row['duration']) . ' - Month'; ?>" class="input02" readonly>
    <label class="placeholder2">Duration</label>
</div>
<div class="trial1">
    <input type="text" placeholder="" value="<?php echo $row['shift']; ?>" class="input02" readonly>
    <label class="placeholder2">Shift</label>
</div>
<div class="trial1">
<input type="text" placeholder="" value="<?php echo (new DateTime($row['tentative_date']))->format('jS M Y'); ?>" class="input02" readonly>
    <label class="placeholder2">Required At Site</label>
</div>
</div>
<div class="trial1">
    <input type="text" placeholder="" value="<?php echo $row['epc_company']; ?>" class="input02" readonly>
    <label class="placeholder2">EPC Name</label>
</div>
<div class="outer02">

<div class="trial1">
    <input type="text" placeholder="" value="<?php echo $row['epc_email']; ?>" class="input02" readonly>
    <label class="placeholder2"> Email</label>
</div>
<div class="trial1">
    <input type="text" placeholder="" value="<?php echo $row['epc_contact']; ?>" class="input02" readonly>
    <label class="placeholder2">Contact</label>
</div>
</div>
<div class="trial1">
    <textarea type="text" placeholder=""  class="input02" readonly><?php echo $row['not_interested_reason']; ?></textarea>
    <label class="placeholder2">Not Interested Reason</label>
</div>
<br>
    </div>
    <br><br>
</form> 
</body>
</html>