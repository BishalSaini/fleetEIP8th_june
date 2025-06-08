<?php
include("partials/_dbconnect.php");
session_start();
$companyname001=$_SESSION['companyname'];
$enterprise = $_SESSION['enterprise'];
$email = $_SESSION['email'];

$id=$_GET['id'];
$assetcode=$_GET['assetcode'];
$worefno=$_GET['worefno'];


$sql = "SELECT * FROM logsheetnew WHERE id='$id' AND companyname='$companyname001'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);

}
else{
    $row[""] = "";
}

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

$showAlert=false;
$showError=false;


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
    $otprorata = $_POST['otprorata'];
    $otnotes = $_POST['otnotes'];
    $logtype = $_POST['logtype'];
    $editid=$_POST['editid'];
    $othours=$_POST['othours'];


    if (isset($id)) {
        // Update existing record if ID is present
        $query = "UPDATE logsheetnew SET 
            date='$date', 
            dayondate='$dayondate', 
            othours='$othours',
            logtype='$logtype', 
            assetcode='$assetcode', 
            shift='$shift', 
            equipmenttype='$equipmenttype', 
            make='$make', 
            model='$model', 
            clientname='$clientname', 
            projectname='$projectname', 
            worefno='$worefno', 
            rentalcharges='$rentalcharges', 
            workingdays='$workingdays', 
            conditions='$conditions', 
            start_time='$start_time', 
            close_time='$close_time', 
            start_hmr='$start_hmr', 
            closed_hmr='$closed_hmr', 
            start_km='$start_km', 
            closed_km='$closed_km', 
            night_start_time='$night_start_time', 
            night_close_time='$night_close_time', 
            night_start_hmr='$night_start_hmr', 
            night_closed_hmr='$night_closed_hmr', 
            night_start_km='$night_start_km', 
            night_closed_km='$night_closed_km', 
            fuel_taken='$fuel_taken', 
            engineer_name='$engineer_name', 
            operator_name='$operator_name', 
            night_engineer='$night_engineer', 
            second_operator='$second_operator', 
            remark='$remark', 
            breakdown_hours='$breakdown_hours', 
            breakdown_reason='$breakdown_reason', 
            otprorata='$otprorata', 
            otnotes='$otnotes', 
            createdby='$email', 
            companyname='$companyname001' 
            WHERE id='$editid'";
    } 

    // Execute the query
    $result = mysqli_query($conn, $query);
    if ($result) {
        $_SESSION['success'] = 'true';
    } else {
        $_SESSION['error'] = 'true';
    }

    // Redirect back to dashboard
    header("Location: logsheetdashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Log Sheet</title>
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="favicon.jpg" type="image/x-icon">
    <script src="main.js"></script>
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


<form action="editlogsheet.php?id=<?php echo $id; ?>" class="outerform" method="POST" autocomplete="off">
        <div class="logsheet_container">
            <p class="headingpara">View/Edit Log Sheet</p>
            <div class="outer02">
            <input type="hidden" name="logtype" value="<?php echo $row['logtype']; ?>" id="logtype" placeholder="" class="input02" readonly>
<input type="hidden" name="editid" value="<?php echo $id ; ?>">
            <div class="trial1">
    <input type="date" name="date" id="date" value="<?php echo isset($row['date']) ? htmlspecialchars($row['date']) : ''; ?>" placeholder="" class="input02">
    <label for="date" class="placeholder2">Date</label>
</div>
<div class="trial1">
    <input type="text" name="dayondate" id="dayondate" value="<?php echo $row['dayondate'] ?? ''; ?>" placeholder="" class="input02" readonly>
    <label for="dayondate" class="placeholder2">Day</label>
</div>
            </div>
            <div class="outer02">
                <div class="trial1">
                    <select name="assetcode" id="" class="input02"  onchange="fetchassetDetails(this.value)">
                        <option value="" disabled selected>Choose Asset Code </option>
                        <?php
                        $assetcode = "SELECT * FROM `fleet1` where companyname='$companyname001'";
                        $result = mysqli_query($conn, $assetcode);
                        if (mysqli_num_rows($result) > 0) {
                            while ($row1 = mysqli_fetch_assoc($result)) {
                                ?>
                                <option <?php if($row['assetcode']=== $row1['assetcode']){echo 'selected';} ?> value="<?php echo $row1['assetcode'] ?>">
                                    <?php echo $row1['assetcode'] . '-' . $row1['sub_type'] . '-' . $row1['yom'] . '-' . $row1['capacity'] . $row1['unit'] ?>
                                </option>
                            <?php }
                        } ?>
                    </select>
                </div>

                <div class="trial1">
                    <select name="shift" id="shift_dd" onchange="shiftrelatedfield()" class="input02">
                        <option value="" disabled selected>Shift</option>
                        <option <?php if($row['shift']==='Single'){echo 'selected';} ?> value="Single">Single Shift</option>
                        <option <?php if($row['shift']==='Double'){echo 'selected';} ?> value="Double">Double Shift</option>
                        <!-- <option value="Breakdown">Breakdown</option> -->
                    </select>
                </div>

            </div>
            <div class="outer02">

                <div class="trial1">
                    <input type="text" placeholder="" value="<?php echo $row['equipmenttype'] ?? ''; ?>" id="equipmenttype" name="equipmenttype" class="input02">
                    <label for="" class="placeholder2">Equipment Type</label>
                </div>
                <div class="trial1">
                    <input type="text" placeholder="" value="<?php echo $row['make'] ?? ''; ?>" id="equipmentmake" name="make" class="input02">
                    <label for="" class="placeholder2">Asset Make</label>
                </div>

                <div class="trial1">
                    <input type="text" placeholder="" id="equipmentmodel" value="<?php echo $row['model'] ?? ''; ?>" name="model" class="input02">
                    <label for="" class="placeholder2">Asset Model</label>
                </div>

            </div>
            <div class="outer02">
                <div class="trial1">
                    <input type="text" value="<?php echo $row['clientname'] ?? ''; ?>" name="clientname" placeholder="" id="clientname" class="input02">
                    <label for="" class="placeholder2">Client Name</label>
                </div>
                <div class="trial1">
                    <input type="text" name="projectname" value="<?php echo $row['projectname'] ?? ''; ?>" placeholder="" id="projectname" class="input02">
                    <label for="" class="placeholder2">Project Name</label>
                </div>
                <div class="trial1">
                    <input type="text" placeholder="" name="worefno" value="<?php echo $row['worefno'] ?? ''; ?>" id="workorder_ref" class="input02">
                    <label for="" class="placeholder2">WO Ref No</label>
                </div>
            </div>
            <div class="outer02">
                <div class="trial1">
                    <input type="text" placeholder="" name="rentalcharges" value="<?php echo $row['rentalcharges'] ?? ''; ?>" id="rentalcharges" class="input02">
                    <label for="" class="placeholder2">Rental Charges</label>
                </div>
                <div class="trial1">
                    <input type="text" placeholder="" name="workingdays" value="<?php echo $row['workingdays'] ?? ''; ?>" id="workingdays" class="input02">
                    <label for="" class="placeholder2">Working Days</label>
                </div>
                <div class="trial1">
                    <input type="text" placeholder="" name="conditions" value="<?php echo $row['conditions'] ?? ''; ?>" id="workingconditions" class="input02">
                    <label for="" class="placeholder2">Condition</label>
                </div>
            </div>
            <div class="outer02" id="singleshift1">
                <div class="trial1">
                    <input type="time" name="start_time" placeholder="" value="<?php echo $row['start_time'] ?? ''; ?>" class="input02">
                    <label for="" class="placeholder2">Start Time</label>
                </div>
                <div class="trial1">
                    <input type="time" name="close_time" placeholder="" value="<?php echo $row['close_time'] ?? ''; ?>" class="input02">
                    <label for="" class="placeholder2">Close Time</label>
                </div>
            </div>
            <div class="outer02" id="singleshift2" >
                <div class="trial1">
                    <input type="number" name="start_hmr" id="start_hmr_container" value="<?php echo $row['start_hmr'] ?? ''; ?>" value="" placeholder="" class="input02">
                    <label for="" class="placeholder2">Start HMR</label>
                </div>
                <div class="trial1">
                    <input type="number" name="closed_hmr" placeholder="" value="<?php echo $row['closed_hmr'] ?? ''; ?>" class="input02">
                    <label for="" class="placeholder2">Closed HMR</label>
                </div>
            </div>
            <div class="outer02" id="singleshift3">
                <div class="trial1">
                    <input type="number" name="start_km" id="kmr" value="<?php echo $row['start_km'] ?? ''; ?>" placeholder="" class="input02">
                    <label for="" class="placeholder2">Start KMR</label>
                </div>
                <div class="trial1">
                    <input type="number" id="hmr" name="closed_km" value="<?php echo $row['closed_km'] ?? ''; ?>" placeholder="" class="input02">
                    <label for="" class="placeholder2">Closed KMR</label>
                </div>
            </div>

            <div class="outer02" id="doubleshift1">
                <div class="trial1">
                    <input type="time" name="night_start_time" value="<?php echo $row['night_start_time'] ?? ''; ?>" placeholder="" class="input02">
                    <label for="" class="placeholder2">Night Start Time</label>
                </div>
                <div class="trial1">
                    <input type="time" name="night_close_time" value="<?php echo $row['night_close_time'] ?? ''; ?>" placeholder="" class="input02">
                    <label for="" class="placeholder2">Night Close Time</label>
                </div>
            </div>
            <div class="outer02" id="doubleshift2">
                <div class="trial1">
                    <input type="text" name="night_start_hmr" id="night_hmr_start" value="<?php echo $row['night_start_hmr'] ?? ''; ?>" placeholder="" class="input02">
                    <label for="" class="placeholder2">Night Start HMR</label>
                </div>
                <div class="trial1">
                    <input type="text" name="night_closed_hmr" value="<?php echo $row['night_closed_hmr'] ?? ''; ?>" placeholder="" class="input02">
                    <label for="" class="placeholder2">Night Closed HMR</label>
                </div>
            </div>
            <div class="outer02" id="doubleshift3">
                <div class="trial1">
                    <input type="text" name="night_start_km" value="<?php echo $row['night_start_km'] ?? ''; ?>" placeholder="" class="input02">
                    <label for="" class="placeholder2">Night Start KMR</label>
                </div>
                <div class="trial1">
                    <input type="text" name="night_closed_km" value="<?php echo $row['night_closed_km'] ?? ''; ?>" placeholder="" class="input02">
                    <label for="" class="placeholder2">Night Closed KMR</label>
                </div>
            </div>

            <div class="outer02" id="singleshift4" >
                <div class="trial1">
                    <input type="text" name="fuel_taken" value="<?php echo $row['fuel_taken'] ?? ''; ?>" placeholder="" class="input02">
                    <label for="" class="placeholder2">Fuel Taken</label>
                </div>
                <div class="trial1">
                    <input type="text" name="engineer_name" value="<?php echo $row['engineer_name'] ?? ''; ?>" placeholder="" class="input02">
                    <label for="" class="placeholder2">1st Shift Engineer Name</label>
                </div>
                <div class="trial1">
                    <input type="text" placeholder="" id="op1" value="<?php echo $row['operator_name'] ?? ''; ?>" name="operator_name" class="input02">
                    <label for="" class="placeholder2"> 1st Shift Operator Name</label>
                </div>

            </div>
            <div class="outer02" id="doubleshift4">
                <div class="trial1">
                    <input type="text" placeholder="" value="<?php echo $row['night_engineer'] ?? ''; ?>" name="night_engineer" class="input02">
                    <label for="" class="placeholder2">2nd Shift Engineer</label>
                </div>
                <div class="trial1">
                    <input type="text" placeholder="" value="<?php echo $row['second_operator'] ?? ''; ?>" name="second_operator" class="input02">
                    <label for="" class="placeholder2">2nd Shift Operator</label>
                </div>

            </div>
            <div class="trial1" id="shiftremark">
                <textarea name="remark" id="" placeholder="" class="input02"><?php echo $row['remark'] ?? ''; ?></textarea>
                <label for="" class="placeholder2">Remark If Any</label>
            </div>

            <div class="trial1" id="breakdown1">
                    <input type="text" name="breakdown_hours" placeholder="" value="<?php echo $row['breakdown_hours'] ?? ''; ?>" class="input02">
                    <label for="" class="placeholder2">Breakdown Hours</label>
            </div>
            <div class="trial1" id="breakdown2">
                <textarea name="breakdown_reason" id="" placeholder="" value="<?php echo $row['breakdown_reason'] ?? ''; ?>" class="input02"></textarea>
                <label for="" class="placeholder2">Breakdown Reason</label>
            </div>
            <div class="outer02" id="ot1">
            <div class="trial1" >
                    <input type="text" name="breakdown_hours" placeholder="" value="<?php echo $row['breakdown_hours'] ?? ''; ?>" class="input02">
                    <label for="" class="placeholder2">Over Time Hours</label>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" name="otprorata" value="<?php echo $row['otprorata'] ?? ''; ?>" id="prorata" class="input02">
                <label for="" class="placeholder2">OT Pro Rata</label>
            </div>
            </div>
            <div class="trial1" id="ot2">
                <textarea name="otnotes" id="" placeholder="" class="input02"><?php  echo $row['otnotes'] ?></textarea>
                <label for="" class="placeholder2">Notes</label>
            </div>
            <button class="epc-button">Submit</button>









        </div>
    </form>

</body>
<script>

document.addEventListener('DOMContentLoaded', function() {
    // Check if oem_fleet_type7 is not empty and call seco_equip_2()
    var logtype = document.getElementById('logtype');
    if (logtype.value == 'ot') {
        toggleChange('ot');
    }
});

document.addEventListener('DOMContentLoaded', function() {
    // Check if oem_fleet_type7 is not empty and call seco_equip_2()
    var logtype = document.getElementById('logtype');
    if (logtype.value == 'shift') {
        toggleChange('shift');
    }
});

document.addEventListener('DOMContentLoaded', function() {
    // Check if oem_fleet_type7 is not empty and call seco_equip_2()
    var logtype = document.getElementById('logtype');
    if (logtype.value == 'breakdown') {
        toggleChange('breakdown');
    }
});


    document.addEventListener('DOMContentLoaded', function(){
        var shift_dd=document.getElementById("shift_dd");
        if(shift_dd.value !== ''){
            shiftrelatedfield();
        }
    })

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


        });
}

</script>
</html>