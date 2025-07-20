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

// Pagination setup for PO
$po_per_page = 10;
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($page - 1) * $po_per_page;

// Count total unique POs for pagination
$sql_count = "SELECT COUNT(DISTINCT po.id) as total FROM purchase_orders po WHERE po.companyname='$companyname'";
$result_count = mysqli_query($conn, $sql_count);
$total_po = 0;
if ($row_count = mysqli_fetch_assoc($result_count)) {
    $total_po = intval($row_count['total']);
}
$total_pages = ceil($total_po / $po_per_page);

// Fetch only current page POs (IDs)
$sql_po_ids = "SELECT po.id FROM purchase_orders po WHERE po.companyname='$companyname' ORDER BY po.created_at DESC, po.id DESC LIMIT $po_per_page OFFSET $offset";
$result_po_ids = mysqli_query($conn, $sql_po_ids);
$po_ids = [];
while ($row = mysqli_fetch_assoc($result_po_ids)) {
    $po_ids[] = $row['id'];
}

// Fetch all product lines for current page POs and group by PO
$orders_by_po = [];
if (count($po_ids) > 0) {
    $po_ids_str = implode(',', array_map('intval', $po_ids));
    $sql = "SELECT po.id as po_id, po.vendor_id, po.vendor_name, pop.product_serial, pop.product_name, pop.qty, pop.unit_price, pop.total_price, po.created_at
            FROM purchase_orders po
            JOIN purchase_order_products pop ON po.id = pop.po_id
            WHERE po.companyname = ? AND po.id IN ($po_ids_str)
            ORDER BY po.created_at DESC, po.id DESC, pop.product_serial ASC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $companyname);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $orders_by_po[$row['po_id']]['po'] = $row;
        $orders_by_po[$row['po_id']]['products'][] = $row;
    }
    $stmt->close();
}

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

        
.pagination-nav {
  display: flex;
  justify-content: center;
  align-items: center;
  flex-wrap: wrap;
  gap: 2px;
  margin: 0 auto;
  padding: 0;
}

.pagination-btn {
  color: #4067B5;
  padding: 6px 14px;
  text-decoration: none;
  border: 1px solid #4067B5;
  margin: 0 2px;
  border-radius: 4px;
  background: #fff;
  font-weight: 500;
  transition: background 0.2s, color 0.2s;
  min-width: 36px;
  text-align: center;
  display: inline-block;
}

.pagination-btn:hover {
  background: #4067B5;
  color: #fff;
}

.pagination-btn.active {
  background: #4067B5;
  color: #fff;
  border: 1px solid #4067B5;
  pointer-events: none;
}

.pagination-ellipsis {
  padding: 6px 8px;
  color: #888;
  background: none;
  border: none;
  font-size: 16px;
  min-width: 20px;
  pointer-events: none;
}

