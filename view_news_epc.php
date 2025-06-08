
<style>
  <?php include "style.css" 
  ?>
</style>
<?php
include 'partials/_dbconnect.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">      <link rel="icon" href="favicon.jpg" type="image/x-icon">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News</title>
</head>
<body>
    <div class="navbar1">
    <div class="logo_fleet">
    <img src="logo_fe.png" alt="FLEET EIP" onclick="window.location.href='<?php echo $dashboard_url  ?>'">
</div>

        <div class="iconcontainer">
        <ul>
        <li><a href="epc_dashboard.php">Dashboard</a></li>
            <li><a href="view_news_epc.php">News</a></li>

            <li><a href="logout.php">Log Out</a></li></ul>
        </div>
    </div> 
    <!-- <h2 class=newsheading>News</h2> -->
    <table class="newstable">
        <tr>
            <?php
                    include_once 'partials/_dbconnect.php'; // Include the database connection file

                    $result = mysqli_query($conn, "SELECT * FROM news order by sno desc ");
                    $loop_count = 1;
                    while ($row = mysqli_fetch_assoc($result)) {
                        // Display member information within a <td>
                        echo '<td>';
                        echo '<br>';

                        echo '<div class="news_card">';
                        echo '<div class="news_image">';
                        echo "<img class='news_image1' src='img/" . $row['news_image'] . "' >";   
                        echo '</div>';

                        echo '<h2 class="news_head"><p><b>' . $row['news_head'] . '</b></p></h2>';
                        echo '<hr>';
                        echo '<br>';

                        echo '<p class="news_head1"><p class="content_news"><b>' . $row['news_content'] . '</b></p></p>';
                        echo '</td>';
                        // echo '<br>';
                        echo '</div>';

                        if ($loop_count > 0 && $loop_count % 2 == 0) {
                            echo '</tr><tr>';
                        }
            
                        $loop_count++;
                    }





            
            ?>
        </tr>
    </table>

    
</body>
</html>