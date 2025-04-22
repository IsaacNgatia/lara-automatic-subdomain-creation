<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            /* background-image: url('{{ public_path('logo/header.png') }}'); */
            background-size: cover;
            /* Ensures the image covers the whole page */
            background-position: center;
            /* Centers the image */
            background-repeat: no-repeat;
            /* Prevents tiling */
        }

        .container {
            width: 100%;
            max-width: 800px;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #eaeaea;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 24px;
            color: #555;
        }

        .section-title {
            font-weight: bold;
            margin-bottom: 10px;
            color: #444;
        }

        .invoice-details,
        .payment-info {
            margin-bottom: 20px;
        }

        .invoice-details .detail-row,
        .payment-info .detail-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .table th {
            background: #f4f4f4;
            font-weight: bold;
            color: #333;
        }

        .table .total-row {
            font-weight: bold;
            text-align: right;
        }

        .table thead {
            background-color: #017CFF;
            /* Blue background */
            color: white;
            /* White text for contrast */
        }



        .footer-div {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            background-color: #017CFF;
            color: white;
            text-align: center;
            padding: 10px;
            font-size: 14px;
        }

        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            background-color: #017CFF;
            color: white;
            text-align: center;
            padding: 10px;
            font-size: 14px;
        }

        .footer-text {
            color: #fff;
        }

        .img-circle {
            border-radius: 50%;
        }

        .img-fluid {
            height: auto;
        }

        .company-image {
            max-width: 130px;
        }

        img {
            vertical-align: middle;
            border-style: none;
            word-wrap: break-word;
            text-align: left;
            padding-bottom: .5rem !important;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: #212529;

        }
    </style>
    {{-- <style>
            body {
                color: #2B2000;
                font-family: 'Helvetica';
                font-size: 11pt;
            }
    
            @page {
                margin: 3mm;
            }
    
            .invoice-box {
                width: 210mm;
                padding: 0mm;
                border: 0;
                font-size: 11pt;
                line-height: 12pt;
                color: #000;
            }
    
            .party {
                border: #ccc 1px solid;
            }
    
            table tr.heading td {
                background: #515151;
                color: #FFF;
                padding: 6pt;
            }
    
            .company {
                width: 300pt;
            }
    
            .customer {
                width: 290pt;
            }
    
            .bill_info {
                font-size: 10pt;
            }
    
            .heading {
                width: 900pt;
            }
    
            .m_fill {
                background-color: #eee;
            }
    
            .product_list td {
                padding: 4px;
            }
    
            .product_row td {
                border: 1px solid #ddd;
            }
    
            .summary td {
                padding-left: 8pt;
                padding-right: 8pt;
                margin: 2px;
                border: 1px solid #ccc;
    
    
            }
    
            .sign {
                text-align: center;
                margin-bottom: 4pt
            }
    
            .logo_box {
                width: 60%;
                align: left;
            }
    
            .date_box {
                width: 30%;
                align: right;
            }
    
            .text_center {
                text-align: center;
            }
    
            .text_right {
                text-align: right;
            }
    
            .sign_box {
                display: block;
                margin-left: 400pt;
                width: 100pt;
                align: right;
            }
    
            .row {
                width: 100%;
            }
    
    
        </style> --}}
</head>

<body>
    <div class="container">

        <div class="img-circle img-fluid company-image">
            <img src="{{ public_path('logo/temp_logo.png') }}" alt="Company Logo" width="100px">
            <h4>ISP Kenya </h4>
            <h4>INVOICE</h4>
        </div>

        <table style="width: 100%;">
            <tr>
                <td style="width: 50%; text-align: left; vertical-align: top;">
                    <strong>Invoice To:</strong><br>
                    <span>Isaac Miles</span><br>
                    <span>Phone: 0790008915</span><br>
                    <span>Date: {{ now()->toDateString() }}</span><br>
                </td>
                <td style="width: 50%; text-align: right; vertical-align: top;">
                    <strong>Pay To:</strong><br>
                    <span>ISP Kenya</span><br>
                    <span>Phone: 0790008915</span><br>
                    <span>Email: admin@ispkenya.co.ke</span><br>
                </td>
            </tr>
        </table>


        <table class="table">
            <thead style="background-color: #017CFF">
                <tr>
                    <th>Qty</th>
                    <th>Package</th>

                    <th>Reference No</th>
                    <th>Valid From</th>
                    <th>Valid To</th>
                    <th>Price (KES)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>profile1</td>
                    <td>0790008915</td>
                    <td>2024-01-16 00:00:00</td>
                    <td>2024-02-16 00:00:00</td>
                    <td>1.00</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>profile1</td>
                    <td>0790008915</td>
                    <td>2024-02-16 00:00:00</td>
                    <td>2024-03-16 00:00:00</td>
                    <td>1.00</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>profile1</td>
                    <td>0790008915</td>
                    <td>2024-03-16 00:00:00</td>
                    <td>2024-04-16 00:00:00</td>
                    <td>1.00</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5" class="total-row">Total (KES)</td>
                    <td>3.00</td>
                </tr>
            </tfoot>
        </table>


        <table style="width: 100%;">
            <tr>
                <td style="width: 50%; text-align: left; vertical-align: top;">
                    <strong>Payment Info</strong><br>
                    <span>Paybill: 4094869</span><br>
                    <span>Account: 0790008915</span><br>
                </td>
                <td style="width: 50%; text-align: right; vertical-align: top;">
                    <strong>Contact Info</strong><br>
                    <span>Phone: +254726179305</span><br>
                    <span>Email: admin@ispkenya.co.ke</span><br>
                </td>
            </tr>
        </table>
        <div class="footer-div">
            {{-- <div class="footer"> --}}
            <p class="footer-text">Copyright © {{ date('Y') }} | ISP Kenya - Your Billing Solution Partner</p>

            {{-- </div> --}}
        </div>
    </div>
</body>

</html>
{{-- 
<!DOCTYPE html>
<html>
<head>
    <title>Full-Page Image PDF</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
        }

        .full-page-image {
            width: 100%;
            height: 100vh; /* Full height of the viewport */
            object-fit: cover; /* Ensures the image scales proportionally and covers the area */
        }
    </style>
</head>
<body>
    <img src="{{ public_path('logo/header.png') }}" alt="Full Page Image" class="full-page-image">
</body>
</html> --}}
