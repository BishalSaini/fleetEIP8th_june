<!-- delete.php -->

<?php
// Include your database connection file (e.g., dbConnection.php)
require_once('partials/_dbconnect.php');


$editId = $_GET['id'];

    // Perform the database delete
    $sql = "DELETE FROM `myoperators` WHERE id = '$editId'";
    if (mysqli_query($conn, $sql)) {
        session_start();
        $_SESSION['success']='true';
    } else {
        session_start();
        $_SESSION['error_message']='true';
    }

    // Redirect back to the original page (e.g., a success page or the list of records)
    header('Location: view_operator.php');
    exit;


