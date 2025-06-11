<?php
session_start();
$companyname001=$_SESSION['companyname'];

if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['clientsubmit'])){
    include "partials/_dbconnect.php";
    $clientname=$_POST['clientname'];
    $clientid=$_POST['clientid'];
    $heading=$_POST['heading'];
    $siteaddress=$_POST['siteaddress'];
    $sitestate=$_POST['sitestate'];
    $heading=$_POST['heading'];
    $kam = $_POST['handled_by'];

    $sql="INSERT INTO `site_office`( `companyname`, `clientid`,
     `clientname`, `address`, `heading`, `state`,`KAM`) 
     VALUES ('$companyname001','$clientid','$clientname',
     '$siteaddress','$heading','$sitestate','$kam')";
     $result=mysqli_query($conn,$sql);
     if($result){
        session_start();
        $_SESSION['success']='success';
        header("Location: rentalclientdetail.php?id=" . urlencode($clientid));
        exit;
    
    }
    else{
        $_SESSION['error']='success';
        header("Location: rentalclientdetail.php?id=" . urlencode($clientid));

    }
}