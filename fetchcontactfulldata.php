<?php
include "partials/_dbconnect.php";
// session_start();
// $companyname001=$_SESSION['companyname'];

if (isset($_GET['name']) && isset($_GET['companyname'])) {
    $name = mysqli_real_escape_string($conn, $_GET['name']);
    $companyname = mysqli_real_escape_string($conn, $_GET['companyname']);

    // Query to fetch designation and email for the selected name
    $query = "SELECT * FROM `fleeteip_clientlist` WHERE contactperson='$name' and name='$companyname' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        echo json_encode($row);
    } else {
        echo json_encode(null); // If no data is found, return null
    }
}
?>
