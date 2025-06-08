<?php 
include_once 'partials/_dbconnect.php'; // Include the database connection file
$company=$_GET['comp_name'];
$sql_query_del="DELETE FROM `dl_expiry` where `company_name`='$company'";
$result=mysqli_query($conn , $sql_query_del);
if ($result){
    header("Location: view_operator.php");
}