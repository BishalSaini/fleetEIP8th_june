<?php
include_once 'partials/_dbconnect.php'; // Include the database connection file
session_start();

$companyname001 = $_SESSION['companyname'];
$enterprise = $_SESSION['enterprise'];

$dashboard_url = '';
if ($enterprise === 'rental') {
    $dashboard_url = 'rental_dashboard.php';
} elseif ($enterprise === 'logistics') {
    $dashboard_url = 'logisticsdashboard.php';
} elseif ($enterprise === 'epc') {
    $dashboard_url = 'epc_dashboard.php';
} 

$editid = $_GET['id'];
$projectid = $_GET['projectid'];

$sql = "SELECT * FROM `epcprojectcontact` WHERE id='$editid' AND projectid='$projectid' AND companyname='$companyname001'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updatecontactbutton'])) {
    $contactid = $_POST['contactid']; 
    $contactname = $_POST['contactname'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $department = $_POST['department'];
    $designation = $_POST['designation'];
    $projectidnumber = $_POST['projectidnumber'];
    $associatedto = $_POST['associatedto'];

    // Directly use the variables in the SQL query
    $contactdetail = "UPDATE `epcprojectcontact` 
                      SET `associated_to` = '$associatedto', 
                          `projectid` = '$projectidnumber', 
                          `companyname` = '$companyname001', 
                          `name` = '$contactname', 
                          `email` = '$email', 
                          `mobile` = '$mobile', 
                          `department` = '$department', 
                          `designation` = '$designation' 
                      WHERE `id` = '$contactid'"; 

    $result = mysqli_query($conn, $contactdetail);
    if ($result) {
        $_SESSION['success'] = 'updated';
    } else {
        $_SESSION['error'] = 'update_failed';
    }
    
    header("Location: projectinsight.php?id=" . urlencode($projectidnumber));
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit</title>
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="favicon.jpg" type="image/x-icon">
</head>
<body>
<div class="navbar1">
    <div class="logo_fleet">
        <img src="logo_fe.png" alt="FLEET EIP" onclick="window.location.href='<?php echo $dashboard_url ?>'">
    </div>
    <div class="iconcontainer">
        <ul>
            <li><a href="<?php echo $dashboard_url ?>">Dashboard</a></li>
            <li><a href="news/">News</a></li>
            <li><a href="logout.php">Log Out</a></li>
        </ul>
    </div>
</div>
<form action="editprojectteam.php?id=<?php echo $editid; ?>&projectid=<?php echo $projectid; ?>" method="POST" autocomplete="off" class="outerform">
    <div class="addteamprojectinner">
        <p class="headingpara">Edit Team Member</p>
        <input type="hidden" name="contactid" value="<?php echo $editid ?>">

        <div class="trial1">
            <select name="associatedto" class="input02">
                <option value="" disabled selected>Contact Associated To</option>
                <option <?php if($row['associated_to'] === 'Consultant Team') echo 'selected'; ?> value="Consultant Team">Associated To: Consultant Team</option>
                <option <?php if($row['associated_to'] === 'Client Team') echo 'selected'; ?> value="Client Team">Associated To: Client Team</option>
                <option <?php if($row['associated_to'] === $companyname001 . ' Team') echo 'selected'; ?> value="<?php echo $companyname001; ?> Team">Associated To: <?php echo ucwords($companyname001); ?> Team</option>
            </select>
        </div>
        <input type="hidden" name="projectidnumber" value="<?php echo $projectid; ?>">
        
        <div class="trial1">
            <input type="text" value="<?php echo $row['name']; ?>" name="contactname" class="input02" required>
            <label class="placeholder2">Name</label>
        </div>
        <div class="trial1">
            <input type="email" value="<?php echo $row['email']; ?>" name="email" class="input02" required>
            <label class="placeholder2">Email</label>
        </div>
        <div class="trial1">
            <input type="text" value="<?php echo $row['mobile']; ?>" name="mobile" class="input02" required>
            <label class="placeholder2">Cell-Phone</label>
        </div>
        <div class="trial1">
            <input type="text" value="<?php echo $row['department']; ?>" name="department" class="input02" required>
            <label class="placeholder2">Department</label>
        </div>
        <div class="trial1">
            <input type="text" value="<?php echo $row['designation']; ?>" name="designation" class="input02" required>
            <label class="placeholder2">Designation</label>
        </div>
        <button type="submit" name="updatecontactbutton" class="epc-button">Update</button>
    </div>
</form>
</body>
</html>
