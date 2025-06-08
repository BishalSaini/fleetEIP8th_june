<?php
include "partials/_dbconnect.php";
$id=$_GET['id'];
$sql="DELETE FROM `billing_clients` WHERE id='$id'";
$result=mysqli_query($conn , $sql);
if($result){
    header("location:view_clients.php");
}