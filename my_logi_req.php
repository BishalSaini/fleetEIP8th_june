<?php
include_once 'partials/_dbconnect.php';
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
else if(isset($_SESSION['something_went_wrong'])){
    $showError=true;
    unset($_SESSION['something_went_wrong']);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">      <link rel="icon" href="favicon.jpg" type="image/x-icon">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="tiles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <title>Document</title>
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
          <span class="alertText_addfleet"><b>Success!Requirement Edited
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

    <div class="generate_logi_requirement">    
        <article class="article-wrapper" id="post_rfq_button" onclick="location.href='logistics.php'" > 
  <div class="rounded-lg container-projectss ">
    </div>
    <div class="project-info">
      <div class="flex-pr">
        <div class="project-title text-nowrap">Post RFQ</div>
          <div class="project-hover">
            <svg style="color: black;" xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" color="black" stroke-linejoin="round" stroke-linecap="round" viewBox="0 0 24 24" stroke-width="2" fill="none" stroke="currentColor"><line y2="12" x2="19" y1="12" x1="5"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
            </div>
          </div>
          <div class="types">
        </div>
    </div>
</article>
</div>

<?php
include_once 'partials/_dbconnect.php';

$result = mysqli_query($conn, "SELECT * FROM `logistics_need` where `companyname_need_generator`='$companyname001' ORDER BY id desc");
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
            <div class="custom-card" id="rate_card">

                <h3 class="custom-card__title"><?php echo $row['material_detail'] ?></h3>
                <p class="insidedetails" id=""><?php echo $row['from'] .'-' . $row['from_pincode'] ?></p>
                <p class="insidedetails" id=""><?php echo $row['to'] .'-' . $row['to_pincode'] ?></p>

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