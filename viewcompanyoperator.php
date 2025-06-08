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
    <title>Operator Information</title>
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
    <table class="members_table">           
            <tr>
        <?php
             
     
        $result = mysqli_query($conn, "SELECT * FROM myoperators WHERE company_name=$name");
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

            
            echo '</div>';
            echo'<br>';

           
            echo '</div>';
            echo '<br>';
            ?>
                <div class="notification_background" id="notification_bg">
                <div class="noti_outer">
                <div class="closeall" onclick="close_all_notification_dl('<?php echo $companyname001 ?>')"><i class="fa-solid fa-xmark cross_symbol"></i>  Close All</div>

                <?php
        while($row_noti_content = mysqli_fetch_assoc($result_noti) ){
    ?>
    <div class="noti_container">
        <div class="noti_content_main">
            <div class="content_holder">
        <?php 

echo "Driving License Of " . $row_noti_content['driver_name'] . "<br>";
echo "Expires in " . $row_noti_content['days_left'] . " days" . "<br>";
?>
</div>
<a onclick="del_notification_dl(<?php echo $row_noti_content['sno']; ?>)" id="del_notification"><i class="fa-solid fa-xmark"></i></a>          


        </div>
    </div>
    
    <?php
}

?>

                </div>
                </div>

            <div id="rate_operator" class="ratingoperator">
            <div class="ratingcontent">
                <form action="view_operator.php" method="POST" class="rating_operator_form">
                <div class="ratingcontentinner">
                    <div class="trial1">
                        <input type="text" name="license_op" placeholder="" value="<?php echo $row['driving_license'] ?>" class="input02" readonly>
                        <label for="" class="placeholder2">Driving License Number</label>
                    </div>
                    <div class="trial1">
                        <select name="operator_rate" id="" class="input02">
                        <option value="None"disabled selected>Rate Overall Performance of Operator </option>
                        <option value="1">★</option>
                        <option value="2">★★</option>
                        <option value="3">★★★</option>
                        <option value="4">★★★★</option>
                        <option value="5">★★★★★</option>
            </select>
                    </div>
            <div class="trial1">
            <textarea type="text" name='feed' id='feedback_text1' rows="7" class="input02" placeholder=""></textarea>
            <label for="" class="placeholder2">Feedback</label>
            </div>
            <div class="trial1" id='rate_button'>
                <button id="submit_rate" name="rateing_op" type="SUBMIT">Submit</button>
                <button id="cancel_rate" type="button" onclick="cancelbtn()">Cancel</button>

            </div>
        
                    </div>
                </div>
            </div>
        </div>
        </form>
        
            
<?php
            // Create a new row after every 5 members
            if ($loop_count > 0 && $loop_count % 4 == 0) {
                echo '</tr><tr>';
            }

            $loop_count++;
        }
        ?>
    </tr>
</table>

    </body>
</html>

