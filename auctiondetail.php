<?php
$id = $_GET['id'];
include "partials/_dbconnect.php";
session_start();
$companyname001 = $_SESSION['companyname'];
$enterprise = $_SESSION['enterprise'];
$email=$_SESSION['email'];

$dashboard_url = '';
if ($enterprise === 'rental') {
    $dashboard_url = 'rental_dashboard.php';
} elseif ($enterprise === 'logistics') {
    $dashboard_url = 'logisticsdashboard.php';
} elseif ($enterprise === 'epc') {
    $dashboard_url = 'epc_dashboard.php';
} elseif ($enterprise === 'admin') {
    $dashboard_url = 'news/admin/dashboard.php';
}

$currentDate = new DateTime();
$showAlert = false;
$showError = false;

if (isset($_SESSION['success'])) {
    $showAlert = true;
    unset($_SESSION['success']);
} elseif (isset($_SESSION['error'])) {
    $showError = true;
    unset($_SESSION['error']);
}

include "partials/_dbconnect.php"; // Ensure the database connection is included at the top

// Prepare to fetch auction details using prepared statements
$id = $_GET['id']; // Make sure $id is sanitized if coming from user input
$query = "SELECT * FROM `auctiondetail` WHERE id = $id";
$result = $conn->query($query);

if ($result) {
    $row = $result->fetch_assoc();
}

