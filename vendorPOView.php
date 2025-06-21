<?php
include_once 'partials/_dbconnect.php';
session_start();
$companyname = $_SESSION['companyname'] ?? '';
$enterprise = $_SESSION['enterprise'] ?? '';
$dashboard_url = '';
if ($enterprise === 'rental') {
    $dashboard_url = 'rental_dashboard.php';
} elseif ($enterprise === 'logistics') {
    $dashboard_url = 'logisticsdashboard.php';
} elseif ($enterprise === 'epc') {
    $dashboard_url = 'epc_dashboard.php';
}

// Fetch POs and product lines for this company
$orders = [];
$sql = "SELECT po.id as po_id, po.vendor_id, po.vendor_name, pop.product_serial, pop.product_name, pop.qty, pop.unit_price, pop.total_price, po.created_at
        FROM purchase_orders po
        JOIN purchase_order_products pop ON po.id = pop.po_id
        WHERE po.companyname = ?
        ORDER BY po.created_at DESC, po.id DESC, pop.product_serial ASC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $companyname);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $orders[] = $row;
}
$stmt->close();

// Get vendor names for mapping
$vendorMap = [];
$sql_vendors = "SELECT id, vendor_name FROM vendors WHERE companyname = ?";
$stmt_vendors = $conn->prepare($sql_vendors);
$stmt_vendors->bind_param("s", $companyname);
$stmt_vendors->execute();
$result_vendors = $stmt_vendors->get_result();
while ($row = $result_vendors->fetch_assoc()) {
    $vendorMap[$row['id']] = $row['vendor_name'];
}
$stmt_vendors->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">   
    <link rel="icon" href="favicon.jpg" type="image/x-icon">
    <title>Vendor Purchase Orders</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="tiles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        .vendorpo-table-container {
            padding: 20px;
        }
        .vendorpo-btn-container {
             display: flex!important;
             justify-content: space-between!important;
             align-items: center!important;
              margin-bottom: 20px!important;
        }
        .vendorpo-btn {
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
        .vendorpo-btn:hover {
            background-color: #2253a3;
            color: #fff;
        }
        .vendorpo-table {
            width: 100%;
            font-size: 13px;
            border-collapse: collapse;
            margin-top: 20px;
            margin: 0 auto;
            padding: 10px;
        }
        .vendorpo-table, .vendorpo-table th, .vendorpo-table td {
            border: 1px solid #4067B5 !important;
        }
        .vendorpo-table th, .vendorpo-table td {
            padding: 8px !important;
            text-align: left !important;
        }
        .vendorpo-table .table-heading {
            background-color: #4067B5 !important;
            color: white !important;
        }
        .vendorpo-icon {
            background-color: #B4C5E4;
            color: black;
            border-radius: 5px;
            width: 22px;
            height: 22px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-right: 4px;
            text-decoration: none;
        }
        .vendorpo-icon:hover {
            background: #4067B5;
            color: #fff;
        }
        .modal-overlay {
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,0,0,0.18);
            z-index: 9999;
            display: none;
            align-items: center;
            justify-content: center;
        }
        .modal-box {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 8px 32px rgba(34,83,163,0.18);
            padding: 32px 28px 22px 28px;
            min-width: 320px;
            max-width: 90vw;
            text-align: center;
            position: relative;
        }
        .modal-title {
            font-size: 20px;
            font-weight: 700;
            color: #2253a3;
            margin-bottom: 10px;
        }
        .modal-msg {
            font-size: 15px;
            color: #333;
            margin-bottom: 24px;
        }
        .modal-btn {
            background: #2253a3;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 8px 28px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            margin: 0 10px;
            transition: background 0.18s;
        }
        .modal-btn:hover {
            background: #1a237e;
        }
        @media screen and (max-width: 600px) {
            .vendorpo-table {
                border: 0;
            }
            .vendorpo-table thead {
                display: none;
            }
            .vendorpo-table tr {
                border-bottom: 1px solid #4067B5;
                display: block;
                margin-bottom: 10px;
            }
            .vendorpo-table td {
                border-bottom: none;
                display: flex;
                flex-direction: column;
                justify-content: center;
                padding: 10px 0;
            }
            .vendorpo-table td:before {
                content: attr(data-label);
                float: left;
                font-weight: bold;
                text-transform: uppercase;
            }
            .vendorpo-btn-container {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="navbar1">
        <div class="logo_fleet">
            <img src="logo_fe.png" alt="FLEET EIP" onclick="window.location.href='<?php echo $dashboard_url ?>'">
        </div>
        <div class="iconcontainer">
            <ul>
                <li><a href="<?php echo $dashboard_url ?>">Dashboard</a></li>
                <li><a href="news/">News</a></li>
                <li><a href="logout.php">Log Out</a></li>
            </ul>
        </div>
    </div>
    <div class="vendorpo-table-container">
        <div class="vendorpo-btn-container">
            <h2>Vendor Purchase Orders</h2>
           <!--  <button class="vendorpo-btn" onclick="window.location.href='vendorPO06.php'">
                <i class="bi bi-plus-circle"></i> Generate PO
            </button> -->  
              <button class="generate-btn" onclick="window.location.href='vendorPurchaseOrder.php'"> 
            <article class="article-wrapper" style="height:65px;" onclick="location.href='generate_quotation.php'" > 
  <div class="rounded-lg container-projectss ">
    </div>
    <div class="project-info">
      <div class="flex-pr">
        <div class="project-title text-nowrap">Add PO</div>
          <div class="project-hover">
            <svg style="color: black;" xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" color="black" stroke-linejoin="round" stroke-linecap="round" viewBox="0 0 24 24" stroke-width="2" fill="none" stroke="currentColor"><line y2="12" x2="19" y1="12" x1="5"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
            </div>
          </div>
          <div class="types">
        </div>
    </div>
</article> 
            </button>
        </div>
        <table class="vendorpo-table">
            <thead>
                <tr>
                    <th class="table-heading" style="width:5%;">#</th>
                    <th class="table-heading" style="min-width:120px;">Vendor</th>
                    <th class="table-heading" style="min-width:180px;">Product</th>
                    <th class="table-heading" style="width:60px;">Qty</th>
                    <th class="table-heading" style="width:110px;">Price</th>
                    <th class="table-heading" style="width:120px;">Date</th>
                    <th class="table-heading" style="width:180px;">Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php if (count($orders) === 0): ?>
                <tr>
                    <td colspan="7" class="text-center text-muted">No Purchase Orders found.</td>
                </tr>
            <?php else: foreach ($orders as $i => $o): ?>
                <tr>
                    <td data-label="#"> <?= $i+1 ?> </td>
                    <td data-label="Vendor">
                        <?= htmlspecialchars(
                            $o['vendor_id'] && isset($vendorMap[$o['vendor_id']])
                            ? $vendorMap[$o['vendor_id']]
                            : $o['vendor_name']
                        ) ?>
                    </td>
                    <td data-label="Product">
                        <span class="fw-semibold"><?= htmlspecialchars($o['product_serial']) ?></span>
                        <br>
                        <small class="text-muted"><?= htmlspecialchars($o['product_name']) ?></small>
                    </td>
                    <td data-label="Qty"><?= htmlspecialchars($o['qty']) ?></td>
                    <td data-label="Price"><?= htmlspecialchars($o['total_price']) ?></td>
                    <td data-label="Date"><?= date('d-M-Y', strtotime($o['created_at'])) ?></td>
                    <td data-label="Actions">
                        <a href="vendorPO06.php?edit=<?= $o['po_id'] ?>" class="vendorpo-icon" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <a href="#" onclick="return showDeleteModal('vendorPODelete.php?po_id=<?= $o['po_id'] ?>&product_serial=<?= urlencode($o['product_serial']) ?>');" class="vendorpo-icon" title="Delete">
                            <i class="bi bi-trash"></i>
                        </a>
                        <a href="vendorPOPDF.php?id=<?= $o['po_id'] ?>" class="vendorpo-icon" title="PDF" target="_blank">
                            <i class="bi bi-file-earmark-pdf"></i>
                        </a>
                    </td>
                </tr>
            <?php endforeach; endif; ?>
            </tbody>
        </table>
    </div>
<!-- Custom Delete Modal -->
<div class="modal-overlay" id="deleteModalOverlay">
    <div class="modal-box">
        <div class="modal-title">Delete Confirmation</div>
        <div class="modal-msg">Are you sure you want to delete this product line from the Purchase Order?</div>
        <button class="modal-btn" id="modalOkBtn">OK</button>
        <button class="modal-btn" id="modalCancelBtn">Cancel</button>
    </div>
</div>
<script>
let deleteUrl = '';
function showDeleteModal(url) {
    deleteUrl = url;
    document.getElementById('deleteModalOverlay').style.display = 'flex';
    return false;
}
document.getElementById('modalOkBtn').onclick = function() {
    window.location.href = deleteUrl;
};
document.getElementById('modalCancelBtn').onclick = function() {
    document.getElementById('deleteModalOverlay').style.display = 'none';
    deleteUrl = '';
};
</script>
</body>
</html>
