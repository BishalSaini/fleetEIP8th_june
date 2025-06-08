<?php
session_start();
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

include 'partials/_dbconnect.php';
$id = $_GET['id'];
$sql="SELECT * FROM `myoperators` WHERE id='$id'";
$result=mysqli_query($conn ,$sql);
$row=mysqli_fetch_assoc($result);
?>
<?php
// Include the database connection file
include 'partials/_dbconnect.php';
$companyname = $_SESSION['companyname'];

// Query to retrieve asset codes from the database
$sql = "SELECT DISTINCT assetcode FROM fleet1 WHERE companyname = '$companyname'";
$result = mysqli_query($conn, $sql);

// Check if query was successful
if ($result) {
    $assetCodes = [];
    // Fetch asset codes and store in an array
    while ($row2 = mysqli_fetch_assoc($result)) {
        $assetCodes[] = $row2['assetcode'];
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
    // $travel=$_POST['travel'];
    // $accomodation=$_POST['accomodation'];
    // $food=$_POST['food'];
    // $bonus=$_POST['bonus'];
    $driving_license = $_POST["license"];
    $issued_date = $_POST["license_issueddate"];
    $dl_expiry=$_POST['dl_expiry'];
    $aadhar_card = $_POST["aadhar_card"];
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
    $edit_id1=$_POST['id'];
    $assetCode = !empty($_POST["assetCode"]) ? $_POST["assetCode"] : NULL;
    $editable_field = $_POST['existing_image'];
    $pre_ac=$_POST['existing_image_aadhar'];
    $pre_pan=$_POST['existing_image_pancard'];
// Upload DL License Image


if(!empty($_FILES['dl_license_image']['name'])){
    $dl_image = $_FILES['dl_license_image']['name'];
    $temp_file_path = $_FILES['dl_license_image']['tmp_name'];
    $folder1 = 'img/' . $dl_image;
    move_uploaded_file($temp_file_path, $folder1);


}
else{
    $dl_image = $editable_field;

}
// Upload Aadhar Card Image
if (!empty($_FILES['upload_aadhar']['name'])) {
    $aadhar_image = $_FILES['upload_aadhar']['name'];
    $temp_file_path_ac = $_FILES['upload_aadhar']['tmp_name'];
    $folder2 = 'img/' . $aadhar_image;
    move_uploaded_file($temp_file_path_ac, $folder2);
} else {
    $aadhar_image = $pre_ac;
}

// Upload PAN Card Image
if (!empty($_FILES['pan_image']['name'])) {
    $pan_image = $_FILES['pan_image']['name'];
    $temp_file_path_pc = $_FILES['pan_image']['tmp_name'];
    $folder3 = 'img/' . $pan_image;
    move_uploaded_file($temp_file_path_pc, $folder3);
} else {
    $pan_image = $pre_pan;
}
        
        $sql = "UPDATE `myoperators` SET `upload_pancard`='$pan_image',`upload_aadharcard`='$aadhar_image', `upload_dl` = '$dl_image', `operator_fname` = '$operator_fname', `designation` = '$designation', 
        `company_name` = '$companyname0', `startdate_crnt_company` = '$current_company_strt', `fleet_category` = '$fleet_category', `fleet_Type` = '$fleet_type', 
        `cap_metric_ton` = '$fleet_capacity', `salary` = '$salary', `pf_deduction` = '$pf', 
          `driving_license` = '$driving_license',
          `issued_date` = '$issued_date', `dl_expiry` = '$dl_expiry', `aadhar_card` = '$aadhar_card', `pancard` = '$pancard_number', `mobile_number` = '$mob_no',
           `address` = '$address', `pincode` = '$pincode', `reference1` = '$ref1', `relation_refernce1` = '$relation_ref1', `reference2` = '$ref2',
            `relation_refernce2` = '$relation_ref2', `reference2_mobile` = '$ref2_mobile', `previous_company` = '$previous_company',
             `startdate_previous_company` = '$previous_company_strt', `enddate_previous_company` = '$previous_company_end', 
             `current_status` = '$crnt_status',`esic`='$esic',`reference1_mobile`='$ref1_mobile', `driving_asset_code` = '$assetCode' WHERE `myoperators`.`id` = '$edit_id1'";
    $result_update = mysqli_query($conn , $sql);
    if($result_update){
        header("location:view_operator.php");
    }
}


?>
<style>
  <?php include "style.css" 
  ?>
</style>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">      <link rel="icon" href="favicon.jpg" type="image/x-icon">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Edit Operator</title>
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
    <form action="view_operator_additionalinfo.php" class="addoperator_form" method="POST" enctype="multipart/form-data">
    <div class="addoperator_container">
        <div class="add_operator"><p>Your Fleet Manager</p></div>
        <input type="text" placeholder="id" name="id" value="<?php echo $row['id'] ?>" hidden>
        <div class="outer02">
        <div class="trial1">
        <input type="text" name="firstname" value="<?php echo $row['operator_fname'] ?>" placeholder="" class="input02">
        <label class="placeholder2"> Name</label>
        </div>
        <div class="trial1">
            <select name="designation" id="" class="input02">
            <option value="none"disabled selected>Choose Designation</option>
            <option value="Operator" <?php if($row['designation'] === 'Operator') { echo 'selected'; } ?>>Operator</option>
            <option value="Helper"<?php if($row['designation'] === 'Helper') { echo 'selected'; } ?>>Helper</option>
                <option value="Rigger" <?php if($row['designation'] === 'Rigger') { echo 'selected'; } ?>>Rigger</option>
            </select>
        </div>
        </div>
        <!-- <div class="trial1">
        <input type="text" name="lastname" value="" placeholder="" class="input02">
        <label class="placeholder2">Operator Last Name</label>
        </div> -->
        <input type="hidden" name="existing_image" value="<?php echo htmlspecialchars($row['upload_dl']); ?>">
        <input type="hidden" name="existing_image_aadhar" value="<?php echo htmlspecialchars($row['upload_aadharcard']); ?>">
        <input type="hidden" name="existing_image_pancard" value="<?php echo htmlspecialchars($row['upload_pancard']); ?>">

        <div class="outer02">
        <div class="trial1">
        <input type="text" name="companyname"  value="<?php echo $row['company_name'] ?>" placeholder="" class="input02">
        <label class="placeholder2">Company Name</label>
        </div>
        <div class="trial1">
        <input type="date" value="<?php echo $row['startdate_crnt_company'] ?>" name="strt_date" placeholder="" class="input02">
        <label class="placeholder2">Started From</label>
        </div>
    </div>
        <div class="outer02">
        <div class="trial1">
        <select class="input02" name="fleet_category" id="oem_fleet_type" onchange="purchase_option()" required>
            <option value="" disabled selected>Select Fleet Category</option>
            <option value="Aerial Work Platform"<?php if($row['fleet_category'] === 'Aerial Work Platform') { echo 'selected'; } ?>>Aerial Work Platform</option>
            <option value="Concrete Equipment" <?php if($row['fleet_category'] === 'Concrete Equipment'){echo 'selected';} ?>>Concrete Equipment</option>
            <option value="EarthMovers and Road Equipments" <?php if($row['fleet_category'] === 'EarthMovers and Road Equipments'){echo 'selected';} ?>>EarthMovers and Road Equipments</option>
            <option value="Material Handling Equipments" <?php if($row['fleet_category'] === 'Material Handling Equipments'){echo 'selected';} ?>>Material Handling Equipments</option>           
            <option value="Ground Engineering Equipments" <?php if($row['fleet_category'] === 'Ground Engineering Equipments'){echo 'selected';} ?> >Ground Engineering Equipments</option>
            <option value="Trailor and Truck" <?php if($row['fleet_category'] === 'Trailor and Truck'){echo 'selected';} ?>>Trailor and Truck</option>
            <option value="Generator and Lighting" <?php if($row['fleet_category'] === 'Generator and Lighting'){echo 'selected';} ?>>Generator and Lighting</option>
        </select>
        </div>
        <div class="trial1">
        <select class="input02" name="type" id="fleet_sub_type" onchange="crawler_options()" required>
            <option value="" disabled selected>Select Fleet Type</option>
            <option <?php if($row['fleet_Type']=== 'Self Propelled Articulated Boomlift'){echo 'selected';} ?> value="Self Propelled Articulated Boomlift"class="awp_options"  id="aerial_work_platform_option1">Self Propelled Articulated Boomlift</option>
            <option <?php if($row['fleet_Type']=== 'Scissor Lift Diesel'){echo 'selected';} ?> value="Scissor Lift Diesel" class="awp_options" id="aerial_work_platform_option2">Scissor Lift Diesel</option>
            <option <?php if($row['fleet_Type']=== 'Scissor Lift Electric'){echo 'selected';} ?> value="Scissor Lift Electric"class="awp_options"  id="aerial_work_platform_option3">Scissor Lift Electric</option>
            <option <?php if($row['fleet_Type']=== 'Spider Lift'){echo 'selected';} ?> value="Spider Lift"class="awp_options"  id="aerial_work_platform_option4">Spider Lift</option>
            <option <?php if($row['fleet_Type']=== 'Self Propelled Straight Boomlift'){echo 'selected';} ?> value="Self Propelled Straight Boomlift"class="awp_options"  id="aerial_work_platform_option5">Self Propelled Straight Boomlift</option>
            <option <?php if($row['fleet_Type']=== 'Truck Mounted Articulated Boomlift'){echo 'selected';} ?> value="Truck Mounted Articulated Boomlift"class="awp_options"  id="aerial_work_platform_option6">Truck Mounted Articulated Boomlift</option>
            <option <?php if($row['fleet_Type']=== 'Truck Mounted Straight Boomlift'){echo 'selected';} ?> value="Truck Mounted Straight Boomlift"class="awp_options"  id="aerial_work_platform_option7">Truck Mounted Straight Boomlift</option>
            <option <?php if($row['fleet_Type']=== 'Batching Plant'){echo 'selected';} ?> value="Batching Plant"class="cq_options" id="concrete_equipment_option1">Batching Plant</option>
            <option <?php if($row['fleet_Type']=== 'Self Loading Mixer'){echo 'selected';} ?> value="Self Loading Mixer"class="cq_options" id="">Self Loading Mixer</option>
            <option <?php if($row['fleet_Type']=== 'Concrete Boom Placer'){echo 'selected';} ?> value="Concrete Boom Placer"class="cq_options" id="concrete_equipment_option2">Concrete Boom Placer</option>
            <option <?php if($row['fleet_Type']=== 'Concrete Pump'){echo 'selected';} ?> value="Concrete Pump"class="cq_options" id="concrete_equipment_option3">Concrete Pump</option>
            <option <?php if($row['fleet_Type']=== 'Moli Pump'){echo 'selected';} ?> value="Moli Pump"class="cq_options" id="concrete_equipment_option4">Moli Pump</option>
            <option <?php if($row['fleet_Type']=== 'Mobile Batching Plant'){echo 'selected';} ?> value="Mobile Batching Plant"class="cq_options" id="concrete_equipment_option5">Mobile Batching Plant</option>
            <option <?php if($row['fleet_Type']=== 'Static Boom Placer'){echo 'selected';} ?> value="Static Boom Placer"class="cq_options" id="concrete_equipment_option6">Static Boom Placer</option>
            <option <?php if($row['fleet_Type']=== 'Transit Mixer'){echo 'selected';} ?> value="Transit Mixer"class="cq_options" id="concrete_equipment_option7">Transit Mixer</option>
            <option <?php if($row['fleet_Type']=== 'Baby Roller'){echo 'selected';} ?> value="Baby Roller" class="earthmover_options" id="earthmovers_option1">Baby Roller</option>
            <option <?php if($row['fleet_Type']=== 'Backhoe Loader'){echo 'selected';} ?> value="Backhoe Loader" class="earthmover_options" id="earthmovers_option2">Backhoe Loader</option>
            <option <?php if($row['fleet_Type']=== 'Bulldozer'){echo 'selected';} ?> value="Bulldozer" class="earthmover_options" id="earthmovers_option3">Bulldozer</option>
            <option <?php if($row['fleet_Type']=== 'Excavator'){echo 'selected';} ?> value="Excavator" class="earthmover_options" id="earthmovers_option4">Excavator</option>
            <option <?php if($row['fleet_Type']=== 'Milling Machine'){echo 'selected';} ?> value="Milling Machine" class="earthmover_options" id="earthmovers_option5">Milling Machine</option>
            <option <?php if($row['fleet_Type']=== 'Motor Grader'){echo 'selected';} ?> value="Motor Grader" class="earthmover_options" id="earthmovers_option6">Motor Grader</option>
            <option <?php if($row['fleet_Type']=== 'Pneumatic Tyre Roller'){echo 'selected';} ?> value="Pneumatic Tyre Roller" class="earthmover_options" id="earthmovers_option7">Pneumatic Tyre Roller</option>
            <option <?php if($row['fleet_Type']=== 'Single Drum Roller'){echo 'selected';} ?> value="Single Drum Roller" class="earthmover_options" id="earthmovers_option8">Single Drum Roller</option>
            <option <?php if($row['fleet_Type']=== 'Skid Loader'){echo 'selected';} ?> value="Skid Loader" class="earthmover_options" id="earthmovers_option9">Skid Loader</option>
            <option <?php if($row['fleet_Type']=== 'Slip Form Paver'){echo 'selected';} ?> value="Slip Form Paver" class="earthmover_options" id="earthmovers_option10">Slip Form Paver</option>
            <option <?php if($row['fleet_Type']=== 'Soil Compactor'){echo 'selected';} ?> value="Soil Compactor" class="earthmover_options" id="earthmovers_option11">Soil Compactor</option>
            <option <?php if($row['fleet_Type']=== 'Tandem Roller'){echo 'selected';} ?> value="Tandem Roller" class="earthmover_options" id="earthmovers_option12">Tandem Roller</option>
            <option <?php if($row['fleet_Type']=== 'Vibratory Roller'){echo 'selected';} ?> value="Vibratory Roller" class="earthmover_options" id="earthmovers_option13">Vibratory Roller</option>
            <option <?php if($row['fleet_Type']=== 'Wheeled Excavator'){echo 'selected';} ?> value="Wheeled Excavator" class="earthmover_options" id="earthmovers_option14">Wheeled Excavator</option>
            <option <?php if($row['fleet_Type']=== 'Wheeled Loader'){echo 'selected';} ?> value="Wheeled Loader" class="earthmover_options" id="earthmovers_option15">Wheeled Loader</option>
            <option id="mhe_option1"  class="mhe_options"<?php if($row['fleet_Type']==='Fixed Tower Crane'){ echo 'selected';} ?> value="Fixed Tower Crane">Fixed Tower Crane</option>
            <option id="mhe_option2" class="mhe_options" <?php if($row['fleet_Type']==='Fork Lift Diesel'){ echo 'selected';} ?> value="Fork Lift Diesel">Fork Lift Diesel</option>
            <option id="mhe_option3" class="mhe_options" <?php if($row['fleet_Type']==='Fork Lift Electric'){ echo 'selected';} ?> value="Fork Lift Electric">Fork Lift Electric</option>
            <option id="mhe_option4" class="mhe_options" <?php if($row['fleet_Type']==='Hammerhead Tower Crane'){ echo 'selected';} ?> value="Hammerhead Tower Crane">Hammerhead Tower Crane</option>
            <option id="mhe_option5" class="mhe_options" <?php if($row['fleet_Type']==='Hydraulic Crawler Crane'){ echo 'selected';} ?> value="Hydraulic Crawler Crane">Hydraulic Crawler Crane</option>
            <option id="mhe_option6" class="mhe_options" <?php if($row['fleet_Type']==='Luffing Jib Tower Crane'){ echo 'selected';} ?> value="Luffing Jib Tower Crane">Luffing Jib Tower Crane</option>
            <option id="mhe_option7" class="mhe_options" <?php if($row['fleet_Type']==='Mechanical Crawler Crane'){ echo 'selected';} ?> value="Mechanical Crawler Crane">Mechanical Crawler Crane</option>
            <option id="mhe_option8" class="mhe_options" <?php if($row['fleet_Type']==='Pick and Carry Crane'){ echo 'selected';} ?> value="Pick and Carry Crane">Pick and Carry Crane</option>
            <option id="mhe_option9" class="mhe_options" <?php if($row['fleet_Type']==='Reach Stacker'){ echo 'selected';} ?> value="Reach Stacker">Reach Stacker</option>
            <option id="mhe_option10" class="mhe_options" <?php if($row['fleet_Type']==='Rough Terrain Crane'){echo 'selected';} ?> value="Rough Terrain Crane">Rough Terrain Crane</option>
            <option id="mhe_option11" class="mhe_options" <?php if($row['fleet_Type']==='Telehandler'){echo 'selected';} ?> value="Telehandler">Telehandler</option>
            <option id="mhe_option12" class="mhe_options" <?php if($row['fleet_Type']==='Telescopic Crawler Crane'){echo 'selected';} ?> value="Telescopic Crawler Crane">Telescopic Crawler Crane</option>
            <option id="mhe_option13" class="mhe_options" <?php if($row['fleet_Type']==='Telescopic Mobile Crane'){echo 'selected';} ?> value="Telescopic Mobile Crane">Telescopic Mobile Crane</option>
            <option id="mhe_option14" class="mhe_options" <?php if($row['fleet_Type']==='All Terrain Mobile Crane'){echo 'selected';} ?> value="All Terrain Mobile Crane">All Terrain Mobile Crane</option>
            <option id="mhe_option15" class="mhe_options" <?php if($row['fleet_Type']==='Self Loading Truck Crane'){echo 'selected';} ?> value="Self Loading Truck Crane">Self Loading Truck Crane</option>

            <option id="ground_engineering_equipment_option1" class="gee_options" <?php if($row['fleet_Type']=== 'Hydraulic Drilling Rig') {echo 'selected';} ?>  value="Hydraulic Drilling Rig">Hydraulic Drilling Rig</option>
            <option id="ground_engineering_equipment_option2" class="gee_options" <?php if($row['fleet_Type']=== 'Rotary Drilling Rig'){echo 'selected';} ?> value="Rotary Drilling Rig">Rotary Drilling Rig</option>
            <option id="ground_engineering_equipment_option3" class="gee_options" <?php if($row['fleet_Type']=== 'Vibro Hammer'){echo 'selected';} ?> value="Vibro Hammer">Vibro Hammer</option>
            <option  id="trailor_option1" class="trailor_options" <?php if($row['fleet_Type']==='Dumper'){echo 'selected';} ?> value="Dumper">Dumper</option>
            <option  id="trailor_option2" class="trailor_options" <?php if($row['fleet_Type']==='Truck'){echo 'selected';} ?> value="Truck">Truck</option>
            <option  id="trailor_option3" class="trailor_options" <?php if($row['fleet_Type']==='Water Tanker'){echo 'selected';} ?> value="Water Tanker">Water Tanker</option>
            <option id="trailor_option4"  class="trailor_options" <?php if($row['fleet_Type']==='Low Bed'){echo 'selected';} ?> value="Low Bed">Low Bed</option>
            <option id="trailor_option5"  class="trailor_options" <?php if($row['fleet_Type']==='Semi Low Bed'){echo 'selected';} ?> value="Semi Low Bed">Semi Low Bed</option>
            <option  id="trailor_option6" class="trailor_options" <?php if($row['fleet_Type']==='Flatbed'){echo 'selected';} ?> value="Flatbed">Flatbed</option>
            <option  id="trailor_option7" class="trailor_options" <?php if($row['fleet_Type']==='Hydraulic Axle'){echo 'selected';} ?> value="Hydraulic Axle">Hydraulic Axle</option>
            <option id="generator_option1" class="generator_options" <?php if($row['fleet_Type']==='Silent Diesel Generator'){echo 'selected';} ?> value="Silent Diesel Generator">Silent Diesel Generator</option>
            <option id="generator_option2" class="generator_options" <?php if($row['fleet_Type']==='Mobile Light Tower'){echo 'selected';} ?> value="Mobile Light Tower">Mobile Light Tower</option>
            <option id="generator_option3" class="generator_options" <?php if($row['fleet_Type']==='Diesel Generator'){echo 'selected';} ?> value="Diesel Generator">Diesel Generator</option>
        </select>
        </div>

        <div class="trial1">
        <input type="text" name="fleet_capacity" value="<?php echo $row['cap_metric_ton'] ?>" placeholder="" class="input02">
        <label class="placeholder2">Capacity In Metric Ton</label>
        </div>
        </div>
        <div class="outer02">
            <div class="trial1">
            <input type="text" placeholder="" value="<?php echo $row['salary'] ?>" name="salary" class="input02">
            <label for="" class="placeholder2">Salary</label>
            </div>
            <div class="trial1">
                <select name="pf" id="" class="input02">
                    <option value="none" disabled selected>Choose PF Deduction</option>
                    <option value="Yes" <?php if($row['pf_deduction']==='Yes'){echo 'selected';} ?>>Yes</option>
                    <option value="No" <?php if($row['pf_deduction']==='No'){echo 'selected';} ?>>No</option>
                </select>
            </div>
            <div class="trial1">
                <select name="esic" id="" class="input02">
                    <option value="none">ESIC Deduction?</option>
                    <option value="Yes" <?php if($row['esic']==='Yes'){echo 'selected';} ?>>Yes</option>
                    <option value="No" <?php if($row['esic']==='No'){echo 'selected';} ?>>No</option>
                </select>
            </div>
        </div>
        <!-- <div class="outer02">
        <div class="trial1">
            <input type="text" name="travel" value="<?php echo $row['travel_allowance'] ?>" placeholder="" class="input02">
            <label for="" class="placeholder2">Travelling Allowance</label>
        </div>
        <div class="trial1">
            <input type="text" name="accomodation" value="<?php echo $row['accomodation_allowance'] ?>" placeholder="" class="input02">
            <label for="" class="placeholder2">Room Allowance</label>
        </div>
        <div class="trial1">
            <input type="text" name="food" value="<?php echo $row['food_allowance'] ?>" placeholder="" class="input02">
            <label for="" class="placeholder2">Food Allowance</label>
        </div>
        <div class="trial1">
            <input type="text" name="bonus" placeholder="" value="<?php echo $row['bonus'] ?>" class="input02">
            <label for="" class="placeholder2">Bonus</label>
        </div>
        </div> -->

        <div class="outer02">
        <div class="trial1">
        <input type="text" name="license" placeholder="" value="<?php echo $row['driving_license'] ?>" class="input02">
        <label class="placeholder2">Driving License</label>
        </div>
        <div class="trial1">
        <input type="date" name="license_issueddate" placeholder="" value="<?php echo $row['issued_date'] ?>" class="input02">
        <label class="placeholder2">Issued Date</label>
        </div>
        <div class="trial1">
        <input type="date" name="dl_expiry" value="<?php echo $row['dl_expiry'] ?>" placeholder="" class="input02">
        <label class="placeholder2">Expiry Date</label>
        </div>
        <div class="trial1">
            <input type="file" name="dl_license_image"  placeholder="" class="input02">
            <label for="" class="placeholder2">Upload Driving License</label>
        </div>

        </div>
        <div class="outer02">
        <div class="trial1">
        <input type="text" name="aadhar_card" placeholder="" value="<?php echo $row['aadhar_card'] ?>" class="input02">
        <label class="placeholder2">Aadhar Card</label>
        </div>
        <div class="trial1">
            <input type="file" name="upload_aadhar" placeholder=""  class="input02">
            <label for="" class="placeholder2">Upload Aadhar Card</label>
        </div>
        </div>
        <div class="outer02">
            <div class="trial1">
                <input type="text" name="pancard_number" value="<?php echo $row['pancard'] ?>" class="input02">
                <label for="" class="placeholder2">Pancard</label>
            </div>
            <div class="trial1">
                <input type="file" name="pan_image"  class="input02">
                <label for="" class="placeholder2">Pancard Image</label>
            </div>
        </div>
        <div class="outer02">
        <div class="trial1">
        <input type="text" name="mobile_no" placeholder="" value="<?php echo $row['mobile_number'] ?>" class="input02">
        <label class="placeholder2">Mobile Number</label>
        </div>
        <div class="trial1">
        <input type="text" name="address" placeholder="" value="<?php echo $row['address'] ?>" class="input02">
        <label class="placeholder2">Address</label>
        </div>
        <div class="trial1">
        <input type="text" name="pincode" placeholder="" value="<?php echo $row['pincode'] ?>"class="input02">
        <label class="placeholder2">Pincode</label>
        </div></div>
        <div class="outer02">
        <div class="trial1">
        <input type="text" name="reference1" value="<?php echo $row['reference1'] ?>" placeholder="" class="input02">
        <label class="placeholder2">Reference 1</label>
        </div> 
        <div class="trial1"> 
        <select name="reference1_relation" id="" class="input02">
            <option value=""disabled selected>Relation With Reference</option>
            <option value="mother" <?php if($row['relation_refernce1'] === "mother"){ echo "selected" ;} ?>>Mother</option>
            <option value="father" <?php if($row['relation_refernce1'] === "father"){ echo 'selected'; } ?>>Father</option>
            <option value="brother" <?php if($row['relation_refernce1'] === "brother"){ echo 'selected'; } ?>>Brother</option>
            <option value="sister" <?php if($row['relation_refernce1'] === "sister"){ echo 'selected'; } ?>>Sister</option>
            <option value="friend" <?php if($row['relation_refernce1'] === "friend"){ echo 'selected'; } ?>>Friend</option>
        </select></div>
        <div class="trial1">
            <input type="text" name="ref1_mobile" value="<?php echo $row['reference1_mobile']  ?>" placeholder="" class="input02">
            <label for="" class="placeholder2">Reference 1 Mobile Number</label>
        </div>

        </div>
        <div class="outer02">
        <div class="trial1">
        <input type="text" name="reference2" value="<?php echo $row['reference2'] ?>" placeholder="" class="input02">
        <label class="placeholder2">Reference 2</label>
        </div>  
        <div class="trial1">
        <select name="reference2_relation" id="" class="input02">
            <option value=""disabled selected>Relation With Reference</option>
            <option value="mother" <?php if($row['relation_refernce2'] === 'mother') {echo 'selected';}  ?>>Mother</option>
            <option value="father" <?php if($row['relation_refernce2'] === 'father') {echo 'selected';}  ?>>Father</option>
            <option value="brother" <?php if($row['relation_refernce2'] === 'brother') {echo 'selected';}  ?>>Brother</option>
            <option value="sister" <?php if($row['relation_refernce2'] === 'sister') {echo 'selected';}  ?>>Sister</option>
            <option value="friend" <?php if($row['relation_refernce2'] === 'friend') {echo 'selected';}  ?>>Friend</option>
        </select>
        </div>
        <div class="trial1">
            <input type="text" name="ref2_mobile" value="<?php echo $row['reference2_mobile']  ?>" placeholder="" class="input02">
            <label for="" class="placeholder2">Reference 2 Contact Number</label>
        </div>

        </div>
    <div class="outer02">
        <div class="trial1">
        <input type="text" name="previous_company" value="<?php echo $row['previous_company'] ?>" placeholder="" class="input02">
        <label class="placeholder2">Previous Company</label>
        </div> 
        <div class="trial1">
        <input type="date" name="strt_date_previous_company" value="<?php echo $row['startdate_previous_company'] ?>" placeholder="" class="input02">
        <label class="placeholder2">Started From</label>
        </div>
        <div class="trial1">
        <input type="date" name="end_date_previous_company" placeholder="" value="<?php echo $row['enddate_previous_company'] ?>" class="input02">
        <label class="placeholder2">End Date</label>
        </div>
    </div>
    <div class="trial1">
    <select name="current_status" id="operator_status" class="input02" onchange="idlefunction()">
        <option value="" disabled selected >Choose Operator Status</option>
        <option value="idle" <?php if($row['current_status']==='idle'){ echo 'selected';} ?>>Idle</option>
        <option value="working" <?php if($row['current_status']==='working'){ echo 'selected';} ?>>Working</option>
    </select>
    </div>
    <div class="trial1">
        <select name="assetCode" id="" class="input02">
            <option value="" disabled selected>Choose Operator Driving Asset Code </option>
        <?php
    // Display the asset codes as dropdown options
    if (!empty($assetCodes)) {
        foreach ($assetCodes as $code) {
            echo '<option value="' . $code . '" ' . ($row['driving_asset_code'] === $code ? 'selected' : '') . '>' . $code . '</option>';        }
    } else {
        echo '<option value="">No asset codes found</option>';
    }
    ?>
        </select>
    </div>
<p>Right Click On Document And Open Image In New Tab For Bigger Version</p> 
 <div class="doc"><img src="img/<?php echo ($row['upload_dl']); ?>" alt=""></div>
<div class="doc"><img src="img/<?php echo ($row['upload_aadharcard']); ?>" alt=""></div>
<div class="doc"><img src="img/<?php echo ($row['upload_pancard']); ?>" alt=""></div>
    <button class="epc-button" type="submit">Edit Operator</button>
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