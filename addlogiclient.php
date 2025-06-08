<?php 
session_start();
$showAlert=false;
$showError=false;
$companyname001 = $_SESSION['companyname'];
$enterprise=$_SESSION['enterprise'];
// $id=$_GET['id'];

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
    $state=$_POST['state'];

    $sql = "INSERT INTO clients_logi (clientstate,gst,companyname,client_name, address, contact_person1, contact_number1, contact_email1, contact_person2, contact_number2, contact_email2) 
        VALUES ('$state','$gst','$companyname001','$client_name', '$address', '$contact_person1', '$contact_number1', '$contact_email1', '$contact_person2', '$contact_number2', '$contact_email2')";

    $result=mysqli_query($conn,$sql);
    if($result){
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
    <meta charset="UTF-8">
    <link rel="icon" href="favicon.jpg" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="tiles.css">
    <title>Add Client</title>
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
<div class="add_fleet_btn_new" id="logiclient">
<button class="generate-btn"> 
    <article class="article-wrapper" onclick="window.location.href='viewlogiclient.php'" id="clientlogibtn"> 
  <div class="rounded-lg container-projectss ">
    </div>
    <div class="project-info">
      <div class="flex-pr">
        <div class="project-title text-nowrap">View Client</div>
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

    <form action="addlogiclient.php" method="POST" class="addlogiclient" autocomplete="off">
    <div class="addlogiclientcontainer">
        <p class="headingpara">Add Client</p>
        <div class="trial1">
            <input type="text" placeholder="" name="client_name" class="input02">
            <label for="client_name" class="placeholder2">Client Name</label>
        </div>
        <div class="trial1">
            <textarea placeholder="" name="address" class="input02"></textarea>
            <label for="address" class="placeholder2">Address</label>
        </div>
        <div class="outer02">
        <div class="trial1">
        <select name="state" id="state" class="input02">
            <option value="" disabled selected>Select  state</option>
            <option value="Andhra Pradesh">Andhra Pradesh</option>
            <option value="Arunachal Pradesh">Arunachal Pradesh</option>
            <option value="Assam">Assam</option>
            <option value="Bihar">Bihar</option>
            <option value="Chhattisgarh">Chhattisgarh</option>
            <option value="Goa">Goa</option>
            <option value="Gujarat">Gujarat</option>
            <option value="Haryana">Haryana</option>
            <option value="Himachal Pradesh">Himachal Pradesh</option>
            <option value="Jharkhand">Jharkhand</option>
            <option value="Karnataka">Karnataka</option>
            <option value="Kerala">Kerala</option>
            <option value="Madhya Pradesh">Madhya Pradesh</option>
            <option value="Maharashtra">Maharashtra</option>
            <option value="Manipur">Manipur</option>
            <option value="Meghalaya">Meghalaya</option>
            <option value="Mizoram">Mizoram</option>
            <option value="Nagaland">Nagaland</option>
            <option value="Odisha">Odisha</option>
            <option value="Punjab">Punjab</option>
            <option value="Rajasthan">Rajasthan</option>
            <option value="Sikkim">Sikkim</option>
            <option value="Tamil Nadu">Tamil Nadu</option>
            <option value="Telangana">Telangana</option>
            <option value="Tripura">Tripura</option>
            <option value="Uttar Pradesh">Uttar Pradesh</option>
            <option value="Uttarakhand">Uttarakhand</option>
            <option value="West Bengal">West Bengal</option>
            <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
            <option value="Chandigarh">Chandigarh</option>
            <option value="Dadra and Nagar Haveli and Daman and Diu">Dadra and Nagar Haveli and Daman and Diu</option>
            <option value="Lakshadweep">Lakshadweep</option>
            <option value="Delhi">Delhi</option>
            <option value="Puducherry">Puducherry</option>
        </select>
            </div>
            <div class="trial1">
            <input placeholder="" name="gst" class="input02">
            <label for="address" class="placeholder2">GST</label>
        </div>

        </div>

        <div class="outer02">
            <div class="trial1">
                <input type="text" placeholder="" name="contact_person1" class="input02">
                <label for="contact_person1" class="placeholder2">Contact Person</label>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" name="contact_number1" class="input02">
                <label for="contact_number1" class="placeholder2">Contact Number</label>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" name="contact_email1" class="input02">
                <label for="contact_email1" class="placeholder2">Contact Email</label>
            </div>
        </div>
        <div class="outer02">
            <div class="trial1">
                <input type="text" placeholder="" name="contact_person2" class="input02">
                <label for="contact_person2" class="placeholder2">Contact Person</label>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" name="contact_number2" class="input02">
                <label for="contact_number2" class="placeholder2">Contact Number</label>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" name="contact_email2" class="input02">
                <label for="contact_email2" class="placeholder2">Contact Email</label>
            </div>
        </div>
        <button type="submit" class="epc-button">Submit</button>
    </div>
</form>
    
</body>
</html>