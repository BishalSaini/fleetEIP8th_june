<?php
include "partials/_dbconnect.php";
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

if(isset($_SESSION['success'])){
    $showAlert=true;
    unset($_SESSION['success']);
}
else if(isset($_SESSION['error'])){
    $showError=true;
    unset($_SESSION['error']);
}

$projectid=$_GET['id'];
$sql="SELECT * FROM `epcproject` where id='$projectid' and companyname='$companyname001'";
$result=mysqli_query($conn,$sql);
if(mysqli_num_rows($result)>0){
    $row=mysqli_fetch_assoc($result);
    $projectcodennumber=$row['projectcode'];
}


if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['addcontactbutton'])){
    include "partials/_dbconnect.php";
    $contactname=$_POST['contactname'];
    $email=$_POST['email'];
    $mobile=$_POST['mobile'];
    $department=$_POST['department'];
    $designation=$_POST['designation'];
    $projectidnumber=$_POST['projectidnumber'];
    $associatedto=$_POST['associatedto'];

    $contactdetail="INSERT INTO `epcprojectcontact`(`associated_to`,`projectid`, `companyname`, `name`,
     `email`, `mobile`, `department`, `designation`) VALUES ('$associatedto','$projectidnumber','$companyname001','$contactname','$email','$mobile','$department','$designation')";
    $result=mysqli_query($conn,$contactdetail);
    if($result){
        session_start();
        $_SESSION['success']='done';
        header("Location: projectinsight.php?id=" . urlencode($projectidnumber));
        exit();

    }
    else{
        session_start();
        $_SESSION['error']='done';
        header("Location: projectinsight.php?id=" . urlencode($projectidnumber));
        exit();


    }

}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Insight</title>
    <link rel="stylesheet" href="style.css">
    <script src="main.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <script src="suggestions.js"defer></script>
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
        <span class="alertText">Success<br class="clear"/></span>
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
 
<div class="projectinsightcontainer">
    <p><strong>Name: </strong><?php echo $row['projectname'] ?></p>
    <p><strong>Project Type: </strong><?php echo $row['project_type'] ?></p>
    <p><strong>Location: </strong><?php echo $row['district'].'-'. $row['state'] ?></p>
    <p>
    <strong>Start Date :</strong> <?php echo date('F Y', strtotime($row['start_date'])); ?> &nbsp;&nbsp;&nbsp;
    <strong>End Date :</strong> <?php echo date('F Y', strtotime($row['end_date'])); ?>
</p>
<p>    <strong>Project Value :</strong> <?php echo ($row['projectvalue']).' '. $row['unit']; ?>
</p>
<p id="projectinsightbutton">        <button class="tripupdate_generatecn" id="addprojectteammemberepc" onclick="showmemberform()">Add Team Member</button>
<button class="tripupdate_generatecn" id="linkanequipmentbutton" onclick="showequipmentform()">Link An Equipment</button>
</p>
    </div>

