<?php
include "partials/_dbconnect.php";
session_start();

$vendor_id = isset($_GET['vendor_id']) ? intval($_GET['vendor_id']) : 0;
$product_id = isset($_GET['product_id']) ? intval($_GET['product_id']) : 0;
$showSuccess = false;
$showError = false;

if ($product_id > 0 && $vendor_id > 0) {
    // Fetch product details
    $sql = "SELECT * FROM vendor_products WHERE id = ? AND vendor_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $product_id, $vendor_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
    $stmt->close();
} else {
    $product = null;
}

// Handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_product_submit'])) {
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

    $sql_update = "UPDATE vendor_products SET product_serial=?, product_name=?, product_uom=?, unit_price=?, qty=?, gst=?, cgst=?, sgst=?, price_after_gst=?, price_after_cgst=?, price_after_sgst=? WHERE id=? AND vendor_id=?";
    $stmt = $conn->prepare($sql_update);
    $stmt->bind_param(
        "ssssidddddiii",
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
        $price_after_sgst,
        $product_id,
        $vendor_id
    );
    if ($stmt->execute()) {
        $showSuccess = true;
    } else {
        $showError = true;
    }
    $stmt->close();
    // Refresh product data
    header("Location: vendorRegionalOffice.php?id=$vendor_id");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Product</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
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
<div style="display:flex;justify-content:center;align-items:center;min-height:80vh;">
    <div class="hqcontactcontainer" style="margin-top:40px;">
        <p class="headingpara">Edit Product</p>
        <?php if ($showSuccess): ?>
            <div class="success-msg">Product updated successfully!</div>
        <?php elseif ($showError): ?>
            <div class="error-msg">Failed to update product. Please try again.</div>
        <?php endif; ?>
        <?php if ($product): ?>
        <form method="POST" autocomplete="off">
            <div class="outer02">
                <div class="trial1" style="margin-bottom:16px;">
                    <input type="text" name="product_serial" class="input02" required style="font-size:1.1rem;" value="<?php echo htmlspecialchars($product['product_serial']); ?>">
                    <label class="placeholder2">Product Serial Number/Code</label>
                </div>
                <div class="trial1" style="margin-bottom:16px;">
                    <input type="text" name="product_name" class="input02" required style="font-size:1.1rem;" value="<?php echo htmlspecialchars($product['product_name']); ?>">
                    <label class="placeholder2">Product Name (Code HSN/SAC)</label>
                </div>
            </div>
            <div class="outer02">
                <div class="trial1" style="margin-bottom:16px;">
                    <select name="product_uom" class="input02" required style="font-size:1.1rem;">
                        <option value="set" <?php if($product['product_uom']=='set')echo 'selected';?>>Set</option>
                        <option value="nos" <?php if($product['product_uom']=='nos')echo 'selected';?>>Nos</option>
                        <option value="kgs" <?php if($product['product_uom']=='kgs')echo 'selected';?>>Kgs</option>
                        <option value="meter" <?php if($product['product_uom']=='meter')echo 'selected';?>>Meter</option>
                        <option value="litre" <?php if($product['product_uom']=='litre')echo 'selected';?>>Litre</option>
                    </select>
                    <label class="placeholder2">UoM (Unit of Measurement)</label>
                </div>
                <div class="trial1" style="margin-bottom:16px;">
                    <input type="number" step="0.01" min="0" name="unit_price" id="unit_price" class="input02" required style="font-size:1.1rem;" value="<?php echo htmlspecialchars($product['unit_price']); ?>">
                    <label class="placeholder2">Unit Price</label>
                </div>
                <div class="trial1" style="margin-bottom:16px;">
                    <input type="number" step="1" min="1" name="qty" id="qty" class="input02" required style="font-size:1.1rem;" value="<?php echo htmlspecialchars($product['qty']); ?>">
                    <label class="placeholder2">Qty</label>
                </div>
            </div>
            <div class="outer02">
                <div class="trial1" style="margin-bottom:16px;">
                    <input type="number" step="0.01" min="0" name="gst" id="gst" class="input02" style="font-size:1.1rem;" value="<?php echo htmlspecialchars($product['gst']); ?>">
                    <label class="placeholder2">GST (%)</label>
                </div>
                <div class="trial1" style="margin-bottom:16px;">
                    <input type="number" step="0.01" min="0" name="price_after_gst" id="price_after_gst" class="input02" style="font-size:1.1rem;" value="<?php echo htmlspecialchars($product['price_after_gst']); ?>">
                    <label for="price_after_gst" class="placeholder2">Price after GST</label>
                </div>
            </div>
            <div class="outer02">
                <div class="trial1" style="margin-bottom:16px;">
                    <input type="number" step="0.01" min="0" name="cgst" id="cgst" class="input02" style="font-size:1.1rem;" value="<?php echo htmlspecialchars($product['cgst']); ?>">
                    <label class="placeholder2">CGST (%)</label>
                </div>
                <div class="trial1" style="margin-bottom:16px;">
                    <input type="number" step="0.01" min="0" name="sgst" id="sgst" class="input02" style="font-size:1.1rem;" value="<?php echo htmlspecialchars($product['sgst']); ?>">
                    <label class="placeholder2">SGST (%)</label>
                </div>
            </div>
            <div class="outer02">
                <div class="trial1" style="margin-bottom:16px;">
                    <input type="number" step="0.01" min="0" name="price_after_cgst" id="price_after_cgst" class="input02" style="font-size:1.1rem;" value="<?php echo htmlspecialchars($product['price_after_cgst']); ?>">
                    <label for="price_after_cgst" class="placeholder2">Price after CGST</label>
                </div>
                <div class="trial1" style="margin-bottom:16px;">
                    <input type="number" step="0.01" min="0" name="price_after_sgst" id="price_after_sgst" class="input02" style="font-size:1.1rem;" value="<?php echo htmlspecialchars($product['price_after_sgst']); ?>">
                    <label for="price_after_sgst" class="placeholder2">Price after SGST</label>
                </div>
            </div>
            <button type="submit" name="edit_product_submit" class="epc-button">Update</button>
        </form>
        <?php else: ?>
            <div class="error-msg">Product not found.</div>
        <?php endif; ?>
    </div>
</div>
<script>
    // GST split logic and price after GST/CGST/SGST (same as add form)
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

            var gstAmount = price * (gstVal / 100);
            var cgstAmount = price * (cgstVal / 100);
            var sgstAmount = price * (sgstVal / 100);

            priceAfterGst.value = gstAmount.toFixed(2);
            priceAfterCgst.value = cgstAmount.toFixed(2);
            priceAfterSgst.value = sgstAmount.toFixed(2);
        }

        if (gstInput && cgstInput && sgstInput && unitPriceInput) {
            gstInput.addEventListener('input', updateGSTFields);
            gstInput.addEventListener('blur', updateGSTFields);
            unitPriceInput.addEventListener('input', updateGSTFields);
            updateGSTFields();
        }
    });
</script>
</body>
</html>
