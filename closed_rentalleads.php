<?php
include_once 'partials/_dbconnect.php'; // Include the database connection file

// First SQL query
$sql = "SELECT * FROM `closed_requirement_epc_latest` ORDER BY id DESC";
$result = mysqli_query($conn, $sql);

// Second SQL query
$today = date('Y-m-d'); // Get today's date in PHP
$sql1 = "SELECT * FROM req_by_epc WHERE reqvalid < '$today' ORDER BY id ASC";
$result1 = mysqli_query($conn, $sql1);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="favicon.jpg" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Closed Leads</title>
    <style><?php include "style.css" ?></style>
</head>
<body>
    <div class="navbar1">
        <div class="logo_fleet">
            <img src="logo_fe.png" alt="FLEET EIP" onclick="window.location.href='<?php echo $dashboard_url ?>'">
        </div>
        <div class="iconcontainer">
            <ul>
                <li><a href="<?php echo $dashboard_url ?>">Dashboard</a></li>
                <li><a href="news/">News</a></li>
                <li><a href="logout.php">Log Out</a></li>
            </ul>
        </div>
    </div>

    <!-- Display results from the first query -->
    <!-- <h2>Closed Requirements</h2> -->
    <?php
    if (mysqli_num_rows($result) > 0) {
        echo '<table class="purchase_table" id="logi_rates"><tr>';
        $loop_count = 0; // Initialize the counter

        while ($row = mysqli_fetch_assoc($result)) {
            if ($loop_count > 0 && $loop_count % 4 == 0) {
                echo '</tr><tr>'; // Close the current row and start a new one after every 4 cards
            }
            ?>
            <td>
                <div class="custom-card">
                    <h3 class="custom-card__title" onclick="window.location.href='view_closedrequirement_full.php?id=<?php echo $row['id']; ?>'"><?php echo $row['equipment_type'] ?></h3>
                    <p class="insidedetails">Capacity: <?php echo $row['equipment_capacity'] . ' ' . $row['unit'] ?></p>
                    <p class="insidedetails">Duration : <?php echo $row['duration_month'] . ' Months' ?></p>
                    <p class="insidedetails">Project : <?php echo $row['project_type'] ?></p>
                    <p class="insidedetails">State : <?php echo $row['state'] ?></p>
                    <div class="custom-card__arrow">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </div>
            </td>
            <?php
            $loop_count++;
        }
        echo '</tr></table>';
    } 
    ?>

    <!-- Display results from the second query -->
    <!-- <h2>Expired Requirements</h2> -->
    <?php
    if (mysqli_num_rows($result1) > 0) {
        echo '<table class="purchase_table" id="logi_rates"><tr>';
        $loop_count = 0; // Initialize the counter

        while ($row1 = mysqli_fetch_assoc($result1)) {
            if ($loop_count > 0 && $loop_count % 4 == 0) {
                echo '</tr><tr>'; // Close the current row and start a new one after every 4 cards
            }
            ?>
            <td>
                <div class="custom-card">
                    <h3 class="custom-card__title"><?php echo $row1['equipment_type'] ?></h3>
                    <p class="insidedetails">Capacity: <?php echo $row1['equipment_capacity'] . ' ' . $row1['unit'] ?></p>
                    <p class="insidedetails">Duration : <?php echo $row1['duration_month'] . ' Months' ?></p>
                    <p class="insidedetails">Project : <?php echo $row1['project_type'] ?></p>
                    <p class="insidedetails">State : <?php echo $row1['state'] ?></p>
                    <div class="custom-card__arrow">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </div>
            </td>
            <?php
            $loop_count++;
        }
        echo '</tr></table>';
    } 
    ?>
</body>
</html>