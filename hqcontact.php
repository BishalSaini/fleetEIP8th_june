<?php
session_start();
$companyname001 = $_SESSION['companyname'];

if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['hqsubmit'])){
    include "partials/_dbconnect.php";
    $hqname=$_POST['hqname'];
    $hqdesignation=$_POST['hqdesignation'];
    $hqcontact=$_POST['hqcontact'];
    $hqemail=$_POST['hqemail'];
    $hqaddress=$_POST['hqaddress'];
    $clientidhq=$_POST['clientidhq'];
    $clientname=$_POST['clientname'];

    $hq = "INSERT INTO `rentalclients` (
        `companyname`, `clientname`, `clientaddress`,
        `address_type`, `contact_person`, `designation`,
        `contact_number`, `contact_email`, `clientid`
    ) VALUES (
        '$companyname001', '$clientname', '$hqaddress',
        'HQ', '$hqname', '$hqdesignation', '$hqcontact', '$hqemail', '$clientidhq'
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
?>