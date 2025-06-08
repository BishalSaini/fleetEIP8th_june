
<?php 
session_start();
include "partials/_dbconnect.php";
$showAlert=false;
$showError=false;
$companyname001 = $_SESSION['companyname'];
$enterprise=$_SESSION['enterprise'];
$id=$_GET['id'];

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

if(isset($_SESSION['success'])){
    $showAlert=true;
    unset($_SESSION['success']);
}

else if(isset($_SESSION['error'])){
    $showError=true;
    unset($_SESSION['error']);
}


$sql="SELECT * FROM `clients_logi` where companyname='$companyname001' and id='$id'";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_assoc($result);


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "partials/_dbconnect.php";
    // Retrieve values from the form
    $client_name = isset($_POST['client_name']) ? $_POST['client_name'] : '';
    $address = isset($_POST['address']) ? $_POST['address'] : '';
    $contact_person1 = isset($_POST['contact_person1']) ? $_POST['contact_person1'] : '';
    $contact_number1 = isset($_POST['contact_number1']) ? $_POST['contact_number1'] : '';
    $contact_email1 = isset($_POST['contact_email1']) ? $_POST['contact_email1'] : '';
    $contact_person2 = isset($_POST['contact_person2']) ? $_POST['contact_person2'] : '';
    $contact_number2 = isset($_POST['contact_number2']) ? $_POST['contact_number2'] : '';
    $contact_email2 = isset($_POST['contact_email2']) ? $_POST['contact_email2'] : '';
    $gst=$_POST['gst'];
    $editid=$_POST['editid'];
    $state=$_POST['state'];


    $sql = "UPDATE clients_logi 
        SET gst='$gst', companyname='$companyname001', client_name='$client_name', address='$address', 
            contact_person1='$contact_person1', contact_number1='$contact_number1', contact_email1='$contact_email1', 
            contact_person2='$contact_person2', contact_number2='$contact_number2', contact_email2='$contact_email2', clientstate='$state'
        WHERE id='$editid'";

