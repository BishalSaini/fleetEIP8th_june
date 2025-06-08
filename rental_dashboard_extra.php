<?php
session_start();
?>
<style>
<?php include "style.css" ?>
</style>
<script>
    <?php include "main.js" ?>
    </script>
    <?php
include 'partials/_dbconnect.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">      <link rel="icon" href="favicon.jpg" type="image/x-icon">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="style.css">
    <title>Dashboard</title>
</head>
<body class="rental_dashboard">
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

// Check if the companyname session variable is set
if (isset($_SESSION['companyname'])) {
    $companyname = $_SESSION['companyname'];
    echo "Welcome: " . $companyname;
} else {
    echo "Company Name: Not Available";
}
?>
<div class="outercard">
            <div class="card_container1">
            <div class="button-52" onclick="location.href='addfleetnew.php'" >Add Fleets</div>
            <div class="button-52" onclick="location.href='viewfleet2.php'" >View Fleets</div>
            <div class="button-52" onclick="location.href='purchase.php'" >Purchase Requisition</div>
            <div class="button-52" onclick="location.href='view_req_rental.php'" >Market Leads</div>

        </div>
        <div class="card_container2">
        <div class="button-52" onclick="location.href='marketplace.php'" >Market Place</div>
        <div class="button-52" onclick="location.href='operator.php'" >Man Power</div>
        <div class="button-52" onclick="location.href='livesearch.php'" >Directory</div>
        <div class="button-52" onclick="location.href='rental_subuser.php'" >Add Company Members</div>
    </div>
    <br><br><br>
    <div class="card_container2">
        <div class="button-52" onclick="location.href='rental_employee.php'" >Add Subusers</div>
        <div class="button-52" onclick="location.href='edit_profile.php'" >Edit Profile</div>
    </div>
</div>

</body>
</html>