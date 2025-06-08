<?php
session_start();
$_SESSION['loggedin'] = true;
$companyname001=$_SESSION['companyname'];
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

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fleet Managers</title>
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
            <li><a href="logout.php">Logout</a></li>
                </ul>
    </div>
</div> 


<div class="filters">
    <p>Apply Filter :</p>
    <form action="filteredoperator.php" method="GET">
        <select name="filtertype" id="filterselect" class="filter_button" required>
            <option value="" disabled selected>Select Filter</option>
            <option value="Idle">Idle </option>
            <option value="Working">Working </option>
        </select>
        <button  id="operatorfilterbutton" class="filter_button">Submit</button>
    </form>
</div>

<table class="members_table">           
            <tr>
        <?php
             include "partials/_dbconnect.php";
        $statusfilter=$_GET['filtertype'];
        $result = mysqli_query($conn, "SELECT * FROM myoperators WHERE company_name='$companyname001' and current_status='$statusfilter'");
        $loop_count = 1;

        while ($row = mysqli_fetch_assoc($result)) { 
            // Display member information within a <td>
            echo '<td>';
            echo '<div class="viewfleet_outer">';
            echo '<div class="fleetcard_operator">';
            echo '<img src="fleet_manager.jpg">';  
            // echo '<h2 class="fontasset"><b>' . $row['assetcode'] . '</b></h2>';
            echo '</div>';
            echo '<div class="content">';
            // echo '<p>‣ Assetcode:' . $row['assetcode'] . '</p>';
            echo '<p><strong>' . $row['designation'] . ':</strong> ' . $row['operator_fname'] . '</p>';
                echo '<p><strong>Fleet Type:</strong> ' . $row['fleet_Type'] . '</p>';
            echo '<p><strong>Capacity:</strong> ' . $row['cap_metric_ton'] . '</p>';
            echo '<p><strong>Driving License:</strong> ' . $row['driving_license'] . '</p>';
            echo '<p><strong>Current Status:</strong> ' . $row['current_status'] . '</p>';
            echo '<p><strong>Driving Asset Code:</strong> ' . $row['driving_asset_code'] . '</p>';
                        
            echo'</div>';

            echo'<div class="btn01">';
            echo '<div class="viewbtn">';
            echo "
            <a class='btn_operator' href='view_operator_additionalinfo.php?id=" . $row['id'] .  "'>View </a>
            </div>";
            echo '<div class="delbtn">';
            echo "
            <a class='btn_operator' href='deleteoperator.php?id=" . $row['id'] .  "'>Delete </a>
            </div>";
            
            // echo "<a class='btn_operator' id='ratingbutton' onclick='ratingoperator(".$row['driving_license'].")'>Rate</a></div>";            

            echo '</div>';
            echo'</div>';
            
            echo '</div>';
            echo'<br>';

           
            echo '</div>';
            echo '<br>';
            ?>
        </div>
    </div>
    
    <?php
}

?>

                </div>
                </div>

        
            
<?php
            // Create a new row after every 5 members
            if ($loop_count > 0 && $loop_count % 4 == 0) {
                echo '</tr><tr>';
            }

            $loop_count++;
    
        ?>
    </tr>
</table>

</body>
</html>