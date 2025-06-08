<?php
// Connect to your database (replace with your actual database credentials)
include 'partials/_dbconnect.php';


// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to get the count of companies with status 'Working' and 'Idle'
$sql = "SELECT status, COUNT(*) as count FROM `fleet1` GROUP BY status ";

$result = $conn->query($sql);

$data = array();
while($row = $result->fetch_assoc()) {
    $data[] = array("label" => $row['status'], "y" => $row['count']);
}

// Close the connection
$conn->close();

// Return the data as JSON
header('Content-Type: application/json');
echo json_encode($data);
?>