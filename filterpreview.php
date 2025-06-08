<?php
session_start();
$email = $_SESSION['email'];
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.4/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="shortcut icon" href="favicon.jpg" type="image/x-icon">
    <title>Fleet</title>
</head>
<body>
<div class="navbar1">
    <!-- Navbar section -->
    <div class="logo_fleet">
        <!-- Logo with a link to the dashboard -->
        <img src="logo_fe.png" alt="FLEET EIP" onclick="window.location.href='<?php echo $dashboard_url ?>'">
    </div>
    <div class="iconcontainer">
        <!-- Navigation links -->
        <ul>
            <li><a href="<?php echo $dashboard_url ?>">Dashboard</a></li>
            <li><a href="news/">News</a></li>
            <li><a href="logout.php">Log Out</a></li>
        </ul>
    </div>
</div>
<div class="filters">
    <p>Apply Filter :</p>
    <form action="filterpreview.php" method="GET">
        <select name="filtertype" id="filterselect" class="filter_button" required>
            <option value="" disabled selected>Select Filter</option>
            <option value="Idle">Idle Equipment</option>
            <option value="Working">Working Equipment</option>
        </select>
        <button  class="filter_button" id="submitfilter">Submit</button>
    </form>
</div>

<table class="members_table" id="members_tablecontent1">
<?php
include "partials/_dbconnect.php";

$filtertype = isset($_GET['filtertype']) ? mysqli_real_escape_string($conn, $_GET['filtertype']) : '';
$companyname001 = mysqli_real_escape_string($conn, $companyname001); // Assuming $companyname001 is defined

$query = "SELECT * FROM fleet1 WHERE companyname='$companyname001'";
if ($filtertype) {
    $query .= " AND status='$filtertype'";
}
$result_filter = mysqli_query($conn, $query);

$loop_count_filter = 0;
echo '<tr>'; // Start with the first row

// Short form mapping for categories
$categoryShortForms = array(
    'Aerial Work Platform' => 'AWP',
    'Concrete Equipment' => 'CE',
    'Earthmover' => 'EM',
    'Road Equipment' => 'RE',
    'Material Handling Equipment' => 'MHE',
    'Ground Engineering Equipment' => 'GEE',
    'Trailor and Truck' => 'T&T',
    'Generator and Lighting' => 'GL'
);

while ($rowfilter = mysqli_fetch_assoc($result_filter)) {
    // Start a new row if the count is a multiple of 4
    if ($loop_count_filter > 0 && $loop_count_filter % 4 == 0) {
        echo '</tr><tr>';
    }

    // Get category and short form
    $category = $rowfilter['category']; // Adjust the field name if different
    $categoryShortForm = isset($categoryShortForms[$category]) ? $categoryShortForms[$category] : '';

    echo '<td>';
    echo '<div class="viewfleet_outer">';
    echo '<div class="fleetcard">';
    // Print the category short form if available
    echo $categoryShortForm . '-' . htmlspecialchars($rowfilter['assetcode']);
    echo '</div>';
    echo '<div class="content">';
    echo '<p>‣ Assetcode: ' . htmlspecialchars($rowfilter['assetcode']) . '</p>';
    echo '<p>‣ Make: ' . htmlspecialchars($rowfilter['make']) . '</p>';
    echo '<p>‣ Model: ' . htmlspecialchars($rowfilter['model']) . '</p>';
    echo '<p>‣ Registration: ' . htmlspecialchars($rowfilter['registration']) . '</p>';
    echo '<p>‣ Operator: <a class="operator_fullinfo" href="explore_operator.php?id=' . htmlspecialchars($rowfilter['snum']) . '&fname=' . htmlspecialchars($rowfilter['operator_fname']) . '">' . htmlspecialchars($rowfilter['operator_fname']) . '</a></p>';
    echo '<p>‣ Status: ' . htmlspecialchars($rowfilter['status']) . '</p>';
    echo '</div>';
    echo '<div class="viewfleet2_btncontainer">';
    echo '<a href="edit_fleetnew.php?id=' . htmlspecialchars($rowfilter['snum']) . '">';
    echo '<i title="View & Edit" class="bi bi-eye"></i>';
    echo '</a>';
    echo '<a href="delete.php?id=' . htmlspecialchars($rowfilter['snum']) . '">';
    echo '<i title="Delete" class="bi bi-trash"></i>';
    echo '</a>';
    echo '<a ' . (empty($rowfilter['loadchart']) ? 'style="display:none;"' : '') . ' href="img/' . htmlspecialchars($rowfilter['loadchart']) . '" target="_blank">';
    echo '<i title="View & Download Load Chart" class="bi bi-download"></i>';
    echo '</a>';
    echo '</div>';
    echo '</div>';
    echo '</td>';

    $loop_count_filter++;
}

// Close the last row if needed
if ($loop_count_filter % 4 != 0) {
    echo '</tr>';
}
?>
</table>

</body>
</html>
