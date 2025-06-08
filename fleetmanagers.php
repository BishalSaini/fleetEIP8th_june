<?php
include_once 'partials/_dbconnect.php'; // Include the database connection file
session_start();
// $email = $_SESSION["email"];
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
$enterprise=$_SESSION['enterprise'];

$showAlert=false;
$showError=false;
$showAlert_addop=false;
$showError_addop=false;

if(isset($_SESSION['success']))
{
    $showAlert_addop=true;
    unset($_SESSION['success']);
}
else if (isset($_SESSION['error_message'])){
    $showError=true;
    unset($_SESSION['error_message']);
}



$sql = "SELECT DISTINCT assetcode FROM fleet1 WHERE companyname = '$companyname001'";
$result = mysqli_query($conn, $sql);

// Check if query was successful
if ($result) {
    $assetCodes = [];
    // Fetch asset codes and store in an array
    while ($row = mysqli_fetch_assoc($result)) {
        $assetCodes[] = $row['assetcode'];
    }
}


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

?>

<style>
  <?php include "style.css" 
  ?>
</style>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST"){
$operator_fname = $_POST["firstname"];
$designation=$_POST['designation'];
$companyname0 = $_POST["companyname"];
$current_company_strt = $_POST["strt_date"];
$fleet_category=$_POST['fleet_category'];
$fleet_type = $_POST["type"];
$fleet_capacity = $_POST["fleet_capacity"];
$salary=$_POST['salary'];
$pf=$_POST['pf'];
$esic=$_POST['esic'];
// $travel=$_POST['travel'];
// $accomodation=$_POST['accomodation'];
// $food=$_POST['food'];
// $bonus=$_POST['bonus'];
$driving_license = $_POST["license"];
$issued_date = $_POST["license_issueddate"];
$dl_expiry=$_POST['dl_expiry'];
$aadhar_card = $_POST["aadhar_card_number"];
$pancard_number=$_POST['pancard_number'];
$mob_no = $_POST["mobile_no"];
$address = $_POST["address"];
$pincode = $_POST["pincode"];
$ref1 = $_POST["reference1"];
$relation_ref1 = $_POST["reference1_relation"];
$ref1_mobile=$_POST['ref1_mobile'];
$ref2 = $_POST["reference2"];
$relation_ref2 = $_POST["reference2_relation"];
$ref2_mobile=$_POST['ref2_mobile'];
$previous_company = $_POST["previous_company"];
$previous_company_strt = $_POST["strt_date_previous_company"];
$previous_company_end = $_POST["end_date_previous_company"];
$crnt_status=$_POST['current_status'];
$assetCode = !empty($_POST["assetCode"]) ? $_POST["assetCode"] : NULL;

$dl_image = $_FILES['dl_license_image']['name'];
$temp_file_path = $_FILES['dl_license_image']['tmp_name'];
$random_string_dl = bin2hex(random_bytes(8)); // Generates an 8-byte random string
$unique_filename_dl = $random_string_dl . '_' . $dl_image;
$folder1 = 'img/' . $unique_filename_dl;
move_uploaded_file($temp_file_path, $folder1);

$aadhar_image = $_FILES['upload_aadhar']['name'];
$temp_file_path = $_FILES['upload_aadhar']['tmp_name'];
$random_string_aadhar = bin2hex(random_bytes(8)); // Generates an 8-byte random string
$unique_filename_aadhar = $random_string_aadhar . '_' . $aadhar_image;
$folder2 = 'img/' . $unique_filename_aadhar;
move_uploaded_file($temp_file_path, $folder2);

$pan_image = $_FILES['pan_image']['name'];
$temp_file_path = $_FILES['pan_image']['tmp_name'];
$random_string = bin2hex(random_bytes(8)); // Generates an 8-byte random string
$unique_filename = $random_string . '_' . $pan_image;
$folder3 = 'img/' . $unique_filename;
move_uploaded_file($temp_file_path, $folder3);


