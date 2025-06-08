<?php
session_start();
include "partials/_dbconnect.php";

$vendor_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$vendor = null;

if ($vendor_id > 0) {
    $sql = "SELECT * FROM vendors WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $vendor_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $vendor = $result->fetch_assoc();
    $stmt->close();
}

// Handle regional office form submission
$showSuccess = false;
$showError = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['regional_office_submit'])) {
    $office_address = $_POST['regional_office_address'];
    $state = $_POST['regional_office_state'];
    $contact_person = $_POST['regional_office_contact_person'];
    $contact_number = $_POST['regional_office_contact_number'];
    $contact_email = $_POST['regional_office_contact_email'];

    $sql_insert = "INSERT INTO vendor_regional_office (vendor_id, office_address, state, contact_person, contact_number, contact_email) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql_insert);
    $stmt->bind_param("isssss", $vendor_id, $office_address, $state, $contact_person, $contact_number, $contact_email);
    if ($stmt->execute()) {
        $showSuccess = true;
    } else {
        $showError = true;
    }
    $stmt->close();
}

// Handle product form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_submit'])) {
    $product_serial = $_POST['product_serial'];
    $product_name = $_POST['product_name'];
    $product_uom = $_POST['product_uom'];
    $unit_price = $_POST['unit_price'];
    $qty = $_POST['qty'];

    $sql_product_insert = "INSERT INTO vendor_products (vendor_id, product_serial, product_name, product_uom, unit_price, qty) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt_product = $conn->prepare($sql_product_insert);
    $stmt_product->bind_param("isssdi", $vendor_id, $product_serial, $product_name, $product_uom, $unit_price, $qty);
    $stmt_product->execute();
    $stmt_product->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Vendor Regional Office</title>
    <link rel="stylesheet" href="style.css"> 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style> 
    .vendorform {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .vendor-detail-container {
            max-width: 500px;
            margin: 40px auto;
            padding: 24px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background: #fafbfc;
        }
        .vendor-detail-container h2 {
            margin-top: 0;
        }
        .vendor-detail-container p {
            margin: 8px 0;
        }
        .regional-office-btn {
            display: block;
            margin: 24px auto 12px auto;
            padding: 10px 24px;
            background: #4067B5;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-weight: 600;
            cursor: pointer;
        }
        .regional-office-form {
            display: none;
            max-width: 500px;
            margin: 0 auto 24px auto;
            padding: 20px;
            border: 1px solid #b4c5e4;
            border-radius: 8px;
            background: #f5f7fa;
        }
        .regional-office-form input,
        .regional-office-form select {
            width: 100%;
            padding: 8px;
            margin-bottom: 14px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .regional-office-form label {
            font-weight: 500;
            margin-bottom: 4px;
            display: block;
        }
        .success-msg {
            color: green;
            text-align: center;
        }
        .error-msg {
            color: red;
            text-align: center;
        } 
    </style>
    <script>
        function toggleRegionalOfficeForm() {
            var form = document.getElementById('regionalOfficeForm');
            form.style.display = (form.style.display === 'block') ? 'none' : 'block';
        }
        function toggleProductForm() {
            var form = document.getElementById('productForm');
            form.style.display = (form.style.display === 'block') ? 'none' : 'block';
        }
    </script>
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

<!-- <div class="vendor-detail-container">
    <?php if ($vendor): ?>
        <h2><?php echo htmlspecialchars($vendor['vendor_name']); ?></h2>
        <p><strong>Category:</strong> <?php echo htmlspecialchars($vendor['vendor_category']); ?></p>
        <p><strong>Code:</strong> <?php echo htmlspecialchars($vendor['vendor_code']); ?></p>
        <p><strong>Office Address:</strong> <?php echo htmlspecialchars($vendor['office_address']); ?></p>
    <?php else: ?>
        <p>Vendor not found.</p>
    <?php endif; ?>
</div> -->


<?php if ($showSuccess): ?>
    <div class="success-msg">Regional office created successfully!</div>
<?php elseif ($showError): ?>
    <div class="error-msg">Failed to create regional office. Please try again.</div>
<?php endif; ?>

<?php if ($vendor): ?>
    <div style="display: flex; flex-direction: column; align-items: center;">
        <div style="display: flex; flex-direction: row; gap: 16px; margin:24px 0 12px 0;">
            <button class="regional-office-btn" onclick="toggleRegionalOfficeForm()" style="min-width:220px; margin:0;">
                Create Regional Office
            </button>
            <button class="regional-office-btn" onclick="toggleProductForm()" style="min-width:220px; background:#2253a3; margin:0;">
                Add Product
            </button>
        </div>
        <form id="regionalOfficeForm" class="vendorform" method="POST" autocomplete="off" style="display:none; margin-top: 20px;">
            <div class="rentalclientcontainer" style="min-width:420px; max-width:520px; padding: 32px 32px 24px 32px;">
                <p class="headingpara" style="background:#2253a3;color:#fff;padding:16px 0 12px 18px;border-radius:2px 2px 0 0;margin:-16px -16px 24px -16px;font-size:1.15rem;font-weight:600;">Add Regional Office</p>
                <div class="trial1" style="margin-bottom:16px;">
                    <input type="text" placeholder="" name="regional_office_address" class="input02" required style="font-size:1.1rem;">
                    <label for="" class="placeholder2">Regional Office Address</label>
                </div>
                <div class="trial1" style="margin-bottom:16px;">
                    <select name="regional_office_state" class="input02" required style="font-size:1.1rem;">
                        <option value="" disabled selected>Select State</option>
                        <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
                        <option value="Andhra Pradesh">Andhra Pradesh</option>
                        <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                        <option value="Assam">Assam</option>
                        <option value="Bihar">Bihar</option>
                        <option value="Chandigarh">Chandigarh</option>
                        <option value="Chhattisgarh">Chhattisgarh</option>
                        <option value="Dadra and Nagar Haveli and Daman and Diu">Dadra and Nagar Haveli and Daman and Diu</option>
                        <option value="Delhi">Delhi</option>
                        <option value="Goa">Goa</option>
                        <option value="Gujarat">Gujarat</option>
                        <option value="Haryana">Haryana</option>
                        <option value="Himachal Pradesh">Himachal Pradesh</option>
                        <option value="Jammu and Kashmir">Jammu and Kashmir</option>
                        <option value="Jharkhand">Jharkhand</option>
                        <option value="Karnataka">Karnataka</option>
                        <option value="Kerala">Kerala</option>
                        <option value="Ladakh">Ladakh</option>
                        <option value="Lakshadweep">Lakshadweep</option>
                        <option value="Madhya Pradesh">Madhya Pradesh</option>
                        <option value="Maharashtra">Maharashtra</option>
                        <option value="Manipur">Manipur</option>
                        <option value="Meghalaya">Meghalaya</option>
                        <option value="Mizoram">Mizoram</option>
                        <option value="Nagaland">Nagaland</option>
                        <option value="Odisha">Odisha</option>
                        <option value="Puducherry">Puducherry</option>
                        <option value="Punjab">Punjab</option>
                        <option value="Rajasthan">Rajasthan</option>
                        <option value="Sikkim">Sikkim</option>
                        <option value="Tamil Nadu">Tamil Nadu</option>
                        <option value="Telangana">Telangana</option>
                        <option value="Tripura">Tripura</option>
                        <option value="Uttar Pradesh">Uttar Pradesh</option>
                        <option value="Uttarakhand">Uttarakhand</option>
                        <option value="West Bengal">West Bengal</option>
                    </select>
                    <label for="" class="placeholder2">State</label>
                </div>
                <div class="trial1" style="margin-bottom:16px;">
                    <input type="text" placeholder="" name="regional_office_contact_person" class="input02" required style="font-size:1.1rem;">
                    <label for="" class="placeholder2">Contact Person</label>
                </div>
                <div class="trial1" style="margin-bottom:16px;">
                    <input type="text" placeholder="" name="regional_office_contact_number" class="input02" required style="font-size:1.1rem;">
                    <label for="" class="placeholder2">Contact Number</label>
                </div>
                <div class="trial1" style="margin-bottom:16px;">
                    <input type="email" placeholder="" name="regional_office_contact_email" class="input02" required style="font-size:1.1rem;">
                    <label for="" class="placeholder2">Contact Email</label>
                </div>
                <button type="submit" name="regional_office_submit" class="epc-button" style="width:100%;background:#2253a3;font-size:1.1rem;font-weight:600;padding:12px 0;">SUBMIT</button>
            </div>
        </form>
        <!-- Product Form -->
        <form id="productForm" class="vendorform" method="POST" autocomplete="off" style="display:none; margin-top: 20px;">
            <div class="rentalclientcontainer" style="min-width:420px; max-width:520px; padding: 32px 32px 24px 32px;">
                <p class="headingpara" style="background:#2253a3;color:#fff;padding:16px 0 12px 18px;border-radius:2px 2px 0 0;margin:-16px -16px 24px -16px;font-size:1.15rem;font-weight:600;">Add Product</p>
                <div class="trial1" style="margin-bottom:16px;">
                    <input type="text" name="product_serial" class="input02" required style="font-size:1.1rem;">
                    <label class="placeholder2">Product Serial Number/Code</label>
                </div>
                <div class="trial1" style="margin-bottom:16px;">
                    <input type="text" name="product_name" class="input02" required style="font-size:1.1rem;">
                    <label class="placeholder2">Product Name (Code HSN/SAC)</label>
                </div>
                <div class="trial1" style="margin-bottom:16px;">
                    <select name="product_uom" class="input02" required style="font-size:1.1rem;">
                        <option value="" disabled selected>Select UoM</option>
                        <option value="set">Set</option>
                        <option value="nos">Nos</option>
                        <option value="kgs">Kgs</option>
                        <option value="meter">Meter</option>
                        <option value="litre">Litre</option>
                        <!-- Add more as needed -->
                    </select>
                    <label class="placeholder2">UoM (Unit of Measurement)</label>
                </div>
                <div class="trial1" style="margin-bottom:16px;">
                    <input type="number" step="0.01" min="0" name="unit_price" id="unit_price" class="input02" required style="font-size:1.1rem;">
                    <label class="placeholder2">Unit Price</label>
                </div>
                <div class="trial1" style="margin-bottom:16px;">
                    <input type="number" step="1" min="1" name="qty" id="qty" class="input02" required style="font-size:1.1rem;">
                    <label class="placeholder2">Qty</label>
                </div>
                <button type="submit" name="product_submit" class="epc-button" style="width:100%;background:#2253a3;font-size:1.1rem;font-weight:600;padding:12px 0;">SUBMIT</button>
            </div>
        </form>
    </div>
<?php endif; ?> 

<?php
// Show all regional offices for this vendor
if ($vendor_id > 0) {
    $regional_sql = "SELECT * FROM vendor_regional_office WHERE vendor_id = ?";
    $regional_stmt = $conn->prepare($regional_sql);
    $regional_stmt->bind_param("i", $vendor_id);
    $regional_stmt->execute();
    $regional_result = $regional_stmt->get_result();

    if ($regional_result->num_rows > 0) {
        while ($rowreg = $regional_result->fetch_assoc()) {
            ?>
            <br>
            <h3 class="contactheading">
                Regional Office : <?php echo htmlspecialchars($rowreg['office_address']); ?>
                <a href="editVendorRegional.php?id=<?php echo $rowreg['id'] ?>&vendorid=<?php echo $vendor_id; ?>" id="editregionalofficebutton" title="Edit Regional Office" style="display:inline-block;vertical-align:middle;">
                    <i class="bi bi-pencil" style="font-size:20px;vertical-align:middle;line-height:1;"></i>
                </a>
            </h3>
            <h5 class="contactheading"><strong>State: </strong><?php echo htmlspecialchars($rowreg['state']); ?></h5>
            <h5 class="contactheading"><strong>Contact Person: </strong><?php echo htmlspecialchars($rowreg['contact_person']); ?></h5>
            <h5 class="contactheading"><strong>Contact Number: </strong><?php echo htmlspecialchars($rowreg['contact_number']); ?></h5>
            <h5 class="contactheading"><strong>Contact Email: </strong><?php echo htmlspecialchars($rowreg['contact_email']); ?></h5>
            <?php
        }
    }
    $regional_stmt->close();
}
?>

</body>
</html>
