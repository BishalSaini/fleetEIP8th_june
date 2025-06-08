<?php
include 'partials/_dbconnect.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">      
    <link rel="icon" href="favicon.jpg" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="tiles.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <title>Document</title>
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
            <li><a href="logout.php">Log Out</a></li></ul>
        </div>
    </div> 
<!--     <div class="outercard">
            <div class="card_container1">
            <div class="button-52" onclick="location.href='quoted_pricerental.php'" > Quoted Price</div>
            <div class="button-52" onclick="location.href='notinterested_leads_listing.php'" >Not Interested Leads</div>
            <div class="button-52" onclick="location.href='view_req_rentalinner.php'" >View Leads</div>
            <div class="button-52" onclick="location.href='closed_rentalleads.php'" >Closed Leads</div>
             <div class="button-52" onclick="location.href='purchase.php'" >Purchase Requisition</div>
            <div class="button-52" onclick="location.href='view_req_rental.php'" >Requirements</div> 

        </div>  -->

        
  <div class="newtilecontainer">
<article class="article-wrapper" onclick="location.href='quoted_pricerental.php'">
  <div class="rounded-lg container-project price">
    </div>
    <div class="project-info">
      <div class="flex-pr">
        <div class="project-title text-nowrap">Quoted Price</div>
          <div class="project-hover">
            <svg style="color: black;" xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" color="black" stroke-linejoin="round" stroke-linecap="round" viewBox="0 0 24 24" stroke-width="2" fill="none" stroke="currentColor"><line y2="12" x2="19" y1="12" x1="5"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
            </div>
          </div>
          <div class="types">
            <span style="background-color: rgba(165, 96, 247, 0.43); color: rgb(85, 27, 177);" class="project-type">•View Price</span>
             <span class="project-type">• Edit Price</span>
        </div>
    </div>
</article>

<!-- <article class="article-wrapper" onclick="location.href='notinterested_leads_listing.php'">
  <div class="rounded-lg container-project bills_tile">
    </div>
    <div class="project-info">
      <div class="flex-pr">
        <div class="project-title text-nowrap">Not Interested Leads</div>
          <div class="project-hover">
            <svg style="color: black;" xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" color="black" stroke-linejoin="round" stroke-linecap="round" viewBox="0 0 24 24" stroke-width="2" fill="none" stroke="currentColor"><line y2="12" x2="19" y1="12" x1="5"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
            </div>
          </div>
          <div class="types">
            <span style="background-color: rgba(165, 96, 247, 0.43); color: rgb(85, 27, 177);" class="project-type">• Manage Bills</span>
             <span class="project-type">• Generate Bills</span>
        </div>
    </div>
</article> -->


<article class="article-wrapper" onClick="location.href='view_req_rentalinner.php'">
  <div class="rounded-lg container-project lead">
    </div>
    <div class="project-info">
      <div class="flex-pr">
        <div class="project-title text-nowrap">Leads</div>
          <div class="project-hover">
            <svg style="color: black;" xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" color="black" stroke-linejoin="round" stroke-linecap="round" viewBox="0 0 24 24" stroke-width="2" fill="none" stroke="currentColor"><line y2="12" x2="19" y1="12" x1="5"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
            </div>
          </div>
          <div class="types">
            <span style="background-color: rgba(165, 96, 247, 0.43); color: rgb(85, 27, 177)" class="project-tyep">• View Leads</span>
             <span class="project-tyep">• Not Interested Leads</span>
        </div>
    </div>
</article> 


<article class="article-wrapper" onClick="location.href='closed_rentalleads.php'">
  <div class="rounded-lg container-project close-lead">
    </div>
    <div class="project-info">
      <div class="flex-pr">
        <div class="project-title text-nowrap">Closed Leads</div>
          <div class="project-hover">
            <svg style="color: black;" xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" color="black" stroke-linejoin="round" stroke-linecap="round" viewBox="0 0 24 24" stroke-width="2" fill="none" stroke="currentColor"><line y2="12" x2="19" y1="12" x1="5"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
            </div>
          </div>
          <div class="types">
            <span style="background-color: rgba(165, 96, 247, 0.43); color: rgb(85, 27, 177);" class="project-type">• Open Bill</span>
             <span class="project-type">• Closed Bill</span>
        </div>
    </div>
</article>



</div>
 
</body>
</html>