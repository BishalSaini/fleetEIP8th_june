<?php
session_start();

include "partials/_dbconnect.php";
// Initialize variables
$showAlert = false;
$showError = false;

// Fetch session variables
$companyname001 = $_SESSION['companyname'] ?? '';
$enterprise = $_SESSION['enterprise'] ?? '';
$email = $_SESSION['email'];
// Determine dashboard URL based on enterprise
$dashboard_url = '';
if ($enterprise === 'rental') {
    $dashboard_url = 'rental_dashboard.php';
} elseif ($enterprise === 'logistics') {
    $dashboard_url = 'logisticsdashboard.php';
} elseif ($enterprise === 'epc') {
    $dashboard_url = 'epc_dashboard.php';
}

$sql="SELECT * FROM `to_do` where assigned_to_email='$email' and status='Completed' and companyname='$companyname001'";
$result=mysqli_query($conn,$sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <link rel="shortcut icon" href="favicon.jpg" type="image/x-icon">
    <title>Completed Task</title>
</head>
<body>
<div class="navbar1">
        <div class="logo_fleet">
            <img src="logo_fe.png" alt="FLEET EIP" onclick="window.location.href='<?php echo $dashboard_url; ?>'">
        </div>
        <div class="iconcontainer">
            <ul>
                <li><a href="<?php echo $dashboard_url; ?>">Dashboard</a></li>
                <li><a href="news/">News</a></li>
                <li><a href="logout.php">Log Out</a></li>

            </ul>
        </div>
    </div>
<?php
if(mysqli_num_rows($result)>0){ ?>
    <table class="todotable" id="viewcompletedtasktable">
    <tr>
                <th>Date</th>
                <th>Task</th>
                <th>Type</th>
                <!-- <th>Current Status</th> -->
                <th>Created By</th>
                <th>Action</th>
            </tr>
            <?php
            while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                    <td><?php echo date("jS M y", strtotime($row['date'])); ?></td>
                    <td><?php echo $row['task']; ?></td>
                    <td><?php echo $row['task_type'] . (!empty($row['clientname']) ? '-' . $row['clientname'] : ''); ?></td>
                    <!-- <td><?php echo $row['status']; ?></td> -->
                        <td class="todatacont"><?php echo $row['listed_by']; ?></td>
                        <td data-label="Actions">
            <a  style="<?php echo ($row['status'] != 'Open') ? 'display:none;' : ''; ?>"  href="taskcompleted.php?id=<?php echo $row['id']; ?>" class="quotation-icon" title="Task Completed">
            <i style="width: 22px; height: 22px;" class="bi bi-check-circle"></i>
            </a>
            <a 
    style="<?php echo ($row['listed_by'] != $email) ? 'display:none;' : ''; ?>" 
    href="deletetodotask.php?id=<?php echo $row['id']; ?>" 
    class="quotation-icon" 
    title="Delete">
               <i style="width: 22px; height: 22px;" class="bi bi-trash"></i>
            </a>
        </td>
                    </tr>
                <?php }
            } else{ ?>
            <tr>
            <td colspan="6"><div class="fulllength">No Data Found</div></td>
            </tr>

    </table>
<?php
}
?>
</body>
</html>