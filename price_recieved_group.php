<?php 
include "partials\_dbconnect.php";
$id=$_GET['id'];
$sql = "SELECT * FROM `requirement_price_byrental` WHERE req_id='$id' ORDER BY price_quoted ASC";
$result=mysqli_query($conn,$sql);


$sql2 = "SELECT * FROM `req_by_epc` WHERE id='$id'";
$result2=mysqli_query($conn,$sql2);
$row2=mysqli_fetch_assoc($result2);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">      <link rel="icon" href="favicon.jpg" type="image/x-icon">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            <li><a href="epc_dashboard.php">Dashboard</a></li>
            <li><a href="view_news_epc.php">News</a></li>
            <li><a href="logout.php">Log Out</a></li>
        </ul>
    </div>
</div> 
<div class="project_details">
    <div class="proj_detail1">

    <p>Requirement Posted At: <?php echo date('d-m-Y H:i:s', strtotime($row2['enquiry_posted_date'])) ?></p>
    <p>Project Code: <?php echo $row2['project_code'] ?></p>
    <p>Project Type: <?php echo $row2['project_type'] ?></p>
    <p>Project State: <?php echo $row2['state'] ?></p>
    <p>Project District: <?php echo $row2['district'] ?></p>
    <p>Project Duration: <?php echo $row2['duration_month']  . " Month" ?></p>
    <p>Working Shift: <?php echo $row2['working_shift']  .  " Shift"?></p>

    </div>
    <div class="proj_detail1">
    <p>Equipment Type: <?php echo $row2['equipment_type'] ?></p>
    <p>Project Capacity: <?php echo $row2['equipment_capacity'] . " " .  $row2['unit']?></p>
    <p>Boom Combination: <?php echo $row2['boom_combination'] ?></p>
    <p>Fuel Scope: <?php echo $row2['fuel_scope'] ?></p>
    <p>Accomodation Scope: <?php echo $row2['accomodation_scope'] ?></p>
    <p>Contact Person: <?php echo $row2['contact_person'] ?></p>
    <p>Notes: <?php echo $row2['notes'] ?></p>


    </div>

</div>
<table class="prices_by_rentals">
<th>Rental Company Name</th><th>Rental Email Id</th><th>Rental Contact</th><th>Equipment Make</th><th>Equipment Model</th><th>YOM</th><th>Equipment Location</th><th>Equipment Available From</th><th>Price Quoted</th><th>Action</th>;
    <?php 
     $lowestPrice = PHP_INT_MAX;
if(mysqli_num_rows($result) > 0){
    while ($row = mysqli_fetch_assoc($result)){
        echo '<tr>';
        echo '<td>' . $row['rental_name'] . '</td>';
        echo '<td>' . $row['rental_email'] . '</td>';
        echo '<td>' . $row['rental_number'] . '</td>';
        echo '<td>' . $row['offer_make'] . '</td>';
        echo '<td>' . $row['offer_model'] . '</td>';
        echo '<td>' . $row['offer_yom'] . '</td>';
        echo '<td>' . $row['offer_equip_location'] . "  . " . $row['offer_district'] .'</td>';
        echo '<td>' . date('d-m-Y', strtotime($row['available_From_offer'])) . '</td>';
        // echo '<td>' . $row['price_quoted'] . '</td>';
        echo '<td';
        if ($row['price_quoted'] < $lowestPrice) {
            $lowestPrice = $row['price_quoted'];
            echo ' class="lowest-price"';
        }
        echo '>' . $row['price_quoted'] . '</td>';
        echo '<td><a href="view_crane_offer_full.php?id=' . $row['id'] . '" class="view_quote_price">View</a></td>';



        ?>
       <td>
        <!-- <a class='btn_listing' href='edit_rental_price.php?id=<?php echo $row['id']; ?>'> Edit Price</a> -->
    </td>;
        <?php
        echo '</tr>';
    }

    }

?>

</table>

</body>
</html>