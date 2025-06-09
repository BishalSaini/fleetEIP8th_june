<?php
include "partials/_dbconnect.php";
$vendor_id = isset($_GET['vendor_id']) ? intval($_GET['vendor_id']) : 0;
$products = [];
if ($vendor_id) {
    $sql = "SELECT product_serial, product_name, product_uom, unit_price FROM vendor_products WHERE vendor_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $vendor_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
    $stmt->close();
}
header('Content-Type: application/json');
echo json_encode($products);
