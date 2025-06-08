<?php
include "partials/_dbconnect.php";
$id=$_GET['id'];
$sql = "DELETE FROM `auctiondetail` WHERE id='$id'";
$result = mysqli_query($conn, $sql);

session_start();

if ($result) {
    $_SESSION['success'] = 'success';
} else {
    $_SESSION['error'] = 'error';
}

header("Location: auction.php");
exit(); 
?>
