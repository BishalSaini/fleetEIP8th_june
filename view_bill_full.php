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


?>
<?php
$serial_number=$_GET['id'];
$sql_fetch_data="SELECT * FROM `bill_generated` where id='$serial_number'";
$result_fetch=mysqli_query($conn,$sql_fetch_data);
$rowfetch=mysqli_fetch_assoc($result_fetch);
?>


<?php
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    include_once 'partials/_dbconnect.php';

$edit_id=$_POST['edit_id'];
$date=$_POST['date'];
$bill_to_client=$_POST['bill_to_client'];
$ship_to_client=$_POST['ship_to_client'];
$billing_asset_code=$_POST['billing_asset_code'];
$sac=$_POST['sac'];
$uom=$_POST['uom'];
$rate=$_POST['rate'];
$qty=$_POST['qty'];
$month=$_POST['month'];
$bill_from=$_POST['bill_from'];
$bill_to=$_POST['bill_to'];

$sql_edit_bill="UPDATE `bill_generated` SET  `date` = '$date', 
`bill_to_client` = '$bill_to_client', `ship_to_client` = '$ship_to_client', `asset_code` = '$billing_asset_code', 
`billing_month` = '$month', `start_date` = '$bill_from', `end_date` = '$bill_to', 
`sac` = '$sac', `uom` = '$uom', `rate` = '$rate', `qty` = '$qty' WHERE `bill_generated`.`id` = '$edit_id'";
$sql_result_edit_bill=mysqli_query($conn , $sql_edit_bill);
if($sql_result_edit_bill){
    session_start();
    $_SESSION['message'] = "Bill edited successfully.";
    header("location:view_print_bills.php");
}
else{
    $showError = false;

}}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">      <link rel="icon" href="favicon.jpg" type="image/x-icon">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
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
<form action="view_bill_full.php" method="POST" class="bill_form">
    <div class="bill_form_container">
        <p>Generate Bill</p>
        <input type="text" name="edit_id" placeholder="" value="<?php echo $rowfetch['id'] ?>" hidden class="input02">
        <div class="trial1">
            <input type="date" placeholder="" value="<?php echo $rowfetch['date'] ?>" name="date" class="input02">
            <label for="" class="placeholder2">Date</label>
        </div>
        <div class="outer02">
            <div class="trial1">
                <select  id="" name="bill_to_client" class="input02">
                    <option value=""disabled selected>Bill To Client</option>
                    <?php  while( $row=mysqli_fetch_assoc($result)){
                    ?>
            <option value="<?php echo $row['name']; ?>" <?php if($rowfetch['bill_to_client'] === $row['name']){ echo 'selected'; } ?>><?php echo $row['name']; ?></option>
            <?php
                }?>

                </select>
            </div>
            <div class="trial1">
                <select  id="" name="ship_to_client" class="input02">
                    <option value=""disabled selected>Ship To Client</option>
                    <?php  while( $row1=mysqli_fetch_assoc($result1)){
                    ?>
                    <option value="<?php echo $row1['name'] ?>" <?php if($rowfetch['ship_to_client'] === $row1['name']){ echo 'selected'; } ?>><?php echo $row1['name'] ?></option>
            <?php
                }?>

                </select>
            </div>
        </div>
        <div class="trial1">
            <select id="" name="billing_asset_code" class="input02">
                <option value=""disabled selected>Choose Billing Asset Code </option>
                <?php  while( $row_assetcode=mysqli_fetch_assoc($result_asset_code)){
                    ?>
                    <option value="<?php echo $row_assetcode['assetcode'] ?>"<?php if($rowfetch['asset_code'] === $row_assetcode['assetcode']){ echo 'selected'; } ?>><?php echo $row_assetcode['assetcode'] ?></option>
            <?php
                }?>

            </select>
        </div>
        <div class="outer02">
        <div class="trial1">
                <select name="month" id=""  class="input02">
                    <option value=""disabled selected>Bill For The Month Of</option>
                    <option value="January"<?php if($rowfetch['billing_month'] === 'January'){ echo 'selected';} ?>>January</option>
                    <option value="February" <?php if($rowfetch['billing_month'] === 'February'){ echo 'selected';} ?> >February</option>
                    <option value="March" <?php if($rowfetch['billing_month'] === 'March'){ echo 'selected';} ?> >March</option>
                    <option value="April" <?php if($rowfetch['billing_month'] === 'April'){ echo 'selected';} ?>>April</option>
                    <option value="May" <?php if($rowfetch['billing_month'] === 'May'){ echo 'selected';} ?>>May</option>
                    <option value="June" <?php if($rowfetch['billing_month'] === 'June'){ echo 'selected';} ?>>June</option>
                    <option value="July" <?php if($rowfetch['billing_month'] === 'July'){ echo 'selected';} ?>>July</option>
                    <option value="August" <?php if($rowfetch['billing_month'] === 'August'){ echo 'selected';} ?>>August</option>
                    <option value="September" <?php if($rowfetch['billing_month'] === 'September'){ echo 'selected';} ?>>September</option>
                    <option value="October" <?php if($rowfetch['billing_month'] === 'October'){ echo 'selected';} ?>>October</option>
                    <option value="November" <?php if($rowfetch['billing_month'] === 'November'){ echo 'selected';} ?>>November</option>
                    <option value="December" <?php if($rowfetch['billing_month'] === 'December'){ echo 'selected';} ?>>December</option>
                </select>
            </div>
            <div class="trial1">
                <input type="date" name="bill_from" value="<?php echo $rowfetch['start_date'] ?>" placeholder="" class="input02">
                <label for="" class="placeholder2">Bill From</label>
            </div>
            <div class="trial1">
                <input type="date" name="bill_to" value="<?php echo $rowfetch['end_date'] ?>" placeholder="" class="input02">
                <label for="" class="placeholder2">Bill To</label>
            </div>
        </div>
        <div class="outer02">
            <div class="trial1">
                <input type="text" name="sac" value="<?php echo $rowfetch['sac'] ?>" placeholder="" class="input02">
                <label for="" class="placeholder2">SAC</label>
            </div>
            <div class="trial1">
                <select name="uom" id="" value="<?php echo $rowfetch['uom'] ?>" class="input02">
                    <option value=""disabled selected>UOM</option>
                    <option value="Hours" <?php if($rowfetch['uom'] === 'Hours'){ echo 'selected';} ?>>Hours</option>
                    <option value="Days" <?php if($rowfetch['uom'] === 'Days'){ echo 'selected';} ?>>Days</option>
                    <option value="Month" <?php if($rowfetch['uom'] === 'Month'){ echo 'selected';} ?>>Month</option>
                    <option value="Lumpsum" <?php if($rowfetch['uom'] === 'Lumpsum'){ echo 'selected';} ?>>Lumpsum</option>
                </select>
            </div>
            <div class="trial1">
                <input type="text" name="rate" placeholder="" value="<?php echo $rowfetch['rate'] ?>" class="input02">
                <label for="" class="placeholder2">Rate/Day</label>
            </div>
            <div class="trial1">
                <input type="text" name="qty" placeholder="" value="<?php echo $rowfetch['qty'] ?>" class="input02">
                <label for="" class="placeholder2">Qty</label>
            </div>
        </div>
        <br>
        <button class="epc-button"type="submit">Edit Bill</button>
        <br>
    </div>
</form>
</body>
</html>