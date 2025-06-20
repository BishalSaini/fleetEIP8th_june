<?php
include_once 'partials/_dbconnect.php';
session_start();
$companyname001 = $_SESSION['companyname'] ?? '';
if (isset($_POST['vendor_name'])) {
    $vendor_name = $_POST['vendor_name'];
    $stmt = $conn->prepare("SELECT id FROM vendors WHERE companyname = ? AND vendor_name = ? LIMIT 1");
    $stmt->bind_param("ss", $companyname001, $vendor_name);
    $stmt->execute();
    $stmt->bind_result($vendor_id);
    $stmt->fetch();
    $stmt->close();
    echo json_encode(['vendor_id' => $vendor_id]);
}
?>
