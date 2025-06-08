<?php 
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="tiles.css">
    <link rel="shortcut icon" href="favicon.jpg" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complete Information</title>
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
    <div class="newtilecontainer">
    <article class="article-wrapper" onclick="location.href='viewcompanyteam.php?name=<?php echo urlencode($name); ?>'">
    <div class="rounded-lg container-project clients">
    </div>
    <div class="project-info">
      <div class="flex-pr">
        <div class="project-title text-nowrap">Team </div>
          <div class="project-hover">
            <svg style="color: black;" xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" color="black" stroke-linejoin="round" stroke-linecap="round" viewBox="0 0 24 24" stroke-width="2" fill="none" stroke="currentColor"><line y2="12" x2="19" y1="12" x1="5"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
            </div>
          </div>
          <div class="types">
            <span style="background-color: rgba(165, 96, 247, 0.43); color: rgb(85, 27, 177);" class="project-type">• Management </span>
             <span class="project-type">• Team </span>
        </div>
    </div>
</article>

<article class="article-wrapper" onClick="location.href='viewcompanyequipment.php?name=<?php echo urlencode($name); ?>'">
  <div class="rounded-lg container-project truck">
    </div>
    <div class="project-info">
      <div class="flex-pr">
        <div class="project-title text-nowrap">Equipments</div>
          <div class="project-hover">
            <svg style="color: black;" xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" color="black" stroke-linejoin="round" stroke-linecap="round" viewBox="0 0 24 24" stroke-width="2" fill="none" stroke="currentColor"><line y2="12" x2="19" y1="12" x1="5"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
            </div>
          </div>
          <div class="types">
            <span style="background-color: rgba(165, 96, 247, 0.43); color: rgb(85, 27, 177)" class="project-tyep">• Idle</span>
             <span class="project-tyep">• Working</span>
        </div>
    </div>
</article> 


<article class="article-wrapper" onClick="location.href='viewcompanyoperator.php?name=<?php echo urlencode($name); ?>'">
  <div class="rounded-lg container-project listing">
    </div>
    <div class="project-info">
      <div class="flex-pr">
        <div class="project-title text-nowrap">Operators</div>
          <div class="project-hover">
            <svg style="color: black;" xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" color="black" stroke-linejoin="round" stroke-linecap="round" viewBox="0 0 24 24" stroke-width="2" fill="none" stroke="currentColor"><line y2="12" x2="19" y1="12" x1="5"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
            </div>
          </div>
          <div class="types">
            <span style="background-color: rgba(165, 96, 247, 0.43); color: rgb(85, 27, 177);" class="project-type">• Idle</span>
             <span class="project-type">• Working</span>
        </div>
    </div>
</article>



</div>


</body>
</html>
