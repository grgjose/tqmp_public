<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>6K5 GLASS INSTALLATION SERVICES - Quotation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            box-sizing: border-box; 
            font-size: 10pt;
        }
        .container {
            width: 8.5in; 
            margin: 0 auto;
            border: 1px solid #ccc; 
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header, .recipient-info, .items-table, .summary, .signatures, .terms, .bank-info {
            margin-bottom: 15px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 1px solid #000;
            padding-bottom: 10px;
        }
        .header p {
            margin: 0;
            line-height: 1.3;
        }
        .header .main-title {
            font-size: 14pt;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .header .address {
            font-size: 9pt;
        }
        .header .quotation-details {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
            font-size: 10pt;
            border-top: 1px solid #000;
            padding-top: 5px;
        }
        .header .quotation-details div {
            flex: 1;
        }
        .header .quotation-details .right-align {
            text-align: right;
        }
        .recipient-info {
            display: flex;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }
        .recipient-info .left-col, .recipient-info .right-col {
            flex: 1;
            padding-right: 10px;
            box-sizing: border-box;
        }
        .recipient-info .right-col {
            padding-left: 10px;
        }
        .recipient-info p {
            margin: 2px 0;
            font-size: 9pt;
        }
        .recipient-info .label {
            font-weight: bold;
        }
        .recipient-info .customer-name {
            font-size: 11pt;
            font-weight: bold;
        }
        .recipient-info .vat-reg {
            border: 1px solid #000;
            width: 30px;
            height: 20px;
            display: inline-block;
            vertical-align: middle;
            text-align: center;
            line-height: 20px;
            margin-right: 5px;
        }
        .recipient-info .box-w, .recipient-info .box-h {
            border: 1px solid #000;
            width: 20px;
            height: 20px;
            display: inline-block;
            vertical-align: middle;
            text-align: center;
            line-height: 20px;
            margin-left: 5px;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 9pt;
        }
        .items-table th, .items-table td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
        }
        .items-table th {
            background-color: #f2f2f2;
            text-align: center;
        }
        .items-table .text-center { text-align: center; }
        .items-table .text-right { text-align: right; }
        .items-table .qty-col { width: 5%; }
        .items-table .item-col { width: 25%; }
        .items-table .desc-col { width: 30%; }
        .items-table .width-col, .items-table .height-col, .items-table .unit-col, .items-table .total-col {
            width: 10%; 
        }
        .summary {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 20px;
        }
        .summary-box {
            width: 300px; 
            border: 1px solid #000;
            padding: 10px;
            box-sizing: border-box;
            font-size: 10pt;
        }
        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }
        .summary-row.total {
            font-weight: bold;
            border-top: 1px solid #000;
            padding-top: 5px;
            margin-top: 5px;
        }
        .summary-row.quotation-no {
            text-align: center;
            margin-top: 15px;
            font-size: 12pt;
            font-weight: bold;
            padding: 5px 0;
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
            background-color: #f2f2f2;
        }
        .summary-row.quotation-no span {
            border: 2px solid #000;
            padding: 3px 8px;
        }
        .quotation-notes {
            margin-top: 20px;
            font-size: 9pt;
            line-height: 1.4;
            display: flex;
        }
        .quotation-notes .left-notes {
            flex: 2;
            padding-right: 15px;
        }
        .quotation-notes .right-notes {
            flex: 1;
            padding-left: 15px;
            border-left: 1px solid #ccc; 
        }
        .quotation-notes .right-notes p {
            margin: 0 0 5px 0;
        }
        .quotation-notes .important-note {
            font-weight: bold;
            color: red;
        }
        .signatures {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
            font-size: 9pt;
        }
        .signature-block {
            width: 45%;
        }
        .signature-line {
            border-bottom: 1px solid #000;
            margin-top: 50px; 
            margin-bottom: 5px;
        }
        .signatures .title {
            text-align: center;
            font-weight: bold;
        }
        .signatures .contact-info {
            text-align: center;
            font-style: italic;
        }
        .signatures .right-block {
            text-align: center;
        }
        .terms {
            margin-top: 30px;
            border: 1px solid #000;
            padding: 10px;
            font-size: 8pt;
            line-height: 1.4;
        }
        .terms p {
            margin: 0 0 5px 0;
        }
        .terms .terms-title {
            font-weight: bold;
            margin-bottom: 10px;
            text-decoration: underline;
        }
        .bank-info {
            margin-top: 20px;
            padding: 10px;
            border: 1px solid #ccc;
            font-size: 8pt;
            text-align: right;
        }
        .bank-info p {
            margin: 2px 0;
        }
        .bank-info .account-number {
            font-size: 10pt;
            font-weight: bold;
            margin-top: 10px;
        }
        @media print {
            body {
                margin: 0;
                padding: 0;
                font-size: 9pt; 
            }
            .container {
                border: none; 
                box-shadow: none;
                width: 100%; 
                padding: 0;
            }
            .header, .recipient-info, .items-table, .summary, .signatures, .terms, .bank-info {
                margin-bottom: 10px; 
            }
            .header .main-title { font-size: 12pt; }
            .header .address { font-size: 8pt; }
            .recipient-info p, .items-table th, .items-table td, .summary-box {
                font-size: 8pt; 
            }
            .summary-row.quotation-no { font-size: 10pt; }
            .quotation-notes { font-size: 8pt; }
            .signatures { margin-top: 20px; }
            .signature-line { margin-top: 30px; } 
            .terms { font-size: 7pt; padding: 5px; }
            .bank-info { font-size: 7pt; padding: 5px; }
            .bank-info .account-number { font-size: 9pt; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <p class="main-title">Main Office: 108 Sapang Bakaw St, Laguno Balay, Valenzuela City</p>
            <p class="address">
                Telefax: 82880767 to 68; Fax. Number: 82888707 to 68 press 6<br>
                GPAA Stad: Mesa 80546126; Quezon City: 85189002; Masing: 84700135; Blumentritt: 85215155;Mindoro: 0432887450; Isabela: 0783247617; Dagupan: 0756005737; Batangas: 0437400035
            </p>
            <p class="address">Tel.#: 032-8208767 Email Address: sales@tqmp.biz</p>
            <p class="address">JUN-17-25 09:48 AM</p>
            <div class="quotation-details">
                <div>Quote Date June 16, 2025</div>
                <div>Quotation No.: Q-011022-F</div>
                <div>Terms CASH</div>
                <div>011022-F</div>
                <div class="right-align">Page: 1 of 1</div>
            </div>
        </div>
        <div class="recipient-info">
            <div class="left-col">
                <p><span class="label">6K5 GLASS INSTALLATION SERVICES</span></p>
                <p>Blk 12A Lot 20 Phase 5 Eastwood Residences</p>
                <p><span class="label">Tel #.:</span> -</p>
                <p><span class="label">Fax #.:</span> -</p>
                <p>Dear Sir/Madam:</p>
                <p>We are pleased to quote you for the following item/s:</p>
                <p>w/ <span class="vat-reg"></span></p>
            </div>
            <div class="right-col">
                <p><span class="label">F-0960</span></p>
                <p><span class="label">Branch:</span> MNL</p>
                <p><span class="label">Cust. P.O.#</span></p>
                <p>
                    <span class="label">W</span> <span class="box-w"></span> <span class="label">X For Log:</span> <span class="box-h"></span> <span class="label">H</span>
                </p>
            </div>
        </div>
        <table class="items-table">
            <thead>
                <tr>
                    <th class="qty-col">Item</th>
                    <th class="item-col">Pattern</th>
                    <th class="desc-col">Description/Size</th>
                    <th class="width-col">Width</th>
                    <th class="height-col">Height</th>
                    <th class="unit-col">Unit Price</th>
                    <th class="total-col">Total</th>
                </tr>
                <tr>
                    <td class="text-center">1</td>
                    <td class="text-center">2</td>
                    <td class="text-center"></td>
                    <td class="text-center">1</td>
                    <td class="text-center">2</td>
                    <td class="text-center"></td>
                    <td class="text-center"></td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><input type="checkbox" checked> 1</td>
                    <td>6mm Clear</td>
                    <td>Temp/FEP-Shape Glass</td>
                    <td class="text-right">55 1/8</td>
                    <td class="text-right">35 3/8</td>
                    <td class="text-right">1,500.00</td>
                    <td class="text-right">1,500.00</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2">Qty: <span style="border: 1px solid #000; padding: 2px 5px;">1</span> Deliver</td>
                    <td colspan="2">GPAAD QC</td>
                    <td colspan="2" class="text-right">Total:</td>
                    <td class="text-right" style="font-weight: bold;">1,500.00</td>
                </tr>
            </tfoot>
        </table>
        <div class="quotation-notes">
            <div class="left-notes">
                <p>In case any revision, such as hold, changes in size or other special instructions, after confirmation of this quotation JO revision Form has to be signed and acknowledge to confirm validity. It is important that the customer keep copy of the JO revision Form which is signed by your company representative and your office.</p>
                <div class="summary">
                    <div class="summary-box">
                        <div class="summary-row">
                            <span>Add. Chrgs:</span>
                            <span>1,650.00</span>
                        </div>
                        <div class="summary-row">
                            <span>Trucking Fee</span>
                            <span>150.00</span>
                        </div>
                        <div class="summary-row total">
                            <span>Net Total:</span>
                            <span>1,650.00</span>
                        </div>
                        <div class="summary-row quotation-no">
                            <span>Q-011022-F</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="right-notes">
                <p><span class="important-note">Important</span></p>
                <p>Items ordered should be claimed 30days from the date downpayment has been made otherwise, glass ordered will be automatically for disposal without need for further notice due to quality & storage concerns. Further, <span class="important-note">PAYMENT MADE WILL BE AUTOMATICALLY FORFEITED</span>.</p>
                <p style="margin-top: 20px;">Payment Info. for Bank Transfer</p>
                <p>TOTAL QUALITY MANUFACTURING PRODUCTS (TQMP)</p>
                <p>PHILIPPINES CORPORATION</p>
                <p style="margin-top: 10px; font-weight: bold;">BDO 003900422278</p>
            </div>
        </div>
        <div class="signatures">
            <div class="signature-block">
                <div class="signature-line"></div>
                <p class="title">EDWIN BARILLO</p>
                <p class="contact-info">Sales Executive</p>
            </div>
            <div class="signature-block">
                <p>Conforme: 6K5 GLASS INSTALLATION SERVICES</p>
                <p>Due date:____________</p>
                <p class="contact-info">email to: sales@tqmp.biz</p>
                <p style="margin-top: 50px;">Checked By: __________________________</p>
            </div>
        </div>
        <div class="terms">
            <p class="terms-title">TERMS & CONDITIONS:</p>
            <ol>
                <li>PAYMENT TERMS: FULL PAYMENT UPON CONFORMING ORDER.</li>
                <li>DELIVERY WILL BE MADE 1-2 WEEKS AFTER CONFORME & PAYMENT MADE.</li>
                <li>CLEAR COPY OF DETAILED DRAWING WITH COMPLETE DIMENSIONS & FULLY SIGNED.</li>
                <li>DELIVERY HAS TO BE DONE ONLY UP TO THE GROUND FLOOR WITH STAGING AREA ALONG THE STREET ADJACENT TO THE JOBSITE. WE WILL NOT BE RESPONSIBLE TO BRING THE GOODS TO THEIR STORAGE AREA.</li>
            </ol>
            <ol start="5">
                <li>ANY ADJUSTMENT, CHANGE IN QUOTATION, REQUIREMENTS, SPECIFICATIONS WILL BE CHARGED ACCORDINGLY.</li>
                <li>PRICES MAY CHANGED WITHOUT PRIOR NOTICE.</li>
                <li>ITEMS QUOTED WILL BE SUBJECT TO STOCK AVAILABILITY AT THE TIME OF ACTUAL ORDERING.</li>
            </ol>
            <p class="terms-title" style="margin-top: 15px;">TERMS AND CONDITIONS FOR QUALITY</p>
            <ol>
                <li>SETTLEMENT OF QUALITY OVER HASSLE. RESERVATIONS TO AND IT OBJECT CUSTOMER ON OUR VERIFICATION OF CUSTOMER GLAZES MATERIALS ORDERED PARTNERSHIP. CUSTOMER REPRESENTATIVE IS ORDERED VALUATION ARE ALL.</li>
            </ol>
            <ol start="2">
                <li>GLASS IS SOMEWHAT UNPREDICTABLE MATERIAL. THIS IS THE REASON WHY GLASS IS NOT WARRANTABLE. HANDLING DEFECT AND ON-ON BREAKAAGE SHALL NOT BE THE</li>
            </ol>
        </div>
        <div class="bank-info">
            <p>Payment Info. for Bank Transfer</p>
            <p>TOTAL QUALITY MANUFACTURING PRODUCTS (TQMP)</p>
            <p>PHILIPPINES CORPORATION</p>
            <p class="account-number">BDO 003900422278</p>
        </div>
    </div>
</body>
</html>