$sql_insert="INSERT INTO `myoperators` (`upload_dl`,`upload_aadharcard`,`upload_pancard`,`operator_fname`, `designation`, `company_name`, `startdate_crnt_company`, `fleet_category`, `fleet_Type`, `cap_metric_ton`, `salary`, `pf_deduction`, `esic`, `driving_license`, `issued_date`, `dl_expiry`, `aadhar_card`, `pancard`, `mobile_number`, `address`, `pincode`, `reference1`, `relation_refernce1`, `reference1_mobile`, `reference2`, `relation_refernce2`, `reference2_mobile`, `previous_company`, `startdate_previous_company`, `enddate_previous_company`, `current_status`, `driving_asset_code`)
 VALUES ('$unique_filename_dl','$unique_filename_aadhar','$unique_filename','$operator_fname', '$designation', '$companyname0', '$current_company_strt', '$fleet_category', '$fleet_type', '$fleet_capacity', '$salary', '$pf', '$esic','$driving_license', '$issued_date', '$dl_expiry', '$aadhar_card', '$pancard_number', '$mob_no', '$address', '$pincode', '$ref1', '$relation_ref1', '$ref1_mobile', '$ref2', '$relation_ref2', '$ref2_mobile', '$previous_company', '$previous_company_strt', '$previous_company_end', '$crnt_status', '$assetCode')";
    $result = mysqli_query($conn, $sql_insert);
    if($result){
        $showAlert_addop=true;
    }
    else{
        $showError_addop=true;
    }




    

    





}
?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['rateing_op'])){
    include_once 'partials/_dbconnect.php'; // Include the database connection file
    $license=$_POST['license_op'];
    $rating=$_POST['operator_rate'];
    $feedback_operator=$_POST['feed'];
    $sql_rating="INSERT INTO `operator_rating` ( `operator_license`, `operator_rating`, `feedback`) 
    VALUES ( '$license', '$rating', '$feedback_operator') ";
        $result = mysqli_query($conn, $sql_rating);
        if($result){
    $showAlert=true;
        }
        else{
            $showError=true;
        }

}
?>
<?php
$sql_notification_count_expiry="SELECT COUNT(sno) AS total_notification FROM `dl_expiry` where company_name='$companyname001'";
$result_count=mysqli_query($conn,$sql_notification_count_expiry);
$row_count_noti= mysqli_fetch_assoc($result_count);
$count_of_notification=$row_count_noti['total_notification']
?>
<?php
$sql_noti="SELECT * FROM `dl_expiry` WHERE `company_name`='$companyname001'";
$result_noti=mysqli_query($conn,$sql_noti);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">      <link rel="icon" href="favicon.jpg" type="image/x-icon">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Fleet Managers</title>
    <link rel="stylesheet" href="tiles.css">

    <script src="main.js"></script>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <link rel="stylesheet" href="style.css">
    <style>
                .generate-btn{
            border:none;
            background-color:white;
            /* border:1px solid red; */
            margin-top:70px;
        }
        .project-info{
            width: 250px;
            height:50px!important;
        }
        .article-wrapper{
            width: 270px;
        }

    </style>

</head>
<body>
    <div class="navbar1">
    <div class="logo_fleet">
    <img src="logo_fe.png" alt="FLEET EIP" onclick="window.location.href='<?php echo $dashboard_url ?>'">
</div>

        <div class="iconcontainer">
        <ul>
        <li><a href="<?php echo $dashboard_url ?>">Dashboard</a></li>
            <li><a href="news/">News</a></li>
            <li><a href="logout.php">Log Out</a></li>
            <li <?php if($count_of_notification == 0) echo 'style="display: none;"' ?>><div class="alerts" onclick="dl_expirynotification()" ><?php echo $count_of_notification ?> Alerts</div></li>
       
        </ul>

        </div>
    </div> 
    <?php
