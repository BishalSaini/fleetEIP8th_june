<?php
include_once 'partials/_dbconnect.php'; // Include the database connection file
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

$sql = "SELECT * FROM `req_by_epc` WHERE epc_name='$companyname001'";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">      <link rel="icon" href="favicon.jpg" type="image/x-icon">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script src="main.js"></script>
    <title>Document</title>
</head>
<body>
    <div class="navbar1">
    <div class="logo_fleet">
    <img src="logo_fe.png" alt="FLEET EIP" onclick="window.location.href='<?php echo $dashboard_url  ?>'">
</div>

    <div class="iconcontainer">
        <ul>
            <li><a href="epc_dashboard.php">Dashboard</a></li>
            <li><a href="view_news_epc.php">News</a></li>
            <li><a href="logout.php">Log Out</a></li>
        </ul>
    </div>
</div> 
<table class="req_group">
<tr class="epc_reqrow">
    <?php

    while ($row = mysqli_fetch_assoc($result)) {
    ?>
    <td class="req_epc_Card" onclick="open_req_grpinner(<?php echo $row['id'] ?>)">
        <div class="epc_card_pic"></div>
        <div class="epc_req_grp_info">
            <p>Project Code: <?php echo $row['project_code'] ?></p>
            <p>Project type: <?php echo $row['project_type'] ?></p>
            <p>Equipment Type: <?php echo $row['equipment_type'] ?></p>
            <p>Equipment Capacity: <?php echo $row['equipment_capacity'] . ' ' . $row['unit']?></p>
            <p>Duration: <?php echo $row['duration_month'] . " Months"?></p>
            <p>State: <?php echo $row['state'] ?></p>
        </div>
    </td>
    <?php
    }
    ?>
</tr>
</table>
</body>
</html>
