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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">      <link rel="icon" href="favicon.jpg" type="image/x-icon">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php 
        include_once 'partials/_dbconnect.php';

    $id=$_GET['id'];
    $reasons=$_GET['reasons'];
    $sql="SELECT * FROM `req_by_epc` WHERE id='$id'";
    $result=mysqli_query($conn , $sql);
    $row=mysqli_fetch_assoc($result);


    $sql_notinterested = "INSERT INTO `notinterested_rental` (`requirement_id`, `equipment_type`,`equipment_capacity`, `boom_combination`, `project_type`, `state`, `district`, `duration`, `shift`, `tentative_date`, `epc_company`, `epc_email`, `epc_contact`, `rental_name`, `rental_email`, `not_interested_reason`)
    VALUES ('$id','".$row['equipment_type']."', '".$row['equipment_capacity']."', '".$row['boom_combination']."', '".$row['project_type']."', '".$row['state']."', '".$row['district']."', '".$row['duration_month']."', '".$row['working_shift']."', '".$row['tentative_date']."', '".$row['epc_name']."', '".$row['epc_email']."', '".$row['epc_number']."', '$companyname001', '$email', '$reasons')";
    $result=mysqli_query($conn, $sql_notinterested);
    if ($result){
        $_SESSION['success_msg'] = "Data inserted successfully";
        header("location:view_req_rentalinner.php");

    }
    ?>
</body>
</html>


