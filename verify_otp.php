<?php 
include "partials/_dbconnect.php";

session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['verify_otp'])) {
        // OTP Verification
        $entered_code = mysqli_real_escape_string($conn, $_POST['otp']);
        $email = $_SESSION['email'];

        $sql_check = "SELECT * FROM job_application_apply WHERE email_id=? AND code=? AND status='notverified'";
        $stmt = mysqli_prepare($conn, $sql_check);
        mysqli_stmt_bind_param($stmt, 'ss', $email, $entered_code);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            $update_sql = "UPDATE job_application_apply SET status='verified', code=0 WHERE email_id=?";
            $stmt = mysqli_prepare($conn, $update_sql);
            mysqli_stmt_bind_param($stmt, 's', $email);

            if (mysqli_stmt_execute($stmt)) {
                $_SESSION['success'] = 'OTP verified successfully!';
                unset($_SESSION['email']);
                unset($_SESSION['otp']);
                header('Location: jobs_corner.php');
                exit();
            } else {
                $_SESSION['error'] = 'Failed to update status!';
                header('Location: verify_otp.php');
                exit();
            }
        } else {
            $_SESSION['error'] = 'Invalid OTP!';
            header('Location: verify_otp.php');
            exit();
        }
    }

    if (isset($_POST['resend_otp'])) {
        // Resend OTP
        $email = $_SESSION['email'];
        $code = rand(999999, 111111);

        $sql_update = "UPDATE job_application_apply SET code=? WHERE email_id=? AND status='notverified'";
        $stmt = mysqli_prepare($conn, $sql_update);
        mysqli_stmt_bind_param($stmt, 'ss', $code, $email);

        if (mysqli_stmt_execute($stmt)) {
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();                                           
                $mail->Host       = 'smtp.hostinger.com';                    
                $mail->SMTPAuth   = true;                                   
                $mail->Username   = 'support@fleeteip.com';                  
                $mail->Password   = 'fleetEIP@0807';                         
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;              
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
            <p>Your new OTP for job application is: <b>$code</b></p>
            <p>Please enter this OTP on the verification page to complete your application process.</p>
        </div>
    </div>
</body>
</html>
";
                $mail->send();
                echo 'success';
            } catch (Exception $e) {
                echo 'error';
            }
            exit();
        } else {
            echo 'error';
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
    <title>Verify OTP</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f5f5f5; }
        .navbar1 { background-color: #4067B5; padding: 10px; }
        .logo_fleet img { width: 150px; }
        .verify_otp_container { max-width: 600px; margin: 50px auto; padding: 20px; background-color: #fff; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); }
    </style>
</head>
<body>

<div class="verify_otp_container">
    <h2 class="verify_otp">Verify OTP</h2>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?php echo $_SESSION['error']; ?>
            <?php unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['info'])): ?>
        <div class="alert alert-info">
            <?php echo $_SESSION['info']; ?>
            <?php unset($_SESSION['info']); ?>
        </div>
    <?php endif; ?>

    <form id="otpForm" action="verify_otp.php" method="post">
        <div class="mb-3">
            <!-- <label for="otp" class="enter_otp">Enter OTP</label> -->
            <div class="trial1">
            <input type="text" placeholder="" class="input02" id="otp" name="otp" required>
            <label for="" class="placeholder2">Enter OTP</label>
            </div>
        </div>
        <button type="submit" name="verify_otp" class="verify_otp_button">Verify OTP</button>
        <button type="button" id="resendOtpBtn" class="verify_otp_button">Resend OTP</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>
<script>
document.getElementById('resendOtpBtn').addEventListener('click', function() {
    var form = document.getElementById('otpForm');
    var action = form.action;

    var formData = new FormData();
    formData.append('resend_otp', 'true');

    fetch(action, {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        if (data === 'success') {
            document.querySelector('.alert').innerHTML = "We've resent an OTP to your email.";
        } else if (data === 'error') {
            alert('Failed to resend OTP. Please try again.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
});
</script>
</body>
</html>