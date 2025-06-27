<?php
session_start();
include "partials/_dbconnect.php";

$regional_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$vendor_id = isset($_GET['vendorid']) ? intval($_GET['vendorid']) : 0;
$showSuccess = isset($_GET['success']) && $_GET['success'] == 1;
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
        // Get id from POST for update
        $regional_id_post = isset($_POST['id']) ? intval($_POST['id']) : $regional_id;

        $sql_update = "UPDATE vendor_regional_office SET office_address=?, state=?, contact_person=?, contact_number=?, contact_email=? WHERE id=?";
        $stmt = $conn->prepare($sql_update);
        $stmt->bind_param("sssssi", $office_address, $state, $contact_person, $contact_number, $contact_email, $regional_id_post);
        if ($stmt->execute()) {
            // Redirect to same page with success message
            header("Location: editVendorRegional.php?id=$regional_id_post&vendorid=$vendor_id&success=1");
            exit();
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
    <style>
        .modal-msg {
            position: fixed;
            right: 30px;
            bottom: 30px;
            min-width: 280px;
            max-width: 350px;
            z-index: 9999;
            border-radius: 8px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.13);
            padding: 18px 28px;
            font-size: 1.05rem;
            display: flex;
            align-items: center;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s;
        }
        .modal-msg.show {
            opacity: 1;
            pointer-events: auto;
        }
        .modal-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .modal-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .modal-msg .close-btn {
            margin-left: auto;
            background: none;
            border: none;
            color: inherit;
            font-size: 1.2rem;
            cursor: pointer;
        }
    </style>
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

<div id="modalMsg" class="modal-msg<?php if ($showSuccess) echo ' modal-success show'; elseif ($showError) echo ' modal-error show'; ?>">
    <?php if ($showSuccess): ?>
        Regional office updated successfully!
    <?php elseif ($showError): ?>
        Failed to update regional office. Please try again.
    <?php endif; ?>
    <button class="close-btn" onclick="hideModalMsg()" aria-label="Close">&times;</button>
</div>

<script>
    function hideModalMsg() {
        var modal = document.getElementById('modalMsg');
        if (modal) modal.classList.remove('show');
    }
    window.onload = function() {
        var modal = document.getElementById('modalMsg');
        if (modal && modal.classList.contains('show')) {
            setTimeout(hideModalMsg, 5000);
        }
    }
</script>

