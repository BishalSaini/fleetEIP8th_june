<?php
include "partials/_dbconnect.php";

$assetcode = $_GET['assetcode'] ?? '';
$companyname = $_GET['companyname'] ?? '';
$projectname = $_GET['projectname'] ?? '';
$date = $_GET['date'] ?? '';

header('Content-Type: application/json');

if ($assetcode && $companyname && $projectname && $date) {
    $sql = "SELECT start_hmr, start_km FROM logsheetnew 
            WHERE assetcode = ? AND companyname = ? AND projectname = ? AND date = ?
            ORDER BY date ASC LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $assetcode, $companyname, $projectname, $date);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        echo json_encode([
            'match_found' => true,
            'start_hmr' => $row['start_hmr'],
            'start_km' => $row['start_km']
        ]);
    } else {
        echo json_encode([
            'match_found' => false,
            'start_hmr' => "",
            'start_km' => ""
        ]);
    }
    $stmt->close();
} else {
    echo json_encode([
        'match_found' => false,
        'start_hmr' => "",
        'start_km' => ""
    ]);
}
?>
