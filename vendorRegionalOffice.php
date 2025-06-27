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
    $gst = isset($_POST['gst']) ? $_POST['gst'] : 0;
    $cgst = isset($_POST['cgst']) ? $_POST['cgst'] : 0;
    $sgst = isset($_POST['sgst']) ? $_POST['sgst'] : 0;
    $price_after_gst = isset($_POST['price_after_gst']) ? $_POST['price_after_gst'] : 0;
    $price_after_cgst = isset($_POST['price_after_cgst']) ? $_POST['price_after_cgst'] : 0;
    $price_after_sgst = isset($_POST['price_after_sgst']) ? $_POST['price_after_sgst'] : 0;

    $sql_product_insert = "INSERT INTO vendor_products (
        vendor_id, product_serial, product_name, product_uom, unit_price, qty, gst, cgst, sgst, price_after_gst, price_after_cgst, price_after_sgst
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt_product = $conn->prepare($sql_product_insert);
    // Corrected type string: i = int, s = string, d = double/float
    // vendor_id (i), product_serial (s), product_name (s), product_uom (s), unit_price (d), qty (i), gst (d), cgst (d), sgst (d), price_after_gst (d), price_after_cgst (d), price_after_sgst (d)
    $stmt_product->bind_param(
        "isssdidddddd",
        $vendor_id,
        $product_serial,
        $product_name,
        $product_uom,
        $unit_price,
        $qty,
        $gst,
        $cgst,
        $sgst,
        $price_after_gst,
        $price_after_cgst,
        $price_after_sgst
    );
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
        <link
            rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

        <style>
            body {
                min-height: 100vh;
                margin: 0;
                padding: 0;
                display: flex;
                flex-direction: column;
            }
            .main-center-flex {
                flex: 1 1 auto;
                display: flex;
                align-items: flex-start;
                /* changed from center */
                justify-content: center;
                width: 100%;
                min-height: unset;
                margin-top: 24px;
                /* add a small top margin */
            }
            .main-content-inner {
                display: flex;
                flex-direction: column;
                align-items: center;
                width: 100%;
                margin-top: 0;
                /* remove extra margin */
            }
            .button-row {
                display: flex;
                flex-direction: row;
                gap: 16px;
                margin: 0 0 18px;
                /* reduce top margin */
            }
            .createregionalofficecontainer {
                margin: 0 auto;
                border: 1px solid #ddd;
                border-radius: 8px;
                box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            }

            .hqcontactcontainer {
                width: 60%;
                margin: 0 auto;
                border: 1px solid #ddd;
                border-radius: 8px;
                box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            }

            .regional-offices-row {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
                gap: 24px;
                margin: 150px 0;
            }
            .regional-office-card {
                background: #f5f7fa;
                border: 1px solid #b4c5e4;
                border-radius: 10px;
                box-shadow: 0 2px 8px rgba(0,0,0,0.06);
                padding: 24px 32px;
                min-width: 280px;
                max-width: 340px;
                display: flex;
                flex-direction: column;
                align-items: flex-start;
            }
            /* Highlight incomplete data */
            .regional-office-card.incomplete-data {
                background: #ffe5e5;
                border: 2px solid #e74c3c;
            }
            .regional-office-card h3 {
                margin: 0 0 10px;
                font-size: 1.2rem;
                color: #2253a3;
                font-weight: 600;
                display: flex;
                align-items: center;
                gap: 8px;
            }
            .regional-office-card h5 {
                margin: 4px 0;
                font-size: 1rem;
                font-weight: 400;
                color: #333;
            }
            .regional-office-card .edit-link {
                margin-left: 8px;
                color: #4067B5;
                text-decoration: none;
                transition: color 0.2s;
            }
            .regional-office-card .edit-link:hover {
                color: #2253a3;
            }

            .vendor-detail-container h2 {
                margin-top: 0;
            }
            .vendor-detail-container p {
                margin: 8px 0;
            }
            .regional-office-btn {
                display: block;
                margin: 24px auto 12px;
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
                margin: 0 auto 24px;
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
                var regionalForm = document.getElementById('createregionalofficeform');
                var productForm = document.getElementById('hqcontactform');
                if (regionalForm.style.display === 'block') {
                    regionalForm.style.display = 'none';
                } else {
                    regionalForm.style.display = 'block';
                    productForm.style.display = 'none';
                }
            }
            function toggleProductForm() {
                var regionalForm = document.getElementById('createregionalofficeform');
                var productForm = document.getElementById('hqcontactform');
                if (productForm.style.display === 'block') {
                    productForm.style.display = 'none';
                } else {
                    productForm.style.display = 'block';
                    regionalForm.style.display = 'none';
                }
            }
        </script>
    </head>
    <body>
        <div class="navbar1">
            <div class="logo_fleet">
                <img
                    src="logo_fe.png"
                    alt="FLEET EIP"
                    onclick="window.location.href='rental_dashboard.php'">
            </div>
            <div class="iconcontainer">
                <ul>
                    <li>
                        <a href="rental_dashboard.php">Dashboard</a>
                    </li>
                    <li>
                        <a href="news/">News</a>
                    </li>
                    <li>
                        <a href="logout.php">Log Out</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="main-center-flex">
            <?php if ($showSuccess): ?>
            <div class="success-msg">Regional office created successfully!</div>
        <?php elseif ($showError): ?>
            <div class="error-msg">Failed to create regional office. Please try again.</div>
            <?php endif; ?>

            <?php if ($vendor): ?>
            <div class="main-content-inner">
                <div class="button-row">
                    <button
                        class="regional-office-btn"
                        onclick="toggleRegionalOfficeForm()"
                        style="min-width:220px; margin:0;">
                        Create Regional Office
                    </button>
                    <button
                        class="regional-office-btn"
                        onclick="toggleProductForm()"
                        style="min-width:220px; background:#2253a3; margin:0;">
                        Add Product
                    </button>
                </div>
                <form
                    class="createregionaloffice"
                    id="createregionalofficeform"
                    method="POST"
                    autocomplete="off"
                    style="display:none;">
                    <div class="createregionalofficecontainer">
                        <p class="headingpara">Create Regional Office</p>
                        <div class="trial1" style="margin-bottom:16px;">
                            <input
                                type="text"
                                placeholder=""
                                name="regional_office_address"
                                class="input02"
                                required="required"
                                style="font-size:1.1rem;">
                            <label for="" class="placeholder2">Regional Office Address</label>
                        </div>
                        <div class="trial1" style="margin-bottom:16px;">
                            <select
                                name="regional_office_state"
                                class="input02"
                                required="required"
                                style="font-size:1.1rem;">
                                <option value="" disabled="disabled" selected="selected">Select State</option>
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
                            <input
                                type="text"
                                placeholder=""
                                name="regional_office_contact_person"
                                class="input02"
                                required="required"
                                style="font-size:1.1rem;">
                            <label for="" class="placeholder2">Contact Person</label>
                        </div>
                        <div class="trial1" style="margin-bottom:16px;">
                            <input
                                type="text"
                                placeholder=""
                                name="regional_office_contact_number"
                                class="input02"
                                required="required"
                                style="font-size:1.1rem;">
                            <label for="" class="placeholder2">Contact Number</label>
                        </div>
                        <div class="trial1" style="margin-bottom:16px;">
                            <input
                                type="email"
                                placeholder=""
                                name="regional_office_contact_email"
                                class="input02"
                                required="required"
                                style="font-size:1.1rem;">
                            <label for="" class="placeholder2">Contact Email</label>
                        </div>
                        <button type="submit" name="regional_office_submit" class="epc-button">SUBMIT</button>
                    </div>
                </form>
                <!-- Product Form -->
                <form class="hqcontact" id="hqcontactform" method="POST" autocomplete="off">
                    <div class="hqcontactcontainer">
                        <p class="headingpara">Add Product</p>
                        <div class="outer02">
                            <div class="trial1" style="margin-bottom:16px;">
                                <input
                                    type="text"
                                    placeholder=""
                                    name="product_serial"
                                    class="input02"
                                    required="required"
                                    style="font-size:1.1rem;">
                                <label for="" class="placeholder2">Product Serial Number/Code</label>
                            </div>
                            <div class="trial1" style="margin-bottom:16px;">
                                <input
                                    type="text"
                                    placeholder=""
                                    name="product_name"
                                    class="input02"
                                    required="required"
                                    style="font-size:1.1rem;">
                                <label for="" class="placeholder2">Product Name (Code HSN/SAC)</label>
                            </div>
                        </div>
                        <div class="outer02">
                            <div class="trial1" style="margin-bottom:16px;">
                                <select
                                    name="product_uom"
                                    class="input02"
                                    required="required"
                                    style="font-size:1.1rem;">
                                    <option value="" disabled="disabled" selected="selected">Select UoM</option>
                                    <option value="set">Set</option>
                                    <option value="nos">Nos</option>
                                    <option value="kgs">Kgs</option>
                                    <option value="meter">Meter</option>
                                    <option value="litre">Litre</option>
                                </select>
                                <label class="placeholder2">UoM (Unit of Measurement)</label>
                            </div>

                            <div class="trial1" style="margin-bottom:16px;">
                                <input
                                    type="number"
                                    placeholder=""
                                    step="0.01"
                                    min="0"
                                    name="unit_price"
                                    id="unit_price"
                                    class="input02"
                                    required="required"
                                    style="font-size:1.1rem;">
                                <label for="" class="placeholder2">Unit Price</label>
                            </div>

                            <div class="trial1" style="margin-bottom:16px;">
                                <input
                                    type="number"
                                    placeholder=""
                                    step="1"
                                    min="1"
                                    name="qty"
                                    id="qty"
                                    class="input02"
                                    required="required"
                                    style="font-size:1.1rem;"
                                    value="1"
                                    readonly="readonly">
                                <label for="" class="placeholder2">Qty</label>
                            </div>
                        </div>
                        <div class="outer02">
                            <div class="trial1" style="margin-bottom:16px;">
                                <input
                                    type="number"
                                    placeholder=""
                                    step="0.01"
                                    min="0"
                                    name="gst"
                                    id="gst"
                                    class="input02"
                                    style="font-size:1.1rem;">
                                <label for="" class="placeholder2">GST (%)</label>
                            </div>
                            <div class="trial1" style="margin-bottom:16px;">
                                <input
                                    type="number"
                                    placeholder=""
                                    step="0.01"
                                    min="0"
                                    name="price_after_gst"
                                    id="price_after_gst"
                                    class="input02"
                                    style="font-size:1.1rem;"
                                    readonly="readonly">
                                <label for="price_after_gst" class="placeholder2">Price after GST</label>
                            </div>
                        </div>
                        <div class="outer02">
                            <div class="trial1" style="margin-bottom:16px;">
                                <input
                                    type="number"
                                    placeholder=""
                                    step="0.01"
                                    min="0"
                                    name="cgst"
                                    id="cgst"
                                    class="input02"
                                    style="font-size:1.1rem;"
                                    readonly="readonly">
                                <label for="" class="placeholder2">CGST (%)</label>
                            </div>
                            <div class="trial1" style="margin-bottom:16px;">
                                <input
                                    type="number"
                                    placeholder=""
                                    step="0.01"
                                    min="0"
                                    name="sgst"
                                    id="sgst"
                                    class="input02"
                                    style="font-size:1.1rem;"
                                    readonly="readonly">
                                <label for="" class="placeholder2">SGST (%)</label>
                            </div>
                        </div>
                        <div class="outer02">
                            <div class="trial1" style="margin-bottom:16px;">
                                <input
                                    type="number"
                                    placeholder=""
                                    step="0.01"
                                    min="0"
                                    name="price_after_cgst"
                                    id="price_after_cgst"
                                    class="input02"
                                    style="font-size:1.1rem;"
                                    readonly="readonly">
                                <label for="price_after_cgst" class="placeholder2">Price after CGST</label>
                            </div>
                            <div class="trial1" style="margin-bottom:16px;">
                                <input
                                    type="number"
                                    placeholder=""
                                    step="0.01"
                                    min="0"
                                    name="price_after_sgst"
                                    id="price_after_sgst"
                                    class="input02"
                                    style="font-size:1.1rem;"
                                    readonly="readonly">
                                <label for="price_after_sgst" class="placeholder2">Price after SGST</label>
                            </div>
                        </div>
                        <button type="submit" name="product_submit" class="epc-button">SUBMIT</button>
                    </div>
                </form>
                <script>
                    // GST split logic and price after GST/CGST/SGST
                    document.addEventListener('DOMContentLoaded', function () {
                        var gstInput = document.getElementById('gst');
                        var cgstInput = document.getElementById('cgst');
                        var sgstInput = document.getElementById('sgst');
                        var unitPriceInput = document.getElementById('unit_price');
                        var priceAfterGst = document.getElementById('price_after_gst');
                        var priceAfterCgst = document.getElementById('price_after_cgst');
                        var priceAfterSgst = document.getElementById('price_after_sgst');

                        function updateGSTFields() {
                            var price = parseFloat(unitPriceInput.value) || 0;
                            var gstVal = parseFloat(gstInput.value) || 0;
                            var cgstVal = gstVal / 2;
                            var sgstVal = gstVal / 2;
                            cgstInput.value = cgstVal ? cgstVal.toFixed(2) : '';
                            sgstInput.value = sgstVal ? sgstVal.toFixed(2) : '';

                            // Calculate prices
                            var gstAmount = price * (gstVal / 100);
                            var cgstAmount = price * (cgstVal / 100);
                            var sgstAmount = price * (sgstVal / 100);

                            priceAfterGst.value = (price + gstAmount).toFixed(2);
                            priceAfterCgst.value = (price + cgstAmount).toFixed(2);
                            priceAfterSgst.value = (price + sgstAmount).toFixed(2);
                        }

                        if (gstInput && cgstInput && sgstInput && unitPriceInput) {
                            gstInput.addEventListener('input', updateGSTFields);
                            gstInput.addEventListener('blur', updateGSTFields);
                            unitPriceInput.addEventListener('input', updateGSTFields);
                            // Trigger calculation on page load in case values are prefilled
                            updateGSTFields();
                        }
                    });
                </script>
            </div>
            <?php endif; ?>
        </div>
        <?php
