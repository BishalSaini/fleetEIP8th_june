<?php 
if(isset($_POST['add_employe'])){
    include "partials/_dbconnect.php";
    $name=$_POST['team_name'];
    $mob_num=$_POST['number'];
    $company=$_POST['companyname'];
    $email=$_POST['email'];
    $department=$_POST['department'];
    $actual_designation=$_POST['actual_designation'];

    $sql="INSERT INTO `team_members` (`name`, `mob_number`, `email`, `company_name`, `department`, `designation`) 
    VALUES ('$name', '$mob_num', '$email', '$company', '$department', '$actual_designation')";
    $result=mysqli_query($conn,$sql);
    if($result){
        session_start();
        $_SESSION['basic_detail_success']="success";
        header("Location:complete_profile_new.php");
    }
    else{
        $_SESSION['basic_detail_error']="error";
        header("Location:complete_profile_new.php");

    }
}
?>