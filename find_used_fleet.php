<?php 
session_start();
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


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="favicon.jpg" type="image/x-icon">
    <title>Document</title>
    <link rel="stylesheet" href="style.css"> <!-- Correct way to include CSS -->
</head>
<body>
    <div class="navbar1">
        <div class="logo_fleet">
            <img src="logo_fe.png" alt="FLEET EIP" onclick="window.location.href='<?php echo $dashboard_url ?>'">
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
    if (isset($_POST['submit'])) {
        include_once 'partials/_dbconnect.php';

        $fleet_category = $_POST['fleet_category'];
        $fleet_sub_type = $_POST['type'];
        $purchase_capacity = $_POST['purchase_capacity'] ?? '';

        if (!empty($purchase_capacity)) {
            $sqlcap = "SELECT * FROM images WHERE category = '$fleet_category' AND sub_type='$fleet_sub_type' AND capacity='$purchase_capacity' order by `id` desc";
            $resultcap = mysqli_query($conn, $sqlcap);
            if (!$resultcap) {
                echo "Error: " . mysqli_error($conn);
            }
        } else {
            $sql = "SELECT * FROM images WHERE category = '$fleet_category' AND sub_type='$fleet_sub_type' order by `id` desc";
            $result = mysqli_query($conn, $sql);
            if (!$result) {
                echo "Error: " . mysqli_error($conn);
            }
        }

        // Check if any results found in either query
        $has_results = (isset($result) && mysqli_num_rows($result) > 0) || (isset($resultcap) && mysqli_num_rows($resultcap) > 0);

        if ($has_results) {
            ?>
            <div class="outer_Sell_table">
                <table class="sellfleet_table">
                    <tr>
                    <?php
                    $loop_count = 0;

                    // Use the correct result set based on the query executed
                    $result_set = !empty($purchase_capacity) ? $resultcap : $result;

                    while ($row = mysqli_fetch_assoc($result_set)) {
                        if ($loop_count > 0 && $loop_count % 4 == 0) {
                            echo '</tr><tr>'; // Start a new row after every 4th item
                        }
                        ?>
                        <td>
                            <div class="sell_fleet_card">
                                <div class="card-image" style="background-image: url('<?php echo 'img/'.$row['front_pic']; ?>');"></div>
                                <div class="category">Used Equipment</div>
                                <div class="heading">
                                    <?php echo $row['sub_type']; ?>
                                    <div class="author" id="first_info">Yom- <?php echo $row['yom']; ?></div>
                                    <div class="author">Capacity- <?php echo $row['capacity'].' ' . $row['unit']; ?></div>
                                    <div class="author">Location- <?php echo $row['location'] ?></div>
                                    <div class="author">Price- <?php echo $row['price']; ?></div>
                                    <button class="view_used_fleet_button" onclick="window.location.href='full_info_used_fleet.php?id=<?php echo $row['id'] ?>'">View</button>
                                </div>
                            </div>
                        </td>
                        <?php
                        $loop_count++;
                    }
                    ?>
                    </tr>
                </table>
            </div>
            <?php
        } else {
            ?>
            <p class="nomatching">No matching fleet found as of now. We will notify you as soon as the equipment is available.</p>
            <?php
        }
    }
    ?>

    <script src="main.js"></script> <!-- Correct way to include JavaScript -->
</body>
</html>
