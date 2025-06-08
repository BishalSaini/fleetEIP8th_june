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
else {
    $dashboard_url = '';
}
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
if (isset($_POST['submit']) && isset($_FILES['my_image'])) {
	include_once 'partials/_dbconnect.php'; // Include the database connection file

	$category=$_POST['fleet_category'];
	$subtype=$_POST['type'];
	$kmr01 = $_POST['kmr'];
	$hmr01 = $_POST['hmr'];
	// $type01 = $_POST['sell_type'];
	$price01 = $_POST['price'];
	$contact_no01 = $_POST['contact_no'];
	$make01 = $_POST['make'];
	$model01 = $_POST['model'];
	$capacity01 = $_POST['capacity'];
  $unit=$_POST['unit'];
	$yom01 = $_POST['yom'];
	$location01 = $_POST['location'];
	$boomlength01 = $_POST['boom_length'];
	$jiblength01 = $_POST['jib_length'];
	$luffinglength01 = $_POST['luffing_length'];
	$cranedesc01 = $_POST['crane_desc'];
	$img_name = $_FILES['my_image']['name'];
	$img_size = $_FILES['my_image']['size'];
	$tmp_name = $_FILES['my_image']['tmp_name'];
	$error = $_FILES['my_image']['error'];

  $registration=$_POST['registration'];
  $chassis_make=$_POST['chassis_make'] ?? null;
  $model_no=$_POST['model_no'];
  $height_meter=$_POST['height_meter'];
  $total_height=$_POST['total_height'];
  $free_standing_height=$_POST['free_standing_height'];
  $tipload=$_POST['tipload'];
  $kealy=$_POST['kealy'] ?? null;
  $pipeline=$_POST['pipeline'];
  $silos_no=$_POST['silos_no'] ?? null;
  $cement_silos=$_POST['cement_silos'];
  $flyash_silos=$_POST['flyash_silos'];
  $cement_silos_qty=$_POST['cement_silos_qty'];
  $flyash_silos_qty=$_POST['flyash_silos_qty'];
  $chiller_available=$_POST['chiller_available'] ?? null;












	// echo "<pre>";
	// print_r($_FILES['my_image2']);
	// echo "</pre>";
	$img_name2 = $_FILES['my_image2']['name'];
	$img_size2 = $_FILES['my_image2']['size'];
	$tmp_name2 = $_FILES['my_image2']['tmp_name'];
	$error2 = $_FILES['my_image']['error'];


	// echo "<pre>";
	// print_r($_FILES['my_image3']);
	// echo "</pre>";
	$img_name3 = $_FILES['my_image3']['name'];
	$img_size3 = $_FILES['my_image3']['size'];
	$tmp_name3 = $_FILES['my_image3']['tmp_name'];
	$error3 = $_FILES['my_image3']['error'];

  if (!empty($_FILES['pic4_image']['name'])) {
    $pic4 = $_FILES['pic4_image']['name'];
    $temp_file_path = $_FILES['pic4_image']['tmp_name'];
    $folder1 = 'img/' . $pic4;
    move_uploaded_file($temp_file_path, $folder1);
} else {
    $pic4 = "$img_name";
}

if (!empty($_FILES['pic5_image']['name'])) {
    $pic5 = $_FILES['pic5_image']['name'];
    $temp_file_path = $_FILES['pic5_image']['tmp_name'];
    $folder2 = 'img/' . $pic5;
    move_uploaded_file($temp_file_path, $folder2);
} else {
    $pic5 = "$img_name2";
}



	if ($error === 0) {
		if ($img_size > 1250000 || $img_size2 > 1250000 || $img_size3 > 1250000 ) {			
		    // header("Location: index.php?error=$em");
			echo "File Size Is Too large";
		}else {
			$img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
			$img_ex_lc = strtolower($img_ex);

			$img_ex2 = pathinfo($img_name2, PATHINFO_EXTENSION);
			$img_ex_lc2 = strtolower($img_ex2);

			$img_ex3 = pathinfo($img_name3, PATHINFO_EXTENSION);
			$img_ex_lc3 = strtolower($img_ex3);

			$allowed_exs = array("jpg", "jpeg", "png"); 

			if (in_array($img_ex_lc, $allowed_exs)) {
				$new_img_name = uniqid("IMG-", true).'.'.$img_ex_lc;
				$img_upload_path = 'img/'.$new_img_name;
				move_uploaded_file($tmp_name, $img_upload_path);

				$new_img_name2 = uniqid("IMG-", true).'.'.$img_ex_lc2;
				$img_upload_path2 = 'img/'.$new_img_name2;
				move_uploaded_file($tmp_name2, $img_upload_path2);

				$new_img_name3 = uniqid("IMG-", true).'.'.$img_ex_lc3;
				$img_upload_path3 = 'img/'.$new_img_name3;
				move_uploaded_file($tmp_name3, $img_upload_path3);

				// Insert into Database
        $sql="INSERT INTO `images` (`companyname`, `category`, `sub_type`, `kmr`, `hmr`,
         `email`, `price`, `contact_no`, `front_pic`, `left_side_pic`, `right_side_pic`, `pic4`,
          `pic5`, `model`, `make`, `capacity`, `unit`, `yom`, `location`, `boomlength`,
           `jiblength`, `luffinglength`, `description`, `registration`, `chassis_make`, `model_no`,
            `height_meter`, `total_height`, `free_standing_height`, `tip_load`, 
            `kaely`, `pipeline`, `silos_no`, `cmnt_silos`, `flyash_silos`, `cmnt_silos_qty`,
             `flyash_silos_qty`, `chiller`) VALUES ( '$companyname001', '$category', '$subtype', '$kmr01',
              '$hmr01', '$email', '$price01', '$contact_no01', '$new_img_name', '$new_img_name2', '$new_img_name3', '$pic4', '$pic5',
               '$model01', '$make01', '$capacity01', '$unit',
               '$yom01', '$location01', '$boomlength01', '$jiblength01', '$luffinglength01', '$cranedesc01', '$registration', '$chassis_make', '$model_no',
                '$height_meter', '$total_height', '$free_standing_height',
                '$tipload','$kealy', '$pipeline', '$silos_no', '$cement_silos', '$flyash_silos', '$cement_silos_qty', '$flyash_silos_qty', '$chiller_available')";


				// $sql = "INSERT INTO images(pic5,pic4,unit,companyname,category,sub_type,kmr,hmr,email,price,contact_no,front_pic,left_side_pic,right_side_pic,model,make,capacity,yom,location,boomlength,jiblength,luffinglength,description) 
				//         VALUES('$pic5','$pic4','$unit','$companyname001','$category','$subtype','$kmr01' , '$hmr01' , '$email' , '$price01' , '$contact_no01' , '$new_img_name' , '$new_img_name2' , '$new_img_name3' , '$model01' , '$make01' , '$capacity01' , '$yom01' , '$location01' , '$boomlength01' , '$jiblength01' , '$luffinglength01' , '$cranedesc01')";
				$result01=mysqli_query($conn, $sql);
				if ($result01){
					$showAlert = true;	
				}
			
			else{
				$showError = true;
				// header("Location: tets.php");

			}
				
			}
}}}

