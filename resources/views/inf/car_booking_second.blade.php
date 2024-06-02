@extends('layouts.lay')
@section('title','Vehicle Booking')
@section('style')
<style>
 .titel{Margin-bottom:50px}
</style>
@endsection
@section('script')
 <script src="{{asset('app-assets/js/scripts/pages/modal-edit-user.min.js')}}"></script>
 <script>
   document.addEventListener("DOMContentLoaded", function() {
    // Your JavaScript code here
    const advanced = document.getElementById('advanced');
    var amount = document.getElementById('amount');
    var rest = document.getElementById('topay');

    advanced.addEventListener('input', updateMilageCost);

    function updateMilageCost() {
      
      
      const amountnew = parseFloat(amount.value);
      const adva = parseFloat(advanced.value);

      const topay = amountnew - adva;

      rest.value = isNaN(topay) ? '' : topay.toFixed(2);
    }
});
  </script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const brandSelect = document.getElementById('brand');
        const modelSelect = document.getElementById('model');

        brandSelect.addEventListener('change', function () {
            const selectedBrandId = this.value;
       if (selectedBrandId) {
                // Enable the model dropdown
                modelSelect.disabled = false;
            // Clear existing options in the model dropdown
            modelSelect.innerHTML = "";

            // Make an AJAX request to fetch models based on the selected brand
            fetch(`/get_models_booking/${selectedBrandId}`)
                .then(response => response.json())
                .then(models => {
                    // Populate the model dropdown with fetched data
                    models.forEach(model => {
                        const option = document.createElement('option');
                        option.value = model.model;
                        option.text = model.model;
                        modelSelect.add(option);
                    });
                })
                .catch(error => console.error('Error fetching models:', error));
              } else {
                // If no brand is selected, disable the model dropdown
                modelSelect.disabled = true;
            }
        });
    });
</script>
<!-- Your existing HTML code -->

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function () {
        // Attach event listeners to dropdowns and date pickers
        $('#brand, #model, #start_date, #end_date').change(fetchData);

        function fetchData() {
            var brand = $('#brand').val();
            var model = $('#model').val();
            var startDate = $('#start_date').val();
            var endDate = $('#end_date').val();

            // Make AJAX request without pagination parameters
            $.ajax({
                url: '{{ route('fetchData') }}',
                type: 'GET',
                data: {
                    brand: brand,
                    model: model,
                    start_date: startDate,
                    end_date: endDate
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
            var tableBody = $('#vehicle_table tbody');
            tableBody.empty(); // Clear existing rows

            if (data.length === 0) {
                // Display a message if no data is found
                tableBody.append('<tr><td colspan="4">No vehicles found for the selected criteria.</td></tr>');
            } else {
                // Populate the table with the fetched data
                data.forEach(function (item) {
                    var row = '<tr class="vehicle-row" data-name="' + item.vehicle_name + '" data-number="' + item.vehicle_number + '">' +
                        '<td>' + item.vehicle_name + '</td>' +
                        '<td>' + item.vehicle_number + '</td>' +
                        '<td>' + item.vehicle_status + '</td>' +
                        '<td>' + item.reason + '</td>' +
                        '<td>' + item.booking_status + '</td>' +
                        '<td>' + item.release_date + '</td>' +
                        '</tr>';
                    tableBody.append(row);
                });
            }
        }
    });
</script>



<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function () {
        $(document).on("click", ".vehicle-row", function () {
            var name = $(this).data('name');
            var number = $(this).data('number');

            $("#vehicle_name").val(name);
            $("#vehicle_number").val(number);
        });
    });
</script>


<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function() {
        $(document).on("click", ".customer_row", function (){
            var name = $(this).data('name');
            var id = $(this).data('id');
            var pss = $(this).data('pss');
            var mobile = $(this).data('number');

            $("#customer_name").val(name);
            $("#id_card").val(id);
            $("#passport").val(pss);
            $("#mobile").val(mobile);
        });
    });
</script>



