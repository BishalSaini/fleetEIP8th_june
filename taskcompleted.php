<?php
session_start();
$companyname001=$_SESSION['companyname'];
$id=$_GET['id'];
include "partials/_dbconnect.php";

$sql="UPDATE `to_do` SET `status`='Completed' where id='$id' and companyname='$companyname001'";
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