require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Capture POST data
    $companyname = $_POST['companyname'];
    $contact_person = $_POST['contact_person'];
    $email = $_POST['email'];
    $cell = $_POST['cell'];
    $auctionid = $_POST['auctionid'];
    $auctionowner = $_POST['auctionowner'];
    $auctionownercompany = $_POST['auctionownercompany'];

    $auctiontype = $_POST['auctiontype'];
    $starttime = $_POST['starttime'];
    $endtime = $_POST['endtime'];
    $startdate = $_POST['startdate'];
    $enddate = $_POST['enddate'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $status = 'Pending'; // Set the status

    // Execute the insert statement
    $sql = "INSERT INTO `enrollinauction` (status, auctionid, companyname, contactperson, contactemail, cell, auctionowner) 
            VALUES ('$status', '$auctionid', '$companyname', '$contact_person', '$email', '$cell', '$auctionowner')";

    if (mysqli_query($conn, $sql)) {
        // Prepare email to the auction owner
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'smtp.hostinger.com';                   // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'support@fleeteip.com';                 // SMTP username
            $mail->Password   = 'fleetEIP@0807';                        // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            // Enable implicit TLS encryption
            $mail->Port       = 465;                                    // TCP port to connect to

            // Email to the auction owner
            $mail->setFrom('support@fleeteip.com', 'FleetEIP');
            $mail->addAddress($auctionowner);  

            // Prepare the email content
            $mail->isHTML(true);
            $mail->Subject = 'Auction Enrollment Request Received';
            $mail->Body = "
<html>
<head>
<style>
body {font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; line-height: 1.6; background-color: #f9f9f9; margin: 0; padding: 0;}
.container {width: 100%; max-width: 600px; margin: 20px auto; background-color: #ffffff; border-radius: 8px; box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;}
.header {background-color: #253C6A; color: white; padding: 15px; text-align: center; font-size: 24px;}
.content p {font-size: 16px; color: #333;}
.footer {text-align: center; font-size: 12px; color: #888; margin-top: 20px;}
.quotation-table {width: 100%; font-size: 13px; border-collapse: collapse; margin-top: 20px; margin: 0 auto; padding: 10px;}
.quotation-table, .quotation-table th, .quotation-table td {border: 1px solid black!important; margin-top: 30px;}
.quotation-table th, .quotation-table td {padding: 8px!important; text-align: left!important;}
.quotation-table .table-heading { background-color: #4067B5!important; color: black!important; }
</style>
</head>
<body>
<div class='container'>
<div class='header'>Auction Enrollment Request </div>
<div class='content'>
    <p>Dear $auctionownercompany,</p>
    <p>This is with reference to your below auction.</p>        
    <table class='quotation-table'>
        <tr>
            <th>Type</th>
            <th>Start At</th>
            <th>End At</th>
            <th>Description</th>
            <th>Price Detail</th>
        </tr>
        <tr>
            <td>$auctiontype</td>
            <td>$startdate | $starttime</td>
            <td>$enddate | $endtime</td>
            <td>$description</td>
            <td>$price</td>
        </tr>
    </table>
    <p>You have received an enrollment request for the above-mentioned auction. The details of the enrollment request are as follows:-</p>
    <p><strong>Rental Company:</strong> $companyname</p>
    <p><strong>Contact Person:</strong> $contact_person</p>
    <p><strong>Email:</strong> $email</p>
    <p><strong>Contact:</strong> $cell - $email</p>
    <br>
    <p>For accepting the enrollment request kindly login to your Fleet EIP account.</p>
    <p>Thank you,<br> FleetEIP Team<br> 9326178925</p>
</div>
<div class='footer'>
    <p>&copy; 2024 FleetEIP. All rights reserved.</p>
</div>
</div>
</body>
</html>";

            // Send the email
            $mail->send();
            $_SESSION['success'] = 'Enrollment successful!';
        } catch (Exception $e) {
            // Handle email sending errors
            $_SESSION['error'] = 'Failed to send email: ' . $mail->ErrorInfo;
        }
    } else {
        $_SESSION['error'] = 'Enrollment failed. Please try again.';
    }

    // Redirect to the auction page
    header("Location: auction.php");
    exit; // Always exit after header redirection
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auction Detail</title>
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="favicon.jpg" type="image/x-icon">
</head>
<body>
<div class="navbar1">
    <div class="logo_fleet">
        <img src="logo_fe.png" alt="FLEET EIP" onclick="window.location.href='<?php echo $dashboard_url; ?>'">
    </div>
    <div class="iconcontainer">
        <ul>
            <li><a href="<?php echo $dashboard_url; ?>">Dashboard</a></li>
            <li><a href="logout.php">Log Out</a></li>
        </ul>
    </div>
</div>

<div class="tripinfo">
    <div class="tripinfocontainer">
        <div class="trip1">
            <p class="trip_details"><strong>Auction Type :</strong> <?php echo htmlspecialchars($row['auctiontype']); ?></p>
            <p class="trip_details"><strong>Start Date :</strong> <?php echo date('d-m-Y', strtotime($row['startdate'])); ?></p>
            <p class="trip_details"><strong>End Date :</strong> <?php echo date('d-m-Y', strtotime($row['enddate'])); ?></p>
            <p class="trip_details"><strong>Description :</strong> <?php echo htmlspecialchars($row['description']); ?></p>
            <p class="trip_details <?php if (empty($row['baseprice']) || $row['baseprice'] == 0) { echo 'hideit'; } ?>">
                <strong>Base Price:</strong> <?php echo htmlspecialchars(number_format($row['baseprice'], 2)); ?>
            </p>
            <p class="trip_details <?php if (empty($row['maxprice']) || $row['maxprice'] == 0) { echo 'hideit'; } ?>">
                <strong>Max Price:</strong> <?php echo htmlspecialchars(number_format($row['maxprice'], 2)); ?>
            </p>
            <br>
        </div>
    </div>
    <div class="tripbutton">
    <button onclick="#" class="tripupdate_generatecn">
        Enroll Into Auction
    </button>
</div>

</div>

    <form action="auctiondetail.php" method="POST" autocomplete="off" class="outerform">
        <div class="enrollauction">
            <p class="headingpara">Enroll </p>
            <input type="hidden" name="auctionid" value="<?php echo $id ?>">
            <input type="hidden" name="auctionowner" value="<?php echo $row['created_by'] ?>">
            <input type="hidden" name="auctionownercompany" value="<?php echo $row['companyname'] ?>">
            <input type="hidden" name="auctiontype" value="<?php echo htmlspecialchars($row['auctiontype']); ?>">
            <input type="hidden" name="starttime" value="<?php echo htmlspecialchars($row['starttime']); ?>">
            <input type="hidden" name="endtime" value="<?php echo htmlspecialchars($row['endtime']); ?>">
            <input type="hidden" name="startdate" value="<?php echo htmlspecialchars(date('d-m-Y', strtotime($row['startdate']))); ?>">
<input type="hidden" name="enddate" value="<?php echo htmlspecialchars(date('d-m-Y', strtotime($row['enddate']))); ?>">
            <input type="hidden" name="description" value="<?php echo htmlspecialchars($row['description']); ?>">
            <input type="hidden" name="price" value="<?php echo htmlspecialchars(!empty($row['baseprice']) && $row['baseprice'] != 0 ? $row['baseprice'] : (!empty($row['maxprice']) && $row['maxprice'] != 0 ? $row['maxprice'] : '')); ?>">
            <div class="trial1">
                <input type="text" placeholder="" value="<?php echo $companyname001; ?>" name="companyname" class="input02">
                <label for="" class="placeholder2">Company Name</label>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" name="contact_person" class="input02">
                <label for="" class="placeholder2">Contact Person</label>
            </div>
            <div class="outer02">
                <div class="trial1">
                <input type="text" placeholder="" value="<?php echo $email; ?>" name="email" class="input02">
                <label for="" class="placeholder2">Email</label>
                </div>
                <div class="trial1">
                <input type="text" placeholder="" name="cell" class="input02">
                <label for="" class="placeholder2">Cell</label>

                </div>

            </div>
            <button class="epc-button">Submit</button>
        </div>
    </form>
</div>

</body>
</html>