<script>
    $(document).ready(function () {
        // Attach event listener to the search button
        $('#searchButton').click(fetchFilteredData);

        // Attach event listener to input fields for Enter key press
        $('#search_cus, #search_cus_id, #search_cus_number').on('keypress', function (event) {
            if (event.which === 13) {
                fetchFilteredData();
            }
        });

        function fetchFilteredData() {
            var search_cus = $('#search_cus').val();
            var search_cus_id = $('#search_cus_id').val();
            var search_cus_number = $('#search_cus_number').val();

            // Make AJAX request
            $.ajax({
                url: '{{ route('fetchFilteredData') }}', // Replace with your actual route
                type: 'GET',
                data: {
                    search_cus: search_cus,
                    search_cus_id: search_cus_id,
                    search_cus_number: search_cus_number,
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
            var tableBody = $('#customer_table tbody');
            tableBody.empty(); // Clear existing rows

            if (data.length === 0) {
                // Display a message if no data is found
                tableBody.append('<tr><td colspan="5">No customers found for the selected criteria.</td></tr>');
            } else {
                // Populate the table with the fetched data
                $.each(data, function (index, item) {
                    tableBody.append('<tr class="customer_row" data-name="' + item.fname + ' ' + item.lname + '" data-id="' + item.id + '" data-pss="' + item.passportnumber + '" data-number="' + item.phonenumber + '">' +
                        '<td>' + item.fname + ' ' + item.lname + '</td>' +
                        '<td>' + item.idnumber + '</td>' +
                        '<td>' + item.passportnumber + '</td>' +
                        '<td>' + item.phonenumber + '</td>' +
                        '<td>' + item.regDate + '</td>' +
                        '</tr>');
                });
            }
        }
    });
</script>




<!-- Your existing HTML code -->
<script>
    $(document).ready(function () {
        // Attach event listener to the search button
        $('#searchall').click(filterBooking);

        // Attach event listener to input fields for Enter key press
        $('#search_all').on('keypress', function (event) {
            if (event.which === 13) {
                filterBooking();
            }
        });

        function filterBooking() {
            var search_all = $('#search_all').val();

            // Make AJAX request
            $.ajax({
                url: '{{ route('filter_booking') }}',
                type: 'GET',
                data: {
                    search_all: search_all
                },
                dataType: 'json',
                success: function (response) {
                    if (response.data.length > 0) {
                        updateTable(response.data);

                        // Re-attach event listener to dynamically created elements
                        $('.book_row').off('click').on('click', function() {
                            var inv = $(this).data('invbk');
                            $("#invq").val(inv);
                        });
                    } else {
                        displayNoResultsMessage();
                    }
                },
                error: function (error) {
                    console.log(error);
                    displayErrorMessage();
                }
            });
        }

        function updateTable(data) {
            var tableBody = $('#empbook_table tbody');
            tableBody.empty(); // Clear existing rows

            $.each(data, function (index, item) {
                tableBody.append('<tr class="book_row" data-invbk="' + item.invoice_number + '">' +
                    '<td>' + item.invoice_number + '</td>' +
                    '<td>' + item.customer_name + '</td>' +
                    '</tr>');
            });
        }

        function displayNoResultsMessage() {
            var tableBody = $('#empbook_table tbody');
            tableBody.empty();
            tableBody.append('<tr><td colspan="2">No bookings found for the selected criteria.</td></tr>');
        }

        function displayErrorMessage() {
            var tableBody = $('#empbook_table tbody');
            tableBody.empty();
            tableBody.append('<tr><td colspan="2">An error occurred while fetching bookings.</td></tr>');
        }
    });
</script>



{{-- get invoice number to text input --}}
<script>
    $(document).ready(function() {
        // Attach event listener to dynamically created elements
        $(document).on("click", ".book_row", function() {
            var inv = $(this).data('invbk');
            $("#invq").val(inv);
        });
    });
</script>
{{-- get invoice number to text input in assign --}}

<script>
   $(document).ready(function () {
    console.log("Document ready function executed."); // Add this line
    // Rest of your code...
});
</script> 


{{-- fetch employee names --}}
<script>
    $(document).ready(function () {
        // Event listener for fetching employee names
        $('#fetchEmployees').click(function () {
            $('#invq').val('');
            // Make AJAX request
            $.ajax({
                url: '/getEmployeeNames', // Adjust the URL based on your route
                type: 'GET',
                success: function (response) {
                    // Update the dropdown options with employee names
                    updateDropdown(response.data);

                },
                error: function (error) {
                    console.log(error);
                }
            });
        });

        // Function to update the dropdown with employee names
        function updateDropdown(employees) {
            var dropdown = $('#empdropdown');
            dropdown.empty(); // Clear existing options
dropdown.append('<option value="">Select Name</option>');
            // Populate the dropdown with fetched employee names
            $.each(employees, function (index, employee) {
                dropdown.append('<option value="' + employee.user_id + '">' + employee.name + '</option>');
            });
        }
    });
</script>
<script>
   
    $(document).ready(function () {
        // Event listener for clicking the "Assign Employee" link
        $(document).on('click', '#fetchEmp', function () {
            var invoiceNumber = $(this).data('invbk'); // Get the invoice number from data-invbk attribute
            var vn=$(this).data('vn');
            // Make AJAX request to fetch employee names
            $.ajax({
                url: '/getEmployeeNames', // Adjust the URL based on your route
                type: 'GET',
                success: function (response) {
                    // Update the dropdown options with employee names
                    updateDropdown(response.data);

                    // Set the invoice number in the input field
                    $('#invqw').val(invoiceNumber);
                    $('#vn').val(vn);
                },
                error: function (error) {
                    console.log(error);
                }
            });
        });

        // Function to update the dropdown with employee names
        function updateDropdown(employees) {
            var dropdown = $('#empdrop');
            dropdown.empty(); // Clear existing options
dropdown.append('<option value="">Select Name</option>');
            // Populate the dropdown with fetched employee names
            $.each(employees, function (index, employee) {
                dropdown.append('<option value="' + employee.user_id + '">' + employee.name + '</option>');
            });
        }
    });
</script>


{{-- fetch bookings --}}
<script>
    $(document).ready(function () {
        // Attach event listener to the search button
        $('#search_book').click(filterBooking);

        // Attach event listener to input fields for Enter key press
        $('#search_book_input').on('keypress', function (event) {
            if (event.which === 13) {
                filterBooking();
            }
        });

        function filterBooking(event) {
            // Prevent default form submission behavior
            if (event) {
                event.preventDefault();
            }

            var search_all = $('#search_book_input').val();

            // Make AJAX request
            $.ajax({
                url: '{{ route('filter_booking') }}',
                type: 'GET',
                data: {
                    search_all: search_all
                },
                dataType: 'json',
                success: function (response) {
                    if (response.data.length > 0) {
                        updateTable(response.data);
                    } else {
                        displayNoResultsMessage();
                    }
                },
                error: function (error) {
                    console.log(error);
                    displayErrorMessage();
                }
            });
        }

        function updateTable(data) {
            var tableBody = $('#booking_table tbody');
            tableBody.empty(); // Clear existing rows

            $.each(data, function (index, item) {
                tableBody.append('<tr class="booking_row" data-invbk="' + item.invoice_number + '">' +
                    '<td>' + item.invoice_number + '</td>' +
                    '<td>' + item.customer_name + '</td>' +
                    '<td>' + item.cus_id + '</td>' +
                    '<td>' + item.cus_passport + '</td>' +
                    '<td>' + item.vehicle_name + '</td>' +
                    '<td>' + item.vehicle_number + '</td>' +
                    '<td>' + item.reg_date + '</td>' +
                    '<td>' + item.advanced + '</td>' +
                    '<td>' + item.amount + '</td>' +
                    '<td>' + item.rest + '</td>' +
                    '<td>' + item.select_employee + '</td>' +
                    '<td>' + item.vehicle_pickup_location + '</td>' +
                    '</tr>');
            });
        }

        function displayNoResultsMessage() {
            var tableBody = $('#booking_table tbody');
            tableBody.empty();
            tableBody.append('<tr><td colspan="2">No bookings found for the selected criteria.</td></tr>');
        }

        function displayErrorMessage() {
            var tableBody = $('#booking_table tbody');
            tableBody.empty();
            tableBody.append('<tr><td colspan="2">An error occurred while fetching bookings.</td></tr>');
        }
    });
</script>

<script>
   $(document).ready(function () {
    // Attach event listener to the search button
    $('#sb').click(filterBooking);

    // Attach event listener to input fields for Enter key press
    $('#sbinput').on('keypress', function (event) {
        if (event.which === 13) {
            filterBooking();
        }
    });

    function filterBooking() {
        var search_all = $('#sbinput').val();

        // Make AJAX request
        $.ajax({
            url: '{{ route('filter_booking') }}',
            type: 'GET',
            data: {
                sbinput: search_all // Use sbinput as the parameter name
            },
            dataType: 'json',
            success: function (response) {
                if (response.data.length > 0) {
                    updateTable(response.data);
                } else {
                    displayNoResultsMessage();
                }
            },
            error: function (error) {
                console.log('Error:', error);
                displayErrorMessage();
            }
        });
    }

    function updateTable(data) {
    var tableBody = $('#assign_book_table tbody');
    tableBody.empty(); // Clear existing rows

    $.each(data, function (index, item) {
        var rowHtml = '<tr class="assign_book" data-invbk="' + item.invoice_number + '">' +
            '<td>' + item.invoice_number + '</td>' +
            '<td>' + item.customer_name + '</td>' +
            '<td>' + item.cus_id + '</td>' +
            '<td>' + item.cus_passport + '</td>' +
            '<td>' + item.vehicle_name + '</td>' +
            '<td>' + item.vehicle_number + '</td>' +
            '<td>' + item.reg_date + '</td>' +
            '<td>' + item.advanced + '</td>' +
            '<td>' + item.amount + '</td>' +
            '<td>' + item.rest + '</td>' +
            '<td>' + item.select_employee + '</td>' +
            '<td>' + item.vehicle_pickup_location + '</td>' +
            '<td>' +
                '<div class="dropdown">' +
                    '<button type="button" class="btn btn-sm dropdown-toggle hide-arrow py-0" data-bs-toggle="dropdown" >' +
                        'click' +
                    '</button>' +
                    '<div class="dropdown-menu dropdown-menu-end">' +
                        '<a class="dropdown-item" href="/test">' +
                            '<i data-feather="edit-2" class="me-50"></i>' +
                            '<span>Assign Employee</span>' +
                        '</a>' +
                    '</div>' +
                '</div>' +
            '</td>' +
        '</tr>';
        tableBody.append(rowHtml);
    });
}


    function displayNoResultsMessage() {
        var tableBody = $('#assign_book_table tbody');
        tableBody.empty();
        tableBody.append('<tr><td colspan="2">No bookings found for the selected criteria.</td></tr>');
        console.log

    }

    function displayErrorMessage() {
        var tableBody = $('#assign_book_table tbody');
        tableBody.empty();
        tableBody.append('<tr><td colspan="2">An error occurred while fetching bookings.</td></tr>');
    }
});

</script>

{{-- automatic booking load  --}}
{{-- <script>
    var eventSource = new EventSource("{{ route('sse') }}");

eventSource.onmessage = function(event) {
    console.log("Received SSE message:", event.data); // Log the raw SSE data

    var bookings = JSON.parse(event.data);
    console.log("Parsed bookings data:", bookings); // Log the parsed JSON data

    var bookingList = document.getElementById('bookingList');
    bookingList.innerHTML = ''; // Clear existing list
    bookings.forEach(function(booking) {
        var tr = document.createElement('tr');
        tr.innerHTML = 
            '<td>' + booking.invoice_number + '</td>' +
            '<td>' + booking.customer_name + '</td>' +
            '<td>' + booking.cus_id + '</td>' +
            '<td>' + booking.cus_passport + '</td>' +
            '<td>' + booking.vehicle_name + '</td>' +
            '<td>' + booking.vehicle_number + '</td>' +
            '<td>' + booking.reg_date + '</td>' +
            '<td>' + booking.advanced + '</td>' +
            '<td>' + booking.amount + '</td>' +
            '<td>' + booking.rest + '</td>' +
            '<td>' + booking.select_employee + '</td>' +
            '<td>' + booking.vehicle_pickup_location + '</td>';
        bookingList.appendChild(tr);
    });
};

</script> --}}


@endsection
@section('content')

@if(Session::has('s'))
 <div class="toastqq" id="toastqq">{{session('s')}}</div>
@endif

@if(Session::has('f'))
<div class="toastHH" id="toastHH">{{session('f')}}</div>
                
@endif



<!-- Inputs Group with Buttons -->
<section id="input-group-buttons">
<h3 class="titel">Vehicle Booking</h3>

@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="" method="get">
          <div class="row">
            <div class="col-md-3 mb-1  ">
            <label class="form-label" for="large-select">Vehicle Brand</label>
              <div class="input-group">
                    <select class="select2-size-lg form-select" id="brand" name="brand">
                    <option value="">Select</option>
                    @foreach($branddata as $br)
                    <option value="{{$br->brand}}">{{$br->brand}}</option>
                    @endforeach
                  </select>
              </div>
            </div>

            <div class="col-md-3 mb-1 ">
            <label class="form-label" for="large-select">Vehicle Model</label>
              <div class="input-group">
                    <select class="select2-size-lg form-select"  id="model" name="model" disabled>
                    <option value="">Select</option>
                    
                  </select>
              </div>
            </div>

            <div class="col-md-3 mb-1 ">
            <label class="form-label" for="large-select">Start Date</label>
              <div class="input-group">
                <input
                    type="text"
                    id="start_date"
                    name="start_date"
                    class="form-control flatpickr-basic"
                    placeholder="Search Date"
                    
                  />
                </div>
              </div>

              <div class="col-md-3 mb-1 ">
              <label class="form-label" for="large-select">End Date</label>
              <div class="input-group">
                <input
                    type="text"
                    id="end_date"
                    name="end_date"
                    
                    class="form-control flatpickr-basic"
                    placeholder="Search Date"
                  />
                </div>
              </div>
            </div>
          </div>
          </form>
 </section>


 <div class="row mt-1 "  id="basic-table">
  <div class="content-body mb-2 ">
  <div class="row mt-1 " id="dark-table">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h5>Vehicle Available & Pending Details</h5>
      </div>
      
<div class="col-12 ">
    <div class="card">   
      <div class="table-responsive" style="max-height:300px">
        <table class="table table-hover" id="vehicle_table">
          <thead>
            <tr>
              <th>Vehicle Name</th>
              <th>Number Plate</th>
              <th>Status</th>
              <th>Reason</th>
              <th>Booking Status</th>
              <th>Release Date</th>
            </tr>
          </thead>
          <tbody>
            @forelse($data as $da)
            <tr class="vehicle-row"    data-name="{{ $da->vehicle_name }}" data-number="{{ $da->vehicle_number }}">
              <td>{{$da->vehicle_name}}</td>
              <td>{{$da->vehicle_number}}</td>
              <td>{{$da->vehicle_status}}</td>
              <td>{{$da->reason}}</td>
              <td>{{$da->booking_status}}</td>
              <td>{{$da->release_date}}</td>
              
              </tr>
              @empty
                            <tr>
                                <td colspan="3">No vehicles found  <a href="#" > <b><span style="color:red;">Refresh</span></b></a></td>
                            </tr>
               @endforelse 
                            </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
</div>





<section id="input-group-buttons mb-5">
    <div class="row">
        <div class="col-md-6 mb-0 mt-2">
            <div class="input-group">
                <input
                    type="text"
                    class="form-control"
                    id="search_cus"
                    placeholder="Customer Name"
                    aria-describedby="button-addon2"
                />

                <input
                    type="text"
                    class="form-control"
                    id="search_cus_id"
                    placeholder="Id/Passport Number"
                    aria-describedby="button-addon2"
                />

                <input
                    type="text"
                    class="form-control"
                    id="search_cus_number"
                    placeholder="Phone Number"
                    aria-describedby="button-addon2"
                />
                
                <span class="input-group-text" id="searchButton"><i data-feather="search"></i></span>
            </div>
        </div>
    </div>
</section>



  <div class="content-body mb-2 mt-2">
  <div class="col-12">
    <div class="card">
      
<div class="col-12 ">
    <div class="card">   
      <div class="table-responsive" style="max-height:300px">
         <table class="table table-hover" id="customer_table">
          <thead>
            <tr>
              <th>Customer Name</th>
              <th>Id Number</th>
              <th>Passport Number</th>
              <th>Phone Number</th>
              <th>Date</th>
              
            </tr>
          </thead>
          <tbody>
          @forelse($cus as $cs)
            <tr class="customer_row"    
            data-name="{{$cs->fname}} {{$cs->lname}}" 
            data-id="{{$cs->idnumber}}"
            data-pss="{{$cs->passportnumber}}"
            data-number="{{$cs->phonenumber}}">
              <td>{{$cs->fname}} {{$cs->lname}}</td>
              <td>{{$cs->idnumber}}</td>
              <td>{{$cs->passportnumber}}</td>
              <td>{{$cs->phonenumber}}</td>
              <td>{{$cs->regDate}}</td>
              
              </tr>
              @empty
                            <tr>
                                <td colspan="3">No customer found  <a href="#" > <b><span style="color:red;">Refresh</span></b></a></td>
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





<section id="multiple-column-form">
  <div class="row mt-1 ">
    <div class="col-12">
      <div class="card">
         <div class="card-body">
          <form class="form" action="{{route('insert_booking_data')}}" method="post">
                

             @csrf
             <div class="col-md-3 col-12">
                <div class="mb-1" >
                <label for="lname" class="form-label">Invoice Number </label>
                    <input
                      type="text"
                      class="form-control"
                      id="invoice"
                      name="invoice"
                      value="{{old('invoice')}}"
                      placeholder="     "
                      style="border: 0.5px solid red;"
                      
                      />
                      <span class="text-danger">@error('invoice'){{$message}}@enderror</span>
                </div>
              </div>
            <div class="row">
              <div class="col-md-4 col-12">
                <div class="mb-1">
                <label for="fname" class="form-label">Vehicle Name</label>
                  <input
                    type="text"
                    class="form-control"
                    id="vehicle_name"
                    name="vehicle_name"
                    value="{{old('vehicle_name')}}"
                    placeholder="john"
                    
                    
                  />
                    <span class="text-danger">@error('vehicle_name'){{$message}}@enderror</span>
                </div>
              </div>

              
              <div class="col-md-4 col-12">
                <div class="mb-1">
                <label for="email" class="form-label">Vehicle Number</label>
            <input
              type="text"
              class="form-control"
              id="vehicle_number"
              name="vehicle_number"
              value="{{old('vehicle_number')}}"
              placeholder="ABC-0987"
              aria-describedby="login-email"
              
            />
            <span class="text-danger">@error('vehicle_number'){{$message}}@enderror</span>
                </div>
              </div>


              <div class="col-md-4 col-12">
                <div class="mb-3">
                <label for="username" class="form-label">Customer Name</label>
            <input
              type="text"
              class="form-control"
              id="customer_name"
              name="customer_name"
              value="{{old('customer_name')}}"
              placeholder="waruna"
              value=""
             
            />
            <span class="text-danger">@error('customer_name'){{$message}}@enderror</span>
                </div>
              </div>


              <div class="col-md-4 col-12">
                <div class="mb-3">
                <label for="lname" class="form-label">Id Number</label>
                    <input
                      type="text"
                      class="form-control"
                      id="id_card"
                      value="{{old('id_card')}}"
                      name="id_card"
                      value=""
                      placeholder=""
                      
                     
                      />
                      <span class="text-danger">@error('id_card'){{$message}}@enderror</span>
                </div>
              </div>
              <div class="col-md-4 col-12">
                <div class="mb-3">
                <label for="lname" class="form-label">Passport </label>
                    <input
                      type="text"
                      class="form-control"
                      id="passport"
                      name="passport"
                      value="{{old('passport')}}"
                      value=""
                      placeholder=""
                      
                     
                      />
                      <span class="text-danger">@error('passport'){{$message}}@enderror</span>
                </div>
              </div>

              <div class="col-md-4 col-12">
                <div class="mb-3">
                <label for="lname" class="form-label">Phone Number </label>
                    <input
                      type="text"
                      class="form-control"
                      id="mobile"
                      name="mobile"
                      value="{{old('passport')}}"
                      placeholder=""
                      
                      
                      />
                      <span class="text-danger">@error('mobile'){{$message}}@enderror</span>
                </div>
              </div>

                <div class="col-md-4 col-12">
                <div class="mb-3">
                <label class="form-label" for="fp-range">Start date</label>
                  <input
                    type="text"
                    id="s_date"
                    name="s_date"
                    value="{{old('s_date')}}"
                    class="form-control flatpickr-basic"
                    placeholder="YYYY-MM-DD"
                  />
                      <span class="text-danger">@error('s_date'){{$message}}@enderror</span>
                </div>
              </div>
                <div class="col-md-4 col-12">
                <div class="mb-3">
                <label class="form-label" for="fp-range">End date</label>
                  <input
                    type="text"
                    id="e_date"
                    name="e_date"
                    value="{{old('e_date')}}"
                    class="form-control flatpickr-basic"
                    placeholder="YYYY-MM-DD"
                  />
                      <span class="text-danger">@error('e_date'){{$message}}@enderror</span>
                </div>
              </div>

            <div class="col-md-4 col-12">
                <div class="mb-3">
                <label for="lname" class="form-label">Destination </label>
                    <input
                      type="text"
                      class="form-control"
                      id="destination"
                      value="{{old('destination')}}"
                      name="destination"
                      
                      />
                      <span class="text-danger">@error('destination'){{$message}}@enderror</span>
                </div>
              </div>

                <div class="col-md-4 col-12">
                <div class="mb-3">
                <label for="lname" class="form-label">Flight Number</label>
                    <input
                      type="text"
                      class="form-control"
                      id="flight_number"
                      name="flight_number"
                      value="{{old('flightnumber')}}"
                      placeholder=""
                      
                      
                      />
                      <span class="text-danger">@error('flight_number'){{$message}}@enderror</span>
                </div>
              </div>

              <div class="col-md-4 col-12">
                <div class="mb-3">
                <label for="lname" class="form-label">Date of Arrival</label>
                <input
                    type="text"
                    id="e_date"
                    name="date_of_arrival"
                    value="{{old('date_of_arrival')}}"
                    class="form-control flatpickr-basic"
                    placeholder="YYYY-MM-DD"
                  />
                      <span class="text-danger">@error('date_of_arrival'){{$message}}@enderror</span>
                </div>
              </div>

              <div class="col-md-4 col-12">
                <div class="mb-3">
                <label for="lname" class="form-label">Time of Landing </label>
                    <input
                      type="text"
                      class="form-control"
                      id="time_of_landing"
                      name="time_of_landing"
                      value="{{old('time_of_landing')}}"
                      placeholder=""
                      
                      
                      />
                      <span class="text-danger">@error('time_of_landing'){{$message}}@enderror</span>
                </div>
              </div>

              <div class="col-md-4 col-12">
                <div class="mb-3">
                <label for="lname" class="form-label">Agreed Mileage </label>
                    <input
                      type="text"
                      class="form-control"
                      id="agreemile"
                      name="agreemile"
                      value="{{old('agreemile')}}"
                      placeholder=""
                      
                      
                      />
                      <span class="text-danger">@error('agreemile'){{$message}}@enderror</span>
                </div>
              </div>

            <div class="col-md-4 col-12">
                <div class="mb-3">
                <label for="lname" class="form-label"> Trip Amount </label>
                    <input
                      type="text"
                      class="form-control"
                      id="amount"
                      name="amount"
                      value="{{old('amount')}}"
                      placeholder=""
                      />
                      <span class="text-danger">@error('amount'){{$message}}@enderror</span>
                </div>
              </div>
              <div class="col-md-4 col-12">
                <div class="mb-3">
                <label for="lname" class="form-label">Advanced </label>
                    <input
                      type="text"
                      class="form-control"
                      id="advanced"
                      name="advanced"
                      value="{{old('advanced')}}"
                      placeholder=""
                      
                      
                      />
                      <span class="text-danger">@error('advanced'){{$message}}@enderror</span>
                </div>
              </div>
            <div class="col-md-4 col-12">
                <div class="mb-3">
                <label for="lname" class="form-label">To Pay </label>
                    <input
                      type="text"
                      class="form-control"
                      id="topay"
                      name="topay"
                      value="{{old('topay')}}"
                      placeholder=""
                      
                      
                      />
                      <span class="text-danger">@error('topay'){{$message}}@enderror</span>
                </div>
              </div>

              <div class="col-md-4 col-12">
                <div class="mb-3">
                <label for="lname" class="form-label">Additional Cost </label>
                    <input
                      type="text"
                      class="form-control"
                      id="additional_cost"
                      name="additional_cost"
                      value="{{old('additional_cost')}}"
                      placeholder=""
                      
                      
                      />
                      <span class="text-danger">@error('topay'){{$message}}@enderror</span>
                </div>
              </div>

              

            <div class="col-12" style="text-align: center;">
                  <button type="submit"class="btn btn-primary  w-30 mt-1">Submit All</button>
                  <button type="reset" class="btn btn-outline-secondary  w-30 mt-1">Reset All</button>
                </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- <div class="d-flex justify-content-left pt-2 mt-0">
              <a
                href=""
                class="btn btn-primary me-1"
                data-bs-target="#editUser"
                data-bs-toggle="modal"
                id="fetchEmployees"
                >Assign Employee Here</a
              >
              
            </div> --}}


 <!-- Edit User Modal -->
<div class="modal fade" id="editUser" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
    <div class="modal-content">
      <div class="modal-header bg-transparent">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body pb-5 px-sm-5 pt-10">
        {{-- search booking --}}
        

<section id="input-group-buttons mb-5">
    <div class="row">
        <div class="col-md-6 mb-0 mt-2">
            <div class="input-group">
                <input
                    type="text"
                    class="form-control"
                    id="search_all"
                    name="search_all"
                    placeholder="search"
                    aria-describedby="button-addon2"
                />

               
                <span class="input-group-text" id="searchall"><i data-feather="search"></i></span>
            </div>
        </div>
    </div>
</section>
{{-- end search bookinh --}}


  <div class="content-body mb-2 mt-2">
  <div class="col-12">
    <div class="card">
      
<div class="col-12 ">
    <div class="card">   
      <div class="table-responsive">
         <table class="table table-hover" id="empbook_table">
          <thead>
            <tr>
              <th>Invoice Number</th>
              <th>Customer Name</th>
              
             
              
            </tr>
          </thead>
          <tbody>
          @forelse($booking as $bk)
            <tr class="book_row" data-invbk="{{$bk->invoice_number}}">
              <td>{{$bk->invoice_number}}</td>
              <td>{{$bk->customer_name}}</td>
              
              
              </tr>
              @empty
                            <tr>
                                <td colspan="3">No booking found  <a href="#" > <b><span style="color:red;">Refresh</span></b></a></td>
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
<form action="{{route('assign_employee')}}" method="post">
                @csrf
<div class="col-md-4 col-12">
                <div class="mb-3">
                <label for="lname" class="form-label">Invoice Number </label>
                    <input
                      type="text"
                      class="form-control"
                      id="invq"
                      name="inv"
                      value=""
                      placeholder=""
                      
                      
                      />
                       <span id="invErrorMessage" class="text-danger"></span>
                </div>
              </div>



          <div class="mb-1">

                <div class="col-11 ">
                  <label class="form-label " for="large-select">Choose Employee</label>
                  
                    <select class="select2-size-lg form-select" id="empdropdown" name="empdropdown">
                      
                      
                    </select>
                  

            <div class="form-check form-check-inline mb-1 mt-2">
    <label class="form-check-label" for="inlineCheckbox1">Upload the vehicle images</label>
    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" name="checkboxes[1]" value="upload_images" checked />
</div>
<div class="mt-1 md-2">
    <textarea class="form-control" id="taskDesc21" rows="2" name="taskDesc2[1]" placeholder="Description for image upload"></textarea>
    <span id="textareaErrorMessage1" class="text-danger"></span>
</div>

<div class="form-check form-check-inline mb-1">
    <label class="form-check-label" for="inlineCheckbox2">Get the Mileage</label>
    <input class="form-check-input" type="checkbox" id="inlineCheckbox2" name="checkboxes[2]" value="get_mileage" />
</div>
<div class="mt-1 md-2">
    <textarea class="form-control" id="taskDesc22" rows="2" name="taskDesc2[2]" placeholder="Description for mileage"></textarea>
    <span id="textareaErrorMessage2" class="text-danger"></span>
</div>

<div class="form-check form-check-inline mb-1">
    <label class="form-check-label" for="inlineCheckbox3">Ready the Vehicle</label>
    <input class="form-check-input" type="checkbox" id="inlineCheckbox3" name="checkboxes[3]" value="ready_vehicle" />
</div>
<div class="mt-1 md-2">
    <textarea class="form-control" id="taskDesc23" rows="2" name="taskDesc2[3]" placeholder="Description for ready vehicle"></textarea>
    <span id="textareaErrorMessage3" class="text-danger"></span>
</div>
         <div class="form-check form-check-inline mb-1">
    <label class="form-check-label" for="inlineCheckbox4">Get gas level</label>
    <input class="form-check-input" type="checkbox" id="inlineCheckbox4" name="checkboxes[4]" value="get_gas" />
</div>
<div class="mt-1 md-2">
    <textarea class="form-control" id="taskDesc24" rows="2" name="taskDesc4[4]" placeholder="Description for gas level"></textarea>
    <span id="textareaErrorMessage3" class="text-danger"></span>
</div>       
                <div class="mb-1 mt-2">
              <button type="submit" class="btn btn-primary" id="submitEmp">submit</button>
              <button type="submit" class="btn btn-primary">Clear</button>
              </div>
             </div>
           </div>
        </form>



      </div>
    </div>
  </div>
</div>
<!--/ Edit User Modal -->

    



<!-- Hoverable rows start -->

  <div class="col-12" style="margin-top: 20px;">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title">Booking Details</h4>
      </div>
      <div class="card-body">
        <section id="input-group-buttons mb-5">
            <div class="row">
                <div class="col-md-6 mb-0 mt-2">
                    <div class="input-group">
                        <input
                            type="text"
                            class="form-control"
                            id="search_book_input"
                            name="search_book_input"
                            placeholder="search booking by invoice number / vehicle number"
                            aria-describedby="button-addon2"

                        />

                       
                        <span class="input-group-text" id="search_book"><i data-feather="search"></i></span>
                    </div>
                </div>
            </div>
        </section>
      </div>
      <div class="table-responsive">
        <table class="table table-hover" id="booking_table">
          <thead>
            <tr>
              <th>Invoice Number</th>
              <th>Customer Name </th>
              <th>Id Number</th>
              <th>Passport Number</th>
              <th>Vehicle Model</th>
              <th>Number Plate</th>
              <th>Start Date</th>
              <th>End Date</th>
              <th>Booking Date </th>
              <th>Flight Number</th>
              <th>Date of Arrival</th>
              <th>Time of Landing</th>
              <th>Advance</th>
              <th>Total Amount</th>
              <th>To Pay</th>
              <th>Additional Cost</th>
              <th>Select Employe</th>
              <th>Destination</th>
              
            </tr>
          </thead>
          <tbody id="bookingList">
            @forelse($booking as $bk)
            <tr class="booking_row" data-invbk="{{$bk->invoice_number}}">
              <td>{{$bk->invoice_number}}</td>
              <td>{{$bk->customer_name}}</td>
              <td>{{$bk->cus_id}}</td>
              <td>{{$bk->cus_passport}}</td>
              <td>{{$bk->vehicle_name}}</td>
              <td>{{$bk->vehicle_number}}</td>
              <td>{{$bk->start_date}}</td>
              <td>{{$bk->end_date}}</td>
              <td>{{$bk->reg_date}}</td>
              <td></td>
              <td></td>
              <td></td>
              <td>{{$bk->advanced}}</td>
              <td>{{$bk->amount}}</td>
              <td>{{$bk->rest}}</td>
              <td></td>
              <td>{{$bk->select_employee}}</td>
              <td>{{$bk->vehicle_pickup_location}}</td>


            </tr>
            @empty
            <tr>
            <td colspan="3">No booking found  <a href="#" > <b><span style="color:red;">Refresh
            </span></b></a></td>
            </tr>
            @endforelse 
          </tbody>
        </table>
      </div>
    </div>
  </div>

   

<!-- Hoverable rows start -->

  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title">Assign Employee</h4>
      </div>
      <div class="card-body">
        <section id="input-group-buttons mb-5">
            <div class="row">
                <div class="col-md-6 mb-0 mt-2">
                    <div class="input-group">
                        <input
                            type="text"
                            class="form-control"
                            id="sbinput"
                            name="sbinput"
                            placeholder="search booking by invoice number/vehicle number"
                            aria-describedby="button-addon2"
                        />

                       
                        <span class="input-group-text" id="sb"><i data-feather="search"></i></span>
                    </div>
                </div>
            </div>
        </section>
      </div>
      <div class="table-responsive">
        <table class="table table-hover" id="assign_book_table">
          <thead>
            <tr>
              <th>Invoice Number</th>
              <th>Customer Name </th>
              <th>Id Number</th>
              <th>Passport Number</th>
              <th>Vehicle Model</th>
              <th>Number Plate</th>
              <th>Booking Date </th>
              <th>Flight Number</th>
              <th>Date of Arrival</th>
              <th>Time of Landing</th>
              <th>Advance</th>
              <th>Total Amount</th>
              <th>To Pay</th>
              <th>Additional Cost</th>
              <th>Select Employe</th>
              <th>Destination</th>
              <th>Assign Employee</th>
            </tr>
          </thead>
          <tbody id="bookingListsecond">
            @forelse($booking as $bk)
            <tr class="assign_book" data-invbk="{{$bk->invoice_number}}">
              <td>{{$bk->invoice_number}}</td>
              <td>{{$bk->customer_name}}</td>
              <td>{{$bk->cus_id}}</td>
              <td>{{$bk->cus_passport}}</td>
              <td>{{$bk->vehicle_name}}</td>
              <td>{{$bk->vehicle_number}}</td>
              <td>{{$bk->reg_date}}</td>
              <td></td>
              <td></td>
              <td></td>
              <td>{{$bk->advanced}}</td>
              <td>{{$bk->amount}}</td>
              <td>{{$bk->rest}}</td>
              <td></td>
              <td>{{$bk->select_employee}}</td>
              <td>{{$bk->vehicle_pickup_location}}</td>
              <td>
                <div class="dropdown">
                  <button type="button" class="btn btn-sm dropdown-toggle hide-arrow py-0" data-bs-toggle="dropdown">
                    click
                  </button>
                  <div class="dropdown-menu dropdown-menu-end">
                    <a class="dropdown-item" href="#"
                        data-bs-target="#assignemp"
                        data-bs-toggle="modal"
                        id="fetchEmp"
                        data-invbk="{{$bk->invoice_number}}"
                        data-vn="{{$bk->vehicle_number}}"
                    >
                      <i data-feather="edit-2" class="me-50"></i>
                      <span>Assign Employee</span>
                    </a>
                    
                  </div>
                </div>
              </td>
            
            </tr>
            @empty
            <tr>
            <td colspan="3">No booking found  <a href="#" > <b><span style="color:red;">Refresh
            </span></b></a></td>
            </tr>
            @endforelse 
          </tbody>
        </table>
      </div>
    </div>
  </div>

<!-- Hoverable rows end -->
 <!-- Edit User Modal -->
<div class="modal fade" id="assignemp" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
    <div class="modal-content">
      <div class="modal-header bg-transparent">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body pb-5 px-sm-5 pt-10">


  <div class="content-body mb-2 mt-2">
  <div class="col-12">
    <div class="card">
      

<form action="{{route('assign_employee_book')}}" method="post">
                @csrf
<div class="col-md-4 col-12">
                <div class="mb-3">
                <label for="lname" class="form-label">Invoice Number</label>
                    <input
                      type="text"
                      class="form-control"
                      id="invqw"
                      name="invw"
                      value=""
                      placeholder=""
                      
                      
                      />
                      <span class="text-danger"></span>
                </div>
              </div>

<div class="col-md-4 col-12">
                <div class="mb-3">
                <label for="lname" class="form-label">Vehicle Number</label>
                    <input
                      type="text"
                      class="form-control"
                      id="vn"
                      name="vn"
                      value=""
                      placeholder=""
                      
                      
                      />
                      <span class="text-danger"></span>
                </div>
              </div>

          <div class="mb-1">

                <div class="col-11 ">
                  <label class="form-label " for="large-select">Choose Employee</label>
                  
                    <select class="select2-size-lg form-select" id="empdrop" name="empdrop">
                      
                      
                    </select>
                  

           <div class="form-check form-check-inline mb-1 mt-2">
    <label class="form-check-label" for="inlineCheckbox1">Upload the vehicle images</label>
    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" name="checkb[1]" value="upload_images" checked />
</div>
<div class="mt-1 md-2">
    <textarea class="form-control" id="taskDesc1" rows="2" name="taskDesc[1]" placeholder="Description for image upload"></textarea>
    <span id="textareaErrorMessage1" class="text-danger"></span>
</div>

<div class="form-check form-check-inline mb-1">
    <label class="form-check-label" for="inlineCheckbox2">Get the Mileage</label>
    <input class="form-check-input" type="checkbox" id="inlineCheckbox2" name="checkb[2]" value="get_mileage" />
</div>
<div class="mt-1 md-2">
    <textarea class="form-control" id="taskDesc2" rows="2" name="taskDesc[2]" placeholder="Description for mileage"></textarea>
    <span id="textareaErrorMessage2" class="text-danger"></span>
</div>

<div class="form-check form-check-inline mb-1">
    <label class="form-check-label" for="inlineCheckbox3">Ready the Vehicle</label>
    <input class="form-check-input" type="checkbox" id="inlineCheckbox3" name="checkb[3]" value="ready_vehicle" />
</div>
<div class="mt-1 md-2">
    <textarea class="form-control" id="taskDesc3" rows="2" name="taskDesc[3]" placeholder="Description for ready vehicle"></textarea>
    <span id="textareaErrorMessage3" class="text-danger"></span>
</div>


<div class="form-check form-check-inline mb-1">
    <label class="form-check-label" for="inlineCheckbox3">Get Gas Level</label>
    <input class="form-check-input" type="checkbox" id="inlineCheckbox4" name="checkb[4]" value="get_gas" />
</div>
<div class="mt-1 md-2">
    <textarea class="form-control" id="taskDesc4" rows="2" name="taskDesc[4]" placeholder="Description for gas level"></textarea>
    <span id="textareaErrorMessage4" class="text-danger"></span>
</div>

                <div class="mb-1 mt-2">
              <button type="submit" class="btn btn-primary" id="askValue">submit</button>
              <button type="submit" class="btn btn-primary">Clear</button>
              </div>
             </div>
           </div>
        </form>



      </div>
    </div>
  </div>
</div>
<!--/ Edit User Modal -->
@endsection




{{-- @extends('layouts.lay')
@section('title','Vehicle Booking')
@section('style')
<style>
 .titel{Margin-bottom:50px}
</style>
@endsection
@section('script')
 <script src="{{asset('app-assets/js/scripts/pages/modal-edit-user.min.js')}}"></script>
 <script>
   document.addEventListener("DOMContentLoaded", function() {
    // Your JavaScript code here
    const advanced = document.getElementById('advanced');
    var amount = document.getElementById('amount');
    var rest = document.getElementById('topay');

    advanced.addEventListener('input', updateMilageCost);

    function updateMilageCost() {
      
      
      const amountnew = parseFloat(amount.value);
      const adva = parseFloat(advanced.value);

      const topay = amountnew - adva;

      rest.value = isNaN(topay) ? '' : topay.toFixed(2);
    }
});
  </script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const brandSelect = document.getElementById('brand');
        const modelSelect = document.getElementById('model');

        brandSelect.addEventListener('change', function () {
            const selectedBrandId = this.value;
       if (selectedBrandId) {
                // Enable the model dropdown
                modelSelect.disabled = false;
            // Clear existing options in the model dropdown
            modelSelect.innerHTML = "";

            // Make an AJAX request to fetch models based on the selected brand
            fetch(`/get_models_booking/${selectedBrandId}`)
                .then(response => response.json())
                .then(models => {
                    // Populate the model dropdown with fetched data
                    models.forEach(model => {
                        const option = document.createElement('option');
                        option.value = model.model;
                        option.text = model.model;
                        modelSelect.add(option);
                    });
                })
                .catch(error => console.error('Error fetching models:', error));
              } else {
                // If no brand is selected, disable the model dropdown
                modelSelect.disabled = true;
            }
        });
    });
</script>
<!-- Your existing HTML code -->

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function () {
        // Attach event listeners to dropdowns and date pickers
        $('#brand, #model, #start_date, #end_date').change(fetchData);

        function fetchData() {
            var brand = $('#brand').val();
            var model = $('#model').val();
            var startDate = $('#start_date').val();
            var endDate = $('#end_date').val();

            // Make AJAX request without pagination parameters
            $.ajax({
                url: '{{ route('fetchData') }}',
                type: 'GET',
                data: {
                    brand: brand,
                    model: model,
                    start_date: startDate,
                    end_date: endDate
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
            var tableBody = $('#vehicle_table tbody');
            tableBody.empty(); // Clear existing rows

            if (data.length === 0) {
                // Display a message if no data is found
                tableBody.append('<tr><td colspan="4">No vehicles found for the selected criteria.</td></tr>');
            } else {
                // Populate the table with the fetched data
                data.forEach(function (item) {
                    var row = '<tr class="vehicle-row" data-name="' + item.vehicle_name + '" data-number="' + item.vehicle_number + '">' +
                        '<td>' + item.vehicle_name + '</td>' +
                        '<td>' + item.vehicle_number + '</td>' +
                        '<td>' + item.vehicle_status + '</td>' +
                        '<td>' + item.reason + '</td>' +
                        '<td>' + item.booking_status + '</td>' +
                        '<td>' + item.release_date + '</td>' +
                        '</tr>';
                    tableBody.append(row);
                });
            }
        }
    });
</script>



<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function () {
        $(document).on("click", ".vehicle-row", function () {
            var name = $(this).data('name');
            var number = $(this).data('number');

            $("#vehicle_name").val(name);
            $("#vehicle_number").val(number);
        });
    });
</script>


<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function() {
        $(document).on("click", ".customer_row", function (){
            var name = $(this).data('name');
            var id = $(this).data('id');
            var pss = $(this).data('pss');
            var mobile = $(this).data('number');

            $("#customer_name").val(name);
            $("#id_card").val(id);
            $("#passport").val(pss);
            $("#mobile").val(mobile);
        });
    });
</script>



<script>
    $(document).ready(function () {
        // Attach event listener to the search button
        $('#searchButton').click(fetchFilteredData);

        // Attach event listener to input fields for Enter key press
        $('#search_cus, #search_cus_id, #search_cus_number').on('keypress', function (event) {
            if (event.which === 13) {
                fetchFilteredData();
            }
        });

        function fetchFilteredData() {
            var search_cus = $('#search_cus').val();
            var search_cus_id = $('#search_cus_id').val();
            var search_cus_number = $('#search_cus_number').val();

            // Make AJAX request
            $.ajax({
                url: '{{ route('fetchFilteredData') }}', // Replace with your actual route
                type: 'GET',
                data: {
                    search_cus: search_cus,
                    search_cus_id: search_cus_id,
                    search_cus_number: search_cus_number,
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
            var tableBody = $('#customer_table tbody');
            tableBody.empty(); // Clear existing rows

            if (data.length === 0) {
                // Display a message if no data is found
                tableBody.append('<tr><td colspan="5">No customers found for the selected criteria.</td></tr>');
            } else {
                // Populate the table with the fetched data
                $.each(data, function (index, item) {
                    tableBody.append('<tr class="customer_row" data-name="' + item.fname + ' ' + item.lname + '" data-id="' + item.id + '" data-pss="' + item.passportnumber + '" data-number="' + item.phonenumber + '">' +
                        '<td>' + item.fname + ' ' + item.lname + '</td>' +
                        '<td>' + item.idnumber + '</td>' +
                        '<td>' + item.passportnumber + '</td>' +
                        '<td>' + item.phonenumber + '</td>' +
                        '<td>' + item.regDate + '</td>' +
                        '</tr>');
                });
            }
        }
    });
</script>




<!-- Your existing HTML code -->
<script>
    $(document).ready(function () {
        // Attach event listener to the search button
        $('#searchall').click(filterBooking);

        // Attach event listener to input fields for Enter key press
        $('#search_all').on('keypress', function (event) {
            if (event.which === 13) {
                filterBooking();
            }
        });

        function filterBooking() {
            var search_all = $('#search_all').val();

            // Make AJAX request
            $.ajax({
                url: '{{ route('filter_booking') }}',
                type: 'GET',
                data: {
                    search_all: search_all
                },
                dataType: 'json',
                success: function (response) {
                    if (response.data.length > 0) {
                        updateTable(response.data);

                        // Re-attach event listener to dynamically created elements
                        $('.book_row').off('click').on('click', function() {
                            var inv = $(this).data('invbk');
                            $("#invq").val(inv);
                        });
                    } else {
                        displayNoResultsMessage();
                    }
                },
                error: function (error) {
                    console.log(error);
                    displayErrorMessage();
                }
            });
        }

        function updateTable(data) {
            var tableBody = $('#empbook_table tbody');
            tableBody.empty(); // Clear existing rows

            $.each(data, function (index, item) {
                tableBody.append('<tr class="book_row" data-invbk="' + item.invoice_number + '">' +
                    '<td>' + item.invoice_number + '</td>' +
                    '<td>' + item.customer_name + '</td>' +
                    '</tr>');
            });
        }

        function displayNoResultsMessage() {
            var tableBody = $('#empbook_table tbody');
            tableBody.empty();
            tableBody.append('<tr><td colspan="2">No bookings found for the selected criteria.</td></tr>');
        }

        function displayErrorMessage() {
            var tableBody = $('#empbook_table tbody');
            tableBody.empty();
            tableBody.append('<tr><td colspan="2">An error occurred while fetching bookings.</td></tr>');
        }
    });
</script>



{{-- get invoice number to text input --}}
<script>
    $(document).ready(function() {
        // Attach event listener to dynamically created elements
        $(document).on("click", ".book_row", function() {
            var inv = $(this).data('invbk');
            $("#invq").val(inv);
        });
    });
</script>
{{-- get invoice number to text input in assign --}}

<script>
   $(document).ready(function () {
    console.log("Document ready function executed."); // Add this line
    // Rest of your code...
});
</script> 


{{-- fetch employee names --}}
<script>
    $(document).ready(function () {
        // Event listener for fetching employee names
        $('#fetchEmployees').click(function () {
            $('#invq').val('');
            // Make AJAX request
            $.ajax({
                url: '/getEmployeeNames', // Adjust the URL based on your route
                type: 'GET',
                success: function (response) {
                    // Update the dropdown options with employee names
                    updateDropdown(response.data);

                },
                error: function (error) {
                    console.log(error);
                }
            });
        });

        // Function to update the dropdown with employee names
        function updateDropdown(employees) {
            var dropdown = $('#empdropdown');
            dropdown.empty(); // Clear existing options
dropdown.append('<option value="">Select Name</option>');
            // Populate the dropdown with fetched employee names
            $.each(employees, function (index, employee) {
                dropdown.append('<option value="' + employee.user_id + '">' + employee.name + '</option>');
            });
        }
    });
</script>
<script>
   
    $(document).ready(function () {
        // Event listener for clicking the "Assign Employee" link
        $(document).on('click', '#fetchEmp', function () {
            var invoiceNumber = $(this).data('invbk'); // Get the invoice number from data-invbk attribute
            var vn=$(this).data('vn');
            // Make AJAX request to fetch employee names
            $.ajax({
                url: '/getEmployeeNames', // Adjust the URL based on your route
                type: 'GET',
                success: function (response) {
                    // Update the dropdown options with employee names
                    updateDropdown(response.data);

                    // Set the invoice number in the input field
                    $('#invqw').val(invoiceNumber);
                    $('#vn').val(vn);
                },
                error: function (error) {
                    console.log(error);
                }
            });
        });

        // Function to update the dropdown with employee names
        function updateDropdown(employees) {
            var dropdown = $('#empdrop');
            dropdown.empty(); // Clear existing options
dropdown.append('<option value="">Select Name</option>');
            // Populate the dropdown with fetched employee names
            $.each(employees, function (index, employee) {
                dropdown.append('<option value="' + employee.user_id + '">' + employee.name + '</option>');
            });
        }
    });
</script>


{{-- fetch bookings --}}
<script>
    $(document).ready(function () {
        // Attach event listener to the search button
        $('#search_book').click(filterBooking);

        // Attach event listener to input fields for Enter key press
        $('#search_book_input').on('keypress', function (event) {
            if (event.which === 13) {
                filterBooking();
            }
        });

        function filterBooking(event) {
            // Prevent default form submission behavior
            if (event) {
                event.preventDefault();
            }

            var search_all = $('#search_book_input').val();

            // Make AJAX request
            $.ajax({
                url: '{{ route('filter_booking') }}',
                type: 'GET',
                data: {
                    search_all: search_all
                },
                dataType: 'json',
                success: function (response) {
                    if (response.data.length > 0) {
                        updateTable(response.data);
                    } else {
                        displayNoResultsMessage();
                    }
                },
                error: function (error) {
                    console.log(error);
                    displayErrorMessage();
                }
            });
        }

        function updateTable(data) {
            var tableBody = $('#booking_table tbody');
            tableBody.empty(); // Clear existing rows

            $.each(data, function (index, item) {
                tableBody.append('<tr class="booking_row" data-invbk="' + item.invoice_number + '">' +
                    '<td>' + item.invoice_number + '</td>' +
                    '<td>' + item.customer_name + '</td>' +
                    '<td>' + item.cus_id + '</td>' +
                    '<td>' + item.cus_passport + '</td>' +
                    '<td>' + item.vehicle_name + '</td>' +
                    '<td>' + item.vehicle_number + '</td>' +
                    '<td>' + item.reg_date + '</td>' +
                    '<td>' + item.advanced + '</td>' +
                    '<td>' + item.amount + '</td>' +
                    '<td>' + item.rest + '</td>' +
                    '<td>' + item.select_employee + '</td>' +
                    '<td>' + item.vehicle_pickup_location + '</td>' +
                    '</tr>');
            });
        }

        function displayNoResultsMessage() {
            var tableBody = $('#booking_table tbody');
            tableBody.empty();
            tableBody.append('<tr><td colspan="2">No bookings found for the selected criteria.</td></tr>');
        }

        function displayErrorMessage() {
            var tableBody = $('#booking_table tbody');
            tableBody.empty();
            tableBody.append('<tr><td colspan="2">An error occurred while fetching bookings.</td></tr>');
        }
    });
</script>

<script>
   $(document).ready(function () {
    // Attach event listener to the search button
    $('#sb').click(filterBooking);

    // Attach event listener to input fields for Enter key press
    $('#sbinput').on('keypress', function (event) {
        if (event.which === 13) {
            filterBooking();
        }
    });

    function filterBooking() {
        var search_all = $('#sbinput').val();

        // Make AJAX request
        $.ajax({
            url: '{{ route('filter_booking') }}',
            type: 'GET',
            data: {
                sbinput: search_all // Use sbinput as the parameter name
            },
            dataType: 'json',
            success: function (response) {
                if (response.data.length > 0) {
                    updateTable(response.data);
                } else {
                    displayNoResultsMessage();
                }
            },
            error: function (error) {
                console.log('Error:', error);
                displayErrorMessage();
            }
        });
    }

    function updateTable(data) {
    var tableBody = $('#assign_book_table tbody');
    tableBody.empty(); // Clear existing rows

    $.each(data, function (index, item) {
        var rowHtml = '<tr class="assign_book" data-invbk="' + item.invoice_number + '">' +
            '<td>' + item.invoice_number + '</td>' +
            '<td>' + item.customer_name + '</td>' +
            '<td>' + item.cus_id + '</td>' +
            '<td>' + item.cus_passport + '</td>' +
            '<td>' + item.vehicle_name + '</td>' +
            '<td>' + item.vehicle_number + '</td>' +
            '<td>' + item.reg_date + '</td>' +
            '<td>' + item.advanced + '</td>' +
            '<td>' + item.amount + '</td>' +
            '<td>' + item.rest + '</td>' +
            '<td>' + item.select_employee + '</td>' +
            '<td>' + item.vehicle_pickup_location + '</td>' +
            '<td>' +
                '<div class="dropdown">' +
                    '<button type="button" class="btn btn-sm dropdown-toggle hide-arrow py-0" data-bs-toggle="dropdown" >' +
                        'click' +
                    '</button>' +
                    '<div class="dropdown-menu dropdown-menu-end">' +
                        '<a class="dropdown-item" href="/test">' +
                            '<i data-feather="edit-2" class="me-50"></i>' +
                            '<span>Assign Employee</span>' +
                        '</a>' +
                    '</div>' +
                '</div>' +
            '</td>' +
        '</tr>';
        tableBody.append(rowHtml);
    });
}


    function displayNoResultsMessage() {
        var tableBody = $('#assign_book_table tbody');
        tableBody.empty();
        tableBody.append('<tr><td colspan="2">No bookings found for the selected criteria.</td></tr>');
        console.log

    }

    function displayErrorMessage() {
        var tableBody = $('#assign_book_table tbody');
        tableBody.empty();
        tableBody.append('<tr><td colspan="2">An error occurred while fetching bookings.</td></tr>');
    }
});

</script>

{{-- automatic booking load  --}}
{{-- <script>
    var eventSource = new EventSource("{{ route('sse') }}");

eventSource.onmessage = function(event) {
    console.log("Received SSE message:", event.data); // Log the raw SSE data

    var bookings = JSON.parse(event.data);
    console.log("Parsed bookings data:", bookings); // Log the parsed JSON data

    var bookingList = document.getElementById('bookingList');
    bookingList.innerHTML = ''; // Clear existing list
    bookings.forEach(function(booking) {
        var tr = document.createElement('tr');
        tr.innerHTML = 
            '<td>' + booking.invoice_number + '</td>' +
            '<td>' + booking.customer_name + '</td>' +
            '<td>' + booking.cus_id + '</td>' +
            '<td>' + booking.cus_passport + '</td>' +
            '<td>' + booking.vehicle_name + '</td>' +
            '<td>' + booking.vehicle_number + '</td>' +
            '<td>' + booking.reg_date + '</td>' +
            '<td>' + booking.advanced + '</td>' +
            '<td>' + booking.amount + '</td>' +
            '<td>' + booking.rest + '</td>' +
            '<td>' + booking.select_employee + '</td>' +
            '<td>' + booking.vehicle_pickup_location + '</td>';
        bookingList.appendChild(tr);
    });
};

</script> --}}


@endsection
@section('content')

@if(Session::has('s'))
 <div class="toastqq" id="toastqq">{{session('s')}}</div>
@endif

@if(Session::has('f'))
<div class="toastHH" id="toastHH">{{session('f')}}</div>
                
@endif



<!-- Inputs Group with Buttons -->
<section id="input-group-buttons">
<h3 class="titel">Vehicle Booking</h3>

@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="" method="get">
          <div class="row">
            <div class="col-md-3 mb-1  ">
            <label class="form-label" for="large-select">Vehicle Brand</label>
              <div class="input-group">
                    <select class="select2-size-lg form-select" id="brand" name="brand">
                    <option value="">Select</option>
                    @foreach($branddata as $br)
                    <option value="{{$br->brand}}">{{$br->brand}}</option>
                    @endforeach
                  </select>
              </div>
            </div>

            <div class="col-md-3 mb-1 ">
            <label class="form-label" for="large-select">Vehicle Model</label>
              <div class="input-group">
                    <select class="select2-size-lg form-select"  id="model" name="model" disabled>
                    <option value="">Select</option>
                    
                  </select>
              </div>
            </div>

            <div class="col-md-3 mb-1 ">
            <label class="form-label" for="large-select">Start Date</label>
              <div class="input-group">
                <input
                    type="text"
                    id="start_date"
                    name="start_date"
                    class="form-control flatpickr-basic"
                    placeholder="Search Date"
                    
                  />
                </div>
              </div>

              <div class="col-md-3 mb-1 ">
              <label class="form-label" for="large-select">End Date</label>
              <div class="input-group">
                <input
                    type="text"
                    id="end_date"
                    name="end_date"
                    
                    class="form-control flatpickr-basic"
                    placeholder="Search Date"
                  />
                </div>
              </div>
            </div>
          </div>
          </form>
 </section>


 <div class="row mt-1 "  id="basic-table">
  <div class="content-body mb-2 ">
  <div class="row mt-1 " id="dark-table">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h5>Vehicle Available & Pending Details</h5>
      </div>
      
<div class="col-12 ">
    <div class="card">   
      <div class="table-responsive" style="max-height:300px">
        <table class="table table-hover" id="vehicle_table">
          <thead>
            <tr>
              <th>Vehicle Name</th>
              <th>Number Plate</th>
              <th>Status</th>
              <th>Reason</th>
              <th>Booking Status</th>
              <th>Release Date</th>
            </tr>
          </thead>
          <tbody>
            @forelse($data as $da)
            <tr class="vehicle-row"    data-name="{{ $da->vehicle_name }}" data-number="{{ $da->vehicle_number }}">
              <td>{{$da->vehicle_name}}</td>
              <td>{{$da->vehicle_number}}</td>
              <td>{{$da->vehicle_status}}</td>
              <td>{{$da->reason}}</td>
              <td>{{$da->booking_status}}</td>
              <td>{{$da->release_date}}</td>
              
              </tr>
              @empty
                            <tr>
                                <td colspan="3">No vehicles found  <a href="#" > <b><span style="color:red;">Refresh</span></b></a></td>
                            </tr>
               @endforelse 
                            </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
</div>





<section id="input-group-buttons mb-5">
    <div class="row">
        <div class="col-md-6 mb-0 mt-2">
            <div class="input-group">
                <input
                    type="text"
                    class="form-control"
                    id="search_cus"
                    placeholder="Customer Name"
                    aria-describedby="button-addon2"
                />

                <input
                    type="text"
                    class="form-control"
                    id="search_cus_id"
                    placeholder="Id/Passport Number"
                    aria-describedby="button-addon2"
                />

                <input
                    type="text"
                    class="form-control"
                    id="search_cus_number"
                    placeholder="Phone Number"
                    aria-describedby="button-addon2"
                />
                
                <span class="input-group-text" id="searchButton"><i data-feather="search"></i></span>
            </div>
        </div>
    </div>
</section>



  <div class="content-body mb-2 mt-2">
  <div class="col-12">
    <div class="card">
      
<div class="col-12 ">
    <div class="card">   
      <div class="table-responsive" style="max-height:300px">
         <table class="table table-hover" id="customer_table">
          <thead>
            <tr>
              <th>Customer Name</th>
              <th>Id Number</th>
              <th>Passport Number</th>
              <th>Phone Number</th>
              <th>Date</th>
              
            </tr>
          </thead>
          <tbody>
          @forelse($cus as $cs)
            <tr class="customer_row"    
            data-name="{{$cs->fname}} {{$cs->lname}}" 
            data-id="{{$cs->idnumber}}"
            data-pss="{{$cs->passportnumber}}"
            data-number="{{$cs->phonenumber}}">
              <td>{{$cs->fname}} {{$cs->lname}}</td>
              <td>{{$cs->idnumber}}</td>
              <td>{{$cs->passportnumber}}</td>
              <td>{{$cs->phonenumber}}</td>
              <td>{{$cs->regDate}}</td>
              
              </tr>
              @empty
                            <tr>
                                <td colspan="3">No customer found  <a href="#" > <b><span style="color:red;">Refresh</span></b></a></td>
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





<section id="multiple-column-form">
  <div class="row mt-1 ">
    <div class="col-12">
      <div class="card">
         <div class="card-body">
          <form class="form" action="{{route('insert_booking_data')}}" method="post">
                

             @csrf
             <div class="col-md-3 col-12">
                <div class="mb-1" >
                <label for="lname" class="form-label">Invoice Number </label>
                    <input
                      type="text"
                      class="form-control"
                      id="invoice"
                      name="invoice"
                      value="{{old('invoice')}}"
                      placeholder="inv09876"
                      style="border: 0.5px solid red;"
                      
                      />
                      <span class="text-danger">@error('invoice'){{$message}}@enderror</span>
                </div>
              </div>
            <div class="row">
              <div class="col-md-4 col-12">
                <div class="mb-1">
                <label for="fname" class="form-label">Vehicle Name</label>
                  <input
                    type="text"
                    class="form-control"
                    id="vehicle_name"
                    name="vehicle_name"
                    value="{{old('vehicle_name')}}"
                    placeholder="john"
                    
                    
                  />
                    <span class="text-danger">@error('vehicle_name'){{$message}}@enderror</span>
                </div>
              </div>

              
              <div class="col-md-4 col-12">
                <div class="mb-1">
                <label for="email" class="form-label">Vehicle Number</label>
            <input
              type="text"
              class="form-control"
              id="vehicle_number"
              name="vehicle_number"
              value="{{old('vehicle_number')}}"
              placeholder="ABC-0987"
              aria-describedby="login-email"
              
            />
            <span class="text-danger">@error('vehicle_number'){{$message}}@enderror</span>
                </div>
              </div>


              <div class="col-md-4 col-12">
                <div class="mb-3">
                <label for="username" class="form-label">Customer Name</label>
            <input
              type="text"
              class="form-control"
              id="customer_name"
              name="customer_name"
              value="{{old('customer_name')}}"
              placeholder="waruna"
              value=""
             
            />
            <span class="text-danger">@error('customer_name'){{$message}}@enderror</span>
                </div>
              </div>


              <div class="col-md-4 col-12">
                <div class="mb-3">
                <label for="lname" class="form-label">Id Number</label>
                    <input
                      type="text"
                      class="form-control"
                      id="id_card"
                      value="{{old('id_card')}}"
                      name="id_card"
                      value=""
                      placeholder=""
                      
                     
                      />
                      <span class="text-danger">@error('id_card'){{$message}}@enderror</span>
                </div>
              </div>
              <div class="col-md-4 col-12">
                <div class="mb-3">
                <label for="lname" class="form-label">Passport </label>
                    <input
                      type="text"
                      class="form-control"
                      id="passport"
                      name="passport"
                      value="{{old('passport')}}"
                      value=""
                      placeholder=""
                      
                     
                      />
                      <span class="text-danger">@error('passport'){{$message}}@enderror</span>
                </div>
              </div>

              <div class="col-md-4 col-12">
                <div class="mb-3">
                <label for="lname" class="form-label">Phone Number </label>
                    <input
                      type="text"
                      class="form-control"
                      id="mobile"
                      name="mobile"
                      value="{{old('passport')}}"
                      placeholder=""
                      
                      
                      />
                      <span class="text-danger">@error('mobile'){{$message}}@enderror</span>
                </div>
              </div>

                <div class="col-md-4 col-12">
                <div class="mb-3">
                <label class="form-label" for="fp-range">Start date</label>
                  <input
                    type="text"
                    id="s_date"
                    name="s_date"
                    value="{{old('s_date')}}"
                    class="form-control flatpickr-basic"
                    placeholder="YYYY-MM-DD"
                  />
                      <span class="text-danger">@error('s_date'){{$message}}@enderror</span>
                </div>
              </div>
                <div class="col-md-4 col-12">
                <div class="mb-3">
                <label class="form-label" for="fp-range">End date</label>
                  <input
                    type="text"
                    id="e_date"
                    name="e_date"
                    value="{{old('e_date')}}"
                    class="form-control flatpickr-basic"
                    placeholder="YYYY-MM-DD"
                  />
                      <span class="text-danger">@error('e_date'){{$message}}@enderror</span>
                </div>
              </div>

            <div class="col-md-4 col-12">
                <div class="mb-3">
                <label for="lname" class="form-label">Destination </label>
                    <input
                      type="text"
                      class="form-control"
                      id="destination"
                      value="{{old('destination')}}"
                      name="destination"
                      
                      
                      
                      />
                      <span class="text-danger">@error('destination'){{$message}}@enderror</span>
                </div>
              </div>
<div class="col-md-4 col-12">
                <div class="mb-3">
                <label for="lname" class="form-label">Agreed Mileage </label>
                    <input
                      type="text"
                      class="form-control"
                      id="agreemile"
                      name="agreemile"
                      value="{{old('agreemile')}}"
                      placeholder=""
                      
                      
                      />
                      <span class="text-danger">@error('agreemile'){{$message}}@enderror</span>
                </div>
              </div>
            <div class="col-md-4 col-12">
                <div class="mb-3">
                <label for="lname" class="form-label"> Trip Amount </label>
                    <input
                      type="text"
                      class="form-control"
                      id="amount"
                      name="amount"
                      value="{{old('amount')}}"
                      placeholder=""
                      />
                      <span class="text-danger">@error('amount'){{$message}}@enderror</span>
                </div>
              </div>
              <div class="col-md-4 col-12">
                <div class="mb-3">
                <label for="lname" class="form-label">Advanced </label>
                    <input
                      type="text"
                      class="form-control"
                      id="advanced"
                      name="advanced"
                      value="{{old('advanced')}}"
                      placeholder=""
                      
                      
                      />
                      <span class="text-danger">@error('advanced'){{$message}}@enderror</span>
                </div>
              </div>
            <div class="col-md-4 col-12">
                <div class="mb-3">
                <label for="lname" class="form-label">To Pay </label>
                    <input
                      type="text"
                      class="form-control"
                      id="topay"
                      name="topay"
                      value="{{old('topay')}}"
                      placeholder=""
                      
                      
                      />
                      <span class="text-danger">@error('topay'){{$message}}@enderror</span>
                </div>
              </div>

              

            <div class="col-12" style="text-align: center;">
                  <button type="submit"class="btn btn-primary  w-30 mt-1">Submit All</button>
                  <button type="reset" class="btn btn-outline-secondary  w-30 mt-1">Reset All</button>
                </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- <div class="d-flex justify-content-left pt-2 mt-0">
              <a
                href=""
                class="btn btn-primary me-1"
                data-bs-target="#editUser"
                data-bs-toggle="modal"
                id="fetchEmployees"
                >Assign Employee Here</a
              >
              
            </div> --}}


 <!-- Edit User Modal -->
<div class="modal fade" id="editUser" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
    <div class="modal-content">
      <div class="modal-header bg-transparent">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body pb-5 px-sm-5 pt-10">
        {{-- search booking --}}
        

<section id="input-group-buttons mb-5">
    <div class="row">
        <div class="col-md-6 mb-0 mt-2">
            <div class="input-group">
                <input
                    type="text"
                    class="form-control"
                    id="search_all"
                    name="search_all"
                    placeholder="search"
                    aria-describedby="button-addon2"
                />

               
                <span class="input-group-text" id="searchall"><i data-feather="search"></i></span>
            </div>
        </div>
    </div>
</section>
{{-- end search bookinh --}}


  <div class="content-body mb-2 mt-2">
  <div class="col-12">
    <div class="card">
      
<div class="col-12 ">
    <div class="card">   
      <div class="table-responsive">
         <table class="table table-hover" id="empbook_table">
          <thead>
            <tr>
              <th>Invoice Number</th>
              <th>Customer Name</th>
              
             
              
            </tr>
          </thead>
          <tbody>
          @forelse($booking as $bk)
            <tr class="book_row" data-invbk="{{$bk->invoice_number}}">
              <td>{{$bk->invoice_number}}</td>
              <td>{{$bk->customer_name}}</td>
              
              
              </tr>
              @empty
                            <tr>
                                <td colspan="3">No booking found  <a href="#" > <b><span style="color:red;">Refresh</span></b></a></td>
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
<form action="{{route('assign_employee')}}" method="post">
                @csrf
<div class="col-md-4 col-12">
                <div class="mb-3">
                <label for="lname" class="form-label">Invoice Number </label>
                    <input
                      type="text"
                      class="form-control"
                      id="invq"
                      name="inv"
                      value=""
                      placeholder=""
                      
                      
                      />
                       <span id="invErrorMessage" class="text-danger"></span>
                </div>
              </div>



          <div class="mb-1">

                <div class="col-11 ">
                  <label class="form-label " for="large-select">Choose Employee</label>
                  
                    <select class="select2-size-lg form-select" id="empdropdown" name="empdropdown">
                      
                      
                    </select>
                  

            <div class="form-check form-check-inline mb-1 mt-2">
    <label class="form-check-label" for="inlineCheckbox1">Upload the vehicle images</label>
    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" name="checkboxes[1]" value="upload_images" checked />
</div>
<div class="mt-1 md-2">
    <textarea class="form-control" id="taskDesc21" rows="2" name="taskDesc2[1]" placeholder="Description for image upload"></textarea>
    <span id="textareaErrorMessage1" class="text-danger"></span>
</div>

<div class="form-check form-check-inline mb-1">
    <label class="form-check-label" for="inlineCheckbox2">Get the Mileage</label>
    <input class="form-check-input" type="checkbox" id="inlineCheckbox2" name="checkboxes[2]" value="get_mileage" />
</div>
<div class="mt-1 md-2">
    <textarea class="form-control" id="taskDesc22" rows="2" name="taskDesc2[2]" placeholder="Description for mileage"></textarea>
    <span id="textareaErrorMessage2" class="text-danger"></span>
</div>

<div class="form-check form-check-inline mb-1">
    <label class="form-check-label" for="inlineCheckbox3">Ready the Vehicle</label>
    <input class="form-check-input" type="checkbox" id="inlineCheckbox3" name="checkboxes[3]" value="ready_vehicle" />
</div>
<div class="mt-1 md-2">
    <textarea class="form-control" id="taskDesc23" rows="2" name="taskDesc2[3]" placeholder="Description for ready vehicle"></textarea>
    <span id="textareaErrorMessage3" class="text-danger"></span>
</div>
         <div class="form-check form-check-inline mb-1">
    <label class="form-check-label" for="inlineCheckbox4">Get gas level</label>
    <input class="form-check-input" type="checkbox" id="inlineCheckbox4" name="checkboxes[4]" value="get_gas" />
</div>
<div class="mt-1 md-2">
    <textarea class="form-control" id="taskDesc24" rows="2" name="taskDesc4[4]" placeholder="Description for gas level"></textarea>
    <span id="textareaErrorMessage3" class="text-danger"></span>
</div>       
                <div class="mb-1 mt-2">
              <button type="submit" class="btn btn-primary" id="submitEmp">submit</button>
              <button type="submit" class="btn btn-primary">Clear</button>
              </div>
             </div>
           </div>
        </form>



      </div>
    </div>
  </div>
</div>
<!--/ Edit User Modal -->

    



<!-- Hoverable rows start -->

  <div class="col-12" style="margin-top: 20px;">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title">Booking Details</h4>
      </div>
      <div class="card-body">
        <section id="input-group-buttons mb-5">
            <div class="row">
                <div class="col-md-6 mb-0 mt-2">
                    <div class="input-group">
                        <input
                            type="text"
                            class="form-control"
                            id="search_book_input"
                            name="search_book_input"
                            placeholder="search booking by invoice number / vehicle number"
                            aria-describedby="button-addon2"

                        />

                       
                        <span class="input-group-text" id="search_book"><i data-feather="search"></i></span>
                    </div>
                </div>
            </div>
        </section>
      </div>
      <div class="table-responsive">
        <table class="table table-hover" id="booking_table">
          <thead>
            <tr>
              <th>Invoice Number</th>
              <th>Customer Name </th>
              <th>Id Number</th>
              <th>Passport Number</th>
              <th>Vehicle Model</th>
              <th>Number Plate</th>
              <th>Start Date</th>
              <th>End Date</th>
              <th>Booking Date </th>
              <th>Advance</th>
              <th>Total Amount</th>
              <th>To Pay</th>
              <th>Select Employe</th>
              <th>Destination</th>
              
            </tr>
          </thead>
          <tbody id="bookingList">
            @forelse($booking as $bk)
            <tr class="booking_row" data-invbk="{{$bk->invoice_number}}">
              <td>{{$bk->invoice_number}}</td>
              <td>{{$bk->customer_name}}</td>
              <td>{{$bk->cus_id}}</td>
              <td>{{$bk->cus_passport}}</td>
              <td>{{$bk->vehicle_name}}</td>
              <td>{{$bk->vehicle_number}}</td>
              <td>{{$bk->start_date}}</td>
              <td>{{$bk->end_date}}</td>
              <td>{{$bk->reg_date}}</td>
              <td>{{$bk->advanced}}</td>
              <td>{{$bk->amount}}</td>
              <td>{{$bk->rest}}</td>
              <td>{{$bk->select_employee}}</td>
              <td>{{$bk->vehicle_pickup_location}}</td>


            </tr>
            @empty
            <tr>
            <td colspan="3">No booking found  <a href="#" > <b><span style="color:red;">Refresh
            </span></b></a></td>
            </tr>
            @endforelse 
          </tbody>
        </table>
      </div>
    </div>
  </div>

   

<!-- Hoverable rows start -->

  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title">Assign Employee</h4>
      </div>
      <div class="card-body">
        <section id="input-group-buttons mb-5">
            <div class="row">
                <div class="col-md-6 mb-0 mt-2">
                    <div class="input-group">
                        <input
                            type="text"
                            class="form-control"
                            id="sbinput"
                            name="sbinput"
                            placeholder="search booking by invoice number/vehicle number"
                            aria-describedby="button-addon2"
                        />

                       
                        <span class="input-group-text" id="sb"><i data-feather="search"></i></span>
                    </div>
                </div>
            </div>
        </section>
      </div>
      <div class="table-responsive">
        <table class="table table-hover" id="assign_book_table">
          <thead>
            <tr>
              <th>Invoice Number</th>
              <th>Customer Name </th>
              <th>Id Number</th>
              <th>Passport Number</th>
              <th>Vehicle Model</th>
              <th>Number Plate</th>
              <th>Booking Date </th>
              <th>Advance</th>
              <th>Total Amount</th>
              <th>To Pay</th>
              <th>Select Employe</th>
              <th>Destination</th>
              <th>Assign Employee</th>
            </tr>
          </thead>
          <tbody id="bookingListsecond">
            @forelse($booking as $bk)
            <tr class="assign_book" data-invbk="{{$bk->invoice_number}}">
              <td>{{$bk->invoice_number}}</td>
              <td>{{$bk->customer_name}}</td>
              <td>{{$bk->cus_id}}</td>
              <td>{{$bk->cus_passport}}</td>
              <td>{{$bk->vehicle_name}}</td>
              <td>{{$bk->vehicle_number}}</td>
              <td>{{$bk->reg_date}}</td>
              <td>{{$bk->advanced}}</td>
              <td>{{$bk->amount}}</td>
              <td>{{$bk->rest}}</td>
              <td>{{$bk->select_employee}}</td>
              <td>{{$bk->vehicle_pickup_location}}</td>
              <td>
                <div class="dropdown">
                  <button type="button" class="btn btn-sm dropdown-toggle hide-arrow py-0" data-bs-toggle="dropdown">
                    click
                  </button>
                  <div class="dropdown-menu dropdown-menu-end">
                    <a class="dropdown-item" href="#"
                        data-bs-target="#assignemp"
                        data-bs-toggle="modal"
                        id="fetchEmp"
                        data-invbk="{{$bk->invoice_number}}"
                        data-vn="{{$bk->vehicle_number}}"
                    >
                      <i data-feather="edit-2" class="me-50"></i>
                      <span>Assign Employee</span>
                    </a>
                    
                  </div>
                </div>
              </td>
            
            </tr>
            @empty
            <tr>
            <td colspan="3">No booking found  <a href="#" > <b><span style="color:red;">Refresh
            </span></b></a></td>
            </tr>
            @endforelse 
          </tbody>
        </table>
      </div>
    </div>
  </div>

<!-- Hoverable rows end -->
 <!-- Edit User Modal -->
<div class="modal fade" id="assignemp" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
    <div class="modal-content">
      <div class="modal-header bg-transparent">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body pb-5 px-sm-5 pt-10">


  <div class="content-body mb-2 mt-2">
  <div class="col-12">
    <div class="card">
      

<form action="{{route('assign_employee_book')}}" method="post">
                @csrf
<div class="col-md-4 col-12">
                <div class="mb-3">
                <label for="lname" class="form-label">Invoice Number</label>
                    <input
                      type="text"
                      class="form-control"
                      id="invqw"
                      name="invw"
                      value=""
                      placeholder=""
                      
                      
                      />
                      <span class="text-danger"></span>
                </div>
              </div>

<div class="col-md-4 col-12">
                <div class="mb-3">
                <label for="lname" class="form-label">Vehicle Number</label>
                    <input
                      type="text"
                      class="form-control"
                      id="vn"
                      name="vn"
                      value=""
                      placeholder=""
                      
                      
                      />
                      <span class="text-danger"></span>
                </div>
              </div>

          <div class="mb-1">

                <div class="col-11 ">
                  <label class="form-label " for="large-select">Choose Employee</label>
                  
                    <select class="select2-size-lg form-select" id="empdrop" name="empdrop">
                      
                      
                    </select>
                  

           <div class="form-check form-check-inline mb-1 mt-2">
    <label class="form-check-label" for="inlineCheckbox1">Upload the vehicle images</label>
    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" name="checkb[1]" value="upload_images" checked />
</div>
<div class="mt-1 md-2">
    <textarea class="form-control" id="taskDesc1" rows="2" name="taskDesc[1]" placeholder="Description for image upload"></textarea>
    <span id="textareaErrorMessage1" class="text-danger"></span>
</div>

<div class="form-check form-check-inline mb-1">
    <label class="form-check-label" for="inlineCheckbox2">Get the Mileage</label>
    <input class="form-check-input" type="checkbox" id="inlineCheckbox2" name="checkb[2]" value="get_mileage" />
</div>
<div class="mt-1 md-2">
    <textarea class="form-control" id="taskDesc2" rows="2" name="taskDesc[2]" placeholder="Description for mileage"></textarea>
    <span id="textareaErrorMessage2" class="text-danger"></span>
</div>

<div class="form-check form-check-inline mb-1">
    <label class="form-check-label" for="inlineCheckbox3">Ready the Vehicle</label>
    <input class="form-check-input" type="checkbox" id="inlineCheckbox3" name="checkb[3]" value="ready_vehicle" />
</div>
<div class="mt-1 md-2">
    <textarea class="form-control" id="taskDesc3" rows="2" name="taskDesc[3]" placeholder="Description for ready vehicle"></textarea>
    <span id="textareaErrorMessage3" class="text-danger"></span>
</div>


<div class="form-check form-check-inline mb-1">
    <label class="form-check-label" for="inlineCheckbox3">Get Gas Level</label>
    <input class="form-check-input" type="checkbox" id="inlineCheckbox4" name="checkb[4]" value="get_gas" />
</div>
<div class="mt-1 md-2">
    <textarea class="form-control" id="taskDesc4" rows="2" name="taskDesc[4]" placeholder="Description for gas level"></textarea>
    <span id="textareaErrorMessage4" class="text-danger"></span>
</div>

                <div class="mb-1 mt-2">
              <button type="submit" class="btn btn-primary" id="askValue">submit</button>
              <button type="submit" class="btn btn-primary">Clear</button>
              </div>
             </div>
           </div>
        </form>



      </div>
    </div>
  </div>
</div>
<!--/ Edit User Modal -->
@endsection --}}