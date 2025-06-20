<?php
include_once 'partials/_dbconnect.php';
session_start();
$companyname = $_SESSION['companyname'] ?? 'Company Name';
$po_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($po_id <= 0) {
    die('Invalid PO ID');
}
// Fetch PO header
$stmt = $conn->prepare("SELECT * FROM purchase_orders WHERE id = ?");
$stmt->bind_param("i", $po_id);
$stmt->execute();
$po = $stmt->get_result()->fetch_assoc();
$stmt->close();
if (!$po) die('PO not found');
// Fetch product lines
$stmt2 = $conn->prepare("SELECT * FROM purchase_order_products WHERE po_id = ? ORDER BY product_serial ASC");
$stmt2->bind_param("i", $po_id);
$stmt2->execute();
$products = $stmt2->get_result();
$stmt2->close();

// Fetch logo if available
$logo = '';
$sql_logo = "SELECT companylogo FROM basic_details WHERE companyname=? LIMIT 1";
$stmt_logo = $conn->prepare($sql_logo);
$stmt_logo->bind_param("s", $companyname);
$stmt_logo->execute();
$stmt_logo->bind_result($logo);
$stmt_logo->fetch();
$stmt_logo->close();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>PO PDF</title>
        <style>
            body {
                font-family: 'Segoe UI', Arial, sans-serif;
                font-size: 13px;
                background: #f4f4f4;
            }
            .container_outer {
                max-width: 800px;
                margin: 0 auto;
                background: #fff;
                box-shadow: 0 0 10px rgba(0,0,0,0.1);
                padding: 20px;
                border-radius: 8px;
            }
            .logo_namecontainer {
                width: 100%;
                display: flex;
                align-items: center;
                justify-content: center;
                border-bottom: 1px solid #4067B5;
                margin-bottom: 10px;
            }
            .companylogo img {
                max-width: 100px;
                max-height: 100px;
            }
            .compname_ {
                font-size: 28px;
                font-weight: bold;
                color: #2253a3;
                margin-left: 18px;
            }
            .section {
                margin-bottom: 18px;
            }
            .row {
                display: flex;
                justify-content: space-between;
                gap: 24px;
            }
            .col {
                width: 48%;
                background: #f5f7fa;
                border-radius: 6px;
                padding: 12px 16px;
                box-sizing: border-box;
                border: 1px solid #e0e0e0;
            }
            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 18px;
            }
            td,
            th {
                border: 1px solid #b0bec5;
                padding: 8px 6px;
                font-size: 13px;
            }
            th {
                background: #e3eafc;
                color: #1a237e;
                font-weight: 600;
            }
            .right {
                text-align: right;
            }
            .bold {
                font-weight: 700;
            }
            .totals {
                margin-top: 18px;
                width: 100%;
                max-width: 340px;
                margin-left: auto;
                margin-right: 0;
                float: none;
            }
            .totals td {
                border: none;
                font-size: 14px;
            }
            .totals .bold {
                font-size: 15px;
            }
            .footer {
                margin-top: 40px;
                font-size: 13px;
                color: #555;
                border-top: 1px solid #e0e0e0;
                padding-top: 12px;
            }
            .download-btn,
            .goback-btn {
                display: inline-block;
                background: #2253a3;
                color: #fff;
                border: none;
                border-radius: 5px;
                padding: 10px 28px;
                font-size: 15px;
                font-weight: 600;
                cursor: pointer;
                transition: background 0.2s;
                margin: 0 10px;
            }
            .download-btn:hover,
            .goback-btn:hover {
                background: #1a237e;
            }
            .no-print {
                text-align: center;
                margin: 40px auto 20px;
            }
            .section-title-inline {
                font-weight: 600;
                display: inline-block;
                margin-right: 6px;
            }
            @media print {
                .no-print {
                    display: none !important;
                }
            }
        </style>
    </head>
    <body>
        <div class="no-print">
            <button type="button" onclick="downloadPDF()" class="download-btn">Download PDF</button>
            <button type="button" onclick="goBack()" class="goback-btn">Go Back</button>
        </div>
        <div class="container_outer">
            <div class="logo_namecontainer">
                <div class="companylogo">
                    <?php if ($logo): ?>
                    <img src="img/<?= htmlspecialchars($logo) ?>" alt="Logo">
                    <?php endif; ?>
                </div>
                <div class="compname_">
                    <?= htmlspecialchars($companyname) ?>
                </div>
            </div>
            <div class="section row">
                <div class="col">
                    <div>
                        <span class="section-title-inline">Bill To :</span><span><?= htmlspecialchars($po['bill_to_name']) ?></span></div>
                    <div><?= nl2br(htmlspecialchars($po['bill_to_address'])) ?><br>
                        GSTIN:
                        <?= htmlspecialchars($po['bill_to_gstin']) ?><br>
                        PAN:
                        <?= htmlspecialchars($po['bill_to_pan']) ?><br>
                        Contact person:
                        <?= htmlspecialchars($po['bill_to_contact']) ?>
                    </div>
                </div>
                <div class="col">
                    <div>
                        <span class="section-title-inline">Ship To :</span><span><?= htmlspecialchars($po['ship_to_name']) ?></span></div>
                    <div><?= nl2br(htmlspecialchars($po['ship_to_address'])) ?><br>
                        GSTIN:
                        <?= htmlspecialchars($po['ship_to_gstin']) ?><br>
                        PAN:
                        <?= htmlspecialchars($po['ship_to_pan']) ?><br>
                        Contact person:
                        <?= htmlspecialchars($po['ship_to_contact']) ?>
                    </div>
                </div>
            </div>
            <div class="section">
                <table>
                    <tr>
                        <th>SNO</th>
                        <th>Description & Specification of Goods</th>
                        <th>HSN/SAC</th>
                        <th>Qty & UOM</th>
                        <th>Rate per Unit</th>
                        <th>Disc</th>
                        <th>Net Amount</th>
                    </tr>
                    <?php $i=1; $total=0; foreach ($products as $prod): ?>
                    <tr>
                        <td class="right"><?= $i++ ?></td>
                        <td><?= htmlspecialchars($prod['product_name']) ?></td>
                        <td><?= htmlspecialchars($prod['product_serial']) ?></td>
                        <td class="right"><?= htmlspecialchars($prod['qty']) ?>
                            <?= htmlspecialchars($prod['product_uom']) ?></td>
                        <td class="right"><?= number_format($prod['unit_price'],2) ?></td>
                        <td class="right">-</td>
                        <td class="right"><?= number_format($prod['total_price'],2) ?></td>
                    </tr>
                    <?php $total += $prod['total_price']; endforeach; ?>
                </table>
            </div>
            <table class="totals">
                <tr>
                    <td class="right bold">Taxable Total:</td>
                    <td class="right"><?= number_format($total,2) ?></td>
                </tr>
                <tr>
                    <td class="right bold">CGST:</td>
                    <td class="right">-</td>
                </tr>
                <tr>
                    <td class="right bold">SGST:</td>
                    <td class="right">-</td>
                </tr>
                <tr>
                    <td class="right bold">Invoice Total:</td>
                    <td class="right bold"><?= number_format($total,2) ?></td>
                </tr>
            </table>
            <div class="footer">
                <div>Terms of delivery: Customer Account</div>
                <div>Mode of Transport: Self Pick</div>
                <div>Payment terms: 0030 Within 30 days net</div>
            </div>
        </div>
        <script
            src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>
        <script>
            function downloadPDF() {
                // Hide the buttons before generating PDF
                document
                    .querySelector('.no-print')
                    .style
                    .display = 'none';
                const element = document.querySelector('.container_outer');
                html2pdf()
                    .from(element)
                    .set({
                        margin: 0.2,
                        filename: 'PO_<?= $po_id ?>.pdf',
                        image: {
                            type: 'jpeg',
                            quality: 1.0
                        },
                        html2canvas: {
                            dpi: 400,
                            letterRendering: true,
                            scale: 2,
                            useCORS: true
                        },
                        jsPDF: {
                            unit: 'in',
                            format: 'letter',
                            orientation: 'portrait'
                        }
                    })
                    .save()
                    .then(() => {
                        // Show the buttons again after PDF is generated
                        document
                            .querySelector('.no-print')
                            .style
                            .display = 'block';
                    });
            }
            function goBack() {
                window.location.href = 'vendorPOView.php';
            }
        </script>
    </body>
</html>