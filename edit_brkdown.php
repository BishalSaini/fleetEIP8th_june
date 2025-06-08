<?php 
include "partials/_dbconnect.php";
$id_edit=$_GET['id'];
session_start();
$companyname001=$_SESSION['companyname'];
$sql="SELECT * FROM `brkdown_log` where companyname='$companyname001' and id='$id_edit'";
$resut=mysqli_query($conn,$sql);
$row=mysqli_fetch_assoc($resut);

if($_SERVER['REQUEST_METHOD']==='POST'){
    include "partials/_dbconnect.php";
    $id_content=$_POST['id_content'];
    $date=$_POST['date'];
    $breakdown_hours=$_POST['breakdown_hours'];
    $op_name=$_POST['op_name'];
    $reason=$_POST['reason'];
    $asset_code=$_POST['asset_code'];

    $sql_edit_hours="UPDATE `brkdown_log` SET 
    `date` = '$date', `brkdown_hour` = '$breakdown_hours',
     `reason` = '$reason', `operator_name` = '$op_name'
      WHERE id='$id_content'";
      $result_edit=mysqli_query($conn,$sql_edit_hours);
      if($result_edit){
        session_start();
        $_SESSION['message']="done";
        header("Location: log_sheet_summary.php?id=" . $asset_code);
                exit();
      }
      else{
        session_start();
        $_SESSION['errormessage']="error not done";
        header("Location: log_sheet_summary.php?id=" . $asset_code);
        exit();
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
        <form action="edit_brkdown.php?id=<?php echo $id_edit; ?>" method="POST" placeholder="" class="logsheet_form">
        <div class="logsheet_container">
                <p>Log Sheet </p>
                <input type="text" name="id_content" value="<?php echo $id_edit ?>" hidden>
                <div class="outer02">
                    <div class="trial1">
                        <input type="date" value="<?php echo $row['date'] ?>" name="date" placeholder="" class="input02">
                        <label for="" class="placeholder2">Date</label>
                    </div>
                    <div class="trial1">
                    <input type="text " value="<?php echo 'Breakdown' ?>" class="input02" readonly>
                    <lable class="placeholder2">Shift</lable>
                </div>
                </div>
                <div class="outer02">
                <div class="trial1">
                        <input type="text" name="asset_code" placeholder="" readonly value="<?php echo $row['asset_code'] ?>"
                            class="input02" readonly>
                        <label for="" class="placeholder2">Asset Code</label>
                    </div>


                <div class="trial1">
                    <input type="text" name="breakdown_hours" placeholder="" value="<?php echo $row['brkdown_hour'] ?>" class="input02">
                    <label for="" class="placeholder2">Breakdown Hours</label>
                </div></div>
                <div class="trial1">
                    <input type="text" placeholder="" name="op_name" value="<?php echo $row['operator_name'] ?>" class="input02">
                    <label for="" class="placeholder2">Operator Name</label>
                </div>
                <div class="trial1">
                    <input type="text" placeholder="" value="<?php echo $row['reason'] ?>" name="reason" class="input02">
                    <label for="" class="placeholder2">Reason</label>
                </div>
                <br>
                <button class="epc-button" type="submit">Submit</button>
                <br>


</div>
</form>

</body>
</html>