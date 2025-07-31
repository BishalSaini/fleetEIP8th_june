<?php
session_start();
$companyname001 = $_SESSION['companyname'];
$showAlert = false;
$showError = false;
$showDelete = false; 


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include "partials/_dbconnect.php";
    $vendor_name = $_POST['vendor_name'];
    $office_address = $_POST['office_address'];
    $vendor_code = $_POST['vendor_code'];
    $vendor_category = $_POST['vendor_category'];
    $state = $_POST['clientstate'];
    $company_name = $companyname001;

    // Check for duplicate vendor_code for this company
    $check_sql = "SELECT id FROM vendors WHERE vendor_code = ? AND companyname = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("ss", $vendor_code, $company_name);
    $check_stmt->execute();
    $check_stmt->store_result();
    if ($check_stmt->num_rows > 0) {
        $showError = "Vendor Code already exists for this company.";
        // Clear POST data so form fields are empty after refresh
        $_POST = [];
    } else {
        $sql = "INSERT INTO vendors (vendor_name, office_address, vendor_code, vendor_category, state, companyname) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("ssssss", $vendor_name, $office_address, $vendor_code, $vendor_category, $state, $company_name);
            if ($stmt->execute()) {
                $showAlert = true;
                // Clear POST data so form fields are empty after refresh
                $_POST = [];
            } else {
                $showError = "Something Went Wrong";
            }
            $stmt->close();
        } else {
            $showError = "Something Went Wrong";
        }
    }
    $check_stmt->close();
    $conn->close();
}

$edit_mode = isset($_GET['edit']) && $_GET['edit'] == 1 && isset($_GET['id']);
$vendor_edit = null;
if ($edit_mode) {
    include "partials/_dbconnect.php";
    $edit_id = intval($_GET['id']);
    $sql = "SELECT * FROM vendors WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $edit_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $vendor_edit = $result->fetch_assoc();
    $stmt->close();
}

// Handle update vendor
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['vendor_id']) && $_POST['vendor_id']) {
    include "partials/_dbconnect.php";
    $vendor_id = intval($_POST['vendor_id']);
    $vendor_name = $_POST['vendor_name'];
    $office_address = $_POST['office_address'];
    $vendor_code = $_POST['vendor_code'];
    $vendor_category = $_POST['vendor_category'];
    $state = $_POST['clientstate'];
    $company_name = $companyname001;

    $sql = "UPDATE vendors SET vendor_name=?, office_address=?, vendor_code=?, vendor_category=?, state=?, companyname=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssi", $vendor_name, $office_address, $vendor_code, $vendor_category, $state, $company_name, $vendor_id);
    if ($stmt->execute()) {
        $showAlert = true;
    } else {
        $showError = true;
    }
    $stmt->close();
    $conn->close();
    // Optionally redirect or reload
}

if (isset($_GET['delete']) && $_GET['delete'] == 1 && isset($_GET['id'])) {
    include "partials/_dbconnect.php";
    $del_id = intval($_GET['id']);
    $del_sql = "DELETE FROM vendors WHERE id = ?";
    $del_stmt = $conn->prepare($del_sql);
    $del_stmt->bind_param("i", $del_id);
    if ($del_stmt->execute()) {
        $showDelete = true;
    } else {
        $showError = true;
    }
    $del_stmt->close();
    $conn->close();
    // Optionally, redirect to remove delete param from URL
    header("Location: vendorsFleet.php?deleted=1");
    exit();
}

if (isset($_GET['deleted']) && $_GET['deleted'] == 1) {
    $showDelete = true;
} 

// Fetch all vendors for card display
include "partials/_dbconnect.php";
$sql_vendors = "SELECT * FROM vendors WHERE companyname = ?";
$stmt_vendors = $conn->prepare($sql_vendors);
$stmt_vendors->bind_param("s", $companyname001);
$stmt_vendors->execute();
$result_vendors = $stmt_vendors->get_result();
$all_vendors = [];
while ($row = $result_vendors->fetch_assoc()) {
    $all_vendors[] = $row;
}
$stmt_vendors->close();

