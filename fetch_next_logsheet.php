<?php
header('Content-Type: application/json');
include "partials/_dbconnect.php";

$assetcode = isset($_GET['assetcode']) ? $_GET['assetcode'] : '';
$date = isset($_GET['date']) ? $_GET['date'] : '';

if (!$assetcode || !$date) {
    echo json_encode(['found' => false]);
    exit;
}

// Query for the next day's logsheet entry for this asset
$query = "SELECT start_hmr, start_km FROM logsheetnew WHERE assetcode = ? AND date = ? LIMIT 1";
$stmt = $conn->prepare($query);
$stmt->bind_param("ss", $assetcode, $date);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    echo json_encode([
        'found' => true,
        'start_hmr' => $row['start_hmr'],
        'start_km' => $row['start_km']
    ]);
} else {
    echo json_encode(['found' => false]);
}
$stmt->close();
$conn->close();
?>
