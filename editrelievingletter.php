<?php
$id=$_GET['id'];

include "partials/_dbconnect.php";


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$companyname001 = $_SESSION['companyname'];
$enterprise = $_SESSION['enterprise'];
$email = $_SESSION['email'];

$dashboard_url = '';
if ($enterprise === 'rental') {
    $dashboard_url = 'rental_dashboard.php';
} elseif ($enterprise === 'logistics') {
    $dashboard_url = 'logisticsdashboard.php';
} elseif ($enterprise === 'epc') {
    $dashboard_url = 'epc_dashboard.php';
} elseif ($enterprise === 'admin') {
    $dashboard_url = 'news/admin/dashboard.php';
}
$showAlert = false;
$showError = false;

$sql="SELECT * FROM employeedetails where companyname='$companyname001' and status='Working'";
$result=mysqli_query($conn,$sql);


$editdata="SELECT * FROM `relieving_letters` where id=$id and companyname='$companyname001'";
$resulteditdata=mysqli_query($conn,$editdata);
$row=mysqli_fetch_assoc($resulteditdata);

if($_SERVER['REQUEST_METHOD']==='POST'){
    include "partials/_dbconnect.php";
    $relievinglettergeneratedon=$_POST['relievinglettergeneratedon'];
    $salutation_dd=$_POST['salutation_dd'] ?? '';
    $fullname=$_POST['fullname'];
    $contactemail=$_POST['contactemail'];
    $contactnumber=$_POST['contactnumber'];
    $to_address=$_POST['to_address'];
    $jobrole=$_POST['jobrole'];
    $department=$_POST['department'];
    $resignation_date=$_POST['resignation_date'];
    $joindate=$_POST['joindate'];
    $relievingdate=$_POST['relievingdate'];
    $companyaddress=$_POST['companyaddress'];
    $notes=$_POST['notes'];
    $sendersname = isset($_POST['newsendername']) && !empty($_POST['newsendername']) 
    ? $_POST['newsendername'] 
    : (isset($_POST['sendersname']) ? $_POST['sendersname'] : '');
    $designation=$_POST['designation'];
    $sendersemail=$_POST['sendersemail'];
    $refno=$_POST['refno'];
    $editid=$_POST['editid'];


    $update = "UPDATE relieving_letters SET 
    relievinglettergeneratedon = '$relievinglettergeneratedon', 
    salutation_dd = '$salutation_dd', 
    fullname = '$fullname', 
    contactemail = '$contactemail', 
    contactnumber = '$contactnumber', 
    to_address = '$to_address', 
    jobrole = '$jobrole', 
    department = '$department', 
    resignation_date = '$resignation_date', 
    joindate = '$joindate', 
    relievingdate = '$relievingdate', 
    companyaddress = '$companyaddress', 
    notes = '$notes', 
    sendersname = '$sendersname', 
    designation = '$designation', 
    sendersemail = '$sendersemail', 
    companyname = '$companyname001', 
    refno = '$refno', 
    createdby = '$email'
WHERE id = '$editid' AND companyname = '$companyname001'";

$resultinsert=mysqli_query($conn,$update);
if($resultinsert){
    session_start();
    $_SESSION['success']='true';
}

else{
    session_start();
    $_SESSION['error']='true';
}
header("Location: relievingletterdashboard.php");




}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relieving Letter</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="tiles.css">
    <link rel="shortcut icon" href="favicon.jpg" type="image/x-icon">
</head>
<body>
<div class="navbar1">
        <div class="logo_fleet">
            <img src="logo_fe.png" alt="FLEET EIP" onclick="window.location.href='<?php echo $dashboard_url  ?>'">
        </div>
        <div class="iconcontainer">
            <ul>
                <li><a href="<?php echo $dashboard_url ?>">Dashboard</a></li>
                <li><a href="logout.php">Log Out</a></li>
            </ul>
        </div>
    </div>
    <?php
    if ($showAlert) {
        echo '<label><input type="checkbox" class="alertCheckbox" autocomplete="off" />
        <div class="alert notice"><span class="alertClose">X</span><span class="alertText">Success<br class="clear"/></span></div></label>';
    }
    if ($showError) {
        echo '<label><input type="checkbox" class="alertCheckbox" autocomplete="off" />
        <div class="alert error"><span class="alertClose">X</span><span class="alertText">Something Went Wrong<br class="clear"/></span></div></label>';
    }
