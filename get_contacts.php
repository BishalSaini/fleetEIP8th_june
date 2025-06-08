<?php
// Display errors for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Database connection
include "partials/_dbconnect.php";

// Check connection
if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

if (isset($_GET['companyName']) && isset($_GET['selfName'])) {
    $companyName = $conn->real_escape_string($_GET['companyName']);
    $selfName = $conn->real_escape_string($_GET['selfName']);

    $sql = "SELECT id, contact_person AS name, handled_by, working_days, engine_hours FROM rentalclients WHERE clientname = '$companyName' AND companyname = '$selfName' AND contact_person !='' AND status !='left'";
    $result = $conn->query($sql);

    if (!$result) {
        die(json_encode(["error" => "Error executing query: " . $conn->error]));
    }

    $contacts = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $contacts[] = $row;
        }
    }

    echo json_encode($contacts);
} else {
    echo json_encode(["error" => "Missing parameters"]);
}

$conn->close();
?>