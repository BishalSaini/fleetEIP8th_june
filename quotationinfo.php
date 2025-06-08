<?php
include_once 'partials/_dbconnect.php';
$showAlert = false;
$showError = false;

session_start();

// Ensure session variables exist
if (!isset($_SESSION['companyname'], $_SESSION['enterprise'])) {
    die("Session variables are missing. Please login again.");
}

$companyname001 = $_SESSION['companyname'];
$enterprise = $_SESSION['enterprise'];

$dashboard_url = '';
if ($enterprise === 'rental') {
    $dashboard_url = 'rental_dashboard.php';
} elseif ($enterprise === 'logistics') {
    $dashboard_url = 'logisticsdashboard.php';
} elseif ($enterprise === 'epc') {
    $dashboard_url = 'epc_dashboard.php';
}

if(isset($_SESSION['success'])){
  $showAlert= true;
  unset($_SESSION['success']);
}
else if(isset($_SESSION['failed'])){
  $showError= true;
  unset($_SESSION['failed']);

}
else if(isset($_SESSION['error'])){
  $showError= true;
  unset($_SESSION['error']);

}

// Validate GET parameter
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid request. No sender specified.");
}

$sendername = mysqli_real_escape_string($conn, $_GET['id']);
$sql = "SELECT * FROM `quotation_generated` WHERE `sender_name`='$sendername' AND `company_name`='$companyname001' order by sno desc";
$result = mysqli_query($conn, $sql);

// Check if query executed successfully
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}
?>
<?php
if(isset($_POST['quote_status_btn'])){
  include "partials/_dbconnect.php";
  $stats_ref_no = !empty($_POST['stats_ref_no']) ? $_POST['stats_ref_no'] : null;
  $stats_compname = !empty($_POST['stats_compname']) ? $_POST['stats_compname'] : null;
  $generated_By = !empty($_POST['generated_By']) ? $_POST['generated_By'] : null;
  $current_status_ = !empty($_POST['current_status_']) ? $_POST['current_status_'] : null;


  $enquiry_close = !empty($_POST['enquiry_close']) ? $_POST['enquiry_close'] : null;
  $postponed_date = !empty($_POST['postponed_date']) ? $_POST['postponed_date'] : null;
  $lost_to = !empty($_POST['lost_to']) ? $_POST['lost_to'] : null;
  $regretted_reason = !empty($_POST['regretted_reason']) ? $_POST['regretted_reason'] : null;
  $unique_id=$_POST['unique_id'];
  


  $check_query = "SELECT * FROM `quotation_status` WHERE `ref_no` = '$stats_ref_no' AND `companyname` = '$stats_compname'";
  $check_result = mysqli_query($conn, $check_query);

  
  if(mysqli_num_rows($check_result) > 0){
    // Update query
    $sql_crnt_status = "UPDATE `quotation_status` SET 
                        `generated_by` = '$generated_By', 
                        `current_status` = '$current_status_', 
                        `inquiry_closed_reason` = '$enquiry_close', 
                        `regretted_reason` = '$regretted_reason', 
                        `lost_to` = '$lost_to', 
                        `postponed_date` = '$postponed_date', 
                        `unique_id`='$unique_id'
                        WHERE `ref_no` = '$stats_ref_no' AND `companyname` = '$stats_compname'";
  } else {
    // Insert query
    $sql_crnt_status = "INSERT INTO `quotation_status` (`unique_id`,`ref_no`, `generated_by`, `companyname`, `current_status`, `inquiry_closed_reason`, `regretted_reason`, `lost_to`, `postponed_date`) 
                        VALUES ('$unique_id','$stats_ref_no', '$generated_By', '$stats_compname', '$current_status_', '$enquiry_close', '$regretted_reason', '$lost_to', '$postponed_date')";
  }
$result_new_=mysqli_query($conn,$sql_crnt_status);
if($result_new_){
  $showAlert=true;
}
else{
  $showError=true;
}

}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quotation Information</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        .quotation-table {
  width: 90%;
  font-size: 13px;
  border-collapse: collapse;
  margin-top: 20px;
  /* margin: 0 auto;  */
  padding: 10px; 

}

    </style>
    <link rel="shortcut icon" href="favicon.jpg" type="image/x-icon">
</head>
<body>

