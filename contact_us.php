<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){
    include 'partials/_dbconnect.php';
    $emailid = $_POST["emailid"];
    $mobno = $_POST["mobno"];
    $feedback = $_POST["feedback"];
    $sql="INSERT INTO `feedback` (`emailid`, `mobno`, `feedback`) VALUES
         ('$emailid', '$mobno', '$feedback')";
         $result = mysqli_query($conn, $sql);
}
?>
<style>
  <?php include "style.css"; ?>
</style>
<script>
    <?php include "main.js" ?>
    </script>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">      <link rel="icon" href="favicon.jpg" type="image/x-icon">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Contact Us</title>
</head>
<body>
    <div class="navbar1">
    <div class="logo_fleet">
    <img src="logo_fe.png" alt="FLEET EIP" onclick="window.location.href='<?php echo $dashboard_url  ?>'">
</div>

        <div class="iconcontainer">
        <ul><li><a href="sign_in.php">Home</a></li>
            <li><a href="about_us.html">About Us</a></li>
            <li><a href="contact_us.php">Contact Us</a></li>
            <li><a href="sign_up.php">Sign Up</a></li></ul>
        </div>
    </div>
            <form action="/fleeteip/contact_us.php" method="post" class="contactform" autocomplete="off">
                <div class="imagecontact"></div>
                <div class="contactform2">
                    <div class="contact"><p>CONTACT US</p></div>
                    <div class="trial1">
                    <input type="text" name="emailid" class="input02" placeholder="" required>
                    <label class="placeholder2">Email</label>
                    </div>
                    <div class="trial1">
                    <input type="text" name="mobno" class="input02" placeholder="" required>
                    <label class="placeholder2">Contact Number</label>
                    </div>
                    <div class="trial1">
                    <textarea name="feedback"class="input02" placeholder=" " required></textarea>
                    <label class="placeholder2">Feedback</label>
                    </div>
                    <button type="submit" class="epc-button">Submit</button>
                    <br>
                </div>
            </form>
   
</body>
        