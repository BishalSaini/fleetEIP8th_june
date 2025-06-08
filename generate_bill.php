<?php
include_once 'partials/_dbconnect.php';
$showAlert = false;
$showError = false;

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
$sql="SELECT * FROM `billing_clients` WHERE added_by='$companyname001' ORDER BY id DESC";
$result=mysqli_query($conn , $sql);


$sql1="SELECT * FROM `billing_clients` WHERE added_by='$companyname001' ORDER BY id DESC";
$result1=mysqli_query($conn , $sql1);

$sql_asset_code="SELECT * FROM `fleet1` WHERE companyname='$companyname001'";
$result_asset_code=mysqli_query($conn , $sql_asset_code);

if(isset($_GET['equipment'])){
    $equipment_detail = $_GET['equipment'];
    $rc_detail = $_GET['rentalcharge'];
    $asset_code_detial=$_GET['asset_code'];
    $ot_pro_rata=$_GET['ot_pro_rata'];


}

?>
<?php 
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    include_once 'partials/_dbconnect.php';
$date=$_POST['date'];
$bill_to_client=$_POST['bill_to_client'];
$ship_to_client=$_POST['ship_to_client'];
$billing_asset_code=$_POST['billing_asset_code'];
$assetcode_info="SELECT * FROM `fleet1` WHERE companyname='$companyname001' and assetcode='$billing_asset_code'";
$asset_Code_result=mysqli_query($conn ,$assetcode_info);
$row_asset_code=mysqli_fetch_assoc($asset_Code_result);

$sac=$_POST['sac'];
$uom=$_POST['uom'];
$rate=$_POST['rate'];
$qty=$_POST['qty'];
$month=$_POST['month'];
$bill_from=$_POST['bill_from'];
$bill_to=$_POST['bill_to'];

$sql_bill_detail="INSERT INTO `bill_generated` (`companyname`, `date`, `bill_to_client`, `ship_to_client`, 
`asset_code`,`asset_code_make`,`ac_model`,`ac_sub_type`,`reg_no`,`billing_month`,`start_date`,`end_date`, `sac`, `uom`, `rate`, `qty`) 
VALUES ('$companyname001', '$date', '$bill_to_client', '$ship_to_client', '$billing_asset_code',
'".$row_asset_code['make']."','".$row_asset_code['model']."','".$row_asset_code['sub_type']."','".$row_asset_code['registration']."','$month','$bill_from','$bill_to', '$sac', '$uom', '$rate', '$qty')";
$result_sql_bill_detail=mysqli_query($conn , $sql_bill_detail);
if($result_sql_bill_detail){
    $showAlert=true;
}
else{
    $showError=true;
}
}


?>
<script><?php include "main.js"  ?></script>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">      <link rel="icon" href="favicon.jpg" type="image/x-icon">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="main.js"></script>
    <title>Generate Bills</title>
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
      <span class="alertText_addfleet"><b>Success! </b>Bill Generated Successfully<a href="view_print_bills.php">View It Here</a>
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

