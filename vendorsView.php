<?php
session_start();
$companyname001 = $_SESSION['companyname'];
$enterprise = $_SESSION['enterprise'];
$dashboard_url = '';
if ($enterprise === 'rental') {
    $dashboard_url = 'rental_dashboard.php';
} elseif ($enterprise === 'logistics') {
    $dashboard_url = 'logisticsdashboard.php';
} elseif ($enterprise === 'epc') {
    $dashboard_url = 'epc_dashboard.php';
} else {
    $dashboard_url = '';
}

include "partials/_dbconnect.php";
// Only fetch vendors for the current company
$sql = "SELECT * FROM `vendors` WHERE companyname = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $companyname001);
$stmt->execute();
$result = $stmt->get_result();

// Group vendors by category
$vendors_by_category = [];
while ($row = $result->fetch_assoc()) {
    $category = $row['vendor_category'];
    if (!isset($vendors_by_category[$category])) {
        $vendors_by_category[$category] = [];
    }
    $vendors_by_category[$category][] = $row;
}
$stmt->close();

// Flatten all vendors into a single array for table display
$all_vendors = [];
foreach ($vendors_by_category as $category => $vendors) {
    foreach ($vendors as $row) {
        $all_vendors[] = $row;
    }
}

// Prepare filter options
$categories = [];
$vendor_names = [];
$vendor_codes = [];
foreach ($all_vendors as $row) {
    $categories[$row['vendor_category']] = true;
    $vendor_names[$row['vendor_name']] = true;
    $vendor_codes[$row['vendor_code']] = true;
}

