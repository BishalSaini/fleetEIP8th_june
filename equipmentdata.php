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

if($_SERVER['REQUEST_METHOD']==='POST'){
    include "partials/_dbconnect.php";
    $fleet_category=$_POST['fleet_category'];
    $type=$_POST['type'];
    $make=$_POST['make'];
    $model=$_POST['model'];
    $cap=$_POST['cap'];
    $unit=$_POST['unit'];
    $radiuscap=$_POST['radiuscap'];
    $height=$_POST['height'];
    $luffer_available=$_POST['luffer_available'];
    $flyjib_available=$_POST['flyjib_available'];

    $radius=$_POST['radius'];
    $launchyear=$_POST['launchyear'];
    $basicmainboom=$_POST['basicmainboom'];
    $fixedjib=$_POST['fixedjib'];
    $luffing=$_POST['luffing'];
    $boomcombination=$_POST['boomcombination'] ?? '';
    $boom_flyjib_mainboom=$_POST['boom_flyjib_mainboom'];
    $boom_flyjib_flyjib=$_POST['boom_flyjib_flyjib'];
    $boom_luffer_mainboom=$_POST['boom_luffer_mainboom'];
    $boom_luffer_luffingjib=$_POST['boom_luffer_luffingjib'];
    $fueltank=$_POST['fueltank'];
    $hydraulictank=$_POST['hydraulictank'];
    $enginemake=$_POST['enginemake'];
    $enginemodel=$_POST['enginemodel'];
    $cw1desc=$_POST['cw1desc'];
    $cw1cap=$_POST['cw1cap'];
    $cw1nos=$_POST['cw1nos'];
    $cw2desc=$_POST['cw2desc'];
    $cw2cap=$_POST['cw2cap'];
    $cw2nos=$_POST['cw2nos'];
    $cw3desc=$_POST['cw3desc'];
    $cw3cap=$_POST['cw3cap'];
    $cw3nos=$_POST['cw3nos'];
    $cw4desc=$_POST['cw4desc'];
    $cw4cap=$_POST['cw4cap'];
    $cw4nos=$_POST['cw4nos'];
    
    $cw5desc=$_POST['cw5desc'];
    $cw5cap=$_POST['cw5cap'];
    $cw5nos=$_POST['cw5nos'];
    $cw6desc=$_POST['cw6desc'];
    $cw6cap=$_POST['cw6cap'];
    $cw6nos=$_POST['cw6nos'];

    $hook1=$_POST['hook1'];
    $hook2=$_POST['hook2'];
    $hook3=$_POST['hook3'];
    $hook4=$_POST['hook4'];
    $hook5=$_POST['hook5'];
    $hook6=$_POST['hook6'];

    $cabin_dimension=$_POST['cabin_dimension'];
    $cabinweight=$_POST['cabinweight'];
    $cabinunit=$_POST['cabinunit'];
    $cabintrailor=$_POST['cabintrailor'];
    $mainwinchlength=$_POST['mainwinchlength'];
    $mainwinchdia=$_POST['mainwinchdia'];
    $secondwinchlength=$_POST['secondwinchlength'];
    $secondwinchdia=$_POST['secondwinchdia'];
    $auxiwinchlength=$_POST['auxiwinchlength'];
    $auxiwinchdia=$_POST['auxiwinchdia'];
    $currentstatus=$_POST['currentstatus'];

    $loadchart = $_FILES['loadchart']['name'];
    $temp_file_path = $_FILES['loadchart']['tmp_name'];
    $random_string = bin2hex(random_bytes(8)); // Generates an 8-byte random string
    $uniqueloadchartname = $random_string . '_' . $loadchart;
    $folder1 = 'img/' . $uniqueloadchartname;
    move_uploaded_file($temp_file_path, $folder1);

    $image = $_FILES['image']['name'];
    $temp_file_path = $_FILES['image']['tmp_name'];
    $random_string2 = bin2hex(random_bytes(8)); // Generates an 8-byte random string
    $uniqueimage = $random_string2 . '_' . $image;
    $folder2 = 'img/' . $uniqueimage;
    move_uploaded_file($temp_file_path, $folder2);
    

    $insertdata = "INSERT INTO adminfleet (
        `image`,`fleet_category`, `loadchart`, `height`, `flyjib_available`, `luffer_available`, `type`, `make`, `model`, `cap`, `unit`, `radiuscap`, `radius`, `launchyear`,
        `basicmainboom`, `fixedjib`, `luffing`, `boomcombination`,
        `boom_flyjib_mainboom`, `boom_flyjib_flyjib`,
        `boom_luffer_mainboom`, `boom_luffer_luffingjib`,
        `fueltank`, `hydraulictank`, `enginemake`, `enginemodel`,
        `cw1desc`, `cw1cap`, `cw1nos`,
        `cw2desc`, `cw2cap`, `cw2nos`,
        `cw3desc`, `cw3cap`, `cw3nos`,
        `cw4desc`, `cw4cap`, `cw4nos`,
        `cw5desc`, `cw5cap`, `cw5nos`,
        `cw6desc`, `cw6cap`, `cw6nos`,
        `hook1`, `hook2`, `hook3`, `hook4`, `hook5`, `hook6`,
        `cabin_dimension`, `cabinweight`, `cabinunit`, `cabintrailor`,
        `mainwinchlength`, `mainwinchdia`,
        `secondwinchlength`, `secondwinchdia`,
        `auxiwinchlength`, `auxiwinchdia`, `current_status`, `added_by`
    ) VALUES (
        '$uniqueimage','$fleet_category','$uniqueloadchartname','$height','$flyjib_available','$luffer_available', '$type', '$make', '$model', '$cap', '$unit', '$radiuscap', '$radius', '$launchyear',
        '$basicmainboom', '$fixedjib', '$luffing', '$boomcombination',
        '$boom_flyjib_mainboom', '$boom_flyjib_flyjib',
        '$boom_luffer_mainboom', '$boom_luffer_luffingjib',
        '$fueltank', '$hydraulictank', '$enginemake', '$enginemodel',
        '$cw1desc', '$cw1cap', '$cw1nos',
        '$cw2desc', '$cw2cap', '$cw2nos',
        '$cw3desc', '$cw3cap', '$cw3nos',
        '$cw4desc', '$cw4cap', '$cw4nos',
        '$cw5desc', '$cw5cap', '$cw5nos',
        '$cw6desc', '$cw6cap', '$cw6nos',
        '$hook1', '$hook2', '$hook3', '$hook4', '$hook5', '$hook6',
        '$cabin_dimension', '$cabinweight', '$cabinunit', '$cabintrailor',
        '$mainwinchlength', '$mainwinchdia',
        '$secondwinchlength', '$secondwinchdia',
        '$auxiwinchlength', '$auxiwinchdia','$currentstatus', '$companyname001'
    )";
    $resultinsert=mysqli_query($conn,$insertdata);
