<?php
session_start();
include "partials/_dbconnect.php";
$companyname001=$_SESSION['companyname'];
$id=$_GET['id'];
$clientid=$_GET['clientid'];

$sql="DELETE FROM `rentalclients` WHERE id='$id' and companyname='$companyname001'";
$result=mysqli_query($conn,$sql);
if($result){
    session_start();
    $_SESSION['success']='success';
    header("Location:rentalclientdetail.php?id=" .urlencode($clientid));
}
else{
    $_SESSION['error']='success';
    header("Location:rentalclientdetail.php?id=" .urlencode($clientid));
 
}