<?php
session_start();
include "partials/_dbconnect.php";
$email = $_SESSION['email'];
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

// Retrieve and sanitize GET parameters
$quotefilter_date = $_GET['quotefilter_date'] ?? '';
$filterclient = $_GET['filterclient'] ?? '';
$filterstatus = $_GET['filterstatus'] ?? '';
$filterassetcode = $_GET['filterassetcode'] ?? '';
$sendername = $_GET['uname'] ?? '';

// Escape the parameters to prevent SQL injection
$quotefilter_date = mysqli_real_escape_string($conn, $quotefilter_date);
$filterclient = mysqli_real_escape_string($conn, $filterclient);
$filterstatus = mysqli_real_escape_string($conn, $filterstatus);
$filterassetcode = mysqli_real_escape_string($conn, $filterassetcode);

// SQL query to join quotation_generated with quotation_status
$sql = "SELECT qg.*, qs.current_status 
        FROM `quotation_generated` qg
        LEFT JOIN `quotation_status` qs ON qg.ref_no = qs.ref_no
        WHERE qg.company_name='$companyname001' and sender_name='$sendername'";

// Array to store conditions
$conditions = [];

// Add conditions based on filters
if (!empty($quotefilter_date)) {
    $conditions[] = "qg.quote_date='$quotefilter_date'";
}
if (!empty($filterclient)) {
    $conditions[] = "qg.to_name='$filterclient'";
}
if (!empty($filterstatus)) {
    $conditions[] = "qs.current_status='$filterstatus'";
}
if (!empty($filterassetcode)) {
    $conditions[] = "qg.asset_code='$filterassetcode'";
}

// Combine conditions with AND
if (count($conditions) > 0) {
    $sql .= " AND (" . implode(" AND ", $conditions) . ")";
}

// Execute the query
$result = mysqli_query($conn, $sql);

// Check for errors in query execution
if (!$result) {
    die('Query Error: ' . mysqli_error($conn));
}?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script src="main.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <link rel="shortcut icon" href="favicon.jpg" type="image/x-icon">
    <title>Quotation</title>
</head>
<style>
    .quotation-table {
  width: 96%;
  margin-left:2%;
  font-size: 13px;
  border-collapse: collapse;
  margin-top: 20px;
  padding: 10px; 
}
.date_content_td{
  width: 7%;
}
.ref_no_th{
  width: 5%;
}
.quotation-table, .quotation-table th, .quotation-table td {
  border: 1px solid black!important; 
  margin-top:30px;
}

.quotation-table th, .quotation-table td {
  padding: 8px!important;
  text-align: left!important;
}  

.quotation-table .table-heading { 
    background-color: #4067B5!important; 
    color: white!important;
}


</style>
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
    <div class="filters" id="quotationfilter filteroptionnew">
    <p>Apply Filter :</p>
    <form action="quotationfilter.php" class="quotationfilterform" method="GET">
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

<?php 
if(mysqli_num_rows($result)>0){ ?>
    <table class="quotation-table">
    <thead>
      <tr>
        <th class="table-heading date_content_td">Date</th>
        <th class="table-heading ref_no_th">Ref No</th>
        <th class="table-heading">To</th>
        <th class="table-heading">Asset</th>
        <th class="table-heading">Equipment</th>
        <!-- <th class="table-heading">Capacity</th> -->
        <th class="table-heading">Shift</th>
        <th class="table-heading">Rental</th>
        <th class="table-heading">Duration</th>
        <th class="table-heading">Site</th>
  
        <th class="table-heading">Status</th>
  
        <th class="table-heading">Actions</th>
      </tr>
    </thead>
    <tbody>
  
<?php 
while($row=mysqli_fetch_assoc($result)){
    ?>
<tr>
<td data-label="Date"><?php echo date('d-m-y', strtotime($row['quote_date'])); ?></td>
        <td data-label="Ref No"><?php echo $row['ref_no'] ?></td>
        <td class="todatacont" data-label="To"><?php echo $row['to_name'] ?></td>
        <td data-label="Asset Code">
    <?php 
    // Check if the asset_code is "New Equipment" and display "New" if true
    if ($row['asset_code'] === 'New Equipment') {
        echo 'New';
    } else {
        echo htmlspecialchars($row['asset_code']); // Use htmlspecialchars to avoid XSS attacks
    }
    ?>
</td>
        <td data-label="Equipment"><?php echo $row['make'] . " " . $row['model']; ?></td>
        <!-- <td data-label="Capacity"><?php echo $row['cap'] . " " . $row['cap_unit']; ?></td> -->
        <td data-label="Duration"><?php echo $row['shift_info'] ?></td>
        <td data-label="Rental Charges"><?php echo number_format($row['rental_charges']) ?></td>
        <td data-label="Period Contract"><?php echo $row['period_contract'] ?></td>
        <td data-label="Site Location"><?php echo $row['site_loc'] ?></td>
        <td data-label="Current Status" onclick="toggleModal('modal_<?php echo $row['ref_no']; ?>')">
            <?php echo isset($row_crnt_status_check['current_status']) ? $row_crnt_status_check['current_status'] : 'Open'; ?>
        </td>
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
    <?php
}
}
else{
    echo '<p class="norecord"> No Matching Records Were Found </p>';
}

?>

</body>
</html>