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
$showemail = false;
$showAlert = false;
$showError = false;
include 'partials/_dbconnect.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $subemail = $_POST["subemail"];
    $subpass = $_POST["password"];
    $subcpass = $_POST["cpassword"];
    $comp = $_POST['company_name'];
    $enterprise_subuser = $_POST['enterprise_type'];
    $contactnumber_subuser = $_POST["contact"];
    $designation=$_POST['designation'];
    $username=$_POST['username'];

    $sql_check011 = "SELECT * FROM `login` WHERE email='$subemail'";
    $result_subuser = mysqli_query($conn, $sql_check011);
    $row_subemail = mysqli_fetch_assoc($result_subuser);

    if ($row_subemail > 0) {
        $showemail = true;
    } else {

        if ($subpass == $subcpass) {
            // Fetch enterprise details from existing user
            $sql_check_exist77 = "SELECT * FROM `login` WHERE email='$email' and companyname='$companyname001'";
            $result_exist = mysqli_query($conn, $sql_check_exist77);
            $row_exist = mysqli_fetch_assoc($result_exist);

            $sql_subuser1 = "SELECT * FROM `login` WHERE `email`='$email' AND `companyname`='$companyname001' AND `added_by`=''";
            $result121 = mysqli_query($conn, $sql_subuser1);
            $row_new = mysqli_fetch_assoc($result121);
    

            $sql = "INSERT INTO `login` (`username`,`compnay_pincode`,`company_address`,`comp_web`,`designation`,`email`, `password`, `enterprise`, `contactnumber`, `added_by`, `companyname`,`gst`,`pancard`,`webiste_address`,`add_on_services`,`rmc_type`,`rmc_location`,`rmc_pincode`)
            VALUES ('$username','".$row_new['compnay_pincode']."','".$row_new['company_address']."','".$row_new['comp_web']."','$designation','$subemail', '$subpass', '$enterprise_subuser', '$contactnumber_subuser', '$email', '$comp','".$row_new['gst']."','".$row_new['pancard']."','".$row_new['webiste_address']."','".$row_new['add_on_services']."','".$row_new['rmc_type']."','".$row_new['rmc_location']."','".$row_new['rmc_pincode']."')";
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

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-f1sFFmh2aWzj45p7NlsbK2G7Fl+E0ueNc+gJiSAwDY0+0w8pTKXn1foU9s9xqjumT2cEiS0TRgNpS0+8A1fFWQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Document</title> 
    <style> 
        .oemsubusers {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.subuser-container {
    width: 30%;
    gap:8px!important;
    
}

.subuser_div h2 {
    text-align: center;
}

.trial1 {
    position: relative;
    
}

.input02 {
    width: 100%;
    padding: 10px;
    box-sizing: border-box;
}

.placeholder2 {
    position: absolute;
    top: -20px;
    left: 10px;
    font-size: 14px;
    color: #555;
}

.outer02 {
    display: flex;
    justify-content: space-between;
}

.row {
    position: relative;
    width: 100%;
}

.toggle-password {
    position: absolute;
    top: 50%;
    right: 10px;
    transform: translateY(-50%);
    cursor: pointer;
}

.epc-button {
    padding: 10px 20px;
    background-color: #4067B5;
    color: #fff;
    border: none;
    cursor: pointer;
    font-size: 16px;
}

.epc-button:hover {
    background-color: #d94404;
}

    </style>
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
          <span class="alertText">Subuser Can Now LogIN
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
    <form action="rental_employee.php" method="POST" class="oemsubusers" autocomplete="off">
    <div class="subuser-container">
        <div class="subuser_div">
            <h2>Add SubUsers</h2>
        </div>
        <div class="trial1">
            <input type="text" name="username" class="input02" required>
            <label for="" class="placeholder2"> Name</label>
        </div>
        <div class="trial1">
            <input type="email" name="subemail" class="input02" required>
            <label class="placeholder2">Email</label>
        </div>
        <div class="outer02">
    <div class="trial1">
        <div class="row">
            <input type="password" name="password" class="input02" id="password" required>
            <label for="" class="placeholder2">Password</label>
            <span class="toggle-password"><i class="far fa-eye" onclick="togglePassword('password')"></i></span>
        </div>
    </div>
    <div class="trial1">
        <div class="row">
            <input type="password" name="cpassword" class="input02" id="cpassword" required>
            <label for="" class="placeholder2">Confirm Password</label>
            <span class="toggle-password"><i class="far fa-eye" onclick="togglePassword('cpassword')"></i></span>
        </div>
    </div>
</div>
        <div class="outer02">
            <div class="trial1">
                <input type="text" name="company_name" value="<?php echo $companyname001 ?>" class="input02" readonly>
                <label class="placeholder2">Company</label>
            </div>
            <div class="trial1">
                <input type="text" name="enterprise_type" value="<?php echo $row_exist['enterprise'] ?>" class="input02" readonly>
                <label class="placeholder2">Enterprise Type</label>
            </div>
        </div>
        <div class="outer02">
            <div class="trial1">
                <input type="text" name="contact" class="input02" required>
                <label class="placeholder2">Contact Number</label>
            </div>
            <div class="trial1">
                <select name="designation" class="input02" required>
                    <option value="" disabled selected>Department</option>
                    <option value="marketing">Marketing</option>
                    <option value="operation">Operation and Maintenance</option>
                    <option value="accounts">Accounts</option>
                    <!-- <option value="management">Management</option> -->
                </select>
            </div>
        </div>
        <button type="submit" class="epc-button">Add SubUser</button>
        <br>
    </div>
</form>

<br>
<br> 

<script>
function togglePassword(fieldId) {
    var field = document.getElementById(fieldId);
    var fieldType = field.getAttribute('type') === 'password' ? 'text' : 'password';
    field.setAttribute('type', fieldType);
}
</script>

</body>
</html>