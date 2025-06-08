<?php
$edit_id=$_GET['id'];
session_start();
$companyname001=$_SESSION['companyname'];

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
elseif ($enterprise === 'admin') {
    $dashboard_url = 'news/admin/dashboard.php';
}

else {
    $dashboard_url = '';
}
include "partials/_dbconnect.php";
$sql="SELECT * FROM `job_posting` where sno='$edit_id'";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_assoc($result);



?>
<?php

if(isset($_POST['JOB_submit'])){
    include "partials/_dbconnect.php";
    $job_heading=$_POST['job_heading'];
    $job_location=$_POST['job_location'];
    $pay_range=$_POST['pay_range'];
    $contact_person=$_POST['contact_person'];
    $designation=$_POST['designation'];
    $email=$_POST['email'];
    $contact_number=$_POST['contact_number'];
    $valid_till=$_POST['valid_till'];
    $roles=$_POST['roles'];
    $education=$_POST['education'];
    $perks=$_POST['perks'];
    $companyname=$_POST['companyname'];
    $minimum_experience=$_POST['minimum_experience'];
    $edit_id=$_POST['edit_id'];

    $sql_edit="UPDATE `job_posting` SET `job_heading` = '$job_heading', `job_location` = '$job_location',
     `pay_range` = '$pay_range', `contact_person` = '$contact_person', `designation` = '$designation',
      `email` = '$email', `contact_number` = '$contact_number', `valid_till` = '$valid_till',
       `roles` = '$roles ', `education` = '$education',`company_name`='$companyname', `perks` = '$perks',
        `minimum_experience` = '$minimum_experience' WHERE `job_posting`.`sno` = '$edit_id'";
    $result_edit=mysqli_query($conn,$sql_edit);
    if($result_edit){
        session_start();
        $_SESSION['success']='success';
        header("Location: adminjobposting.php");

    }
    else{
        $_SESSION['error']='success';
        header("Location: adminjobposting.php");
    }

}

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.4/font/bootstrap-icons.min.css" rel="stylesheet">

    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="favicon.jpg" type="image/x-icon">
    <title>Edit</title>
</head>
<body>
<div class="navbar1">
        <!-- Navbar section -->
        <div class="logo_fleet">
            <!-- Logo with a link to rental_dashboard.php -->
            <img src="logo_fe.png" alt="FLEET EIP" onclick="window.location.href='<?php echo $dashboard_url  ?>'">
        </div>
        <div class="iconcontainer">
            <!-- Navigation links -->
            <ul>
              <li><a href="<?php echo $dashboard_url ?>">Dashboard</a></li>
                <li><a href="news/">News</a></li>
                <li><a href="logout.php">Log Out</a></li>
            </ul>
        </div>
    </div>
    <form action="admineditjob.php" class="job_posting" method="POST" autocomplete="off">
    <div class="job_posting_container1" id="job_detail">
        <p>Job Details</p>
        <div class="trial1">
            <input type="text" name="job_heading" value="<?php echo $row['job_heading'] ?>" placeholder="" class="input02" required>
            <label for="" class="placeholder2">Job Heading</label>
        </div>
        <div class="trial1">
        <input type="text" name="companyname" value="<?php echo $row['company_name'] ?>" placeholder="" class="input02"  >
         <label for="" class="placeholder2">Company Name</label>

        </div>

        <!-- <input type="text" name="companyname" value="<?php echo $companyname001 ?>" hidden readonly> -->
        <input type="text" name="edit_id" value="<?php echo $edit_id ?>" hidden readonly>
        <div class="outer02">
        <div class="trial1">
            <input type="text" value="<?php echo $row['job_location'] ?>" name="job_location" placeholder="" class="input02" required>
            <label for="" class="placeholder2">Job Location</label>
        </div>
        <div class="trial1">
            <input type="text" name="pay_range" value="<?php echo $row['pay_range'] ?>" placeholder="" class="input02" required>
            <label for="" class="placeholder2">Pay Range/Month</label>
        </div>
        </div>
        <div class="outer02">
        <div class="trial1">
            <input type="text" value="<?php echo $row['contact_person'] ?>" name="contact_person" placeholder="" class="input02" required>
            <label for="" class="placeholder2">Contact Person</label>
        </div>
        <div class="trial1">
            <input type="text" value="<?php echo $row['designation'] ?>" name="designation" placeholder="" class="input02" required>
            <label for="" class="placeholder2">Designation</label>
        </div>

        </div>
        <div class="outer02">
        <div class="trial1">
            <input type="text" value="<?php echo $row['email'] ?>" name="email" placeholder="" class="input02" required>
            <label for="" class="placeholder2">Email Id</label>
        </div>
        <div class="trial1">
            <input type="text" value="<?php echo $row['contact_number'] ?>" name="contact_number" placeholder="" class="input02" required>
            <label for="" class="placeholder2">Contact Number</label>
        </div>

        </div>
        <div class="outer02">
        <div class="trial1">
            <input type="date" value="<?php echo $row['valid_till'] ?>" name="valid_till" placeholder="" class="input02" required>
            <label for="" class="placeholder2">Job Opening Valid Till</label>
        </div>
        <div class="trial1">
            <input type="text" value="<?php echo $row['minimum_experience'] ?>" name="minimum_experience" placeholder="" class="input02">
            <label for="" class="placeholder2">Minimum Experience</label>
        </div>
        </div>

        <a class="epc-button" onclick="jobdescription()">Next</a><span id="job_postingstep">Step:1/2</span>
        <br>

</div>
<div class="job_posting_container2" id="job_desc">
    <p>Job Description</p>
        <div class="trial1">
            <textarea rows="8"  name="roles" type="text" placeholder="" class="input02" ><?php echo $row['roles']?></textarea>
            <label for="" class="placeholder2">Roles & Responsibilities</label>
        </div>
        <div class="trial1">
            <textarea rows="4"  name="education" type="text" placeholder="" class="input02" required><?php echo $row['education'] ?></textarea>
            <label for="" class="placeholder2">Education Required</label>
        </div>
        <div class="trial1">
            <textarea  rows="4"  name="perks" type="text" placeholder="" class="input02" required><?php echo $row['perks'] ?></textarea>
            <label for="" class="placeholder2">Company Provided Perks </label>
        </div>
        <button class="epc-button" name="JOB_submit" type="submit">Post</button>
        <a class="backarrow" onclick="back_arrow()"><i class="bi bi-arrow-left"></i> Back</a>
        <br>




    </div>
    
</form>
<script>
    function jobdescription(){
        document.getElementById("job_detail").style.display='none';
        document.getElementById("job_desc").style.display='block';
        document.getElementById("job_desc").style.display='flex';
    
    }
    function back_arrow(){
        document.getElementById("job_detail").style.display='block';
        document.getElementById("job_desc").style.display='none';
        document.getElementById("job_detail").style.display='flex';
    
    }
</script>

</body>
</html>