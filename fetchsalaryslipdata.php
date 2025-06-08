<?php
include "partials/_dbconnect.php";
session_start();

if (isset($_GET['name']) && isset($_SESSION['companyname'])) {
    $name = mysqli_real_escape_string($conn, $_GET['name']);
    $companyname = $_SESSION['companyname'];

    $query = "SELECT * FROM employeedetails WHERE fullname='$name' 
              AND companyname='$companyname' LIMIT 1";
    
    $result = mysqli_query($conn, $query);
    echo mysqli_num_rows($result) > 0 ? json_encode(mysqli_fetch_assoc($result)) : json_encode(null);
}
?>
