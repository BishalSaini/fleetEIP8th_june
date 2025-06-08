<?php
include "partials/_dbconnect.php";
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$companyname001 = $_SESSION['companyname'];
$enterprise = $_SESSION['enterprise'];
$email = $_SESSION['email'];


$assetcode=$_GET['assetcode'];
$worefno=$_GET['worefno'];
$clientnameget=$_GET['clientname'];
$month=$_GET['month'];
$sitelocation=$_GET['sitelocation'];



$dashboard_url = '';
if ($enterprise === 'rental') {
    $dashboard_url = 'rental_dashboard.php';
} elseif ($enterprise === 'logistics') {
    $dashboard_url = 'logisticsdashboard.php';
} elseif ($enterprise === 'epc') {
    $dashboard_url = 'epc_dashboard.php';
} elseif ($enterprise === 'admin') {
    $dashboard_url = 'news/admin/dashboard.php';
}
$showAlert = false;
$showError = false;

if(isset($_SESSION['success'])){
    $showAlert= true;
    unset($_SESSION['success']);
  }
  else if(isset($_SESSION['error'])){
    $showError= true;
    unset($_SESSION['error']);
  
  }
  

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log Sheet Summary</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.4/font/bootstrap-icons.min.css">

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
                <li><a href="logout.php">Log Out</a></li>
            </ul>
        </div>
    </div>
    <?php
if ($showAlert) {
    echo  '<label>
    <input type="checkbox" class="alertCheckbox" autocomplete="off" />
    <div class="alert notice">
      <span class="alertClose">X</span>
      <span class="alertText_addfleet"><b>Success! 
          <br class="clear"/></span>
    </div>
  </label>';
}
if ($showError) {
    echo '<label>
    <input type="checkbox" class="alertCheckbox" autocomplete="off" />
    <div class="alert error">
      <span class="alertClose">X</span>
      <span class="alertText">Something Went Wrong
          <br class="clear"/></span>
    </div>
  </label>';
}
?>
    <div class="fulllength">
    <button onclick="window.location.href='downloadlogsheet.php?assetcode=<?php echo urlencode($assetcode); ?>&worefno=<?php echo urlencode($worefno); ?>&clientname=<?php echo urlencode($clientnameget); ?>&month=<?php echo urlencode($month); ?>&sitelocation=<?php echo urlencode($sitelocation); ?>'" class="downloadbuttonsummary">View Log Sheet</button>
    <button onclick="window.location.href='monthlylogbook.php?assetcode=<?php echo $assetcode; ?>&worefno=<?php echo $worefno ?>&clientname=<?php echo $clientnameget ?>&sitelocation=<?php echo $sitelocation ;?>'" class="gobackbuttonsummary">    <i class="bi bi-arrow-left"></i> Go Back
        </button>
    </div>

    <?php
    $sql=" SELECT * FROM logsheetnew where assetcode='$assetcode' and worefno='$worefno' and clientname='$clientnameget' and month_year='$month' and sitelocation='$sitelocation' and companyname='$companyname001' and logtype='shift'";
    $result=mysqli_query($conn,$sql);
    
