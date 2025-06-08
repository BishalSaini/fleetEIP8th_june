<?php
session_start();
$email=$_SESSION['email'];
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
$showAlert = false;
$showError = false;

?>

<?php
include_once 'partials/_dbconnect.php'; // Include the database connection file
$sql_bank_details="SELECT * FROM `complete_profile` WHERE companyname='$companyname001'";
$result_sql_bank=mysqli_query($conn , $sql_bank_details);
$row_bank=mysqli_fetch_assoc($result_sql_bank);

?>
<?php 
if(isset($_SESSION['message'])){
    $showAlert=true;
    unset($_SESSION['message']);
}

?>
<?php 
if($_SERVER['REQUEST_METHOD']==='POST'){
    include "partials/_dbconnect.php";
   $email_company=$_POST['email_company'] ;
   $companyname=$_POST['companyname'];
   $gst=$_POST['gst'];
   $pancard=$_POST['pancard'];
   $contact_num=$_POST['contact_num'];
   $web_dd=$_POST['web_dd'];
   $web_add=!empty($_POST['web_add']) ? $_POST['web_add'] : 'None';
   $enterprise=$_POST['enterprise'];
   $add_on=!empty($_POST['add_on']) ? $_POST['add_on'] : 'None';
   $rmc_type=!empty($_POST['rmc_type']) ? $_POST['rmc_type'] : 'None';
   $rmc_location=$_POST['rmc_location'];
   $rmc_pincode=$_POST['rmc_pincode'];
   $company_Address=$_POST['company_Address'];
   $comp_pincode=$_POST['comp_pincode'];


   $sql_edit_profile="UPDATE `login` SET `email` = '$email_company', `companyname` = '$companyname',
    `company_address` = '$company_Address', `compnay_pincode` = '$comp_pincode', `gst` = '$gst', `pancard` = '$pancard', `contactnumber` = '$contact_num', 
    `comp_web` = '$web_dd', `webiste_address` = '$web_add', `enterprise` = '$enterprise', `add_on_services` = '$add_on', `rmc_type` = '$rmc_type',
     `rmc_location` = '$rmc_location', `rmc_pincode` = '$rmc_pincode' WHERE `login`.`companyname` = '$companyname001'";
     $result_edit_profile=mysqli_query($conn , $sql_edit_profile);
     if($result_edit_profile){
        $showAlert=true;
     }
     else{
        $showError=true;
     }
}

?>
<style>
<?php
include 'style.css'
?>
</style>
<?php 
    include_once 'partials/_dbconnect.php'; // Include the database connection file

$sql_profile="SELECT * FROM login where email='$email' and companyname='$companyname001'";
$result_profile=mysqli_query($conn , $sql_profile);
$row=mysqli_fetch_assoc($result_profile);

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
            <li><a href="view_news_epc.php">News</a></li>
            
            <li><a href="logout.php">Log Out</a></li></ul>
  </div>
</div>
  <?php
