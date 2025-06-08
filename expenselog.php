
<?php 
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


if($_SERVER['REQUEST_METHOD']==='POST'){
    include "partials/_dbconnect.php";
    $assetcode=$_POST['assetcode'];
    $type=$_POST['type'];
    $initiated=$_POST['initiated'];
    $initiate_date=$_POST['initiate_date'];
    $approved=$_POST['approved'];
    $approved_date=$_POST['approved_date'];
    $fund_transfer_date=$_POST['fund_transfer_date'];
    $transfered_to=$_POST['transfered_to'];
    $remark=$_POST['remark'];
    $amount=$_POST['amount'];

    $expenselog = "INSERT INTO `expense` (`assetcode`, `type`, `initiated`, `initiate_date`, 
    `approved`, `approved_date`, `fund_transfer_date`, `transferred_to`, 
    `remark`, `companyname`,`amount`,`logdate`) VALUES ('$assetcode', '$type', '$initiated', '$initiate_date', 
    '$approved', '$approved_date', '$fund_transfer_date', '$transfered_to', 
    '$remark', '$companyname001','$amount',NOW())";
    $resultlog=mysqli_query($conn,$expenselog);
    if($resultlog){
        $showAlert=true;
    }
    else{
        $showError=true;
    }

}
include "partials/_dbconnect.php";
$myexpense = "SELECT * FROM `expense` WHERE companyname='$companyname001' GROUP BY assetcode";
$myexpenseresult=mysqli_query($conn,$myexpense);


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expense</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="tiles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script src="main.js"></script>
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
<form action="expenselog.php" id="expenselogform" method="POST" class="addexpenseform" autocomplete="off">
    <div class="expenseloginner">
        <p class="headingpara">Add Expense</p>
        <div class="trial1">
            <select name="assetcode" id="assetcode" class="input02">
                <option value=""disabled selected>Select Asset Code</option>
                <?php 
                include "partials/_dbconnect.php";
                $sql="SELECT * FROM `fleet1` where companyname='$companyname001' order by assetcode asc";
                $result=mysqli_query($conn,$sql);
                if(mysqli_num_rows($result)>0){
                    while($row=mysqli_fetch_assoc($result)){ ?>
                        <option value="<?php echo $row['assetcode'] ?>"><?php echo $row['assetcode'] .'-'. $row['make'].'-'. $row['model'].'-'. $row['capacity'].''. $row['unit'].'-'. $row['yom']?></option>
                 <?php   }
                }
                ?>
            </select>
        </div>
        <div class="trial1">
            <select name="type" id="" class="input02">
                <option value=""disabled selected>Select Expense Type</option>
                <option value="O&M">O&M</option>
                <option value="Repair-spares">Repair-spares</option>
                <option value="Operating crew">Operating crew</option>
                <option value="Other">Other</option>
            </select>
        </div>
        <div class="outer02">
            <select name="initiated" id="" class="input02">
                <option value=""disabled selected>Request Initiated By</option>
                <?php 
                $initiatedby="SELECT * FROM `team_members` where company_name='$companyname001'";
                $resultinitiatedby=mysqli_query($conn,$initiatedby);
                if(mysqli_num_rows($resultinitiatedby)>0){
                    while($row2=mysqli_fetch_assoc($resultinitiatedby)){
                        ?>
                    <option value="<?php echo $row2['name'] ?>"><?php echo $row2['name'] ?></option>
                        <?php
                    }
                }
                ?>

            </select>
            <div class="trial1">
            <input type="date" name="initiate_date" class="input02" value="<?php echo date('Y-m-d'); ?>">
            <label for="" class="placeholder2">Req Initiated On</label>
            </div>
        </div>

        <div class="outer02">
            <select name="approved" id="" class="input02">
                <option value=""disabled selected>Request Approved By</option>
                <?php 
                $approvedby="SELECT * FROM `team_members` where company_name='$companyname001'";
                $resultapprovedby=mysqli_query($conn,$approvedby);
                if(mysqli_num_rows($resultapprovedby)>0){
                    while($row1=mysqli_fetch_assoc($resultapprovedby)){
                        ?>
                    <option value="<?php echo $row1['name'] ?>"><?php echo $row1['name'] ?></option>
                        <?php
                    }
                }
                ?>
            </select>
            <div class="trial1">
                <input type="date" placeholder="" name="approved_date" class="input02">
                <label for="" class="placeholder2">Req Approved On</label>
            </div>
        </div>
        <div class="outer02">
        <div class="trial1">
                <input type="date" placeholder="" name="fund_transfer_date" class="input02">
                <label for="" class="placeholder2">Fund Transfered On</label>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" name="transfered_to" class="input02">
                <label for="" class="placeholder2">Fund Transfered To</label>
            </div>

        </div>
        <div class="trial1">
        <input type="number" placeholder="" name="amount" class="input02" min="0" step="any">
        <label for="" class="placeholder2">Amount</label>
        </div>
        <div class="trial1">
            <textarea name="remark" id="" placeholder="" class="input02"></textarea>
            <label for="" class="placeholder2">Remarks</label>
        </div>
        <button class="epc-button">Submit</button>
    </div>
