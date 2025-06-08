<?php
include_once 'partials/_dbconnect.php'; 
session_start();
$companyname001=$_SESSION['companyname'];
$id=$_GET['del_id'];
$sql1="SELECT * FROM `quotation_generated` where sno='$id'";
$result1=mysqli_query($conn,$sql1);
$row1=mysqli_fetch_assoc($result1);

$sql="DELETE FROM `quotation_generated` WHERE `sno`='$id'";
$result=mysqli_query($conn , $sql);


$seconduniqueid=$row1['uniqueid'];
$sql1="DELETE FROM `second_vehicle_quotation` WHERE uniqueid='$seconduniqueid'";
$result1=mysqli_query($conn,$sql1);

$sql3="DELETE FROM `thirdvehicle_quotation` WHERE uniqueid='$seconduniqueid'";
$result3=mysqli_query($conn,$sql3);

$sql4="DELETE FROM `fourthvehicle_quotation` WHERE uniqueid='$seconduniqueid'";
$result4=mysqli_query($conn,$sql4);

$sql5="DELETE FROM `fifthvehicle_quotation` WHERE uniqueid='$seconduniqueid'";
$result5=mysqli_query($conn,$sql5);

$sql6="DELETE FROM `quotation_status` WHERE unique_id='$seconduniqueid'";
$result6=mysqli_query($conn,$sql6);


if($result){
    $_SESSION['success']='success';
    header("location:generate_quotation_landingpage.php");
}
else{
    $_SESSION['failed']='success';
    header("location:generate_quotation_landingpage.php");

}