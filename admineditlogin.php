<?php
session_start();
$email = $_SESSION['email'];
// $companyname001 = $_SESSION['companyname'];
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
elseif ($enterprise === 'admin') {
    $dashboard_url = 'news/admin/dashboard.php';
} 

else {
    $dashboard_url = '';
}

include "partials/_dbconnect.php";  
$id=$_GET['id'];
$sql="SELECT * FROM `login` where sno=$id";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_assoc($result);

if($_SERVER['REQUEST_METHOD']==='POST'){
    include "partials/_dbconnect.php";  

    // $email=$_POST['email'];
    $websiteaddress=$_POST['websiteaddress'];
    $enterprise=$_POST['enterprise'];
    $status=$_POST['status'];
    $editid=$_POST['editid'];
    $companyname=$_POST['companyname'];

    $edit="UPDATE `login` SET `webiste_address`='$websiteaddress',`companyname`='$companyname',`enterprise`='$enterprise',`status`='$status' WHERE `sno`='$editid'";
    $resultedit=mysqli_query($conn,$edit);

    if($resultedit){
        session_start();
        $_SESSION['success']='true';
        header("Location: admin_enrolled.php");
        exit();
    }
    else{
        session_start();
        $_SESSION['error']='true';
        header("Location: admin_enrolled.php");
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
            <li><a href="logout.php">Log Out</a></li></ul>
        </div>
    </div>

    <form action="admineditlogin.php?id=<?php echo $id; ?>" method="POST" autocomplete="off" class="editlogin">
        <div class="editlogininner">
            <p class="headingpara">Edit Login</p>
            <input type="hidden" name="editid" value="<?php echo $id ;?>">
            <div class="trial1">
                <input type="text" name="companyname" placeholder="" value="<?php echo $row['companyname'] ?>"  class="input02" >
                <label for="" class="placeholder2">Company Name</label>
            </div>
            <div class="trial1">
            <input type="text" name="email" placeholder="" value="<?php echo htmlspecialchars($row['email']); ?>" class="input02" readonly>
            <label for="" class="placeholder2">Email</label>
            </div>
            <div class="trial1">
                <input type="text" name="websiteaddress" placeholder="" value="<?php echo $row['webiste_address'] ?>"  class="input02" >
                <label for="" class="placeholder2">Website</label>
            </div>
            <div class="outer02">

            <div class="trial1">
                <select name="enterprise" id="" class="input02">
                    <option value=""disabled selected>Enterprise Type</option>
                    <option <?php if($row['enterprise']==='OEM'){echo 'selected';} ?> value="OEM">OEM</option>
                    <option <?php if($row['enterprise']==='rental'){echo 'selected';} ?> value="rental">Rental</option>
                    <option <?php if($row['enterprise']==='logistics'){echo 'selected';} ?> value="logistics">Logistics</option>
                    <option <?php if($row['enterprise']==='epc'){echo 'selected';} ?> value="epc">EPCM</option>
                </select>
            </div>
            <div class="trial1">
                <select name="status" id="" class="input02">
                    <option value=""disabled selected>Select Status</option>
                    <option <?php if($row['status']==='verified'){echo 'selected';} ?> value="verified">verified</option>
                    <option <?php if($row['status']==='notverified'){echo 'selected';} ?> value="notverified">notverified</option>

                    
                </select>
                <!-- <input type="text" placeholder="" name="status" value="<?php echo $row['status'] ?>" class="input02">
                <label for="" class="placeholder2">Status</label> -->
            </div>
            </div>

            <button class="epc-button">Submit</button>
        </div>
    </form>
</body>
</html>