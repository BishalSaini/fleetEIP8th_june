<?php 
session_start();
include "partials/_dbconnect.php";
$companyname001=$_SESSION['companyname'];
$id=$_GET['notification_id'];
$sql="DELETE FROM `todo_noti` WHERE id='$id' and companyname='$companyname001'";
$result=mysqli_query($conn,$sql);
if($result){
    $_SESSION['success']="true";
    header("Location: todolist.php");
    exit();
}
else{
    $_SESSION['error']="true";
    header("Location: todolist.php");
    exit();

}
