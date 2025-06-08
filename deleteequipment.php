<?php
include "partials/_dbconnect.php";
$id=$_GET['id'];
$sql="DELETE FROM `adminfleet` WHERE id=$id";
$result=mysqli_query($conn,$sql);
if($result){
    session_start();
    $_SESSION['success']='true';
}
else{
    session_start();
    $_SESSION['error']='true';
}
header("Location: equipment.php?id=" .urldecode($id));
exit();