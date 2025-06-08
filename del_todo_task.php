<?php 
include_once 'partials/_dbconnect.php'; // Include the database connection file
$del_id=$_GET['id'];
$sql="DELETE FROM `to_do` where id='$del_id'";
$result=mysqli_query($conn,$sql);
if($result){
    session_start();
    $_SESSION['del_message']='del successfull';
    header("location:rental_dashboard.php");
    exit();
}
else{
    session_start();
    $_SESSION['error_del']="error";
    header("location:rental_dashboard.php");
    exit();

}
