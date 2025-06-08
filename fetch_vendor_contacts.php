<?php
include "partials/_dbconnect.php";
$vendor_id = intval($_GET['vendor_id']);
$res = [];
$sql = "SELECT DISTINCT contact_person FROM vendor_regional_office WHERE vendor_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $vendor_id);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $res[] = $row;
}
echo json_encode($res);
