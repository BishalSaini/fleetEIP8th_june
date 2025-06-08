<?php
session_start();
include "partials/_dbconnect.php";
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
if(isset($_SESSION['success'])){
    $showAlert=true;
    unset($_SESSION['success']);
}
else if(isset($_SESSION['error'])){
    $showError=true;
    unset($_SESSION['error']);
}



$type=$_GET['type'] ?? '';
$assetcodeid=$_GET['assetcodeid'];
$initiated_by=$_GET['initiated_by'] ?? '';
$approved_by=$_GET['approved_by'] ?? '';
$startdate=$_GET['startdate'] ?? '';
$enddate=$_GET['enddate'] ?? '';
$sql = "SELECT * FROM `expense` WHERE companyname='$companyname001' AND assetcode='$assetcodeid'";

// Add conditions for type, initiated_by, approved_by if they are not empty
$conditions = [];

if (!empty($type)) {
    $conditions[] = "`type`='$type'";
}
if (!empty($initiated_by)) {
    $conditions[] = "`initiated`='$initiated_by'";
}
if (!empty($approved_by)) {
    $conditions[] = "`approved`='$approved_by'";
}
if (!empty($startdate) && !empty($enddate)) {
    // Ensure end date includes all records up to the end of the day
    $enddate = date('Y-m-d', strtotime($enddate . ' +1 day')); // Increment end date by one day
    $conditions[] = "`logdate` BETWEEN '$startdate' AND '$enddate'";
}
// If there are conditions, append them to the SQL query
if (count($conditions) > 0) {
    $sql .= " AND " . implode(" AND ", $conditions);
}$result=mysqli_query($conn,$sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expense</title>
    <link rel="stylesheet" href="style.css">
    <script src="main.js"defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js" defer></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

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
            <!-- <li><a href="contact_us.php">Contact Us</a></li> -->
            <li><a href="logout.php">Log Out</a></li></ul>
        </div>
    </div>
    <div class="fulllength">
        <button onclick="downloadsummary()" class="downloadbuttonsummary">Download</button>
        <button onclick="window.location.href='viewexpense.php?id=<?php echo $assetcodeid; ?>'" class="gobackbuttonsummary">
    <i class="bi bi-arrow-left"></i> Go Back
</button>
    </div>
    </div>
    <div class="filters">
    <p>Apply Filter :</p>
    <form action="filterexpense.php" method="GET" class="viewexpensefilterform">
        <select name="filtertype" id="expensefilterselection" onchange="expensefilter()" class="filter_button" required>
            <option value="" disabled selected>Select Filter</option>
            <option value="Expense-Type">Expense-Type</option>
            <option value="Initiated By">Initiated By</option>
            <option value="Approved By">Approved By</option>
            <option value="Date">Date</option>
        </select>
        <div class="outer02" id="startandenddate">
        <div class="trial1">
        <input type="date" placeholder="Start Date" class="filter_button input02">
        <label for="" class="placeholder2">Start Date</label>
        </div>
        <div class="trial1">
        <input type="date" placeholder="Start Date" class="filter_button input02">
        <label for="" class="placeholder2">End Date</label>
        </div>
        </div>

        <select name="type" id="expensetypeselect" class="filter_button" >
                <option value=""disabled selected>Select Expense Type</option>
                <option value="O&M">O&M</option>
                <option value="Repair-spares">Repair-spares</option>
                <option value="Operating crew">Operating crew</option>
                <option value="Other">Other</option>
            </select>
        <select name="initiated_by" id="initiatedbyselect" class="filter_button" >
                <option value=""disabled selected>Initiated By</option>
                <?php 
                include "partials/_dbconnect.php";
                $initiatedby="SELECT * FROM `team_members` where company_name='$companyname001'";
                $resultinitiated=mysqli_query($conn,$initiatedby);
                if(mysqli_num_rows($resultinitiated)>0){
                    while($row=mysqli_fetch_assoc($resultinitiated)){ ?>
                    <option value="<?php echo $row['name'] ?>"><?php echo $row['name'] ?></option>
                 <?php   }
                }
                ?>

            </select>
            <input type="hidden" name="assetcodeid" value="<?php echo $assetcodeid ?>">
        <select name="approved_by" id="approvedbyselect" class="filter_button" >
                <option value=""disabled selected>Approved By</option>
                <?php 
                include "partials/_dbconnect.php";
                $approvedby="SELECT * FROM `team_members` where company_name='$companyname001'";
                $resultapproved=mysqli_query($conn,$approvedby);
                if(mysqli_num_rows($resultapproved)>0){
                    while($row1=mysqli_fetch_assoc($resultapproved)){ ?>
                    <option value="<?php echo $row1['name'] ?>"><?php echo $row1['name'] ?></option>
                 <?php   }
                }
                ?>

            </select>

        <button  id="quotationfilterbutton" class="filter_button">Submit</button>
    </form>
</div>
<div class="expensesummarydetail">
    <?php 
    $assetinfo="SELECT * FROM `fleet1` where companyname='$companyname001' and assetcode='$assetcodeid'";
    $resultassetinfo=mysqli_query($conn,$assetinfo);
    if(mysqli_num_rows($resultassetinfo) > 0){
        $rowasset=mysqli_fetch_assoc($resultassetinfo);
    }
    ?>
    
    <p class="copyright"><img src="favicon.jpg" alt="">Powered By Fleeteip</p>

    <p><strong>Summary Sheet Of Expenses For Asset Code:</strong> <?php echo $assetcodeid .' ('. $rowasset['make'] .' '.$rowasset['model'].' '.$rowasset['yom'].')' ?></p>

    <?php if (!empty($type)): ?>
        <p><strong>Applied Constrain: </strong> Expense-Type <?php echo $type; ?></p>
    <?php endif; ?>

    <?php if (!empty($initiated_by)): ?>
        <p><strong>Applied Constrain: </strong> Initiated-By <?php echo $initiated_by; ?></p>
    <?php endif; ?>

    <?php if (!empty($approved_by)): ?>
        <p><strong>Applied Constrain: </strong> Approved-By <?php echo $approved_by; ?></p>
    <?php endif; ?>

    <?php if (!empty($startdate) && !empty($enddate)): ?>
        <p><strong>Applied Constrain: </strong> Date-Between <?php echo $startdate . ' - ' . $enddate; ?></p>
    <?php endif; ?>

    <?php if (mysqli_num_rows($result) > 0): ?>
        <table class="todotable" id="viewcompletedtasktable">
            <tr>
                <th>Log Date</th>
                <th>Task-Type</th>
                <th>Initiated By</th>
                <th>Approved By</th>
                <th>Transfer Date</th>
                <th>Amount</th>
                <th>Remark</th>
                <th>Action</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo date("jS M y", strtotime($row['logdate'])); ?></td>
                    <td><?php echo $row['type']; ?></td>
                    <td><?php echo $row['initiated']?></td>
                    <td><?php echo $row['approved']?></td>
                    <td><?php echo date("jS M y", strtotime($row['fund_transfer_date'])); ?></td>
                    <td><?php echo $row['amount']?></td>
                    <td class="todatacont"><?php echo $row['remark']?></td>
                    <td data-label="Actions">
                        <a href="viewexpensedetail.php?id=<?php echo $row['id']; ?>&asset_id=<?php echo $assetcodeid; ?>" class="quotation-icon" title="View & Edit">
                            <i style="width: 22px; height: 22px;" class="bi bi-eye"></i>
                        </a>
                        <a href="delexpense.php?id=<?php echo $row['id']; ?>&asset_id=<?php echo $assetcodeid; ?>" class="quotation-icon" title="Delete">
                            <i style="width: 22px; height: 22px;" class="bi bi-trash"></i>
                        </a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <div class="fulllength">No Data Found</div>
    <?php endif; ?>
</div>
</body>
<script>
    function downloadsummary() {
        const element = document.querySelector('.expensesummarydetail');
        
        // Hide the Action column
        const table = element.querySelector('#viewcompletedtasktable');
        const actionColumnIndex = 7; // Assuming the Action column is the 8th column (0-indexed)

        // Hide the header
        const headerRow = table.querySelector('tr');
        const actionHeader = headerRow.children[actionColumnIndex];
        actionHeader.style.display = 'none';

        // Hide all action cells in the rows
        const rows = table.querySelectorAll('tr');
        rows.forEach(row => {
            if (row.children.length > actionColumnIndex) {
                row.children[actionColumnIndex].style.display = 'none';
            }
        });

        // Generate PDF
        html2pdf(element, {
            margin: [0.2, 0.2, 0.2, 0.2], 
            filename: '<?php echo 'Summary' . '.pdf'; ?>',
            image: { type: 'jpeg', quality: 1.0 },
            html2canvas: { 
                dpi: 400, 
                letterRendering: true, 
                scale: 4, 
                useCORS: true 
            },
            jsPDF: { 
                unit: 'in', 
                format: 'letter', 
                orientation: 'portrait' 
            }
        }).then(() => {
            // Show the Action column again after download
            actionHeader.style.display = '';
            rows.forEach(row => {
                if (row.children.length > actionColumnIndex) {
                    row.children[actionColumnIndex].style.display = '';
                }
            });
        });
    }
</script>
</html>

