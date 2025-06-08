<?php
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
$showemail=false;
$showAlert = false;
$showError = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'partials/_dbconnect.php';
    $subemail = $_POST["subemail"];
    $subpass = $_POST["password"];
    $subcpass = $_POST["cpassword"];
    $comp = $_POST['company_name'];
    $enterprise_subuser = $_POST['enterprise_type'];
    $contactnumber_subuser = $_POST["contact"];

    $sql_check = "SELECT * FROM `login` WHERE email='$subemail'";
    $result_subuser = mysqli_query($conn, $sql_check);
    $row_subemail = mysqli_fetch_assoc($result_subuser);

    if ($row_subemail > 0) {
        $showemail=true;
    } else {
        if ($subpass == $subcpass) {
            $sql = "INSERT INTO `login` (`email`, `password`, `enterprise`, `contactnumber`, `added_by`, `companyname`)
            VALUES ('$subemail', '$subpass', '$enterprise_subuser', '$contactnumber_subuser', '$email', '$comp')";
            $result = mysqli_query($conn, $sql);
            
            if ($result) {
                $showAlert = true;
            } else {
                $showError = true;
            }
        } else {
            $showError = true;
        }
    }
}
?>
<?php 
    include 'partials/_dbconnect.php';

$sql_check="SELECT * FROM `login` where email='$email' and companyname='$companyname001'";
$result_exist=mysqli_query($conn , $sql_check);
$row_exist=mysqli_fetch_assoc($result_exist);


?>
<style>
  <?php include "style.css" 
  ?>
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
        <li><a href="oem_dashboard.php">Dashboard</a></li>
            <li><a href="news/">News</a></li>
                        <li><a href="logout.php">Log Out</a></li></ul>
        </div>
</div>
<?php
if($showemail){
    echo '<label>
    <input type="checkbox" class="alertCheckbox" autocomplete="off" />
    <div class="alert error">
      <span class="alertClose">X</span>
      <span class="alertText">Email Already Exist
          <br class="clear"/></span>
    </div>
  </label>';
}
    if($showAlert){
        echo '<label>
        <input type="checkbox" class="alertCheckbox" autocomplete="off" />
        <div class="alert notice">
          <span class="alertClose">X</span>
          <span class="alertText">You Can Now LogIN
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
<form action="oem_subuser.php" method="POST" class="oemsubusers">
    <div class="subuser-container">
        <div class="subuser_div"><h2>Add SubUsers</h2></div>
        <div class="trial1">
        <input type="text" name="subemail" placeholder="" class="input02" required>
        <label class="placeholder2">Email</label>
    </div>
        <div class="trial1">
        <input type="password"name="password" placeholder="" class="input02" required>
        <label class="placeholder2">Password</label>
        </div>
        <div class="trial1">
        <input type="password" name="cpassword" placeholder="" class="input02" required>
        <label class="placeholder2">Confirm Password</label>
        </div>
        <div class="trial1">
        <input type="text" name="company_name" placeholder="" value="<?php echo $companyname001  ?>" class="input02" readonly>
        <label class="placeholder2">Company</label>
        </div>
        <div class="trial1">
        <input type="text" name="enterprise_type" placeholder="" value="<?php echo $row_exist['enterprise']  ?>" class="input02" readonly>
        <label class="placeholder2">Enterprise Type</label>
        </div>
        <div class="trial1">
        <input type="text" name="contact" placeholder="" class="input02" required>
        <label class="placeholder2">Contact Number</label>
        </div>

        <button type="submit" class="epc-button">Add SubUser</button>
        <br>
    </div>
</form>
<br>
<br>
</body>
</html>