<?php
include_once 'partials/_dbconnect.php';
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
$requirement_id = $_GET['id'];

$sql_inquiry = "SELECT * FROM `logistics_need` where id='$requirement_id' and `companyname_need_generator`='$companyname001'";
$result_inquiry = mysqli_query($conn, $sql_inquiry);
$row_inquiry = mysqli_fetch_assoc($result_inquiry);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="favicon.jpg" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
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
$sql_basic_detail = "SELECT * FROM `logistics_need` where id='$requirement_id' and companyname_need_generator='$companyname001'";
$result_sql_edit = mysqli_query($conn, $sql_basic_detail);
$row_basic = mysqli_fetch_assoc($result_sql_edit);
?>

<div class="basic_details_container">
    <div class="basic_detail1">
        <p><strong>Material Detail : </strong><?php echo $row_basic['material_detail'] ?></p>
        <p><strong>From : </strong><?php echo $row_basic['from'] . ' - ' . $row_basic['from_pincode']; ?></p>
        <p><strong>To : </strong><?php echo $row_basic['to'] . ' - ' . $row_basic['to_pincode']; ?></p>
        <p><strong>Number Of Trailor Required : </strong><?php echo $row_basic['number_of_trailor'] ?></p>
        <p><strong>Advance Payment : </strong><?php echo $row_basic['adv_payment']?><span <?php if(empty($row_basic['adv_pay_percent'])){ echo 'hidden';} ?>> - <?php echo $row_basic['adv_pay_percent'] ?></span></p>
        <p><strong>Balance Payment : </strong><?php echo $row_basic['balance_pay']?></p>
    </div>
    <div class="basic_detail2">
        <p id="requirement"><strong>Trailor Requirement Details</strong></p>
        <p>Dimensions Unit : <?php echo $row_basic['dimension_unit'] ?></p>
        <p>
            <?php echo $row_basic['no_1_trailor'] . 'nos - ' . $row_basic['trailor_type1'] . ' - ' . $row_basic['length1'] .'*' . $row_basic['width1']  . '*' . $row_basic['height1'] . ' &nbsp  ' . ' Weight :' . $row_basic['weight1']. $row_basic['weight_unit']; ?>
        </p>
        <p style="<?php if (empty($row_basic['no_2_trailor'])) {
            echo 'display: none;';
        } ?>">
            <?php echo $row_basic['no_2_trailor'] . 'no - ' . $row_basic['trailor2'] . ' - ' . $row_basic['length2'] .'*' . $row_basic['width2']  . '*' . $row_basic['height2'] . ' &nbsp  ' . ' Weight :' . $row_basic['weight2']. $row_basic['weight_unit']; ?>
            </p>
        <p style="<?php if (empty($row_basic['no_3_trailor'])) {
            echo 'display: none;';
        } ?>">
            <?php echo $row_basic['no_3_trailor'] . 'no - ' . $row_basic['trailor3'] . ' - ' . $row_basic['length3'] .'*' . $row_basic['width3']  . '*' . $row_basic['height3'] . ' &nbsp  ' . ' Weight :' . $row_basic['weight3']. $row_basic['weight_unit']; ?>
            </p>
        <p style="<?php if (empty($row_basic['no_4_trailor'])) {
            echo 'display: none;';
        } ?>">
            <?php echo $row_basic['no_4_trailor'] . 'no - ' . $row_basic['trailor4'] . ' - ' . $row_basic['length4'] .'*' . $row_basic['width4']  . '*' . $row_basic['height4'] . ' &nbsp  ' . ' Weight :' . $row_basic['weight4']. $row_basic['weight_unit']; ?>
            </p>
        <p style="<?php if (empty($row_basic['no_5_trailor'])) {
            echo 'display: none;';
        } ?>">
            <?php echo $row_basic['no_5_trailor'] . 'no - ' . $row_basic['trailor5'] . ' - ' . $row_basic['length5'] .'*' . $row_basic['width5']  . '*' . $row_basic['height5'] . ' &nbsp  ' . ' Weight :' . $row_basic['weight5']. $row_basic['weight_unit']; ?>
            </p>
        <p style="<?php if (empty($row_basic['no_6_trailor'])) {
            echo 'display: none;';
        } ?>">
            <?php echo $row_basic['no_6_trailor'] . 'no - ' . $row_basic['trailor6'] . ' - ' . $row_basic['length6'] .'*' . $row_basic['width6']  . '*' . $row_basic['height6'] . ' &nbsp  ' . ' Weight :' . $row_basic['weight6']. $row_basic['weight_unit']; ?>
            </p>
        <p style="<?php if (empty($row_basic['no_7_trailor'])) {
            echo 'display: none;';
        } ?>">
            <?php echo $row_basic['no_7_trailor'] . 'no - ' . $row_basic['trailor7'] . ' - ' . $row_basic['length7'] .'*' . $row_basic['width7']  . '*' . $row_basic['height7'] . ' &nbsp  ' . ' Weight :' . $row_basic['weight7']. $row_basic['weight_unit']; ?>
            </p>
        <p style="<?php if (empty($row_basic['no_8_trailor'])) {
            echo 'display: none;';
        } ?>">
            <?php echo $row_basic['no_8_trailor'] . 'no - ' . $row_basic['trailor8'] . ' - ' . $row_basic['length8'] .'*' . $row_basic['width8']  . '*' . $row_basic['height8'] . ' &nbsp  ' . ' Weight :' . $row_basic['weight8']. $row_basic['weight_unit']; ?>
            </p>
        <p style="<?php if (empty($row_basic['no_9_trailor'])) {
            echo 'display: none;';
        } ?>">
            <?php echo $row_basic['no_9_trailor'] . 'no - ' . $row_basic['trailor9'] . ' - ' . $row_basic['length9'] .'*' . $row_basic['width9']  . '*' . $row_basic['height9'] . ' &nbsp  ' . ' Weight :' . $row_basic['weight9']. $row_basic['weight_unit']; ?>
            </p>
        <p style="<?php if (empty($row_basic['no_10_trailor'])) {
            echo 'display: none;';
        } ?>">
            <?php echo $row_basic['no_10_trailor'] . 'no - ' . $row_basic['trailor10'] . ' - ' . $row_basic['length10'] .'*' . $row_basic['width10']  . '*' . $row_basic['height10'] . ' &nbsp  ' . ' Weight :' . $row_basic['weight10']. $row_basic['weight_unit']; ?>
            </p>
    </div>