if($resultinsert){
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
    <title>Equipment</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="tiles.css">
    <script src="main.js"></script>
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
        echo  '<label>
        <input type="checkbox" class="alertCheckbox" autocomplete="off" />
        <div class="alert notice">
          <span class="alertClose">X</span>
          <span class="alertText_addfleet"><b>Success!</b>
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

<div class="add_fleet_btn_new" id="rentalclientbutton" >
<button class="generate-btn"> 
    <article class="article-wrapper" onclick="window.location.href='equipment.php'" id="rentalclientbuttoncontainer"> 
  <div class="rounded-lg container-projectss ">
    </div>
    <div class="project-info">
      <div class="flex-pr">
        <div class="project-title text-nowrap">View Equipment</div>
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

    <form action="equipmentdata.php" method="POST" autocomplete="off"   class="outerform" enctype="multipart/form-data">
        <div class="equipdatainner">
            <p class="headingpara">Add Equipment</p>
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
            <option value="Shotcrete Machine"class="cq_options" id="concrete_equipment_option7">Shotcrete Machine</option>
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
                <select name="make" id="" class="input02">
                    <option value=""disabled selected>Equipment Make</option>
                <option value="ACE">ACE</option>
  <option value="Ajax Fiori">Ajax Fiori</option>
  <option value="AMW">AMW</option>
  <option value="Apollo">Apollo</option>
  <option value="Aquarius">Aquarius</option>
  <option value="Ashok Leyland">Ashok Leyland</option>
  <option value="Atlas Copco">Atlas Copco</option>
  <option value="Belaz">Belaz</option>
  <option value="Bemi">Bemi</option>
  <option value="BEML">BEML</option>
  <option value="Bharat Benz">Bharat Benz</option>
  <option value="Bob Cat">Bob Cat</option>
  <option value="Bull">Bull</option>
  <option value="Bauer">Bauer</option>
  <option value="BMS">BMS</option>
  <option value="Bomag">Bomag</option>
  <option value="Case">Case</option>
  <option value="Cat">Cat</option>
  <option value="Cranex">Cranex</option>
  <option value="Casagrande">Casagrande</option>
  <option value="Coles">Coles</option>
  <option value="CHS">CHS</option>
    <option value="Doosan">Doosan</option>
    <option value="Dynapac">Dynapac</option>
    <option value="Demag">Demag</option>
    <option value="Eicher">Eicher</option>
    <option value="Escorts">Escorts</option>
    <option value="Fuwa">Fuwa</option>
    <option value="Fushan">Fushan</option>
    <option value="Genie">Genie</option>
    <option value="Godrej">Godrej</option>
    <option value="Grove">Grove</option>
    <option value="HAMM AG">HAMM AG</option>
    <option value="Haulott">Haulott</option>
    <option value="Hidromek">Hidromek</option>
    <option value="Hydrolift">Hydrolift</option>
    <option value="Hyundai">Hyundai</option>
    <option value="Hidrocon">Hidrocon</option>
    <option value="Ingersoll Rand">Ingersoll Rand</option>
    <option value="Isuzu">Isuzu</option>
    <option value="IHI">IHI</option>
    <option value="JCB">JCB</option>
    <option value="JLG">JLG</option>
    <option value="Jaypee">Jaypee</option>
    <option value="Jinwoo">Jinwoo</option>
    <option value="John Deere">John Deere</option>
    <option value="Jackson">Jackson</option>
    <option value="Kamaz">Kamaz</option>
    <option value="Kato">Kato</option>
    <option value="Kobelco">Kobelco</option>
    <option value="Komatsu">Komatsu</option>
    <option value="Konecranes">Konecranes</option>
    <option value="Kubota">Kubota</option>
    <option value="KYB Conmat">KYB Conmat</option>
    <option value="Krupp">Krupp</option>
    <option value="Kirloskar">Kirloskar</option>
    <option value="Kohler">Kohler</option>
    <option value="L&T">L&T</option>
    <option value="Leeboy">Leeboy</option>
    <option value="LGMG">LGMG</option>
    <option value="Liebherr">Liebherr</option>
    <option value="Link-Belt">Link-Belt</option>
    <option value="Liugong">Liugong</option>
    <option value="Lorain">Lorain</option>
    <option value="Mahindra">Mahindra</option>
    <option value="Magni">Maqni</option>
    <option value="Manitou">Manitou</option>
    <option value="Maintowoc">Maintowoc</option>
    <option value="Marion">Marion</option>
    <option value="MAIT">MAIT</option>
    <option value="Marchetti">Marchetti</option>
    <option value="Noble Lift">Noble Lift</option>
    <option value="New Holland">New Holland</option>
    <option value="Palfinger">Palfinger</option>
    <option value="Potain">Potain</option>
    <option value="Putzmeister">Putzmeister</option>
    <option value="P&H">P&H</option>
    <option value="Pinguely">Pinguely</option>
    <option value="PTC">PTC</option>
    <option value="Reva">Reva</option>
    <option value="Sany">Sany</option>
    <option value="Scania">Scania</option>
    <option value="Schwing Stetter">Schwing Stetter</option>
    <option value="SDLG">SDLG</option>
    <option value="Sennebogen">Sennebogen</option>
    <option value="Shuttle Lift">Shuttle Lift</option>
    <option value="Skyjack">Skyjack</option>
    <option value="Snorkel">Snorkel</option>
    <option value="Soilmec">Soilmec</option>
    <option value="Socma">Socma</option>

    <option value="Socma">Socma</option>
    <option value="Sunward">Sunward</option>
    <option value="Tadano">Tadano</option>
    <option value="Tata Hitachi">Tata Hitachi</option>
    <option value="TATA">TATA</option>
    <option value="Terex">Terex</option>
    <option value="TIL">TIL</option>
    <option value="Toyota">Toyota</option>
    <option value="Teupen">Teupen</option>
    <option value="Unicon">Unicon</option>
    <option value="URB Engineering">URB Engineering</option>
    <option value="Universal Construction">Universal Construction</option>
    <option value="Unipave">Unipave</option>
    <option value="Vogele">Vogele</option>
    <option value="Volvo">Volvo</option>
    <option value="Wirtgen Group">Wirtgen Group</option>
    <option value="XCMG Group">XCMG Group</option>
    <option value="XGMA">XGMA</option>
    <option value="Yanmar">Yanmar</option>
    <option value="Zoomlion">Zoomlion</option>
    <option value="ZPMC">ZPMC</option>
    <option value="Others">Others</option>
</select>

            </div>
            <div class="trial1">
                <input type="text" name="model" placeholder="" class="input02">
                <label for="" class="placeholder2">Model</label>
            </div>

            </div>
            <div class="outer02">
            <div class="trial1">
                <input type="text" name="cap" placeholder="" class="input02">
                <label for="" class="placeholder2">Capacity</label>
            </div>
            <div class="trial1">
            <select name="unit" id="" class="input02" required>
            <option value="" disabled selected> Unit</option>
                <option value="Ton">Ton</option>
                <option value="Kgs">Kgs</option>
                <option value="KnM">KnM</option>
                <option value="Meter">Meter</option>
                <option value="M³">M³</option>
            </select>
            </div>
            </div>
            <p class="meterdescription">Equipment Lifting Capacity At Certain Height & Radius </p>
            <div class="outer02">
                <div class="trial1">
                    <input type="text" placeholder="" name="height" class="input02">
                    <label for="" class="placeholder2">At Height In Meter</label>
                </div>
                <div class="trial1">
                    <input type="text" placeholder="" name="radius" class="input02">
                    <label for="" class="placeholder2">At Radius In Meter</label>
                </div>
                <div class="trial1">
                    <input type="text" placeholder="" name="radiuscap" class="input02">
                    <label for="" class="placeholder2">Capacity In Ton</label>
                </div>


            </div>
            <div class="trial1">
                <input type="number" placeholder="" name="launchyear"  class="input02">
                <label for="" class="placeholder2">Launch Year</label>
            </div>
            <!-- <div class="trial1">
                    <input type="text" name="boomcombination" placeholder="" class="input02">
                    <label for="" class="placeholder2">Boom Combination</label>
                </div> -->
                <p class="meterdescription">Main Boom :</p>
                <div class="trial1">
                    <input type="" oninput="copyValue(this.value)" placeholder=""  class="input02">
                    <label for="" class="placeholder2">Main Boom</label>
                </div>

                <p class="meterdescription" id="">Boom + Flyjib :</p>

                <div class="trial1">
                <select name="flyjib_available" id="flyjib_availability" onchange="flyjibinputinfo()" class="input02">
                        <option value=""disabled selected>Flyjib Availability</option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select>

                </div>
                <div class="outer02" id="jibheadingcontent">
                    <div class="trial1">
                        <input type="text" readonly name="boom_flyjib_mainboom" placeholder="" class="input02">
                        <label for="" class="placeholder2">Main Boom</label>
                    </div>
                     <input readonly type="text" id="plusiconinput" class="input02" value="<?php echo '+' ?>">
                    <div class="trial1">
                        <input type="text" name="boom_flyjib_flyjib" oninput="copyValue2(this.value)" placeholder="" class="input02">
                        <label for="" class="placeholder2">Fly Jib</label>
                    </div>

                </div>

                <p class="meterdescription" id="">Boom + Luffer :</p>

                <div class="trial1">
                <select name="luffer_available" id="luffer_availability" onchange="lufferinputinfo()" class="input02">
                        <option value=""disabled selected>Luffer Availability</option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select>

                </div>

                <div class="outer02" id="lufferheadingcontent">
                    <div class="trial1">
                        <input type="text" readonly name="boom_luffer_mainboom" placeholder="" class="input02">
                        <label for="" class="placeholder2">Main Boom</label>
                    </div>
                     <input readonly type="text" id="plusiconinput" class="input02" value="<?php echo '+' ?>">
                    <div class="trial1">
                        <input type="text" name="boom_luffer_luffingjib" oninput="copyvalue3(this.value)" placeholder="" class="input02">
                        <label for="" class="placeholder2">Luffing Jib</label>
                    </div>

                </div>
                <br>
                <p class="meterdescription">Boom Combination:</p>
            <div class="outer02">
                <div class="trial1">
                <input type="text" readonly name="basicmainboom" placeholder=""  class="input02">
                <label for="" class="placeholder2">Basic Main Boom </label>

                </div>
                <div class="trial1">
                    <input type="text" readonly name="fixedjib" placeholder="" class="input02">
                    <label for="" class="placeholder2">Fixed Jib</label>
                </div>
                <div class="trial1">
                    <input type="text" readonly name="luffing" placeholder="" class="input02">
                    <label for="" class="placeholder2">Luffing Jib</label>
                </div>
            </div>
<br>
                <div class="outer02">
                    <div class="trial1">
                        <input type="text" placeholder="" name="fueltank" class="input02">
                        <label for="" class="placeholder2">Fuel Tank</label>
                    </div>
                    <div class="trial1">
                        <input type="text" placeholder="" name="hydraulictank" class="input02">
                        <label for="" class="placeholder2">Hydraulic Tank</label>
                    </div>
                </div>
                <div class="outer02">
                    <div class="trial1">
                        <input type="text" placeholder="" name="enginemake" class="input02">
                        <label for="" class="placeholder2">Engine Make</label>
                    </div>
                    <div class="trial1">
                        <input type="text" placeholder="" name="enginemodel" class="input02">
                        <label for="" class="placeholder2">Engine Model</label>
                    </div>
                </div>
                <p class="meterdescription" >Counter Weight Description :</p>

                <div class="outer02">
    <div class="trial1">
        <textarea type="text" name="cw1desc" placeholder="" class="input02"></textarea>
        <label for="" class="placeholder2">CW plate description</label>
    </div>
    <div class="trial1">
        <input type="number" step="0.1" name="cw1cap" placeholder="" class="input02">
        <label for="" class="placeholder2">Capacity In Ton</label>
    </div>
    <div class="trial1">
        <input type="number" step="0.1" name="cw1nos" placeholder="" class="input02">
        <label for="" class="placeholder2">Nos</label>
    </div>
    <div class="trial1 abcd" id="icon1">
            <i class="fa-solid fa-plus" onclick="showcw2()"></i>
            </div>
</div>

                <div class="outer02" id="cw2">
                    <div class="trial1">
                    <textarea type="text" name="cw2desc" placeholder=""  class="input02"></textarea>
                    <label for="" class="placeholder2">CW plate description</label>

                    </div>
                    <div class="trial1">
                    <input type="number" step="0.1" name="cw2cap" placeholder=""  class="input02">
                    <label for="" class="placeholder2">Capacity In Ton</label>

                    </div>
                    <div class="trial1">
                    <input type="number" step="0.1" name="cw2nos" placeholder=""  class="input02">
                    <label for="" class="placeholder2">Nos</label>

                    </div>
                    <div class="trial1 abcd" id="icon2">
            <i class="fa-solid fa-plus" onclick="showcw3()"></i>
            </div>


                </div>

                <div class="outer02" id="cw3">
                    <div class="trial1">
                    <textarea type="text" name="cw3desc" placeholder=""  class="input02"></textarea>
                    <label for="" class="placeholder2">CW plate description</label>

                    </div>
                    <div class="trial1">
                    <input type="number" step="0.1" name="cw3cap" placeholder=""  class="input02">
                    <label for="" class="placeholder2">Capacity In Ton</label>

                    </div>
                    <div class="trial1">
                    <input type="number" step="0.1" name="cw3nos" placeholder=""  class="input02">
                    <label for="" class="placeholder2">Nos</label>

                    </div>
                    <div class="trial1 abcd" id="icon3">
            <i class="fa-solid fa-plus" onclick="showcw4()"></i>
            </div>


                </div>

                <div class="outer02" id="cw4">
                    <div class="trial1">
                    <textarea type="text" name="cw4desc" placeholder=""  class="input02"></textarea>
                    <label for="" class="placeholder2">CW plate description</label>

                    </div>
                    <div class="trial1">
                    <input type="number" step="0.1" name="cw4cap" placeholder=""  class="input02">
                    <label for="" class="placeholder2">Capacity In Ton</label>

                    </div>
                    <div class="trial1">
                    <input type="number" step="0.1" name="cw4nos" placeholder=""  class="input02">
                    <label for="" class="placeholder2">Nos</label>

                    </div>
                    <div class="trial1 abcd" id="icon4">
            <i class="fa-solid fa-plus" onclick="showcw5()"></i>
            </div>


                </div>

                <div class="outer02" id="cw5">
                    <div class="trial1">
                    <textarea type="text" name="cw5desc" placeholder=""  class="input02"></textarea>
                    <label for="" class="placeholder2">CW plate description</label>

                    </div>
                    <div class="trial1">
                    <input type="number" step="0.1" name="cw5cap" placeholder=""  class="input02">
                    <label for="" class="placeholder2">Capacity In Ton</label>

                    </div>
                    <div class="trial1">
                    <input type="number" step="0.1" name="cw5nos" placeholder=""  class="input02">
                    <label for="" class="placeholder2">Nos</label>

                    </div>
                    <div class="trial1 abcd" id="icon5">
            <i class="fa-solid fa-plus" onclick="showcw6()"></i>
            </div>


                </div>

                <div class="outer02" id="cw6">
                    <div class="trial1">
                    <textarea type="text" name="cw6desc" placeholder=""  class="input02"></textarea>
                    <label for="" class="placeholder2">CW plate description</label>

                    </div>
                    <div class="trial1">
                    <input type="number" step="0.1" name="cw6cap" placeholder=""  class="input02">
                    <label for="" class="placeholder2">Capacity In Ton</label>

                    </div>
                    <div class="trial1">
                    <input type="number" step="0.1" name="cw6nos" placeholder=""  class="input02">
                    <label for="" class="placeholder2">Nos</label>

                    </div>

                </div>
                <p class="meterdescription">Hook blocks as per load chart</p>
                <div class="outer02">
                <div class="trial1" id="hbinput">
                    <input type="number" step="0.1" name="hook1" placeholder="" class="input02">
                    <label for="" class="placeholder2">Hook Block Capacity In Ton</label>
                </div>
                <div class="trial1 abcd" id="hbicon1">
            <i class="fa-solid fa-plus" onclick="showhb2()"></i>
            </div>


                </div>                
                <div class="outer02" id="hb2">
                <div class="trial1" id="hbinput">
                    <input type="number" step="0.1" name="hook2" placeholder="" class="input02">
                    <label for="" class="placeholder2">Hook Block Capacity In Ton</label>
                </div>
                <div class="trial1 abcd" id="hbicon2">
            <i class="fa-solid fa-plus" onclick="showhb3()"></i>
            </div>


                </div>                
                <div class="outer02" id="hb3">
                <div class="trial1" id="hbinput">
                    <input type="number" step="0.1" name="hook3" placeholder="" class="input02">
                    <label for="" class="placeholder2">Hook Block Capacity In Ton</label>
                </div>
                <div class="trial1 abcd" id="hbicon3">
            <i class="fa-solid fa-plus" onclick="showhb4()"></i>
            </div>


                </div>                
                <div class="outer02" id="hb4">
                <div class="trial1" id="hbinput">
                    <input type="number" step="0.1" name="hook4" placeholder="" class="input02">
                    <label for="" class="placeholder2">Hook Block Capacity In Ton</label>
                </div>
                <div class="trial1 abcd" id="hbicon4">
            <i class="fa-solid fa-plus" onclick="showhb5()"></i>
            </div>


                </div>                
                <div class="outer02" id="hb5">
                <div class="trial1" id="hbinput">
                    <input type="number" step="0.1" name="hook5" placeholder="" class="input02">
                    <label for="" class="placeholder2">Hook Block Capacity In Ton</label>
                </div>
                <div class="trial1 abcd" id="hbicon5">
            <i class="fa-solid fa-plus" onclick="showhb6()"></i>
            </div>


                </div>                
                <div class="outer02" id="hb6">
                <div class="trial1" id="hbinput">
                    <input type="number" step="0.1" name="hook6" placeholder="" class="input02">
                    <label for="" class="placeholder2">Hook Block Capacity In Ton</label>
                </div>


                </div> 
                <p class="meterdescription">Cabin Section :</p>               
                <div class="trial1">
                    <input type="text" name="cabin_dimension" placeholder="" class="input02">
                    <label for="" class="placeholder2">Main Cabin Dimension</label>
                </div>
                <div class="outer02">
                    <div class="trial1">
                    <input type="text" placeholder="" name="cabinweight" class="input02">
                    <label for="" class="placeholder2">Cabin Weight </label>

                    </div>
                    <div class="trial1" id="cabinweightunit">
                        <select name="cabinunit" id="" class="input02">
                            <option value=""disabled selected>Unit</option>
                            <option value="kg">Kg</option>
                            <option value="Ton">Ton</option>
                        </select>
                    </div>

                    <div class="trial1">
                        <select name="cabintrailor" id="" class="input02">
                            <option value=""disabled selected >Suitable Trailor Type</option>
                            <option value="Axle">Axle</option>
                <option value="LBT">LBT</option>
                <option value="SLBT">SLBT</option>
                <option value="HBT">HBT</option>
                <option value="Lorry">Lorry</option>
                        </select>
                    </div>
                </div>
<p class="meterdescription">Main winch wire rope</p>
<div class="outer02">
    <div class="trial1">
        <input type="text" name="mainwinchlength" placeholder="" class="input02">
        <label for="" class="placeholder2">Length/Mtrs</label>
    </div>
    <div class="trial1">
        <input type="text" name="mainwinchdia" placeholder="" class="input02">
        <label for="" class="placeholder2">Dia/mm</label>
    </div>
</div>
<p class="meterdescription">Second winch wire rope</p>
<div class="outer02">
    <div class="trial1">
        <input type="text" name="secondwinchlength" placeholder="" class="input02">
        <label for="" class="placeholder2">Length/Mtrs</label>
    </div>
    <div class="trial1">
        <input type="text" name="secondwinchdia" placeholder="" class="input02">
        <label for="" class="placeholder2">Dia/mm</label>
    </div>
</div>
<p class="meterdescription">Auxilary winch wire rope</p>
<div class="outer02">
    <div class="trial1">
        <input type="text" name="auxiwinchlength" placeholder="" class="input02">
        <label for="" class="placeholder2">Length/Mtrs</label>
    </div>
    <div class="trial1">
        <input type="text" name="auxiwinchdia" placeholder="" class="input02">
        <label for="" class="placeholder2">Dia/mm</label>
    </div>
</div>
<div class="trial1">
    <select name="currentstatus" id="" class="input02">
    <option value=""disabled selected>Current Status</option>
        <option value="In Production">In Production</option>
    <option value="discontinued">Discontinued</option>
    <option value="limited Production">Limited Production</option>
    <option value="special Edition">Special Editions or Limited Runs</option>
    </select>
</div>
<div class="trial1">
    <input type="file" name="loadchart" class="input02">
    <label for="" class="placeholder2">Upload Load Chart</label>
</div>
<div class="trial1">
    <input type="file" name="image" class="input02">
    <label for="" class="placeholder2">Upload Image</label>
</div>
                <button class="epc-button">Submit</button>


        </div>

    </form>
</body>
<script>
    function copyValue(value) {
    // Get the target input elements
    const lufferInput = document.querySelector('input[name="boom_luffer_mainboom"]');
    const flyJibInput = document.querySelector('input[name="boom_flyjib_mainboom"]');
    const mainboommaininput = document.querySelector('input[name="basicmainboom"]');

    // Set their values to the value from the first input
    lufferInput.value = value;
    flyJibInput.value = value;
    mainboommaininput.value = value;
}
    function copyValue2(value) {
    const fixedjib = document.querySelector('input[name="fixedjib"]');
    fixedjib.value = value;
}
    function copyvalue3(value) {
    const luffing = document.querySelector('input[name="luffing"]');
    luffing.value = value;
}
</script>
</html>