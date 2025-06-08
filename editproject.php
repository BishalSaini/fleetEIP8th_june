<?php
session_start();
$email = $_SESSION['email'];
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
elseif ($enterprise === 'admin') {
    $dashboard_url = 'news/admin/dashboard.php';
} 

else {
    $dashboard_url = '';
}
$showAlert = false;
$showError = false;

if(isset($_SESSION['error'])){
    $showError=true;
    unset($_SESSION['error']);
}

else if(isset($_SESSION['success'])){
    $showAlert=true;
    unset($_SESSION['success']);

}
$editid=$_GET['id'];
include "partials/_dbconnect.php";

$sql="SELECT * FROM `epcproject` where companyname='$companyname001' and id='$editid'";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include "partials/_dbconnect.php";
    
    // Assuming you have the project ID from the form or session
    $project_id = $_POST['project_id']; // Make sure to pass this ID in your form

    $projectname = $_POST['projectname'];
    $district = $_POST['district'];
    $state = $_POST['state'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $project_organization = $_POST['project_organization'];
    $project_type = $_POST['project_type'];
    $projectvalue = $_POST['projectvalue'];
    $unit = $_POST['unit'] ?? '';

    // Update query
    $sql = "UPDATE `epcproject` 
            SET `project_type` = '$project_type', 
                `projectvalue` = '$projectvalue', 
                `unit` = '$unit', 
                `companyname` = '$companyname001', 
                `projectname` = '$projectname', 
                `district` = '$district', 
                `state` = '$state', 
                `start_date` = '$start_date', 
                `end_date` = '$end_date', 
                `project_organization` = '$project_organization' 
            WHERE `id` = $project_id"; 

    $result = mysqli_query($conn, $sql);
    if ($result) {
        session_start();
        $_SESSION['success']='true';
        header("Location: editproject.php?id=$project_id");
        exit();
    } else {
        session_start();
        $_SESSION['error']='true';
        header("Location: editproject.php?id=$project_id");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="tiles.css">
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
            <!-- <li><a href="news/">News</a></li> -->
    
        <li><a href="logout.php">Log Out</a></li></ul>
        </div>
    </div> 
    <?php
if($showAlert){
    echo '<label>
    <input type="checkbox" class="alertCheckbox" autocomplete="off" />
    <div class="alert notice">
        <span class="alertClose">X</span>
        <span class="alertText">Success <br class="clear"/></span>
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


<form action="editproject.php?id=<?php echo $editid ?>" method="POST" autocomplete="off" class="outerform">
    <div class="epcprojectcontainer">
        <p class="headingpara">Create Project</p>
        <input type="hidden" name="project_id" value="<?php echo $editid ?>">
        <div class="trial1">
        <select class="input02" name="project_type" id="">
            <option value="" disabled selected>Project Type</option>
            <option <?php if($row['project_type']==='Urban Infra'){ echo 'selected';} ?> value="Urban Infra">Project Type : Urban Infra</option>
            <option <?php if($row['project_type']==='PipeLine'){ echo 'selected';} ?> value="PipeLine">Project Type : PipeLine</option>
            <option <?php if($row['project_type']==='Marine'){ echo 'selected';} ?> value="Marine">Project Type : Marine</option>
            <option <?php if($row['project_type']==='Road'){ echo 'selected';} ?> value="Road">Project Type : Road</option>
            <option <?php if($row['project_type']==='Bridge And Metro'){ echo 'selected';} ?> value="Bridge And Metro">Project Type : Bridge And Metro</option>
            <option <?php if($row['project_type']==='Plant'){ echo 'selected';} ?> value="Plant">Project Type : Plant</option>
            <option <?php if($row['project_type']==='Refinery'){ echo 'selected';} ?> value="Refinery">Project Type : Refinery</option>
            <option <?php if($row['project_type']==='Others'){ echo 'selected';} ?> value="Others">Project Type : Others</option>
        </select>
        </div>
        <div class="trial1">
            <input type="text" placeholder="" value="<?php echo $row['projectname'] ?>" name="projectname" class="input02">
            <label for="" class="placeholder2">Project Name</label>
        </div>
        <div class="outer02">
        <div class="trial1">
            <input type="text" placeholder="" value="<?php echo $row['district'] ?>" name="district" class="input02" required >
            <label for="" class="placeholder2">Project District</label>
        </div>
        <select name="state" id="project_state" class="input02" required >
    <option value="" disabled selected>Select Project State</option>
    <option <?php if ($row['state'] === 'Andhra Pradesh') { echo 'selected'; } ?> value="Andhra Pradesh">Andhra Pradesh</option>
<option <?php if ($row['state'] === 'Arunachal Pradesh') { echo 'selected'; } ?> value="Arunachal Pradesh">Arunachal Pradesh</option>
<option <?php if ($row['state'] === 'Assam') { echo 'selected'; } ?> value="Assam">Assam</option>
<option <?php if ($row['state'] === 'Bihar') { echo 'selected'; } ?> value="Bihar">Bihar</option>
<option <?php if ($row['state'] === 'Chhattisgarh') { echo 'selected'; } ?> value="Chhattisgarh">Chhattisgarh</option>
<option <?php if ($row['state'] === 'Goa') { echo 'selected'; } ?> value="Goa">Goa</option>
<option <?php if ($row['state'] === 'Gujarat') { echo 'selected'; } ?> value="Gujarat">Gujarat</option>
<option <?php if ($row['state'] === 'Haryana') { echo 'selected'; } ?> value="Haryana">Haryana</option>
<option <?php if ($row['state'] === 'Himachal Pradesh') { echo 'selected'; } ?> value="Himachal Pradesh">Himachal Pradesh</option>
<option <?php if ($row['state'] === 'Jharkhand') { echo 'selected'; } ?> value="Jharkhand">Jharkhand</option>
<option <?php if ($row['state'] === 'Karnataka') { echo 'selected'; } ?> value="Karnataka">Karnataka</option>
<option <?php if ($row['state'] === 'Kerala') { echo 'selected'; } ?> value="Kerala">Kerala</option>
<option <?php if ($row['state'] === 'Madhya Pradesh') { echo 'selected'; } ?> value="Madhya Pradesh">Madhya Pradesh</option>
<option <?php if ($row['state'] === 'Maharashtra') { echo 'selected'; } ?> value="Maharashtra">Maharashtra</option>
<option <?php if ($row['state'] === 'Manipur') { echo 'selected'; } ?> value="Manipur">Manipur</option>
<option <?php if ($row['state'] === 'Meghalaya') { echo 'selected'; } ?> value="Meghalaya">Meghalaya</option>
<option <?php if ($row['state'] === 'Mizoram') { echo 'selected'; } ?> value="Mizoram">Mizoram</option>
<option <?php if ($row['state'] === 'Nagaland') { echo 'selected'; } ?> value="Nagaland">Nagaland</option>
<option <?php if ($row['state'] === 'Odisha') { echo 'selected'; } ?> value="Odisha">Odisha</option>
<option <?php if ($row['state'] === 'Punjab') { echo 'selected'; } ?> value="Punjab">Punjab</option>
<option <?php if ($row['state'] === 'Rajasthan') { echo 'selected'; } ?> value="Rajasthan">Rajasthan</option>
<option <?php if ($row['state'] === 'Sikkim') { echo 'selected'; } ?> value="Sikkim">Sikkim</option>
<option <?php if ($row['state'] === 'Tamil Nadu') { echo 'selected'; } ?> value="Tamil Nadu">Tamil Nadu</option>
<option <?php if ($row['state'] === 'Telangana') { echo 'selected'; } ?> value="Telangana">Telangana</option>
<option <?php if ($row['state'] === 'Tripura') { echo 'selected'; } ?> value="Tripura">Tripura</option>
<option <?php if ($row['state'] === 'Uttar Pradesh') { echo 'selected'; } ?> value="Uttar Pradesh">Uttar Pradesh</option>
<option <?php if ($row['state'] === 'Uttarakhand') { echo 'selected'; } ?> value="Uttarakhand">Uttarakhand</option>
<option <?php if ($row['state'] === 'West Bengal') { echo 'selected'; } ?> value="West Bengal">West Bengal</option>
<option <?php if ($row['state'] === 'Andaman and Nicobar Islands') { echo 'selected'; } ?> value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
<option <?php if ($row['state'] === 'Chandigarh') { echo 'selected'; } ?> value="Chandigarh">Chandigarh</option>
<option <?php if ($row['state'] === 'Dadra and Nagar Haveli and Daman and Diu') { echo 'selected'; } ?> value="Dadra and Nagar Haveli and Daman and Diu">Dadra and Nagar Haveli and Daman and Diu</option>
<option <?php if ($row['state'] === 'Lakshadweep') { echo 'selected'; } ?> value="Lakshadweep">Lakshadweep</option>
<option <?php if ($row['state'] === 'Delhi') { echo 'selected'; } ?> value="Delhi">Delhi</option>
<option <?php if ($row['state'] === 'Puducherry') { echo 'selected'; } ?> value="Puducherry">Puducherry</option>
</select>

        </div>
        <div class="outer02">   
        <div class="trial1">
            <input type="month" placeholder="" value="<?php echo $row['start_date'] ?>" name="start_date" class="input02">
            <label for="" class="placeholder2">Start Date</label>
        </div>

        <div class="trial1">
            <input type="month" placeholder="" value="<?php echo $row['end_date'] ?>" name="end_date" class="input02">
            <label for="" class="placeholder2">Expected End Date</label>
        </div>

        </div>
        <div class="outer02">
            <div class="trial1">
                <input type="number" value="<?php echo $row['projectvalue'] ?>" name="projectvalue" placeholder="" class="input02">
                <label for="" class="placeholder2">Project Value</label>
            </div>
            <select name="unit" id="" class="input02">
                <option value=""disabeled selected>Unit</option>
                <option <?php if($row['unit']==='lakh'){echo 'selected';} ?> value="lakh">Lakh</option>
                <option <?php if($row['unit']==='crore'){echo 'selected';} ?> value="crore">Crore</option>
            </select>
        </div>
        <div class="trial1">
            <input type="text" value="<?php echo $row['project_organization'] ?>" placeholder="" name="project_organization" class="input02">
            <label for="" class="placeholder2">Project Organization</label>
        </div>
        <button class="epc-button">Submit</button>
    </div>
</form>
</body>
</html>