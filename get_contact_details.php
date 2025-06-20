<?php
include_once 'partials/_dbconnect.php';
if (isset($_POST['contact_id'])) {
    $contact_id = $_POST['contact_id'];
    $stmt = $conn->prepare("SELECT contact_email, contact_number, office_address FROM vendor_regional_office WHERE id = ?");
    $stmt->bind_param("i", $contact_id);
    $stmt->execute();
    $stmt->bind_result($contact_email, $contact_number, $office_address);
    $stmt->fetch();
    $stmt->close();
    echo json_encode([
        'email' => $contact_email,
        'contact_number' => $contact_number,
        'office_address' => $office_address
    ]);
}
?>
