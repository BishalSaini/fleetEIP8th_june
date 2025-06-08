<?php 
include "partials/_dbconnect.php";
session_start();

$id = $_GET['id'];
$companyname001 = $_SESSION['companyname'];

// Sanitize input
$id = mysqli_real_escape_string($conn, $id);
$companyname001 = mysqli_real_escape_string($conn, $companyname001);

$sql = " DELETE FROM `workorder` WHERE id='$id' AND companyname='$companyname001'";
$result = mysqli_query($conn, $sql);

if ($result) {
    $_SESSION['success'] = 'true';
} else {
    $_SESSION['error'] = 'true';
}

header("Location: workorder.php");
exit(); 
?>
