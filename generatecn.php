<?php
session_start();
$showAlert=false;
$showError=false;

$sourcestation="";
$destinationstation="";
$freight_price="";
$consignorpartyname="";
$tripidinfo="";

if(isset($_GET['from'])){
    $sourcestation=$_GET['from'];
}
if (isset($_GET['to']) && !empty($_GET['to'])) {
    $destinationstation = $_GET['to'];
}
if (isset($_GET['freight']) && !empty($_GET['freight'])) {
    $freight_price = $_GET['freight'];
}
if (isset($_GET['consignor']) && !empty($_GET['consignor'])) {
    $consignorpartyname = $_GET['consignor'];
}
if (isset($_GET['tripid']) && !empty($_GET['tripid'])) {
    $tripidinfo = $_GET['tripid'];
}
include "partials/_dbconnect.php";
$companyname001 = $_SESSION['companyname'];
$email=$_SESSION['email'];
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

$sql_max_ref_no = "SELECT MAX(cnnumber) AS max_ref_no FROM `cn` WHERE companyname = '$companyname001'";
$result_max_ref_no = mysqli_query($conn, $sql_max_ref_no);
$row_max_ref_no = mysqli_fetch_assoc($result_max_ref_no);
$next_ref_no = ($row_max_ref_no['max_ref_no'] === null) ? 1 : $row_max_ref_no['max_ref_no'] + 1;



$sqlMaxChallanNumber = "SELECT MAX(challannumber) AS max_challan_number FROM `challans` WHERE companyname = '$companyname001'";
$resultMaxChallanNumber = mysqli_query($conn, $sqlMaxChallanNumber);
$rowMaxChallanNumber = mysqli_fetch_assoc($resultMaxChallanNumber);
$nextChallanNumber = ($rowMaxChallanNumber['max_challan_number'] === null) ? 1 : $rowMaxChallanNumber['max_challan_number'] + 1;



