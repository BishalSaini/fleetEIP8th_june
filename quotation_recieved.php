<?php
include 'partials/_dbconnect.php';
session_start();
$companyname = $_SESSION['companyname'];
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
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>
    <div class="navbar1">
    <div class="logo_fleet">
    <img src="logo_fe.png" alt="FLEET EIP" onclick="window.location.href='<?php echo $dashboard_url  ?>'">
</div>

        <div class="iconcontainer">
        <ul><li><a href="rental_dashboard.php">Dashboard</a></li>
            <li><a href="news/">News</a></li>
            <!-- <li><a href="contact_us.php">Contact Us</a></li> -->
            <li><a href="logout.php">LogOut</a></li></ul>
        </div>
</div>
<?php
$result = mysqli_query($conn, "SELECT * FROM `quote_required` WHERE `company name` = '$companyname' order by id desc");
if(mysqli_num_rows($result) > 0) {
    // Display the data in a table
    echo '<table class="purchase_table">';
    echo '<tr><th>Fleet Category</th><th>Fleet Type</th><th>Capacity</th><th>Project Location</th><th>OEM Contact Number</th><th>OEM Email</th><th>OEM Company Name</th><th>Price Quoted</th></tr>';
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<tr>';
        echo '<td>' . $row['fleet_category'] . '</td>';
        echo '<td>' . $row['fleet_type'] . '</td>';
        echo '<td>' . $row['fleet_capacity'] . '</td>';
        echo '<td>' . $row['project_location'] . '</td>';
        echo '<td>' . $row['oem_contact_number'] . '</td>';
        echo '<td>' . $row['oem_email'] . '</td>';
        echo '<td>' . $row['oem_company'] . '</td>';
        echo '<td>' . $row['price'] . '</td>';

        ?>
        <!-- <td>
        <a class='btn_listing' href='quote_price.php?id='>Quote A Price</a>
        </td> -->
        <?php
        echo '</tr>';
    }

    echo '</table>';

}
?>
</body>
</html>