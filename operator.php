<style>
  <?php include "style.css" 
  ?>
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
    <div class="outercard">
            <div class="card_container_purchase">
            <div class="button-52" onclick="location.href='addoperator.php'" >Add Fleet Manager</div>
            <div class="button-52" onclick="location.href='view_operator.php'" >View Fleet Manager</div>
            <div class="button-52" onclick="location.href='#'" >Search Fleet Managers</div>
        </div>         
</body>
</html>