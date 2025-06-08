<?php
session_start();
include "partials/_dbconnect.php";

// Only show vendors for the logged-in company
$companyname = $_SESSION['companyname'] ?? '';
$vendors = [];
$sql_vendors = "SELECT id, vendor_name FROM vendors WHERE companyname = ? ORDER BY vendor_name ASC";
$stmt_vendors = $conn->prepare($sql_vendors);
$stmt_vendors->bind_param("s", $companyname);
$stmt_vendors->execute();
$result_vendors = $stmt_vendors->get_result();
while ($row = $result_vendors->fetch_assoc()) {
    $vendors[] = $row;
}
$stmt_vendors->close();

// Handle form submission
$showSuccess = false;
$showError = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vendor/contact info
    $vendor_id = $_POST['vendor_id'] ?? null;
    $new_vendor_name = $_POST['new_vendor_name'] ?? null;
    $contact_person = $_POST['contact_person'] ?? null;
    $new_contact_person = $_POST['new_contact_person'] ?? null;
    $contact_number = $_POST['contact_number'] ?? null;
    $contact_email = $_POST['contact_email'] ?? null;
    $office_address = $_POST['office_address'] ?? null;

    // Product info
    $product_serial = $_POST['product_serial'] ?? null;
    $new_product_serial = $_POST['new_product_serial'] ?? null;
    $product_name = $_POST['product_name'] ?? null;
    $product_uom = $_POST['product_uom'] ?? null;
    $unit_price = $_POST['unit_price'] ?? null;
    $qty = $_POST['qty'] ?? null;
    $price = $_POST['price'] ?? null;

    // Insert into vendor_purchase_orders table
    $sql = "INSERT INTO vendor_purchase_orders (
        vendor_id, new_vendor_name, contact_person, new_contact_person, contact_number, contact_email, office_address,
        product_serial, new_product_serial, product_name, product_uom, unit_price, qty, price, created_at
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "issssssssssdds",
        $vendor_id,
        $new_vendor_name,
        $contact_person,
        $new_contact_person,
        $contact_number,
        $contact_email,
        $office_address,
        $product_serial,
        $new_product_serial,
        $product_name,
        $product_uom,
        $unit_price,
        $qty,
        $price
    );
    if ($stmt->execute()) {
        $showSuccess = true;
    } else {
        $showError = true;
    }
    $stmt->close();
    // Optionally, redirect or show a success message
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Vendor Purchase Order</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Use the same layout and field styles as generate_quotation.php */
        .vendorform { max-width: 700px; margin: 40px auto; background: #fafbfc; border: 1px solid #ddd; border-radius: 8px; padding: 32px 32px 24px 32px; }
        .headingpara { background: #2253a3; color: #fff; padding: 16px 0 12px 18px; border-radius: 2px 2px 0 0; margin: -16px -16px 24px -16px; font-size: 1.15rem; font-weight: 600; }
        .outer02 { display: flex; gap: 18px; flex-wrap: wrap; }
        .trial1 { flex: 1 1 220px; margin-bottom: 18px; position: relative; display: flex; flex-direction: column; }
        .input02, select { width: 100%; padding: 8px; font-size: 1.1rem; border: 1px solid #ccc; border-radius: 4px; }
        .placeholder2 { font-weight: 500; margin-bottom: 4px; display: block; }
        .suggestions { border: 1px solid #ccc; background: #fff; position: absolute; z-index: 10; width: 100%; max-height: 180px; overflow-y: auto; }
        .suggestion-item { padding: 8px; cursor: pointer; }
        .suggestion-item:hover { background: #e9ecef; }
        .next-btn, .back-btn { background: #2253a3; color: #fff; border: none; border-radius: 4px; font-weight: 600; padding: 12px 0; width: 100%; font-size: 1.1rem; margin-top: 10px; }
        .back-btn { background: #4067B5; }
        .form-btn-row { display: flex; gap: 16px; margin-top: 10px; }
        .hidden { display: none; }
        .form-section { margin-bottom: 0; }
        .form-section.hidden { display: none; }
        .form-section.active { display: block; }
    </style>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
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
    <div style="margin: 20px auto; max-width: 600px;">
        <div style="background: #d4edda; color: #155724; border: 1px solid #c3e6cb; padding: 16px; border-radius: 4px; text-align:center;">
            <b>Success!</b> Purchase Order submitted successfully.
        </div>
    </div>
<?php elseif ($showError): ?>
    <div style="margin: 20px auto; max-width: 600px;">
        <div style="background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; padding: 16px; border-radius: 4px; text-align:center;">
            <b>Error!</b> Something went wrong. Please try again.
        </div>
    </div>
<?php endif; ?>

<form id="vendorPOForm" class="vendorform" method="POST" autocomplete="off">
    <div id="contactSection" class="form-section active">
        <p class="headingpara">Vendor Contact Details</p>
        <div class="outer02">
            <div class="trial1" style="position:relative;">
                <input type="text" id="vendorSearch" class="input02" autocomplete="off" onkeyup="filterVendors()" onclick="showVendorDropdown()">
                <select id="vendorSelect" name="vendor_id" class="input02" style="display:none;" onchange="newVendorCheck(); fetchVendorContacts();">
                    <option value="" disabled selected>Select Vendor</option>
                    <?php foreach ($vendors as $v): ?>
                        <option value="<?php echo $v['id']; ?>"><?php echo htmlspecialchars($v['vendor_name']); ?></option>
                    <?php endforeach; ?>
                    <option value="new_vendor">New Vendor</option>
                </select>
                <div id="vendorSuggestions" class="suggestions" style="display:none;"></div>
                <label class="placeholder2">Vendor Name</label>
            </div>
            <div class="trial1 hidden" id="newVendorDiv">
                <input type="text" name="new_vendor_name" class="input02">
                <label class="placeholder2">New Vendor Name</label>
            </div>
            <div class="trial1" style="position:relative;">
                <select id="contactPersonSelect" name="contact_person" class="input02" onchange="newContactCheck(); autofillContactDetails();">
                    <option value="" disabled selected>Select Contact Person</option>
                    <option value="new_contact">New Contact Person</option>
                </select>
                <label class="placeholder2">Contact Person</label>
            </div>
            <div class="trial1 hidden" id="newContactDiv">
                <input type="text" name="new_contact_person" class="input02">
                <label class="placeholder2">New Contact Person</label>
            </div>
            <div class="trial1">
                <input type="text" name="contact_number" id="contact_number" class="input02">
                <label class="placeholder2">Contact Number</label>
            </div>
            <div class="trial1">
                <input type="email" name="contact_email" id="contact_email" class="input02">
                <label class="placeholder2">Contact Email</label>
            </div>
            <div class="trial1">
                <input type="text" name="office_address" id="office_address" class="input02">
                <label class="placeholder2">Office Address</label>
            </div>
        </div>
        <div class="form-btn-row">
            <button type="button" class="next-btn" onclick="showProductSection()">Next</button>
        </div>
    </div>

    <div id="productSection" class="form-section hidden">
        <p class="headingpara" style="background:#2253a3;">Add Product</p>
        <div class="outer02">
            <div class="trial1" style="position:relative;">
                <input type="text" id="productSearch" class="input02" autocomplete="off" onkeyup="filterProducts()" onclick="showProductDropdown()">
                <select id="productSelect" name="product_serial" class="input02" style="display:none;" onchange="autofillProductDetails(); newProductCheck();">
                    <option value="" disabled selected>Select Product</option>
                    <option value="new_product">New Product</option>
                </select>
                <div id="productSuggestions" class="suggestions" style="display:none;"></div>
                <label class="placeholder2">Product Serial Number/Code</label>
            </div>
            <div class="trial1 hidden" id="newProductDiv">
                <input type="text" name="new_product_serial" class="input02">
                <label class="placeholder2">New Product Serial/Code</label>
            </div>
            <div class="trial1">
                <input type="text" id="product_name" name="product_name" class="input02">
                <label class="placeholder2">Product Name (Code HSN/SAC)</label>
            </div>
            <div class="trial1">
                <select id="product_uom" name="product_uom" class="input02">
                    <option value="" disabled selected>Select UoM</option>
                    <option value="set">Set</option>
                    <option value="nos">Nos</option>
                    <option value="kgs">Kgs</option>
                    <option value="meter">Meter</option>
                    <option value="litre">Litre</option>
                </select>
                <label class="placeholder2">UoM (Unit of Measurement)</label>
            </div>
            <div class="trial1">
                <input type="number" step="0.01" min="0" id="unit_price" name="unit_price" class="input02" oninput="calcProductPrice()">
                <label class="placeholder2">Unit Price</label>
            </div>
            <div class="trial1">
                <input type="number" step="1" min="1" id="qty" name="qty" class="input02" oninput="calcProductPrice()">
                <label class="placeholder2">Qty</label>
            </div>
            <div class="trial1">
                <input type="number" step="0.01" min="0" id="price" name="price" class="input02" readonly style="background:#e9ecef;">
                <label class="placeholder2">Price (Unit Price × Qty)</label>
            </div>
        </div>
        <div class="form-btn-row">
            <button type="button" class="back-btn" onclick="showContactSection()">Back</button>
            <button type="submit" class="next-btn">Submit PO</button>
        </div>
    </div>
</form>

<script>
let vendorList = <?php echo json_encode($vendors); ?>;

function filterVendors() {
    let input = document.getElementById('vendorSearch').value.toLowerCase();
    let suggestions = document.getElementById('vendorSuggestions');
    suggestions.innerHTML = '';
    let found = false;
    vendorList.forEach(function(v) {
        if (v.vendor_name.toLowerCase().includes(input) && input) {
            let div = document.createElement('div');
            div.className = 'suggestion-item';
            div.textContent = v.vendor_name;
            div.onclick = function() {
                document.getElementById('vendorSearch').value = v.vendor_name;
                document.getElementById('vendorSelect').value = v.id;
                suggestions.style.display = 'none';
                fetchVendorContacts();
                newVendorCheck();
            };
            suggestions.appendChild(div);
            found = true;
        }
    });
    if (!found && input) {
        let div = document.createElement('div');
        div.className = 'suggestion-item';
        div.textContent = 'New Vendor';
        div.onclick = function() {
            document.getElementById('vendorSearch').value = 'New Vendor';
            document.getElementById('vendorSelect').value = 'new_vendor';
            suggestions.style.display = 'none';
            fetchVendorContacts();
            newVendorCheck();
        };
        suggestions.appendChild(div);
    }
    suggestions.style.display = input ? 'block' : 'none';
}
function showVendorDropdown() {
    document.getElementById('vendorSuggestions').style.display = 'block';
}
function newVendorCheck() {
    let val = document.getElementById('vendorSelect').value;
    document.getElementById('newVendorDiv').classList.toggle('hidden', val !== 'new_vendor');
    if (val === 'new_vendor') {
        document.getElementById('contactPersonSelect').innerHTML = '<option value="new_contact">New Contact Person</option>';
        document.getElementById('newContactDiv').classList.remove('hidden');
        document.getElementById('contact_number').value = '';
        document.getElementById('contact_email').value = '';
        document.getElementById('office_address').value = '';
    } else {
        fetchVendorContacts();
        document.getElementById('newContactDiv').classList.add('hidden');
    }
}
function fetchVendorContacts() {
    let vendorId = document.getElementById('vendorSelect').value;
    if (!vendorId || vendorId === 'new_vendor') return;
    $.get('fetch_vendor_contacts.php?vendor_id=' + vendorId, function(data) {
        let select = document.getElementById('contactPersonSelect');
        select.innerHTML = '<option value="" disabled selected>Select Contact Person</option><option value="new_contact">New Contact Person</option>';
        let arr = JSON.parse(data);
        arr.forEach(function(cp) {
            let opt = document.createElement('option');
            opt.value = cp.contact_person;
            opt.text = cp.contact_person;
            select.appendChild(opt);
        });
    });
}
function newContactCheck() {
    let val = document.getElementById('contactPersonSelect').value;
    document.getElementById('newContactDiv').classList.toggle('hidden', val !== 'new_contact');
    if (val !== 'new_contact' && val) {
        autofillContactDetails();
    }
}
function autofillContactDetails() {
    let vendorId = document.getElementById('vendorSelect').value;
    let contactPerson = document.getElementById('contactPersonSelect').value;
    if (!vendorId || !contactPerson || contactPerson === 'new_contact') {
        document.getElementById('contact_number').value = '';
        document.getElementById('contact_email').value = '';
        document.getElementById('office_address').value = '';
        return;
    }
    $.get('fetch_vendor_contact_detail.php?vendor_id=' + vendorId + '&contact_person=' + encodeURIComponent(contactPerson), function(data) {
        let d = JSON.parse(data);
        document.getElementById('contact_number').value = d.contact_number || '';
        document.getElementById('contact_email').value = d.contact_email || '';
        document.getElementById('office_address').value = d.office_address || '';
    });
}
function showProductSection() {
    document.getElementById('contactSection').classList.remove('active');
    document.getElementById('contactSection').classList.add('hidden');
    document.getElementById('productSection').classList.remove('hidden');
    document.getElementById('productSection').classList.add('active');
    // Load product list for selected vendor
    let vendorId = document.getElementById('vendorSelect').value;
    if (vendorId && vendorId !== 'new_vendor') {
        $.get('fetch_vendor_products.php?vendor_id=' + vendorId, function(data) {
            let select = document.getElementById('productSelect');
            select.innerHTML = '<option value="" disabled selected>Select Product</option><option value="new_product">New Product</option>';
            let arr = JSON.parse(data);
            arr.forEach(function(p) {
                let opt = document.createElement('option');
                opt.value = p.product_serial;
                opt.text = p.product_serial + ' - ' + p.product_name;
                select.appendChild(opt);
            });
        });
    }
}
function showContactSection() {
    document.getElementById('productSection').classList.remove('active');
    document.getElementById('productSection').classList.add('hidden');
    document.getElementById('contactSection').classList.remove('hidden');
    document.getElementById('contactSection').classList.add('active');
}
function filterProducts() {
    let input = document.getElementById('productSearch').value.toLowerCase();
    let suggestions = document.getElementById('productSuggestions');
    let vendorId = document.getElementById('vendorSelect').value;
    suggestions.innerHTML = '';
    if (!vendorId || vendorId === 'new_vendor') return;
    $.get('fetch_vendor_products.php?vendor_id=' + vendorId, function(data) {
        let arr = JSON.parse(data);
        let found = false;
        arr.forEach(function(p) {
            if (p.product_serial.toLowerCase().includes(input) || p.product_name.toLowerCase().includes(input)) {
                let div = document.createElement('div');
                div.className = 'suggestion-item';
                div.textContent = p.product_serial + ' - ' + p.product_name;
                div.onclick = function() {
                    document.getElementById('productSearch').value = p.product_serial;
                    document.getElementById('productSelect').value = p.product_serial;
                    autofillProductDetails();
                    suggestions.style.display = 'none';
                };
                suggestions.appendChild(div);
                found = true;
            }
        });
        if (!found && input) {
            let div = document.createElement('div');
            div.className = 'suggestion-item';
            div.textContent = 'New Product';
            div.onclick = function() {
                document.getElementById('productSearch').value = 'New Product';
                document.getElementById('productSelect').value = 'new_product';
                newProductCheck();
                suggestions.style.display = 'none';
            };
            suggestions.appendChild(div);
        }
        suggestions.style.display = input ? 'block' : 'none';
    });
}
function showProductDropdown() {
    document.getElementById('productSuggestions').style.display = 'block';
}
function newProductCheck() {
    let val = document.getElementById('productSelect').value;
    document.getElementById('newProductDiv').classList.toggle('hidden', val !== 'new_product');
}
function autofillProductDetails() {
    let vendorId = document.getElementById('vendorSelect').value;
    let prodSerial = document.getElementById('productSelect').value;
    if (!vendorId || !prodSerial || prodSerial === 'new_product') return;
    $.get('fetch_vendor_product_detail.php?vendor_id=' + vendorId + '&product_serial=' + encodeURIComponent(prodSerial), function(data) {
        let p = JSON.parse(data);
        document.getElementById('product_name').value = p.product_name || '';
        document.getElementById('product_uom').value = p.product_uom || '';
        document.getElementById('unit_price').value = p.unit_price || '';
        document.getElementById('qty').value = p.qty || '';
        calcProductPrice();
    });
}
function calcProductPrice() {
    let up = parseFloat(document.getElementById('unit_price').value) || 0;
    let qty = parseInt(document.getElementById('qty').value) || 0;
    document.getElementById('price').value = (up * qty).toFixed(2);
}

// Hide suggestions on click outside
document.addEventListener('click', function(event) {
    ['vendorSuggestions', 'productSuggestions'].forEach(function(id) {
        let el = document.getElementById(id);
        let input = document.getElementById(id === 'vendorSuggestions' ? 'vendorSearch' : 'productSearch');
        if (!el.contains(event.target) && event.target !== input) {
            el.style.display = 'none';
        }
    });
});
</script>
</body>
</html>
