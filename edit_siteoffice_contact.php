<?php
$id=$_GET['id'];
$clientid=$_GET['clientid'];
include "partials/_dbconnect.php";
session_start();
$companyname001=$_SESSION['companyname'];
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

$sql="SELECT * FROM `rentalclients` where id='$id' and companyname='$companyname001'";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_assoc($result);

if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['sitesubmit'])){
    include "partials/_dbconnect.php";
    $sitename=$_POST['sitename'];
    $sitedestination=$_POST['sitedestination'];
    $sitecontact=$_POST['sitecontact'];
    $siteemail=$_POST['siteemail'];
    $clientidnew=$_POST['clientid'];
    $editid=$_POST['editid'];
    $handled_by=$_POST['handled_by'];


    $sqledit="UPDATE `rentalclients` SET `contact_person`='$sitename',`designation`='$sitedestination',
    `contact_number`='$sitecontact',`handled_by`='$handled_by',`contact_email`='$siteemail'WHERE id='$editid'";
    $sqlresult=mysqli_query($conn,$sqledit);
    if($sqlresult){
        session_start();
        $_SESSION['success']='success';
        header("Location:rentalclientdetail.php?id=" .urlencode($clientidnew));
    
    }
    else{
        session_start();
        $_SESSION['success']='success';
        header("Location:rentalclientdetail.php?id=" .urlencode($clientidnew));
    
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
    <title>Edit</title>
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

<form action="edit_siteoffice_contact.php" method="POST" autocomplete="off" class="hqcontact" id="">
        <div class="hqcontactcontainer">
            <p class="headingpara">Site Contact Person</p>

            <div class="outer02">
            <div class="trial1">
                <input type="text" placeholder="" value="<?php echo $row['contact_person'] ?>" name="sitename" class="input02">
                <label for="" class="placeholder2">Name</label>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" value="<?php echo $row['designation'] ?>" name="sitedestination" class="input02">
                <label for="" class="placeholder2">Designation</label>
            </div>
            <input type="hidden" name="clientid" value="<?php echo $clientid ?>">
            <input type="hidden" name="editid" value="<?php echo $id ?>">
            </div>
            <div class="outer02">
            <div class="trial1">
                <input type="text" placeholder="" value="<?php echo $row['contact_number'] ?>" name="sitecontact" class="input02">
                <label for="" class="placeholder2">Contact Number</label>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" value="<?php echo $row['contact_email'] ?>" name="siteemail" class="input02">
                <label for="" class="placeholder2">Contact Email</label>
            </div>

            </div>
            <?php 
            include "partials/_dbconnect.php";
            $sql_teammember="SELECT * FROM `team_members` where company_name='$companyname001' and department='marketing' or company_name='$companyname001' and department='Management' ";
            $result_teammember=mysqli_query($conn,$sql_teammember);
            // $row_teammember=mysqli_fetch_assoc($result_teammember);
            ?>
            <div class="trial1">
                <select name="handled_by" id="" class="input02" required>
                    <option value=""disabled selected>KAM</option>
                    <?php if(mysqli_num_rows($result_teammember)>0){
                        while($row_team=mysqli_fetch_assoc($result_teammember)){ ?>
<option <?php if ($row['handled_by'] === $row_team['name']) { echo 'selected'; } ?> value="<?php echo $row_team['name']; ?>">KAM :<?php echo $row_team['name']; ?></option>

                      <?php  }
                    } ?>
                </select>
            </div>


            <button class="epc-button" name="sitesubmit">Submit</button>
        </div>
    </form>

</body>
</html>