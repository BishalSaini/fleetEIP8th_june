<?php
include "partials/_dbconnect.php";
$id=$_GET['id'];
session_start();
$compannyname001=$_SESSION['companyname'];
$sql="DELETE FROM `employeedetails` where id=$id and companyname='$compannyname001'";
$result=mysqli_query($conn,$sql);
if($result){
    $_SESSION['success']='true';
}
else{
    $_SESSION['error']='true';

}
header("Location: offerletterdashboard.php");
exit();