/* Responsive for pagination */
@media screen and (max-width: 600px) {
  .pagination-nav {
    width: 100%;
    font-size: 14px;
    gap: 0;
  }
  .pagination-btn {
    padding: 6px 8px;
    font-size: 13px;
    min-width: 28px;
  }
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
        #vendorpofilterbutton {
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

        <!-- Move filter section here, directly below Add PO button -->
        <div class="filters" id="vendorpofilter" style="margin-bottom:18px; margin-left:18%;">
        <p>Apply Filter :</p>
        <form action="" class="vendorpofilterform" method="GET" style="display:flex; gap:10px; flex-wrap:wrap;">
            <select name="filtertype" onchange="vendorpo_filter()" id="vendorpofilterdd" class="filter_button">
                <option value="" disabled selected>Select Filter</option>
                <option value="Date">Date</option>
                <option value="Vendor">Vendor</option>
                <option value="Product">Product</option>
            </select>
            <input type="date" name="pofilter_date" id="vendorpofilterdate" class="vendorpo_select" style="display:none;">
            <select name="filtervendor" id="vendorfilter" class="vendorpo_select" style="display:none;">
                <option value="" disabled selected>Select Vendor</option>
                <?php
                $sql_vendor="SELECT DISTINCT vendor_name FROM purchase_orders WHERE companyname='$companyname'";
                $result_vendor=mysqli_query($conn,$sql_vendor);
                while($row_vendor=mysqli_fetch_assoc($result_vendor)){
                ?>
                <option value="<?php echo htmlspecialchars($row_vendor['vendor_name']); ?>"><?php echo htmlspecialchars($row_vendor['vendor_name']); ?></option>
                <?php } ?>
            </select>
            <select name="filterproduct" id="productfilter" class="vendorpo_select" style="display:none;">
                <option value="" disabled selected>Select Product</option>
                <?php
                $sql_product="SELECT DISTINCT product_name FROM purchase_order_products WHERE po_id IN (SELECT id FROM purchase_orders WHERE companyname='$companyname')";
                $result_product=mysqli_query($conn,$sql_product);
                while($row_product=mysqli_fetch_assoc($result_product)){
                ?>
                <option value="<?php echo htmlspecialchars($row_product['product_name']); ?>"><?php echo htmlspecialchars($row_product['product_name']); ?></option>
                <?php } ?>
            </select>
            <button id="vendorpofilterbutton" class="filter_button">Submit</button>
        </form>
    </div>

    <table class="vendorpo-table">
        <thead>
            <tr>
                <th class="table-heading" style="width:5%;">#</th>
                <th class="table-heading" style="min-width:120px;">Vendor</th>
                <th class="table-heading" style="min-width:180px;">Product</th>
                <th class="table-heading" style="width:60px;">Qty</th>
                <th class="table-heading" style="width:110px;">Total Price</th>
                <th class="table-heading" style="width:120px;">Date</th>
                <th class="table-heading" style="width:180px;">Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php
        // Filtering logic
        $filtered_orders_by_po = $orders_by_po;
        $filter_applied = false;
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && (
            isset($_GET['filtertype']) && $_GET['filtertype'] !== ''
        )) {
            $type = $_GET['filtertype'];
            if ($type === 'Date' && !empty($_GET['pofilter_date'])) {
                $date = $_GET['pofilter_date'];
                $filtered_orders_by_po = array_filter($orders_by_po, function($data) use ($date) {
                    return isset($data['po']['created_at']) && substr($data['po']['created_at'],0,10) === $date;
                });
                $filter_applied = true;
            } elseif ($type === 'Vendor' && !empty($_GET['filtervendor'])) {
                $vendor = $_GET['filtervendor'];
                $filtered_orders_by_po = array_filter($orders_by_po, function($data) use ($vendor) {
                    return isset($data['po']['vendor_name']) && $data['po']['vendor_name'] === $vendor;
                });
                $filter_applied = true;
            } elseif ($type === 'Product' && !empty($_GET['filterproduct'])) {
                $product = $_GET['filterproduct'];
                $filtered_orders_by_po = array_filter($orders_by_po, function($data) use ($product) {
                    foreach ($data['products'] as $prod) {
                        if ($prod['product_name'] === $product) return true;
                    }
                    return false;
                });
                $filter_applied = true;
            }
        }
        if ($filter_applied && count($filtered_orders_by_po) === 0): ?>
            <tr>
                <td colspan="7" class="text-center text-muted" style="color:#d00;font-weight:500;">No records found</td>
            </tr>
        <?php elseif (count($filtered_orders_by_po) === 0): ?>
            <tr>
                <td colspan="7" class="text-center text-muted">No Purchase Orders found.</td>
            </tr>
        <?php else:
            $srno = 0;
            foreach ($filtered_orders_by_po as $po_id => $data):
                $srno++;
                $po = $data['po'];
                $products = $data['products'];
                $vendor_name = $po['vendor_id'] && isset($vendorMap[$po['vendor_id']])
                    ? $vendorMap[$po['vendor_id']]
                    : $po['vendor_name'];
                $first_product = $products[0];
                $qty_total = 0;
                $price_total = 0;
                foreach ($products as $prod) {
                    $qty_total += intval($prod['qty']);
                    $price_total += floatval($prod['total_price']);
                }
        ?>
            <tr>
                <td data-label="#"><?= $srno ?></td>
                <td data-label="Vendor"><?= htmlspecialchars($vendor_name) ?></td>
                <td data-label="Product">
                    <span class="fw-semibold"><?= htmlspecialchars($first_product['product_serial']) ?></span>
                    <br>
                    <small class="text-muted"><?= htmlspecialchars($first_product['product_name']) ?></small>
                </td>
                <td data-label="Qty"><?= $qty_total ?></td>
                <td data-label="Total Price"><?= number_format($price_total, 2) ?></td>
                <td data-label="Date"><?= date('d-M-Y', strtotime($po['created_at'])) ?></td>
                <td data-label="Actions">
                    <a href="vendorPO06.php?edit=<?= $po_id ?>" class="vendorpo-icon" title="Edit">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <a href="#" onclick="return showDeleteModal('vendorPODelete.php?po_id=<?= $po_id ?>');" class="vendorpo-icon" title="Delete">
                        <i class="bi bi-trash"></i>
                    </a>
                    <a href="vendorPOPDF.php?id=<?= $po_id ?>" class="vendorpo-icon" title="PDF" target="_blank">
                        <i class="bi bi-file-earmark-pdf"></i>
                    </a>
                </td>
            </tr>
        <?php endforeach; endif; ?>
        </tbody>
    </table>
    <!-- Pagination Controls -->
