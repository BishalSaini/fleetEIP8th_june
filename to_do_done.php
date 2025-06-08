<?php
include "partials/_dbconnect.php";
$completed_id=$_GET['id'];
$sql="UPDATE `to_do` SET `status` = 'Closed' WHERE id=$completed_id";
$result=mysqli_query($conn,$sql);
if($result){
    session_start();
    $_SESSION['status_change']='status changed successfully';
    header("Location:rental_dashboard.php");
    exit();
}
else{
    session_start();
    $_SESSION['status_notchange']='status not changed successfully';
    header("Location:rental_dashboard.php");
    exit();

}
