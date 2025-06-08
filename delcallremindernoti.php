<?php 
include "partials/_dbconnect.php";
session_start();
$email=$_SESSION['email'];
$companyname001=$_SESSION['companyname'];
$currentDate = date('Y-m-d'); // Get the current date in 'Y-m-d' format
$sql="DELETE FROM call_reminders where companyname='$companyname001' and added_by='$email' and reminderon='$currentDate'";
$result=mysqli_query($conn,$sql);
if($result){
    header("Location:rental_dashboard.php");
    exit();
}
else{
    header("Location:rental_dashboard.php");
    exit();
 
}