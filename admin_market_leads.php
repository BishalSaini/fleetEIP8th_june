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
?>
<?php
if($_SERVER["REQUEST_METHOD"] == "POST")

{
include 'partials/_dbconnect.php';
$project_code=$_POST['project_code'] ?? '';
// $project_type=$_POST['project_type_epc'];
$fuel=$_POST['fuel_scope'];
$accomodation=$_POST['accomodation_scope'];
$fleet_category=$_POST['fleet_category'];
$type = $_POST["type"];
$quip_capacity = $_POST["equip_capacity"];
$unit=$_POST['unit'];
$engine_hour = isset($_POST['engine_hour']) ? $_POST['engine_hour'] : NULL;
// $contact_person=$_POST['contact_person'];

$contact_person=!empty($_POST['newcontactname']) ? $_POST['newcontactname'] : $_POST['contact_person'];



$req_notes=$_POST['notes'];
$boom_combination = $_POST["boom_combination"];
$project_type = $_POST["project_type"];
$state = $_POST["state"];
$district = $_POST["district"];
$duration = $_POST["duration"];
$workingshift = $_POST["workingshift"];
$date = $_POST["date"];

$comp_name = !empty($_POST['newcompanynameinput']) ? $_POST['newcompanynameinput'] : $_POST['comp_name'];



$epc_email = $_POST["epc_email"];
$epc_number = $_POST["epc_number"];
$posted_by=$_POST['posted_by'];


$reqvalid=$_POST['reqvalid'];
$working_days=$_POST['working_days'];
$adbluescope=$_POST['adbluescope'];
$demob_recovery=$_POST['demob_recovery'];
$mob_recovery=$_POST['mob_recovery'];
$advance=$_POST['advance'];
$advfor=$_POST['advfor'] ?? '';
$creditterm=$_POST['creditterm'];
$projectname=$_POST['projectname'];
$workinghour=$_POST['workinghour'] ?? '';


if(!empty($_POST['newcompanynameinput']) || !empty(($_POST['newcontactname']))) {
$newname="INSERT INTO `fleeteip_clientlist`(`name`,`added_by`, `contactperson`, `email`, `contact_number`)
 VALUES ('$comp_name','$companyname001','$contact_person','$epc_email','$epc_number')";
 $resultnew=mysqli_query($conn,$newname);
}

$sql_insert="INSERT INTO `req_by_epc` (`workinghours`,`projectname`,`posted_by`,`enquiry_posted_date`,`project_code`,`fuel_scope`,`accomodation_scope`,`fleet_category`,`contact_person`,`engine_hour`,`notes`,`unit`, `equipment_type`, `equipment_capacity`, `boom_combination`, `project_type`,  `state`, `district`,`duration_month`, `working_shift`, `tentative_date`, `epc_name`, `epc_email`, `epc_number`,`reqvalid`, `working_days`, `adblue_scope`, `mobilisation_recovery`, `demobilisation_recovery`, `advance`, `adv_for`, `credit_term`)
 VALUES ('$workinghour','$projectname','$posted_by',NOW(),'$project_code','$fuel','$accomodation','$fleet_category','$contact_person','$engine_hour','$req_notes','$unit', '$type', '$quip_capacity', '$boom_combination', '$project_type', '$state', '$district', '$duration', '$workingshift', '$date', '$comp_name', '$epc_email', '$epc_number','$reqvalid','$working_days','$adbluescope','$mob_recovery','$demob_recovery','$advance','$advfor','$creditterm')";
$result= mysqli_query($conn , $sql_insert);
if($result){
$showAlert=true;
}
else{
    $showError=true;
}
}

?>
<style>
  <?php include "style.css" ?>
</style>
<script>
    <?php include "main.js" ?>
    </script>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">      <link rel="icon" href="favicon.jpg" type="image/x-icon">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Requirement</title>
    <link rel="stylesheet" href="style.css">
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
         <span class="alertText">Requirement Posted Successfully 
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
    ?>

