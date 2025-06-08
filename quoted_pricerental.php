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
$showAlert = false;
$showError = false;

?>
<?php
if(isset($_SESSION['success'])){
    $showAlert=true;
    unset($_SESSION['success']);
}
else if(isset($_SESSION['wrong'])){
    $showError=true;
    unset($_SESSION['wrong']);

}
?>

<style>
  <?php include "style.css" ?>
</style>
<script>
  <?php include "main.js" ?>
</script>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="favicon.jpg" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Leads</title>
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
    if($showAlert){
        echo  '<label>
        <input type="checkbox" class="alertCheckbox" autocomplete="off" />
        <div class="alert notice">
          <span class="alertClose">X</span>
          <span class="alertText_addfleet"><b>Success!
              <br class="clear"/></span>
        </div>
      </label>';
    }
    if($showError){
        echo '<label>
        <input type="checkbox" class="alertCheckbox" autocomplete="off" />
        <div class="alert error">
          <span class="alertClose">X</span>
          <span class="alertText">Something Went Wrong
              <br class="clear"/></span>
        </div>
      </label>';
    }
    ?>

<?php
include_once 'partials/_dbconnect.php'; // Include the database connection file

$result = mysqli_query($conn, "SELECT r.id, r.equipment_type, r.equipment_capacity, r.unit, r.duration_month, r.project_type, r.state, rp.price_quoted,rp.mob_charges,rp.demob_charges
    FROM `requirement_price_byrental` rp
    INNER JOIN `req_by_epc` r ON rp.req_id = r.id
    WHERE rp.rental_name = '$companyname001'
    ORDER BY r.id DESC");
if (mysqli_num_rows($result) > 0) {
    // Start the table
    echo '<table class="purchase_table" id="logi_rates"><tr>';

    $loop_count = 1; // Initialize the counter

    while ($row = mysqli_fetch_assoc($result)) {
        if ($loop_count > 0 && $loop_count % 4 == 0) {
            echo '</tr><tr>'; // Close the current row and start a new one after every 3 cards
        }
        ?>
        <td>
            <div class="custom-card" id="">
                <h3 class="custom-card__title" onclick="window.location.href='edit_rental_price.php?id=<?php echo $row['id']; ?>'"><?php echo $row['equipment_type'] ?></h3>
                <p class="insidedetails" id="">Capacity: <?php echo $row['equipment_capacity'] .' ' .$row['unit'] ?></p>
                <p class="insidedetails" id="email_logi">Duration : <?php echo $row['duration_month'] .' Months' ?></p>
                <p class="insidedetails">Project : <?php echo $row['project_type'] ?></p>
                <p class="insidedetails">State : <?php echo $row['state'] ?></p>
                <p class="insidedetails">Quoted Price : <?php echo $row['price_quoted'] ?></p>
                <p class="insidedetails">Mob-Charges : <?php echo $row['mob_charges'] ?> DeMob-Charges : <?php echo $row['demob_charges'] ?></p>
                <p class="insidedetails"></p>
                <p class="insidedetails" id="button_container_resume">
    <!-- <a title="View And Quote Price" href='view_quoteprice_rental.php?id=<?php echo $row['id']; ?>'>
        <button class="downloadresume" type="button"><i class="fa-regular fa-eye"></i></button>
    </a> -->
    <!-- <a title="Not Interested" id="" onclick="notinterested()">
        <button class="downloadresume" type="button"><i class="fa-solid fa-cancel"></i></button>
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
