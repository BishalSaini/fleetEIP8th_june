<?php
include "partials/_dbconnect.php";

$assetcode = $_GET['assetcode'] ?? '';
$companyname = $_GET['companyname'] ?? '';
$projectname = $_GET['projectname'] ?? '';
$date = $_GET['date'] ?? '';

header('Content-Type: application/json');

if ($assetcode && $companyname && $projectname && $date) {
    $sql = "SELECT closed_hmr, closed_km, clientname, workingdays, conditions, projectname FROM logsheetnew 
            WHERE assetcode = ? AND companyname = ? AND projectname = ? AND date = ?
            ORDER BY date DESC LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $assetcode, $companyname, $projectname, $date);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        echo json_encode([
            'match_found' => true,
            'closed_hmr' => $row['closed_hmr'],
            'closed_km' => $row['closed_km'],
            "clientname" => $row['clientname'],
            "workingdays" => $row['workingdays'],
            "conditions" => $row['conditions'],
            "projectname" => $row['projectname']
        ]);
    } else {
        echo json_encode([
            'match_found' => false,
            'closed_hmr' => "",
            'closed_km' => "",
            "clientname" => "",
            "workingdays" => "",
            "conditions" => "",
            "projectname" => ""
        ]);
    }
    $stmt->close();
} else {
    echo json_encode([
        'match_found' => false,
        'closed_hmr' => "",
        'closed_km' => "",
        "clientname" => "",
        "workingdays" => "",
        "conditions" => "",
        "projectname" => ""
    ]);
}
?>
