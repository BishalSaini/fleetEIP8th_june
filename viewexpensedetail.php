<?php 

$id=$_GET['id'];
$assetid=$_GET['asset_id'];
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
$sql="SELECT * FROM `expense` where id='$id' and companyname='$companyname001'";
$result=mysqli_query($conn,$sql);
$data=mysqli_fetch_assoc($result);



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include "partials/_dbconnect.php";
    $assetcode = $_POST['assetcode'];
    $type = $_POST['type'];
    $initiated = $_POST['initiated'];
    $initiate_date = $_POST['initiate_date'];
    $approved = $_POST['approved'];
    $approved_date = $_POST['approved_date'];
    $fund_transfer_date = $_POST['fund_transfer_date'];
    $transfered_to = $_POST['transfered_to'];
    $remark = $_POST['remark'];
    $amount = $_POST['amount'];
    $editassetid=$_POST['editassetid'];
    $editid = $_POST['id']; // Assuming you have an ID to update

    $expenselog = "UPDATE `expense` SET 
        `assetcode` = '$assetcode', 
        `type` = '$type', 
        `initiated` = '$initiated', 
        `initiate_date` = '$initiate_date', 
        `approved` = '$approved', 
        `approved_date` = '$approved_date', 
        `fund_transfer_date` = '$fund_transfer_date', 
        `transferred_to` = '$transfered_to', 
        `remark` = '$remark', 
        `amount` = '$amount'
    WHERE `id` = '$editid'";

    $resultlog = mysqli_query($conn, $expenselog);
    if ($resultlog) {
        session_start();
        $_SESSION['success']='success';
        header("Location: viewexpense.php?id=" . urlencode($editassetid));
        exit(); // It's good practice to call exit after a header redirect
    }
        else {
            session_start();
            $_SESSION['error']='success';
            header("Location: viewexpense.php?id=" . urlencode($editassetid));
            exit(); // It's good practice to call exit after a header redirect
        }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View And Edit</title>
    <link rel="stylesheet" href="style.css">
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
    <form action="viewexpensedetail.php" id="" method="POST" class="addexpenseform" autocomplete="off">
    <div class="expenseloginner">
        <p class="headingpara">View / Edit Expense</p>
        <div class="trial1">
            <input type="text" placeholder="" value="<?php echo $data['logdate'] ?>" class="input02" readonly>
            <label for="" class="placeholder2">Log Date</label>
        </div>
        <div class="trial1">
            <select name="assetcode" id="assetcode" class="input02">
                <option value=""disabled selected>Select Asset Code</option>
                <?php 
                include "partials/_dbconnect.php";
                $sql="SELECT * FROM `fleet1` where companyname='$companyname001' order by assetcode asc";
                $result=mysqli_query($conn,$sql);
                if(mysqli_num_rows($result)>0){
                    while($row=mysqli_fetch_assoc($result)){ ?>
                        <option <?php if($data['assetcode']=== $row['assetcode']){echo 'selected';} ?> value="<?php echo $row['assetcode'] ?>"><?php echo $row['assetcode'] .'-'. $row['make'].'-'. $row['model'].'-'. $row['capacity'].''. $row['unit'].'-'. $row['yom']?></option>
                 <?php   }
                }
                ?>
            </select>
        </div>
        <input type="hidden" value="<?php echo $id; ?>" name="id">
        <input type="hidden" value="<?php echo $assetid; ?>" name="editassetid">
        <div class="trial1">
            <select name="type" id="" class="input02">
                <option value=""disabled selected>Select Expense Type</option>
                <option <?php if($data['type']==='O&M'){echo 'selected';} ?> value="O&M">O&M</option>
                <option <?php if($data['type']==='Repair-spares'){echo 'selected';} ?> value="Repair-spares">Repair-spares</option>
                <option <?php if($data['type']==='Operating crew'){echo 'selected';} ?> value="Operating crew">Operating crew</option>
                <option <?php if($data['type']==='Other'){echo 'selected';} ?> value="Other">Other</option>
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
                    <option <?php if($data['initiated']===$row2['name']){echo 'selected';} ?> value="<?php echo $row2['name'] ?>">Initiated By : <?php echo $row2['name'] ?></option>
                        <?php
                    }
                }
                ?>

            </select>
            <div class="trial1">
            <input type="date" name="initiate_date" class="input02" value="<?php echo $data['initiate_date']; ?>">
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
                    <option <?php if($data['approved']===$row1['name']){echo 'selected';} ?>  value="<?php echo $row1['name'] ?>">Approved By : <?php echo $row1['name'] ?></option>
                        <?php
                    }
                }
                ?>
            </select>
            <div class="trial1">
                <input type="date" placeholder="" value="<?php echo $data['approved_date'] ?>" name="approved_date" class="input02">
                <label for="" class="placeholder2">Req Approved On</label>
            </div>
        </div>
        <div class="outer02">
        <div class="trial1">
                <input type="date" placeholder="" value="<?php echo $data['fund_transfer_date'] ?>" name="fund_transfer_date" class="input02">
                <label for="" class="placeholder2">Fund Transfered On</label>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" value="<?php echo $data['transferred_to'] ?>" name="transfered_to" class="input02">
                <label for="" class="placeholder2">Fund Transfered To</label>
            </div>

        </div>
        <div class="trial1">
        <input type="number" placeholder="" name="amount" value="<?php echo $data['amount'] ?>" class="input02" min="0" step="any">
        <label for="" class="placeholder2">Amount</label>
        </div>
        <div class="trial1">
            <textarea name="remark" id="" placeholder="" class="input02"><?php echo $data['remark'] ?></textarea>
            <label for="" class="placeholder2">Remarks</label>
        </div>
        <button class="epc-button">Submit</button>
    </div>
</form>

</body>
</html>