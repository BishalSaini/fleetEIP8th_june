<?php
include_once 'partials/_dbconnect.php'; // Include the database connection file
$del_id = $_GET["id"];
$sql_del = "DELETE FROM `logistics_need` WHERE id='$del_id'";
$result = mysqli_query($conn, $sql_del);
if ($result) {
    header("location:my_logi_req.php");
}
?>