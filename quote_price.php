<?php
session_start();
$email = $_SESSION["email"];

?>


<?php
include 'partials/_dbconnect.php';
// $row = array(); // Initialize $row as an empty array

// if (isset($_GET["id"]) && !empty($_GET["id"])) {
//     $id = $_GET["id"];
//     $sql = "SELECT * FROM quote_required WHERE id = $id";
//     $result = mysqli_query($conn, $sql);

//     if(mysqli_num_rows($result) > 0) {
//         $row = mysqli_fetch_assoc($result);
//     }
// }

$row = array(); // Initialize $row as an empty array

if (isset($_GET["id"]) && !empty($_GET["id"])) {
    $id = $_GET["id"];
    $sql = "SELECT * FROM quote_required WHERE id = $id";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['edit01']) && !empty($_POST['edit01'])) {
        $editid = $_POST['edit01'];
        $price_quote = $_POST['price'];
        $oem_contact_number = $_POST['oem_contact_number'];
        $oem_email = $_POST['oem_email'];

        $sql1 = "UPDATE quote_required SET price='$price_quote' , oem_contact_number='$oem_contact_number' , oem_email='$email' WHERE id = '$editid'";   
        $result123 = mysqli_query($conn, $sql1);

        if ($result123) {
            header("location:oem_requirement.php");
        }
         else {
            // Failed to update
            echo "Error updating price: " . mysqli_error($conn);
        }
    }
}
?>

<script>
    <?php include "main.js" ?>
    </script>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">      <link rel="icon" href="favicon.jpg" type="image/x-icon">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Request A Quote</title>
</head>
<body>
        <div class="navbar1">
    <div class="logo_fleet">
    <img src="logo_fe.png" alt="FLEET EIP" onclick="window.location.href='<?php echo $dashboard_url  ?>'">
</div>

        <div class="iconcontainer">
            <ul>
            <li><a href="oem_dashboard.php">Dashboard</a></li>
            <li><a href="news/">News</a></li>
            <li><a href="logout.php">LogOut</a></li>
            </ul>
        </div>
    </div>

    <form action="quote_price.php" method="POST" class="request_quoteform">
        <div class="request_quote_innercontainer">
            <div class="quotehead"><p>Quote A Price</p></div>
            <div class="trial1">
                <input type="text" class="input02" placeholder="" value="<?php echo $id; ?>" name="edit01" readonly hidden>
                <label class="placeholder2" hidden>id</label>
            </div>
            <div class="trial1">
                <input type="text" class="input02" placeholder="" value="<?php echo $row['oem_company']; ?>" name="companyname" readonly>
                <label class="placeholder2">OEM Company name</label>
            </div>
            <div class="trial1">
                <input type="text" class="input02" placeholder="" value="<?php echo $row['fleet_category']; ?>" name="fleet_category" readonly>
                <label class="placeholder2">Fleet Category</label>
            </div>
            <div class="trial1">
                <input type="text" class="input02" placeholder="" value="<?php echo $row['fleet_type']; ?>" name="fleet_type" readonly>
                <label class="placeholder2">Fleet Type</label>
            </div>
            <div class="trial1">
                <input type="text" class="input02" placeholder="" value="<?php echo $row['fleet_capacity']; ?>" name="fleet_cap" readonly>
                <label class="placeholder2">Fleet Capacity</label>
            </div>
            <div class="trial1">
                <input type="text" class="input02" placeholder="" value="<?php echo $row['project_location']; ?>" name="project_location">
                <label class="placeholder2">Project Location</label>
            </div>
            <div class="trial1">
                <input type="text" class="input02" placeholder="" value="<?php echo $row['contact_number']; ?>" name="contact_no">
                <label class="placeholder2"> Rental Contact Number</label>
            </div>
            <div class="trial1">
                <input type="text" class="input02" placeholder="" value="<?php echo $row['email']; ?>" name="email" readonly>
                <label class="placeholder2"> Rental Email</label>
            </div>
            <div class="trial1">
                <input type="text" class="input02" placeholder="" value="<?php echo $row['company name']; ?>" name="company_name">
                <label class="placeholder2">Rental Company Name</label>
            </div>
            <div class="trial1">
                <input type="text" class="input02" placeholder="" value="<?php echo $row['more specifics']; ?>" name="specs">
                <label class="placeholder2">More Specifics</label>
            </div>
            <div class="trial1">
                <input type="text" class="input02" placeholder="" value="<?php echo $row['price']; ?>" name="price">
                <label class="placeholder2">Quote A Price</label>
            </div>
            <div class="trial1">
                <input type="text" class="input02" placeholder="" value="<?php echo $row['oem_contact_number']; ?>" name="oem_contact_number">
                <label class="placeholder2">Contact Number</label>
            </div>
            <div class="trial1">
                <input type="text" class="input02" placeholder="" value="<?php echo $email; ?>" name="oem_email">
                <label class="placeholder2">Contact Email</label>
            </div>
            <button type="submit" name="submit" class="epc-button">Submit</button>
            <br>
        </div>
    </form>
</body>
</html>