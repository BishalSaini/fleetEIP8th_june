<?php 
include "partials/_dbconnect.php";
session_start();
$name=$_GET['name'];
$email = $_SESSION['email'];
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
elseif ($enterprise === 'admin') {
    $dashboard_url = 'news/admin/dashboard.php';
} 

else {
    $dashboard_url = '';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="tiles.css">
    <link rel="shortcut icon" href="favicon.jpg" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Equipment Information</title>
</head>
<body>
<div class="navbar1">
    <div class="logo_fleet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <img src="logo_fe.png" alt="FLEET EIP" onclick="window.location.href='<?php echo $dashboard_url  ?>'">
</div>

        <div class="iconcontainer">
        <ul>
      <li><a href="<?php echo $dashboard_url ?>">Dashboard</a></li>
            <li><a href="logout.php">Log Out</a></li></ul>
        </div>
    </div> 
    
    <table class="members_table" id="members_tablecontent">

    <?php

    // Fetch fleet information
    $result = mysqli_query($conn, "SELECT * FROM fleet1 WHERE companyname=$name ORDER BY category, snum DESC");

    // Array to hold grouped fleet data
    $groupedFleet = array();

    // Group the results by fleet_category
    while ($row = mysqli_fetch_assoc($result)) {
        $category = $row['category'];
        if (!isset($groupedFleet[$category])) {
            $groupedFleet[$category] = array();
        }
        $groupedFleet[$category][] = $row;
    }

    // Display the grouped fleet data
    foreach ($groupedFleet as $category => $fleets) {
        echo '<tr><td ><h2 class="categoryheading">' . htmlspecialchars($category) . '</h2></td></tr>'; // Print the category heading
        
        $loop_count = 0; // Counter for items in the row
        echo '<tr>'; // Start a new row

        $categoryShortForms = array(
            'Aerial Work Platform' => 'AWP',
            'Concrete Equipment' => 'CE',
            'EarthMovers and Road Equipments' => 'EM',
            'Material Handling Equipments' => 'MHE',
            'Ground Engineering Equipments' => 'GEE',
            'Trailor and Truck' => 'T&T',
            'Generator and Lighting' => 'GL'
        );
        
        $loop_count = 0;
        foreach ($fleets as $row) {
            // Determine the short form based on the category
            $categoryShortForm = isset($categoryShortForms[$row['category']]) ? $categoryShortForms[$row['category']] : 'Unknown';
        
            if ($loop_count > 0 && $loop_count % 4 == 0) {
                echo '</tr><tr>'; // Close current row and start a new row
            }
            echo '<td>';
            echo '<div class="viewfleet_outer">';
            echo '<div class="fleetcard">';
            // Print the category short form
            echo $categoryShortForm . '-' . htmlspecialchars($row['assetcode']);
        
            echo '</div>';
        
            echo '<div class="content">';
            echo '<p>‣ Assetcode: ' . htmlspecialchars($row['assetcode']) . '</p>';
            echo '<p>‣ Make: ' . htmlspecialchars($row['make']) . '</p>';
            echo '<p>‣ Model: ' . htmlspecialchars($row['model']) . '</p>';
            echo '<p>‣ Registration: ' . htmlspecialchars($row['registration']) . '</p>';
            echo '<p>‣ Operator: <a class="operator_fullinfo" href="explore_operator.php?id=' . htmlspecialchars($row['snum']) . '&fname=' . htmlspecialchars($row['operator_fname']) . '">' . htmlspecialchars($row['operator_fname']) . '</a></p>';
            echo '<p>‣ Status: ' . htmlspecialchars($row['status']) . '</p>';
            echo '</div>';
        
            // echo '<div class="viewfleet2_btncontainer">';
            // echo '<a href="edit_fleetnew.php?id=' . htmlspecialchars($row['snum']) . '">';
            // echo '<i title="View & Edit" class="bi bi-eye"></i>';
            // echo '</a>';
            // echo '<a href="delete.php?id=' . htmlspecialchars($row['snum']) . '" onclick="return confirm(\'Are you sure you want to delete this?\');" >';
            // echo '<i title="Delete" class="bi bi-trash"></i>';
            // echo '</a>';
            // echo '<a ' . (empty($row['loadchart']) ? 'hidden' : '') . ' href="img/' . htmlspecialchars($row['loadchart']) . '" target="_blank">';
            // echo '<i title="View & Download Load Chart" class="bi bi-download"></i>';
            // echo '</a>';
            // echo '</div>'; 
        
            echo '</div>'; // Close viewfleet_outer
            echo '</td>'; // Close table cell
            $loop_count++;
        }
        
        // Close the last row if it's not already closed
        if ($loop_count % 4 != 0) {
            echo '</tr>'; // Close the row if there are less than 4 items
        }}
        ?>
        </table>

    </body>
</html>
