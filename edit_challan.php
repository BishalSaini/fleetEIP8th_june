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
$id=$_GET['id'];
$sql_cn="SELECT * FROM `cn` where companyname='$companyname001'";
$result_cn=mysqli_query($conn,$sql_cn);

$sqlchallan="SELECT * FROM `challans` where companyname='$companyname001' and id='$id'";
$result_challan=mysqli_query($conn,$sqlchallan);
$roww=mysqli_fetch_assoc($result_challan);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        include "partials/_dbconnect.php";
    $consignor = $_POST['consignor'];
$source_station = $_POST['source_station'];
$consignee = $_POST['consignee'];
$destination_station = $_POST['destination_station'];
$no_of_package = $_POST['no_of_package'];
$actual_weight = $_POST['actual_weight'];
$charged_weight = $_POST['charged_weight'];
$vehicle_type = $_POST['vehicle_type'];
$capacity = $_POST['capacity'];
$vehicle_ownership = $_POST['vehicle_ownership'];
$vehicle_reg_no = $_POST['vehicle_reg_no'];
$driver_name = $_POST['driver_name'];
$driver_mobile = $_POST['driver_mobile'];
$broker_name = $_POST['broker_name'];
$broker_mobile = $_POST['broker_mobile'];
$lorryhire = $_POST['lorryhire'];
$loading_charge = $_POST['loading_charge'];
$height_charge = $_POST['height_charge'];
$length_charge = $_POST['length_charge'];
$detention_charge = $_POST['detention_charge'];
$misc_expense = $_POST['misc_expense'];
$total_hire = $_POST['total_hire'];
$advance = $_POST['advance'];
$balance = $_POST['balance'];
$remark = $_POST['remark'];
$editid=$_POST['editid'];
$brokercontactperson = $_POST['brokercontactperson'] ?? '';
$owner_name = $_POST['owner_name'] ?? '';
$dl = $_POST['dl'] ?? '';
$tripid = $_POST['tripid'] ?? '';



$sqledit = "UPDATE challans SET 
    consignor = '$consignor', 
    source_station = '$source_station', 
    consignee = '$consignee', 
    destination_station = '$destination_station', 
    no_of_package = '$no_of_package', 
    actual_weight = '$actual_weight', 
    charged_weight = '$charged_weight', 
    vehicle_type = '$vehicle_type', 
    capacity = '$capacity', 
    vehicle_ownership = '$vehicle_ownership', 
    vehicle_reg_no = '$vehicle_reg_no', 
    driver_name = '$driver_name', 
    driver_mobile = '$driver_mobile', 
    broker_name = '$broker_name', 
    broker_mobile = '$broker_mobile', 
    lorryhire = '$lorryhire', 
    loading_charge = '$loading_charge', 
    height_charge = '$height_charge', 
    length_charge = '$length_charge', 
    detention_charge = '$detention_charge', 
    misc_expense = '$misc_expense', 
    total_hire = '$total_hire', 
    advance = '$advance', 
    balance = '$balance', 
    remark = '$remark',
    dl= '$dl', 
    owner_name = '$owner_name',
    brokercontactperson = '$brokercontactperson',
    associate_trip_id = '$tripid'
WHERE id = '$editid'";
$resultedit=mysqli_query($conn,$sqledit);
if($resultedit){
    session_start();
    $_SESSION['success']='success';
    header("Location:generatedchallan.php");
}
else{
    $_SESSION['error']='success';
    header("Location:generatedchallan.php");
}

}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="favicon.jpg" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
    <title>Edit Challan</title>
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

