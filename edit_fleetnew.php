<?php
    // Include the database connection file
    require_once('partials/_dbconnect.php');

    // Get the record ID from the URL parameter
    $editId = $_GET['id'];
    // echo $editId;

    // Retrieve data based on the ID
    $query = "SELECT * FROM `fleet1` WHERE snum ='$editId'";
    $result = mysqli_query($conn, $query);
    $row_info = mysqli_fetch_assoc($result);

    if (!$row_info) {
        echo "<p>Record not found.</p>";
    } 
        ?>

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


$sql_client_name="SELECT * FROM `rentalclient_basicdetail` where companyname='$companyname001' order by clientname ASC";
$result_clients=mysqli_query($conn, $sql_client_name);

$sql_operator_name="SELECT * FROM `myoperators` where company_name='$companyname001' and designation='Operator'";
$result_operator=mysqli_query($conn,$sql_operator_name);
$result_operator2=mysqli_query($conn,$sql_operator_name);

$sql_helper_name="SELECT * FROM `myoperators` where company_name='$companyname001' and designation='Helper'";
$result_helper=mysqli_query($conn,$sql_helper_name);
$result_helper2=mysqli_query($conn,$sql_helper_name);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="favicon.jpg" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="style.css">
    <title>Fleet</title>
    <script><?php include "main.js" ?></script>
    <style><?php include "style.css" ?></style>
</head>
<body>
<div class="navbar1">
        <!-- Navbar section -->
        <div class="logo_fleet">
            <!-- Logo with a link to rental_dashboard.php -->
            <img src="logo_fe.png" alt="FLEET EIP" onclick="window.location.href='<?php echo $dashboard_url  ?>'">
        </div>
        <div class="iconcontainer">
            <!-- Navigation links -->
            <ul>
              <li><a href="<?php echo $dashboard_url ?>">Dashboard</a></li>
                <li><a href="news/">News</a></li>
                <li><a href="logout.php">Log Out</a></li>
            </ul>
        </div>
    </div>

