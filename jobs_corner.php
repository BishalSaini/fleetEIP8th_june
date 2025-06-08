<?php
include "partials/_dbconnect.php";
$sql="SELECT * FROM `job_posting` ORDER BY sno desc";
$result=mysqli_query($conn,$sql);
$showAlert=false;
$showError=false;

session_start();
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
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>
<div class="navbar1">
    <div class="logo_fleet">
    <img src="logo_fe.png" alt="FLEET EIP" onclick="window.location.href='index.php'">
</div>

        <div class="iconcontainer">
        <ul>
            <li><a href="index.php">Home</a></li>
            <!-- <li><a href="news/">News</a></li> -->
            <!-- <li><a href="contact_us.php">Contact Us</a></li> -->
            <!-- <li><a href="logout.php">Log Out</a></li></ul> -->
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

<?php  
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {   ?>
    <div class="job_heading_container">
        <div class="job_heading">
        <h3><?php echo strtoupper($row['job_heading']); ?></h3>
        <p><strong>Company name :</strong><?php echo ucwords($row['company_name']) ?></p>
        <p><strong>Location :</strong><?php echo ucwords($row['job_location']); ?></p>
        <p><strong>Pay Range :</strong><?php echo $row['pay_range'] ?></p>
        <p><strong>Minimum Experience :</strong><?php echo $row['minimum_experience'] ?></p>
        <br>
        <p>      <div class="links">
        <button class="follow" onclick="window.location.href='viewjobdetails.php?id=<?php echo $row['sno']; ?>'">View</button>
      </div>
</p>
        </div>
        <div class="job_postedon">
           <p> Job Posted On :<?php echo ucwords($row['created_at']) ?></p>
        </div>
    </div>

<?php
} 

}?>
</body>
</html>