<?php
include "partials/_dbconnect.php";
session_start();

if (isset($_GET['assetnumber']) && isset($_SESSION['companyname'])) {
    $assetnumber = mysqli_real_escape_string($conn, $_GET['assetnumber']);
    $companyname = $_SESSION['companyname'];

    $query = "SELECT * FROM fleet1 WHERE assetcode='$assetnumber' 
              AND companyname='$companyname' LIMIT 1";
    
    $result = mysqli_query($conn, $query);
    echo mysqli_num_rows($result) > 0 ? json_encode(mysqli_fetch_assoc($result)) : json_encode(null);
}