<form action="update.php? assetcode=<?php echo $editId; ?>"  method="POST" class="edit_fleet_new" autocomplete="off" enctype="multipart/form-data">
    <div class="first_two_form_container">
        <div class="first_form">
            <p>Basic Details</p>
        <div class="outer02">
        <div class="trial1">
        <select class="input02" name="fleet_category" id="oem_fleet_type" onchange="purchase_option()" required>
            <option value="" disabled selected>Select Fleet Category</option>
            <option value="Aerial Work Platform" <?php if($row_info['category'] === 'Aerial Work Platform') { echo 'selected'; } ?>>Aerial Work Platform</option>
    <option value="Concrete Equipment" <?php if($row_info['category'] === 'Concrete Equipment') { echo 'selected'; } ?>>Concrete Equipment</option>
    <option value="EarthMovers and Road Equipments" <?php if($row_info['category'] === 'EarthMovers and Road Equipments') { echo 'selected'; } ?>>EarthMovers and Road Equipments</option>
    <option value="Material Handling Equipments" <?php if($row_info['category'] === 'Material Handling Equipments') { echo 'selected'; } ?>>Material Handling Equipments</option>
    <option value="Ground Engineering Equipments" <?php if($row_info['category'] === 'Ground Engineering Equipments') { echo 'selected'; } ?>>Ground Engineering Equipments</option>
    <option value="Trailor and Truck" <?php if($row_info['category'] === 'Trailor and Truck') { echo 'selected'; } ?>>Trailor and Truck</option>
    <option value="Generator and Lighting" <?php if($row_info['category'] === 'Generator and Lighting') { echo 'selected'; } ?>>Generator and Lighting</option>        </select>
        </div>
        <div class="trial1">
        <select class="input02" name="type" id="fleet_sub_type" onchange="crawler_options()" required>
            <option value="" disabled selected>Select Fleet Type</option>
            <option value="Self Propelled Articulated Boomlift" <?php if($row_info['sub_type'] === 'Self Propelled Articulated Boomlift') { echo 'selected'; } ?> class="awp_options" id="aerial_work_platform_option1">Self Propelled Articulated Boomlift</option>
    <option value="Scissor Lift Diesel" <?php if($row_info['sub_type'] === 'Scissor Lift Diesel') { echo 'selected'; } ?> class="awp_options" id="aerial_work_platform_option2">Scissor Lift Diesel</option>
    <option value="Scissor Lift Electric" <?php if($row_info['sub_type'] === 'Scissor Lift Electric') { echo 'selected'; } ?> class="awp_options" id="aerial_work_platform_option3">Scissor Lift Electric</option>
    <option value="Spider Lift" <?php if($row_info['sub_type'] === 'Spider Lift') { echo 'selected'; } ?> class="awp_options" id="aerial_work_platform_option4">Spider Lift</option>
    <option value="Self Propelled Straight Boomlift" <?php if($row_info['sub_type'] === 'Self Propelled Straight Boomlift') { echo 'selected'; } ?> class="awp_options" id="aerial_work_platform_option5">Self Propelled Straight Boomlift</option>
    <option value="Truck Mounted Articulated Boomlift" <?php if($row_info['sub_type'] === 'Truck Mounted Articulated Boomlift') { echo 'selected'; } ?> class="awp_options" id="aerial_work_platform_option6">Truck Mounted Articulated Boomlift</option>
    <option value="Truck Mounted Straight Boomlift" <?php if($row_info['sub_type'] === 'Truck Mounted Straight Boomlift') { echo 'selected'; } ?> class="awp_options" id="aerial_work_platform_option7">Truck Mounted Straight Boomlift</option>
    
    <option value="Batching Plant" <?php if($row_info['sub_type'] === 'Batching Plant') { echo 'selected'; } ?> class="cq_options" id="concrete_equipment_option1">Batching Plant</option>
    <option value="Self Loading Mixer" <?php if($row_info['sub_type'] === 'Self Loading Mixer') { echo 'selected'; } ?> class="cq_options" id="">Self Loading Mixer</option>
    <option value="Concrete Boom Placer" <?php if($row_info['sub_type'] === 'Concrete Boom Placer') { echo 'selected'; } ?> class="cq_options" id="concrete_equipment_option2">Concrete Boom Placer</option>
    <option value="Concrete Pump" <?php if($row_info['sub_type'] === 'Concrete Pump') { echo 'selected'; } ?> class="cq_options" id="concrete_equipment_option3">Concrete Pump</option>
    <option value="Moli Pump" <?php if($row_info['sub_type'] === 'Moli Pump') { echo 'selected'; } ?> class="cq_options" id="concrete_equipment_option4">Moli Pump</option>
    <option value="Mobile Batching Plant" <?php if($row_info['sub_type'] === 'Mobile Batching Plant') { echo 'selected'; } ?> class="cq_options" id="concrete_equipment_option5">Mobile Batching Plant</option>
    <option value="Static Boom Placer" <?php if($row_info['sub_type'] === 'Static Boom Placer') { echo 'selected'; } ?> class="cq_options" id="concrete_equipment_option6">Static Boom Placer</option>
    <option value="Transit Mixer" <?php if($row_info['sub_type'] === 'Transit Mixer') { echo 'selected'; } ?> class="cq_options" id="concrete_equipment_option7">Transit Mixer</option>
    <option value="Shotcrete Machine" <?php if($row_info['sub_type'] === 'Shotcrete Machine') { echo 'selected'; } ?> class="cq_options" id="concrete_equipment_option8">Shotcrete Machine</option>
    
    <option value="Baby Roller" <?php if($row_info['sub_type'] === 'Baby Roller') { echo 'selected'; } ?> class="earthmover_options" id="earthmovers_option1">Baby Roller</option>
    <option value="Backhoe Loader" <?php if($row_info['sub_type'] === 'Backhoe Loader') { echo 'selected'; } ?> class="earthmover_options" id="earthmovers_option2">Backhoe Loader</option>
    <option value="Bulldozer" <?php if($row_info['sub_type'] === 'Bulldozer') { echo 'selected'; } ?> class="earthmover_options" id="earthmovers_option3">Bulldozer</option>
    <option value="Excavator" <?php if($row_info['sub_type'] === 'Excavator') { echo 'selected'; } ?> class="earthmover_options" id="earthmovers_option4">Excavator</option>
    <option value="Milling Machine" <?php if($row_info['sub_type'] === 'Milling Machine') { echo 'selected'; } ?> class="earthmover_options" id="earthmovers_option5">Milling Machine</option>
    <option value="Motor Grader" <?php if($row_info['sub_type'] === 'Motor Grader') { echo 'selected'; } ?> class="earthmover_options" id="earthmovers_option6">Motor Grader</option>
    <option value="Pneumatic Tyre Roller" <?php if($row_info['sub_type'] === 'Pneumatic Tyre Roller') { echo 'selected'; } ?> class="earthmover_options" id="earthmovers_option7">Pneumatic Tyre Roller</option>
    <option value="Single Drum Roller" <?php if($row_info['sub_type'] === 'Single Drum Roller') { echo 'selected'; } ?> class="earthmover_options" id="earthmovers_option8">Single Drum Roller</option>
    <option value="Skid Loader" <?php if($row_info['sub_type'] === 'Skid Loader') { echo 'selected'; } ?> class="earthmover_options" id="earthmovers_option9">Skid Loader</option>
    <option value="Slip Form Paver" <?php if($row_info['sub_type'] === 'Slip Form Paver') { echo 'selected'; } ?> class="earthmover_options" id="earthmovers_option10">Slip Form Paver</option>
    <option value="Soil Compactor" <?php if($row_info['sub_type'] === 'Soil Compactor') { echo 'selected'; } ?> class="earthmover_options" id="earthmovers_option11">Soil Compactor</option>
    <option value="Tandem Roller" <?php if($row_info['sub_type'] === 'Tandem Roller') { echo 'selected'; } ?> class="earthmover_options" id="earthmovers_option12">Tandem Roller</option>
    <option value="Vibratory Roller" <?php if($row_info['sub_type'] === 'Vibratory Roller') { echo 'selected'; } ?> class="earthmover_options" id="earthmovers_option13">Vibratory Roller</option>
    <option value="Wheeled Excavator" <?php if($row_info['sub_type'] === 'Wheeled Excavator') { echo 'selected'; } ?> class="earthmover_options" id="earthmovers_option14">Wheeled Excavator</option>
    <option value="Wheeled Loader" <?php if($row_info['sub_type'] === 'Wheeled Loader') { echo 'selected'; } ?> class="earthmover_options" id="earthmovers_option15">Wheeled Loader</option>
    
    <option value="Fixed Tower Crane" <?php if($row_info['sub_type'] === 'Fixed Tower Crane') { echo 'selected'; } ?> class="mhe_options" id="mhe_option1">Fixed Tower Crane</option>
    <option value="Fork Lift Diesel" <?php if($row_info['sub_type'] === 'Fork Lift Diesel') { echo 'selected'; } ?> class="mhe_options" id="mhe_option2">Fork Lift Diesel</option>
    <option value="Fork Lift Electric" <?php if($row_info['sub_type'] === 'Fork Lift Electric') { echo 'selected'; } ?> class="mhe_options" id="mhe_option3">Fork Lift Electric</option>
    <option value="Hammerhead Tower Crane" <?php if($row_info['sub_type'] === 'Hammerhead Tower Crane') { echo 'selected'; } ?> class="mhe_options" id="mhe_option4">Hammerhead Tower Crane</option>
    <option value="Hydraulic Crawler Crane" <?php if($row_info['sub_type'] === 'Hydraulic Crawler Crane') { echo 'selected'; } ?> class="mhe_options" id="mhe_option5">Hydraulic Crawler Crane</option>
    <option value="Luffing Jib Tower Crane" <?php if($row_info['sub_type'] === 'Luffing Jib Tower Crane') { echo 'selected'; } ?> class="mhe_options" id="mhe_option6">Luffing Jib Tower Crane</option>
    <option value="Mechanical Crawler Crane" <?php if($row_info['sub_type'] === 'Mechanical Crawler Crane') { echo 'selected'; } ?> class="mhe_options" id="mhe_option7">Mechanical Crawler Crane</option>
    <option value="Pick and Carry Crane" <?php if($row_info['sub_type'] === 'Pick and Carry Crane') { echo 'selected'; } ?> class="mhe_options" id="mhe_option8">Pick and Carry Crane</option>
    <option value="Reach Stacker" <?php if($row_info['sub_type'] === 'Reach Stacker') { echo 'selected'; } ?> class="mhe_options" id="mhe_option9">Reach Stacker</option>
    <option value="Rough Terrain Crane" <?php if($row_info['sub_type'] === 'Rough Terrain Crane') { echo 'selected'; } ?> class="mhe_options" id="mhe_option10">Rough Terrain Crane</option>
    <option value="Telehandler" <?php if($row_info['sub_type'] === 'Telehandler') { echo 'selected'; } ?> class="mhe_options" id="mhe_option11">Telehandler</option>
    <option value="Telescopic Crawler Crane" <?php if($row_info['sub_type'] === 'Telescopic Crawler Crane') { echo 'selected'; } ?> class="mhe_options" id="mhe_option12">Telescopic Crawler Crane</option>
    <option value="Telescopic Mobile Crane" <?php if($row_info['sub_type'] === 'Telescopic Mobile Crane') { echo 'selected'; } ?> class="mhe_options" id="mhe_option13">Telescopic Mobile Crane</option>
    <option value="All Terrain Mobile Crane" <?php if($row_info['sub_type'] === 'All Terrain Mobile Crane') { echo 'selected'; } ?> class="mhe_options" id="mhe_option14">All Terrain Mobile Crane</option>
    <option value="Self Loading Truck Crane" <?php if($row_info['sub_type'] === 'Self Loading Truck Crane') { echo 'selected'; } ?> class="mhe_options" id="mhe_option15">Self Loading Truck Crane</option>
    
    <option value="Hydraulic Drilling Rig" <?php if($row_info['sub_type'] === 'Hydraulic Drilling Rig') { echo 'selected'; } ?> class="gee_options" id="ground_engineering_equipment_option1">Hydraulic Drilling Rig</option>
    <option value="Rotary Drilling Rig" <?php if($row_info['sub_type'] === 'Rotary Drilling Rig') { echo 'selected'; } ?> class="gee_options" id="ground_engineering_equipment_option2">Rotary Drilling Rig</option>
    <option value="Vibro Hammer" <?php if($row_info['sub_type'] === 'Vibro Hammer') { echo 'selected'; } ?> class="gee_options" id="ground_engineering_equipment_option3">Vibro Hammer</option>
    
    <option value="Dumper" <?php if($row_info['sub_type'] === 'Dumper') { echo 'selected'; } ?> class="trailor_options" id="trailor_option1">Dumper</option>
    <option value="Truck" <?php if($row_info['sub_type'] === 'Truck') { echo 'selected'; } ?> class="trailor_options" id="trailor_option2">Truck</option>
    <option value="Water Tanker" <?php if($row_info['sub_type'] === 'Water Tanker') { echo 'selected'; } ?> class="trailor_options" id="trailor_option3">Water Tanker</option>
    <option value="Low Bed" <?php if($row_info['sub_type'] === 'Low Bed') { echo 'selected'; } ?> class="trailor_options" id="trailor_option4">Low Bed</option>
    <option value="Semi Low Bed" <?php if($row_info['sub_type'] === 'Semi Low Bed') { echo 'selected'; } ?> class="trailor_options" id="trailor_option5">Semi Low Bed</option>
    <option value="Flatbed" <?php if($row_info['sub_type'] === 'Flatbed') { echo 'selected'; } ?> class="trailor_options" id="trailor_option6">Flatbed</option>
    <option value="Hydraulic Axle" <?php if($row_info['sub_type'] === 'Hydraulic Axle') { echo 'selected'; } ?> class="trailor_options" id="trailor_option7">Hydraulic Axle</option>
    
    <option value="Silent Diesel Generator" <?php if($row_info['sub_type'] === 'Silent Diesel Generator') { echo 'selected'; } ?> class="generator_options" id="generator_option1">Silent Diesel Generator</option>
    <option value="Mobile Light Tower" <?php if($row_info['sub_type'] === 'Mobile Light Tower') { echo 'selected'; } ?> class="generator_options" id="generator_option2">Mobile Light Tower</option>
    <option value="Diesel Generator" <?php if($row_info['sub_type'] === 'Diesel Generator') { echo 'selected'; } ?> class="generator_options" id="generator_option3">Diesel Generator</option>
        </select>
        </div>
        </div>
        <div class="outer02">
        <div class="trial1">
        <input type="text" value="<?php echo $row_info['assetcode'] ?>" class="input02" placeholder="" name="assetcode" required>
        <label class="placeholder2">Asset Code</label>
        </div>
        <div class="trial1">
        <select class="input02" name="make" id="crane_make_retnal" onchange="rental_addfleet()" required> 
            <option value="" disabled selected>Fleet Make</option>
            <option value="ACE" <?php if($row_info['make'] === 'ACE') { echo 'selected'; } ?>>ACE</option>
    <option value="Ajax Fiori" <?php if($row_info['make'] === 'Ajax Fiori') { echo 'selected'; } ?>>Ajax Fiori</option>
    <option value="AMW" <?php if($row_info['make'] === 'AMW') { echo 'selected'; } ?>>AMW</option>
    <option value="Apollo" <?php if($row_info['make'] === 'Apollo') { echo 'selected'; } ?>>Apollo</option>
    <option value="Aquarius" <?php if($row_info['make'] === 'Aquarius') { echo 'selected'; } ?>>Aquarius</option>
    <option value="Ashok Leyland" <?php if($row_info['make'] === 'Ashok Leyland') { echo 'selected'; } ?>>Ashok Leyland</option>
    <option value="Atlas Copco" <?php if($row_info['make'] === 'Atlas Copco') { echo 'selected'; } ?>>Atlas Copco</option>
    <option value="Belaz" <?php if($row_info['make'] === 'Belaz') { echo 'selected'; } ?>>Belaz</option>
    <option value="Bemi" <?php if($row_info['make'] === 'Bemi') { echo 'selected'; } ?>>Bemi</option>
    <option value="BEML" <?php if($row_info['make'] === 'BEML') { echo 'selected'; } ?>>BEML</option>
    <option value="Bharat Benz" <?php if($row_info['make'] === 'Bharat Benz') { echo 'selected'; } ?>>Bharat Benz</option>
    <option value="Bob Cat" <?php if($row_info['make'] === 'Bob Cat') { echo 'selected'; } ?>>Bob Cat</option>
    <option value="Bull" <?php if($row_info['make'] === 'Bull') { echo 'selected'; } ?>>Bull</option>
    <option value="Bauer" <?php if($row_info['make'] === 'Bauer') { echo 'selected'; } ?>>Bauer</option>
    <option value="BMS" <?php if($row_info['make'] === 'BMS') { echo 'selected'; } ?>>BMS</option>
    <option value="Bomag" <?php if($row_info['make'] === 'Bomag') { echo 'selected'; } ?>>Bomag</option>
    <option value="Case" <?php if($row_info['make'] === 'Case') { echo 'selected'; } ?>>Case</option>
    <option value="Cat" <?php if($row_info['make'] === 'Cat') { echo 'selected'; } ?>>Cat</option>
    <option value="Cranex" <?php if($row_info['make'] === 'Cranex') { echo 'selected'; } ?>>Cranex</option>
    <option value="Casagrande" <?php if($row_info['make'] === 'Casagrande') { echo 'selected'; } ?>>Casagrande</option>
    <option value="Coles" <?php if($row_info['make'] === 'Coles') { echo 'selected'; } ?>>Coles</option>
    <option value="CHS" <?php if($row_info['make'] === 'CHS') { echo 'selected'; } ?>>CHS</option>
    <option value="Doosan" <?php if($row_info['make'] === 'Doosan') { echo 'selected'; } ?>>Doosan</option>
    <option value="Dynapac" <?php if($row_info['make'] === 'Dynapac') { echo 'selected'; } ?>>Dynapac</option>
    <option value="Demag" <?php if($row_info['make'] === 'Demag') { echo 'selected'; } ?>>Demag</option>
    <option value="Eicher" <?php if($row_info['make'] === 'Eicher') { echo 'selected'; } ?>>Eicher</option>
    <option value="Escorts" <?php if($row_info['make'] === 'Escorts') { echo 'selected'; } ?>>Escorts</option>
    <option value="Fuwa" <?php if($row_info['make'] === 'Fuwa') { echo 'selected'; } ?>>Fuwa</option>
    <option value="Fushan" <?php if($row_info['make'] === 'Fushan') { echo 'selected'; } ?>>Fushan</option>
    <option value="Genie" <?php if($row_info['make'] === 'Genie') { echo 'selected'; } ?>>Genie</option>
    <option value="Godrej" <?php if($row_info['make'] === 'Godrej') { echo 'selected'; } ?>>Godrej</option>
    <option value="Grove" <?php if($row_info['make'] === 'Grove') { echo 'selected'; } ?>>Grove</option>
    <option value="Hamm AG" <?php if($row_info['make'] === 'Hamm AG') { echo 'selected'; } ?>>Hamm AG</option>
    <option value="Haulott" <?php if($row_info['make'] === 'Haulott') { echo 'selected'; } ?>>Haulott</option>
    <option value="Hidromek" <?php if($row_info['make'] === 'Hidromek') { echo 'selected'; } ?>>Hidromek</option>
    <option value="Hydrolift" <?php if($row_info['make'] === 'Hydrolift') { echo 'selected'; } ?>>Hydrolift</option>
    <option value="Hyundai" <?php if($row_info['make'] === 'Hyundai') { echo 'selected'; } ?>>Hyundai</option>
    <option value="Hidrocon" <?php if($row_info['make'] === 'Hidrocon') { echo 'selected'; } ?>>Hidrocon</option>
    <option value="Ingersoll Rand" <?php if($row_info['make'] === 'Ingersoll Rand') { echo 'selected'; } ?>>Ingersoll Rand</option>
    <option value="Isuzu" <?php if($row_info['make'] === 'Isuzu') { echo 'selected'; } ?>>Isuzu</option>
    <option value="IHI" <?php if($row_info['make'] === 'IHI') { echo 'selected'; } ?>>IHI</option>
    <option value="JCB" <?php if($row_info['make'] === 'JCB') { echo 'selected'; } ?>>JCB</option>
    <option value="JLG" <?php if($row_info['make'] === 'JLG') { echo 'selected'; } ?>>JLG</option>
    <option value="Jaypee" <?php if($row_info['make'] === 'Jaypee') { echo 'selected'; } ?>>Jaypee</option>
    <option value="Jinwoo" <?php if($row_info['make'] === 'Jinwoo') { echo 'selected'; } ?>>Jinwoo</option>
    <option value="John Deere" <?php if($row_info['make'] === 'John Deere') { echo 'selected'; } ?>>John Deere</option>
    <option value="Jackson" <?php if($row_info['make'] === 'Jackson') { echo 'selected'; } ?>>Jackson</option>
    <option value="Kamaz" <?php if($row_info['make'] === 'Kamaz') { echo 'selected'; } ?>>Kamaz</option>
    <option value="Kato" <?php if($row_info['make'] === 'Kato') { echo 'selected'; } ?>>Kato</option>
    <option value="Kobelco" <?php if($row_info['make'] === 'Kobelco') { echo 'selected'; } ?>>Kobelco</option>
    <option value="Komatsu" <?php if($row_info['make'] === 'Komatsu') { echo 'selected'; } ?>>Komatsu</option>
    <option value="Konecranes" <?php if($row_info['make'] === 'Konecranes') { echo 'selected'; } ?>>Konecranes</option>
    <option value="Kubota" <?php if($row_info['make'] === 'Kubota') { echo 'selected'; } ?>>Kubota</option>
    <option value="KYB Conmat" <?php if($row_info['make'] === 'KYB Conmat') { echo 'selected'; } ?>>KYB Conmat</option>
    <option value="Krupp" <?php if($row_info['make'] === 'Krupp') { echo 'selected'; } ?>>Krupp</option>
    <option value="Kirloskar" <?php if($row_info['make'] === 'Kirloskar') { echo 'selected'; } ?>>Kirloskar</option>
    <option value="Kohler" <?php if($row_info['make'] === 'Kohler') { echo 'selected'; } ?>>Kohler</option>
    <option value="L&T" <?php if($row_info['make'] === 'L&T') { echo 'selected'; } ?>>L&T</option>
    <option value="Leeboy" <?php if($row_info['make'] === 'Leeboy') { echo 'selected'; } ?>>Leeboy</option>
    <option value="LGMG" <?php if($row_info['make'] === 'LGMG') { echo 'selected'; } ?>>LGMG</option>
    <option value="Liebherr" <?php if($row_info['make'] === 'Liebherr') { echo 'selected'; } ?>>Liebherr</option>
    <option value="Link-Belt" <?php if($row_info['make'] === 'Link-Belt') { echo 'selected'; } ?>>Link-Belt</option>
    <option value="Liugong" <?php if($row_info['make'] === 'Liugong') { echo 'selected'; } ?>>Liugong</option>
    <option value="Lorain" <?php if($row_info['make'] === 'Lorain') { echo 'selected'; } ?>>Lorain</option>
    <option value="Mahindra" <?php if($row_info['make'] === 'Mahindra') { echo 'selected'; } ?>>Mahindra</option>
    <option value="Manitou" <?php if($row_info['make'] === 'Manitou') { echo 'selected'; } ?>>Manitou</option>
    <option value="Maintowoc" <?php if($row_info['make'] === 'Maintowoc') { echo 'selected'; } ?>>Maintowoc</option>
    <option value="Marion" <?php if($row_info['make'] === 'Marion') { echo 'selected'; } ?>>Marion</option>
    <option value="MAIT" <?php if($row_info['make'] === 'MAIT') { echo 'selected'; } ?>>MAIT</option>
    <option value="Marchetti" <?php if($row_info['make'] === 'Marchetti') { echo 'selected'; } ?>>Marchetti</option>
    <option value="Noble Lift" <?php if($row_info['make'] === 'Noble Lift') { echo 'selected'; } ?>>Noble Lift</option>
    <option value="New Holland" <?php if($row_info['make'] === 'New Holland') { echo 'selected'; } ?>>New Holland</option>
    <option value="Palfinger" <?php if($row_info['make'] === 'Palfinger') { echo 'selected'; } ?>>Palfinger</option>
    <option value="Potain" <?php if($row_info['make'] === 'Potain') { echo 'selected'; } ?>>Potain</option>
    <option value="Putzmeister" <?php if($row_info['make'] === 'Putzmeister') { echo 'selected'; } ?>>Putzmeister</option>
    <option value="P&H" <?php if($row_info['make'] === 'P&H') { echo 'selected'; } ?>>P&H</option>
    <option value="Pinguely" <?php if($row_info['make'] === 'Pinguely') { echo 'selected'; } ?>>Pinguely</option>
    <option value="PTC" <?php if($row_info['make'] === 'PTC') { echo 'selected'; } ?>>PTC</option>
    <option value="Reva" <?php if($row_info['make'] === 'Reva') { echo 'selected'; } ?>>Reva</option>
    <option value="Sany" <?php if($row_info['make'] === 'Sany') { echo 'selected'; } ?>>Sany</option>
    <option value="Scania" <?php if($row_info['make'] === 'Scania') { echo 'selected'; } ?>>Scania</option>
    <option value="Schwing Stetter" <?php if($row_info['make'] === 'Schwing Stetter') { echo 'selected'; } ?>>Schwing Stetter</option>
    <option value="SDLG" <?php if($row_info['make'] === 'SDLG') { echo 'selected'; } ?>>SDLG</option>
    <option value="Sennebogen" <?php if($row_info['make'] === 'Sennebogen') { echo 'selected'; } ?>>Sennebogen</option>
    <option value="Shuttle Lift" <?php if($row_info['make'] === 'Shuttle Lift') { echo 'selected'; } ?>>Shuttle Lift</option>
    <option value="Skyjack" <?php if($row_info['make'] === 'Skyjack') { echo 'selected'; } ?>>Skyjack</option>
    <option value="Snorkel" <?php if($row_info['make'] === 'Snorkel') { echo 'selected'; } ?>>Snorkel</option>
    <option value="Soilmec" <?php if($row_info['make'] === 'Soilmec') { echo 'selected'; } ?>>Soilmec</option>
    <option value="Sunward" <?php if($row_info['make'] === 'Sunward') { echo 'selected'; } ?>>Sunward</option>
    <option value="Tadano" <?php if($row_info['make'] === 'Tadano') { echo 'selected'; } ?>>Tadano</option>
    <option value="Tata Hitachi" <?php if($row_info['make'] === 'Tata Hitachi') { echo 'selected'; } ?>>Tata Hitachi</option>
    <option value="TATA" <?php if($row_info['make'] === 'TATA') { echo 'selected'; } ?>>TATA</option>
    <option value="Terex" <?php if($row_info['make'] === 'Terex') { echo 'selected'; } ?>>Terex</option>
    <option value="TIL" <?php if($row_info['make'] === 'TIL') { echo 'selected'; } ?>>TIL</option>
    <option value="Toyota" <?php if($row_info['make'] === 'Toyota') { echo 'selected'; } ?>>Toyota</option>
    <option value="Teupen" <?php if($row_info['make'] === 'Teupen') { echo 'selected'; } ?>>Teupen</option>
    <option value="Unicon" <?php if($row_info['make'] === 'Unicon') { echo 'selected'; } ?>>Unicon</option>
    <option value="Urb Engineering" <?php if($row_info['make'] === 'Urb Engineering') { echo 'selected'; } ?>>Urb Engineering</option>
    <option value="Universal Construction" <?php if($row_info['make'] === 'Universal Construction') { echo 'selected'; } ?>>Universal Construction</option>
    <option value="Unipave" <?php if($row_info['make'] === 'Unipave') { echo 'selected'; } ?>>Unipave</option>
    <option value="Vogele" <?php if($row_info['make'] === 'Vogele') { echo 'selected'; } ?>>Vogele</option>
    <option value="Volvo" <?php if($row_info['make'] === 'Volvo') { echo 'selected'; } ?>>Volvo</option>
    <option value="Wirtgen Group" <?php if($row_info['make'] === 'Wirtgen Group') { echo 'selected'; } ?>>Wirtgen Group</option>
    <option value="XCMG Group" <?php if($row_info['make'] === 'XCMG Group') { echo 'selected'; } ?>>XCMG Group</option>
    <option value="XGMA" <?php if($row_info['make'] === 'XGMA') { echo 'selected'; } ?>>XGMA</option>
    <option value="Yanmar" <?php if($row_info['make'] === 'Yanmar') { echo 'selected'; } ?>>Yanmar</option>
    <option value="Zoomlion" <?php if($row_info['make'] === 'Zoomlion') { echo 'selected'; } ?>>Zoomlion</option>
    <option value="ZPMC" <?php if($row_info['make'] === 'ZPMC') { echo 'selected'; } ?>>ZPMC</option>
    <!-- <option value="Others" <?php if($row_info['make'] === 'Others') { echo 'selected'; } ?>>Others</option> -->
