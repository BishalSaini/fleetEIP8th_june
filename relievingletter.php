<?php
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

if(isset($_GET['id'])){
    $id=$_GET['id'];
    $editsql="SELECT * FROM `employeedetails` where id=$id and companyname='$companyname001'";
    $resultedit=mysqli_query($conn,$editsql);
    $row=mysqli_fetch_assoc($resultedit);

}


$sql="SELECT * FROM employeedetails where companyname='$companyname001' and status='Working'";
$result=mysqli_query($conn,$sql);

$sql_max_ref_no = "SELECT MAX(refno) AS max_ref_no FROM `relieving_letters` WHERE companyname = '$companyname001'";
$result_max_ref_no = mysqli_query($conn, $sql_max_ref_no);
$row_max_ref_no = mysqli_fetch_assoc($result_max_ref_no);
$next_ref_no = ($row_max_ref_no['max_ref_no'] === null) ? 1 : $row_max_ref_no['max_ref_no'] + 1;



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
    $employeetableid=$_POST['employeetableid'];

    if(isset($employeetableid) && !empty($employeetableid)){
        $updatestatus = "UPDATE `employeedetails` SET `status`='Not Working', `relievingdate`='$relievingdate' WHERE `id`=$employeetableid";
        
        $resultupdate=mysqli_query($conn,$updatestatus);
    
    }
    
    


    $insert="INSERT INTO relieving_letters (
    relievinglettergeneratedon, 
    salutation_dd, 
    fullname, 
    contactemail, 
    contactnumber, 
    to_address, 
    jobrole, 
    department, 
    resignation_date, 
    joindate, 
    relievingdate, 
    companyaddress, 
    notes, 
    sendersname, 
    designation, 
    sendersemail, 
    companyname, 
    refno,
    createdby
) VALUES (
    '$relievinglettergeneratedon',
    '$salutation_dd',
    '$fullname',
    '$contactemail',
    '$contactnumber',
    '$to_address',
    '$jobrole',
    '$department',
    '$resignation_date',
    '$joindate',
    '$relievingdate',
    '$companyaddress',
    '$notes',
    '$sendersname',
    '$designation',
    '$sendersemail',
    '$companyname001',
    '$refno',
    '$email'
)";
$resultinsert=mysqli_query($conn,$insert);

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
<form action="relievingletter.php" class="outerform" METHOD='POST' autocomplete="off">
    <div class="relievinglettercontainer">
        <p class="headingpara">Relieving Letter</p>
        <div class="outer02">
            <div class="trial1">
                <input type="text" placeholder="" value="<?php  echo $next_ref_no; ?>" name="refno" class="input02">
                <label for="" class="placeholder2">Ref No</label>
            </div>
            <div class="trial1">
                <input type="date" placeholder="" value="<?php echo date('Y-m-d'); ?>" name="relievinglettergeneratedon" class="input02">
                <label for="" class="placeholder2">Date</label>
            </div>

        </div>

            <div class="outer02">
            <div class="trial1" id="salute_dd">
            <select name="salutation_dd"  class="input02" required>
                <option value="Mr">Mr</option>
                <option value="Ms">Ms</option>
            </select>
        </div>

            <div class="trial1">
                <select name="fullname" id="selectemployeenamedd" class="input02" onchange="fetchdetailforrelieving(this.value)">
                    <option value=""disabled selected>Select Employee Name</option>
                    <?php if(mysqli_num_rows($result)>0){
                        while($row=mysqli_fetch_assoc($result)){ ?>
                        <option <?php if(isset($id) && $id===$row['id']){echo 'selected';} ?> value="<?php echo $row['fullname'] ?>"><?php echo $row['fullname'] .' - ('. $row['jobrole'] .')'?></option>
                   <?php     }
                    } ?>
                </select>
            </div>
            </div>
            <input type="hidden" name="employeetableid" id="employeeidnumber" value="<?php if(isset($id)){echo $id ;} ?>">
            <div class="outer02">
                <div class="trial1">
                    <input type="text" placeholder="" id="contactemail" name="contactemail" class="input02">
                    <label for="" class="placeholder2">Contact Email</label>
                </div>
                <div class="trial1">
                    <input type="text" placeholder="" id="contactnumber" name="contactnumber" class="input02">
                    <label for="" class="placeholder2">Contact Number</label>
                </div>
            </div>
            <div class="trial1">
                <textarea name="to_address" placeholder="" class="input02" id="to_address"></textarea>
                <label for="" class="placeholder2">Communication Address</label>
            </div>
            <div class="outer02">
                <div class="trial1">
                    <input type="text" placeholder="" id="jobrole" name="jobrole" class="input02">
                    <label for="" class="placeholder2">Job Role</label>
                </div>
                <div class="trial1">
                    <input type="text" placeholder="" id="department" name="department" class="input02">
                    <label for="" class="placeholder2">Department</label>
                </div>
            </div>
            <div class="trial1">
                <input type="date" placeholder="" name="resignation_date" class="input02">
                <label for="" class="placeholder2">Regisgnation Date</label>
            </div>
            <div class="outer02">
                <div class="trial1">
                    <input type="date" placeholder="" id="joiningdate" name="joindate" class="input02">
                    <label for="" class="placeholder2">Date Of Joining</label>
                </div>
                <div class="trial1">
                    <input type="date" placeholder="" name="relievingdate" class="input02" required>
                    <label for="" class="placeholder2">Date of Relieving</label>
                </div>
</div>
<div class="trial1">
    <textarea name="companyaddress" id="companyaddress" class="input02" placeholder=""></textarea>
    <label for="" class="placeholder2">Company Address</label>
</div>
<div class="trial1">
    <textarea type="text" name="notes" placeholder="" class="input02"></textarea>
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
        <option value="<?php echo $senderrow['name']; ?>"><?php echo $senderrow['name'] . ' (' . $senderrow['department'] . ')'; ?></option>
    <?php } } ?>
</select>
        </div>

<div class="trial1" id="newteammemberdiv">
    <input type="text" id="newteammemberinput" name="newsendername" placeholder="" class="input02">
    <label for="" class="placeholder2">Name</label>
</div>

<div class="trial1">
    <input type="text" id="designation" placeholder="" name="designation" class="input02">
    <label for="" class="placeholder2">Designation</label>
</div>
<div class="trial1">
    <input type="text" id="email" placeholder="" name="sendersemail" class="input02">
    <label for="" class="placeholder2">Email</label>
</div>
        </div>

<button class="epc-button">Submit</button>
    </div>
</form>
</body>
<script>
    document.addEventListener('DOMContentLoaded', function() {
    var selectemployeenamedd = document.getElementById('selectemployeenamedd');
    
    // Check if the select element has a value set
    if (selectemployeenamedd.value !== '') {
        fetchdetailforrelieving(selectemployeenamedd.value);
    } else {
        // If no value, check if there's a default value to select
        var selectedEmployeeName = "<?php echo isset($row['fullname']) ? $row['fullname'] : ''; ?>";
        if (selectedEmployeeName) {
            selectemployeenamedd.value = selectedEmployeeName;
            fetchdetailforrelieving(selectedEmployeeName);
        }
    }
});




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
                document.getElementById('employeeidnumber').value = data.id;
            } else {
                // If no data is returned, clear the fields
                document.getElementById('contactemail').value = "";
                document.getElementById('contactnumber').value = "";
                document.getElementById('joiningdate').value = "";
                document.getElementById('companyaddress').value = "";
                document.getElementById('to_address').value = "";
                document.getElementById('department').value = "";
                document.getElementById('jobrole').value = "";
                document.getElementById('employeeidnumber').value = "";
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