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
    $product_serials = $_POST['product_serial'] ?? [];
    $new_product_serials = $_POST['new_product_serial'] ?? [];
    $product_names = $_POST['product_name'] ?? [];
    $product_uoms = $_POST['product_uom'] ?? [];
    $unit_prices = $_POST['unit_price'] ?? [];
    $qtys = $_POST['qty'] ?? [];
    $prices = $_POST['price'] ?? [];

    // Bill to/ship to info
    $billto = $_POST['billto'] ?? null;
    $billto_address = $_POST['billto_address'] ?? null;
    $billto_gstn = $_POST['billto_gstn'] ?? null;
    $billto_pan = $_POST['billto_pan'] ?? null;
    $billto_contactperson = $_POST['billto_contactperson'] ?? null;
    $billto_contactno = $_POST['billto_contactno'] ?? null;
    $shipto = $_POST['shipto'] ?? null;
    $shipto_address = $_POST['shipto_address'] ?? null;
    $shipto_gstn = $_POST['shipto_gstn'] ?? null;
    $placeofsupply = $_POST['placeofsupply'] ?? null;
    $shipto_contactperson = $_POST['shipto_contactperson'] ?? null;
    $shipto_contactno = $_POST['shipto_contactno'] ?? null;

    // If vendor_id is not 'new_vendor', ignore new_vendor_name
    if ($vendor_id !== 'new_vendor') {
        $new_vendor_name = null;
    }
    // If vendor_id is 'new_vendor', set vendor_id to null for DB
    if ($vendor_id === 'new_vendor' || empty($vendor_id)) {
        $vendor_id = null;
    }

    // Insert for each product (max 5)
    $max_products = min(5, count($product_names));
    for ($i = 0; $i < $max_products; $i++) {
        $sql = "INSERT INTO vendor_purchase_orders (
            vendor_id, new_vendor_name, contact_person, new_contact_person, contact_number, contact_email, office_address,
            product_serial, new_product_serial, product_name, product_uom, unit_price, qty, price, created_at,
            billto, billto_address, billto_gstn, billto_pan, billto_contactperson, billto_contactno,
            shipto, shipto_address, shipto_gstn, placeofsupply, shipto_contactperson, shipto_contactno
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param(
            "issssssssssddsssssssssssss",
            $vendor_id,
            $new_vendor_name,
            $contact_person,
            $new_contact_person,
            $contact_number,
            $contact_email,
            $office_address,
            $product_serials[$i],
            $new_product_serials[$i],
            $product_names[$i],
            $product_uoms[$i],
            $unit_prices[$i],
            $qtys[$i],
            $prices[$i],
            $billto,
            $billto_address,
            $billto_gstn,
            $billto_pan,
            $billto_contactperson,
            $billto_contactno,
            $shipto,
            $shipto_address,
            $shipto_gstn,
            $placeofsupply,
            $shipto_contactperson,
            $shipto_contactno
        );
        $stmt->execute();
        $stmt->close();
    }
    header("Location: vendorPOView.php?success=1");
    exit();
}

// Autofill Bill To details from basic_details table
$companyname = $_SESSION['companyname'] ?? '';
$billto_detail = [];
$table_exists = false;
$check_table = $conn->query("SHOW TABLES LIKE 'basic_details'");
if ($check_table && $check_table->num_rows > 0) {
    $table_exists = true;
}
if ($table_exists) {
    $sql_basic = "SELECT companyname, company_address FROM basic_details WHERE companyname = ? LIMIT 1";
    $stmt_basic = $conn->prepare($sql_basic);
    $stmt_basic->bind_param("s", $companyname);
    $stmt_basic->execute();
    $result_basic = $stmt_basic->get_result();
    if ($row = $result_basic->fetch_assoc()) {
        $billto_detail = $row;
    }
    $stmt_basic->close();
}

// Autofill Contact Person and Contact No from team_members table
$team_contacts = [];
$sql_team = "SELECT name, mob_number FROM team_members WHERE company_name = ?";
$stmt_team = $conn->prepare($sql_team);
$stmt_team->bind_param("s", $companyname);
$stmt_team->execute();
$result_team = $stmt_team->get_result();
while ($row = $result_team->fetch_assoc()) {
    $team_contacts[] = $row;
}
$stmt_team->close();