</select>
</div>

        <div class="trial1">
        <input type="text" value="<?php echo $row_info['model']?>" class="input02" placeholder="" name="model" required>
        <label class="placeholder2">Model</label>
        </div>
        
        </div>
        <div class="trial1" id="othermake01">
        <input type="text" placeholder="" name="other_make" id="" class="input02" >
        <label class="placeholder2">Specify Other Make</label>
        </div>

        
        <div class="cap_container">
        <div class="trial1">
    <input type="month" value="<?php echo $row_info['yom'] ?>" name="yom" placeholder="" class="input02" required min="1900" max="2099">
    <label class="placeholder2">YOM</label>
</div>
        <div class="trial1">
        <input type="text" value="<?php echo $row_info['capacity'] ?>" name="capacity" placeholder="" class="input02" required>
        <label class="placeholder2">Capacity</label>
        </div>
        <div class="trial1">
            <select name="unit" id="" class="input02" required>
            <option value="" disabled selected> Unit</option>
                <option <?php if($row_info['unit']==='Ton'){ echo 'selected';} ?> value="Ton">Ton</option>
                <option <?php if($row_info['unit']==='Kgs'){ echo 'selected';} ?> value="Kgs">Kgs</option>
                <option <?php if($row_info['unit']==='KnM'){ echo 'selected';} ?> value="KnM">KnM</option>
                <option <?php if($row_info['unit']==='Meter'){ echo 'selected';} ?> value="Meter">Meter</option>
                <option <?php if($row_info['unit']==='M³'){ echo 'selected';} ?> value="M³">M³</option>
            </select>
        </div>
        </div>
        <div class="outer02" id="reg_container">
            <div class="trial1"  >
                <select class="input02" id="regestration_dd" onchange="reg_input()">
                    <option value=""disabled selected>Registration ?</option>
                    <option <?php if($row_info['registrationdd']==='Yes'){echo "selected";} ?> value="Yes">Yes</option>
                    <option <?php if($row_info['registrationdd']==='No'){echo "selected";} ?> value="No">No</option>
                </select>
            </div>

        </div>
        <div class="trial1" id="registration_rental">
        <input type="text"  name="registration" value="<?php echo $row_info['registration'] ?>" placeholder="" class="input02">
        <label class="placeholder2">Registration Number</label>
        </div>


        <div class="outer02" id="chassis_make_rental_outer" >
        <div class="trial1" >
        <select name="chassis_make" class="input02 chassis_makedd" id="chassis_make_rental" onchange="chassis_make_rental1()" >
            <option value="">Choose Chassis Make</option>
            <option <?php if($row_info['chassis'] === 'AWM') { echo 'selected'; } ?> value="AWM">AWM</option>
    <option <?php if($row_info['chassis'] === 'Eicher') { echo 'selected'; } ?> value="Eicher">Eicher</option>
    <option <?php if($row_info['chassis'] === 'TATA') { echo 'selected'; } ?> value="TATA">TATA</option>
    <option <?php if($row_info['chassis'] === 'Bharat Benz') { echo 'selected'; } ?> value="Bharat Benz">Bharat Benz</option>
    <option <?php if($row_info['chassis'] === 'Ashok Leyland') { echo 'selected'; } ?> value="Ashok Leyland">Ashok Leyland</option>
    <option <?php if($row_info['chassis'] === 'Volvo') { echo 'selected'; } ?> value="Volvo">Volvo</option>
    <option <?php if($row_info['chassis'] === 'Other') { echo 'selected'; } ?> value="Other">Other</option>
        </select>
        </div>
        <div class="trial1" id="model_number">
            <input type="text" value="<?php echo $row_info['model_no'] ?>" name="model_no" placeholder="" class="input02">
            <label for="" class="placeholder2">Model No</label>
        </div>
        </div>
        <div class="trial1" id="otherchassis">
        <input type="text" name="new_chassis_maker" placeholder=""   class=" input02" >
        <label class="placeholder2">Specify Other Chassis Make</label>
        </div>
        <div class="trial1" id="forklift_height">
            <input type="number" name="height_meter" value="<?php echo $row_info['height'] ?>" placeholder="" class="input02">
            <label for="" class="placeholder2">Height/Meter</label>
        </div>
        <div class="outer02" id="tower_crane">
            <div class="trial1">
                <input type="number" name="total_height"  value="<?php echo $row_info['total_height'] ?>"  id="total_height_input"  placeholder="" class="input02">
                <label for="" class="placeholder2 tip_load_in_tons">Total Height In Mtr</label>
            </div>
            <div class="trial1">
                <input type="number" value="<?php echo $row_info['free_standing_height'] ?>" name="free_standing_height" id="free_standing_height"  placeholder="" class="input02">
                <label for="" id="" class="placeholder2 tip_load_in_tons">Free Standing Height</label>
            </div>
            <div class="trial1">
                <input type="number" value="<?php echo $row_info['tip_load'] ?>" name="tipload" id="tip_load_height" placeholder="" class="input02">
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
            <input type="number" value="<?php echo $row_info['boom_length'] ?>" name="boomLength"  placeholder="" class=" input02" >
            <label class="placeholder2">Boom Length</label>
        </div>    
        <div class="trial1" id="jib_input">
            <input type="number" name="jibLength" value="<?php echo $row_info['jib_length'] ?>"  placeholder="" class="input02 " >
            <label class="placeholder2">Jib Length</label>
        </div>
        <div class="trial1" id="luffing_input">
            <input type="number" name="luffingLength" value="<?php echo $row_info['luffing_length'] ?>" placeholder="" class=" input02" >
            <label class="placeholder2">Luffing Length</label>
        </div>
        </div>
        <div class="trial1" id="kealy_length">
            <input type="text" name='kealy' value="<?php echo $row_info['kealy_length'] ?>" placeholder="" class="input02">
            <label for="" class="placeholder2">Kealy Length</label>
        </div>
        <div class="trial1" id="pipelength">
            <input type="text" name='pipeline' value="<?php echo $row_info['pipelength_length'] ?>" placeholder="" class="input02">
            <label for="" class="placeholder2">Pipeline Length</label>
        </div>
        <div class="outer02" id="silos_container">
            <div class="trial1">
                <select name="silos_no" id="" class="input02">
                    <option value=""disabled selected>Silos No</option>
                    <option <?php if($row_info['silos_no']==='1'){ echo 'selected';} ?> value="1">1</option>
                    <option <?php if($row_info['silos_no']==='2'){ echo 'selected';} ?> value="2">2</option>
                    <option <?php if($row_info['silos_no']==='3'){ echo 'selected';} ?> value="3">3</option>
                    <option <?php if($row_info['silos_no']==='4'){ echo 'selected';} ?> value="4">4</option>
                    <option <?php if($row_info['silos_no']==='5'){ echo 'selected';} ?> value="5">5</option>
                </select>
            </div>
            <div class="trial1">
                <input type="text" name="cement_silos" value="<?php echo $row_info['cement_silos'] ?>" placeholder="" class="input02">
                <label for="" class="placeholder2">Cement Silos No</label>
            </div>
            <div class="trial1">
                <input type="text" name="flyash_silos" value="<?php echo $row_info['flyash_silos'] ?>" placeholder="" class="input02">
                <label for="" class="placeholder2">Flyash Silos No</label>
            </div>

        </div>
        <div class="outer02" id="silos_qty_container">
        <div class="trial1">
                <input type="text" value="<?php echo $row_info['cement_silos_qty'] ?>" name="cement_silos_qty" placeholder="" class="input02">
                <label for="" class="placeholder2">Cement Silos Qty</label>
            </div>
            <div class="trial1">
                <input type="text" value="<?php echo $row_info['flyash_silos_qty'] ?>" name="flyash_silos_qty" placeholder="" class="input02">
                <label for="" class="placeholder2">Flyash Silos Qty</label>
            </div>
                <div class="trial1">
                    <select name="chiller_available" id="" class="input02"> 
                        <option value=""disable selected>Chiller?</option>
                        <option <?php if($row_info['chiller_available']==='Yes'){ echo 'selected';} ?> value="Yes">Available</option>
                        <option <?php if($row_info['chiller_available']==='No'){ echo 'selected';} ?> value="No">Not Available</option>
                    </select>
                </div>

        </div>
                    <div class="trial1" id="bedlengthdiv">
                <input type="number" step="0.1" placeholder="" value="<?php echo $row_info['bedlength'] ?>" name="bedlength" id="bedlengthinput" class="input02">
                <label for="" class="placeholder2">Bed Length In Feet</label>
            </div>
            <div class="outer02">
            <div class="trial1" id="fuelefficiency">
            <input type="number" step="0.1" placeholder=""  value="<?php echo $row_info["fuelEficiency"] ?>" name="fuelEficiency" class="input02">
            <label for="" class="placeholder2">Fuel Eficiency</label>
            </div>
            <select name="fuelUnit" id="" class="input02">
                <option value=""disabled selected>Unit</option>
                <option <?php if($row_info['fuelUnit']==='ltrs/hour'){echo 'selected';} ?> value="ltrs/hour">ltrs/hour</option>
                <option <?php if($row_info['fuelUnit']==='kms/ltrs'){echo 'selected';} ?> value="kms/ltrs">kms/ltrs</option>
            </select>

            </div>

            <div class="outer02">
                <div class="trial1">
                    <select name="adblue" id="" class="input02">
                        <option <?php if($row_info['adblue']==='Yes'){echo 'selected';} ?> value="Yes">Adblue: Yes</option>
                        <option <?php if($row_info['adblue']==='No'){echo 'selected';} ?> value="No">Adblue: No</option>

                    </select>
                </div>
        <div class="trial1">
        <select class="input02" name="status" required >
            <option value="" disabled selected>Choose Current Status</option>
            <option <?php if($row_info['status']==='Working'){ echo 'selected';} ?> value="Working">Currently : Working</option>
            <option <?php if($row_info['status']==='Idle'){ echo 'selected';} ?> value="Idle">Currently : Idle</option>
            <!-- <option value="Not in use">Not in use</option> -->
        </select>
        </div>
        </div>
        <div class="trial1">
            <input type="text" placeholder="" value="<?php echo $row_info['equipmentLocation'] ?>" name="equipmentLocation" class="input02" required>
            <label for="" class="placeholder2">Equipment Location</label>
        </div>

        
        </div>

        <div class="first_form">
    <p>Work Order Details</p>
