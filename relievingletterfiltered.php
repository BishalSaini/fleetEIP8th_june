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
    $sql="SELECT * FROM relieving_letters WHERE 1=1 AND companyname='$companyname001'";

    switch ($filtertype) {
        case "relieveddate":
            if (!empty($_GET["relievedonfilter"])) {
                $relievedonfilter = mysqli_real_escape_string($conn, $_GET['relievedonfilter']);
                $sql .= " AND relievingdate='$relievedonfilter'";
            }
            break;
        case "name":
            if (!empty($_GET["namefilter"])) {
                $namefilter = mysqli_real_escape_string($conn, $_GET["namefilter"]);
                $sql .= " AND fullname LIKE '%$namefilter%'";
            }
            break;
        case "refno":
            if (!empty($_GET["refnofilter"])) {
                $refnofilter = mysqli_real_escape_string($conn, $_GET["refnofilter"]);
                $sql .= " AND refno='$refnofilter'";
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

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
    <form action="relievingletterfiltered.php" method="GET" autocomplete="off">
        <div class="filterformcontainer">
    <select name="filtertype" id="filterselect" onchange="updateFilterInput(this.value)" class="filter_button" required>
        <option value="" disabled selected>Select Filter</option>
        <option value="relieveddate">Search By Relieving Date</option>
        <option value="name">Search By Name</option>
        <option value="refno">Search By Ref No</option>
    </select>

    <input type="date" name="relievedonfilter" id="enterrelieveddatefilter" placeholder="Enter Relieved Date" class="filterinput" style="display: none;">
    <input type="text" name="namefilter" id="enternamefilter" placeholder="Enter Name" class="filterinput" style="display: none;">
    <input type="text" name="refnofilter" id="enterrefnofilter" placeholder="Enter Ref No" class="filterinput" style="display: none;">
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
                <th>Relieving Date</th>
                <th>Name</th>
                <th>Email</th>
                <th>Job Role</th>
                <th>Department</th>
                <th>Join Date</th>
                <th>Action</th>
            </tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>{$row['refno']}</td>
                    <td>{$row['relievingdate']}</td>
                    <td>{$row['fullname']}</td>
                    <td>{$row['contactemail']}</td>
                    <td>{$row['jobrole']}</td>
                    <td>{$row['department']}</td>
                    <td>{$row['joindate']}</td>
<td>

                <a href='editrelievingletter.php?id={$row['id']}' class='quotation-icon' title='Edit'>
                    <i style='width: 22px; height: 22px;' class='bi bi-pencil'></i>
                </a>
                <a href='viewrelievingletter.php?id={$row['id']}' class='quotation-icon' title='Print'>
                    <i style='width: 22px; height: 22px;' class='bi bi-file-text'></i>
                </a>
            </td>                </tr>";
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
<script>
        function updateFilterInput(selectedValue) {
        document.getElementById("enterrelieveddatefilter").style.display = "none";
        document.getElementById("enternamefilter").style.display = "none";
        document.getElementById("enterrefnofilter").style.display = "none";

        if (selectedValue) {
            const inputField = document.getElementById(`enter${selectedValue}filter`);
            if (inputField) {
                inputField.style.display = "block";
            }
        }
    }


</script>
</html>