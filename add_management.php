<?php 
 if(isset($_POST['addmanagement_btn'])){
    include "partials/_dbconnect.php";
    $name=$_POST['management_name'];
    $email=$_POST['management_email'];
    $contact=$_POST['management_contact_number'];
    $designation=$_POST['management_designation'];
    $com_name=$_POST['com_name'];
    $sql="INSERT INTO `team_members` (`name`, `mob_number`, `email`, `company_name`, `department`, `designation`)
     VALUES ('$name', '$contact', '$email', '$com_name', 'Management', '$designation')";
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