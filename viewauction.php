<?php 
$id = $_GET['id'];
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

$showAlert = false;
$showError = false;

if (isset($_SESSION['success'])) {
    $showAlert = true;
    unset($_SESSION['success']);
} else if (isset($_SESSION['error'])) {
    $showError = true;
    unset($_SESSION['error']);
}

$sql = "SELECT * FROM `auctiondetail` WHERE id=$id";
$result = mysqli_query($conn, $sql);
$auctionRow = mysqli_fetch_assoc($result); // Rename this row to avoid conflict
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Auction</title>
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

<div class="tripinfo">
    <div class="tripinfocontainer">
        <div class="trip1">
            <p class="trip_details"><strong>Auction Type :</strong> <?php echo htmlspecialchars($auctionRow['auctiontype']); ?></p>
            <p class="trip_details"><strong>Start Date :</strong> <?php echo date('d-m-Y', strtotime($auctionRow['startdate'])); ?></p>
            <p class="trip_details"><strong>End Date :</strong> <?php echo date('d-m-Y', strtotime($auctionRow['enddate'])); ?></p>
            <p class="trip_details"><strong>Description :</strong> <?php echo htmlspecialchars($auctionRow['description']); ?></p>
            <p class="trip_details <?php if (empty($auctionRow['baseprice']) || $auctionRow['baseprice'] == 0) { echo 'hideit'; } ?>">
                <strong>Base Price:</strong> <?php echo htmlspecialchars(number_format($auctionRow['baseprice'], 2)); ?>
            </p>
            <p class="trip_details <?php if (empty($auctionRow['maxprice']) || $auctionRow['maxprice'] == 0) { echo 'hideit'; } ?>">
                <strong>Max Price:</strong> <?php echo htmlspecialchars(number_format($auctionRow['maxprice'], 2)); ?>
            </p>
            <br>
        </div>
    </div>
</div>

<?php
$myauction = "SELECT * FROM `enrollinauction` WHERE auctionid=$id";
$result = mysqli_query($conn, $myauction);

if (mysqli_num_rows($result) > 0) {
?>
    <div class="myauctionheading"><h2>My Auction :</h2></div>
    <table class="quotation-table" id="myauctiontable">
        <th>Company Name</th>
        <th>Contact Person</th>
        <th>Email</th>
        <th>Cell</th>
        <th>Status</th>
        <th>Action</th>
        <?php while ($enrollmentRow = mysqli_fetch_assoc($result)) { // Use $enrollmentRow instead ?>
        <tr>
            <td><?php echo $enrollmentRow['companyname'] ?></td>
            <td><?php echo $enrollmentRow['contactperson'] ?></td>
            <td><?php echo $enrollmentRow['contactemail'] ?></td>
            <td><?php echo $enrollmentRow['cell'] ?></td>
            <td><?php echo $enrollmentRow['status'] ?></td>
            <td>
                <a href="approveauctionentry.php?id=<?php echo $enrollmentRow['id']; ?>" class="quotation-icon" onclick="return confirmapprove();" title="Approve Enrollment">
                    <i style="width: 22px; height: 22px;" class="bi bi-check-circle"></i>
                </a>
                <a href="rejectauctionentry.php?id=<?php echo $enrollmentRow['id']; ?>" class="quotation-icon" onclick="return confirmreject();" title="Reject Enrollment">
                <i style="width: 22px; height: 22px;" class="bi bi-x-circle"></i>
                </a>
            </td>
        </tr>
        <?php } ?>
    </table>
<?php } else { ?>
    <p class="fulllength">No enrollment as of now</p>
<?php } ?>
</body>
<script>
    function confirmapprove() {
        return confirm("Are you sure you want to approve the following enrollment ?");
    }

    function confirmreject() {
        return confirm("Are you sure you want to reject the following enrollment ?");
    }


</script>
</html>