</div>
<form action="linkequipment.php" method="POST" autocomplete="off" class="outerform" enctype="multipart/form-data" id="linkequipmentform">
<div class="linkequipmentinner">
    <p class="headingpara">Link Equipment</p>
    <input type="hidden" name="linkequipmentprojectid" value="<?php echo $projectid ;?>">
    <div class="trial1">
        <input type="text" placeholder="" name="project_name" value="<?php echo $row['projectname'] ?>" class="input02" readonly>
        <label for="" class="placeholder2">Project Name</label>
    </div>
    <div class="trial1">
        <input type="text" id="autocomplete-input" placeholder="" name="rental_companyname" class="input02">
        <label for="" class="placeholder2">Rental Name</label>
        <div id="suggestions" class="suggestions"></div>

    </div> 
    <div class="outer02">
        <div class="trial1">
        <select class="input02" name="fleet_category" onchange="purchase_option()" id="oem_fleet_type" required>
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
        <select class="input02" name="type" id="fleet_sub_type" onchange="toggleRegistrationFields()" required>
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
    </div>


    <div class="outer02">
        <div class="trial1">
            <input type="text" name="make" placeholder="" class="input02">
            <label for="" class="placeholder2">Equipment Make</label>
        </div>
        <div class="trial1">
            <input type="text" name="model" placeholder="" class="input02">
            <label for="" class="placeholder2">Model</label>
        </div>
    

    </div>
    <div class="outer02">
    <div class="trial1">
            <input type="month" name="yom" placeholder="" class="input02">
            <label for="" class="placeholder2">YOM</label>
        </div>
        <div class="trial1">
            <input type="number" name="capacity" placeholder="" class="input02">
            <label for="" class="placeholder2">Capacity</label>
        </div>
        <select name="unit" id="projectinsightunit" class="input02">
                <option value=""disabled selected>Unit</option>
                <option value="Ton">Ton</option>
                <option value="Kgs">Kgs</option>
                <option value="KnM">KnM</option>
                <option value="Meter">Meter</option>
                <option value="M³">M³</option>
            </select>


    </div>
        <div class="outer02">
            <div class="trial1">
                <input type="date" placeholder="" name="wo_start" class="input02">
                <label for="" class="placeholder2">Work Order Start Date</label>
            </div>
            <div class="trial1">
                <input type="date" placeholder="" name="wo_end" class="input02">
                <label for="" class="placeholder2">Work Order End Date</label>
            </div>
        </div>
    <div class="outer02">
    <div class="trial1">
            <input type="text" placeholder="" name="monthly_rental" class="input02">
            <label for="" class="placeholder2">Monthly Rental</label>
        </div>
        <div class="trial1">
            <input type="text" placeholder="" name="mob" class="input02">
            <label for="" class="placeholder2">MOB</label>
        </div>
        <div class="trial1">
            <input type="text" placeholder="" name="demob" class="input02">
            <label for="" class="placeholder2">DeMOB</label>
        </div>


    </div>
    <div class="outer02">
        <select name="shift" id="projectinsightshiftdd" class="input02" onchange="projectinsightshift()">
            <option value=""disabled selected>Working Shift</option>
            <option value="Single Shift">Single Shift</option>
            <option value="Double Shift">Double Shift</option>
            <option value="Flexi Shift">Flexi Shift</option>
            </select>
        <select name="engine_hour" id="projectinsightenginehour" class="input02">
            <option value=""disabled selected>Engine Hours</option>
            <option value="200">200 Hours</option>
            <option value="208">208 Hours</option>
            <option value="260">260 Hours</option>
            <option value="270">270 Hours</option>
            <option value="280">280 Hours</option>
            <option value="300">300 Hours</option>
            <option value="312">312 Hours</option>
            <option value="360">360 Hours</option>
            <option value="400">400 Hours</option>
            <option value="416">416 Hours</option>
            <option value="460">460 Hours</option>
            <option value="572">572 Hours</option>
            <option value="672">672 Hours</option>
            <option value="720">720 Hours</option>
        </select>
        <select name="workinghour" id="projectinsightworkinghour" class="input02">
                    <option value=""disabled selected>Working Hours</option>
                <option value="8">8 Hours</option>
                <option value="10">10 Hours</option>
                <option value="12">12 Hours</option>
                <option value="14">14 Hours</option>
                <option value="16">16 Hours</option>

                </select>

    </div>
    <div class="outer02">
        <select name="operator" id="" class="input02">
            <option value=""disabled selected>Operator Count</option>
            <option value="Not Applicable">Not Applicable</option>

            <option value="1">1 Operator</option>
            <option value="2">2 Operator</option>
            <option value="3">3 Operator</option>
        </select>
        <select name="helper" id="" class="input02">
            <option value=""disabled selected>Helper Count</option>
            <option value="Not Applicable">Not Applicable</option>
            <option value="1">1 Helper</option>
            <option value="2">2 Helper</option>
            <option value="3">3 Helper</option>
        </select>
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
        <div class="trial1" id="reg_number">
        <input type="text" placeholder="" name="reg" class="input02">
        <label for="" class="placeholder2">Registration Number</label>
    </div>
    <div class="trial1" id="chassis_number" >
        <input type="text" placeholder="" name="chassis_no" class="input02">
        <label for="" class="placeholder2">Chassis Number</label>
    </div>
            <div class="trial1">
            <input type="file" name="wo" placeholder="" class="input02">
            <label for="" class="placeholder2">Upload Work Order</label>
        </div>
    <button class="epc-button" name="projectinsightlinkequipment">Submit</button>
