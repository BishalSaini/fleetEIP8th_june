<?php 
session_start();
$companyname001 = $_SESSION['companyname'];
$enterprise=$_SESSION['enterprise'];
$id=$_GET['id'];

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
include "partials/_dbconnect.php";

$sql="SELECT * FROM `cn` where id='$id' and companyname='$companyname001'";
$result=mysqli_query($conn,$sql);
if($result){
    $row=mysqli_fetch_assoc($result);
}
else{
    $row=array();
}

$sqlMaxChallanNumber = "SELECT MAX(challannumber) AS max_challan_number FROM `challans` WHERE companyname = '$companyname001'";
$resultMaxChallanNumber = mysqli_query($conn, $sqlMaxChallanNumber);
$rowMaxChallanNumber = mysqli_fetch_assoc($resultMaxChallanNumber);
$nextChallanNumber = ($rowMaxChallanNumber['max_challan_number'] === null) ? 1 : $rowMaxChallanNumber['max_challan_number'] + 1;

if (isset($_GET['tripid']) && !empty($_GET['tripid'])) {
    $tripidinfo = $_GET['tripid'];
}


?>
<?php
include "partials/_dbconnect.php";
if (($_SERVER['REQUEST_METHOD']==='POST') && isset($_POST['generatecnsubmit'])) {
    // Retrieve form input values
    $branch = $_POST['branch'] ?? '';
    $cnnumber = $_POST['cnnumber'] ?? '';
    $cndate = $_POST['cndate'] ?? '';
    $consignor = $_POST['consignor'] ?? '';
    $consignor_state = $_POST['consignor_state'] ?? '';
    $booking_station = $_POST['booking_station'] ?? '';
    $consignor_address = $_POST['consignor_address'] ?? '';
    $consignor_contactperson = $_POST['consignor_contactperson'] ?? '';
    $consignor_email = $_POST['consignor_email'] ?? '';

    // Consignee Information
    $consignee_name = $_POST['consignee_name'] ?? '';
    $consignee_state = $_POST['consignee_state'] ?? '';
    $consignee_booking_station = $_POST['consignee_booking_station'] ?? '';
    $consignee_address = $_POST['consignee_address'] ?? '';
    $consignee_contactperson = $_POST['consignee_contactperson'] ?? '';
    $consignee_email = $_POST['consignee_email'] ?? '';

    // Goods Information
    $no_of_package = $_POST['no_of_package'] ?? '';
    $actual_weight = $_POST['actual_weight'] ?? '';
    $charge_weight = $_POST['charge_weight'] ?? '';
    $load_type = $_POST['load_type'] ?? '';
    $load_desc = $_POST['load_desc'] ?? '';
    $delivery_basis = $_POST['delivery_basis'] ?? '';
    $billing_basis = $_POST['billing_basis'] ?? '';
    $gst = $_POST['gst'] ?? '';
    $freight = $_POST['freight'] ?? '';
    $invoice_number = $_POST['invoice_number'] ?? '';
    $invoice_date = $_POST['invoice_date'] ?? '';
    $goods_value = $_POST['goods_value'] ?? '';
    $waybill = $_POST['waybill'] ?? '';
    $waybill_validity = $_POST['waybill_validity'] ?? '';
    $billing_party = $_POST['billing_party'] ?? '';
    $billingparty_address = $_POST['billingparty_address'] ?? '';
    $billingparty_contactperson = $_POST['billingparty_contactperson'] ?? '';
    $billingparty_contactnumber = $_POST['billingparty_contactnumber'] ?? '';
    $billingparty_contactemail = $_POST['billingparty_contactemail'] ?? '';
    $editid=$_POST['editid'];



    $billingparty_state=$_POST['billingparty_state'] ?? '';
    $taxes=$_POST['taxes'] ?? '';
    $consignee_gst=$_POST['consignee_gst'];
    $consignor_gst=$_POST['consignor_gst'];
    $consignee_contactperson_number=$_POST['consignee_contactperson_number']?? '';
    $consignor_contactnumber=$_POST['consignor_contactnumber'];
    $billingparty_gst=$_POST['billingparty_gst'];
    $vehicle_reg=$_POST['vehicle_reg'];





    $challan_num = $_POST['challan_num'] ?? '';
    $capacity = $_POST['capacity'] ?? '';
    $vehicle_ownership = $_POST['vehicle_ownership'] ?? '';
    $driver_name = $_POST['driver_name'] ?? '';
    $driver_mobile = $_POST['driver_mobile'] ?? '';
    $broker_name = $_POST['broker_name'] ?? '';
    $broker_mobile = $_POST['broker_mobile'] ?? '';
    $lorryhire = $_POST['lorryhire'] ?? '';
    $loading_charge = $_POST['loading_charge'] ?? '';
    $height_charge = $_POST['height_charge'] ?? '';
    $length_charge = $_POST['length_charge'] ?? '';
    $detention_charge = $_POST['detention_charge'] ?? '';
    $misc_expense = $_POST['misc_expense'] ?? '';
    $total_hire = $_POST['total_hire'] ?? '';
    $advance = $_POST['advance'] ?? '';
    $balance = $_POST['balance'] ?? '';
    $remark = $_POST['remark'] ?? '';
    $brokercontactperson = $_POST['brokercontactperson'] ?? '';
    $owner_name = $_POST['owner_name'] ?? '';
    $dl = $_POST['dl'] ?? '';
    $tripid = $_POST['tripid'] ?? '';
    $vehicle_type = $_POST['vehicle_type'] ?? '';
    

    $sqlupdate = "UPDATE `cn` SET 
    `branch` = '$branch',
    `companyname` = '$companyname001',
    `cndate` = '$cndate',
    `consignor` = '$consignor',
    `consignor_state` = '$consignor_state',
    `booking_station` = '$booking_station',
    `consignor_address` = '$consignor_address',
    `consignor_contactperson` = '$consignor_contactperson',
    `consignor_email` = '$consignor_email',
    `consignee_name` = '$consignee_name',
    `consignee_state` = '$consignee_state',
    `consignee_booking_station` = '$consignee_booking_station',
    `consignee_address` = '$consignee_address',
    `consignee_contactperson` = '$consignee_contactperson',
    `consignee_email` = '$consignee_email',
    `no_of_package` = $no_of_package,
    `actual_weight` = $actual_weight,
    `charge_weight` = $charge_weight,
    `load_type` = '$load_type',
    `load_desc` = '$load_desc',
    `delivery_basis` = '$delivery_basis',
    `billing_basis` = '$billing_basis',
    `gst` = '$gst',
    `freight` = $freight,
    `invoice_number` = '$invoice_number',
    `invoice_date` = '$invoice_date',
    `goods_value` = $goods_value,
    `waybill` = $waybill,
    `waybill_validity` = '$waybill_validity',
    `billing_party` = '$billing_party_name',
    `billingparty_address` = '$billingparty_address',
    `billingparty_contactperson` = '$billingparty_contactperson',
    `billingparty_contactnumber` = '$billingparty_contactnumber',
    `billingparty_contactemail` = '$billingparty_contactemail',
    `taxes` = '$taxes',
    `consignor_gst` = '$consignor_gst',
    `consignee_gst` = '$consignee_gst',
    `consignor_contactnumber` = '$consignor_contactnumber',
    `consignee_contactnumber` = '$consignee_contactperson_number',
    `billingparty_state` = '$billingparty_state',
    `billingparty_gst` = '$billingparty_gst',
    `vehicle_reg` = '$vehicle_reg',
    `Challannumber` = '$challan_num',
    `capacity` = '$capacity',
    `vehicle_ownership` = '$vehicle_ownership',
    `driver_name` = '$driver_name',
    `driver_mobile` = '$driver_mobile',
    `broker_name` = '$broker_name',
    `broker_mobile` = '$broker_mobile',
    `lorryhire` = '$lorryhire',
    `loading_charge` = '$loading_charge',
    `height_charge` = '$height_charge',
    `length_charge` = '$length_charge',
    `detention_charge` = '$detention_charge',
    `misc_expense` = '$misc_expense',
    `total_hire` = '$total_hire',
    `advance` = '$advance',
    `balance` = '$balance',
    `remark` = '$remark',
    `brokercontactperson` = '$brokercontactperson',
    `owner_name` = '$owner_name',
    `dl` = '$dl',
    `vehicle_type` = '$vehicle_type'
WHERE 
    `id` = '$editid' and companyname='$companyname001'"; 



//     $sqlupdate = "UPDATE `cn` SET
//     `branch` = '$branch',
//     `companyname` = '$companyname001',
//     `cnnumber` = '$cnnumber',
//     `cndate` = '$cndate',
//     `consignor` = '$consignor',
//     `consignor_state` = '$consignor_state',
//     `booking_station` = '$booking_station',
//     `consignor_address` = '$consignor_address',
//     `consignor_contactperson` = '$consignor_contactperson',
//     `consignor_email` = '$consignor_email',
//     `consignee_name` = '$consignee_name',
//     `consignee_state` = '$consignee_state',
//     `consignee_booking_station` = '$consignee_booking_station',
//     `consignee_address` = '$consignee_address',
//     `consignee_contactperson` = '$consignee_contactperson',
//     `consignee_email` = '$consignee_email',
//     `no_of_package` = $no_of_package,
//     `actual_weight` = $actual_weight,
//     `charge_weight` = $charge_weight,
//     `load_type` = '$load_type',
//     `load_desc` = '$load_desc',
//     `delivery_basis` = '$delivery_basis',
//     `billing_basis` = '$billing_basis',
//     `gst` = '$gst',
//     `freight` = $freight,
//     `invoice_number` = '$invoice_number',
//     `invoice_date` = '$invoice_date',
//     `goods_value` = $goods_value,
//     `waybill` = $waybill,
//     `waybill_validity` = '$waybill_validity',
//     `billing_party` = '$billing_party',
//     `billingparty_address` = '$billingparty_address',
//     `billingparty_contactperson` = '$billingparty_contactperson',
//     `billingparty_contactnumber` = '$billingparty_contactnumber',
//     `billingparty_contactemail` = '$billingparty_contactemail'
// WHERE
//     `id` = '$editid' and companyname='$companyname001'"; 
    $resultedit=mysqli_query($conn,$sqlupdate);
    if($resultedit){
        session_start();
        $_SESSION['success']='success';
        header("Location:viewcn.php");
        exit();
    }
    else{
        session_start();
        $_SESSION['error']='success';
        header("Location:viewcn.php");
        exit();

    }


}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="favicon.jpg" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Edit CN</title>
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
    $showAlert=false;
    $showError=false;
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

    <form class="generatecnform" method="POST" action="editcn.php" autocomplete="off">
    <div class="consigerinfo" id="consignorform">
        <p>Edit CN</p>
        <input type="text" name="editid" value="<?php echo $id; ?>" hidden>
        <div class="outer02">
            <div class="trial1">
                <input type="text" placeholder="" name="branch" class="input02" value="<?php echo htmlspecialchars($row['branch']); ?>">
                <label for="" class="placeholder2">Branch Name</label>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" value="<?php echo htmlspecialchars($row['cnnumber']); ?>" name="cnnumber" class="input02">
                <label for="" class="placeholder2">CN number</label>
            </div>
            <div class="trial1">
                <input type="date" placeholder="" name="cndate" class="input02" value="<?php echo htmlspecialchars($row['cndate']); ?>">
                <label for="" class="placeholder2">CN Date</label>
            </div>
        </div>
        <div class="trial1">
            <input type="text" placeholder="" name="booking_station" class="input02" value="<?php echo htmlspecialchars($row['booking_station']); ?>">
            <label for="" class="placeholder2">Booking Station Name</label>
        </div>
        <div class="outer02">
            <div class="trial1">
                <input type="text" placeholder="" name="consignor" class="input02" value="<?php echo htmlspecialchars($row['consignor']); ?>">
                <label for="" class="placeholder2">Consignor Name</label>
            </div>
            <div class="trial1">
                <select id="states" name="consignor_state" class="input02">
                    <option value="" disabled selected>Consignor State</option>
                    <?php
                    $states = ["Andhra Pradesh", "Arunachal Pradesh", "Assam", "Bihar", "Chhattisgarh", "Goa", "Gujarat", "Haryana", "Himachal Pradesh", "Jharkhand", "Karnataka", "Kerala", "Madhya Pradesh", "Maharashtra", "Manipur", "Meghalaya", "Mizoram", "Nagaland", "Odisha", "Punjab", "Rajasthan", "Sikkim", "Tamil Nadu", "Telangana", "Tripura", "Uttar Pradesh", "Uttarakhand", "West Bengal", "Andaman and Nicobar Islands", "Chandigarh", "Dadra and Nagar Haveli and Daman and Diu", "Lakshadweep", "Delhi", "Puducherry"];
                    foreach ($states as $state) {
                        $selected = ($row['consignor_state'] === $state) ? 'selected' : '';
                        echo "<option value=\"$state\" $selected>$state</option>";
                    }
                    ?>
                </select>
            </div>

        </div>
        <div class="trial1">
            <textarea type="text" placeholder="" name="consignor_address" class="input02"><?php echo htmlspecialchars($row['consignor_address']); ?></textarea>
            <label for="" class="placeholder2">Consignor Address</label>
        </div>
        <div class="outer02">
            <div class="trial1">
                <input type="text" placeholder="" name="consignor_contactperson" class="input02" value="<?php echo htmlspecialchars($row['consignor_contactperson']); ?>">
                <label for="" class="placeholder2">Contact Person</label>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" name="consignor_email" class="input02" value="<?php echo htmlspecialchars($row['consignor_email']); ?>">
                <label for="" class="placeholder2">Contact Email</label>
            </div>
        </div>
        <button type="button" class="epc-button" onclick="showconsigneeinfo()">Next</button>
        </div>
    <div class="consigneeinfo" id="consigneeform">
        <p>Consignee Information</p>
        <div class="trial1">
            <input type="text" placeholder="" name="consignee_name" class="input02" value="<?php echo htmlspecialchars($row['consignee_name']); ?>">
            <label for="" class="placeholder2">Consignee Name</label>
        </div>
        <div class="outer02">
            <div class="trial1">
                <select id="states" name="consignee_state" class="input02">
                    <option value="" disabled selected>Consignee State</option>
                    <?php
                    foreach ($states as $state) {
                        $selected = ($row['consignee_state'] === $state) ? 'selected' : '';
                        echo "<option value=\"$state\" $selected>$state</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" name="consignee_booking_station" class="input02" value="<?php echo htmlspecialchars($row['consignee_booking_station']); ?>">
                <label for="" class="placeholder2">Destination Station Name</label>
            </div>
        </div>
        <div class="trial1">
            <textarea type="text" placeholder="" name="consignee_address" class="input02"><?php echo htmlspecialchars($row['consignee_address']); ?></textarea>
            <label for="" class="placeholder2">Consignee Address</label>
        </div>
        <div class="outer02">
            <div class="trial1">
                <input type="text" placeholder="" name="consignee_contactperson" class="input02" value="<?php echo htmlspecialchars($row['consignee_contactperson']); ?>">
                <label for="" class="placeholder2">Contact Person</label>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" name="consignee_email" class="input02" value="<?php echo htmlspecialchars($row['consignee_email']); ?>">
                <label for="" class="placeholder2">Contact Email</label>
            </div>
        </div>
        <button type="button" class="epc-button" onclick="goodsinfo()">Next</button>
            <div class="cnbackcontainer">

            <a onclick="bringconsignorback()" class="backbuttonclick"><i class="fas fa-arrow-left"></i> </a></div>


    </div>
    <div class="goodsinfo" id="goodsinfo1">
        <div class="goodsinformation">
            <p class="headingpara">Goods & Billing Information</p>
            <div class="outer02">
                <div class="trial1">
                    <input type="number" placeholder="" name="no_of_package" class="input02" value="<?php echo htmlspecialchars($row['no_of_package']); ?>">
                    <label for="" class="placeholder2 smalllabel">No Of Package</label>
                </div>
                <div class="trial1">
                    <input type="text" placeholder="" name="actual_weight" class="input02" value="<?php echo htmlspecialchars($row['actual_weight']); ?>">
                    <label for="" class="placeholder2 smalllabel">Actual Weight</label>
                </div>
                <div class="trial1">
                    <input type="text" placeholder="" name="charge_weight" class="input02" value="<?php echo htmlspecialchars($row['charge_weight']); ?>">
                    <label for="" class="placeholder2 smalllabel">Charge Weight</label>
                </div>
            </div>
            <div class="outer02">
                <div class="trial1">
                    <select type="text" placeholder="" name="load_type" class="input02">
                        <option value="" disabled selected>Load Type</option>
                        <option value="Small" <?php echo ($row['load_type'] === 'Small') ? 'selected' : ''; ?>>Small</option>
                        <option value="Part" <?php echo ($row['load_type'] === 'Part') ? 'selected' : ''; ?>>Part</option>
                        <option value="LCV" <?php echo ($row['load_type'] === 'LCV') ? 'selected' : ''; ?>>LCV</option>
                        <option value="MCV" <?php echo ($row['load_type'] === 'MCV') ? 'selected' : ''; ?>>MCV</option>
                        <option value="FTL" <?php echo ($row['load_type'] === 'FTL') ? 'selected' : ''; ?>>FTL</option>
                        <option value="TLR" <?php echo ($row['load_type'] === 'TLR') ? 'selected' : ''; ?>>TLR</option>
                        <option value="HCV" <?php echo ($row['load_type'] === 'HCV') ? 'selected' : ''; ?>>HCV</option>
                    </select>
                </div>
                <div class="trial1">
                    <input type="text" placeholder="" name="load_desc" class="input02" value="<?php echo htmlspecialchars($row['load_desc']); ?>">
                    <label for="" class="placeholder2 smalllabel">Load Description</label>
                </div>
            </div>
            <div class="outer02">
                <div class="trial1">
                    <select name="delivery_basis" id="" class="input02">
                        <option value="" disabled selected>Delivery Basis</option>
                        <option value="Godown Delivery Without CC" <?php echo ($row['delivery_basis'] === 'Godown Delivery Without CC') ? 'selected' : ''; ?>>Godown Delivery Without CC</option>
                        <option value="Door Delivery With CC" <?php echo ($row['delivery_basis'] === 'Door Delivery With CC') ? 'selected' : ''; ?>>Door Delivery With CC</option>
                        <option value="Godown Delivery With CC" <?php echo ($row['delivery_basis'] === 'Godown Delivery With CC') ? 'selected' : ''; ?>>Godown Delivery With CC</option>
                        <option value="Door Delivery Without CC" <?php echo ($row['delivery_basis'] === 'Door Delivery Without CC') ? 'selected' : ''; ?>>Door Delivery Without CC</option>
                    </select>
                </div>
                <div class="trial1">
                    <select name="billing_basis" id="" class="input02">
                        <option value="" disabled selected>Billing Basis</option>
                        <option value="To Pay" <?php echo ($row['billing_basis'] === 'To Pay') ? 'selected' : ''; ?>>To Pay</option>
                        <option value="TBB" <?php echo ($row['billing_basis'] === 'TBB') ? 'selected' : ''; ?>>TBB</option>
                        <option value="Paid" <?php echo ($row['billing_basis'] === 'Paid') ? 'selected' : ''; ?>>Paid</option>
                        <option value="FOC" <?php echo ($row['billing_basis'] === 'FOC') ? 'selected' : ''; ?>>FOC</option>
                        <option value="Rebooked" <?php echo ($row['billing_basis'] === 'Rebooked') ? 'selected' : ''; ?>>Rebooked</option>
                        <option value="Included" <?php echo ($row['billing_basis'] === 'Included') ? 'selected' : ''; ?>>Included</option>
                        <option value="Cancelled" <?php echo ($row['billing_basis'] === 'Cancelled') ? 'selected' : ''; ?>>Cancelled</option>
                        <option value="NR" <?php echo ($row['billing_basis'] === 'NR') ? 'selected' : ''; ?>>NR</option>
                    </select>
                </div>
            </div>
            <div class="trial1">
                <select type="text" name="gst" placeholder="" class="input02">
                    <option value="" disabled selected>GST Paid By</option>
                    <option value="Consignee" <?php echo ($row['gst'] === 'Consignee') ? 'selected' : ''; ?>>Consignee</option>
                    <option value="Consignor" <?php echo ($row['gst'] === 'Consignor') ? 'selected' : ''; ?>>Consignor</option>
                    <option value="Carrier" <?php echo ($row['gst'] === 'Carrier') ? 'selected' : ''; ?>>Carrier</option>
                </select>
            </div>
            <div class="outer02">
                <div class="trial1">
                    <input type="text" name="freight" value="<?php echo htmlspecialchars($row['freight']); ?>" placeholder="" class="input02">
                    <label for="" class="placeholder2">Freight Amount </label>
                </div>
                <div class="trial1">
                    <input type="number" name="taxes" value="<?php echo htmlspecialchars($row['taxes']); ?>" placeholder="" class="input02">
                    <label for="" class="placeholder2">Taxes </label>
                </div>

                </div>
            <div class="outer02">
                <div class="trial1">
                    <input type="text" name="invoice_number" placeholder="" class="input02" value="<?php echo htmlspecialchars($row['invoice_number']); ?>">
                    <label for="" class="placeholder2">Invoice Number</label>
                </div>
                <div class="trial1">
                    <input type="date" name="invoice_date" placeholder="" class="input02" value="<?php echo htmlspecialchars($row['invoice_date']); ?>">
                    <label for="" class="placeholder2">Invoice Date</label>
                </div>
                <div class="trial1">
                    <input type="text" name="goods_value" placeholder="" class="input02" value="<?php echo htmlspecialchars($row['goods_value']); ?>">
                    <label for="" class="placeholder2">Goods Value</label>
                </div>
            </div>
            <div class="outer02">
                <div class="trial1">
                    <input type="text" name="waybill" placeholder="" class="input02" value="<?php echo htmlspecialchars($row['waybill']); ?>">
                    <label for="" class="placeholder2">Waybill Number</label>
                </div>
                <div class="trial1">
                    <input type="date" name="waybill_validity" placeholder="" class="input02" value="<?php echo htmlspecialchars($row['waybill_validity']); ?>">
                    <label for="" class="placeholder2">Waybill Validity</label>
                </div>
            </div>
            <div class="trial1">
                <input type="text" name="billing_party" placeholder="" class="input02" value="<?php echo htmlspecialchars($row['billing_party']); ?>">
                <label for="" class="placeholder2">Billing Party Name</label>
            </div>
            <div class="trial1">
                <textarea type="text" name="billingparty_address" placeholder="" class="input02"><?php echo htmlspecialchars($row['billingparty_address']); ?></textarea>
                <label for="" class="placeholder2">Address</label>
            </div>
            <div class="outer02">
                <div class="trial1">
                    <input type="text" placeholder="" name="billingparty_contactperson" class="input02" value="<?php echo htmlspecialchars($row['billingparty_contactperson']); ?>">
                    <label for="" class="placeholder2">Contact Person</label>
                </div>
                <div class="trial1">
                    <input type="text" placeholder="" name="billingparty_contactnumber" class="input02" value="<?php echo htmlspecialchars($row['billingparty_contactnumber']); ?>">
                    <label for="" class="placeholder2">Number</label>
                </div>
                <div class="trial1">
                    <input type="text" placeholder="" name="billingparty_contactemail" class="input02" value="<?php echo htmlspecialchars($row['billingparty_contactemail']); ?>">
                    <label for="" class="placeholder2">Email</label>
                </div>
            </div>
            <button class="epc-button" type="button" onclick="challanform()">Next</button>
                <div class="cnbackcontainer">

                <a onclick="bringconsigneeback()" class="backbuttonclick"><i class="fas fa-arrow-left"></i> </a></div>

                </div>
                </div>

                <div class="challandetails" id="challanformcontainer">
            <div class="challandetail_container">
            <p class="headingpara">Challan Details</p>
            <div class="trial1">
                <input type="text" value="<?php echo $row['Challannumber'] ?>" name="challan_num" class="input02" >
                <label for="" class="placeholder2">Challan Number</label>
            </div>
            <div class="outer02">
            <div class="trial1">
                <select name="vehicle_type" id="vehicle_type" class="input02">
                    <option  value="" disabled selected>Vehicle Type</option>
                    <option <?php if($row['vehicle_type']==='Trailor'){echo 'selected';} ?> value="Trailor">Trailor</option>
                    <option <?php if($row['vehicle_type']==='Truck'){echo 'selected';} ?> value="Truck">Truck</option>
                    <option <?php if($row['vehicle_type']==='Container'){echo 'selected';} ?> value="Container">Container</option>
                    <option <?php if($row['vehicle_type']==='Tempo'){echo 'selected';} ?> value="Tempo">Tempo</option>
                </select>
            </div>
            <div class="trial1">
                <input type="number" value="<?php echo $row['capacity'] ?>" name="capacity" id="capacity" placeholder="" class="input02">
                <label for="capacity" class="placeholder2">Capacity In Ton</label>
            </div>
            <div class="trial1">
                <select name="vehicle_ownership" id="vehicle_ownership" class="input02" onchange="markethired()">
                    <option value="" disabled selected>Vehicle Ownership</option>
                    <option <?php if($row['vehicle_ownership']==='Market Hired'){echo 'selected';} ?> value="Market Hired">Market Hired</option>
                    <option <?php if($row['vehicle_ownership']==='Company Owned'){echo 'selected';} ?> value="Company Owned">Company Owned</option>
                </select>
            </div>
        </div>
        <div class="outer02">
            <div class="trial1">
                <input type="text" name="driver_name" value="<?php echo $row['driver_name'] ?>" id="driver_name" placeholder="" class="input02">
                <label for="driver_name" class="placeholder2">Driver Name</label>
            </div>
            
            <div class="trial1">
                <input type="text" name="dl" value="<?php echo $row['dl'] ?>" id="" placeholder="" class="input02">
                <label for="driver_name" class="placeholder2">Driver License</label>
            </div>

            <div class="trial1">
                <input type="text" name="driver_mobile" value="<?php echo $row['driver_mobile'] ?>" id="driver_mobile" placeholder="" class="input02">
                <label for="driver_mobile" class="placeholder2">Mobile Number</label>
            </div>
        </div>
        <div class="outer02" id="marketvehicleoptions">
            <div class="trial1">
                <input type="text" name="broker_name" value="<?php echo $row['broker_name'] ?>" id="broker_name" placeholder="" class="input02">
                <label for="broker_name" class="placeholder2">Broker Company</label>
            </div>
            <div class="trial1">
                <input type="text" name="brokercontactperson" value="<?php echo $row['brokercontactperson'] ?>" id="" placeholder="" class="input02">
                <label for="broker_mobile" class="placeholder2">Contact Person</label>
            </div>

            <div class="trial1">
                <input type="text" name="broker_mobile" id="broker_mobile" value="<?php echo $row['broker_mobile'] ?>" placeholder="" class="input02">
                <label for="broker_mobile" class="placeholder2">Mobile Number</label>
            </div>
            <div class="trial1">
                <input type="text" name="owner_name" id="" placeholder="" value="<?php echo $row['owner_name'] ?>" class="input02">
                <label for="broker_mobile" class="placeholder2">Owner Name</label>
            </div>

        </div>
        <div class="outer02">
        <div class="trial1">
            <input type="text" name="lorryhire" id="lorryhire" value="<?php echo $row['lorryhire'] ?>" placeholder="" oninput="calculateTotal()" class="input02">
            <label for="lorryhire" class="placeholder2">Lorry Hire</label>
        </div>

            <div class="trial1">
                <input type="text" name="loading_charge" id="loading_charge" value="<?php echo $row['loading_charge'] ?>" oninput="calculateTotal()" placeholder="" class="input02">
                <label for="loading_charge" class="placeholder2">Loading Charge</label>
            </div>
            <div class="trial1">
                <input type="text" name="height_charge" id="height_charge" oninput="calculateTotal()" value="<?php echo $row['height_charge'] ?>" placeholder="" class="input02">
                <label for="height_charge" class="placeholder2">Height Charge</label>
            </div>
            <div class="trial1">
                <input type="text" name="length_charge" id="length_charge" oninput="calculateTotal()" value="<?php echo $row['length_charge'] ?>" placeholder="" class="input02">
                <label for="length_charge" class="placeholder2">Length Charge</label>
            </div>
        </div>
        <div class="outer02">
            <div class="trial1">
                <input type="text" name="detention_charge" id="detention_charge" value="<?php echo $row['detention_charge'] ?>" oninput="calculateTotal()" placeholder="" class="input02">
                <label for="detention_charge" class="placeholder2">Detention Charge</label>
            </div>
            <div class="trial1">
                <input type="text" name="misc_expense" id="misc_expense" value="<?php echo $row['misc_expense'] ?>" oninput="calculateTotal()" placeholder="" class="input02">
                <label for="misc_expense" class="placeholder2">Miscellaneous Charge</label>
            </div>
        </div>
        <div class="outer02">
            <div class="trial1">
                <input type="text" name="total_hire" id="total_hire" value="<?php echo $row['total_hire'] ?>" placeholder="" class="input02" readonly>
                <label for="total_hire" class="placeholder2">Total Hire</label>
            </div>
            <div class="trial1">
                <input type="text" name="advance" id="advance" placeholder="" value="<?php echo $row['advance'] ?>" oninput="calculateTotal()" class="input02">
                <label for="advance" class="placeholder2">Advance</label>
            </div>
            <div class="trial1">
                <input type="text" name="balance" id="balance" placeholder="" value="<?php echo $row['balance'] ?>" class="input02" readonly>
                <label for="balance" class="placeholder2">Balance</label>
            </div>
        </div>
        <div class="trial1">
            <input type="text" placeholder="" value="<?php echo $row['tripid'] ?>" name="tripid"  class="input02">
            <label for="" class="placeholder2">Associated Trip ID If Any</label>
        </div>
        <div class="trial1">
            <textarea name="remark" id="remark"  class="input02" placeholder=""><?php echo $row['remark'] ?></textarea>
            <label for="remark" class="placeholder2">Remark If Any</label>
        </div>
        <button class="epc-button" type="submit" name="generatecnsubmit">Submit</button>
           <div class="cnbackcontainer">
           <a onclick="bringbillingback()" class="backbuttonclick"><i class="fas fa-arrow-left"></i></a>
           </div>


        </div>
    </div>
</form>
</body>
<script>

function calculateTotal() {
        // Get the values of the input fields
        let lorryhire = parseFloat(document.getElementById('lorryhire').value) || 0;
        let loadingCharge = parseFloat(document.getElementById('loading_charge').value) || 0;
        let heightCharge = parseFloat(document.getElementById('height_charge').value) || 0;
        let lengthCharge = parseFloat(document.getElementById('length_charge').value) || 0;
        let detentionCharge = parseFloat(document.getElementById('detention_charge').value) || 0;
        let miscExpense = parseFloat(document.getElementById('misc_expense').value) || 0;
        let advance = parseFloat(document.getElementById('advance').value) || 0;

        // Calculate the total
        let totalHire = lorryhire + loadingCharge + heightCharge + lengthCharge + detentionCharge + miscExpense;

        // Calculate the balance
        let balance = totalHire - advance;

        // Set the total in the total_hire input field
        document.getElementById('total_hire').value = totalHire.toFixed(2);

        // Set the balance in the balance input field
        document.getElementById('balance').value = balance.toFixed(2);
    }


        function bringbillingback(){
        const challanformcontainer=document.getElementById("challanformcontainer").style.display="none";
        const goodsinfo1=document.getElementById("goodsinfo1").style.display="flex";


    }

    function bringconsigneeback(){
        const consignorform=document.getElementById("consignorform");
        const consigneeform=document.getElementById("consigneeform");
        const goodsinfo=document.getElementById("goodsinfo1");
        const challanformcontainer=document.getElementById("challanformcontainer");


        consignorform.style.display="none";
        consigneeform.style.display="flex";
        goodsinfo.style.display="none";
        challanformcontainer.style.display="none";


    }


    function challanform(){
        const consignorform=document.getElementById("consignorform").style.display="none";
        const consigneeform=document.getElementById("consigneeform").style.display="none";
        const goodsinfo1=document.getElementById("goodsinfo1").style.display="none";
        const challanformcontainer=document.getElementById("challanformcontainer").style.display="block";


    }


    function showconsigneeinfo(){
        const consignorform=document.getElementById("consignorform");
        const consigneeform=document.getElementById("consigneeform");
        consignorform.style.display="none";
        consigneeform.style.display="flex";
        


    }
    function goodsinfo(){
        const consignorform=document.getElementById("consignorform");
        const consigneeform=document.getElementById("consigneeform");
        const goodsinfo=document.getElementById("goodsinfo1");
        consignorform.style.display="none";
        consigneeform.style.display="none";
        goodsinfo.style.display="flex";
        


    }
    function bringconsignorback(){
        const consignorform=document.getElementById("consignorform");
        const consigneeform=document.getElementById("consigneeform");

        consignorform.style.display="flex";
        consigneeform.style.display="none";

    }

    function bringconsigneeback(){
        const consignorform=document.getElementById("consignorform");
        const consigneeform=document.getElementById("consigneeform");
        const goodsinfo=document.getElementById("goodsinfo1");

        consignorform.style.display="none";
        consigneeform.style.display="flex";
        goodsinfo.style.display="none";


    }

</script>

</html>