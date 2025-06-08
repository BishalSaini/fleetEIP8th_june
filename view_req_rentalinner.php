<?php
include 'partials/_dbconnect.php';

?>
<?php
session_start();
$showAlert=false;
$showError=false;
$email = $_SESSION['email'];
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

<style>
  <?php include "style.css" ?>
</style>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">     
    <link rel="icon" href="favicon.jpg" type="image/x-icon">
    <link rel="stylesheet" href="tiles.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="stylesheet" href="style.css">
    <title>Requirements</title>
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

            <li><a href="logout.php">Log Out</a></li></ul>
        </div>
    </div>
    <?php
if($showAlert){
    echo '<label>
    <input type="checkbox" class="alertCheckbox" autocomplete="off" />
    <div class="alert notice">
        <span class="alertClose">X</span>
        <span class="alertText">Success<br class="clear"/></span>
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
    <div class="add_fleet_btn_new" id="leads_button">
<button class="generate-btn"> 
    <article class="article-wrapper" onclick="window.location.href='quoted_pricerental.php'" > 
  <div class="rounded-lg container-projectss ">
    </div>
    <div class="project-info">
      <div class="flex-pr">
        <div class="project-title text-nowrap">Quoted Price</div>
          <div class="project-hover">
            <svg style="color: black;" xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" color="black" stroke-linejoin="round" stroke-linecap="round" viewBox="0 0 24 24" stroke-width="2" fill="none" stroke="currentColor"><line y2="12" x2="19" y1="12" x1="5"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
            </div>
          </div>
          <div class="types">
        </div>
    </div>
</article>
    </button>

    <button class="generate-btn"> 
    <article class="article-wrapper" onclick="window.location.href='closed_rentalleads.php'" > 
  <div class="rounded-lg container-projectss ">
    </div>
    <div class="project-info">
      <div class="flex-pr">
        <div class="project-title text-nowrap">Closed Leads</div>
          <div class="project-hover">
            <svg style="color: black;" xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" color="black" stroke-linejoin="round" stroke-linecap="round" viewBox="0 0 24 24" stroke-width="2" fill="none" stroke="currentColor"><line y2="12" x2="19" y1="12" x1="5"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
            </div>
          </div>
          <div class="types">
        </div>
    </div>
</article>
    </button>


    <button class="generate-btn"> 
    <article class="article-wrapper" onclick="window.location.href='notinterested_leads_listing.php'" > 
  <div class="rounded-lg container-projectss ">
    </div>
    <div class="project-info">
      <div class="flex-pr">
        <div class="project-title text-nowrap">Regretted Leads</div>
          <div class="project-hover">
            <svg style="color: black;" xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" color="black" stroke-linejoin="round" stroke-linecap="round" viewBox="0 0 24 24" stroke-width="2" fill="none" stroke="currentColor"><line y2="12" x2="19" y1="12" x1="5"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
            </div>
          </div>
          <div class="types">
        </div>
    </div>
</article>
    </button>


</div>

    <?php
        if (isset($_SESSION['success_msg'])) {
            echo '<label>
            <input type="checkbox" class="alertCheckbox" autocomplete="off" />
            <div class="alert notice">
              <span class="alertClose">X</span>
              <span class="alertText">Listing Added To Not Interested
                  <br class="clear"/></span>
            </div>
          </label>';
            unset($_SESSION['success_msg']); // Unset the session after displaying the message
        }
        ?>
    <?php
$today = date('Y-m-d'); // Get today's date in PHP

$result = mysqli_query($conn, "SELECT * FROM req_by_epc e 
    WHERE NOT EXISTS (SELECT 1 FROM notinterested_rental n WHERE n.requirement_id = e.id AND n.rental_name = '$companyname001') 
    AND NOT EXISTS (SELECT 1 FROM requirement_price_byrental p WHERE p.req_id = e.id AND p.rental_name = '$companyname001') 
    AND reqvalid > '$today' 
    ORDER BY e.id DESC");
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
            <div class="custom-card" id="application_card">
                <h3 class="custom-card__title" onclick="window.location.href='view_quoteprice_rental.php?id=<?php echo $row['id']; ?>'"><?php echo $row['equipment_type'] ?></h3>
                <p class="insidedetails" id="">Capacity: <?php echo $row['equipment_capacity'] .' ' .$row['unit'] ?></p>
                <p class="insidedetails" id="email_logi">Duration : <?php echo $row['duration_month']  ?></p>
                <p class="insidedetails">Project : <?php echo $row['project_type'] ?></p>
                <p class="insidedetails">State : <?php echo $row['state'] ?></p>
                <p class="insidedetails" id="button_container_resume">
    <a title="Not Interested" id="" onclick="notinterested()">
        <button class="downloadresume" type="button"><i class="fa-solid fa-cancel"></i></button>
    </a>
</p>


                <div class="custom-card__arrow">
                    <i class="fas fa-arrow-right"></i>
                </div>
            </div>
        </td>
    <div class="info" id='notinterested'>
    <div class="notinterested_content">
        <div class="trial1">
        <select name="" id="notinterested_reason" class="input02" required>
            <option value="" disabled selected>Select A Reason</option>
            <option value="Equipment Not Available">Equipment Not Available</option>
            <option value="Non Serviceable Area">Non Serviceable Area</option>
            <option value="Rental Period Is Short">Rental Period Is Short</option>
            <option value="Client Issue">Client Issue</option>
            <option value="Other Reason">Other Reason</option>
        </select>
        </div>
        <div class="button_notinterested">
        <a title="Confirm" class='downloadresume' onclick="notinterested_Reasson(<?php echo $row['id']; ?>)"> <i class="fas fa-thumbs-up"></i></a>
            <a title="Cancel" class='downloadresume' href="view_req_rentalinner.php"><i class="fas fa-xmark"></i></a>
    </div>
    </div>
   </div> 
   <?php
        $loop_count++;
    }

    // Close the last row and the table
    echo '</tr></table>';
}
?>
   <script>
function notinterested(){
    const box=document.getElementById("notinterested");
    box.style.display='block';
}
function notinterested_Reasson(id) {
    const dropdown_reason=document.getElementById("notinterested_reason").value;
    window.location.href = 'notinterested.php?id=' + id + '&reasons=' + dropdown_reason;


}
    </script>
</body>
</html>