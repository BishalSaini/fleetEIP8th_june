<?php 
session_start();
$showAlert=false;
$showError=false;
include "partials/_dbconnect.php";
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

$tripid=$_GET['id'];
$sql_tripbasic="SELECT * FROM `triplogi` where id='$tripid' and companyname='$companyname001'";
$result_tripbasic=mysqli_query($conn,$sql_tripbasic);
if($result_tripbasic){
    $rowbasic=mysqli_fetch_assoc($result_tripbasic);
}
else{
    $rowbasic=array();
}
$challan_associated_trip_id=$rowbasic['tripid'];
$sql_truck="SELECT * FROM `challans` where `associate_trip_id`='$challan_associated_trip_id'";
$result=mysqli_query($conn,$sql_truck);
// $row=mysqli_fetch_assoc($result);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="favicon.jpg" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <title>Trip Updates</title>
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
<div class="tripinfo">
    <p class="trip_details"><strong>Trip ID:</strong> <?php echo $rowbasic['tripid'] ?> &nbsp &nbsp <strong>From : </strong><?php echo ucwords ($rowbasic['source']) ?> &nbsp &nbsp <strong>To : </strong><?php echo ucwords ($rowbasic['destination']) ?></p>
    <div class="tripinfocontainer">
        <div class="trip1">
            <p class="trip_details"><strong>Consignor :</strong><?php echo $rowbasic['consignor'] ?></p>
            <p class="trip_details"><strong>Address :</strong><?php echo $rowbasic['address'] ?></p>
            <p class="trip_details"><strong>Contact Person :</strong><?php echo $rowbasic['contactperson_consignor'] ?></p>
            <p class="trip_details"><strong>Cell :</strong><?php echo $rowbasic['consignor_contactperson_number'] ?></p>
            <p class="trip_details"><strong>Freight Charges :</strong><?php echo $rowbasic['freight_charges'] ?></p>
            <p class="trip_details"><strong>PO Number :</strong><?php echo $rowbasic['po_no'] ?> &nbsp &nbsp <strong>PO-Date : </strong><?php echo date('d-m-y', strtotime($rowbasic['po_date'])); ?></p>
            <br>

        </div>
    </div>
    <div class="tripbutton">
    <button onclick="window.location.href='generatecn.php?from=<?php echo urlencode($rowbasic['source']); ?>&to=<?php echo urlencode($rowbasic['destination']); ?>&freight=<?php echo urlencode($rowbasic['freight_charges']); ?>&consignor=<?php echo urlencode($rowbasic['consignor']); ?>&tripid=<?php echo urlencode($rowbasic['tripid']); ?>'" class="tripupdate_generatecn">
    Generate CN
</button>
</div>
</div>
    <div class="truckcontainer">
        <?php if(mysqli_num_rows($result)>0){
                echo '<table class="purchase_table" id="logi_rates"><tr>';

                $loop_count = 0;
            
            while($row=mysqli_fetch_assoc($result)){ 
        if ($loop_count > 0 && $loop_count % 4 == 0) {
            echo '</tr><tr>'; 
        }
        $challanid=$row['id'];
        ?>
            <td>
                
                <div class="custom-card" id="application_card" onclick="window.location.href='addlocationupdate.php?id=<?php echo $challanid; ?>'">
                    <p class="insidedetails"><strong>Vehicle :</strong> <?php echo($row['vehicle_reg_no']) ?></p>
                    <p class="insidedetails"><strong>CN : </strong><?php echo($row['cnnumber']) ?> &nbsp &nbsp <strong>Challan : </strong><?php echo($row['challannumber']) ?></p>
                    <p class="insidedetails"><strong>Broker : </strong><?php echo($row['broker_name']) ?></p>
<br>
                    <!-- <p class="insidedetails" id="button_container_resume">
                        <a href='editlogiclient?id=<?php echo urlencode($row['id']); ?>'>
                            <button title="View/Edit" class="downloadresume" type="button"><i class="fas fa-eye"></i>

                            </button>
                        </a> -->
                        <!-- <a href='javascript:void(0)'>
                            <button title="Mark As Sold" onclick='openPopup1(<?php echo intval($row['id']); ?>)' class="downloadresume" type="button"><i class="fa-solid fa-check-circle"></i></button>
                        </a> -->
                    <!-- </p> -->
                    <div class="custom-card__arrow">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </div>
            </td>


<?php
 $loop_count++;  
    }
    echo '</tr></table>';
    }
    ?>




</div>
<input type="" readonly name="trip" value="<?php echo $tripid; ?>" hidden>
</body>
</html>