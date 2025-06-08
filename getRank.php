<?php
// Include your database connection file here
include 'partials/_dbconnect.php';

$companyname001 = $_GET['companyname']; // Ensure to sanitize and validate this input
$auctionid = $_GET['auctionid']; // Ensure to sanitize and validate this input

// Fetch the current rank from the database
$currentrankQuery = "SELECT rank FROM `bids` WHERE companyname='$companyname001' AND auctionid=$auctionid ORDER BY id DESC LIMIT 1";
$result = mysqli_query($conn, $currentrankQuery);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    echo json_encode(['rank' => $row['rank']]);
} else {
    echo json_encode(['rank' => 'N/A']);
}
?>