<?php
include "partials/_dbconnect.php";
session_start();
$companyname001=$_SESSION['companyname'];
$delid=$_GET['id'];
$sql="DELETE FROM `employeedetails` WHERE id='$delid' and companyname='$companyname001'";
$result=mysqli_query($conn,$sql);
if($result){
    $_SESSION['success']='true';
}
else{
    $_SESSION['error']='true';
}
header("Location: newjoiner.php");
exit();