?>
<form action="editrelievingletter.php?id=<?php echo $id; ?>" class="outerform" METHOD='POST' autocomplete="off">
    <div class="relievinglettercontainer">
        <p class="headingpara">Relieving Letter</p>
        <input type="hidden" name="editid" value="<?php echo $id ?>">
        <div class="outer02">
            <div class="trial1">
                <input type="text" placeholder="" value="<?php echo $row['refno']; ?>" name="refno" class="input02" >
                <label for="" class="placeholder2">Ref No</label>
            </div>
            <div class="trial1">
                <input type="date" placeholder="" value="<?php echo $row['relievinglettergeneratedon']; ?>" name="relievinglettergeneratedon" class="input02">
                <label for="" class="placeholder2">Date</label>
            </div>
        </div>

        <div class="outer02">
            <div class="trial1" id="salute_dd">
                <select name="salutation_dd" class="input02" required>
                    <option value="Mr" <?php echo ($row['salutation_dd'] === 'Mr') ? 'selected' : ''; ?>>Mr</option>
                    <option value="Ms" <?php echo ($row['salutation_dd'] === 'Ms') ? 'selected' : ''; ?>>Ms</option>
                </select>
            </div>

            <div class="trial1">
                <select name="fullname" id="" class="input02" onchange="fetchdetailforrelieving(this.value)">
                    <option value=""disabled selected>Select Employee Name</option>
                    <?php if(mysqli_num_rows($result)>0){
                        while($roww=mysqli_fetch_assoc($result)){ ?>
<option value="<?php echo $roww['fullname']; ?>" 
    <?php if ($row['fullname'] === $roww['fullname']) { echo 'selected'; } ?>>
    <?php echo $roww['fullname'] . ' - (' . $roww['jobrole'] . ')'; ?>
</option>
                   <?php     }
                    } ?>
                </select>
            </div>
        </div>

        <div class="outer02">
            <div class="trial1">
                <input type="text" placeholder="" id="contactemail" name="contactemail" value="<?php echo $row['contactemail']; ?>" class="input02">
                <label for="" class="placeholder2">Contact Email</label>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" id="contactnumber" name="contactnumber" value="<?php echo $row['contactnumber']; ?>" class="input02">
                <label for="" class="placeholder2">Contact Number</label>
            </div>
        </div>

        <div class="trial1">
            <textarea name="to_address" placeholder="" class="input02" id="to_address"><?php echo $row['to_address']; ?></textarea>
            <label for="" class="placeholder2">Communication Address</label>
        </div>

        <div class="outer02">
            <div class="trial1">
                <input type="text" placeholder="" id="jobrole" name="jobrole" value="<?php echo $row['jobrole']; ?>" class="input02">
                <label for="" class="placeholder2">Job Role</label>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" id="department" name="department" value="<?php echo $row['department']; ?>" class="input02">
                <label for="" class="placeholder2">Department</label>
            </div>
        </div>

        <div class="trial1">
            <input type="date" placeholder="" name="resignation_date" value="<?php echo $row['resignation_date']; ?>" class="input02">
            <label for="" class="placeholder2">Resignation Date</label>
        </div>

        <div class="outer02">
            <div class="trial1">
                <input type="date" placeholder="" id="joiningdate" name="joindate" value="<?php echo $row['joindate']; ?>" class="input02">
                <label for="" class="placeholder2">Date Of Joining</label>
            </div>
            <div class="trial1">
                <input type="date" placeholder="" name="relievingdate" value="<?php echo $row['relievingdate']; ?>" class="input02">
                <label for="" class="placeholder2">Date of Relieving</label>
            </div>
        </div>

        <div class="trial1">
            <textarea name="companyaddress" id="companyaddress" class="input02" placeholder=""><?php echo $row['companyaddress']; ?></textarea>
            <label for="" class="placeholder2">Company Address</label>
        </div>

        <div class="trial1">
            <textarea type="text" name="notes" placeholder="" class="input02"><?php echo $row['notes']; ?></textarea>
            <label for="" class="placeholder2">Notes</label>
        </div>

        <div class="outer02">
        <div class="trial1" id="sendernameofferletterdiv">
