<?php
include "partials/_dbconnect.php";
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$companyname001 = $_SESSION['companyname'];
$enterprise = $_SESSION['email'];
$email = $_SESSION['email'];

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

?>
<?php
if (isset($_SESSION['success'])) {
    $showAlert = true;
    unset($_SESSION['success']);
} else if (isset($_SESSION['error'])) {
    $showError = true;
    unset($_SESSION['error']);

}

// $prev_date = date('Y-m-d', strtotime($date . ' -1 day'));  // Get the previous date
// $query = "SELECT closed_hmr, closed_km FROM logsheetnew WHERE assetcode = '$assetcode' AND date = '$prev_date' ORDER BY date DESC LIMIT 1";
// $result = mysqli_query($conn, $query);

// if ($result && mysqli_num_rows($result) > 0) {
//     $row = mysqli_fetch_assoc($result);
//     $prev_hmr = $row['closed_hmr'];
//     $prev_km = $row['closed_km'];
// }


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include "partials/_dbconnect.php";
    $date = $_POST['date'];
    $dayondate = $_POST['dayondate'];
    $assetcode = $_POST['assetcode'];
    $shift = $_POST['shift'];
    $equipmenttype = $_POST['equipmenttype'];
    $make = $_POST['make'];
    $model = $_POST['model'];
    $clientname = $_POST['clientname'];
    $projectname = $_POST['projectname'];
    $worefno = $_POST['worefno'];
    $rentalcharges = $_POST['rentalcharges'];
    $workingdays = $_POST['workingdays'];
    $conditions = $_POST['conditions'];
    $start_time = $_POST['start_time'];
    $close_time = $_POST['close_time'];
    $start_hmr = $_POST['start_hmr'];
    $closed_hmr = $_POST['closed_hmr'];
    $start_km = $_POST['start_km'];
    $closed_km = $_POST['closed_km'];
    $night_start_time = $_POST['night_start_time'];
    $night_close_time = $_POST['night_close_time'];
    $night_start_hmr = $_POST['night_start_hmr'];
    $night_closed_hmr = $_POST['night_closed_hmr'];
    $night_start_km = $_POST['night_start_km'];
    $night_closed_km = $_POST['night_closed_km'];
    $fuel_taken = $_POST['fuel_taken'];
    $engineer_name = $_POST['engineer_name'];
    $operator_name = $_POST['operator_name'];
    $night_engineer = $_POST['night_engineer'];
    $second_operator = $_POST['second_operator'];
    $remark = $_POST['remark'];
    $breakdown_hours = $_POST['breakdown_hours'];
    $breakdown_reason = $_POST['breakdown_reason'];
    $breakdown_hours = $_POST['breakdown_hours'];
    $otprorata = $_POST['otprorata'];
    $otnotes = $_POST['otnotes'];
    $email = $_SESSION['email'];  // Assuming session stores user email
    $companyname001 = $_SESSION['companyname'];
    $logtype = $_POST['logtype'];
    $othours = $_POST['othours'];
    $month_year=$_POST['month_year'];
    $sitelocation=$_POST['sitelocation'];
    $shift_hour=$_POST['shift_hour'];


    $query = "INSERT INTO logsheetnew (
    date,sitelocation,shift_hour,month_year, dayondate,logtype, assetcode, shift, equipmenttype, make, model, clientname, projectname, 
    worefno, rentalcharges, workingdays, conditions, start_time, close_time, start_hmr, closed_hmr, 
    start_km, closed_km, night_start_time, night_close_time, night_start_hmr, night_closed_hmr, 
    night_start_km, night_closed_km, fuel_taken, engineer_name, operator_name, night_engineer, 
    second_operator, remark, breakdown_hours, breakdown_reason, othours, otprorata, otnotes, createdby, companyname
) VALUES (
    '$date','$sitelocation','$shift_hour','$month_year', '$dayondate','$logtype', '$assetcode', '$shift', '$equipmenttype', '$make', '$model', '$clientname', '$projectname', 
    '$worefno', '$rentalcharges', '$workingdays', '$conditions', '$start_time', '$close_time', '$start_hmr', '$closed_hmr', 
    '$start_km', '$closed_km', '$night_start_time', '$night_close_time', '$night_start_hmr', '$night_closed_hmr', 
    '$night_start_km', '$night_closed_km', '$fuel_taken', '$engineer_name', '$operator_name', '$night_engineer', 
    '$second_operator', '$remark', '$breakdown_hours', '$breakdown_reason','$othours', '$otprorata', '$otnotes', '$email', '$companyname001'
)";
    $result = mysqli_query($conn, $query);
    if ($result) {
        $_SESSION['success'] = 'true';
    } else {
        $_SESSION['error'] = 'true';
    }
    header("Location: logsheetdashboard.php");
    exit();


}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Log Sheet</title>
    <link rel="stylesheet" href="style.css">
    <script src="main.js"></script>
    <link rel="shortcut icon" href="favicon.jpg" type="image/x-icon">
