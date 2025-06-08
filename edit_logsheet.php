<?php 
include "partials/_dbconnect.php";
session_start();
$companyname001=$_SESSION['companyname'];
$id=$_GET['id'];
$sql="SELECT * FROM `logsheet` where id='$id'";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_assoc($result);

$sql_ac = "SELECT * FROM `fleet1` WHERE assetcode='{$row['assetcode']}' AND companyname='$companyname001'";
$result_ac=mysqli_query($conn,$sql_ac);
$row_ac=mysqli_fetch_assoc($result_ac);
?>
<?php
if($_SERVER['REQUEST_METHOD']==='POST'){
    include_once "partials/_dbconnect.php";
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
    $id01=$_POST['id_number'];
    $second_engineer=$_POST['second_engineer'];
    $second_operator=$_POST['second_operator'];


    $sql_edit_logsheet="UPDATE `logsheet` SET `shift` = '$shift' ,`night_shift_operator`='$second_operator' ,`night_shift_engineer`='$second_engineer', `operator_name` = '$operator_name',
     `date` = '$date', `start_time` = '$start_time', `unit1` = '$unit1', `close_time` = '$closed_time',
      `unit2` = '$unit2', `start_hmr` = '$start_hmr', `closed_hmr` = '$closed_hmr', `start_km` = '$start_km',
       `fuel_taken` = '$fuel_taken', `engineer_name` = '$engineer_name', `night_start_time` = '$night_start_time',
        `night_close_time` = '$night_close_time',
        `unit1_night` = '$night_unit1', `unit2_night` = '$night_unit2', `night_start_hmr` = '$night_start_hmr',
         `night_close_hmr` = '$night_closed_hmr', 
        `night_start_km` = '$night_start_km', `night_close_km` = '$night_closed_km', `remark` = '$remark' WHERE `logsheet`.`id` = '$id01'";
    $result_edit=mysqli_query($conn ,$sql_edit_logsheet);
    if($result_edit){
        session_start();
$_SESSION['message']='done';
header("location: log_sheet_summary.php?id=" . $asset_code);

    }
    else{
        session_start();
        $_SESSION['errormessage']='done';
        header("location: log_sheet_summary.php?id=" . $asset_code);
         
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">      <link rel="icon" href="favicon.jpg" type="image/x-icon">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
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
        <form action="edit_logsheet.php" method="POST" placeholder="" class="logsheet_form">
            <div class="logsheet_container">
                <p>Log Sheet </p>
                <input type="text" value="<?php echo $id ?>" name="id_number" class="input02" hidden>
                <div class="outer02">
                    <div class="trial1">
                        <input type="date" name="date" value="<?php echo $row['date'] ?>" placeholder="" class="input02">
                        <label for="" class="placeholder2">Date</label>
                    </div>
                    <div class="trial1">
                        <select name="shift" id="shift_dd" class="input02" onchange="double_Shift()">
                            <option value=""disabled selected>Shift</option>
                            <option value="Single" <?php if($row["shift"]==='Single'){ echo 'selected';} ?>>Single Shift</option>
                            <option value="Double" <?php if($row["shift"]==='Double'){ echo 'selected';} ?>>Double Shift</option>
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
                    <input type="text" placeholder="" name="equipment" value="<?php echo $row['equipment'] ?>" class="input02" readonly>
                    <label for="" class="placeholder2">Equipment</label>
                </div>
                </div>
                <div class="outer02">
                    <div class="trial1">
                        <input type="text" placeholder="" name="make" value="<?php echo $row['make'] ?>" class="input02" readonly>
                        <label for="" class="placeholder2">Asset Make</label>
                    </div>
                    <div class="trial1">
                        <input type="text" placeholder="" name="model" value="<?php echo $row['model'] ?>" class="input02" readonly>
                        <label for="" class="placeholder2">Asset Model</label>
                    </div>
                </div>
                <div class="outer02">
                <div class="trial1">
                    <input type="text" placeholder="" class="input02" value="<?php echo $row_ac['client_name'] ?>"  readonly>
                    <label for="" class="placeholder2">Client Name</label>
                </div>
                <div class="trial1">
                    <input type="text" placeholder="" value="<?php echo $row_ac['project_name'] ?>" class="input02" readonly>
                    <label for="" class="placeholder2">Project Name</label>
                </div>
                </div>
                <div class="outer02">
                    <div class="trial1">
                        <input type="text" value="<?php echo $row['start_time'] ?>" name="start_time" placeholder="" class="input02">
                        <label for="" class="placeholder2">Start Time</label>
                    </div>
                    <select name="unit1" id="unit1" class="input02">
                        <option value=""disabled selected>Unit</option>
                        <option value="AM" <?php if($row['unit1']==="AM"){ echo 'selected';} ?>>AM</option>
                        <option value="PM" <?php if($row['unit1']==="PM"){ echo 'selected';} ?>>PM</option>
                    </select>
                    <div class="trial1">
                        <input type="text" name="close_time" value="<?php echo $row['close_time'] ?>"  placeholder="" class="input02">
                        <label for="" class="placeholder2">Close Time</label>
                    </div>
                    <select name="unit2" id="unit1" class="input02">
                        <option value=""disabled selected>Unit</option>
                        <option value="AM" <?php if($row['unit2']==="AM"){ echo 'selected';} ?>>AM</option>
                        <option value="PM" <?php if($row['unit2']==="PM"){ echo 'selected';} ?>>PM</option>
                    </select>
                </div>
                <div class="outer02">
                    <div class="trial1">
                    <input type="text" name="start_hmr" value="<?php echo $row['start_hmr'] ?>" id="start_hmr_container" value="<?php echo isset($last_hmr) ? $last_hmr : '' ?>"  placeholder="" class="input02">
                        <label for="" class="placeholder2">Start HMR</label>
                    </div>
                    <div class="trial1">
                        <input type="text" name="closed_hmr" value="<?php echo $row['closed_hmr'] ?>" placeholder="" class="input02">
                        <label for="" class="placeholder2">Closed HMR</label>
                    </div>
                    </div>
                    <div class="outer02">
                    <div class="trial1">
                        <input type="text" name="start_km" placeholder="" value="<?php echo $row['start_km']  ?>" class="input02">
                        <label for="" class="placeholder2">Start KMR</label>
                    </div>
                    <div class="trial1">
                        <input type="text" name="closed_km" value="<?php echo $row['closed_km']  ?>" placeholder="" class="input02">
                        <label for="" class="placeholder2">Closed KMR</label>
                    </div>
                </div>
        <div class="outer-container1" id="night">
        <div class="night_shift_container">
                <div class="outer02">
                    <div class="trial1">
                        <input type="text" name="night_start_time" value="<?php echo $row['night_start_time']  ?>" placeholder="" class="input02">
                        <label for="" class="placeholder2">Night Start Time</label>
                    </div>
                    <select name="night_unit1" id="unit1" class="input02">
                        <option value=""disabled selected>Unit</option>
                        <option value="AM"<?php if($row['unit1_night']==='AM'){ echo 'selected';} ?>>AM</option>
                        <option value="PM" <?php if($row['unit1_night']==='PM'){ echo 'selected';} ?>>PM</option>
                    </select>
                    <div class="trial1">
                        <input type="text" name="night_close_time" value="<?php echo $row['night_close_time']  ?>" placeholder="" class="input02">
                        <label for="" class="placeholder2">Night Close Time</label>
                    </div>
                    <select name="night_unit2" id="unit1" class="input02">
                        <option value=""disabled selected>Unit</option>
                        <option value="AM" <?php if($row['unit2_night']==='AM'){ echo 'selected';} ?>>AM</option>
                        <option value="PM" <?php if($row['unit2_night']==='PM'){ echo 'selected';} ?>>PM</option>
                    </select>
                </div>
                <div class="outer02">
                    <div class="trial1">
                    <!-- value="<?php echo $last_hmr ?>" -->
                        <input type="text" name="night_start_hmr" value="<?php echo $row['night_start_hmr'] ?>"  placeholder="" class="input02">
                        <label for="" class="placeholder2">Night Start HMR</label>
                    </div>
                    <div class="trial1">
                        <input type="text" name="night_closed_hmr" value="<?php echo $row['night_close_hmr'] ?>" placeholder="" class="input02">
                        <label for="" class="placeholder2">Night Closed HMR</label>
                    </div>
                    </div>
                    <div class="outer02">
                    <div class="trial1">
                        <input type="text" name="night_start_km" placeholder="" value="<?php echo $row['night_start_km'] ?>" class="input02">
                        <label for="" class="placeholder2">Night Start KMR</label>
                    </div>
                    <div class="trial1">
                        <input type="text" name="night_closed_km" placeholder="" value="<?php echo $row['night_close_km'] ?>" class="input02">
                        <label for="" class="placeholder2">Night Closed KMR</label>
                    </div>
                </div>
                <div class="outer02">
                    <div class="trial1">
                        <input type="text" name="second_engineer" value="<?php echo $row['night_shift_engineer'] ?>" placeholder="" class="input02">
                        <label for="" class="placeholder2">2nd Shift Enginner</label>
                    </div>
                    <div class="trial1">
                        <input type="text" name="second_operator" value="<?php echo $row['night_shift_operator'] ?>" placeholder="" class="input02">
                        <label for="" class="placeholder2">2nd Shift Operator</label>
                    </div>
                </div>
                </div>
                </div>


                <div class="outer02">
                    <div class="trial1">
                        <input type="text" value="<?php echo $row['fuel_taken'] ?>" name="fuel_taken" placeholder="" class="input02">
                        <label for="" class="placeholder2">Fuel Taken</label>
                    </div>
                    <div class="trial1">
                        <input type="text" name="engineer_name" value="<?php echo $row['engineer_name'] ?>" placeholder="" class="input02">
                        <label for="" class="placeholder2">1st Shift Engineer Name</label>
                    </div>
                </div>
                <div class="outer02">
                <div class="trial1">
                    <input type="text" name="remark" value="<?php echo $row['remark'] ?>" placeholder="" class="input02">
                    <label for="" class="placeholder2">Remark</label>
                </div>
                <div class="trial1">
                    <input type="text" placeholder="" name="operator_name" value="<?php echo $row_ac['operator_fname'] ?>" class="input02">
                    <label for="" class="placeholder2">1st Shift Operator Name</label>
                </div>
                </div>
                <div class="summary_logsheet">
                <button class="epc-button" type="submit">Edit</button>

                </div>
                <br>
            </div>
        </form>
<script>
    function double_Shift() {
    const drop_menu = document.getElementById("shift_dd");
    const cont = document.getElementById("night");
    const input_hmr = document.getElementById("night_hmr_start");

    if (drop_menu.value === 'Double') {
        cont.style.display = "block";
    } 
    else if(drop_menu.value === 'Single'){
        input_hmr.value = null;    }
    
    else {
        cont.style.display = "none";
    }
}
</script>
</body>
</html> 