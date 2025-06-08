<?php
include "partials/_dbconnect.php";
if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM `todo_noti` WHERE assinged_to='$id'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        header("Location: rental_dashboard.php");
        exit(); // Ensure no further output is sent
    }}