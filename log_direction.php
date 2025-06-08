<?php
$edit_id = $_GET['id'];
session_start();
$_SESSION['message']='done';
header("location: log_sheet.php?id=" . $edit_id);
exit(); // Ensure that subsequent code is not executed after redirection
