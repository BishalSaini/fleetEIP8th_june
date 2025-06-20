<?php
include_once 'partials/_dbconnect.php';

header('Content-Type: application/json');

$search = trim($_POST['search'] ?? '');
$vendor_id = intval($_POST['vendor_id'] ?? 0);
$type = $_POST['type'] ?? '';

if (!$search || !$vendor_id || !in_array($type, ['serial', 'name'])) {
    echo json_encode([]);
    exit;
}

$field = $type === 'serial' ? 'product_serial' : 'product_name';

$stmt = $conn->prepare(
    "SELECT product_serial, product_name, product_uom, unit_price, qty 
     FROM vendor_products 
     WHERE vendor_id = ? AND $field LIKE CONCAT('%', ?, '%') 
     ORDER BY product_serial ASC LIMIT 10"
);
$stmt->bind_param("is", $vendor_id, $search);
$stmt->execute();
$result = $stmt->get_result();

$products = [];
while ($row = $result->fetch_assoc()) {
    $products[] = [
        'product_serial' => $row['product_serial'],
        'product_name'   => $row['product_name'],
        'product_uom'    => $row['product_uom'],
        'unit_price'     => $row['unit_price'],
        'qty'            => $row['qty']
    ];
}
$stmt->close();

echo json_encode($products);