$sql="SELECT * FROM `clients_logi` where companyname='$companyname001'";
$result=mysqli_query($conn,$sql);
$result1=mysqli_query($conn,$sql);
$result2=mysqli_query($conn,$sql);
?>
<?php
$party_name = '';
$consignee_party_name = '';
$billing_party_name = '';
include "partials/_dbconnect.php";
if (($_SERVER['REQUEST_METHOD']==='POST') && isset($_POST['generatecnsubmit'])) {
    // Retrieve form input values
    $branch = $_POST['branch'] ?? '';
    $cnnumber = $_POST['cnnumber'] ?? '';
    $cndate = $_POST['cndate'] ?? '';
    // $consignor = $_POST['consignor'] ?? '';
    $consignor_old = isset($_POST['consignor_old']) ? $_POST['consignor_old'] : '';
    $consignor = isset($_POST['consignor']) ? $_POST['consignor'] : '';

    if (isset($consignor_old) && $consignor_old !== 'New Client') {
        $party_name = $consignor_old;
    } else {
        $party_name = $consignor;
    }

    $consignor_state = $_POST['consignor_state'] ?? '';
    $booking_station = $_POST['booking_station'] ?? '';
    $consignor_address = $_POST['consignor_address'] ?? '';
    $consignor_contactperson = $_POST['consignor_contactperson'] ?? '';
    $consignor_email = $_POST['consignor_email'] ?? '';

    // Consignee Information
    $consignee_old=$_POST['consignee_old'] ?? '';
    $consignee_name = $_POST['consignee_name'] ?? '';
    $consignee_state = $_POST['consignee_state'] ?? '';
    $consignee_booking_station = $_POST['consignee_booking_station'] ?? '';
    $consignee_address = $_POST['consignee_address'] ?? '';
    $consignee_contactperson = $_POST['consignee_contactperson'] ?? '';
    $consignee_email = $_POST['consignee_email'] ?? '';

    if (isset($consignee_old) && $consignee_old !== 'New Client') {
        $consignee_party_name = $consignee_old;
    } else {
        $consignee_party_name = $consignee_name;
    }


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
    $billing_party_old=$_POST['billing_party_old'] ?? '';
    $billing_party = $_POST['billing_party'] ?? '';

    if (isset($billing_party_old) && $billing_party_old !== 'New Client') {
        $billing_party_name = $billing_party_old;
    } else {
        $billing_party_name = $billing_party;
    }




    $billingparty_address = $_POST['billingparty_address'] ?? '';
    $billingparty_contactperson = $_POST['billingparty_contactperson'] ?? '';
    $billingparty_contactnumber = $_POST['billingparty_contactnumber'] ?? '';
    $billingparty_contactemail = $_POST['billingparty_contactemail'] ?? '';
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
    





    
    
    $sqlinsert = "INSERT INTO `cn` (
        `branch`, `companyname`, `cnnumber`, `cndate`, `consignor`, `consignor_state`,
        `booking_station`, `consignor_address`, `consignor_contactperson`, `consignor_email`,
        `consignee_name`, `consignee_state`, `consignee_booking_station`, `consignee_address`,
        `consignee_contactperson`, `consignee_email`, `no_of_package`, `actual_weight`,
        `charge_weight`, `load_type`, `load_desc`, `delivery_basis`, `billing_basis`, `gst`,
        `freight`, `invoice_number`, `invoice_date`, `goods_value`, `waybill`, `waybill_validity`,
        `billing_party`, `billingparty_address`, `billingparty_contactperson`, `billingparty_contactnumber`,
        `billingparty_contactemail`,`taxes`,`consignor_gst`,`consignee_gst`,`consignor_contactnumber`,`consignee_contactnumber`,`billingparty_state`,`billingparty_gst`,`vehicle_reg`,Challannumber, capacity, vehicle_ownership, driver_name, driver_mobile, broker_name, broker_mobile, 
    lorryhire, loading_charge, height_charge, length_charge, detention_charge, misc_expense, total_hire, 
    advance, balance, remark, brokercontactperson, owner_name, dl, tripid, vehicle_type
    ) VALUES (
        '$branch', '$companyname001', '$cnnumber', '$cndate', '$party_name', '$consignor_state',
        '$booking_station', '$consignor_address', '$consignor_contactperson', '$consignor_email',
        '$consignee_party_name', '$consignee_state', '$consignee_booking_station', '$consignee_address',
        '$consignee_contactperson', '$consignee_email', $no_of_package, $actual_weight, $charge_weight,
        '$load_type', '$load_desc', '$delivery_basis', '$billing_basis', '$gst', $freight,
        '$invoice_number', '$invoice_date', $goods_value, $waybill, '$waybill_validity',
        '$billing_party_name', '$billingparty_address', '$billingparty_contactperson',
        '$billingparty_contactnumber', '$billingparty_contactemail' , '$taxes' , '$consignor_gst' , '$consignee_gst' , '$consignor_contactnumber' , '$consignee_contactperson_number', '$billingparty_state','$billingparty_gst','$vehicle_reg','$challan_num', '$capacity', '$vehicle_ownership', '$driver_name', '$driver_mobile', '$broker_name', 
    '$broker_mobile', '$lorryhire', '$loading_charge', '$height_charge', '$length_charge', '$detention_charge', 
    '$misc_expense', '$total_hire', '$advance', '$balance', '$remark', '$brokercontactperson', '$owner_name', 
    '$dl', '$tripid', '$vehicle_type'
    )";

    if(isset($_POST['consignor']) && !empty($_POST['consignor'])){
        $sqlnew="INSERT INTO `clients_logi`(`client_name`, `address`, 
        `contact_person1`, `companyname`, `contact_email1`,
         `clientstate`,`gst`,`contact_number1`)
          VALUES ('$consignor','$consignor_address','$consignee_contactperson',
          '$companyname001','$consignor_email','$consignor_state','$consignor_gst','$consignor_contactnumber')";
          $result1=mysqli_query($conn,$sqlnew);
    }

    if(isset($_POST['consignee_name']) && !empty($_POST['consignee_name'])){
        $sqlnew2="INSERT INTO `clients_logi`(`client_name`, `address`, 
        `contact_person1`, `companyname`, `contact_email1`,
         `clientstate`,`gst`,`contact_number1`)
          VALUES ('$consignee_name','$consignee_address','$consignee_contactperson',
          '$companyname001','$consignee_email','$consignee_state','$consignee_gst','$consignee_contactperson_number')";
          $result3=mysqli_query($conn,$sqlnew2);


    }
    if(isset($_POST['billing_party']) && !empty($_POST['billing_party'])){
        $sqlnew3="INSERT INTO `clients_logi`(`client_name`, `address`, 
        `contact_person1`, `companyname`, `contact_email1`,
         `clientstate`,`gst`,`contact_number1`)
          VALUES ('$billing_party','$billingparty_address','$billingparty_contactperson',
          '$companyname001','$billingparty_contactemail','$billingparty_state','$billingparty_gst','$billingparty_contactnumber')";
          $result3=mysqli_query($conn,$sqlnew3);


    }

    $result=mysqli_query($conn,$sqlinsert);
    if ($result) {
    session_start();
        $_SESSION['success']='success';
        header("Location:viewcn.php");
}
    else{
        $_SESSION['error']='success';
        header("Location:viewcn.php");
    }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="favicon.jpg" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="tiles.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js"></script>

    <script src="logiclient.js"defer></script>
    <title>Generate CN</title>
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

    <div class="add_fleet_btn_new" id="logiquotation">
