@extends('layouts.lay')
@section('title','Vehicle Owner Payment')
@section('style')
<style>
 .titel{Margin-bottom:40px}
</style>
<!-- Flatpickr Month Select Plugin CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/style.css">
@endsection
@section('script')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const rows = document.querySelectorAll('#ownerpay tr');
    rows.forEach(row => {
        row.addEventListener('click', function() {
            document.getElementById('owner_name').value = this.dataset.owner_name;
            document.getElementById('contact_number').value = this.dataset.phone_number;
            document.getElementById('vehicle_number').value = this.dataset.vnumber;
            document.getElementById('vehicle_name').value = this.dataset.vname;
            document.getElementById('agreed_miledge').value = this.dataset.agreed_miledge;
            document.getElementById('agreed_payment').value = this.dataset.agreed_payment;
            document.getElementById('previous_milage').value = this.dataset.previous_mile;
            document.getElementById('fees_for_liesence').value = this.dataset.liesence_renew_cost;
            document.getElementById('lrn_date').value = this.dataset.liesence_renew_date;
        });
    });
});
</script>

<!-- Flatpickr CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<!-- Flatpickr JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>



<!-- Flatpickr Month Select Plugin JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/index.js"></script>


<script>
  document.addEventListener('DOMContentLoaded', function() {
    flatpickr('#pre_date', {
        plugins: [
            new monthSelectPlugin({
                shorthand: true, // defaults to false
                dateFormat: "Y-m", // defaults to "F Y"
                altFormat: "F Y", // defaults to "F Y"
            })
        ]
    });
});

</script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    flatpickr('#renewed_date', {
        plugins: [
            new monthSelectPlugin({
                shorthand: true, // defaults to false
                dateFormat: "Y-m", // defaults to "F Y"
                altFormat: "F Y", // defaults to "F Y"
            })
        ]
    });
});

