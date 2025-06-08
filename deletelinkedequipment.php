<?php
include "partials/_dbconnect.php";
session_start();

$email = $_SESSION['email'];
$enterprise = $_SESSION['enterprise'];
$id = $_GET['id'];
$projectid = $_GET['projectid'];

// Sanitize input
$id = mysqli_real_escape_string($conn, $id);
$companyname001 = mysqli_real_escape_string($conn, $_SESSION['companyname']); // Assuming this is set in session

// Delete query
$sql = "DELETE FROM `linked_equipment` WHERE id='$id' AND companyname='$companyname001'";
$result = mysqli_query($conn, $sql);

if ($result) {
    $_SESSION['success'] = 'true';
} else {
    $_SESSION['error'] = 'true';
}

// Correct header redirection without space
header("Location: projectinsight.php?id=" . urlencode($projectid));
exit();
