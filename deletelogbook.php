<?php
$assetcode=$_GET['assetcode'];
$woref=$_GET['woref'];
$clientname=$_GET['clientname'];
include ("partials/_dbconnect.php");
session_start();
$comapnyname001=$_SESSION['companyname'];
$sql="DELETE FROM logsheetnew WHERE assetcode='$assetcode' AND worefno='$woref' and clientname='$clientname'";
$result=mysqli_query($conn,$sql);
if($result){
    $_SESSION['success']='true';
}
else{
    $_SESSION['error']= 'true';
}
header('Location: logsheetdashboard.php');
exit();