<div class="trial1">
<select class="input02"  onchange="client_nameadd()" id="workorder_DROPDOWN" name="workorder" >
            <option value="" disabled selected>Work Order Recieved ?</option>
            <option <?php if($row_info['workorder']==='yes'){ echo 'selected';} ?> value="yes">Work Order Recieved : Yes</option>
            <option <?php if($row_info['workorder']==='no'){ echo 'selected';} ?> value="no">Work Order Recieved : No</option>
        </select>
</div>  
<div class="client_info" id='outerclient1'> 
<div class="trial1">
    <a href="add_bill_client.php" class="client_list">If Client not in list add them here</a>
            <select name="client_name" id="" class="input02">
                <option value=""disabled selected>Choose Client Equipment Working At</option>
                <?php while($row_client=mysqli_fetch_assoc($result_clients)){?>
                    <option <?php if($row_info['client_name']=== $row_client['clientname']){ echo 'selected';} ?> value="<?php echo $row_client['clientname'] ?>"><?php echo  $row_client['clientname'] ?></option>
              <?php  } ?>
            </select>
</div> 
<div class="outer02">
    <div class="trial1">
        <input type="text" placeholder="" value="<?php echo $row_info['workorder_ref'] ?>" name="wo_refno" class="input02">
        <label for="" class="placeholder2">WO Ref No</label>
    </div>
    <div class="trial1">
        <input type="date" placeholder="" value="<?php echo $row_info['workorder_issueddate'] ?>" name="wo_date" class="input02">
        <label for="" class="placeholder2">WO Issued Date</label>
    </div>

