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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="tiles.css">

    <title>Dashboard</title>
</head>
<body>
    <div class="navbar1">
    <div class="logo_fleet">
    <img src="logo_fe.png" alt="FLEET EIP" onclick="window.location.href='epc_dashboard.php'">
</div>

        <div class="iconcontainer">
        <ul>
            <li><a href="epc_dashboard.php">Dashboard</a></li>
            <!-- <li><a href="view_news_epc.php">News</a></li> -->
            
            <li><a href="logout.php">Log Out</a></li></ul>
        </div>
    </div> 
    <!-- <div class="outercard">
            <div class="card_container1">
            <div class="button-52" onclick="location.href='quote_byrental_to_epc.php'" >Quotation Recieved</div>
            <div class="button-52" onclick="location.href='epc_requirements.php'" >Post Requirement</div>
            <div class="button-52" onclick="location.href='requirementlisting.php'" >View My Requirements</div>
            <div class="button-52" onclick="location.href='view_closed_requirement_epc.php'" >Closed Requirements</div>
        </div> -->
        <div class="newtilecontainer">
<article class="article-wrapper" onclick="location.href='epc_requirements.php'">
  <div class="rounded-lg container-project equi"> 
    </div> 
    <div class="project-info">
      <div class="flex-pr">
        <div class="project-title text-nowrap">Post<br> <span class="project-title" style="font-size:16px;">Requirement</span> </div>
          <div class="project-hover">
            <svg style="color: black;" xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" color="black" stroke-linejoin="round" stroke-linecap="round" viewBox="0 0 24 24" stroke-width="2" fill="none" stroke="currentColor"><line y2="12" x2="19" y1="12" x1="5"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
            </div>
          </div>
          <div class="types">
            <span style="background-color: rgba(165, 96, 247, 0.43); color: rgb(85, 27, 177);" class="project-type">• Rental Requirement</span>
             <!-- <span class="project-type">• Purchase New Fleet</span> -->
        </div>
    </div>
</article>

<article class="article-wrapper" onclick="location.href='requirementlisting.php'" >
  <div class="rounded-lg container-project logi">
    </div>
    <div class="project-info">
      <div class="flex-pr">
        <div class="project-title text-nowrap">My <br> <span class="project-title" style="font-size:16px;">Requirements</span> </div>
          <div class="project-hover">
            <svg style="color: black;" xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" color="black" stroke-linejoin="round" stroke-linecap="round" viewBox="0 0 24 24" stroke-width="2" fill="none" stroke="currentColor"><line y2="12" x2="19" y1="12" x1="5"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
            </div>
          </div>
          <div class="types">
            <span style="background-color: rgba(165, 96, 247, 0.43); color: rgb(85, 27, 177);" class="project-type">• Closed Req</span>
             <span class="project-type">• Delete Req</span>
        </div>
    </div>
</article>


<article class="article-wrapper"onclick="location.href='spare_parts.php'" >
  <div class="rounded-lg container-project consu">
    </div>
    <div class="project-info">
      <div class="flex-pr">
        <div class="project-title text-nowrap">Quotation <br> <span class="project-title" style="font-size:16px;">Recieved</span> </div>
          <div class="project-hover">
            <svg style="color: black;" xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" color="black" stroke-linejoin="round" stroke-linecap="round" viewBox="0 0 24 24" stroke-width="2" fill="none" stroke="currentColor"><line y2="12" x2="19" y1="12" x1="5"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
            </div>
          </div>
          <div class="types">
            <span style="background-color: rgba(165, 96, 247, 0.43); color: rgb(85, 27, 177);" class="project-type">• Recieved Quotation</span>
             <!-- <span class="project-type">• Recieved Quotation</span> -->
        </div>
    </div>
</article> 

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
</html>