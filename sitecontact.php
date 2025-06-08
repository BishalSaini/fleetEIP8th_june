<?php
session_start();
$companyname001=$_SESSION['companyname'];

if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['sitesubmit'])){
    include "partials/_dbconnect.php";
    $sitename=$_POST['sitename'];
    $sitedestination=$_POST['sitedestination'];
    $sitecontact=$_POST['sitecontact'];
    $siteemail=$_POST['siteemail'];
    // $siteaddress=$_POST['siteaddress'];
    $clientname=$_POST['clientname'];
    $clientidhq=$_POST['clientidhq'];
    $associated_site=$_POST['associated_site'];

    $clientdetail="SELECT * FROM `site_office` where companyname='$companyname001' and clientid='$clientidhq'";
    $resultdetail=mysqli_query($conn,$clientdetail);
    $row=mysqli_fetch_assoc($resultdetail);
    $clientaddress=$row['address'];


    $hq = "INSERT INTO `rentalclients` (
        `companyname`, `clientname`,
        `address_type`, `contact_person`, `designation`,
        `contact_number`, `contact_email`, `associate_site`, `clientaddress`,`clientid`
    ) VALUES (
        '$companyname001', '$clientname',
        'Site Office', '$sitename', '$sitedestination', '$sitecontact', '$siteemail', '$associated_site', '$clientaddress','$clientidhq'
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