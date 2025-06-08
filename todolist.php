<?php
include_once 'partials/_dbconnect.php'; // Include the database connection file
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

session_start();

include "partials/_dbconnect.php";
// Initialize variables
$showAlert = false;
$showError = false;

// Fetch session variables
$companyname001 = $_SESSION['companyname'];
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
if(isset($_SESSION['success'])){
    $showAlert=true;
    unset($_SESSION['success']);
}
else if(isset($_SESSION['error'])){
    $showError=true;
    unset($_SESSION['error']);
}

if(($_SERVER['REQUEST_METHOD'] === 'POST') && isset($_POST['submitcallreminder'])){
    include "partials/_dbconnect.php";

    $reminderon=$_POST['reminderon'];
    $description=$_POST['description'];
    $priority=$_POST['priority'];
    $clientName = !empty($_POST['newrentalclient']) ? $_POST['newrentalclient'] : $_POST['to'];
    $contactPerson= !empty($_POST['newrentalcontactperson']) ? $_POST['newrentalcontactperson'] : $_POST['contact_person'];
    $contactNumber=$_POST['contact_number'];
    $contactEmail = $_POST['email_id'];

    $call="INSERT INTO call_reminders (`clientName`, `contactPerson`, `contactNumber`, `contactEmail`,`added_by`,reminderon, description, priority, companyname)
VALUES ('$clientName','$contactPerson','$contactNumber','$contactEmail','$email','$reminderon', '$description', '$priority', '$companyname001')";
    $callresult=mysqli_query($conn,$call);
    if($callresult){
        $showAlert=true;
    }
    else{
        $showError=true;
    }




}


