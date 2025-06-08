<?php
include "partials/_dbconnect.php";
$id=$_GET['del_id'];
$sql="DELETE FROM `login` WHERE `sno`=$id";
$resultedit=mysqli_query($conn,$sql);
if($resultedit){
    session_start();
    $_SESSION['success']='true';
    header("Location: admin_enrolled.php");
    exit();
}
else{
    session_start();
    $_SESSION['error']='true';
    header("Location: admin_enrolled.php");
    exit();

}
