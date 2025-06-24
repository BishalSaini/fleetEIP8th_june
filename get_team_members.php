<?php
include 'db_connection.php'; // adjust as needed

$company_id = $_GET['company_id'];
$query = "SELECT id, name, email FROM team_members WHERE company_id=?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $company_id);
$stmt->execute();
$result = $stmt->get_result();

$members = [];
while ($row = $result->fetch_assoc()) {
    $members[] = $row;
}
echo json_encode($members);
?>
