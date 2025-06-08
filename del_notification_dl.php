<?php
include_once 'partials/_dbconnect.php'; // Include the database connection file
$id=$_GET['notification_id'];
$sql_delete="DELETE  FROM `dl_expiry` WHERE `sno`='$id'";
$result=mysqli_query($conn, $sql_delete);
if ($result) {
    header("Location: view_operator.php"); 
    exit(); 
}