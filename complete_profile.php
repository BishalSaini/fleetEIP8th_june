<?php 
$showAlert = false;
$showError = false;
include 'partials/_dbconnect.php';
session_start();
$companyname001=$_SESSION['companyname'];

include 'partials/_dbconnect.php';
$sql_check="SELECT * FROM `complete_profile` where companyname='$companyname001'";
$result_check=mysqli_query($conn , $sql_check);
$row_check=mysqli_fetch_assoc($result_check);


if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['letterhead'])){
    include 'partials/_dbconnect.php';

    $bankname=$_POST['bankname'];
    $acc_num=$_POST['acc_num'];
    $ifsc=$_POST['ifsc'];
    $branch=$_POST['branch'];
    $acc_type=$_POST['acc_type'];
    $companylogo = $_FILES['letterhead']['name'];
    $temp_file_path = $_FILES['letterhead']['tmp_name'];
    $folder1 = 'img/' . $companylogo;

    if (move_uploaded_file($temp_file_path, $folder1)) {
    $sql="INSERT INTO `complete_profile` (`letter_head`, `bank_name`, `account_num`, `branch`, `ifsc_code`, `account_type`, `companyname`) 
    VALUES ('$companylogo','$bankname', '$acc_num', '$ifsc', '$branch', '$acc_type', '$companyname001')";
    $result=mysqli_query($conn,$sql);
    if($result){
        $showAlert=true;
    }
    else{
        $showError=true;
    }
}
else{
    $showError=true;

}}

?>

<?php 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">      <link rel="icon" href="favicon.jpg" type="image/x-icon">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Complete Profile</title>
</head>
<body>
    <style>
        <?php include "style.css" ?>
    </style>
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
if($showAlert){
    echo '<label>
    <input type="checkbox" class="alertCheckbox" autocomplete="off" />
    <div class="alert notice">
        <span class="alertClose">X</span>
        <span class="alertText">Profile Completed Successfully<br class="clear"/></span>
    </div>
    </label>';
}
if($showError){
    echo '<label>
    <input type="checkbox" class="alertCheckbox" autocomplete="off" />
    <div class="alert error">
        <span class="alertClose">X</span>
        <span class="alertText">Something Went Wrong<br class="clear"/></span>
    </div>
    </label>';
}
?>
<p class="after_display" <?php if(empty($row_check['ifsc_code'])){ echo 'style="display:none"';} ?>>Profile Is Completed For Any Changes edit your profile&nbsp;<a href="edit_profile.php">Here</a></p>
<p <?php if(!empty($row_check['ifsc_code'])){ echo 'style="display:none"';} ?> class="complete_profile">Complete Your Profile To Automate Billing And Quotation Process</p>
<form action="complete_profile.php" autocomplete="off" method="POST" class="profile" enctype="multipart/form-data" <?php if(!empty($row_check['ifsc_code'])){ echo 'style="display:none"';} ?>>
    <div class="profile_container">
        <p>Complete Profile</p>
        <div class="trial1">
            <input type="file" name="letterhead" placeholder=""  class="input02" >
            <label for="" class="placeholder2">Upload Letter Head Header</label>
        </div>
        <div class="trial1">
            <input type="text" name="bankname" placeholder=""  class="input02">
            <label for="" class="placeholder2">Enter Bank Name</label>
        </div>
        <div class="trial1">
            <input type="text" name="acc_num" placeholder="" class="input02">
            <label for="" class="placeholder2">Enter Bank Account Number</label>
        </div>
        <div class="trial1">
            <input type="text" name="ifsc" placeholder="" class="input02">
            <label for="" class="placeholder2">IFSC Code</label>
        </div>
        <div class="trial1">
            <input type="text" name="branch" placeholder="" class="input02">
            <label for="" class="placeholder2"> Branch</label>
        </div>
        <div class="trial1">
            <select name="acc_type" id="" class="input02">
                <option value=""disabled selected>Choose Account Type</option>
                <option value="Current">Current</option>
                <!-- <option value="Savings">Savings</option> -->
            </select>
        </div>
        <div class="trial1">
            <select name="msme" id="" class="input02">
                <option value=""disabled selected>MSME Registered ?</option>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
            </select>
        </div>
        <div class="outer02">
            <div class="trial1">
                <input type="text" name="msme_number" class="input02">
                <label for="" class="placeholder2">MSME Number</label>
            </div>
            <div class="trial1">
                <input type="file" name="msme_certificate" class="input02">
                <label for="" class="placeholder2">MSME Certificate</label>
            </div>
        </div>
        <button class="epc-button" type="submit">Submit</button>
        <br><br>
    </div>
</form>
</body>
</html>