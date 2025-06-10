<?php
include 'partials/_dbconnect.php';
session_start();
$companyname001 = $_SESSION['companyname'];
$email1=$_SESSION['email'];
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


$strt_time=$_SESSION['time'];
$expiry_date = date('d-m-Y', strtotime($strt_time . ' +3 months'));


$sql_addedfleet="SELECT COUNT(snum) AS total FROM `fleet1` where companyname='$companyname001'";
$result = mysqli_query($conn, $sql_addedfleet);
$row = mysqli_fetch_assoc($result);
$total_count = $row['total'];

$sql_addedoperator = "SELECT COUNT(id) AS total_operator FROM `myoperators` where company_name='$companyname001'";
$result_operator = mysqli_query($conn, $sql_addedoperator);
$row_operator = mysqli_fetch_assoc($result_operator);
$total_count_operator = $row_operator['total_operator']; // Update variable name to $row_operator


$today = date('Y-m-d'); // Get today's date in PHP

$sql_new_leads="SELECT COUNT(id) AS total_new_leads FROM  `req_by_epc` WHERE id NOT IN (SELECT requirement_id FROM `notinterested_rental` WHERE rental_name = '$companyname001') AND id NOT IN (SELECT req_id FROM `requirement_price_byrental` WHERE rental_name = '$companyname001') AND reqvalid > '$today' ";
$result_new_leads=mysqli_query($conn,$sql_new_leads);
$row_new_leads=mysqli_fetch_assoc($result_new_leads);
$total_new_leads = $row_new_leads['total_new_leads'];

$sql_notification_count_expiry="SELECT COUNT(sno) AS total_notification FROM `insaurance_notification` where company_name='$companyname001'";
$result_count=mysqli_query($conn,$sql_notification_count_expiry);
$row_count_noti= mysqli_fetch_assoc($result_count);
$count_of_notification=$row_count_noti['total_notification'];

$sql_dl_expiry_count = "SELECT COUNT(sno) AS total_dl_notification FROM `dl_expiry` WHERE company_name='$companyname001'";
$dl_result = mysqli_query($conn, $sql_dl_expiry_count);
$row_count_dl = mysqli_fetch_assoc($dl_result);
$count_of_dl_notification = $row_count_dl['total_dl_notification'];

$todonoti="SELECT COUNT(id) AS todonoticount FROM `todo_noti` where assigned_to_email='$email1' and companyname='$companyname001' ";
$resulttodonoti=mysqli_query($conn,$todonoti);
$rowtodonoti=mysqli_fetch_assoc($resulttodonoti);
$todonoticount=$rowtodonoti['todonoticount'];


$currentDate = date('Y-m-d'); // Get the current date in 'Y-m-d' format

$callnoti = "SELECT * FROM `call_reminders` 
              WHERE added_by = '$email1' 
              AND companyname = '$companyname001' 
              AND DATE(reminderon) = '$currentDate'"; // Filter by today's date

$resultcall = mysqli_query($conn, $callnoti);
$callReminders = [];
while ($rowcallnoti = mysqli_fetch_assoc($resultcall)) {
    $callReminders[] = $rowcallnoti; // Store each reminder in an array
}

$sql_to_do_data="SELECT * FROM `to_do` where companyname='$companyname001'";
$sql_todo_result=mysqli_query($conn ,$sql_to_do_data);

$sql_employee="SELECT * FROM `login` where companyname='$companyname001'";
$sql_employee_result=mysqli_query($conn,$sql_employee);

?>
<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="../favicon.jpg" type="image/x-icon">
    <script src="main.js"></script>
    <script src="admin.js" defer></script>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="favicon.jpg" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <!----======== CSS ======== -->
    <link rel="stylesheet" href="admin.css"> 

    <!-- <link rel="stylesheet" href="./style.css"> -->
     
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">


    <title>Dashboard</title> 
    
