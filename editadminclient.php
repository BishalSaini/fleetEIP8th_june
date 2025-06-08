<?php 
session_start();
$showAlert = false;
$showError = false;

include "partials/_dbconnect.php";
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


$id = $_GET['id'];
$sql = "SELECT * FROM `fleeteip_clientlist` WHERE id=$id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include "partials/_dbconnect.php";
    $clientname = $_POST['clientname'];
    $hq = $_POST['hq'];
    $cell = $_POST['cell'];
    $state = $_POST['state'];
    $type = $_POST['type'];
    $editid = $_POST['editid'];
    $website=$_POST['website'];

    $gst=$_POST['gst'];
    $payment_terms=$_POST['payment_terms'];
    $adv_payment=$_POST['adv_payment'];
    $working_days=$_POST['working_days'];
    $engine_hours=$_POST['engine_hours'];






    $edit = "UPDATE `fleeteip_clientlist` SET 
        `name`='$clientname',
        `hq`='$hq',
        `cell`='$cell',
        `state`='$state',
        `website`='$website',
        `gst`='$gst',
        `payment_terms`='$payment_terms',
        `adv_payment`='$adv_payment',
        `working_days`='$working_days',
        `engine_hours`='$engine_hours',
        `type`='$type'
        
        WHERE id='$editid'";

    $editresult = mysqli_query($conn, $edit);

    if ($editresult) {
        session_start();
        $_SESSION['success'] = 'true';
        header("Location: admin_addclient_directory.php");
        exit();
    } else {
        session_start();

        $_SESSION['error'] = 'true';
        header("Location: admin_addclient_directory.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit</title>
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
            <li><a href="news/">News</a></li>
            <!-- <li><a href="contact_us.php">Contact Us</a></li> -->
            <li><a href="logout.php">Log Out</a></li>
        </ul>
    </div>
</div>
<form action="editadminclient.php?id=<?php echo $id; ?>" method="POST" class="editadminclient" autocomplete="off">
    <div class="editadminclientinner">
        <p class="headingpara">Edit Client</p>
        <input type="hidden" name="editid" value="<?php echo $id; ?>">
        <div class="trial1">
            <input type="text" placeholder="" value="<?php echo $row['name'] ?>" name="clientname" class="input02" required>
            <label for="" class="placeholder2">Name</label>
        </div>
        <div class="trial1">
            <textarea name="hq" id="" placeholder="" class="input02" required><?php echo $row['hq'] ?></textarea>
            <label for="" class="placeholder2">HQ Address</label>
        </div>
        <div class="outer02">
        <div class="trial1">
            <input type="text" placeholder="" value="<?php echo $row['cell'] ?>" name="cell" class="input02">
            <label for="" class="placeholder2">Landline Number</label>
        </div>
        <div class="trial1">
            <input type="text" value="<?php echo $row['website'] ?>" name="website" placeholder="" class="input02">
            <label for="" class="placeholder2">Website Address</label>
        </div>
        </div>


        <div class="outer02">
            <div class="trial1">
                <select name="state" id="state" class="input02" required>
                    <option value="" disabled selected>Select State</option>
                    <option <?php if ($row['state'] === 'Andhra Pradesh') { echo 'selected'; } ?> value="Andhra Pradesh">Andhra Pradesh</option>
    <option <?php if ($row['state'] === 'Arunachal Pradesh') { echo 'selected'; } ?> value="Arunachal Pradesh">Arunachal Pradesh</option>
    <option <?php if ($row['state'] === 'Assam') { echo 'selected'; } ?> value="Assam">Assam</option>
    <option <?php if ($row['state'] === 'Bihar') { echo 'selected'; } ?> value="Bihar">Bihar</option>
    <option <?php if ($row['state'] === 'Chhattisgarh') { echo 'selected'; } ?> value="Chhattisgarh">Chhattisgarh</option>
    <option <?php if ($row['state'] === 'Goa') { echo 'selected'; } ?> value="Goa">Goa</option>
    <option <?php if ($row['state'] === 'Gujarat') { echo 'selected'; } ?> value="Gujarat">Gujarat</option>
    <option <?php if ($row['state'] === 'Haryana') { echo 'selected'; } ?> value="Haryana">Haryana</option>
    <option <?php if ($row['state'] === 'Himachal Pradesh') { echo 'selected'; } ?> value="Himachal Pradesh">Himachal Pradesh</option>
    <option <?php if ($row['state'] === 'Jharkhand') { echo 'selected'; } ?> value="Jharkhand">Jharkhand</option>
    <option <?php if ($row['state'] === 'Karnataka') { echo 'selected'; } ?> value="Karnataka">Karnataka</option>
    <option <?php if ($row['state'] === 'Kerala') { echo 'selected'; } ?> value="Kerala">Kerala</option>
    <option <?php if ($row['state'] === 'Madhya Pradesh') { echo 'selected'; } ?> value="Madhya Pradesh">Madhya Pradesh</option>
    <option <?php if ($row['state'] === 'Maharashtra') { echo 'selected'; } ?> value="Maharashtra">Maharashtra</option>
    <option <?php if ($row['state'] === 'Manipur') { echo 'selected'; } ?> value="Manipur">Manipur</option>
    <option <?php if ($row['state'] === 'Meghalaya') { echo 'selected'; } ?> value="Meghalaya">Meghalaya</option>
    <option <?php if ($row['state'] === 'Mizoram') { echo 'selected'; } ?> value="Mizoram">Mizoram</option>
    <option <?php if ($row['state'] === 'Nagaland') { echo 'selected'; } ?> value="Nagaland">Nagaland</option>
    <option <?php if ($row['state'] === 'Odisha') { echo 'selected'; } ?> value="Odisha">Odisha</option>
    <option <?php if ($row['state'] === 'Punjab') { echo 'selected'; } ?> value="Punjab">Punjab</option>
    <option <?php if ($row['state'] === 'Rajasthan') { echo 'selected'; } ?> value="Rajasthan">Rajasthan</option>
    <option <?php if ($row['state'] === 'Sikkim') { echo 'selected'; } ?> value="Sikkim">Sikkim</option>
    <option <?php if ($row['state'] === 'Tamil Nadu') { echo 'selected'; } ?> value="Tamil Nadu">Tamil Nadu</option>
    <option <?php if ($row['state'] === 'Telangana') { echo 'selected'; } ?> value="Telangana">Telangana</option>
    <option <?php if ($row['state'] === 'Tripura') { echo 'selected'; } ?> value="Tripura">Tripura</option>
    <option <?php if ($row['state'] === 'Uttar Pradesh') { echo 'selected'; } ?> value="Uttar Pradesh">Uttar Pradesh</option>
    <option <?php if ($row['state'] === 'Uttarakhand') { echo 'selected'; } ?> value="Uttarakhand">Uttarakhand</option>
    <option <?php if ($row['state'] === 'West Bengal') { echo 'selected'; } ?> value="West Bengal">West Bengal</option>
    <option <?php if ($row['state'] === 'Andaman and Nicobar Islands') { echo 'selected'; } ?> value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
    <option <?php if ($row['state'] === 'Chandigarh') { echo 'selected'; } ?> value="Chandigarh">Chandigarh</option>
    <option <?php if ($row['state'] === 'Dadra and Nagar Haveli and Daman and Diu') { echo 'selected'; } ?> value="Dadra and Nagar Haveli and Daman and Diu">Dadra and Nagar Haveli and Daman and Diu</option>
    <option <?php if ($row['state'] === 'Lakshadweep') { echo 'selected'; } ?> value="Lakshadweep">Lakshadweep</option>
    <option <?php if ($row['state'] === 'Delhi') { echo 'selected'; } ?> value="Delhi">Delhi</option>
    <option <?php if ($row['state'] === 'Puducherry') { echo 'selected'; } ?> value="Puducherry">Puducherry</option>                </select>
            </div>
            <div class="trial1">
                <select name="type" id="" class="input02" required>
                    <option value="" disabled selected>Client Type</option>
                    <option <?php if($row['type']==='EPC'){echo 'selected';} ?> value="EPC">Client Type: EPC</option>
                    <option <?php if($row['type']==='Rental'){echo 'selected';} ?> value="Rental">Client Type: Rental</option>
                    <option <?php if($row['type']==='Logistics'){echo 'selected';} ?> value="Logistics">Client Type: Logistics</option>
                    <option <?php if($row['type']==='RMC Company'){echo 'selected';} ?> value="RMC Company">Client Type: RMC Company</option>
                    <option <?php if($row['type']==='Broker'){echo 'selected';} ?> value="Broker">Client Type: Broker</option>
                    <option <?php if($row['type']==='OEM'){echo 'selected';} ?> value="OEM">Client Type: OEM</option>
                </select>
            </div>
        </div>
        <div class="outer02">
            <div class="trial1">
                <input type="text" placeholder="" value="<?php echo $row['gst']; ?>" name="gst" class="input02">
                <label for="" class="placeholder2">Gst Number</label>
            </div>
            <div class="trial1">
                <select name="adv_payment" id="" class="input02">
                    <option value=""disabled selected>Advance Payment</option>
                    <option <?php if($row['adv_payment']==='Yes'){echo 'selected';} ?> value="Yes">Advance Payment : Yes</option>
                    <option <?php if($row['adv_payment']==='No'){echo 'selected';} ?> value="No">Advance Payment :No</option>
                </select>
            </div>

            <select name="payment_terms" id="" class="input02">
                <option value=""disabled selected>Payment Terms</option>
                <option <?php if($row['payment_terms']==='within 7 days Of invoice submission'){echo 'selected';} ?> value="within 7 days Of invoice submission">Pay Terms: within 7 Days Of invoice submission</option>
                <option <?php if($row['payment_terms']==='within 10 days Of invoice submission'){echo 'selected';} ?> value="within 10 days Of invoice submission">Pay Terms: within 10 Days Of invoice submission</option>
                <option <?php if($row['payment_terms']==='within 30 days Of invoice submission'){echo 'selected';} ?> value="within 30 days Of invoice submission">Pay Terms: within 30 Days Of invoice submission</option>
                <option <?php if($row['payment_terms']==='within 45 days Of invoice submission'){echo 'selected';} ?> value="within 45 days Of invoice submission">Pay Terms: within 45 Days Of invoice submission</option>

            </select>
        </div>
        <div class="outer02">
    <div class="trial1">
    <select name="working_days" id="" class="input02">
    <option value=""disabled selected>Select Working Hours</option>
    <option <?php if($row['working_days']==='26'){echo 'selected';} ?> value="26">Working Hours: 26 Days</option>
    <option <?php if($row['working_days']==='27'){echo 'selected';} ?> value="27">Working Hours: 27 Days</option>
    <option <?php if($row['working_days']==='28'){echo 'selected';} ?> value="28">Working Hours: 28 Days</option>
    <option <?php if($row['working_days']==='29'){echo 'selected';} ?> value="29">Working Hours: 29 Days</option>
    <option <?php if($row['working_days']==='30'){echo 'selected';} ?> value="30">Working Hours: 30 Days</option>
</select>

    </div>
    <div class="trial1">
        <select name="engine_hours" id="" class="input02">
            <option value=""disabled selected>Select Engine Hours</option>
            <option <?php if($row['engine_hours']==='200'){echo 'selected';} ?> value="200">Engine Hours: 200 Hours</option>
            <option <?php if($row['engine_hours']==='208'){echo 'selected';} ?> value="208">Engine Hours: 208 Hours</option>
            <option <?php if($row['engine_hours']==='260'){echo 'selected';} ?> value="260">Engine Hours: 260 Hours</option>
            <option <?php if($row['engine_hours']==='270'){echo 'selected';} ?> value="270">Engine Hours: 270 Hours</option>
            <option <?php if($row['engine_hours']==='280'){echo 'selected';} ?> value="280">Engine Hours: 280 Hours</option>
            <option <?php if($row['engine_hours']==='300'){echo 'selected';} ?> value="300">Engine Hours: 300 Hours</option>
            <option <?php if($row['engine_hours']==='312'){echo 'selected';} ?> value="312">Engine Hours: 312 Hours</option>
            <option <?php if($row['engine_hours']==='360'){echo 'selected';} ?> value="360">Engine Hours: 360 Hours</option>
            <option <?php if($row['engine_hours']==='400'){echo 'selected';} ?> value="400">Engine Hours: 400 Hours</option>
            <option <?php if($row['engine_hours']==='416'){echo 'selected';} ?> value="416">Engine Hours: 416 Hours</option>
            <option <?php if($row['engine_hours']==='460'){echo 'selected';} ?> value="460">Engine Hours: 460 Hours</option>
            <option <?php if($row['engine_hours']==='572'){echo 'selected';} ?> value="572">Engine Hours: 572 Hours</option>
            <option <?php if($row['engine_hours']==='672'){echo 'selected';} ?> value="672">Engine Hours: 672 Hours</option>
            <option <?php if($row['engine_hours']==='720'){echo 'selected';} ?> value="720">Engine Hours: 720 Hours</option>
        </select>
    </div>
</div>


        <button type="submit" class="epc-button">Submit</button>

    </div>
</form>

</body>
</html>