</div>
<div class="outer02">
    <div class="trial1">
        <input type="text" placeholder="" value="<?php echo $row_info['woissuedby'] ?>" name="wo_issued_by" class="input02">
        <label for="" class="placeholder2">WO Issued By</label>
    </div>
    <div class="trial1">
        <input type="text" placeholder="" value="<?php echo $row_info['wocontactperson'] ?>" name="contact_personwo" class="input02">
        <label for="" class="placeholder2">Contact Person</label>
    </div>

    <div class="trial1">
        <input type="text" placeholder="" value="<?php echo $row_info['wocontactnumber'] ?>" name="contactmob_num" class="input02">
        <label for="" class="placeholder2">Contact Number</label>
    </div>

</div>
<div class="outer02">
    <div class="trial1">
        <input type="date" placeholder="" value="<?php echo $row_info['workorder_from']; ?>" name="workorder_start" class="input02">
        <label for="" class="placeholder2">Work Order From</label>
    </div>
<div class="trial1" id="wo_validity">  
        <input class="input02" type="date"   name="workorder_validity" value="<?php echo $row_info['workorder_valid']; ?>" placeholder="">
        <label class="placeholder2">Work Order To</label>
        </div>
        </div> 
        <div class="outer02">
                <div class="trial1">
                    <input type="text" name="working_days_month" value="<?php echo $row_info['working_days_in_month'] ?>" placeholder="" class="input02">
                    <label for="" class="placeholder2">Working Days</label>
                </div>
                <div class="trial1">
                    <select name="sunday_condition" id="" class="input02">
                        <option value="" disabled selected>Condition</option>
                        <option value="Including Sunday" <?php if($row_info['condition_sundays']==='Including Sunday'){ echo 'selected';} ?>>Including Sundays</option>
                        <option value="Excluding Sunday" <?php if($row_info['condition_sundays']==='Excluding Sunday'){ echo 'selected';} ?>>Excluding Sundays</option>
                    </select>
                </div>
                <div class="trial1">
                    <input type="text" placeholder="" value="<?php echo $row_info['fuel_norms'] ;?>" name="fuel_condition" class="input02">
                    <label for="" class="placeholder2">Fuel Norms </label>
                </div>
            </div>
            <div class="outer02" >
            <div class="trial1">
                <input type="text" placeholder="" value="<?php echo $row_info['project_name'] ?>" name="project_name" class="input02">
                <label for="" class="placeholder2">Project Name</label>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" value="<?php echo $row_info['project_location'] ?>" name="project_location" class="input02">
                <label for="" class="placeholder2">Project Location</label>
            </div>
            <!-- <div class="trial1">
                <input type="text" placeholder="" name="hour_shift" value="<?php echo $row_info['hour_shift'] ?>" class="input02">
                <label for="" class="placeholder2">Working Hours</label>
            </div> -->
            </div>
            <div class="outer02" >
            <div class="trial1">
                <input type="text" placeholder="" value="<?php echo $row_info['rental_charges_wo'] ?>"  name="rental_charges_wo" class="input02">
                <label for="" class="placeholder2">Rental Charges</label>
            </div>
            <div class="trial1">
                <select name="shift_wo" id="select_shift" class="input02" onchange="shift_hour()">
                    <option value=""disabled selected>Select Shift</option>
                    <option value="Single Shift" <?php if($row_info['shift_wo']==='Single Shift'){ echo 'selected';} ?>>Single Shift</option>
                    <option value="Double Shift" <?php if($row_info['shift_wo']==='Double Shift'){ echo 'selected';} ?>>Double Shift</option>
                    <option value="Double Shift" <?php if($row_info['shift_wo']==='Flexi Shift'){ echo 'selected';} ?>>Flexi Shift</option>
                </select>
        </div>
        <div class="trial1" id="single_Shift_hour">
            <!-- <input type="text" placeholder="" name="shifthours" class="input02">
            <label for="" class="placeholder2">Shift Hours</label> -->
            <select name="hour_shift" id="" class="input02">
                <option value="">Shift Duration</option>
                <option value="8">8 Hours</option>
                <option value="10">10 Hours</option>
                <option value="12">12 Hours</option>
                <option value="14">14 Hours</option>
                <option value="16">16 Hours</option>
            </select>

        </div>
        <div class="trial1" id="othershift_enginehour">
            <!-- <input type="text" placeholder="" name="enginehours" class="input02">
            <label for="" class="placeholder2">Engine Hours</label> -->
            <select name="engine_hour" id="" class="input02">
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

        </div>

            <div class="trial1">
                <select name="ot_charges" id="" class="input02">
                    <option value=""disabled selected>OT Charges</option>
                    <option value="10"<?php if($row_info['ot_charges']==='10'){ echo 'selected';} ?> >10% pro-rata</option>
                    <option value="20" <?php if($row_info['ot_charges']==='20'){ echo 'selected';} ?>>20% pro-rata</option>
                    <option value="30" <?php if($row_info['ot_charges']==='30'){ echo 'selected';} ?>>30% pro-rata</option>
                    <option value="40" <?php if($row_info['ot_charges']==='40'){ echo 'selected';} ?>>40% pro-rata</option>
                    <option value="50" <?php if($row_info['ot_charges']==='50'){ echo 'selected';} ?>>50% pro-rata</option>
                    <option value="60" <?php if($row_info['ot_charges']==='60'){ echo 'selected';} ?>>60% pro-rata</option>
                    <option value="70" <?php if($row_info['ot_charges']==='70'){ echo 'selected';} ?>>70% pro-rata</option>
                    <option value="80" <?php if($row_info['ot_charges']==='80'){ echo 'selected';} ?>>80% pro-rata</option>
                    <option value="90" <?php if($row_info['ot_charges']==='90'){ echo 'selected';} ?>>90% pro-rata</option>
                    <option value="100" <?php if($row_info['ot_charges']==='100'){ echo 'selected';} ?>>100% pro-rata</option>
                </select>
            </div>

            </div>

