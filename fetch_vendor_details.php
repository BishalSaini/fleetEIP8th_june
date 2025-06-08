<?php
include_once 'partials/_dbconnect.php';
$vendor_id = isset($_GET['vendor_id']) ? intval($_GET['vendor_id']) : 0;
$response = [
    'office_address' => '',
    'contact_person' => '',
    'contact_number' => '',
    'contact_email' => '',
    'regional_offices' => []
];
if ($vendor_id > 0) {
    // Get vendor main address
    $sql = "SELECT * FROM vendors WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $vendor_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $response['office_address'] = $row['office_address'];
        // Optionally, if you have HQ contact fields in vendors table, fill them here
        $response['contact_person'] = $row['contact_person'] ?? '';
        $response['contact_number'] = $row['contact_number'] ?? '';
        $response['contact_email'] = $row['contact_email'] ?? '';
    }
    $stmt->close();

    // Get regional offices
    $sql2 = "SELECT id, office_address, state FROM vendor_regional_office WHERE vendor_id = ?";
    $stmt2 = $conn->prepare($sql2);
    $stmt2->bind_param("i", $vendor_id);
    $stmt2->execute();
    $result2 = $stmt2->get_result();
    while ($row2 = $result2->fetch_assoc()) {
        $response['regional_offices'][] = $row2;
    }
    $stmt2->close();
}
header('Content-Type: application/json');
echo json_encode($response);
