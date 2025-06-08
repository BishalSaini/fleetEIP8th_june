<?php 
session_start();
$showAlert=false;
$showError=false;
include "partials/_dbconnect.php";
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
$sql="SELECT * FROM `challans` where companyname='$companyname001'";
$result=mysqli_query($conn,$sql);

if(isset($_SESSION['success'])){
    $showAlert= true;
    unset($_SESSION['success']);
  }
  else if(isset($_SESSION['error'])){
    $showErrort= true;
    unset($_SESSION['error']);
  
  }
  
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="favicon.jpg" type="image/x-icon">
    <title>Generated Challan</title>
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
            <!-- <li><a href="contact_us.php">Contact Us</a></li> -->
            <li><a href="logout.php">Log Out</a></li></ul>
        </div>
    </div> 
    <?php
if ($showAlert) {
    echo  '<label>
    <input type="checkbox" class="alertCheckbox" autocomplete="off" />
    <div class="alert notice">
      <span class="alertClose">X</span>
      <span class="alertText_addfleet"><b>Success! </b>
          <br class="clear"/></span>
    </div>
  </label>';
}
if ($showError) {
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
if(mysqli_num_rows($result)>0){
    echo '<table class="purchase_table" id="logi_rates"><tr>';

    $loop_count = 0;

    while($row=mysqli_fetch_assoc($result)){
        if ($loop_count > 0 && $loop_count % 4 == 0) {
            echo '</tr><tr>'; 
        }
        $id=$row['id'];
        ?>
            <td>
                
                <div class="custom-card" id="application_card" onclick="window.location.href='edit_challan.php?id=<?php echo $id; ?>'">
                    <h3 class="custom-card__title">CN :<?php echo htmlspecialchars($row['cnnumber']); ?></h3>
                    <!-- <p class="insidedetails">Date : <?php echo htmlspecialchars((new DateTime($row['cndate']))->format('d-m-Y')); ?></p> -->
                    <p class="insidedetails">Consignor :<?php echo htmlspecialchars($row['consignor']); ?></p>
                    <div class="insidedetails">Consignee : <?php echo htmlspecialchars($row['consignee']); ?></div>
                    <div class="insidedetails"><?php echo htmlspecialchars($row['source_station'] .' - '. $row['destination_station']); ?></div>
<br>
                    <!-- <p class="insidedetails" id="button_container_resume">
                        <a href='printcn.php?id=<?php echo urlencode($row['id']); ?>'>
                            <button title="Print" class="downloadresume" type="button"><i class="fas fa-file-pdf"></i>

                            </button>
                        </a> -->
                        <!-- <a href='javascript:void(0)'>
                            <button title="Mark As Sold" onclick='openPopup1(<?php echo intval($row['id']); ?>)' class="downloadresume" type="button"><i class="fa-solid fa-check-circle"></i></button>
                        </a> -->
                    <!-- </p> -->
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