</div>



</div>



 









    </div>
    <div class="second_two_form_container">

    <div class="second_form">
            <p>Machine Details</p>
            <div class="fourthrow">
        <div class="trial1">
        <input class="input02" value="<?php echo $row_info['rc_valid']; ?>" type="date" name="rc_validity"  placeholder="">
        <label class="placeholder2">RC-Validity</label>
        </div>
        <div class="trial1">
        <input class="input02" type="date" value="<?php echo $row_info['fc_valid']; ?>" name="fc_validity"  placeholder="">
        <label class="placeholder2">FC-Validity</label>
        </div>
        </div>
        <div class="fourthrow">
        <div class="trial1">
            <input class="input02" value="<?php echo $row_info['insaurance_valid']; ?>" type="date"  name="insaurance"  placeholder="">
            <label class="placeholder2">Insaurance-Validity</label>
        </div>
        <div class="trial1">
            <input class="input02" type="date" value="<?php echo $row_info['np_valid']; ?>" name="np_validity"  placeholder="">
            <label class="placeholder2">NP-Validity</label>
        </div>
        </div> 




            <div class="outer02">
            <div class="trial1">
            <input type="text" name="dieselTankCap" value="<?php echo $row_info['diesel_tank_capacity']; ?>" placeholder="" class="input02" >
            <label class="placeholder2">Diesel Tank Capacity</label>
            </div>
            <div class="trial1">
                <input type="text" name="adbluetank" value="<?php echo $row_info['adbluetank'] ?>" placeholder="" class="input02">
                <label for="" class="placeholder2">Adblue Tank</label>
            </div>
            </div>
            <div class="hydraulic_outer">
            <div class="trial1">
            <input type="text" name="hydraulicOilTank" value="<?php echo $row_info['hydraulic_oil_tank']; ?>" placeholder="" class="input02" >
            <label class="placeholder2">Hydraulic oil tank</label>
            </div>
            <div class="trial1">
            <input type="text" name="hydraulicOilGrade" value="<?php echo $row_info['hydraulic_oil_grade']; ?>" placeholder="" class="input02" >
            <label class="placeholder2">Hydraulic oil grade</label>
            </div>
            </div>
            <div class="hydraulic_outer">
            <div class="trial1">
            <input type="text" name="engineOilCapacity" value="<?php echo $row_info['engine_oil_capacity']; ?>" placeholder="" class="input02" >
            <label class="placeholder2">Engine oil Capacity</label>
            </div>
            <div class="trial1">
            <input type="text" name="engineOilGrade" value="<?php echo $row_info['engine_oil_grade']; ?>" placeholder="" class="input02" >
            <label class="placeholder2">Engine oil Grade</label>
            </div>
            </div>
            <h6>Main WIre Rope Section</h6>
            <div class="outer02">
                <div class="trial1">
                    <input type="text" placeholder="" value="<?php echo $row_info['main_wire_dia'] ?>" name="mainwire_dia" class="input02">
                    <label for="" class="placeholder2">Dia/mm</label>
                </div>
                <div class="trial1">
                    <input type="text" placeholder="" value="<?php echo $row_info['main_wire_length'] ?>" name="mainwire_length" class="input02">
                    <label for="" class="placeholder2">Length/mtr</label>
                </div>

            </div>
            <h6>Secondary WIre Rope Section</h6>
            <div class="outer02">
                <div class="trial1">
                    <input type="text" placeholder="" value="<?php echo $row_info['second_wire_dia'] ?>" name="secondwire_dia" class="input02">
                    <label for="" class="placeholder2">Dia/mm</label>
                </div>
                <div class="trial1">
                    <input type="text" placeholder="" value="<?php echo $row_info['second_wire_length'] ?>" name="secondwire_length" class="input02">
                    <label for="" class="placeholder2">Length/mtr</label>
                </div>

            </div>
            <div class="trial1">
                <input type="file" placeholder="" name="loadchart" class="input02">
                <label for="" class="placeholder2">Upload Load Chart</label>
            </div>

        </div>

