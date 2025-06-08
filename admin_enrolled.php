<?php 
$showError=false;
$showAlert=false;
include "partials/_dbconnect.php";
$sql = "SELECT * FROM `login` order by time desc";
$result = mysqli_query($conn, $sql);

// Initialize an array to store data grouped by enterprise
$enterprise_groups = [];

// Fetch rows and group them by enterprise
while($row = mysqli_fetch_assoc($result)) {
    $enterprise = $row['enterprise'];
    if (!isset($enterprise_groups[$enterprise])) {
        $enterprise_groups[$enterprise] = [];
    }
    $enterprise_groups[$enterprise][] = $row;
}
?>
<?php
session_start();
$email = $_SESSION['email'];
// $companyname001 = $_SESSION['companyname'];
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
elseif ($enterprise === 'admin') {
    $dashboard_url = 'news/admin/dashboard.php';
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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="favicon.jpg" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
    <style>
        .quotation-table {
            width: 90%;
            margin: 20px auto; /* Centers the table horizontally and adds top margin */
            font-size: 13px;
            border-collapse: collapse;
            padding: 10px;
            text-align: center;
        }

        .quotation-table, .quotation-table th, .quotation-table td {
            border: 1px solid black;
        }

        .quotation-table th, .quotation-table td {
            padding: 8px;
            text-align: left;
        }

        .quotation-table th {
            background-color: #1C549E;
            color: white;
        }

        .quotation-table .table-heading { 
            background-color: #4067B5; 
            color: white;
        }
    </style>
    <title>Enrolled</title>
</head>
<body>
<div class="navbar1">
    <div class="logo_fleet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <img src="logo_fe.png" alt="FLEET EIP" onclick="window.location.href='<?php echo $dashboard_url  ?>'">
</div>

        <div class="iconcontainer">
        <ul>
      <li><a href="<?php echo $dashboard_url ?>">Dashboard</a></li>
            <!-- <li><a href="news/">News</a></li> -->
    
        <li><a href="logout.php">Log Out</a></li></ul>
        </div>
    </div> 
    <?php
if ($showAlert) {
    echo '<label>
    <input type="checkbox" class="alertCheckbox" autocomplete="off" />
    <div class="alert notice">
        <span class="alertClose">X</span>
        <span class="alertText"> Edit Success<br class="clear"/></span>
    </div>
    </label>';
}
if ($showError) {
    echo '<label>
    <input type="checkbox" class="alertCheckbox" autocomplete="off" />
    <div class="alert error">
        <span class="alertClose">X</span>
        <span class="alertText">Something Went Wrong<br class="clear"/></span>
    </div>
    </label>';
}
?>

<div class="countcontainer">
<table class="quotation-table" id="countofclient">
    <thead>
        <th>Count</th>
    </thead>
    <tbody>
        <tr>
            <?php 
            include "partials/_dbconnect.php"; // Ensure your DB connection is included

            // SQL query to count the number of entries for each enterprise type
            $sqlcount = "SELECT enterprise, COUNT(*) as count FROM login GROUP BY enterprise";
            $resultcount = mysqli_query($conn, $sqlcount);

            // Initialize a variable to hold the total counts
            $total_count = [];

            // Check if query was successful
            if ($resultcount) {
                while ($rowcount = mysqli_fetch_assoc($resultcount)) {
                    $enterprise = htmlspecialchars($rowcount['enterprise']);
                    $count = htmlspecialchars($rowcount['count']);
                    
                    // Append to the total_count array
                    $total_count[] = "$enterprise: $count";
                }
                
                // Join the counts into a single string for display
                $total_display = implode(' - ', $total_count);
                
                // Display the concatenated result in a single row
                echo '<td colspan="2" style="font-size: 16px;">' . $total_display . '</td>';
            } else {
                // Handle query error
                echo '<td colspan="2">Query Error: ' . mysqli_error($conn) . '</td>';
            }
            ?>
        </tr>
    </tbody>
</table>
</div>

    <?php foreach ($enterprise_groups as $enterprise => $rows) { ?>
        <h2 class="enterpriseheading"><?php echo htmlspecialchars($enterprise); ?></h2>
        <table class="quotation-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Email</th>
                    <th>Companyname</th>
                    <th>Website?</th>
                    <th>Website Address</th>
                    <th>Enterprise</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rows as $row) { ?>
                    <tr>
                    <td><?php echo (new DateTime($row['time']))->format('jS M y'); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><a href="companydetails.php?name='<?php echo htmlspecialchars($row['companyname']); ?>'"><?php echo htmlspecialchars($row['companyname']); ?></a></td>
                        <td><?php echo htmlspecialchars($row['comp_web']); ?></td>
                        <td><?php echo htmlspecialchars($row['webiste_address']); ?></td>
                        <td><?php echo htmlspecialchars($row['enterprise']); ?></td>
                        <td><?php echo htmlspecialchars($row['status']); ?></td>
                        <td data-label="Actions">
            <a href="admineditlogin.php?id=<?php echo $row['sno']; ?>" class="quotation-icon" title="Edit">
                <i style="width: 22px; height: 22px;" class="bi bi-pencil"></i>
            </a>
            <a href="admindeluser.php?del_id=<?php echo $row['sno']; ?>" class="quotation-icon" title="Delete">
                <i style="width: 22px; height: 22px;" class="bi bi-trash"></i>
            </a>
        </td>

                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } ?>
</body>
</html>
