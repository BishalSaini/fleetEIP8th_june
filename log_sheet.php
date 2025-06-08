<?php
session_start();
include "partials/_dbconnect.php";
$asset_id = isset($_GET['id']) ? $_GET['id'] : null;
$dd_value = isset($_GET['dropdownValue']) ? $_GET['dropdownValue'] : null;

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

$showAlert = false;
$showError = false;

$sql_ac = "SELECT * FROM `fleet1` where snum='$asset_id'";
$result = mysqli_query($conn, $sql_ac);
$row = mysqli_fetch_assoc($result);
// $fleet_asset_code = $row['assetcode'];

?>
<?php
include "partials/_dbconnect.php";
$sql_hmr = "SELECT * FROM `logsheet` WHERE asset_id='$asset_id' AND companyname='$companyname001' ORDER BY `date` DESC";
$result_hmr=mysqli_query($conn,$sql_hmr);
if($result_hmr){
$row_hmr=mysqli_fetch_assoc($result_hmr);
if (!empty($row_hmr) && isset($row_hmr['closed_hmr']) && ($row_hmr['closed_hmr'])>$row_hmr['night_close_hmr']) {
    $last_hmr = $row_hmr['closed_hmr'];
    $last_kmr = $row_hmr['closed_km'];
} elseif (!empty($row_hmr) && isset($row_hmr['night_close_hmr']) && ($row_hmr['night_close_hmr'])>$row_hmr['closed_hmr']) {
    $last_hmr = $row_hmr['night_close_hmr'];
    $last_kmr = $row_hmr['night_close_km'];
} else {
    $last_hmr = null;
}}
else{
    $last_hmr=null;
}
?>
<?php
$sql_time_fetch="SELECT * FROM `logsheet` where assetcode='{$row['assetcode']}' and companyname='$companyname001' ORDER BY date DESC";
$result_time_fetch=mysqli_query($conn , $sql_time_fetch);
if($result_time_fetch){
    if (mysqli_num_rows($result_time_fetch) > 0) {
        // Fetch the row
        $row_time_fetch = mysqli_fetch_assoc($result_time_fetch);
        // Use the fetched row data
        // ...
    } else {
        // No rows found that satisfy the condition
        // Handle this case as needed, such as displaying a message
        $row_time_fetch=null;
    }}
?>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $date = $_POST['date'];
    $asset_code = $_POST['asset_code'];
    $start_time = $_POST['start_time'];
    $closed_time = $_POST['close_time'];
    $start_hmr = $_POST['start_hmr'];
    $start_km = $_POST['start_km'];
    $closed_km = $_POST['closed_km'];
    $fuel_taken = $_POST['fuel_taken'];
    $engineer_name = $_POST['engineer_name'];
    $remark = $_POST['remark'];
    $shift=$_POST['shift'];
    $equipment=$_POST['equipment'];
    $make=$_POST['make'];
    $model=$_POST['model'];
    $closed_hmr=$_POST['closed_hmr'];
    $unit1 = !empty($_POST['unit1']) ? $_POST['unit1'] : null;
    $unit2 = !empty($_POST['unit2']) ? $_POST['unit2'] : null;
    $night_start_time=$_POST['night_start_time'];
    $night_close_time=$_POST['night_close_time'];
    $night_start_hmr=!empty($_POST['night_closed_hmr']) ? $_POST['night_start_hmr'] : null;
    $night_closed_hmr=$_POST['night_closed_hmr'];
    $night_start_km=!empty($_POST['night_closed_km']) ? $_POST['night_start_km'] : null;
    $night_closed_km=$_POST['night_closed_km'];
    $night_unit1 = !empty($_POST['night_unit1']) ? $_POST['night_unit1'] : null;
    $night_unit2 = !empty($_POST['night_unit2']) ? $_POST['night_unit2'] : null;
    $operator_name=$_POST['operator_name'];
    $hours=$_POST['hours'];
    $night_engineer=$_POST['night_engineer'];
    $second_operator=$_POST['second_operator'];




    $insert_logsheet = "INSERT INTO `logsheet` (`night_shift_operator`,`night_shift_engineer`,`hours_shift`,`operator_name`,`night_start_time`, `night_close_time`, `unit1_night`, `unit2_night`, 
    `night_start_hmr`, `night_close_hmr`, `night_start_km`, `night_close_km`,`unit1`,`unit2`,`asset_id`,`shift`,`equipment`,`make`,`model`,`closed_hmr`,`assetcode`, `date`, `start_time`, `close_time`, `start_hmr`, `start_km`, `closed_km`, `fuel_taken`, `engineer_name`, `remark`, `companyname`)
 VALUES ('$second_operator','$night_engineer','$hours','$operator_name','$night_start_time','$night_close_time','$night_unit1','$night_unit2','$night_start_hmr','$night_closed_hmr','$night_start_km','$night_closed_km','$unit1','$unit2','$asset_id','$shift','$equipment','$make','$model','$closed_hmr','$asset_code', '$date', '$start_time', '$closed_time', '$start_hmr', '$start_km', '$closed_km', '$fuel_taken', '$engineer_name', '$remark', '$companyname001')";
    $result_value_inserted = mysqli_query($conn, $insert_logsheet);
    if ($result_value_inserted) {
        $showAlert = true;
    } else {
        $showError = true;
    }
    header("location: log_direction.php?id=" . $asset_id);
    exit();


}

