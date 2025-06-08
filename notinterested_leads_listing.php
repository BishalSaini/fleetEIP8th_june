<?php
session_start();
$email = $_SESSION["email"];
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
<?php
include 'partials/_dbconnect.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">      <link rel="icon" href="favicon.jpg" type="image/x-icon">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <style>
    <?php include "style.css"; ?>
  </style>
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
        <li><a href="logout.php">Log Out</a></li>
      </ul>
    </div>
    </div>

    <?php
    include_once 'partials/_dbconnect.php';
    $sql = "SELECT * FROM `notinterested_rental` WHERE `rental_name` = '$companyname001' ORDER BY id DESC"; 
    $result = mysqli_query($conn, $sql);
    ?>
        <?php
    if (mysqli_num_rows($result) > 0) {
        // Start the table
        echo '<table class="purchase_table" id="logi_rates"><tr>';

        $loop_count = 0; // Initialize the counter

        while ($row = mysqli_fetch_assoc($result)) {
            if ($loop_count > 0 && $loop_count % 4 == 0) {
                echo '</tr><tr>'; // Close the current row and start a new one after every 3 cards
            }
            ?>
            <td>
                <div class="custom-card" >
                <h3 class="custom-card__title" onclick="window.location.href='view_not_interested_leads_rental.php?id=<?php echo $row['id']; ?>'"><?php echo $row['equipment_type'] ?></h3>
                <p class="insidedetails">Capacity: <?php echo $row['equipment_capacity'] ?></p>
                    <p class="insidedetails">Duration : <?php echo $row['duration'] . ' Months' ?></p>
                    <p class="insidedetails">Project : <?php echo $row['project_type'] ?></p>
                    <p class="insidedetails">State : <?php echo $row['state'] ?></p>
                    <p class="insidedetails">Reason : <?php echo $row['not_interested_reason'] ?></p>
                    <!-- <p class="insidedetails">Quoted Price : <?php echo $row['price_quoted'] ?></p> -->
                    <p class="insidedetails" id="button_container_resume">
                        <!-- <a title="View And Quote Price" href='view_quoteprice_rental.php?id=<?php echo $row['id']; ?>'>
                            <button class="downloadresume" type="button"><i class="far fa-eye"></i></button>
                        </a> -->
                        <!-- <a title="Not Interested" id="" onclick="notinterested()">
                            <button class="downloadresume" type="button"><i class="fas fa-times"></i></button>
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

        // Close the last row and the table
        echo '</tr></table>';
    }
    ?>

</body>

</html>