<?php
include "partials/_dbconnect.php";
$vendor_id = intval($_GET['vendor_id']);
$product_serial = $_GET['product_serial'];
$sql = "SELECT * FROM vendor_products WHERE vendor_id = ? AND product_serial = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $vendor_id, $product_serial);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
echo json_encode($row ?: []);
