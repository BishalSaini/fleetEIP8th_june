    <?php
include 'partials/_dbconnect.php';
session_start();
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

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="tiles.css">
    <link rel="shortcut icon" href="favicon.jpg" type="image/x-icon">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <title>Purchase Requisition</title>  
    <style> 
      .project-type{ 
        font-size:10px!important;
      }
    </style>

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
            <li><a href="logout.php">Log Out</a></li></ul>
        </div>
    </div> 

  <div class="newtilecontainer">
<article class="article-wrapper" onclick="location.href='purchase_requisition.php'">
  <div class="rounded-lg container-project equi"> 
    </div> 
    <div class="project-info">
      <div class="flex-pr">
        <div class="project-title text-nowrap">Equipment <br> <span class="project-title" style="font-size:16px;">Purchase Request</span> </div>
          <div class="project-hover">
            <svg style="color: black;" xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" color="black" stroke-linejoin="round" stroke-linecap="round" viewBox="0 0 24 24" stroke-width="2" fill="none" stroke="currentColor"><line y2="12" x2="19" y1="12" x1="5"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
            </div>
          </div>
          <div class="types">
            <span style="background-color: rgba(165, 96, 247, 0.43); color: rgb(85, 27, 177);" class="project-type">• Quotation Recieved</span>
             <span class="project-type">• Purchase New Fleet</span>
        </div>
    </div>
</article>

<article class="article-wrapper" onclick="location.href='recieved_quotation_logistics.php'" >
  <div class="rounded-lg container-project logi">
    </div>
    <div class="project-info">
      <div class="flex-pr">
        <div class="project-title text-nowrap">Logistics</div>
          <div class="project-hover">
            <svg style="color: black;" xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" color="black" stroke-linejoin="round" stroke-linecap="round" viewBox="0 0 24 24" stroke-width="2" fill="none" stroke="currentColor"><line y2="12" x2="19" y1="12" x1="5"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
            </div>
          </div>
          <div class="types">
            <span style="background-color: rgba(165, 96, 247, 0.43); color: rgb(85, 27, 177);" class="project-type">• Recieved Quotations</span>
             <span class="project-type">• Post Requirement</span>
        </div>
    </div>
</article>


<!-- <article class="article-wrapper"onclick="location.href='spare_parts.php'" >
  <div class="rounded-lg container-project consu">
    </div>
    <div class="project-info">
      <div class="flex-pr">
        <div class="project-title text-nowrap">Consumeable</div>
          <div class="project-hover">
            <svg style="color: black;" xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" color="black" stroke-linejoin="round" stroke-linecap="round" viewBox="0 0 24 24" stroke-width="2" fill="none" stroke="currentColor"><line y2="12" x2="19" y1="12" x1="5"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
            </div>
          </div>
          <div class="types">
            <span style="background-color: rgba(165, 96, 247, 0.43); color: rgb(85, 27, 177);" class="project-type">• Post Requirement</span>
             <span class="project-type">• Recieved Quotation</span>
        </div>
    </div>
</article>  -->

<!-- <article class="article-wrapper"onclick="location.href='quotation_recieved.php'" >
  <div class="rounded-lg container-project bill">
    </div>
    <div class="project-info">
      <div class="flex-pr">
        <div class="project-title text-nowrap">Quotation <br><span class="project-title" style="font-size:15px;"> Recieved </span></div>
          <div class="project-hover">
            <svg style="color: black;" xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" color="black" stroke-linejoin="round" stroke-linecap="round" viewBox="0 0 24 24" stroke-width="2" fill="none" stroke="currentColor"><line y2="12" x2="19" y1="12" x1="5"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
            </div>
          </div>
          <div class="types">
            <span style="background-color: rgba(165, 96, 247, 0.43); color: rgb(85, 27, 177);" class="project-type">• Post Requirement</span>
             <span class="project-type">• Closed Bill</span>
        </div>
    </div>
</article> -->



</div>
 
</body>
<style>
<?php include "style.css" ?>
</style>
<style>
<?php include "tile.css" ?>
</style>
<script>
    <?php include "main.js" ?>
    </script>
</html>