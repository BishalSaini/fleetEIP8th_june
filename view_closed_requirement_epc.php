<?php
include_once 'partials/_dbconnect.php'; // Include the database connection file
session_start();
// $email = $_SESSION["email"];
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

?>
<script>
    <?php include "main.js" ?>
    </script>
<style>
  <?php include "style.css" ?>
</style>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">      <link rel="icon" href="favicon.jpg" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

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
            
            <li><a href="logout.php">Log Out</a></li></ul>
        </div>
    </div> 

    <?php
    include_once 'partials/_dbconnect.php'; // Include the database connection file

    $result = mysqli_query($conn, "SELECT * FROM `closed_requirement_epc_latest` WHERE epc_name = '$companyname001' ORDER BY id DESC");

    if(mysqli_num_rows($result) > 0) {
    // Display the data in a table
    echo '<table class="myreq_epc">';
    echo '<tr><th>Equipment Type</th><th>Equipment Capacity</th><th>Project Type</th><th>Duration</th><th>State</th><th>District</th><th>Platform</th><th>Vendor</th><th>Actions</th></tr>';
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<tr>';
        echo '<td>' . $row['equipment_type'] . '</td>';
        echo '<td>' . $row['equipment_capacity'] . '</td>';
        echo '<td>' . $row['project_type'] . '</td>';
        echo '<td>' . $row['duration_month'] . '</td>';
        echo '<td>' . $row['state'] . '</td>';
        echo '<td>' . $row['district'] . '</td>';
        echo '<td>' . $row['platform'] . '</td>';
        echo '<td>' . $row['vendor'] . '</td>';
        ?>
        <td>
        <a class='btn_listing' href='view_epc_closedfull.php?id=<?php echo $row['id'];?>'> View</a>
    </td>
        <?php
        echo '</tr>';
       
    }

    echo '</table>';

}

?>
        
</body>
</html>
