<?php
$showAlert = false;
$showError = false;
$del_done = false;
$del_error=false;
$showAlert_status=false;
$showerror_status=false;

include_once 'partials/_dbconnect.php'; // Include the database connection file

// Start the session and retrieve the company name from the session
session_start();
$name_user=$_SESSION['username'];
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
else {
    $dashboard_url = '';
}
// $_SESSION['time'] = $strt_time;
$strt_time=$_SESSION['time'];
$expiry_date = date('d-m-Y', strtotime($strt_time . ' +3 months'));

if (!isset($_SESSION['insuarance_expiry_reminder_included'])) {
    include "insuarance_expiry_reminder.php";
    include "work_order_validity.php";
    include "rc_validity.php";
    include "fc_validity.php";
    include "np_validity.php";
    include "dl_expiry_notification.php";
    include "remove_dupli_noti.php";
    include "dl_dubli_noti_del.php";
    // Set a session flag to indicate that the file has been included
    $_SESSION['insuarance_expiry_reminder_included'] = true;
}

?>
<?php
$sql_to_do_notif="SELECT COUNT(id) AS toal_noti FROM `todo_noti` where companyname='$companyname001' and assinged_to='$name_user'";
$result_noti_todo=mysqli_query($conn,$sql_to_do_notif);
$row_count=mysqli_fetch_assoc($result_noti_todo);
$count_todo=$row_count['toal_noti'];


?>
<?php
if($_SERVER['REQUEST_METHOD']==='POST'){
    include_once 'partials/_dbconnect.php'; // Include the database connection file
$task_info=$_POST['task_info'];
$employe_sel=$_POST['employe_sel'];

$sql_todo="INSERT INTO `to_do` (`date`, `task`, `assinged_to`, `companyname`,`status`,`listed_by`)
 VALUES ( CURDATE(), '$task_info', '$employe_sel', '$companyname001','Open','$name_user')";
$result_todo_data=mysqli_query($conn,$sql_todo);
if($result_todo_data){
    $sql_todo_noti = "INSERT INTO `todo_noti` (`date`, `task`, `assinged_to`, `companyname`, `status`, `listed_by`)
                      VALUES (CURDATE(), '$task_info', '$employe_sel', '$companyname001', 'Open', '$name_user')";
    $result_todo_noti = mysqli_query($conn, $sql_todo_noti);
    header("Location: to-do_redirection.php");
    exit();
}
else{
    $showError=true;
}
}

if(isset($_SESSION['message'])){
    $showAlert=true;
    unset($_SESSION['message']);    
}
if(isset($_SESSION['del_message'])){
    $del_done=true;
    unset($_SESSION['del_message']);    
}
if(isset($_SESSION['error_del'])){
    $del_error=true;
    unset($_SESSION['error_del']);    
}
if(isset($_SESSION['status_change'])){
    $showAlert_status=true;
    unset($_SESSION['status_change']);    
}
if(isset($_SESSION['status_notchange'])){
    $showerror_status=true;
    unset($_SESSION['status_notchange']);    
}

?>
<?php
$sql_notification_count_expiry="SELECT COUNT(sno) AS total_notification FROM `insaurance_notification` where company_name='$companyname001'";
$result_count=mysqli_query($conn,$sql_notification_count_expiry);
$row_count_noti= mysqli_fetch_assoc($result_count);
$count_of_notification=$row_count_noti['total_notification']
?>
<?php 
$sql_dl_expiry_count = "SELECT COUNT(sno) AS total_dl_notification FROM `dl_expiry` WHERE company_name='$companyname001'";
$dl_result = mysqli_query($conn, $sql_dl_expiry_count);
$row_count_dl = mysqli_fetch_assoc($dl_result);
$count_of_dl_notification = $row_count_dl['total_dl_notification'];
?>
<?php
$sql_addedfleet="SELECT COUNT(snum) AS total FROM `fleet1` where companyname='$companyname001'";
$result = mysqli_query($conn, $sql_addedfleet);
$row = mysqli_fetch_assoc($result);
$total_count = $row['total'];

$sql_addedoperator = "SELECT COUNT(id) AS total_operator FROM `myoperators` where company_name='$companyname001'";
$result_operator = mysqli_query($conn, $sql_addedoperator);
$row_operator = mysqli_fetch_assoc($result_operator);
$total_count_operator = $row_operator['total_operator']; // Update variable name to $row_operator

