<?php
include "partials/_dbconnect.php";
$id=$_GET['id'];
$ac=$_GET['asset_code'];
$sql="DELETE FROM `brkdown_log` where id='$id'";
$result=mysqli_query($conn,$sql);
if($result){
    session_start();
    $_SESSION["log_del"]="deleted";
    header("Location:log_sheet_summary.php?id=$ac");
}