<?php 
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
else {
    $dashboard_url = '';
}


if(isset($_SESSION['success'])){
    $showAlert=true;
    unset($_SESSION['success']);
}
else if(isset($_SESSION['error'])){
    $showError=true;
    unset($_SESSION['error']);
}
?>
<?php 
include "partials/_dbconnect.php";
$sql="SELECT * FROM `cn` where companyname='$companyname001' order by `id` desc";
$result=mysqli_query($conn,$sql);


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="favicon.jpg" type="image/x-icon">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <title>View CN</title>
    <link rel="stylesheet" href="tiles.css">
    <link rel="stylesheet" href="style.css">
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

    <!-- <div class="add_fleet_btn_new" id="logiquotation">
<button class="generate-btn"> 
    <article class="article-wrapper" onclick="window.location.href='generatechallan.php'" id="viewcnbutton"> 
  <div class="rounded-lg container-projectss ">
    </div>
    <div class="project-info">
      <div class="flex-pr">
        <div class="project-title text-nowrap">Generate Challan</div>
          <div class="project-hover">
            <svg style="color: black;" xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" color="black" stroke-linejoin="round" stroke-linecap="round" viewBox="0 0 24 24" stroke-width="2" fill="none" stroke="currentColor"><line y2="12" x2="19" y1="12" x1="5"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
            </div>
          </div>
          <div class="types">
        </div>
    </div>
</article>
    </button>


</div> -->
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
                
                <div class="custom-card" id="application_card" onclick="window.location.href='editcn.php?id=<?php echo $id; ?>'">
                    <h3 class="custom-card__title">CN :<?php echo htmlspecialchars($row['cnnumber']); ?></h3>
                    <p class="insidedetails">Date : <?php echo htmlspecialchars((new DateTime($row['cndate']))->format('d-m-Y')); ?></p>
                    <p class="insidedetails">Consignor :<?php echo htmlspecialchars($row['consignor']); ?></p>
                    <div class="insidedetails">Consignee : <?php echo htmlspecialchars($row['consignee_name']); ?></div>
                    <div class="insidedetails"><?php echo htmlspecialchars($row['consignor_state'] .' - '. $row['consignee_state']); ?></div>
<br>
                    <p class="insidedetails" id="button_container_resume">
                        <a href='printcn.php?id=<?php echo urlencode($row['id']); ?>'>
                            <button title="Print CN" class="transportbuttoncn" type="button">View CN</i>
                            <!-- <i class="fas fa-file-pdf"> -->

                            </button>
                        </a>
                        <a href='printchallan.php?id=<?php echo urlencode($row['id']); ?>'>
                            <button title="Print Challan" class="transportbuttoncn" type="button">View Challan
                            <!-- <i class="fas fa-print"></i> -->

                            </button>
                        </a>
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