?>
<?php 
if(isset($_SESSION['message'])){
    $showAlert=true;
    unset($_SESSION['message']);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">      <link rel="icon" href="favicon.jpg" type="image/x-icon">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Log Sheet</title>
</head>

<body onload="double_Shift()">
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
        <?php
if($showAlert){
echo  '<label>
    <input type="checkbox" class="alertCheckbox" autocomplete="off" />
    <div class="alert notice">
      <span class="alertClose">X</span>
      <span class="alertText_addfleet"><b>Success!</b>LogSheet Added Successfully
          <br class="clear"/></span>
    </div>
  </label>';
 }
 if($showError){
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

<form action="log_sheet.php?id=<?php echo $asset_id; ?>" method="POST" placeholder="" class="logsheet_form">
            <div class="logsheet_container">
                <p>Log Sheet </p>
                <div class="outer02">
                    <div class="trial1">
                        <input type="date" name="date" placeholder="" class="input02">
                        <label for="" class="placeholder2">Date</label>
                    </div>
                    <div class="trial1">
                        <select name="shift" id="shift_dd" class="input02" onchange="double_Shift(<?php echo $asset_id?>)">
                            <option value=""disabled selected>Shift</option>
                            <option value="Single"<?php if($dd_value === 'Single'){echo 'selected';} ?>>Single Shift</option>
                            <option value="Double" <?php if($dd_value === 'Double'){echo 'selected';} ?>>Double Shift</option>
                            <option value="Breakdown">Breakdown</option>
                        </select>
                    </div>
                </div>
                <div class="outer02">
                <div class="trial1">
                        <input type="text" name="asset_code" placeholder="" value="<?php echo $row['assetcode'] ?>"
                            class="input02" readonly>
                        <label for="" class="placeholder2">Asset Code</label>
                    </div>
                    <div class="trial1">
                        <input type="text" placeholder="" name="hours" value="<?php echo $row['hour_shift'] ?> " class="input02">
                        <label for="" class="placeholder2">Shift Working Hours</label>
                    </div>


                </div>
                <div class="outer02">
                <div class="trial1">
                        <input type="text" placeholder="" name="make" value="<?php echo $row['make'] ?>" class="input02" readonly>
                        <label for="" class="placeholder2">Asset Make</label>
                    </div>

                <div class="trial1">
                    <input type="text" placeholder="" name="equipment" value="<?php echo $row['sub_type'] ?>" class="input02" readonly>
                    <label for="" class="placeholder2">Equipment</label>
                </div>

                    <div class="trial1">
                        <input type="text" placeholder="" name="model" value="<?php echo $row['model'] ?>" class="input02" readonly>
                        <label for="" class="placeholder2">Asset Model</label>
                    </div>

                </div>
                <div class="outer02">
                <div class="trial1">
                    <input type="text" placeholder="" class="input02" value="<?php echo $row['client_name'] ?>"  readonly>
                    <label for="" class="placeholder2">Client Name</label>
                </div>
                <div class="trial1">
                    <input type="text" placeholder="" value="<?php echo $row['project_name'] ?>" class="input02">
                    <label for="" class="placeholder2">Project Name</label>
                </div>
                </div>
                <div class="outer02">
                    <div class="trial1">
                        <input type="text" name="start_time" value="<?php if(isset($row_time_fetch)) {echo $row_time_fetch['start_time'];} ?>" placeholder="" class="input02">
                        <label for="" class="placeholder2">Start Time</label>
                    </div>
                    <select name="unit1" id="unit1" class="input02">
                        <option value=""disabled selected>Unit</option>
                        <option value="AM" <?php if(isset($row_time_fetch) && $row_time_fetch['unit1']==='AM'){ echo 'selected';} ?> >AM</option>
                        <option value="PM" <?php if(isset($row_time_fetch) && $row_time_fetch['unit1']==='PM'){ echo 'selected';} ?> >PM</option>
                    </select>
                    <div class="trial1">
                        <input type="text" name="close_time" value="<?php if(isset($row_time_fetch)) {echo $row_time_fetch['close_time']; } ?>" placeholder="" class="input02">
                        <label for="" class="placeholder2">Close Time</label>
                    </div>
                    <select name="unit2" id="unit1" class="input02">
                        <option value=""disabled selected>Unit</option>
                        <option value="AM" <?php if(isset($row_time_fetch) && $row_time_fetch['unit2']==='AM'){ echo 'selected';} ?>>AM</option>
                        <option value="PM"<?php if(isset($row_time_fetch) && $row_time_fetch['unit2']==='PM'){ echo 'selected';} ?>>PM</option>
                    </select>
                </div>
                <div class="outer02">
                    <div class="trial1">
                    <input type="text" name="start_hmr" id="start_hmr_container" value="<?php echo isset($last_hmr) ? $last_hmr : '' ?>"  placeholder="" class="input02">
                        <label for="" class="placeholder2">Start HMR</label>
                    </div>
                    <div class="trial1">
                        <input type="text" name="closed_hmr" placeholder="" class="input02">
                        <label for="" class="placeholder2">Closed HMR</label>
                    </div>
                    </div>
                    <div class="outer02">
                    <div class="trial1">
                        <input type="text" name="start_km" placeholder="" value="<?php echo isset($last_kmr) ? $last_kmr : ''  ?>" class="input02">
                        <label for="" class="placeholder2">Start KMR</label>
                    </div>
                    <div class="trial1">
                        <input type="text" name="closed_km" placeholder="" class="input02">
                        <label for="" class="placeholder2">Closed KMR</label>
                    </div>
                </div>
        <div class="outer-container1" id="night">
        <div class="night_shift_container">
                <div class="outer02">
                    <div class="trial1">
                        <input type="text" name="night_start_time" placeholder="" class="input02">
                        <label for="" class="placeholder2">Night Start Time</label>
                    </div>
                    <select name="night_unit1" id="unit1" class="input02">
                        <option value=""disabled selected>Unit</option>
                        <option value="AM">AM</option>
                        <option value="PM">PM</option>
                    </select>
                    <div class="trial1">
                        <input type="text" name="night_close_time" placeholder="" class="input02">
                        <label for="" class="placeholder2">Night Close Time</label>
                    </div>
                    <select name="night_unit2" id="unit1" class="input02">
                        <option value=""disabled selected>Unit</option>
                        <option value="AM">AM</option>
                        <option value="PM">PM</option>
                    </select>
                </div>
                <div class="outer02">
                    <div class="trial1">
                    <!-- value="<?php echo $last_hmr ?>" -->
                        <input type="text" name="night_start_hmr" id="night_hmr_start"  placeholder="" class="input02">
                        <label for="" class="placeholder2">Night Start HMR</label>
                    </div>
                    <div class="trial1">
                        <input type="text" name="night_closed_hmr" placeholder="" class="input02">
                        <label for="" class="placeholder2">Night Closed HMR</label>
                    </div>
                    </div>
                    <div class="outer02">
                    <div class="trial1">
                        <input type="text" name="night_start_km" placeholder="" class="input02">
                        <label for="" class="placeholder2">Night Start KMR</label>
                    </div>
                    <div class="trial1">
                        <input type="text" name="night_closed_km" placeholder="" class="input02">
                        <label for="" class="placeholder2">Night Closed KMR</label>
                    </div>
                </div>
                <div class="outer02">
                <div class="trial1">
                        <input type="text" placeholder=""  name="night_engineer" class="input02">
                        <label for="" class="placeholder2">2nd Shift Engineer</label>
                    </div>
                    <div class="trial1">
                        <input type="text" placeholder="" name="second_operator" class="input02">
                        <label for="" class="placeholder2">2nd Shift Operator</label>
                    </div>

                    </div>
                </div>
                </div>


                <div class="outer02">
                    <div class="trial1">
                        <input type="text" name="fuel_taken" placeholder="" class="input02">
                        <label for="" class="placeholder2">Fuel Taken</label>
                    </div>
                    <div class="trial1">
                        <input type="text" name="engineer_name" value="<?php if(isset($row_time_fetch)) {echo $row_time_fetch['engineer_name'] ;}?>" placeholder="" class="input02">
                        <label for="" class="placeholder2">1st Shift Engineer Name</label>
                    </div>
                </div>
                <div class="outer02">
                <div class="trial1">
                    <input type="text" name="remark" placeholder="" class="input02">
                    <label for="" class="placeholder2">Remark</label>
                </div>
                <div class="trial1">
                    <input type="text" placeholder="" name="operator_name" value="<?php echo $row['operator_fname'] ?>" class="input02">
                    <label for="" class="placeholder2"> 1st Shift Operator Name</label>
                </div>
                </div>
                <div class="summary_logsheet">
                <button class="epc-button" type="submit">Submit</button>
                <a href="log_sheet_summary.php?id=<?php echo $row['assetcode'] ?>" id="view_summary_button" class="epc-button">View Summary</a>

                </div>
                <br>
            </div>
        </form>

        <script>
function double_Shift(id_ac) {
    const drop_menu = document.getElementById("shift_dd");
    const cont = document.getElementById("night");
    const input_hmr = document.getElementById("night_hmr_start");

    if (drop_menu.value === 'Double') {
        cont.style.display = "block";
    } 
    else if (drop_menu.value === 'Breakdown'){
        window.location = "breakdown_logsheet.php?id=" + id_ac;        }
    else if(drop_menu.value === 'Single'){
        input_hmr.value = null;    }
    
    else {
        cont.style.display = "none";
    }
}
    function copyToNightStartHMR() {
        var closedHMRValue = document.getElementsByName("closed_hmr")[0].value;
        document.getElementsByName("night_start_hmr")[0].value = closedHMRValue;
    }

       document.getElementsByName("closed_hmr")[0].addEventListener("input", copyToNightStartHMR);



       function copyToNightStartKM(){
        var closedKMRValue = document.getElementsByName("closed_km")[0].value;
        document.getElementsByName("night_start_km")[0].value = closedKMRValue;


       }
       document.getElementsByName("closed_km")[0].addEventListener("input", copyToNightStartKM);


    // document.getElementById("start_hmr_container").value = "<?php echo $last_hmr ?>";


</script>
</body>
</html>