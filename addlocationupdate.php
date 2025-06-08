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

$challanid=$_GET['id'];
$sql="SELECT * FROM `challans` where id='$challanid'";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_assoc($result);


if ($_SERVER["REQUEST_METHOD"] === 'POST'){
    
    include "partials/_dbconnect.php";
    $reg_no=$_POST['reg_no'];
    $challannumber=$_POST['challannumber'];
    $cnnumber=$_POST['cnnumber'];
    $date=$_POST['date'];
    $location=$_POST['location'];
    $challanidnumber=$_POST['challanidnumber'];
    $status=$_POST['status'];

    $location="INSERT INTO `location_update`(`status`,`companyname`, `cnnumber`, `challannumber`, `reg_no`, `date`, `location`)
     VALUES ('$status','$companyname001','$cnnumber','$challannumber','$reg_no','$date','$location')";

     $locationresult=mysqli_query($conn,$location);
     if($locationresult){
        header("Location: addlocationupdate.php?id=" . urlencode($challanidnumber));
        exit();

    }
     else{
        echo 'error';
     }

}

$location_updates = "SELECT * FROM `location_update` 
    WHERE companyname = '$companyname001' 
    AND cnnumber = '" . $row['cnnumber'] . "' 
    AND challannumber = '" . $row['challannumber'] . "' 
    AND reg_no = '" . $row['vehicle_reg_no'] . "'";

$result_update = mysqli_query($conn, $location_updates);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">

    <link rel="shortcut icon" href="favicon.jpg" type="image/x-icon">
    <title>Add Location</title>
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
            <!-- <li><a href="contact_us.php">Contact Us</a></li> -->
            <li><a href="logout.php">Log Out</a></li></ul>
        </div>
    </div> 
    <div class="trucktripinfo">
        <div class="truckinfo1">
        <p class="trip_details"><strong>Regestration Number :</strong> <?php echo $row['vehicle_reg_no'] ?></p>
             <p class="trip_details"><strong>Broker Company:</strong><?php echo $row['broker_name'] ?></p> 
             <p class="trip_details"><strong>Name:</strong><?php echo $row['brokercontactperson'] ?></p> 
             <p class="trip_details"><strong>Cell:</strong><?php echo $row['broker_mobile'] ?></p> 
             <p class="trip_details"><strong>Driver Name:</strong><?php echo $row['driver_name'] ?></p> 
             <p class="trip_details"><strong>Cell:</strong><?php echo $row['driver_mobile'] ?></p> 

        </div>
        <div class="truckinfo2">
            <?php if(mysqli_num_rows($result_update)>0){ ?>
                <table class="trucklocationtable">
                    <tr>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Location</th>
                    </tr>



<?php                while($rowupdate=mysqli_fetch_assoc($result_update)){
                    ?>
                    <tr>

                    <td><?php echo date('d-m-y', strtotime($rowupdate['date'])); ?></td>
                    <td><?php echo $rowupdate['status'] ?></td>
                        <td><?php echo $rowupdate['location'] ?></td>
                    </tr>

<?php
                }

            } ?>
        <!-- <p class="trip_details"><strong>Regestration Number :</strong> <?php echo $row['vehicle_reg_no'] ?></p>
             <p class="trip_details"><strong>Broker Name:</strong><?php echo $row['broker_name'] ?></p>  -->
             </table>

        </div>
        </div>
    </div>
</div>
<form class="locationform" action="addlocationupdate.php" method="POST" autocomplete="off">
    
    <div class="locationformcontainer">
        <p class="headingpara">Location Update</p>
        <div class="outer02">
        <div class="trial1">
            <input type="text" name="reg_no" placeholder="" value="<?php echo $row['vehicle_reg_no'] ?>" class="input02" readonly>
            <label for="" class="placeholder2">Regestration Number</label>
        </div>
        <div class="trial1">
            <select name="status" id="" class="input02" required>
                <option value=""disabled selected>Status</option>
                <option value="Vehicle Placed">Vehicle Placed</option>
                <option value="At Loading Site">At Loading Site</option>
                <option value="Dispatched">Dispatched</option>
                <option value="In Transit">In Transit</option>
                <option value="At UnLoading Site">At UnLoading Site</option>
                <option value="Unloading Completed">Unloading Completed</option>
            </select>
        </div>

        </div>
        <input type="hidden" name="challannumber" value="<?php echo $row['challannumber'] ?>">
        <input type="hidden" name="challanidnumber" value="<?php echo $challanid ?>">
        <input type="hidden" name="cnnumber" value="<?php echo $row['cnnumber'] ?>">
        <div class="outer02">
        <div class="trial1">
        <input type="date" value="<?php echo date('Y-m-d'); ?>" name="date" class="input02">
        <label for="" class="placeholder2">Date</label>
        </div>
        <div class="trial1">
            <input type="text" placeholder="" name="location" class="input02">
            <label for="" class="placeholder2">Current Location</label>
        </div>
        </div>
        <button type="submit" class="epc-button">Submit</button>


    </div>
</form>
 
</body>
</html>