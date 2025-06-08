<?php
session_start();
include "partials/_dbconnect.php";
$email=$_SESSION['email'];
$comp_name=$_GET['comp_name'];
$sql="DELETE FROM `todo_noti` WHERE assigned_to_email='$email' and companyname='$comp_name'";
$result=mysqli_query($conn,$sql);
if($result){

    header("Location: todolist.php");
    exit();
}
else{

}