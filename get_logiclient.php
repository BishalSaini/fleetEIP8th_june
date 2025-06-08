<?php
include_once 'partials/_dbconnect.php';

if (isset($_GET['companyname'])) {
    $companyname = $_GET['companyname'];

    // Directly include the variable in the query
    $sql = "SELECT * FROM clients_logi WHERE companyname = '$companyname'";
    $result = mysqli_query($conn, $sql);

    $json_array = array();
    while ($data = mysqli_fetch_assoc($result)) {
        $json_array[] = $data;
    }

    echo json_encode($json_array);
} else {
    echo json_encode(array('error' => 'Company name parameter missing'));
}
?>
