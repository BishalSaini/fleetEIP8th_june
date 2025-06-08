<?php 
// session_start();
$showAlert=false;
$showError=false;

$companyname001 = $_SESSION['companyname'];
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

include "partials/_dbconnect.php";
$sql = "SELECT * FROM `fleeteip_clientlist` where added_by='$companyname001'";
$result = mysqli_query($conn, $sql);

// Create an associative array to group clients by state
$clients_by_state = [];

while ($row = mysqli_fetch_assoc($result)) {
    $state = $row['state'];
    if (!isset($clients_by_state[$state])) {
        $clients_by_state[$state] = [];
    }
    $clients_by_state[$state][] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="shortcut icon" href="favicon.jpg" type="image/x-icon">
    <title>View Client</title>
    <style>
        .purchase_table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .purchase_table th, .purchase_table td {
            padding: 8px;
        }
        .purchase_table th {
            background-color: #f2f2f2;
        }
        .custom-card {
            border: 1px solid #ddd;
            padding: 10px;
            margin: 10px 0;
            text-align: center;
        }
        .custom-card__title {
            font-size: 1.2em;
            margin: 0;
        }
        .custom-card__arrow i {
            font-size: 1.2em;
        }
    </style>
</head>
<body>
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


<?php
if (count($clients_by_state) > 0) { ?>
    <h2 class="fulllength">Fleet EIP Client List</h2>
    <?php
    foreach ($clients_by_state as $state => $clients) {
        echo '<h2 class="statesegregation">' . htmlspecialchars($state) . '</h2>'; // Print the state name

        echo '<table class="purchase_table" id="job_posting">';
        echo '<tr>'; // Start the first row

        $loop_count = 0; // Initialize the counter

        foreach ($clients as $row) {
            $id = $row['id'];

            if ($loop_count > 0 && $loop_count % 4 == 0) {
                echo '</tr><tr>'; // Close the current row and start a new one
            }

            // Table cell
            echo '<td>
            <a href="editadminclient.php?id=' . urlencode($id) . '" class="custom-card-link">
                <div class="custom-card" id="requirement_club">
                    <h3 class="custom-card__title">' . htmlspecialchars($row['name']) . '</h3>
                    <p class="insidedetails">State: ' . htmlspecialchars($row['state']) . '</p>
                    
                    <!-- Corrected Delete Button -->
                    <a onclick="return deleteconfirmation();" href="deleteadminclient.php?id=' . urlencode($row['id']) . '">
                        <button title="Delete Client" class="transportbuttoncn" type="button">
                            <i class="fas fa-trash"></i> 
                        </button>
                    </a>
    
                    <div class="custom-card__arrow">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </div>
            </a>
        </td>';
    
            $loop_count++;
        }

        echo '</tr>'; // Close the last row
        echo '</table>';
    }
} else {
    echo '<p class="norecord">Added Clients Will Be Displayed Here </p>';
}
?>

</body>
<script>
function deleteconfirmation() {
    return confirm("Are you sure you want to delete?");
}
</script>
</html>
