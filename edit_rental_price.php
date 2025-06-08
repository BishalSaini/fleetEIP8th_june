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
elseif ($enterprise === 'admin') {
    $dashboard_url = 'news/admin/dashboard.php';
} 


else {
    $dashboard_url = '';
}

include 'partials/_dbconnect.php';
$edit_id = $_GET['id']; 
$sql = "
    SELECT rp.id AS rp_id, rp.price_quoted,rp.mob_charges,rp.demob_charges,rp.contact_person_offer ,rp.rental_email, rp.rental_number, r.*
    FROM `requirement_price_byrental` rp
    INNER JOIN `req_by_epc` r ON rp.req_id = r.id
    WHERE rp.req_id = '$edit_id'
";
$result = mysqli_query($conn , $sql);
$row = mysqli_fetch_assoc($result);
?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'partials/_dbconnect.php';
    $id= $_POST['id'];
    $price = $_POST['edit_price'];
    $contact = $_POST['edit_number'];
    $mobcharges = $_POST['mobcharges'];
    $demobcharges = $_POST['demobcharges'];
    $rental_contact_email= $_POST['rental_contact_email'];
    $contactpersonrental= $_POST['contactpersonrental'];

    $sql_update = "UPDATE `requirement_price_byrental` 
    SET price_quoted = '$price', 
        rental_number = '$contact', 
        mob_charges = '$mobcharges', 
        demob_charges = '$demobcharges',
        rental_email = '$rental_contact_email',
        contact_person_offer = '$contactpersonrental'
    WHERE id = '$id'
";   

$result = mysqli_query($conn,$sql_update);
    if($result){
        session_start();
        $_SESSION['success']="success";
        header("location:quoted_pricerental.php");
    }
    else{
        $_SESSION['wrong']="success";
        header("location:quoted_pricerental.php");
 
    }
}
?>
<script>
    <?php include "main.js" ?>
    </script>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">      <link rel="icon" href="favicon.jpg" type="image/x-icon">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Edit Price</title>
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
<form action="edit_rental_price.php" method="POST" class="epc_req1">
    <div class="epc_red_div" id="reqrentalpriceedit">
        <div class="epc_req_heading"><h2> Requirement Details</h2></div>
        <div class="trial1" hidden>
        <input type="hidden" name="id" class="input02" value="<?php echo htmlspecialchars($row['rp_id']); ?>" placeholder="" readonly>
        <label class="placeholder2" hidden>Equipment Type</label >
        </div>
        <div class="outer02">

        <div class="trial1">
        <input type="text" name="equip_type" class="input02" value="<?php echo $row['equipment_type'] ?>" placeholder="" readonly>
        <label class="placeholder2">Equipment Type</label>
        </div>
        <div class="trial1">
        <input type="text" name="equip_type" class="input02" value="<?php echo $row['equipment_capacity'] ?>" placeholder="" readonly>
        <label class="placeholder2">Equipment Capacity</label>
        </div>
        <div class="trial1">
        <input type="text" name="equip_type" class="input02" value="<?php echo $row['boom_combination'] ?>" placeholder="" readonly>
        <label class="placeholder2">Boom Combination</label>
        </div>
        </div>
        <div class="outer02">
        <div class="trial1">
        <input type="text" name="equip_type" class="input02" value="<?php echo $row['project_type'] ?>" placeholder="" readonly>
        <label class="placeholder2">Project Type</label>
        </div>
        <div class="trial1">
        <input type="text" name="equip_type" class="input02" value="<?php echo $row['state'] ?>" placeholder="" readonly>
        <label class="placeholder2">Project State</label>
        </div>
        <div class="trial1">
        <input type="text" name="equip_type" class="input02" value="<?php echo $row['district'] ?>" placeholder="" readonly>
        <label class="placeholder2">Project District</label>
        </div></div>
        <div class="outer02">
        <div class="trial1">
        <input type="text" name="equip_type" class="input02" value="<?php echo $row['working_shift'] ?>" placeholder="" readonly>
        <label class="placeholder2">Working Shift</label>
        </div>
        <div class="trial1">
        <input type="text" name="equip_type" class="input02" value="<?php echo (new DateTime($row['tentative_date']))->format('jS M Y'); ?>" placeholder="" readonly>
        <label class="placeholder2">Equipment Required At Site</label>
        </div>
        </div>
        <div class="outer02">
        <div class="trial1">
        <input type="text" name="equip_type" class="input02" value="<?php echo $row['epc_name'] ?>" placeholder="" readonly>
        <label class="placeholder2">EPC</label>
        </div>
        <div class="trial1">
        <input type="text" name="equip_type" class="input02" value="<?php echo $row['epc_email'] ?>" placeholder="" readonly>
        <label class="placeholder2">EPC Email</label>
        </div>
        <div class="trial1">
        <input type="text" name="equip_type" class="input02" value="<?php echo $row['epc_number'] ?>" placeholder="" readonly>
        <label class="placeholder2">Contact Number</label>
        </div>
        </div>
        <div class="outer02">
        <div class="trial1 hideit">
        <input type="text" name="equip_type" class="input02" value="<?php echo $row['rental_name'] ?>" placeholder="" readonly >
        <label class="placeholder2">Rental Company Name</label>
        </div>
        <div class="trial1">
            <input type="text" placeholder="" name="contactpersonrental" value="<?php echo $row['contact_person_offer'] ?>" class="input02">
            <label for="" class="placeholder2">Contact Person</label>
        </div>
        <div class="trial1">
        <input type="text" name="rental_contact_email" class="input02" value="<?php echo $row['rental_email'] ?>" placeholder="" >
        <label class="placeholder2">Contact Email</label>
        </div>
        <div class="trial1">
        <input type="text" name="edit_number" class="input02" value="<?php echo $row['rental_number'] ?>" placeholder=""  >
        <label class="placeholder2">Contact Number</label>
        </div>
        </div>
        <div class="outer02">
        <div class="trial1">
        <input type="text" name="edit_price" class="input02" value="<?php echo htmlspecialchars($row['price_quoted']); ?>" placeholder="">
        <label class="placeholder2">Rental</label>
        </div>
        <div class="trial1">
            <input type="text" name="mobcharges" value="<?php echo htmlspecialchars($row['mob_charges']); ?>" class="input02">
            <label for="" class="placeholder2">Mob Charges</label>
        </div>
        <div class="trial1">
            <input type="text" name="demobcharges" value="<?php echo htmlspecialchars($row['demob_charges']); ?>" class="input02">
            <label for="" class="placeholder2">DeMob Charges</label>
        </div>

        </div>

        <button class="epc-button" type="submit">Update </button>
        <br><br>
</form>
</body>
</html>