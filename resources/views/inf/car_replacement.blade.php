@extends('layouts.lay')
@section('title','Vehicle replacement')
@section('script')
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
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
<script>
    document.addEventListener('DOMContentLoaded', function () {
    const brandSelect = document.getElementById('brand');
    const modelSelect = document.getElementById('model');
    const vehicleNameInput = document.getElementById('vehicle_name_5');
    const vcat=document.getElementById('vcat');

    

    brandSelect.addEventListener('change', function () {
        const selectedBrandId = this.value;
        const vehicat=vcat.value;
        if (selectedBrandId) {
            // Enable the model dropdown
            modelSelect.disabled = false;
            // Clear existing options in the model dropdown
            modelSelect.innerHTML = "";

            // Append "Select Model" option
            const selectModelOption = document.createElement('option');
            selectModelOption.value = "";
            selectModelOption.text = "Select";
            modelSelect.appendChild(selectModelOption);

            // Make an AJAX request to fetch models based on the selected brand
            fetch(`/get_models_booking/${selectedBrandId}/${vehicat}`)
                .then(response => response.json())
                .then(models => {
                    // Populate the model dropdown with fetched data
                    models.forEach(model => {
                        
                        const option = document.createElement('option');
                        option.value = model.model;
                        option.text = model.model;
                        modelSelect.add(option);
                    });
                    // Update the vehicle name input when brand or model changes
                    updateVehicleName();
                })
                .catch(error => console.error('Error fetching models:', error));
        } else {
            // If no brand is selected, disable the model dropdown
            modelSelect.disabled = true;
            // Clear the model dropdown options
            modelSelect.innerHTML = "";
            // Clear the vehicle name input
            vehicleNameInput.value = '';
        }
    });

    
});

</script>

<!-- Your existing HTML code -->

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function () {
    // Attach event listener to the vehicle model dropdown
    $('#model').change(function() {
        // Get the selected brand and model
        var brand = $('#brand').val();
        var model = $(this).val();

        // Check if both brand and model are selected
        if (brand && model) {
            // Make an AJAX request to fetch data from the VehicleRegister model
            $.ajax({
                url: '/fetchDataFromVehicleRegister', // Update the URL to your route
                type: 'GET',
                data: {
                    brand: brand,
                    model: model
                },
                success: function (response) {
                    // Update the UI with fetched data
                    updateUI(response);
                },
                error: function (error) {
                    console.log(error);
                }
            });
        }
    });

    // Function to update the UI with fetched data
    function updateUI(data) {
        // Clear previous data from the table
        $('#vehicle_table tbody').empty();

        // Append column headings
        var tableHeadings = '<tr><th>vehicle name</th><th>Number</th></tr>';
        $('#vehicle_table thead').html(tableHeadings);

        // Append data rows
        data.forEach(function (item) {
            var rowData = '<tr class="vehicle-row" data-name="' + item.brand + ' ' + item.model + '" data-number="' + item.vehicle_number + '"><td>' + item.brand + ' ' + item.model + '</td><td>' + item.vehicle_number + '</td></tr>';
            $('#vehicle_table tbody').append(rowData);
        });
    }
});

</script>

<script>
    $(document).ready(function () {
        $('#end_date').change(function () {
            var brand = $('#brand').val();
            var model = $('#model').val();
            var start_date = $('#start_date').val();
            var end_date = $('#end_date').val();
            var vcat = $('#vcat').val(); // Get the vcat value

            $.ajax({
                type: "GET",
                url: "{{ route('getAvailableVehicle') }}",
                data: {
                    brand: brand,
                    model: model,
                    start_date: start_date,
                    end_date: end_date,
                    vcat: vcat // Include vcat in the request
                },
                success: function (response) {
                    console.log(response);
                    updateUI(response);
                },
                error: function (error) {
                    console.log(error);
                }
            });
        });

        function updateUI(data) {
            // Clear previous data from the table
            $('#vehicle_table tbody').empty();

            // Append column headings
            var tableHeadings = '<tr><th>Vehicle Name</th><th>Number</th></tr>';
            $('#vehicle_table thead').html(tableHeadings);

            // Append data rows
            data.forEach(function (item) {
                var rowData = '<tr class="vehicle-row" data-name="' + item.brand + ' ' + item.model + '" data-number="' + item.vehicle_number + '"><td>' + item.brand + ' ' + item.model + '</td><td>' + item.vehicle_number + '</td></tr>';
                $('#vehicle_table tbody').append(rowData);
            });
        }
    });
