<?php
session_start();
$companyname001=$_SESSION['companyname'];
if($_SERVER['REQUEST_METHOD']==='POST'){
    include "partials/_dbconnect.php";
    $clientname=$_POST['clientname'];
    $heading=$_POST['heading'];
    $regionaloffice_address=$_POST['regionaloffice_address'];
    $regional_office_state=$_POST['regional_office_state'];
    $clientid=$_POST['clientid'];
    $handled_by=$_POST['handled_by'];

    $sql="INSERT INTO `regional_office`(`kam`,`clientid`,`companyname`, `clientname`, `heading`, 
    `address`, `state`) VALUES ('$handled_by','$clientid','$companyname001','$clientname','$heading','$regionaloffice_address','$regional_office_state')";
    $result=mysqli_query($conn,$sql);
    if($result){
        session_start();
        $_SESSION['success']='success';
        header("Location: rentalclientdetail.php?id=" . urlencode($clientid));
        exit();
    
    }
}