if($showAlert){
    echo  '<label>
    <input type="checkbox" class="alertCheckbox" autocomplete="off" />
    <div class="alert notice">
      <span class="alertClose">X</span>
      <span class="alertText_addfleet"><b>Success!</b>Rating Added Successfully!
          <br class="clear"/></span>
    </div>
  </label>';
 }
 if($showError){
    echo '<label>
    <input type="checkbox" class="alertCheckbox" autocomplete="off" />
    <div class="alert error">
      <span class="alertClose">X</span>
      <span class="alertText">Something Went Wrong
          <br class="clear"/></span>
    </div>
  </label>';
 }
 if($showAlert_addop){
    echo  '<label>
    <input type="checkbox" class="alertCheckbox" autocomplete="off" />
    <div class="alert notice">
      <span class="alertClose">X</span>
      <span class="alertText_addfleet"><b>Success!</b>
          <br class="clear"/></span>
    </div>
  </label>';
 }
 if($showError_addop){
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
<div class="view_op_btn">
<button class="generate-btn"> 
    <article class="article-wrapper" onclick="addfleetnew()" > 
  <div class="rounded-lg container-projectss ">
    </div>
    <div class="project-info" onclick="view_op_screen()">
      <div class="flex-pr">
        <div class="project-title text-nowrap">Add Fleet Manager</div>
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
<!-- <div class="view_op_btn"><button class="add_fleet_manager_btn" onclick="view_op_screen()">Add Fleet Manager</button><button id="search_op" class="add_fleet_manager_btn">Search Operator</button></div> -->
<div class="modal_new_fleetadd" id="addop_new">
<form action="view_operator.php" class="addoperator_form" method="POST" autocomplete="off" enctype="multipart/form-data">
        <div class="addoperator_container">
        <div class="add-fleet"><p class="add_rental_fleet">Add Fleet Manager</p><i onclick="window.location.href = 'view_operator.php';" class="fa-solid fa-xmark"></i></div>
        <div class="outer02">
        <div class="trial1">
        <input type="text" name="firstname" placeholder="" class="input02">
        <label class="placeholder2">Fleet Manager Name</label>
        </div>
        <div class="trial1">
            <select name="designation" id="" class="input02">
                <option value="none"disabled selected>Choose Designation</option>
                <option value="Operator">Operator</option>
                <option value="Helper">Helper</option>
                <option value="Rigger">Rigger</option>
            </select>
        </div>
        </div>
        <div class="outer02">
        <div class="trial1">
        <input type="text" name="companyname" value="<?php echo $companyname001 ?>" placeholder="" class="input02" readonly>
        <label class="placeholder2">Company Name</label>
        </div>
        <div class="trial1">
        <input type="date" name="strt_date" placeholder="" class="input02">
        <label class="placeholder2">Started From</label>
        </div></div>
        <div class="outer02">
        <div class="trial1">
        <select class="input02" name="fleet_category" id="oem_fleet_type" onchange="purchase_option()" required>
            <option value="" disabled selected>Select Fleet Category</option>
            <option value="Aerial Work Platform">Aerial Work Platform</option>
            <option value="Concrete Equipment">Concrete Equipment</option>
            <option value="EarthMovers and Road Equipments">EarthMovers and Road Equipments</option>
            <!-- <option value="aerial_work_platform">Aerial Work Platform</option> -->
            <option value="Material Handling Equipments">Material Handling Equipments</option>
            <option value="Ground Engineering Equipments">Ground Engineering Equipments</option>
            <option value="Trailor and Truck">Trailor and Truck</option>
            <option value="Generator and Lighting">Generator and Lighting</option>
        </select>
        </div>
        <div class="trial1">
        <select class="input02" name="type" id="fleet_sub_type" onchange="crawler_options()" required>
            <option value="" disabled selected>Select Fleet Type</option>
            <option value="Self Propelled Articulated Boomlift"class="awp_options"  id="aerial_work_platform_option1">Self Propelled Articulated Boomlift</option>
            <option value="Scissor Lift Diesel" class="awp_options" id="aerial_work_platform_option2">Scissor Lift Diesel</option>
            <option value="Scissor Lift Electric"class="awp_options"  id="aerial_work_platform_option3">Scissor Lift Electric</option>
            <option value="Spider Lift"class="awp_options"  id="aerial_work_platform_option4">Spider Lift</option>
            <option value="Self Propelled Straight Boomlift"class="awp_options"  id="aerial_work_platform_option5">Self Propelled Straight Boomlift</option>
            <option value="Truck Mounted Articulated Boomlift"class="awp_options"  id="aerial_work_platform_option6">Truck Mounted Articulated Boomlift</option>
            <option value="Truck Mounted Straight Boomlift"class="awp_options"  id="aerial_work_platform_option7">Truck Mounted Straight Boomlift</option>
            <option value="Batching Plant"class="cq_options" id="concrete_equipment_option1">Batching Plant</option>
            <option value="Self Loading Mixer"class="cq_options" id="">Self Loading Mixer</option>
            <option value="Concrete Boom Placer"class="cq_options" id="concrete_equipment_option2">Concrete Boom Placer</option>
            <option value="Concrete Pump"class="cq_options" id="concrete_equipment_option3">Concrete Pump</option>
            <option value="Moli Pump"class="cq_options" id="concrete_equipment_option4">Moli Pump</option>
            <option value="Mobile Batching Plant"class="cq_options" id="concrete_equipment_option5">Mobile Batching Plant</option>
            <option value="Static Boom Placer"class="cq_options" id="concrete_equipment_option6">Static Boom Placer</option>
            <option value="Transit Mixer"class="cq_options" id="concrete_equipment_option7">Transit Mixer</option>
            <option value="Baby Roller" class="earthmover_options" id="earthmovers_option1">Baby Roller</option>
            <option value="Backhoe Loader" class="earthmover_options" id="earthmovers_option2">Backhoe Loader</option>
            <option value="Bulldozer" class="earthmover_options" id="earthmovers_option3">Bulldozer</option>
            <option value="Excavator" class="earthmover_options" id="earthmovers_option4">Excavator</option>
            <option value="Milling Machine" class="earthmover_options" id="earthmovers_option5">Milling Machine</option>
            <option value="Motor Grader" class="earthmover_options" id="earthmovers_option6">Motor Grader</option>
            <option value="Pneumatic Tyre Roller" class="earthmover_options" id="earthmovers_option7">Pneumatic Tyre Roller</option>
            <option value="Single Drum Roller" class="earthmover_options" id="earthmovers_option8">Single Drum Roller</option>
            <option value="Skid Loader" class="earthmover_options" id="earthmovers_option9">Skid Loader</option>
            <option value="Slip Form Paver" class="earthmover_options" id="earthmovers_option10">Slip Form Paver</option>
            <option value="Soil Compactor" class="earthmover_options" id="earthmovers_option11">Soil Compactor</option>
            <option value="Tandem Roller" class="earthmover_options" id="earthmovers_option12">Tandem Roller</option>
            <option value="Vibratory Roller" class="earthmover_options" id="earthmovers_option13">Vibratory Roller</option>
            <option value="Wheeled Excavator" class="earthmover_options" id="earthmovers_option14">Wheeled Excavator</option>
            <option value="Wheeled Loader" class="earthmover_options" id="earthmovers_option15">Wheeled Loader</option>
            <option id="mhe_option1"  class="mhe_options" value="Fixed Tower Crane">Fixed Tower Crane</option>
            <option id="mhe_option2" class="mhe_options" value="Fork Lift Diesel">Fork Lift Diesel</option>
            <option id="mhe_option3" class="mhe_options" value="Fork Lift Electric">Fork Lift Electric</option>
            <option id="mhe_option4" class="mhe_options" value="Hammerhead Tower Crane">Hammerhead Tower Crane</option>
            <option id="mhe_option5" class="mhe_options" value="Hydraulic Crawler Crane">Hydraulic Crawler Crane</option>
            <option id="mhe_option6" class="mhe_options" value="Luffing Jib Tower Crane">Luffing Jib Tower Crane</option>
            <option id="mhe_option7" class="mhe_options" value="Mechanical Crawler Crane">Mechanical Crawler Crane</option>
            <option id="mhe_option8" class="mhe_options" value="Pick and Carry Crane">Pick and Carry Crane</option>
            <option id="mhe_option9" class="mhe_options" value="Reach Stacker">Reach Stacker</option>
            <option id="mhe_option10" class="mhe_options" value="Rough Terrain Crane">Rough Terrain Crane</option>
            <option id="mhe_option11" class="mhe_options" value="Telehandler">Telehandler</option>
            <option id="mhe_option12" class="mhe_options" value="Telescopic Crawler Crane">Telescopic Crawler Crane</option>
            <option id="mhe_option13" class="mhe_options" value="Telescopic Mobile Crane">Telescopic Mobile Crane</option>
            <option id="mhe_option14" class="mhe_options" value="All Terrain Mobile Crane">All Terrain Mobile Crane</option>
            <option id="mhe_option15" class="mhe_options" value="Self Loading Truck Crane">Self Loading Truck Crane</option>

            <option id="ground_engineering_equipment_option1" class="gee_options" value="Hydraulic Drilling Rig">Hydraulic Drilling Rig</option>
            <option id="ground_engineering_equipment_option2" class="gee_options" value="Rotary Drilling Rig">Rotary Drilling Rig</option>
            <option id="ground_engineering_equipment_option3" class="gee_options" value="Vibro Hammer">Vibro Hammer</option>
            <option  id="trailor_option1" class="trailor_options" value="Dumper">Dumper</option>
            <option  id="trailor_option2" class="trailor_options" value="Truck">Truck</option>
            <option  id="trailor_option3" class="trailor_options" value="Water Tanker">Water Tanker</option>
            <option id="trailor_option4"  class="trailor_options" value="Low Bed">Low Bed</option>
            <option id="trailor_option5"  class="trailor_options" value="Semi Low Bed">Semi Low Bed</option>
            <option  id="trailor_option6" class="trailor_options" value="Flatbed">Flatbed</option>
            <option  id="trailor_option7" class="trailor_options" value="Hydraulic Axle">Hydraulic Axle</option>
            <option id="generator_option1" class="generator_options" value="Silent Diesel Generator">Silent Diesel Generator</option>
            <option id="generator_option2" class="generator_options" value="Mobile Light Tower">Mobile Light Tower</option>
            <option id="generator_option3" class="generator_options" value="Diesel Generator">Diesel Generator</option>
        </select>
        </div>

        <div class="trial1">
        <input type="text" name="fleet_capacity" placeholder="" class="input02">
        <label class="placeholder2">Capacity In Metric Ton</label>
        </div>
        </div>
        <div class="outer02">
            <div class="trial1">
            <input type="text" placeholder="" name="salary" class="input02">
            <label for="" class="placeholder2">Salary</label>
            </div>
            <div class="trial1">
                <select name="pf" id="" class="input02">
                    <option value="none" disabled selected>Choose PF Deduction</option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                </select>
            </div>
            <div class="trial1">
                <select name="esic" id="" class="input02">
                    <option value="none">ESIC Deduction?</option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                </select>
            </div>
        </div>
        <!-- <div class="outer02">
        <div class="trial1">
            <input type="text" name="travel" placeholder="" class="input02">
            <label for="" class="placeholder2">Travelling Allowance</label>
        </div>
        <div class="trial1">
            <input type="text" name="accomodation" placeholder="" class="input02">
            <label for="" class="placeholder2">Room Allowance</label>
        </div>
        <div class="trial1">
            <input type="text" name="food" placeholder="" class="input02">
            <label for="" class="placeholder2">Food Allowance</label>
        </div>
        <div class="trial1">
            <input type="text" name="bonus" placeholder="" class="input02">
            <label for="" class="placeholder2">Bonus</label>
        </div>
        </div> -->
        <div class="outer02">
        <div class="trial1">
        <input type="text" name="license" placeholder="" class="input02">
        <label class="placeholder2">Driving License</label>
        </div>
        <div class="trial1">
        <input type="date" name="license_issueddate" placeholder="" class="input02">
        <label class="placeholder2">Issued Date</label>
        </div>
        <div class="trial1">
        <input type="date" name="dl_expiry" placeholder="" class="input02">
        <label class="placeholder2">Expiry Date</label>
        </div>
        <div class="trial1">
            <input type="file" name="dl_license_image" placeholder="" class="input02">
            <label for="" class="placeholder2">Upload Driving License</label>
        </div>
        </div>
        <div class="outer02">
        <div class="trial1">
        <input type="text" name="aadhar_card_number" placeholder="" class="input02">
        <label class="placeholder2">Aadhar Card Number</label>
        </div>
        <div class="trial1">
            <input type="file" name="upload_aadhar" placeholder="" class="input02">
            <label for="" class="placeholder2">Upload Aadhar Card</label>
        </div>
        </div>
        <div class="outer02">
            <div class="trial1">
                <input type="text" name="pancard_number" placeholder="" class="input02">
                <label for="" class="placeholder2">Pancard Number</label>
            </div>
            <div class="trial1">
                <input type="file" placeholder="" name="pan_image" class="input02">
                <label for="" class="placeholder2">Upload Pancard</label>
            </div>
        </div>
        <div class="outer02">
        <div class="trial1">
        <input type="text" name="mobile_no" placeholder="" class="input02">
        <label class="placeholder2">Mobile Number</label>
        </div>
        <div class="trial1">
        <input type="text" name="address" placeholder="" class="input02">
        <label class="placeholder2">Address</label>
        </div>
        <div class="trial1">
        <input type="text" name="pincode" placeholder="" class="input02">
        <label class="placeholder2">Pincode</label>
        </div>
        </div>
        <div class="outer02">
        <div class="trial1">
        <input type="text" name="reference1" placeholder="" class="input02">
        <label class="placeholder2">Reference 1</label>
        </div> 
        <div class="trial1">
        <select name="reference1_relation" id="" class="input02">
            <option value=""disabled selected>Relation With Reference</option>
            <option value="mother">Mother</option>
            <option value="father">Father</option>
            <option value="brother">Brother</option>
            <option value="sister">Sister</option>
            <option value="friend">Friend</option>
        </select>
        </div> 
        <div class="trial1">
            <input type="text" name="ref1_mobile" placeholder="" class="input02">
            <label for="" class="placeholder2">Reference 1 Mobile Number</label>
        </div>
        </div>
        
        <div class="outer02">
        <div class="trial1">
        <input type="text" name="reference2" placeholder="" class="input02">
        <label class="placeholder2">Reference 2</label>
        </div> 
        <div class="trial1">
         
        <select name="reference2_relation" id="" class="input02">
            <option value=""disabled selected>Relation With Reference</option>
            <option value="mother">Mother</option>
            <option value="father">Father</option>
            <option value="brother">Brother</option>
            <option value="sister">Sister</option>
            <option value="friend">Friend</option>
        </select>
        </div>
        <div class="trial1">
            <input type="text" name="ref2_mobile" placeholder="" class="input02">
            <label for="" class="placeholder2">Reference 2 Contact Number</label>
        </div>
        </div>
    <div class="outer02">
        <div class="trial1">
        <input type="text" name="previous_company" placeholder="" class="input02">
        <label class="placeholder2">Previous Company</label>
        </div> 
        <div class="trial1">
        <input type="date" name="strt_date_previous_company" placeholder="" class="input02">
        <label class="placeholder2">Started From</label>
        </div>
        <div class="trial1">
        <input type="date" name="end_date_previous_company" placeholder="" class="input02">
        <label class="placeholder2">End Date</label>
        </div>
    </div>
        <!-- <div class="trial1">
        <select name="skill_set" id="" class="input02">
            <option value="" disabled selected>Skill Set</option>
            <option value="Altitude">Altitude</option>
            <option value="Co-ordination">Co-ordination</option>
            <option value="Maintenance">Maintenance</option>
        </select>
        </div>
        <div class="trial1" >
        <select name="language" class="input02">
        <option value="" disabled selected>Select Language</option>
        <option value="Assamese">Assamese</option>
        <option value="Bengali">Bengali</option>
        <option value="English">English</option>
        <option value="Gujarati">Gujarati</option>
        <option value="Hindi">Hindi</option>
        <option value="Kannada">Kannada</option>
        <option value="Kashmiri">Kashmiri</option>
        <option value="Konkani">Konkani</option>
        <option value="Malayalam">Malayalam</option>
        <option value="Manipuri">Manipuri</option>
        <option value="Marathi">Marathi</option>
        <option value="Nepali">Nepali</option>
        <option value="Odia">Odia</option>
        <option value="Punjabi">Punjabi</option>
        <option value="Sanskrit">Sanskrit</option>
        <option value="Sindhi">Sindhi</option>
        <option value="Tamil">Tamil</option>
        <option value="Telugu">Telugu</option>
        <option value="Urdu">Urdu</option>
        <option value="Other">Other</option>
    </select>
        </div> -->
    <div class="trial1">
    <select name="current_status" id="operator_status" class="input02" onchange="idlefunction()" required>
        <option value="" disabled selected >Choose Operator Status</option>
        <option value="idle">Idle</option>
        <option value="working">Working</option>
    </select>
    </div>
    <div class="trial1" id="asset_code">
    <select name="assetCode" id="" class="input02">
        <option value="none" disabled selected>Choose Operator Driving Asset Code</option>
        <?php
        // // Display the asset codes with additional details
        // if (!empty($assetCodes)) {
        //     foreach ($assetCodes as $code => $details) {
        //         // Assuming $details is an associative array with make, model, YOM, and capacity
        //         echo '<option value="' . $code . '">' . 
        //              $code . ' - ' . 
        //              $details['make'] . ', ' . 
        //              $details['model'] . ', ' . 
        //              $details['yom'] . ', ' . 
        //              $details['capacity'] . 
        //              '</option>';
        //     }
        // } else {
        //     echo '<option value="">No asset codes found</option>';
        // }
        $asset_code_selection = "SELECT * FROM `fleet1` WHERE `companyname`='$companyname001'";
$result_asset_code = mysqli_query($conn, $asset_code_selection);


        while ($row_asset_code2 = mysqli_fetch_assoc($result_asset_code)) {
            echo '<option value="' . $row_asset_code2['assetcode'] . '">' . $row_asset_code2['assetcode'] . " (" . $row_asset_code2['sub_type'] . " " . $row_asset_code2['make'] . " " . $row_asset_code2['model'] ." " . $row_asset_code2['yom'] ." " . $row_asset_code2['capacity'] . " " . $row_asset_code2['unit'] .")" . '</option>';
        }

        ?>
    </select>
</div>
     
    <button class="epc-button" type="submit">Add Operator</button>
    <br>

    </div>
    
</form>
<br><br>


</div>

<div class="chart_outer_cont">

    <div class="chartdatacontainer">
<div class="container12345" >
<div id="container" class="center-block view_operator_container"></div>
    
</div>
<?php
$sql_idle = "SELECT fleet_category, COUNT(*) AS working_operator_count 
FROM myoperators 
WHERE company_name='$companyname001' 
AND current_status='working' 
GROUP BY fleet_category";    
$result02 = mysqli_query($conn, $sql_idle);
    ?>
    <table class="idleoperator_table">
        <tr>
            <th> Working Managers</th>
        </tr>
        
        <?php
        while ($row = mysqli_fetch_assoc($result02)) {
            echo '<tr style="margin-top: 5px;">'; // Add top margin style to table rows
            echo '<td style="font-weight: 200;">'; // Add inline style for bold text
            echo '◍ '. $row["fleet_category"] . " - " . $row["working_operator_count"] . "<br>";
            echo '</td>';
            echo '</tr>';
        }
        ?>
    </table>
    <!-- <a class='btn_operator'  href='rate_operator.php?id=" . $row['id'] .  "'>Rating </a> -->

    <?php
$sql_idle2 = "SELECT fleet_category, COUNT(*) AS idle_operator_count 
FROM myoperators 
WHERE company_name='$companyname001' 
AND current_status='idle' 
GROUP BY fleet_category";    
$result02 = mysqli_query($conn, $sql_idle2);
    ?>
    <table class="idleoperator_table">
        <tr>
            <th> Idle Managers</th>
        </tr>
        
        <?php
        while ($row = mysqli_fetch_assoc($result02)) {
            echo '<tr style="margin-top: 5px;">'; // Add top margin style to table rows
            echo '<td style="font-weight: 100;">'; // Add inline style for bold text
            echo '◍ '. $row["fleet_category"] . " - " . $row["idle_operator_count"] . "<br>";
            echo '</td>';
            echo '</tr>';
        }
        ?>
    </table>
</div>
    </div>

    <div class="filters">
    <p>Apply Filter :</p>
    <form action="filteredoperator.php" method="GET">
        <select name="filtertype" id="filterselect" class="filter_button" required>
            <option value="" disabled selected>Select Filter</option>
            <option value="Idle">Idle </option>
            <option value="Working">Working </option>
        </select>
        <button  id="operatorfilterbutton" class="filter_button">Submit</button>
    </form>
</div>

        <table class="members_table">           
            <tr>
        <?php
             
     
        $result = mysqli_query($conn, "SELECT * FROM myoperators WHERE company_name='$companyname001'");
        $loop_count = 1;

        while ($row = mysqli_fetch_assoc($result)) { 
            // Display member information within a <td>
            echo '<td>';
            echo '<div class="viewfleet_outer">';
            echo '<div class="fleetcard_operator">';
            echo '<img src="fleet_manager.jpg">';  
            // echo '<h2 class="fontasset"><b>' . $row['assetcode'] . '</b></h2>';
            echo '</div>';
            echo '<div class="content">';
            // echo '<p>‣ Assetcode:' . $row['assetcode'] . '</p>';
            echo '<p><strong>' . $row['designation'] . ':</strong> ' . $row['operator_fname'] . '</p>';
                echo '<p><strong>Fleet Type:</strong> ' . $row['fleet_Type'] . '</p>';
            echo '<p><strong>Capacity:</strong> ' . $row['cap_metric_ton'] . '</p>';
            echo '<p><strong>Driving License:</strong> ' . $row['driving_license'] . '</p>';
            echo '<p><strong>Current Status:</strong> ' . $row['current_status'] . '</p>';
            echo '<p><strong>Driving Asset Code:</strong> ' . $row['driving_asset_code'] . '</p>';
                        
            echo'</div>';

            echo'<div class="btn01">';
            echo '<div class="viewbtn">';
            echo "
            <a class='btn_operator' href='view_operator_additionalinfo.php?id=" . $row['id'] .  "'>View </a>
            </div>";
            echo '<div class="delbtn">';
            echo "
            <a class='btn_operator' href='deleteoperator.php?id=" . $row['id'] . "' onclick='return confirmDelete();'>Delete</a>
            </div>";
                        echo "<a class='btn_operator' id='ratingbutton' onclick='ratingoperator(".$row['driving_license'].")'>Rate</a></div>";            

            echo '</div>';
            echo'</div>';
            
            echo '</div>';
            echo'<br>';

           
            echo '</div>';
            echo '<br>';
            ?>
                <div class="notification_background" id="notification_bg">
                <div class="noti_outer">
                <div class="closeall" onclick="close_all_notification_dl('<?php echo $companyname001 ?>')"><i class="fa-solid fa-xmark cross_symbol"></i>  Close All</div>

                <?php
        while($row_noti_content = mysqli_fetch_assoc($result_noti) ){
    ?>
    <div class="noti_container">
        <div class="noti_content_main">
            <div class="content_holder">
        <?php 

echo "Driving License Of " . $row_noti_content['driver_name'] . "<br>";
echo "Expires in " . $row_noti_content['days_left'] . " days" . "<br>";
?>
</div>
<a onclick="del_notification_dl(<?php echo $row_noti_content['sno']; ?>)" id="del_notification"><i class="fa-solid fa-xmark"></i></a>          


        </div>
    </div>
    
    <?php
}

?>

                </div>
                </div>

            <div id="rate_operator" class="ratingoperator">
            <div class="ratingcontent">
                <form action="view_operator.php" method="POST" class="rating_operator_form">
                <div class="ratingcontentinner">
                    <div class="trial1">
                        <input type="text" name="license_op" placeholder="" value="<?php echo $row['driving_license'] ?>" class="input02" readonly>
                        <label for="" class="placeholder2">Driving License Number</label>
                    </div>
                    <div class="trial1">
                        <select name="operator_rate" id="" class="input02">
                        <option value="None"disabled selected>Rate Overall Performance of Operator </option>
                        <option value="1">★</option>
                        <option value="2">★★</option>
                        <option value="3">★★★</option>
                        <option value="4">★★★★</option>
                        <option value="5">★★★★★</option>
            </select>
                    </div>
            <div class="trial1">
            <textarea type="text" name='feed' id='feedback_text1' rows="7" class="input02" placeholder=""></textarea>
            <label for="" class="placeholder2">Feedback</label>
            </div>
            <div class="trial1" id='rate_button'>
                <button id="submit_rate" name="rateing_op" type="SUBMIT">Submit</button>
                <button id="cancel_rate" type="button" onclick="cancelbtn()">Cancel</button>

            </div>
        
                    </div>
                </div>
            </div>
        </div>
        </form>
        
            
<?php
            // Create a new row after every 5 members
            if ($loop_count > 0 && $loop_count % 4 == 0) {
                echo '</tr><tr>';
            }

            $loop_count++;
        }
        ?>
    </tr>
</table>
<?php
include 'partials/_dbconnect.php';
$query = "SELECT current_status, COUNT(*) as count FROM `myoperators` WHERE company_name='$companyname001' GROUP BY current_status";
$getData = $conn->query($query);
?>
<script>
                function dl_expirynotification(){
            document.getElementById("notification_bg").style.display = "block";
        }

        function del_notification_dl(del_noti) {
    window.location.href = "del_notification_dl.php?notification_id=" + del_noti;
}


function close_all_notification_dl(comp_name){
    window.location.href = "del_all_dl_notification.php?comp_name=" + comp_name;
}



Highcharts.chart('container', {
    credits: {
        enabled: false
    },
    chart: {
        type: 'line'
    },
    title: {
        text: ' Statistics'
    },
    xAxis: {
        categories: ['Idle', 'Working'] // Replace with your actual categories
    },
    yAxis: {
        title: {
            text: 'Count'
        }
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.y}</b>',
        valueSuffix: ' Fleet Managers'
    },
    accessibility: {
        point: {
            valueSuffix: ' operator'
        }
    },
    series: [{
        name: 'Count',
        data: [
            <?php
            $data = '';
            if ($getData->num_rows > 0) {
                while ($row = $getData->fetch_assoc()) {
                    $data .= $row['count'] . ',';
                }
            }
            echo rtrim($data, ','); // Remove trailing comma
            ?>
        ]
    }]
});



    function ratingoperator(DL){
        document.getElementById("rate_operator").style.display = "block";


    }

    function cancelbtn() {
    window.location.href = "view_operator.php";
}