<form action="edit_challan.php" method="POST" class="generatechallan" autocomplete="off">
    <div class="generatechallancontainer">
        <p class="headingpara">Edit Challan</p>
        <div class="outer02">
        <div class="trial1">
            <select name="cnnumber" id="cnnumber" class="input02">
                <option value="" disabled selected>Challan Against CN</option>
                <?php 
                if(mysqli_num_rows($result_cn) > 0){
                    while($row = mysqli_fetch_assoc($result_cn)) { ?>
                        <option <?php if($roww['cnnumber']===$row['cnnumber']){ echo 'selected';} ?> value="<?php echo $row['cnnumber']; ?>"><?php echo $row['cnnumber'] .' - ' .$row['consignor'] .' - ' . $row['booking_station']; ?></option>
                <?php
                    }
                }
                ?>
            </select>
        </div>
        <div class="trial1">
            <input type="text" palceholder="" value="<?php echo $roww['challannumber'] ?>" class="input02" readonly>
            <label for="" class="placeholder2">Challan Number</label>
        </div>
        </div>
        <div class="outer02">
    <div class="trial1">
        <input type="text" name="consignor" id="consignor" placeholder="" class="input02" value="<?php echo htmlspecialchars($roww['consignor']); ?>">
        <label for="consignor" class="placeholder2">Consignor</label>
    </div>
    <div class="trial1">
        <input type="text" name="source_station" id="source_station" placeholder="" class="input02" value="<?php echo htmlspecialchars($roww['source_station']); ?>">
        <label for="source_station" class="placeholder2">Source Station</label>
    </div>
</div>
<input type="hidden" name="companyname" id="logicompanyname" value="<?php echo htmlspecialchars($roww['companyname']); ?>">
<input type="hidden" name="editid" id="" value="<?php echo $id ?>">
<div class="outer02">
    <div class="trial1">
        <input type="text" name="consignee" id="consignee" placeholder="" class="input02" value="<?php echo htmlspecialchars($roww['consignee']); ?>">
        <label for="consignee" class="placeholder2">Consignee</label>
    </div>
    <div class="trial1">
        <input type="text" name="destination_station" id="destination_station" placeholder="" class="input02" value="<?php echo htmlspecialchars($roww['destination_station']); ?>">
        <label for="destination_station" class="placeholder2">Destination Station</label>
    </div>
</div>
<div class="outer02">
    <div class="trial1">
        <input type="text" name="no_of_package" id="no_of_package" placeholder="" class="input02" value="<?php echo htmlspecialchars($roww['no_of_package']); ?>">
        <label for="no_of_package" class="placeholder2">No Of Package</label>
    </div>
    <div class="trial1">
        <input type="text" name="actual_weight" id="actual_weight" placeholder="" class="input02" value="<?php echo htmlspecialchars($roww['actual_weight']); ?>">
        <label for="actual_weight" class="placeholder2">Actual Weight</label>
    </div>
    <div class="trial1">
        <input type="text" name="charged_weight" id="charged_weight" placeholder="" class="input02" value="<?php echo htmlspecialchars($roww['charged_weight']); ?>">
        <label for="charged_weight" class="placeholder2">Charged Weight</label>
    </div>
</div>

<div class="outer02">
    <div class="trial1">
        <select name="vehicle_type" id="vehicle_type" class="input02">
            <option value="" disabled>Select Vehicle Type</option>
            <option value="Trailor" <?php if ($roww['vehicle_type'] == 'Trailor') echo 'selected'; ?>>Trailor</option>
            <option value="Truck" <?php if ($roww['vehicle_type'] == 'Truck') echo 'selected'; ?>>Truck</option>
            <option value="Container" <?php if ($roww['vehicle_type'] == 'Container') echo 'selected'; ?>>Container</option>
            <option value="Tempo" <?php if ($roww['vehicle_type'] == 'Tempo') echo 'selected'; ?>>Tempo</option>
        </select>
    </div>
    <div class="trial1">
        <input type="number" name="capacity" id="capacity" placeholder="" class="input02" value="<?php echo htmlspecialchars($roww['capacity']); ?>">
        <label for="capacity" class="placeholder2">Capacity In Ton</label>
    </div>
    <div class="trial1">
        <select name="vehicle_ownership" id="vehicle_ownership" class="input02" onchange="markethired()">
            <option value="" disabled>Select Vehicle Ownership</option>
            <option value="Market Hired" <?php if ($roww['vehicle_ownership'] == 'Market Hired') echo 'selected'; ?>>Market Hired</option>
            <option value="Company Owned" <?php if ($roww['vehicle_ownership'] == 'Company Owned') echo 'selected'; ?>>Company Owned</option>
        </select>
    </div>
    <div class="trial1">
        <input type="text" name="vehicle_reg_no" id="vehicle_reg_no" placeholder="" class="input02" value="<?php echo htmlspecialchars($roww['vehicle_reg_no']); ?>">
        <label for="vehicle_reg_no" class="placeholder2">Vehicle Reg-No</label>
    </div>
