<?php
session_start();

// Include database connection
include "partials/_dbconnect.php";

// Check database connection
if ($conn->connect_error) {
    die(json_encode(["error" => "Database connection failed: " . $conn->connect_error]));
}

// Check if company name is set in session
if (!isset($_SESSION['companyname'])) {
    die(json_encode(["error" => "Company name not found in session. Please log in again."]));
}
$companyname001 = $_SESSION['companyname'];

// Check if fleet_category is provided in the request
if (!isset($_GET['fleet_category'])) {
    die(json_encode(["error" => "Fleet category not provided."]));
}
$fleetCategory = $_GET['fleet_category'];

// Sanitize the input to prevent SQL injection
$fleetCategory = mysqli_real_escape_string($conn, $fleetCategory);

// Fetch asset codes based on the selected category
$query = "SELECT * FROM fleet1 WHERE companyname = ? AND category = ? ORDER BY assetcode ASC";
$stmt = $conn->prepare($query);

if (!$stmt) {
    die(json_encode(["error" => "Failed to prepare SQL statement: " . $conn->error]));
}

// Bind parameters and execute the query
$stmt->bind_param("ss", $companyname001, $fleetCategory);
if (!$stmt->execute()) {
    die(json_encode(["error" => "Failed to execute SQL statement: " . $stmt->error]));
}

// Fetch the result
$result = $stmt->get_result();
$assetCodes = [];

while ($row = $result->fetch_assoc()) {
    $assetCodes[] = $row;
}

// Return the asset codes as JSON
header('Content-Type: application/json');
echo json_encode($assetCodes);

// Close the statement and connection
$stmt->close();
$conn->close();
?>