if (mysqli_num_rows($result) > 0) { ?>
<br>
    <div class="length80">
        <h3>Asset Code : <?php echo $assetcode ?> Log Sheet</h3>
    </div>

    <table class="quotation-table" id="exemployee">
        <thead>
            <tr>
                <th>Date</th>
                <th>Month</th>
                <th>Asset Code</th>
                <th>Shift</th>
                <th>Start Time</th>
                <th>Close Time</th>
                <th>Fuel Taken</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($rowpending = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo date("d-M-y", strtotime($rowpending['date'])) ?></td>
                    <td><?php echo date("M", strtotime($rowpending['date'])) ?></td>
                    <td>
    <?php 
    echo htmlspecialchars($rowpending['assetcode']) . ' [' . 
         htmlspecialchars($rowpending['equipmenttype'] . ' - ' . $rowpending['make'] . '-' . $rowpending['model'].']'); 
    ?>
</td>
                    <td><?php echo $rowpending['shift']; ?></td>

                    <td><?php echo $rowpending['start_time']; ?></td>
                    <td><?php echo $rowpending['close_time']; ?></td>
                    <td><?php echo $rowpending['fuel_taken']; ?></td>
                    <td data-label="Actions">
                    <a href="editlogsheet.php?id=<?php echo $rowpending['id']; ?>&assetcode=<?php echo $assetcode ?>&worefno=<?php echo $worefno ?>" class="quotation-icon" title="View/Edit Log Sheet">
    <i style="width: 22px; height: 22px;" class="bi bi-pen"></i>
</a>
            <a href="deletelogsheet.php?id=<?php echo $rowpending['id']; ?>&assetcode=<?php echo $assetcode ?>&worefno=<?php echo $worefno ?>" onclick="return confirmdelete();" class="quotation-icon" title="Delete Log Sheet Entry">
                <i style="width: 22px; height: 22px;" class="bi bi-trash"></i>
            </a>
        </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
<?php
}
?>
<br>

<?php
    $sql=" SELECT * FROM logsheetnew where assetcode='$assetcode' and worefno='$worefno' and clientname='$clientnameget' and month_year='$month' and companyname='$companyname001' and logtype='ot'";
    $result=mysqli_query($conn,$sql);
    
if (mysqli_num_rows($result) > 0) { ?>
<br>
    <div class="length80">
        <h3>Asset Code : <?php echo $assetcode ?> OT Log Sheet</h3>
    </div>

    <table class="quotation-table" id="exemployee">
        <thead>
            <tr>
                <th>Date</th>
                <th>Asset Code</th>
                <th>Over Time Hour</th>
                <th>OT Pro Rata</th>
                <!-- <th>Close Time</th> -->
                <th>Fuel Taken</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($rowpending = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo date("d-M-y", strtotime($rowpending['date'])) ?></td>
                    <td>
    <?php 
    echo htmlspecialchars($rowpending['assetcode']) . ' [' . 
         htmlspecialchars($rowpending['equipmenttype'] . ' - ' . $rowpending['make'] . '-' . $rowpending['model'].']'); 
    ?>
</td>
                    <td><?php echo $rowpending['othours']; ?></td>
                    <td><?php echo $rowpending['otprorata']; ?></td>

                    <td><?php echo $rowpending['fuel_taken']; ?></td>
                    <td data-label="Actions">
                    <a href="editlogsheet.php?id=<?php echo $rowpending['id']; ?>&assetcode=<?php echo $assetcode ?>&worefno=<?php echo $worefno ?>" class="quotation-icon" title="View/Edit Log Sheet">
    <i style="width: 22px; height: 22px;" class="bi bi-pen"></i>
</a>
            <a href="deletelogsheet.php?id=<?php echo $rowpending['id']; ?>&assetcode=<?php echo $assetcode ?>&worefno=<?php echo $worefno ?>" onclick="return confirmdelete();" class="quotation-icon" title="Delete Log Sheet Entry">
                <i style="width: 22px; height: 22px;" class="bi bi-trash"></i>
            </a>
        </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
<?php
}
?>
<br>
<?php
    $sql="SELECT * FROM logsheetnew where assetcode='$assetcode' and worefno='$worefno' and clientname='$clientnameget' and month_year='$month' and companyname='$companyname001' and logtype='breakdown'";
    $result=mysqli_query($conn,$sql);
    
if (mysqli_num_rows($result) > 0) { ?>
<br>
    <div class="length80">
        <h3>Asset Code : <?php echo $assetcode ?> Breakdown Log Sheet</h3>
    </div>

    <table class="quotation-table" id="exemployee">
        <thead>
            <tr>
            <th>Date</th>
                <th>Asset Code</th>
                <th>Breakdown Hour</th>
                <!-- <th>OT Pro Rata</th> -->
                <!-- <th>Close Time</th> -->
                <th>Fuel Taken</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($rowpending = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo date("d-M-y", strtotime($rowpending['date'])) ?></td>
                    <td>
    <?php 
    echo htmlspecialchars($rowpending['assetcode']) . ' [' . 
         htmlspecialchars($rowpending['equipmenttype'] . ' - ' . $rowpending['make'] . '-' . $rowpending['model'].']'); 
    ?>
</td>
                    <td><?php echo $rowpending['breakdown_hours']; ?></td>

                    <td><?php echo $rowpending['fuel_taken']; ?></td>
                    <td data-label="Actions">
                    <a href="editlogsheet.php?id=<?php echo $rowpending['id']; ?>&assetcode=<?php echo $assetcode ?>&worefno=<?php echo $worefno ?>" class="quotation-icon" title="View/Edit Log Sheet">
    <i style="width: 22px; height: 22px;" class="bi bi-pen"></i>
</a>
            <a href="deletelogsheet.php?id=<?php echo $rowpending['id']; ?>&assetcode=<?php echo $assetcode ?>&worefno=<?php echo $worefno ?>" onclick="return confirmdelete();" class="quotation-icon" title="Delete Log Sheet Entry">
                <i style="width: 22px; height: 22px;" class="bi bi-trash"></i>
            </a>
        </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
<?php
}
?>





</body>
<script>
function confirmdelete() {
    return confirm("Are you sure you want to delete the logsheet entry?");
}
</script>
</html>