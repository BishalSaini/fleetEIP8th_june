<?php
session_start();
$email = $_SESSION["email"];
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

include 'partials/_dbconnect.php';
?>
<?php 
$showAlert=false;
if(isset($_SESSION['success'])){
  $showAlert=true;
  unset($_SESSION['success']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="favicon.jpg" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        <?php include "style.css"; ?>
    </style>
</head>
<body>
    <div class="navbar1">
        <div class="logo_fleet">
            <img src="logo_fe.png" alt="FLEET EIP" onclick="window.location.href='<?php echo $dashboard_url ?>'">
        </div>
        <div class="iconcontainer">
            <ul>
                <li><a href="<?php echo $dashboard_url ?>">Dashboard</a></li>
                <li><a href="news/">News</a></li>
                <li><a href="logout.php">Log Out</a></li>
            </ul>
        </div>
    </div>
    <?php
    if($showAlert){
		echo  '<label>
        <input type="checkbox" class="alertCheckbox" autocomplete="off" />
        <div class="alert notice">
          <span class="alertClose">X</span>
          <span class="alertText_addfleet"><b>Success!</b>Listing Added To Sold Section Successfully
              <br class="clear"/></span>
        </div>
      </label>';
    }
    ?> 

    <?php
    $result = mysqli_query($conn, "SELECT * FROM `images` WHERE `companyname`='$companyname001' ORDER BY id DESC");
    if (mysqli_num_rows($result) > 0) {
        echo '<table class="purchase_table" id="logi_rates"><tr>';

        $loop_count = 1; // Initialize the counter

        while ($row = mysqli_fetch_assoc($result)) {
            if ($loop_count > 0 && $loop_count % 4 == 0) {
                echo '</tr><tr>'; // Close the current row and start a new one after every 4 items
            }
            ?>
            <td>
                <div class="custom-card" id="application_card">
                    <h3 class="custom-card__title"><?php echo htmlspecialchars($row['sub_type']); ?></h3>
                    <p class="insidedetails">Capacity : <?php echo htmlspecialchars($row['capacity']); ?></p>
                    <p class="insidedetails">YOM : <?php echo htmlspecialchars($row['yom']); ?></p>
                    <div class="insidedetails">Price : <?php echo htmlspecialchars($row['price']); ?></div>
                    <p class="insidedetails" id="button_container_resume">
                        <a href='edit_listing.php?id=<?php echo urlencode($row['id']); ?>'>
                            <button title="Edit" class="downloadresume" type="button"><i class="fa-regular fa-eye"></i></button>
                        </a>
                        <a href='javascript:void(0)'>
                            <button title="Mark As Sold" onclick='openPopup1(<?php echo intval($row['id']); ?>)' class="downloadresume" type="button"><i class="fa-solid fa-check-circle"></i></button>
                        </a>
                    </p>
                    <div class="custom-card__arrow">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </div>
            </td>
            <?php
            $loop_count++; ?>
        


    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <h4>Are you sure you want to delete this listing?</h4>
            <div class="btn_delete01">
                <a class='btn_listing' href='delete_listing.php?id=<?php echo urlencode($row['id']); ?>'>Confirm Delete</a>
                <a class='btn_listing' href='view_listing.php'>Cancel</a>
            </div>
        </div>
    </div>

    <div id="soldModel" class="modal1">
        <div class="modal-content">
            <select name="sold_platform" id="sold_platform" class="input02" required>
                <option value="" disabled selected>Mark As Sold Reason</option>
                <option value="Listing Sold Through Fleet EIP">Listing Sold Through Fleet EIP</option>
                <option value="Sold Through Other Platform">Sold Through Other Platform</option>
                <option value="Sold Offline">Sold Offline</option>
                <option value="Not Selling Anymore">Not Selling Anymore</option>
            </select>
            <div class="confirmsoldbutton">
                <a class="downloadresume" id="confirmSoldLink" href='javascript:void(0)'>
                    <i class="fa-solid fa-thumbs-up" title="Confirm"></i>
                </a>
                <a class="downloadresume" href='view_listing.php'>
                    <i class="fa-solid fa-xmark" title="Cancel"></i>
                </a>
            </div>
        </div>
    </div>
    <?php  
    }
    echo '</tr></table>';
    }
    ?>

    <script>
        function openPopup1(id) {
            // Show the popup
            document.getElementById("soldModel").style.display = "block";

            // Update the confirm button with the correct URL
            document.getElementById("confirmSoldLink").onclick = function() {
                confirmSold(id);
            };
        }

        function confirmSold(id) {
            const soldItem = document.getElementById("sold_platform").value;
            window.location.href = 'sold_items.php?id=' + id + '&soldItem=' + encodeURIComponent(soldItem);
        }
    </script>
</body>
</html>