// Execute the query
$result = mysqli_query($conn, $sql);
if ($result) {
    session_start();
    $_SESSION['success']='success';
    header("Location: editlogiclient.php?id=$editid");
} else {
    $_SESSION['error']='success';
    header("Location: editlogiclient.php?id=$editid");
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="favicon.jpg" type="image/x-icon">
    <title>View/Edit</title>
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
            <!-- <li><a href="contact_us.php">Contact Us</a></li> -->
            <li><a href="logout.php">Log Out</a></li></ul>
        </div>
    </div> 
    <?php
if ($showAlert) {
    echo  '<label>
    <input type="checkbox" class="alertCheckbox" autocomplete="off" />
    <div class="alert notice">
      <span class="alertClose">X</span>
      <span class="alertText_addfleet"><b>Success! </b>
          <br class="clear"/></span>
    </div>
  </label>';
}
if ($showError) {
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

<form action="editlogiclient.php?id=<?php echo $id; ?>" method="POST" class="addlogiclient" autocomplete="off">
    <div class="addlogiclientcontainer">
        <p class="headingpara">Edit Client</p>
        <input type="text" value="<?php echo $id ?>" name="editid" hidden>
        <div class="trial1">
            <input type="text" placeholder="" name="client_name" class="input02" value="<?php echo htmlspecialchars($row['client_name']); ?>">
            <label for="client_name" class="placeholder2">Client Name</label>
        </div>
        <div class="trial1">
            <textarea placeholder="" name="address" class="input02"><?php echo htmlspecialchars($row['address']); ?></textarea>
            <label for="address" class="placeholder2">Address</label>
        </div>
        <div class="outer02">
        <div class="trial1">
        <select name="state" id="state" class="input02">
    <option value="" disabled selected>Select state</option>
    <option value="Andhra Pradesh" <?php echo $row['clientstate'] === 'Andhra Pradesh' ? 'selected' : ''; ?>>Andhra Pradesh</option>
    <option value="Arunachal Pradesh" <?php echo $row['clientstate'] === 'Arunachal Pradesh' ? 'selected' : ''; ?>>Arunachal Pradesh</option>
    <option value="Assam" <?php echo $row['clientstate'] === 'Assam' ? 'selected' : ''; ?>>Assam</option>
    <option value="Bihar" <?php echo $row['clientstate'] === 'Bihar' ? 'selected' : ''; ?>>Bihar</option>
    <option value="Chhattisgarh" <?php echo $row['clientstate'] === 'Chhattisgarh' ? 'selected' : ''; ?>>Chhattisgarh</option>
    <option value="Goa" <?php echo $row['clientstate'] === 'Goa' ? 'selected' : ''; ?>>Goa</option>
    <option value="Gujarat" <?php echo $row['clientstate'] === 'Gujarat' ? 'selected' : ''; ?>>Gujarat</option>
    <option value="Haryana" <?php echo $row['clientstate'] === 'Haryana' ? 'selected' : ''; ?>>Haryana</option>
    <option value="Himachal Pradesh" <?php echo $row['clientstate'] === 'Himachal Pradesh' ? 'selected' : ''; ?>>Himachal Pradesh</option>
    <option value="Jharkhand" <?php echo $row['clientstate'] === 'Jharkhand' ? 'selected' : ''; ?>>Jharkhand</option>
    <option value="Karnataka" <?php echo $row['clientstate'] === 'Karnataka' ? 'selected' : ''; ?>>Karnataka</option>
    <option value="Kerala" <?php echo $row['clientstate'] === 'Kerala' ? 'selected' : ''; ?>>Kerala</option>
    <option value="Madhya Pradesh" <?php echo $row['clientstate'] === 'Madhya Pradesh' ? 'selected' : ''; ?>>Madhya Pradesh</option>
    <option value="Maharashtra" <?php echo $row['clientstate'] === 'Maharashtra' ? 'selected' : ''; ?>>Maharashtra</option>
    <option value="Manipur" <?php echo $row['clientstate'] === 'Manipur' ? 'selected' : ''; ?>>Manipur</option>
    <option value="Meghalaya" <?php echo $row['clientstate'] === 'Meghalaya' ? 'selected' : ''; ?>>Meghalaya</option>
    <option value="Mizoram" <?php echo $row['clientstate'] === 'Mizoram' ? 'selected' : ''; ?>>Mizoram</option>
    <option value="Nagaland" <?php echo $row['clientstate'] === 'Nagaland' ? 'selected' : ''; ?>>Nagaland</option>
    <option value="Odisha" <?php echo $row['clientstate'] === 'Odisha' ? 'selected' : ''; ?>>Odisha</option>
    <option value="Punjab" <?php echo $row['clientstate'] === 'Punjab' ? 'selected' : ''; ?>>Punjab</option>
    <option value="Rajasthan" <?php echo $row['clientstate'] === 'Rajasthan' ? 'selected' : ''; ?>>Rajasthan</option>
    <option value="Sikkim" <?php echo $row['clientstate'] === 'Sikkim' ? 'selected' : ''; ?>>Sikkim</option>
    <option value="Tamil Nadu" <?php echo $row['clientstate'] === 'Tamil Nadu' ? 'selected' : ''; ?>>Tamil Nadu</option>
    <option value="Telangana" <?php echo $row['clientstate'] === 'Telangana' ? 'selected' : ''; ?>>Telangana</option>
    <option value="Tripura" <?php echo $row['clientstate'] === 'Tripura' ? 'selected' : ''; ?>>Tripura</option>
    <option value="Uttar Pradesh" <?php echo $row['clientstate'] === 'Uttar Pradesh' ? 'selected' : ''; ?>>Uttar Pradesh</option>
    <option value="Uttarakhand" <?php echo $row['clientstate'] === 'Uttarakhand' ? 'selected' : ''; ?>>Uttarakhand</option>
    <option value="West Bengal" <?php echo $row['clientstate'] === 'West Bengal' ? 'selected' : ''; ?>>West Bengal</option>
    <option value="Andaman and Nicobar Islands" <?php echo $row['clientstate'] === 'Andaman and Nicobar Islands' ? 'selected' : ''; ?>>Andaman and Nicobar Islands</option>
    <option value="Chandigarh" <?php echo $row['clientstate'] === 'Chandigarh' ? 'selected' : ''; ?>>Chandigarh</option>
    <option value="Dadra and Nagar Haveli and Daman and Diu" <?php echo $row['clientstate'] === 'Dadra and Nagar Haveli and Daman and Diu' ? 'selected' : ''; ?>>Dadra and Nagar Haveli and Daman and Diu</option>
    <option value="Lakshadweep" <?php echo $row['clientstate'] === 'Lakshadweep' ? 'selected' : ''; ?>>Lakshadweep</option>
    <option value="Delhi" <?php echo $row['clientstate'] === 'Delhi' ? 'selected' : ''; ?>>Delhi</option>
    <option value="Puducherry" <?php echo $row['clientstate'] === 'Puducherry' ? 'selected' : ''; ?>>Puducherry</option>
</select>
            </div>
            <div class="trial1">
            <input placeholder="" value="<?php echo $row['gst']; ?>" name="gst" class="input02">
            <label for="address" class="placeholder2">GST</label>
        </div>

        </div>
        <div class="outer02">
            <div class="trial1">
                <input type="text" placeholder="" name="contact_person1" class="input02" value="<?php echo htmlspecialchars($row['contact_person1']); ?>">
                <label for="contact_person1" class="placeholder2">Contact Person</label>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" name="contact_number1" class="input02" value="<?php echo htmlspecialchars($row['contact_number1']); ?>">
                <label for="contact_number1" class="placeholder2">Contact Number</label>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" name="contact_email1" class="input02" value="<?php echo htmlspecialchars($row['contact_email1']); ?>">
                <label for="contact_email1" class="placeholder2">Contact Email</label>
            </div>
        </div>
        <div class="outer02">
            <div class="trial1">
                <input type="text" placeholder="" name="contact_person2" class="input02" value="<?php echo htmlspecialchars($row['contact_person2']); ?>">
                <label for="contact_person2" class="placeholder2">Contact Person</label>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" name="contact_number2" class="input02" value="<?php echo htmlspecialchars($row['contact_number2']); ?>">
                <label for="contact_number2" class="placeholder2">Contact Number</label>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" name="contact_email2" class="input02" value="<?php echo htmlspecialchars($row['contact_email2']); ?>">
                <label for="contact_email2" class="placeholder2">Contact Email</label>
            </div>
        </div>
        <button type="submit" class="epc-button">Submit</button>
    </div>
</form>
</body>
</html>