if (($_SERVER['REQUEST_METHOD'] === 'POST') && isset($_POST['addtaskbutton'])) {
    include "partials/_dbconnect.php";
    $todotask = $_POST['todotask'];
    $assignee = $_POST['assignee'];
    $tasktype = $_POST['tasktype'];
    // $clientname = $_POST['clientname'] ?? '';
    $assignedtoemail = $_POST['assignedtoemail'];
    $prioritytodo=$_POST['prioritytodo'];
    $clientname = !empty($_POST['newrentalclient']) ? $_POST['newrentalclient'] : $_POST['to'];

    $clientNameClass = empty($clientname) ? 'hideit' : '';
    $contactPerson= !empty($_POST['newrentalcontactperson']) ? $_POST['newrentalcontactperson'] : $_POST['contact_person'];
    $contactNumber=$_POST['contact_number'];
    $contactEmail = $_POST['email_id'];


    $nameofassigned = "SELECT email FROM `team_members` WHERE name='$assignee' AND company_name='$companyname001'";
    $resultassigned = mysqli_query($conn, $nameofassigned);
    $row1 = mysqli_fetch_assoc($resultassigned);

    if ($row1) {
        $assigned_to_email = $row1['email'];
        $randomUniqueNumber = rand(100000, 999999);

        // Insert the task
        $task = "INSERT INTO `to_do` (`clientname`, `contactPerson`, `contactNumber`, `contactEmail`,`priority`,`task_type`,`date`, `task`, `listed_by`, `assinged_to`, `status`, `companyname`, `assigned_to_email`, `uniqueid`) VALUES 
        ('$clientname','$contactPerson','$contactNumber','$contactEmail','$prioritytodo','$tasktype',NOW(), '$todotask', '$email', '$assignee', 'Open', '$companyname001', '$assigned_to_email','$randomUniqueNumber')";
        $resulttask = mysqli_query($conn, $task);

        // // Insert notification
        // $tasknoti = "INSERT INTO `todo_noti`(`date`, `task`, `listed_by`, `assinged_to`, `status`, `companyname`, `assigned_to_email`, `uniqueid`) VALUES (NOW(),'$todotask','$email','$assignee','Open','$companyname001','$assigned_to_email','$randomUniqueNumber')";
        // $resultnoti = mysqli_query($conn, $tasknoti);

        if ($resulttask) {
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host       = 'smtp.hostinger.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'support@fleeteip.com';
            $mail->Password   = 'fleetEIP@0807';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;
        
            // Email to the user for verification
            $mail->setFrom('support@fleeteip.com', 'FleetEIP');
            $mail->addAddress($assigned_to_email);
        
            $mail->isHTML(true);
            $mail->Subject = 'Task Assigned Notification';
            $mail->Body = "
            <html>
            <head>
            <style>
            body {font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; line-height: 1.6; background-color: #f9f9f9; margin: 0; padding: 0;}
            .container {
                width: 100%;
                max-width: 600px;
                margin: 20px auto;
                background-color: #ffffff;
                border-radius: 8px;
                box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
            }
            .header {background-color: #253C6A; color: white; padding: 15px; text-align: center; font-size: 24px;}
            .content p {font-size: 16px; color: #333;}
            .footer {text-align: center; font-size: 12px; color: #888; margin-top: 20px;}
            .task-details {
                margin-top: 20px;
                padding: 10px;
                border: 1px solid #ddd;
                border-radius: 5px;
            }
            .hideit{
                display: none;
            }
            .task-details div {
                margin-bottom: 10px;
            }
            </style>
            </head>
            <body>
            <div class='container'>
                <div class='header'>Task Assigned</div>
                <div class='content'>
                    <p>Dear $assignee,</p>
                    <p>You have been assigned a new task. Here are the details:</p>
                    <div class='task-details'>
                        <div><strong>Task:</strong> $todotask</div>
                        <div><strong>Priority:</strong> $prioritytodo</div>
                        <div><strong>Type:</strong> $tasktype</div>
<div class='$clientNameClass'>
    <strong>Client Name:</strong> $clientname <br>
    <strong>Contact Person:</strong> $contactPerson <br>
    <strong>Number:</strong> $contactNumber <br>
    <strong>Contact Email:</strong> $contactEmail
</div>                        <div><strong>Assigned By:</strong> $email</div>
                        <div><strong>Status:</strong> Open</div>
                    </div>
                    <p>Thank you,<br> FleetEIP Team</p>
                </div>
                <div class='footer'>
                    <p>&copy; 2024 FleetEIP. All rights reserved.</p>
                </div>
            </div>
            </body>
            </html>";
        
            $mail->send();
            $showAlert = true;
        } else {
            $showError = true;
        }
    }}$mytask = "SELECT * FROM `to_do` WHERE (assigned_to_email='$email' AND companyname='$companyname001' AND status != 'Completed') || (listed_by='$email' and companyname='$companyname001')";
$resulttask = mysqli_query($conn, $mytask);

$todonoti="SELECT * , COUNT(id) AS todonoticount FROM `todo_noti` where assigned_to_email='$email' and companyname='$companyname001' ";
$resulttodonoti=mysqli_query($conn,$todonoti);
$rowtodonoti=mysqli_fetch_assoc($resulttodonoti);
$todonoticount=$rowtodonoti['todonoticount'];

$viewnoti="SELECT *  FROM `todo_noti` where (assigned_to_email='$email' and companyname='$companyname001') || (listed_by='$email' and companyname='$companyname001') ";
$viewnotiresult=mysqli_query($conn,$viewnoti);

$sql_client = "SELECT DISTINCT clientname FROM rentalclients WHERE `companyname` = '$companyname001' order by clientname asc";
$result_client=mysqli_query($conn,$sql_client);

$sql_client1 = "SELECT DISTINCT clientname FROM rentalclients WHERE `companyname` = '$companyname001' order by clientname asc";
$result_client1=mysqli_query($conn,$sql_client1);



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script src="main.js"defer></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="todoautofill.js" defer></script>
    <script src="getclient_quotation.js"defer></script>
    <script src="contactpersondetails.js"defer></script>
    <script src="contactpersondetails1.js"defer></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="shortcut icon" href="favicon.jpg" type="image/x-icon">
    <title>To-Do</title>
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
                <li <?php if($todonoticount == '0') echo 'style="display: none;"' ?>><div class="alerts" onclick="todonotiview()" ><?php echo $todonoticount ?> Alerts</div></li>

            </ul>
        </div>
    </div>

    <?php
    if ($showAlert) {
        echo '<label>
        <input type="checkbox" class="alertCheckbox" autocomplete="off" />
        <div class="alert notice">
            <span class="alertClose">X</span>
            <span class="alertText">Success<br class="clear"/></span>
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

<form action="todolist.php" method="post" id="addtaskform_todo" autocomplete="off" class="addtodotask">
    <div class="todocontainer">
        <p class="headingpara">Add Task</p>
        <div class="trial1">
            <select name="tasktype" id="tasktypedd" onchange="showclient()" class="input02">
                <option value="" disabled selected>Select Task Type</option>
                <option value="Call">Call A Client</option>
                <option value="General">General Task</option>
            </select>
        </div>

        <div class="trial1" style="width: 100%;" id="selectclient">
            <div class="trial1" id="newrentalclient" style="width: 80%;">
                <input type="text" placeholder="" name="newrentalclient" class="input02">
                <label for="" class="placeholder2">New Client</label>
            </div>
            <div class="trial1" id="companySelectouter_todo">
                <input type="text" id="clientSearch_todo" class="input02" placeholder="Select Client" onkeyup="filterClients_todo()" onclick="showDropdown_todo()" autocomplete="off">
                <select id="companySelect_todo" name="to" class="input02" onchange="updateContactPerson_todo(); newclient_todo();" style="display: none;">
                    <option value="" disabled selected>Select Client</option>
                    <option value="New Client" id="newClientOption">New Client</option>
                    <?php
                    if (mysqli_num_rows($result_client1) > 0) {
                        while ($row_client1 = mysqli_fetch_assoc($result_client1)) {
                            echo '<option value="' . $row_client1['clientname'] . '">' . $row_client1['clientname'] . '</option>';
                        }
                    }
                    ?>
                </select>
                <div id="suggestions_todo" class="suggestions"></div>
            </div>

            <div class="trial1" id="contactSelectouter_todo">
                <select id="contactSelect_todo" class="input02" name="contact_person" onchange="newcontactpersonfunction_todo()">
                    <option value="" disabled selected>Select Contact Person</option>
                    <option value="New Contact Person">New Contact Person</option>
                </select>
            </div>

            <div class="trial1" id="newrentalcontactperson" style="width: 80% !important;">
                <input type="text" placeholder="" name="newrentalcontactperson" class="input02">
                <label for="" class="placeholder2">Contact Person</label>
            </div>
            <div class="outer02">
                <div class="trial1" id="contact_number1">
                    <input type="text" placeholder="" id="clientcontactnumber1" name="contact_number" class="input02" required>
                    <label for="" class="placeholder2">Contact Number</label>
                </div>
                
                <div class="trial1">
                    <input type="text" placeholder="" id="clientcontactemail1" name="email_id" class="input02" required>
                    <label for="" class="placeholder2">Email Id</label>
                </div>
            </div>
        </div>
        
        <div class="trial1">
            <select name="prioritytodo" placeholder="" class="input02" required>
                <option value="" disabled selected>Select Task Priority</option>
                <option value="High">High</option>
                <option value="Medium">Medium</option>
                <option value="Low">Low</option>
            </select>
            <label for="" class="placeholder2">Priority</label>
        </div>

        <div class="trial1">
            <textarea name="todotask" placeholder="" id="todotask" class="input02" required></textarea>
            <label for="todotask" class="placeholder2">Task</label>
        </div>
        <input type="hidden" id="logistics_need_rental" value="<?php echo $companyname001; ?>">
        <div class="trial1">
            <p class="task_para"><a href="complete_profile_new.php">Employee Name Not In List? Add Team Member here</a></p>
            <?php 
            include "partials/_dbconnect.php";
            $sqlemployee = "SELECT * FROM `team_members` WHERE company_name='$companyname001'";
            $resultemployee = mysqli_query($conn, $sqlemployee);
            ?>
            <select name="assignee" id="assigntasktoname" class="input02" required>
                <option value="" disabled selected>Assign Task To?</option>
                <?php while ($roww = mysqli_fetch_assoc($resultemployee)) { ?>
                    <option value="<?php echo $roww['name']; ?>"><?php echo $roww['name']; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="trial1">
            <input type="text" placeholder="" id="todoemail" name="assignedtoemail" class="input02">
            <label for="" class="placeholder2">Email</label>
        </div>
        <button class="epc-button" name="addtaskbutton">Add Task</button>
    </div>
</form>

<br>
<form action="todolist.php" id="callreminderformrental" method="POST" autocomplete="off" class="callreminderform">
    <div class="callreminderinner">
        <p class="headingpara">Call Reminder</p>
        <input type="text" id="comp_name_trial" value="<?php echo $companyname001 ?>" hidden>
        
        <div class="trial1">
            <input type="date" placeholder="" name="reminderon" class="input02" required>
            <label for="reminderon" class="placeholder2">Remind Me On</label>
        </div>
        <div class="trial1" id="newrentalclient" style="width: 80%;">
            <input type="text" placeholder="" name="newrentalclient" class="input02">
            <label for="" class="placeholder2">New Client</label>
        </div>
        <div class="trial1" id="companySelectouter">
    <input type="text" id="clientSearch" class="input02" placeholder="Select Client" onkeyup="filterClients()" onclick="showDropdown()" autocomplete="off">
    <select id="companySelect" name="to" class="input02" onchange="updateContactPerson(); newclient();" style="display: none;">
        <option value="" disabled selected>Select Client</option>
        <option value="New Client" id="newClientOption">New Client</option>
        <?php
        if (mysqli_num_rows($result_client) > 0) {
            while ($row_client = mysqli_fetch_assoc($result_client)) {
                echo '<option value="' . $row_client['clientname'] . '">' . $row_client['clientname'] . '</option>';
            }
        }
        ?>
    </select>
    <div id="suggestions" class="suggestions"></div>

</div>
        <!-- <div class="trial1" id="salute_dd">
            <select name="salutation_dd"  class="input02" required>
                <option value="Mr">Mr</option>
                <option value="Ms">Ms</option>
            </select>
        </div> -->
        <div class="trial1" id="contactSelectouter">
        <!-- <input type="text" placeholder="" name="contact_person" class="input02" required>
        <label for="" class="placeholder2">Contact Person</label> -->
        <select id="contactSelect" class="input02" name="contact_person" onchange="newcontactpersonfunction()">
            <option value=""disabled selected>Select Contact Person</option>
            <option value="New Contact Person">New Contact Person</option>

    </select>
        
        </div>

        <div class="trial1" id="newrentalcontactperson" style="width: 80% !important;">
        <input type="text" placeholder="" name="newrentalcontactperson" class="input02" >
            <label for="" class="placeholder2">Contact Person</label>
        </div>
        <div class="outer02">
        <div class="trial1" id="contact_number1">
        <input type="text" placeholder="" id="clientcontactnumber" name="contact_number" class="input02" required>
        <label for="" class="placeholder2">Contact Number</label>
        </div>
        
        <div class="trial1 ">
        <input type="text" placeholder="" id="clientcontactemail" name="email_id" class="input02" required>
        <label for="" class="placeholder2">Email Id</label>
        </div>

        </div>

                <div class="trial1">
            <textarea name="description" placeholder="" class="input02" rows="4" required></textarea>
            <label for="description" class="placeholder2">Description</label>
        </div>

        <div class="trial1">
            <select name="priority" placeholder="" class="input02" required>
                <option value="" disabled selected>Select Priority</option>
                <option value="high">High</option>
                <option value="medium">Medium</option>
                <option value="low">Low</option>
            </select>
            <label for="priority" class="placeholder2">Priority</label>
        </div>

        <button type="submit" name="submitcallreminder" class="epc-button">Set Reminder</button>
    </div>
</form>

<div class="fulllengthright"><button class="tripupdate_generatecn" id="addtasktodolist" onclick="showform()">Add Task</button>
    <button class="tripupdate_generatecn" id="addcallreminderbutton" onclick="showcallreminderform()">Add Call Reminder</button>
    <button class="tripupdate_generatecn" id="viewcompletedtask" onclick="window.location.href='viewcompletedtask.php'">View Completed Task</button>
</div>

    <table class="todotable">
        <thead>
            <tr>
                <th>Date</th>
                <th>Task</th>
                <th>Type</th>
                <th>Current Status</th>
                <th>Created By</th>
                <th>Assigned to</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($resulttask) > 0) {
                while ($row = mysqli_fetch_assoc($resulttask)) { ?>
                    <tr>
                    <td><?php echo date("jS M y", strtotime($row['date'])); ?></td>
                    <td><?php echo $row['task']; ?></td>
                    <td><?php echo $row['task_type'] . (!empty($row['clientname']) ? '-' . $row['clientname'] : ''); ?></td>
                    <td><?php echo $row['status']; ?></td>
                        <td class="todatacont"><?php echo $row['listed_by']; ?></td>
                        <td class="todatacont"><?php echo $row['assigned_to_email']; ?></td>
                        <td data-label="Actions">
            <a href="edittodotask.php?id=<?php echo $row['id']; ?>" class="quotation-icon" onclick="return confirmAction(event, this.href);" title="Edit">
            <i style="width: 22px; height: 22px;" class="bi bi-pencil"></i>
            </a>
            <a  style="<?php echo ($row['status'] != 'Open') ? 'display:none;' : ''; ?>"  href="taskcompleted.php?id=<?php echo $row['id']; ?>" onclick="return confirmComplete()" class="quotation-icon" title="Task Completed">
            <i style="width: 22px; height: 22px;" class="bi bi-check-circle"></i>
            </a>
            <a 
    style="<?php echo ($row['listed_by'] != $email) ? 'display:none;' : ''; ?>" 
    href="deletetodotask.php?id=<?php echo $row['id']; ?>" onclick="return (confirmDelete());" 
    class="quotation-icon" 
    title="Delete">
               <i style="width: 22px; height: 22px;" class="bi bi-trash"></i>
            </a>
        </td>
                    </tr>
                <?php }
            } else{ ?>
            <tr>
            <td colspan="6"><div class="fulllength">No Relative Data Found</div><br></td>
            </tr>
            
           <?php }?>
            
        </tbody>
    </table>
    <!-- viewnotisection -->
    <div class="notification_background" id="notification_bg">
                <div class="noti_outer">
                <div class="closeall" onclick="close_all_todonoti('<?php echo $companyname001 ?>')"><i class="fa-solid fa-xmark cross_symbol"></i>  Close All</div>

                <?php
        while($row_noti_content = mysqli_fetch_assoc($viewnotiresult) ){
    ?>
    <div class="noti_container">
        <div class="noti_content_main">
            <div class="content_holder">
        <?php 

echo "Task Assigned Which Says - " . $row_noti_content['task'] . "<br>";
// echo "Expires in " . $row_noti_content['listed_by'] . " days" . "<br>";
?>
</div>
<a onclick="del_notificationtodo(<?php echo $row_noti_content['id']; ?>)" id="del_notification"><i class="fa-solid fa-xmark"></i></a>          


        </div>
    </div>
    
    <?php
}

?>

                </div>
                </div>

</body>
<script>
    function showform() {
        const addtaskform_todo = document.getElementById("addtaskform_todo");
        const addtasktodolist = document.getElementById("addtasktodolist");
        
        addtaskform_todo.style.display = "flex";
        addtasktodolist.style.display = "none";
    }

                    function todonotiview(){
            document.getElementById("notification_bg").style.display = "block";
        }

        function close_all_todonoti(comp_name){
    window.location.href = "del_all_todonoti.php?comp_name=" + comp_name;
}

function del_notificationtodo(del_noti) {
    window.location.href = "del_notification_todo.php?notification_id=" + del_noti;
}
function confirmAction(event, url) {
    event.preventDefault(); // Prevent default link behavior
    if (confirm("Are you sure you want to edit this task?")) {
        window.location.href = url; // Redirect if user confirms
    }
}
function confirmComplete(){
    return(confirm("Task completed ?"))
}

function confirmDelete(){
    return(confirm("Are you sure you want to delete the task ?"))
}
function filterClients() {
    const input = document.getElementById('clientSearch');
    const filter = input.value.toLowerCase();
    const suggestions = document.getElementById('suggestions');
    const select = document.getElementById('companySelect');
    const options = select.getElementsByTagName('option');

    suggestions.innerHTML = ''; // Clear previous suggestions
    let hasVisibleItems = false;

    for (let i = 0; i < options.length; i++) {
        const optionText = options[i].textContent || options[i].innerText;
        if (optionText.toLowerCase().includes(filter) && filter) {
            const suggestionItem = document.createElement('div');
            suggestionItem.className = 'suggestion-item';
            suggestionItem.textContent = optionText;
            suggestionItem.onclick = function() {
                select.value = options[i].value; // Set the select value
                input.value = optionText; // Set the input value
                suggestions.style.display = 'none'; // Hide suggestions
                updateContactPerson(); // Call the onchange function
                newclient(); // Call the newclient function
            };
            suggestions.appendChild(suggestionItem);
            hasVisibleItems = true;
        }
    }

    // If no suggestions found, show "New Client" option
    if (!hasVisibleItems) {
        const newClientItem = document.createElement('div');
        newClientItem.className = 'suggestion-item';
        newClientItem.textContent = 'New Client';
        newClientItem.onclick = function() {
            select.value = 'New Client'; // Set the select value
            input.value = 'New Client'; // Set the input value
            suggestions.style.display = 'none'; // Hide suggestions
            updateContactPerson(); // Call the onchange function
            newclient(); // Call the newclient function
        };
        suggestions.appendChild(newClientItem);
        suggestions.style.display = 'block'; // Show the suggestions
    } else {
        suggestions.style.display = 'block'; // Show suggestions if there are any
    }
}
function newclient(){
    const companySelect=document.getElementById("companySelect");
    const contactSelect=document.getElementById("contactSelectouter");
    const newrentalcontactperson=document.getElementById("newrentalcontactperson");
    const companySelectouter=document.getElementById("companySelectouter");
        const newrentalclient=document.getElementById("newrentalclient");

    
        if(companySelect.value==='New Client'){
            companySelectouter.style.display='none';
            contactSelect.style.display='none';
            newrentalcontactperson.style.display='flex';
            newrentalclient.style.display='flex';
    
        }

}

function newcontactpersonfunction(){
    const contactSelect=document.getElementById("contactSelect");
    const contactSelectouter=document.getElementById("contactSelectouter");
    const newrentalcontactperson=document.getElementById("newrentalcontactperson");
    const quoteouter02=document.getElementById("quoteouter02");

    if(contactSelect.value==='New Contact Person'){
        contactSelectouter.style.display='none';
        newrentalcontactperson.style.display='flex';

    
        }


}

function showDropdown() {
    const suggestions = document.getElementById('suggestions');
    suggestions.style.display = 'block';
}

// Close suggestions when clicking outside
document.addEventListener('click', function(event) {
    const suggestions = document.getElementById('suggestions');
    const input = document.getElementById('clientSearch');
    if (!suggestions.contains(event.target) && event.target !== input) {
        suggestions.style.display = 'none';
    }
});
function newcontactpersonfunction(){
    const contactSelect=document.getElementById("contactSelect");
    const contactSelectouter=document.getElementById("contactSelectouter");
    const newrentalcontactperson=document.getElementById("newrentalcontactperson");
    const quoteouter02=document.getElementById("quoteouter02");

    if(contactSelect.value==='New Contact Person'){
        contactSelectouter.style.display='none';
        newrentalcontactperson.style.display='flex';

    
        }


}

function filterClients_todo() {
    const input = document.getElementById('clientSearch_todo');
    const filter = input.value.toLowerCase();
    const suggestions = document.getElementById('suggestions_todo');
    const select = document.getElementById('companySelect_todo');
    const options = select.getElementsByTagName('option');

    suggestions.innerHTML = '';
    let hasVisibleItems = false;

    for (let i = 0; i < options.length; i++) {
        const optionText = options[i].textContent || options[i].innerText;
        if (optionText.toLowerCase().includes(filter) && filter) {
            const suggestionItem = document.createElement('div');
            suggestionItem.className = 'suggestion-item';
            suggestionItem.textContent = optionText;
            suggestionItem.onclick = function() {
                select.value = options[i].value;
                input.value = optionText;
                suggestions.style.display = 'none';
                updateContactPerson_todo();
                newclient_todo();
            };
            suggestions.appendChild(suggestionItem);
            hasVisibleItems = true;
        }
    }

    if (!hasVisibleItems) {
        const newClientItem = document.createElement('div');
        newClientItem.className = 'suggestion-item';
        newClientItem.textContent = 'New Client';
        newClientItem.onclick = function() {
            select.value = 'New Client';
            input.value = 'New Client';
            suggestions.style.display = 'none';
            updateContactPerson_todo();
            newclient_todo();
        };
        suggestions.appendChild(newClientItem);
        suggestions.style.display = 'block';
    } else {
        suggestions.style.display = 'block';
    }
}

function newclient_todo() {
    const companySelect = document.getElementById("companySelect_todo");
    const contactSelect = document.getElementById("contactSelectouter_todo");
    const newrentalcontactperson = document.getElementById("newrentalcontactperson");
    const companySelectouter = document.getElementById("companySelectouter_todo");
    const newrentalclient = document.getElementById("newrentalclient");

    if (companySelect.value === 'New Client') {
        companySelectouter.style.display = 'none';
        contactSelect.style.display = 'none';
        newrentalcontactperson.style.display = 'flex';
        newrentalclient.style.display = 'flex';
    }
}

function newcontactpersonfunction_todo() {
    const contactSelect = document.getElementById("contactSelect_todo");
    const contactSelectouter = document.getElementById("contactSelectouter_todo");
    const newrentalcontactperson = document.getElementById("newrentalcontactperson");

    if (contactSelect.value === 'New Contact Person') {
        contactSelectouter.style.display = 'none';
        newrentalcontactperson.style.display = 'flex';
    }
}

function showDropdown_todo() {
    const suggestions = document.getElementById('suggestions_todo');
    suggestions.style.display = 'block';
}

// Close suggestions when clicking outside
document.addEventListener('click', function(event) {
    const suggestions = document.getElementById('suggestions_todo');
    const input = document.getElementById('clientSearch_todo');
    if (!suggestions.contains(event.target) && event.target !== input) {
        suggestions.style.display = 'none';
    }
});

// You'll need to implement this function if it's used
function updateContactPerson_todo() {
    // Your implementation for updating contact person
}


</script>
</html>
