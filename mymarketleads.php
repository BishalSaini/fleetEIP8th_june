<?php
session_start();
$email = $_SESSION['email'];
// $companyname001 = $_SESSION['companyname'];
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
elseif ($enterprise === 'admin') {
    $dashboard_url = 'news/admin/dashboard.php';
} 

else {
    $dashboard_url = '';
}
include "partials/_dbconnect.php";
$sql="SELECT * FROM `req_by_epc` where posted_by='admin' order by id desc";
$result=mysqli_query($conn,$sql);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Leads</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

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
            <!-- <li><a href="news/">News</a></li> -->
    
        <li><a href="logout.php">Log Out</a></li></ul>
        </div>
    </div> 
    <?php
if (mysqli_num_rows($result) > 0) {
    // Start the table
    echo '<table class="purchase_table" id="logi_rates">';
    
    // Initialize the row
    echo '<tr>';

    $loop_count = 0; // Initialize the counter

    while ($row = mysqli_fetch_assoc($result)) {
        // After every 4 cards, close the current row and start a new one
        if ($loop_count > 0 && $loop_count % 4 == 0) {
            echo '</tr><tr>'; // Close the current row and open a new one
        }

        ?>
        <td>
            <div class="custom-card" id="application_card">
                <h3 class="custom-card__title" onclick="window.location.href='view_epc_full.php?id=<?php echo $row['id']; ?>'"><?php echo $row['equipment_type'] ?></h3>
                <p class="insidedetails">Capacity: <?php echo $row['equipment_capacity'] .' ' .$row['unit'] ?></p>
                <p class="insidedetails" id="email_logi">Duration : <?php echo $row['duration_month']  ?></p>
                <p class="insidedetails">Project : <?php echo $row['project_type'] ?></p>
                <p class="insidedetails">State : <?php echo $row['state'] ?></p>
                <div class="custom-card__arrow">
                    <i class="fas fa-arrow-right"></i>
                </div>
            </div>
        </td>
        <?php 
        $loop_count++; // Increment the loop count
    }

    // Close the last row if necessary
    if ($loop_count % 4 != 0) {
        echo '</tr>';
    }

    echo '</table>';
}
?>
</body>
</html>