<?php if ($total_pages > 1): ?>
<div style="text-align:center; margin:20px 0;">
    <nav class="pagination-nav">
        <?php if ($page > 1): ?>
            <a href="?page=1" class="pagination-btn">First</a>
            <a href="?page=<?php echo $page-1; ?>" class="pagination-btn">&laquo; Prev</a>
        <?php endif; ?>

        <?php
        $visible = 2;
        if ($total_pages <= 7) {
            for ($i = 1; $i <= $total_pages; $i++) {
                echo '<a href="?page='.$i.'" class="pagination-btn'.($i==$page?' active':'').'">'.$i.'</a>';
            }
        } else {
            echo '<a href="?page=1" class="pagination-btn'.($page==1?' active':'').'">1</a>';
            if ($page > $visible + 2) {
                echo '<span class="pagination-ellipsis">...</span>';
            }
            $start = max(2, $page - $visible);
            $end = min($total_pages - 1, $page + $visible);
            for ($i = $start; $i <= $end; $i++) {
                echo '<a href="?page='.$i.'" class="pagination-btn'.($i==$page?' active':'').'">'.$i.'</a>';
            }
            if ($page < $total_pages - $visible - 1) {
                echo '<span class="pagination-ellipsis">...</span>';
            }
            echo '<a href="?page='.$total_pages.'" class="pagination-btn'.($page==$total_pages?' active':'').'">'.$total_pages.'</a>';
        }
        ?>

        <?php if ($page < $total_pages): ?>
            <a href="?page=<?php echo $page+1; ?>" class="pagination-btn">Next &raquo;</a>
            <a href="?page=<?php echo $total_pages; ?>" class="pagination-btn">Last</a>
        <?php endif; ?>
    </nav>
</div>
<?php endif; ?>
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
function vendorpo_filter() {
    var type = document.getElementById('vendorpofilterdd').value;
    document.getElementById('vendorpofilterdate').style.display = 'none';
    document.getElementById('vendorfilter').style.display = 'none';
    document.getElementById('productfilter').style.display = 'none';
    if (type === 'Date') {
        document.getElementById('vendorpofilterdate').style.display = 'inline-block';
    } else if (type === 'Vendor') {
        document.getElementById('vendorfilter').style.display = 'inline-block';
    } else if (type === 'Product') {
        document.getElementById('productfilter').style.display = 'inline-block';
    }
}
document.addEventListener('DOMContentLoaded', function() {
    var vendorpofilterdd = document.getElementById('vendorpofilterdd');
    if (vendorpofilterdd.value !== '') {
        vendorpo_filter();
    }
});
</script>
</body>
</html>