<form action="admin_market_leads.php" method="POST" class="epc_req1" autocomplete="off">
    <div class="epc_red_div" id="adminpanelepcreq">
<p class="headingpara">Post Requirement</p>        

<div class="trial1" id="companynamesuggestioncontainer">
    <input type="text" name="comp_name" id="comp_name_input" class="input02" placeholder="" onkeyup="filterOptions(this.value)">
    <label for="comp_name_input" class="placeholder2">Enter Company Name</label>
    <select id="comp_name_select" class="suggestions input02" size="3" style="display:none;" onchange="selectOption(this); addnewcompany();">
        <!-- Options will be dynamically populated -->
    </select>
</div> 
<div class="trial1" id="newcompanynamecontainer">
    <input type="text" placeholder="" name="newcompanynameinput" class="input02">
    <label for="" class="placeholder2">New Company Name</label>
</div>

            <div class="trial1" id="contactpersoncontainer">
    <select class="input01" name="contact_person" id="contact_person" onchange="fetchcontactdetails(this.value); addnewcontactperson();">
        <option value=""disabled selected>Select Contact Person</option>
        <option value="New">Add New Contact Person</option>
        <!-- <option value="" onclick="">New Contact Person</option> -->
    </select>
</div>
<div class="trial1" id="newcontactpersoncontainer">
    <input type="text" placeholder="" id="newcontactnameinput" name="newcontactname" class="input02">
    <label for="" class="placeholder2">New Contact Name</label>