<div class="second_form">
    <p>Fleet Manager Detail</p>
    <div class="trial1">
            <h6 class="addoperator_ifnot">If Your operator is not in the options please add it in <a href="addoperator.php">Add Operator</a></h6>
        </div>
        <div class="outer02" id="operator_name_">
        <div class="trial1">
            <select class="input02" type="text" name="operator-fname"  placeholder="" >
                <option value="" disabled selected>Choose Operator Name</option>
                <?php while($row_operator=mysqli_fetch_assoc($result_operator)) {?>
                    <option <?php if($row_info['operator_fname']===$row_operator['operator_fname']){ echo 'selected';} ?> value="<?php echo $row_operator['operator_fname'] ?>"><?php echo $row_operator['operator_fname'] ?></option>

               <?php }?>
        
                </select>

</div>
<select name="operator-fname2"  class="input02" id="secondoperator_name">
    <option value=""disbaled selected>2nd Operator</option>
    <?php while($row_operator2=mysqli_fetch_assoc($result_operator2)) {?>
                    <option <?php if($row_info['operator_fname2']=== $row_operator2['operator_fname']){ echo 'selected';} ?> value="<?php echo $row_operator2['operator_fname'] ?>"><?php echo $row_operator2['operator_fname'] ?></option>

               <?php }?>

