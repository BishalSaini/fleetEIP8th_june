<?php 
include "partials/_dbconnect.php";
session_start();
$name=$_GET['name'];
$email = $_SESSION['email'];
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
$sql="SELECT * FROM `team_members` where company_name=$name";
$result=mysqli_query($conn,$sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="tiles.css">
    <link rel="shortcut icon" href="favicon.jpg" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Team Information</title>
</head>
<body>
<div class="navbar1">
    <div class="logo_fleet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <img src="logo_fe.png" alt="FLEET EIP" onclick="window.location.href='<?php echo $dashboard_url  ?>'">
</div>

        <div class="iconcontainer">
        <ul>
      <li><a href="<?php echo $dashboard_url ?>">Dashboard</a></li>
            <li><a href="logout.php">Log Out</a></li></ul>
        </div>
    </div> 
    <?php 
     if(mysqli_num_rows($result)>0){ ?>
    <table class="quotation-table" id="viewcompleteinfotable">
        <tr>
            <th>Name</th>
            <th>Cell</th>
            <th>Email</th>
            <th>Department</th>
            <th>Designation</th>
        </tr>
        <?php while($row=mysqli_fetch_assoc($result)){ ?>
          <tr>
            <td><?php echo $row['name'] ?></td>
            <td><?php echo $row['mob_number'] ?></td>
            <td><?php echo $row['email'] ?></td>
            <td><?php echo $row['department'] ?></td>
            <td><?php echo $row['designation'] ?></td>
          </tr>

        <?php } ?>
    </table>
    <?php }
else {
    echo '<p class="fulllength">No Team Member Found</p>';
}
    ?>
    
    </body>
</html>

