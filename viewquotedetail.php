<?php
session_start();
$showAlert=false;
$showError=false;
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
elseif ($enterprise === 'admin') {
    $dashboard_url = 'news/admin/dashboard.php';
} 


else {
    $dashboard_url = '';
}
include "partials/_dbconnect.php";
$id=$_GET['id'];
$sql="SELECT * FROM `requirement_price_byrental` where id=$id";
$result=mysqli_query($conn,$sql);
if(mysqli_num_rows($result)>0){
    $row=mysqli_fetch_assoc($result);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View</title>
    <link rel="stylesheet" href="style.css">
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
            <li><a href="view_news_epc.php">News</a></li>
            
            <li><a href="logout.php">Log Out</a></li></ul>
        </div>
    </div> 
<form action="" class="quotedetailform " >
    <div class="quoteformcontainer">
        <p class="headingpara">View Quote</p>
        <div class="trial1">
            <input type="text" value="<?php echo $row['rental_name'] ?>" class="input02" readonly>
            <label for="" class="placeholder2">Company Name</label>
        </div>
        <div class="trial1">
            <input type="text" value="<?php echo $row['contact_person_offer'] ?>" class="input02" readonly>
            <label for="" class="placeholder2">Contact Person</label>
        </div>
        <div class="outer02">
        <div class="trial1">
            <input type="text" value="<?php echo $row['rental_email'] ?>" class="input02" readonly>
            <label for="" class="placeholder2">Email</label>
        </div>
        <div class="trial1">
            <input type="text" value="<?php echo $row['rental_number'] ?>" class="input02" readonly>
            <label for="" class="placeholder2">Cell</label>
        </div>
        </div>
        <div class="outer02">
        <div class="trial1">
            <input type="text" value="<?php echo $row['offer_make'] ?>" class="input02" readonly>
            <label for="" class="placeholder2">Make</label>
        </div>
        <div class="trial1">
            <input type="text" value="<?php echo $row['offer_model'] ?>" class="input02" readonly>
            <label for="" class="placeholder2">Model</label>
        </div>
        <div class="trial1">
            <input type="text" value="<?php echo $row['offer_yom'] ?>" class="input02" readonly>
            <label for="" class="placeholder2">YOM</label>
        </div>

        <div class="trial1">
            <input type="text" value="<?php echo $row['cap'].' '.$row['unit'] ?>" class="input02" readonly>
            <label for="" class="placeholder2">Capacity</label>
        </div>
        </div>
        <div class="outer02">
            <div class="trial1">
                <input type="text" value="<?php echo $row['boom'] ?>" class="input02">
                <label for="" class="placeholder2">Boom</label>
            </div>
            <div class="trial1">
                <input type="text" value="<?php echo $row['jib'] ?>" class="input02">
                <label for="" class="placeholder2">Jib</label>
            </div>
            <div class="trial1">
                <input type="text" value="<?php echo $row['luffing'] ?>" class="input02">
                <label for="" class="placeholder2">Luffing</label>
            </div>
        </div>
        <div class="trial1">
        <input type="text" value="<?php echo (new DateTime($row['available_From_offer']))->format('jS M Y'); ?>" class="input02 " readonly>
        <label for="" class="placeholder2">Available From</label>
        </div>
        <div class="outer02">
        <div class="trial1">
            <input type="text" value="<?php echo $row['offer_equip_location'] ?>" class="input02" readonly>
            <label for="" class="placeholder2">Equipment Location</label>
        </div>
        <div class="trial1">
            <input type="text" value="<?php echo $row['offer_district'] ?>" class="input02" readonly>
            <label for="" class="placeholder2">District </label>
        </div>

        </div>
        <div class="outer02">
        <div class="trial1">
            <input type="text" value="<?php echo $row['offer_assembly'] ?>" class="input02" readonly>
            <label for="" class="placeholder2">Assembly Required</label>
        </div>
        <div class="trial1">
            <input type="text" value="In <?php echo $row['offer_assembly_scope'] ?> Scope" class="input02" readonly>
            <label for="" class="placeholder2">Assembly Scope</label>
        </div>


        </div>
        <div class="trial1">
            <input type="text" value="<?php echo $row['payment_terms'] ?>" class="input02" readonly>
            <label for="" class="placeholder2">Payment Terms</label>
        </div>
        <div class="outer02">
        <div class="trial1">
        <input type="text" value="<?php echo number_format($row['price_quoted'], 0); ?>" class="input02" readonly>
        <label for="" class="placeholder2">Rental</label>
        </div>
        <div class="trial1">
        <input type="text" value="<?php echo number_format($row['mob_charges'], 0); ?>" class="input02" readonly>
        <label for="" class="placeholder2">MOB Charges</label>
        </div>
        <div class="trial1">
        <input type="text" value="<?php echo number_format($row['demob_charges'], 0); ?>" class="input02" readonly>
        <label for="" class="placeholder2">DeMOB Charges</label>
        </div>

        </div>
        <div class="trial1">
        <textarea class="input02" name="" id="" readonly><?php echo $row['rental_notes'] ?></textarea>
        <label for="" class="placeholder2">Notes</label>
        </div>
        <br>

    </div>
</form>
</body>
</html>