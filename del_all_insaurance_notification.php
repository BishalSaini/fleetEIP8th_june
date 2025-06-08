<?php 
include_once 'partials/_dbconnect.php'; // Include the database connection file
$company=$_GET['comp_name'];
$sql_query_del="DELETE FROM `insaurance_notification` where `company_name`='$company'";
$result=mysqli_query($conn , $sql_query_del);
if ($result){
    header("Location: viewfleet2.php");
}