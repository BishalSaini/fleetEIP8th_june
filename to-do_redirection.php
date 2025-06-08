<?php
    session_start();
    $_SESSION['message'] = 'success';
    header("Location: rental_dashboard.php");
    exit(); // Ensure no further code execution
?>