if ($showAlert) {
    echo  '<label>
    <input type="checkbox" class="alertCheckbox" autocomplete="off" />
    <div class="alert notice">
      <span class="alertClose">X</span>
      <span class="alertText_addfleet"><b>Success! </b>Profile Edited Successfully
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

    </div> 
    <div class="letterhead_logo" style="background-image: url('img/<?php echo $row_bank['letter_head']; ?>');"></div>
    <div class="both_form_container">
    <form action="edit_profile.php" method="POST" class="edit_profile_form">
        <div class="edit_profile_container">
            <div class="proifle_heading">Edit General Profile</div>
            <div class="trial1">
                <input type="text" placeholder="" name="email_company" class="input02" value="<?php echo$row['email']; ?>">
                <lable class="placeholder2">Email</lable>
            </div>
            <!-- <div class="trial1">
                <input type="password" placeholder="" value="<?php echo$row['password']; ?>" class="input02">
                <lable class="placeholder2">Confirm Password</lable>
            </div> -->
            <div class="trial1">
                <input type="text" value="<?php echo$row['companyname']; ?>" name="companyname" placeholder="" class="input02">
                <lable class="placeholder2">Company Name</lable>
            </div>
        <div class="trial1">
        <input type="text" class="input02" placeholder="" value="<?php echo$row['company_address']; ?>" name="company_Address">    
        <label for="" class="placeholder2">Company Address</label>
        </div>
        <div class="trial1">
                <input type="text" placeholder="" name="comp_pincode" value="<?php echo $row['compnay_pincode'] ?>" class="input02">
                <label for="" class="placeholder2">Company Pincode</label>
        </div>
        <div class="trial1">
                    <input type="text" placeholder="" name="gst" value="<?php echo$row['gst']; ?>" class="input02">
                <lable class="placeholder2">GST Number</lable>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" name="pancard" value="<?php echo$row['pancard']; ?>" class="input02">
                <lable class="placeholder2">Pan Card</lable>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" name="contact_num" value="<?php echo$row['contactnumber']; ?>" class="input02">
                <lable class="placeholder2">Contact Number</lable>
            </div>
            <div class="trial1">
                <select  name="web_dd" id="company_web_drop_down" class="input02" onchange="website_input()">
                    <option value="none" disabled selected>Company Website?</option>
                    <option value="yes" <?php if($row['comp_web']==='yes'){echo 'selected';}?>>Yes</option>
                    <option value="no" <?php if($row['comp_web']==='no'){echo 'selected';}?>>No</option>
                </select>
            </div>
            <div class="trial1">
            <input type="text" placeholder="" name="web_add" value="<?php echo $row['webiste_address'] ?>" class="input02">
            <label for="" class="placeholder2">Company Website</label>
            </div>
            <div class="trial1"> 
                <select name="enterprise" id="" class="input02">
                <option value="none" disabled selected>Enterprise Classifiesd As</option>
                <option value="OEM" <?php if($row['enterprise']==='OEM'){echo 'selected';} ?>>OEM</option>
                <option value="rental" <?php if($row['enterprise']==='rental'){echo 'selected';} ?>>Rental</option>
                <option value="logistics" <?php if($row['enterprise']==='logistics'){echo 'selected';} ?>>Logistics</option>
                <option value="epc" <?php if($row['enterprise']==='epc'){echo 'selected';} ?>>EPC</option>

                </select>
            </div>
            <div class="trial1">
                <select name="add_on" id="" class="input02">
                <option value="none" disabled selected>Choose Add On Services</option>
                    <option value="RMC Plant"<?php if($row['add_on_services']==='RMC Plant'){echo 'selected';} ?>>RMC Plant</option>
                    <option value="Foundation Work" <?php if($row['add_on_services']==='Foundation Work'){echo 'selected';} ?>>Piling Contract</option>
                    <option value="RMC Plant And Foundation Work" <?php if($row['add_on_services']==='RMC Plant And Foundation Work'){echo 'selected';} ?>>RMC Plant And Foundation Work</option>
                    <option value="None" <?php if($row['add_on_services']==='None'){echo 'selected';} ?>>None</option>
                </select>
            </div>
            <div class="trial1">
                <select name="rmc_type" id="" class="input02">
                <option value="none" disabled selected>Choose RMC Type If Any</option>
                <option value="Dedicated" <?php if($row['rmc_type']==='Dedicated'){ echo 'selected';} ?>>Dedicated</option>
                <option value="Commercial" <?php if($row['rmc_type']==='Commercial'){ echo 'selected';} ?>>Commercial</option>
                </select>
            </div>
            <div class="outer02">
            <div class="trial1">
                    <input type="text" placeholder="" name="rmc_location" value="<?php echo $row['rmc_location'] ?>" class="input02">
                    <label for="" class="placeholder2">RMC Location</label>
                </div>
                <div class="trial1">
                    <input type="text" placeholder="" name="rmc_pincode" value="<?php echo $row['rmc_pincode'] ?>" class="input02">
                    <label for="" class="placeholder2">RMC Pincode</label>
                </div>
            </div>

    <button class="epc-button" type="submit">Edit Profile Details</button>
        <br>
            </div>
    </form>
    <form action="bank_detail_edit.php"    method="POST" class="bill_info001" enctype="multipart/form-data">
    <div class="bill_contianer">
        <p>Edit Billing Detials</p>
        <a class="letterhead_caution">If Want to change the letter head upload it here</a>
         <div class="trial1">
            <input type="file" placeholder="" name="logo" class="input02">
            <label for="" class="placeholder2">Letter Head Header</label>
        </div>
        <div class="trial1">
            <input type="text" placeholder="" name="bank_name" value="<?php echo $row_bank['bank_name']  ?>" class="input02">
            <label for="" class="placeholder2">Bank Name</label>
        </div>
        <div class="trial1">
            <input type="text" name="acc_num"  value="<?php echo $row_bank['account_num']  ?>" placeholder="" class="input02">
            <label for="" class="placeholder2">Enter Bank Account Number</label>
        </div>
        <div class="trial1">
            <input type="text" name="ifsc" value="<?php echo $row_bank['ifsc_code'] ?>" placeholder="" class="input02">
            <label for="" class="placeholder2">IFSC Code</label>
        </div>
        <div class="trial1">
            <input type="text" name="branch" value="<?php echo $row_bank['branch'] ?>"  placeholder="" class="input02">
            <label for="" class="placeholder2"> Branch</label>
        </div>
        <div class="trial1">
            <select name="acc_type" id="" class="input02">
                <option value=""disabled selected>Choose Account Type</option>
                <option value="Current" <?php if($row_bank['account_type']==='Current'){ echo 'selected';} ?>>Current</option>
                <option value="Savings" <?php if($row_bank['account_type']==='Savings'){ echo 'selected';} ?>>Savings</option>
            </select>
        </div>
        <div class="trial1">
            <input type="text" name="company_name_bank" placeholder="" value="<?php echo $companyname001 ?>" class="input02">
            <label for="" class="placeholder2">Company name</label>
        </div>
        <button class="epc-button" type="submit">Submit</button>
        <br><br>

    </div>

    </div>
</body>
</html>