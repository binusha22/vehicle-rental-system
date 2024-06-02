@extends('layouts.lay')
@section('title','POS customer-payment')
@section('script')
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function () {
        // Delegate the click event to the tbody element
        $(document).on("click", ".payment", function () {
            try {
                var inv = $(this).data('invoice');
                var vn = $(this).data('vehicle-number');
                var cn = $(this).data('customer-name');
                var cid = $(this).data('customer-id');
                var cp = $(this).data('passport');
                var s = $(this).data('start-date');
                var e = $(this).data('end-date');
                var fullAmount = $(this).data('full-amount');
                var agr = $(this).data('agreed-mileage');
                var trip = $(this).data('trip-mileage');
                var advance = $(this).data('advance-payment'); 
                var aditional = $(this).data('aditional');
                var rest = $(this).data('rest');
                var customerid=$(this).data('cusid');

                // Set input field values
                $("#invoice_number").val(inv);
                $("#vehicle_number").val(vn);
                $("#customer_name").val(cn);
                $("#id_number").val(cid);
                $("#passport_number").val(cp);
                $("#start_date").val(s);
                $("#end_date").val(e);
                $("#trip_amount").val(fullAmount);
                $("#advance").val(advance);
                $("#agreed").val(agr);
                $("#trip_milage").val(trip);
                $("#additional_milage").val(aditional);
                $("#to_pay").val(rest);
                $("#additional_cost_per_km").val('');
                $("#additional_milage_cost").val('');
                $("#final_amount").val('');
                $("#cusid").val(customerid);

                // Make AJAX request to fetch deposit data
                $.ajax({
                    url: "{{ route('fetchDeposit') }}",
                    type: "GET",
                    data: { invoice: customerid },
                    success: function(response) {
                        if (response.success) {
                        console.log("Deposit here:", response.deposit);
                        // Set the deposit value to the input field
                        $("#deposit").val(response.deposit);
                    } else {
                        console.error("Error:", response.message);
                    }

                    },
                    error: function(xhr, status, error) {
                        console.error("Error occurred while fetching deposit data:", error);
                    }
                });

            } catch (error) {
                console.error("Error occurred:", error);
            }
        });
    });
