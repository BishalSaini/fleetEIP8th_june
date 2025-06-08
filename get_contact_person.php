<?php
include 'partials/_dbconnect.php';

if (isset($_GET['company_name'])) {
    $companyName = $_GET['company_name'];
    $contactQuery = "SELECT contactperson FROM `fleeteip_clientlist` WHERE name = ?";
    $stmt = $conn->prepare($contactQuery);
    $stmt->bind_param("s", $companyName); // Bind the company name to the query
    $stmt->execute();
    $result = $stmt->get_result();

    $contactPersons = [];
    while ($row = $result->fetch_assoc()) {
        $contactPersons[] = $row;
    }

    // Return the result as JSON
    echo json_encode($contactPersons);
}
?>