$sql_new_leads="SELECT COUNT(id) AS total_new_leads FROM  `req_by_epc` WHERE id NOT IN (SELECT requirement_id FROM `notinterested_rental` WHERE rental_name = '$companyname001') AND id NOT IN (SELECT req_id FROM `requirement_price_byrental` WHERE rental_name = '$companyname001')";
$result_new_leads=mysqli_query($conn,$sql_new_leads);
$row_new_leads=mysqli_fetch_assoc($result_new_leads);
$total_new_leads = $row_new_leads['total_new_leads'];


$sql_to_do_data="SELECT * FROM `to_do` where companyname='$companyname001'";
$sql_todo_result=mysqli_query($conn ,$sql_to_do_data);


$sql_employee="SELECT * FROM `login` where companyname='$companyname001'";
$sql_employee_result=mysqli_query($conn,$sql_employee);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">      <link rel="icon" href="favicon.jpg" type="image/x-icon">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Alata&display=swap" rel="stylesheet">
    <title>Dashboard</title>
</head>
<body>
    <div class="navbar1">
    <div class="logo_fleet">
    <img src="logo_fe.png" alt="FLEET EIP" onclick="window.location.href='<?php echo $dashboard_url  ?>'">
</div>

        <div class="iconcontainer">
        <ul>
          <li><a href="<?php echo $dashboard_url ?>">Dashboard</a></li>
            <li><a href="news/">News</a></li>
            <!-- <li><a href="contact_us.php">Contact Us</a></li> -->
            <li><a href="logout.php">Log Out</a></li>
        <li id="alert_id" <?php if($count_todo == 0) echo 'style="display: none;"' ?>><div class="alerts" onclick="show_to_do_assigned()" ><?php echo $count_todo ?> Alerts</div></li>
</ul>
        </div>
    </div> 
    <?php
    if($showAlert){
        echo '<label>
        <input type="checkbox" class="alertCheckbox" autocomplete="off" />
        <div class="alert notice">
          <span class="alertClose">X</span>
          <span class="alertText">Task Added Successfully!
              <br class="clear"/></span>
        </div>
      </label>';
     }
     if($showError){
        echo '<label>
        <input type="checkbox" class="alertCheckbox" autocomplete="off" />
        <div class="alert error">
          <span class="alertClose">X</span>
          <span class="alertText">Something Went Wrong
              <br class="clear"/></span>
        </div>
      </label>';

    }
    if($showAlert_status){
        echo '<label>
        <input type="checkbox" class="alertCheckbox" autocomplete="off" />
        <div class="alert notice">
          <span class="alertClose">X</span>
          <span class="alertText">Task Status Changed Successfully!
              <br class="clear"/></span>
        </div>
      </label>';
     }
     if($showerror_status){
        echo '<label>
        <input type="checkbox" class="alertCheckbox" autocomplete="off" />
        <div class="alert error">
          <span class="alertClose">X</span>
          <span class="alertText">Something Went Wrong
              <br class="clear"/></span>
        </div>
      </label>';

    }

    if($del_done){
        echo '<label>
        <input type="checkbox" class="alertCheckbox" autocomplete="off" />
        <div class="alert notice">
          <span class="alertClose">X</span>
          <span class="alertText">Task Deleted SUccessfully!
              <br class="clear"/></span>
        </div>
      </label>';
     }
     if($del_error){
        echo '<label>
        <input type="checkbox" class="alertCheckbox" autocomplete="off" />
        <div class="alert error">
          <span class="alertClose">X</span>
          <span class="alertText">Something Went Wrong
              <br class="clear"/></span>
        </div>
      </label>';
      
    }

    ?> 
    <?php 
            include "partials/_dbconnect.php";
            $sql_to_noti_display="SELECT * FROM `todo_noti` where companyname='$companyname001' and assinged_to= '$name_user'";
            $res=mysqli_query($conn,$sql_to_noti_display);
            ?>
    <div class="black_modal" id="todonoti">
    <div class="noti_contai">
        <button class="epc-button" id="closeall_tasknoti" onclick="resetCount('<?php echo $name_user ?>')">Close All</button>
        <?php while($row_todoo=mysqli_fetch_assoc($res)){
            ?>
<div class="todo_nnoti_info">
    <div class="noti_content">
    <?php 
    echo $row_todoo['listed_by'] . " &nbspAssigned You A Task Which Says " . $row_todoo['task'];
    ?>
</div>
</div>
            <?php
        } ?>

            </div>
