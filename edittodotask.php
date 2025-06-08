<?php
session_start();
include "partials/_dbconnect.php";

// Fetch session variables
$companyname001 = $_SESSION['companyname'] ?? '';
$enterprise = $_SESSION['enterprise'] ?? '';
$email = $_SESSION['email'];

// Determine dashboard URL
$dashboard_url = match($enterprise) {
    'rental' => 'rental_dashboard.php',
    'logistics' => 'logisticsdashboard.php',
    'epc' => 'epc_dashboard.php',
    default => ''
};

$id = $_GET['id'] ?? null;

// Fetch task details
$sql = "SELECT * FROM `to_do` WHERE `id` = $id AND `companyname` = '$companyname001'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $todotask = $_POST['todotask'];
    $assignee = $_POST['assignee'];
    $tasktype = $_POST['tasktype'];
    $clientname = $_POST['clientname'] ?? '';

    // Fetch the assigned email
    $nameofassigned = "SELECT email FROM `team_members` WHERE name='$assignee' AND company_name='$companyname001'";
    $resultassigned = mysqli_query($conn, $nameofassigned);
    $row1 = mysqli_fetch_assoc($resultassigned);

    if ($row1) {
        $assigned_to_email = $row1['email'];

        // Update the task
        $updateTask = "UPDATE `to_do` 
                        SET `task_type` = '$tasktype', 
                            `clientname` = '$clientname', 
                            `task` = '$todotask', 
                            `assinged_to` = '$assignee', 
                            `assigned_to_email` = '$assigned_to_email' 
                        WHERE `id` = $id AND `companyname` = '$companyname001'";

        if (mysqli_query($conn, $updateTask)) {
            session_start();
            $_SESSION['success'] = 'success';
            header("Location: todolist.php");
} else {
    session_start();
    $_SESSION['error'] = 'success';
    header("Location: todolist.php");
}
    } else {
        echo 'Assignee not found.';
    }
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
<form action="edittodotask.php?id=<?php echo $id; ?>" method="post" class="addtodotask">
    <div class="todocontainer">
        <p class="headingpara">Edit Task</p>
        <div class="trial1">
            <select name="tasktype" id="tasktypeddedit" onchange="showclientedit()" class="input02" required>
                <option value="" disabled selected>Select Task Type</option>
                <option value="Call" <?php if ($row['task_type'] === 'Call') echo 'selected'; ?>>Task Type: Call A Client</option>
                <option value="General" <?php if ($row['task_type'] === 'General') echo 'selected'; ?>>Task Type: General Task</option>
            </select>
        </div>
        <div class="trial1" id="selectclientedit" style="display: <?php echo $row['task_type'] === 'Call' ? 'block' : 'none'; ?>">
            <select name="clientname" class="input02" >
                <option value="" disabled selected>Select Client</option>
                <?php
                $myclient = "SELECT * FROM `rentalclient_basicdetail` WHERE companyname='$companyname001' ORDER BY clientname ASC";
                $resultclient = mysqli_query($conn, $myclient);
                while ($rowclient = mysqli_fetch_assoc($resultclient)) {
                    echo "<option value=\"{$rowclient['clientname']}\" " . ($row['clientname'] === $rowclient['clientname'] ? 'selected' : '') . ">Client Name: {$rowclient['clientname']}</option>";
                }
                ?>
            </select>
        </div>
        <div class="trial1">
            <textarea name="todotask" id="todotask" class="input02" required><?php echo $row['task']; ?></textarea>
            <label for="todotask" class="placeholder2">Task</label>
        </div>
        <div class="trial1">
            <p class="task_para"><a href="complete_profile_new.php">Employee Name Not In List? Add Team Member here</a></p>
            <?php
            $sqlemployee = "SELECT * FROM `team_members` WHERE company_name='$companyname001'";
            $resultemployee = mysqli_query($conn, $sqlemployee);
            ?>
            <select name="assignee" id="assignee" class="input02" required>
                <option value="" disabled selected>Assign Task To?</option>
                <?php while ($roww = mysqli_fetch_assoc($resultemployee)) { ?>
                    <option value="<?php echo $roww['name']; ?>" <?php if ($row['assinged_to'] === $roww['name']) echo 'selected'; ?>>Task Assigned To: <?php echo $roww['name']; ?></option>
                <?php } ?>
            </select>
        </div>
        <button class="epc-button">Update Task</button>
    </div>
</form>

<script>
function showclientedit() {
    const tasktypeddedit = document.getElementById("tasktypeddedit");
    const selectclientedit = document.getElementById("selectclientedit");

    console.log("Selected Task Type:", tasktypeddedit.value);

    selectclientedit.style.display = (tasktypeddedit.value === 'Call') ? 'block' : 'none';

    if (tasktypeddedit.value === 'General') {
        const clientSelect = selectclientedit.querySelector('select');
        clientSelect.value = ''; // Reset the value of the <select> inside the <div>
    }
}
</script>
</body>
</html>
