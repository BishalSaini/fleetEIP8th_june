<?php
include "partials/_dbconnect.php";
$vendor_id = intval($_GET['vendor_id']);
$res = [];
$sql = "SELECT product_serial, product_name FROM vendor_products WHERE vendor_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $vendor_id);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $res[] = $row;
}
echo json_encode($res);