</div> 
<div class="main_container">
    <div class="left_menu_options">
        <div class="left_menu_inner">
            <!-- <a href="addfleetnew.php" class="add_fleet_menu">⧃ Add Fleet</a> -->
            <a href="viewfleet2.php" class="add_fleet_menu">⧃ Fleet Management</a>
            <a href="admindash.php" class="add_fleet_menu">⧃ New Dashboard</a>
            <a href="purchase.php" class="add_fleet_menu">⧃ Purchase Requisition</a>
            <a href="view_req_rental.php" class="add_fleet_menu">⧃ Market Leads</a>
            <a href="marketplace.php" class="add_fleet_menu">⧃ Market Place</a>
            <a href="view_operator.php" class="add_fleet_menu">⧃ Man Power</a>
            <a href="livesearch.php" class="add_fleet_menu">⧃ Directory</a>
            <a href="rental_subuser.php" class="add_fleet_menu">⧃ Add Members</a>
            <a href="rental_employee.php" class="add_fleet_menu">⧃ Add Sub Users</a>
            <a href="complete_profile.php" class="add_fleet_menu">⧃ Complete Profile</a>

            <a href="edit_profile.php" class="add_fleet_menu">⧃ Edit Profile</a>
            <!-- <a href="generate_quotation.php" class="add_fleet_menu">✧ Generate Quotation</a> -->
            <a href="generate_quotation_landingpage.php" class="add_fleet_menu">⧃ Generate Quotation </a>
            <!-- <a href="generate_quotation2.php" class="add_fleet_menu">✧ Generate Quotation 2</a> -->
            <!-- <a href="rental_generated_quotation.php" class="add_fleet_menu">✧ My Quotation</a> -->
            <a href="generate_invoice.php" class="add_fleet_menu">⧃ Generate Bill</a>



        </div>
    </div>
    <div class="right_menu_options">
    <div class="welcome_message">
        <p>Welcome <?php echo $companyname001 ?>  &nbsp &nbsp &nbsp Trial Expiry Date = <?php echo $expiry_date ?></p>
    </div>   

        <div class="firstrow_stats" >
            <div class="first_block_container0">
        <div class="firstblock" onclick="open_added_fleet()">
        <div class="added_fleet_notification" <?php if($count_of_notification == 0) echo 'style="display: none;"' ?>><?php echo $count_of_notification ?></div>
        <div class="firstblock_inside1">Fleet Added </div>
            <div class="firstblock_inside2"><?php echo $total_count ?></div>
        </div>
        </div>
        <div class="secondblock" onclick="open_added_operators()" >
        <div class="added_fleet_notification" <?php if($count_of_dl_notification == 0) echo 'style="display: none;"' ?>><?php echo $count_of_dl_notification ?></div>
        <div class="secondblock_inside1">Operator Added </div>
        <div class="secondblock_inside2"><?php echo  $total_count_operator ?></div>
        </div>
        <div class="thirdblock" onclick="open_market_leads()">
        <!-- <div class="added_fleet_notification" <?php if($total_new_leads == 0) echo 'style="display: none;"' ?>><?php echo $count_of_dl_notification ?></div> -->
        <div class="thirdblock_inside1">New Requirements </div>
        <div class="thirdblock_inside2"><?php echo $total_new_leads ?></div>

        </div>
        </div>
        <br>
        <div class="secondrow_stats">
            <div class="todolist">
                <div class="todo_heading"><p>To-Do-List</p> <div class="addtask"><button onclick="add_task()"><i class="fa-solid fa-plus"></i>&nbsp Add Task</button></div>