</div>
</form>




<form action="projectinsight.php?id=<?php $projectid ?>" method="POST" autocomplete="off" id="epcprojectcontactinfo" class="outerform">
    <div class="addteamprojectinner">
        <p class="headingpara">Add Team Member</p>
        <div class="trial1">
        <select name="associatedto" id="" class="input02">
            <option value=""disabled selected>Contact Associated To</option>
            <option value="Consultant Team">Consultant Team</option>
            <option value="Client Team">Client Team</option>
            <option value="<?php echo ($companyname001 )?> Team"><?php echo ucwords($companyname001) ?> Team</option>
        </select>

        </div>
        <input type="hidden" name="projectidnumber" value="<?php echo $projectid; ?>">
        <div class="trial1">
            <input type="text" placeholder="" name="contactname" class="input02">
            <label for="" class="placeholder2">Name</label>
        </div>
        <div class="trial1">
            <input type="text" placeholder="" name="email" class="input02">
            <label for="" class="placeholder2">Email</label>
        </div>
        <div class="trial1">
            <input type="text" placeholder="" name="mobile" class="input02">
            <label for="" class="placeholder2">Cell-Phone</label>
        </div>
        <div class="trial1">
            <input type="text" placeholder="" name="department" class="input02">
            <label for="" class="placeholder2">Department</label>
        </div>

        <div class="trial1">
            <input type="text" name="designation" placeholder="" class="input02">
            <label for="" class="placeholder2">Designation</label>
        </div>
        <button class="epc-button" name="addcontactbutton">Submit</button>
    </div>
