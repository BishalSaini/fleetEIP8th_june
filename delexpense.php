<?php
include "partials/_dbconnect.php";

$id = $_GET['id'];
$asset_id = $_GET['asset_id'];

$sql = "DELETE FROM `expense` WHERE id='$id'";
$result = mysqli_query($conn, $sql);

session_start();

if ($result) {
    $_SESSION['success'] = 'success';
} else {
    $_SESSION['error'] = 'error';
}

header("Location: viewexpense.php?id=" . urlencode($asset_id));
exit(); 
?>
