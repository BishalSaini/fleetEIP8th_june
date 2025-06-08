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

$id=$_GET['id'];
$sql="SELECT * FROM `clients_logi` where companyname='$companyname001'";
$result=mysqli_query($conn,$sql);

$sql_data="SELECT * FROM `triplogi` where id='$id' and companyname='$companyname001'";
$result_data=mysqli_query($conn,$sql_data);
$roww=mysqli_fetch_assoc($result_data);

$sqlcn="SELECT * FROM `cn` where companyname='$companyname001'";
$resultcn=mysqli_query($conn,$sqlcn);

$sqlchallan="SELECT * FROM `challans` where companyname='$companyname001'";
$resultchallan=mysqli_query($conn,$sqlchallan);


if(isset($_SESSION['success'])){
    $showAlert=true;
    unset($_SESSION['success']);
}
else if(isset($_SESSION['error'])){
    $showError=true;
    unset($_SESSION['error']);
}

$partyname="";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include "partials/_dbconnect.php";

    $editid=$_POST['editid'];
    $consignor = $_POST['consignor'];
    $new_client_name=$_POST['new_client_name'] ?? '';
    $address = $_POST['address'];
    $contactperson_consignor = $_POST['contactperson_consignor'];
    $consignor_contactperson_number = $_POST['consignor_contactperson_number'];
    $contactemail_consignor = $_POST['contactemail_consignor'];
    $po_no = $_POST['po_no'];
    $po_date = $_POST['po_date'];
    $source = $_POST['source'];
    $destination = $_POST['destination'];
    $truck_date = $_POST['truck_date'];
    $freight_charges = $_POST['freight_charges'];
    $detention = $_POST['detention'] ?? '';
    $payment_terms = $_POST['payment_terms'];

    if(isset($_POST['consignor']) && $_POST['consignor'] !='New Client'){
        $partyname=$_POST['consignor'];
    }
    else if(isset($_POST['new_client_name']) && !empty($_POST['new_client_name'])){
        $partyname=$_POST['new_client_name'];

    }
    if(isset($_POST['new_client_name']) && !empty($_POST['new_client_name'])){
        $sqllogiclient="INSERT INTO `clients_logi`( `client_name`, `address`, `contact_person1`,
         `companyname`, `contact_number1`, `contact_email1`)
          VALUES ('$partyname','$address','$contactperson_consignor','$companyname001','$consignor_contactperson_number','$contactemail_consignor')";
          $resultinsert=mysqli_query($conn,$sqllogiclient);


    }
    $sqlupdate = "UPDATE triplogi SET
    consignor = '$partyname',
    address = '$address',
    contactperson_consignor = '$contactperson_consignor',
    consignor_contactperson_number = '$consignor_contactperson_number',
    contactemail_consignor = '$contactemail_consignor',
    po_no = '$po_no',
    po_date = '$po_date',
    source = '$source',
    destination = '$destination',
    truck_date = '$truck_date',
    freight_charges = '$freight_charges',
    detention = '$detention',
    payment_terms = '$payment_terms',
    companyname = '$companyname001'
    WHERE id = '$editid'";
    $resultupdate=mysqli_query($conn,$sqlupdate);

    if($resultupdate){
        session_start();
        $_SESSION['success']='success';
        header("Location: addtriprecord.php?id=" . $editid);
        exit();

    }
    else{
        $_SESSION['error']='success';
        header("Location: addtriprecord.php?id=" . $editid);
        exit();
    }

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="favicon.jpg" type="image/x-icon">
    <title>Add Trip Updates</title>
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


