<?php
include_once 'partials/_dbconnect.php'; // Include the database connection file
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

session_start();
$companyname001 = $_SESSION['companyname'];
$enterprise = $_SESSION['enterprise'];
$dashboard_url = '';

if ($enterprise === 'rental') {
    $dashboard_url = 'rental_dashboard.php';
} elseif ($enterprise === 'logistics') {
    $dashboard_url = 'logisticsdashboard.php';
} elseif ($enterprise === 'epc') {
    $dashboard_url = 'epc_dashboard.php';
} else {
    $dashboard_url = '';
}

$showAlert = false;
$showError = false;

if (isset($_SESSION['success'])) {
    $showAlert = true;
    unset($_SESSION['success']);
} else if (isset($_SESSION['error'])) {
    $showError = true;
    unset($_SESSION['error']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include "partials/_dbconnect.php";
    $type = $_POST['type'];
    $amount = $_POST['amount'];
    $contactperson = $_POST['contactperson'];
    $number = $_POST['number'];
    $notes = $_POST['notes'];
    $bankemail = 'support@fleeteip.com';

    $sql = "INSERT INTO `finance`(`type`, `amount`, `contactperson`, `number`, `notes`, `created_at`) 
            VALUES ('$type','$amount','$contactperson','$number','$notes',NOW())";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'smtp.hostinger.com';                   // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'support@fleeteip.com';                 // SMTP username
            $mail->Password   = 'fleetEIP@0807';                        // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            // Enable implicit TLS encryption
            $mail->Port       = 465;                                    // TCP port to connect to

            // Email to the user for verification
            $mail->setFrom('support@fleeteip.com', 'FleetEIP');
            $mail->addAddress($bankemail);  

            $mail->isHTML(true);
            $mail->Subject = 'Loan Requirement Received';
            $mail->Body = "
<html>
<head>
<style>
body {font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; line-height: 1.6; background-color: #f9f9f9; margin: 0; padding: 0;}
.container {
width: 100%;
max-width: 600px;
margin: 20px auto;
background-color: #ffffff;
border-radius: 8px;
box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
}
.header {background-color: #253C6A; color: white; padding: 15px; text-align: center; font-size: 24px;}
.content p {font-size: 16px; color: #333;}
.footer {text-align: center; font-size: 12px; color: #888; margin-top: 20px;}
.quotation-table {
width: 100%;
font-size: 13px;
border-collapse: collapse;
margin-top: 20px;
padding: 10px; 
}
.quotation-table, .quotation-table th, .quotation-table td {
border: 1px solid black!important; 
}

.quotation-table th, .quotation-table td {
padding: 8px!important;
text-align: left!important;
}  

.quotation-table .table-heading { 
background-color: #4067B5!important; 
color: black!important;
}

</style>
</head>
<body>
<div class='container'>
<div class='header'>Financial Assistance Requirement</div>
<div class='content'>
    <p>Dear Sir,</p>
    <p>Here are the details of the person requesting finance assistance.</p>        
    <table class='quotation-table'>
        <tr>
            <th>Type</th>
            <th>Amount</th>
            <th>Contact Person</th>
            <th>Cell</th>
            <th>Notes</th>
        </tr>
        <tr>
            <td>$type</td>
            <td>$amount</td>
            <td>$contactperson</td>
            <td>$number</td>
            <td>$notes</td>
        </tr>
    </table>

    <p>Thank you,<br> FleetEIP Team<br> 9326178925</p>
</div>
<div class='footer'>
    <p>&copy; 2024 FleetEIP. All rights reserved.</p>
</div>
</div>
</body>
</html>";               

            $mail->send();
            $_SESSION['success'] = 'true'; // Set session success
            header("Location: financeassistance.php"); // Redirect after sending email
            exit(); // Exit after redirection to prevent further code execution
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        $_SESSION['error'] = 'true'; // Set session success
        header("Location: financeassistance.php"); // Redirect after sending email
        exit(); // Exit after redirection to prevent further code execution
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finance</title>
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="favicon.jpg" type="image/x-icon">
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
            <li><a href="logout.php">Log Out</a></li>
        </ul>
    </div>
</div>
<?php
if($showAlert){
    echo '<label>
    <input type="checkbox" class="alertCheckbox" autocomplete="off" />
    <div class="alert notice">
        <span class="alertClose">X</span>
        <span class="alertText">Request Submitted Successfully The Respective Team Will Contact You Soon<br class="clear"/>
        </span>
    </div>
    </label>';
}
if($showError){
    echo '<label>
    <input type="checkbox" class="alertCheckbox" autocomplete="off" />
    <div class="alert error">
        <span class="alertClose">X</span>
        <span class="alertText">Something Went Wrong<br class="clear"/></span>
    </div>
    </label>';
}

?>
<div class="fulllength" id="disclamer_finance">Fleet EIP is committed to safeguarding customer data and will not misuse it. Additionally, you will not receive unwanted calls regarding loan offers.</div>
<form action="financeassistance.php" method="POST" autocomplete="off" class="finance">
    <div class="financecontainer">
        <p class="headingpara">Finance</p>
        <div class="trial1">
            <select name="type" id="" class="input02" required>
                <option value=""disabled selected>Finance Assistance Type</option>
                <option value="Overdraft Loan-OD">Overdraft Loan-OD</option>
                <option value="Business Loan">Business Loan</option>
                <option value="Commercial Vehicle Loan">Commercial Vehicle Loan</option>
                <option value="Commercial Vehicle Refinance">Commercial Vehicle Refinance</option>
                <option value="Commercial Space Loan">Commercial Space Loan</option>
                <option value="Home Loan">Home Loan</option>
                <option value="Car Loan">Car Loan</option>
            </select>
        </div>
        <div class="trial1">
            <input type="text" placeholder="" name="amount"  class="input02" required>
            <label for="" class="placeholder2">Amount Required</label>
        </div>
        <div class="trial1">
            <input type="text" placeholder="" name="contactperson" class="input02" required>
            <label for="" class="placeholder2">Contact Person</label>
        </div>
        <div class="trial1">
            <input type="text" placeholder="" name="number" class="input02" required>
            <label for="" class="placeholder2">Contact Number</label>
        </div>
        <div class="trial1">
            <textarea class="input02" name="notes" id="" placeholder=""></textarea>
            <label for="" class="placeholder2">Notes</label>
        </div>
        <button class="epc-button">Submit</button>
    </div>
</form>
</body>
</html>