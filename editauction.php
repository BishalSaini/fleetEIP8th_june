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
if(isset($_SESSION['success'])){
    $showAlert=true;
    unset($_SESSION['success']);
}
else if(isset($_SESSION['error'])){
    $showError=true;
    unset($_SESSION['error']);
}



$id=$_GET['id'];
$sql = "SELECT * FROM `auctiondetail` WHERE id = $id AND companyname = '$companyname001'";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_assoc($result);


if($_SERVER['REQUEST_METHOD']==='POST'){
    include "partials/_dbconnect.php";
    $auctiontype = $_POST['auctiontype'];
    $startdate = $_POST['startdate'];
    $enddate = $_POST['enddate'];
    $description = $_POST['description'];
    $maxprice = $_POST['maxprice'];
    $baseprice = $_POST['baseprice'];
    $editid=$_POST['editid'];
    $endtime=$_POST['endtime'];
    $starttime=$_POST['starttime'];



    $sqlupdate = "UPDATE auctiondetail SET 
    auctiontype = '$auctiontype',
    startdate = '$startdate',
    enddate = '$enddate',
    starttime = '$starttime',
    endtime = '$endtime',
    description = '$description',
    maxprice = '$maxprice',
    baseprice = '$baseprice'
WHERE id = $editid";
    $result=mysqli_query($conn,$sqlupdate);
    if ($result) {
        session_start();
        $_SESSION['success']='true';
    } else {
        session_start();
        $_SESSION['error']='true';
    }
    header("Location: auction.php?id=" . urlencode($editid));
    exit();

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Auction</title>
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

<form action="editauction.php?id=<?php echo $id; ?>" method="POST" class="outerform">
        <div class="auctioncontainer">
            <input type="hidden" name="editid" value="<?php echo $id ?>">
            <p class="headingpara">Create Auction</p>
            <div class="trial1">
                <select name="auctiontype" id="auctiontypedd" onchange="auctiontypefunction()" class="input02">
                    <option value=""disabled selected>Auction Type</option>
                    <option <?php if($row['auctiontype']==='Service'){echo 'selected';} ?> value="Service">Auction Type : Service</option>
                    <option <?php if($row['auctiontype']==='Equipement Selling'){echo 'selected';} ?> value="Equipement Selling">Auction Type : Equipement Selling</option>
                </select>
            </div>
            <div class="outer02">
            <div class="trial1">
            <input type="date" value="<?php echo $row['startdate'] ?>" name="startdate" class="input02">
            <label for="" class="placeholder2">Auction Start Date </label>
            </div>
            <div class="trial1">
            <input type="time" value="<?php echo $row['starttime'] ?>" name="starttime" class="input02">
            <label for="" class="placeholder2">Auction Start Time</label>
            </div>


            </div>
            <div class="outer02">
            <div class="trial1">
            <input type="date" value="<?php echo $row['enddate'] ?>" name="enddate" class="input02">
            <label for="" class="placeholder2">Auction End Date</label>
            </div>
            <div class="trial1">
            <input type="time" value="<?php echo $row['endtime'] ?>" name="endtime" class="input02">
            <label for="" class="placeholder2">Auction End Time</label>
            </div>

            </div>
            <div class="trial1">
                <textarea name="description" id=""  placeholder="" class="input02"><?php echo $row['description'] ?></textarea>
                <label for="" class="placeholder2">Auction Description</label>
            </div>
            <div class="trial1" id="maxpriceinput">
            <input type="text" name="maxprice"  placeholder="" value="<?php echo $row['maxprice'] ?>" class="input02">
            <label for="" class="placeholder2">Maximum Price</label>
            </div>

            <div class="trial1" id="basepriceinput">
            <input type="text" name="baseprice"  placeholder="" value="<?php echo $row['baseprice'] ?>" class="input02">
            <label for="" class="placeholder2">Base Price</label>
            </div>
            <button class="epc-button">Submit</button>

        </div>
    </form>
</body>
<script>
    document.addEventListener('DOMContentLoaded', function() {
    // Check if oem_fleet_type7 is not empty and call seco_equip_2()
    var auctiontypedd = document.getElementById('auctiontypedd');
    if (auctiontypedd.value !== '') {
        auctiontypefunction();
    }
});

</script>
</html>