<form action="generate_bill.php" method="POST" class="bill_form">
    <div class="bill_form_container">
        <p>Generate Bill</p>
        <div class="trial1">
            <select id="bill_ac" name="billing_asset_code" onchange="Get_asset_Detail()" class="input02">
                <option value=""disabled selected> Billing Asset Code </option>
                <?php  while( $row_assetcode=mysqli_fetch_assoc($result_asset_code)){
                    ?>
            <option value="<?php echo $row_assetcode['assetcode'] ?>" <?php if(isset($asset_code_detial) and $row_assetcode['assetcode'] === $asset_code_detial){ echo 'selected';} ?> ><?php echo $row_assetcode['assetcode'] ." " . $row_assetcode['sub_type'] ." " . $row_assetcode['model'] ?></option>
            <?php
                }?>

            </select>
        </div>

        <div class="outer02">
            <!-- <?php echo $asset_code_detial ?> -->
        <div class="trial1">
            <input type="text" <?php if(isset($equipment_detail)) { echo 'value="' . $equipment_detail . '"'; } ?> class="input02">
            <label for="" class="placeholder2">Equipment</label>
        </div>
        <div class="trial1">
        <input type="text" <?php if(isset($rc_detail)) { echo 'value="' . $rc_detail . '"'; } ?> class="input02">
            <label for="" class="placeholder2">Rental Charge</label>
        </div>

        </div>
        <div class="trial1">
            <?php $current_date_info=date('Y-m-d'); ?>

            <input type="date" placeholder="" name="date" value="<?php echo $current_date_info ?>" class="input02">
            <label for="" class="placeholder2">Date</label>
        </div>

        <a class="add_clients" href="add_bill_client.php">If Client Not in Option Add Them Here</a>

        <div class="outer02">
            <div class="trial1">
                <select  id="" name="bill_to_client" class="input02">
                    <option value=""disabled selected>Bill To Client</option>
                    <?php  while( $row=mysqli_fetch_assoc($result)){
                    ?>
                    <option value="<?php echo $row['name'] ?>"><?php echo $row['name'] ?></option>
            <?php
                }?>

                </select>
            </div>
            <div class="trial1">
                <select  id="" name="ship_to_client" class="input02">
                    <option value=""disabled selected>Ship To Client</option>
                    <?php  while( $row1=mysqli_fetch_assoc($result1)){
                    ?>
                    <option value="<?php echo $row1['name'] ?>"><?php echo $row1['name'] ?></option>
            <?php
                }?>

                </select>
            </div>
        </div>

        <div class="outer02">
        <div class="trial1">
                <select name="month" id="" class="input02">
                    <option value=""disabled selected>Bill For The Month Of</option>
                    <option value="January">January</option>
                    <option value="February">February</option>
                    <option value="March">March</option>
                    <option value="April">April</option>
                    <option value="May">May</option>
                    <option value="June">June</option>
                    <option value="July">July</option>
                    <option value="August">August</option>
                    <option value="September">September</option>
                    <option value="October">October</option>
                    <option value="November">November</option>
                    <option value="December">December</option>
                </select>
            </div>
            <div class="trial1">
                <input type="date" name="bill_from" placeholder="" class="input02">
                <label for="" class="placeholder2">Bill From</label>
            </div>
            <div class="trial1">
                <input type="date" name="bill_to" placeholder="" class="input02">
                <label for="" class="placeholder2">Bill To</label>
            </div>
        </div>
        <div class="outer02">
            <div class="trial1">
                <input type="text" name="sac" placeholder="" class="input02">
                <label for="" class="placeholder2">SAC</label>
            </div>
            <div class="trial1">
                <select name="uom" id="" class="input02">
                    <option value=""disabled selected>UOM</option>
                    <option value="Hours">Hours</option>
                    <option value="Days">Days</option>
                    <option value="Month">Month</option>
                    <option value="Lumpsum">Lumpsum</option>
                </select>
            </div>
           

            <div class="trial1">
                <input type="text" name="rate" placeholder="" class="input02">
                <label for="" class="placeholder2">Rate</label>
            </div>
            <div class="trial1">
                <input type="text" name="qty" placeholder="" class="input02">
                <label for="" class="placeholder2">Qty</label>
            </div>
        </div>
        <!-- <div class="outer02">
            <div class="trial1">
                <input type="text" class="input02">
                <label for="" class="placeholder2">Mob Charges</label>
            </div>
            <div class="trial1">
                <input type="text" class="input02">
                <label for="" class="placeholder2">DeMob Charges</label>
            </div>
            <div class="trial1">
                <input type="text" class="input02">
                <label for="" class="placeholder2">Crew Charges</label>
            </div>
        </div> -->
         <!-- <div class="outer02">
                    <div class="trial1">
                        <input type="text" <?php if(isset($equipment_detail)) { echo 'value="' . $ot_pro_rata . '"'; } ?>  class="input02">
                        <label for="" class="placeholder2">Ot Charges in % (Pro-rata)</label>
                    </div>
                    <div class="trial1">
                        <input type="text" class="input02">
                        <label for="" class="placeholder2">Ot hours</label>
                    </div>
                    <div class="icon_contai">
                    <i class="fa-solid fa-plus" id="first_expense_btn" onclick="add_other_expense()"></i>
                    </div>
                </div> -->
        <!--<div class="outer02">
            <div class="trial1" id="expn_desc1">
            <input type="text" class="input02">
            <label for="" class="placeholder2">Other Expense Description</label>
            </div>
            <div class="trial1" id="cost1">
            <input type="text" class="input02">
            <label for="" class="placeholder2">Expense Cost</label>
            </div>
            <div class="icon_contai">
                    <i class="fa-solid fa-plus" id="second_expense_btn" onclick="add_other_Expense2()"></i>


        </div></div>

        <div class="outer02">
            <div class="trial1" id="expn_desc2">
            <input type="text" class="input02">
            <label for="" class="placeholder2">Other Expense Description</label>
            </div>
            <div class="trial1" id="cost2">
            <input type="text" class="input02">
            <label for="" class="placeholder2">Expense Cost</label>
            </div>

        </div> -->

        <br>
        <button class="epc-button"type="submit">Generate Bill</button>
        <br>
    </div>
</form>
</body>
</html>