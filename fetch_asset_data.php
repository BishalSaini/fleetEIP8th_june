<?php
// Include database connection file
include "partials/_dbconnect.php";

// Check if the assetcode is received via POST
if (isset($_POST['assetcode'])) {
    $assetcode = $_POST['assetcode'];

    // Prepare and execute query to fetch other information based on assetcode
    $stmt = $conn->prepare("SELECT capacity, yom FROM fleet1 WHERE assetcode = :assetcode");
    $stmt->bindParam(':assetcode', $assetcode);
    $stmt->execute();

    // Fetch the data
    if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $response = array(
            'success' => true,
            'capacity' => $row['capacity'],
            'yom' => $row['yom']
            // Add more fields as needed
        );
    } else {
        $response = array(
            'success' => false,
            'message' => 'Asset data not found'
        );
    }
} else {
    $response = array(
        'success' => false,
        'message' => 'Asset code not provided'
    );
}

// Return the response as JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
