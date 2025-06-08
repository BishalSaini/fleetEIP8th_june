<?php
include "partials/_dbconnect.php";
session_start();
$companyname001 = $_SESSION['companyname'];

$delid = $_GET['id'];
$projectid = $_GET['projectid'];
$sql="DELETE FROM `epcprojectcontact` WHERE id='$delid' and companyname='$companyname001'";
$result=mysqli_query($conn,$sql);
if ($result) {
    $_SESSION['success'] = 'updated';
} else {
    $_SESSION['error'] = 'update_failed';
}

header("Location: projectinsight.php?id=" . urlencode($projectid));
exit();
