<?php
include_once 'partials/_dbconnect.php';
session_start();

$po_id = isset($_GET['po_id']) ? intval($_GET['po_id']) : 0;
$product_serial = isset($_GET['product_serial']) ? $_GET['product_serial'] : '';

if ($po_id > 0 && $product_serial !== '') {
    $stmt = $conn->prepare("DELETE FROM purchase_order_products WHERE po_id = ? AND product_serial = ?");
    $stmt->bind_param("is", $po_id, $product_serial);
    $stmt->execute();
    $stmt->close();
}

header('Location: vendorPOView.php');
exit();
