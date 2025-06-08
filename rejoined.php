<?php 
session_start();
include "partials/_dbconnect.php";
$companyname001 = $_SESSION['companyname'];
$id = $_GET['id'];
$updatestatus = "UPDATE `employeedetails` SET `status`='Working' , relievingdate='' WHERE `id`=$id AND companyname='$companyname001'"; 
$resultupdate = mysqli_query($conn, $updatestatus);

if ($resultupdate) {
    $_SESSION['success'] = 'true';
} else {
    $_SESSION['error'] = 'true';
}

header("Location: newjoiner.php");
exit();
?>
