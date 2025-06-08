<?php
include("partials/_dbconnect.php");
session_start();
$comapnyname001=$_SESSION['companyname'];
$id=$_GET['id'];
$assetcode=$_GET['assetcode'];
$worefno=$_GET['worefno'];

$sql="DELETE FROM logsheetnew where id=$id and companyname='$comapnyname001'";
$result=mysqli_query($conn,$sql);
if($result){
    $_SESSION['success']='true';
}
else{
    $_SESSION['error']='true';
}
header("Location: logsheetsummary.php?assetcode=" . urlencode($assetcode) . "&worefno=" . urlencode($worefno));
exit;
