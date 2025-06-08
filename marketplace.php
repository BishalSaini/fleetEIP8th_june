<style>
  <?php include "style.css" 
  ?>
</style>
<script>
    <?php include "main.js" ?>
    </script>
    <?php
include 'partials/_dbconnect.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">      <link rel="icon" href="favicon.jpg" type="image/x-icon">
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
<!-- <div class="outercard">
            <div class="card_container_purchase">
            <div class="button-52" onclick="location.href='tets.php'" >Sell Fleet</div>
            <div class="button-52" onclick="location.href='buyusedfleet.php'" >Buy Fleet</div>
            <div class="button-52" onclick="location.href='view_listing_dashboard.php'" >View Listing</div>
        </div>  -->


        
  <div class="newtilecontainer">
<article class="article-wrapper" onclick="location.href='tets.php'" >
  <div class="rounded-lg container-project truck">
    </div>
    <div class="project-info">
      <div class="flex-pr">
        <div class="project-title text-nowrap">Sell Fleet</div>
          <div class="project-hover">
            <svg style="color: black;" xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" color="black" stroke-linejoin="round" stroke-linecap="round" viewBox="0 0 24 24" stroke-width="2" fill="none" stroke="currentColor"><line y2="12" x2="19" y1="12" x1="5"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
            </div>
          </div>
          <div class="types">
            <span style="background-color: rgba(165, 96, 247, 0.43); color: rgb(85, 27, 177);" class="project-type">• Equiment</span>
             <span class="project-type">• Sell Your Crane</span>
        </div>
    </div>
</article>

<article class="article-wrapper" onclick="location.href='buyusedfleet.php'"  >
  <div class="rounded-lg container-project buy">
    </div>
    <div class="project-info">
      <div class="flex-pr">
        <div class="project-title text-nowrap">Buy Fleet</div>
          <div class="project-hover">
            <svg style="color: black;" xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" color="black" stroke-linejoin="round" stroke-linecap="round" viewBox="0 0 24 24" stroke-width="2" fill="none" stroke="currentColor"><line y2="12" x2="19" y1="12" x1="5"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
            </div>
          </div>
          <div class="types">
            <span style="background-color: rgba(165, 96, 247, 0.43); color: rgb(85, 27, 177);" class="project-type">• Fleet</span>
             <span class="project-type">• Purchase Requisition</span>
        </div>
    </div>
</article>


<article class="article-wrapper"onclick="location.href='view_listing_dashboard.php'"  >
  <div class="rounded-lg container-project listing">
    </div>
    <div class="project-info">
      <div class="flex-pr">
        <div class="project-title text-nowrap">View Listing</div>
          <div class="project-hover">
            <svg style="color: black;" xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" color="black" stroke-linejoin="round" stroke-linecap="round" viewBox="0 0 24 24" stroke-width="2" fill="none" stroke="currentColor"><line y2="12" x2="19" y1="12" x1="5"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
            </div>
          </div>
          <div class="types">
            <span style="background-color: rgba(165, 96, 247, 0.43); color: rgb(85, 27, 177);" class="project-type">• Active Listing</span>
             <span class="project-type">• Sold Listing</span>
        </div>
    </div>
</article> 

</body>
</html>