<?php 
include "partials/_dbconnect.php";
$enrollmentId = $_GET['id'];

// First, get the auction ID related to this enrollment
$sql = "SELECT auctionid FROM `enrollinauction` WHERE id=$enrollmentId";
$result = mysqli_query($conn, $sql);
$auctionId = mysqli_fetch_assoc($result)['auctionid']; // Fetch the auction ID

// Update the enrollment status to 'Approved'
$sql = "UPDATE `enrollinauction` SET `status`='Approved' WHERE id=$enrollmentId";
$result = mysqli_query($conn, $sql);

session_start();
if ($result) {
    $_SESSION['success'] = 'true';
} else {
    $_SESSION['error'] = 'true';
}

// Redirect to the auction page using the auction ID
header("Location: viewauction.php?id=" . urldecode($auctionId));
exit();
