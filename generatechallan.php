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

$sql_cn="SELECT * FROM `cn` where companyname='$companyname001'";
$result_cn=mysqli_query($conn,$sql_cn);

$sql_max_ref_no = "SELECT MAX(challannumber) AS max_ref_no FROM `challans` WHERE companyname = '$companyname001'";
$result_max_ref_no = mysqli_query($conn, $sql_max_ref_no);
$row_max_ref_no = mysqli_fetch_assoc($result_max_ref_no);
$next_ref_no = ($row_max_ref_no['max_ref_no'] === null) ? 1 : $row_max_ref_no['max_ref_no'] + 1;


?>
<?php
include "partials/_dbconnect.php";
if(isset($_POST['challansubmit'])){

    $cnnumber = $_POST['cnnumber'] ?? '';
$consignor = $_POST['consignor'] ?? '';
$source_station = $_POST['source_station'] ?? '';
$companyname = $_POST['companyname'] ?? '';
$consignee = $_POST['consignee'] ?? '';
$destination_station = $_POST['destination_station'] ?? '';
$vehicle_type = $_POST['vehicle_type'] ?? '';
$capacity = $_POST['capacity'] ?? '';
$vehicle_ownership = $_POST['vehicle_ownership'] ?? '';
$vehicle_reg_no = $_POST['vehicle_reg_no'] ?? '';
$driver_name = $_POST['driver_name'] ?? '';
$driver_mobile = $_POST['driver_mobile'] ?? '';
$broker_name = $_POST['broker_name'] ?? '';
$broker_mobile = $_POST['broker_mobile'] ?? '';
$no_of_package = $_POST['no_of_package'] ?? '';
$actual_weight = $_POST['actual_weight'] ?? '';
$charged_weight = $_POST['charged_weight'] ?? '';
$lorryhire = $_POST['lorryhire'] ?? '';
$loading_charge = $_POST['loading_charge'] ?? '';
$height_charge = $_POST['height_charge'] ?? '';
$length_charge = $_POST['length_charge'] ?? '';
$detention_charge = $_POST['detention_charge'] ?? '';
$misc_expense = $_POST['misc_expense'] ?? '';
$total_hire = $_POST['total_hire'] ?? '';
$advance = $_POST['advance'] ?? '';
$balance = $_POST['balance'] ?? '';
$remark = $_POST['remark'] ?? '';
$brokercontactperson = $_POST['brokercontactperson'] ?? '';
$owner_name = $_POST['owner_name'] ?? '';
$dl = $_POST['dl'] ?? '';
$tripid = $_POST['tripid'] ?? '';
$Challannumber = $_POST['Challannumber'] ?? '';




$sql = "INSERT INTO challans (
    cnnumber, consignor, source_station, companyname, consignee, 
    destination_station, vehicle_type, capacity, vehicle_ownership, 
    vehicle_reg_no, driver_name, driver_mobile, broker_name, broker_mobile, 
    no_of_package, actual_weight, charged_weight, lorryhire, loading_charge, 
    height_charge, length_charge, detention_charge, misc_expense, 
    total_hire, advance, balance, remark, dl, owner_name, brokercontactperson, challannumber, associate_trip_id
) VALUES (
    '$cnnumber', '$consignor', '$source_station', '$companyname', '$consignee', 
    '$destination_station', '$vehicle_type', '$capacity', '$vehicle_ownership', 
    '$vehicle_reg_no', '$driver_name', '$driver_mobile', '$broker_name', '$broker_mobile', 
    '$no_of_package', '$actual_weight', '$charged_weight', '$lorryhire', '$loading_charge', 
    '$height_charge', '$length_charge', '$detention_charge', '$misc_expense', 
    '$total_hire', '$advance', '$balance', '$remark', '$dl', '$owner_name', '$brokercontactperson', $Challannumber, $tripid
)";
$result=mysqli_query($conn,$sql);
if($result){
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
    <link rel="icon" href="favicon.jpg" type="image/x-icon">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js"></script>
<script src="challanlogidata.js"defer></script>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Challan</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="tiles.css">
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
    <div class="add_fleet_btn_new" id="logiquotation">
<button class="generate-btn"> 
    <article class="article-wrapper" onclick="window.location.href='generatedchallan.php'" id="viewcnbutton"> 
  <div class="rounded-lg container-projectss ">
    </div>
    <div class="project-info">
      <div class="flex-pr">
        <div class="project-title text-nowrap">Generated Challan</div>
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

    <form action="generatechallan.php" method="POST" class="generatechallan" autocomplete="off">
    <div class="generatechallancontainer">
        <p class="headingpara">Generate Challan</p>
        <div class="outer02">
        <div class="trial1">
            <select name="cnnumber" id="cnnumber" class="input02">
                <option value="" disabled selected>Challan Against CN</option>
                <?php 
                if(mysqli_num_rows($result_cn) > 0){
                    while($row = mysqli_fetch_assoc($result_cn)) { ?>
                        <option value="<?php echo $row['cnnumber']; ?>"><?php echo $row['cnnumber'] .' - ' .$row['consignor'] .' - ' . $row['booking_station']; ?></option>
                <?php
                    }
                }
                ?>
            </select>
        </div>
        <div class="trial1">
            <input type="text" placeholder="" value="<?php echo $next_ref_no ?>" name="Challannumber" class="input02">
            <label for="" class="placeholder2">Challan Number</label>
        </div>

        </div>
        <div class="outer02">
            <div class="trial1">
                <input type="text" name="consignor" id="consignor" placeholder="" class="input02">
                <label for="consignor" class="placeholder2">Consignor</label>
            </div>
            <div class="trial1">
                <input type="text" name="source_station" id="source_station" placeholder="" class="input02">
                <label for="source_station" class="placeholder2">Source Station</label>
            </div>
        </div>
        <input type="hidden" name="companyname" id="logicompanyname" value="<?php echo $companyname001 ?>">
        <div class="outer02">
            <div class="trial1">
                <input type="text" name="consignee" id="consignee" placeholder="" class="input02">
                <label for="consignee" class="placeholder2">Consignee</label>
            </div>
            <div class="trial1">
                <input type="text" name="destination_station" id="destination_station" placeholder="" class="input02">
                <label for="destination_station" class="placeholder2">Destination Station</label>
            </div>
        </div>
        <div class="outer02">
            <div class="trial1">
                <input type="text" name="no_of_package" id="no_of_package" placeholder="" class="input02">
                <label for="no_of_package" class="placeholder2">No Of Package</label>
            </div>
            <div class="trial1">
                <input type="text" name="actual_weight" id="actual_weight" placeholder="" class="input02">
                <label for="actual_weight" class="placeholder2">Actual Weight</label>
            </div>
            <div class="trial1">
                <input type="text" name="charged_weight" id="charged_weight" placeholder="" class="input02">
                <label for="charged_weight" class="placeholder2">Charged Weight</label>
            </div>
        </div>

        <div class="outer02">
            <div class="trial1">
                <select name="vehicle_type" id="vehicle_type" class="input02">
                    <option value="" disabled selected>Vehicle Type</option>
                    <option value="Trailor">Trailor</option>
                    <option value="Truck">Truck</option>
                    <option value="Container">Container</option>
                    <option value="Tempo">Tempo</option>
                </select>
            </div>
            <div class="trial1">
                <input type="number" name="capacity" id="capacity" placeholder="" class="input02">
                <label for="capacity" class="placeholder2">Capacity In Ton</label>
            </div>
            <div class="trial1">
                <select name="vehicle_ownership" id="vehicle_ownership" class="input02" onchange="markethired()">
                    <option value="" disabled selected>Vehicle Ownership</option>
                    <option value="Market Hired">Market Hired</option>
                    <option value="Company Owned">Company Owned</option>
                </select>
            </div>
            <div class="trial1">
                <input type="text" name="vehicle_reg_no" id="vehicle_reg_no" placeholder="" class="input02">
                <label for="vehicle_reg_no" class="placeholder2">Vehicle Reg-No</label>
            </div>
        </div>
        <div class="outer02">
            <div class="trial1">
                <input type="text" name="driver_name" id="driver_name" placeholder="" class="input02">
                <label for="driver_name" class="placeholder2">Driver Name</label>
            </div>
            
            <div class="trial1">
                <input type="text" name="dl" id="" placeholder="" class="input02">
                <label for="driver_name" class="placeholder2">Driver License</label>
            </div>

            <div class="trial1">
                <input type="text" name="driver_mobile" id="driver_mobile" placeholder="" class="input02">
                <label for="driver_mobile" class="placeholder2">Mobile Number</label>
            </div>
        </div>
        <div class="outer02" id="marketvehicleoptions">
            <div class="trial1">
                <input type="text" name="broker_name" id="broker_name" placeholder="" class="input02">
                <label for="broker_name" class="placeholder2">Broker Company</label>
            </div>
            <div class="trial1">
                <input type="text" name="brokercontactperson" id="" placeholder="" class="input02">
                <label for="broker_mobile" class="placeholder2">Contact Person</label>
            </div>

            <div class="trial1">
                <input type="text" name="broker_mobile" id="broker_mobile" placeholder="" class="input02">
                <label for="broker_mobile" class="placeholder2">Mobile Number</label>
            </div>
            <div class="trial1">
                <input type="text" name="owner_name" id="" placeholder="" class="input02">
                <label for="broker_mobile" class="placeholder2">Owner Name</label>
            </div>

        </div>
        <div class="outer02">
        <div class="trial1">
            <input type="text" name="lorryhire" id="lorryhire" placeholder="" oninput="calculateTotal()" class="input02">
            <label for="lorryhire" class="placeholder2">Lorry Hire</label>
        </div>

            <div class="trial1">
                <input type="text" name="loading_charge" id="loading_charge" oninput="calculateTotal()" placeholder="" class="input02">
                <label for="loading_charge" class="placeholder2">Loading Charge</label>
            </div>
            <div class="trial1">
                <input type="text" name="height_charge" id="height_charge" oninput="calculateTotal()" placeholder="" class="input02">
                <label for="height_charge" class="placeholder2">Height Charge</label>
            </div>
            <div class="trial1">
                <input type="text" name="length_charge" id="length_charge" oninput="calculateTotal()" placeholder="" class="input02">
                <label for="length_charge" class="placeholder2">Length Charge</label>
            </div>
        </div>
        <div class="outer02">
            <div class="trial1">
                <input type="text" name="detention_charge" id="detention_charge" oninput="calculateTotal()" placeholder="" class="input02">
                <label for="detention_charge" class="placeholder2">Detention Charge</label>
            </div>
            <div class="trial1">
                <input type="text" name="misc_expense" id="misc_expense" oninput="calculateTotal()" placeholder="" class="input02">
                <label for="misc_expense" class="placeholder2">Miscellaneous Charge</label>
            </div>
        </div>
        <div class="outer02">
            <div class="trial1">
                <input type="text" name="total_hire" id="total_hire" placeholder="" class="input02" readonly>
                <label for="total_hire" class="placeholder2">Total Hire</label>
            </div>
            <div class="trial1">
                <input type="text" name="advance" id="advance" placeholder="" oninput="calculateTotal()" class="input02">
                <label for="advance" class="placeholder2">Advance</label>
            </div>
            <div class="trial1">
                <input type="text" name="balance" id="balance" placeholder="" class="input02" readonly>
                <label for="balance" class="placeholder2">Balance</label>
            </div>
        </div>
        <div class="trial1">
            <input type="text" placeholder="" name="tripid"  class="input02">
            <label for="" class="placeholder2">Associated Trip ID If Any</label>
        </div>
        <div class="trial1">
            <textarea name="remark" id="remark" class="input02" placeholder=""></textarea>
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
    
    </script>
</html>