</div>
                <div class="todo_list">
    <table class="to_do_content">
        <th>Date</th>
        <th>Day</th>
        <th>Task</th>
        <th>Assigned To</th>
        <th>Current Status</th>
        <th>Listed By</th>
        <th>Action</th>
        <?php 
            while ($row_todo_table = mysqli_fetch_assoc($sql_todo_result)) {
                if ($row_todo_table) {
        ?>
        <tr>
            <td><?php echo date("d-m-Y", strtotime($row_todo_table['date'])) ?></td>
            <td><?php echo substr(date("D", strtotime($row_todo_table['date'])), 0, 3) ?></td>
            <td><?php echo $row_todo_table['task'] ?></td>
            <td><?php echo $row_todo_table['assinged_to'] ?></td>
            <td><?php echo $row_todo_table['status'] ?></td>
            <td><?php echo $row_todo_table['listed_by'] ?></td>

            <td class="action_td"><div class="btn_cnt" <?php if($row_todo_table['listed_by']!=$name_user){echo 'hidden';} ?>><button class="done_btn" onclick="task_done(<?php echo $row_todo_table['id'] ?>)"><i class="fa-solid fa-check"></i> Close</button></div>
                    <div class="btn_cnt" <?php if($row_todo_table['assinged_to']!=$name_user ||$row_todo_table['status']==='Closed' ){echo 'hidden';} ?> ><button class="done_btn" onclick="task_completed(<?php echo $row_todo_table['id'] ?>)">Completed</button></div>
        </td>

            <!-- <td><button class="done_btn" onclick="task_done(<?php echo $row_todo_table['id'] ?>)"><i class="fa-solid fa-check"></i> Done</button></td> -->
        </tr>
        <div class="black_modal" id="task_done">
            <div class="done_task_outer">
                <div class="done_task">
                   <h3><strong>Close The Task ?</strong></h3>
                   <div class="btn_task_done"><a id="deleteTaskLink" class="cls-btn">Close</a>
 &nbsp <button class="cls-btn" onclick="window.location='rental_dashboard.php'">Cancel</button></div>

                </div>
            </div>
        </div>

        <?php
                } else {
                    echo ""; // Echoing an empty string doesn't do anything, you can remove this line.
                }
            }
        ?>
    </table>
</div>
                </div>
            </div>

        </div>
    </div>

</div>
<div class="black_modal" id="on_add_task">
    <div class="add_task_cont">
        <form action="rental_dashboard.php" method="POST" class="add_task">
        <div class="add_task_form_cont">
            <div class="task_heading"><p>Add Task</p><i class="fa-solid fa-xmark" onclick="window.location='rental_dashboard.php'"></i></div>
            <div class="trial1">
                <textarea type="text" placeholder="" name="task_info" class="input02"  id="task_area"></textarea>
                <label for="" class="placeholder2">Task</label>
            </div>
            <p class="task_para"><a href="rental_employee.php">Not Able To Find the employee Name Add them here </a></p>
            <div class="trial1">
            <select name="employe_sel" id="" class="input02">
    <option value="" disabled selected>Task Assigned To</option>
    <?php
    while ($row_employee = mysqli_fetch_assoc($sql_employee_result)) {
        if ($row_employee) {
    ?>
            <option value="<?php echo $row_employee['username'] ?>"><?php echo $row_employee['username'] ?></option>
        <?php
        } else {
            echo "<option value=''>No Employee Found</option>";
        }
    }
    ?>
</select>
            <br>
            <div class="task_btn">
            <button class="taskadd" type="submit">Add Task</button> <br>
        

            </div>
            <br>
            </div>
        </div>
        </form>
    </div>
</div>
<script>
function resetCount(user_namme) {
    window.location.href = "del_todonoti.php?id=" + user_namme;
}


function open_added_fleet() {
    window.location.href = "viewfleet2.php";
}
function open_added_operators(){
    window.location.href="view_operator.php";
}

function open_market_leads(){
    window.location.href="view_req_rentalinner.php";
}

function add_task() {
    document.getElementById("on_add_task").style.display = "block";
}

function show_to_do_assigned(){
    document.getElementById("todonoti").style.display = "block";

}

function task_done(id) {
    // Construct the deletion link with the task ID
    var deletionLink = "del_todo_task.php?id=" + id;
    // Set the "Close" button link to the constructed deletion link
    document.getElementById("deleteTaskLink").href = deletionLink;
    // Show the modal
    document.getElementById("task_done").style.display = "block";
}
function task_completed(id){
    window.location = "to_do_done.php?id=" + id;

}
</script>
</body>
</html>