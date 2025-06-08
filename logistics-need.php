<?php
session_start(); // Ensure session is started
$showAlert=false;
$showError=false;

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
    <link rel="icon" href="favicon.jpg" type="image/x-icon">
    <link rel="stylesheet" href="tiles.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="stylesheet" href="style.css"> <!-- Correctly include CSS file -->
    <title>Document</title>
</head>
<body>
    <div class="navbar1">
        <div class="logo_fleet">
            <img src="logo_fe.png" alt="FLEET EIP" onclick="window.location.href='logisticsdashboard.php'">
        </div>
        <div class="iconcontainer">
            <ul>
                <li><a href="logisticsdashboard.php">Dashboard</a></li>
                <!-- Uncomment and adjust as needed -->
                <!-- <li><a href="about_us.html">About Us</a></li> -->
                <!-- <li><a href="contact_us.php">Contact Us</a></li> -->
                <li><a href="logout.php">Log Out</a></li>
            </ul>
        </div>
    </div>
    <?php 
    if($showAlert){
        echo '<label>
        <input type="checkbox" class="alertCheckbox" autocomplete="off" />
        <div class="alert notice">
          <span class="alertClose">X</span>
          <span class="alertText">Success 
              <br class="clear"/></span>
        </div>
      </label>';
     }
 if($showError){
    echo '<label>
    <input type="checkbox" class="alertCheckbox" autocomplete="off" />
    <div class="alert error">
        <span class="alertClose">X</span>
        <span class="alertText">Something Went Wrong<br class="clear"/></span>
    </div>
    </label>';
}


?>

    <div class="add_fleet_btn_new" id="logiquotedprice">
<button class="generate-btn"> 
    <article class="article-wrapper" onclick="window.location.href='quoted_price_logistics.php'" id="logi_quotebtn"> 
  <div class="rounded-lg container-projectss ">
    </div>
    <div class="project-info">
      <div class="flex-pr">
        <div class="project-title text-nowrap">Quoted Price</div>
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
    include_once 'partials/_dbconnect.php'; // Include the database connection file

    // Query database
    $result = mysqli_query($conn, "SELECT ln.*
    FROM logistics_need ln
    LEFT JOIN logi_price_quoted lpq ON ln.id = lpq.req_no
    WHERE lpq.req_no IS NULL");

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
                <div class="custom-card" id="application_card"  onclick="window.location.href='quote_price_logi.php?id=<?php echo $row['id']; ?>'">
                <h3 class="custom-card__title"><?php echo htmlspecialchars($row['type_of_requirement']); ?></h3>
                <p class="insidedetails"><?php echo htmlspecialchars($row['from'].' - ' . $row['to']); ?></p>
                    <p class="insidedetails">Material: <?php echo htmlspecialchars($row['material_detail'] ) ?></p>
                    <p class="insidedetails">Company: <?php echo htmlspecialchars($row['companyname_need_generator'] ); ?></p>
                    <p class="insidedetails">Last Date: <?php echo htmlspecialchars($row['requirement_valid_till']); ?></p>
                    <p class="insidedetails">Trailors: <?php echo htmlspecialchars($row['number_of_trailor']); ?></p>

                    <!-- <p class="insidedetails" id="button_container_resume"> -->
                        <!-- <a title="View And Quote Price" href='view_quoteprice_rental.php?id=<?php echo $row['id']; ?>'>
                            <button class="downloadresume" type="button"><i class="fa-regular fa-eye"></i></button>
                        </a> -->
                        <!-- <a title="Not Interested" id="" onclick="notinterested()">
                            <button class="downloadresume" type="button"><i class="fa-solid fa-eye"></i></button>
                        </a>
                    </p> -->

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

    <!-- Include JavaScript files correctly -->
    <script src="main.js"></script>
</body>
</html>
