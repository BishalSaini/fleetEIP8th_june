<?php
session_start();
include 'partials/_dbconnect.php';
$fleet_category = $_SESSION['fleet_category'];
$fleet_capacity = $_SESSION['fleet_capacity'];
$fleet_type = $_SESSION['fleet_type'];
?>

<style>
  <?php include "style.css"; ?>
</style>
<script>
    <?php include "main.js" ?>
    </script>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">      <link rel="icon" href="favicon.jpg" type="image/x-icon">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Crane</title>
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
    // session_start();  // Start the session
    if (isset($_SESSION['message'])) {
        echo '<label>
        <input type="checkbox" class="alertCheckbox" autocomplete="off" />
        <div class="alert notice">
          <span class="alertClose">X</span>
          <span class="alertText"><b>Success! </b> Request Submitted OEM Will Reach Out To You Shortly
              <br class="clear"/></span>
        </div>
        </label>';
        unset($_SESSION['message']);  // Remove the message from the session so it is displayed only once
    }
    ?>
    <?php
    if(isset($_SESSION['fleet_category']) && isset($_SESSION['fleet_capacity'])) {
        $fleet_category = $_SESSION['fleet_category'];
        $fleet_capacity = $_SESSION['fleet_capacity'];
        $fleet_type = $_SESSION['fleet_type'];

        // Query to fetch data based on session values
        $result = mysqli_query($conn, "SELECT * FROM `oem_fleet` WHERE fleet_category='$fleet_category' AND capacity='$fleet_capacity' AND fleet_type='$fleet_type'");
        
        if(mysqli_num_rows($result) > 0) {
            // Display the data in a table
            echo '<table class="purchase_table">';
            echo '<tr><th>Fleet Category</th><th>Fleet Type</th><th>Capacity</th><th>Counter Weight</th><th>OEM Name</th><th>Engine Make</th><th>Action</th></tr>';

            while ($row = mysqli_fetch_assoc($result)) {
                echo '<tr>';
                echo '<td>' . $row['fleet_category'] . '</td>';
                echo '<td>' . $row['fleet_type'] . '</td>';
                echo '<td>' . $row['capacity'] . '</td>';
                echo '<td>' . $row['counter_weight'] . '</td>';
                echo '<td>' . $row['companyname'] . '</td>';
                echo '<td>' . $row['engine_make'] . '</td>';

                ?>
                <td>
                <a class='btn_listing' href='crane_full_specs_readonly.php?id=<?php echo $row['sno']; ?>'>Full Specifications</a>
                <a class='btn_listing' href='request_quote.php?id=<?php echo $row['companyname']; ?>'>Request Quote</a>
                </td>
                <?php
                echo '</tr>';
            }

            echo '</table>';

            echo'<br>';
            echo "<a class='btn_listing10' href='request_quote_fromall.php'>Request Quote From All</a>";
        } else {
            echo "No matching records were found";
        }
    } else {
        echo "No session data was found"; // Handle case where session data is not set
    }
    ?>
    </div> <!-- Add this closing div tag -->
</body>

</html>