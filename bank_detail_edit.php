<?php
include "partials/_dbconnect.php";

session_start();
$email = $_SESSION['email'];
$companyname001 = $_SESSION['companyname'];
$enterprise=$_SESSION['enterprise'];
$dashboard_url = '';
if ($enterprise === 'rental') {
    $dashboard_url = 'rental_dashboard.php';
} elseif ($enterprise === 'logistics') {
    $dashboard_url = 'logisticsdashboard.php';
} 
elseif ($enterprise === 'epc') {
    $dashboard_url = 'epc_dashboard.php';
} 
else {
    $dashboard_url = '';
}
$showAlert = false;
$showError = false;

$sql_bank_fetch = "SELECT * FROM `complete_profile` where companyname='$companyname001'";
$sql_result_fetch = mysqli_query($conn, $sql_bank_fetch);
$row_fetch = mysqli_fetch_assoc($sql_result_fetch);

if ($_SERVER['REQUEST_METHOD'] === 'POST' ) {
    include "partials/_dbconnect.php";

    // Check if the 'logo' file input is empty
    if (empty($_FILES['logo']['name'])) {
        // If 'logo' input is empty, post the file stored in $_FILES[$row['letter_head']]
        $logo = $row_fetch['letter_head'];
    } else {
        // If 'logo' input is not empty, upload the file
        $logo = $_FILES['logo']['name'];
        $temp_file_path = $_FILES['logo']['tmp_name'];
        $folder1 = 'img/' . $logo;
        move_uploaded_file($temp_file_path, $folder1);
    }

    $bank_name = $_POST['bank_name'];
    $acc_num = $_POST['acc_num'];
    $ifsc = $_POST['ifsc'];
    $branch = $_POST['branch'];
    $acc_type = $_POST['acc_type'];
    $company_name_bank = $_POST['company_name_bank'];

    $sql_bank_edit = "UPDATE `complete_profile` SET `letter_head`='$logo',`bank_name` = '$bank_name', `account_num` = '$acc_num',
     `branch` = '$branch', `ifsc_code` = '$ifsc', `account_type` = '$acc_type', `companyname` = '$company_name_bank'
      WHERE `companyname` = '$companyname001'";
    $result = mysqli_query($conn, $sql_bank_edit);
    if ($result) {
        $_SESSION['message'] = 'message';
        header("location: edit_profile.php");
        exit(); // Ensure that no code is executed after the header redirection
    } else {
        echo "error";
    }
}
