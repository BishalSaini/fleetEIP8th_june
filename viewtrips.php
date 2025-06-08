<?php
include "partials/_dbconnect.php";
session_start();
$companyname001 = $_SESSION['companyname'];

$sql = "SELECT * FROM `triplogi` WHERE companyname='$companyname001'";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="favicon.jpg" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>View Trips</title>
</head>
<body>
    <div class="navbar1">
        <div class="logo_fleet">
            <img src="logo_fe.png" alt="FLEET EIP" onclick="window.location.href='logisticsdashboard.php'">
        </div>
        <div class="iconcontainer">
            <ul>
                <li><a href="logisticsdashboard.php">Dashboard</a></li>
                <li><a href="logout.php">Log Out</a></li>
            </ul>
        </div>
    </div>
    <?php if ($result && mysqli_num_rows($result) > 0) {
        echo '<table class="purchase_table" id="logi_rates"><tr>';

        $loop_count = 0; 

        while ($row = mysqli_fetch_assoc($result)) {
            if ($loop_count > 0 && $loop_count % 4 == 0) {
                echo '</tr><tr>'; 
            }
            $rowid = $row['id']; 
            ?>
            <td>
                <div class="custom-card" id="application_card">
                    <h3 class="custom-card__title" onclick="window.location.href='tripupdates.php?id=<?php echo $rowid; ?>'"><?php echo htmlspecialchars($row['consignor']); ?></h3>
                    <p class="insidedetails">Trip ID :<?php echo htmlspecialchars($row['tripid']); ?></p>
                    <p class="insidedetails">From-<?php echo htmlspecialchars($row['source'].' To '.$row['destination']); ?></p>
                    <p class="insidedetails">Freight Charges : <?php echo htmlspecialchars($row['freight_charges']); ?></p>
                                        <p class="insidedetails" id="button_container_resume">
                        <a title="Edit Trip" href='edittriprecord.php?id=<?php echo $rowid ; ?>'>
                            <button class="downloadresume" type="button"><i class="fa-regular fa-edit"></i></button>
                        </a>
                        <!-- <a title="Not Interested" id="" onclick="notinterested()">
                            <button class="downloadresume" type="button"><i class="fa-solid fa-eye"></i></button>
                        </a> -->
                    </p>

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