</script>
{{-- //get data in final payment table --}}

<script>
    $(document).ready(function () {
        $(document).on("click", ".pending_final", function () {
            try {
                var inv = $(this).data('invoice');
                var vn = $(this).data('vehicle-number');
                var cn = $(this).data('customer-name');
                var cid = $(this).data('customer-id');
                var cp = $(this).data('passport');
                var s = $(this).data('start-date');
                var e = $(this).data('end-date');
                var tripAmount = $(this).data('trip');
                var deposit = $(this).data('depo');

                // Set input field values
                $("#invoice_number2").val(inv);
                $("#vehicle_number2").val(vn);
                $("#customer_name2").val(cn);
                $("#id_number2").val(cid);
                $("#passport_number2").val(cp);
                $("#start_date2").val(s);
                $("#end_date2").val(e);
                $("#trip_amount2").val(tripAmount);

                $('#depositsec').val(deposit);
                //Make AJAX request to fetch deposit data
                $.ajax({
                    url: "{{ route('fetchMiledge') }}",
                    type: "GET",
                    data: { invoice: inv },
                    success: function(response) {
                        if (response.success) {
                        
                        $('#additional_milage2').val(response.data.additionalMile);
                        $('#additional_cost_per_km2').val(response.data.additional_cost_km);
                        $('#additional_milage_cost2').val(response.data.totalcost);
                        // Set the deposit value to the input field
                        //$("#deposit").val(response.deposit);
                    } else {
                        console.error("Error:", response.message);
                    }
                        
                    },
                    error: function(xhr, status, error) {
                        console.error("Error occurred while fetching deposit data:", error);
                    }
                });
                
            } catch (error) {
                console.error("Error occurred:", error);
            }
        });
    });
</script>

<script>
    $(document).ready(function () {
      
        $('#inv').change(fetchData);

        function fetchData() {
            var invoice_number = $('#inv').val();

            // Make AJAX request
            $.ajax({
                url: '{{ route('load-invoice-payment') }}',
                type: 'GET',
                data: {
                    inv: invoice_number,
                },
                success: function (response) {
                    // Handle the response and update the table
                    updateTable(response.data);
                },
                error: function (xhr, status, error) {
                    // Log the error to the console
                    console.log("Error:", error);

                    // Display the error message on the webpage
                    $('#error-message').text("An error occurred: " + error);
                }
            });
        }

        function updateTable(data) {
            // Update the table with the fetched data
            var tableBody = $('#book_table tbody');
            tableBody.empty(); // Clear existing rows

            if (data.length === 0) {
                // Display a message if no data is found
                tableBody.append('<tr><td colspan="4">No data found for the selected criteria.</td></tr>');
            } else {
                // Populate the table with the fetched data
                data.forEach(function (item) {
                    var row = '<tr class="payment" ' +
                        'data-invoice="' + item.invoice_number + '" ' +
                        'data-vehicle-number="' + item.vehicle_number + '" ' +
                        'data-customer-name="' + item.customer_name + '" ' +
                        'data-customer-id="' + item.cus_id + '" ' +
                        'data-passport="' + item.cus_passport + '" ' +
                        'data-start-date="' + item.reg_date + '" ' +
                        'data-end-date="' + item.end_date + '" ' +
                        'data-full-amount="' + item.amount + '" ' +
                        'data-agreed-mileage="' + item.agreedmile + '" ' +
                        'data-trip-mileage="' + item.trip_range + '" ' +
                        'data-advance-payment="' + item.advanced + '" ' +
                        'data-aditional="' + item.additinalMile + '" ' +
                        'data-rest="' + item.rest + '">' +
                        '<td>' + item.invoice_number + '</td>' +
                        '<td>' + item.vehicle_number + '</td>' +
                        '<td>' + item.customer_name + '</td>' +
                        '<td>' + item.cus_id + '</td>' +
                        '<td>' + item.cus_passport + '</td>' +
                        '<td>' + item.reg_date + '</td>' +
                        '<td>' + item.amount + '</td>' +
                        '<td>' + item.advanced + '</td>' +
                        '<td>' + item.rest + '</td>' +
                        '</tr>';
                    tableBody.append(row);
                });
            }
        }
    });
</script>
<script>
    $(document).ready(function () {
      
        $('#invsecond').change(fetchData);

        function fetchData() {
            var invoice_number = $('#invsecond').val();

            // Make AJAX request
            $.ajax({
                url: '{{ route('load-cus-payment') }}',
                type: 'GET',
                data: {
                    invsecond: invoice_number, // Change 'inv' to 'invsecond'
                },
                success: function (response) {
                    // Handle the response and update the table
                    updateTable(response.data);
                },
                error: function (xhr, status, error) {
                    // Log the error to the console
                    console.log("Error:", error);

                    // Display the error message on the webpage
                    $('#error-message').text("An error occurred: " + error);
                }
            });
        }

        function updateTable(data) {
            // Update the table with the fetched data
            var tableBody = $('#book_table_second tbody');
            tableBody.empty(); // Clear existing rows

            if (data.length === 0) {
                // Display a message if no data is found
                tableBody.append('<tr><td colspan="11">No data found for the selected criteria.</td></tr>');
            } else {
                // Populate the table with the fetched data
                data.forEach(function (item) {
                    var row = '<tr>' +
                        '<td>' + item.invoice_number + '</td>' +
                        '<td>' + item.vehicle_number + '</td>' +
                        '<td>' + item.customer_name + '</td>' +
                        '<td>' + item.start_date + '</td>' +
                        '<td>' + item.end_date + '</td>' +
                        '<td>' + item.trip_amount + '</td>' +
                        '<td>' + item.additional_milage + '</td>' +
                        '<td>' + item.additional_milage_cost + '</td>' +
                        '<td>' + item.damage_fee + '</td>' +
                        '<td>' + item.final_amount + '</td>' +
                        '<td>' + item.deposit + '</td>' +
                        '<td>' + item.rest_of_deposit + '</td>' +
                        '</tr>';
                    tableBody.append(row);
                });
            }
        }
    });
</script>




<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
{{-- <script>
$(document).ready(function () {
    // Attach event listener to the select element
    $('#inv').change(fetchData);

    function fetchData() {
        var invoice_number = $('#inv').val();

        // Make AJAX request
        $.ajax({
            url: '{{ route('load-invoice-payment') }}',
            type: 'GET',
            data: {
                inv: invoice_number,
            },
            success: function (response) {
                // Handle the response and update the table
                updateTable(response.data);
            },
            error: function (error) {
                console.log(error);
            }
        });
    }

    function updateTable(data) {
        // Update the table with the fetched data
        var tableBody = $('#book_table tbody');
        tableBody.empty(); // Clear existing rows

        if (data.length === 0) {
            // Display a message if no data is found
            tableBody.append('<tr><td colspan="4">No data found for the selected criteria.</td></tr>');
        } else {
            // Populate the table with the fetched data
            data.forEach(function (item) {
                var row = '<tr>' +
                    '<td>' + item.invoice_number + '</td>' +
                    '<td>' + item.vehicle_number + '</td>' +
                    '<td>' + item.customer_name + '</td>' +
                    '<td>' + item.cus_id + '</td>' 
                    '<td>' + item.cus_passport + '</td>' +
                    '<td>' + item.reg_date + '</td>' +
                    '<td>' + item.amount + '</td>' +
                    '<td>' + item.advanced + '</td>' +
                    '<td>' + item.rest + '</td>' +
                    '<td>' + item.agreedmile + '</td>' +
                    '<td>' + item.trip_range + '</td>' +
                    '<td>' + item.additinalMile + '</td>' +
                    '<td><span class="badge rounded-pill badge-light-danger me-1">' + item.status + '</span></td>' +
                    '</tr>';
                tableBody.append(row);
            });
        }
    }
});
</script> --}}
<script>
    $(document).ready(function() {
        // Function to calculate final amount
        function calculateFinalAmount() {
            // Get values from inputs
            var damageFee = parseFloat($('#damage_fee').val()) || 0;
            var additionalMilageCost = parseFloat($('#additional_milage_cost2').val()) || 0;
            var depo = parseFloat($('#depositsec').val()) || 0;

            // Calculate final amount
            var finalAmount = damageFee + additionalMilageCost;
            var restDepo = depo - finalAmount;

            // Update final amount input
            $('#final_amount').val(finalAmount.toFixed(2));
            $('#restDepo').val(restDepo.toFixed(2));
        }

        // Attach event listener to #damage_fee and #additional_milage_cost2 inputs
        $('#damage_fee, #additional_milage_cost2').on('input', calculateFinalAmount);

        // Attach event listener to clear values when backspace is pressed
        $('#damage_fee, #additional_milage_cost2').on('keydown', function(event) {
            // Check if the pressed key is backspace (key code 8)
            if (event.keyCode === 8) {
                $('#final_amount').val('');
                $('#restDepo').val('');
            }
        });
    });
</script>

<script>
    $(document).ready(function () {
        // Attach event listener to the document for right-click on any '.payment' row
        $(document).on('contextmenu', '.payment', function (event) {
            event.preventDefault();
            $('#addAmount').val(''); 
            $('#getEditedTopay').val('');
            // Retrieve data from the clicked row
            var invoiceNumber = $(this).data('invoice');
            // var vehicleNumber = $(this).data('vehicle-number');
            // var customerName = $(this).data('customer-name');
            // var customerId = $(this).data('customer-id');
            // var passport = $(this).data('passport');
            // var startDate = $(this).data('start-date');
            // var endDate = $(this).data('end-date');
            // var fullAmount = $(this).data('full-amount');
            // var agreedMileage = $(this).data('agreed-mileage');
            // var tripMileage = $(this).data('trip-mileage');
            var advancePayment = $(this).data('advance-payment');
            // var additional = $(this).data('aditional');
            var rest = $(this).data('rest');
            // var cusId = $(this).data('cusid');

            // Populate modal fields with data
            $('#getInvo').val(invoiceNumber);
            $('#getTopay').val(rest);
            
            // Show the modal
            $('#edit-2').modal('show');
        });

        $('#inv').change(fetchData);

        function fetchData() {
            var invoice_number = $('#inv').val();

            // Make AJAX request
            $.ajax({
                url: '{{ route('load-invoice-payment') }}',
                type: 'GET',
                data: {
                    inv: invoice_number,
                },
                success: function (response) {
                    // Handle the response and update the table
                    updateTable(response.data);
                },
                error: function (xhr, status, error) {
                    // Log the error to the console
                    console.log("Error:", error);

                    // Display the error message on the webpage
                    $('#error-message').text("An error occurred: " + error);
                }
            });
        }

        function updateTable(data) {
            // Update the table with the fetched data
            var tableBody = $('#book_table tbody');
            tableBody.empty(); // Clear existing rows

            if (data.length === 0) {
                // Display a message if no data is found
                tableBody.append('<tr><td colspan="4">No data found for the selected criteria.</td></tr>');
            } else {
                // Populate the table with the fetched data
                data.forEach(function (item) {
                    var row = '<tr class="payment" ' +
                        'data-invoice="' + item.invoice_number + '" ' +
                        'data-vehicle-number="' + item.vehicle_number + '" ' +
                        'data-customer-name="' + item.customer_name + '" ' +
                        'data-customer-id="' + item.cus_id + '" ' +
                        'data-passport="' + item.cus_passport + '" ' +
                        'data-start-date="' + item.reg_date + '" ' +
                        'data-end-date="' + item.end_date + '" ' +
                        'data-full-amount="' + item.amount + '" ' +
                        'data-agreed-mileage="' + item.agreedmile + '" ' +
                        'data-trip-mileage="' + item.trip_range + '" ' +
                        'data-advance-payment="' + item.advanced + '" ' +
                        'data-aditional="' + item.additinalMile + '" ' +
                        'data-rest="' + item.rest + '">' +
                        '<td>' + item.invoice_number + '</td>' +
                        '<td>' + item.vehicle_number + '</td>' +
                        '<td>' + item.customer_name + '</td>' +
                        '<td>' + item.cus_id + '</td>' +
                        '<td>' + item.cus_passport + '</td>' +
                        '<td>' + item.reg_date + '</td>' +
                        '<td>' + item.amount + '</td>' +
                        '<td>' + item.advanced + '</td>' +
                        '<td>' + item.rest + '</td>' +
                        '</tr>';
                    tableBody.append(row);
                });
            }
        }
    });
</script>

<script>
    $(document).ready(function () {
        // Add event listener to the "Add Amount" input field
        $('#addAmount').on('input', function () {
            // Retrieve values from the input fields
            var addAmountValue = parseFloat($(this).val()) || 0;
            var topayValue = parseFloat($('#getTopay').val()) || 0;

            // Calculate the new values
            var editedTopayValue = topayValue - addAmountValue;

            // Update the "Edited Topay" input field
            $('#getEditedTopay').val(editedTopayValue.toFixed(2));

            // Check if the "Add Amount" input field is empty
            if ($(this).val() === '') {
                // If empty, clear the "Edited Topay" input field
                $('#getEditedTopay').val('');
            }
        });
    });
</script>
@endsection
@section('content')
@if(Session::has('s'))
 <div class="toastqq" id="toastqq">{{session('s')}}</div>
@endif

@if(Session::has('f'))
<div class="toastHH" id="toastHH">{{session('f')}}</div>
                
@endif
@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<h3 class="titel">Customer Payment</h3>



<!-- Inputs Group with Buttons -->
<section id="input-group-buttons">
                 
          <div class="row">
            <div class="col-md-3 mb-1">
              <div class="input-group">
    
                  <select class="select2-size-lg form-select" id="inv">
    <option value="">Select Invoice Number</option>
    @foreach($invonumbers as $inv)
    <option value="{{ $inv }}">{{ $inv }}</option>
    @endforeach
</select>


              
                
              </div>
            </div>

            </div>
          </div>
 </section>

 <div class="content-body"> 
      <!-- Bootstrap Validation -->
      <div class="row mt-1 mb-0"  id="basic-table">
  <div class="col-12">
    <div class="card">   
    <div class="card-header">
          <h4 class="card-title">Customer Invoice First Payment</h4>
</div>
       <div class="table-responsive">
        <table class="table table-hover" id="book_table">
          <thead>


            <tr>
              <th>Invoice Number</th>
              <th>Number Plate</th>
              <th>Customer Name</th>
              <th>ID Number</th>
              <th>Passport Number</th>
              <th>Booking Date</th>
              <th>Trip Amount</th>
              <th>Advanced Amount</th>
              <th>To Pay</th>
              
              
              
            </tr>
            
          </thead>
          

          <tbody>
            @if ($bookData->isEmpty())
                 <tr>
                  <td>
                    no data
                  </td>
                   
                </tr>
            @else
            @foreach ($bookData as $bk)
            <tr class="payment" 
                  data-invoice="{{$bk->invoice_number}}" 
                  data-vehicle-number="{{$bk->vehicle_number}}" 
                  data-customer-name="{{$bk->customer_name}}" 
                  data-customer-id="{{$bk->cus_id}}" 
                  data-passport="{{$bk->cus_passport}}" 
                  data-start-date="{{$bk->start_date}}" 
                  data-end-date="{{$bk->end_date}}" 
                  data-full-amount="{{$bk->amount}}" 
                  data-agreed-mileage="{{$bk->agreedmile}}" 
                  data-trip-mileage="{{$bk->trip_range}}" 
                  data-advance-payment="{{$bk->advanced}}"
                  data-aditional="{{$bk->additinalMile}}"
                  data-rest="{{$bk->rest}}"
                  data-cusid="{{$bk->customer_id}}"
              >
              <td>{{$bk->invoice_number}}</td>
              <td>{{$bk->vehicle_number}}</td>
              <td>{{$bk->customer_name}}</td>
              <td>{{$bk->cus_id}}</td>
              <td>{{$bk->cus_passport}}</td>
              <td>{{$bk->reg_date}}</td>
              <td>{{$bk->amount}}</td>
              <td>{{$bk->advanced}}</td>
              <td>{{$bk->rest}}</td>
              
              
              @endforeach
          @endif
          </tbody>

        </table>
      </div>
    </div>
  </div>
</div>
</div>


<form action="{{route('insert-customer-payments')}}" method="post">
  @csrf
<section id="multiple-column-form">
  <div class="row">
    <div class="col-12">
      <div class="card">
       
        <div class="card-body">
          <form class="form">
            <div class="row">
              <div class="col-md-3 col-12">
                <div class="mb-1">
                  <label class="form-label" for="first-name-column">Invoice Number</label>
                  <input
                    type="text"
                    id="invoice_number"
                    class="form-control"
                    placeholder=""
                    name="invoice_number"
                  />
                </div>
              </div>

              <div class="col-md-3 col-12">
                <div class="mb-1">
                <label for="lname" class="form-label">customer id</label>
                    <input
                      type="text"
                      class="form-control"
                      id="cusid"
                      name="cusid"
                      value=""
                      placeholder=""
                      readonly
                     
                      />
                      <span class="text-danger"></span>
                </div>
              </div>

              <div class="col-md-3 col-12">
                <div class="mb-1">
                  <label class="form-label" for="last-name-column">Customer Name</label>
                  <input
                    type="text"
                    id="customer_name"
                    class="form-control"
                    placeholder=""
                    name="customer_name"
                  />
                </div>
              </div>
              <div class="col-md-3 col-12">
                <div class="mb-1">
                  <label class="form-label" for="city-column">Vehicle Number</label>
                  <input type="text" id="vehicle_number" class="form-control" placeholder="" name="vehicle_number" />
                </div>
              </div>
              <div class="col-md-3 col-12">
                <div class="mb-1">
                  <label class="form-label" for="country-floating">ID Number</label>
                  <input
                    type="text"
                    id="id_number"
                    class="form-control"
                    name="id_number"
                    placeholder=""
                  />
                </div>
              </div>
              <div class="col-md-3 col-12">
                <div class="mb-1">
                  <label class="form-label" for="country-floating">Passport Number</label>
                  <input
                    type="text"
                    id="passport_number"
                    class="form-control"
                    name="passport_number"
                    placeholder=""
                  />
                </div>
              </div>
              <div class="col-md-3 col-12">
                <div class="mb-1">
                  <label class="form-label" for="company-column">Start Date</label>
                  <input
                    type="text"
                    id="start_date"
                    class="form-control flatpickr-basic"
                    name="start_date"
                    placeholder=""
                  />
                </div>
              </div>
              <div class="col-md-3 col-12">
                <div class="mb-1">
                  <label class="form-label" for="email-id-column">End Date</label>
                  <input
                    type="text"
                    id="end_date"
                    class="form-control flatpickr-basic"
                    name="end_date"
                    placeholder=""
                  />
                </div>
              </div>
              
              <div class="col-md-3 col-12">
                <div class="mb-1">
                  <label class="form-label" for="email-id-column">Trip Amount(LKR)</label>
                  <input
                    type="text"
                    id="trip_amount"
                    class="form-control"
                    name="trip_amount"
                    placeholder=""
                  />
                </div>
              </div>
              <div class="col-md-3 col-12">
                <div class="mb-1">
                  <label class="form-label" for="email-id-column">Advanced Amount(LKR)</label>
                  <input
                    type="text"
                    id="advance"
                    class="form-control"
                    name="advance"
                    placeholder=""
                  />
                </div>
              </div>
              <div class="col-md-3 col-12">
                <div class="mb-1">
                  <label class="form-label" for="email-id-column">To Pay(LKR)</label>
                  <input
                    type="number"
                    id="to_pay"
                    class="form-control"
                    name="to_pay"
                    placeholder=""
                  />
                </div>
              </div>

              <div class="col-md-3 col-12">
                <div class="mb-1">
                  <label class="form-label" for="email-id-column">Deposit(LKR)</label>
                  <input
                    type="number"
                    id="deposit"
                    class="form-control"
                    name="deposit"
                    placeholder=""
                  />
                </div>
              </div>
              <div class="col-12 mt-2">
                <button type="submit" class="btn btn-primary me-1">Submit</button>
                
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
</form>

{{-- data-bs-target="#edit-2" data-bs-toggle="modal" --}}
<!-- aluthinma table ekak add kala  -->

 <div class="content-body"> 
      <!-- Bootstrap Validation -->
      <div class="row mt-3 mb-0"  id="basic-table">
  <div class="col-12">
    <div class="card">   
    <div class="card-header">
          <h4 class="card-title">Customer Final Payment</h4>
</div>
       <div class="table-responsive">
        <table class="table table-hover" id="pending_final">
          <thead>

            <tr>
              <th>Invoice Number</th>
              <th>Vehicle Number</th>
              <th>Customer Name</th>
              <th>Start Date</th>
              <th>End Date</th>
              
              <th>Trip Amount</th>
              <th>Deposit</th>
            </tr>
          </thead>
          

          <tbody>
            @foreach($pending_final_stage as $pf)
           <tr   class="pending_final" 
                data-invoice="{{$pf->invoice_number}}" 
                  data-vehicle-number="{{$pf->vehicle_number}}" 
                  data-customer-name="{{$pf->customer_name}}" 
                  data-customer-id="{{$pf->id_number}}" 
                  data-passport="{{$pf->passport_number}}" 
                  data-start-date="{{$pf->start_date}}" 
                  data-end-date="{{$pf->end_date}}" 
                  data-trip="{{$pf->trip_amount}}" 
                  data-depo="{{$pf->deposit}}"
                  
                  >
              <td>{{$pf->invoice_number}}</td>
              <td>{{$pf->vehicle_number}}</td>
              <td>{{$pf->customer_name}}</td>
              <td>{{$pf->start_date}}</td>
              <td>{{$pf->end_date}}</td>
              
              <td>{{$pf->trip_amount}}</td>
              <td>{{$pf->deposit}}</td>
             </tr> 
             @endforeach
          </tbody>

        </table>
      </div>
    </div>
  </div>
</div>
</div>



<section id="multiple-column-form">
  <div class="row">
    <div class="col-12">
      <div class="card">
       
        <div class="card-body">
          <form class="form" action="{{route('insertfinalpay')}}"method="post">
            @csrf
            <div class="row">
              <div class="col-md-3 col-12">
                <div class="mb-1">
                  <label class="form-label" for="first-name-column">Invoice Number</label>
                  <input
                    type="text"
                    id="invoice_number2"
                    class="form-control"
                    placeholder=""
                    name="invoice_number2"
                  />
                </div>
              </div>



              <div class="col-md-3 col-12">
                <div class="mb-1">
                  <label class="form-label" for="last-name-column">Customer Name</label>
                  <input
                    type="text"
                    id="customer_name2"
                    class="form-control"
                    placeholder=""
                    name="customer_name2"
                  />
                </div>
              </div>
              <div class="col-md-3 col-12">
                <div class="mb-1">
                  <label class="form-label" for="city-column">Vehicle Number</label>
                  <input type="text" id="vehicle_number2" class="form-control" placeholder="" name="vehicle_number2" />
                </div>
              </div>
              <div class="col-md-3 col-12">
                <div class="mb-1">
                  <label class="form-label" for="country-floating">ID Number</label>
                  <input
                    type="text"
                    id="id_number2"
                    class="form-control"
                    name="id_number2"
                    placeholder=""
                  />
                </div>
              </div>
              <div class="col-md-3 col-12">
                <div class="mb-1">
                  <label class="form-label" for="country-floating">Passport Number</label>
                  <input
                    type="text"
                    id="passport_number2"
                    class="form-control"
                    name="passport_number2"
                    placeholder=""
                  />
                </div>
              </div>
              <div class="col-md-3 col-12">
                <div class="mb-1">
                  <label class="form-label" for="company-column">Start Date</label>
                  <input
                    type="text"
                    id="start_date2"
                    class="form-control flatpickr-basic"
                    name="start_date2"
                    placeholder=""
                  />
                </div>
              </div>
              <div class="col-md-3 col-12">
                <div class="mb-1">
                  <label class="form-label" for="email-id-column">End Date</label>
                  <input
                    type="text"
                    id="end_date2"
                    class="form-control flatpickr-basic"
                    name="end_date2"
                    placeholder=""
                  />
                </div>
              </div>
              <div class="col-md-3 col-12">
                <div class="mb-1">
                  <label class="form-label" for="email-id-column">Trip Amount</label>
                  <input
                    type="text"
                    id="trip_amount2"
                    class="form-control"
                    name="trip_amount2"
                    placeholder=""
                  />
                </div>
              </div>
              
              <div class="col-md-3 col-12">
                <div class="mb-1">
                  <label class="form-label" for="email-id-column">Additonal Milage</label>
                  <input
                    type="number"
                    id="additional_milage2"
                    class="form-control"
                    name="additional_milage2"
                    placeholder=""
                  />
                </div>
              </div>
              <div class="col-md-3 col-12">
                <div class="mb-1">
                  <label class="form-label" for="email-id-column">Additional Cost per 1 KM</label>
                  <input
                    type="text"
                    id="additional_cost_per_km2"
                    class="form-control"
                    name="additional_cost_per_km2"
                    placeholder=""
                  />
                </div>
              </div>

              <div class="col-md-3 col-12">
                <div class="mb-1">
                  <label class="form-label" for="email-id-column">Additional Milage Cost</label>
                  <input
                    type="number"
                    id="additional_milage_cost2"
                    class="form-control"
                    name="additional_milage_cost2"
                    placeholder=""
                  />
                </div>
              </div>
              <div class="col-md-3 col-12">
                <div class="mb-1">
                  <label class="form-label" for="email-id-column">Damage Fee</label>
                  <input
                    type="text"
                    id="damage_fee"
                    class="form-control"
                    name="damage_fee"
                    placeholder=""
                  />
                </div>
              </div>
              <div class="col-md-3 col-12">
                <div class="mb-1">
                  <label class="form-label" for="email-id-column">Final Amount</label>
                  <input
                    type="text"
                    id="final_amount"
                    class="form-control"
                    name="final_amount"
                    placeholder=""
                  />
                </div>
              </div>
              <div class="col-md-3 col-12">
                <div class="mb-1">
                  <label class="form-label" for="email-id-column">Deposit</label>
                  <input
                    type="number"
                    id="depositsec"
                    class="form-control"
                    name="depositsec"
                    placeholder=""
                  />
                </div>
              </div>

              <div class="col-md-3 col-12">
                <div class="mb-1">
                  <label class="form-label" for="email-id-column">Rest of Deposit</label>
                  <input
                    type="number"
                    id="restDepo"
                    class="form-control"
                    name="restDepo"
                    placeholder=""
                  />
                </div>
              </div>
                <div class="col-md-3 col-12">
                    <div class="mb-1 form-check">
                        <input type="checkbox" class="form-check-input" id="useRestDepo" name="useRestDepo">
                        <label class="form-check-label" for="useRestDepo">Return the deposit to customer</label>
                    </div>
                </div>

              <div class="col-12 mt-2">
                <button type="submit" class="btn btn-primary me-1">Submit</button>
                
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>



<section id="input-group-buttons">
                 
          <div class="row">
            <div class="col-md-3 mb-0 mt-2 ">
              <div class="input-group">
                <select class="select2-size-lg form-select" id="invsecond">
                    <option value="">Select Invoice Number</option>
                    @foreach($invonumbersSecond as $inv)
                    <option value="{{ $inv }}">{{ $inv }}</option>
                    @endforeach
                </select>
              </div>
            </div>
             </div>
 </section>


 <div class="content-body"> 
      <!-- Bootstrap Validation -->
      <div class="row mt-1 mb-0"  id="basic-table">
  <div class="col-12">
    <div class="card">   
    <div class="card-header">
          <h4 class="card-title">Customer Payment Summary Details</h4>
</div>
      <div class="table-responsive">
        <table class="table table-hover" id="book_table_second">
          <thead>
            <tr>
              <th>Invoice Number</th>
              <th>Vehicle Number</th>
              <th>Customer Name</th>
              <th>Start Date</th>
              <th>End Date</th>
              <th>Trip Amount</th>
              <th>Additional Milage</th>
              <th>Additional Cost per 1KM</th>
             
              <th>Damage Fee</th>
              <th>Final Amount</th>
              <th>Deposit</th>
              <th>Rest of Deposit</th>
              <!-- methana machan waguwe godak wenas una t head tika -->
            </tr>
          </thead>
          <tbody>
            @if ($completeBook->isEmpty())
                 <tr>
                  <td>
                    no data
                  </td>
                   
                </tr>
            @else
            @foreach ($completeBook as $bk)
            <tr>
              <td>{{$bk->invoice_number}}</td>
              <td>{{$bk->vehicle_number}}</td>
              <td>{{$bk->customer_name}}</td>
              <td>{{$bk->start_date}}</td>
              <td>{{$bk->end_date}}</td>
              <td>{{$bk->trip_amount}}</td>
              <td>{{$bk->additional_milage}}</td>
              <td>{{$bk->additional_milage_cost}}</td>
              <td>{{$bk->damage_fee}}</td>
              <td>{{$bk->final_amount}}</td>
              <td>{{$bk->deposit}}</td>
              <td>{{$bk->rest_of_deposit}}</td>
          </tr>
          @endforeach
          @endif
          </tbody>



        </table>
      </div>
    </div>
  </div>
</div>
</div>




      
<!-- POPUP -->
<div class="modal fade" id="edit-2" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
      <div class="modal-content">
        <div class="modal-header bg-transparent">
          <button type="button"  class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body pb-5 px-sm-5 pt-50 ">
          <h2 class="mb-4" style="border-bottom: 1px solid #ccc; padding-bottom: 10px;">Edit Details</h2>
                  
          <form action="{{route('edit_topay')}}" method="post">
          @csrf 
          
          <div class="row">
            <div class="col-md-6 mb-1  ">
            <label class="form-label" for="large-select">Invoice</label>
              <input
                type="text"
                class="form-control"
                id="getInvo"
                name="getInvo"
                placeholder="01234340"
                readonly
              />
            </div>
            <div class="col-md-6 mb-1">
    <label class="form-label" for="large-select">Add Amount</label>
    <input
        type="text"
        class="form-control"
        id="addAmount"
        name="addAmount"
        placeholder="0000.00"
    />
</div>

<div class="col-md-6 mb-1">
    <label class="form-label" for="large-select">Topay</label>
    <input
        type="text"
        class="form-control"
        id="getTopay"
        name="getTopay"
        placeholder="0000.00"
        readonly
    />
</div>

<div class="col-md-6 mb-1">
    <label class="form-label" for="large-select">Edited Topay</label>
    <input
        type="text"
        class="form-control"
        id="getEditedTopay"
        name="getEditedTopay"
        placeholder="0000.00"
        readonly
    />
</div>



            
              <div class="mt-2 mb-3">
              <button type="submit" class="btn btn-primary">Update</button>
              </div>

           </div>
         </form>
        </div>
      </div>
    </div>
  </div>
<!-- POP END  -->
@endsection