</div>
<div class="outer02">
    <div class="trial1">
        <input type="text" name="driver_name" id="driver_name" placeholder="" class="input02" value="<?php echo htmlspecialchars($roww['driver_name']); ?>">
        <label for="driver_name" class="placeholder2">Driver Name</label>
    </div>
    <div class="trial1">
                <input type="text" name="dl" id="" value="<?php echo htmlspecialchars($roww['dl']); ?>" placeholder="" class="input02">
                <label for="driver_name" class="placeholder2">Driver License</label>
            </div>

    <div class="trial1">
        <input type="text" name="driver_mobile" id="driver_mobile" placeholder="" class="input02" value="<?php echo htmlspecialchars($roww['driver_mobile']); ?>">
        <label for="driver_mobile" class="placeholder2">Mobile Number</label>
    </div>
</div>
<div class="outer02" id="marketvehicleoptions">
    <div class="trial1">
        <input type="text" name="broker_name" id="broker_name" placeholder="" class="input02" value="<?php echo htmlspecialchars($roww['broker_name']); ?>">
        <label for="broker_name" class="placeholder2">Broker Name</label>
    </div>
    <div class="trial1">
                <input type="text" name="brokercontactperson" id="" value="<?php echo htmlspecialchars($roww['brokercontactperson']); ?>" placeholder="" class="input02">
                <label for="broker_mobile" class="placeholder2">Contact Person</label>
            </div>

    <div class="trial1">
        <input type="text" name="broker_mobile" id="broker_mobile" placeholder="" class="input02" value="<?php echo htmlspecialchars($roww['broker_mobile']); ?>">
        <label for="broker_mobile" class="placeholder2">Mobile Number</label>
    </div>
    <div class="trial1">
                <input type="text" name="owner_name" id=""value="<?php echo htmlspecialchars($roww['owner_name']); ?>"  placeholder="" class="input02">
                <label for="broker_mobile" class="placeholder2">Owner Name</label>
            </div>

</div>
<div class="outer02">
    <div class="trial1">
        <input type="text" name="lorryhire" id="lorryhire" placeholder="" oninput="calculateTotal()" class="input02" value="<?php echo htmlspecialchars($roww['lorryhire']); ?>">
        <label for="lorryhire" class="placeholder2">Lorry Hire</label>
    </div>
    <div class="trial1">
        <input type="text" name="loading_charge" id="loading_charge" oninput="calculateTotal()" placeholder="" class="input02" value="<?php echo htmlspecialchars($roww['loading_charge']); ?>">
        <label for="loading_charge" class="placeholder2">Loading Charge</label>
    </div>
    <div class="trial1">
        <input type="text" name="height_charge" id="height_charge" oninput="calculateTotal()" placeholder="" class="input02" value="<?php echo htmlspecialchars($roww['height_charge']); ?>">
        <label for="height_charge" class="placeholder2">Height Charge</label>
    </div>
    <div class="trial1">
        <input type="text" name="length_charge" id="length_charge" oninput="calculateTotal()" placeholder="" class="input02" value="<?php echo htmlspecialchars($roww['length_charge']); ?>">
        <label for="length_charge" class="placeholder2">Length Charge</label>
    </div>
