<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

if (!isset($_SESSION['email'])) {
    header('location: sign_in.php');
    exit();
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include "partials/_dbconnect.php";

    if (isset($_POST['check'])) {
        $otp_code = mysqli_real_escape_string($conn, $_POST['otp']);
        $check_code = "SELECT * FROM login WHERE code = $otp_code";
        $code_res = mysqli_query($conn, $check_code);

        if (mysqli_num_rows($code_res) > 0) {
            $fetch_data = mysqli_fetch_assoc($code_res);
            $fetch_code = $fetch_data['code'];
            $email = $fetch_data['email'];
            $code = 0;
            $status = 'verified';

            $update_otp = "UPDATE login SET code = $code, status = '$status' WHERE code = $fetch_code";
            $update_res = mysqli_query($conn, $update_otp);

            if ($update_res) {
                $_SESSION['email'] = $email;
                $_SESSION['verified'] = "mail verified";

                header('location: sign_in.php');
                exit();
            } else {
                $errors['otp-error'] = "Failed while updating code!";
            }
        } else {
            $errors['otp-error'] = "You've entered incorrect code!";
        }
    } elseif (isset($_POST['resend'])) {
        $email_new = $_SESSION['email'];
        $code = rand(999999, 111111);

        // Update the verification code in the database
        $sql_update_code = "UPDATE login SET code='$code' WHERE email='$email_new'";
        $result_update_code = mysqli_query($conn, $sql_update_code);

        if ($result_update_code) {
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.hostinger.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'support@fleeteip.com';
                $mail->Password = 'fleetEIP@0807';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port = 465;

                $mail->setFrom('support@fleeteip.com', 'FleetEIP');
                $mail->addAddress($email_new);

                $mail->isHTML(true);
                $subject = "Resend: Email Verification Code";
                $message = "
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
            background-color: #3f67b5;
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
            color: #3f67b5;
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
            Fleet EIP - Email Verification
        </div>
        <div class='content'>
            <p>Dear User,</p>
            <p>We have resent the verification code to your email address. Please verify your email by entering the new verification code provided below:</p>
            <h2>$code</h2>
            <p>This verification code is valid for a limited time and should be kept confidential.</p>
            <p>If you did not request this verification, please ignore this email or contact our support team immediately.</p>
            <p>Thank you,<br>
            Fleet EIP Support Team</p>
        </div>
        <div class='footer'>
            <p>This email was sent from an address that cannot receive replies. If you need further assistance, please contact our support team.</p>
            <p>&copy; 2024 Fleet EIP. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
";

                $mail->Subject = $subject;
                $mail->Body = $message;
                $mail->send();

                $info = "A new verification code has been sent to your email - $email_new";
                $_SESSION['info'] = $info;

                header('location: user-otp.php');
                exit();
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        } else {
            $errors['otp-error'] = "Failed to update the verification code!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="favicon.jpg" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
    <link rel="stylesheet" href="style.css">
</head>
    <div class="navbar1">
    <div class="logo_fleet">
    <img src="logo_fe.png" alt="FLEET EIP" onclick="window.location.href='<?php echo $dashboard_url  ?>'">
</div>

    <div class="iconcontainer">
        <ul>
            <li><a href="index.php">Home</a></li>
            <!-- <li><a href="about_us.html">About Us</a></li>
            <li><a href="contact_us.php">Contact Us</a></li> -->
            <li><a href="sign_in.php">LogIn</a></li>
        </ul>
    </div>
</div>
<body>
    <form id="otp-form" action="user-otp.php" class="otpform" method="POST">
        <div class="otp_container">
            <!-- <h2>OTP Verification</h2> -->
             <p class="headingpara">OTP Verification</p>
            <?php
            if (isset($_SESSION['info'])) {
                echo '<div>' . $_SESSION['info'] . '</div>';
            }
            if (isset($errors['otp-error'])) {
                echo '<div>' . $errors['otp-error'] . '</div>';
            }
            ?>
            <div class="trial1">
                <input type="text" name="otp" placeholder="" class="input02" required>
                <label for="" class="placeholder2">Enter OTP</label>
            </div>
            <div class="button_container_resend">
            <button type="submit" class="epc-button" name="check" id="verifyotpbutton">Verify</button>            <button onclick="document.getElementById('resend-form').submit();" class="epc-button">Resend OTP</button>

            </div>
            <br>
        </div>
    </form>
    <form id="resend-form" action="user-otp.php" method="POST" style="display:none;">
        <input type="hidden" name="resend" value="resend">

    </form>
</body>
</html>