<button class="generate-btn"> 
    <article class="article-wrapper" onclick="window.location.href='viewcn.php'" id="viewcnbutton"> 
  <div class="rounded-lg container-projectss ">
    </div>
    <div class="project-info">
      <div class="flex-pr">
        <div class="project-title text-nowrap">View Generated CN</div>
          <div class="project-hover">
            <svg style="color: black;" xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" color="black" stroke-linejoin="round" stroke-linecap="round" viewBox="0 0 24 24" stroke-width="2" fill="none" stroke="currentColor"><line y2="12" x2="19" y1="12" x1="5"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
            </div>
          </div>
          <div class="types">
        </div>
    </div>
</article>
    </button>


    <!-- <button class="generate-btn"> 
    <article class="article-wrapper" onclick="window.location.href='generatechallan.php'" id="viewcnbutton"> 
  <div class="rounded-lg container-projectss ">
    </div>
    <div class="project-info">
      <div class="flex-pr">
        <div class="project-title text-nowrap">Generated Challan</div>
          <div class="project-hover">
            <svg style="color: black;" xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" color="black" stroke-linejoin="round" stroke-linecap="round" viewBox="0 0 24 24" stroke-width="2" fill="none" stroke="currentColor"><line y2="12" x2="19" y1="12" x1="5"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
            </div>
          </div>
          <div class="types">
        </div>
    </div>
</article>
    </button>
 -->