function purchase_option() {
    const options = document.getElementsByClassName('awp_options');
    const options1 = document.getElementsByClassName('cq_options');
    const options2 = document.getElementsByClassName('earthmover_options');
    const options3 = document.getElementsByClassName('mhe_options');
    const options4 = document.getElementsByClassName('gee_options');
    const options5 = document.getElementsByClassName('trailor_options');
    const options6 = document.getElementsByClassName('generator_options');

    const first_select = document.getElementById('oem_fleet_type');

    // Set the display style for all elements at once
    const displayStyle = (first_select.value === "Aerial Work Platform") ? "block" : "none";
    Array.from(options).forEach(option => option.style.display = displayStyle);

    const displayStyle1 = (first_select.value === "Concrete Equipment") ? "block" : "none";
    Array.from(options1).forEach(option => option.style.display = displayStyle1);

    const displayStyle2 = (first_select.value === "EarthMovers and Road Equipments") ? "block" : "none";
    Array.from(options2).forEach(option => option.style.display = displayStyle2);

    const displayStyle3 = (first_select.value === "Material Handling Equipments") ? "block" : "none";
    Array.from(options3).forEach(option => option.style.display = displayStyle3);

    const displayStyle4 = (first_select.value === "Ground Engineering Equipments") ? "block" : "none";
    Array.from(options4).forEach(option => option.style.display = displayStyle4);

    const displayStyle5 = (first_select.value === "Trailor and Truck") ? "block" : "none";
    Array.from(options5).forEach(option => option.style.display = displayStyle5);

    const displayStyle6 = (first_select.value === "Generator and Lighting") ? "block" : "none";
    Array.from(options6).forEach(option => option.style.display = displayStyle6);


}
function confirmDelete() {
        return confirm("Are you sure you want to delete ?");
    }



</script>

</body>
</html>