<select name="sendersname" id="sendernameofferletter" class="input02" onchange="fetchTeamMemberDetails(this.value)">
    <option value="" disabled selected>Senders Name</option>
    <option value="New Member">New Member</option>
    <?php
    $sendersinfo = "SELECT * FROM `team_members` WHERE company_name='$companyname001' AND (department='Management' OR department='Human Resource Department')";
    $senderresult = mysqli_query($conn, $sendersinfo);
    if (mysqli_num_rows($senderresult) > 0) {
        while ($senderrow = mysqli_fetch_assoc($senderresult)) {
    ?>
        <option value="<?php echo $senderrow['name']; ?>" <?php if($row['sendersname']===$senderrow['name']){echo 'selected';} ?>><?php echo $senderrow['name'] . ' (' . $senderrow['department'] . ')'; ?></option>
    <?php } } ?>
</select>
        </div>


            <div class="trial1" id="newteammemberdiv">
                <input type="text" id="newteammemberinput" name="newsendername" placeholder=""  class="input02">
                <label for="" class="placeholder2">Name</label>
            </div>

            <div class="trial1">
                <input type="text" id="designation" placeholder="" name="designation" value="<?php echo $row['designation']; ?>" class="input02">
                <label for="" class="placeholder2">Designation</label>
            </div>

            <div class="trial1">
                <input type="text" id="email" placeholder="" name="sendersemail" value="<?php echo $row['sendersemail']; ?>" class="input02">
                <label for="" class="placeholder2">Email</label>
            </div>
        </div>

        <button class="epc-button">Submit</button>
    </div>
</form>
</body>
<script>
            function fetchdetailforrelieving(name) {
    // AJAX request to fetch data from PHP
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "fetchdataforrelieving.php?name=" + name, true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var data = JSON.parse(xhr.responseText);
            if (data) {
                document.getElementById('contactemail').value = data.contactemail;
                document.getElementById('contactnumber').value = data.contactnumber;
                document.getElementById('joiningdate').value = data.joindate;
                document.getElementById('to_address').value = data.to_address;
                document.getElementById('companyaddress').value = data.joinlocation;
                document.getElementById('department').value = data.department;
                document.getElementById('jobrole').value = data.jobrole;
            } else {
                // If no data is returned, clear the fields
                document.getElementById('contactemail').value = "";
                document.getElementById('contactnumber').value = "";
                document.getElementById('joiningdate').value = "";
                document.getElementById('companyaddress').value = "";
                document.getElementById('to_address').value = "";
                document.getElementById('department').value = "";
                document.getElementById('jobrole').value = "";
            }
        }
    };
    xhr.send();
}
function fetchTeamMemberDetails(name) {
    // Check if "New Member" is selected
    if (name === "New Member") {

        document.getElementById('newteammemberdiv').style.display = "block";
        // document.getElementById('sendernameofferletterdiv').style.display = "none";
        document.getElementById('designation').value = "";
        document.getElementById('email').value = "";
        return;
    } else {
        document.getElementById('newteammemberdiv').style.display = "none";
    }

    // AJAX request to fetch data from PHP
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "fetch_team_member.php?name=" + name, true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var data = JSON.parse(xhr.responseText);
            if (data) {
                document.getElementById('designation').value = data.designation;
                document.getElementById('email').value = data.email;
            } else {
                // If no data is returned, clear the fields
                document.getElementById('designation').value = "";
                document.getElementById('email').value = "";
            }
        }
    };
    xhr.send();
}


</script>
</html>