</div>

    <form class="generatecnform" method="POST" action="generatecn.php" autocomplete="off">
        <div class="consigerinfo" id="consignorform">
            <p>Consignor Information</p>
            <div class="outer02">
            <div class="trial1">
                <input type="text" placeholder="" name="branch" class="input02">
                <label for="" class="placeholder2">Branch Name</label>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" value="<?php echo $next_ref_no ?>" name="cnnumber" class="input02">
                <label for="" class="placeholder2">CN number</label>
            </div>
            <div class="trial1">
                <input type="date" placeholder="" value="<?php echo date('Y-m-d'); ?>" name="cndate" class="input02">
                <label for="" class="placeholder2">CN Date</label>
            </div>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" value="<?php if(isset($sourcestation) && !empty($sourcestation)){ echo $sourcestation;} ?>" name="booking_station" class="input02">
                <label for="" class="placeholder2">Source Station Name</label>
            </div>

            <div class="outer02">
            <div class="trial1" id="select_client" >
                <select name="consignor_old" id="consignor" class="input02" onchange="newconsignorclient()">
                    <option value=""disabled selected>Select Client</option>
                    <option value="New Client">Add New Client</option>
                    <?php
                    // if(mysqli_num_rows($result)>0){
                        while($row=mysqli_fetch_assoc($result)){ ?>
                    <option <?php if($consignorpartyname===$row['client_name']){ echo 'selected';} ?> value="<?php echo $row['client_name'] ?>"><?php echo $row['client_name'] ?></option>

                    <?php    }
                    // }
                    ?>
                </select>


            </div>

            <div class="trial1" id="newconsignor">
            <input type="text" placeholder=""  name="consignor"  class="input02">
            <label for="" class="placeholder2">Consignor Name</label>
            </div>

            <div class="trial1">
                <input type="text" placeholder=""  name="consignor_state" id="consignorstate" class="input02">
                <label for="" class="placeholder2">Consignor State</label>
            </div>

            </div>
            <div class="trial1">
                <input type="text" placeholder="" name="consignor_gst"  id="consignor_gst" class="input02">
                <label for="" class="placeholder2">Consignor GST</label>
            </div>
            <div class="trial1">
                <textarea type="text" placeholder="" id="address" name="consignor_address" class="input02"></textarea>
                <label for="" class="placeholder2">Consignor Address</label>
            </div>
            <div class="outer02">
            <div class="trial1">
                <input type="text" placeholder="" id="contactperson_consignor" name="consignor_contactperson" class="input02">
                <label for="" class="placeholder2">Contact Person</label>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" id="consignor_contactperson_number" name="consignor_contactnumber" class="input02">
                <label for="" class="placeholder2">Cell No</label>
            </div>

            <div class="trial1">
                <input type="text" placeholder="" id="contactemail_consignor" name="consignor_email" class="input02">
                <label for="" class="placeholder2">Contact Email</label>
            </div>

            </div>
            <button type="button" class="epc-button" onclick="showconsigneeinfo()">Next</button>


        </div>
        <div class="consigneeinfo" id="consigneeform">
            <p>Consignee Information</p>
            <input type="text" value="<?php echo $companyname001 ?>" id="logicompanyname" hidden>
            <div class="trial1">

            <input type="text" placeholder="" value="<?php echo htmlspecialchars($destinationstation); ?>" name="consignee_booking_station" class="input02">
                <label for="" class="placeholder2">Destination </label>
            </div>

            <div class="outer02">
            <div class="trial1" id="consignee_client">
                <select name="consignee_old" id="consignee_name" class="input02" onchange="newconsigneeclient()">
                    <option value=""disabled selected>Select Client</option>
                    <option value="New Client">New Client</option>
                    <?php
                    if(mysqli_num_rows($result)>0){
                        while($row1=mysqli_fetch_assoc($result1)){ ?>
                    <option value="<?php echo $row1['client_name'] ?>"><?php echo $row1['client_name'] ?></option>

                    <?php    }
                    }
                    ?>

                </select>
            </div>
            <div class="trial1" id="newconsigneename">
                <input type="text" placeholder="" id="newconsigneenamelogi" name="consignee_name" class="input02">
                <label for="" class="placeholder2">Consignee Name</label>
                </div>


        <div class="trial1">
            <input type="text" name="consignee_state" placeholder="" id="consignee_state" class="input02">
            <label for="" class="placeholder2">Consignee State</label>
     </div>


            </div>
            <div class="trial1">
                <input type="text" placeholder="" name="consignee_gst"  id="consignee_gst" class="input02">
                <label for="" class="placeholder2">Consignee GST</label>
            </div>

            <div class="trial1">
                <textarea type="text" placeholder="" name="consignee_address" id="consignee_address" class="input02"></textarea>
                <label for="" class="placeholder2">Consignee Address</label>
            </div>
            <div class="outer02">
            <div class="trial1">
                <input type="text" placeholder="" name="consignee_contactperson" id="consignee_contactperson" class="input02">
                <label for="" class="placeholder2">Contact Person</label>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" id="consignee_contactperson_number" name="consignee_contactperson_number" class="input02">
                <label for="" class="placeholder2">Cell No</label>
            </div>

            <div class="trial1">
                <input type="text" placeholder="" name="consignee_email" id="consignee_email" class="input02">
                <label for="" class="placeholder2">Contact Email</label>
            </div>

            </div>
            <button type="button" class="epc-button" onclick="goodsinfo()">Next</button>
            <div class="cnbackcontainer">

            <a onclick="bringconsignorback()" class="backbuttonclick"><i class="fas fa-arrow-left"></i> </a></div>


        </div>
        <div class="goodsinfo" id="goodsinfo1" >
            <div class="goodsinformation">
                <p class="headingpara">Goods & Billing Information</p>
                <div class="trial1">
                    <input type="text" name="vehicle_reg" placeholder="" class="input02">
                    <label for="" class="placeholder2">Vehicle Reg-No</label>
                </div>
                <div class="outer02">
                <div class="trial1">
                    <input type="number" placeholder="" name="no_of_package" class="input02">
                    <label  for="" class="placeholder2 smalllabel">No Of Package</label>
                </div>
                <div class="trial1">
                    <input type="text" placeholder="" name="actual_weight" class="input02">
                    <label for="" class="placeholder2 smalllabel">Actual Weight</label>
                </div>
                <div class="trial1">
                    <input type="text" placeholder="" name="charge_weight" class="input02">
                    <label for="" class="placeholder2 smalllabel">Charge Weight</label>
                </div>
                </div>
                <div class="outer02">
                <div class="trial1">
                    <select type="text" placeholder="" name="load_type" class="input02">
                        <option value=""disabled selected>Load Type</option>
                        <option value="Small">Small</option>
                        <option value="Part">Part</option>
                        <option value="LCV">LCV</option>
                        <option value="MCV">MCV</option>
                        <option value="FTL">FTL</option>
                        <option value="TLR">TLR</option>
                        <option value="HCV">HCV</option>
                    </select>
                </div>
                <div class="trial1">
                    <input type="text" placeholder="" name="load_desc" class="input02">
                    <label for="" class="placeholder2 smalllabel">Load Description</label>
                </div>
                </div>
                <div class="outer02">
                    <div class="trial1">
                    <select name="delivery_basis" id="" class="input02">
                        <option value=""disabled selected>Delivery Basis</option>
                        <option value="Godown Delivery Without CC">Godown Delivery Without CC</option>
                        <option value="Door Delivery With CC">Door Delivery With CC</option>
                        <option value="Godown Delivery With CC">Godown Delivery With CC</option>
                        <option value="Door Delivery Without CC">Door Delivery Without CC</option>
                    </select>
                    </div>
                    <div class="trial1">
                        <select name="billing_basis" id="" class="input02">
                            <option value=""disabled selected>Billing Basis</option>
                            <option value="To Pay">To Pay</option>
                            <option value="TBB">TBB</option>
                            <option value="Paid">Paid</option>
                            <option value="FOC">FOC</option>
                            <option value="Rebooked">Rebooked</option>
                            <option value="Included">Included</option>
                            <option value="Cancelled">Cancelled</option>
                            <option value="NR">NR</option>
                        </select>
                    </div>
                </div>
                <div class="trial1">
                        <select type="text" name="gst" placeholder="" class="input02">
                            <option value=""disabled selected>GST Paid By</option>
                            <option value="Consignee">Consignee</option>
                            <option value="Consignor">Consignor</option>
                            <option value="Carrier">Carrier</option>
                        </select>
                    </div>
                    <div class="outer02">
                <div class="trial1">
                    <input type="text" name="freight" value="<?php echo htmlspecialchars($freight_price); ?>" placeholder="" class="input02">
                    <label for="" class="placeholder2">Freight Amount </label>
                </div>
                <div class="trial1">
                    <input type="number" name="taxes" placeholder="" class="input02">
                    <label for="" class="placeholder2">Taxes </label>
                </div>

                </div>
                <div class="outer02">
                    <div class="trial1">
                        <input type="text" name="invoice_number" placeholder="" class="input02">
                        <label for="" class="placeholder2">Invoice Number</label>
                    </div>
                    <div class="trial1">
                        <input type="date" name="invoice_date" placeholder="" class="input02">
                        <label for="" class="placeholder2">Invoice Date</label>
                    </div>
                    <div class="trial1">
                        <input type="text" name="goods_value" placeholder="" class="input02">
                        <label for="" class="placeholder2">Goods Value</label>
                    </div>
                </div>
                <div class="outer02">
                <div class="trial1">
                        <input type="text" name="waybill" placeholder="" class="input02">
                        <label for="" class="placeholder2">Waybill Number</label>
                    </div>
                    <div class="trial1">
                        <input type="date" name="waybill_validity" placeholder="" class="input02">
                        <label for="" class="placeholder2">Waybill Validity</label>
                    </div>


                </div>
                <div class="outer02">
                <div class="trial1" id="billingouter">
                    <select name="billing_party_old" id="billing_party" class="input02" onchange="newbillingclient()"> 
                    <option value=""disabled selected>Select Billing Client</option>
                    <option value="New Client">New Client</option>
                    <?php
                    if(mysqli_num_rows($result)>0){
                        while($row2=mysqli_fetch_assoc($result2)){ ?>
                    <option value="<?php echo $row2['client_name'] ?>"><?php echo $row2['client_name'] ?></option>

                    <?php    }
                    }
                    ?>

                </select>
                                  


                </div>
                <div class="trial1" id="billingclient_name">
                      <input type="text" name="billing_party" placeholder="" class="input02">
                    <label for="" class="placeholder2">Billing Client Name </label>
                </div>
                <div class="trial1">
                    <input type="text" placeholder="" name="billingparty_state" id="billingparty_state" class="input02">
                    <label for="" class="placeholder2">Billing Party State</label>
                </div>
                </div>
                <div class="trial1">
                    <textarea type="text" name="billingparty_address" id="billingparty_address" placeholder="" class="input02"></textarea>
                    <label for="" class="placeholder2">Address</label>
                </div>
                <div class="trial1">
                    <input type="text" placeholder="" name="billingparty_gst" id="billingparty_gst" class="input02">
                    <label for="" class="placeholder2">GST</label>
                </div>
                <div class="outer02">
                    <div class="trial1">
                        <input type="text" placeholder="" name="billingparty_contactperson" id="billingparty_contactperson" class="input02">
                        <label for="" class="placeholder2">Contact Person</label>
                    </div>
                    <div class="trial1">
                        <input type="text" placeholder="" name="billingparty_contactnumber" id="billingparty_contactnumber" class="input02">
                        <label for="" class="placeholder2">Number</label>
                    </div>
                    <div class="trial1">
                        <input type="text" placeholder="" name="billingparty_contactemail" id="billingparty_contactemail" class="input02">
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
                <input type="text" value="<?php echo $nextChallanNumber ?>" name="challan_num" class="input02" >
                <label for="" class="placeholder2">Challan Number</label>
            </div>
            <div class="outer02">
            <div class="trial1">
                <select name="vehicle_type" id="vehicle_type" class="input02">
                    <option value="" disabled selected>Vehicle Type</option>
                    <option value="Trailor">Trailor</option>
                    <option value="Truck">Truck</option>
                    <option value="Container">Container</option>
                    <option value="Tempo">Tempo</option>
                </select>
            </div>
            <div class="trial1">
                <input type="number" name="capacity" id="capacity" placeholder="" class="input02">
                <label for="capacity" class="placeholder2">Capacity In Ton</label>
            </div>
            <div class="trial1">
                <select name="vehicle_ownership" id="vehicle_ownership" class="input02" onchange="markethired()">
                    <option value="" disabled selected>Vehicle Ownership</option>
                    <option value="Market Hired">Market Hired</option>
                    <option value="Company Owned">Company Owned</option>
                </select>
            </div>
        </div>
        <div class="outer02">
            <div class="trial1">
                <input type="text" name="driver_name" id="driver_name" placeholder="" class="input02">
                <label for="driver_name" class="placeholder2">Driver Name</label>
            </div>
            
            <div class="trial1">
                <input type="text" name="dl" id="" placeholder="" class="input02">
                <label for="driver_name" class="placeholder2">Driver License</label>
            </div>

            <div class="trial1">
                <input type="text" name="driver_mobile" id="driver_mobile" placeholder="" class="input02">
                <label for="driver_mobile" class="placeholder2">Mobile Number</label>
            </div>
        </div>
        <div class="outer02" id="marketvehicleoptions">
            <div class="trial1">
                <input type="text" name="broker_name" id="broker_name" placeholder="" class="input02">
                <label for="broker_name" class="placeholder2">Broker Company</label>
            </div>
            <div class="trial1">
                <input type="text" name="brokercontactperson" id="" placeholder="" class="input02">
                <label for="broker_mobile" class="placeholder2">Contact Person</label>
            </div>

            <div class="trial1">
                <input type="text" name="broker_mobile" id="broker_mobile" placeholder="" class="input02">
                <label for="broker_mobile" class="placeholder2">Mobile Number</label>
            </div>
            <div class="trial1">
                <input type="text" name="owner_name" id="" placeholder="" class="input02">
                <label for="broker_mobile" class="placeholder2">Owner Name</label>
            </div>

        </div>
        <div class="outer02">
        <div class="trial1">
            <input type="text" name="lorryhire" id="lorryhire" placeholder="" oninput="calculateTotal()" class="input02">
            <label for="lorryhire" class="placeholder2">Lorry Hire</label>
        </div>

            <div class="trial1">
                <input type="text" name="loading_charge" id="loading_charge" oninput="calculateTotal()" placeholder="" class="input02">
                <label for="loading_charge" class="placeholder2">Loading Charge</label>
            </div>
            <div class="trial1">
                <input type="text" name="height_charge" id="height_charge" oninput="calculateTotal()" placeholder="" class="input02">
                <label for="height_charge" class="placeholder2">Height Charge</label>
            </div>
            <div class="trial1">
                <input type="text" name="length_charge" id="length_charge" oninput="calculateTotal()" placeholder="" class="input02">
                <label for="length_charge" class="placeholder2">Length Charge</label>
            </div>
        </div>
        <div class="outer02">
            <div class="trial1">
                <input type="text" name="detention_charge" id="detention_charge" oninput="calculateTotal()" placeholder="" class="input02">
                <label for="detention_charge" class="placeholder2">Detention Charge</label>
            </div>
            <div class="trial1">
                <input type="text" name="misc_expense" id="misc_expense" oninput="calculateTotal()" placeholder="" class="input02">
                <label for="misc_expense" class="placeholder2">Miscellaneous Charge</label>
            </div>
        </div>
        <div class="outer02">
            <div class="trial1">
                <input type="text" name="total_hire" id="total_hire" placeholder="" class="input02" readonly>
                <label for="total_hire" class="placeholder2">Total Hire</label>
            </div>
            <div class="trial1">
                <input type="text" name="advance" id="advance" placeholder="" oninput="calculateTotal()" class="input02">
                <label for="advance" class="placeholder2">Advance</label>
            </div>
            <div class="trial1">
                <input type="text" name="balance" id="balance" placeholder="" class="input02" readonly>
                <label for="balance" class="placeholder2">Balance</label>
            </div>
        </div>
        <div class="trial1">
            <input type="text" placeholder="" value="<?php echo $tripidinfo ?>" name="tripid"  class="input02">
            <label for="" class="placeholder2">Associated Trip ID If Any</label>
        </div>
        <div class="trial1">
            <textarea name="remark" id="remark" class="input02" placeholder=""></textarea>
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

    function bringbillingback(){
        const challanformcontainer=document.getElementById("challanformcontainer").style.display="none";
        const goodsinfo1=document.getElementById("goodsinfo1").style.display="flex";


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
    function newconsignorclient(){

        const consignor=document.getElementById("consignor");
        const select_client=document.getElementById("select_client");
        const newconsignor=document.getElementById("newconsignor");
        if(consignor.value==='New Client'){
            select_client.style.display='none';
            newconsignor.style.display='block';

        }
 
        
    }

    function newconsigneeclient(){
        const consignee_name=document.getElementById("consignee_name");
        const consignee_client=document.getElementById("consignee_client");
        const newconsigneename=document.getElementById("newconsigneename");

        if(consignee_name.value==='New Client'){
            consignee_client.style.display='none';
            newconsigneename.style.display='block';
        }


    }
    function newbillingclient(){
        const billingouter=document.getElementById("billingouter");
        const billing_party=document.getElementById("billing_party");
        const billingclient_name=document.getElementById("billingclient_name");

        if(billing_party.value==='New Client'){
            billingouter.style.display='none';
            billingclient_name.style.display='block';

        }
    }


    document.addEventListener('DOMContentLoaded', function() {
    // Check if oem_fleet_type7 is not empty and call seco_equip_2()
    var consignor = document.getElementById('consignor');
    if (consignor.value !== '') {
        populateConsignorFields();
    }
});

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
    function markethired(){
        const vehicle_ownership=document.getElementById("vehicle_ownership");
        const marketvehicleoptions=document.getElementById("marketvehicleoptions");
        if(vehicle_ownership.value==='Market Hired'){
            marketvehicleoptions.style.display='flex';
        }
        else{
            marketvehicleoptions.style.display='none';

        }
    }



</script>
</html>