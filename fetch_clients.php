<?php
// fetch_clients.php
include "partials/_dbconnect.php";

if (isset($_GET['query'])) {
    $query = mysqli_real_escape_string($conn, $_GET['query']); // Prevent SQL injection
    $sql = "SELECT name FROM `fleeteip_clientlist` WHERE name LIKE '%$query%' ORDER BY name ASC LIMIT 5"; // Limit to 5 suggestions
    $result = mysqli_query($conn, $sql);

    $clients = [];
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $clients[] = $row['name'];
        }
    }

    echo json_encode($clients); // Return as a JSON array
}
?>