<form action="addtriprecord.php" method="POST" class="tripstart">
        <div class="tripstart_container">
            <p class="headingpara">Edit Trip</p>
            <div class="outer02" id="tripclientcontainer">
                <div class="trial1">
                    <input type="text" placeholder="" value="<?php echo $roww['tripid'] ?>" class="input02" readonly>
                    <label for="" class="placeholder2">Trip ID</label>
                </div>
                <select name="consignor" id="consignor" class="input02" onchange="newtripclient()">
                    <option value="" disabled selected>Select A Client</option>
                    <option value="New Client">New Client</option>
                    <?php
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) { ?>
                            <option <?php if($roww['consignor']===$row['client_name']){ echo 'selected';} ?> value="<?php echo $row['client_name'] ?>"><?php echo $row['client_name'] ?></option>
                        <?php }
                    }
                    ?>
                </select>
                <input type="hidden" name="editid" value="<?php echo $id ?>">
                <div class="trial1" id="newtripclientinput" style="display: none;">
                    <input type="text"  name="new_client_name" placeholder="" class="input02">
                    <label for="new_client_name" class="placeholder2">Client Name</label>
                </div>
            </div>
            <input type="text" value="<?php echo $companyname001 ?>" id="logicompanyname" name="companyname" hidden>

            <div class="trial1">
                <textarea name="address"  id="address" placeholder="" class="input02"><?php echo $roww['address'] ?></textarea>
                <label for="address" class="placeholder2">Address</label>
            </div>

            <div class="outer02">
                <div class="trial1">
                    <input type="text" name="contactperson_consignor" value="<?php echo $roww['contactperson_consignor'] ?>" id="contactperson_consignor" placeholder="" class="input02">
                    <label for="contactperson_consignor" class="placeholder2">Contact Person</label>
                </div>
                <div class="trial1">
                    <input type="text" name="consignor_contactperson_number" value="<?php echo $roww['consignor_contactperson_number'] ?>" id="consignor_contactperson_number" placeholder="" class="input02">
                    <label for="consignor_contactperson_number" class="placeholder2">Number</label>
                </div>
                <div class="trial1">
                    <input type="text" name="contactemail_consignor" value="<?php echo $roww['contactemail_consignor'] ?>" id="contactemail_consignor" placeholder="" class="input02">
                    <label for="contactemail_consignor" class="placeholder2">Email</label>
                </div>
            </div>  

            <div class="outer02">
                <div class="trial1">
                    <input type="text" name="po_no" value="<?php echo $roww['po_no'] ?>" placeholder="" class="input02">
                    <label for="po_no" class="placeholder2">PO NO</label>
                </div>
                <div class="trial1">
                    <input type="date" name="po_date" value="<?php echo $roww['po_date'] ?>" placeholder="" class="input02">
                    <label for="po_date" class="placeholder2">PO Date</label>
                </div>
                <div class="trial1">
                    <input type="text" name="source" value="<?php echo $roww['source'] ?>" placeholder="" class="input02">
                    <label for="source" class="placeholder2">Source</label>
                </div>
                <div class="trial1">
                    <input type="text" name="destination" value="<?php echo $roww['destination'] ?>" placeholder="" class="input02">
                    <label for="destination" class="placeholder2">Destination</label>
                </div>
            </div> 

            <div class="trial1">
                <input type="date" name="truck_date" placeholder="" value="<?php echo $roww['truck_date'] ?>" class="input02">
                <label for="truck_date" class="placeholder2">Truck To Be Placed On?</label>
            </div> 

            <div class="outer02">
                <div class="trial1">
                    <input type="text" name="freight_charges" value="<?php echo $roww['freight_charges'] ?>" placeholder="" class="input02">
                    <label for="freight_charges" class="placeholder2">Freight Charges</label>
                </div>
                <div class="trial1">
                    <input type="text" name="detention" value="<?php echo $roww['detention'] ?>" placeholder="" class="input02">
                    <label for="detention" class="placeholder2">Detention</label>
                </div>
                <div class="trial1">
                    <select name="payment_terms" class="input02">
                        <option value="" disabled selected>Payment Terms</option>
                        <option <?php if($roww['payment_terms']==='Advance'){ echo 'selected';} ?> value="Advance">Advance</option>
                        <option <?php if($roww['payment_terms']==='15 Days Credit'){ echo 'selected';} ?> value="15 Days Credit">15 Days Credit</option>
                        <option <?php if($roww['payment_terms']==='30 Days Credit'){ echo 'selected';} ?> value="30 Days Credit">30 Days Credit</option>
                        <option <?php if($roww['payment_terms']==='45 Days Credit'){ echo 'selected';} ?> value="45 Days Credit">45 Days Credit</option>
                        <option <?php if($roww['payment_terms']==='60 Days Credit'){ echo 'selected';} ?> value="60 Days Credit">60 Days Credit</option>
                    </select>
                </div>
            </div>


            <button class="epc-button" type="submit">Update</button>      
        </div>
    </form>

</body>
<script>
    function newtripclient(){
        const selecttripclient=document.getElementById("consignor");
        const newtripclientinput=document.getElementById("newtripclientinput");
        const tripclientcontainer=document.getElementById("tripclientcontainer");

        if(selecttripclient.value ==='New Client'){
            selecttripclient.style.display='none';
            newtripclientinput.style.display='flex';
        }

    }

    document.addEventListener('DOMContentLoaded', function() {
    // Check if oem_fleet_type7 is not empty and call seco_equip_2()
    var consignor = document.getElementById('consignor');
    if (consignor.value !== '') {
        newtripclient();
    }
});

</script>
</html>