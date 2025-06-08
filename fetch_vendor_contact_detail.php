<?php
include "partials/_dbconnect.php";
$vendor_id = intval($_GET['vendor_id']);
$contact_person = $_GET['contact_person'];
$sql = "SELECT contact_number, contact_email, office_address FROM vendor_regional_office WHERE vendor_id = ? AND contact_person = ? LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $vendor_id, $contact_person);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
echo json_encode($row ?: []);