</div>

            <div class="outer02">
            <div class="trial1"> 
            <input class="input02" name="epc_email" id="epcemail" type="text" placeholder=""  >
            <label class="placeholder2">Email</label>
            </div>

            <div class="trial1">
            <input class="input02" name="epc_number" id="epcnumber" type="text" placeholder="">
            <label class="placeholder2"> Contact Number</label>
            </div>
            </div>
        <div class="outer02">
            <div class="trial1 hideit">
                <!-- <select name="" id="" class="input02">
                    <option value=""disabled selected>Choose Project Code</option>
                </select> -->
                <input type="text" placeholder="" name="project_code" class="input02">
                <label for="" class="placeholder2">Project Code</label>
            </div>
        <div class="trial1">
        <select class="input02" name="project_type" id="">
            <option value="" disabled selected>Choose Project Type</option>
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
            <input type="text" placeholder='' name="projectname" class="input02">
            <label for="" class="placeholder2">Project Name</label>
        </div>
        
        </div>
        <div class="outer02">
        <div class="trial1">
            <!-- <input class="input02" name="duration" type="text" placeholder="" >
            <label class="placeholder2">Duration In Months</label> -->
            <select name="duration" class="input02">
                <option value="" disabled selected>Project Duration</option>
                <option value="1 Month">1 Month</option>
                <option value="2 Months">2 Months</option>
                <option value="3 Months">3 Months</option>
                <option value="4 Months">4 Months</option>
                <option value="5 Months">5 Months</option>
                <option value="6 Months">6 Months</option>
                <option value="7 Months">7 Months</option>
                <option value="8 Months">8 Months</option>
                <option value="9 Months">9 Months</option>
                <option value="10 Months">10 Months</option>
                <option value="11 Months">11 Months</option>
                <option value="12 Months">12 Months</option>
                <option value="12+ Months">12+ Months</option>
            </select>
            </div>
        <div class="trial1">
            <select class="input02" name="state" id="state">
                <option value="" disabled selected>Project State</option>
                <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                <option value="Andhra Pradesh">Andhra Pradesh</option>
                <option value="Assam">Assam</option>
                <option value="Bihar">Bihar</option>
                <option value="Chandigarh">Chandigarh</option>
                <option value="Chhattisgarh">Chhattisgarh</option>
                <option value="Dadar and Nagar Haveli">Dadar and Nagar Haveli</option>
                <option value="Daman and Diu">Daman and Diu</option>
                <option value="Delhi">Delhi</option>
                <option value="Lakshadweep">Lakshadweep</option>
                <option value="Puducherry">Puducherry</option>
                <option value="Goa">Goa</option>
                <option value="Gujarat">Gujarat</option>
                <option value="Haryana">Haryana</option>
                <option value="Himachal Pradesh">Himachal Pradesh</option>
                <option value="Jammu and Kashmir">Jammu and Kashmir</option>
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
            </select>
            </div>
            <div class="trial1">
            <input class="input02"id="project_district" name="district" type="text" placeholder="">
            <label class="placeholder2">Project District</label>
            </div>
            </div>
            <div class="outer02">
        <div class="trial1">
            <input class="input02" id="tentative_date" name="date" type="date"  placeholder="" >
            <label class="placeholder2"> Equipment Req At Site</label>
            </div>
        <div class="trial1">
            <input class="input02" id="req_valid" name="reqvalid" type="date"  placeholder="" >
            <label class="placeholder2"> Requirement Valid Till</label>
            </div>

        </div>


        <div class="outer02">
        <div class="trial1">
        <select class="input02" name="fleet_category" id="oem_fleet_type" onchange="purchase_option()" required>
            <option value="" disabled selected>Select Fleet Category</option>
            <option value="Aerial Work Platform">Aerial Work Platform</option>
            <option value="Concrete Equipment">Concrete Equipment</option>
            <option value="EarthMovers and Road Equipments">EarthMovers and Road Equipments</option>
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
            <option value="Self Loafing Mixer"class="cq_options" id="">Self Loafing Mixer</option>
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
            <option id="mhe_option15" class="mhe_options" value="Crane">Crane</option>

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
    </div>
    <div class="outer02">
        <div class="trial1">
        <input type="text" name="equip_capacity" class="input02" placeholder="">
        <label class="placeholder2">Equipment Capacity</label>
        </div>
        <div class="trial1">
            <select name="unit" id="" class="input02" required>
            <option value="" disabled selected>Select Unit</option>
            <option value="Ton">Ton</option>
                <option value="Kgs">Kgs</option>
                <option value="KnM">KnM</option>
                <option value="Meter">Meter</option>
                <option value="M³">M³</option>
            </select>
        </div>

        <div class="trial1">
        <input type="text" name="boom_combination" class="input02" placeholder="">
        <label class="placeholder2">Boom Combination</label>
        </div>
        </div>
        <div class="outer02">
        <div class="trial1">
            <select class="input02" name="workingshift" id="working_shift_dd" onchange="engine_hour_input()">
                <option value="" disabled selected> Select Working shift</option>
                <option value="Single">Single</option>
                <option value="Double">Double</option>
                <option value="Flexi Single">Flexi Single</option>
            </select>
            </div>
            <div class="trial1" id="workinghourcontainer">
                <select name="workinghour" id="" class="input02">
                    <option value=""disabled selected>Working Hours</option>
                <option value="8">8 Hours</option>
                <option value="10">10 Hours</option>
                <option value="12">12 Hours</option>
                <option value="14">14 Hours</option>
                <option value="16">16 Hours</option>

                </select>
            </div>
            <div class="trial1" id="engine_hour_dd">
                <select name="engine_hour"  class="input02">
                    <option value="" disabled selected>Choose Engine Hour</option>
                    <option value="260">260</option>
                    <option value="280">280</option>
                    <option value="300">300</option>
                    <option value="312">312</option>
                    <option value="416">416</option>
                    <option value="572">572</option>
                </select>
            </div>

            <select name="working_days" id="" class="input02">
                <option value=""disabled selected>Working days</option>
                <option value="7">7 Days/Month</option>
                <option value="10">10 Days/Month</option>
                <option value="15">15 Days/Month</option>
                <option value="26" >26 Days/Month</option>
                <option value="28">28 Days/Month</option>
                <option value="30">30 Days/Month</option>

            </select>
        </div>
        <div class="outer02">
        <div class="trial1">
            <select name="fuel_scope" id="" class="input02">
                <option value=""disabled selected>Fuel In Scope Of?</option>
                <option value="EPC Scope">EPC Scope</option>
                <option value="Service Provider">Service Provider</option>
            </select></div>
            <select name="adbluescope" id="adbluescope" class="input02">
                <option value="disabled selected">⁠Adblue scope</option>
                <option value="EPC Scope">EPC Scope</option>
                <option value="Service Provider">Service Provider</option>

            </select>

            <div class="trial1">
                <select name="accomodation_scope" id="" class="input02">
                    <option value=""disabled selected>Accomodation Scope</option>
                    <option value="EPC Scope">EPC Scope</option>
                    <option value="Service Provider">Service Provider</option>
                </select>
            
            </div>

        </div>
        <div class="outer02">
            <select name="mob_recovery" id="" class="input02">
                <option value=""disabled selected>Mobilisation recovery</option>
                <option value="Not Applicable">Not Applicable</option>
                <option value="3 Months">3 Months</option>
                <option value="6 Months">6 Months</option>
                <option value="9 Months">9 Months</option>
                <option value="12 Months">12 Months</option>
            </select>
            <select name="demob_recovery" id="" class="input02">
                <option value=""disabled selected>Demobilisation recovery</option>
                <option value="Not Applicable">Not Applicable</option>
                <option value="3 Months">3 Months</option>
                <option value="6 Months">6 Months</option>
                <option value="9 Months">9 Months</option>
                <option value="12 Months">12 Months</option>
            </select>
        </div>
        <div class="outer02">
            <select name="advance" id="advanceapplicable" class="input02" onchange="advancefordd()">
                <option value=""disabled selected>Advance </option>
                <option value="Applicable"> Applicable</option>
                <option value="Not Applicable">Not Applicable</option>

            </select>
            <select name="advfor" id="advancefor" class="input02">
                <option value=""disabled selected>Advance For</option>
                <option value="Transportation">Transportation</option>
                <option value="Rental">Rental</option>
                <option value="Rental + Transportation">Rental + Transportation</option>
            </select>
            <select name="creditterm" id="" class="input02">
                <option value=""disabled selected>Credit Term</option>
                <option value="7 Days">7 Days</option>
                <option value="10 Days">10 Days</option>
                <option value="15 Days">15 Days</option>
                <option value="30 Days">30 Days</option>
                <option value="45 Days">45 Days</option>
                <option value="60 Days">60 Days</option>
                <option value="90 Days">90 Days</option>
            </select>
        </div>
            <!-- <div class="outer02"> -->
            <!-- <div class="trial1">
            <input class="input02" name="duration" type="text" placeholder="" >
            <label class="placeholder2">Duration In Months</label>
            </div>  -->
            <!-- <div class="trial1">
            <select class="input02" name="workingshift" id="working_shift_dd" onchange="engine_hour_input()">
                <option value="" disabled selected> Select Working shift</option>
                <option value="Single">Single</option>
                <option value="Double">Double</option>
                <option value="Flexi Single">Flexi Single</option>
            </select> -->
            <!-- </div> -->
            

            
           
            <div class="trial1">
            <textarea class="input02" name="notes" type="text" placeholder=""></textarea>
            <label class="placeholder2">Requirements Notes for vendor</label>
            </div>
            <input type="hidden" name="posted_by" value="<?php echo 'admin'; ?>">
            <button class="epc-button" type="submit">Submit</button>
            <br>
        </div>
