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

if($_SERVER['REQUEST_METHOD']==='GET' && isset($_GET['filtertype'])){
    $filtertype=$_GET['filtertype'];
    $sql="SELECT * FROM employeedetails WHERE 1=1 AND companyname='$companyname001'";

    switch ($filtertype) {
        case "email":
            if (!empty($_GET["emailfilter"])) {
                $emailfilter = mysqli_real_escape_string($conn, $_GET['emailfilter']);
                $sql .= " AND contactemail='$emailfilter'";
            }
            break;
        case "name":
            if (!empty($_GET["namefilter"])) {
                $namefilter = mysqli_real_escape_string($conn, $_GET["namefilter"]);
                $sql .= " AND fullname LIKE '%$namefilter%'";
            }
            break;
        case "mobile":
            if (!empty($_GET["mobilefilter"])) {
                $mobilefilter = mysqli_real_escape_string($conn, $_GET["mobilefilter"]);
                $sql .= " AND contactnumber='$mobilefilter'";
            }
            break;
        case 'jobrole':
            if (!empty($_GET['jobrolefilter'])) {
                $jobRole = mysqli_real_escape_string($conn, $_GET['jobrolefilter']);
                $sql .= " AND jobrole LIKE '%$jobRole%'";
            }
            break;
        case 'joiningdate':
            if (!empty($_GET['joiningfilter'])) {
                $joiningDate = mysqli_real_escape_string($conn, $_GET['joiningfilter']);
                $sql .= " AND joindate = '$joiningDate'";
            }
            break;
        case 'joininglocation':
            if (!empty($_GET['statefilter'])) {
                $state = mysqli_real_escape_string($conn, $_GET['statefilter']);
                $sql .= " AND joinlocation = '$state'";
            }
        case 'refno':
            if (!empty($_GET['refnofilter'])) {
                $refno = mysqli_real_escape_string($conn, $_GET['refnofilter']);
                $sql .= " AND refno = '$refno'";
            }
            break;
        case 'department':
            if (!empty($_GET['departmentfilter'])) {
                $departmentfilter = mysqli_real_escape_string($conn, $_GET['departmentfilter']);
                $sql .= " AND department = '$departmentfilter'";
            }
            break;
        default:
            echo "Invalid filter type.";
            exit;
    }}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Offer Letter</title>
    <link rel="stylesheet" href="style.css">
    <style>
    .quotation-table {
  width: 96%;
  margin-left:2%;
  font-size: 13px;
  border-collapse: collapse;
  margin-top: 20px;
  padding: 10px; 
}
.date_content_td{
  width: 7%;
}
.ref_no_th{
  width: 5%;
}
.quotation-table, .quotation-table th, .quotation-table td {
  border: 1px solid black!important; 
  margin-top:30px;
}

.quotation-table th, .quotation-table td {
  padding: 8px!important;
  text-align: left!important;
}  

.quotation-table .table-heading { 
    background-color: #4067B5!important; 
    color: white!important;
}


</style>

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
    <br><br>
<div class="filters">
    <p>Apply Filter :</p>
    <form action="offerletterfiltered.php" method="GET" autocomplete="off">
        <div class="filterformcontainer">
    <select name="filtertype" id="filterselect" onchange="updateFilterInput(this.value)" class="filter_button" required>
        <option value="" disabled selected>Select Filter</option>
        <option value="email">Search By Email</option>
        <option value="name">Search By Name</option>
        <option value="mobile">Search By Mobile</option>
        <option value="jobrole">Search By Job Role</option>
        <option value="joiningdate">Search By Date Of Joining</option>
        <option value="joininglocation">Search By Joining Location</option>
        <option value="department">Search By Department</option>
        <option value="refno">Search By Ref No</option>
    </select>

    <input type="text" name="emailfilter" id="enteremailfilter" placeholder="Enter Email" class="filterinput" style="display: none;">
    <input type="text" name="namefilter" id="enternamefilter" placeholder="Enter Name" class="filterinput" style="display: none;">
    <input type="text" name="mobilefilter" id="entermobilefilter" placeholder="Enter Mobile" class="filterinput" style="display: none;">
    <input type="text" name="jobrolefilter" id="enterjobrolefilter" placeholder="Enter Job Role" class="filterinput" style="display: none;">
    <input type="date" name="joiningfilter" id="enterjoiningdatefilter" placeholder="Enter Date Of Joining" class="filterinput" style="display: none;">
    <input type="text" name="departmentfilter" id="enterdepartmentfilter" placeholder="Enter Department" class="filterinput" style="display: none;">
    <input type="text" name="refnofilter" id="enterrefnofilter" placeholder="Enter Ref No" class="filterinput" style="display: none;">
    <!-- <input type="text" name="aadhar" id="enterjoininglocationfilter" placeholder="Enter Joining" class="filterinput" style="display: none;" minlength="12" maxlength="12" pattern="\d{12}" title="Aadhar number must be exactly 12 digits"> -->
    <select name="statefilter" id="enterjoininglocationfilter" style="display: none;" class="filterinput2">
    <option value="" disabled selected>Joining State</option>
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
    <option value="Delhi">Delhi</option>
    <option value="Jammu and Kashmir">Jammu and Kashmir</option>
    <option value="Ladakh">Ladakh</option>
    <option value="Lakshadweep">Lakshadweep</option>
    <option value="Puducherry">Puducherry</option>

    </select>
    <button class="filter_button" id="submitfilter">Submit</button>
</div>
</form>

</div>



    <?php 
// Execute the query
$result = mysqli_query($conn, $sql);

if ($result) {
    if (mysqli_num_rows($result) > 0) {
        // Display results
        echo "<table class='quotation-table' style='width:80%; margin-left: 10%;' border='1'>";
        echo "<tr>
                <th>Ref No</th>
                <th>Name</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>Job Role</th>
                <th>Department</th>
                <th>Joining Date</th>
                <th>Aadhar Number</th>
                <th>Joining Location</th>
            </tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>{$row['refno']}</td>
                    <td>{$row['fullname']}</td>
                    <td>{$row['contactemail']}</td>
                    <td>{$row['contactnumber']}</td>
                    <td>{$row['jobrole']}</td>
                    <td>{$row['department']}</td>
                    <td>{$row['joindate']}</td>
                    <td>{$row['aadhaar']}</td>
                    <td>{$row['joinlocation']}</td>
                </tr>";
        }
        echo "</table>";
    } else {
        echo "<p class='fulllength'>No records found matching the criteria.</p>";
    }
} else {
    echo "Error: " . mysqli_error($conn);
}


// Close database connection
mysqli_close($conn);
?>
</body>
</html>