</head>
<body>
    <nav>
        <div class="logo-name">
            <div class="logo-image">
                <img src="LogoFE.jpeg" alt="logo here">
            </div>

            <span class="logo_name">Fleet EIP</span>
        </div>

        <div class="menu-items">
            <ul class="nav-links">
                <li><a href="rental_dashboard.php" title="Dashboard">
                <i class="bi bi-speedometer2"></i>
                    <span class="link-name">Dashboard</span>
                </a></li>
                <!-- <li><a href="complete_profile_new.php" title="Dashboard">
                <i class="bi bi-speedometer2"></i>
                    <span class="link-name">Complete Profile New</span>
                </a></li> -->
                <li><a href="complete_profile_new.php">
                <i class="fas fa-user-check"></i>
                    <span class="link-name"> Complete Profile</span>
                </a></li>

                <li><a href="viewfleet2.php">
                <i class="bi bi-truck-flatbed"></i>
                    <span class="link-name">Fleet Management</span>
                </a></li>

                <li><a href="logsheetdashboard.php">
                <i class="bi bi-file-earmark-text"></i>
                    <span class="link-name">Log Sheet</span>
                </a></li>


                <li><a href="auction.php">
                <i class="bi bi-cash-coin"></i>
                <span class="link-name">Auction</span>
                </a>
            </li>
            
                <li><a href="purchase.php">
                <i class="bi bi-file-earmark"></i>
                    <span class="link-name">Purchase Requisition</span>
                </a></li>
                <li><a href="view_req_rentalinner.php">
                <i class="fas fa-chart-line"></i>
                    <span class="link-name">Market Leads</span>
                </a></li>
                <li><a href="tets.php">
                <i class="fas fa-store"></i>
                    <span class="link-name">Market Place</span>
                </a></li> 

                <li><a href="view_operator.php">
                <i class="bi bi-lightning"></i>
                    <span class="link-name">Man Power</span>
                </a></li>
    
                <li><a href="livesearch.php">
                <i class="fas fa-address-book"></i>
                    <span class="link-name">Directory</span>
                </a></li>
                <!-- <li>
                <a href="rental_employee.php">
                <i class="fas fa-user-plus"></i>
                    <span class="link-name">Add Subusers</span>
                </a></li> -->
                                <li>
                <a href="calculator.php">
                <i class="fas fa-calculator"></i>
                <span class="link-name">Calculator</span>
                </a></li>

                <li><a href="news/">
                <i class="uil uil-globe"></i>
                    <span class="link-name"> News</span>
                </a></li>
            </ul> 

            <br>
            
            <ul class="logout-mode"> 

           

               
