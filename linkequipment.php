<?php
session_start();
$email = $_SESSION['email'];
$companyname001 = $_SESSION['companyname'];
$enterprise = $_SESSION['enterprise'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['projectinsightlinkequipment'])) {
    include "partials/_dbconnect.php";

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($_FILES['wo']['error'] !== UPLOAD_ERR_OK) {
        $_SESSION['error'] = 'File upload error!';
        header("Location: projectinsight.php?id=" . urlencode($_POST['linkequipmentprojectid']));
        exit();
    }

    $wo = $_FILES['wo']['name'];
    $temp_file_path = $_FILES['wo']['tmp_name'];
    $random_string = bin2hex(random_bytes(8));
    $unique_filename = $random_string . '_' . $wo;
    $folder3 = 'img/' . $unique_filename;

    if (!move_uploaded_file($temp_file_path, $folder3)) {
        $_SESSION['error'] = 'Failed to move uploaded file!';
        header("Location: projectinsight.php?id=" . urlencode($_POST['linkequipmentprojectid']));
        exit();
    }

    // Directly assign POST variables (no sanitization)
    $project_name = $_POST['project_name'];
    $rental_companyname = $_POST['rental_companyname'];
    $fleet_category = $_POST['fleet_category'];
    $type = $_POST['type'];
    $make = $_POST['make'];
    $model = $_POST['model'];
    $yom = $_POST['yom'];
    $capacity = $_POST['capacity'];
    $unit = $_POST['unit'];
    $wo_start = $_POST['wo_start'];
    $wo_end = $_POST['wo_end'];
    $monthly_rental = $_POST['monthly_rental'];
    $mob = $_POST['mob'];
    $demob = $_POST['demob'];
    $shift = $_POST['shift'];
    $engine_hour = $_POST['engine_hour'] ?? '';
    $workinghour = $_POST['workinghour'] ?? '';
    $operator = $_POST['operator'];
    $helper = $_POST['helper'];
    $mob_recovery = $_POST['mob_recovery'];
    $demob_recovery = $_POST['demob_recovery'];
    $linkequipmentprojectid = $_POST['linkequipmentprojectid'];
    $reg=$_POST['reg'];
    $chassis_no=$_POST['chassis_no'];

    // Directly using the values in the SQL query
    // $sql = "INSERT INTO `linked_equipment` (`category`,`type`,`companyname`, `projectname`, `projectid`, `rental_name`, `make`, `model`, `yom`, `wo_start`, `wo_end`, `monthly_rental`, `wo`) 
    // VALUES ('$fleet_category','$type','$companyname001', '$project_name', '$linkequipmentprojectid', '$rental_companyname', '$make', '$model', '$yom', '$wo_start', '$wo_end', '$monthly_rental', '$unique_filename')";
    
$sql="INSERT INTO `linked_equipment`(`reg`,`chassis_no`,`companyname`, `projectname`, `projectid`,
     `rental_name`, `make`, `model`, `yom`,
      `wo_start`, `wo_end`, `monthly_rental`, 
      `wo`, `category`, `type`, `cap`, `unit`,
       `mob`, `demob`, `shift`, `working_hour`,
        `engine_hour`, `operator`, `helper`, `mob_recovery`,
         `demob_recovery`) VALUES ('$reg','$chassis_no','$companyname001','$project_name','$linkequipmentprojectid',
         '$rental_companyname','$make','$model','$yom','$wo_start','$wo_end','$monthly_rental','$unique_filename','$fleet_category',
         '$type','$capacity','$unit','$mob','$demob','$shift','$workinghour','$engine_hour','$operator','$helper','$mob_recovery','$demob_recovery')";


    if ($conn->query($sql) === TRUE) {
        $linknoti="INSERT INTO `rentallinkedequipment`(`companyname`, `rentalname`, `type`, `make`, `model`, `yom`, `cap`, `unit`, `reg`, `chassis_no`) VALUES
         ('$companyname001','$rental_companyname','$type','$make','$model','$yom','$capacity','$unit','$reg','$chassis_no')";
         $resultnoti=mysqli_query($conn,$linknoti);
        $_SESSION['success'] = 'done';
    } else {
        $_SESSION['error'] = 'done';
    }

    header("Location: projectinsight.php?id=" . urlencode($linkequipmentprojectid));
    exit();
}
?>
