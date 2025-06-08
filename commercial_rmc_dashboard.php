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
		<li><a href="commercial_rmc_dashboard.php">Dashboard</a></li>
            <li><a href="news/">News</a></li>
            <li><a href="logout.php">Log Out</a></li></ul>
        </div>
</div>
<div class="outercard">
            <div class="card_container1">
            <div class="button-52" onclick="location.href=''" >Market Leads</div>
            <div class="button-52" onclick="location.href=''" >Add Fleets</div>
            <div class="button-52" onclick="location.href=''" >Add Manpower</div>
            <div class="button-52" onclick="location.href=''" >Purchase Requisition</div>

        </div>
        <div class="card_container2">
        <div class="button-52" onclick="location.href=''" >Store Management</div>
        <div class="button-52" onclick="location.href=''" >Sales Management</div>
        <div class="button-52" onclick="location.href=''" >Market Place</div>
        <!-- <div class="button-52" onclick="location.href='livesearch.php'" >Directory</div>
        <div class="button-52" onclick="location.href='rental_subuser.php'" >Add Company Members</div> -->
    </div>

 
</body>
</html>