<?php
session_start();
include "partials/_dbconnect.php";
$companyname001=$_SESSION['companyname'];
$name_user=$_SESSION['username'];


// Fetch the count of to-do notifications
$sql_to_do_notif = "SELECT COUNT(id) AS toal_noti FROM `todo_noti` where companyname='$companyname001' and assinged_to='$name_user'";
$result_noti_todo = mysqli_query($conn, $sql_to_do_notif);
$row_count = mysqli_fetch_assoc($result_noti_todo);
$count_todo = $row_count['toal_noti'];

// Handle adding new tasks via form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include_once 'partials/_dbconnect.php'; // Include the database connection file
    $task_info = $_POST['task_info'];
    $employe_sel = $_POST['employe_sel'];

    $sql_todo = "INSERT INTO `to_do` (`date`, `task`, `assinged_to`, `companyname`, `status`, `listed_by`)
    VALUES ( CURDATE(), '$task_info', '$employe_sel', '$companyname001', 'Open', '$name_user')";
    $result_todo_data = mysqli_query($conn, $sql_todo);

    if ($result_todo_data) {
        $sql_todo_noti = "INSERT INTO `todo_noti` (`date`, `task`, `assinged_to`, `companyname`, `status`, `listed_by`)
                          VALUES (CURDATE(), '$task_info', '$employe_sel', '$companyname001', 'Open', '$name_user')";
        $result_todo_noti = mysqli_query($conn, $sql_todo_noti);
        header("Location: to-do_redirection.php");
        exit();
    } else {
        $showError = true;
    }
}

// Fetch the to-do data for display
$sql_to_do_data = "SELECT * FROM `to_do` where companyname='$companyname001'";
$sql_todo_result = mysqli_query($conn, $sql_to_do_data);

// Fetch employees list for assigning tasks
$sql_employee = "SELECT * FROM `login` where companyname='$companyname001'";
$sql_employee_result = mysqli_query($conn, $sql_employee);
?>
<!-- To-Do List Section -->
 <link rel="stylesheet" href="style.css">
 <script src="main.js"></script>
<!-- To-Do List Section -->
<div class="todolist">
    <div class="todo_heading">
        <p>To-Do-List</p>
        <div class="addtask">
            <button onclick="add_task()">
                <i class="fa-solid fa-plus"></i>&nbsp Add Task
            </button>
        </div>
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
                <td class="action_td">
                    <div class="btn_cnt" <?php if ($row_todo_table['listed_by'] != $name_user) { echo 'hidden'; } ?>>
                        <button class="done_btn" onclick="task_done(<?php echo $row_todo_table['id'] ?>)">
                            <i class="fa-solid fa-check"></i> Close
                        </button>
                    </div>
                    <div class="btn_cnt" <?php if ($row_todo_table['assinged_to'] != $name_user || $row_todo_table['status'] === 'Closed') { echo 'hidden'; } ?>>
                        <button class="done_btn" onclick="task_completed(<?php echo $row_todo_table['id'] ?>)">Completed</button>
                    </div>
                </td>
            </tr>
            <?php
                }
            }
            ?>
        </table>
    </div>
</div>

<!-- Add Task Modal -->
<div class="black_modal" id="on_add_task">
    <div class="add_task_cont">
        <form action="rental_dashboard.php" method="POST" class="add_task">
            <div class="add_task_form_cont">
                <div class="task_heading">
                    <p>Add Task</p>
                    <i class="fa-solid fa-xmark" onclick="window.location='rental_dashboard.php'"></i>
                </div>
                <div class="trial1">
                    <textarea type="text" placeholder="" name="task_info" class="input02" id="task_area"></textarea>
                    <label for="" class="placeholder2">Task</label>
                </div>
                <p class="task_para"><a href="rental_employee.php">Not Able To Find the employee Name? Add them here</a></p>
                <div class="trial1">
                    <select name="employe_sel" id="" class="input02">
                        <option value="" disabled selected>Task Assigned To</option>
                        <?php
                        while ($row_employee = mysqli_fetch_assoc($sql_employee_result)) {
                            if ($row_employee) {
                        ?>
                        <option value="<?php echo $row_employee['username'] ?>"><?php echo $row_employee['username'] ?></option>
                        <?php
                            }
                        }
                        ?>
                    </select>
                    <br>
                    <div class="task_btn">
                        <button class="taskadd" type="submit">Add Task</button><br>
                    </div>
                    <br>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- JavaScript for Task Actions -->
<script>
function add_task() {
    document.getElementById("on_add_task").style.display = "block";
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
