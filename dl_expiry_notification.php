<?php
include_once 'partials/_dbconnect.php'; // Include the database connection file
// session_start();
$companyname001 = $_SESSION['companyname'];
$enterprise=$_SESSION['enterprise'];
$dashboard_url = '';
if ($enterprise === 'rental') {
    $dashboard_url = 'rental_dashboard.php';
} elseif ($enterprise === 'logistics') {
    $dashboard_url = 'logisticsdashboard.php';
} 
elseif ($enterprise === 'epc') {
    $dashboard_url = 'epc_dashboard.php';
} 
else {
    $dashboard_url = '';
}

$sql = "SELECT * FROM myoperators WHERE company_name='$companyname001'";
$result = mysqli_query($conn, $sql);

$notificationThreshold = 7; // Threshold for notification (e.g., 7 days before expiry)

while ($row = mysqli_fetch_assoc($result)) {

    $expiryDate = strtotime($row['dl_expiry']);
    $currentDate = time();
    $daysUntilExpiry = floor(($expiryDate - $currentDate) / (60 * 60 * 24));

    // Check if expiry is near
    if ($daysUntilExpiry <= $notificationThreshold) {
        // echo "Expiry Date of Asset Code " . $row['assetcode'] . " is Near: $daysUntilExpiry days left<br>";
        include_once 'partials/_dbconnect.php'; // Include the database connection file
        if(!empty($row['dl_expiry'])){
        $sql_expiry_notification="INSERT  INTO `dl_expiry` (`driver_name`,`dl`, `expiry_date`,
         `days_left`,`company_name`)
         VALUES ('". $row['operator_fname'] ."', '". $row['driving_license'] ."','". $row['dl_expiry'] ."','$daysUntilExpiry','". $row['company_name'] ."')";
        $result_notification=mysqli_query($conn,$sql_expiry_notification);
    }}
    
}

