<?php
include_once 'partials/_dbconnect.php'; // Include the database connection file
session_start();
$email = $_SESSION["email"];
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
if($_SERVER["REQUEST_METHOD"] == "POST"){
    include 'partials/_dbconnect.php';
    $name = $_POST["team_name"];
    $mobnum = $_POST["number"];
    $team_email = $_POST["email"];
    $companyname = $_POST["companyname"];
    $designation = $_POST["designation"];
    // $sql = ("SELECT companyname FROM `login` WHERE email='$email'");

    // $result = $conn->query($sql);
    // if ($result->num_rows > 0) {
    //     $row = $result->fetch_assoc();
    //     $companyname = $row['companyname'];  

        $sql="INSERT INTO `team_members` (`added_by`, `name`, `mob_number`, `email`, `compnay name`, `designation`)
         VALUES ('$email', '$name', '$mobnum', '$team_email', '$companyname', '$designation')";
         $result = mysqli_query($conn, $sql);
         if ($result){
            $showAlert = true;
        }
    
    else{
        $showError = true;
    
     }};

?>



<style>
  <?php include "style.css" ?>
</style>
<script>
    <?php include "main.js" ?>
    </script>
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
        <li><a href="oem_dashboard.php">Dashboard</a></li>
            <li><a href="news/">News</a></li>
    
        <li><a href="logout.php">Log Out</a></li></ul>
        </div>
    </div> 
    <?php
    if($showAlert){
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
             <strong>Success!</strong>" Team Member Added Successfully."
             </div>';
     }
     if($showError){
         echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
             <strong>Error!</strong> Something Went Wrong .
             </div>';
     }
    ?>  
    <form action="rental_subuser.php" method="POST" class="rental-subuser-form">
        <div class="innersubuser">
            <div class="add_subuser_heading"><h2 class="rental_heading1">Add SubUser</h2></div>
            
            <div class="trial1">
            <input type="text" name="team_name" id="" placeholder="" class="input3">
            <label class="placeholder">Name</label>
            </div>
            <div class="trial1">
            <input type="text" name="number" id="" placeholder="" class="input3">
            <label class="placeholder">Mobile Number</label>
            </div>
            <div class="trial1">
            <input type="text" name="companyname" id="" value="<?php echo $companyname001 ?>" placeholder="" class="input02" readonly>
            <label class="placeholder2">Company Name</label>
            </div>
            <div class="trial1">

            <input type="text" name="email" id="" placeholder="" class="input3">
            <label class="placeholder">Email</label>
            </div>
            <!-- <input type="text" name="compname" placeholder="Company Name" class="rentaluser-info"> -->
            <select name="designation" id="" class="rentaluser-info">
                <option value="" disabled selected >User Designation</option>
                <option value="marketing">Marketing</option>
                <option value="operation">Operation and Maintanance</option>
                <option value="accounts">Accounts</option>
            </select>
            <button type="submit" class="epc-button">Add User</button>
            <br>

        </div>
    </form>

</body>
</html>