</head>

<body>
    <div class="navbar1">
        <div class="logo_fleet">
            <img src="logo_fe.png" alt="FLEET EIP" onclick="window.location.href='<?php echo $dashboard_url ?>'">
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
        echo '<label>
    <input type="checkbox" class="alertCheckbox" autocomplete="off" />
    <div class="alert notice">
      <span class="alertClose">X</span>
      <span class="alertText_addfleet"><b>Success!</b>LogSheet Added Successfully
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
    <div class="fulllength" id="typeoflogsheet">
        <button class="tripupdate_generatecn rmccalbtn" onclick="toggleChange('shift')">Shift Log</button>
        <button class="tripupdate_generatecn rmccalbtn" onclick="toggleChange('breakdown')">Breakdown Log</button>
        <button class="tripupdate_generatecn rmccalbtn" onclick="toggleChange('ot')">Over Time Log</button>
    </div>

    <form action="logsheet.php" class="outerform" method="POST" autocomplete="off">
        <div class="logsheet_container">
            <p class="headingpara">Log Sheet</p>
            <div class="outer02">
                <input type="hidden" name="logtype" value="<?php echo 'shift'; ?>" id="logtype" placeholder=""
                    class="input02" readonly>

                <div class="trial1">
                    <input type="date" name="date" id="date" class="input02">
                    <label for="date" class="placeholder2">Date</label>
                </div>
                <input type="hidden" placeholder="" id="monthandyear" name="month_year" class="input02">

                <div class="trial1">
                    <input type="text" name="dayondate" id="dayondate" placeholder="" class="input02" readonly>
                    <label for="dayondate" class="placeholder2">Day</label>
                </div>
            </div> 
            <div class="outer02">  
                      <!-- Fleet Category Dropdown -->
                <div class="trial1">
                    <select id="fleet_category" class="input02" onchange="updateAssetCodeDropdown()" required>
                        <option value="" disabled selected>Select Fleet Category</option>
                        <option value="Aerial Work Platform">Aerial Work Platform</option>
                        <option value="Concrete Equipment">Concrete Equipment</option>
                        <option value="EarthMovers and Road Equipments">EarthMovers and Road Equipments</option>
                        <option value="Material Handling Equipments">Material Handling Equipments</option>
                        <option value="Ground Engineering Equipments">Ground Engineering Equipments</option>
                        <option value="Trailor and Truck">Trailor and Truck</option>
                        <option value="Generator and Lighting">Generator and Lighting</option>
                    </select>
                </div>
                <!-- Asset Code Dropdown (populated by JS) -->
                <div class="trial1">
                    <select name="assetcode" id="assetcode" class="input02"
                        onchange="onAssetCodeChange()" required>
                        <option value="" disabled selected>Choose Asset Code</option>
                        <option value="New Equipment">Choose New Equipment</option>
                        <!-- Options will be dynamically populated -->
                    </select>
                </div>
                <div class="trial1">
                    <select name="shift" id="shift_dd" onchange="shiftrelatedfield()" class="input02">
                        <option value="" disabled selected>Shift</option>
                        <option value="Single Shift">Single Shift</option>
                        <option value="Double Shift">Double Shift</option>
                        <!-- <option value="Breakdown">Breakdown</option> -->
                    </select>
                </div>
                <div class="trial1">
                    <input type="text" placeholder="" name="shift_hour" id="workinghourinput" class="input02">
                    <label for="" class="placeholder2">Working Hours</label>
                </div>
                <div class="trial1">
                    <input type="text" placeholder="" name="sitelocation" id="sitelocation" class="input02">
                    <label for="" class="placeholder2">Site Location</label>
                </div>

            </div> 

            <div class="outer02"> 
            <div class="trial1">
                    <select id="new_fleet_category" class="input02" onchange="updateFleetTypeOptions()" required>
                        <option value="" disabled selected>Select Fleet Category</option>
                        <option value="Aerial Work Platform">Aerial Work Platform</option>
                        <option value="Concrete Equipment">Concrete Equipment</option>
                        <option value="EarthMovers and Road Equipments">EarthMovers and Road Equipments</option>
                        <option value="Material Handling Equipments">Material Handling Equipments</option>
                        <option value="Ground Engineering Equipments">Ground Engineering Equipments</option>
                        <option value="Trailor and Truck">Trailor and Truck</option>
                        <option value="Generator and Lighting">Generator and Lighting</option>
                    </select>
                </div>
                <div class="trial1">
                    <select id="new_fleet_type" class="input02" name="equipmenttype" required>
                        <option value="" disabled selected>Select Fleet Type</option>
                        <!-- Options will be dynamically populated based on category -->
                    </select>
                </div>
            </div>
            <div class="outer02">
                <div class="trial1">
                    <input type="text" id="equipmenttype" name="equipmenttype" class="input02" placeholder="">
                    <label for="" class="placeholder2">Equipment Type</label>
                </div>
                <div class="trial1">
                    <input type="text" id="equipmentmake" name="make" class="input02" placeholder="">
                    <label for="" class="placeholder2">Asset Make</label>
                </div>

                <div class="trial1">
                    <input type="text" id="equipmentmodel" name="model" class="input02" placeholder="">
                    <label for="" class="placeholder2">Asset Model</label>
                </div>

            </div>
            <div class="outer02">
                <div class="trial1">
                    <input type="text" name="clientname" placeholder="" id="clientname" class="input02">
                    <label for="" class="placeholder2">Client Name</label>
                </div>
                <div class="trial1">
                    <input type="text" name="projectname" placeholder="" id="projectname" class="input02">
                    <label for="" class="placeholder2">Project Name</label>
                </div>
                <div class="trial1">
                    <input type="text" placeholder="" name="worefno" id="workorder_ref" class="input02">
                    <label for="" class="placeholder2">WO Ref No</label>
                </div>
            </div>
            <div class="outer02">
                <div class="trial1">
                    <input type="text" placeholder="" name="rentalcharges" id="rentalcharges" class="input02">
                    <label for="" class="placeholder2">Rental Charges</label>
                </div>
                <div class="trial1">
                    <input type="text" placeholder="" name="workingdays" id="workingdays" class="input02">
                    <label for="" class="placeholder2">Working Days</label>
                </div>
                <div class="trial1">
                    <input type="text" placeholder="" name="conditions" id="workingconditions" class="input02">
                    <label for="" class="placeholder2">Condition</label>
                </div>
            </div>
            <div class="outer02" id="singleshift1">
                <div class="trial1">
                    <input type="time" name="start_time" placeholder="" class="input02">
                    <label for="" class="placeholder2">Start Time</label>
                </div>
                <div class="trial1">
                    <input type="time" name="close_time" placeholder="" class="input02">
                    <label for="" class="placeholder2">Close Time</label>
                </div>
            </div>
            <div class="outer02" id="singleshift2">
                <div class="trial1">
                    <input type="number" name="start_hmr" id="start_hmr_container" value="" placeholder=""
                        class="input02">
                    <label for="" class="placeholder2">Start HMR</label>
                </div>
                <div class="trial1">
                    <input type="number" name="closed_hmr" id="morning_closedhmr" placeholder="" class="input02">
                    <label for="" class="placeholder2">Closed HMR</label>
                </div>
            </div>
            <div class="outer02" id="singleshift3">
                <div class="trial1">
                    <input type="number" name="start_km" id="kmr" placeholder="" class="input02">
                    <label for="" class="placeholder2">Start KMR</label>
                </div>
                <div class="trial1">
                    <input type="number" id="closedkmr" name="closed_km"  placeholder="" class="input02">
                    <label for="" class="placeholder2">Closed KMR</label>
                </div>
            </div>

            <div class="outer02" id="doubleshift1">
                <div class="trial1">
                    <input type="time" name="night_start_time" placeholder="" class="input02">
                    <label for="" class="placeholder2">Night Start Time</label>
                </div>
                <div class="trial1">
                    <input type="time" name="night_close_time" placeholder="" class="input02">
                    <label for="" class="placeholder2">Night Close Time</label>
                </div>
            </div>
            <div class="outer02" id="doubleshift2">
                <div class="trial1">
                    <input type="number" name="night_start_hmr" id="night_hmr_start" placeholder="" class="input02">
                    <label for="" class="placeholder2">Night Start HMR</label>
                </div>
                <div class="trial1">
                    <input type="text" name="night_closed_hmr" placeholder="" class="input02">
                    <label for="" class="placeholder2">Night Closed HMR</label>
                </div>
            </div>
            <div class="outer02" id="doubleshift3">
                <div class="trial1">
                    <input type="text" name="night_start_km" placeholder="" id="nightstartkmrinput" class="input02">
                    <label for="" class="placeholder2">Night Start KMR</label>
                </div>
                <div class="trial1">
                    <input type="text" name="night_closed_km" placeholder="" class="input02">
                    <label for="" class="placeholder2">Night Closed KMR</label>
                </div>
            </div>

            <div class="outer02" id="singleshift4">
                <div class="trial1">
                    <input type="text" name="fuel_taken" placeholder="" class="input02">
                    <label for="" class="placeholder2">Fuel Taken</label>
                </div>
                <div class="trial1">
                    <input type="text" name="engineer_name" placeholder="" class="input02">
                    <label for="" class="placeholder2">1st Shift Engineer Name</label>
                </div>
                <div class="trial1">
                    <input type="text" placeholder="" id="op1" name="operator_name" class="input02">
                    <label for="" class="placeholder2"> 1st Shift Operator Name</label>
                </div>

            </div>
            <div class="outer02" id="doubleshift4">
                <div class="trial1">
                    <input type="text" placeholder="" name="night_engineer" class="input02">
                    <label for="" class="placeholder2">2nd Shift Engineer</label>
                </div>
                <div class="trial1">
                    <input type="text" placeholder="" name="second_operator" class="input02">
                    <label for="" class="placeholder2">2nd Shift Operator</label>
                </div>

            </div>
            <div class="trial1" id="shiftremark">
                <textarea name="remark" id="" placeholder="" class="input02"></textarea>
                <label for="" class="placeholder2">Remark If Any</label>
            </div>

            <div class="trial1" id="breakdown1">
                <input type="text" name="breakdown_hours" placeholder="" class="input02">
                <label for="" class="placeholder2">Breakdown Hours</label>
            </div>
            <div class="trial1" id="breakdown2">
                <textarea name="breakdown_reason" id="" placeholder="" class="input02"></textarea>
                <label for="" class="placeholder2">Breakdown Reason</label>
            </div>
            <div class="outer02" id="ot1">
                <div class="trial1">
                    <input type="text" name="othours" placeholder="" class="input02">
                    <label for="" class="placeholder2">Over Time Hours</label>
                </div>
                <div class="trial1">
                    <input type="text" placeholder="" name="otprorata" id="prorata" class="input02">
                    <label for="" class="placeholder2">OT Pro Rata</label>
                </div>
            </div>
            <div class="trial1" id="ot2">
                <textarea name="otnotes" id="" placeholder="" class="input02"></textarea>
                <label for="" class="placeholder2">Notes</label>
            </div>
            <button class="epc-button">Submit</button>

            <!-- New Equipment Fields (hidden by default, shown when "Choose New Equipment" is selected) -->
        
        </div>
    </form>
