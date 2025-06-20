<?php
include_once 'partials/_dbconnect.php';
if (isset($_POST['vendor_id'])) {
    $vendor_id = $_POST['vendor_id'];
    $stmt = $conn->prepare("SELECT id, contact_person FROM vendor_regional_office WHERE vendor_id = ?");
    $stmt->bind_param("i", $vendor_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $contacts = [];
    while ($row = $result->fetch_assoc()) {
        $contacts[] = ['id' => $row['id'], 'contact_person' => $row['contact_person']];
    }
    echo json_encode($contacts);
}
?>