</select>
<!-- <div class="trial1" id="plus_icon_op">
<i title="Add second operator" onclick="second_operator()" class="fa-solid fa-plus"></i>

</div> -->
</div>
<div class="trial1">
            <h6 class="addoperator_ifnot">If Your Healper is not in the options please add it in <a href="addoperator.php">Add Helper</a></h6>

        </div>
<div class="outer02">
    <div class="trial1">
    <select name="helper1" id="" class="input02">
        <option value=""disabled selected>Helper Name</option>
        <?php while($row_helper=mysqli_fetch_assoc($result_helper)) {?>
                    <option <?php if($row_info['helper1']===$row_helper['operator_fname']){ echo 'selected';} ?> value="<?php echo $row_helper['operator_fname'] ?>"><?php echo $row_helper['operator_fname'] ?></option>

               <?php }?>


    </select>
</div>
<div class="trial1" id="second_helper_name">
    <select name="helper2" id="" class="input02">
        <option value=""disabled selected>2nd Helper Name</option>
        <?php while($row_helper2=mysqli_fetch_assoc($result_helper2)) {?>
                    <option <?php if($row_info['helper2']===$row_helper2['operator_fname']){ echo 'selected';} ?> value="<?php echo $row_helper2['operator_fname'] ?>"><?php echo $row_helper2['operator_fname'] ?></option>

               <?php }?>

    </select>
</div>
<!-- <div class="trial1" id="plus_icon_helper">
<i title="Add second operator" onclick="second_helper()" class="fa-solid fa-plus"></i>

</div> -->

</div>
<div class="links" id="editfleetbutton">
      <button id="editfleet" class="follow" type="submit">UPDATE FLEET</button>
      <!-- <button class="view">View profile</button> -->
      </div>


</form>
<script>
        document.addEventListener('DOMContentLoaded', function() {
    // Check if choose_Ac2 is not empty and call choose_new_equ2()
    var workorder_DROPDOWN = document.getElementById('workorder_DROPDOWN');
    if (workorder_DROPDOWN.value !== '') {
        client_nameadd();
    }
});
        document.addEventListener('DOMContentLoaded', function() {
    // Check if choose_Ac2 is not empty and call choose_new_equ2()
    var oem_fleet_type = document.getElementById('oem_fleet_type');
    if (oem_fleet_type.value !== '') {
        purchase_option();
    }
});
        document.addEventListener('DOMContentLoaded', function() {
    // Check if choose_Ac2 is not empty and call choose_new_equ2()
    var fleet_sub_type = document.getElementById('fleet_sub_type');
    if (fleet_sub_type.value !== '') {
        crawler_options();
    }
});

    function second_operator(){
        document.getElementById("secondoperator_name").style.display='block';
        document.getElementById("plus_icon_op").style.display='none';
    }
    function second_helper(){
        document.getElementById("second_helper_name").style.display='block';
        document.getElementById("plus_icon_helper").style.display='none';
    }



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
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
    // Check if choose_Ac2 is not empty and call choose_new_equ2()
    var regestration_dd = document.getElementById('regestration_dd');
    if (regestration_dd.value !== '') {
        reg_input();
    }
});


    </script>
</body>
</html>