</script>
{{-- open popup when right click on rows --}}
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function () {
        // Attach event listener to the document for right-click on any '.payment' row
        $(document).on('contextmenu', '.ownerPayClass', function (event) {
            event.preventDefault();
            
            var vehicleNumber = $(this).data('vnumber');
            
            // var advancePayment = $(this).data('advance-payment');
            
            // $('#getTopay').val(rest);
            console.log("from click"+vehicleNumber);
            // Show the modal
            $('#edit-2').modal('show');
            fetchData(vehicleNumber);
        });

        function fetchData(number) {
            console.log("function  "+number);
            //Make AJAX request
            $.ajax({
                url: '{{ route('fetch-service-cost') }}',
                type: 'GET',
                data: {
                    inv: number,
                },
                success: function (response) {
                  
                  $('#fees_for_maintain').val(response.dataSumt);
                    // Handle the response and update the table
                    updateTable(response.data);
                    $('#totalMaintainCost').text(response.dataSumt);
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
            var tableBody = $('#popup_maintain_table tbody');
            tableBody.empty(); // Clear existing rows

            if (data.length === 0) {
                // Display a message if no data is found
                tableBody.append('<tr><td colspan="3">No data found for the selected criteria.</td></tr>');
            } else {
                // Populate the table with the fetched data
                data.forEach(function (item) {
                    var row = '<tr class="popup_maintain_class">' +
                        '<td>' + item.vnumber + '</td>' +
                        '<td>' + item.vname + '</td>' +
                        '<td>' + item.cost + '</td>' +
                        '</tr>';
                    tableBody.append(row);
                });
            }
        }
    });
</script>
{{-- calculations --}}
<script>
    $(document).ready(function() {
        // Function to calculate final amount
        function calculateFinalAmount() {
            // Get values from inputs
            var newMiledge = parseFloat($('#new_miledge').val()) || 0;
            var preMiledge = parseFloat($('#previous_milage').val()) || 0;
            var agreddmile = parseFloat($('#agreed_miledge').val()) || 0;

            var tripMile=newMiledge-preMiledge;
            var additionalMile=tripMile-agreddmile;

            $('#actual_milage').val(tripMile);
            $('#additonal_milage').val(additionalMile);
        }


//calculate total amount for owner
        function calcu(){
          var aggreePay = parseFloat($('#agreed_payment').val()) || 0;
          var adMile = parseFloat($('#additonal_milage').val()) || 0;
          var cost_for_admile = parseFloat($('#charge_for_additonal_per_1km').val()) || 0;

          var maintainFee = parseFloat($('#fees_for_maintain').val()) || 0;
          var liecenFee = parseFloat($('#fees_for_liesence').val()) || 0;

          var totalAdmile=cost_for_admile*adMile;
          var tOpay=totalAdmile+aggreePay;

var need_to_pay=tOpay-(maintainFee+liecenFee);
          $('#total_additional_cost').val(totalAdmile);
          $('#monthly_payment').val(need_to_pay);


        }
        // Attach event listener to #damage_fee and #additional_milage_cost2 inputs
        $('#charge_for_additonal_per_1km').on('input', calcu);
        $('#new_miledge').on('input', calculateFinalAmount);
        // Attach event listener to clear values when backspace is pressed
        $('#new_miledge').on('keydown', function(event) {
            // Check if the pressed key is backspace (key code 8)
            if (event.keyCode === 8) {
                $('#actual_milage').val('');
                $('#additonal_milage').val('');
            }
        });

        $('#charge_for_additonal_per_1km').on('keydown', function(event) {
            // Check if the pressed key is backspace (key code 8)
            if (event.keyCode === 8) {
                $('#monthly_payment').val('');
                $('#total_additional_cost').val('');
            }
        });
    });
</script>
<script>
    document.getElementById('resetButton').addEventListener('click', function() {
    // Clear all input fields
    document.getElementById('owner_name').value = '';
    document.getElementById('contact_number').value = '';
    document.getElementById('vehicle_number').value = '';
    document.getElementById('vehicle_name').value = '';
    document.getElementById('agreed_miledge').value = '';
    document.getElementById('agreed_payment').value = '';
    document.getElementById('previous_milage').value = '';
    document.getElementById('fees_for_maintain').value = '';
    document.getElementById('fees_for_liesence').value = '';
    document.getElementById('new_miledge').value = '';
    document.getElementById('actual_milage').value = '';
    document.getElementById('additonal_milage').value = '';
    document.getElementById('charge_for_additonal_per_1km').value = '';
    document.getElementById('total_additional_cost').value = '';
    document.getElementById('monthly_payment').value = '';
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

<h3 class="titel">Vehicle Owner Payment</h3>

<section id="input-group-buttons">
                 <form >
                  @csrf
          <div class="row">
            <div class="col-md-3 mb-1">
              <div class="input-group">
              <input
                    name="search"
                    id="search"
                    type="text"
                    class="form-control"
                    placeholder="Search Owner Name"
                    aria-describedby="button-addon2"
                    value=""
                />
              </div>
            </div>
            
            <div class="col-md-3 mb-1">
                <div class="input-group">
                    <input type="text" 
                           id="renewed_date" 
                           class="form-control flatpickr-basic" 
                           name="renewed_date" 
                           placeholder="search Payment date" />
                </div>
            </div>
            </div>
          </div>
          </form>
 </section>


 <div class="content-body"> 
      <!-- Bootstrap Validation -->
      <div class="row mt-1 mb-0"  id="basic-table">
  <div class="col-12">
    <div class="card">
    <div class="card-header">
          <h5 class="card-title">Vehicle Owner List</h5>
</div>   
       <div class="table-responsive" style="max-height: 500px;overflow-y: auto;">
        <table class="table table-hover" id="owner_pay_table">
    <thead>
        <tr>
            <th>Vehicle Number</th>
            <th>Vehicle Name</th>
            <th>Owner Name</th>
            <th>Contact Number</th>
            <th>Agreed Payment</th>
            <th>Agreed Mileage</th>
            <th>License Renew Cost</th>
            <th>License Renew Date</th>
            <th>Previous Mileage</th>
            <th>Additional Mileage</th>
            <th>Previous Payment Date</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody id="ownerpay">
        @forelse($paymentsThisMonth as $owner)
        <tr class="ownerPayClass" data-vnumber="{{$owner->vnumber}}"
            data-vname="{{$owner->vname}}"
            data-owner_name="{{$owner->owner_name}}"
            data-phone_number="{{$owner->phone_number}}"
            data-agreed_payment="{{$owner->agreed_payment}}"
            data-agreed_miledge="{{$owner->agreed_miledge}}"
            data-liesence_renew_cost="{{$owner->liesence_renew_cost}}"
            data-liesence_renew_date="{{$owner->liesence_renew_date}}"
            data-previous_mile="{{$owner->previous_mile}}"
            data-additional_mile="{{$owner->additional_mile}}"
            data-previous_pay_date="{{$owner->previous_pay_date}}">
            <td>{{$owner->vnumber}}</td>
            <td>{{$owner->vname}}</td>
            <td>{{$owner->owner_name}}</td>
            <td>{{$owner->phone_number}}</td>
            <td>{{$owner->agreed_payment}}</td>
            <td>{{$owner->agreed_miledge}}</td>
            <td>{{$owner->liesence_renew_cost}}</td>
            <td>{{$owner->liesence_renew_date}}</td>
            <td>{{$owner->previous_mile}}</td>
            <td>{{$owner->additional_mile}}</td>
            <td>{{$owner->previous_pay_date}}</td>
            <td>{{$owner->status}}</td>
        </tr>
        @empty
        <tr>
            <td colspan="11">No Data Found</td>
        </tr>
        @endforelse
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
          <form action="{{route('insetData')}}" method="post">
                @csrf 

<input type="hidden" id="lrn_date" class="d-none" placeholder="Mr/Ms" name="lrn_date" />
<input type="hidden" id="new_current_mile" class="d-none" placeholder="Mr/Ms" name="new_current_mile" />

            <div class="row">
              <div class="col-md-3 col-12">
    <div class="mb-1">
        <label class="form-label" for="owner_name">Owner Name</label>
        <input type="text" id="owner_name" class="form-control" placeholder="Mr/Ms" name="owner_name" readonly style="border: 1px solid ghostwhite;" />
    </div>
</div>

<div class="col-md-3 col-12">
    <div class="mb-1">
        <label class="form-label" for="contact_number">Contact Number</label>
        <input type="text" id="contact_number" class="form-control" placeholder="+94" name="contact_number" readonly style="border: 1px solid ghostwhite;" />
    </div>
</div>

<div class="col-md-3 col-12">
    <div class="mb-1">
        <label class="form-label" for="vehicle_number">Vehicle Number</label>
        <input type="text" id="vehicle_number" class="form-control" placeholder="" name="vehicle_number" readonly style="border: 1px solid ghostwhite;" />
    </div>
</div>

<div class="col-md-3 col-12">
    <div class="mb-1">
        <label class="form-label" for="vehicle_name">Vehicle Name</label>
        <input type="text" id="vehicle_name" class="form-control" placeholder="" name="vehicle_name" readonly style="border: 1px solid ghostwhite;" />
    </div>
</div>

<div class="col-md-3 col-12">
    <div class="mb-1">
        <label class="form-label" for="agreed_miledge">Agreed Mileage</label>
        <input type="text" id="agreed_miledge" class="form-control" placeholder="" name="agreed_miledge" readonly style="border: 1px solid ghostwhite;" />
    </div>
</div>

<div class="col-md-3 col-12">
    <div class="mb-1">
        <label class="form-label" for="agreed_payment">Agreed Payment</label>
        <input type="text" id="agreed_payment" class="form-control" placeholder="" name="agreed_payment" readonly style="border: 1px solid ghostwhite;" />
    </div>
</div>

<div class="col-md-3 col-12">
    <div class="mb-1">
        <label class="form-label" for="previous_milage">Previous Mileage</label>
        <input type="text" id="previous_milage" class="form-control" name="previous_milage" placeholder="Km" readonly style="border: 1px solid ghostwhite;" />
    </div>
</div>
              <div class="col-md-3 col-12">
                <div class="mb-1">
                  <label class="form-label" for="email-id-column">Fees for Maintain(LKR)</label>
                  <input
                    type="number"
                    id="fees_for_maintain"
                    class="form-control"
                    name="fees_for_maintain"
                    placeholder="Rs."
                    style="border: 1px solid ghostwhite;"
                  />
                </div>
              </div>
              <div class="col-md-3 col-12">
                <div class="mb-1">
                  <label class="form-label" for="email-id-column">Fees for lience(LKR)</label>
                  <input
                    type="number"
                    id="fees_for_liesence"
                    class="form-control"
                    name="fees_for_liesence"
                    placeholder="Rs."
                    style="border: 1px solid ghostwhite;"
                  />
                </div>
              </div>
              <div class="col-md-3 col-12">
                <div class="mb-1">
                  <label class="form-label" for="country-floating">Add New Milage</label>
                  <input
                    type="text"
                    id="new_miledge"
                    class="form-control"
                    name="new_miledge"
                    placeholder="Km"
                    style="border: 1px solid yellowgreen;"
                  />
                </div>
              </div>
              <div class="col-md-3 col-12">
                <div class="mb-1">
                  <label class="form-label" for="country-floating">Actual Milage</label>
                  <input
                    type="text"
                    id="actual_milage"
                    class="form-control"
                    name="actual_milage"
                    placeholder="Km"
                  />
                </div>
              </div>

              <div class="col-md-3 col-12">
                <div class="mb-1">
                  <label class="form-label" for="email-id-column">Additonal Milage</label>
                  <input
                    type="number"
                    id="additonal_milage"
                    class="form-control"
                    name="additonal_milage"
                    placeholder="Km"
                  />
                </div>
              </div>

              <div class="col-md-3 col-12">
                <div class="mb-1">
                  <label class="form-label" for="email-id-column">Charge For Additonal Per 1KM(LKR)</label>
                  <input
                    type="text"
                    id="charge_for_additonal_per_1km"
                    class="form-control"
                    name="charge_for_additonal_per_1km"
                    placeholder="Rs."
                  />
                </div>
              </div>
              <div class="col-md-3 col-12">
                <div class="mb-1">
                  <label class="form-label" for="email-id-column">additional miledge cost(LKR)</label>
                  <input
                    type="number"
                    id="total_additional_cost"
                    class="form-control"
                    name="total_additional_cost"
                    placeholder="Rs."
                  />
                </div>
              </div>

              
              <div class="col-md-3 col-12">
                <div class="mb-1">
                  <label class="form-label" for="email-id-column">Monthly Payment(LKR)</label>
                  <input
                    type="text"
                    id="monthly_payment"
                    class="form-control"
                    name="monthly_payment"
                    placeholder="Rs."
                  />
                </div>
              </div>

              

              
              <div class="col-12 mt-2">
                <button type="submit" class="btn btn-primary me-1">Submit</button>
                <button type="button" id="resetButton" class="btn btn-outline-secondary">Reset</button>

              </div>

            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>





<div class="content-body mt-5"> 

<section id="input-group-buttons">
                 <form >
                  @csrf
          <div class="row">
            <div class="col-md-3 mb-1">
              <div class="input-group">
              <input
                    name="search"
                    id="searchOwner"
                    type="text"
                    class="form-control"
                    placeholder="Search Owner Name"
                    aria-describedby="button-addon2"
                    value=""
                />
                
              </div>
            </div>
            
            <div class="col-md-3 mb-1 ">
              <div class="input-group">
              <input type="text" 
              id="pre_date" 
              class="form-control flatpickr-basic" 
              name="" 
              placeholder="search Payment date" 
              />
             
                </div>
              </div>
            </div>
          </div>
          </form>
 </section>


     <!-- Bootstrap Validation -->
     <div class="row mt-1 mb-0"  id="basic-table">
 <div class="col-12">
   <div class="card">
   <div class="card-header">
         <h5 class="card-title">Vehicle Owner Details</h5>
</div>   
      <div class="table-responsive" style="max-height: 1200px;overflow-y: auto;">
       <table class="table table-hover" id="pay_details_table">
         <thead>


           <tr>
             <th>Owner Name</th>
             <th>Contact Number</th>
             <th>Vehicle Number</th>
             <th>Previous Milage</th>
             <th>New Added Milage</th>
             <th>Additonal Milage</th>
             <th>Fees for Maintain</th>
             <th>Fees for Renew Liesence</th>
             <th>Previous Payment Date</th>
           </tr>
         </thead>
         

         <tbody id="pay_details">
            @forelse($paymentDetails as $pd)
           <tr>
             <td>{{$pd->owner_name}}</td>
             <td>{{$pd->phone_number}}</td>
             <td>{{$pd->vnumber}}</td>
             <td>{{$pd->previous_mile}}</td>
             <td>{{$pd->new_mile}}</td>
             <td>{{$pd->additional_mile}}</td>
             <td>{{$pd->maintain_cost}}</td>
             <td>{{$pd->liesence_renew_cost}}</td>
             <td>{{$pd->previous_pay_date}}</td>
             
             </tr>
             @empty
             <tr>
                 <td colspan="">No data found</td>
             </tr>
             @endforelse
          </tbody>

       </table>
     </div>
   </div>
   {{$paymentDetails->links('pagination.custom')}}
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
          <h2 class="mb-4" style="border-bottom: 1px solid #ccc; padding-bottom: 10px;">Maintain & Service Details <span style="font-size: 20px;color: yellowgreen;margin-left: 50px;">Total cost-Rs :- </span><span id="totalMaintainCost"></span></h2>
                  
          <div class="table-responsive">
       <table class="table table-hover" id="popup_maintain_table">
         <thead>


           <tr>
             <th>Vehicle Number</th>
             <th>Vehicle Name</th>
             <th>Maintain Cost</th>
            
           </tr>
         </thead>
         

         <tbody id="popup_maintain_body">
           <tr id="popup_maintain_class">
             <td></td>
             <td></td>
             <td></td>
             
             
          </tbody>

       </table>
     </div>

        </div>
      </div>
    </div>
  </div>
<!-- POP END  -->
 {{-- filter data in table --}}
 <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
  $(document).ready(function() {
    // Initialize Flatpickr with month and year only
    $('#renewed_date').change(function () {
        dateFormat: "Y-m", // Only show month and year
        
            // Trigger filter on date change
            filterPayments();
        
    });

    // Handle enter key press in the search input
    $('#search').on('keypress', function(e) {
        if (e.which === 13) { // Enter key
            filterPayments();
        }
    });

    function filterPayments() {
        var ownerName = $('#search').val();
        var paymentDate = $('#renewed_date').val();

        $.ajax({
            url: '{{ route('filter_payments') }}',
            method: 'GET',
            data: {
                owner_name: ownerName,
                payment_date: paymentDate
            },
            success: function(response) {
                // Clear the table body
                $('#ownerpay').empty();

                if (response.length > 0) {
                    // Populate the table with the filtered data
                    response.forEach(function(owner) {
                        $('#ownerpay').append(`
                            <tr data-vnumber="${owner.vnumber}"
                                data-vname="${owner.vname}"
                                data-owner_name="${owner.owner_name}"
                                data-phone_number="${owner.phone_number}"
                                data-agreed_payment="${owner.agreed_payment}"
                                data-agreed_miledge="${owner.agreed_miledge}"
                                data-liesence_renew_cost="${owner.liesence_renew_cost}"
                                data-liesence_renew_date="${owner.liesence_renew_date}"
                                data-previous_mile="${owner.previous_mile}"
                                data-additional_mile="${owner.additional_mile}"
                                data-previous_pay_date="${owner.previous_pay_date}">
                                <td>${owner.vnumber}</td>
                                <td>${owner.vname}</td>
                                <td>${owner.owner_name}</td>
                                <td>${owner.phone_number}</td>
                                <td>${owner.agreed_payment}</td>
                                <td>${owner.agreed_miledge}</td>
                                <td>${owner.liesence_renew_cost}</td>
                                <td>${owner.liesence_renew_date}</td>
                                <td>${owner.previous_mile}</td>
                                <td>${owner.additional_mile}</td>
                                <td>${owner.previous_pay_date}</td>
                                <td>${owner.status}</td>
                            </tr>
                        `);
                    });
                } else {
                    // Show no data found message
                    $('#ownerpay').append(`
                        <tr>
                            <td colspan="11">No Data Found</td>
                        </tr>
                    `);
                }

                // Re-attach the event listeners to the new rows
                attachRowClickEvents();
            },
            error: function(error) {
                console.error('Error fetching data:', error);
            }
        });
    }

    // Attach event listeners to table rows
    function attachRowClickEvents() {
        const rows = document.querySelectorAll('#ownerpay tr');
        rows.forEach(row => {
            row.addEventListener('click', function() {
                document.getElementById('owner_name').value = this.dataset.owner_name;
                document.getElementById('contact_number').value = this.dataset.phone_number;
                document.getElementById('vehicle_number').value = this.dataset.vnumber;
                document.getElementById('vehicle_name').value = this.dataset.vname;
                document.getElementById('agreed_miledge').value = this.dataset.agreed_miledge;
                document.getElementById('agreed_payment').value = this.dataset.agreed_payment;
                document.getElementById('previous_milage').value = this.dataset.previous_mile;
                document.getElementById('fees_for_liesence').value = this.dataset.liesence_renew_cost;
                document.getElementById('lrn_date').value = this.dataset.liesence_renew_date;
            });

        row.addEventListener('contextmenu', function(event) {
                event.preventDefault(); // Prevent the default context menu
                var vehicleNumber = $(this).data('vnumber');
                // Populate the modal with data from the clicked row
                // $('#modal-owner-name').text(this.dataset.owner_name);
                // $('#modal-contact-number').text(this.dataset.phone_number);
                // $('#modal-vehicle-number').text(this.dataset.vnumber);
                
                // Show the modal
                $('#edit-2').modal('show');
                


//make ajax request to fetch data
                $.ajax({
                url: '{{ route('fetch-service-cost') }}',
                type: 'GET',
                data: {
                    inv: vehicleNumber,
                },
                success: function (response) {
                  $('#fees_for_maintain').val(response.dataSumt);
                    // Handle the response and update the table
                    updateTable(response.data);
                    $('#totalMaintainCost').text(response.dataSumt);
                },
                error: function (xhr, status, error) {
                    // Log the error to the console
                    console.log("Error:", error);

                    // Display the error message on the webpage
                    $('#error-message').text("An error occurred: " + error);
                }
            });
                function updateTable(data) {
            // Update the table with the fetched data
            var tableBody = $('#popup_maintain_table tbody');
            tableBody.empty(); // Clear existing rows

            if (data.length === 0) {
                // Display a message if no data is found
                tableBody.append('<tr><td colspan="3">No data found for the selected criteria.</td></tr>');
            } else {
                // Populate the table with the fetched data
                data.forEach(function (item) {
                    var row = '<tr class="popup_maintain_class">' +
                        '<td>' + item.vnumber + '</td>' +
                        '<td>' + item.vname + '</td>' +
                        '<td>' + item.cost + '</td>' +
                        '</tr>';
                    tableBody.append(row);
                });
            }
        }
            });
        });
    }

    // Initial attachment of row click events
    attachRowClickEvents();


  });
</script>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function() {
  // Initialize Flatpickr
  $('#pre_date').change(function () {
    dateFormat: "Y-m",
    
      filterPayments();
    
  });

  // Handle enter key press in the search input
  $('#searchOwner').on('keypress', function(e) {
    if (e.which === 13) { // Enter key
      filterPayments();
    }
  });

  function filterPayments() {
    var ownerName = $('#searchOwner').val();
    var paymentDate = $('#pre_date').val();

    $.ajax({
      url: '{{ route('filterservicedetails') }}',
      method: 'GET',
      data: {
        owner_name: ownerName,
        previous_pay_date: paymentDate
      },
      success: function(response) {
        // Clear the table body
        $('#pay_details').empty();

        if (response.data.length > 0) {
          // Populate the table with the filtered data
          response.data.forEach(function(pd) {
            $('#pay_details').append(`
              <tr>
                <td>${pd.owner_name}</td>
                <td>${pd.phone_number}</td>
                <td>${pd.vnumber}</td>
                <td>${pd.previous_mile}</td>
                <td>${pd.new_mile}</td>
                <td>${pd.additional_mile}</td>
                <td>${pd.maintain_cost}</td>
                <td>${pd.license_renew_cost}</td>
                <td>${pd.previous_pay_date}</td>
              </tr>
            `);
          });
        } else {
          // Show no data found message
          $('#pay_details').append(`
            <tr>
              <td colspan="9">No data found</td>
            </tr>
          `);
        }
      },
      error: function(error) {
        console.error('Error fetching data:', error);
      }
    });
  }
});

</script>
@endsection