</form>
    <br><br>
    <script>   
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

    function engine_hour_input(){
        const dd_menu=document.getElementById('working_shift_dd');
        const work=document.getElementById('engine_hour_dd');
        const workinghourcontainer=document.getElementById('workinghourcontainer');
        if(dd_menu.value==='Double' || dd_menu.value==='Flexi Single'){
            work.style.display='block';
            workinghourcontainer.style.display='none';

        }
        else if (dd_menu.value==='Single'){
            workinghourcontainer.style.display='block';
            work.style.display='none';

        }
        else{
            work.style.display='none';
            workinghourcontainer.style.display='none';

        }
    }


    const companies = [
    <?php
    include "partials/_dbconnect.php";
    $sql = "SELECT * FROM `fleeteip_clientlist`";
    $resultclient = mysqli_query($conn, $sql);
    while ($rowclient = mysqli_fetch_array($resultclient)) {
        echo '"' . $rowclient['name'] . '",';
    }
    ?>
];

// Function to filter companies based on the input value
function filterOptions(inputValue) {
    const selectElement = document.getElementById("comp_name_select");
    selectElement.innerHTML = ""; // Clear previous options

    const filteredCompanies = companies.filter(company =>
        company.toLowerCase().includes(inputValue.toLowerCase())
    );

    if (inputValue.length >= 2) {
        if (filteredCompanies.length > 0) {
            selectElement.style.display = "block";
            filteredCompanies.forEach(company => {
                const option = document.createElement("option");
                option.value = company;
                option.textContent = company;
                selectElement.appendChild(option);
            });
        } else {
            selectElement.style.display = "block";
            selectElement.innerHTML = "<option value='New'>Add New Company </option>"
        }
    } else {
        selectElement.style.display = "none";
    }
}

