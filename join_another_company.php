<?php
session_start();
include "partials/_dbconnect.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ex_employee_id = intval($_POST['ex_employee_id']);
    $new_clientname = mysqli_real_escape_string($conn, $_POST['new_clientname']);
    $current_clientid = intval($_POST['current_clientid']);

    // Remove previous designation, office address, and related fields
    $update = "UPDATE rentalclients 
        SET clientname='$new_clientname', 
            status='active', 
            designation='', 
            address_type='', 
            associated_regoffice='', 
            associate_site='', 
            clientaddress=''
        WHERE id=$ex_employee_id";
    if (mysqli_query($conn, $update)) {
        $_SESSION['success'] = "Employee joined another company and previous office data cleared.";
    } else {
        $_SESSION['error'] = "Failed to update employee.";
    }

    // Redirect back to the current client detail page
    header("Location: rentalclientdetail.php?id=" . urlencode($current_clientid));
    exit();
} else {
    header("Location: rentalclientdetail.php");
    exit();
}
