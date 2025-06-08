<?php
include "partials/_dbconnect.php";
$id=$_GET['id'];
$sql="DELETE FROM `bill_generated` WHERE id='$id'";
$result=mysqli_query($conn , $sql);
if($result){
    header("location:view_print_bills.php");
}