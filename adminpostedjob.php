<?php
session_start();
$companyname001=$_SESSION['companyname'];
$showAlert = false;
$showError = false;
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


?>
<?php
if(isset($_SESSION['success'])){
    $showAlert=true;
    unset($_SESSION['success']);
}
else if(isset($_SESSION['error'])){
    $showError=true;
    unset($_SESSION['error']);
}


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

    $sql="INSERT INTO `job_posting` (`minimum_experience`,`job_heading`, `job_location`, `pay_range`, `contact_person`,
     `designation`, `email`, `contact_number`, `valid_till`, `roles`,
      `education`, `perks`, `company_name`, `added_by`) VALUES ('$minimum_experience','$job_heading', '$job_location', '$pay_range', '$contact_person', '$designation',
       '$email', '$contact_number', '$valid_till', '$roles', '$education', '$perks','$companyname','$companyname001')";
    $result=mysqli_query($conn,$sql);
    if($result){
        $showAlert=true;
    }
    else{
$showError=true;
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
    <title>Job Posting</title>
</head>
<body>
<div class="navbar1">
    <div class="logo_fleet">
    <img src="logo_fe.png" alt="FLEET EIP" onclick="window.location.href='<?php echo $dashboard_url  ?>'">
</div>

        <div class="iconcontainer">
        <ul>
      <li><a href="<?php echo $dashboard_url ?>">Dashboard</a></li>
            <li><a href="news/">News</a></li>
                        <li><a href="logout.php">Log Out</a></li></ul>
        </div>
</div>
<?php
if ($showAlert) {
    echo  '<label>
    <input type="checkbox" class="alertCheckbox" autocomplete="off" />
    <div class="alert notice">
      <span class="alertClose">X</span>
      <span class="alertText_addfleet"><b>Success! </b>
          <br class="clear"/></span>
    </div>
  </label>';
}
if ($showError) {
    echo '<label>
    <input type="checkbox" class="alertCheckbox" autocomplete="off" />
    <div class="alert error">
      <span class="alertClose">X</span>
      <span class="alertText">Something Went Wrong
          <br class="clear"/></span>
    </div>
  </label>';
}
?>

<form action="adminpostedjob.php" class="job_posting" method="POST" autocomplete="off">
    <div class="job_posting_container1" id="job_detail">
        <p>Job Details</p>
        <div class="trial1">
            <input type="text" name="job_heading" placeholder="" class="input02" required>
            <label for="" class="placeholder2">Job Heading</label>
        </div>
        <div class="trial1">
        <input type="text" name="companyname" placeholder="" class="input02"  >
         <label for="" class="placeholder2">Company Name</label>

        </div>
        <div class="outer02">
        <div class="trial1">
            <input type="text" name="job_location" placeholder="" class="input02" required>
            <label for="" class="placeholder2">Job Location</label>
        </div>
        <div class="trial1">
            <input type="text" name="pay_range" placeholder="" class="input02" required>
            <label for="" class="placeholder2">Pay Range/Month</label>
        </div>
        </div>
        <div class="outer02">
        <div class="trial1">
            <input type="text" name="contact_person" placeholder="" class="input02" required>
            <label for="" class="placeholder2">Contact Person</label>
        </div>
        <div class="trial1">
            <input type="text" name="designation" placeholder="" class="input02" required>
            <label for="" class="placeholder2">Designation</label>
        </div>

        </div>
        <div class="outer02">
        <div class="trial1">
            <input type="text" name="email" placeholder="" class="input02" required>
            <label for="" class="placeholder2">Email Id</label>
        </div>
        <div class="trial1">
            <input type="text" name="contact_number" placeholder="" class="input02" required>
            <label for="" class="placeholder2">Contact Number</label>
        </div>

        </div>
        <div class="outer02">
        <div class="trial1">
            <input type="date" name="valid_till" placeholder="" class="input02" required>
            <label for="" class="placeholder2">Job Opening Valid Till</label>
        </div>
        <div class="trial1">
            <input type="text" name="minimum_experience" placeholder="" class="input02">
            <label for="" class="placeholder2">Minimum Experience</label>
        </div>
        </div>

        <a class="epc-button" onclick="jobdescription()">Next</a><span id="job_postingstep">Step:1/2</span>
        <br>

</div>
<div class="job_posting_container2" id="job_desc">
    <p>Job Description</p>
        <div class="trial1">
            <textarea rows="8" id="roles" name="roles" type="text" placeholder="" class="input02" ></textarea>
            <label for="" class="placeholder2">Roles & Responsibilities</label>
        </div>
        <div class="trial1">
            <textarea rows="4" name="education" type="text" placeholder="" class="input02" required></textarea>
            <label for="" class="placeholder2">Education Required</label>
        </div>
        <div class="trial1">
            <textarea  rows="4" name="perks" type="text" placeholder="" class="input02" required></textarea>
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

    document.getElementById('roles').addEventListener('keypress', function (e) {
    if (e.key === 'Enter') {
        e.preventDefault(); // Prevent the default newline
        const start = this.selectionStart;
        const end = this.selectionEnd;

        // Insert a bullet point at the current cursor position
        const value = this.value;
        this.value = value.substring(0, start) + '• ' + value.substring(end);
        
        // Move the cursor to the end of the inserted bullet point
        this.selectionStart = this.selectionEnd = start + 2; // 2 for the bullet and space
    }
});
</script>
</body>
</html>