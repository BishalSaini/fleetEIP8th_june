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
    <title>Document</title>
</head>
<body class="admin_body">
    <div class="navbar1">
    <div class="logo_fleet">
    <img src="logo_fe.png" alt="FLEET EIP" onclick="window.location.href='<?php echo $dashboard_url  ?>'">
</div>

        <div class="iconcontainer">
        <ul><li><a href="sign_in.php">Home</a></li>
            <!-- <li><a href="about_us.html">About Us</a></li>
            <li><a href="contact_us.php">Contact Us</a></li> -->
            <li><a href="logout.php">Log Out</a></li></ul>
        </div>
</div>
<!-- <div class="outercard">
            <div class="card1" onclick="location.href='add_news.php'">
                <img src="img_avatar.png" alt="avatar" style="width: 200px;">
                <div class="font"><p>Add News</p></div>
            </div>
</div> -->
<div class="outercard">
<div class="card_container1">
<div class="button-52" onclick="location.href='add_news.php'" >Add News</div>
<div class="button-52" onclick="location.href='admin_market_leads.php'" >Add Market Leads</div>
<div class="button-52" onclick="location.href='admin_add_directory.php'" >Add Directory Content</div>

</div>
</div>
</body>
</html>