<?php if ($regional): ?>
    <form action="editVendorRegional.php?id=<?php echo $regional_id; ?>&vendorid=<?php echo $vendor_id; ?>" class="createregionaloffice" id="createregionalofficeform" method="POST" autocomplete="off" style="display: flex; margin-top: 20px;">
        <input type="hidden" name="id" value="<?php echo $regional_id; ?>">
        <input type="hidden" name="vendorid" value="<?php echo $vendor_id; ?>">
        <div class="rentalclientcontainer">
            <p class="headingpara" >Edit Regional Office</p>
            <div class="trial1" style="margin-bottom:16px;">
                <input type="text" placeholder="" name="regional_office_address" class="input02" required style="font-size:1.1rem;" value="<?php echo htmlspecialchars($regional['office_address']); ?>">
                <label for="" class="placeholder2">Regional Office Address</label>
            </div>
            <div class="trial1" style="margin-bottom:16px;">
                <select name="regional_office_state" class="input02" required style="font-size:1.1rem;">
                    <option value="" <?php echo ($regional['state'] == '') ? 'selected' : ''; ?>>Select State</option>
                    <option value="Andaman and Nicobar Islands" <?php echo ($regional['state'] == 'Andaman and Nicobar Islands') ? 'selected' : ''; ?>>Andaman and Nicobar Islands</option>
                    <option value="Andhra Pradesh" <?php echo ($regional['state'] == 'Andhra Pradesh') ? 'selected' : ''; ?>>Andhra Pradesh</option>
                    <option value="Arunachal Pradesh" <?php echo ($regional['state'] == 'Arunachal Pradesh') ? 'selected' : ''; ?>>Arunachal Pradesh</option>
                    <option value="Assam" <?php echo ($regional['state'] == 'Assam') ? 'selected' : ''; ?>>Assam</option>
                    <option value="Bihar" <?php echo ($regional['state'] == 'Bihar') ? 'selected' : ''; ?>>Bihar</option>
                    <option value="Chandigarh" <?php echo ($regional['state'] == 'Chandigarh') ? 'selected' : ''; ?>>Chandigarh</option>
                    <option value="Chhattisgarh" <?php echo ($regional['state'] == 'Chhattisgarh') ? 'selected' : ''; ?>>Chhattisgarh</option>
                    <option value="Dadra and Nagar Haveli and Daman and Diu" <?php echo ($regional['state'] == 'Dadra and Nagar Haveli and Daman and Diu') ? 'selected' : ''; ?>>Dadra and Nagar Haveli and Daman and Diu</option>
                    <option value="Delhi" <?php echo ($regional['state'] == 'Delhi') ? 'selected' : ''; ?>>Delhi</option>
                    <option value="Goa" <?php echo ($regional['state'] == 'Goa') ? 'selected' : ''; ?>>Goa</option>
                    <option value="Gujarat" <?php echo ($regional['state'] == 'Gujarat') ? 'selected' : ''; ?>>Gujarat</option>
                    <option value="Haryana" <?php echo ($regional['state'] == 'Haryana') ? 'selected' : ''; ?>>Haryana</option>
                    <option value="Himachal Pradesh" <?php echo ($regional['state'] == 'Himachal Pradesh') ? 'selected' : ''; ?>>Himachal Pradesh</option>
                    <option value="Jammu and Kashmir" <?php echo ($regional['state'] == 'Jammu and Kashmir') ? 'selected' : ''; ?>>Jammu and Kashmir</option>
                    <option value="Jharkhand" <?php echo ($regional['state'] == 'Jharkhand') ? 'selected' : ''; ?>>Jharkhand</option>
                    <option value="Karnataka" <?php echo ($regional['state'] == 'Karnataka') ? 'selected' : ''; ?>>Karnataka</option>
                    <option value="Kerala" <?php echo ($regional['state'] == 'Kerala') ? 'selected' : ''; ?>>Kerala</option>
                    <option value="Ladakh" <?php echo ($regional['state'] == 'Ladakh') ? 'selected' : ''; ?>>Ladakh</option>
                    <option value="Lakshadweep" <?php echo ($regional['state'] == 'Lakshadweep') ? 'selected' : ''; ?>>Lakshadweep</option>
                    <option value="Madhya Pradesh" <?php echo ($regional['state'] == 'Madhya Pradesh') ? 'selected' : ''; ?>>Madhya Pradesh</option>
                    <option value="Maharashtra" <?php echo ($regional['state'] == 'Maharashtra') ? 'selected' : ''; ?>>Maharashtra</option>
                    <option value="Manipur" <?php echo ($regional['state'] == 'Manipur') ? 'selected' : ''; ?>>Manipur</option>
                    <option value="Meghalaya" <?php echo ($regional['state'] == 'Meghalaya') ? 'selected' : ''; ?>>Meghalaya</option>
                    <option value="Mizoram" <?php echo ($regional['state'] == 'Mizoram') ? 'selected' : ''; ?>>Mizoram</option>
                    <option value="Nagaland" <?php echo ($regional['state'] == 'Nagaland') ? 'selected' : ''; ?>>Nagaland</option>
                    <option value="Odisha" <?php echo ($regional['state'] == 'Odisha') ? 'selected' : ''; ?>>Odisha</option>
                    <option value="Puducherry" <?php echo ($regional['state'] == 'Puducherry') ? 'selected' : ''; ?>>Puducherry</option>
                    <option value="Punjab" <?php echo ($regional['state'] == 'Punjab') ? 'selected' : ''; ?>>Punjab</option>
                    <option value="Rajasthan" <?php echo ($regional['state'] == 'Rajasthan') ? 'selected' : ''; ?>>Rajasthan</option>
                    <option value="Sikkim" <?php echo ($regional['state'] == 'Sikkim') ? 'selected' : ''; ?>>Sikkim</option>
                    <option value="Tamil Nadu" <?php echo ($regional['state'] == 'Tamil Nadu') ? 'selected' : ''; ?>>Tamil Nadu</option>
                    <option value="Telangana" <?php echo ($regional['state'] == 'Telangana') ? 'selected' : ''; ?>>Telangana</option>
                    <option value="Tripura" <?php echo ($regional['state'] == 'Tripura') ? 'selected' : ''; ?>>Tripura</option>
                    <option value="Uttar Pradesh" <?php echo ($regional['state'] == 'Uttar Pradesh') ? 'selected' : ''; ?>>Uttar Pradesh</option>
                    <option value="Uttarakhand" <?php echo ($regional['state'] == 'Uttarakhand') ? 'selected' : ''; ?>>Uttarakhand</option>
                    <option value="West Bengal" <?php echo ($regional['state'] == 'West Bengal') ? 'selected' : ''; ?>>West Bengal</option>
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
<?php 
    else: 
?>
    <div class="modal-msg modal-error show" id="modalMsgError">
        Regional office not found.
        <button class="close-btn" onclick="document.getElementById('modalMsgError').classList.remove('show')" aria-label="Close">&times;</button>
    </div>
    <script>
        window.onload = function() {
            var modal = document.getElementById('modalMsgError');
            if (modal) setTimeout(function(){ modal.classList.remove('show'); }, 5000);
        }
    </script>
<?php 
    endif; 
?>
</body>
</html>
