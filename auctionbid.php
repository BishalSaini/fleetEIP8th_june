<?php
$id = $_GET['id'];
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;



include "partials/_dbconnect.php";
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$companyname001 = $_SESSION['companyname'];
$enterprise = $_SESSION['enterprise'];
$email = $_SESSION['email'];

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

$baseerror = false;
$maxerror = false;
$currentranknumber="";

if (isset($_SESSION['success'])) {
    $showAlert = true;
    unset($_SESSION['success']);
} elseif (isset($_SESSION['error'])) {
    $showError = true;
    unset($_SESSION['error']);
}

$sql = "SELECT * FROM `auctiondetail` WHERE id=$id";
$result = mysqli_query($conn, $sql);
$auctionRow = mysqli_fetch_assoc($result);

$approved = "SELECT * FROM `enrollinauction` WHERE auctionid = $id AND companyname = '$companyname001' AND status = 'Approved'";
$resultapproved = mysqli_query($conn, $approved);

// Check if the form has been submitted via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['bidsubmit'])) {
    // Collect form data
    $bidAmount = $_POST['bid'];
    $auctionidnumber = $_POST['auctionidnumber'];

    // Fetch auction details to validate bid amount
    $auctionSql = "SELECT * FROM auctiondetail WHERE id = '$auctionidnumber'";
    $auctionResult = mysqli_query($conn, $auctionSql);
    $auctionRow = mysqli_fetch_assoc($auctionResult);

    // Validate bid amount
    if ($auctionRow['baseprice'] > $bidAmount) {
        $baseerror = true;
        $bidError = 'Bid amount must be greater than or equal to the base price.';
    } elseif (!empty($auctionRow['maxprice']) && $auctionRow['maxprice'] < $bidAmount) {
        $maxerror = true;
        $bidError = 'Bid amount must be less than or equal to the maximum price.';
    } else {
        // Step 1: Insert the new bid into the database
        $insertBidSql = "INSERT INTO `bids` (`amount`, `auctionid`, `companyname`, `time`, `date`) 
                         VALUES ('$bidAmount', '$auctionidnumber', '$companyname001', NOW(), CURDATE())";
        
        if (mysqli_query($conn, $insertBidSql)) {
            // Step 2: Update the ranks after inserting the bid
            updateRanks($conn, $auctionidnumber);

            // Set success message
            $_SESSION['success'] = 'true';
        } else {
            // Set error message
            $_SESSION['error'] = 'true';
        }
        // Redirect back to the auction bid page
        header("Location: auctionbid.php?id=" . urlencode($auctionidnumber));
        exit;
    }
}

// Function to update ranks based on bid amounts
function updateRanks($conn, $auctionidnumber) {
    // Fetch all bids for the auction ordered by amount (ascending)
    $selectBidsSql = "SELECT id, companyname, amount FROM bids WHERE auctionid = '$auctionidnumber' ORDER BY amount ASC";
    $result = mysqli_query($conn, $selectBidsSql);
    
    if ($result) {
        // Initialize rank variable
        $rank = 1;

        // Loop through the sorted bids and update their rank
        while ($row = mysqli_fetch_assoc($result)) {
            $bidId = $row['id'];
            
            // Update the rank for this bid in the database
            $updateRankSql = "UPDATE bids SET rank = $rank WHERE id = '$bidId'";
            if (mysqli_query($conn, $updateRankSql)) {
                // Optionally, you can log each rank update (this is just for debugging)
                // echo "Rank updated for Company: " . $row['companyname'] . " with Bid Amount: " . $row['amount'] . " - Rank: $rank<br>";
            } else {
                // Log any errors when updating the rank
                echo "Error updating rank for Bid ID: $bidId - " . mysqli_error($conn) . "<br>";
            }

            // Increment the rank for the next bid
            $rank++;
        }
    } else {
        echo "Error fetching bids: " . mysqli_error($conn);
    }
}

$prebid = "SELECT * FROM `bids` WHERE auctionid=$id AND companyname='$companyname001'";
$resultbid = mysqli_query($conn, $prebid);

