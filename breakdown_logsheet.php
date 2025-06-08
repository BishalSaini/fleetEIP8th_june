<?php 
include "partials/_dbconnect.php";
$showAlert = false;
$showError = false;

$asset_id=$_GET['id'];
session_start();
$companyname001=$_SESSION['companyname'];
$sql="SELECT * FROM `fleet1` where snum='$asset_id' and companyname='$companyname001'";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_assoc($result);
?>
<?php 
if($_SERVER['REQUEST_METHOD']==='POST'){
    include "partials/_dbconnect.php";
    $date=$_POST['date'];
    $asset_code=$_POST['asset_code'];
    $make=$_POST['make'];
    $equipment=$_POST['equipment'];
    $model=$_POST['model'];
    $breakdown_hours=$_POST['breakdown_hours'];
    $op_name=$_POST['op_name'];
    $reason=$_POST['reason'];




    $sql_logsheet_entry="INSERT INTO `brkdown_log` (`reason`, `date`, `asset_code`, `asset_make`, `equipment`, `model`,
     `brkdown_hour`, `operator_name`, `companyname`)
     VALUES ('$reason','$date', '$asset_code', '$make', '$equipment', '$model', '$breakdown_hours', '$op_name', '$companyname001')";
    $result_logsheet=mysqli_query($conn,$sql_logsheet_entry);
    if($result_logsheet){
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
    <meta charset="UTF-8">      <link rel="icon" href="favicon.jpg" type="image/x-icon">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
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
        <?php
if($showAlert){
echo  '<label>
    <input type="checkbox" class="alertCheckbox" autocomplete="off" />
    <div class="alert notice">
      <span class="alertClose">X</span>
      <span class="alertText_addfleet"><b>Success!</b>Breakdown Log Added Successfully
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

        <form action="breakdown_logsheet.php?id=<?php echo $asset_id; ?>" autocomplete="off" method="POST" placeholder="" class="logsheet_form">
        <div class="logsheet_container">
                <p>Log Sheet </p>
                <div class="outer02">
                    <div class="trial1">
                        <input type="date" name="date" placeholder="" class="input02">
                        <label for="" class="placeholder2">Date</label>
                    </div>
                    <div class="trial1">
                        <select name="shift" id="shift_dd_brkdown" class="input02" onchange="_Shift(<?php echo $asset_id?>)">
                            <option value="">Shift</option>
                            <option value="Single">Single Shift</option>
                            <option value="Double">Double Shift</option>
                            <option value="Breakdown" selected>Breakdown</option>
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
                <div class="trial1">
                    <input type="text" name="breakdown_hours" placeholder="" class="input02">
                    <label for="" class="placeholder2">Breakdown Hours</label>
                </div>
                <div class="trial1">
                    <input type="text" placeholder="" name="op_name" value="<?php echo $row['operator_fname'] ?>" class="input02">
                    <label for="" class="placeholder2">Operator Name</label>
                </div>
                <div class="trial1">
                    <input type="text" placeholder="" name="reason" class="input02">
                    <label for="" class="placeholder2">Reason</label>
                </div>
                <br>
                <div class="summary_logsheet">

                <button class="epc-button">Submit</button>
                <a href="log_sheet_summary.php?id=<?php echo $row['assetcode'] ?>" id="view_summary_button" class="epc-button">View Summary</a>

</div>
                <br>


</div>
</form>
<script>
    function _Shift(id)
    {
        const drop_menu = document.getElementById("shift_dd_brkdown");
        if (drop_menu.value ==="Single" || drop_menu.value ==="Double"){
            const dropdownValue = drop_menu.value;
            window.location = "log_sheet.php?id=" + id;  
            window.location = "log_sheet.php?id=" + id + "&dropdownValue=" + dropdownValue;      

        }

    }
</script>
</body>
</html>