</body>
<script>
document.getElementById('morning_closedhmr').addEventListener('input', function() {
    const shift_dd = document.getElementById("shift_dd"); 
    if (shift_dd.value === 'Double') {
        document.getElementById('night_hmr_start').value = this.value;
    }
});

document.getElementById('closedkmr').addEventListener('input', function() {
    const shift_dd = document.getElementById("shift_dd"); 
    if (shift_dd.value === 'Double') {
        document.getElementById('nightstartkmrinput').value = this.value;
    }
});


const dateInput = document.getElementById('date');
const dayInput = document.getElementById('dayondate');
const monthAndYearInput = document.getElementById('monthandyear');

// Add an event listener to detect changes in the date input
dateInput.addEventListener('change', function () {
    const selectedDate = new Date(this.value); // Parse the selected date
    
    // Get the day of the week
    const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
    const day = days[selectedDate.getDay()]; 
    dayInput.value = day || ''; // Set the day in the text input

    // Get the month and year
    const month = selectedDate.toLocaleString('default', { month: 'long' }); // e.g., January
    const year = selectedDate.getFullYear(); // e.g., 2024
    monthAndYearInput.value = `${month} ${year}`; // Set month and year in the second input
});

    function fetchassetDetails(assetnumber) {
        fetch(`fetchlogsheetdata.php?assetnumber=${assetnumber}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('equipmenttype').value = data?.sub_type || '';
                document.getElementById('equipmentmake').value = data?.make || '';
                document.getElementById('equipmentmodel').value = data?.model || '';
                document.getElementById('clientname').value = data?.client_name || '';
                document.getElementById('projectname').value = data?.project_name || '';
                document.getElementById('workingdays').value = data?.working_days_in_month || '';
                document.getElementById('workingconditions').value = data?.condition_sundays || '';
                document.getElementById('rentalcharges').value = data?.rental_charges_wo || '';
                document.getElementById('sitelocation').value = data?.project_location || '';
                document.getElementById('workinghourinput').value = data?.hour_shift || '';


                var shift_dd = document.getElementById('shift_dd');
                // Only set value if shift_dd is visible
                if (getComputedStyle(shift_dd).display !== 'none') {
                    shift_dd.value = data?.shift_wo || '';
                    shift_dd.onchange();
                } else {
                    shift_dd.value = '';
                }

                document.getElementById('workorder_ref').value = data?.workorder_ref || '';
                document.getElementById('prorata').value = data?.ot_charges || '';
                document.getElementById('op1').value = data?.operator_fname || '';
            })
            .catch(() => {  // Handle errors
                document.getElementById('equipmenttype').value = '';
                document.getElementById('equipmentmake').value = '';
                document.getElementById('equipmentmodel').value = '';
                document.getElementById('clientname').value = '';
                document.getElementById('projectname').value = '';
                document.getElementById('shift_dd').value = '';
                document.getElementById('workorder_ref').value = '';
                document.getElementById('prorata').value = '';
                document.getElementById('workingdays').value = '';
                document.getElementById('workingconditions').value = '';
                document.getElementById('rentalcharges').value = '';
                document.getElementById('op1').value = '';
                document.getElementById('sitelocation').value = '';
                document.getElementById('workinghourinput').value = '';


            });
    }

    function toggleChange(type) {
        if (type === 'breakdown') {
            document.getElementById("singleshift1").style.display = 'none';
            document.getElementById("singleshift2").style.display = 'none';
            document.getElementById("singleshift3").style.display = 'none';
            document.getElementById("singleshift4").style.display = 'none';

            document.getElementById("doubleshift1").style.display = 'none';
            document.getElementById("doubleshift2").style.display = 'none';
            document.getElementById("doubleshift3").style.display = 'none';
            document.getElementById("doubleshift4").style.display = 'none';

            document.getElementById("breakdown1").style.display = 'block';
            document.getElementById("breakdown2").style.display = 'block';
            document.getElementById("logtype").value = 'breakdown';

            document.getElementById("shift_dd").style.display = 'none';
            document.getElementById("ot1").style.display = 'none';
            document.getElementById("ot2").style.display = 'none';
            document.getElementById("shiftremark").style.display = 'none';
        } else if (type === 'ot') {
            document.getElementById("singleshift1").style.display = 'none';
            document.getElementById("singleshift2").style.display = 'none';
            document.getElementById("singleshift3").style.display = 'none';
            document.getElementById("singleshift4").style.display = 'none';

            document.getElementById("logtype").value = 'ot';


            document.getElementById("doubleshift1").style.display = 'none';
            document.getElementById("doubleshift2").style.display = 'none';
            document.getElementById("doubleshift3").style.display = 'none';
            document.getElementById("doubleshift4").style.display = 'none';


            document.getElementById("breakdown1").style.display = 'none';
            document.getElementById("breakdown2").style.display = 'none';
            document.getElementById("shift_dd").style.display = 'none';
            document.getElementById("ot1").style.display = 'flex';
            document.getElementById("ot2").style.display = 'block';
            document.getElementById("shiftremark").style.display = 'none';
        } else if (type === 'shift') {
            document.getElementById("singleshift1").style.display = 'flex';
            document.getElementById("singleshift2").style.display = 'flex';
            document.getElementById("singleshift3").style.display = 'flex';
            document.getElementById("singleshift4").style.display = 'flex';

            document.getElementById("logtype").value = 'shift';



            document.getElementById("breakdown1").style.display = 'none';
            document.getElementById("breakdown2").style.display = 'none';
            document.getElementById("shift_dd").style.display = 'block';
            document.getElementById("ot1").style.display = 'none';
            document.getElementById("ot2").style.display = 'none';
            document.getElementById("shiftremark").style.display = 'block';
        }
    }



    function fetchCombinedDetails() {
    const assetcode = document.getElementById("assetcode").value;
    const equipmenttype = document.getElementById("equipmenttype").value;
    const equipmentmake = document.getElementById("equipmentmake").value;
    const equipmentmodel = document.getElementById("equipmentmodel").value;

    const params = new URLSearchParams({
        assetcode: assetcode,
        equipmenttype: equipmenttype,
        equipmentmake: equipmentmake,
        equipmentmodel: equipmentmodel
    });

    fetch(`fetch_combined_details.php?${params.toString()}`)
        .then(response => response.json())
        .then(data => {
            let startHmrValue = '';
            let startKmrValue = '';

            if (data && data.match_found) {
                startHmrValue = data.closed_hmr || '';
                startKmrValue = data.closed_km || '';
                // Autofill additional fields
                document.getElementById('clientname').value = data.clientname || '';
                document.getElementById('workingdays').value = data.workingdays || '';
                document.getElementById('workingconditions').value = data.conditions || '';
                document.getElementById('projectname').value = data.projectname || '';
            }

            document.getElementById('start_hmr_container').value = startHmrValue || '';
            document.getElementById('kmr').value = startKmrValue || '';
        })
        .catch(error => {
            document.getElementById('start_hmr_container').value = '';
            document.getElementById('kmr').value = '';
            // Clear additional fields on error
            document.getElementById('clientname').value = '';
            document.getElementById('workingdays').value = '';
            document.getElementById('workingconditions').value = '';
            document.getElementById('projectname').value = '';
        });
}


    document.getElementById("date").addEventListener("change", fetchCombinedDetails);
document.getElementById("assetcode").addEventListener("change", fetchCombinedDetails);
document.getElementById("equipmenttype").addEventListener("change", fetchCombinedDetails);
document.getElementById("equipmentmake").addEventListener("change", fetchCombinedDetails);
document.getElementById("equipmentmodel").addEventListener("change", fetchCombinedDetails);
document.getElementById("sitelocation").addEventListener("change", fetchCombinedDetails);


function updateAssetCodeDropdown() {
    var fleetCategory = document.getElementById('fleet_category').value;
    var assetCodeDropdown = document.getElementById('assetcode');
    assetCodeDropdown.innerHTML = '<option value="" disabled selected>Choose Asset Code</option><option value="New Equipment">Choose New Equipment</option>';
    // AJAX to fetch asset codes for selected category
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "fetch_asset_codes.php?fleet_category=" + encodeURIComponent(fleetCategory), true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            try {
                var response = JSON.parse(xhr.responseText);
                if (response.error) return;
                response.forEach(function (asset) {
                    var option = document.createElement("option");
                    option.value = asset.assetcode;
                    option.text = asset.assetcode + " (" + asset.sub_type + " " + asset.make + " " + asset.model + " " + asset.capacity + " " + asset.unit + ") " + asset.status;
                    if (asset.status.toLowerCase() === "idle") {
                        option.style.backgroundColor = "lightgreen";
                    } else if (asset.status.toLowerCase() === "working") {
                        option.style.backgroundColor = "lightcoral";
                    }
                    assetCodeDropdown.appendChild(option);
                });
            } catch (e) { }
        }
    };
    xhr.send();
}

function onAssetCodeChange() {
    var assetCode = document.getElementById('assetcode').value;
    var newFields = document.getElementById('new_equipment_fields');
    if (assetCode === "New Equipment") {
        newFields.style.display = "flex";
        // Clear autofill fields
        document.getElementById('equipmenttype').value = '';
        document.getElementById('equipmentmake').value = '';
        document.getElementById('equipmentmodel').value = '';
        // Optionally clear other autofill fields
    } else {
        newFields.style.display = "none";
        // Call autofill as usual
        fetchassetDetails(assetCode);
        setTimeout(fetchCombinedDetails, 200);
    }
}

// Fleet type options by category (same as generate_quotation.php)
const fleetTypeOptions = {
    "Aerial Work Platform": [
        "Self Propelled Articulated Boomlift",
        "Scissor Lift Diesel",
        "Scissor Lift Electric",
        "Spider Lift",
        "Self Propelled Straight Boomlift",
        "Truck Mounted Articulated Boomlift",
        "Truck Mounted Straight Boomlift"
    ],
    "Concrete Equipment": [
        "Batching Plant",
        "Self Loading Mixer",
        "Concrete Boom Placer",
        "Concrete Pump",
        "Moli Pump",
        "Mobile Batching Plant",
        "Static Boom Placer",
        "Transit Mixer",
        "Shotcrete boom"
    ],
    "EarthMovers and Road Equipments": [
        "Baby Roller",
        "Backhoe Loader",
        "Bulldozer",
        "Excavator",
        "Milling Machine",
        "Motor Grader",
        "Pneumatic Tyre Roller",
        "Single Drum Roller",
        "Skid Loader",
        "Slip Form Paver",
        "Soil Compactor",
        "Tandem Roller",
        "Vibratory Roller",
        "Wheeled Excavator",
        "Wheeled Loader"
    ],
    "Material Handling Equipments": [
        "Fixed Tower Crane",
        "Fork Lift Diesel",
        "Fork Lift Electric",
        "Hammerhead Tower Crane",
        "Hydraulic Crawler Crane",
        "Luffing Jib Tower Crane",
        "Mechanical Crawler Crane",
        "Pick and Carry Crane",
        "Reach Stacker",
        "Rough Terrain Crane",
        "Telehandler",
        "Telescopic Crawler Crane",
        "Telescopic Mobile Crane",
        "All Terrain Mobile Crane",
        "Self Loading Truck Crane"
    ],
    "Ground Engineering Equipments": [
        "Hydraulic Drilling Rig",
        "Rotary Drilling Rig",
        "Vibro Hammer"
    ],
    "Trailor and Truck": [
        "Dumper",
        "Truck",
        "Water Tanker",
        "Low Bed",
        "Semi Low Bed",
        "Flatbed",
        "Hydraulic Axle"
    ],
    "Generator and Lighting": [
        "Silent Diesel Generator",
        "Mobile Light Tower",
        "Diesel Generator"
    ]
};

function updateFleetTypeOptions() {
    var category = document.getElementById('new_fleet_category').value;
    var typeSelect = document.getElementById('new_fleet_type');
    typeSelect.innerHTML = '<option value="" disabled selected>Select Fleet Type</option>';
    if (fleetTypeOptions[category]) {
        fleetTypeOptions[category].forEach(function(type) {
            var option = document.createElement('option');
            option.value = type;
            option.text = type;
            typeSelect.appendChild(option);
        });
    }
}
</script>

</html>