// Show all regional offices for this vendor
if ($vendor_id > 0) {
    $regional_sql = "SELECT * FROM vendor_regional_office WHERE vendor_id = ?";
    $regional_stmt = $conn->prepare($regional_sql);
    $regional_stmt->bind_param("i", $vendor_id);
    $regional_stmt->execute();
    $regional_result = $regional_stmt->get_result();

    if ($regional_result->num_rows > 0) {
        echo '<div class="regional-offices-row">';
        while ($rowreg = $regional_result->fetch_assoc()) {
            // Check for incomplete data
            $incomplete = (
                empty($rowreg['office_address']) ||
                empty($rowreg['state']) ||
                empty($rowreg['contact_person']) ||
                empty($rowreg['contact_number']) ||
                empty($rowreg['contact_email'])
            );
            $cardClass = 'regional-office-card' . ($incomplete ? ' incomplete-data' : '');
            ?>
        <div class="<?php echo $cardClass; ?>">
            <h3>
                Regional Office:
                <?php echo htmlspecialchars($rowreg['office_address']); ?>
                <a
                    href="editVendorRegional.php?id=<?php echo $rowreg['id'] ?>&vendorid=<?php echo $vendor_id; ?>"
                    class="edit-link"
                    title="Edit Regional Office">
                    <i
                        class="bi bi-pencil"
                        style="font-size:20px;vertical-align:middle;line-height:1;"></i>
                </a>
            </h3>
            <h5>
                <strong>State:</strong>
                <?php echo htmlspecialchars($rowreg['state']); ?></h5>
            <h5>
                <strong>Contact Person:</strong>
                <?php echo htmlspecialchars($rowreg['contact_person']); ?></h5>
            <h5>
                <strong>Contact Number:</strong>
                <?php echo htmlspecialchars($rowreg['contact_number']); ?></h5>
            <h5>
                <strong>Contact Email:</strong>
                <?php echo htmlspecialchars($rowreg['contact_email']); ?></h5>
            <?php if ($incomplete): ?>
            <div style="color:#e74c3c; font-weight:600; margin-top:8px;">Incomplete Data</div>
            <?php endif; ?>
        </div>
        <?php
        }
        echo '</div>';
    }
    $regional_stmt->close();
}
?>

    </body>
</html>