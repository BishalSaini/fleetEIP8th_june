<?php
include_once 'partials/_dbconnect.php'; // Include the database connection file

$noti_check = "SELECT COUNT(snum) AS total FROM `fleet1` WHERE companyname='akash'";
$result = mysqli_query($conn, $noti_check);

$row = mysqli_fetch_assoc($result);
$total_count = $row['total'];
?>
<style>
  <?php include "style.css" 
  ?>
</style>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">      <link rel="icon" href="favicon.jpg" type="image/x-icon">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>
    <div class="bell_cont">
        <img src="bell.png" alt="">
        <!-- <i class="fa-solid fa-bell"></i> -->
        <div class="noti_count_container">
        <?php echo $total_count ?>
    </div>
    </div>
    
</body>
</html>