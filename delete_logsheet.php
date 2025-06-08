<?php
$del_id = $_GET['id'];
include "partials/_dbconnect.php";

$sql_ac = "SELECT * FROM `logsheet` WHERE id='$del_id'";
$result_ac = mysqli_query($conn, $sql_ac);
$row_ac = mysqli_fetch_assoc($result_ac);
$ac_code = $row_ac['assetcode'];

$sql = "DELETE FROM `logsheet` WHERE id='$del_id'";
$result = mysqli_query($conn, $sql);
session_start();
if ($result) {
    $_SESSION['message'] = "Logsheet deleted successfully";
    header("location:log_sheet_summary.php?id=$ac_code");
} else {
    $_SESSION['errormessage'] = "Failed to delete logsheet";
    header("location: log_sheet_summary.php?id=$ac_code");
}
