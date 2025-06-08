<?php
include "partials/_dbconnect.php";
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
} elseif ($enterprise === 'admin') {
    $dashboard_url = 'news/admin/dashboard.php';
}

$currentDate = new DateTime();
$showAlert = false;
$showError = false;
$hasLiveAuction = false; // Flag to check if there are any live auctions


if (isset($_SESSION['success'])) {
    $showAlert = true;
    unset($_SESSION['success']);
} else if (isset($_SESSION['error'])) {
    $showError = true;
    unset($_SESSION['error']);
}

date_default_timezone_set('Asia/Kolkata'); // Set timezone to India
$currentDateTime = new DateTime(); // Get current date and time
// echo $currentDateTime->format('Y-m-d H:i:s'); // Form

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auction</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="shortcut icon" href="favicon.jpg" type="image/x-icon">
    <script src="main.js"></script>
    <link rel="stylesheet" href="tiles.css">
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
?>

<div class="add_fleet_btn_new" id="rentalclientbutton">
    <button class="generate-btn">
        <article class="article-wrapper" onclick="window.location.href='createauction.php'" id="rentalclientbuttoncontainer">
            <div class="rounded-lg container-projectss"></div>
            <div class="project-info">
                <div class="flex-pr">
                    <div class="project-title text-nowrap">Create Auction</div>
                    <div class="project-hover">
                        <svg style="color: black;" xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" color="black" stroke-linejoin="round" stroke-linecap="round" viewBox="0 0 24 24" stroke-width="2" fill="none" stroke="currentColor">
                            <line y2="12" x2="19" y1="12" x1="5"></line>
                            <polyline points="12 5 19 12 12 19"></polyline>
                        </svg>
                    </div>
                </div>
            </div>
        </article>
    </button>


    <button class="generate-btn">
        <article class="article-wrapper" onclick="window.location.href='enrolledauction.php'" id="rentalclientbuttoncontainer">
            <div class="rounded-lg container-projectss"></div>
            <div class="project-info">
                <div class="flex-pr">
                    <div class="project-title text-nowrap">Enrolled Auction</div>
                    <div class="project-hover">
                        <svg style="color: black;" xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" color="black" stroke-linejoin="round" stroke-linecap="round" viewBox="0 0 24 24" stroke-width="2" fill="none" stroke="currentColor">
                            <line y2="12" x2="19" y1="12" x1="5"></line>
                            <polyline points="12 5 19 12 12 19"></polyline>
                        </svg>
                    </div>
                </div>
            </div>
        </article>
    </button>

</div>

<?php
include "partials/_dbconnect.php";
$myauction = "SELECT * FROM `auctiondetail` WHERE companyname='$companyname001'";
$result = mysqli_query($conn, $myauction);

if (mysqli_num_rows($result) > 0) {
?>
    <div class="myauctionheading"><h2>My Auction :</h2></div>
    <table class="quotation-table" id="myauctiontable">
        <th>Type</th>
        <th>Start</th>
        <th>End</th>
        <th>Description</th>
        <th>Price Description</th>
        <th>Action</th>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?php echo $row['auctiontype'] ?></td>
            <td><?php echo date('jS M y', strtotime($row['startdate'])) . ' | ' . $row['starttime']; ?></td>
            <td><?php echo date('jS M y', strtotime($row['enddate'])) . ' | ' . $row['endtime']; ?></td>
            <td class="todatacont"><?php echo $row['description'] ?></td>

            <?php if (!empty($row['baseprice']) && $row['baseprice'] != 0): ?>
                <td><?php echo 'Base Price: ' . htmlspecialchars(number_format($row['baseprice'], 2)); ?></td>
            <?php endif; ?>

            <?php if (!empty($row['maxprice']) && $row['maxprice'] != 0): ?>
                <td><?php echo 'Max Price: ' . htmlspecialchars(number_format($row['maxprice'], 2)); ?></td>
            <?php endif; ?>

            <td>
    <a href="editauction.php?id=<?php echo $row['id']; ?>" class="quotation-icon" title="Edit">
        <i style="width: 22px; height: 22px;" class="bi bi-pencil"></i>
    </a>
    <a href="deleteauction.php?id=<?php echo $row['id']; ?>" onclick="return confirmDelete();" class="quotation-icon" title="Delete">
        <i style="width: 22px; height: 22px;" class="bi bi-trash"></i>
    </a>
    <a href="viewauction.php?id=<?php echo $row['id']; ?>" class="quotation-icon" title="View Enrollment">
        <i style="width: 22px; height: 22px;" class="bi bi-eye"></i> <!-- "View" button -->
    </a>
</td>
        </tr>
        <?php } ?>
    </table>
<?php } ?>
 
<!-- live auction -->

<?php
// Query to get all auctions

$auctionQuery = "SELECT * FROM `auctiondetail` ORDER BY `id` DESC";
$auctionResult = mysqli_query($conn, $auctionQuery);

