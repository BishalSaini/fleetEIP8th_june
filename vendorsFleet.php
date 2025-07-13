<?php
session_start();
$companyname001 = $_SESSION['companyname'];
$showAlert = false;
$showError = false; 


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include "partials/_dbconnect.php";
    $vendor_name = $_POST['vendor_name'];
    $office_address = $_POST['office_address'];
    $vendor_code = $_POST['vendor_code'];
    $vendor_category = $_POST['vendor_category'];
    $state = $_POST['clientstate'];
    $company_name = $companyname001; // from session

    // Insert companyname and state into the vendors table
    $sql = "INSERT INTO vendors (vendor_name, office_address, vendor_code, vendor_category, state, companyname) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $vendor_name, $office_address, $vendor_code, $vendor_category, $state, $company_name);
    if ($stmt->execute()) {
        $showAlert = true;
    } else {
        $showError = true;
    }
    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Add Vendor</title>
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="tiles.css">
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

        <div class="generate-btn-container">
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
        </div>

        <!-- <div class="generate-btn-container"> <button class="generate-btn"
        onclick="window.location.href='vendorsView.php'"> <div class="project-info">
        <div class="flex-pr"> <div class="project-title text-nowrap">Vendors</div> <div
        class="project-hover"> <svg style="color: black;"
        xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" color="black"
        stroke-linejoin="round" stroke-linecap="round" viewBox="0 0 24 24"
        stroke-width="2" fill="none" stroke="currentColor"><line y2="12" x2="19" y1="12"
        x1="5"></line><polyline points="12 5 19 12 12 19"></polyline></svg> </div>
        </div> <div class="types"></div> </div> </button> </div> -->

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
                <span class="alertText">Something Went Wrong<br class="clear"/></span>
            </div>
        </label>
        <?php endif; ?>

        <form
            action="vendorsFleet.php"
            method="POST"
            class="vendorform"
            autocomplete="off"
            style="margin-top: 40px;">
            <div class="rentalclientcontainer">
                <p class="headingpara">Add Vendor</p>
                <div class="trial1">
                    <input
                        type="text"
                        placeholder=""
                        name="vendor_name"
                        class="input02"
                        required="required">
                    <label for="" class="placeholder2">Vendor Name</label>
                </div>
                <div class="trial1">
                    <textarea
                        placeholder=""
                        name="office_address"
                        class="input02"
                        required="required"></textarea>
                    <label for="" class="placeholder2">Office Address</label>
                </div>

                <div class="trial1">
                    <select name="clientstate" id="clientstate" class="input02">
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

                </div>
                <div class="outer02">
                    <div class="trial1">
                        <input
                            type="text"
                            placeholder=""
                            name="vendor_code"
                            class="input02"
                            required="required">
                        <label for="" class="placeholder2">Vendor Code</label>
                    </div>

                    <select name="vendor_category" class="input02" required="required">
                        <option value="" disabled="disabled" selected="selected">Vendor Category</option>
                        <option value="Logistics">Logistics</option>
                        <option value="Spares">Spares</option>
                        <option value="OEM">OEM</option>
                    </select>
                </div>
                <button type="submit" class="epc-button">Submit</button>
            </div>
        </form>
    </body>
</html>