<?php
include_once 'partials/_dbconnect.php';
session_start();
$companyname001 = $_SESSION['companyname'] ?? '';
if (isset($_POST['search'])) {
    $search = $_POST['search'];
    $stmt = $conn->prepare("SELECT vendor_name FROM vendors WHERE companyname = ? AND vendor_name LIKE ? ORDER BY vendor_name ASC LIMIT 10");
    $like = "%$search%";
    $stmt->bind_param("ss", $companyname001, $like);
    $stmt->execute();
    $result = $stmt->get_result();
    $out = '';
    while ($row = $result->fetch_assoc()) {
        $out .= '<li>' . htmlspecialchars($row['vendor_name']) . '</li>';
    }
    echo $out;
}
?>
