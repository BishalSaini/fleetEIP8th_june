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
$clientid=$_GET['clientid'];

$sql="SELECT * FROM `rentalclients` where id='$id'";
$result=mysqli_query($conn,$sql);
if(mysqli_num_rows($result)>0){
    $row=mysqli_fetch_assoc($result);
}
else{
    $row=array();
}
if($_SERVER['REQUEST_METHOD']==='POST'){
    $hqname=$_POST['hqname'];
    $hqdesignation=$_POST['hqdesignation'];
    $hqcontact=$_POST['hqcontact'];
    $hqemail=$_POST['hqemail'];
    $editid=$_POST['editid'];
    $clientid=$_POST['clientid'];

    $update="UPDATE `rentalclients` SET `contact_person`='$hqname',`designation`='$hqdesignation',`contact_number`='$hqcontact',`contact_email`='$hqemail' WHERE id='$editid'";
    $result=mysqli_query($conn,$update);
    if($result){
        session_start();
        $_SESSION['success']='success';
        header("Location: rentalclientdetail.php?id=" . urlencode($clientid));
        exit();
    }
    else{
        $_SESSION['error']='success';
        header("Location: rentalclientdetail.php?id=" . urlencode($clientid));
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
    <title>Edit Detials</title>
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
<form action="edithqcontactperson.php" method="POST" class="hqcontact" id="" autocomplete="off">
        <div class="hqcontactcontainer">
            <p class="headingpara">HQ Contact Person</p>
                <input type="hidden" name="editid" value="<?php echo $id ?>">
                <input type="hidden" name="clientid" value="<?php echo $clientid ?>">
            <div class="outer02">
            <div class="trial1">
                <input type="text" placeholder="" value="<?php echo $row['contact_person'] ?>" name="hqname" class="input02">
                <label for="" class="placeholder2">Name</label>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" value="<?php echo $row['designation'] ?>" name="hqdesignation" class="input02">
                <label for="" class="placeholder2">Designation</label>
            </div>
            </div>
            <div class="outer02">
            <div class="trial1">
                <input type="text" placeholder="" value="<?php echo $row['contact_number'] ?>" name="hqcontact" class="input02">
                <label for="" class="placeholder2">Contact Number</label>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" name="hqemail" value="<?php echo $row['contact_email'] ?>" class="input02">
                <label for="" class="placeholder2">Contact Email</label>
            </div>

            </div>
            <div class="trial1 hideit">
            <textarea name="hqaddress" id="" class="input02"><?php echo $row['clientaddress'] ?></textarea>
            <label for="" class="placeholder2">Address</label>

            </div>
            <button class="epc-button" name="hqsubmit">Submit</button>
        </div>
    </form>

</body>
</html>