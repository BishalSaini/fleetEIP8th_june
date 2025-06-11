<?php
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

include "partials/_dbconnect.php";
// Only fetch vendors for the current company
$sql = "SELECT * FROM `vendors` WHERE companyname = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $companyname001);
$stmt->execute();
$result = $stmt->get_result();

// Group vendors by category
$vendors_by_category = [];
while ($row = $result->fetch_assoc()) {
    $category = $row['vendor_category'];
    if (!isset($vendors_by_category[$category])) {
        $vendors_by_category[$category] = [];
    }
    $vendors_by_category[$category][] = $row;
}
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="shortcut icon" href="favicon.jpg" type="image/x-icon">
    <title>View Vendors</title>
    <style>
        .purchase_table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .purchase_table th, .purchase_table td {
            padding: 8px;
        }
        .purchase_table th {
            background-color: #f2f2f2;
        }
        .custom-card {
            border: 1px solid #ddd;
            padding: 10px;
            margin: 10px 0;
            text-align: center;
        }
        .custom-card__title {
            font-size: 1.2em;
            margin: 0;
        }
        .custom-card__arrow i {
            font-size: 1.2em;
        }
    </style>
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
// Flatten all vendors into a single array for card display
$all_vendors = [];
foreach ($vendors_by_category as $category => $vendors) {
    foreach ($vendors as $row) {
        $all_vendors[] = $row;
    }
}

if (count($all_vendors) > 0) { ?>
<div class="fulllength"><h3 id="myclientheading">Vendors</h3></div>
<?php
    echo '<table class="purchase_table" id="job_posting">';
    echo '<tr>'; // Start the first row

    $loop_count = 0; // Initialize the counter

    foreach ($all_vendors as $row) {
        $id = $row['id'];

        if ($loop_count > 0 && $loop_count % 4 == 0) {
            echo '</tr><tr>'; // Close the current row and start a new one
        }

        echo '<td>
        <a href="vendorRegionalOffice.php?id=' . urlencode($id) . '" class="custom-card-link">
            <div class="custom-card" id="requirement_club">
                <h3 class="custom-card__title">' . htmlspecialchars($row['vendor_name']) . '</h3>
                <p class="insidedetails">Category: ' . htmlspecialchars($row['vendor_category']) . '</p>
                <p class="insidedetails">Code: ' . htmlspecialchars($row['vendor_code']) . '</p>
                <p class="insidedetails">Address: ' . htmlspecialchars($row['office_address']) . '</p>
                <div class="custom-card__arrow">
                    <i class="fas fa-arrow-right"></i>
                </div>
            </div>
        </a>
    </td>';
        $loop_count++;
    }

    echo '</tr>'; // Close the last row
    echo '</table>';
} else {
    echo '<p class="norecord"> Added Vendors Will Be Displayed Here</p>';
}
?>
<br>

</body>
</html>
