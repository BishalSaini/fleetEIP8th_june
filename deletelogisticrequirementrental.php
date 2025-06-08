<?php
include "partials/_dbconnect.php";
session_start();
$companyname001=$_SESSION['companyname'];
$delid=$_GET['id'];
$sql="DELETE FROM `logistics_need` WHERE id='$delid' and companyname_need_generator='$companyname001'";
$result=mysqli_query($conn,$sql);
if($result){
    session_start();
    $_SESSION['success']='true';

}
else{
    session_start();
    $_SESSION['error']='true';

}
header("Location: recieved_quotation_logistics.php");
exit();