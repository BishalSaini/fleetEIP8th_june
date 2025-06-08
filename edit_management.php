<?php
include "partials/_dbconnect.php";
$management_id=$_GET['id'];
session_start();
$companyname001=$_SESSION['companyname'];

$sql="SELECT * FROM `team_members` where `sno`='$management_id'";
$result=mysqli_query($conn,$sql);
if($result){
    $row=mysqli_fetch_assoc($result);
}
else{
    $row=array();

}
?>
<?php
if (isset($_POST['addmanagement_btn'])){
    include "partials/_dbconnect.php";
    $management_name=$_POST['management_name'];
    $management_email=$_POST['management_email'];
    $management_contact_number=$_POST['management_contact_number'];
    $management_designation=$_POST['management_designation'];

    $sql_edit="UPDATE `team_members` SET `name` = '$management_name', `mob_number` = '$management_contact_number', 
    `email` = '$management_email', `department` = 'Management',
     `designation` = '$management_designation' WHERE `sno` = '$management_id'";
     $result_edit=mysqli_query($conn,$sql_edit);
     if($result_edit){
        session_start();
        $_SESSION['basic_detail_success'] = "success";
        header("Location: complete_profile_new.php");
        exit;

     }
     else{
        $_SESSION['basic_detail_error'] = "error";
        header("Location: complete_profile_new.php");

     }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<form action="" method="POST" class="addmanagement_member" id="editmanagement_form">
            <div class="manage_container">
                <p>Add Management</p>
                <div class="trial1">
                    <input type="text" value="<?php echo $row['name'] ?>" name="management_name" placeholder="" class="input02">
                    <label for="" class="placeholder2">Name</label>
                </div>
                <div class="trial1">
                    <input type="text" name="management_email" value="<?php echo $row['email'] ?>" placeholder="" class="input02">
                    <label for="" class="placeholder2">Email</label>
                </div>
                <input type="text" name="com_name" value="<?php echo $companyname001 ?>" hidden>
                <div class="trial1">
                    <input type="text" name="management_contact_number" value="<?php echo $row['mob_number'] ?>" placeholder="" class="input02">
                    <label for="" class="placeholder2">Contact Number</label>
                </div>
                <div class="trial1">
                    <input type="text" name="management_designation" value="<?php echo $row['designation'] ?>" placeholder="" class="input02">
                    <label for="" class="placeholder2">Designation</label>
                </div>
                <button class="basic-detail-button" name="addmanagement_btn">Submit</button>


            </div>

        </form>

</body>
</html>