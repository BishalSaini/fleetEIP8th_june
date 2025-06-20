<?php
include_once 'partials/_dbconnect.php';
$showAlert = false;
$showError = false;
$showAlertuser=false;

session_start();
if (isset($_POST['submit_po'])) {
    $vendor_id = $_POST['vendor_id'] ?? 0;
    $vendor_name = $_POST['vendor_name'] ?? '';
    $salutation = $_POST['salutation_dd'] ?? '';
    $contact_person = $_POST['contact_person'] ?? '';
    $new_contact_person = $_POST['new_contact_person'] ?? '';
    $to_address = $_POST['to_address'] ?? '';
    $contact_number = $_POST['contact_number'] ?? '';
    $email_id = $_POST['email_id'] ?? '';
    $companyname = $_POST['comp_name_trial'] ?? '';
    $bill_to_name = $_POST['bill_to_name'] ?? '';
    $bill_to_address = $_POST['bill_to_address'] ?? '';
    $bill_to_gstin = $_POST['bill_to_gstin'] ?? '';
    $bill_to_pan = $_POST['bill_to_pan'] ?? '';
    $bill_to_contact = $_POST['bill_to_contact'] ?? '';
    $bill_to_email = $_POST['bill_to_email'] ?? '';
    $ship_to_name = $_POST['ship_to_name'] ?? '';
    $ship_to_address = $_POST['ship_to_address'] ?? '';
    $ship_to_gstin = $_POST['ship_to_gstin'] ?? '';
    $ship_to_pan = $_POST['ship_to_pan'] ?? '';
    $ship_to_contact = $_POST['ship_to_contact'] ?? '';
    $ship_to_email = $_POST['ship_to_email'] ?? '';

    // Insert main PO (header) data
    $stmt = $conn->prepare("INSERT INTO purchase_orders (
        vendor_id, vendor_name, salutation, contact_person, new_contact_person, to_address, contact_number, email_id, companyname,
        bill_to_name, bill_to_address, bill_to_gstin, bill_to_pan, bill_to_contact, bill_to_email,
        ship_to_name, ship_to_address, ship_to_gstin, ship_to_pan, ship_to_contact, ship_to_email
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param(
        "issssssssssssssssssss",
        $vendor_id, $vendor_name, $salutation, $contact_person, $new_contact_person, $to_address, $contact_number, $email_id, $companyname,
        $bill_to_name, $bill_to_address, $bill_to_gstin, $bill_to_pan, $bill_to_contact, $bill_to_email,
        $ship_to_name, $ship_to_address, $ship_to_gstin, $ship_to_pan, $ship_to_contact, $ship_to_email
    );
    if ($stmt->execute()) {
        $po_id = $stmt->insert_id;
        $stmt->close();
        // Insert product lines for each product if present
        $stmt2 = $conn->prepare("INSERT INTO purchase_order_products (
            po_id, product_serial, product_name, product_uom, unit_price, qty, total_price
        ) VALUES (?, ?, ?, ?, ?, ?, ?)");
        for ($i = 1; $i <= 5; $i++) {
            $serial = $_POST['product_serial_' . $i] ?? '';
            $name = $_POST['product_name_' . $i] ?? '';
            $uom = $_POST['product_uom_' . $i] ?? '';
            $unit_price = $_POST['unit_price_' . $i] ?? '';
            $qty = $_POST['qty_' . $i] ?? '';
            $total = $_POST['total_price_' . $i] ?? '';
            if (!empty($serial)) {
                $stmt2->bind_param("isssddd", $po_id, $serial, $name, $uom, $unit_price, $qty, $total);
                $stmt2->execute();
            }
        }
        $stmt2->close();
        $showAlert = true;
        header("Location: vendorPOView.php");
        exit;
    } else {
        $showError = true;
    }
}

$companyname001 = $_SESSION['companyname'] ?? '';
$enterprise = $_SESSION['enterprise'] ?? '';
$dashboard_url = '';
if ($enterprise === 'rental') {
    $dashboard_url = 'rental_dashboard.php';
} elseif ($enterprise === 'logistics') {
    $dashboard_url = 'logisticsdashboard.php';
} 
elseif ($enterprise === 'epc') {
    $dashboard_url = 'epc_dashboard.php';
}  

// Fetch vendors for this company
$vendors = [];
$stmt_vendors = $conn->prepare("SELECT id, vendor_name FROM vendors WHERE companyname = ? ORDER BY vendor_name ASC");
$stmt_vendors->bind_param("s", $companyname001);
$stmt_vendors->execute();
$result_vendors = $stmt_vendors->get_result();
while ($row = $result_vendors->fetch_assoc()) {
    $vendors[] = $row;
}
$stmt_vendors->close();

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <link rel="icon" href="favicon.jpg" type="image/x-icon">

        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
        <!-- Only one jQuery include before your code -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <title>PO</title>
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css"
            rel="stylesheet">
        <link
            rel="stylesheet"
            href="https://code.jquery.com/ui/1.13.3/themes/base/jquery-ui.css">
        <!-- Remove duplicate jQuery and unnecessary inline JS includes -->
        <style><?php include "style.css" ?></style>
        <script><?php include "main.js" ?></script>
        <script><?php include "autofill.js" ?></script>
        <script scr="autofill.js" defer="defer"></script>
        <script scr="main.js" defer="defer"></script>
        <style>
            #vendorDropdown.dropdown-menu {
                box-shadow: 0 2px 8px rgba(0,0,0,0.08);
                border-radius: 0 0 4px 4px;
                padding: 0;
                margin: 0;
            }
            #vendorDropdown li {
                list-style: none;
                padding: 8px 16px;
                cursor: pointer;
                border-bottom: 1px solid #eee;
                transition: background 0.2s;
            }
            #vendorDropdown li:last-child {
                border-bottom: none;
            }
            #vendorDropdown li:hover {
                background: #f1f1f1;
            }
            #productNameDropdown.dropdown-menu,
            #productSerialDropdown.dropdown-menu {
                box-shadow: 0 2px 8px rgba(0,0,0,0.08);
                border-radius: 0 0 4px 4px;
                padding: 0;
                margin: 0;
                position: absolute;
                background: #fff;
                z-index: 1000;
                width: 100%;
                border: 1px solid #ccc;
                max-height: 180px;
                overflow-y: auto;
            }
            #productNameDropdown li,
            #productSerialDropdown li {
                list-style: none;
                padding: 8px 16px;
                cursor: pointer;
                border-bottom: 1px solid #eee;
                transition: background 0.2s;
            }
            #productNameDropdown li:last-child,
            #productSerialDropdown li:last-child {
                border-bottom: none;
            }
            #productNameDropdown li:hover,
            #productSerialDropdown li:hover {
                background: #f1f1f1;
            }
            .product-dropdown.dropdown-menu {
                box-shadow: 0 2px 8px rgba(0,0,0,0.08);
                border-radius: 0 0 4px 4px;
                padding: 0;
                margin: 0;
                position: absolute;
                background: #fff;
                z-index: 1000;
                width: 100%;
                border: 1px solid #ccc;
                max-height: 180px;
                overflow-y: auto;
            }
            .product-dropdown li {
                list-style: none;
                padding: 8px 16px;
                cursor: pointer;
                border-bottom: 1px solid #eee;
                transition: background 0.2s;
            }
            .product-dropdown li:last-child {
                border-bottom: none;
            }
            .product-dropdown li:hover {
                background: #f1f1f1;
            }

            .product-dropdown li:last-child {
                border-bottom: none;
            }
            .product-dropdown li:hover {
                background: #f1f1f1;
            }
        </style>

    </head>
    <body>
        <div class="navbar1">
            <div class="logo_fleet">
                <img
                    src="logo_fe.png"
                    alt="FLEET EIP"
                    onclick="window.location.href='<?php echo $dashboard_url  ?>'">
            </div>

            <div class="iconcontainer">
                <ul>
                    <li>
                        <a href="<?php echo $dashboard_url ?>">Dashboard</a>
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

        <form
            action=""
            method="POST"
            id="vendorPOForm"
            class="generate_quotation"
            autocomplete="off"
            enctype="multipart/form-data">
            <div class="generate_quote_container">
                <div id="contactpersonsectioncontainer">
                    <p class="headingpara">Vendor Contact Section</p>
                    <!-- <div class="generate_quote_heading">Generate Quotation</div> -->

                    <div class="outer02" id="quoteouter02">
                        <div class="trial1" id="newrentalclient" style="display:none;">
                            <input
                                type="text"
                                placeholder=""
                                name="newrentalclient"
                                class="input02"
                                id="newrentalclient_input">
                            <label for="newrentalclient_input" class="placeholder2">New vendor name</label>
                        </div>

                        <div class="trial1" id="vendorSelectouter" style="position:relative;">
                            <input
                                type="text"
                                id="vendor_name"
                                class="input02"
                                placeholder=""
                                autocomplete="off"/>
                            <input type="hidden" id="vendorSelect" name="vendor"/>
                            <input type="hidden" id="vendor_id" name="vendor_id"/>
                            <ul
                                id="vendorDropdown"
                                class="dropdown-menu show"
                                style="display:none; position:absolute; top:100%; left:0; width:100%; z-index:1000; background:#fff; border:1px solid #ccc; border-radius:0 0 4px 4px; max-height:180px; overflow-y:auto; padding:0; margin:0;"></ul>
                            <label for="vendor_name" class="placeholder2">Vendor Name</label>
                        </div>
                        <div class="trial1" id="salute_dd">
                            <select name="salutation_dd" class="input02" required="required">
                                <option value="Mr">Mr</option>
                                <option value="Ms">Ms</option>
                            </select>
                        </div>
                        <div class="trial1" id="contactSelectouter">
                            <select id="vendorContactSelect" name="contact_person" class="input02">
                                <option value="" disabled="disabled" selected="selected">Select Contact Person</option>
                                <!-- Options will be loaded by JS -->
                                <option value="new_contact_person">New Contact Person</option>
                            </select>
                            <input
                                type="text"
                                id="vendorContactInput"
                                name="contact_person"
                                class="input02"
                                placeholder="Enter new contact person name"
                                style="display:none; margin-top:8px;"/>
                            <label for="vendorContactSelect" class="placeholder2">Contact Person</label>
                        </div>

                    </div>

                    <div class="outer02">
                        <div class="trial1">
                            <input
                                type="text"
                                placeholder=""
                                id="vendor_address"
                                name="to_address"
                                class="input02">
                            <label for="vendor_address" class="placeholder2">Office Address</label>
                        </div>

                        <div class="trial1" id="contact_number1">
                            <input
                                type="text"
                                placeholder=""
                                id="vendor_contact_number"
                                name="contact_number"
                                class="input02">
                            <label for="vendor_contact_number" class="placeholder2">Contact Number</label>
                        </div>

                        <div class="trial1 ">
                            <input
                                type="text"
                                placeholder=""
                                id="vendor_email"
                                name="email_id"
                                class="input02">
                            <label for="vendor_email" class="placeholder2">Contact Email</label>
                        </div>
                    </div>
                    <input
                        type="text"
                        value="<?php echo $companyname001 ?>"
                        id="comp_name_trial"
                        name="comp_name_trial"
                        hidden="hidden">

                    <button
                        class="quotationnavigatebutton bg-white text-center w-30 rounded-lg h-10 relative text-black text-sm font-semibold group"
                        type="button"
                        onclick="equipmentsection()">
                        <div
                            class="bg-custom-blue rounded-md h-8 w-1/4 flex items-center justify-center absolute left-1 top-[2px] group-hover:w-[110px] z-10 duration-300"
                            style="background-color: #1C549E;">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                viewbox="0 0 1024 1024"
                                height="18px"
                                width="18px"
                                transform="rotate(180)">
                                <path d="M224 480h640a32 32 0 1 1 0 64H224a32 32 0 0 1 0-64z" fill="white"></path>
                                <path
                                    d="m237.248 512 265.408 265.344a32 32 0 0 1-45.312 45.312l-288-288a32 32 0 0 1 0-45.312l288-288a32 32 0 1 1 45.312 45.312L237.248 512z"
                                    fill="white"></path>
                            </svg>
                        </div>
                        <p class="translate-x-1">Next</p>
                    </button>
                </div>
                <!-- Product Information Section -->
                <div id="equipmentinfosectioncontainer">
                    <p class="headingpara">Product Information</p>
                    <br>
                    <div class="outer02 product-group" data-group="1" id="quoteouter02">
                        <div class="trial1">
                            <input
                                type="text"
                                placeholder=""
                                id="product_serial_1"
                                name="product_serial_1"
                                class="input02 product-autocomplete"
                                autocomplete="off"
                                required="required">
                            <ul
                                id="productSerialDropdown_1"
                                class="dropdown-menu show product-dropdown"
                                style="display:none; position:absolute; top:100%; left:0; width:100%; z-index:1000; background:#fff; border:1px solid #ccc; border-radius:0 0 4px 4px; max-height:180px; overflow-y:auto; padding:0; margin:0;"></ul>
                            <label for="product_serial_1" class="placeholder2">Product Serial Number/Code</label>
                        </div>
                        <div class="trial1">
                            <input
                                type="text"
                                placeholder=""
                                id="product_name_1"
                                name="product_name_1"
                                class="input02 product-autocomplete"
                                autocomplete="off"
                                required="required">
                            <ul
                                id="productNameDropdown_1"
                                class="dropdown-menu show product-dropdown"
                                style="display:none; position:absolute; top:100%; left:0; width:100%; z-index:1000; background:#fff; border:1px solid #ccc; border-radius:0 0 4px 4px; max-height:180px; overflow-y:auto; padding:0; margin:0;"></ul>
                            <label for="product_name_1" class="placeholder2">Product Name (Code HSN/SAC)</label>
                        </div>
                        <div class="trial1 ">
                            <select class="input02" name="product_uom_1" id="product_uom_1" required="required">
                                <option value="" disabled="disabled" selected="selected">Select UoM</option>
                                <option value="set">Set</option>
                                <option value="nos">Nos</option>
                                <option value="kgs">Kgs</option>
                                <option value="meter">Meter</option>
                                <option value="litre">Litre</option>
                            </select>
                            <label for="product_uom_1" class="placeholder2">UoM (Unit of Measurement)</label>
                        </div>
                    </div>
                    <div class="outer02 product-group" data-group="1">
                        <div class="trial1">
                            <input
                                placeholder=""
                                id="unit_price_1"
                                name="unit_price_1"
                                class="input02"
                                required="required">
                            <label for="unit_price_1" class="placeholder2">Unit Price</label>
                        </div>
                        <div class="trial1" id="contact_number1">
                            <input type="text" placeholder="" id="qty_1" name="qty_1" class="input02" required="required">
                            <label for="qty_1" class="placeholder2">QTY</label>
                        </div>
                        <div class="trial1 ">
                            <input
                                type="text"
                                placeholder=""
                                id="total_price_1"
                                name="total_price_1"
                                class="input02"
                                readonly="readonly"
                                required="required">
                            <label for="total_price_1" class="placeholder2">Price (Unit Price × Qty)</label>
                        </div>
                    </div>
                    <input
                        type="text"
                        value="<?php echo $companyname001 ?>"
                        id="comp_name_trial"
                        hidden="hidden">

                    <div class="addbuttonicon" id="second_addequipbtn">
                        <i onclick="other_quotation()" class="bi bi-plus-circle">Add Another Equipment</i>
                    </div>
                    <div class="otherquipquote" id="new_out1">
                        <br>
                        <p class="add_second_equipment_generate">Add Second Product Details
                            <i onclick="cancelsecondequipment()" class="bi bi-x icon-cancel"></i>
                        </p>
                        <div class="outer02 mt-10px product-group" data-group="2">
                            <div class="trial1">
                                <input
                                    type="text"
                                    placeholder=""
                                    id="product_serial_2"
                                    name="product_serial_2"
                                    class="input02 product-autocomplete"
                                    autocomplete="off"
                                    >
                                <ul
                                    id="productSerialDropdown_2"
                                    class="dropdown-menu show product-dropdown"
                                    style="display:none; position:absolute; top:100%; left:0; width:100%; z-index:1000; background:#fff; border:1px solid #ccc; border-radius:0 0 4px 4px; max-height:180px; overflow-y:auto; padding:0; margin:0;"></ul>
                                <label for="product_serial_2" class="placeholder2">Product Serial Number/Code</label>
                            </div>
                            <div class="trial1">
                                <input
                                    type="text"
                                    placeholder=""
                                    id="product_name_2"
                                    name="product_name_2"
                                    class="input02 product-autocomplete"
                                    autocomplete="off"
                                >
                                <ul
                                    id="productNameDropdown_2"
                                    class="dropdown-menu show product-dropdown"
                                    style="display:none; position:absolute; top:100%; left:0; width:100%; z-index:1000; background:#fff; border:1px solid #ccc; border-radius:0 0 4px 4px; max-height:180px; overflow-y:auto; padding:0; margin:0;"></ul>
                                <label for="product_name_2" class="placeholder2">Product Name (Code HSN/SAC)</label>
                            </div>
                            <div class="trial1 ">
                                <select
                                    class="input02"
                                    name="product_uom_2"
                                    id="product_uom_2"
                                    >
                                    <option value="" disabled="disabled" selected="selected">Select UoM</option>
                                    <option value="set">Set</option>
                                    <option value="nos">Nos</option>
                                    <option value="kgs">Kgs</option>
                                    <option value="meter">Meter</option>
                                    <option value="litre">Litre</option>
                                </select>
                                <label for="product_uom_2" class="placeholder2">UoM (Unit of Measurement)</label>
                            </div>
                        </div>
                        <div class="outer02 product-group" data-group="2">
                            <div class="trial1">
                                <input
                                    type="text"
                                    placeholder=""
                                    id="unit_price_2"
                                    name="unit_price_2"
                                    class="input02"
                                    >
                                <label for="unit_price_2" class="placeholder2">Unit Price</label>
                            </div>
                            <div class="trial1" id="contact_number1">
                                <input
                                    type="text"
                                    placeholder=""
                                    id="qty_2"
                                    name="qty_2"
                                    class="input02"
                                    >
                                <label for="qty_2" class="placeholder2">QTY</label>
                            </div>
                            <div class="trial1 ">
                                <input
                                    type="text"
                                    placeholder=""
                                    id="total_price_2"
                                    name="total_price_2"
                                    class="input02"
                                    readonly="readonly"
                                    >
                                <label for="total_price_2" class="placeholder2">Price (Unit Price × Qty)</label>
                            </div>
                        </div>
                        <div class="addbuttonicon" id="third_addequipbtn">
                            <i onclick="third_vehicle()" class="bi bi-plus-circle">Add Another Equipment</i>
                        </div>
                    </div>

                    <!-- thirdrow -->
                    <div class="otherquipquote" id="thirdvehicledetail">
                        <br>
                        <p class="add_second_equipment_generate">Add Third Product Details
                            <i onclick="cancelthirdequipment()" title="cancel" class="bi bi-x icon-cancel"></i>
                        </p>
                        <div class="outer02 mt-10px product-group" data-group="3">
                            <div class="trial1">
                                <input
                                    type="text"
                                    placeholder=""
                                    id="product_serial_3"
                                    name="product_serial_3"
                                    class="input02 product-autocomplete"
                                    autocomplete="off"
                                    >
                                <ul
                                    id="productSerialDropdown_3"
                                    class="dropdown-menu show product-dropdown"
                                    style="display:none; position:absolute; top:100%; left:0; width:100%; z-index:1000; background:#fff; border:1px solid #ccc; border-radius:0 0 4px 4px; max-height:180px; overflow-y:auto; padding:0; margin:0;"></ul>
                                <label for="product_serial_3" class="placeholder2">Product Serial Number/Code</label>
                            </div>
                            <div class="trial1">
                                <input
                                    type="text"
                                    placeholder=""
                                    id="product_name_3"
                                    name="product_name_3"
                                    class="input02 product-autocomplete"
                                    autocomplete="off"
                                >
                                <ul
                                    id="productNameDropdown_3"
                                    class="dropdown-menu show product-dropdown"
                                    style="display:none; position:absolute; top:100%; left:0; width:100%; z-index:1000; background:#fff; border:1px solid #ccc; border-radius:0 0 4px 4px; max-height:180px; overflow-y:auto; padding:0; margin:0;"></ul>
                                <label for="product_name_3" class="placeholder2">Product Name (Code HSN/SAC)</label>
                            </div>
                            <div class="trial1 ">
                                <select
                                    class="input02"
                                    name="product_uom_3"
                                    id="product_uom_3"
                                    >
                                    <option value="" disabled="disabled" selected="selected">Select UoM</option>
                                    <option value="set">Set</option>
                                    <option value="nos">Nos</option>
                                    <option value="kgs">Kgs</option>
                                    <option value="meter">Meter</option>
                                    <option value="litre">Litre</option>
                                </select>
                                <label for="product_uom_3" class="placeholder2">UoM (Unit of Measurement)</label>
                            </div>
                        </div>
                        <div class="outer02 product-group" data-group="3">
                            <div class="trial1">
                                <input
                                    type="text"
                                    placeholder=""
                                    id="unit_price_3"
                                    name="unit_price_3"
                                    class="input02"
                                    >
                                <label for="unit_price_3" class="placeholder2">Unit Price</label>
                            </div>
                            <div class="trial1" id="contact_number1">
                                <input
                                    type="text"
                                    placeholder=""
                                    id="qty_3"
                                    name="qty_3"
                                    class="input02"
                                    >
                                <label for="qty_3" class="placeholder2">QTY</label>
                            </div>
                            <div class="trial1 ">
                                <input
                                    type="text"
                                    placeholder=""
                                    id="total_price_3"
                                    name="total_price_3"
                                    class="input02"
                                    readonly="readonly"
                                    >
                                <label for="total_price_3" class="placeholder2">Price (Unit Price × Qty)</label>
                            </div>
                        </div>
                        <div class="addbuttonicon" id="fourth_addequipbtn">
                            <i onclick="fourth_quotation()" class="bi bi-plus-circle">Add Another Equipment</i>
                        </div>
                    </div>

                    <!-- fourthrow -->
                    <div class="otherquipquote" id="fouthvehicledata">
                        <br>
                        <p class="add_second_equipment_generate">Add Fourth Product Details
                            <i onclick="cancelfourthequipment()" class="bi bi-x icon-cancel"></i>
                        </p>
                        <div class="outer02 mt-10px product-group" data-group="4">
                            <div class="trial1">
                                <input
                                    type="text"
                                    placeholder=""
                                    id="product_serial_4"
                                    name="product_serial_4"
                                    class="input02 product-autocomplete"
                                    autocomplete="off"
                                    >
                                <ul
                                    id="productSerialDropdown_4"
                                    class="dropdown-menu show product-dropdown"
                                    style="display:none; position:absolute; top:100%; left:0; width:100%; z-index:1000; background:#fff; border:1px solid #ccc; border-radius:0 0 4px 4px; max-height:180px; overflow-y:auto; padding:0; margin:0;"></ul>
                                <label for="product_serial_4" class="placeholder2">Product Serial Number/Code</label>
                            </div>
                            <div class="trial1">
                                <input
                                    type="text"
                                    placeholder=""
                                    id="product_name_4"
                                    name="product_name_4"
                                    class="input02 product-autocomplete"
                                    autocomplete="off"
                                >
                                <ul
                                    id="productNameDropdown_4"
                                    class="dropdown-menu show product-dropdown"
                                    style="display:none; position:absolute; top:100%; left:0; width:100%; z-index:1000; background:#fff; border:1px solid #ccc; border-radius:0 0 4px 4px; max-height:180px; overflow-y:auto; padding:0; margin:0;"></ul>
                                <label for="product_name_4" class="placeholder2">Product Name (Code HSN/SAC)</label>
                            </div>
                            <div class="trial1 ">
                                <select
                                    class="input02"
                                    name="product_uom_4"
                                    id="product_uom_4"
                                    >
                                    <option value="" disabled="disabled" selected="selected">Select UoM</option>
                                    <option value="set">Set</option>
                                    <option value="nos">Nos</option>
                                    <option value="kgs">Kgs</option>
                                    <option value="meter">Meter</option>
                                    <option value="litre">Litre</option>
                                </select>
                                <label for="product_uom_4" class="placeholder2">UoM (Unit of Measurement)</label>
                            </div>
                        </div>
                        <div class="outer02 product-group" data-group="4">
                            <div class="trial1">
                                <input
                                    type="text"
                                    placeholder=""
                                    id="unit_price_4"
                                    name="unit_price_4"
                                    class="input02"
                                    >
                                <label for="unit_price_4" class="placeholder2">Unit Price</label>
                            </div>
                            <div class="trial1" id="contact_number1">
                                <input
                                    type="text"
                                    placeholder=""
                                    id="qty_4"
                                    name="qty_4"
                                    class="input02"
                                    >
                                <label for="qty_4" class="placeholder2">QTY</label>
                            </div>
                            <div class="trial1 ">
                                <input
                                    type="text"
                                    placeholder=""
                                    id="total_price_4"
                                    name="total_price_4"
                                    class="input02"
                                    readonly="readonly"
                                    >
                                <label for="total_price_4" class="placeholder2">Price (Unit Price × Qty)</label>
                            </div>
                        </div>
                        <div class="addbuttonicon" id="fifth_addequipbtn">
                            <i onclick="fifth_quotation()" class="bi bi-plus-circle">Add Another Equipment</i>
                        </div>
                    </div>

                    <!-- fifthrow -->
                    <div class="otherquipquote" id="fifthvehicledata">
                        <br>
                        <p class="add_second_equipment_generate">Add Fifth Product Details
                            <i onclick="cancelfifthequipment()" class="bi bi-x icon-cancel"></i>
                        </p>
                        <div class="outer02 mt-10px product-group" data-group="5">
                            <div class="trial1">
                                <input
                                    type="text"
                                    placeholder=""
                                    id="product_serial_5"
                                    name="product_serial_5"
                                    class="input02 product-autocomplete"
                                    autocomplete="off"
                                    >
                                <ul
                                    id="productSerialDropdown_5"
                                    class="dropdown-menu show product-dropdown"
                                    style="display:none; position:absolute; top:100%; left:0; width:100%; z-index:1000; background:#fff; border:1px solid #ccc; border-radius:0 0 4px 4px; max-height:180px; overflow-y:auto; padding:0; margin:0;"></ul>
                                <label for="product_serial_5" class="placeholder2">Product Serial Number/Code</label>
                            </div>
                            <div class="trial1">
                                <input
                                    type="text"
                                    placeholder=""
                                    id="product_name_5"
                                    name="product_name_5"
                                    class="input02 product-autocomplete"
                                    autocomplete="off"
                                    >
                                <ul
                                    id="productNameDropdown_5"
                                    class="dropdown-menu show product-dropdown"
                                    style="display:none; position:absolute; top:100%; left:0; width:100%; z-index:1000; background:#fff; border:1px solid #ccc; border-radius:0 0 4px 4px; max-height:180px; overflow-y:auto; padding:0; margin:0;"></ul>
                                <label for="product_name_5" class="placeholder2">Product Name (Code HSN/SAC)</label>
                            </div>
                            <div class="trial1 ">
                                <select
                                    class="input02"
                                    name="product_uom_5"
                                    id="product_uom_5"
                                    >
                                    <option value="" disabled="disabled" selected="selected">Select UoM</option>
                                    <option value="set">Set</option>
                                    <option value="nos">Nos</option>
                                    <option value="kgs">Kgs</option>
                                    <option value="meter">Meter</option>
                                    <option value="litre">Litre</option>
                                </select>
                                <label for="product_uom_5" class="placeholder2">UoM (Unit of Measurement)</label>
                            </div>
                        </div>
                        <div class="outer02 product-group" data-group="5">
                            <div class="trial1">
                                <input
                                    type="text"
                                    placeholder=""
                                    id="unit_price_5"
                                    name="unit_price_5"
                                    class="input02"
                                >
                                <label for="unit_price_5" class="placeholder2">Unit Price</label>
                            </div>
                            <div class="trial1" id="contact_number1">
                                <input
                                    type="text"
                                    placeholder=""
                                    id="qty_5"
                                    name="qty_5"
                                    class="input02"
                                    >
                                <label for="qty_5" class="placeholder2">QTY</label>
                            </div>
                            <div class="trial1 ">
                                <input
                                    type="text"
                                    placeholder=""
                                    id="total_price_5"
                                    name="total_price_5"
                                    class="input02"
                                    readonly="readonly"
                                >
                                <label for="total_price_5" class="placeholder2">Price (Unit Price × Qty)</label>
                            </div>
                        </div>
                        <!-- No more add button for last row -->
                    </div>

                    <div class="fulllength" id="quotationnextback">
                        <button
                            class="quotationnavigatebutton bg-white text-center w-30 rounded-lg h-10 relative text-black text-sm font-semibold group"
                            type="button"
                            onclick="backtocontactpersonsection()">
                            <div
                                class="rounded-md h-8 w-1/4 flex items-center justify-center absolute left-1 top-[2px] group-hover:w-[110px] z-10 duration-300"
                                style="background-color: #1C549E;">

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewbox="0 0 1024 1024"
                                    height="18px"
                                    width="18px">
                                    <path d="M224 480h640a32 32 0 1 1 0 64H224a32 32 0 0 1 0-64z" fill="white"></path>
                                    <path
                                        d="m237.248 512 265.408 265.344a32 32 0 0 1-45.312 45.312l-288-288a32 32 0 0 1 0-45.312l288-288a32 32 0 1 1 45.312 45.312L237.248 512z"
                                        fill="white"></path>
                                </svg>
                            </div>
                            <p class="translate-x-1">Back</p>
                        </button>

                        <button
                            class="quotationnavigatebutton bg-white text-center w-30 rounded-lg h-10 relative text-black text-sm font-semibold group"
                            type="button"
                            onclick="termssection()">
                            <div
                                class="bg-custom-blue rounded-md h-8 w-1/4 flex items-center justify-center absolute left-1 top-[2px] group-hover:w-[110px] z-10 duration-300"
                                style="background-color: #1C549E;">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewbox="0 0 1024 1024"
                                    height="18px"
                                    width="18px"
                                    transform="rotate(180)">
                                    <path d="M224 480h640a32 32 0 1 1 0 64H224a32 32 0 0 1 0-64z" fill="white"></path>
                                    <path
                                        d="m237.248 512 265.408 265.344a32 32 0 0 1-45.312 45.312l-288-288a32 32 0 0 1 0-45.312l288-288a32 32 0 1 1 45.312 45.312L237.248 512z"
                                        fill="white"></path>
                                </svg>
                            </div>
                            <p class="translate-x-1">Next</p>
                        </button>

                    </div>
                    <br>

                </div>

                <div id="termssectioncontainer">
                    <p class="headingpara">Bill To Information</p>
                    <div class="outer02">
                        <div class="trial1">
                            <input
                                type="text"
                                placeholder=""
                                id="bill_to_name"
                                name="bill_to_name"
                                class="input02">
                            <label for="bill_to_name" class="placeholder2">Bill To (Company Name)</label>
                        </div>
                        <div class="trial1">
                            <input
                                type="text"
                                placeholder=""
                                id="bill_to_address"
                                name="bill_to_address"
                                class="input02">
                            <label for="bill_to_address" class="placeholder2">Address</label>
                        </div>
                        <div class="trial1">
                            <input
                                type="text"
                                placeholder=""
                                id="bill_to_gstin"
                                name="bill_to_gstin"
                                class="input02">
                            <label for="bill_to_gstin" class="placeholder2">GSTIN
                            </label>
                        </div>
                    </div>
                    <div class="outer02">
                        <div class="trial1">
                            <input
                                type="text"
                                placeholder=""
                                id="bill_to_pan"
                                name="bill_to_pan"
                                class="input02">
                            <label for="bill_to_pan" class="placeholder2">PAN</label>
                        </div>
                        <div class="trial1">
                            <input
                                type="text"
                                placeholder=""
                                id="bill_to_contact"
                                name="bill_to_contact"
                                class="input02">
                            <label for="bill_to_contact" class="placeholder2">Contact Person</label>
                        </div>
                        <div class="trial1">
                            <input
                                type="email"
                                placeholder=""
                                id="bill_to_email"
                                name="bill_to_email"
                                class="input02">
                            <label for="bill_to_email" class="placeholder2">Contact No</label>
                        </div>
                    </div>
                    <div class="fulllength" id="billtonextback">
                        <button
                            class="quotationnavigatebutton bg-white text-center w-30 rounded-lg h-10 relative text-black text-sm font-semibold group"
                            type="button"
                            onclick="backtoequipementsection()">
                            <div
                                class="rounded-md h-8 w-1/4 flex items-center justify-center absolute left-1 top-[2px] group-hover:w-[110px] z-10 duration-300"
                                style="background-color: #1C549E;">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewbox="0 0 1024 1024"
                                    height="18px"
                                    width="18px">
                                    <path d="M224 480h640a32 32 0 1 1 0 64H224a32 32 0 0 1 0-64z" fill="white"></path>
                                    <path
                                        d="m237.248 512 265.408 265.344a32 32 0 0 1-45.312 45.312l-288-288a32 32 0 0 1 0-45.312l288-288a32 32 0 1 1 45.312 45.312L237.248 512z"
                                        fill="white"></path>
                                </svg>
                            </div>
                            <p class="translate-x-1">Back</p>
                        </button>

                        <button
                            class="quotationnavigatebutton bg-white text-center w-30 rounded-lg h-10 relative text-black text-sm font-semibold group"
                            type="button"
                            onclick="termssection2()">
                            <div
                                class="bg-custom-blue rounded-md h-8 w-1/4 flex items-center justify-center absolute left-1 top-[2px] group-hover:w-[110px] z-10 duration-300"
                                style="background-color: #1C549E;">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewbox="0 0 1024 1024"
                                    height="18px"
                                    width="18px"
                                    transform="rotate(180)">
                                    <path d="M224 480h640a32 32 0 1 1 0 64H224a32 32 0 0 1 0-64z" fill="white"></path>
                                    <path
                                        d="m237.248 512 265.408 265.344a32 32 0 0 1-45.312 45.312l-288-288a32 32 0 0 1 0-45.312l288-288a32 32 0 1 1 45.312 45.312L237.248 512z"
                                        fill="white"></path>
                                </svg>
                            </div>
                            <p class="translate-x-1">Next</p>
                        </button>
                    </div>
                    <br>
                </div>
                <!-- End Bill To Section -->

                <div id="termssectioncontainer2">
                    <p class="headingpara">Ship To Information</p>
                    <div class="outer02">
                        <div class="trial1">
                            <input
                                type="text"
                                placeholder=""
                                id="ship_to_name"
                                name="ship_to_name"
                                class="input02">
                            <label for="ship_to_name" class="placeholder2">Ship To (Company Name)</label>
                        </div>
                        <div class="trial1">
                            <input
                                type="text"
                                placeholder=""
                                id="ship_to_address"
                                name="ship_to_address"
                                class="input02">
                            <label for="ship_to_address" class="placeholder2">Address</label>
                        </div>
                        <div class="trial1">
                            <input
                                type="text"
                                placeholder=""
                                id="ship_to_gstin"
                                name="ship_to_gstin"
                                class="input02">
                            <label for="ship_to_gstin" class="placeholder2">GSTIN</label>
                        </div>
                    </div>
                    <div class="outer02">
                        <div class="trial1">
                            <input
                                type="text"
                                placeholder=""
                                id="ship_to_pan"
                                name="ship_to_pan"
                                class="input02">
                            <label for="ship_to_pan" class="placeholder2">PAN</label>
                        </div>
                        <div class="trial1">
                            <input
                                type="text"
                                placeholder=""
                                id="ship_to_contact"
                                name="ship_to_contact"
                                class="input02">
                            <label for="ship_to_contact" class="placeholder2">Contact Person</label>
                        </div>
                        <div class="trial1">
                            <input
                                type="text"
                                placeholder=""
                                id="ship_to_email"
                                name="ship_to_email"
                                class="input02">
                            <label for="ship_to_email" class="placeholder2">Contact No</label>
                        </div>
                    </div>

                    <div class="fulllength" id="billtonextback">
                        <button
                            class="quotationnavigatebutton bg-white text-center w-30 rounded-lg h-10 relative text-black text-sm font-semibold group"
                            type="button"
                            onclick="backtoequipementsection2()">
                            <div
                                class="rounded-md h-8 w-1/4 flex items-center justify-center absolute left-1 top-[2px] group-hover:w-[110px] z-10 duration-300"
                                style="background-color: #1C549E;">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewbox="0 0 1024 1024"
                                    height="18px"
                                    width="18px">
                                    <path d="M224 480h640a32 32 0 1 1 0 64H224a32 32 0 0 1 0-64z" fill="white"></path>
                                    <path
                                        d="m237.248 512 265.408 265.344a32 32 0 0 1-45.312 45.312l-288-288a32 32 0 0 1 0-45.312l288-288a32 32 0 1 1 45.312 45.312L237.248 512z"
                                        fill="white"></path>
                                </svg>
                            </div>
                            <p class="translate-x-1">Back</p>
                        </button>

                        <button
                            class="quotationnavigatebutton bg-white text-center w-30 rounded-lg h-10 relative text-black text-sm font-semibold group"
                           name="submit_po" type="submit">
                            <div
                                class="bg-custom-blue rounded-md h-8 w-1/4 flex items-center justify-center absolute left-1 top-[2px] group-hover:w-[110px] z-10 duration-300"
                                style="background-color: #1C549E;">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewbox="0 0 1024 1024"
                                    height="18px"
                                    width="18px"
                                    transform="rotate(180)">
                                    <path d="M224 480h640a32 32 0 1 1 0 64H224a32 32 0 0 1 0-64z" fill="white"></path>
                                    <path
                                        d="m237.248 512 265.408 265.344a32 32 0 0 1-45.312 45.312l-288-288a32 32 0 0 1 0-45.312l288-288a32 32 0 1 1 45.312 45.312L237.248 512z"
                                        fill="white"></path>
                                </svg>
                            </div>
                            <p class="translate-x-1">Submit</p>
                        </button>
                    </div>
                    <br>
                </div>

            </div>
        </form>

        <script>
            function not_immediate() {
                const availability_dd = document.getElementById("availability_dd");
                const date_of_availability = document.getElementById("date_of_availability");
                if (availability_dd.value === "Not Immediate") {
                    date_of_availability.style.display = "block";
                } else {
                    date_of_availability.style.display = "none";
                }
            }

            function purchase_option() {
                const options = document.getElementsByClassName('awp_options');
                const options1 = document.getElementsByClassName('cq_options');
                const options2 = document.getElementsByClassName('earthmover_options');
                const options3 = document.getElementsByClassName('mhe_options');
                const options4 = document.getElementsByClassName('gee_options');
                const options5 = document.getElementsByClassName('trailor_options');
                const options6 = document.getElementsByClassName('generator_options');

                const first_select = document.getElementById('oem_fleet_type');

                // Set the display style for all elements at once
                const displayStyle = (first_select.value === "Aerial Work Platform")
                    ? "block"
                    : "none";
                Array
                    .from(options)
                    .forEach(option => option.style.display = displayStyle);

                const displayStyle1 = (first_select.value === "Concrete Equipment")
                    ? "block"
                    : "none";
                Array
                    .from(options1)
                    .forEach(option => option.style.display = displayStyle1);

                const displayStyle2 = (
                    first_select.value === "EarthMovers and Road Equipments"
                )
                    ? "block"
                    : "none";
                Array
                    .from(options2)
                    .forEach(option => option.style.display = displayStyle2);

                const displayStyle3 = (first_select.value === "Material Handling Equipments")
                    ? "block"
                    : "none";
                Array
                    .from(options3)
                    .forEach(option => option.style.display = displayStyle3);

                const displayStyle4 = (first_select.value === "Ground Engineering Equipments")
                    ? "block"
                    : "none";
                Array
                    .from(options4)
                    .forEach(option => option.style.display = displayStyle4);

                const displayStyle5 = (first_select.value === "Trailor and Truck")
                    ? "block"
                    : "none";
                Array
                    .from(options5)
                    .forEach(option => option.style.display = displayStyle5);

                const displayStyle6 = (first_select.value === "Generator and Lighting")
                    ? "block"
                    : "none";
                Array
                    .from(options6)
                    .forEach(option => option.style.display = displayStyle6);

            }
            function officetypedd() {
                const office_typenew = document.getElementById("office_typenew");
                const regandsitecontainerouter = document.getElementById(
                    "regandsitecontainerouter"
                );
                const siteoffice = document.getElementById("siteoffice");
                const regionaloffice = document.getElementById("regionaloffice");
                if (office_typenew.value === 'Regional Office') {
                    regandsitecontainerouter.style.display = 'flex';
                    regionaloffice.style.display = 'block';
                    siteoffice.style.display = 'none';

                } else if (office_typenew.value === 'Site Office') {
                    regandsitecontainerouter.style.display = 'flex';
                    siteoffice.style.display = 'block';
                    regionaloffice.style.display = 'none';

                } else {
                    regandsitecontainerouter.style.display = 'none';
                    siteoffice.style.display = 'none';
                    regionaloffice.style.display = 'none';

                }
            }

            function seco_equip() {
                const options1 = document.getElementsByClassName('awp_options1');
                const options11 = document.getElementsByClassName('cq_options1');
                const options21 = document.getElementsByClassName('earthmover_options1');
                const options31 = document.getElementsByClassName('mhe_options1');
                const options41 = document.getElementsByClassName('gee_options1');
                const options51 = document.getElementsByClassName('trailor_options1');
                const options61 = document.getElementsByClassName('generator_options1');

                const first_select1 = document.getElementById('oem_fleet_type1');

                // Set the display style for all elements at once
                const displayStyle00 = (first_select1.value === "Aerial Work Platform")
                    ? "block"
                    : "none";
                Array
                    .from(options1)
                    .forEach(option => option.style.display = displayStyle00);

                const displayStyle1 = (first_select1.value === "Concrete Equipment")
                    ? "block"
                    : "none";
                Array
                    .from(options11)
                    .forEach(option => option.style.display = displayStyle1);

                const displayStyle2 = (
                    first_select1.value === "EarthMovers and Road Equipments"
                )
                    ? "block"
                    : "none";
                Array
                    .from(options21)
                    .forEach(option => option.style.display = displayStyle2);

                const displayStyle3 = (first_select1.value === "Material Handling Equipments")
                    ? "block"
                    : "none";
                Array
                    .from(options31)
                    .forEach(option => option.style.display = displayStyle3);

                const displayStyle4 = (first_select1.value === "Ground Engineering Equipments")
                    ? "block"
                    : "none";
                Array
                    .from(options41)
                    .forEach(option => option.style.display = displayStyle4);

                const displayStyle5 = (first_select1.value === "Trailor and Truck")
                    ? "block"
                    : "none";
                Array
                    .from(options51)
                    .forEach(option => option.style.display = displayStyle5);

                const displayStyle6 = (first_select1.value === "Generator and Lighting")
                    ? "block"
                    : "none";
                Array
                    .from(options61)
                    .forEach(option => option.style.display = displayStyle6);

            }
            function updateAssetCode(selectElement) {
                // Get the selected fleet category and dropdown ID
                var fleetCategory = selectElement.value;
                var dropdownId = selectElement.getAttribute("data-dropdown");

                // Find the corresponding asset code dropdown
                var assetCodeDropdown = document.querySelector(
                    '.asset-code[data-dropdown="' + dropdownId + '"]'
                );

                // Make an AJAX request to fetch asset codes based on the selected category
                var xhr = new XMLHttpRequest();
                xhr.open(
                    "GET",
                    "fetch_asset_codes.php?fleet_category=" + encodeURIComponent(fleetCategory),
                    true
                );
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        try {
                            var response = JSON.parse(xhr.responseText);

                            // Check if the response contains an error
                            if (response.error) {
                                console.error("Error:", response.error);
                                return;
                            }

                            // Clear existing options
                            assetCodeDropdown.innerHTML = '<option value="" disabled selected>Choose Asset Code</option><option value="Ne' +
                                    'w Equipment">Choose New Equipment</option>';

                            // Append new options
                            response.forEach(function (asset) {
                                var option = document.createElement("option");
                                option.value = asset.assetcode;
                                option.text = asset.assetcode + " (" + asset.sub_type + " " + asset.make + " " +
                                        asset.model + " " + asset.capacity + " " + asset.unit + ") " + asset.status;

                                // Set background color based on status
                                if (asset.status.toLowerCase() === "idle") {
                                    option.style.backgroundColor = "lightgreen";
                                } else if (asset.status.toLowerCase() === "working") {
                                    option.style.backgroundColor = "lightcoral"; // Light red
                                }

                                assetCodeDropdown.appendChild(option);
                            });
                        } catch (e) {
                            console.error("Failed to parse JSON response:", e);
                            console.error("Response:", xhr.responseText);
                        }
                    }
                };
                xhr.send();
            }
            function newclient() {
                const companySelect = document.getElementById("companySelect");
                const contactSelect = document.getElementById("contactSelectouter");
                const newrentalcontactperson = document.getElementById(
                    "newrentalcontactperson"
                );
                const companySelectouter = document.getElementById("companySelectouter");
                const newrentalclient = document.getElementById("newrentalclient");

                if (companySelect.value === 'New Client') {
                    companySelectouter.style.display = 'none';
                    contactSelect.style.display = 'none';
                    newrentalcontactperson.style.display = 'flex';
                    newrentalclient.style.display = 'flex';

                }

            }

            function newcontactpersonfunction() {
                const contactSelect = document.getElementById("contactSelect");
                const contactSelectouter = document.getElementById("contactSelectouter");
                const newrentalcontactperson = document.getElementById(
                    "newrentalcontactperson"
                );
                const quoteouter02 = document.getElementById("quoteouter02");

                if (contactSelect.value === 'New Contact Person') {
                    contactSelectouter.style.display = 'none';
                    newrentalcontactperson.style.display = 'flex';

                }

            }

            function third_vehicle() {
                const thirdvehicledetail = document.getElementById("thirdvehicledetail");
                const third_addequipbtn = document.getElementById("third_addequipbtn");
                thirdvehicledetail.style.display = "flex";
                third_addequipbtn.style.display = "none";

            }
            function fourth_quotation() {
                const fouthvehicledata = document.getElementById("fouthvehicledata");
                const fourth_addequipbtn = document.getElementById("fourth_addequipbtn");
                fouthvehicledata.style.display = "flex";
                fourth_addequipbtn.style.display = "none";

            }

            function fifth_quotation() {
                const fifthvehicledata = document.getElementById("fifthvehicledata");
                const fifth_addequipbtn = document.getElementById("fifth_addequipbtn");
                fifthvehicledata.style.display = "flex";
                fifth_addequipbtn.style.display = "none";

            }

            function filterClients() {
                const input = document.getElementById('clientSearch');
                const filter = input
                    .value
                    .toLowerCase();
                const suggestions = document.getElementById('suggestions');
                const select = document.getElementById('companySelect');
                const options = select.getElementsByTagName('option');

                suggestions.innerHTML = ''; // Clear previous suggestions
                let hasVisibleItems = false;

                for (let i = 0; i < options.length; i++) {
                    const optionText = options[i].textContent || options[i].innerText;
                    if (optionText.toLowerCase().includes(filter) && filter) {
                        const suggestionItem = document.createElement('div');
                        suggestionItem.className = 'suggestion-item';
                        suggestionItem.textContent = optionText;
                        suggestionItem.onclick = function () {
                            select.value = options[i].value; // Set the select value
                            input.value = optionText; // Set the input value
                            suggestions.style.display = 'none'; // Hide suggestions
                            updateContactPerson(); // Call the onchange function
                            newclient(); // Call the newclient function
                        };
                        suggestions.appendChild(suggestionItem);
                        hasVisibleItems = true;
                    }
                }

                // If no suggestions found, show "New Client" option
                if (!hasVisibleItems) {
                    const newClientItem = document.createElement('div');
                    newClientItem.className = 'suggestion-item';
                    newClientItem.textContent = 'New Client';
                    newClientItem.onclick = function () {
                        select.value = 'New Client'; // Set the select value
                        input.value = 'New Client'; // Set the input value
                        suggestions.style.display = 'none'; // Hide suggestions
                        updateContactPerson(); // Call the onchange function
                        newclient(); // Call the newclient function
                    };
                    suggestions.appendChild(newClientItem);
                    suggestions.style.display = 'block'; // Show the suggestions
                } else {
                    suggestions.style.display = 'block'; // Show suggestions if there are any
                }
            }

            function showDropdown() {
                const suggestions = document.getElementById('suggestions');
                suggestions.style.display = 'block';
            }

            // Close suggestions when clicking outside
            document.addEventListener('click', function (event) {
                const suggestions = document.getElementById('suggestions');
                const input = document.getElementById('clientSearch');
                if (suggestions && !suggestions.contains(event.target) && event.target !== input) {
                    suggestions.style.display = 'none';
                }
            });

            // --- Auto-select fleet category in new equipment section when "Choose New
            // Equipment" is selected ---
            document.addEventListener('DOMContentLoaded', function () {
                // Map dropdown index to new equipment fleet category select IDs
                const newEquipFleetCategoryIds = {
                    1: 'oem_fleet_type',
                    2: 'oem_fleet_type1',
                    3: 'oem_fleet_type3',
                    4: 'oem_fleet_type4',
                    5: 'oem_fleet_type5'
                };

                // Map dropdown index to fleet type onchange handler
                const fleetTypeOnChangeFns = {
                    1: window.purchase_option,
                    2: window.seco_equip,
                    3: window.third_equipment
                        ? window.third_equipment
                        : function () {},
                    4: window.fourth_equipment
                        ? window.fourth_equipment
                        : function () {},
                    5: window.fifth_equipment
                        ? window.fifth_equipment
                        : function () {}
                };

                document
                    .querySelectorAll('.asset-code')
                    .forEach(function (assetCodeSelect) {
                        assetCodeSelect.addEventListener('change', function () {
                            const selectedOption = assetCodeSelect.value;
                            const dropdownId = assetCodeSelect.getAttribute('data-dropdown');
                            if (selectedOption === 'New Equipment') {
                                // Find the fleet category select for this section
                                const fleetCategorySelect = document.querySelector(
                                    '.fleet-category[data-dropdown="' + dropdownId + '"]'
                                );
                                const newEquipFleetCategoryId = newEquipFleetCategoryIds[dropdownId];
                                const newEquipFleetCategorySelect = document.getElementById(
                                    newEquipFleetCategoryId
                                );
                                if (fleetCategorySelect && newEquipFleetCategorySelect) {
                                    // Set value and trigger change
                                    newEquipFleetCategorySelect.value = fleetCategorySelect.value;
                                    // Trigger the correct onchange handler for fleet type options
                                    if (typeof newEquipFleetCategorySelect.onchange === "function") {
                                        newEquipFleetCategorySelect.onchange();
                                    }
                                    // Also call the mapped function if available (for sections 2-5)
                                    if (fleetTypeOnChangeFns[dropdownId]) {
                                        fleetTypeOnChangeFns[dropdownId]();
                                    }
                                }
                            }
                        });
                    });
            });
        </script>
        <script>
            $(document).ready(function () {
                // Vendor autocomplete
                $('#vendor_name').on('keyup focus', function () {
                    let query = $(this)
                        .val()
                        .trim();
                    if (query.length === 0) {
                        $('#vendorDropdown').hide();
                        return;
                    }
                    $.ajax({
                        url: 'fetch_vendor.php',
                        method: 'POST',
                        data: {
                            search: query
                        },
                        success: function (data) {
                            if (data.trim() !== '') {
                                $('#vendorDropdown')
                                    .html(data)
                                    .show();
                            } else {
                                $('#vendorDropdown').hide();
                            }
                        }
                    });
                });

                // Helper to load contact persons and always add "New Contact Person"
                function loadContactPersons(data) {
                    let $select = $('#vendorContactSelect');
                    $select.empty();
                    $select.append(
                        '<option value="" disabled selected>Select Contact Person</option>'
                    );
                    if (data && data.length > 0) {
                        data.forEach(function (person) {
                            $select.append(
                                '<option value="' + person.id + '">' + person.contact_person + '</option>'
                            );
                        });
                    }
                    $select.append(
                        '<option value="new_contact_person">New Contact Person</option>'
                    );
                    $('#newContactPersonInput').hide();
                }

                // On vendor select
                $(document).on('click', '#vendorDropdown li', function () {
                    let selected = $(this).text();
                    $('#vendor_name').val(selected);
                    $('#vendorSelect').val(selected);
                    $('#vendorDropdown').hide();

                    // Fetch vendor id and then contact persons
                    $.ajax({
                        url: 'get_vendor_id.php',
                        method: 'POST',
                        dataType: 'json',
                        data: {
                            vendor_name: selected
                        },
                        success: function (res) {
                            if (res && res.vendor_id) {
                                $('#vendor_id').val(res.vendor_id);
                                // Fetch contact persons for this vendor id
                                $.ajax({
                                    url: 'get_vendor_contacts.php',
                                    method: 'POST',
                                    dataType: 'json',
                                    data: {
                                        vendor_id: res.vendor_id
                                    },
                                    success: function (data) {
                                        loadContactPersons(data);
                                        $('#vendor_email').val('');
                                        $('#vendor_contact_number').val('');
                                        $('#vendor_address').val('');
                                    }
                                });
                            }
                        }
                    });
                });

                // On contact person select, autofill details or show input for new contact
                // person
                $('#vendorContactSelect').on('change', function () {
                    let contact_id = $(this).val();
                    if (contact_id === 'new_contact_person') {
                        $('#vendorContactSelect').hide();
                        $('#vendorContactInput').show().val('');
                        $('#vendor_email').val('');
                        $('#vendor_contact_number').val('');
                        $('#vendor_address').val('');
                    } else if (contact_id) {
                        $('#vendorContactInput').hide();
                        $('#vendorContactSelect').show();
                        $.ajax({
                            url: 'get_contact_details.php',
                            method: 'POST',
                            dataType: 'json',
                            data: {
                                contact_id: contact_id
                            },
                            success: function (data) {
                                if (data) {
                                    $('#vendor_email').val(data.email);
                                    $('#vendor_contact_number').val(data.contact_number);
                                    $('#vendor_address').val(data.office_address);
                                }
                            }
                        });
                    } else {
                        $('#vendorContactInput').hide();
                        $('#vendorContactSelect').show();
                        $('#vendor_email').val('');
                        $('#vendor_contact_number').val('');
                        $('#vendor_address').val('');
                    }
                });

                // When page loads, always ensure "New Contact Person" is present
                loadContactPersons([]);

                // Hide dropdown on outside click
                $(document).on('click', function (e) {
                    if (!$(e.target).closest('#vendorSelectouter').length) {
                        $('#vendorDropdown').hide();
                    }
                });
            });
        </script>
        <script>
            $(document).ready(function () {
                // --- Product Autocomplete ---
                function showProductDropdown($input, $dropdown, data) {
                    $dropdown.empty();
                    if (data.length === 0) {
                        $dropdown.hide();
                        return;
                    }
                    data.forEach(function (item) {
                        $dropdown.append(
                            $('<li>').css({'list-style': 'none', 'padding': '8px 16px', 'cursor': 'pointer', 'border-bottom': '1px solid #eee'}).html(
                                '<strong>' + item.product_serial + '</strong> - ' + item.product_name
                            ).data('product', item)
                        );
                    });
                    $dropdown.show();
                }

                function fetchProductSuggestions(query, vendor_id, type, callback) {
                    $.ajax({
                        url: 'fetch_product.php',
                        method: 'POST',
                        dataType: 'json',
                        data: {
                            search: query,
                            vendor_id: vendor_id,
                            type: type
                        },
                        success: function (data) {
                            callback(data);
                        }
                    });
                }

                function fillProductFields(product) {
                    $('#product_serial').val(product.product_serial);
                    $('#product_name').val(product.product_name);
                    $('#product_uom').val(product.product_uom);
                    $('#unit_price').val(product.unit_price);
                    $('#qty').val(product.qty);
                    $('#total_price').val(product.unit_price * product.qty);
                    $('#productSerialDropdown, #productNameDropdown').hide();
                }

                // Autocomplete for product_serial
                $('#product_serial').on('keyup focus', function () {
                    let query = $(this)
                        .val()
                        .trim();
                    let vendor_id = $('#vendor_id').val();
                    if (!query || !vendor_id) {
                        $('#productSerialDropdown').hide();
                        return;
                    }
                    fetchProductSuggestions(query, vendor_id, 'serial', function (data) {
                        showProductDropdown($('#product_serial'), $('#productSerialDropdown'), data);
                    });
                });

                // Autocomplete for product_name
                $('#product_name').on('keyup focus', function () {
                    let query = $(this)
                        .val()
                        .trim();
                    let vendor_id = $('#vendor_id').val();
                    if (!query || !vendor_id) {
                        $('#productNameDropdown').hide();
                        return;
                    }
                    fetchProductSuggestions(query, vendor_id, 'name', function (data) {
                        showProductDropdown($('#product_name'), $('#productNameDropdown'), data);
                    });
                });

                // On selecting from dropdown (serial)
                $(document).on('click', '#productSerialDropdown li', function () {
                    let product = $(this).data('product');
                    fillProductFields(product);
                });

                // On selecting from dropdown (name)
                $(document).on('click', '#productNameDropdown li', function () {
                    let product = $(this).data('product');
                    fillProductFields(product);
                });

                // Hide dropdowns on outside click
                $(document).on('click', function (e) {
                    if (!$(e.target).closest('#product_serial').length) {
                        $('#productSerialDropdown').hide();
                    }
                    if (!$(e.target).closest('#product_name').length) {
                        $('#productNameDropdown').hide();
                    }
                });

                // Autofill total price on qty or unit price change
                $('#unit_price, #qty').on('input', function () {
                    let price = parseFloat($('#unit_price').val()) || 0;
                    let qty = parseFloat($('#qty').val()) || 0;
                    $('#total_price').val(price * qty);
                });

                // Vendor autocomplete
                $('#vendor_name').on('keyup focus', function () {
                    let query = $(this)
                        .val()
                        .trim();
                    if (query.length === 0) {
                        $('#vendorDropdown').hide();
                        return;
                    }
                    $.ajax({
                        url: 'fetch_vendor.php',
                        method: 'POST',
                        data: {
                            search: query
                        },
                        success: function (data) {
                            if (data.trim() !== '') {
                                $('#vendorDropdown')
                                    .html(data)
                                    .show();
                            } else {
                                $('#vendorDropdown').hide();
                            }
                        }
                    });
                });

                // Helper to load contact persons and always add "New Contact Person"
                function loadContactPersons(data) {
                    let $select = $('#vendorContactSelect');
                    $select.empty();
                    $select.append(
                        '<option value="" disabled selected>Select Contact Person</option>'
                    );
                    if (data && data.length > 0) {
                        data.forEach(function (person) {
                            $select.append(
                                '<option value="' + person.id + '">' + person.contact_person + '</option>'
                            );
                        });
                    }
                    $select.append(
                        '<option value="new_contact_person">New Contact Person</option>'
                    );
                    $('#newContactPersonInput').hide();
                }

                // On vendor select
                $(document).on('click', '#vendorDropdown li', function () {
                    let selected = $(this).text();
                    $('#vendor_name').val(selected);
                    $('#vendorSelect').val(selected);
                    $('#vendorDropdown').hide();

                    // Fetch vendor id and then contact persons
                    $.ajax({
                        url: 'get_vendor_id.php',
                        method: 'POST',
                        dataType: 'json',
                        data: {
                            vendor_name: selected
                        },
                        success: function (res) {
                            if (res && res.vendor_id) {
                                $('#vendor_id').val(res.vendor_id);
                                // Fetch contact persons for this vendor id
                                $.ajax({
                                    url: 'get_vendor_contacts.php',
                                    method: 'POST',
                                    dataType: 'json',
                                    data: {
                                        vendor_id: res.vendor_id
                                    },
                                    success: function (data) {
                                        loadContactPersons(data);
                                        $('#vendor_email').val('');
                                        $('#vendor_contact_number').val('');
                                        $('#vendor_address').val('');
                                    }
                                });
                            }
                        }
                    });
                });

                // On contact person select, autofill details or show input for new contact
                // person
                $('#vendorContactSelect').on('change', function () {
                    let contact_id = $(this).val();
                    if (contact_id === 'new_contact_person') {
                        $('#vendorContactSelect').hide();
                        $('#vendorContactInput').show().val('');
                        $('#vendor_email').val('');
                        $('#vendor_contact_number').val('');
                        $('#vendor_address').val('');
                    } else if (contact_id) {
                        $('#vendorContactInput').hide();
                        $('#vendorContactSelect').show();
                        $.ajax({
                            url: 'get_contact_details.php',
                            method: 'POST',
                            dataType: 'json',
                            data: {
                                contact_id: contact_id
                            },
                            success: function (data) {
                                if (data) {
                                    $('#vendor_email').val(data.email);
                                    $('#vendor_contact_number').val(data.contact_number);
                                    $('#vendor_address').val(data.office_address);
                                }
                            }
                        });
                    } else {
                        $('#vendorContactInput').hide();
                        $('#vendorContactSelect').show();
                        $('#vendor_email').val('');
                        $('#vendor_contact_number').val('');
                        $('#vendor_address').val('');
                    }
                });

                // When page loads, always ensure "New Contact Person" is present
                loadContactPersons([]);

                // Hide dropdown on outside click
                $(document).on('click', function (e) {
                    if (!$(e.target).closest('#vendorSelectouter').length) {
                        $('#vendorDropdown').hide();
                    }
                });
            });
        </script>
        <script>
            $(document).ready(function () {
                // --- Product Autocomplete for all product groups ---
                function showProductDropdown($dropdown, data) {
                    $dropdown.empty();
                    if (data.length === 0) {
                        $dropdown.hide();
                        return;
                    }
                    data.forEach(function (item) {
                        $dropdown.append(
                            $('<li>').css({'list-style': 'none', 'padding': '8px 16px', 'cursor': 'pointer', 'border-bottom': '1px solid #eee'}).html(
                                '<strong>' + item.product_serial + '</strong> - ' + item.product_name
                            ).data('product', item)
                        );
                    });
                    $dropdown.show();
                }

                function fetchProductSuggestions(query, vendor_id, type, callback) {
                    $.ajax({
                        url: 'fetch_product.php',
                        method: 'POST',
                        dataType: 'json',
                        data: {
                            search: query,
                            vendor_id: vendor_id,
                            type: type
                        },
                        success: function (data) {
                            callback(data);
                        }
                    });
                }

                function fillProductFields(group, product) {
                    $('#product_serial_' + group).val(product.product_serial);
                    $('#product_name_' + group).val(product.product_name);
                    $('#product_uom_' + group).val(product.product_uom);
                    $('#unit_price_' + group).val(product.unit_price);
                    $('#qty_' + group).val(product.qty);
                    $('#total_price_' + group).val(product.unit_price * product.qty);
                    $(
                        '#productSerialDropdown_' + group + ', #productNameDropdown_' + group
                    ).hide();
                }

                // Delegate autocomplete for all product_serial fields
                $(document).on('keyup focus', '.product-autocomplete', function () {
                    var $input = $(this);
                    var id = $input.attr('id');
                    var match = id.match(/(product_serial|product_name)_(\d+)/);
                    if (!match) 
                        return;
                    var type = match[1] === 'product_serial'
                        ? 'serial'
                        : 'name';
                    var group = match[2];
                    var query = $input
                        .val()
                        .trim();
                    var vendor_id = $('#vendor_id').val();
                    var $dropdown = $('#' + (
                        type === 'serial'
                            ? 'productSerialDropdown_'
                            : 'productNameDropdown_'
                    ) + group);
                    if (!query || !vendor_id) {
                        $dropdown.hide();
                        return;
                    }
                    fetchProductSuggestions(query, vendor_id, type, function (data) {
                        showProductDropdown($dropdown, data);
                    });
                });

                // Delegate click for dropdown selection (serial/name)
                $(document).on('click', '.product-dropdown li', function () {
                    var $dropdown = $(this).closest('ul');
                    var id = $dropdown.attr('id');
                    var match = id.match(/product(?:Serial|Name)Dropdown_(\d+)/);
                    if (!match) 
                        return;
                    var group = match[1];
                    var product = $(this).data('product');
                    fillProductFields(group, product);
                });

                // Hide dropdowns on outside click for all groups
                $(document).on('click', function (e) {
                    $('.product-dropdown').each(function () {
                        var $dropdown = $(this);
                        var inputId = $dropdown
                            .attr('id')
                            .replace('Dropdown', '');
                        if (!$(e.target).closest('#' + inputId).length && !$(e.target).closest($dropdown).length) {
                            $dropdown.hide();
                        }
                    });
                });

                // Autofill total price on qty or unit price change for all groups
                $(document).on('input', '[id^=unit_price_], [id^=qty_]', function () {
                    var id = $(this).attr('id');
                    var match = id.match(/_(\d+)$/);
                    if (!match) 
                        return;
                    var group = match[1];
                    var price = parseFloat($('#unit_price_' + group).val()) || 0;
                    var qty = parseFloat($('#qty_' + group).val()) || 0;
                    $('#total_price_' + group).val(price * qty);
                });

            });
        </script>

    </body>
</html>