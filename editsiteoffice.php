<?php 
session_start();
$enterprise=$_SESSION['enterprise'];

$companyname001 = $_SESSION['companyname'];
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

$id=$_GET['id'];
$clientid=$_GET['clientid'];

$sql="SELECT * FROM `site_office` where id='$id' and companyname='$companyname001'";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_assoc($result);


if($_SERVER['REQUEST_METHOD']==='POST'){
    include "partials/_dbconnect.php";

    $editid=$_POST['editid'];
    $clientidinput=$_POST['clientidinput'];
    $heading=$_POST['heading'];
    $address=$_POST['address'];
    $state=$_POST['state'];

    $sqledit="UPDATE `site_office` SET `address`='$address',`heading`='$heading',`state`='$state' WHERE id='$editid'";
    $resultedit=mysqli_query($conn,$sqledit);

    $sqlalledit="UPDATE `rentalclients` SET `associate_site`='$heading',`clientaddress`='$address' where `clientid`='$clientidinput' and companyname='$companyname001' and `address_type`='Site Office' ";
    $resultall=mysqli_query($conn,$sqlalledit);
    if($resultedit && $resultall){
        session_start();
        $_SESSION['success']='success';
        header("Location:rentalclientdetail.php?id=".urldecode($clientidinput));

    }
    else{
        $_SESSION['error']='success';
        header("Location:rentalclientdetail.php?id=".urldecode($clientidinput));

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
            <li><a href="logout.php">Log Out</a></li>
        </ul>
    </div>
</div>
<form action="editsiteoffice.php" autocomplete="off" method="POST" class="editsiteofficeform">
    <div class="editsiteofficecontainer">
        <input type="hidden" name="editid" value="<?php echo $id ?>">
        <input type="hidden" name="clientidinput" value="<?php echo $clientid ?>">
        <p class="headingpara">Edit Site Office</p>
        <div class="trial1">
            <input type="text" placeholder="" value="<?php echo $row['heading'] ?>" name="heading" class="input02">
            <label for="" class="placeholder2">Heading</label>
        </div>

        <div class="trial1">
        <textarea class="input02" name="address" id=""><?php echo $row['address'] ?></textarea>
        <label for="" class="placeholder2">Address</label>

        </div>
        <div class="trial1">
        <select name="state" id="" class="input02">
                    <option value=""disabled selected>Select State</option>
                    <option <?php if($row['state'] === 'Andhra Pradesh') { echo 'selected'; } ?> value="Andhra Pradesh">Andhra Pradesh</option>
    <option <?php if($row['state'] === 'Arunachal Pradesh') { echo 'selected'; } ?> value="Arunachal Pradesh">Arunachal Pradesh</option>
    <option <?php if($row['state'] === 'Assam') { echo 'selected'; } ?> value="Assam">Assam</option>
    <option <?php if($row['state'] === 'Bihar') { echo 'selected'; } ?> value="Bihar">Bihar</option>
    <option <?php if($row['state'] === 'Chandigarh') { echo 'selected'; } ?> value="Chandigarh">Chandigarh</option>
    <option <?php if($row['state'] === 'Chhattisgarh') { echo 'selected'; } ?> value="Chhattisgarh">Chhattisgarh</option>
    <option <?php if($row['state'] === 'Dadra and Nagar Haveli and Daman and Diu') { echo 'selected'; } ?> value="Dadra and Nagar Haveli and Daman and Diu">Dadra and Nagar Haveli and Daman and Diu</option>
    <option <?php if($row['state'] === 'Delhi') { echo 'selected'; } ?> value="Delhi">Delhi</option>
    <option <?php if($row['state'] === 'Goa') { echo 'selected'; } ?> value="Goa">Goa</option>
    <option <?php if($row['state'] === 'Gujarat') { echo 'selected'; } ?> value="Gujarat">Gujarat</option>
    <option <?php if($row['state'] === 'Haryana') { echo 'selected'; } ?> value="Haryana">Haryana</option>
    <option <?php if($row['state'] === 'Himachal Pradesh') { echo 'selected'; } ?> value="Himachal Pradesh">Himachal Pradesh</option>
    <option <?php if($row['state'] === 'Jammu and Kashmir') { echo 'selected'; } ?> value="Jammu and Kashmir">Jammu and Kashmir</option>
    <option <?php if($row['state'] === 'Jharkhand') { echo 'selected'; } ?> value="Jharkhand">Jharkhand</option>
    <option <?php if($row['state'] === 'Karnataka') { echo 'selected'; } ?> value="Karnataka">Karnataka</option>
    <option <?php if($row['state'] === 'Kerala') { echo 'selected'; } ?> value="Kerala">Kerala</option>
    <option <?php if($row['state'] === 'Ladakh') { echo 'selected'; } ?> value="Ladakh">Ladakh</option>
    <option <?php if($row['state'] === 'Lakshadweep') { echo 'selected'; } ?> value="Lakshadweep">Lakshadweep</option>
    <option <?php if($row['state'] === 'Madhya Pradesh') { echo 'selected'; } ?> value="Madhya Pradesh">Madhya Pradesh</option>
    <option <?php if($row['state'] === 'Maharashtra') { echo 'selected'; } ?> value="Maharashtra">Maharashtra</option>
    <option <?php if($row['state'] === 'Manipur') { echo 'selected'; } ?> value="Manipur">Manipur</option>
    <option <?php if($row['state'] === 'Meghalaya') { echo 'selected'; } ?> value="Meghalaya">Meghalaya</option>
    <option <?php if($row['state'] === 'Mizoram') { echo 'selected'; } ?> value="Mizoram">Mizoram</option>
    <option <?php if($row['state'] === 'Nagaland') { echo 'selected'; } ?> value="Nagaland">Nagaland</option>
    <option <?php if($row['state'] === 'Odisha') { echo 'selected'; } ?> value="Odisha">Odisha</option>
    <option <?php if($row['state'] === 'Puducherry') { echo 'selected'; } ?> value="Puducherry">Puducherry</option>
    <option <?php if($row['state'] === 'Punjab') { echo 'selected'; } ?> value="Punjab">Punjab</option>
    <option <?php if($row['state'] === 'Rajasthan') { echo 'selected'; } ?> value="Rajasthan">Rajasthan</option>
    <option <?php if($row['state'] === 'Sikkim') { echo 'selected'; } ?> value="Sikkim">Sikkim</option>
    <option <?php if($row['state'] === 'Tamil Nadu') { echo 'selected'; } ?> value="Tamil Nadu">Tamil Nadu</option>
    <option <?php if($row['state'] === 'Telangana') { echo 'selected'; } ?> value="Telangana">Telangana</option>
    <option <?php if($row['state'] === 'Tripura') { echo 'selected'; } ?> value="Tripura">Tripura</option>
    <option <?php if($row['state'] === 'Uttar Pradesh') { echo 'selected'; } ?> value="Uttar Pradesh">Uttar Pradesh</option>
    <option <?php if($row['state'] === 'Uttarakhand') { echo 'selected'; } ?> value="Uttarakhand">Uttarakhand</option>
    <option <?php if($row['state'] === 'West Bengal') { echo 'selected'; } ?> value="West Bengal">West Bengal</option>

                </select>
        </div>
    <button class="epc-button">Submit</button>
    </div>
</form>

</body>
</html>