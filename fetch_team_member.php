<?php
include "partials/_dbconnect.php";
session_start();
$companyname001=$_SESSION['companyname'];

if (isset($_GET['name'])) {
    $name = mysqli_real_escape_string($conn, $_GET['name']);

    // Query to fetch designation and email for the selected name
    $query = "SELECT designation, email FROM `team_members` WHERE name='$name' and (department='Management' || department='Human Resource Department') and company_name='$companyname001' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        echo json_encode($row);
    } else {
        echo json_encode(null); // If no data is found, return null
    }
}
?>
