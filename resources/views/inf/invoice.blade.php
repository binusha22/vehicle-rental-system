@extends('layouts.lay')
@section('title', 'Invoice Details')
@section('style')

@endsection

@section('script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        function filterTable() {
            var invoiceNumber = $('#search_by_invoice_number').val();
            var customerName = $('#search_by_customer').val();

            $.ajax({
                url: "{{ route('filterInvoices') }}",
                type: 'GET',
                data: {
                    invoice_number: invoiceNumber,
                    customer_name: customerName
                },
                success: function (response) {
                    // Clear the existing rows in the table body
                    console.log(response);
                    $('#invoice_table tbody').empty();

                    if (response.length > 0) {
                        // Populate the table with the filtered data
                        response.forEach(function (inv) {
                            var row = '<tr>' +
                                '<td>' + inv.invoice_number + '</td>' +
                                '<td>' + inv.customer_name + '</td>' +
                                '<td>' + inv.reg_date + '</td>' +
                                '<td><button onclick="openModal(\'' + inv.invoice_number + '\')" class="btn btn-light">Set To Print</button></td>' +
                                '</tr>';
                            $('#invoice_table tbody').append(row);
                        });
                    } else {
                        // Display no invoice found message
                        var noDataRow = '<tr><td colspan="4">No invoice found  <a href="#"><b><span style="color:red;">Refresh</span></b></a></td></tr>';
                        $('#invoice_table tbody').append(noDataRow);
                    }
                },
                error: function (error) {
                    console.log(error);
                }
            });
        }

        $('#searchButton').click(function () {
            filterTable();
        });

        $('#search_by_invoice_number, #search_by_customer').on('keyup', function (e) {
            if (e.key === 'Enter') {
                filterTable();
            }
        });
    });
</script>
<script>
    var selectedInvoiceNumber = '';

    function openModal(invoiceNumber) {
        selectedInvoiceNumber = invoiceNumber;
        document.getElementById("inputModal").style.display = "block";
    }

    function closeModal() {
        document.getElementById("inputModal").style.display = "none";
    }

    function submitForm() {
        var bankName = document.getElementById("bankName").value;
        var accountNumber = document.getElementById("accountNumber").value;
        var url = '/get-invoice-details/' + selectedInvoiceNumber + '?bankName=' + encodeURIComponent(bankName) + '&accountNumber=' + encodeURIComponent(accountNumber);
        
        // Open the URL in a new tab
        window.open(url, '_blank');

        // Close the modal
        closeModal();
    }
</script>
@endsection

@section('content')
<section id="input-group-buttons mb-5">
    <h2 class="text-title">Search your invoice here</h2>
    <div class="row">
        <div class="col-md-6 mb-0 mt-2">
            <div class="input-group">
                <input type="text" class="form-control" id="search_by_invoice_number" placeholder="invoice number" aria-describedby="button-addon2" />
                <input type="text" class="form-control" id="search_by_customer" placeholder="customer name" aria-describedby="button-addon2" />
                <span class="input-group-text" id="searchButton"><i data-feather="search"></i></span>
            </div>
        </div>
    </div>
</section>
<div class="content-body mb-2 mt-2">
    <div class="col-12">
        <div class="card">
            <div class="col-12">
                <div class="card">
                    <div class="table-responsive" style="max-height:300px">
                        <table class="table table-hover" id="invoice_table">
                            <thead>
                                <tr>
                                    <th>Invoice</th>
                                    <th>Customer Name</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($invoice as $inv)
                                    <tr>
                                        <td>{{$inv->invoice_number}}</td>
                                        <td>{{$inv->customer_name}}</td>
                                        <td>{{$inv->reg_date}}</td>
                                        <td>
                                            <button onclick="openModal('{{$inv->invoice_number}}')" class="btn btn-light">Set To Print</button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4">No invoice found  <a href="#"><b><span style="color:red;">Refresh</span></b></a></td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Structure -->
<div id="inputModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2>Enter Bank Details</h2>
        <form id="inputForm">
            <label for="bankName">Bank Name:</label>
            <input type="text" style="margin-bottom: 15px;" class="inputBill" id="bankName" name="bankName" required autofocus>
            <br><br>
            <label for="accountNumber">Account Number:</label>
            <input type="text" class="inputBill" id="accountNumber" name="accountNumber" required>
            <br>
            <button type="button" onclick="submitForm()" class="okbtn">OK</button>
        </form>
    </div>
</div>

<!-- Styles for the modal -->
<style>
    #inputForm{
        position: relative;
    }
    .inputBill{
        text-decoration: none;
        outline: none;
        position: absolute;
        right: 0;
        color: black;
        border: 1px solid black;
        margin-bottom: 5px;
    }
    .okbtn{
        background-color: blue;
        color: #fff;
        padding: 5px 10px 5px 10px;
        border-radius: 10px;
    }
    .okbtn:hover{
        background-color: green;
        color: #fff;
    }
.modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgb(0,0,0);
    background-color: rgba(0,0,0,0.4);
}

.modal-content {
    position: relative;
    background-color: #fefefe;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 30%;
}

.close {
    top:0;
    right:10px;
     position: absolute;
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: red;
    text-decoration: none;
    cursor: pointer;
}
</style>
@endsection
