<?php
$delid=$_GET['id'];
$clientid=$_GET['clientid'];
include "partials/_dbconnect.php";

$sql="DELETE FROM `rentalclients` WHERE id='$delid'";
$result=mysqli_query($conn,$sql);
if($result){
    session_start();
    $_SESSION['success']='success';
    header("Location: rentalclientdetail.php?id=" . urlencode($clientid));
}
else{
    $_SESSION['error']='success';
    header("Location: rentalclientdetail.php?id=" . urlencode($clientid));
    exit();

}
