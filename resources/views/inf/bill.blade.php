<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Invoice :{{ $invoices[0]->invoice_number }}</title>
<script>
        // Function to handle right-click event
        function handleRightClick(event) {
            // Show the "View as PDF" button
            document.getElementById('pdfButton').style.display = 'block';
            
            // Prevent the default right-click context menu
            event.preventDefault();
        }

        // Function to generate PDF when the button is clicked
        function generatePDF() {
            const element = document.body;
            const options = {
                margin: 1,
                filename: 'myfile.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
            };

            // Generate PDF
            html2pdf().from(element).set(options).save();
        }

        // Add event listener to show the button on right-click
        document.addEventListener('contextmenu', handleRightClick);

        // Add event listener to generate PDF when the button is clicked
        document.getElementById('pdfButton').addEventListener('click', generatePDF);
    </script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.1/html2pdf.bundle.min.js"></script>
    <script>
    function generatePdnv() {
    var invoiceNumber = '{{$invoices[0]->invoice_number}}';
    var accountNumber = document.getElementById('accountNumber').innerText;
    var bankName = document.getElementById('bankName').innerText;
    console.log(bankName);
    var url = '/get-invoice-details/' + invoiceNumber + '/generate?accountNumber=' + encodeURIComponent(accountNumber) + '&bankName=' + encodeURIComponent(bankName);
    
    // Open the URL in a new tab
    window.open(url, '_blank');
}