?>
<style>
  <?php include "style.css" 
  ?>
</style>
<script>
  <?php include "main.js" ?>
</script>
<?php
include 'partials/_dbconnect.php';

?>
<!DOCTYPE html>
<html>
<head>
	<title>Sell Your Fleet </title>
  <link rel="stylesheet" href="tiles.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script src="main.js"defer></script>
	
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

            <li><a href="logout.php">Log Out</a></li></ul>
        </div>
</div>
<?php
    if($showAlert){
		echo  '<label>
        <input type="checkbox" class="alertCheckbox" autocomplete="off" />
        <div class="alert notice">
          <span class="alertClose">X</span>
          <span class="alertText_addfleet"><b>Success!</b>Listing Posted Successfully<a href="view_listing.php">View listing</a>
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
    <div class="add_fleet_btn_new" id="view_listing_container">
<button class="generate-btn" id="view_listing_button"> 
    <article id="actualbutton_view_listings" class="article-wrapper" onclick="view_selling_listing()" > 
  <div class="rounded-lg container-projectss ">
    </div>
    <div class="project-info">
      <div class="flex-pr">
        <div class="project-title text-nowrap">View Listings</div>
          <div class="project-hover">
            <svg style="color: black;" xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" color="black" stroke-linejoin="round" stroke-linecap="round" viewBox="0 0 24 24" stroke-width="2" fill="none" stroke="currentColor"><line y2="12" x2="19" y1="12" x1="5"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
            </div>
          </div>
          <div class="types">
        </div>
    </div>
</article>
    </button>

<button class="generate-btn" id="view_listing_button"> 
    <article id="actualbutton_view_listings" class="article-wrapper" onclick="window.location.href='buyusedfleet.php'" > 
  <div class="rounded-lg container-projectss ">
    </div>
    <div class="project-info">
      <div class="flex-pr">
        <div class="project-title text-nowrap">Buy Equipment</div>
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

<form action="tets.php" method="post" class="sellcrane" autocomplete="off" enctype="multipart/form-data">
	<div class="sellcrane-container">
	<div class="sellcrane_heading"><h2>Sell Your Equipment</h2></div>
    <!-- <div class="trial1">
	<select name="sell_type" class="input02" id="">
  <option value="" disabled selected> Type</option>
  <option value="Backhoe loader">Backhoe loader</option>
  <option value="Barges">Barges</option>
  <option value="Bulldozers">Bulldozers</option>
  <option value="Compactor">Compactor</option>
  <option value="Concrete pump">Concrete pump</option>
  <option value="Crawler">Crawler</option>
  <option value="Crawler telescopic">Crawler telescopic</option>
  <option value="Excavator">Excavator</option>
  <option value="Forklift">Forklift</option>
  <option value="Front loader">Front loader</option>
  <option value="Graders">Graders</option>
  <option value="Heavy Haulage">Heavy Haulage</option>
  <option value="Lift">Lift</option>
  <option value="Lorry Loader">Lorry Loader</option>
  <option value="Mining equipment">Mining equipment</option>
  <option value="Paver">Paver</option>
  <option value="Rig">Rig</option>
  <option value="Skid loader">Skid loader</option>
  <option value="Telehandlers">Telehandlers</option>
  <option value="Telescopic">Telescopic</option>
  <option value="Tipper">Tipper</option>
  <option value="Tower cranes">Tower cranes</option>
  <option value="Trailer-flatbed">Trailer-flatbed</option>
  <option value="Trailer-semi lowbed">Trailer-semi lowbed</option>
  <option value="Trailer-lowbed">Trailer-lowbed</option>
  <option value="Trucks">Trucks</option>
	</select>
	</div> -->
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
        <select class="input02" name="make" id="crane_make_retnal" onchange="rental_addfleet()" required> 
            <option value="" disabled selected>Fleet Make</option>
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
<div class="trial1" id="othermake01">
        <input type="text" placeholder="" name="other_make" id="" class="input02" >
        <label class="placeholder2">Specify Other Make</label>
        </div>

		<div class="trial1">
		<input type="text" class="input02" placeholder="" name="model" required>
		<label class="placeholder2">Model</label>
		</div>
    </div>
    <div class="outer02">
		<div class="trial1">
		<input type="text" class="input02" placeholder="" name="capacity" required>
		<label class="placeholder2">Capacity</label>
		</div>
    <div class="trial1"  id="unit_sell">
      <select name="unit" class="input02" required>
        <option value="disabled selected">Unit</option>
        <option value="Ton">Ton</option>
                <option value="Kgs">Kgs</option>
                <option value="KnM">KnM</option>
                <option value="Meter">Meter</option>
                <option value="M³">M³</option>
      </select>
    </div>
    </div>
    <div class="outer02">
		<div class="trial1" id="kmrsellfleet">
		<input type="text" class="input02" placeholder="" name="kmr">
		<label class="placeholder2">KMR</label>
		</div>
    <div class="trial1" id="hmrsellfleet">
		<input type="text" class="input02" placeholder="" name="hmr">
		<label class="placeholder2">HMR</label>
		</div>
		<div class="trial1" id="sellfleetyom">
		<input type="text" class="input02" placeholder="" name=yom required>
		<label class="placeholder2">YOM</label>
		</div>
    </div>
    <div class="outer02">
		<div class="trial1">
		<input type="text" class="input02" placeholder="" name="location">
		<label class="placeholder2">Location</label>
		</div>
    <div class="trial1">
		<input type="text" class="input02" placeholder="" name="price">
		<label class="placeholder2">Price </label>
		</div>
    </div>
    <div class="outer02" id="reg_container">
            <div class="trial1"  >
                <select class="input02" id="regestration_dd" onchange="reg_input()">
                    <option value=""disabled selected>Registration ?</option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                </select>
            </div>

        </div>
        <div class="trial1" id="registration_rental">
        <input type="text"  name="registration"  placeholder="" class="input02">
        <label class="placeholder2">Registration</label>
        </div>


        <div class="outer02" id="chassis_make_rental_outer" >
        <div class="trial1" >
        <select name="chassis_make" class="input02 chassis_makedd" id="chassis_make_rental" onchange="chassis_make_rental1()" >
            <option value="">Choose Chassis Make</option>
            <option value="AWM">AWM</option>
            <option value="Eicher">Eicher</option>
            <option value="TATA">TATA</option>
            <option value="Bharat Benz">Bharat Benz</option>
            <option value="Ashok Leyland">Ashok Leyland</option>
            <option value="Volvo">Volvo</option>
            <option value="Other">Other</option>
        </select>
        </div>
        <div class="trial1" id="model_number">
            <input type="text" name="model_no" placeholder="" class="input02">
            <label for="" class="placeholder2">Model No</label>
        </div>
        </div>
        <div class="trial1" id="otherchassis">
        <input type="text" name="new_chassis_maker" placeholder=""   class=" input02" >
        <label class="placeholder2">Specify Other Chassis Make</label>
        </div>
        <div class="trial1" id="forklift_height">
            <input type="number" name="height_meter" placeholder="" class="input02">
            <label for="" class="placeholder2">Height/Meter</label>
        </div>
        <div class="outer02" id="tower_crane">
            <div class="trial1">
                <input type="number" name="total_height" id="total_height_input"  placeholder="" class="input02">
                <label for="" class="placeholder2 tip_load_in_tons">Total Height In Mtr</label>
            </div>
            <div class="trial1">
                <input type="number" name="free_standing_height" id="free_standing_height"  placeholder="" class="input02">
                <label for="" id="" class="placeholder2 tip_load_in_tons">Free Standing Height</label>
            </div>
            <div class="trial1">
                <input type="number" name="tipload" id="tip_load_height" placeholder="" class="input02">
                <label for=""  class="placeholder2 tip_load_in_tons">Tip Load In Tons</label>
            </div>


        </div>
        <!-- <div class="trial1">
            <input type="text" name="chassis_number" placeholder="" class="input02">
            <label for="" class="placeholder2">Chassis Number</label>
        </div>
        <div class="trial1">
        <input type="text" name="engine" placeholder="" class="input02" >
        <label class="placeholder2">Engine Make</label>
        </div> -->
        <!-- <div class="length_outercontainer" id="length_outer"> -->
            <div class="outer02" id="length_container">
        <div class="trial1" id="boom_input" >
            <input type="number" name="boom_length"  placeholder="" class=" input02" >
            <label class="placeholder2">Boom Length</label>
        </div>    
        <div class="trial1" id="jib_input">
            <input type="number" name="jib_length"  placeholder="" class="input02 " >
            <label class="placeholder2">Jib Length</label>
        </div>
        <div class="trial1" id="luffing_input">
            <input type="number" name="luffing_length"  placeholder="" class=" input02" >
            <label class="placeholder2">Luffing Length</label>
        </div>
        </div>
        <div class="trial1" id="kealy_length">
            <input type="text" name='kealy' placeholder="" class="input02">
            <label for="" class="placeholder2">Kealy Length</label>
        </div>
        <div class="trial1" id="pipelength">
            <input type="text" name='pipeline' placeholder="" class="input02">
            <label for="" class="placeholder2">Pipeline Length</label>
        </div>
        <div class="outer02" id="silos_container">
            <div class="trial1">
                <select name="silos_no" id="" class="input02">
                    <option value=""disabled selected>Silos No</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </div>
            <div class="trial1">
                <input type="text" name="cement_silos" placeholder="" class="input02">
                <label for="" class="placeholder2">Cement Silos No</label>
            </div>
            <div class="trial1">
                <input type="text" name="flyash_silos" placeholder="" class="input02">
                <label for="" class="placeholder2">Flyash Silos No</label>
            </div>

        </div>
        <div class="outer02" id="silos_qty_container">
        <div class="trial1">
                <input type="text" name="cement_silos_qty" placeholder="" class="input02">
                <label for="" class="placeholder2">Cement Silos Qty</label>
            </div>
            <div class="trial1">
                <input type="text" name="flyash_silos_qty" placeholder="" class="input02">
                <label for="" class="placeholder2">Flyash Silos Qty</label>
            </div>
                <div class="trial1">
                    <select name="chiller_available" id="" class="input02"> 
                        <option value=""disable selected>Chiller?</option>
                        <option value="Yes">Available</option>
                        <option value="No">Not Available</option>
                    </select>
                </div>

        </div>

		<div class="trial1">    
		<textarea type="text" class="input02" placeholder="" name="crane_desc" ></textarea>
		<label class="placeholder2">Equipment Description</label>
		</div>
		
    <div class="trial1">
		<input type="text" class="input02" placeholder="" name="contact_no">
		<label class="placeholder2">Contact Number</label>
		</div>
    <div class="outer02">
		<div class="trial1">
    	<input type="file" class="input02" name="my_image" required>
		<label class="placeholder2">Picture1</label>
		</div>
		<div class="trial1">
		<input type="file" class="input02" name="my_image2" required>
		<label class="placeholder2">Picture 2</label>
		</div>
		<div class="trial1">
		<input type="file" class="input02" name="my_image3" required>
		<label class="placeholder2">Picture 3</label>
		</div>
    <div class="trial1" id="sellfleeticon">
    <i class="fa-solid fa-plus" onclick="sell_icon()"></i>
    </div>
    </div>
    <div class="outer02">
      <div class="trial1" id="pic4">
        <input type="file" name="pic4_image" class="input02">
        <label for="" class="placeholder2">Picture 4</label>
      </div>
      <div class="trial1" id="pic5">
        <input type="file" name="pic5_image" class="input02">
        <label for="" class="placeholder2">Picture 5</label>
      </div>
    </div>
    

        <input type="submit" class="epc-button" name="submit" value="Upload">
<br>
	</div>
</form>
<br><br>
<script>   
function reg_input() {
            const regestration_dd = document.getElementById("regestration_dd");
            const registration_rental = document.getElementById("registration_rental");
            const reg_container1=document.getElementById("reg_container");

            if (regestration_dd && registration_rental) {
                if (regestration_dd.value === 'Yes') {
                    registration_rental.style.display = 'block';
                    

                } else {
                    registration_rental.style.display = 'none';
                }
            }}




  function view_selling_listing(){
    window.location.href="view_listing_dashboard.php"
  }     
    
</script>

</body>
</html>
     	