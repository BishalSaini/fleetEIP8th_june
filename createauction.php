<?php
include "partials/_dbconnect.php";
session_start();
$companyname001=$_SESSION['companyname'];
$email=$_SESSION['email'];
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
elseif ($enterprise === 'admin') {
    $dashboard_url = 'news/admin/dashboard.php';
} 

else {
    $dashboard_url = '';
}
$showAlert = false;
$showError = false;

if($_SERVER['REQUEST_METHOD']==='POST'){
    include "partials/_dbconnect.php";
    $auctiontype = $_POST['auctiontype'];
    $startdate = $_POST['startdate'];
    $enddate = $_POST['enddate'];
    $description = $_POST['description'];
    $maxprice = $_POST['maxprice'];
    $baseprice = $_POST['baseprice'];
    $endtime=$_POST['endtime'];
    $starttime=$_POST['starttime'];
    $contactemail=$_POST['email'];

    $sql = "INSERT INTO auctiondetail (starttime,endtime,created_by, auctiontype, startdate, enddate, description, maxprice, baseprice, companyname) 
    VALUES ('$starttime','$endtime','$contactemail','$auctiontype', '$startdate', '$enddate', '$description', '$maxprice', '$baseprice', '$companyname001')";
    $result=mysqli_query($conn,$sql);

    if ($result) {
        $_SESSION['success'] = 'success';
    } else {
        $_SESSION['error'] = 'error';
    }
    
    header("Location: auction.php");
    exit(); 
    

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Auction</title>
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="favicon.jpg" type="image/x-icon">
    <script src="main.js"defer></script>
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
            <!-- <li><a href="news/">News</a></li> -->
    
        <li><a href="logout.php">Log Out</a></li></ul>
        </div>
    </div>
    <?php
    if($showAlert){
        echo  '<label>
        <input type="checkbox" class="alertCheckbox" autocomplete="off" />
        <div class="alert notice">
          <span class="alertClose">X</span>
          <span class="alertText_addfleet"><b>Success!</b>
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

    <form action="createauction.php" method="POST" autocomplete="off"  class="outerform">
        <div class="auctioncontainer">
            <p class="headingpara">Create Auction</p>
            <div class="trial1">
                <select name="auctiontype" id="auctiontypedd" onchange="auctiontypefunction()" class="input02">
                    <option value=""disabled selected>Auction Type</option>
                    <option value="Service">Service</option>
                    <option value="Equipement Selling">Equipement Selling</option>
                </select>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" value="<?php echo $email ?>" name="email" class="input02">
                <label for="" class="placeholder2">Contact Email</label>
            </div>
            <div class="outer02">
            <div class="trial1">
            <input type="date" name="startdate" class="input02">
            <label for="" class="placeholder2">Auction Start Date </label>
            </div>
            <div class="trial1">
            <input type="time" name="starttime" class="input02">
            <label for="" class="placeholder2">Auction Start Time</label>
            </div>


            </div>
            <div class="outer02">
            <div class="trial1">
            <input type="date" name="enddate" class="input02">
            <label for="" class="placeholder2">Auction End Date</label>
            </div>
            <div class="trial1">
            <input type="time" name="endtime" class="input02">
            <label for="" class="placeholder2">Auction End Time</label>
            </div>

            </div>
            <div class="trial1">
                <textarea name="description" id="" placeholder="" class="input02"></textarea>
                <label for="" class="placeholder2">Auction Description</label>
            </div>
            <div class="trial1" id="maxpriceinput">
            <input type="text" name="maxprice"  placeholder="" class="input02">
            <label for="" class="placeholder2">Maximum Price</label>
            </div>

            <div class="trial1" id="basepriceinput">
            <input type="text" name="baseprice"  placeholder="" class="input02">
            <label for="" class="placeholder2">Base Price</label>
            </div>
            <div class="outer02">
                <div class="trial1">
                    <input type="text" placeholder="" name="make" class="input02">
                    <label for="" class="placeholder2">Make</label>
                </div>
                <div class="trial1">
                    <input type="text" placeholder="" name="model" class="input02">
                    <label for="" class="placeholder2">Model</label>
                </div>
                <div class="trial1">
                    <input type="number" placeholder="" name="yom" class="input02">
                    <label for="" class="placeholder2">YoM</label>
                </div>
                
            </div>
            <button class="epc-button">Submit</button>

        </div>
    </form>
</body>
</html>