<!-- 
                <li class="mode">
                    <a href="#">
                        <i class="uil uil-moon"></i>
                    <span class="link-name">Dark Mode</span>
                </a> -->

                 <div class="mode-toggle">
                 <!--  <span class="switch"></span> -->
                </div> 
            </li>
            </ul>
        </div>
    </nav>

    <section class="dashboard">
        
        <div class="top compdetails">
            <i class="uil uil-bars sidebar-toggle"></i>
            <!-- <p>Food Donate</p> -->
            <p  class ="logo" >Welcome <?php echo ucwords($companyname001); ?> <br>  
            </b></p>
             <p class="user"><i class="uil uil-signout"></i><a href="logout.php">Logout</a>

             </p>
           
        </div>

        <div class="dash-content">
            <div class="overview">
                <div class="title">
                    <i class="uil uil-tachometer-fast-alt"></i>
                    <span class="text">Dashboard</span>
    <span id="dashboardalert" <?php if(count($callReminders) == 0) echo 'style="display: none;"' ?>>
        <?php echo count($callReminders); ?>
    </span>                    <!-- <span style="font-size: 10px; margin-left:850px; color:red;">Trial Expiry =<?php echo $expiry_date; ?></span> -->
                </div> 
                <div id="overlay" style="display: none;">
    <?php 
    // Get today's date in 'Y-m-d' format
    $today = (new DateTime())->format('Y-m-d'); 

    // Initialize a flag to check if any reminders are found
    $foundReminder = false;

    foreach ($callReminders as $reminder): 
        // Check if the reminder date matches today's date
        if ((new DateTime($reminder['reminderon']))->format('Y-m-d') === $today): 
            $foundReminder = true; // Set the flag if a match is found
    ?>
            <div class="callremindernoticontainer">
            <p><strong>Call Reminder:</strong> You set a call reminder for <?php echo (new DateTime($reminder['reminderon']))->format('jS M Y'); ?> to call client <mark><?php echo htmlspecialchars($reminder['clientName']); ?></mark>. Contact details are <mark><?php echo htmlspecialchars($reminder['contactPerson']) . ', ' . htmlspecialchars($reminder['contactEmail']) . ' , ' . htmlspecialchars($reminder['contactNumber']); ?></mark> which says: <?php echo htmlspecialchars($reminder['description']); ?> and is of <?php echo htmlspecialchars($reminder['priority']); ?> priority.</p>
            </div>
    <?php 
        endif; 
    endforeach; 
    ?>

    <?php if (!$foundReminder): ?>
        <div class="callremindernoticontainer">
            <p>No reminders for today.</p>
        </div>
    <?php endif; ?>

    <div class="closeall" onclick="window.location.href='delcallremindernoti.php'">
        <i class="fa-solid fa-xmark cross_symbol"></i>Clear All
    </div>
</div>
<main class="py-6 bg-white ">
    <div class="container-fluid cardscont">
        <!-- Card stats -->
        <div class="row g-6 mb-6">
            <div class="col-xl-3 col-sm-6 col-12">
                <div class="card shadow border-0 card-hover" id="dashboard-card">
                    <div class="card-body" onclick="open_added_fleet()">
                        <div class="row">
<div class="col">
<div>
    <span class="h6 font-semibold text-muted text-sm d-block mb-2">Fleet </span>
</div>
<div>
    <span class="h3 font-bold mb-0"><?php echo $total_count ?></span>
</div>
<div <?php if ($count_of_notification === '0') { echo 'style="display: none;"'; } ?>>
    <span class="h5 font-bold mb-0"><?php echo $count_of_notification ?> Alerts</span>
</div>
</div>
                        <div class="col-auto">
                                <div class="icon icon-shape bg-tertiary text-white text-lg rounded-circle">
                                    <i class="fas fa-truck"></i> 
                                </div>
                                    </div>
                                </div>
                               <!--  <div class="mt-2 mb-0 text-sm">
                                    <span class="badge badge-pill bg-soft-success text-success me-2">
                                        <i class="bi bi-arrow-up me-1"></i>37%
                                    </span>
                                    <span class="text-nowrap text-xs text-muted">Since last month</span>
                                </div> -->
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6 col-12">
                        <div class="card shadow border-0" id="dashboard-card">
                            <div class="card-body" onclick="open_added_operators()">
                                <div class="row">
                                <div class="col">
    <div>
        <span class="h6 font-semibold text-muted text-sm d-block mb-2">Fleet Managers</span>
    </div>
    <div>
        <span class="h3 font-bold mb-0"><?php echo $total_count_operator ?></span>
    </div>
    <div <?php if ($count_of_dl_notification === '0') { echo 'style="display: none;"'; } ?>>
    <span class="h5 font-bold mb-0"><?php echo $count_of_notification ?> Alerts</span>