</form>
<div class="projectcontactepc">
    <?php 
    $teammember = "SELECT * FROM `epcprojectcontact` WHERE companyname='$companyname001' AND projectid='$projectid'";
    $teammemberresult = mysqli_query($conn, $teammember);

    if (mysqli_num_rows($teammemberresult) > 0) {
        $groupedContacts = [];

        // Group contacts by associated_to
        while ($rowteam = mysqli_fetch_assoc($teammemberresult)) {
            $associatedTo = $rowteam['associated_to'];
            $groupedContacts[$associatedTo][] = $rowteam;
        }

        // Display tables for each group
        foreach ($groupedContacts as $associatedTo => $contacts) {
            echo "<h3 class='quotation-title' style='width: 80%; margin-left:10%; border: none;margin-top:20px; margin-bottom: -30px;'>$associatedTo</h3>";
            echo '<table class="quotation-table" style="width: 80%;">';
            echo '<tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Mobile</th>
                    <th>Department</th>
                    <th>Designation</th>
                    <th>Action</th>
                  </tr>';

            foreach ($contacts as $rowteam) {
                echo "<tr>
                        <td>{$rowteam['name']}</td>
                        <td>{$rowteam['email']}</td>
                        <td>{$rowteam['mobile']}</td>
                        <td>{$rowteam['department']}</td>
                        <td>{$rowteam['designation']}</td>
                        <td data-label='Actions'>
                            <a href='editprojectteam.php?id={$rowteam['id']}&projectid={$projectid}' class='quotation-icon' title='Edit'>
                                <i style='width: 22px; height: 22px;' class='bi bi-pencil'></i>
                            </a>
                            <a href='deleteprojectcontact.php?id={$rowteam['id']}&projectid={$projectid}' class='quotation-icon' title='Delete' onclick='return confirmDelete();'>
                                <i style='width: 22px; height: 22px;' class='bi bi-trash'></i>
                            </a>
                        </td>
                      </tr>";
            }

            echo '</table>';

        }
    } 
    ?>

    <div class="linkedequipmentlist">


    <?php
    // Fetch fleet information
    $result = mysqli_query($conn, "SELECT * FROM linked_equipment WHERE companyname='$companyname001' and projectid='$projectid' ORDER BY category, id DESC");
     
    if(mysqli_num_rows($result)){ ?>
            <h3><?php echo ucwords ($row['projectname'] ) ?>`s Linked Equipment</h3>

        <table class="members_table" id="members_tablecontent">


   <?php }
    // Array to hold grouped fleet data
    $groupedFleet = array();

    // Group the results by fleet_category
    while ($row = mysqli_fetch_assoc($result)) {
        $category = $row['category'];
        if (!isset($groupedFleet[$category])) {
            $groupedFleet[$category] = array();
        }
        $groupedFleet[$category][] = $row;
    }

    // Display the grouped fleet data
    foreach ($groupedFleet as $category => $fleets) {
        echo '<tr><td ><h2 class="categoryheading">' . htmlspecialchars($category) . '</h2></td></tr>'; // Print the category heading
        
        $loop_count = 0; // Counter for items in the row
        echo '<tr>'; // Start a new row

        $categoryShortForms = array(
            'Aerial Work Platform' => 'AWP',
            'Concrete Equipment' => 'CE',
            'EarthMovers and Road Equipments' => 'EM',
            'Material Handling Equipments' => 'MHE',
            'Ground Engineering Equipments' => 'GEE',
            'Trailor and Truck' => 'T&T',
            'Generator and Lighting' => 'GL'
        );
        
        $loop_count = 0;
        foreach ($fleets as $row) {
            // Determine the short form based on the category
            $categoryShortForm = isset($categoryShortForms[$row['category']]) ? $categoryShortForms[$row['category']] : 'FLEET EIP';
        
            if ($loop_count > 0 && $loop_count % 4 == 0) {
                echo '</tr><tr>'; // Close current row and start a new row
            }
            echo '<td>';
            echo '<div class="viewfleet_outer">';
            echo '<div class="fleetcard">';
            // Print the category short form
            echo $categoryShortForm ;
        
            echo '</div>';
        
            echo '<div class="content">';
            echo '<p><strong>Company:</strong> ' . htmlspecialchars($row['rental_name']) . '</p>';
            if (!empty($row['reg'])) {
                echo '<p><strong>Registration Num:</strong> ' . htmlspecialchars($row['reg']) . '</p>';
            }
            
            if (!empty($row['chassis_no'])) {
                echo '<p><strong>Chassis Num:</strong> ' . htmlspecialchars($row['chassis_no']) . '</p>';
            }
                        echo '<p><strong>Make-Model:</strong> ' . htmlspecialchars($row['make']) .' - ' . htmlspecialchars($row['model']) . '</p>';
            echo '<p><strong>YOM:</strong> ' . (new DateTime($row['yom']))->format('F Y') . '</p>';
            echo '<p><strong>WO Start:</strong> ' . (new DateTime($row['wo_start']))->format('jS F Y') . '</p>';
            echo '<p><strong>WO End:</strong> ' . (new DateTime($row['wo_end']))->format('jS F Y') . '</p>';
            echo '<p><strong>Monthly Rental:</strong> ' . htmlspecialchars($row['monthly_rental']) . '</p>';

             echo '</div>';
        
            echo '<div class="viewfleet2_btncontainer">';
            echo '<a href="viewhiredequipment.php?id=' . htmlspecialchars($row['id']) .  '&&projectid=' . $projectid . '">';
            echo '<i title="View & Edit" class="bi bi-eye"></i>';
            echo '</a>';
            echo '<a href="deletelinkedequipment.php?id=' . htmlspecialchars($row['id']) . '&&projectid=' . $projectid . '" onclick="return confirmDelete();">';
            echo '<i title="Delete" class="bi bi-trash"></i>';
            echo '</a>';
            echo '<a ' . (empty($row['wo']) ? 'hidden' : '') . ' href="img/' . htmlspecialchars($row['wo']) . '" target="_blank">';
            echo '<i title="View & Download Work Order" class="bi bi-download"></i>';
            echo '</a>';
            echo '</div>'; 
        
            echo '</div>'; // Close viewfleet_outer
            echo '</td>'; // Close table cell
            $loop_count++;
        }
        
        // Close the last row if it's not already closed
        if ($loop_count % 4 != 0) {
            echo '</tr>'; // Close the row if there are less than 4 items
        }}
        ?>
        </table>

    </div>
</div>
<div class="projectrequirement">
    <?php
    // echo $projectcodennumber;
    include "partials/_dbconnect.php";
    
    $myrequirement = "SELECT * FROM `req_by_epc` WHERE posted_by='$companyname001' AND project_code='$projectcodennumber' order by `id` DESC";
    $resultmyproject = mysqli_query($conn, $myrequirement);
    
    if ($resultmyproject && mysqli_num_rows($resultmyproject) > 0) { ?>
      <p class="fulllength">Projects Requirements</p>
    <?php    echo '<table class="purchase_table" id="logi_rates"><tr>';

        $loop_count = 0; // Initialize the counter

        while ($row3 = mysqli_fetch_assoc($resultmyproject)) {
            if ($loop_count > 0 && $loop_count % 4 == 0) {
                echo '</tr><tr>'; 
            }
            ?>
            <td>
                <div class="custom-card" id="application_card" onclick="window.location. href='editequipmentrental.php?id=<?php echo $row3['id']; ?>&&projectid=<?php echo $projectid; ?>'">
                <p class="insidedetails"><strong>Valid Till:</strong> <?php echo htmlspecialchars((new DateTime($row3['reqvalid']))->format('jS-M Y')); ?></p>
                <p class="insidedetails"><strong>Equipment:</strong> <?php echo htmlspecialchars($row3['equipment_type']); ?></p>
<p class="insidedetails"><strong>Capacity:</strong> <?php echo htmlspecialchars($row3['equipment_capacity']) . '-' . htmlspecialchars($row3['unit']); ?></p>
<p class="insidedetails"><strong>Contact Person:</strong> <?php echo htmlspecialchars($row3['contact_person']); ?></p>
<p class="insidedetails"><strong>Location:</strong> <?php echo htmlspecialchars($row3['district']) . '-' . htmlspecialchars($row3['state']); ?></p>
<p class="insidedetails" id="button_container_resume">
                        <!-- <a title="Edit Project" href='editequipmentrental.php?id=<?php echo $row3['id']; ?>&&projectid=<?php echo $projectid; ?>'>
                            <button class="downloadresume" type="button"><i class="fa-regular fa-edit"></i></button>
                        </a> -->
                        <!-- <a title="Delete Project" href='deleteproject.php?id=<?php echo $row3['id']; ?>' onclick="return confirmDelete();">
    <button class="downloadresume" type="button"><i class="fa-solid fa-trash"></i></button>
</a> -->
                  </p>


                    <div class="custom-card__arrow">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </div>
            </td>
            <?php
            $loop_count++;
        }
        echo '</tr></table>';
    } else {
        echo '<p>No project requirements found.</p>'; // Handle no results case
    }
    ?>
</div>
</body>
<script>
    function confirmDelete() {
        return confirm("Are you sure you want to delete ?");
    }

    function toggleRegistrationFields() {
        const fleetType = document.getElementById("fleet_sub_type").value;
        const regNumberDiv = document.getElementById("reg_number");
        const chassisNumberDiv = document.getElementById("chassis_number");

        // Define which options have a registration number
        const regRequiredTypes = [
                "Scissor Lift Diesel",
                "Scissor Lift Electric",
                "Spider Lift",
                "Self Propelled Straight Boomlift",
                "Truck Mounted Articulated Boomlift",
                "Truck Mounted Straight Boomlift",
                "Excavator",
                "Milling Machine",
                "Hydraulic Crawler Crane",
                "Mechanical Crawler Crane",
                "Telescopic Crawler Crane",
                "Hydraulic Drilling Rig",
                "Rotary Drilling Rig",
                "Vibro Hammer"
            
            ];

        // Show or hide fields based on selection
        if (regRequiredTypes.includes(fleetType)) {
            regNumberDiv.style.display = "none"; // Show registration number input
            chassisNumberDiv.style.display = "block"; // Hide chassis number input
        } else {
            regNumberDiv.style.display = "block"; // Hide registration number input
            chassisNumberDiv.style.display = "none"; // Show chassis number input
        }
    }

    // Optional: Initialize the fields on page load
    window.onload = function() {
        toggleRegistrationFields(); // Set initial state based on default selection
    };
</script>
</html>
