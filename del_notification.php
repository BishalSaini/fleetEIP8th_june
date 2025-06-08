<?php
include_once 'partials/_dbconnect.php'; // Include the database connection file
$id=$_GET['notification_id'];
$sql_delete="DELETE  FROM `insaurance_notification` WHERE `sno`='$id'";
$result=mysqli_query($conn, $sql_delete);
if ($result) {
    header("Location: viewfleet2.php"); 
    exit(); 
}