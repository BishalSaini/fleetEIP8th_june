<?php
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

include 'partials/_dbconnect.php';

$id=$_GET['id'];
$sql_epc="SELECT * FROM  `closed_requirement_epc_latest` WHERE id='$id'";
$result=mysqli_query($conn,$sql_epc);
$row=mysqli_fetch_assoc($result);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">      <link rel="icon" href="favicon.jpg" type="image/x-icon">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>
    <div class="navbar1">
    <div class="logo_fleet">
    <img src="logo_fe.png" alt="FLEET EIP" onclick="window.location.href='<?php echo $dashboard_url  ?>'">
</div>

        <div class="iconcontainer">
        <ul>
            <li><a href="epc_dashboard.php">Dashboard</a></li>
            <li><a href="view_news_epc.php">News</a></li>
            
            <li><a href="logout.php">Log Out</a></li></ul>
        </div>
    </div> 
    <form action="" method="POST" class="epc_req1">
    <div class="epc_red_div">
        <div class="epc_req_heading"><h2>View Your Requirement</h2></div>
        <div class="outer02">
            <div class="trial1">
                <!-- <select name="" id="" class="input02">
                    <option value=""disabled selected>Choose Project Code</option>
                </select> -->
                <input type="text" placeholder="" value="<?php echo $row['project_code'] ?>" name="project_code" class="input02" readonly>
                <label for="" class="placeholder2">Project Code</label>
            </div>
<div class="trial1">
    <input type="text" placeholder="" value="<?php echo $row['project_type'] ?>" class="input02" readonly>
    <label for="" class="placeholder2">Project Type</label>
</div>
<div class="trial1">
    <input type="text" placeholder="" value="<?php echo $row['tentative_date'] ?>" class="input02" readonly>
    <label for="" class="placeholder2">Equipment Required At Site</label>
</div>
        </div>
        <div class="outer02">
            <div class="trial1">
                <input type="text" placeholder="" value="<?php echo $row['fleet_category'] ?>" class="input02" readonly>
                <label for="" class="placeholder2">Equipment Category</label>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" value="<?php echo $row['equipment_type'] ?>" class="input02" readonly>
                <label for="" class="placeholder2">Equipment Type</label>
            </div>
        </div>
        <div class="outer02">
            <div class="trial1">
                <input type="text" placeholder="" value="<?php echo $row['equipment_capacity'] ?>" class="input02" readonly>
                <label for="" class="placeholder2">Equipment Capacity</label>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" value="<?php echo $row['unit'] ?>" class="input02" readonly>
                <label for="" class="placeholder2">Unit</label>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" value="<?php echo $row['boom_combination'] ?>" class="input02" readonly>
                <label for="" class="placeholder2">Boom Combination</label>
            </div>
        </div>
        <div class="outer02">
            <div class="trial1">
                <input type="text" class="input02" value="<?php echo $row['working_shift'] ?>" placeholder="" readonly>
                <label for="" class="placeholder2">Working Shift</label>
            </div>
            <div class="trial1">
                <input type="text" class="input02" value="<?php echo $row['fuel_scope'] ?>" placeholder="" readonly>
                <label for="" class="placeholder2">Fuel In Scope Of</label>
            </div>
            <div class="trial1">
                <input type="text" class="input02" value="<?php echo $row['accomodation_scope'] ?>" placeholder="" readonly>
                <label for="" class="placeholder2">Accomodation In Scope Of</label>
            </div>
        </div>
        <div class="outer02">
            <div class="trial1">
                <input type="text" class="input02" value="<?php echo $row['duration_month'] ?>" placeholder="" readonly>
                <label for="" class="placeholder2">Duration In Month</label>
            </div>
            <div class="trial1">
                <input type="text" class="input02" value="<?php echo $row['state'] ?>" placeholder="" readonly>
                <label for="" class="placeholder2">Project State</label>
            </div>
            <div class="trial1">
                <input type="text" class="input02" value="<?php echo $row['district'] ?>" placeholder="" readonly>
                <label for="" class="placeholder2">Project District</label>
            </div>
        </div>
        <?php
            $engine_Style = empty($row['engine_hour']) ? 'style="display:none"' : '';
            ?>

        <div class="trial1" <?php echo $engine_Style ?>>
            <input type="text" placeholder="" value="<?php echo $row['engine_hour'] ?>" class="input02" readonly>
            <label for="" class="placeholder2">Engine Hour</label>
        </div>
        <div class="outer02">
            <div class="trial1">
                <input type="text" class="input02" value="<?php echo $row['contact_person'] ?>" placeholder="" readonly>
                <label for="" class="placeholder2">Contact Person</label>
            </div>
            <div class="trial1">
                <input type="text" class="input02" value="<?php echo $row['epc_number'] ?>" placeholder="" readonly>
                <label for="" class="placeholder2">Contact Number</label>
            </div>
           
        </div>
        <div class="trial1">
    <textarea placeholder="" class="input02" readonly><?php echo $row['notes']; ?></textarea>
    <label class="placeholder2">Notes For Vendor</label>
</div>
        <div class="trial1">
            <input type="text" placeholder="" value="<?php echo $row['platform'] ?>" class="input02">
            <label for="" class="placeholder2">Requirement Fullfill Platform</label>
        </div>
        <?php
            $vendor_Style = empty($row['vendor']) ? 'style="display:none"' : '';
            ?>
        <div class="trial1" <?php echo $vendor_Style ?>>
            <input type="text" placeholder="" value="<?php echo $row['vendor'] ?>" class="input02">
            <label for="" class="placeholder2">Vendor</label>
        </div>
        <br></div>

</body>
</html>