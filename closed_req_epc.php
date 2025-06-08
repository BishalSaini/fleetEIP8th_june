<?php
include 'partials/_dbconnect.php';

$id=$_GET['id'];
$platform=$_GET['platform'];
$vendor=$_GET['vendor'];
$sql1="SELECT * FROM `req_by_epc` where id=$id";
$result=mysqli_query($conn,$sql1);
$row=mysqli_fetch_assoc($result);

$sql_closed = "INSERT INTO `closed_requirement_epc_latest` (`equipment_type`, `equipment_capacity`, `boom_combination`, `project_type`, `duration_month`, `state`, `district`, `working_shift`, `tentative_date`, `epc_name`, `epc_email`, `epc_number`, `fleet_category`, `contact_person`, `engine_hour`, `notes`, `unit`, `project_code`, `fuel_scope`, `accomodation_scope`, `platform`, `vendor`) 
VALUES ('" . $row['equipment_type'] . "', '" . $row['equipment_capacity'] . "', '" . $row['boom_combination'] . "', '" . $row['project_type'] . "', '" . $row['duration_month'] . "', '" . $row['state'] . "', '" . $row['district'] . "', '" . $row['working_shift'] . "', '" . $row['tentative_date'] . "', '" . $row['epc_name'] . "', '" . $row['epc_email'] . "', '" . $row['epc_number'] . "', '" . $row['fleet_category'] . "', '" . $row['contact_person'] . "', '" . $row['engine_hour'] . "', '" . $row['notes'] . "', '" . $row['unit'] . "', '" . $row['project_code'] . "', '" . $row['fuel_scope'] . "', '" . $row['accomodation_scope'] . "',
 '$platform', '$vendor')";
$result_closed=mysqli_query($conn ,$sql_closed);
if($result_closed){
    $deleteQuery = "DELETE FROM `req_by_epc` WHERE id = '$id'";
        $result_delete_query=mysqli_query($conn,$deleteQuery);
    if($result_delete_query){
        session_start();  // Start the session

        $_SESSION['message']="success";
        header("location:requirementlisting.php");
    }

}


?>


