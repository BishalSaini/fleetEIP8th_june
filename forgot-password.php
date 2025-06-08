<?php
session_start();
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$errors = array();

if(isset($_POST['check-email'])){
    $email = $_POST['email'];

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errors['email'] = "Invalid email format";
    }

    if(count($errors) === 0){
        include "partials/_dbconnect.php"; 

        $check_email = "SELECT * FROM login WHERE email='$email'";
        $run_query = mysqli_query($conn, $check_email);

        if(mysqli_num_rows($run_query) > 0){
            $code = rand(100000, 999999); 

            $update_code = "UPDATE login SET code = '$code' WHERE email = '$email'";
            $update_query = mysqli_query($conn, $update_code);

            if($update_query){
                $mail = new PHPMailer(true);

                try {
                    //Server settings
                    $mail->isSMTP();                                            //Send using SMTP
                    $mail->Host       = 'smtp.hostinger.com';                    //Set the SMTP server to send through
                    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                    $mail->Username   = 'support@fleeteip.com';                 //SMTP username
                    $mail->Password   = 'fleetEIP@0807';                        //SMTP password
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                    $mail->Port       = 465;                                    //TCP port to connect to

                    //Recipients
                    $mail->setFrom('support@fleeteip.com', 'FleetEIP');
                    $mail->addAddress($email);                                  //Add a recipient

                    //Content
                    $mail->isHTML(true);  // Set email format to HTML
                    $mail->Subject = 'Password Reset Request - OTP Enclosed';
                    $mail->Body = "
<html>
<head>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            line-height: 1.6;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border: 1px solid #e0e0e0;
        }
        .header {
            background-color: #4067B5;
            color: white;
            padding: 15px;
            border-radius: 8px 8px 0 0;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
        }
        .content {
            margin: 20px 0;
            padding: 20px;
        }
        .content p {
            font-size: 16px;
            color: #333333;
        }
        .content h2 {
            font-size: 28px;
            color: #4067B5;
            text-align: center;
            margin: 20px 0;
        }
        .footer {
            font-size: 12px;
            color: #888888;
            text-align: center;
            margin-top: 20px;
        }
        .footer p {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <div class='container'>
        <div class='header'>
            FleetEIP - Password Reset
        </div>
        <div class='content'>
            <p>Dear User,</p>
            <p>We have received a request to reset your password for your FleetEIP account associated with this email address.</p>
            <p>Your One Time Password (OTP) for resetting your password is:</p>
            <h2>$code</h2>
            <p>Please enter this OTP on the password reset page to proceed with resetting your password. This OTP is valid for a limited time and should be kept confidential.</p>
            <p>If you did not request a password reset, please ignore this email or contact our support team immediately.</p>
            <p>Thank you,<br>
            FleetEIP Support Team</p>
        </div>
        <div class='footer'>
            <p>This email was sent from an address that cannot receive replies. If you need further assistance, please contact our support team.</p>
            <p>&copy; 2024 FleetEIP. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
";

                    
                    $mail->send();
                    $info = "We've sent a password reset OTP to your email - $email";
                    $_SESSION['info'] = $info;
                    $_SESSION['email'] = $email;                           

                    header('location: reset-code.php');                      
                    exit();
                } catch (Exception $e) {
                    $errors['otp-error'] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
            } else {
                $errors['db-error'] = "Failed to update OTP code in database";
            }
        } else {
            $errors['email'] = "This email address does not exist";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css?family=Poppins:400,500,600,700&display=swap');
        html, body {
            background: #fff;
            font-family: 'Poppins', sans-serif;
        }
        ::selection {
            color: #fff;
            background: #fff;
        }
        .container {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
        .container .form {
            background: #fff;
            padding: 30px 35px;
            border-radius: 5px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }
        .container .form .form-control {
            height: 40px;
            font-size: 15px;
        }
        .container .form .forget-pass {
            margin: -15px 0 15px 0;
        }
        .container .form .forget-pass a {
            font-size: 15px;
        }
        .container .form .button {
            background: #4067B5;
            color: #fff;
            font-size: 17px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .container .form .button:hover {
            background: #4067B5;
        }
        .container .form .link {
            padding: 5px 0;
        }
        .container .form .link a {
            color: #6665ee;
        }
        .container .login-form form p {
            font-size: 14px;
        }
        .container .row .alert {
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4 offset-md-4 form">
                <form action="forgot-password.php" method="POST" autocomplete="off">
                    <h2 class="text-center">Forgot Password</h2>
                    <p class="text-center">Enter your email address</p>
                    <?php
                    if(count($errors) > 0){
                        echo '<div class="alert alert-danger text-center">';
                        foreach($errors as $error){
                            echo $error . '<br>';
                        }
                        echo '</div>';
                    }
                    ?>
                    <div class="form-group">
                        <input class="form-control" type="email" name="email" placeholder="Enter email address" required value="<?php echo isset($email) ? $email : ''; ?>">
                    </div>
                    <div class="form-group">
                        <input class="form-control button" type="submit" name="check-email" value="Continue">
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
