<?php
include "partials/_dbconnect.php";
session_start();
$email = $_SESSION['email'];
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
$showAlert = false;
$showError = false;

if(isset($_SESSION['error'])){
    $showError=true;
    unset($_SESSION['error']);
}

else if(isset($_SESSION['success'])){
    $showAlert=true;
    unset($_SESSION['success']);

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Requirements</title>
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="favicon.jpg" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

</head>
<body>
<div class="navbar1">
    <div class="logo_fleet">
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
if($showAlert){
    echo '<label>
    <input type="checkbox" class="alertCheckbox" autocomplete="off" />
    <div class="alert notice">
        <span class="alertClose">X</span>
        <span class="alertText">Success <br class="clear"/></span>
    </div>
    </label>';
}
if($showError){
    echo '<label>
    <input type="checkbox" class="alertCheckbox" autocomplete="off" />
    <div class="alert error">
        <span class="alertClose">X</span>
        <span class="alertText">Something Went Wrong<br class="clear"/></span>
    </div>
    </label>';
}
?>


    <div class="projectrequirement">
    <?php
    // echo $projectcodennumber;
    include "partials/_dbconnect.php";
    
    $myrequirement = "SELECT * FROM `req_by_epc` WHERE posted_by='$companyname001' order by `id` DESC";
    $resultmyproject = mysqli_query($conn, $myrequirement);
    
    if ($resultmyproject && mysqli_num_rows($resultmyproject) > 0) { ?>
    <?php    echo '<table class="purchase_table" id="logi_rates"><tr>';

        $loop_count = 0; // Initialize the counter

        while ($row3 = mysqli_fetch_assoc($resultmyproject)) {
            if ($loop_count > 0 && $loop_count % 4 == 0) {
                echo '</tr><tr>'; 
            }
            ?>
            <td>
                <div class="custom-card" id="application_card" onclick="window.location. href='editequipmentrental.php?id=<?php echo $row3['id']; ?>&&projectid=<?php echo $projectid; ?>'">
                <p class="insidedetails"><strong>Valid Till:</strong> <?php echo htmlspecialchars((new DateTime($row3['reqvalid']))->format('jS-M Y')); ?></p>
                <p class="insidedetails"><strong>Equipment:</strong> <?php echo htmlspecialchars($row3['equipment_type']); ?></p>
<p class="insidedetails"><strong>Capacity:</strong> <?php echo htmlspecialchars($row3['equipment_capacity']) . '-' . htmlspecialchars($row3['unit']); ?></p>
<p class="insidedetails"><strong>Contact Person:</strong> <?php echo htmlspecialchars($row3['contact_person']); ?></p>
<p class="insidedetails"><strong>Location:</strong> <?php echo htmlspecialchars($row3['district']) . '-' . htmlspecialchars($row3['state']); ?></p>
<p class="insidedetails" id="button_container_resume">
                        <a title="Edit Project" href='editequipmentrental.php?id=<?php echo $row3['id']; ?>'>
                            <button class="downloadresume" type="button"><i class="fa-regular fa-edit"></i></button>
                        </a>
                        <a title="Delete Project" href='deleterentalequipmentlisting.php?id=<?php echo $row3['id']; ?>' onclick="return confirmDelete();">
    <button class="downloadresume" type="button"><i class="fa-solid fa-trash"></i></button>
</a>
                  </p>


                    <div class="custom-card__arrow">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </div>
            </td>
            <?php
            $loop_count++;
        }
        echo '</tr></table>';
    } else {
        echo '<br><p class="fulllength">No requirements found.</p>'; // Handle no results case
    }
    ?>
</div>

</body>
<script>
        function confirmDelete() {
        return confirm("Are you sure you want to delete ?");
    }


</script>
</html>