if (mysqli_num_rows($auctionResult) > 0) { ?>

<?php

echo '<table class="purchase_table" id="logi_rates"><tr>'; ?>
<div class="myauctionheading" id="upcomingauctionheading"><h2>Live Auction:</h2></div>
<?php


while ($row = mysqli_fetch_assoc($auctionResult)) {
    // Combine start date and time into a DateTime object
    $startDateTime = new DateTime($row['startdate'] . ' ' . $row['starttime']);
    // Combine end date and time into a DateTime object
    $endDateTime = new DateTime($row['enddate'] . ' ' . $row['endtime']);

    // Check if the auction is live (between start and end date/time)
    if ($currentDateTime >= $startDateTime && $currentDateTime <= $endDateTime) {
        $hasLiveAuction = true; // Set flag to true if there’s a live auction
        ?>
        <td>
            <div class="custom-card" id="application_card">
                <h3 class="custom-card__title" onclick="window.location.href='auctionbid.php?id=<?php echo htmlspecialchars($row['id']); ?>'">
                    Type: <?php echo htmlspecialchars($row['auctiontype']); ?>
                </h3>
                <p class="insidedetails">Start Date: <?php echo date('jS M y', strtotime($row['startdate'])); ?> | <?php echo htmlspecialchars($row['starttime']); ?></p>
                <p class="insidedetails">End Date: <?php echo date('jS M y', strtotime($row['enddate'])); ?> | <?php echo htmlspecialchars($row['endtime']); ?></p>
                <p class="insidedetails">Description: <?php echo htmlspecialchars($row['description']); ?></p>
                
                <?php if (!empty($row['baseprice']) && $row['baseprice'] != 0): ?>
                    <p class="insidedetails">Base Price: <?php echo htmlspecialchars(number_format($row['baseprice'], 2)); ?></p>
                <?php endif; ?>
    
                <?php if (!empty($row['maxprice']) && $row['maxprice'] != 0): ?>
                    <p class="insidedetails">Max Price: <?php echo htmlspecialchars(number_format($row['maxprice'], 2)); ?></p>
                <?php endif; ?>
                
                <div class="custom-card__arrow">
                    <i class="fas fa-arrow-right"></i>
                </div>
            </div>
        </td>
        <?php
    }
}}

// If no live auction was found, display a message
if (!$hasLiveAuction) {
    echo '<br><br><p class="fulllength">No Live Auction At The Moment</p>';
}

echo '</tr></table>'; // Close row and table
?>







<!-- Display Upcoming Auctions -->
<div class="myauctionheading" id="upcomingauctionheading"><h2>Upcoming Auction:</h2></div>

<?php
$upcomingAuctionQuery = "SELECT * 
    FROM `auctiondetail` 
    WHERE id NOT IN (
        SELECT auctionid 
        FROM `enrollinauction` 
        WHERE companyname = '$companyname001'
    ) 
    ORDER BY `id` DESC";
$upcomingResult = mysqli_query($conn, $upcomingAuctionQuery);

$hasUpcomingAuction = false; // Flag to track if any upcoming auctions exist within 7 days

if (mysqli_num_rows($upcomingResult) > 0) {
    echo '<table class="purchase_table" id="logi_rates"><tr>';

    while ($row = mysqli_fetch_assoc($upcomingResult)) {
        $startDate = new DateTime($row['startdate']);
        $difference = $currentDate->diff($startDate)->days;
        $isFuture = $startDate > $currentDate;

        // If the auction is in the future and within 7 days
        if ($isFuture && $difference < 7) {
            $hasUpcomingAuction = true; // Set flag to true if an auction meets the criteria
            ?>
            <td>
                <div class="custom-card" id="application_card">
                    <h3 class="custom-card__title" onclick="window.location.href='auctiondetail.php?id=<?php echo htmlspecialchars($row['id']); ?>'">
                        Type: <?php echo htmlspecialchars($row['auctiontype']); ?>
                    </h3>
                    <p class="insidedetails">Start Date: <?php echo date('jS M y', strtotime($row['startdate'])); ?> | <?php echo htmlspecialchars($row['starttime']); ?></p>
                    <p class="insidedetails">Description: <?php echo htmlspecialchars($row['description']); ?></p>
                    
                    <?php if (!empty($row['baseprice']) && $row['baseprice'] != 0): ?>
                        <p class="insidedetails">Base Price: <?php echo htmlspecialchars(number_format($row['baseprice'], 2)); ?></p>
                    <?php endif; ?>
        
                    <?php if (!empty($row['maxprice']) && $row['maxprice'] != 0): ?>
                        <p class="insidedetails">Max Price: <?php echo htmlspecialchars(number_format($row['maxprice'], 2)); ?></p>
                    <?php endif; ?>
                    
                    <div class="custom-card__arrow">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </div>
            </td>
            <?php
        }
    }

    echo '</tr></table>'; // Close row and table

    // If no upcoming auctions within 7 days were found, display a message
    if (!$hasUpcomingAuction) {
        echo '<br><br><p class="fulllength">No Upcoming Auction At The Moment</p><br><br>';
    }

} else {
    // If no rows were returned at all, display a message
    echo '<br><br><p class="fulllength">No Upcoming Auction At The Moment</p><br><br>';
}
?>
        
</body>
<script>
    function confirmDelete() {
        return confirm("Are you sure you want to delete?");
    }
</script>
</html>
