<?php 
include "partials/_dbconnect.php";
$employeeid = $_GET['id'];
$clientid = $_GET['clientid'];
session_start();
$companyname001 = $_SESSION['companyname'];

$sql = "UPDATE `rentalclients` SET `status` = 'active' WHERE id = '$employeeid' AND companyname = '$companyname001'";
$result = mysqli_query($conn, $sql);

if ($result) {
    $_SESSION['success'] = 'true';
} else {
    $_SESSION['error'] = 'true';
}

// Fixing the header redirection syntax
header("Location: rentalclientdetail.php?id=" . urldecode($clientid));
exit();
?>
