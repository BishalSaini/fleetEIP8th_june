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

if(isset($_SESSION['success'])){
    $showAlert=true;
    unset($_SESSION['success']);
}
if(isset($_SESSION['error'])){
    $showError=true;
    unset($_SESSION['error']);
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HR Corner</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.4/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="tiles.css">
    <link rel="shortcut icon" href="favicon.jpg" type="image/x-icon">
    <style>
                .generate-btn{
            border:none;
            background-color:white;
            /* border:1px solid red; */
            margin-top:70px;
        }
        .project-info{
            width: 250px;
            height:50px!important;
        }
        .article-wrapper{
            width: 270px;
        }
        .menu {
    display: none; /* Initially hidden */
    position: absolute; /* Positioning the menu in relation to the icon */
    background-color: #fff; /* White background */
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2); /* Shadow effect */
    border-radius: 5px; /* Rounded corners */

    margin-top: 70px;
    margin-left: 75px;
        z-index: 1; /* Make sure the menu is above other content */
}


.menu li {
    text-align: left; /* Align text to the left */
    list-style: none;
}

.menu li a {
    padding: 10px 20px;
    text-decoration: none; /* Remove underline from links */
    color: #333; /* Dark color for the text */
    display: block; /* Make the links block-level for easier clicking */
    font-size: 14px; /* Adjust font size */
    padding: 10px 20px; 
    transition: background-color 0.3s ease; /* Smooth transition for hover effect */
}

.menu li a:hover {
    color: black; /* Changes text color to black on hover */
    background-color: #f1f1f1;
    

}
/* Container for employee cards */
.employee-cards-container {
    display: grid;
    grid-template-columns: repeat(4, 1fr); /* 3 cards per row */
    gap: 20px; /* Space between the cards */
    padding: 20px;
}

/* Style for each employee card */
.employee-card {
    /* background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    overflow: hidden; */
}

/* Inner content of the employee card */
.viewfleet_outer {
    padding: 15px;
}

.fleetcard_operator img {
    max-width: 100%;
    border-radius: 8%;
}


/* Mobile responsiveness */
@media (max-width: 768px) {
    .employee-cards-container {
        grid-template-columns: repeat(2, 1fr); /* 2 cards per row on smaller screens */
    }
}

