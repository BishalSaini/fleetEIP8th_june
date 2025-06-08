<?php
include "partials/_dbconnect.php";
    $ac = $_GET['id'];
    echo "ID: " . $ac;

session_start();
$comapnyname001=$_SESSION['companyname'];

$sql="SELECT * FROM fleet1 WHERE companyname='$comapnyname001' and assetcode='$ac'";
$result=mysqli_query($conn , $sql);
$row=mysqli_fetch_assoc($result);
if($row){
    header("Location: generate_bill.php?equipment=" . $row['sub_type'] . "&rentalcharge=" . $row['rental_charges_wo'] ."&asset_code=". $row['assetcode']."&ot_pro_rata=". $row['ot_charges']);
    exit();
}
else{
    header("Location:generate_bill.php");
    exit();

}


