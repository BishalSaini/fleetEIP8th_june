<?php
include "partials/_dbconnect.php";
session_start();
$companyname001=$_SESSION['companyname'];
$id=$_GET['id'];
$sql="DELETE FROM req_by_epc WHERE id='$id' and posted_by='$companyname001'";
$result=mysqli_query($conn,$sql);
if($result){
    $_SESSION['success']='done';
}
else{
    $_SESSION['error']='done';
}
header('Location: requirementlisting.php');
exit();