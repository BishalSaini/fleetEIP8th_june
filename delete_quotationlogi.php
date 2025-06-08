<?php
include "partials/_dbconnect.php";
$id=$_GET['del_id'];
$sql="DELETE FROM `logistic_quotation_generated` WHERE id='$id'";
$result=mysqli_query($conn,$sql);
if($result){
    session_start();
    $_SESSION['success']='success';
    header("Location:logisticsquotation.php");
    exit();
}