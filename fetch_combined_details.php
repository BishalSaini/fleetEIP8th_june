<?php
include "partials/_dbconnect.php";
session_start();

if (isset($_GET['date']) && isset($_SESSION['companyname']) && isset($_GET['assetcode'])) {
    $assetcode = mysqli_real_escape_string($conn, $_GET['assetcode']);
    $date = mysqli_real_escape_string($conn, $_GET['date']);
    $woref = mysqli_real_escape_string($conn, $_GET['woref']);
    $companyname = $_SESSION['companyname'];

    $query = "SELECT * 
    FROM logsheetnew 
    WHERE assetcode = '$assetcode' 
    AND worefno = '$woref' 
    AND companyname = '$companyname' 
    AND date = DATE_SUB('$date', INTERVAL 1 DAY) 
    LIMIT 1";

$result = mysqli_query($conn, $query);
    echo mysqli_num_rows($result) > 0 ? json_encode(mysqli_fetch_assoc($result)) : json_encode(null);
}
else{
    echo 'data not being passed';
}
