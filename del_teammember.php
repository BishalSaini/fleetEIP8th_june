<?php 
include "partials/_dbconnect.php";
$del_id=$_GET['id'];
$sql="DELETE FROM `team_members` where sno='$del_id'";
$result=mysqli_query($conn,$sql);
if($result){
    session_start();
    $_SESSION['del_success']="deleted successfully";
    header("Location: complete_profile_new.php");
    exit;
}
else{
    $_SESSION['del_error']="error in deleting";
    header("Location: complete_profile_new.php");
    exit;


}
?>