<?php
$id=$_GET['id'];
include "partials/_dbconnect.php";
session_start();
$companyname001=$_SESSION['companyname'];
$approve="UPDATE `employeedetails` SET `status`='Working' where id=$id and companyname='$companyname001'";
$resultapprove=mysqli_query($conn,$approve);
if($resultapprove){
    $_SESSION['success']='true';
}
else{
    $_SESSION['error']='true';

}
header("Location: newjoiner.php");