</div>
<div class="outer02">
    <div class="trial1">
        <input type="text" name="detention_charge" id="detention_charge" oninput="calculateTotal()" placeholder="" class="input02" value="<?php echo htmlspecialchars($roww['detention_charge']); ?>">
        <label for="detention_charge" class="placeholder2">Detention Charge</label>
    </div>
    <div class="trial1">
        <input type="text" name="misc_expense" id="misc_expense" oninput="calculateTotal()" placeholder="" class="input02" value="<?php echo htmlspecialchars($roww['misc_expense']); ?>">
        <label for="misc_expense" class="placeholder2">Miscellaneous Charge</label>
    </div>
</div>
<div class="outer02">
    <div class="trial1">
        <input type="text" name="total_hire" id="total_hire" placeholder="" class="input02" readonly value="<?php echo htmlspecialchars($roww['total_hire']); ?>">
        <label for="total_hire" class="placeholder2">Total Hire</label>
    </div>
    <div class="trial1">
        <input type="text" name="advance" id="advance" placeholder="" oninput="calculateTotal()" class="input02" value="<?php echo htmlspecialchars($roww['advance']); ?>">
        <label for="advance" class="placeholder2">Advance</label>
    </div>
    <div class="trial1">
        <input type="text" name="balance" id="balance" placeholder="" class="input02" readonly value="<?php echo htmlspecialchars($roww['balance']); ?>">
        <label for="balance" class="placeholder2">Balance</label>
    </div>
</div>
<div class="trial1">
    <input type="text" name="tripid" placeholder="" value="<?php echo $roww['associate_trip_id'] ?>" class="input02">
    <label for="" class="placeholder2">Associate Trip ID</label>
</div>
<div class="trial1">
    <textarea name="remark" id="remark" class="input02" placeholder=""><?php echo htmlspecialchars($roww['remark']); ?></textarea>
    <label for="remark" class="placeholder2">Remark If Any</label>
</div>
        <button type="submit" name="challansubmit" class="epc-button">Submit</button>
    </div>
</form>

</body>
<script>
function calculateTotal() {
        // Get the values of the input fields
        let lorryhire = parseFloat(document.getElementById('lorryhire').value) || 0;
        let loadingCharge = parseFloat(document.getElementById('loading_charge').value) || 0;
        let heightCharge = parseFloat(document.getElementById('height_charge').value) || 0;
        let lengthCharge = parseFloat(document.getElementById('length_charge').value) || 0;
        let detentionCharge = parseFloat(document.getElementById('detention_charge').value) || 0;
        let miscExpense = parseFloat(document.getElementById('misc_expense').value) || 0;
        let advance = parseFloat(document.getElementById('advance').value) || 0;

        // Calculate the total
        let totalHire = lorryhire + loadingCharge + heightCharge + lengthCharge + detentionCharge + miscExpense;

        // Calculate the balance
        let balance = totalHire - advance;

        // Set the total in the total_hire input field
        document.getElementById('total_hire').value = totalHire.toFixed(2);

        // Set the balance in the balance input field
        document.getElementById('balance').value = balance.toFixed(2);
    }
    function markethired(){
        const vehicle_ownership=document.getElementById("vehicle_ownership");
        const marketvehicleoptions=document.getElementById("marketvehicleoptions");
        if(vehicle_ownership.value==='Market Hired'){
            marketvehicleoptions.style.display='flex';
        }
        else{
            marketvehicleoptions.style.display='none';

        }
    }
    document.addEventListener('DOMContentLoaded', function() {
    // Check if oem_fleet_type7 is not empty and call seco_equip_2()
    var vehicle = document.getElementById('vehicle_ownership');
    if (vehicle.value !== '') {
        markethired();
    }
});

    
    </script>

</html>