// Fetch vendor products for autocomplete (for the logged-in company)
// Add qty to the select
$vendor_products = [];
$vendor_id = null;
if (!empty($vendors)) {
    $vendor_id = $vendors[0]['id'];
}
if ($vendor_id) {
    $sql_products = "SELECT product_serial, product_name, product_uom, unit_price, qty FROM vendor_products WHERE vendor_id = ?";
    $stmt_products = $conn->prepare($sql_products);
    $stmt_products->bind_param("i", $vendor_id);
    $stmt_products->execute();
    $result_products = $stmt_products->get_result();
    while ($row = $result_products->fetch_assoc()) {
        $vendor_products[] = $row;
    }
    $stmt_products->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Vendor Purchase Order</title>
    <link rel="stylesheet" href="style.css"> 
        <style><?php include "style.css" ?></style>
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

<!-- ===================== VENDOR CONTACT SECTION ===================== -->
<form action="" method="POST" id="vendorPOForm" class="generate_quotation" autocomplete="off" enctype="multipart/form-data">
    <div id="contactSection" class="generate_quote_container active">
        <div id="contactpersonsectioncontainer" >
            <p class="headingpara" >Vendor Contact Details</p>
            <div class="outer02" id="quoteouter02">
                <div class="trial1" id="newrentalclient">
                    <input type="text" name="new_vendor_name" class="input02" placeholder="New Vendor Name">
                    <label class="placeholder2">New Vendor Name</label>
                </div>
                <div class="trial1" id="companySelectouter">
                    <input type="text" id="vendorSearch" class="input02" placeholder="Select Vendor" autocomplete="off" onkeyup="filterVendors()" onclick="showVendorDropdown()">
                    <select id="vendorSelect" name="vendor_id" class="input02" style="display:none;" onchange="newVendorCheck(); fetchVendorContacts();">
                        <option value="" disabled selected>Select Vendor</option>
                        <?php foreach ($vendors as $v): ?>
                            <option value="<?php echo $v['id']; ?>"><?php echo htmlspecialchars($v['vendor_name']); ?></option>
                        <?php endforeach; ?>
                        <option value="new_vendor">New Vendor</option>
                    </select>
                    <div id="vendorSuggestions" class="suggestions" style="display:none;"></div>
                </div> 
                <div class="trial1" id="contactSelectouter">
                    <select id="contactPersonSelect" name="contact_person" class="input02" onchange="handleContactPersonSelect(this);" style="transition:all .2s;">
                        <option value="" disabled selected>Select Contact Person</option>
                        <option value="new_contact">New Contact Person</option>
                    </select>
                </div>
                <div class="trial1" id='officetypeouter'>
                    <!-- If you want to add office type for vendor, add here -->
                </div>
            </div>
            <div class="outer02">
                <div class="trial1">
                    <input type="text" name="office_address" id="office_address" class="input02" placeholder="">
                    <label class="placeholder2">Office Address</label>
                </div>
                <div class="trial1" id="contact_number1">
                    <input type="text" name="contact_number" id="contact_number" class="input02" placeholder="">
                    <label class="placeholder2">Contact Number</label>
                </div>
                <div class="trial1">
                    <input type="email" name="contact_email" id="contact_email" class="input02" placeholder="">
                    <label class="placeholder2">Contact Email</label>
                </div>
            </div>
            <!-- Hidden company name if needed -->
            <!-- <input type="text" value="<?php echo $companyname ?>" id="comp_name_trial" hidden> -->
            <button
                class="quotationnavigatebutton bg-white text-center w-30 rounded-lg h-10 relative text-black text-sm font-semibold group"
                type="button" onclick="showProductSection()"
                style="margin-top: 18px;"
            >
                <div
                    class="bg-custom-blue rounded-md h-8 w-1/4 flex items-center justify-center absolute left-1 top-[2px] group-hover:w-[110px] z-10 duration-300"
                    style="background-color: #1C549E;"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 1024 1024"
                        height="18px"
                        width="18px"
                        transform="rotate(180)"
                    >
                        <path
                            d="M224 480h640a32 32 0 1 1 0 64H224a32 32 0 0 1 0-64z"
                            fill="white"
                        ></path>
                        <path
                            d="m237.248 512 265.408 265.344a32 32 0 0 1-45.312 45.312l-288-288a32 32 0 0 1 0-45.312l288-288a32 32 0 1 1 45.312 45.312L237.248 512z"
                            fill="white"
                        ></path>
                    </svg>
                </div>
                <p class="translate-x-1">Next</p>
            </button>
        </div>
    </div>

    <!-- ===================== ADD PRODUCT SECTION ===================== -->
    <div id="productSection" class="generate_quote_container form-section hidden">
        <div class="headingpara" style="background: #2253a3; color: #fff; padding: 18px 0 14px 32px; border-radius: 8px 8px 0 0; margin: 0; font-size: 1.25rem; font-weight: 600; box-sizing: border-box;">
            Product Information
        </div>
        <div style="padding: 32px;">
            <div id="productRepeater">
                <div class="product-group">
                    <div class="outer02">
                        <div class="trial1" style="position:relative;">
                            <input type="text" id="productSearch_0" class="input02 productSearch" autocomplete="off" onkeyup="filterProducts(this)" onclick="showProductDropdown(this)">
                            <select id="productSelect_0" name="product_serial[]" class="input02 productSelect" style="display:none;" onchange="autofillProductDetails(this); newProductCheck(this);">
                                <option value="" disabled selected>Select Product</option>
                                <option value="new_product">New Product</option>
                            </select>
                            <div class="suggestions productSuggestions" style="display:none;"></div>
                            <label class="placeholder2">Product Serial Number/Code</label>
                        </div>
                        <div class="trial1 hidden newProductDiv">
                            <input type="text" name="new_product_serial[]" class="input02">
                            <label class="placeholder2">New Product Serial/Code</label>
                        </div>
                        <div class="trial1">
                            <input type="text" class="input02 product_name" name="product_name[]">
                            <label class="placeholder2">Product Name (Code HSN/SAC)</label>
                        </div>
                        <div class="trial1">
                            <select class="input02 product_uom" name="product_uom[]">
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
                            <input type="number" step="0.01" min="0" class="input02 unit_price" name="unit_price[]" oninput="calcProductPrice(this)">
                            <label class="placeholder2">Unit Price</label>
                        </div>
                        <div class="trial1">
                            <input type="number" step="1" min="1" class="input02 qty" name="qty[]" oninput="calcProductPrice(this)">
                            <label class="placeholder2">Qty</label>
                        </div>
                        <div class="trial1">
                            <input type="number" step="0.01" min="0" class="input02 price" name="price[]" readonly style="background:#e9ecef;">
                            <label class="placeholder2">Price (Unit Price × Qty)</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="addbuttonicon" id="addProductBtnContainer">
                <i id="addProductBtn" onclick="$('#addProductBtn').trigger('click');" class="bi bi-plus-circle">Add Another Product</i>
            </div>
            <div class="fulllength" id="quotationnextback" style="margin-top:16px;">
                <button class="quotationnavigatebutton bg-white text-center w-30 rounded-lg h-10 relative text-black text-sm font-semibold group"
                    type="button" onclick="showContactSection()">
                    <div class="rounded-md h-8 w-1/4 flex items-center justify-center absolute left-1 top-[2px] group-hover:w-[110px] z-10 duration-300"
                        style="background-color: #1C549E;">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 1024 1024"
                            height="18px"
                            width="18px"
                        >
                            <path
                                d="M224 480h640a32 32 0 1 1 0 64H224a32 32 0 0 1 0-64z"
                                fill="white" 
                            ></path>
                            <path
                                d="m237.248 512 265.408 265.344a32 32 0 0 1-45.312 45.312l-288-288a32 32 0 0 1 0-45.312l288-288a32 32 0 1 1 45.312 45.312L237.248 512z"
                                fill="white" 
                            ></path>
                        </svg>
                    </div>
                    <p class="translate-x-1">Back</p>
                </button>
                <button class="quotationnavigatebutton bg-white text-center w-30 rounded-lg h-10 relative text-black text-sm font-semibold group"
                    type="button" onclick="showBillToSection()">
                    <div class="bg-custom-blue rounded-md h-8 w-1/4 flex items-center justify-center absolute left-1 top-[2px] group-hover:w-[110px] z-10 duration-300"
                        style="background-color: #1C549E;" 
                    >
                    <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 1024 1024"
                            height="18px"
                            width="18px"
                            transform="rotate(180)" 
                        >
                            <path
                                d="M224 480h640a32 32 0 1 1 0 64H224a32 32 0 0 1 0-64z"
                                fill="white" 
                            ></path>
                            <path
                                d="m237.248 512 265.408 265.344a32 32 0 0 1-45.312 45.312l-288-288a32 32 0 0 1 0-45.312l288-288a32 32 0 1 1 45.312 45.312L237.248 512z"
                                fill="white" 
                            ></path>
                        </svg>
                    </div>
                    <p class="translate-x-1" >Next</p>
                </button>
            </div>
        </div>
    </div>

    <!-- ===================== BILL TO SECTION ===================== -->
    <div id="billToSection" class="generate_quote_container form-section hidden" >
        <div class="headingpara" style="background: #2253a3; color: #fff; padding: 18px 0 14px 32px; border-radius: 8px 8px 0 0; margin: 0; font-size: 1.25rem; font-weight: 600; box-sizing: border-box;">
            Bill To Details
        </div>
        <div style="padding: 32px;">
            <div class="outer02" style="margin-top:0;">
                <div class="trial1">
                    <input type="text" name="billto" id="billto" class="input02" value="<?php echo htmlspecialchars($billto_detail['companyname'] ?? ''); ?>">
                    <label class="placeholder2">Bill To (Company Name)</label>
                </div>
                <div class="trial1">
                    <input type="text" name="billto_address" id="billto_address" class="input02" value="<?php echo htmlspecialchars($billto_detail['company_address'] ?? ''); ?>">
                    <label class="placeholder2">Address</label>
                </div>
                <div class="trial1">
                    <input type="text" name="billto_gstn" class="input02">
                    <label class="placeholder2">GSTN</label>
                </div>
                <div class="trial1">
                    <input type="text" name="billto_pan" class="input02">
                    <label class="placeholder2">PAN</label>
                </div>
                <div class="trial1" style="position:relative;">
                    <select name="billto_contactperson" id="billto_contactperson" class="input02">
                        <option value="" disabled selected>Select Contact Person</option>
                        <?php foreach ($team_contacts as $c): ?>
                            <option value="<?php echo htmlspecialchars($c['name']); ?>"><?php echo htmlspecialchars($c['name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <label class="placeholder2">Contact Person</label>
                </div>
                <div class="trial1">
                    <input type="text" name="billto_contactno" id="billto_contactno" class="input02">
                    <label class="placeholder2">Contact No</label>
                </div>
            </div>
            <div class="fulllength" id="quotationnextback" style="margin-top:16px;">
                <button class="quotationnavigatebutton bg-white text-center w-30 rounded-lg h-10 relative text-black text-sm font-semibold group"
                    type="button" onclick="showProductSection()">
                    <div class="rounded-md h-8 w-1/4 flex items-center justify-center absolute left-1 top-[2px] group-hover:w-[110px] z-10 duration-300"
                        style="background-color: #1C549E;">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 1024 1024"
                            height="18px"
                            width="18px"
                        >
                            <path
                                d="M224 480h640a32 32 0 1 1 0 64H224a32 32 0 0 1 0-64z"
                                fill="white" 
                            ></path>
                            <path
                                d="m237.248 512 265.408 265.344a32 32 0 0 1-45.312 45.312l-288-288a32 32 0 0 1 0-45.312l288-288a32 32 0 1 1 45.312 45.312L237.248 512z"
                                fill="white" 
                            ></path>
                        </svg>
                    </div>
                    <p class="translate-x-1">Back</p>
                </button>
                <button class="quotationnavigatebutton bg-white text-center w-30 rounded-lg h-10 relative text-black text-sm font-semibold group"
                    type="button" onclick="showShipToSection()">
                    <div class="bg-custom-blue rounded-md h-8 w-1/4 flex items-center justify-center absolute left-1 top-[2px] group-hover:w-[110px] z-10 duration-300"
                        style="background-color: #1C549E;" 

                    >
                    <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 1024 1024"
                            height="18px"
                            width="18px"
                            transform="rotate(180)" 
                        >
                            <path
                                d="M224 480h640a32 32 0 1 1 0 64H224a32 32 0 0 1 0-64z"
                                fill="white" 
                            ></path>
                            <path
                                d="m237.248 512 265.408 265.344a32 32 0 0 1-45.312 45.312l-288-288a32 32 0 0 1 0-45.312l288-288a32 32 0 1 1 45.312 45.312L237.248 512z"
                                fill="white" 
                            ></path>
                        </svg>
                    </div>
                    <p class="translate-x-1" >Next</p>
                </button>
            </div>
        </div>
    </div>

    <!-- ===================== SHIP TO SECTION ===================== -->
    <div id="shipToSection" class="generate_quote_container form-section hidden">
        <div class="headingpara" style="background: #2253a3; color: #fff; padding: 18px 0 14px 32px; border-radius: 8px 8px 0 0; margin: 0; font-size: 1.25rem; font-weight: 600; box-sizing: border-box;">
            Ship To Details
        </div>
        <div style="padding: 32px;">
            <div class="outer02" style="margin-top:0;">
                <div class="trial1">
                    <input type="text" name="shipto" class="input02">
                    <label class="placeholder2">Ship To (Company Name)</label>
                </div>
                <div class="trial1">
                    <input type="text" name="shipto_address" id="shipto_address" class="input02" value="<?php echo htmlspecialchars($billto_detail['company_address'] ?? ''); ?>">
                    <label class="placeholder2">Address</label>
                </div>
                <div class="trial1">
                    <input type="text" name="shipto_gstn" class="input02">
                    <label class="placeholder2">GSTN</label>
                </div>
                <div class="trial1">
                    <input type="text" name="placeofsupply" class="input02">
                    <label class="placeholder2">Place of Supply</label>
                </div>
                <div class="trial1" style="position:relative;">
                    <select name="shipto_contactperson" id="shipto_contactperson" class="input02">
                        <option value="" disabled selected>Select Contact Person</option>
                        <?php foreach ($team_contacts as $c): ?>
                            <option value="<?php echo htmlspecialchars($c['name']); ?>"><?php echo htmlspecialchars($c['name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <label class="placeholder2">Contact Person</label>
                </div>
                <div class="trial1">
                    <input type="text" name="shipto_contactno" id="shipto_contactno" class="input02">
                    <label class="placeholder2">Contact No</label>
                </div>
            </div>
            <div class="fulllength" id="quotationnextback" style="margin-top:16px;">
                <button class="quotationnavigatebutton bg-white text-center w-30 rounded-lg h-10 relative text-black text-sm font-semibold group"
                    type="button" onclick="showBillToSection()">
                    <div class="rounded-md h-8 w-1/4 flex items-center justify-center absolute left-1 top-[2px] group-hover:w-[110px] z-10 duration-300"
                        style="background-color: #1C549E;">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 1024 1024"
                            height="18px"
                            width="18px"
                        >
                            <path
                                d="M224 480h640a32 32 0 1 1 0 64H224a32 32 0 0 1 0-64z"
                                fill="white" 
                            ></path>
                            <path
                                d="m237.248 512 265.408 265.344a32 32 0 0 1-45.312 45.312l-288-288a32 32 0 0 1 0-45.312l288-288a32 32 0 1 1 45.312 45.312L237.248 512z"
                                fill="white" 
                            ></path>
                        </svg>
                    </div>
                    <p class="translate-x-1">Back</p>
                </button>
                <button class="quotationnavigatebutton bg-white text-center w-30 rounded-lg h-10 relative text-black text-sm font-semibold group"
                    type="submit">
                    <div class="bg-custom-blue rounded-md h-8 w-1/4 flex items-center justify-center absolute left-1 top-[2px] group-hover:w-[110px] z-10 duration-300"
                        style="background-color: #1C549E;" 
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 1024 1024"
                            height="18px"
                            width="18px"
                            transform="rotate(180)" 
                        >
                            <path
                                d="M224 480h640a32 32 0 1 1 0 64H224a32 32 0 0 1 0-64z"
                                fill="white" 
                            ></path>
                            <path
                                d="m237.248 512 265.408 265.344a32 32 0 0 1-45.312 45.312l-288-288a32 32 0 0 1 0-45.312l288-288a32 32 0 1 1 45.312 45.312L237.248 512z"
                                fill="white" 
                            ></path>
                        </svg>
                    </div>
                    <p class="translate-x-1" >Submit</p>
                </button>
            </div>
        </div>
    </div>
</form>
<script>
let vendorList = <?php echo json_encode($vendors); ?>;
let teamContacts = <?php echo json_encode($team_contacts); ?>;
let vendorProducts = <?php echo json_encode($vendor_products); ?>;

// When vendor changes, fetch products for that vendor
$('#vendorSelect').on('change', function() {
    let vendorId = $(this).val();
    if (!vendorId || vendorId === 'new_vendor') {
        vendorProducts = [];
        return;
    }
    $.get('fetch_vendor_products.php?vendor_id=' + vendorId, function(data) {
        vendorProducts = JSON.parse(data);
    });
});

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
            // Set the input to the user's typed value, not "New Vendor"
            document.getElementById('vendorSearch').value = document.getElementById('vendorSearch').value;
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
    let newInput = document.getElementById('newContactPersonInput');
    if (val === 'new_contact') {
        newInput.style.display = 'block';
        newInput.required = true;
    } else {
        newInput.style.display = 'none';
        newInput.required = false;
    }
    if (val !== 'new_contact' && val) {
        autofillContactDetails();
    }
}
function handleContactPersonSelect(select) {
    if (select.value === 'new_contact') {
        // Replace select with input for new contact person
        const parent = select.parentNode;
        const input = document.createElement('input');
        input.type = 'text';
        input.name = 'contact_person';
        input.className = 'input02';
        input.placeholder = 'Enter New Contact Person';
        input.id = 'contactPersonSelect';
        input.style.transition = 'all .2s';
        input.onblur = function() {
            // If input is left empty, revert back to select
            if (!input.value.trim()) {
                parent.innerHTML = `
                    <select id="contactPersonSelect" name="contact_person" class="input02" onchange="handleContactPersonSelect(this);" style="transition:all .2s;">
                        <option value="" disabled selected>Select Contact Person</option>
                        <option value="new_contact">New Contact Person</option>
                    </select>
                `;
            }
        };
        parent.replaceChild(input, select);
        input.focus();
        // Clear autofill fields for new contact
        document.getElementById('contact_number').value = '';
        document.getElementById('contact_email').value = '';
        document.getElementById('office_address').value = '';
    } else if (select.value) {
        autofillContactDetails();
    }
}

function autofillContactDetails() {
    // Only run if the contact person is a select (not input)
    var contactPersonElem = document.getElementById('contactPersonSelect');
    if (!contactPersonElem || contactPersonElem.tagName !== 'SELECT') return;
    let vendorId = document.getElementById('vendorSelect').value;
    let contactPerson = contactPersonElem.value;
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
    document.getElementById('billToSection').classList.remove('active');
    document.getElementById('billToSection').classList.add('hidden');
    document.getElementById('shipToSection').classList.remove('active');
    document.getElementById('shipToSection').classList.add('hidden');
}
function showBillToSection() {
    document.getElementById('productSection').classList.remove('active');
    document.getElementById('productSection').classList.add('hidden');
    document.getElementById('billToSection').classList.remove('hidden');
    document.getElementById('billToSection').classList.add('active');
    document.getElementById('shipToSection').classList.remove('active');
    document.getElementById('shipToSection').classList.add('hidden');
}
function showShipToSection() {
    document.getElementById('billToSection').classList.remove('active');
    document.getElementById('billToSection').classList.add('hidden');
    document.getElementById('shipToSection').classList.remove('hidden');
    document.getElementById('shipToSection').classList.add('active');
}
function showContactSection() {
    document.getElementById('productSection').classList.remove('active');
    document.getElementById('productSection').classList.add('hidden');
    document.getElementById('contactSection').classList.remove('hidden');
    document.getElementById('contactSection').classList.add('active');
    document.getElementById('billToSection').classList.remove('active');
    document.getElementById('billToSection').classList.add('hidden');
    document.getElementById('shipToSection').classList.remove('active');
    document.getElementById('shipToSection').classList.add('hidden');
}

// Autofill contact number when contact person is selected in Bill To
$('#billto_contactperson').on('change', function() {
    let name = $(this).val();
    let found = teamContacts.find(c => c.name === name);
    $('#billto_contactno').val(found ? found.mob_number : '');
});

// Autofill contact number when contact person is selected in Ship To
$('#shipto_contactperson').on('change', function() {
    let name = $(this).val();
    let found = teamContacts.find(c => c.name === name);
    $('#shipto_contactno').val(found ? found.mob_number : '');
});

// --- Product Autocomplete and Autofill ---
function filterProducts(input) {
    let $group = $(input).closest('.product-group');
    let inputVal = $(input).val().toLowerCase();
    let suggestions = $group.find('.productSuggestions')[0];
    let $select = $group.find('.productSelect');
    suggestions.innerHTML = '';
    let found = false;
    vendorProducts.forEach(function(p) {
        if (
            (p.product_name && p.product_name.toLowerCase().includes(inputVal)) ||
            (p.product_serial && p.product_serial.toLowerCase().includes(inputVal))
        ) {
            let div = document.createElement('div');
            div.className = 'suggestion-item';
            div.textContent = p.product_name + ' (' + p.product_serial + ')';
            div.onclick = function() {
                // Set input to serial number, not product name
                $group.find('.productSearch').val(p.product_serial);
                // Ensure the select has the correct option and is selected
                let exists = $select.find('option[value="' + p.product_serial + '"]').length > 0;
                if (!exists) {
                    $select.append($('<option>', {
                        value: p.product_serial,
                        text: p.product_serial
                    }));
                }
                $select.val(p.product_serial);
                $(suggestions).hide();
                autofillProductFields($group, p);
                $group.find('.newProductDiv').addClass('hidden');
            };
            suggestions.appendChild(div);
            found = true;
        }
    });
    if ((!found && inputVal) || inputVal === 'new') {
        let div = document.createElement('div');
        div.className = 'suggestion-item';
        div.textContent = 'New Product';
        div.onclick = function() {
            $group.find('.productSearch').val('New Product');
            $select.val('new_product');
            $(suggestions).hide();
            showNewProductFields($group);
        };
        suggestions.appendChild(div);
    }
    suggestions.style.display = inputVal ? 'block' : 'none';
}
function showProductDropdown(input) {
    let $group = $(input).closest('.product-group');
    $group.find('.productSuggestions').show();
}
function showNewProductFields($group) {
    $group.find('.newProductDiv').removeClass('hidden');
    $group.find('.product_name').val('');
    $group.find('.product_uom').val('');
    $group.find('.unit_price').val('');
}
function autofillProductFields($group, product) {
    $group.find('.product_name').val(product.product_name || '');
    $group.find('.product_uom').val(product.product_uom || '');
    $group.find('.unit_price').val(product.unit_price || '');
    $group.find('.qty').val(product.qty || '');
    let unitPrice = parseFloat(product.unit_price) || 0;
    let qty = parseFloat(product.qty) || 0;
    $group.find('.price').val((unitPrice * qty).toFixed(2));
    $group.find('.newProductDiv').addClass('hidden');
}
function newProductCheck(select) {
    let $group = $(select).closest('.product-group');
    let val = $(select).val();
    $group.find('.newProductDiv').toggleClass('hidden', val !== 'new_product');
    if (val === 'new_product') {
        showNewProductFields($group);
    } else {
        let selected = vendorProducts.find(p => p.product_serial == val);
        if (selected) autofillProductFields($group, selected);
    }
}
function autofillProductDetails(select) {
    let $group = $(select).closest('.product-group');
    let val = $(select).val();
    let selected = vendorProducts.find(p => p.product_serial == val);
    if (selected) autofillProductFields($group, selected);
}
function calcProductPrice(input) {
    let $group = $(input).closest('.product-group');
    let unitPrice = parseFloat($group.find('.unit_price').val()) || 0;
    let qty = parseFloat($group.find('.qty').val()) || 0;
    $group.find('.price').val((unitPrice * qty).toFixed(2));
}

// Product repeater logic (max 5)
let productCount = 1;
$('#addProductBtn').on('click', function() {
    if (productCount >= 5) return;
    let $first = $('#productRepeater .product-group').first();
    let $clone = $first.clone(true, true);
    // Reset all input values in the clone
    $clone.find('input, select').each(function() {
        if ($(this).is('select')) {
            this.selectedIndex = 0;
        } else {
            $(this).val('');
        }
    });
    // Update IDs for new group
    $clone.find('.productSearch').attr('id', 'productSearch_' + productCount);
    $clone.find('.productSelect').attr('id', 'productSelect_' + productCount);
    $clone.find('.productSuggestions').attr('id', 'productSuggestions_' + productCount);
    // Hide newProductDiv by default
    $clone.find('.newProductDiv').addClass('hidden');
    $('#productRepeater').append($clone);
    productCount++;
});
</script>
</body>
</html>
