<?php
// Include the database connection file
include 'partials/_dbconnect.php';
session_start();
$companyname = $_SESSION['companyname'];
$showAlert=false;
$showError=false;
// Query to retrieve asset codes from the database
$sql = "SELECT DISTINCT assetcode FROM fleet1 WHERE companyname = '$companyname'";
$result = mysqli_query($conn, $sql);

// Check if query was successful
if ($result) {
    $assetCodes = [];
    // Fetch asset codes and store in an array
    while ($row = mysqli_fetch_assoc($result)) {
        $assetCodes[] = $row['assetcode'];
    }
}
?>
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
$travel=$_POST['travel'];
$accomodation=$_POST['accomodation'];
$food=$_POST['food'];
$bonus=$_POST['bonus'];
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
$folder1 = 'img/' . $dl_image;
move_uploaded_file($temp_file_path, $folder1);

$aadhar_image = $_FILES['upload_aadhar']['name'];
$temp_file_path = $_FILES['upload_aadhar']['tmp_name'];
$folder2 = 'img/' . $aadhar_image;
move_uploaded_file($temp_file_path, $folder2);

$pan_image = $_FILES['pan_image']['name'];
$temp_file_path = $_FILES['pan_image']['tmp_name'];
$folder3 = 'img/' . $pan_image;
move_uploaded_file($temp_file_path, $folder3);


$sql_insert="INSERT INTO `myoperators` (`upload_dl`,`upload_aadharcard`,`upload_pancard`,`operator_fname`, `designation`, `company_name`, `startdate_crnt_company`, `fleet_category`, `fleet_Type`, `cap_metric_ton`, `salary`, `pf_deduction`, `esic`, `travel_allowance`, `accomodation_allowance`, `food_allowance`, `bonus`, `driving_license`, `issued_date`, `dl_expiry`, `aadhar_card`, `pancard`, `mobile_number`, `address`, `pincode`, `reference1`, `relation_refernce1`, `reference1_mobile`, `reference2`, `relation_refernce2`, `reference2_mobile`, `previous_company`, `startdate_previous_company`, `enddate_previous_company`, `current_status`, `driving_asset_code`)
 VALUES ('$dl_image','$aadhar_image','$pan_image','$operator_fname', '$designation', '$companyname0', '$current_company_strt', '$fleet_category', '$fleet_type', '$fleet_capacity', '$salary', '$pf', '$esic', '$travel', '$accomodation', '$food', '$bonus', '$driving_license', '$issued_date', '$dl_expiry', '$aadhar_card', '$pancard_number', '$mob_no', '$address', '$pincode', '$ref1', '$relation_ref1', '$ref1_mobile', '$ref2', '$relation_ref2', '$ref2_mobile', '$previous_company', '$previous_company_strt', '$previous_company_end', '$crnt_status', '$assetCode')";
    $result = mysqli_query($conn, $sql_insert);
    if($result){
        $showAlert=true;
    }
    else{
        $showError=true;
    }




    

    





}
?>

<script>
    <?php include "main.js" ?>
    </script>
<style>
  <?php include "style.css" 
  ?>
</style>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">      <link rel="icon" href="favicon.jpg" type="image/x-icon">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            <li><a href="news/">News</a></li>

            <li><a href="logout.php">Log Out</a></li></ul>
        </div>
</div>
<?php
if($showAlert){
    echo  '<label>
    <input type="checkbox" class="alertCheckbox" autocomplete="off" />
    <div class="alert notice">
      <span class="alertClose">X</span>
      <span class="alertText_addfleet"><b>Success!</b>Operator Added Successfully<a href="view_operator.php">View Operator Here</a>
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

<form action="addoperator.php" class="addoperator_form" method="POST" autocomplete="off" enctype="multipart/form-data">
        <div class="addoperator_container">
        <div class="add_operator"><p>Add Fleet Manager</p></div>
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
        <input type="text" name="companyname" value="<?php echo $companyname ?>" placeholder="" class="input02" readonly>
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
        <div class="outer02">
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
        </div>
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
    <select name="current_status" id="operator_status" class="input02" onchange="idlefunction()">
        <option value="" disabled selected >Choose Operator Status</option>
        <option value="idle">Idle</option>
        <option value="working">Working</option>
    </select>
    </div>
    <div class="trial1" id="asset_code" >
        <select name="assetCode" id="" class="input02">
            <option value="none" disabled selected>Choose Operator Driving Asset Code </option>
        <?php
    // Display the asset codes as dropdown options
    if (!empty($assetCodes)) {
        foreach ($assetCodes as $code) {
            echo '<option value="' . $code . '">' . $code . '</option>';
        }
    } else {
        echo '<option value="">No asset codes found</option>';
    }
    ?>
        </select>
    </div>
     
    <button class="epc-button" type="submit">Add Operator</button>
    <br>

    </div>
</form>
<br>
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


       
    
</script>

</body>
</html>

