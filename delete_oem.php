<!-- delete.php -->

<?php
// Include your database connection file (e.g., dbConnection.php)
require_once('partials/_dbconnect.php');


$editId = $_GET['id'];

    // Perform the database delete
    $sql = "DELETE FROM oem_fleet WHERE sno = '$editId'";
    if (mysqli_query($conn, $sql)) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . mysqli_error($mysqli);
    }

    // Redirect back to the original page (e.g., a success page or the list of records)
    header('Location: viewfleet.php');
    exit;