</script>



    <style>
        html,
        body {
            margin: 10px;
            padding: 10px;
            font-family: sans-serif;
            border: none;
            background-color: #fff;
        }
        .pdf-button {
            position: fixed;
            top: 20px;
            right: 20px;
            font-size: 50px;
            padding: 10px 20px;
            background-color: green;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            display: none; /* Initially hidden */
        }
        h1,h2,h3,h4,h5,h6,p,span,label {
            font-family: sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 0px !important;
        }
        table thead th {
            height: 28px;
            text-align: left;
            font-size: 16px;
            font-family: sans-serif;
        }
        table, th, td {
            
            padding: 8px;
            font-size: 14px;
        }

        .heading {
            font-size: 24px;
            margin-top: 12px;
            margin-bottom: 12px;
            font-family: sans-serif;
        }
        .small-heading {
            font-size: 18px;
            font-family: sans-serif;
        }
        .total-heading {
            font-size: 18px;
            font-weight: 700;
            font-family: sans-serif;
        }
        .order-details tbody tr td:nth-child(1) {
            width: 20%;
        }
        .order-details tbody tr td:nth-child(3) {
            width: 20%;
        }

        .text-start {
            text-align: left;
        }
        .text-end {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .company-data span {
            margin-bottom: 4px;
            display: inline-block;
            font-family: sans-serif;
            font-size: 14px;
            font-weight: 400;
        }
        .no-border {
            border: 1px solid #fff !important;
        }
        .bg-blue {
            background-color: #FF2400;
            color: #fff;
        }
        /* Custom CSS for input and dropdown */
        .custom-input {
            border: none;
            padding: 8px;
            width: 90%;
            box-sizing: border-box;
            font-size: 14px;
            
        }
        .responsive-image {
            max-width: 100%;
            height: auto;
        }

        .custom-dropdown {
            -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
            border: none;
            padding: 8px;
            width: 90%;
            box-sizing: border-box;
            font-size: 14px;
            background-color: #fff;
            cursor: pointer;
        }
    </style>
</head>
<body>
<button id="pdfButton" class="pdf-button" onclick="generatePdnv()">Print</button>


    <table class="order-details">
        <thead>
            <tr>
                <th width="50%" colspan="2">
                    <img src="https://avotasautofleet.com/images/logo.png" alt=" Logo" class="responsive-image" width="200">
                </th>

                <th width="50%" colspan="2" class="text-end company-data">
                    
                    
                    <span>No 330 / 4 / 4 <br>
    New Kandy Road, <br>
    Delgoda <br>
    011 704 704 8 <br>
    avotasautofleet@gmail.com <br>
    www.avotastours.com<br>
    <span >{{$currentDate}}</span><br>
</span>

                </th>
            </tr>
            <tr class="bg-blue">
                <th width="50%" colspan="2">Customer Details</th>
                <th width="50%" colspan="2">Invoice Details</th>
                
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Customer Name:</td>
                <td>{{ $invoices[0]->customer_name }}</td>

                <td>Invoice Number:</td>
                <td>{{ $invoices[0]->invoice_number}}</td>
            </tr>
            <tr>
                <td>Mobile Number:</td>
                <td>{{ $invoices[0]->mobile }}</td>

                <td>User Name:</td>
                <td>{{ session('fname') }}</td>
            </tr>
            <tr>
                

                
            </tr>
            
        </tbody>
    </table>


<table class="order-details">
        <thead>
            
            <tr class="bg-blue">
                <th width="50%" colspan="2">Bank Details</th>
                <th width="50%" colspan="2">Vehicle Details</th>
                
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Bank Details:</td>
                <td>
                    <label id="bankName">{{ $bankName }}</label>
                </td>

                <td>Vehicle Number:</td>
                <td>{{ $invoices[0]->vehicle_number }}</td>
            </tr>
            <tr>
                
                    <td width="">Account Number:</td>
                    <td width=""><label id="accountNumber">{{ $accountNumber }}</label></td>
                

                <td>Vehicle Model:</td>
                <td>{{ $invoices[0]->vehicle_name }}</td>
            </tr>
            
        </tbody>
    </table>










    <table>
        <thead>
            <tr>
                <th class="no-border text-start heading" colspan="4">
                    Details
                </th>
            </tr>
            <tr class="bg-blue">
                <th>Vehicle Number</th>
                <th>Item code</th>
                <th>Description</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td width="20%">{{ $invoices[0]->vehicle_number }}</td>
                <td width="20%">
                    No code
                </td>
            
                <td  width="40%">No description</td>
                <td width="10%" class="fw-bold">{{ $invoices[0]->amount }}</td>
            </tr>
            
            <tr>
                <td align="right" colspan="3" class="total-heading">Total Amount - <small>Rs</small> :</td>
                <td colspan="" class="total-heading" align="right">{{ $invoices[0]->amount }}.00</td>
            </tr>
            <tr>
                <td align="right" colspan="3" class="total-heading"><small>Advanced Rs</small> :</td>
                <td colspan="" class="total-heading"  align="right">{{ $invoices[0]->advanced }}.00</td>
            </tr>
            <tr>
                <td align="right" colspan="3" class="total-heading"><small>Topay Rs</small> :</td>
                <td colspan="" class="total-heading"  align="right">{{ $invoices[0]->rest }}</td>
            </tr>
            <tr style="border-bottom: 1px solid red;">
                <td align="right" colspan="3" class="total-heading"><small>Deposit Rs</small> :</td>
                <td colspan="" class="total-heading"  align="right">{{$depo}}.00</td>
            </tr>
        </tbody>
    </table>

    <br>
    <p class="text-center">
        Thanks For Letting Us Serve You..!
    </p>
    <p class="text-center">
        Powered by Genic Webz / <a style="color: blue;" href="#">www.genicwebz.com</a> / 074 0421997
    </p>
<script>
    // Get the current date
    const currentDate = new Date();

    // Format the date (e.g., "24 / 09 / 2022")
    const formattedDate = currentDate.getDate() + ' / ' + (currentDate.getMonth() + 1) + ' / ' + currentDate.getFullYear();

    // Update the span element with the formatted date
    console.log(formattedDate)
    document.getElementById('currentDate').textContent = formattedDate;
</script>
</body>
</html>

{{-- @if(!$invoices->isEmpty())
@else
    <p>No invoice found.</p>
@endif --}}