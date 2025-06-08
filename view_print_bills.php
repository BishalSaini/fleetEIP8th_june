
<?php
include "partials/_dbconnect.php";
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
$sql = "SELECT * FROM `bill_generated` WHERE companyname='$companyname001' ORDER BY id DESC";
$result=mysqli_query($conn , $sql);



?>
<?php
$showAlert = false;
$showError = false;


if(isset($_SESSION['message'])) {
    $showAlert = true;
    unset($_SESSION['message']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">      <link rel="icon" href="favicon.jpg" type="image/x-icon">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<style>
    <?php include "style.css" ?>
</style>
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
      <span class="alertText_addfleet"><b>Success! </b>Bill Edited Successfully
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

    <table class="view_bills">
    <th>Date</th>
    <th>Ref</th>
    <th>Bill To</th>
    <th>Asset Code</th>
    <th>Equipment</th>
    <th>Bill Month</th>
    <th>Actions</th>
<?php while($row=mysqli_fetch_assoc($result)){
    ?>
<tr>
<td><?php echo date('d-m-Y', strtotime($row['date'])); ?></td>
    <td><?php echo $row['companyname'] .  "/" . " ". $row['id'] ?></td>
    <td><?php echo $row['bill_to_client'] ?></td>
    <td><?php echo $row['asset_code'] ?></td>
    <td><?php echo $row['asset_code_make'] . " " . $row['ac_model']; ?></td>
    <td><?php echo $row['billing_month'] ?></td>
    <td><a href="view_bill_full.php?id=<?php echo $row['id']; ?>" class="view_bill_button1">Edit</a>
    <a  onclick="del_bill()" class="view_bill_button1" id="del_bill_button">Delete</a>
        <a href="final_bill.php?id=<?php echo $row['id'];  ?>" class="view_bill_button1" id="del_bill_button">View</a>
</td>
</tr>
<div id="deleteModal" class="modal_client">
                <div class="del_client_container">
                <div class="confirm_del_client">
                    <p>Confirm Delete?</p>
<div class="btn_set"><a href="del_bill.php?id=<?php echo $row['id'] ?>" class="del_client_confirm" >Delete</a>
<a href="view_print_bills.php" class="del_client_confirm" id="cancel_client">Cancel</a>
</div>
                </div>
                </div>

<?php
} ?>
</table>
<script>
        function del_bill(){
        const deleteModal=document.getElementById("deleteModal").style.display="block";
    }

</script>
</body>
</html>