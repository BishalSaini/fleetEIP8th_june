<?php
include "partials/_dbconnect.php";
session_start();
$companyname001=$_SESSION['companyname'];
if(isset($_POST['tripmanagersubmit'])){
    include "partials/_dbconnect.php";
    $date = $_POST['date'];
    $cnnumber = $_POST['cnnumber'];
    $client = $_POST['client'];
    $trucknumber = $_POST['trucknumber'];
    $owner = $_POST['owner'];
    $broker = $_POST['broker'];
    $from_location = $_POST['from_location'];
    $to_location = $_POST['to_location'];
    $waybill = $_POST['waybill'];
    $waybill_validity = $_POST['waybill_validity'];
    $freight = $_POST['freight'];
    $vehicle = $_POST['vehicle'];
    $adv = $_POST['adv'];
    $balance = $_POST['balance'];

    $sql ="INSERT INTO tripmanager (companyname, date, cnnumber, client, trucknumber, owner, broker, freight, vehicle, adv, balance, from_location, to_location, waybill, waybill_validity) 
            VALUES ('$companyname001', '$date', '$cnnumber', '$client', '$trucknumber', '$owner', '$broker', '$freight', '$vehicle', '$adv', '$balance', '$from_location', '$to_location', '$waybill', '$waybill_validity')";
    $result=mysqli_query($conn,$sql);
    if($result){
        echo "success";
    }
    else{
        echo 'error';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="favicon.jpg" type="image/x-icon">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="favicon.jpg" type="image/x-icon">
    <link rel="stylesheet" href="tiles.css">
    <link rel="stylesheet" href="style.css">
    <title>Trip Manager</title>
</head>
<body>
<div class="navbar1">
        <div class="logo_fleet">
            <img src="logo_fe.png" alt="FLEET EIP" onclick="window.location.href='logisticsdashboard.php'">
        </div>
        <div class="iconcontainer">
            <ul>
                <li><a href="logisticsdashboard.php">Dashboard</a></li>
                <li><a href="logout.php">Log Out</a></li>
            </ul>
        </div>
    </div>
    <div class="add_fleet_btn_new" id="tripsbuttoncontainer">
<button class="generate-btn"> 
    <article class="article-wrapper" onclick="window.location.href='viewtrips.php'" id="tripbtn"> 
  <div class="rounded-lg container-projectss ">
    </div>
    <div class="project-info">
      <div class="flex-pr">
        <div class="project-title text-nowrap">View Open Trips</div>
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

<form action="tripmanager.php" method="POST" class="tripmanager">
    <div class="tripmanagercontainer">
        <p>Trip Details</p>
        <div class="outer02">
        <div class="trial1" id="cndate">
        <input type="date" value="<?php echo date('Y-m-d'); ?>" name="date" class="input02">
        <label for="" class="placeholder2"></label>
        </div>
        <div class="trial1" id="cnnummber">
            <input type="text" placeholder="" name="cnnumber" class="input02">
            <label for="" class="placeholder2">CN Number</label>
        </div>

        <div class="trial1">
            <input type="text" placeholder="" name="client" class="input02">
            <label for="" class="placeholder2">Client Name</label>
        </div>
</div>
        <div class="outer02">
        <div class="trial1">
            <input type="text" placeholder="" name="trucknumber" class="input02">
            <label for="" class="placeholder2">Truck No</label>
        </div>
        
        <div class="trial1">
            <input type="text" placeholder="" name="owner" class="input02">
            <label for="" class="placeholder2">Owner Name</label>
        </div>
        <div class="trial1">
            <input type="text" placeholder="" name="broker" class="input02">
            <label for="" class="placeholder2">Broker Name</label>
        </div>

        </div>
        <div class="outer02">
        <div class="trial1">
            <input type="text" placeholder="" name="from_location" class="input02">
            <label for="" class="placeholder2">From</label>
        </div>

        <div class="trial1">
            <input type="text" placeholder="" name="to_location" class="input02">
            <label for="" class="placeholder2">To</label>
        </div>

        </div>
        <div class="outer02">
            <div class="trial1">
                <input type="text" placeholder="" name="waybill" class="input02">
                <label for="" class="placeholder2">WayBill No</label>

            </div>
            <div class="trial1">
                <input type="date" placeholder="" name="waybill_validity" class="input02">
                <label for="" class="placeholder2">WayBill Validity</label>

            </div>
            
        </div>
        <div class="trial1">
            <input type="text" name="freight" placeholder="" class="input02">
            <label for="" class="placeholder2">Freight Charges</label>
        </div>
        <div class="outer02">
        <div class="trial1">
            <input type="text" name="vehicle" placeholder="" class="input02">
            <label for="" class="placeholder2">Vehicle Charges</label>
        </div>
        <div class="trial1">
            <input type="text" name="adv" placeholder="" class="input02">
            <label for="" class="placeholder2">Advance </label>
        </div>
        <div class="trial1">
            <input type="text" name="balance" placeholder="" class="input02">
            <label for="" class="placeholder2">Balance</label>
        </div>



        </div>
        <button class="quotation_submit" type="submit" name="tripmanagersubmit">Submit</button>
        <br>

    </div>
</form>
</body>
</html>