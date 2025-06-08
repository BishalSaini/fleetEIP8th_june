<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

$showAlert = false;
$showError = false;
$showError1 = false;
$showError2 = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include "partials/_dbconnect.php";

    // Retrieve form data
    $email_new = $_POST['email_new'];
    $pass_new = $_POST['pass_new'];
    $conf_pass_new = $_POST['conf_pass_new'];
    $comp_name_new = $_POST['comp_name_new'];
    $companyweb_dd = $_POST['companyweb_dd'];
    $web_add_new = $_POST['web_add_new'];
    $ent_class_new = !empty($_POST['ent_class_new']) ? $_POST['ent_class_new'] : 'None';
    $secret_key = "6LcCCpMqAAAAAOsjwkWHeASGMdoYAjNWKMHJS8Oj"; // Replace with your secret key


// Continue processing form data
if ($password !== $conf_pass_new) {
    $showError1 = true; // Show error if passwords do not match
}
    // Check if the company already exists
    $sql_exist = "SELECT * FROM login WHERE companyname='$comp_name_new' and status='verified'";
    $result = mysqli_query($conn, $sql_exist);

    if (mysqli_num_rows($result) > 0) {
        session_start();
        $_SESSION['error']='success';
        header("Location:sign_in.php");
    } 
    else if ($pass_new === $conf_pass_new) {
        // $encpass = password_hash($pass_new, PASSWORD_BCRYPT);
        $code = rand(999999, 111111);
        $status = "notverified";

        $sql_insert = "INSERT INTO login ( email, password, companyname,comp_web, webiste_address, enterprise, code, status) 
        VALUES ('$email_new', '$pass_new', '$comp_name_new','$companyweb_dd', '$web_add_new', '$ent_class_new','$code', '$status')";
        
        $result_insert = mysqli_query($conn, $sql_insert);
        if ($result_insert) {
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
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        }
            else {
                $errors['otp-error'] = "Failed while sending code!";
            }
        } else {
            $errors['db-error'] = "Failed while inserting data into database!";
        }
    }
    else {
        // $showError1 = true;
        session_start();
        $_SESSION['wrong_pass'] = 'success';
        header("Location: sign_in.php");
        exit;
    }
?>


<script><?php include "main.js" ?></script>
<style><?php include "style.css" ?></style>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script src="main.js"></script>
    <title>Document</title>
</head>
<body>
    <div class="navbar1">
    <div class="logo_fleet">
    <img src="logo_fe.png" alt="FLEET EIP" onclick="window.location.href='<?php echo $dashboard_url  ?>'">
</div>

        <div class="iconcontainer">
        <ul><li><a href="sign_in.php">Home</a></li>
            <li><a href="about_us.html">About Us</a></li>
            <li><a href="contact_us.php">Contact Us</a></li>
            <li><a href="sign_in.php">LogIn</a></li></ul>
        </div>
    </div>
    <?php
    if($showAlert){
       echo '<label>
       <input type="checkbox" class="alertCheckbox" autocomplete="off" />
       <div class="alert notice">
         <span class="alertClose">X</span>
         <span class="alertText">You Can Now LogIN
             <br class="clear"/></span>
       </div>
     </label>';
    }
    if($showError){
        echo '<label>
        <input type="checkbox" class="alertCheckbox" autocomplete="off" />
        <div class="alert error">
          <span class="alertClose">X</span>
          <span class="alertText">Company Already Exist Kindly Login
              <br class="clear"/></span>
        </div>
      </label>';
      if($showError1){
        echo '<label>
        <input type="checkbox" class="alertCheckbox" autocomplete="off" />
        <div class="alert error">
          <span class="alertClose">X</span>
          <span class="alertText">Mis Matched Credentials
              <br class="clear"/></span>
        </div>
      </label>';}
      if($showError2){
        echo '<label>
        <input type="checkbox" class="alertCheckbox" autocomplete="off" />
        <div class="alert error">
          <span class="alertClose">X</span>
          <span class="alertText">Captcha Verification Failed
              <br class="clear"/></span>
        </div>
      </label>';
    }

    }
    ?>

<form action="sign_up.php" enctype="multipart/form-data" method='POST' class="sign_up_new hideit">
    <div class="form_container1">
        <div class="sign_head">SignUp</div>
        <div class="trial1">
            <input type="text" name="email_new" placeholder="" class="input02 ">
            <label for="" class="placeholder2">Email</label>
        </div>
        <div class="outer02">
        <div class="trial1">
            <input type="password" name="pass_new"  placeholder="" class="input02">
            <label for="" class="placeholder2">Password</label>
        </div>
        <div class="trial1">
            <input type="password" name="conf_pass_new"  placeholder="" class="input02">
            <label for="" class="placeholder2">Confirm Password</label>
        </div>
        </div>
        <div class="trial1">
            <input type="text" name="comp_name_new"  placeholder="" class="input02">
            <label for="" class="placeholder2">Company Name</label>
        </div>
        <div class="trial1">
        <select name="companyweb_dd" class="input02" id="web_present" onchange="webdd_signin()">
            <option value=""disabled selected>Company Website ?</option>
            <option value="Yes">Yes</option>
            <option value="No">No</option>
        </select>
        </div>
        <div class="trial1"  placeholder="" id="web_add_company">
            <input type="text" name="web_add_new" class="input02">
            <label for="" class="placeholder2">Website Address</label>
        </div>
        <div class="trial1">
            <select name="ent_class_new" id="ent_Type_" class="input02" >
                <option value=""disabled selected>Enterprise Classified As</option>
                <option value="OEM">OEM</option>
                <option value="rental">Rental</option>
                <option value="logistics">Logistics</option>
                <option value="epc">EPCM</option>
                <option value="Commercial RMC">RMC Contractor</option>
                <option value="Logistics Broker">Logistics Broker</option>
            </select>
        </div>
        <button type='submit' class="epc-button">SIGNUP</button>
        <p class="terms">Already A Member ?  <a href="sign_in.php" class="sign_in_a">SignIn Here</a> </p>
<br><br>




    </div>
</form>
<br><br>
</body>
</html>