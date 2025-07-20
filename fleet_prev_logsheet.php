<?php
include "partials/_dbconnect.php";
session_start();

$assetcode = $_GET['assetcode'] ?? '';
$equipmenttype = $_GET['equipmenttype'] ?? '';
$equipmentmake = $_GET['equipmentmake'] ?? '';
$equipmentmodel = $_GET['equipmentmodel'] ?? '';
$companyname = $_SESSION['companyname'] ?? '';

header('Content-Type: application/json');

// Find most recent previous logsheet for same asset/type/make/model/company
$sql = "SELECT closed_hmr, closed_km, clientname, workingdays, conditions, projectname
    FROM logsheetnew
    WHERE assetcode = ?
      AND equipmenttype = ?
      AND make = ?
      AND model = ?
      AND companyname = ?
    ORDER BY date DESC LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssss", $assetcode, $equipmenttype, $equipmentmake, $equipmentmodel, $companyname);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode([
        "match_found" => true,
        "closed_hmr" => $row['closed_hmr'],
        "closed_km" => $row['closed_km'],
        "clientname" => $row['clientname'],
        "workingdays" => $row['workingdays'],
        "conditions" => $row['conditions'],
        "projectname" => $row['projectname']
    ]);
    exit;
}

echo json_encode([
    "match_found" => false,
    "closed_hmr" => "",
    "closed_km" => "",
    "clientname" => "",
    "workingdays" => "",
    "conditions" => "",
    "projectname" => ""
]);
?>