// Sort vendors alphabetically by vendor_name
usort($all_vendors, function($a, $b) {
    return strcasecmp($a['vendor_name'], $b['vendor_name']);
});
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Add Vendor</title>
    <link rel="stylesheet" href="tiles.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <style>
            .vendorform {
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 0;
            }
            .rentalclientcontainer {
                margin: 0 auto;
            }
            /* Generate Quotations Button Styles */
            .generate-btn-container {
                display: flex;
                justify-content: flex-end;
                align-items: center;
                margin: 24px 0 0;
            }
            .generate-btn {
                background-color: white!important;
                color: white!important;
                border: none!important;
                border-radius: 4px!important;
                padding: 10px 20px !important;
                cursor: pointer !important;
            }
            .project-info {
                background: white;
                border-radius: 8px;

                padding: 12px 24px;
                max-width: 350px;
                transition: box-shadow 0.2s;
                cursor: pointer;
                display: block;
            }

            .flex-pr {
                display: flex;
                align-items: center;
                justify-content: space-between;
            }
            .project-title.text-nowrap {
                font-size: 1.1rem;
                font-weight: 600;
                color: #22336b;
                white-space: nowrap;
            }
            .project-hover {
                margin-left: 16px;
                display: flex;
                align-items: center;
            }
            .project-hover svg {
                vertical-align: middle;
            }
            .types {
                margin-top: 4px;
            }
            #vendorForm {
                display: none;
                width: 100%;
                justify-content: center;
                align-items: center;
            }
            #vendorForm .rentalclientcontainer {
                margin: 0 auto;
                max-width: 600px;
            }
            @media (min-width: 600px) {
                #vendorForm {
                    display: none;
                    display: flex;
                }
            }
            .client-cards-container {
                display: flex;
                flex-wrap: wrap;
                justify-content: flex-start;
                margin-top: 32px;
                margin-left: 32px;
            }
            .client-cards-container td {
                padding-right: 40px !important; 
                padding-bottom: 40px !important; 
                border: none !important;
            }

            .purchase_table {
                width: 100%;
                border-collapse: collapse;
                margin: 20px 0;
            }
            .purchase_table th, .purchase_table td {
                padding: 8px;
            }
            .purchase_table th {
                background-color: #f2f2f2;
            }
            .custom-card {

                padding: 10px;
                margin: 10px 0;
                text-align: left;
        
             
            
                cursor: pointer;
            }
            .custom-card__title {
                font-size: 1.18em;
                font-weight: 700;
                color: #22336b;
                margin-bottom: 6px;
                text-align: left;
            }
            .insidedetails {
                font-size: 0.98em;
                color: #333;
                margin-bottom: 4px;
                text-align: left;
            }
      
        </style>
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
                <?php if($showAlert): ?>
        <label>
            <input type="checkbox" class="alertCheckbox" autocomplete="off"/>
            <div class="alert notice">
                <span class="alertClose">X</span>
                <span class="alertText">Vendor Added Successfully!<br class="clear"/></span>
            </div>
        </label>
        <?php endif; ?>
        <?php if($showError): ?>
        <label>
            <input type="checkbox" class="alertCheckbox" autocomplete="off"/>
            <div class="alert error">
                <span class="alertClose">X</span>
                <span class="alertText">
                    <?php echo ($showError === "Vendor Code already exists for this company.") ? $showError : "Something Went Wrong<br class='clear'/>"; ?>
                </span>
            </div>
        </label>
        <?php endif; ?>
        <?php if($showDelete): ?>
<label>
    <input type="checkbox" class="alertCheckbox" autocomplete="off"/>
    <div class="alert notice">
        <span class="alertClose">X</span>
        <span class="alertText">Vendor Deleted Successfully!<br class="clear"/></span>
    </div>
</label>
<?php endif; ?>