</div>
</div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-primary text-white text-lg rounded-circle">
                                        <i class="bi bi-person-plus"></i> 
                                        </div>
                                    </div>
                                </div>
                              <!--   <div class="mt-2 mb-0 text-sm">
                                    <span class="badge badge-pill bg-soft-success text-success me-2">
                                        <i class="bi bi-arrow-up me-1"></i>80%
                                    </span>
                                    <span class="text-nowrap text-xs text-muted">Since last month</span>
                                </div> -->
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6 col-12" >
                        <div class="card shadow border-0" id="dashboard-card">
                            <div class="card-body" onclick="open_market_leads()" >
                                <div class="row">
                                    <div class="col">
                                        <span class="h6 font-semibold text-muted text-sm d-block mb-2">Requirement</span>
                                        <span class="h3 font-bold mb-0"><?php echo $total_new_leads ?></span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-info text-white text-lg rounded-circle">
                                        <i class="bi bi-file-earmark-plus"></i>
                                        </div>
                                    </div>
                                </div>
                              <!--   <div class="mt-2 mb-0 text-sm">
                                    <span class="badge badge-pill bg-soft-danger text-danger me-2">
                                        <i class="bi bi-arrow-down me-1"></i>-5%
                                    </span>
                                    <span class="text-nowrap text-xs text-muted">Since last month</span>
                                </div> -->
                            </div>
                        </div>
                    </div> 

                    

                    <div class="col-xl-3 col-sm-6 col-12">
                        <div class="card shadow border-0" id="dashboard-card">
                            <div class="card-body" onclick="generate_quotation()">
                                <div class="row">
                                    <div class="col">
                                        <span class="h6 font-semibold text-muted text-sm d-block mb-2">Quotation</span>
                                        <!-- <span class="h3 font-bold mb-0">4.100</span> -->
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-tertiary text-white text-lg rounded-circle">
                                        <i class="bi bi-file-earmark-text"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 

                    <div class="col-xl-3 col-sm-6 col-12">
                        <div class="card shadow border-0" id="dashboard-card">
                            <div class="card-body" onclick="window.location.href='rentalclient.php'">
                                <div class="row">
                                    <div class="col">
                                        <span class="h6 font-semibold text-muted text-sm d-block mb-2">Add Client</span>
                                      <!--   <span class="h3 font-bold mb-0">4.100</span> -->
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-primary text-white text-lg rounded-circle">
                                        <i class="bi bi-person-plus"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                    
                    <div class="col-xl-3 col-sm-6 col-12">
                        <div class="card shadow border-0" id="dashboard-card">
                            <div class="card-body" onclick="job_corner()">
                                <div class="row">
                                    <div class="col">
                                        <span class="h6 font-semibold text-muted text-sm d-block mb-2">Job Corner</span>
                                      <!--   <span class="h3 font-bold mb-0">4.100</span> -->
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-info text-white text-lg rounded-circle">
                                        <i class="bi bi-briefcase"></i>
                                        </div>
                                    </div>
                                </div>
                              <!--   <div class="mt-2 mb-0 text-sm">
                                    <span class="badge badge-pill bg-soft-danger text-danger me-2">
                                        <i class="bi bi-arrow-down me-1"></i>-5%
                                    </span>
                                    <span class="text-nowrap text-xs text-muted">Since last month</span>
                                </div> -->
                            </div>
                        </div>
                    </div> 
                    <div class="col-xl-3 col-sm-6 col-12">
                        <div class="card shadow border-0" id="dashboard-card">
                            <div class="card-body" onclick="window.location.href='todolist.php'">
                                <div class="row">
                                    <div class="col">
                                        <span class="h6 font-semibold text-muted text-sm d-block mb-2">To-Do</span>
                                      <!--   <span class="h3 font-bold mb-0">4.100</span> -->
                                      <div <?php if ($todonoticount === '0') { echo 'style="display: none;"'; } ?>>
                                    <h6 class="h5 font-bold mb-0"><?php echo $todonoticount ?> Alert</h6>
                                    </div>

                                    </div>

                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-tertiary text-white text-lg rounded-circle">
                                        <i class="bi bi-calendar-check"></i>
                                        </div>
                                        
                                    </div>

                                </div>
                              <!--   <div class="mt-2 mb-0 text-sm">
                                    <span class="badge badge-pill bg-soft-danger text-danger me-2">
                                        <i class="bi bi-arrow-down me-1"></i>-5%
                                    </span>
                                    <span class="text-nowrap text-xs text-muted">Since last month</span>
                                </div> -->
                            </div>
                        </div>
                        
                    </div>  

                                <div class="col-xl-3 col-sm-6 col-12">
                        <div class="card shadow border-0" id="dashboard-card">
                            <div class="card-body" onclick="window.location.href='vendorsFleet.php'">
                                <div class="row">
                                    <div class="col">
                                        <span class="h6 font-semibold text-muted text-sm d-block mb-2">Add Vendor</span>
                                      <!--   <span class="h3 font-bold mb-0">4.100</span> -->
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-primary text-white text-lg rounded-circle">
                                        <i class="bi bi-person-vcard"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>  

                                                   <div class="col-xl-3 col-sm-6 col-12">
                        <div class="card shadow border-0" id="dashboard-card">
                            <div class="card-body" onclick="window.location.href='vendorPOView.php'">
                                <div class="row">
                                    <div class="col">
                                        <span class="h6 font-semibold text-muted text-sm d-block mb-2">Add PO</span>
                                      <!--   <span class="h3 font-bold mb-0">4.100</span> -->
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-info text-white text-lg rounded-circle">
                                        <i class="bi bi-receipt-cutoff"></i>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 

                    <div class="col-xl-3 col-sm-6 col-12">
                        <div class="card shadow border-0" id="dashboard-card">
                            <div class="card-body" onclick="window.location.href='expenselog.php'">
                                <div class="row">
                                    <div class="col">
                                        <span class="h6 font-semibold text-muted text-sm d-block mb-2">Expense Log</span>
                                      <!--   <span class="h3 font-bold mb-0">4.100</span> -->
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-primary text-white text-lg rounded-circle">
                                        <i class="bi bi-cash"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 


                    <div class="col-xl-3 col-sm-6 col-12">
                        <div class="card shadow border-0" id="dashboard-card">
                            <div class="card-body" onclick="window.location.href='hrcorner.php'">
                                <div class="row">
                                    <div class="col">
                                        <span class="h6 font-semibold text-muted text-sm d-block mb-2">HR Corner</span>
                                      <!--   <span class="h3 font-bold mb-0">4.100</span> -->
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-tertiary text-white text-lg rounded-circle">
                                        <i class="bi bi-person-badge"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 



                </div>
                <div class="fulllengthright"><p class="assistancepara" id="assistanceparaid" onclick="window.location.href='financeassistance.php'"><i class="bi bi-cash icon"></i>Financial Assistance</p></div>

                <br>
                

            </div> 
            </main>

        

    </section>

            <br> 
            <!-- <div class="fulllengthright"><p class="user">Add Task</p></div>
            <table class="to_do_content">
            <th>Date</th>
            <th>Task</th>
            <th>Assigned To</th>
            <th>Status</th>
            <th>Listed By</th>
            <th>Action</th>
            </table>
            <br> -->


    <script src="admin.js"></script>
    <script>
        function open_market_leads(){
    window.location.href="view_req_rentalinner.php";
}
function open_added_fleet() {
    window.location.href = "viewfleet2.php";
}
function open_added_operators(){
    window.location.href="view_operator.php";
}
function generate_quotation(){
    window.location.href="generate_quotation_landingpage.php";
}
function generate_bill(){
    window.location.href="generate_invoice.php";
}
function job_corner(){
    window.location.href="joblandingpage.php";
}
document.getElementById('dashboardalert').addEventListener('click', function() {
    var overlay = document.getElementById('overlay');
    overlay.style.display = 'flex'; // Show the overlay
});

// Optionally, add an event listener to close the overlay when clicked
overlay.addEventListener('click', function() {
    overlay.style.display = 'none'; // Hide the overlay
});


    </script>
</body>
</html>
