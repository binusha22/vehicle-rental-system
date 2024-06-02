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



<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
{{-- <script>
    $(document).ready(function () {
        $(document).on("click", ".vehicle-row", function () {
            var name = $(this).data('name');
            var number = $(this).data('number');

            $("#vehicle_name").val(name);
            $("#vehicle_number").val(number);
        });
    });
</script> --}}
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
                    $("#vehicle_name").val(name);
                    $("#vehicle_number").val(number);
                    $("#vehicleModal").modal('hide');

                });
                }else{
                    
                    $("#vehicle_name").val(name);
                    $("#vehicle_number").val(number);
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

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function() {
        $(document).on("click", ".customer_row", function (){
            var name = $(this).data('name');
            var id = $(this).data('id');
            var pss = $(this).data('pss');
            var mobile = $(this).data('number');
            var cusid = $(this).data('cusid');  
            var cuswanumber = $(this).data('wa_number'); 

            $("#wa_number").val(cuswanumber);
            $("#customer_name").val(name);
             $("#cusid").val(cusid);
            $("#id_card").val(id);
            $("#passport").val(pss);
            $("#mobile").val(mobile);

            console.log(cusid);
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
{{-- substract deposit from total amount --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const depoExtend = document.getElementById('depoExtend');
        const totalExtend = document.getElementById('totalExtend');
        const rest_of_depo = document.getElementById('rest_of_depo');

        depoExtend.addEventListener('input', updateRestValue);
        totalExtend.addEventListener('input', updateRestValue);
        totalExtend.addEventListener('keydown', handleBackspace);

        function updateRestValue() {
            const deposit = parseFloat(depoExtend.value) || 0;
            const totalAmount = parseFloat(totalExtend.value) || 0;
            const restValue = deposit - totalAmount;
            rest_of_depo.value = restValue.toFixed(2); // Adjust this according to your formatting needs
        }

        function handleBackspace(event) {
            if (event.key === 'Backspace' && totalExtend.value === '') {
                rest_of_depo.value = ''; // Clear the rest_of_depo input field
            }
        }
    });
</script>


{{-- fetch extend bookinhs --}}
<script>
   
    $(document).ready(function () {
        // Event listener for clicking the "Assign Employee" link
        $(document).on('click', '.extend-booking-link', function () {
            var invoiceNumber = $(this).data('invbk'); // Get the invoice number from data-invbk attribute
            var end = $(this).data('end');
            var start = $(this).data('start');
            var vehi = $(this).data('vehic');
            var cusname = $(this).data('bookcus');
            var cusid = $(this).data('exid');
            var cuspas = $(this).data('expass');
            var ccc=$(this).data('cusid');

            $('#getCusid').val(ccc);
            $('#invExtend').val(invoiceNumber);
            // $('#extendEnddate').val(end);
            $('#vehinum').val(vehi);
            $('#extendStartdate').val(start);
            $('#bookCusname').val(cusname);
            $('#exid').val(cusid);
            $('#expass').val(cuspas);


            // Output data to console for debugging
            console.log("Invoice Number:", invoiceNumber);
            console.log("End Date:", end);
            console.log("Start Date:", start);
            console.log("Vehicle Number:", vehi);
            console.log("Customer Name:", cusname);
            console.log("Customer ID:", cusid);
            console.log("Customer Passport:", cuspas);



           $.ajax({
                    url: "{{ route('fetchDeposit') }}",
                    type: "GET",
                    data: { invoice: ccc },
                    success: function(response) {
                        if (response.success) {
                        console.log("Deposit:", response.deposit);
                        $('#depoExtend').val(response.deposit);
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
        });

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
            var tableBody = $('#bookingList');
            tableBody.empty(); // Clear existing rows

            $.each(data, function (index, item) {
                tableBody.append('<tr class="booking_row" data-invbk="' + item.invoice_number + '">' +
                    '<td>' + item.invoice_number + '</td>' +
                    '<td>' + item.customer_name + '</td>' +
                    '<td>' + item.cus_id + '</td>' +
                    '<td>' + item.cus_passport + '</td>' +
                    '<td>' + item.vehicle_name + '</td>' +
                    '<td>' + item.vehicle_number + '</td>' +
                    '<td>' + item.start_date + '</td>' +
                    '<td>' + item.end_date + '</td>' +
                    '<td>' + item.reg_date + '</td>' +
                    '<td>' + item.flight_number + '</td>' +
                    '<td>' + item.arrival_date + '</td>' +
                    '<td>' + item.landing_time + '</td>' +
                    '<td>' + item.advanced + '</td>' +
                    '<td>' + item.amount + '</td>' +
                    '<td>' + item.rest + '</td>' +
                    '<td>' + item.select_employee + '</td>' +
                    '<td>' + item.vehicle_pickup_location + '</td>' +
                    '<td>' +
                        '<div class="dropdown">' +
                            '<button type="button" class="btn btn-sm dropdown-toggle hide-arrow py-0" data-bs-toggle="dropdown">' +
                                'click' +
                            '</button>' +
                            '<div class="dropdown-menu dropdown-menu-end">' +
                                '<a class="dropdown-item extend-booking-link" href="#" data-bs-target="#extendBook" data-bs-toggle="modal" data-invbk="' + item.invoice_number + '" data-start="' + item.start_date + '" data-end="' + item.end_date + '" data-vehic="' + item.vehicle_number + '" data-bookcus="' + item.customer_name + '" data-exid="' + item.cus_id + '" data-expass="' + item.cus_passport + '" data-cusid="' + item.customer_id + '">' +
                                    '<i data-feather="edit-2" class="me-50"></i>' +
                                    '<span>Extend Booking</span>' +
                                '</a>' +
                                '<form action="/delete_booking/' + item.id + '" method="post" style="display: inline;">' +
                                    '@csrf' +
                                    '@method("DELETE")' +
                                    '<button type="submit" class="dropdown-item">' +
                                        '<i data-feather="trash" class="me-50"></i>' +
                                        '<span>Delete Booking</span>' +
                                    '</button>' +
                                '</form>' +
                            '</div>' +
                        '</div>' +
                    '</td>'+
                    '</tr>');
            });
        }

        function displayNoResultsMessage() {
            var tableBody = $('#bookingList');
            tableBody.empty();
            tableBody.append('<tr><td colspan="18">No bookings found for the selected criteria.</td></tr>');
        }

        function displayErrorMessage() {
            var tableBody = $('#bookingList');
            tableBody.empty();
            tableBody.append('<tr><td colspan="18">An error occurred while fetching bookings.</td></tr>');
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
    '<td>' + item.select_employee + '</td>' +
    '<td>' + item.vehicle_pickup_location + '</td>' +
    '<td>' +
    '<div class="dropdown">' +
    '<button type="button" class="btn btn-sm dropdown-toggle hide-arrow py-0" data-bs-toggle="dropdown">' +
    'click' +
    '</button>' +
    '<div class="dropdown-menu dropdown-menu-end">' +
    '<a class="dropdown-item" href="#" data-invbk="' + item.invoice_number + '" data-vn="' + item.vehicle_number + '" data-bs-target="#assignemp" data-bs-toggle="modal" id="fetchEmp">' +
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
<script>
    function printBill() {
        // Get the printable bill content
        var printableContent = document.getElementById('printableBill').innerHTML;

        // Create a new window for printing
        var printWindow = window.open('', '_blank');
        printWindow.document.open();

        // Write the printable content to the new window
        printWindow.document.write('<html><head><title>Print Bill</title>');
        printWindow.document.write('<style>@media print { body * { visibility: hidden; } #printableBill, #printableBill * { visibility: visible; } #printableBill { position: absolute; left: 0; top: 0; } }</style>');
        printWindow.document.write('</head><body>');
        printWindow.document.write(printableContent);
        printWindow.document.write('</body></html>');

        // Close the document and print
        printWindow.document.close();
        printWindow.print();
    }
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
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const checkbox = document.getElementById('useRestDepo');
        const restDepoDiv = document.getElementById('restDepoDiv');

        // Add event listener for checkbox change
        checkbox.addEventListener('change', function () {
            if (checkbox.checked) {
                restDepoDiv.style.display = 'block';
            } else {
                restDepoDiv.style.display = 'none';
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










<!-- Inputs Group with Buttons -->
<section id="input-group-buttons">
    <h3 class="titel">Vehicle Booking</h3>

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
      <div class="table-responsive" style="max-height: 300px;overflow-y: auto;">
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
      <div class="table-responsive" style="max-height:300px;overflow-y: auto;">
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





<section id="multiple-column-form">
  <div class="row mt-1 ">
    <div class="col-12">
      <div class="card">
         <div class="card-body">
          <form class="form" action="{{route('insert_booking_data')}}" method="post">
                

             @csrf
              
            <div class="row">
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

              <div class="col-md-2 col-6">
                <div class="mb-0" >
                <label for="lname" class="form-label">customer Id </label>
                    <input
                      type="text"
                      class="form-control"
                      id="cusid"
                      name="cusid"
                      value="{{old('cusid')}}"
                      readonly
                      
                      />
                      
                    <span class="text-danger">@error('cusid'){{$message}}@enderror</span>  
                </div>
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
                    placeholder="toyota camry"
                    
                    
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
                      value="{{old('mobile')}}"
                      placeholder=""
                      
                      
                      />
                      <span class="text-danger">@error('mobile'){{$message}}@enderror</span>
                </div>
              </div>

              <div class="col-md-4 col-12">
                <div class="mb-3">
                <label for="lname" class="form-label">Whatsapp Phone Number </label>
                    <input
                      type="text"
                      class="form-control"
                      id="wa_number"
                      name="wa_number"
                      value="{{old('wa_number')}}"
                      placeholder=""
                      
                      
                      />
                      <span class="text-danger">@error('wa_number'){{$message}}@enderror</span>
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
                      value="{{old('flight_number')}}"
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
                    id="arrival_date"
                    name="arrival_date"
                    value="{{old('arrival_date')}}"
                    class="form-control flatpickr-basic"
                    placeholder="YYYY-MM-DD"
                  />
                      <span class="text-danger">@error('arrival_date'){{$message}}@enderror</span>
                </div>
              </div>

              <div class="col-md-4 col-12">
                <div class="mb-3">
                <label for="lname" class="form-label">Time of Landing </label>
                    <input
                      type="text"
                      class="form-control"
                      id="landing_time"
                      name="landing_time"
                      value="{{old('landing_time')}}"
                      placeholder=""
                      
                      
                      />
                      <span class="text-danger">@error('landing_time'){{$message}}@enderror</span>
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
                <label for="lname" class="form-label">cost For Additional km(per 1km) </label>
                    <input
                      type="text"
                      class="form-control"
                      id="additonal_cost_km"
                      name="additonal_cost_km"
                      value="{{old('additonal_cost_km')}}"
                      placeholder=""
                      
                      
                      />
                      <span class="text-danger">@error('additonal_cost_km'){{$message}}@enderror</span>
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
                <label for="lname" class="form-label">deposit </label>
                    <input
                      type="text"
                      class="form-control"
                      id="deposit"
                      name="deposit"
                      value="{{ old('deposit', '0') }}"
                      placeholder=""
                      
                      
                      />
                      <span class="text-danger">@error('deposit'){{$message}}@enderror</span>
                </div>
              </div>

             

            <div class="col-12" style="text-align: center;">
                  
                  <button type="submit"class="btn btn-primary  w-30 mt-1"
                  >Submit</button>
            
         </div>



</div>


          </form>
        </div>
      </div>
    </div>
  </div>
</section>






 <!-- Edit Extend Modal -->
<div class="modal fade" id="extendBook" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
    <div class="modal-content">
      <div class="modal-header bg-transparent">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body pb-5 px-sm-5 pt-10">
        {{-- search booking --}}


  <div class="content-body mb-2 mt-2">
  <div class="col-12">
    <div class="card">
      Extend Your Booking
<div class="col-12 ">
    <div class="card">   
      
    </div>
  </div>
</div>
</div>
</div>
<form action="{{route('extend')}}" method="post">
                @csrf
                <input
                      type="hidden"
                      class="form-control"
                      id="bookCusname"
                      name="bookCusname"
                      
                      />
                      <input
                      type="hidden"
                      class="form-control"
                      id="exid"
                      name="exid"
                      
                      />
                      <input
                      type="hidden"
                      class="form-control"
                      id="expass"
                      name="expass"
                      
                      />
<div class="row">
    <div class="col-md-4 col-12">
                <div class="mb-3">
                <label for="lname" class="form-label">Vehicle Number </label>
                    <input
                      type="text"
                      class="form-control"
                      id="vehinum"
                      name="vehinum"
                      value=""
                      placeholder=""
                      
                      readonly
                      />
                       <span id="invErrorMessage" class="text-danger"></span>
                </div>
              </div>
<div class="col-md-4 col-12">
                <div class="mb-3">
                <label for="lname" class="form-label">Invoice Number </label>
                    <input
                      type="text"
                      class="form-control"
                      id="invExtend"
                      name="invExtend"
                      value=""
                      placeholder=""
                      
                      readonly
                      />
                       <span id="invErrorMessage" class="text-danger"></span>
                </div>
              </div>
              <div class="col-md-4 col-12">
                <div class="mb-3">
                <label for="lname" class="form-label">customer id </label>
                    <input
                      type="text"
                      class="form-control"
                      id="getCusid"
                      name="getCusid"
                      value=""
                      placeholder=""
                      
                      readonly
                      />
                       <span id="invErrorMessage" class="text-danger"></span>
                </div>
              </div>
<div class="col-md-4 col-12">
                <div class="mb-3">
                <label class="form-label" for="large-select">Start Date</label>
                <div class="input-group">
                    <input
                        type="text"
                        id="extendStartdate"
                        name="extendStartdate"
                        class="form-control flatpickr-basic"
                        placeholder="Search Date"
                    />
                </div>
            </div>
        </div>
<div class="col-md-4 col-12">
                <div class="mb-3">
                <label class="form-label" for="large-select">End Date</label>
                <div class="input-group">
                    <input
                        type="text"
                        id="extendEnddate"
                        name="extendEnddate"
                        class="form-control flatpickr-basic"
                        placeholder="Search Date"
                    />
                </div>
            </div>
        </div>
         <div class="col-md-4 col-12">
                <div class="mb-3">
                <label for="lname" class="form-label">Agreed Miledge</label>
                    <input
                      type="text"
                      class="form-control"
                      id="agromile"
                      name="agromile"
                      value=""
                      placeholder=""
                      
                      
                      />
                       <span id="invErrorMessage" class="text-danger"></span>
                </div>
              </div>
        <div class="col-md-4 col-12">
                <div class="mb-3">
                <label for="lname" class="form-label">Deposit Amount </label>
                    <input
                      type="text"
                      class="form-control"
                      id="depoExtend"
                      name="depoExtend"
                      value=""
                      placeholder=""
                      readonly
                      
                      />
                       <span id="invErrorMessage" class="text-danger"></span>
                </div>
              </div>
               
<div class="col-md-4 col-12">
                <div class="mb-3">
                <label for="lname" class="form-label">Trip Amount </label>
                    <input
                      type="text"
                      class="form-control"
                      id="totalExtend"
                      name="totalExtend"
                      value=""
                      placeholder=""
                      
                      
                      />
                       <span id="invErrorMessage" class="text-danger"></span>
                </div>
              </div>
              <div class="col-md-4 col-12" id="restDepoDiv" style="display: none;">
                <div class="mb-3">
                    <label for="lname" class="form-label">Rest of Deposit</label>
                    <input
                        type="text"
                        class="form-control"
                        id="rest_of_depo"
                        name="rest_of_depo"
                        value=""
                        placeholder=""
                        readonly
                    />
                    <span id="invErrorMessage" class="text-danger"></span>
                </div>
            </div>
              <div class="mb-1 form-check">
                <input type="checkbox" class="form-check-input" id="useRestDepo" name="useRestDepo">
                <label class="form-check-label" for="useRestDepo">Charge from deposit</label>
            </div>
</div>
<button type="submit" class="btn btn-primary" >submit</button>
        </form>



      </div>
    </div>
  </div>
</div>
<!--/ Edit extend Modal -->

    



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
      <div class="table-responsive" style="max-height: 1000px;overflow-y: auto;">
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
              
              <th>Select Employe</th>
              <th>Destination</th>
              <th>Action</th>
              
            </tr>
          </thead>
          <tbody id="bookingList" >
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
              <td>{{$bk->flight_number}}</td>
              <td>{{$bk->arrival_date}}</td>
              <td>{{$bk->landing_time}}</td>
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
                    <a  class="dropdown-item extend-booking-link" href="#" data-bs-target="#extendBook"
                            data-bs-toggle="modal" data-invbk="{{$bk->invoice_number}}" data-end="{{$bk->end_date}}"
                            data-start="{{$bk->start_date}}" data-vehic="{{$bk->vehicle_number}}"
                            data-bookcus="{{$bk->customer_name}}" data-exid="{{$bk->cus_id}}"
                            data-expass="{{$bk->cus_passport}}"
                            data-cusid="{{$bk->customer_id}}">
                            <i data-feather="edit-2" class="me-50"></i>
                            <span>Extend Booking</span>
                        </a>
                        <form action="{{ route('delete_booking', ['id' => $bk->id]) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="dropdown-item">
                                <i data-feather="trash" class="me-50"></i>
                                <span>Delete Booking</span>
                            </button>
                        </form>
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
      <div class="table-responsive" style="max-height: 1000px;overflow-y: auto;">
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
  

 <!-- Edit user  Modal -->
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