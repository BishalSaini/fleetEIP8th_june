<?php
include "partials/_dbconnect.php";
session_start();
$companyname001 = $_SESSION['companyname'];
$email = $_SESSION['email'];
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


// Fetch all enrolled auctions for the company
$sql = "SELECT * FROM `enrollinauction` WHERE companyname='$companyname001'";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enrolled Auctions</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <link rel="shortcut icon" href="favicon.jpg" type="image/x-icon">
</head>
<body>
<div class="navbar1">
    <div class="logo_fleet">
        <img src="logo_fe.png" alt="FLEET EIP" onclick="window.location.href='<?php echo $dashboard_url ?>'">
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

<?php if (mysqli_num_rows($result) > 0): ?>
    <div class="myauctionheading"><h2>Your Enrolled Auction :</h2></div>
    <table class="quotation-table" id="enrolledviewtable">
        <thead>
            <tr>
                <th>Auction Type</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Description</th>
                <th>Price</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = mysqli_fetch_assoc($result)):
                // Fetch auction details for each enrolled auction
                $auctionid = $row['auctionid'];
                $projectdetail = "SELECT * FROM `auctiondetail` WHERE id='$auctionid'";
                $resultproject = mysqli_query($conn, $projectdetail);
                $auctionDetails = mysqli_fetch_assoc($resultproject);
            ?>
                <tr>
                    <td><?php echo htmlspecialchars($auctionDetails['auctiontype']); ?></td>
                    <td><?php echo htmlspecialchars((new DateTime($auctionDetails['startdate'] . ' ' . $auctionDetails['starttime']))->format('d-m-Y') . ' | ' . (new DateTime($auctionDetails['startdate'] . ' ' . $auctionDetails['starttime']))->format('H:i')); ?></td>
<td><?php echo htmlspecialchars((new DateTime($auctionDetails['enddate'] . ' ' . $auctionDetails['endtime']))->format('d-m-Y') . ' | ' . (new DateTime($auctionDetails['enddate'] . ' ' . $auctionDetails['endtime']))->format('H:i')); ?></td>
                    <td><?php echo htmlspecialchars($auctionDetails['description']); ?></td>
                    <td><?php echo htmlspecialchars($auctionDetails['baseprice']); ?></td>
                    <td><?php echo htmlspecialchars($row['status']); ?></td>
                    <td>                       <a href="edit_quotation.php?quote_id=<?php echo $row['id']; ?>" class="quotation-icon" title="View">
                <i style="width: 22px; height: 22px;" class="bi bi-eye"></i>
            </a>
 <a href="deleteenrolled.php?id=<?php echo $row['id']; ?>" onclick="return confirmDelete();" class="quotation-icon" title="Delete">
                <i style="width: 22px; height: 22px;" class="bi bi-trash"></i>
            </a>
</td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
<?php else: ?>
    <p class="fulllength">No enrolled auctions found.</p>
<?php endif; ?>

</body>
<script>
    function confirmDelete() {
        return confirm("Are you sure you want to delete ?");
    }


</script>
</html>
