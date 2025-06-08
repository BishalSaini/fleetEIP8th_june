<?php
// Include your database connection file (e.g., dbConnection.php)
require_once('partials/_dbconnect.php');

if(isset($_GET['id'])) {
    $delId = $_GET['id'];

    // Perform the database delete
    $sql = "DELETE FROM images WHERE id = '$delId'";
    if (mysqli_query($conn, $sql)) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
} else {
    echo "Invalid id provided for deletion";
}

// Redirect back to the original page (e.g., a success page or the list of records)
// You can uncomment the header() function if you want to redirect
header('Location: view_listing.php');
exit;
?>