<?php
session_start(); // Ensure the session is started
include_once 'partials/_dbconnect.php'; // Include the database connection file

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
$showAlert=false;
$showError=false;
if(isset($_SESSION['success'])){
    $showAlert=true;
    unset($_SESSION['success']);
}
if(isset($_SESSION['error'])){
    $showError=true;
    unset($_SESSION['error']);
}

// Fetch the data from the database
$result = mysqli_query($conn, "SELECT * FROM `logi_price_quoted` WHERE `logistic_company_name` = '$companyname001'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="favicon.jpg" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css"> <!-- Correctly include CSS file -->
    <title>Document</title>
</head>
<body>
    <div class="navbar1">
        <div class="logo_fleet">
            <img src="logo_fe.png" alt="FLEET EIP" onclick="window.location.href='logisticsdashboard.php'">
        </div>
        <div class="iconcontainer">
            <ul>
                <li><a href="logisticsdashboard.php">Dashboard</a></li>
                <!-- <li><a href="about_us.html">About Us</a></li>
                <li><a href="contact_us.php">Contact Us</a></li> -->
                <li><a href="logout.php">Log Out</a></li>
            </ul>
        </div>
    </div>
    <?php 
    if($showAlert){
        echo '<label>
        <input type="checkbox" class="alertCheckbox" autocomplete="off" />
        <div class="alert notice">
          <span class="alertClose">X</span>
          <span class="alertText">Success 
              <br class="clear"/></span>
        </div>
      </label>';
     }
 if($showError){
    echo '<label>
    <input type="checkbox" class="alertCheckbox" autocomplete="off" />
    <div class="alert error">
        <span class="alertClose">X</span>
        <span class="alertText">Something Went Wrong<br class="clear"/></span>
    </div>
    </label>';
}


?>


    <?php if (mysqli_num_rows($result) > 0): ?>
        <!-- Start the table -->
        <table class="purchase_table" id="logi_rates">
            <tr>
                <?php
                $loop_count = 1; // Initialize the counter

                while ($row = mysqli_fetch_assoc($result)) {
                    if ($loop_count > 1 && ($loop_count - 1) % 4 == 0) {
                        echo '</tr><tr>'; // Close the current row and start a new one after every 3 cards
                    }
                ?>
                <td>
                    <div class="custom-card" id="application_card" >
                        <h3 class="custom-card__title" onclick="window.location.href='edit_quoted_price_logi.php?id=<?php echo $row['id']; ?>'">Material: <?php echo htmlspecialchars($row['material_detail']); ?></h3>
                        <p class="insidedetails"><?php echo htmlspecialchars($row['from_location'].' - ' . $row['to_location']); ?></p>
                        <p class="insidedetails">Company: <?php echo htmlspecialchars($row['requirement_company_name']); ?></p>
                        <p class="insidedetails">Quoted Price : <mark> <?php echo htmlspecialchars($row['quote_price']); ?> </mark></p>
                        <!-- <p class="insidedetails">Trailors: <?php echo htmlspecialchars($row['number_of_trailor']); ?></p> -->
                        <!-- Optional button section -->
                        <div class="custom-card__arrow">
                            <i class="fas fa-arrow-right"></i>
                        </div>
                    </div>
                </td>
                <?php
                    $loop_count++;
                }
                ?>
            </tr>
        </table>
    <?php endif; ?>

    <!-- Include JavaScript file correctly -->
    <script src="main.js"></script>
</body>
</html>