// if (mysqli_num_rows($resultbid) > 0) {
//     $userCompanyRank = "
//         SELECT companyname,
//                amount,
//                ROW_NUMBER() OVER (ORDER BY amount ASC) AS rank
//         FROM bids
//         WHERE auctionid = $id
//         HAVING companyname = '$companyname001'
//     ";
//     $resultUserRank = mysqli_query($conn, $userCompanyRank);
//     $rowrank = mysqli_fetch_assoc($resultUserRank);
// }


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['enrollsubmit'])) {
    // Capture POST data for enrollment
    $companyname = $_POST['companyname'];
    $contact_person = $_POST['contact_person'];
    $email = $_POST['email'];
    $cell = $_POST['cell'];
    $auctionid = $_POST['auctionid'];
    $auctionowner = $_POST['auctionowner'];
    $auctionownercompany = $_POST['auctionownercompany'];

    // Insert enrollment data into the database
    $sql = "INSERT INTO `enrollinauction` (status, auctionid, companyname, contactperson, contactemail, cell, auctionowner) 
            VALUES ('Pending', '$auctionid', '$companyname', '$contact_person', '$email', '$cell', '$auctionowner')";

    if (mysqli_query($conn, $sql)) {
        // Prepare email to auction owner
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
            $mail->addAddress($auctionowner);

            // Prepare the email content
            $mail->isHTML(true);
            $mail->Subject = 'Auction Enrollment Request Received';
            $mail->Body = "
<html>
<head>
<style>
body {font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; line-height: 1.6; background-color: #f9f9f9;}
.container {width: 100%; max-width: 600px; margin: 20px auto; background-color: #ffffff; border-radius: 8px; box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;}
.header {background-color: #253C6A; color: white; padding: 15px; text-align: center; font-size: 24px;}
.content p {font-size: 16px; color: #333;}
.footer {text-align: center; font-size: 12px; color: #888; margin-top: 20px;}
.quotation-table {width: 100%; font-size: 13px; border-collapse: collapse; margin-top: 20px;}
.quotation-table, .quotation-table th, .quotation-table td {border: 1px solid black; padding: 8px; text-align: left;}
.quotation-table th {background-color: #4067B5; color: black;}
</style>
</head>
<body>
<div class='container'>
<div class='header'>Auction Enrollment Request</div>
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
            <td>{$auctionRow['auctiontype']}</td>
            <td>{$auctionRow['startdate']} | {$auctionRow['starttime']}</td>
            <td>{$auctionRow['enddate']} | {$auctionRow['endtime']}</td>
            <td>{$auctionRow['description']}</td>
            <td>{$auctionRow['baseprice']}</td>
        </tr>
    </table>
    <p>You have received an enrollment request for the above-mentioned auction. The details of the enrollment request are as follows:</p>
    <p><strong>Rental Company:</strong> $companyname</p>
    <p><strong>Contact Person:</strong> $contact_person</p>
    <p><strong>Email:</strong> $email</p>
    <p><strong>Contact:</strong> $cell</p>
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
            $_SESSION['error'] = 'Failed to send email: ' . $mail->ErrorInfo;
        }
    } else {
        $_SESSION['error'] = 'Enrollment failed. Please try again.';
    }

    header("Location: auction.php");
    exit;
}
?>

<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
        <script src="main.js"></script>
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js"></script>
        <link rel="shortcut icon" href="favicon.jpg" type="image/x-icon">
        <title>Bidding</title>
    </head>
    <body>
    <div class="navbar1">
        <div class="logo_fleet">
            <img src="logo_fe.png" alt="FLEET EIP" onclick="window.location.href='<?php echo $dashboard_url  ?>'">
        </div>
        <div class="iconcontainer">
            <ul>
                <li><a href="<?php echo $dashboard_url ?>">Dashboard</a></li>
                <li><a href="logout.php">Log Out</a></li>
            </ul>
        </div>
    </div>
    <?php
    if ($showAlert) {
        echo '<label><input type="checkbox" class="alertCheckbox" autocomplete="off" />
        <div class="alert notice"><span class="alertClose">X</span><span class="alertText">Success<br class="clear"/></span></div></label>';
    }
    if ($showError) {
        echo '<label><input type="checkbox" class="alertCheckbox" autocomplete="off" />
        <div class="alert error"><span class="alertClose">X</span><span class="alertText">Something Went Wrong<br class="clear"/></span></div></label>';
    }
    if ($baseerror) {
        echo '<label><input type="checkbox" class="alertCheckbox" autocomplete="off" />
        <div class="alert error"><span class="alertClose">X</span><span class="alertText">Bid amount must be greater than or equal to the base price.<br class="clear"/></span></div></label>';
    }
    if ($maxerror) {
        echo '<label><input type="checkbox" class="alertCheckbox" autocomplete="off" />
        <div class="alert error"><span class="alertClose">X</span><span class="alertText">Bid amount must be less than or equal to the maximum price.<br class="clear"/></span></div></label>';
    }

    $participant = "SELECT COUNT(companyname) AS total FROM `enrollinauction` WHERE auctionid = $id";
    $count = mysqli_query($conn, $participant);

    $row = mysqli_fetch_assoc($count);
    $totalParticipants = $row['total'];



    $participant = "SELECT COUNT(companyname) AS total FROM `enrollinauction` WHERE auctionid = $id";
    $count = mysqli_query($conn, $participant);
    $row = mysqli_fetch_assoc($count);
    $totalParticipants = $row['total'];

    ?>
        


    <div class="tripinfo">
        <div class="tripinfocontainer">
            <div class="trip1">
                <p class="trip_details" id="spaceinbetweenpara">
                    <span><strong>Auction Type :</strong> <?php echo htmlspecialchars($auctionRow['auctiontype']); ?></span>
                    <span><strong>Total Approved Auction Participant : </strong><?php echo $totalParticipants; ?>&nbsp;&nbsp;&nbsp;</span>
                </p>
                <p class="trip_details"><strong>Start Date :</strong> <?php echo date('d-m-Y', strtotime($auctionRow['startdate'])); ?></p>
                <p class="trip_details"><strong>End Date :</strong> <?php echo date('d-m-Y', strtotime($auctionRow['enddate'])); ?></p>
                <p class="trip_details"><strong>Description :</strong> <?php echo htmlspecialchars($auctionRow['description']); ?></p>
                <p class="trip_details <?php if (empty($auctionRow['baseprice']) || $auctionRow['baseprice'] == 0) { echo 'hideit'; } ?>">
                    <strong>Base Price:</strong> <?php echo htmlspecialchars(number_format($auctionRow['baseprice'], 2)); ?>
                </p>
                <p class="trip_details <?php if (empty($auctionRow['maxprice']) || $auctionRow['maxprice'] == 0) { echo 'hideit'; } ?>">
                    <strong>Max Price:</strong> <?php echo htmlspecialchars(number_format($auctionRow['maxprice'], 2)); ?>
                </p>
                <div class="tripbutton">
                <br>

                <button 
    onclick="showcurrentenrollmentform()" 
    class="tripupdate_generatecn" 
    <?php if(mysqli_num_rows($resultapproved) > 0) { echo 'style="display: none;"'; } ?>>
    Enroll Into Auction
</button>
</div>
<br>
            </div>
        </div>
    </div></div> 
    <form action="auctionbid.php?id=<?php echo $id; ?>" method="POST" autocomplete="off" id="currentenrollmentform" class="outerform">
        <div class="enrollauction">
            <p class="headingpara">Enroll </p>
            <input type="hidden" id="auctionid" name="auctionid" value="<?php echo $id ?>">
            <input type="hidden" name="auctionowner" value="<?php echo $auctionRow['created_by'] ?>">
            <input type="hidden" name="auctionownercompany" value="<?php echo $auctionRow['companyname'] ?>">
            <input type="hidden" name="auctiontype" value="<?php echo htmlspecialchars($auctionRow['auctiontype']); ?>">
            <input type="hidden" name="starttime" value="<?php echo htmlspecialchars($auctionRow['starttime']); ?>">
            <input type="hidden" name="endtime" value="<?php echo htmlspecialchars($auctionRow['endtime']); ?>">
            <input type="hidden" name="startdate" value="<?php echo htmlspecialchars(date('d-m-Y', strtotime($auctionRow['startdate']))); ?>">
<input type="hidden" name="enddate" value="<?php echo htmlspecialchars(date('d-m-Y', strtotime($auctionRow['enddate']))); ?>">
            <input type="hidden" name="description" value="<?php echo htmlspecialchars($auctionRow['description']); ?>">
            <input type="hidden" name="price" value="<?php echo htmlspecialchars(!empty($auctionRow['baseprice']) && $auctionRow['baseprice'] != 0 ? $auctionRow['baseprice'] : (!empty($auctionRow['maxprice']) && $auctionRow['maxprice'] != 0 ? $auctionRow['maxprice'] : '')); ?>">
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
            <button class="epc-button" name="enrollsubmit" type="submit">Submit</button>
        </div>
    </form>

    <?php if(mysqli_num_rows($resultapproved)>0){  
                $currentrank="SELECT rank FROM `bids` where companyname='$companyname001' and auctionid=$id order by id desc limit 1";
                $resultcurrentrank=mysqli_query($conn,$currentrank);
                if(mysqli_num_rows($resultcurrentrank)>0){
                    $crntrank=mysqli_fetch_assoc($resultcurrentrank);
                    $currentranknumber=$crntrank['rank'];
                }

        ?>
    <!-- Bidding Form -->
    <form method="POST" action="auctionbid.php?id=<?php echo $id; ?>" autocomplete="off" class="outerform">
            <div class="biddingform">
                <input type="hidden" name="auctionidnumber" value="<?php echo $id; ?>">
            <div class="trial1">
                <input type="text" placeholder="" name="bid" class="input02">
                <label for="" class="placeholder2">Enter Your Bid Amount</label>
            </div>
            <div class="tripbutton"  id="submitbidbutton">
        <button type="submit" name="bidsubmit" class="tripupdate_generatecn">
            Submit Bid
        </button>
        <div>

            </div>
        </form>   

    <?php } 
    else{
        echo '<br><br><p class="fulllength">You Are Not Allowed To Bid Either The Auction Owner Didnt Allowed You Or You Didnt Enrolled In The Auction</p><br>';
    }
    ?>
    </div>
    </div>
    <?php 
$prebid = "SELECT * FROM `bids` WHERE auctionid=$id AND companyname='$companyname001'";
$resultbid = mysqli_query($conn, $prebid);
    ?>
    <div class="bidhistory" id="previoudbidtableinfo">
    <!-- <p class="terms_condition <?php if (empty($auctionRow['maxprice']) || $auctionRow['maxprice'] == 0) { echo 'hideit'; } ?>">Current Lowest Bid : <?php echo $lowestbidamount ?></p>
    <p class="terms_condition <?php if (empty($auctionRow['baseprice']) || $auctionRow['baseprice'] == 0) { echo 'hideit'; } ?>">Current Highest Bid : <?php echo $highestbidamount ?></p>
 -->
 <p>Current rank: <span id="current-rank">L<?php echo $currentranknumber; ?></span></p>
        <div class="previousbidhead"> <?php echo ucwords( $companyname001) ?>`s Previous Bid :</div>

        <table class="quotation-table" id="mybidtable" >
            <th>SR No</th>
            <!-- <th>Date</th> -->
            <th>Time</th>
            <th>Bid Price</th>
            
            <?php
                        $sr="1";

            while($rowbid=mysqli_fetch_assoc($resultbid)){
                ?>
                <tr>
                    <td><?php echo $sr; ?></td>
                    <!-- <td><?php echo date('jS M y', strtotime($rowbid['date'])); ?></td> -->
                    <td><?php echo date('H:i:s', strtotime($rowbid['time'])) ?></td>
                    <td><?php echo $rowbid['amount'] ?></td>
                </tr>
        <?php 
        $sr++;
        } ?>
        </table>
    </div>

    </body>
    <script>
document.addEventListener("DOMContentLoaded", function() {
    // Function to fetch the current rank
    function fetchRank() {
        const companyname = "<?php echo $companyname001; ?>";
        const auctionid = "<?php echo $id; ?>";

        fetch(`getRank.php?companyname=${companyname}&auctionid=${auctionid}`)
            .then(response => response.json())
            .then(data => {
                // Check that the rank element exists
                const rankElement = document.getElementById("current-rank");
                if (rankElement) {
                    rankElement.textContent = "L" + data.rank;
                } else {
                    console.error("Element with ID 'current-rank' not found.");
                }
            })
            .catch(error => console.error('Error fetching rank:', error));
    }

    // Call fetchRank every 5 seconds
    setInterval(fetchRank, 5000); // Adjust the interval as needed
});    </script>
</html>
