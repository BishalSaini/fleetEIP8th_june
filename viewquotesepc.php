<?php
$id=$_GET['id'];
session_start();
$showAlert=false;
$showError=false;
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
elseif ($enterprise === 'admin') {
    $dashboard_url = 'news/admin/dashboard.php';
} 


else {
    $dashboard_url = '';
}
include "partials/_dbconnect.php";
$sql="SELECT * FROM `requirement_price_byrental` where req_id='$id'";
$result=mysqli_query($conn,$sql);


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quotes Recieved</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
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
            <li><a href="view_news_epc.php">News</a></li>
            <li><a href="logout.php">Log Out</a></li></ul>
        </div>
    </div> 
<?php
if (mysqli_num_rows($result) > 0) {
    echo '<div class="downloadsummary">
            <div class="links">
              <button class="follow" onclick="window.location.href=\'downloadsummary.php?id=' . $id . '\'">Download Summary</button>
              <!-- <button class="view">View profile</button> -->
            </div>
          </div>';

    echo '<table class="purchase_table" id="logi_rates"><tr>';

    $loop_count = 1; 
    while ($row = mysqli_fetch_assoc($result)) {
        if ($loop_count > 0 && $loop_count % 4 == 0) {
            echo '</tr><tr>'; 
        }
        ?>
        <td>
            <div class="custom-card" id="">
                <h3 class="custom-card__title" onclick="window.location.href='viewquotedetail.php?id=<?php echo $row['id']; ?>'"><?php echo $row['rental_name'] ?></h3>
                <p class="insidedetails" id="">Make-Model: <?php echo $row['offer_make'] .' ' .$row['offer_model'] ?></p>
                <p class="insidedetails" id="email_logi">YoM : <?php echo $row['offer_yom'] ?></p>
                <p class="insidedetails">Rental : <?php echo number_format($row['price_quoted'], 2); ?></p>
                <p class="insidedetails">Mob : <?php echo number_format($row['mob_charges'], 2); ?> &nbsp DeMob : <?php echo number_format($row['demob_charges'], 2); ?></p>
                <p class="insidedetails"></p>


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
else{
    echo '<p class="completeuser">No Quotes Recieved Yet</p>';
}
?>


</body>
</html>