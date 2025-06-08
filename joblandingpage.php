<?php
session_start();
$companyname001=$_SESSION['companyname'];
$showAlert=false;
$showError=false;

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

?>
<?php
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
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="tiles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Include your CSS files in the head for styling -->
</head>
<body>
    <div class="navbar1">
        <!-- Navbar section -->
        <div class="logo_fleet">
            <!-- Logo with a link to rental_dashboard.php -->
            <img src="logo_fe.png" alt="FLEET EIP" onclick="window.location.href='<?php echo $dashboard_url  ?>'">
        </div>
        <div class="iconcontainer">
            <!-- Navigation links -->
            <ul>
              <li><a href="<?php echo $dashboard_url ?>">Dashboard</a></li>
                <li><a href="news/">News</a></li>
                <li><a href="logout.php">Log Out</a></li>
            </ul>
        </div>
    </div>
    <?php
if ($showAlert) {
    echo  '<label>
    <input type="checkbox" class="alertCheckbox" autocomplete="off" />
    <div class="alert notice">
      <span class="alertClose">X</span>
      <span class="alertText_addfleet"><b>Success! </b>
          <br class="clear"/></span>
    </div>
  </label>';
}
if ($showError) {
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

    <div class="generate_logi_requirement">
        <!-- Main content section -->
        <article class="article-wrapper" id="post_rfq_button" onclick="location.href='job_posting.php'">
            <!-- Article wrapper for a clickable area -->
            <div class="rounded-lg container-projectss">
                <!-- Placeholder for content or styling -->
            </div>
            <div class="project-info">
                <!-- Project information -->
                <div class="flex-pr">
                    <!-- Flexible project title section -->
                    <div class="project-title text-nowrap">Post Job</div>
                    <div class="project-hover">
                        <!-- Project hover effect with SVG icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" stroke-linejoin="round" stroke-linecap="round" viewBox="0 0 24 24" stroke-width="2" fill="none" stroke="currentColor">
                            <line y2="12" x2="19" y1="12" x1="5"></line>
                            <polyline points="12 5 19 12 12 19"></polyline>
                        </svg>
                    </div>
                </div>
            </div>
        </article>
    </div>

    <?php
    include_once 'partials/_dbconnect.php';

    $result = mysqli_query($conn, "SELECT * FROM `job_posting` where `company_name`='$companyname001' ORDER BY sno desc");
    
    if(mysqli_num_rows($result) > 0) {
        echo '<table class="purchase_table" id="job_posting">';
        echo '<tr>'; // Start the first row

        $loop_count = 0; // Initialize the counter
        
        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['sno'];

            if ($loop_count > 0 && $loop_count % 4 == 0) {
                echo '</tr><tr>'; // Close the current row and start a new one
            }
            
            echo '<td>
            <a href="view_application_jobrole.php?id=' . urlencode($id) . '" class="custom-card-link">
                <div class="custom-card" id="requirement_club">
                    <h3 class="custom-card__title">'.$row['job_heading']. '</h3>
                    <p class="custom-card__content">Job Location : '. ($row['job_location']) .'</p>
                    <div class="custom-card__date row_logi_req">'. ($row['pay_range']) . ' Salary' .'</div> 

<a href="viewedit_jobposting.php?id=' . urlencode($id) . '" class="custom-card-link">
    <div class="custom-card__date row_logi_req">
        <p title="view & edit" class="edit_icon_logi">
            <i class="fa-regular fa-eye"></i> 
        </p>
    </div>
</a>

                    <div class="custom-card__arrow">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </div>
            </td>';

            $loop_count++;
        }
        
        echo '</tr>'; // Close the last row
        echo '</table>';
    }
    ?>

</body>
</html>
