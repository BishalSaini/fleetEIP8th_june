<?php
include "partials/_dbconnect.php";
$edit_id=$_GET['id'];
session_start();
$companyname001=$_SESSION['companyname'];
$sql="SELECT * FROM `team_members` where `sno`='$edit_id'";
$result=mysqli_query($conn,$sql);
if($result){
    $row=mysqli_fetch_assoc($result);
}
else{
    $row=array();

}
?>
<?php
if(isset($_POST['add_employe'])){
    include "partials/_dbconnect.php";

    // Retrieve form data
    $team_name = $_POST['team_name'];
    $number = $_POST['number'];
    $email = $_POST['email'];
    $department = $_POST['department'];
    $actual_designation = $_POST['actual_designation'];
    $edit_id = $_POST['edit_id']; // Assuming edit_id is passed via POST
    $edit_id_name=$_POST['edit_id_name'];

    // Update SQL query (assuming $edit_id is properly sanitized elsewhere)
    $sql_edit = "UPDATE `team_members` SET `name` = '$team_name', `mob_number` = '$number',
                 `email` = '$email', `department` = '$department', `designation` = '$actual_designation' 
                 WHERE `sno` = '$edit_id_name'";
                 
    // Execute query
    $result_edit = mysqli_query($conn, $sql_edit);

    // Check if query executed successfully
    if($result_edit){
        session_start();
        $_SESSION['basic_detail_success'] = "success";
        header("Location: complete_profile_new.php");
        exit(); // Always include exit() after header redirect
    } else {
        $_SESSION['basic_detail_error'] = "error";
        header("Location: complete_profile_new.php");
        exit(); // Always include exit() after header redirect
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>
<form action="edit_teammember.php" method="POST" class="rental-subuser-form" autocomplete="off">
        <div class="innersubuser">
            <div class="add_subuser_heading"><h2 class="rental_heading1">Add Team Member</h2></div>
            
            <div class="trial1">
            <input type="text" name="team_name" id="" value="<?php echo $row['name'] ?>" placeholder="" class="input02">
            <label class="placeholder2">Name</label>
            </div>
            <input type="text" name="edit_id_name" value="<?php echo $edit_id ?>" hidden>
            <div class="trial1">
            <input type="text" name="number" id="" value="<?php echo $row['mob_number'] ?>" placeholder="" class="input02">
            <label class="placeholder2">Mobile Number</label>
            </div>
            <div class="trial1">
            <input type="text" name="companyname" id="" value="<?php echo $companyname001 ?>" placeholder="" class="input02" readonly>
            <label class="placeholder2">Company Name</label>
            </div>
            <div class="trial1">

            <input type="text" name="email" id="" value="<?php echo $row['email'] ?>" placeholder="" class="input02">
            <label class="placeholder2">Email</label>
            </div>
            <div class="trial1">
            <select name="department" id="" class="input02">
                <option value="" disabled selected >Choose Department</option>
                <option <?php if($row['department']==='marketing'){ echo 'selected';} ?> value="marketing">Marketing</option>
                <option <?php if($row['department']==='operation'){ echo 'selected';} ?> value="operation">Operation and Maintenance</option>
                <option <?php if($row['department']==='accounts'){ echo 'selected';} ?> value="accounts">Accounts</option>
                <option <?php if($row['department']==='Adminsitration'){ echo 'selected';} ?> value="Administration">Administration</option>
                <option <?php if($row['department']==='Backend Department'){ echo 'selected';} ?> value="Backend Department">Backend Department</option>
                <option <?php if($row['department']==='Human Resource Department'){ echo 'selected';} ?> value="Human Resource Department">Human Resource Department</option>
            </select>
            </div>
            <div class="trial1">
                <input type="text" value="<?php echo $row['designation'] ?>" placeholder="" name="actual_designation" class="input02">
                <label for="" class="placeholder2">Designation</label>
            </div>
            <button class="basic-detail-button" name="add_employe">Edit User</button>
            

        </div>
    </form>

</body>
</html>