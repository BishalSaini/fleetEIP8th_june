<?php
include_once 'partials/_dbconnect.php'; // Ensure this file is correctly included

if (isset($_GET['name'])) {
    $name = $_GET['name'];

    // Use prepared statement to avoid SQL injection
    $sql = "SELECT * FROM fleeteip_clientlist WHERE name = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $name);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        echo json_encode(array(
            'hq' => $row['hq'],
            'website' => $row['website'],
            'type' => $row['type'],
            'state' => $row['state'],
            'gst' => $row['gst']
        ));
    } else {
        echo json_encode(array('error' => 'Client not found'));
    }
} else {
    echo json_encode(array('error' => 'Name parameter missing'));
}
?>