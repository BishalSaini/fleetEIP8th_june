<?php
session_start();
include 'partials/_dbconnect.php';
$fleet_category = $_SESSION['fleet_category'];
$fleet_capacity = $_SESSION['fleet_capacity'];
$fleet_type = $_SESSION['fleet_type'];
$email = $_SESSION['email'];
$companyname = $_SESSION['companyname'];


?>
<?php
if($_SERVER["REQUEST_METHOD"]== "POST"){
    include 'partials/_dbconnect.php';
$fleet_category1=$_POST['fleet_category'];
$fleet_type1=$_POST['fleet_type'];
$fleet_cap1=$_POST['fleet_cap'];
$proj_loc1=$_POST['project_location'];
$contact1=$_POST['contact_no'];
$rental_email1=$_POST['email'];
$rental_compname=$_POST['company_name'];
$morespecs=$_POST['specs'];
$sqlinser="INSERT INTO `oem_general_req` (`fleet_category`, `fleet_type`, `fleet_capacity`, `project_location`, `contact_number`, `rental_email`, `rental_companyname`, `more_specifics`)
 VALUES ('$fleet_category1', '$fleet_type1', '$fleet_cap1', '$proj_loc1', '$contact1', '$rental_email1', '$rental_compname', '$morespecs')";
 $result_insert=mysqli_query($conn , $sqlinser);
 if($result_insert){
    session_start();
    $_SESSION['message']="Success Message";
    header("location:available_crane.php");

 }
}

?>
<style>
  <?php include "style.css"; ?>
</style>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">      <link rel="icon" href="favicon.jpg" type="image/x-icon">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    <form action="request_quote_fromall.php" method="POST" class="request_quoteform">
        <div class="request_quote_innercontainer">
            <div class="quotehead"><p>Request A Quote</p></div>
        <!-- <div class="trial1">
        <input type="text" class="input02" placeholder=""  name="companyname" readonly>
        <label class="placeholder2">OEM Company name</label>
        </div> -->
        <div class="trial1">
        <input type="text" class="input02" placeholder="" value="<?php echo $fleet_category; ?>" name="fleet_category" readonly>
        <label class="placeholder2">Fleet Category</label>
        </div>
        
        <div class="trial1">
        <input type="text" class="input02" placeholder="" value="<?php echo $fleet_type; ?>"  name="fleet_type" readonly>
        <label class="placeholder2">Fleet Type</label>
        </div>
        <div class="trial1">
        <input type="text" class="input02" placeholder="" value="<?php echo $fleet_capacity; ?>"  name="fleet_cap" readonly>
        <label class="placeholder2">Fleet Capacity</label>
        </div>
        <div class="trial1">
        <input type="text" class="input02" placeholder="" name="project_location">
        <label class="placeholder2">Project Location</label>
        </div>
        <div class="trial1">
        <input type="text" class="input02" placeholder="" name="contact_no">
        <label class="placeholder2">Contact Number</label>
        </div>
        <div class="trial1">
        <input type="text" class="input02" placeholder="" value="<?php echo $email; ?>"  name="email" readonly>
        <label class="placeholder2">Rental Email</label>
        </div>
        <div class="trial1">
        <input type="text" class="input02" placeholder="" value="<?php echo $companyname; ?>" name="company_name">
        <label class="placeholder2"> Rental Company Name</label>
        </div>
        <div class="trial1">
        <input type="text" class="input02" placeholder="" name="specs">
        <label class="placeholder2">More Specifics</label>
        </div>
        <button type="submit" name="submit" class="epc-button">Submit</button>
        <br>
        </div>
    </form>

</body>
</html>