<div class="navbar1">
    <div class="logo_fleet">
        <img src="logo_fe.png" alt="FLEET EIP" onclick="window.location.href='<?php echo $dashboard_url; ?>'">
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
if ($showAlert) {
    echo  '<label>
    <input type="checkbox" class="alertCheckbox" autocomplete="off" />
    <div class="alert notice">
      <span class="alertClose">X</span>
      <span class="alertText_addfleet"><b>Success! </b>
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
  <div class="filters" id="filterinfo">
    <p>Apply Filter :</p>
    <form action="quotationinfofilter.php" class="quotationfilterform" method="GET">
        <select name="filtertype" onchange="quotation_filter()" id="quotationfilterdd" class="filter_button">
            <option value="" disabled selected>Select Filter</option>
            <option value="Date">Date </option>
            <option value="Client">Client </option>
            <option value="Status">Status </option>
            <option value="Asset Code">Asset Code </option>
        </select>
        <input type="date" name="quotefilter_date" id="quotationfilterdate" class="quotation_select">
        <select name="filterclient" id="clientfilter" class="quotation_select">
          <option value=""disabled selected>Select Client</option>
          <?php 
          $sqlfilterclient="SELECT * FROM `rentalclient_basicdetail` where companyname='$companyname001'";
          $result_client=mysqli_query($conn,$sqlfilterclient);
          while($rowclientfilter=mysqli_fetch_assoc($result_client)){
            ?>
          <option value="<?php echo $rowclientfilter['clientname'] ?>"><?php  echo $rowclientfilter['clientname'] ?></option>
            <?php
          }
          ?>
          
        </select>
        <input type="text" class="hideit" name="uname" value="<?php echo $sendername; ?>">
        <select name="filterstatus" id="statusfilter" class="quotation_select">
          <option value=""disabled selected>Select Status</option>
          <option value="Inquiry Closed">Inquiry Closed</option>
          <option value="Open">Open</option>
          <option value="Regretted">Regretted</option>
          <option value="Won">Won</option>
          <option value="Lost">Lost</option>
        </select>
        <select name="filterassetcode" id="acfilter" class="quotation_select">
          <option value=""disabled selected>Select Assetcode</option>
          <?php
          $filterac="SELECT * FROM `fleet1` where companyname='$companyname001'";
          $resultfilterac=mysqli_query($conn,$filterac);
          while($rowacfilter=mysqli_fetch_assoc($resultfilterac)){
            ?>
          <option value="<?php echo $rowacfilter['assetcode'] ?>"><?php echo $rowacfilter['assetcode'] .'-'. $rowacfilter['sub_type'] .'-'. $rowacfilter['model'] ?></option>
            <?php
          }
          ?>
        </select>
        <button id="quotationfilterbutton" class="filter_button">Submit</button>
    </form>
</div>

<br>


<?php if(mysqli_num_rows($result) > 0) { ?>
<table class="quotation-table">
    <thead>
        <tr>
            <th>Date</th>
            <th>Ref No</th>
            <th>To</th>
            <th>Asset</th>
            <th>Equipment</th>
            <th>Shift</th>
            <th>Rental</th>
            <th>Duration</th>
            <th>Site</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>

    <?php while ($row = mysqli_fetch_assoc($result)) { 
        // Fetch current status
        $sql_crnt_status_check = "SELECT * FROM `quotation_status` WHERE ref_no = '" . $row['ref_no'] . "' AND companyname = '" . $companyname001 . "' AND unique_id = '" . $row['uniqueid'] . "'";
        $result_crnt_status_check = mysqli_query($conn, $sql_crnt_status_check);
        $row_crnt_status_check = mysqli_fetch_assoc($result_crnt_status_check);
        $current_status = isset($row_crnt_status_check['current_status']) ? $row_crnt_status_check['current_status'] : 'Not Defined';
    ?>
        <tr>
            <td><?php echo date('d-m-Y', strtotime($row['quote_date'])); ?></td>
            <td><?php echo htmlspecialchars($row['ref_no']); ?></td>
            <td><?php echo htmlspecialchars($row['to_name']); ?></td>
            <td><?php echo ($row['asset_code'] === 'New Equipment') ? 'New' : htmlspecialchars($row['asset_code']); ?></td>
            <td><?php echo htmlspecialchars($row['make'] . " " . $row['model']); ?></td>
            <td><?php echo htmlspecialchars($row['shift_info']); ?></td>
            <td><?php echo number_format($row['rental_charges']); ?></td>
            <td><?php echo htmlspecialchars($row['period_contract']); ?></td>
            <td><?php echo htmlspecialchars($row['site_loc']); ?></td>
            <td data-label="Current Status" onclick="toggleModal('modal_<?php echo $row['ref_no']; ?>')" style="cursor: pointer;">
            <mark><?php echo isset($row_crnt_status_check['current_status']) ? $row_crnt_status_check['current_status'] : 'Not Defined'; ?></mark>
        </td>
        <div class="modal" id="modal_<?php echo $row['ref_no']; ?>">
            <form class="quote_status_form" action="quotationinfo.php?id=<?php echo $sendername; ?>" method="POST" autocomplete="off">
                <div class="stat_container">
                    <div class="icon_container">
                        <p class="headingpara">Quotation Status</p>
                        <span  class="back_icon" onclick="toggleModal('modal_<?php echo $row['ref_no']; ?>')">X</span>
                    </div>

                    <div class="trial1">
                        <input type="text" name="stats_ref_no" placeholder="" value="<?php echo htmlspecialchars($row['ref_no']); ?>" class="input02" readonly>
                        <label class="placeholder2">Ref No</label>
                    </div>
                    
                    <input type="hidden" name="unique_id" value="<?php echo $row['uniqueid'] ?>" readonly>
                    <input type="hidden" name="stats_compname" value="<?php echo htmlspecialchars($companyname001); ?>">
                    
                    <div class="trial1">
                        <input type="text" name="generated_By" placeholder="" value="<?php echo htmlspecialchars($row['sender_name']); ?>" class="input02" readonly>
                        <label class="placeholder2">Generated By</label>
                    </div>
                    
                    <div class="trial1">
                    <select name="current_status_" class="input02" onchange="status_change(this.value, '<?php echo $row['ref_no']; ?>')" required>
                    <option value="" disabled selected>Current Status</option>
                            <option value="Closed">Inquiry Closed</option>
                            <option value="Open">Open</option>
                            <option value="Regretted">Regretted</option>
                            <option value="Won">Won</option>
                            <option value="Lost">Lost</option>
                        </select>
                    </div>
                    
                    <div class="trial1 reason-dd" id="enquiry_closed_dd_<?php echo $row['ref_no']; ?>" style="display: none;">
                        <select name="enquiry_close" class="input02" onchange="enquiry_info()">
                            <option value="" disabled selected>Inquiry Closed Reason</option>
                            <option value="Required Equipment Changed">Required Equipment Changed</option>
                            <option value="Requirement Postponed">Requirement Postponed</option>
                            <option value="Project Issue">Project Issue</option>
                        </select>
                    </div>
                    
                    <div class="trial1 reason-dd" id="postponed_to_<?php echo $row['ref_no']; ?>" style="display: none;">
                        <input type="date" name="postponed_date" placeholder="" class="input02">
                        <label class="placeholder2">Postponed Date</label>
                    </div>
                    
                    <div class="trial1 reason-dd" id="lost_to_<?php echo $row['ref_no']; ?>" style="display: none;">
                        <input type="text" name="lost_to" placeholder="" class="input02">
                        <label class="placeholder2">Lost To ?</label>
                    </div>
                    
                    <div class="trial1 reason-dd" id="regretted_reason_<?php echo $row['ref_no']; ?>" style="display: none;">
                        <select name="regretted_reason" class="input02" >
                            <option value="" disabled selected>Regretted Reason</option>
                            <option value="Price Issue">Price Issue</option>
                            <option value="Equipment Not Available">Equipment Not Available</option>
                            <option value="Other Issue">Other Issue</option>
                        </select>
                    </div>
                    
                    <button class="basic-detail-button" type="submit" name="quote_status_btn">Submit</button>
                </div>
            </form>
        </div>

            <td data-label="Actions">
            <a href="editquotationinfo.php?quote_id=<?php echo urlencode($row['sno']); ?>&id=<?php echo urlencode($sendername); ?>" class="quotation-icon" title="Edit">
            <i style="width: 22px; height: 22px;" class="bi bi-pencil"></i>
            </a>
            <a href="delete_quotation_detail.php?del_id=<?php echo urlencode($row['sno']); ?>&id=<?php echo urlencode($sendername); ?>" onclick="return confirmDelete();" class="quotation-icon" title="Delete">
            <i style="width: 22px; height: 22px;" class="bi bi-trash"></i>
            </a>
            <a href="view_quotationinfo.php?quote_id=<?php echo $row['sno']; ?>&id=<?php echo urlencode($sendername) ?>" class="quotation-icon" title="Print">
                <i style="width: 22px; height: 22px;" class="bi bi-file-text"></i>
            </a>
        </td>
        </tr>
    <?php } ?>
    </tbody>
</table>
<?php } else {
    echo "<p class='fulllength'>No quotations found for this sender.</p>";
} ?>

</body>
<script>
    <?php include "main.js" ?>
    function toggleModal(modalId) {
    var modal = document.getElementById(modalId);
    if (modal) {
        modal.style.display = (modal.style.display === 'block') ? 'none' : 'block';
    } else {
        console.error("Modal with ID " + modalId + " not found.");
    }
}

function confirmDelete() {
        return confirm("Are you sure you want to delete ?");
    }

    document.addEventListener('DOMContentLoaded', function() {
    // Check if choose_Ac2 is not empty and call choose_new_equ2()
    var quotationfilterdd = document.getElementById('quotationfilterdd');
    if (quotationfilterdd.value !== '') {
      quotation_filter();
    }
});

</script>
</html>