</script>
{{-- get replacement data to inputs --}}
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function () {
        // Delegate the click event to the tbody element
        $(document).on("click", ".customer_row", function () {
            try {
                
                var cn = $(this).data('name');
                var cid = $(this).data('id');
                var cp = $(this).data('pss');
                var mb = $(this).data('number');
                var cuid=$(this).data('cusid');
               
                $("#Customer_Name").val(cn);
                $("#Id_Number").val(cid);
                $("#Passport_Number").val(cp);
                $('#Phone_Number').val(mb);
                $('#cusid').val(cuid);
                console.log("customer id:",cuid);
                
                

                // Make AJAX request to fetch deposit data
                $.ajax({
                    url: "{{ route('fetchDataInReplace') }}",
                    type: "GET",
                    data: { id: cuid},
                    success: function(response) {
                        if (response.success) {
                            console.log("diposit:", response.dipo);
                            $('#Deposit').val(response.dipo);
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

{{-- get new vehicle data to inputs --}}
{{-- <script>
    $(document).ready(function () {
        // Delegate the click event to the tbody element
        $(document).on("click", ".vehicle-row", function () {
            try {
                
                var vn = $(this).data('number');
            
                var vname = $(this).data('name');
               
                
                

                // Set input field values
                
                $("#Replaced_Vehicle_Number").val(vn);
                
                $("#Replaced_Vehicle_Model").val(vname);
                
                

                
                

            } catch (error) {
                console.error("Error occurred:", error);
            }
        });
    });
</script> --}}

{{-- calculate rest --}}
<script>
    $(document).ready(function() {
    // Function to calculate rest of deposit
    function calculateRestDeposit() {
        var tripAmount = parseFloat($('#Amount').val()) || 0;
        var deposit = parseFloat($('#Deposit').val()) || 0;
        var restDeposit = deposit - tripAmount;
        $('#RestDepo').val(restDeposit.toFixed(2));
    }

    // Calculate rest deposit on trip amount change
    $('#Amount').on('input', function() {
        calculateRestDeposit();
    });

    // Clear rest deposit when trip amount is cleared
    $('#Amount').on('keyup', function(e) {
        if (e.keyCode === 8 || e.keyCode === 46) { // Backspace or Delete key
            $('#RestDepo').val('');
        }
    });
});

</script>
{{-- seacrh replace --}}
<script>
$(document).ready(function () {
    // Attach event listener to the search button
    $('#button-addon2').click(filterBooking);

    // Attach event listener to input fields for Enter key press
    $('#searchReplace').on('keypress', function (event) {
        if (event.which === 13) {
            filterBooking(event);
        }
    });

    function filterBooking(event) {
        // Prevent default form submission behavior
        if (event) {
            event.preventDefault();
        }

        var search_all = $('#searchReplace').val();

        // Make AJAX request
        $.ajax({
            url: '{{ route('car-replace.search') }}',
            type: 'GET',
            data: {
                searchReplace: search_all
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
        var tableBody = $('#replcaeOldbook');
        tableBody.empty(); // Clear existing rows

        $.each(data, function (index, item) {
            tableBody.append('<tr class="replaceTable" data-invoice="' + item.invoice + '" ' +
                'data-vehicle-number="' + item.vehicle_number + '" ' +
                'data-customer-name="' + item.customer_name + '" ' +
                'data-customer-id="' + item.id_number + '" ' +
                'data-passport="' + item.passport + '" ' +
                'data-vname="' + item.vehicle_name + '">' +
                '<td>' + item.invoice + '</td>' +
                '<td>' + item.customer_name + '</td>' +
                '<td>' + item.id_number + '</td>' +
                '<td>' + item.passport + '</td>' +
                '<td>' + item.deposit + '</td>' +
                '<td>' + item.vehicle_name + '</td>' +
                '<td>' + item.vehicle_number + '</td>' +
                '</tr>');
        });
    }

    function displayNoResultsMessage() {
        var tableBody = $('#replcaeOldbook');
        tableBody.empty();
        tableBody.append('<tr><td colspan="7">No replacement data found</td></tr>');
    }

    function displayErrorMessage() {
        var tableBody = $('#replcaeOldbook');
        tableBody.empty();
        tableBody.append('<tr><td colspan="7">An error occurred while fetching bookings.</td></tr>');
    }
});
</script>

{{-- search customer --}}
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
                    tableBody.append('<tr class="customer_row" data-name="' + item.fname + ' ' + item.lname + '" data-id="' + item.idnumber + '" data-cusid="' + item.id + '" data-wa_number="' + item. whatsappnumber + '" data-pss="' + item.passportnumber + '" data-number="' + item.phonenumber + '">' +
                        '<td>'+item.id+'</td>'+
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
<script>
    $(document).ready(function () {
        $('#vcat').change(function () {
            var selectedVcat = $(this).val();

            // Disable brand dropdown initially
            $('#brand').prop('disabled', true);

            // Clear existing options in the brand dropdown
            $('#brand').empty().append('<option value="">Select</option>');

            if (selectedVcat) {
                // Make an AJAX request to fetch brands based on the selected vcat
                $.ajax({
                    type: "GET",
                    data:{
                        cat:selectedVcat
                    },
                    url: "{{ route('loadBrandInFrom') }}",
                    success: function (response) {
                        if (response.length > 0) {
                            // Populate the brand dropdown with fetched data
                            response.forEach(function (brand) {
                                $('#brand').append('<option value="' + brand.brand + '">' + brand.brand + '</option>');
                            });
                            // Enable the brand dropdown
                            $('#brand').prop('disabled', false);
                        } else {
                            // If no brands are available, disable the brand dropdown
                            $('#brand').prop('disabled', true);
                        }
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
            }
        });
    });
</script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function () {
    $(document).on("click", ".vehicle-row", function () {
        var name = $(this).data('name');
        var number = $(this).data('number');
//     // Close the modal
 $("#vehicleModal").modal('hide');
        // Make an AJAX request to get the vehicle status Yard in
        $.ajax({
            url: '{{route('vehicle_dash_status')}}',
            type: 'GET',
            data:{
                number:number
            },
            success: function(response) {
                // Show the status in the console
                //console.log("Vehicle Status: " + response);
                if (response !== "Yard in") {
                    // Show the modal
                    $("#vehicleModal").modal('show');
                    
                    // Display the vehicle status in the modal
                    $("#vehicleStatus").text(response);

                    //Handle the OK button click
                $("#modalOkButton").off('click').on('click', function () {
                    $("#Replaced_Vehicle_Model").val(name);
                    $("#Replaced_Vehicle_Number").val(number);
                    $("#vehicleModal").modal('hide');

                });
                }else{
                    
                    $("#Replaced_Vehicle_Model").val(name);
                    $("#Replaced_Vehicle_Number").val(number);
                }
                
                $("#clButton").off('click').on('click', function () {
                    
                    $("#vehicleModal").modal('hide');

                });
                $("#clButtoncancel").off('click').on('click', function () {
                    
                    $("#vehicleModal").modal('hide');

                });
                
            },
            error: function(xhr, status, error) {
                    console.error("Error: " + xhr.responseText);
                    console.log("Vehicle status could not be retrieved.");
                }
        });
    });
});

</script>

@endsection
@section('style')
<style>
 .titel{Margin-bottom:40px}
</style>
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

<!-- Modal -->
<div id="vehicleModal" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Confirm Vehicle Selection</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="clButton">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to select this vehicle?</p>
        <p>Because the vehicle is in <b><span id="vehicleStatus"></span></b> now.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="modalOkButton">OK</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="clButtoncancel">Cancel</button>
      </div>
    </div>
  </div>
</div>




<h2 class="titel">Vehicle replacement</h2>

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
                <th>customer id</th>
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
            data-cusid="{{$cs->id}}"
            data-pss="{{$cs->passportnumber}}"
            data-number="{{$cs->phonenumber}}"
            data-wa_number="{{$cs->whatsappnumber}}">

            <td>{{$cs->id}}</td>
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



<section id="input-group-buttons">
    

    <form action="" method="get">
        <div class="row">
            <div class="col-md-2 mb-1  ">
                <label class="form-label" for="large-select">Vehicle Category</label>
                <div class="input-group">
                    <select class="select2-size-lg form-select" id="vcat" name="vcat">
                        <option value="">Select</option>
                        @foreach($vcat as $vt)
                        <option value="{{$vt->vcat}}">{{$vt->vcat}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-2 mb-1  ">
                <label class="form-label" for="large-select">Vehicle Brand</label>
                <div class="input-group">
                    <select class="select2-size-lg form-select" id="brand" name="brand" disabled>
                        <option value="">Select</option>
                    </select>
                </div>
            </div>
            <div class="col-md-2 mb-1 ">
                <label class="form-label" for="large-select">Vehicle Model</label>
                <div class="input-group">
                    <select class="select2-size-lg form-select" id="model" name="model" disabled>
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
            <tr><th>vehicle name</th><th>Number</th></tr>
          </thead>
          <tbody>
            @foreach($setVehicle as $set)
            <tr colspan="2" class="vehicle-row" data-name="{{$set->brand}} {{$set->model}}"
             data-number="{{$set->vehicle_number}}">
                <td>{{$set->brand}} {{$set->model}}</td>
                <td>{{$set->vehicle_number}}</td>
                
            </tr>
            @endforeach
            </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
</div>



<!-- methana alutin tex box tikak add una e tika details waguwatat add wenawa  -->

<section id="multiple-column-form">
  <div class="row mt-1">
    <div class="col-12">
      <div class="card">
         <div class="card-body">
          <form class="form" action="{{route('insert_new_booking')}}" method="post">
                     
             @csrf
             
            <div class="row">
            <div class="col-md-3 col-12">
                <div class="mb-1">
                <label for="lname" class="form-label">New Invoice Number</label>
                    <input
                      type="text"
                      class="form-control"
                      id="New_Invoice"
                      name="New_Invoice"
                      value="{{old('New_Invoice')}}"
                      placeholder="Mr.Perera"
                      
                     
                      />
                      <span class="text-danger"></span>
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
                      value="{{old('cusid')}}"
                      placeholder=""
                      
                     
                      />
                      <span class="text-danger"></span>
                </div>
              </div>

              <div class="col-md-3 col-12">
                <div class="mb-1">
                <label for="lname" class="form-label">Customer Name </label>
                    <input
                      type="text"
                      class="form-control"
                      id="Customer_Name"
                      name="Customer_Name"
                      value="{{old('Customer_Name')}}"
                      placeholder="Mr.Perera"
                      
                      
                      />
                      <span class="text-danger"></span>
                </div>
              </div>

              <div class="col-md-3 col-12">
                <div class="mb-1">
                <label for="lname" class="form-label">Phone Number</label>
                    <input
                      type="text"
                      class="form-control"
                      id="Phone_Number"
                      name="Phone_Number"
                      value="{{old('Phone_Number')}}"
                      placeholder="Mr.Perera"
                      
                      
                      />
                      <span class="text-danger"></span>
                </div>
              </div>


              <div class="col-md-3 col-12">
                <div class="mb-1">
                <label for="email" class="form-label">Id Number</label>
            <input
              type="text"
              class="form-control"
              id="Id_Number"
              name="Id_Number"
              value="{{old('Id_Number')}}"
              placeholder="970551536V"
              aria-describedby="login-email"
              
            />
            <span class="text-danger"></span>
                </div>
              </div>
<div class="col-md-3 col-12">
                <div class="mb-1">
                <label for="email" class="form-label">Passport Number</label>
            <input
              type="text"
              class="form-control"
              id="Passport_Number"
              name="Passport_Number"
              value="{{old('Passport_Number')}}"
              placeholder="970551536V"
              aria-describedby="login-email"
              
            />
            <span class="text-danger"></span>
                </div>
              </div>

              
              <div class="col-md-3 col-12">
                <div class="mb-1">
                <label for="lname" class="form-label">Reason for Replacement</label>
                    <input
                      type="text"
                      class="form-control"
                      id="Reason"
                      name="Reason"
                      value="{{old('Reason')}}"
                      placeholder="Reason"
                      
                      
                      />
                      <span class="text-danger"></span>
                </div>
              </div>

              
              <div class="col-md-3 col-12">
                <div class="mb-1">
                <label for="lname" class="form-label">Replaced Vehicle Model</label>
                    <input
                      type="text"
                      class="form-control"
                      id="Replaced_Vehicle_Model"
                      name="Replaced_Vehicle_Model"
                      value="{{old('Replaced_Vehicle_Model')}}"
                      placeholder="Replaced Vehicle Model"
                      
                     
                      />
                      <span class="text-danger"></span>
                </div>
              </div>


              <div class="col-md-3 col-12">
                <div class="mb-1">
                <label for="lname" class="form-label">Replaced Vehicle Number</label>
                    <input
                      type="text"
                      class="form-control"
                      id="Replaced_Vehicle_Number"
                      name="Replaced_Vehicle_Number"
                      value="{{old('Replaced_Vehicle_Number')}}"
                      placeholder="Replaced Vehicle Number"
                      
                      
                      />
                      <span class="text-danger"></span>
                </div>
              </div>

              
              <div class="col-md-3 col-12">
                <div class="mb-1 ">
                <label class="form-label" for="fp-range">Start date</label>
                  <input
                    type="text"
                    id="Start_date"
                    name="Start_date"
                    value="{{old('Start_date')}}"
                    class="form-control flatpickr-basic"
                    placeholder="YYYY-MM-DD"
                    
                  />
                </div>
                </div>

                

              <div class="col-md-3 col-12">
                <div class="mb-1">
                <label class="form-label" for="fp-range">End date</label>
                  <input
                    type="text"
                    id="End_date"
                    name="End_date"
                    value="{{old('End_date')}}"
                    class="form-control flatpickr-basic"
                    placeholder="YYYY-MM-DD"
                  />
                </div>
                </div>


                <div class="col-md-3 col-12">
                <div class="mb-1">
                <label for="lname" class="form-label">Trip Amount</label>
                    <input
                      type="text"
                      class="form-control"
                      id="Amount"
                      name="Amount"
                      value="{{old('Amount')}}"
                      placeholder="Trip Amount"
                      
                      
                      />
                      <span class="text-danger"></span>
                </div>
              </div>

              <div class="col-md-3 col-12">
                <div class="mb-1">
                <label for="lname" class="form-label">Additional Milage per 1KM</label>
                    <input
                      type="text"
                      class="form-control"
                      id="Milage_per_km"
                      name="Milage_per_km"
                      value="{{old('Milage_per_km')}}"
                      placeholder="Additional Milage per 1KM"
                      
                      
                      />
                      <span class="text-danger"></span>
                </div>
              </div>
              <div class="col-md-3 col-12">
                <div class="mb-1">
                <label for="lname" class="form-label">Aggred Milage</label>
                    <input
                      type="text"
                      class="form-control"
                      id="aggreMilage"
                      name="aggreMilage"
                      value="{{old('aggreMilage')}}"
                      placeholder="Additional Milage per 1KM"
                      
                      
                      />
                      <span class="text-danger"></span>
                </div>
              </div>

              <div class="col-md-3 col-12">
                <div class="mb-1">
                <label for="lname" class="form-label">Deposit(LKR)</label>
                    <input
                      type="text"
                      class="form-control"
                      id="Deposit"
                      name="Deposit"
                      value="{{old('Deposit')}}"
                      placeholder="Rs."
                      
                      
                      />
                      <span class="text-danger"></span>
                </div>
              </div>

              <div class="col-md-3 col-12">
                <div class="mb-1">
                <label for="lname" class="d-none">Rest of Deposit</label>
                    <input
                      type="text"
                      class="d-none"
                      id="RestDepo"
                      name="RestDepo"
                      value="{{old('RestDepo')}}"
                      placeholder="Rs."
                      
                      
                      />
                      <span class="text-danger"></span>
                </div>
              </div>

                <div class="col-12" style="text-align: center;">
                  <button class="btn btn-primary " tabindex="4">Submit</button>
                  
                </div>

            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

  
<!-- methanata assing employee table ekai popup ekai add kala -->

<section id="input-group-buttons mb-1">
            <div class="row">
                <div class="col-md-3 mb-0 mt-0">
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
      

<div class="col-12 mt-1">
    <div class="card">
      <div class="card-header">
        <h4>Assign Employee</h4>
      </div>
      <div class="card-body">
        
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
              <th>Start Date </th>
              <th>End Date </th>
              <th>Select Employe</th>
              <th>Assign Employee</th>
            </tr>
          </thead>
          <tbody id="bookingListsecond">
            @forelse($assignEmp as $as)
            <tr >
              <td>{{$as->invoice_number}}</td>
              <td>{{$as->customer_name}}</td>
              <td>{{$as->cus_id}}</td>
              <td>{{$as->cus_passport}}</td>
              <td>{{$as->vehicle_name}}</td>
              <td>{{$as->vehicle_number}}</td>
              <td>{{$as->start_date}}</td>
              <td>{{$as->end_date}}</td>
              <td>{{$as->select_employee}}</td>
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
                        data-invbk="{{$as->invoice_number}}"
                        data-vn="{{$as->vehicle_number}}"
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
            <td colspan="9">No booking found  <a href="#" > <b><span style="color:red;">Refresh
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
</div>
</div>
</div>


<div class="mt-5">
<h5>Replaced Vehicles Details</h5>

                 
          <div class="row">
            <div class="col-md-3 mb-0 ">
              <div class="input-group">
                <input
                  type="text"
                  class="form-control"
                  placeholder="Search Vehicles Number"
                  aria-describedby="button-addon2"
                />
                <span class="input-group-text"><i data-feather="search" type="submit"></i></span>
                </button>
              </div>
            </div>
            </div>
            
            
  
<div class="content-body">
      <div class="row mt-1 mb-2"  id="basic-table">
  <div class="col-14">
    <div class="card">   
      <div class="table-responsive">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>New Invoice Number</th>
              <th>Old Invoice Number</th>
              <th>Customer Name </th>
              <th>Id Number</th>
              <th>Passport Number</th>
              <th>Booking Date</th>
              <th>Start Date</th>
              <th>End Date</th>
              <th>Old Vehicle Number </th>
              <th>New Vehicle Number </th>
              <th>Trip Amount</th>
              <th>Additional Milage per 1KM</th>
              <th>Rest of Deposit</th>
            </tr>
          </thead>
          <tbody>
            @forelse($details as $de)
            <tr>
              <td>{{$de->new_inv}}</td>
              <td>{{$de->old_inv}}</td>
              <td>{{$de->cus_name}}</td>
              <td>{{$de->cus_id}}</td>
              <td>{{$de->passport}}</td>
              <td>{{$de->reg_date}}</td>
              <td>{{$de->s_date}}</td>
              <td>{{$de->e_date}}</td>
              <td>{{$de->old_v_number}}</td>
              <td>{{$de->new_v_number}}</td>
              <td>{{$de->trip_amount}}</td>
              <td>{{$de->additional_cost_km}}</td>
              <td>{{$de->rest_of_deposit}}</td>
            </tr>
            @empty
            <tr>
            <td colspan="9">sorry, this area is still under development <a href="#" > <b><span style="color:red;">
            </span></b></a></td>
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


@endsection