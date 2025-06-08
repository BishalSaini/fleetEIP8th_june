<?php
session_start();

$showError = false;
$showAlert=false;

require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if($_SERVER['REQUEST_METHOD']==='POST'){
    include "partials/_dbconnect.php";

    // Capture the reCAPTCHA response token
    $recaptcha_response = $_POST['g-recaptcha-response'];

    // Verify the token with Google's API
    $secret_key = "6Lc4ucIqAAAAALEzxaKD-3wV7U1FBoeVDfQ4XSF1"; 
    $verify_url = "https://www.google.com/recaptcha/api/siteverify";
    $response = file_get_contents($verify_url . "?secret=" . $secret_key . "&response=" . $recaptcha_response);
    $response_data = json_decode($response);

    // Check if reCAPTCHA validation was successful
    if (!$response_data->success) {
        session_start();
        $_SESSION['captcha_error'] = "Captcha verification failed. Please try again.";
        header("Location: sign_in.php");
        exit;
    }



    

    $email_new=$_POST['email_new'];
    $pass_new=$_POST['pass_new'];
    $conf_pass_new=$_POST['conf_pass_new'];
    $comp_name_new=$_POST['comp_name_new'];
    $companyweb_dd=$_POST['companyweb_dd'];
    $web_add_new=$_POST['web_add_new'];
    $ent_class_new=$_POST['ent_class_new'];

    if($pass_new != $conf_pass_new ){
        session_start();
        $_SESSION['wrong_pass']="password is wrong";
        header("Location: sign_in.php");
        exit;
    }

    $companyexist= "SELECT * FROM login WHERE companyname='$comp_name_new' and status='verified'";
    $result=mysqli_query($conn,$companyexist);
    if(mysqli_num_rows($result)>0){
        session_start();
        $_SESSION['companyexist']="companyname already exist";
        header("Location: sign_in.php");
        exit;
    }
    else{
        $code = rand(999999, 111111);
        $status = "notverified";
        $sql_insert = "INSERT INTO login (email, password, companyname, comp_web, webiste_address, enterprise, code, status) 
                   VALUES ('$email_new', '$pass_new', '$comp_name_new', '$companyweb_dd', '$web_add_new', '$ent_class_new', '$code', '$status')";
        if(mysqli_query($conn,$sql_insert)){
            $mail = new PHPMailer(true);
            try {
                    // Server settings
                    $mail->isSMTP();                                            // Send using SMTP
                    $mail->Host       = 'smtp.gmail.com';                   // Set the SMTP server to send through
                    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                    $mail->Username   = 'akash.s0167@gmail.com';                 // SMTP username
                    $mail->Password   = 'obwe bbza kenq ffiu';                        // SMTP password
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            // Enable implicit TLS encryption
                    $mail->Port       = 465;                                    // TCP port to connect to
    
                    // Email to the user for verification
                    $mail->setFrom('akash.s0167@gmail.com', 'FleetEIP');
                    $mail->addAddress($email_new);  
    
                    $mail->isHTML(true);
                    $mail->Subject = "Email Verification Code";
                    $mail->Body    = "
    <html>
    <head>
        <style>
            body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; line-height: 1.6; background-color: #f9f9f9; margin: 0; padding: 0; }
            .container { width: 100%; max-width: 600px; margin: 20px auto; padding: 20px; background-color: #ffffff; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); border: 1px solid #e0e0e0; }
            .header { background-color: #4067B5; color: white; padding: 15px; border-radius: 8px 8px 0 0; text-align: center; font-size: 24px; font-weight: bold; }
            .content { margin: 20px 0; padding: 20px; }
            .content p { font-size: 16px; color: #333333; }
            .content h2 { font-size: 28px; color: #4067B5; text-align: center; margin: 20px 0; }
            .footer { font-size: 12px; color: #888888; text-align: center; margin-top: 20px; }
            .footer p { margin: 5px 0; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>FleetEIP - Email Verification</div>
            <div class='content'>
                <p>Dear User,</p>
                <p>Thank you for registering with FleetEIP. To complete your registration, please verify your email address by entering the verification code provided below on the verification page:</p>
                <h2>$code</h2>
                <p>This verification code is valid for a limited time and should be kept confidential.</p>
                <p>If you did not request this verification, please ignore this email or contact our support team immediately.</p>
                <p>Thank you,<br>FleetEIP Support Team</p>
            </div>
            <div class='footer'>
                <p>This email was sent from an address that cannot receive replies. If you need further assistance, please contact our support team.</p>
                <p>&copy; 2024 FleetEIP. All rights reserved.</p>
            </div>
        </div>
    </body>
    </html>";
    
                    $mail->send();
    
                    // Email to support@fleeteip.com with user details
                    $mail->clearAddresses(); // Clear previous recipients
                    $mail->addAddress('support@fleeteip.com');  
                    $mail->Subject = "New User Sign Up Notification";
                    $mail->Body    = "
    <html>
    <head>
        <style>
            body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; line-height: 1.6; background-color: #f9f9f9; margin: 0; padding: 0; }
            .container { width: 100%; max-width: 600px; margin: 20px auto; padding: 20px; background-color: #ffffff; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); border: 1px solid #e0e0e0; }
            .header { background-color: #4067B5; color: white; padding: 15px; border-radius: 8px 8px 0 0; text-align: center; font-size: 24px; font-weight: bold; }
            .content { margin: 20px 0; padding: 20px; }
            .content p { font-size: 16px; color: #333333; }
            .footer { font-size: 12px; color: #888888; text-align: center; margin-top: 20px; }
            .footer p { margin: 5px 0; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>FleetEIP - New User Sign Up</div>
            <div class='content'>
                <p>Dear Support Team,</p>
                <p>A new user has signed up on the FleetEIP platform. Below are the details:</p>
                <p><strong>Company Name:</strong> $comp_name_new</p>
                <p><strong>Email:</strong> $email_new</p>
                <p><strong>Company Website:</strong> $companyweb_dd</p>
                <p><strong>Website Address:</strong> $web_add_new</p>
                <p><strong>Enterprise Type:</strong> $ent_class_new</p>
                <p>Please verify the details and take necessary action if required.</p>
                <p>Thank you,<br>FleetEIP System</p>
            </div>
            <div class='footer'>
                <p>&copy; 2024 FleetEIP. All rights reserved.</p>
            </div>
        </div>
    </body>
    </html>";
                    $mail->send();
    
                    $info = "We've sent a verification code to your email - $email_new";
                    $_SESSION['info'] = $info;
                    $_SESSION['email'] = $email_new;
                    $_SESSION['password'] = $pass_new;
                    
                    header('location: user-otp.php');
                    exit();


            }
 catch (Exception $e) {
    session_start();
    $_SESSION['emailerror']="email not sent";
    header("Location :sign_in.php");
    exit;
}

            } 
        
        }







    
}