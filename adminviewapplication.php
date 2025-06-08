<?php
include "partials/_dbconnect.php";
session_start();
$companyname001=$_SESSION['companyname'];
$job_id=$_GET['id'];
$sql="SELECT * FROM `job_application_apply` where job_id='$job_id' and status='verified'";
$result=mysqli_query($conn,$sql);

$sql_="SELECT * FROM `job_posting` where sno='$job_id' ";
$result_=mysqli_query($conn,$sql_);
$row1=mysqli_fetch_assoc($result_);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="favicon.jpg" type="image/x-icon">
    <title>Applications</title>
</head>
<body>
<div class="navbar1">
    <div class="logo_fleet">
    <img src="logo_fe.png" alt="FLEET EIP" onclick="window.location.href='<?php echo $dashboard_url  ?>'">
</div>

        <div class="iconcontainer">
        <ul><li><a href="rental_dashboard.php">Dashboard</a></li>
            <li><a href="news/">News</a></li>
            <!-- <li><a href="contact_us.php">Contact Us</a></li> -->
            <li><a href="logout.php">LogOut</a></li></ul>
        </div>
</div>
    <div class="job_detialscontainer">
    <p><strong>Job Heading :</strong><?php echo $row1['job_heading'] ?></p>
    <p><strong>Company Name :</strong><?php echo $row1['company_name'] ?></p>
    <p><strong>Job location:</strong> <?php echo $row1['job_location'] ?> &nbsp &nbsp <strong>Pay Range :</strong><?php echo $row1['pay_range'] ?> &nbsp &nbsp <strong>Minimum Experience :</strong><?php echo $row1['minimum_experience'] ?></p>
    <p><strong>Roles :</strong><?php echo $row1['roles'] ?></p>
    <p><strong>Education :</strong><?php echo $row1['education'] ?></p>
    <p><strong>Perks :</strong><?php echo $row1['perks'] ?></p>
    <p><strong>Contact Person :</strong><?php echo $row1['contact_person'] .'-'. $row1['designation'] ?></p>
    <p><strong>Contact Email :</strong><?php echo $row1['email'] ?> </p>

</div>

    <?php
if (mysqli_num_rows($result) > 0) {
    // Start the table
    echo '<table class="purchase_table" id="logi_rates"><tr>';

    $loop_count = 1; // Initialize the counter

    while ($row = mysqli_fetch_assoc($result)) {
        if ($loop_count > 0 && $loop_count % 4 == 0) {
            echo '</tr><tr>'; // Close the current row and start a new one after every 3 cards
        }
        ?>
        <td>
            <div class="custom-card" id="application_card">
                <h3 class="">Name: <?php echo $row['name'] ?></h3>
                <p class="insidedetails" id="">Contact: <?php echo $row['number'] ?></p>
                <p class="insidedetails" id="email_logi">Email: <?php echo $row['email_id'] ?></p>
                <div class="insidedetails">Total Experience: <?php echo $row['work_experience'] ?></div>
                <p class="insidedetails" id="button_container_resume">
    <a title="View Resume" href="<?php echo 'img/' . $row['resume']; ?>" target="_blank">
        <button class="downloadresume" type="button"><i class="fa-regular fa-eye"></i></button>
    </a>
    <a title="Download Resume" id="downloadresume" href="<?php echo 'img/' . $row['resume']; ?>" download="<?php echo $row['name'].' Resume' ?>">
        <button class="downloadresume" type="button"><i class="fa-solid fa-download"></i></button>
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

    // Close the last row and the table
    echo '</tr></table>';
}
?>

</body>
</html>