// Filtering logic
$filtered_vendors = $all_vendors;
$filter_applied = false;
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['filtertype']) && $_GET['filtertype'] !== '') {
    $type = $_GET['filtertype'];
    if ($type === 'Category' && !empty($_GET['filtercategory'])) {
        $cat = $_GET['filtercategory'];
        $filtered_vendors = array_filter($all_vendors, function($row) use ($cat) {
            return $row['vendor_category'] === $cat;
        });
        $filter_applied = true;
    } elseif ($type === 'Vendor' && !empty($_GET['filtervendor'])) {
        $vn = $_GET['filtervendor'];
        $filtered_vendors = array_filter($all_vendors, function($row) use ($vn) {
            return $row['vendor_name'] === $vn;
        });
        $filter_applied = true;
    } elseif ($type === 'Code' && !empty($_GET['filtercode'])) {
        $vc = $_GET['filtercode'];
        $filtered_vendors = array_filter($all_vendors, function($row) use ($vc) {
            return $row['vendor_code'] === $vc;
        });
        $filter_applied = true;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css"> 
    <link rel="stylesheet" href="tiles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="shortcut icon" href="favicon.jpg" type="image/x-icon">
    <title>View Vendors</title> 
    <style>
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
            border: 1px solid #ddd;
            padding: 10px;
            margin: 10px 0;
            text-align: center;
        }
        .custom-card__title {
            font-size: 1.2em;
            margin: 0;
        }
        .custom-card__arrow i {
            font-size: 1.2em;
        }
        .generate-btn-container, .generate-btn {
            /* Use same style as vendorsFleet.php */
            display: flex;
            justify-content: flex-end;
            align-items: center;
            margin: 0;
            background: none;
            border: none;
        }
        .generate-btn {
            background-color: white!important;
            color: white!important;
            border: none!important;
            border-radius: 4px!important;
            padding: 10px 20px !important;
            cursor: pointer !important;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        }
        .article-wrapper{ 
            width:288px!important; 
            height:68px;
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
        .vendor-table-container {
            padding: 20px;
        }
        .vendor-btn-container {
            display: flex!important;
            justify-content: space-between!important;
            align-items: center!important;
            margin-bottom: 20px!important;
        }
        .vendor-btn {
            background-color: white;
            color: #2253a3;
            border: 1px solid #2253a3;
            border-radius: 4px;
            padding: 10px 20px;
            cursor: pointer;
            font-weight: 600;
            transition: background 0.18s, color 0.18s;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .vendor-btn:hover {
            background-color: #2253a3;
            color: #fff;
        }
        .vendor-table {
            width: 100%;
            font-size: 13px;
            border-collapse: collapse;
            margin-top: 20px;
            margin: 0 auto;
            padding: 10px;
        }
        .vendor-table, .vendor-table th, .vendor-table td {
            border: 1px solid black!important;
        }
        .vendor-table th, .vendor-table td {
            padding: 8px!important;
            text-align: left!important;
        }
        .table-heading {
            background-color: #4067B5!important;
            color: white!important;
        }
        .action-icon {
            background-color:#B4C5E4;
            color:black;
            border: 1px;
            border-radius:5px;
            width: 22px;
            height: 22px;
            display: inline-block;
            text-align: center;
            line-height: 22px;
        }
        @media screen and (max-width: 600px) {
            .vendor-table thead {
                display: none;
            }
            .vendor-table tr {
                border-bottom: 1px solid #4067B5;
                display: block;
                margin-bottom: 10px;
            }
            .vendor-table td {
                border-bottom: none;
                display: flex;
                flex-direction: column;
                justify-content: center;
                padding: 10px 0;
            }
            .vendor-table td:before {
                content: attr(data-label);
                float: left;
                font-weight: bold;
                text-transform: uppercase;
            }
            .vendor-btn-container {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
        }
        #vendorfilterbutton {
            background: #2253a3;
            color: #fff;
            border: 1px solid #2253a3;
            font-weight: 600;
            padding: 8px 22px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
<div class="navbar1">
    <div class="logo_fleet">
        <img src="logo_fe.png" alt="FLEET EIP" onclick="window.location.href='<?php echo $dashboard_url  ?>'">
    </div>
    <div class="iconcontainer">
        <ul>
            <li><a href="<?php echo $dashboard_url ?>">Dashboard</a></li>
            <li><a href="news/">News</a></li>
            <li><a href="logout.php">Log Out</a></li>
        </ul>
    </div>
</div>
<div class="vendor-table-container">
    <div class="vendor-btn-container">
        <h3 id="myclientheading">Vendors</h3>
        <button class="generate-btn" onclick="window.location.href='vendorsFleet.php'" style="margin-right:32px;">
            <article class="article-wrapper">
                <div class="rounded-lg container-projectss"></div>
                <div class="project-info">
                    <div class="flex-pr">
                        <div class="project-title text-nowrap">Add Vendor</div>
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
    <!-- Filter Section -->
    <div class="filters" id="vendorfilter" style="margin-bottom:18px; margin-left:18%;">
        <p>Apply Filter :</p>
        <form action="" class="vendorfilterform" method="GET" style="display:flex; gap:10px; flex-wrap:wrap;">
            <select name="filtertype" onchange="vendor_filter()" id="vendorfilterdd" class="filter_button">
                <option value="" disabled selected>Select Filter</option>
                <option value="Category">Category</option>
                <option value="Vendor">Vendor Name</option>
                <option value="Code">Vendor Code</option>
            </select>
            <select name="filtercategory" id="categoryfilter" class="vendor_select" style="display:none;">
                <option value="" disabled selected>Select Category</option>
                <?php foreach(array_keys($categories) as $cat): ?>
                <option value="<?php echo htmlspecialchars($cat); ?>"><?php echo htmlspecialchars($cat); ?></option>
                <?php endforeach; ?>
            </select>
            <select name="filtervendor" id="vendornamefilter" class="vendor_select" style="display:none;">
                <option value="" disabled selected>Select Vendor</option>
                <?php foreach(array_keys($vendor_names) as $vn): ?>
                <option value="<?php echo htmlspecialchars($vn); ?>"><?php echo htmlspecialchars($vn); ?></option>
                <?php endforeach; ?>
            </select>
            <select name="filtercode" id="vendorcodefilter" class="vendor_select" style="display:none;">
                <option value="" disabled selected>Select Code</option>
                <?php foreach(array_keys($vendor_codes) as $vc): ?>
                <option value="<?php echo htmlspecialchars($vc); ?>"><?php echo htmlspecialchars($vc); ?></option>
                <?php endforeach; ?>
            </select>
            <button id="vendorfilterbutton" class="filter_button">Submit</button>
        </form>
    </div>
    <!-- End Filter Section -->

    <table class="vendor-table">
        <thead>
            <tr>
                <th class="table-heading" style="width:5%;">#</th>
                <th class="table-heading" style="min-width:120px;">Vendor Name</th>
                <th class="table-heading" style="min-width:120px;">Category</th>
                <th class="table-heading" style="min-width:120px;">Code</th>
                <th class="table-heading" style="min-width:180px;">Address</th>
                <th class="table-heading" style="width:120px;">Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php
        if ($filter_applied && count($filtered_vendors) === 0): ?>
            <tr>
                <td colspan="6" class="text-center text-muted" style="color:#d00;font-weight:500;">No records found</td>
            </tr>
        <?php elseif (count($filtered_vendors) === 0): ?>
            <tr>
                <td colspan="6" class="text-center text-muted">Added Vendors Will Be Displayed Here</td>
            </tr>
        <?php else:
            $srno = 0;
            foreach ($filtered_vendors as $row):
                $srno++;
        ?>
            <tr>
                <td data-label="#"><?= $srno ?></td>
                <td data-label="Vendor Name"><?= htmlspecialchars($row['vendor_name']) ?></td>
                <td data-label="Category"><?= htmlspecialchars($row['vendor_category']) ?></td>
                <td data-label="Code"><?= htmlspecialchars($row['vendor_code']) ?></td>
                <td data-label="Address"><?= htmlspecialchars($row['office_address']) ?></td>
                <td data-label="Actions">
                    <a href="vendorRegionalOffice.php?id=<?= urlencode($row['id']) ?>" class="action-icon" title="View">
                        <i class="fa fa-eye"></i>
                    </a>
                </td>
            </tr>
        <?php endforeach; endif; ?>
        </tbody>
    </table>
</div>
<script>
function vendor_filter() {
    var type = document.getElementById('vendorfilterdd').value;
    document.getElementById('categoryfilter').style.display = 'none';
    document.getElementById('vendornamefilter').style.display = 'none';
    document.getElementById('vendorcodefilter').style.display = 'none';
    if (type === 'Category') {
        document.getElementById('categoryfilter').style.display = 'inline-block';
    } else if (type === 'Vendor') {
        document.getElementById('vendornamefilter').style.display = 'inline-block';
    } else if (type === 'Code') {
        document.getElementById('vendorcodefilter').style.display = 'inline-block';
    }
}
document.addEventListener('DOMContentLoaded', function() {
    var vendorfilterdd = document.getElementById('vendorfilterdd');
    if (vendorfilterdd.value !== '') {
        vendor_filter();
    }
});
</script>
</body>
</html>
