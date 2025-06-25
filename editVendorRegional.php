<?php
session_start();
include "partials/_dbconnect.php";

$regional_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$vendor_id = isset($_GET['vendorid']) ? intval($_GET['vendorid']) : 0;
$showSuccess = false;
$showError = false;

if ($regional_id > 0) {
    // Fetch existing data
    $sql = "SELECT * FROM vendor_regional_office WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $regional_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $regional = $result->fetch_assoc();
    $stmt->close();

    // Handle update
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_regional_office'])) {
        $office_address = $_POST['regional_office_address'];
        $state = $_POST['regional_office_state'];
        $contact_person = $_POST['regional_office_contact_person'];
        $contact_number = $_POST['regional_office_contact_number'];
        $contact_email = $_POST['regional_office_contact_email'];

        $sql_update = "UPDATE vendor_regional_office SET office_address=?, state=?, contact_person=?, contact_number=?, contact_email=? WHERE id=?";
        $stmt = $conn->prepare($sql_update);
        $stmt->bind_param("sssssi", $office_address, $state, $contact_person, $contact_number, $contact_email, $regional_id);
        if ($stmt->execute()) {
            $showSuccess = true;
            // Refresh data
            $regional['office_address'] = $office_address;
            $regional['state'] = $state;
            $regional['contact_person'] = $contact_person;
            $regional['contact_number'] = $contact_number;
            $regional['contact_email'] = $contact_email;
        } else {
            $showError = true;
        }
        $stmt->close();
    }
} else {
    $regional = null;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Vendor Regional Office</title>
    <link rel="stylesheet" href="style.css"> 
    
</head>
<body>
<div class="navbar1">
    <div class="logo_fleet">
        <img src="logo_fe.png" alt="FLEET EIP" onclick="window.location.href='rental_dashboard.php'">
    </div>
    <div class="iconcontainer">
        <ul>
            <li><a href="rental_dashboard.php">Dashboard</a></li>
            <li><a href="news/">News</a></li>
            <li><a href="logout.php">Log Out</a></li>
        </ul>
    </div>
</div>
<?php if ($showSuccess): ?>
    <div class="success-msg">Regional office updated successfully!</div>
<?php elseif ($showError): ?>
    <div class="error-msg">Failed to update regional office. Please try again.</div>
<?php endif; ?>

<?php if ($regional): ?>
    <form action="editVendorRegional.php" class="createregionaloffice" id="createregionalofficeform" method="POST" autocomplete="off" style="display: flex; margin-top: 20px;">
        <div class="rentalclientcontainer">
            <p class="headingpara" >Edit Regional Office</p>
            <div class="trial1" style="margin-bottom:16px;">
                <input type="text" placeholder="" name="regional_office_address" class="input02" required style="font-size:1.1rem;" value="<?php echo htmlspecialchars($regional['office_address']); ?>">
                <label for="" class="placeholder2">Regional Office Address</label>
            </div>
            <div class="trial1" style="margin-bottom:16px;">
                <select name="regional_office_state" class="input02" required style="font-size:1.1rem;">
                    <option value="" disabled>Select State</option>
                    <?php
                    $states = [
                        "Andaman and Nicobar Islands", "Andhra Pradesh", "Arunachal Pradesh", "Assam", "Bihar", "Chandigarh", "Chhattisgarh",
                        "Dadra and Nagar Haveli and Daman and Diu", "Delhi", "Goa", "Gujarat", "Haryana", "Himachal Pradesh", "Jammu and Kashmir",
                        "Jharkhand", "Karnataka", "Kerala", "Ladakh", "Lakshadweep", "Madhya Pradesh", "Maharashtra", "Manipur", "Meghalaya",
                        "Mizoram", "Nagaland", "Odisha", "Puducherry", "Punjab", "Rajasthan", "Sikkim", "Tamil Nadu", "Telangana", "Tripura",
                        "Uttar Pradesh", "Uttarakhand", "West Bengal"
                    ];
                    foreach ($states as $state) {
                        $selected = ($regional['state'] == $state) ? 'selected' : '';
                        echo "<option value=\"$state\" $selected>$state</option>";
                    }
                    ?>
                </select>
                <label for="" class="placeholder2">State</label>
            </div>
            <div class="trial1" style="margin-bottom:16px;">
                <input type="text" placeholder="" name="regional_office_contact_person" class="input02" required style="font-size:1.1rem;" value="<?php echo htmlspecialchars($regional['contact_person']); ?>">
                <label for="" class="placeholder2">Contact Person</label>
            </div>
            <div class="trial1" style="margin-bottom:16px;">
                <input type="text" placeholder="" name="regional_office_contact_number" class="input02" required style="font-size:1.1rem;" value="<?php echo htmlspecialchars($regional['contact_number']); ?>">
                <label for="" class="placeholder2">Contact Number</label>
            </div>
            <div class="trial1" style="margin-bottom:16px;">
                <input type="email" placeholder="" name="regional_office_contact_email" class="input02" required style="font-size:1.1rem;" value="<?php echo htmlspecialchars($regional['contact_email']); ?>">
                <label for="" class="placeholder2">Contact Email</label>
            </div>
            <button type="submit" name="update_regional_office" class="epc-button" >SUBMIT</button>
        </div>
    </form>
<?php else: ?>
    <div class="error-msg">Regional office not found.</div>
<?php endif; ?>
</body>
</html>
