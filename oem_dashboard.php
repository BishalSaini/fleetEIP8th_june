<?php
session_start();
?>
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
    <?php
    if (isset($_SESSION['companyname'])) {
    $companyname = $_SESSION['companyname'];
    echo "Welcome: " . $companyname;
} else {
    echo "Company Name: Not Available";
}
?>
       <div class="outercard">
            <div class="card_container1">
            <div class="button-52" onclick="location.href='oemaddfleet.php'" >Add Fleets</div>
            <div class="button-52" onclick="location.href='viewfleet.php'" >View Fleets</div>
            <div class="button-52" onclick="location.href='oem_requirement.php'" >View Enquiry</div>
            <div class="button-52" onclick="location.href='oem_subuser.php'" >Add Sub User</div>
        </div>
        <div class="card_container2">
        <div class="button-52" onclick="location.href='oem_teammember.php'" >Add Team Members</div>
        </div>
</body>
</html>