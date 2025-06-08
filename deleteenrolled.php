<?php
include "partials/_dbconnect.php";
$id=$_GET['id'];
$sql="DELETE FROM `enrollinauction` WHERE id=$id";
$result=mysqli_query($conn,$sql);
if($result){
    session_start();
    $_SESSION['success']="true";
}
else{
    session_start();
    $_SESSION['error']='true';
}
header("Location: enrolledauction.php");