</div>

<?php
include_once 'partials/_dbconnect.php';

$result = mysqli_query($conn, "SELECT * FROM `logi_price_quoted` where `requirement_company_name`='$companyname001' and `req_no`='$requirement_id' ORDER BY quote_price asc");
if (mysqli_num_rows($result) > 0) {
    // Start the table
    echo '<table class="purchase_table" id="logi_rates"><tr>';

    $loop_count = 1; // Initialize the counter

    while ($row = mysqli_fetch_assoc($result)) {
        if ($loop_count > 0 && $loop_count % 4 == 0) {
            echo '</tr><tr>'; // Close the current row and start a new one after every 3 cards
        }
        ?>
        <td>
            <div class="custom-card" id="rate_card">
            <p id="logi_rank"><?php echo 'L' . $loop_count ?></p>

                <h3 class="custom-card__title"><?php echo $row['logistic_company_name'] ?></h3>
                <p class="insidedetails" id="">Contact: <?php echo $row['logistic_company_number'] ?></p>
                <p class="insidedetails" id="email_logi">Email: <?php echo $row['logistic_company_email'] ?></p>
                <div class="insidedetails">Total Price: <?php echo $row['quote_price'] ?></div>
                <p class="insidedetails"><?php echo $row_basic['trailor_type1'] . '-' . $row['trailor1_price'] ?></p>
                <p class="insidedetails"><?php echo $row_basic['trailor2'] . '-' . $row['trailor2_price'] ?></p>
                <!-- Show trailors dynamically, only if they are not empty -->
                <?php if (!empty($row_basic['trailor3'])) { ?>
                    <p class="insidedetails"><?php echo $row_basic['trailor3'] . '-' . $row['trailor3_price'] ?></p>
                <?php } ?>
                <?php if (!empty($row_basic['trailor4'])) { ?>
                    <p class="insidedetails"><?php echo $row_basic['trailor4'] . '-' . $row['trailor4_price'] ?></p>
                <?php } ?>
                <?php if (!empty($row_basic['trailor5'])) { ?>
                    <p class="insidedetails"><?php echo $row_basic['trailor5'] . '-' . $row['trailor5_price'] ?></p>
                <?php } ?>
                <?php if (!empty($row_basic['trailor6'])) { ?>
                    <p class="insidedetails"><?php echo $row_basic['trailor6'] . '-' . $row['trailor6_price'] ?></p>
                <?php } ?>
                <?php if (!empty($row_basic['trailor7'])) { ?>
                    <p class="insidedetails"><?php echo $row_basic['trailor7'] . '-' . $row['trailor7_price'] ?></p>
                <?php } ?>
                <?php if (!empty($row_basic['trailor8'])) { ?>
                    <p class="insidedetails"><?php echo $row_basic['trailor8'] . '-' . $row['trailor8_price'] ?></p>
                <?php } ?>
                <?php if (!empty($row_basic['trailor9'])) { ?>
                    <p class="insidedetails"><?php echo $row_basic['trailor9'] . '-' . $row['trailor9_price'] ?></p>
                <?php } ?>
                <?php if (!empty($row_basic['trailor10'])) { ?>
                    <p class="insidedetails"><?php echo $row_basic['trailor10'] . '-' . $row['trailor10_price'] ?></p>
                <?php } ?>

                <div class="custom-card__arrow">
                    <i class="fas fa-arrow-right"></i>
                </div>
            </div>
        </td>
        <?php
        $loop_count++;
    }

    // Close the last row and the table
    echo '</tr></table>';
}
?>
</body>
</html>