</form>
<div class="add_fleet_btn_new" id="btncontaineraddexpense">
<button class="generate-btn" id="addexpensebutton"> 
    <article class="article-wrapper" onclick="addexpense()" id="addexpensebtn"> 
  <div class="rounded-lg container-projectss ">
    </div>
    <div class="project-info">
      <div class="flex-pr">
        <div class="project-title text-nowrap">Add Expense</div>
          <div class="project-hover">
            <svg style="color: black;" xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" color="black" stroke-linejoin="round" stroke-linecap="round" viewBox="0 0 24 24" stroke-width="2" fill="none" stroke="currentColor"><line y2="12" x2="19" y1="12" x1="5"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
            </div>
          </div>
          <div class="types">
        </div>
    </div>
</article>
    </button>

</div>
<?php
if (mysqli_num_rows($myexpenseresult) > 0) { ?>
<div class="viewexpense">
    <h2> <?php echo ucwords ($companyname001) ?>`s Expense Book :</h2>

</div>
<?php
    include "partials/_dbconnect.php";
    // Start the table
    echo '<table class="purchase_table" id="logi_rates"><tr>';

    $loop_count = 1; // Initialize the counter

    while ($row = mysqli_fetch_assoc($myexpenseresult)) {
        if ($loop_count > 0 && $loop_count % 4 == 0) {
            echo '</tr><tr>'; // Close the current row and start a new one after every 4 cards
        }
    
        // Fetch asset information
        $assetinfo = "SELECT * FROM `fleet1` WHERE assetcode = '{$row['assetcode']}' AND companyname = '$companyname001'";
        $assetresult = mysqli_query($conn, $assetinfo);
        $assetrow = mysqli_fetch_assoc($assetresult);
    
        // Only display the card if asset data is fetched
        if ($assetrow) {
            ?>
            <td>
                <div class="custom-card" id="application_card">
                    <h3 class="custom-card__title" onclick="window.location.href='viewexpense.php?id=<?php echo $row['assetcode']; ?>'">Asset Code: <?php echo $row['assetcode']; ?></h3>
                    <p class="insidedetails" id="">Make-Model: <?php echo $assetrow['make'] . ' ' . $assetrow['model']; ?></p>
                    <p class="insidedetails" id="email_logi">Capacity: <?php echo $assetrow['capacity'] . ' ' . $assetrow['unit']; ?></p>
                    <p class="insidedetails">YOM: <?php echo $assetrow['yom']; ?></p>
    
                    <div class="custom-card__arrow">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </div>
            </td>
            <?php
        }
    
        $loop_count++;
    }}
    
    // Close the last row and the table
    echo '</tr></table>';
    ?>
    


</body>

</html>