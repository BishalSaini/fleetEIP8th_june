<?php
include "partials/_dbconnect.php";
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$companyname001 = $_SESSION['companyname'];
$enterprise = $_SESSION['enterprise'];
$email = $_SESSION['email'];

$dashboard_url = '';
if ($enterprise === 'rental') {
    $dashboard_url = 'rental_dashboard.php';
} elseif ($enterprise === 'logistics') {
    $dashboard_url = 'logisticsdashboard.php';
} elseif ($enterprise === 'epc') {
    $dashboard_url = 'epc_dashboard.php';
} elseif ($enterprise === 'admin') {
    $dashboard_url = 'news/admin/dashboard.php';
}
$showAlert = false;
$showError = false;

?>
<?php
if(isset($_SESSION['success'])){
  $showAlert= true;
  unset($_SESSION['success']);
}
else if(isset($_SESSION['error'])){
  $showError= true;
  unset($_SESSION['error']);

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log Sheet</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">


    <link rel="stylesheet" href="tiles.css">
    <link rel="shortcut icon" href="favicon.jpg" type="image/x-icon">
</head>
<body>
<div class="navbar1">
        <div class="logo_fleet">
            <img src="logo_fe.png" alt="FLEET EIP" onclick="window.location.href='<?php echo $dashboard_url  ?>'">
        </div>
        <div class="iconcontainer">
            <ul>
                <li><a href="<?php echo $dashboard_url ?>">Dashboard</a></li>
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
      <span class="alertText_addfleet"><b>Success! 
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
    <div class="add_fleet_btn_new" id="rentalclientbutton" >
<button class="generate-btn"> 
    <article class="article-wrapper" onclick="window.location.href='logsheet.php'" id="rentalclientbuttoncontainer"> 
  <div class="rounded-lg container-projectss ">
    </div>
    <div class="project-info">
      <div class="flex-pr">
        <div class="project-title text-nowrap">Generate Log Sheet</div>
          <div class="project-hover">
            <svg style="color: black;" xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" color="black" stroke-linejoin="round" stroke-linecap="round" viewBox="0 0 24 24" stroke-width="2" fill="none" stroke="currentColor"><line y2="12" x2="19" y1="12" x1="5"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
            </div>
          </div>
          <div class="types">
        </div>
    </div>
</article>
    </button>

</div>

<?php 
include "partials/_dbconnect.php";
$sql="SELECT * FROM `logsheetnew`
WHERE companyname = '$companyname001'
  AND id IN (
      SELECT MAX(id) 
      FROM `logsheetnew`
      WHERE companyname = '$companyname001'
      GROUP BY assetcode, worefno
  )
ORDER BY `id` DESC";
$result=mysqli_query($conn,$sql);

if(mysqli_num_rows($result)>0){
    // Use a flexbox grid container instead of table
    echo '<div class="card-grid">';
    while($row=mysqli_fetch_assoc($result)){
        $id=$row['id'];
        ?>
            <div class="custom-card" id="application_card" onclick="window.location.href='monthlylogbook.php?assetcode=<?php echo urlencode($row['assetcode']); ?>&worefno=<?php echo urlencode($row['worefno']); ?>&clientname=<?php echo $row['clientname'] ?>&sitelocation=<?php echo $row['sitelocation'] ?>'">
            <h3 class="custom-card__title">Asset Code :<?php echo htmlspecialchars($row['assetcode']); ?></h3>
                    <p class="insidedetails">Equipment :<?php echo htmlspecialchars($row['equipmenttype'] .' ('. $row['make'] .')('. $row['model']) .')'; ?></p>
                    <p class="insidedetails">WO Ref :<?php echo htmlspecialchars($row['worefno']); ?></p>
                    <div class="insidedetails">Project  : <?php echo htmlspecialchars($row['projectname']); ?></div>
                    <div class="insidedetails">Site Location  : <?php echo htmlspecialchars($row['sitelocation']); ?></div>
<br>
                    <p class="insidedetails" id="button_container_resume">
                        <a href='deletelogbook.php?id=<?php echo urlencode($row['id']); ?>&assetcode=<?php echo $row['assetcode'] ?>&woref=<?php echo $row['worefno'] ?>&clientname=<?php echo $row['clientname'] ?>'>
                            <button title="Delete Complete Log Book" class="downloadresume" onclick="return confirmdelete()" type="button"><i class="fas fa-trash"></i>
                            </button>
                        </a>
                    </p>
                    <div class="custom-card__arrow">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </div>
        <?php
    }
    echo '</div>'; // Close card-grid
}
?>


</body>
<script>
    function confirmdelete(){
        return confirm("Are you sure you want to delete the complete log book this will delete log sheet of all the months for this asset code working at this specific project ?")
    }
</script>
<style>
.card-grid {
    display: flex;
    flex-wrap: wrap;
    gap: 32px;
    justify-content: flex-start;
    margin: 40px 0 0 0;
}
.custom-card {
    flex: 1 1 320px;
    max-width: 350px;
    min-width: 280px;
    box-sizing: border-box;
    margin-bottom: 32px;
}
@media (max-width: 1100px) {
    .custom-card {
        flex: 1 1 45%;
        max-width: 48%;
    }
}
@media (max-width: 700px) {
    .custom-card {
        flex: 1 1 100%;
        max-width: 100%;
    }
}
</style>
</html>