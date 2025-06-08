<?php 
include "partials/_dbconnect.php";
session_start();
$showAlert = false;
$showError = false;
$showError1 = false;  // Added for client existence check

$companyname001 = $_SESSION['companyname'];
$enterprise = $_SESSION['enterprise'];
$dashboard_url = '';

if ($enterprise === 'rental') {
    $dashboard_url = 'rental_dashboard.php';
} elseif ($enterprise === 'logistics') {
    $dashboard_url = 'logisticsdashboard.php';
} elseif ($enterprise === 'epc') {
    $dashboard_url = 'epc_dashboard.php';
} elseif ($enterprise === 'admin') {
    $dashboard_url = 'news/admin/dashboard.php';
} else {
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $clientname = $_POST['clientname'];
    $hq = $_POST['hq'];
    $cell = $_POST['cell'];
    $state = $_POST['state'];
    $type = $_POST['type'];
    $website=$_POST['website'];

    $gst=$_POST['gst'];
    $payment_terms=$_POST['payment_terms'] ?? '';
    $adv_payment=$_POST['adv_payment'] ?? '';
    // $credit_terms=$_POST['credit_terms'] ?? '';
    $working_days=$_POST['working_days'] ?? '';
    $engine_hours=$_POST['engine_hours'] ?? '';





    // Check if the client already exists
    $checkSql = "SELECT * FROM `fleeteip_clientlist` WHERE `name` = '$clientname'";
    $checkResult = mysqli_query($conn, $checkSql);

    if (mysqli_num_rows($checkResult) > 0) {
        $showError1 = true;  // Client already exists
    } else {
        // Insert new client
        $sql = "INSERT INTO `fleeteip_clientlist`(`gst`,`payment_terms`,`adv_payment`,`working_days`,`engine_hours`,`name`, `hq`, `cell`, `state`, `type`, `added_by`, `website`)
                VALUES ('$gst','$payment_terms','$adv_payment','$working_days','$engine_hours','$clientname','$hq','$cell','$state','$type','$companyname001','$website')";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $showAlert = true;
        } else {
            $showError = true;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Client</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="tiles.css">
    <link rel="shortcut icon" href="favicon.jpg" type="image/x-icon">
</head>
<body>
<div class="navbar1">
    <div class="logo_fleet">
        <img src="logo_fe.png" alt="FLEET EIP" onclick="window.location.href='<?php echo $dashboard_url; ?>'">
    </div>
    <div class="iconcontainer">
        <ul>
            <li><a href="<?php echo $dashboard_url; ?>">Dashboard</a></li>
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
        <span class="alertText">Success<br class="clear"/></span>
    </div>
    </label>';
}
if ($showError) {
    echo '<label>
    <input type="checkbox" class="alertCheckbox" autocomplete="off" />
    <div class="alert error">
        <span class="alertClose">X</span>
        <span class="alertText">Something Went Wrong<br class="clear"/></span>
    </div>
    </label>';
}
if ($showError1) {
    echo '<label>
    <input type="checkbox" class="alertCheckbox" autocomplete="off" />
    <div class="alert error">
        <span class="alertClose">X</span>
        <span class="alertText">Client Already Exists<br class="clear"/></span>
    </div>
    </label>';
}
?>
    <!-- <div class="add_fleet_btn_new" id="rentalclientbutton" >
<button class="generate-btn"> 
    <article class="article-wrapper" onclick="window.location.href='adminclient.php'" id="rentalclientbuttoncontainer"> 
  <div class="rounded-lg container-projectss ">
    </div>
    <div class="project-info">
      <div class="flex-pr">
        <div class="project-title text-nowrap">View Client</div>
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
 -->
<form action="admin_addclient_directory.php" method="POST" class="addcleitnadmin" autocomplete="off">
    <div class="adminaddclientinner">
        <p class="headingpara">Add Client</p>
        <div class="trial1">
            <input type="text" placeholder="" name="clientname" class="input02" required>
            <label for="" class="placeholder2">Name</label>
        </div>
        <div class="trial1">
            <textarea name="hq" id="" placeholder="" class="input02" required></textarea>
            <label for="" class="placeholder2">HQ Address</label>
        </div>
    <div class="outer02">
        <div class="trial1">
            <input type="text" placeholder="" name="cell" class="input02">
            <label for="" class="placeholder2">Landline Number</label>
        </div>
        <div class="trial1">
            <input type="text" name="website" placeholder="" class="input02">
            <label for="" class="placeholder2">Website Address</label>
        </div>
        </div>
        <div class="outer02">
            <div class="trial1">
            <select name="state" id="state" class="input02" required>
    <option value="" disabled selected>Select State</option>
    <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
    <option value="Andhra Pradesh">Andhra Pradesh</option>
    <option value="Arunachal Pradesh">Arunachal Pradesh</option>
    <option value="Assam">Assam</option>
    <option value="Bihar">Bihar</option>
    <option value="Chandigarh">Chandigarh</option>
    <option value="Chhattisgarh">Chhattisgarh</option>
    <option value="Dadra and Nagar Haveli and Daman and Diu">Dadra and Nagar Haveli and Daman and Diu</option>
    <option value="Delhi">Delhi</option>
    <option value="Goa">Goa</option>
    <option value="Gujarat">Gujarat</option>
    <option value="Haryana">Haryana</option>
    <option value="Himachal Pradesh">Himachal Pradesh</option>
    <option value="Jammu and Kashmir">Jammu and Kashmir</option>
    <option value="Jharkhand">Jharkhand</option>
    <option value="Karnataka">Karnataka</option>
    <option value="Kerala">Kerala</option>
    <option value="Ladakh">Ladakh</option>
    <option value="Lakshadweep">Lakshadweep</option>
    <option value="Madhya Pradesh">Madhya Pradesh</option>
    <option value="Maharashtra">Maharashtra</option>
    <option value="Manipur">Manipur</option>
    <option value="Meghalaya">Meghalaya</option>
    <option value="Mizoram">Mizoram</option>
    <option value="Nagaland">Nagaland</option>
    <option value="Odisha">Odisha</option>
    <option value="Puducherry">Puducherry</option>
    <option value="Punjab">Punjab</option>
    <option value="Rajasthan">Rajasthan</option>
    <option value="Sikkim">Sikkim</option>
    <option value="Tamil Nadu">Tamil Nadu</option>
    <option value="Telangana">Telangana</option>
    <option value="Tripura">Tripura</option>
    <option value="Uttar Pradesh">Uttar Pradesh</option>
    <option value="Uttarakhand">Uttarakhand</option>
    <option value="West Bengal">West Bengal</option>
</select>
            </div>
            <div class="trial1">
                <select name="type" id="" class="input02" required>
                    <option value="" disabled selected>Client Type</option>
                    <option value="EPC">EPC</option>
                    <option value="Rental">Rental</option>
                    <option value="Logistics">Logistics</option>
                    <option value="RMC Company">RMC Company</option>
                    <option value="Broker">Broker</option>
                    <option value="OEM">OEM</option>
                </select>
            </div>
        </div>
        <!-- <div class="outer02"> -->
            <div class="trial1">
                <input type="text" placeholder="" name="gst" class="input02">
                <label for="" class="placeholder2">Gst Number</label>
            </div>
            <!-- <div class="trial1">
                <select name="adv_payment" id="" class="input02">
                    <option value=""disabled selected>Advance Payment</option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                </select>
            </div>

            <select name="payment_terms" id="" class="input02">
                <option value=""disabled selected>Payment Terms</option>
                <option value="within 7 days Of invoice submission">within 7 Days Of invoice submission</option>
        <option value="within 10 days Of invoice submission">within 10 Days Of invoice submission</option>
        <option value="within 30 days Of invoice submission">within 30 Days Of invoice submission</option>
        <option value="within 45 days Of invoice submission">within 45 Days Of invoice submission</option>

            </select>
        </div>
        <div class="outer02">
    <div class="trial1">
    <select name="working_days" id="" class="input02">
    <option value=""disabled selected>Select Working Hours</option>
    <option value="26">26 Days</option>
    <option value="27">27 Days</option>
    <option value="28">28 Days</option>
    <option value="29">29 Days</option>
    <option value="30">30 Days</option>
</select>

    </div>
    <div class="trial1">
        <select name="engine_hours" id="" class="input02">
            <option value=""disabled selected>Select Engine Hours</option>
            <option value="200">200 Hours</option>
            <option value="208">208 Hours</option>
            <option value="260">260 Hours</option>
            <option value="270">270 Hours</option>
            <option value="280">280 Hours</option>
            <option value="300">300 Hours</option>
            <option value="312">312 Hours</option>
            <option value="360">360 Hours</option>
            <option value="400">400 Hours</option>
            <option value="416">416 Hours</option>
            <option value="460">460 Hours</option>
            <option value="572">572 Hours</option>
            <option value="672">672 Hours</option>
            <option value="720">720 Hours</option>
        </select>
    </div>
</div> -->

        <button type="submit" class="epc-button">Submit</button>
    </div>
</form>
<?php include "adminclient.php" ?>
</body>
</html>
