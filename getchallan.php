<?php
include_once 'partials/_dbconnect.php';

if (isset($_GET['companyname'])) {
    $companyname = $_GET['companyname'];

    // Use prepared statement to avoid SQL injection
    $sql = "SELECT * FROM cn WHERE companyname = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $companyname);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $json_array = array();
    while ($data = mysqli_fetch_assoc($result)) {
        $json_array[] = $data;
    }

    echo json_encode($json_array);
} else {
    echo json_encode(array('error' => 'Company name parameter missing'));
}
?>
