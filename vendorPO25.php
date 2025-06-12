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

    // Get company name from session for each insert
    $companyname = $_SESSION['companyname'] ?? '';

    // Insert for each product (max 5)
    $max_products = min(5, count($product_names));
    for ($i = 0; $i < $max_products; $i++) {
        $sql = "INSERT INTO vendor_purchase_orders (
            vendor_id, new_vendor_name, contact_person, new_contact_person, contact_number, contact_email, office_address,
            product_serial, new_product_serial, product_name, product_uom, unit_price, qty, price, created_at,
            billto, billto_address, billto_gstn, billto_pan, billto_contactperson, billto_contactno,
            shipto, shipto_address, shipto_gstn, placeofsupply, shipto_contactperson, shipto_contactno,
            companyname
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param(
            "issssssssssddssssssssssssss",
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
            $shipto_contactno,
            $companyname // add companyname from session
        );
        $stmt->execute();
        $stmt->close();
    }

    // --- Insert new contact person into vendor_regional_office if needed ---
    // Only if "New Contact Person" was selected and a name was entered
    // Use $vendor_id (if existing) or get the new vendor's id if created
    $contact_person_to_save = $_POST['contact_person'] ?? '';
    $is_new_contact = false;
    if (isset($_POST['contact_person']) && !empty($_POST['contact_person'])) {
        // If the contact_person is not in the select options, it's a new one (input field)
        // Or if the select value is "new_contact" and a new name is entered
        if (
            (isset($_POST['contact_person']) && isset($_POST['new_contact_person']) && !empty($_POST['new_contact_person']))
            || (isset($_POST['contact_person']) && !in_array($_POST['contact_person'], array_column($team_contacts, 'name')))
        ) {
            $is_new_contact = true;
            $contact_person_to_save = $_POST['new_contact_person'] ?? $_POST['contact_person'];
        }
    }

    // If new vendor, get its id (after insert)
    if ($vendor_id === null && !empty($new_vendor_name)) {
        // Try to get the vendor id by name and company
        $stmt = $conn->prepare("SELECT id FROM vendors WHERE vendor_name = ? AND companyname = ? ORDER BY id DESC LIMIT 1");
        $stmt->bind_param("ss", $new_vendor_name, $companyname);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $vendor_id_for_office = $row['id'];
        } else {
            $vendor_id_for_office = null;
        }
        $stmt->close();
    } else {
        $vendor_id_for_office = $vendor_id;
    }

    if ($is_new_contact && $vendor_id_for_office) {
        // Insert into vendor_regional_office
        $office_address_to_save = $_POST['office_address'] ?? '';
        $contact_number_to_save = $_POST['contact_number'] ?? '';
        $contact_email_to_save = $_POST['contact_email'] ?? '';
        $state_to_save = ''; // You can add a field for state in the form if needed

        $stmt = $conn->prepare("INSERT INTO vendor_regional_office (vendor_id, office_address, state, contact_person, contact_number, contact_email) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param(
            "isssss",
            $vendor_id_for_office,
            $office_address_to_save,
            $state_to_save,
            $contact_person_to_save,
            $contact_number_to_save,
            $contact_email_to_save
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
       
        . select { width: 100%; padding: 8px; font-size: 1.1rem; border: 1px solid #ccc; border-radius: 4px; }
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
        /* Add a little spacing for product group */

        .product-header {
            margin-bottom: 10px;
        }
        .remove-product-btn:hover {
            color: blue;
        }
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

  
<!-- First row -->
     <div id="equipmentinfosectioncontainer">
        <p class="headingpara">Product Information</p> 
        <div class="outer02 product-outer">
    <div class="trial1">
        <input type="text" class="input02 productSearch" autocomplete="off" onkeyup="filterProducts(this)" onclick="showProductDropdown(this)">
        <select name="product_serial[]" class="input02 productSelect" style="display:none;" onchange="autofillProductDetails(this); newProductCheck(this);">
            <option value="" disabled selected>Select Product</option>
            <option value="new_product">New Product</option>
        </select>
        <div class="suggestions productSuggestions" style="display:none; position:absolute; z-index:100;"></div>
        <label class="placeholder2">Product Serial Number/Code</label>
    </div>
    <div class="trial1">
        <div class="trial1 hidden newProductDiv">
            <input type="text" name="new_product_serial[]" class="input02">
            <label class="placeholder2">New Product Serial/Code</label>
        </div>
        <div class="trial1">
            <input type="text" class="input02 product_name" name="product_name[]">
            <label class="placeholder2">Product Name (Code HSN/SAC)</label>
        </div>
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
</div>
        <div class="outer02 product-outer">
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
    <div class="addbuttonicon" id="second_addequipbtn"><i onclick="other_quotation()"  class="bi bi-plus-circle">Add Another Equipment</i></div>
    <div class="otherquipquote" id="new_out1">
        <br> 

        <!-- Secondrow -->
        <p class="add_second_equipment_generate">Add Second Equipment Details <i onclick="cancelsecondequipment()" class="bi bi-x icon-cancel"></i></p> 
            <div class="outer02 product-outer">
    <div class="trial1">
        <input type="text" class="input02 productSearch" autocomplete="off" onkeyup="filterProducts(this)" onclick="showProductDropdown(this)">
        <select name="product_serial[]" class="input02 productSelect" style="display:none;" onchange="autofillProductDetails(this); newProductCheck(this);">
            <option value="" disabled selected>Select Product</option>
            <option value="new_product">New Product</option>
        </select>
        <div class="suggestions productSuggestions" style="display:none; position:absolute; z-index:100;"></div>
        <label class="placeholder2">Product Serial Number/Code</label>
    </div>
    <div class="trial1">
        <div class="trial1 hidden newProductDiv">
            <input type="text" name="new_product_serial[]" class="input02">
            <label class="placeholder2">New Product Serial/Code</label>
        </div>
        <div class="trial1">
            <input type="text" class="input02 product_name" name="product_name[]">
            <label class="placeholder2">Product Name (Code HSN/SAC)</label>
        </div>
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
</div>
        <div class="outer02 product-outer">
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
        <div class="addbuttonicon" id="third_addequipbtn"><i onclick="third_vehicle()"  class="bi bi-plus-circle">Add Another Equipment</i></div>
        </div>


    <!-- thirdrow -->
    <div class="otherquipquote" id="thirdvehicledetail">
        <br>
        <p class="add_second_equipment_generate">Add Third Equipment Details <i onclick="cancelthirdequipment()" title="cancel" class="bi bi-x icon-cancel"></i></p> 
           <div class="outer02 product-outer">
    <div class="trial1">
        <input type="text" class="input02 productSearch" autocomplete="off" onkeyup="filterProducts(this)" onclick="showProductDropdown(this)">
        <select name="product_serial[]" class="input02 productSelect" style="display:none;" onchange="autofillProductDetails(this); newProductCheck(this);">
            <option value="" disabled selected>Select Product</option>
            <option value="new_product">New Product</option>
        </select>
        <div class="suggestions productSuggestions" style="display:none; position:absolute; z-index:100;"></div>
        <label class="placeholder2">Product Serial Number/Code</label>
    </div>
    <div class="trial1">
        <div class="trial1 hidden newProductDiv">
            <input type="text" name="new_product_serial[]" class="input02">
            <label class="placeholder2">New Product Serial/Code</label>
        </div>
        <div class="trial1">
            <input type="text" class="input02 product_name" name="product_name[]">
            <label class="placeholder2">Product Name (Code HSN/SAC)</label>
        </div>
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
</div>
        <div class="outer02 product-outer">
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
        <div class="addbuttonicon" id="fourth_addequipbtn"><i onclick="fourth_quotation()"  class="bi bi-plus-circle">Add Another Equipment</i></div>
        </div>


    <!-- fourthrow -->
    <div class="otherquipquote" id="fouthvehicledata">
        <br>
        <p class="add_second_equipment_generate">Add Fourth Equipment Details <i onclick="cancelfourthequipment()" class="bi bi-x icon-cancel"></i></p> 
           <div class="outer02 product-outer">
    <div class="trial1">
        <input type="text" class="input02 productSearch" autocomplete="off" onkeyup="filterProducts(this)" onclick="showProductDropdown(this)">
        <select name="product_serial[]" class="input02 productSelect" style="display:none;" onchange="autofillProductDetails(this); newProductCheck(this);">
            <option value="" disabled selected>Select Product</option>
            <option value="new_product">New Product</option>
        </select>
        <div class="suggestions productSuggestions" style="display:none; position:absolute; z-index:100;"></div>
        <label class="placeholder2">Product Serial Number/Code</label>
    </div>
    <div class="trial1">
        <div class="trial1 hidden newProductDiv">
            <input type="text" name="new_product_serial[]" class="input02">
            <label class="placeholder2">New Product Serial/Code</label>
        </div>
        <div class="trial1">
            <input type="text" class="input02 product_name" name="product_name[]">
            <label class="placeholder2">Product Name (Code HSN/SAC)</label>
        </div>
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
</div>
        <div class="outer02 product-outer">
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
        <div class="addbuttonicon" id="fifth_addequipbtn"><i onclick="fifth_quotation()"  class="bi bi-plus-circle">Add Another Equipment</i></div>

        <!-- <div class="addbuttonicon" id="lastaddequipbtn"><i onclick="addanother_equip()"  class="bi bi-plus-circle"></i><p>Add Another Equipment</p></div> -->
        </div>

    <!-- fifthrow -->
            <div class="outer02 product-outer">
    <div class="trial1">
        <input type="text" class="input02 productSearch" autocomplete="off" onkeyup="filterProducts(this)" onclick="showProductDropdown(this)">
        <select name="product_serial[]" class="input02 productSelect" style="display:none;" onchange="autofillProductDetails(this); newProductCheck(this);">
            <option value="" disabled selected>Select Product</option>
            <option value="new_product">New Product</option>
        </select>
        <div class="suggestions productSuggestions" style="display:none; position:absolute; z-index:100;"></div>
        <label class="placeholder2">Product Serial Number/Code</label>
    </div>
    <div class="trial1">
        <div class="trial1 hidden newProductDiv">
            <input type="text" name="new_product_serial[]" class="input02">
            <label class="placeholder2">New Product Serial/Code</label>
        </div>
        <div class="trial1">
            <input type="text" class="input02 product_name" name="product_name[]">
            <label class="placeholder2">Product Name (Code HSN/SAC)</label>
        </div>
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
</div>
        <div class="outer02 product-outer">
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
        <!-- <div class="addbuttonicon" id="lastaddequipbtn"><i onclick="addanother_equip()"  class="bi bi-plus-circle"></i><p>Add Another Equipment</p></div> -->
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

<button
  class="quotationnavigatebutton bg-white text-center w-30 rounded-lg h-10 relative text-black text-sm font-semibold group"
  type="button" onclick=" showBillToSection()"
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
  <p class="translate-x-1" >Next</p>
</button>

</div>
<br>


    </div>
   

    <!-- ===================== BILL TO SECTION ===================== -->
    <div id="billToSection" class="generate_quote_container form-section hidden" > 
         <div id="contactpersonsectioncontainer" >
        <div class="headingpara" style="background: #2253a3; color: #fff; padding: 18px 0 14px 32px; border-radius: 8px 8px 0 0; margin: 0; font-size: 1.25rem; font-weight: 600; box-sizing: border-box;">
            Bill To Details
        </div>
            <div class="outer02" id="quoteouter02">
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
                </div> 
                         <div class="outer02" id="quoteouter02">
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
    </div>

    <!-- ===================== SHIP TO SECTION ===================== --> 
    <div id="shipToSection" class="generate_quote_container form-section hidden"> 
        <div id="contactpersonsectioncontainer" >
        <div class="headingpara" style="background: #2253a3; color: #fff; padding: 18px 0 14px 32px; border-radius: 8px 8px 0 0; margin: 0; font-size: 1.25rem; font-weight: 600; box-sizing: border-box;">
            Ship To Details
        </div>
    
            <div class="outer02" style="margin-top:0;">
                <div class="trial1">
                    <input type="text" name="shipto" class="input02"value="<?php echo htmlspecialchars($billto_detail['companyname'] ?? ''); ?>">
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
                </div> 
                <div class="outer02" style="margin-top:0;">
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
// Use index-based targeting for autofill
function filterProducts(input) {
    let $input = $(input);
    let inputVal = $input.val().toLowerCase();
    let suggestions = $input.siblings('.productSuggestions')[0];
    let $select = $input.siblings('.productSelect');
    suggestions.innerHTML = '';
    let found = false;

    // Find the index of this product serial input among all product serials
    let idx = $('input.productSearch').index($input);

    vendorProducts.forEach(function(p) {
        if (
            (p.product_serial && p.product_serial.toLowerCase().includes(inputVal))
            || (p.product_name && p.product_name.toLowerCase().includes(inputVal))
        ) {
            let div = document.createElement('div');
            div.className = 'suggestion-item';
            div.textContent = p.product_serial + (p.product_name ? ' (' + p.product_name + ')' : '');
            div.onclick = function() {
                $input.val(p.product_serial);
                let exists = $select.find('option[value="' + p.product_serial + '"]').length > 0;
                if (!exists) {
                    $select.append($('<option>', {
                        value: p.product_serial,
                        text: p.product_serial
                    }));
                }
                $select.val(p.product_serial);
                $(suggestions).hide();
                autofillProductFields(idx, p);
                // Hide newProductDiv for this index
                $('.newProductDiv').eq(idx).addClass('hidden');
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
            $input.val('New Product');
            $select.val('new_product');
            $(suggestions).hide();
            showNewProductFields(idx);
        };
        suggestions.appendChild(div);
    }
    suggestions.style.display = inputVal ? 'block' : 'none';
}

function showProductDropdown(input) {
    $(input).siblings('.productSuggestions').show();
}

function showNewProductFields(idx) {
    $('.newProductDiv').eq(idx).removeClass('hidden');
    $('input.product_name').eq(idx).val('');
    $('select.product_uom').eq(idx).val('');
    $('input.unit_price').eq(idx).val('');
    $('input.qty').eq(idx).val('');
    $('input.price').eq(idx).val('');
}

function autofillProductFields(idx, product) {
    $('input.product_name').eq(idx).val(product.product_name || '');
    $('select.product_uom').eq(idx).val(product.product_uom || '');
    $('input.unit_price').eq(idx).val(product.unit_price || '');
    $('input.qty').eq(idx).val(product.qty || '');
    let unitPrice = parseFloat(product.unit_price) || 0;
    let qty = parseFloat(product.qty) || 0;
    $('input.price').eq(idx).val((unitPrice * qty).toFixed(2));
    $('.newProductDiv').eq(idx).addClass('hidden');
}

function newProductCheck(select) {
    let $select = $(select);
    let idx = $('select.productSelect').index($select);
    let val = $select.val();
    if (val === 'new_product') {
        showNewProductFields(idx);
    } else {
        let selected = vendorProducts.find(p => p.product_serial == val);
        if (selected) autofillProductFields(idx, selected);
    }
}
function autofillProductDetails(select) {
    let $select = $(select);
    let idx = $('select.productSelect').index($select);
    let val = $select.val();
    let selected = vendorProducts.find(p => p.product_serial == val);
    if (selected) autofillProductFields(idx, selected);
}
function calcProductPrice(input) {
    let $input = $(input);
    let idx = $('input.unit_price, input.qty').index($input);
    // Find the correct index for unit_price and qty
    let unitPrice = parseFloat($('input.unit_price').eq(idx).val()) || 0;
    let qty = parseFloat($('input.qty').eq(idx).val()) || 0;
    $('input.price').eq(idx).val((unitPrice * qty).toFixed(2));
}

// Validate required fields before moving to next section
function validateSection(sectionId) {
    let valid = true;
    $('#' + sectionId + ' .input02:visible[required], #' + sectionId + ' select:visible[required]').each(function() {
        if (!$(this).val()) {
            $(this).addClass('input-error');
            valid = false;
        } else {
            $(this).removeClass('input-error');
        }
    });
    return valid;
}

// Add red border for invalid fields
$('<style>.input-error{border:2px solid #e74c3c !important;}</style>').appendTo('head');

// Override navigation buttons
function showProductSection() {
    if (!validateSection('contactSection')) return;
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
    if (!validateSection('productSection')) return;
    document.getElementById('productSection').classList.remove('active');
    document.getElementById('productSection').classList.add('hidden');
    document.getElementById('billToSection').classList.remove('hidden');
    document.getElementById('billToSection').classList.add('active');
    document.getElementById('shipToSection').classList.remove('active');
    document.getElementById('shipToSection').classList.add('hidden');
}
function showShipToSection() {
    if (!validateSection('billToSection')) return;
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

// Only validate required fields in the visible section on submit
$('#vendorPOForm').on('submit', function(e) {
    // Remove required from all hidden fields
    $('.form-section.hidden [required]').each(function() {
        $(this).removeAttr('required').addClass('was-required');
    });
    // Validate only visible required fields
    let valid = true;
    $('.form-section.active [required]').each(function() {
        if (!$(this).val()) {
            $(this).addClass('input-error');
            valid = false;
        } else {
            $(this).removeClass('input-error');
        }
    });
    if (!valid) {
        e.preventDefault();
        // Restore required to hidden fields immediately
        $('.was-required').attr('required', true).removeClass('was-required');
        return false;
    }
    // Restore required to hidden fields after short delay (for next submit)
    setTimeout(function() {
        $('.was-required').attr('required', true).removeClass('was-required');
    }, 100);
});

// Add/Remove Product Logic
const maxProducts = 5;
// Helper to update product group indexes and field IDs/names
function updateProductGroupIndexes() {
    $('#productRepeater .product-group').each(function(idx, group) {
        $(group).find('.productSearch').attr('id', 'productSearch_' + idx);
        $(group).find('.productSelect').attr('id', 'productSelect_' + idx);
    });
    // Show remove button only if more than 1 group
    $('#productRepeater .product-group').each(function(i, group) {
        $(group).find('.remove-product-btn').toggle(i > 0);
    });
}

// Add Product button logic
$('#addProductBtn').on('click', function() {
    let count = $('#productRepeater .product-group').length;
    if (count >= maxProducts) return;
    let $last = $('#productRepeater .product-group').last();
    let $clone = $last.clone(true, true);

    // Clear all input/select values in the clone
    $clone.find('input, select').each(function() {
        if (this.type === 'select-one') {
            this.selectedIndex = 0;
        } else {
            $(this).val('');
        }
    });
    $clone.find('.productSuggestions').hide().empty();
    $clone.find('.newProductDiv').addClass('hidden');
    $clone.insertAfter($last);
    updateProductGroupIndexes();
});

// Remove Product button logic
function removeProductGroup(btn) {
    if ($('#productRepeater .product-group').length > 1) {
        $(btn).closest('.product-group').remove();
        updateProductGroupIndexes();
    }
}

// Update indexes on page load
$(function() {
    updateProductGroupIndexes();
});
</script>
</body>
</html>