@media (max-width: 480px) {
    .employee-cards-container {
        grid-template-columns: 1fr; /* 1 card per row on very small screens */
    }
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
<div class="view_op_btn">
<button class="generate-btn"> 
    <article class="article-wrapper" onclick="window.location.href='addemployee.php'" > 
  <div class="rounded-lg container-projectss ">
    </div>
    <div class="project-info" onclick="view_op_screen()">
      <div class="flex-pr">
        <div class="project-title text-nowrap">Add Employee</div>
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
<br><br>
<div class="filters">
    <p>Apply Filter :</p>
    <form action="employeefiltered.php" method="GET" autocomplete="off">
        <div class="filterformcontainer">
    <select name="filtertype" id="filterselect" onchange="updateFilterInput(this.value)" class="filter_button" required>
        <option value="" disabled selected>Select Filter</option>
        <option value="email">Search By Email</option>
        <option value="name">Search By Name</option>
        <option value="mobile">Search By Mobile</option>
        <option value="jobrole">Search By Job Role</option>
        <option value="joiningdate">Search By Date Of Joining</option>
        <option value="aadharnumber">Search By Aadhar Number</option>
        <option value="joininglocation">Search By Joining Location</option>
        <option value="employeeid">Search By Employee ID</option>
        <option value="department">Search By Department</option>
    </select>

    <input type="text" name="emailfilter" id="enteremailfilter" placeholder="Enter Email" class="filterinput" style="display: none;">
    <input type="text" name="namefilter" id="enternamefilter" placeholder="Enter Name" class="filterinput" style="display: none;">
    <input type="text" name="mobilefilter" id="entermobilefilter" placeholder="Enter Mobile" class="filterinput" style="display: none;">
    <input type="text" name="jobrolefilter" id="enterjobrolefilter" placeholder="Enter Job Role" class="filterinput" style="display: none;">
    <input type="date" name="joiningfilter" id="enterjoiningdatefilter" placeholder="Enter Date Of Joining" class="filterinput" style="display: none;">
    <input type="text" name="aadharfilter" id="enteraadharnumberfilter" placeholder="Enter Aadhar Number" class="filterinput" style="display: none;" minlength="12" maxlength="12" pattern="\d{12}" title="Aadhar number must be exactly 12 digits">
    <input type="text" name="employeeidfilter" id="enteremployeeidfilter" placeholder="Enter Employee ID" class="filterinput" style="display: none;">
    <input type="text" name="departmentfilter" id="enterdepartmentfilter" placeholder="Enter Department" class="filterinput" style="display: none;">
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
$pending = "SELECT * FROM `employeedetails` WHERE companyname='$companyname001' AND status='Offer Sent'";
$pendingresult = mysqli_query($conn, $pending);
if (mysqli_num_rows($pendingresult) > 0) { ?>
    <table class="quotation-table" id="pendingoffers">
        <thead>
            <tr>
                <th>Name</th>
                <th>Offer Date</th>
                <th>Joining Date</th>
                <th>Job Role</th>
                <th>Department</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($rowpending = mysqli_fetch_assoc($pendingresult)) { ?>
                <tr>
                    <td><?php echo $rowpending['fullname']; ?></td>
                    <td><?php echo $rowpending['generatedon']; ?></td>
                    <td><?php echo $rowpending['joindate']; ?></td>
                    <td><?php echo $rowpending['jobrole']; ?></td>
                    <td><?php echo $rowpending['department']; ?></td>
                    <td data-label="Actions">
            <a href="offeraccepted.php?id=<?php echo $rowpending['id']; ?>" class="quotation-icon" onclick="return confirmaccept()" title="Offer Accepted">
                <i style="width: 22px; height: 22px;" class="bi-check-circle"></i>
            </a>
            <a href="delete_quotation.php?del_id=<?php echo $rowpending['id']; ?>" onclick="return confirmrejection();" class="quotation-icon" title="Offer Rejected">
                <i style="width: 22px; height: 22px;" class="bi-x-circle"></i>
            </a>
        </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
<?php
}
?>
<br><br><br>
<?php
$result = mysqli_query($conn, "SELECT * FROM employeedetails WHERE companyname='$companyname001' AND status='Working'");
if(mysqli_num_rows($result)>0){ ?>
    <div class="fulllengthleft">
        <h3><?php echo ucwords($companyname001) ?>`s Employee</h3>
    </div>

    <!-- Container for the employee cards -->
    <div class="employee-cards-container">
        <?php 
        $loop_count = 0;
        while ($row = mysqli_fetch_assoc($result)): ?>
<div class="employee-card">
    <div class="viewfleet_outer">
        <div class="fleetcard_operator">
            <img src="img/<?php echo $row['photo']; ?>" alt="photo">
        </div>
        <div class="content">
            <p><strong>Employee ID : </strong><?php echo $row['employeeid'] ?></p>
            <p><strong>Name:</strong> <?php echo $row['fullname']; ?> </p>  
            <p><strong>Email:</strong> <?php echo $row['contactemail']; ?></p>  
            <p><strong>Phone Number:</strong> <?php echo $row['contactnumber']; ?></p>  
            <p><strong>Job Role:</strong> <?php echo $row['jobrole']; ?></p>  
            <p><strong>Date of Joining:</strong> <?php echo date('jS M Y', strtotime($row['joindate'])); ?></p>
        </div>

        <!-- Button and Menu Container -->
        <div class="viewfleet2_btncontainer">
            <a href="editemployee.php?id=<?php echo $row['id']; ?>" class="action-btn">
                <i title="View & Edit" class="bi bi-pen"></i>
            </a> 
            <a href="deleteemployee.php?id=<?php echo $row['id']; ?>" onclick="return confirmDelete();" class="action-btn">
                <i title="Delete" class="bi bi-trash"></i>
            </a>

            <!-- Expandable Menu Button -->
            <a href="#" class="action-btn" onclick="toggleMenu(<?php echo $row['id']; ?>)">
                <i class="bi bi-three-dots-vertical"></i>
            </a>
        </div>

        <!-- Unique Menu for Each Employee -->
        <ul id="menu-<?php echo $row['id']; ?>" class="menu">
            <li><a href="generatesalaryslip.php?id=<?php echo $row['id']; ?>">Generate Salary Slip</a></li>
            <li><a href="relievingletter.php?id=<?php echo $row['id']; ?>">Generate Relieving Letter</a></li>
            <!-- <li><a href="#">Generate Relieving Letter</a></li> -->
        </ul>
    </div>
</div>
        <?php endwhile; ?>
    </div>
<?php } ?>

<br>
<?php
$pending = "SELECT * FROM `employeedetails` WHERE companyname='$companyname001' AND status='Not Working'";
$pendingresult = mysqli_query($conn, $pending);
if (mysqli_num_rows($pendingresult) > 0) { ?>
    <div class="fulllengthleft">
        <h3><?php echo ucwords($companyname001) ?>`s Ex-Employee</h3>
    </div>

    <table class="quotation-table" id="exemployee">
        <thead>
            <tr>
                <th>Joining Date</th>
                <th>Name</th>

                <th>Job Role</th>
                <th>Department</th>
                <th>Releiving Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($rowpending = mysqli_fetch_assoc($pendingresult)) { ?>
                <tr>
                    <td><?php echo $rowpending['joindate']; ?></td>
                    <td><?php echo $rowpending['fullname']; ?></td>

                    <td><?php echo $rowpending['jobrole']; ?></td>
                    <td><?php echo $rowpending['status']; ?></td>
                    <td><?php echo $rowpending['department']; ?></td>
                    <td data-label="Actions">
                    <a href="editemployee.php?id=<?php echo $rowpending['id']; ?>&readonly=true" class="quotation-icon" title="View Employee">
    <i style="width: 22px; height: 22px;" class="bi bi-eye"></i>
</a>
            <a href="rejoined.php?id=<?php echo $rowpending['id']; ?>" onclick="return confirmrejoin();" class="quotation-icon" title="Rejoined <?php echo $companyname001 ?> ?">
                <i style="width: 22px; height: 22px;" class="bi bi-arrow-repeat"></i>
            </a>
        </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
<?php
}
?>
<br><br>




</body>
<script>

function updateFilterInput(selectedValue) {
        document.getElementById("enteremailfilter").style.display = "none";
        document.getElementById("enternamefilter").style.display = "none";
        document.getElementById("entermobilefilter").style.display = "none";
        document.getElementById("enterjobrolefilter").style.display = "none";
        document.getElementById("enterjoiningdatefilter").style.display = "none";
        document.getElementById("enteraadharnumberfilter").style.display = "none";
        document.getElementById("enterjoininglocationfilter").style.display = "none";
        document.getElementById("enteremployeeidfilter").style.display = "none";
        document.getElementById("enterdepartmentfilter").style.display = "none";

        if (selectedValue) {
            const inputField = document.getElementById(`enter${selectedValue}filter`);
            if (inputField) {
                inputField.style.display = "block";
            }
        }
    }
function confirmDelete() {
    return confirm("Are you sure you want to delete this employee?");
}

function toggleMenu(employeeId) {
    var menu = document.getElementById('menu-' + employeeId);
    // Close all other menus first
    var allMenus = document.querySelectorAll('.menu');
    allMenus.forEach(function(item) {
        if (item !== menu) {
            item.style.display = "none";
        }
    });
    // Toggle the clicked menu
    if (menu.style.display === "none" || menu.style.display === "") {
        menu.style.display = "block";  // Show the menu
    } else {
        menu.style.display = "none";  // Hide the menu
    }
}


    function confirmaccept(){
        return confirm("By clicking 'OK', you are confirming that the user has accepted the offer letter and will be added to the employee list.");
    }
    function confirmrejection(){
        return confirm("By clicking 'OK', you are confirming that the user has rejected the offer letter and will not be added to the employee list.");
    }
    function confirmrejoin(){
        return confirm("By clicking 'OK', you are confirming that the user has rejoined the firm and will be added to the employee list.");
    }
</script>
</html>