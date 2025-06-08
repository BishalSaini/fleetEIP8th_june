<?php
session_start();
$companyname001=$_SESSION['companyname'];

if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['regionalsubmit'])){
    include "partials/_dbconnect.php";
    $regname=$_POST['regname'];
    $regdestination=$_POST['regdestination'];
    $regcontact=$_POST['regcontact'];
    $regemail=$_POST['regemail'];
    // $regaddress=$_POST['regaddress'];
    $clientname=$_POST['clientname'];
    $clientidhq=$_POST['clientidhq'];
    $associatedregoffice=$_POST['associatedregoffice'];

    $clientdetail="SELECT * FROM `regional_office` where companyname='$companyname001' and clientid='$clientidhq'";
    $resultdetail=mysqli_query($conn,$clientdetail);
    $row=mysqli_fetch_assoc($resultdetail);
    $clientaddress=$row['address'];
    $handled_by=$_POST['handled_by'];


    $hq = "INSERT INTO `rentalclients` (
        `companyname`, `clientname`,`handled_by`,
        `address_type`, `contact_person`, `designation`,
        `contact_number`, `contact_email`, `associated_regoffice`, `clientaddress`, `clientid`
    ) VALUES (
        '$companyname001', '$clientname','$handled_by',
        'Regional Office', '$regname', '$regdestination', '$regcontact', '$regemail', '$associatedregoffice', '$clientaddress','$clientidhq'
    )";

    $hqresult = mysqli_query($conn, $hq);
    if ($hqresult) {
        session_start();
        $_SESSION['success']='success';
        header("Location: rentalclientdetail.php?id=" . urlencode($clientidhq));
        
        exit();
    } else {
        $_SESSION['error']='success';
        header("Location: rentalclientdetail.php?id=" . urlencode($clientidhq));
        
    }


}