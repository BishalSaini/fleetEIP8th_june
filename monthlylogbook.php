<?php
include "partials/_dbconnect.php";
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$companyname001 = $_SESSION['companyname'];
$enterprise = $_SESSION['enterprise'];
$email = $_SESSION['email'];

$assetcodeget=$_GET['assetcode'];
$worefnoget=$_GET['worefno'];
$clientnameget=$_GET['clientname'];
$sitelocation=$_GET['sitelocation'];

$sql="SELECT * FROM `logsheetnew` where assetcode='$assetcodeget' and worefno='$worefnoget' and clientname='$clientnameget' and sitelocation='$sitelocation'  and companyname='$companyname001' group by month_year ";
$result=mysqli_query($conn,$sql);

$dashboard_url = '';
if ($enterprise === 'rental') {
    $dashboard_url = 'rental_dashboard.php';
} elseif ($enterprise === 'logistics') {
    $dashboard_url = 'logisticsdashboard.php';
} elseif ($enterprise === 'epc') {
    $dashboard_url = 'epc_dashboard.php';
} elseif ($enterprise === 'admin') {
    $dashboard_url = 'news/admin/dashboard.php';
}
$showAlert = false;
$showError = false;

if (isset($_SESSION['success'])) {
    $showAlert = true;
    unset($_SESSION['success']);
} else if (isset($_SESSION['error'])) {
    $showError = true;
    unset($_SESSION['error']);

}
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <title>Monthly Log </title>
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="favicon.jpg" type="image/x-icon">
    <script src="main.js"></script>
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
    <?php
    if ($showAlert) {
        echo '<label>
    <input type="checkbox" class="alertCheckbox" autocomplete="off" />
    <div class="alert notice">
      <span class="alertClose">X</span>
      <span class="alertText_addfleet"><b>Success!</b>LogSheet Added Successfully
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
        <div class="fulllength">
        <!-- <button onclick="downloadsummary()" class="downloadbuttonsummary">Download</button> -->
        <button
            onclick="window.location.href='logsheetdashboard.php'"
            class="gobackbuttonsummary"> <i class="bi bi-arrow-left"></i> Go Back
        </button>
    </div>

    <?php
if(mysqli_num_rows($result)>0){
    echo '<table class="purchase_table" id="logi_rates"><tr>';

    $loop_count = 0;

    while($row=mysqli_fetch_assoc($result)){
        if ($loop_count > 0 && $loop_count % 2 == 0) {
            echo '</tr><tr>'; 
        }
        $id=$row['id'];
        ?>
            <td>
                
            <div class="custom-card" id="application_card" onclick="window.location.href='logsheetsummary.php?assetcode=<?php echo urlencode($row['assetcode']); ?>&worefno=<?php echo urlencode($row['worefno']); ?>&clientname=<?php echo $row['clientname'] ?>&month=<?php echo $row['month_year'] ?>&sitelocation=<?php echo $row['sitelocation'] ?>'">
            <h3 class="custom-card__title">Month : <?php echo htmlspecialchars($row['month_year']); ?></h3>
            <br>
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