<?php
include "partials/_dbconnect.php";
$id=$_GET['id'];
$sql="DELETE FROM `fleeteip_clientlist` WHERE id='$id'";
$result=mysqli_query($conn,$sql);
session_start();
if($result){
    $_SESSION['success']="true";
}
else{
    $_SESSION['error']="false";
}
header("Location: admin_addclient_directory.php");