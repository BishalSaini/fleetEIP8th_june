<?php
$id=$_GET['id'];
$clientid=$_GET['clientid'];
include "partials/_dbconnect.php";
session_start();
$companyname001=$_SESSION['companyname'];
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

$sql="SELECT * FROM `rentalclients` where id='$id' and companyname='$companyname001'";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_assoc($result);


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Employee</title>
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
            <li><a href="news/">News</a></li>
            <!-- <li><a href="contact_us.php">Contact Us</a></li> -->
            <li><a href="logout.php">Log Out</a></li></ul>
        </div>
    </div> 

<form action="edit_siteoffice_contact.php" method="POST" autocomplete="off" class="hqcontact" id="">
        <div class="hqcontactcontainer">
            <p class="headingpara">Ex Employee</p>

            <div class="outer02">
            <div class="trial1">
                <input type="text" placeholder="" value="<?php echo $row['contact_person'] ?>" name="sitename" class="input02">
                <label for="" class="placeholder2">Name</label>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" value="<?php echo $row['designation'] ?>" name="sitedestination" class="input02">
                <label for="" class="placeholder2">Designation</label>
            </div>
            <input type="hidden" name="clientid" value="<?php echo $clientid ?>">
            <input type="hidden" name="editid" value="<?php echo $id ?>">
            </div>
            <div class="outer02">
            <div class="trial1">
                <input type="text" placeholder="" value="<?php echo $row['contact_number'] ?>" name="sitecontact" class="input02">
                <label for="" class="placeholder2">Contact Number</label>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" value="<?php echo $row['contact_email'] ?>" name="siteemail" class="input02">
                <label for="" class="placeholder2">Contact Email</label>
            </div>

            </div>
            <div class="trial1">
            <input type="text" value="<?php 
    echo $row['address_type'] . '-';
    echo !empty($row['associated_regoffice']) ? $row['associated_regoffice'] : $row['associate_site']; 
?>" placeholder="" class="input02">
                <label for="" class="placeholder2">Associated Office</label>
            </div>
<br>
            <!-- <button class="epc-button" name="sitesubmit">Submit</button> -->
        </div>
    </form>

</body>
</html>