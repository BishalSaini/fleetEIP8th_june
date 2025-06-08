<?php
header('Content-Type: application/json');

include "partials/_dbconnect.php";

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to fetch data
$sql = "SELECT companyname FROM `login`"; // Replace 'your_table' with your actual table name
$result = $conn->query($sql);

$suggestions = [];

// Store fetched data in an array
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $suggestions[] = $row['companyname'];
    }
}

$conn->close(); // Close the connection

// Return the suggestions as a JSON response
echo json_encode($suggestions);
?>
