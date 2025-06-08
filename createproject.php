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

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    include "partials/_dbconnect.php";
    $projectname=$_POST['projectname'];
    $district=$_POST['district'];
    $state=$_POST['state'];
    $start_date=$_POST['start_date'];
    $end_date=$_POST['end_date'];
    $project_organization=$_POST['project_organization'];
    $project_type=$_POST['project_type'];
    $projectvalue=$_POST['projectvalue'];
    $unit=$_POST['unit'] ?? '';
    $projectcode=$_POST['projectcode'];

    $sql = "INSERT INTO `epcproject` (`projectcode`,`project_type`, `projectvalue`, `unit`, `companyname`, `projectname`, `district`, `state`, `start_date`, `end_date`, `project_organization`) 
    VALUES ('$projectcode','$project_type', '$projectvalue', '$unit', '$companyname001', '$projectname', '$district', '$state', '$start_date', '$end_date', '$project_organization')";
    $result = mysqli_query($conn, $sql);
    if($result){
        $showAlert=true;
    }
    else{
        $showError=true;
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
    <div class="add_fleet_btn_new" id="rentalclientbutton" >
<button class="generate-btn"> 
    <article class="article-wrapper" onclick="window.location.href='myprojects.php'" id="rentalclientbuttoncontainer"> 
  <div class="rounded-lg container-projectss ">
    </div>
    <div class="project-info">
      <div class="flex-pr">
        <div class="project-title text-nowrap">My Projects</div>
          <div class="project-hover">
            <svg style="color: black;" xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" color="black" stroke-linejoin="round" stroke-linecap="round" viewBox="0 0 24 24" stroke-width="2" fill="none" stroke="currentColor"><line y2="12" x2="19" y1="12" x1="5"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
            </div>
          </div>
          <div class="types">
        </div>
    </div>
</article>
    </button>

</div>



<form action="createproject.php" method="POST" autocomplete="off" class="outerform">
    <div class="epcprojectcontainer">
        <p class="headingpara">Create Project</p>
        <div class="trial1">
            <input type="text" placeholder="" name="projectcode" class="input02">
            <label for="" class="placeholder2">Project Code</label>
        </div>
        <div class="trial1">
        <select class="input02" name="project_type" id="">
            <option value="" disabled selected>Project Type</option>
            <option value="Urban Infra">Urban Infra</option>
            <option value="PipeLine">PipeLine</option>
            <option value="Marine">Marine</option>
            <option value="Road">Road</option>
            <option value="Bridge And Metro">Bridge And Metro</option>
            <option value="Plant">Plant</option>
            <option value="Refinery">Refinery</option>
            <option value="Others">Others</option>
        </select>
        </div>
        <div class="trial1">
            <input type="text" placeholder="" name="projectname" class="input02">
            <label for="" class="placeholder2">Project Name</label>
        </div>
        <div class="outer02">
        <div class="trial1">
            <input type="text" placeholder="" name="district" class="input02" required >
            <label for="" class="placeholder2">Project District</label>
        </div>
        <select name="state" id="project_state" class="input02" required >
    <option value="" disabled selected>Select Project State</option>
    <option value="Andhra Pradesh">Andhra Pradesh</option>
    <option value="Arunachal Pradesh">Arunachal Pradesh</option>
    <option value="Assam">Assam</option>
    <option value="Bihar">Bihar</option>
    <option value="Chhattisgarh">Chhattisgarh</option>
    <option value="Goa">Goa</option>
    <option value="Gujarat">Gujarat</option>
    <option value="Haryana">Haryana</option>
    <option value="Himachal Pradesh">Himachal Pradesh</option>
    <option value="Jharkhand">Jharkhand</option>
    <option value="Karnataka">Karnataka</option>
    <option value="Kerala">Kerala</option>
    <option value="Madhya Pradesh">Madhya Pradesh</option>
    <option value="Maharashtra">Maharashtra</option>
    <option value="Manipur">Manipur</option>
    <option value="Meghalaya">Meghalaya</option>
    <option value="Mizoram">Mizoram</option>
    <option value="Nagaland">Nagaland</option>
    <option value="Odisha">Odisha</option>
    <option value="Punjab">Punjab</option>
    <option value="Rajasthan">Rajasthan</option>
    <option value="Sikkim">Sikkim</option>
    <option value="Tamil Nadu">Tamil Nadu</option>
    <option value="Telangana">Telangana</option>
    <option value="Tripura">Tripura</option>
    <option value="Uttar Pradesh">Uttar Pradesh</option>
    <option value="Uttarakhand">Uttarakhand</option>
    <option value="West Bengal">West Bengal</option>
    <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
    <option value="Chandigarh">Chandigarh</option>
    <option value="Dadra and Nagar Haveli and Daman and Diu">Dadra and Nagar Haveli and Daman and Diu</option>
    <option value="Lakshadweep">Lakshadweep</option>
    <option value="Delhi">Delhi</option>
    <option value="Puducherry">Puducherry</option>
</select>

        </div>
        <div class="outer02">   
        <div class="trial1">
            <input type="month" placeholder="" name="start_date" class="input02">
            <label for="" class="placeholder2">Start Date</label>
        </div>

        <div class="trial1">
            <input type="month" placeholder="" name="end_date" class="input02">
            <label for="" class="placeholder2">Expected End Date</label>
        </div>

        </div>
        <div class="outer02">
            <div class="trial1">
                <input type="number" name="projectvalue" placeholder="" class="input02">
                <label for="" class="placeholder2">Project Value</label>
            </div>
            <select name="unit" id="" class="input02">
                <option value=""disabeled selected>Unit</option>
                <option value="lakh">Lakh</option>
                <option value="crore">Crore</option>
            </select>
        </div>
        <div class="trial1">
            <input type="text" placeholder="" name="project_organization" class="input02">
            <label for="" class="placeholder2">Project Organization</label>
        </div>
        <button class="epc-button">Submit</button>
    </div>
</form>
</body>
</html>