<?php 
include "partials/_dbconnect.php"; 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

$id = $_GET['id'];
$sql = "SELECT * FROM job_posting WHERE sno='$id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

if (isset($_POST['submit_application'])) {
    $applyname = $_POST['applyname'];
    $mobilenumber = $_POST['mobilenumber'];
    $email = $_POST['email'];
    $job_id = $_POST['job_id'];
    $work_experience = $_POST['work_experience'];
    $company_applyingfor = $_POST['company_applyingfor'];
    
    $resume = $_FILES['resume']['name'];
    $temp_file_path = $_FILES['resume']['tmp_name'];
    $folder1 = 'img/' . $resume;

    if (move_uploaded_file($temp_file_path, $folder1)) {
        $code = rand(999999, 111111);
        $status = "notverified";
        
        $sql_insert = "INSERT INTO job_application_apply (job_id, name, number, email_id, work_experience, applying_for_company, resume, code, status) VALUES ('$job_id', '$applyname', '$mobilenumber', '$email', '$work_experience', '$company_applyingfor', '$resume', '$code', '$status')";
        
        $result = mysqli_query($conn, $sql_insert);
        if ($result) {
            session_start();
            $_SESSION['email'] = $email;
            $_SESSION['otp'] = $code; // Store OTP in session

            // Send OTP via Email
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();                                           
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = 'smtp.hostinger.com';                     //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = 'support@fleeteip.com';                     //SMTP username
                $mail->Password   = 'fleetEIP@0807';                               //SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                $mail->Port       = 465;            


                $mail->setFrom('support@fleeteip.com', 'FleetEIP');
                $mail->addAddress($email);  

                $mail->isHTML(true);  
                $mail->Subject = 'OTP for Job Application';
                $mail->Body    = "
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; }
        .container { width: 100%; max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #4067B5; color: #fff; padding: 10px; text-align: center; }
        .content { margin: 20px 0; }
    </style>
</head>
<body>
    <div class='container'>
        <div class='header'>FleetEIP - OTP Verification</div>
        <div class='content'>
            <p>Dear User,</p>
            <p>Your OTP for job application is: <b>$code</b></p>
            <p>Please enter this OTP on the verification page to complete your application process.</p>
        </div>
    </div>
</body>
</html>
";
                $mail->send();

                $_SESSION['info'] = "We've sent an OTP to your email - $email";
                header('Location: verify_otp.php');
                exit();
            } catch (Exception $e) {
                $_SESSION['error'] = "Failed to send OTP. Mailer Error: {$mail->ErrorInfo}";
                header('Location: jobs_corner.php');
                exit();
            }
        } else {
            $_SESSION['error'] = 'Failed while inserting data into database!';
            header('Location: jobs_corner.php');
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Apply for Job</title>
</head>
<body>
<div class="navbar1">
    <div class="logo_fleet">
        <img src="logo_fe.png" alt="FLEET EIP" onclick="window.location.href='sign_in.php'">
    </div>
</div>

<?php if (isset($_SESSION['info'])): ?>
    <label>
        <input type="checkbox" class="alertCheckbox" autocomplete="off" />
        <div class="alert notice">
            <span class="alertClose">X</span>
            <span class="alertText_addfleet"><b>Success! </b><br class="clear"/></span>
        </div>
    </label>
<?php unset($_SESSION['info']); endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <label>
        <input type="checkbox" class="alertCheckbox" autocomplete="off" />
        <div class="alert error">
            <span class="alertClose">X</span>
            <span class="alertText">Something Went Wrong<br class="clear"/></span>
        </div>
    </label>
<?php unset($_SESSION['error']); endif; ?>

<div class="job_detialscontainer">
    <p><strong>Job Heading :</strong> <?php echo $row['job_heading'] ?></p>
    <p><strong>Company Name :</strong> <?php echo $row['company_name'] ?></p>
    <p><strong>Job location:</strong> <?php echo $row['job_location'] ?> &nbsp &nbsp <strong>Pay Range :</strong> <?php echo $row['pay_range'] ?> &nbsp &nbsp <strong>Minimum Experience :</strong> <?php echo $row['minimum_experience'] ?></p>
    <p><strong>Roles :</strong> <?php echo $row['roles'] ?></p>
    <p><strong>Education :</strong> <?php echo $row['education'] ?></p>
    <p><strong>Perks :</strong> <?php echo $row['perks'] ?></p>
    <p><strong>Contact Person :</strong> <?php echo $row['contact_person'] .'-'. $row['designation'] ?></p>
    <p><strong>Contact Email :</strong> <?php echo $row['email'] ?> </p>
</div>

<form action="viewjobdetails.php" enctype="multipart/form-data" method="POST" class="applyforjob" autocomplete="off">
    <div class="applyjob_container">
        <p>🔴🔵🟢<span class="apply_span">Submit Application</span></p>
        <hr class="custom-hr">

        <div class="outer02">
            <div class="trial1">
                <input type="text" name="applyname" placeholder="" class="input02" required>
                <label for="" class="placeholder2">Name</label>
            </div>
            <div class="trial1">
                <input type="text" name="mobilenumber" placeholder="" class="input02" required>
                <label for="" class="placeholder2">Mobile Number</label>
            </div>
        </div>
        <div class="trial1">
            <input type="text" name="email" placeholder="" class="input02">
            <label for="" class="placeholder2">Email</label>
        </div>
        <input type="text" name="job_id" value="<?php echo $id ?>" hidden>
        <input type="text" name="company_applyingfor" value="<?php echo $row['company_name'] ?>" hidden>
        <div class="trial1">
            <select name="work_experience" id="" class="input02" required>
                <option value="" disabled selected>Work Experience</option>
                <option value="< 1Year">< 1Year</option>
                <option value="2 Years">2 Years</option>
                <option value="3 Years">3 Years</option>
                <option value="4 Years">4 Years</option>
                <option value="5 Years">5 Years</option>
                <option value="> 5Years">> 5Years</option>
            </select>            
        </div>
        <div class="trial1">
            <input type="file" name="resume" placeholder="" class="input02" required>
            <label for="" class="placeholder2">Upload Resume</label>
        </div>
        <div class="links">
            <button class="follow" type="submit" name="submit_application">Submit</button>
        </div>
        <br>
    </div>
</form>
</body>
</html>