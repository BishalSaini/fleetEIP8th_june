<?php 
$assetid=$_GET['id'];
session_start();
$showAlert=false;
$showError=false;

$email1=$_SESSION['email'];
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
if(isset($_SESSION['success'])){
    $showAlert=true;
    unset($_SESSION['success']);
}
else if(isset($_SESSION['error'])){
    $showError=true;
    unset($_SESSION['error']);
}

include "partials/_dbconnect.php";
$sql="SELECT * FROM `expense` where assetcode='$assetid' and companyname='$companyname001' order by logdate desc";
$result=mysqli_query($conn,$sql);




?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Expense</title>
    <link rel="stylesheet" href="style.css">
    <script src="main.js"defer></script>
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
            <li><a href="logout.php">Log Out</a></li></ul>
        </div>
    </div>
    <?php
if($showAlert){
    echo '<label>
    <input type="checkbox" class="alertCheckbox" autocomplete="off" />
    <div class="alert notice">
        <span class="alertClose">X</span>
        <span class="alertText">Success<br class="clear"/></span>
    </div>
    </label>';
}
if($showError){
    echo '<label>
    <input type="checkbox" class="alertCheckbox" autocomplete="off" />
    <div class="alert error">
        <span class="alertClose">X</span>
        <span class="alertText">Something Went Wrong<br class="clear"/></span>
    </div>
    </label>';
}
?>

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
        <input type="date" name="startdate" placeholder="" class="filter_button input02">
        <label for="" class="placeholder2">Start Date</label>
        </div>
        <div class="trial1">
        <input type="date" name="enddate" placeholder="" class="filter_button input02">
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
            <input type="hidden" name="assetcodeid" value="<?php echo $assetid ?>">
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


    <?php
if(mysqli_num_rows($result)>0){ ?>
    <table class="todotable" id="viewexpensetable">
    <tr>
                <th>Task-Type</th>
                <th>Initiated By</th>
                <th>Approved By</th>
                <th>Transfer Date</th>
                <th>Transfered To</th>
                <th>Amount</th>
                <th>Remark</th>
                <th>Action</th>
            </tr>
            <?php
            while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                    <td><?php echo $row['type']; ?></td>
                    <td><?php echo $row['initiated']?></td>
                    <td><?php echo $row['approved']?></td>
                        <td><?php echo date("jS M y", strtotime($row['fund_transfer_date'])); ?></td>
                        <td><?php echo $row['transferred_to']?></td>
                        <td><?php echo $row['amount']?></td>

                        <td title="<?php echo $row['remark']?>" class="todatacont"><?php echo $row['remark']?></td>

                        <td data-label="Actions">
            <a href="viewexpensedetail.php?id=<?php echo $row['id']; ?>&asset_id=<?php echo $assetid; ?>" class="quotation-icon" title="View & Edit">
            <i style="width: 22px; height: 22px;" class="bi bi-eye"></i>
            </a>
            <a href="delexpense.php?id=<?php echo $row['id']; ?>&asset_id=<?php echo $assetid; ?>" class="quotation-icon" title="Delete">
            <i style="width: 22px; height: 22px;" class="bi bi-trash"></i>
            </a>
        </td>
                    </tr>
                <?php }
            } else{ ?>
            <tr>
            <td colspan="6"><div class="fulllength">No Data Found</div></td>
            </tr>

    </table>
<?php
}
?>

</body>
</html>