// Handle company selection and populate the contact person dropdown
function selectOption(select) {
    const input = document.getElementById("comp_name_input");
    input.value = select.value; // Set the input value to the selected company
    const companyName = select.value;

    // Hide the company select dropdown
    document.getElementById("comp_name_select").style.display = "none";

    // Make an AJAX request to get the contact persons for the selected company
    const xhr = new XMLHttpRequest();
    xhr.open("GET", "get_contact_person.php?company_name=" + encodeURIComponent(companyName), true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);
            const contactPersonSelect = document.getElementById("contact_person");
            
            contactPersonSelect.innerHTML = '<option value="" disabled selected>Select Contact Person</option>';
    contactPersonSelect.innerHTML += '<option value="New">Add New Contact Person</option>';
            
            // Populate the contact person select dropdown with new options
            if (response.length > 0) {
                response.forEach(contact => {
                    const option = document.createElement("option");
                    option.value = contact.contactperson;
                    option.textContent = contact.contactperson;
                    contactPersonSelect.appendChild(option);
                });
            } else {
                contactPersonSelect.innerHTML += '<option value="" disabled>No Contact Person Found</option>';
            }
        }
    };
    xhr.send();
}



function fetchcontactdetails(name) {
        const companyname=document.getElementById("comp_name_input").value;

        fetch(`fetchcontactfulldata.php?name=${name}&companyname=${companyname}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('epcemail').value = data?.email || '';
                document.getElementById('epcnumber').value = data?.contact_number || '';
            })
            .catch(() => {  // Handle errors
                document.getElementById('epcemail').value = '';
                document.getElementById('epcnumber').value = '';
            });
    }


    function addnewcontactperson(){
        const contact_person=document.getElementById("contact_person");
        const contactpersoncontainer=document.getElementById("contactpersoncontainer");
        const newcontactpersoncontainer=document.getElementById("newcontactpersoncontainer");
        const newcontactnameinput=document.getElementById("newcontactnameinput");
        if(contact_person.value==='New'){
            contactpersoncontainer.style.display='none';
            newcontactpersoncontainer.style.display='block';
            newcontactnameinput.setAttribute("required", "required");
            
        }
        else {
    newcontactpersoncontainer.removeAttribute("required");
}
    }

    function addnewcompany(){
        const comp_name_select=document.getElementById("comp_name_select");
        const companynamesuggestioncontainer=document.getElementById("companynamesuggestioncontainer");
        const newcompanynamecontainer=document.getElementById("newcompanynamecontainer");

        if(comp_name_select.value==='New'){
            companynamesuggestioncontainer.style.display='none';
            newcompanynamecontainer.style.display='block';
            newcompanynamecontainer.setAttribute("required", "required");


        }
        else{
            newcompanynamecontainer.setAttribute("required");

        }
    }
    </script>
</body>
</html>