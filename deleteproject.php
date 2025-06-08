<?php
session_start();
include "partials/_dbconnect.php";
$companyname001=$_SESSION['companyname'];
$delid=$_GET['id'];
$sql="DELETE FROM `epcproject` WHERE id='$delid' and companyname='$companyname001'";
$result=mysqli_query($conn,$sql);
if($result){
    session_start();
    $_SESSION['success']='true';
}
else{
    $_SESSION['error']='true';
}
header('Location: myprojects.php');
exit();