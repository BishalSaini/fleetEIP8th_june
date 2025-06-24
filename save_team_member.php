<?php
include 'db_connection.php'; // adjust as needed

$name = $_POST['name'];
$company_id = $_POST['company_id'];
$number = $_POST['number'];
$address = $_POST['address'];
$email = $_POST['email'];

// Check if member exists for this company
$query = "SELECT * FROM team_members WHERE name=? AND company_id=?";
$stmt = $conn->prepare($query);
$stmt->bind_param("si", $name, $company_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    // Insert new member
    $insert = "INSERT INTO team_members (name, company_id, number, address, email) VALUES (?, ?, ?, ?, ?)";
    $stmt2 = $conn->prepare($insert);
    $stmt2->bind_param("sisss", $name, $company_id, $number, $address, $email);
    $stmt2->execute();
    echo json_encode(['status' => 'inserted']);
} else {
    echo json_encode(['status' => 'exists']);
}
?>