<!--         <div class="generate-btn-container">
            <h2></h2>
            <button class="generate-btn">
                <article
                    class="article-wrapper"
                    onclick="window.location.href='vendorsView.php'">
                    <div class="rounded-lg container-projectss "></div>
                    <div class="project-info">
                        <div class="flex-pr">
                            <div class="project-title text-nowrap">Vendors</div>
                            <div class="project-hover">
                                <svg
                                    style="color: black;"
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="2em"
                                    height="2em"
                                    color="black"
                                    stroke-linejoin="round"
                                    stroke-linecap="round"
                                    viewbox="0 0 24 24"
                                    stroke-width="2"
                                    fill="none"
                                    stroke="currentColor">
                                    <line y2="12" x2="19" y1="12" x1="5"></line>
                                    <polyline points="12 5 19 12 12 19"></polyline>
                                </svg>
                            </div>
                        </div>
                        <div class="types"></div>
                    </div>
                </article>
            </button>
        </div> -->

        <!-- <div class="generate-btn-container"> <button class="generate-btn"
        onclick="window.location.href='vendorsView.php'"> <div class="project-info">
        <div class="flex-pr"> <div class="project-title text-nowrap">Vendors</div> <div
        class="project-hover"> <svg style="color: black;"
        xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" color="black"
        stroke-linejoin="round" stroke-linecap="round" viewBox="0 0 24 24"
        stroke-width="2" fill="none" stroke="currentColor"><line y2="12" x2="19" y1="12"
        x1="5"></line><polyline points="12 5 19 12 12 19"></polyline></svg> </div>
        </div> <div class="types"></div> </div> </button> </div> -->

        <!-- Vendors Button (top right) -->
        <div style="display:flex;justify-content:flex-end;align-items:center;margin:32px 0 0 0;">
            <button class="generate-btn" id="showVendorFormBtn" style="margin-right:32px;">
                <article class="article-wrapper">
                    <div class="rounded-lg container-projectss"></div>
                    <div class="project-info">
                        <div class="flex-pr">
                            <div class="project-title text-nowrap">Add Vendors</div>
                            <div class="project-hover">
                                <svg style="color: black;" xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" color="black" stroke-linejoin="round" stroke-linecap="round" viewBox="0 0 24 24" stroke-width="2" fill="none" stroke="currentColor">
                                    <line y2="12" x2="19" y1="12" x1="5"></line>
                                    <polyline points="12 5 19 12 12 19"></polyline>
                                </svg>
                            </div>
                        </div>
                        <div class="types"></div>
                    </div>
                </article>
            </button>
        </div>
        <!-- End Vendors Button -->

        <!-- Vendor Form (hidden by default) -->
        <form
            action="vendorsFleet.php<?php echo $edit_mode ? '?id=' . $vendor_edit['id'] . '&edit=1' : ''; ?>"
            method="POST"
            class="vendorform"
            autocomplete="off"
            id="vendorForm"
            style="display:none;margin-top:40px;">
            <div class="rentalclientcontainer">
                <p class="headingpara"><?php echo $edit_mode ? 'Edit Vendor' : 'Add Vendor'; ?></p>
                <?php if ($edit_mode): ?>
                    <input type="hidden" name="vendor_id" value="<?php echo $vendor_edit['id']; ?>">
                <?php endif; ?>
                <div class="trial1">
                    <input
                        type="text"
                        placeholder=""
                        name="vendor_name"
                        class="input02"
                        required="required"
                        value="<?php echo $vendor_edit ? htmlspecialchars($vendor_edit['vendor_name']) : (isset($_POST['vendor_name']) && !$showAlert && !$showError ? htmlspecialchars($_POST['vendor_name']) : ''); ?>">
                    <label for="" class="placeholder2">Vendor Name</label>
                </div>
                <div class="trial1">
                    <textarea
                        placeholder=""
                        name="office_address"
                        class="input02"
                        required="required"><?php echo $vendor_edit ? htmlspecialchars($vendor_edit['office_address']) : (isset($_POST['office_address']) && !$showAlert && !$showError ? htmlspecialchars($_POST['office_address']) : ''); ?></textarea>
                    <label for="" class="placeholder2">Office Address</label>
                </div>
                <div class="trial1">
                    <select name="clientstate" id="clientstate" class="input02">
                        <option value="" disabled="disabled" <?php echo !$vendor_edit ? 'selected' : ''; ?>>Select State</option>
                        <?php
                        $states = [
                            "Andaman and Nicobar Islands","Andhra Pradesh","Arunachal Pradesh","Assam","Bihar","Chandigarh","Chhattisgarh",
                            "Dadra and Nagar Haveli and Daman and Diu","Delhi","Goa","Gujarat","Haryana","Himachal Pradesh","Jammu and Kashmir",
                            "Jharkhand","Karnataka","Kerala","Ladakh","Lakshadweep","Madhya Pradesh","Maharashtra","Manipur","Meghalaya",
                            "Mizoram","Nagaland","Odisha","Puducherry","Punjab","Rajasthan","Sikkim","Tamil Nadu","Telangana","Tripura",
                            "Uttar Pradesh","Uttarakhand","West Bengal"
                        ];
                        foreach ($states as $state) {
                            $selected = ($vendor_edit && $vendor_edit['state'] == $state) ? 'selected' : '';
                            if (!$vendor_edit && isset($_POST['clientstate']) && $_POST['clientstate'] == $state && !$showAlert && !$showError) $selected = 'selected';
                            echo "<option value=\"$state\" $selected>$state</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="outer02">
                    <div class="trial1">
                        <input
                            type="text"
                            placeholder=""
                            name="vendor_code"
                            class="input02"
                            required="required"
                            value="<?php echo $vendor_edit ? htmlspecialchars($vendor_edit['vendor_code']) : (isset($_POST['vendor_code']) && !$showAlert && !$showError ? htmlspecialchars($_POST['vendor_code']) : ''); ?>">
                        <label for="" class="placeholder2">Vendor Code</label>
                    </div>
                    <select name="vendor_category" class="input02" required="required">
                        <option value="" disabled="disabled" <?php echo !$vendor_edit ? 'selected' : ''; ?>>Vendor Category</option>
                        <option value="Logistics" <?php if($vendor_edit && $vendor_edit['vendor_category']=='Logistics') echo 'selected'; elseif(isset($_POST['vendor_category']) && $_POST['vendor_category']=='Logistics' && !$showAlert && !$showError) echo 'selected'; ?>>Logistics</option>
                        <option value="Spares" <?php if($vendor_edit && $vendor_edit['vendor_category']=='Spares') echo 'selected'; elseif(isset($_POST['vendor_category']) && $_POST['vendor_category']=='Spares' && !$showAlert && !$showError) echo 'selected'; ?>>Spares</option>
                        <option value="OEM" <?php if($vendor_edit && $vendor_edit['vendor_category']=='OEM') echo 'selected'; elseif(isset($_POST['vendor_category']) && $_POST['vendor_category']=='OEM' && !$showAlert && !$showError) echo 'selected'; ?>>OEM</option>
                    </select>
                </div>
                <button type="submit" class="epc-button"><?php echo $edit_mode ? 'Update' : 'Submit'; ?></button>
            </div>
        </form>

        <!-- Vendor Cards Section (table layout, same as closed_rentalleads.php) -->
        <h2 style="margin-left:32px;margin-top:24px;font-weight:700;color:#22336b;">Vendors</h2>
        <div class="client-cards-container">
            <?php if (count($all_vendors) === 0): ?>
                <p style="text-align:center;color:#888;font-size:1.1em;">Added Vendors Will Be Displayed Here</p>
            <?php else: ?>
                <table class="" id="vendor_cards_table"><tr>
                <?php
                $loop_count = 0;
                foreach ($all_vendors as $row):
                    if ($loop_count > 0 && $loop_count % 3 == 0) {
                        echo '</tr><tr>';
                    }
                ?>
                    <td>
                        <a href="vendorRegionalOffice.php?id=<?= urlencode($row['id']) ?>" style="text-decoration:none;">
                            <div class="custom-card">
                                <h3 class="custom-card__title"><?= htmlspecialchars($row['vendor_name']) ?></h3>
                                <p class="insidedetails">Category: <?= htmlspecialchars($row['vendor_category']) ?></p>
                                <p class="insidedetails">Code: <?= htmlspecialchars($row['vendor_code']) ?></p>
                                <p class="insidedetails">Address: <?= htmlspecialchars($row['office_address']) ?></p>
                                <div class="custom-card__arrow">
                                    <i class="fas fa-arrow-right"></i>
                                </div>
                            </div>
                        </a>
                    </td>
                <?php
                    $loop_count++;
                endforeach;
                echo '</tr></table>';
            endif;
            ?>
        </div>
        <script>
            // Show form when Vendors button is clicked
            document.addEventListener('DOMContentLoaded', function() {
                var btn = document.getElementById('showVendorFormBtn');
                var form = document.getElementById('vendorForm');
                if (btn && form) {
                    btn.addEventListener('click', function() {
                        form.style.display = form.style.display === 'none' ? 'flex' : 'none';
                    });
                }
            });
            // ...existing code...
        </script>
    </body>
</html>