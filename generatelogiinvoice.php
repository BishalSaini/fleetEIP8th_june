<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice with Credit</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css">
    <style>
        @page {
            size: A4;
            margin: 0;
        }

        @media print {
            html,
            body {
                width: 210mm;
                height: 297mm;
            }
        }

        body {
            background: #f4f4f4;
            font-family: Arial, sans-serif;
        }

        .invoice {
            width: 100%;
            max-width: 970px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .logo {
            max-width: 150px;
            height: auto;
            margin-top: 20px;
        }

        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .pageTitle {
            margin-bottom: 0;
        }

        .ui.segment {
            border: none;
            box-shadow: none;
            padding: 0;
        }

        .ui.card {
            box-shadow: none;
            border: none;
            padding: 10px;
        }

        .itemscard table {
            width: 100%;
        }

        .itemscard table th,
        .itemscard table td {
            text-align: right;
        }

        .itemscard table th:first-child,
        .itemscard table td:first-child {
            text-align: left;
        }

        .bigfont {
            font-size: 2rem;
            margin: 0;
        }

        .mono {
            font-family: "Courier New", Courier, monospace;
        }

        .invoice-footer {
            text-align: center;
            font-size: 0.9em;
            color: #555;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="invoice">
        <div class="invoice-header">
            <div>
                <h1 class="ui header pageTitle">Invoice <small class="ui sub header">With Credit</small></h1>
                <h4 class="ui sub header invDetails">NO: 554775/R1 | Date: 01/01/2015</h4>
            </div>
            <div>
                <img class="logo" src="https://via.placeholder.com/150" alt="RCJA Australia Logo">
                <ul>
                    <li><strong>RCJA Australia</strong></li>
                    <li>Lorem Ipsum</li>
                    <li>2 Alliance Lane VIC</li>
                    <li>info@rcja.com</li>
                </ul>
            </div>
        </div>
        <div class="ui segment">
            <div class="ui two cards">
                <div class="ui card">
                    <div class="content">
                        <div class="header">Company Details</div>
                    </div>
                    <div class="content">
                        <ul>
                            <li><strong>Name:</strong> RCJA</li>
                            <li><strong>Address:</strong> 1 Unknown Street VIC</li>
                            <li><strong>Phone:</strong> (+61)404123123</li>
                            <li><strong>Email:</strong> admin@rcja.com</li>
                            <li><strong>Contact:</strong> John Smith</li>
                        </ul>
                    </div>
                </div>
                <div class="ui card">
                    <div class="content">
                        <div class="header">Customer Details</div>
                    </div>
                    <div class="content">
                        <ul>
                            <li><strong>Name:</strong> RCJA</li>
                            <li><strong>Address:</strong> 1 Unknown Street VIC</li>
                            <li><strong>Phone:</strong> (+61)404123123</li>
                            <li><strong>Email:</strong> admin@rcja.com</li>
                            <li><strong>Contact:</strong> John Smith</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="ui segment itemscard">
                <div class="content">
                    <table class="ui celled table">
                        <thead>
                            <tr>
                                <th>Item / Details</th>
                                <th>Unit Cost</th>
                                <th>Sum Cost</th>
                                <th>Discount</th>
                                <th>Tax</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    Lorem Ipsum Dolor
                                    <br>
                                    <small class="text-muted">The best lorem in town, try it now or leave forever</small>
                                </td>
                                <td>
                                    <span class="mono">$1,000.00</span>
                                    <br>
                                    <small class="text-muted">Before Tax</small>
                                </td>
                                <td>
                                    <span class="mono">$18,000.00</span>
                                    <br>
                                    <small class="text-muted">18 Units</small>
                                </td>
                                <td>
                                    <span class="mono">- $1,800.00</span>
                                    <br>
                                    <small class="text-muted">Special -10%</small>
                                </td>
                                <td>
                                    <span class="mono">+ $3,240.00</span>
                                    <br>
                                    <small class="text-muted">VAT 20%</small>
                                </td>
                                <td>
                                    <strong class="mono">$19,440.00</strong>
                                    <br>
                                    <small class="text-muted mono">$16,200.00</small>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Sit Amet Dolo
                                    <br>
                                    <small class="text-muted">Now you may sit</small>
                                </td>
                                <td>
                                    <span class="mono">$120.00</span>
                                    <br>
                                    <small class="text-muted">Before Tax</small>
                                </td>
                                <td>
                                    <span class="mono">$240.00</span>
                                    <br>
                                    <small class="text-muted">2 Units</small>
                                </td>
                                <td>
                                    <span class="mono">- $0.00</span>
                                    <br>
                                    <small class="text-muted">-</small>
                                </td>
                                <td>
                                    <span class="mono">+ $72.00</span>
                                    <br>
                                    <small class="text-muted">VAT:20% S:10%</small>
                                </td>
                                <td>
                                    <strong class="mono">$312.00</strong>
                                    <br>
                                    <small class="text-muted mono">$240.00</small>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot class="full-width">
                            <tr>
                                <th>Total:</th>
                                <th colspan="2"></th>
                                <th colspan="1">$500</th>
                                <th colspan="1">$800</th>
                                <th colspan="1">$20,000.00</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="ui card">
                <div class="content center aligned">
                    <small class="ui sub header">Amount Due (AUD):</small>
                    <p class="bigfont">$5,000.25</p>
                </div>
            </div>
            <div class="ui card">
                <div class="content">
                    <div class="header">Payment Details</div>
                </div>
                <div class="content">
                    <p><strong>Account Name:</strong> "RJCA"</p>
                    <p><strong>BSB:</strong> 111-111</p>
                    <p><strong>Account Number:</strong> 1234101</p>
                </div>
            </div>
            <div class="ui card">
                <div class="content">
                    <div class="header">Notes</div>
                </div>
                <div class="content">
                    Payment is requested within 15 days of receiving this invoice.
                </div>
            </div>
        </div>
        <div class="invoice-footer">
            Thank you for your business!
        </div>
    </div>
</body>

</html>