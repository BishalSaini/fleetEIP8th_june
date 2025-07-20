<?php
include "partials/_dbconnect.php";
session_start();

// Get parameters
$assetcode = $_GET['assetcode'] ?? '';
$equipmenttype = $_GET['equipmenttype'] ?? '';
$equipmentmake = $_GET['equipmentmake'] ?? '';
$equipmentmodel = $_GET['equipmentmodel'] ?? '';
$companyname = $_SESSION['companyname'] ?? '';

header('Content-Type: application/json');

// Find latest record for same assetcode, equipmenttype, make, model (ignore date)
$match_sql = "SELECT client_name, workorder_ref, working_days_in_month, condition_sundays, project_name, sub_type, make, model, rental_charges_wo, shift_wo, ot_charges, project_location, hour_shift
    FROM fleet1 
    WHERE assetcode = ? 
      AND sub_type = ? 
      AND make = ? 
      AND model = ? " . ($companyname ? "AND companyname = ?" : "") . "
    LIMIT 1";
if ($companyname) {
    $stmt = $conn->prepare($match_sql);
    $stmt->bind_param("sssss", $assetcode, $equipmenttype, $equipmentmake, $equipmentmodel, $companyname);
} else {
    $stmt = $conn->prepare($match_sql);
    $stmt->bind_param("ssss", $assetcode, $equipmenttype, $equipmentmake, $equipmentmodel);
}
$stmt->execute();
$match_result = $stmt->get_result();

if ($match_result && $match_result->num_rows > 0) {
    $row = $match_result->fetch_assoc();
    echo json_encode([
        "match_found" => true,
        "clientname" => $row['client_name'],
        "worefno" => $row['workorder_ref'],
        "workingdays" => $row['working_days_in_month'],
        "conditions" => $row['condition_sundays'],
        "projectname" => $row['project_name'],
        "equipmenttype" => $row['sub_type'],
        "equipmentmake" => $row['make'],
        "equipmentmodel" => $row['model'],
        "rentalcharges" => $row['rental_charges_wo'],
        "shiftwo" => $row['shift_wo'],
        "otcharges" => $row['ot_charges'],
        "projectlocation" => $row['project_location'],
        "hourshift" => $row['hour_shift']
    ]);
    exit;
}

// No data found
echo json_encode([
    "match_found" => false,
    "clientname" => "",
    "worefno" => "",
    "workingdays" => "",
    "conditions" => "",
    "projectname" => "",
    "equipmenttype" => "",
    "equipmentmake" => "",
    "equipmentmodel" => "",
    "rentalcharges" => "",
    "shiftwo" => "",
    "otcharges" => "",
    "projectlocation" => "",
    "hourshift" => ""
]);
/* "closed_km" => "",
"night_closed_hmr" => "",
"night_closed_km" => ""
]);  */

?>
