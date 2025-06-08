<?php
include 'partials/_dbconnect.php';

?>

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
                <li><a href="sign_in.php">Home</a></li>
                <li><a href="about_us.html">About Us</a></li>
                <li><a href="contact_us.php">Contact Us</a></li>
                <li><a href="logout.php">LogOut</a></li>
            </ul>
        </div>
    </div>
    <div class="outercard">
            <div class="card_container1">
            <div class="button-52" onclick="location.href='quoted_price_logistics.php'" >Quoted Prices</div>
            <div class="button-52" onclick="location.href='logistics-need.php'" >View Requirements</div>
        </div>
</body>
</html>