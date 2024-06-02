@extends('layouts.lay')
@section('title','Trip Details')
@section('style')
<style>
 .titel{Margin-bottom:40px}
 .custom-image {
    width: 100%; /* Set the width to 100% to make the image fill the modal */
    height: auto; /* Automatically adjust the height to maintain aspect ratio */

    .setHeight{
        max-height: 300px;
    }




</style>
@endsection
@section('script')
<script>
    window.addEventListener('DOMContentLoaded', (event) => {
        // Clear input fields after page load
        document.getElementById('invoiceNumber').value = '';
        document.getElementById('vehicleNumber').value = '';
        document.getElementById('searchDate').value = '';
    });
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Add click event listener to table rows
        $('#basic-table tbody').on('click', 'tr', function() {
            // Clear previous images
            $('.img-fluid').attr('src', '');
            $('.image-message').hide(); // Hide previous image messages

            // Extract data from the clicked row
            var invoiceNumber = $(this).data('inv');
            var vehicleName = $(this).data('vehicle-name');
            var vehicleNumber = $(this).data('vehicle-number');
            var vehiclePhoto = $(this).data('vehicle-photo'); // Assuming this contains image URLs
            var startMileage = $(this).data('start-mileage');
            var fuelLevel = $(this).data('fuel-level');

            // Populate form fields with extracted data
            $('#inv').val(invoiceNumber);
            $('#vname').val(vehicleName);
            $('#vnumber').val(vehicleNumber);
            $('#smiledge').val(startMileage);
            $('#gas_level').val(fuelLevel);

            // Display images if available
            if (vehiclePhoto) {
                var imageUrls = vehiclePhoto.split(','); // Split image URLs if there are multiple
                console.log("Image URLs: " + imageUrls);
                for (var i = 0; i < imageUrls.length; i++) {
                    var imageUrl = 'storage/' + imageUrls[i]; // Prepend 'storage/' to image URL
                    $('#image' + (i + 1)).attr('src', imageUrl); // Set the src attribute of the image element
                    $('#image' + (i + 1)).closest('.image-container').find('.image-message').hide(); // Hide the image message
                }
            } else {
                // If no image URLs are available, hide the image containers and display the message
                $('.image-container').hide();
                $('.image-message').show();
            }
        });
    });
</script>


<script>
 function openPopup(imageUrl) {
    // Set the src attribute of the popup image
    document.getElementById('popupImage').src = imageUrl;

    // Open the Bootstrap modal
    $('#imageModal').modal('show');
}


</script>

<script>
   
    $(document).ready(function () {
        // Event listener for clicking the "Assign Employee" link
        $(document).on('click', '#fetchEmp', function () {
            var invoiceNumber = $(this).data('invbk'); // Get the invoice number from data-invbk attribute
            var vn=$(this).data('vn');
            var imageUrl = $(this).data('im');
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
                    $('#selectedImageUrl').val(imageUrl);
                   
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
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg"> <!-- Use modal-lg class for a larger modal -->
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="imageModalLabel">Popup Image</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <img src="" id="popupImage" class="img-fluid custom-image" alt="Popup Image" onclick="openPopup(this.src)"> <!-- Use img-fluid class for responsive images -->
      </div>
    </div>
  </div>
</div>


<h3 class="titel">Trip Details</h3>

<!-- Inputs Group with Buttons -->
<section id="input-group-buttons">
  <form id="filterForm" method="GET" action="{{ route('search') }}">
    <div class="row">
      <div class="col-md-8 mb-0 mt-2">
        <div class="input-group">
          <input
            type="text"
            class="form-control"
            name="invoiceNumber"
            placeholder="Invoice Number"
            value="{{request('invoiceNumber')}}"
            aria-describedby="button-addon2"
            @if(request('invoiceNumber')) autofocus @endif
          />

          <input
            type="text"
            class="form-control"
            name="vehicleNumber"
            placeholder="Vehicle Number"
            value="{{request('vehicleNumber')}}"
            aria-describedby="button-addon2"
            @if(request('vehicleNumber')) autofocus @endif
          />

          <input
            type="text"
            class="form-control flatpickr-basic"
            name="searchDate"
            placeholder="Search Date"
          />
          <button class="btn btn-primary" type="submit">Search</button>
        </div>
      </div>
    </div>
  </form>
</section>


<div class="content-body">
    <!-- Bootstrap Validation -->
    <div class="row mt-1 mb-0" id="basic-table">
        <div class="col-12">
            <div class="card">
                <div class="table-container" >
                    <div class="table-responsive">
                        @if ($bookings->isEmpty())
                        <p>No matching records found </p>
                        @else
                        <table class="table table-hover">
                            <thead style="position: sticky; top: 0; background-color: #fff;">
                                <tr>
                                    <th>Invoice Number</th>
                                    <th>Vehicle Name</th>
                                    <th>Vehicle Number</th>
                                    <th>Start Mileage</th>
                                    <th>Fuel Level</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bookings as $items)
                                <tr class="booking-row" data-inv="{{ $items->invoice_number }}" data-vehicle-name="{{ $items->vehicle_name }}" data-vehicle-number="{{ $items->vehicle_number }}" data-vehicle-photo="{{ $items->uploadImage_url }}" data-start-mileage="{{ $items->s_mileage }}" data-fuel-level="{{ $items->fual }}">
                                    <td>{{ $items->invoice_number }}</td>
                                    <td>{{ $items->vehicle_name }}</td>
                                    <td>{{ $items->vehicle_number }}</td>
                                    <td>{{ $items->s_mileage }}</td>
                                    <td>{{ $items->fual }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @endif
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
          <form class="form" action="" method="">
                     
             @csrf
             <div class="row">
              <div class="col-md-3 col-12">
            <div class="mb-1">
                <label for="vname" class="form-label">Invoice</label>
                <input type="text" class="form-control" id="inv" name="inv" value="" placeholder="" />
                <span class="text-danger"></span>
            </div>
             <div class="mb-1">
                <label for="gas_level" class="form-label">Fuel Level</label>
                <input type="text" class="form-control" id="gas_level" name="gas_level" value="" placeholder="" />
                <span class="text-danger"></span>
            </div>
        </div>

        <div class="col-md-3 col-12">
            <div class="mb-1">
                <label for="vname" class="form-label">Vehicle Name</label>
                <input type="text" class="form-control" id="vname" name="vname" value="" placeholder="" />
                <span class="text-danger"></span>
            </div>
        </div>
       
<div class="col-md-3 col-12">
            <div class="mb-1">
                <label for="vnumber" class="form-label">Vehicle Number</label>
                <input type="text" class="form-control" id="vnumber" name="vnumber" value="" placeholder=""
                    aria-describedby="login-email" />
                <span class="text-danger"></span>
            </div>
        </div>
        <div class="col-md-3 col-12">
            <div class="mb-1">
                <label for="smiledge" class="form-label">Start Mileage</label>
                <input type="text" class="form-control" id="smiledge" name="smiledge" value="" placeholder="" />
                <span class="text-danger"></span>
            </div>
        </div>

        


<div class="row">
    <div class="col-lg-12">
        <div style="max-height: 400px; overflow-x: auto;">
            <div class="row">
                    <div class="col-md-4 col-12">
                        <div class="mb-2 mt-2" style="border: 2px solid #3B4253; padding: 10px; height: 200px;">
                            <img id="image1" alt="" class="img-fluid" style="width: 100%; height: 95%;" onclick="openPopup(this.src);">
                            <p class="image-message" style="display: none;">No images available</p>
                        </div>
                    </div>

                    <div class="col-md-4 col-12">
                        <div class="mb-2 mt-2" style="border: 2px solid #3B4253; padding: 10px; height: 200px;">
                            <img id="image2" alt="" class="img-fluid" style="width: 100%; height: 95%;" onclick="openPopup(this.src);">
                            <p class="image-message" style="display: none;">No images available</p>
                        </div>
                    </div>

                    <div class="col-md-4 col-12">
                        <div class="mb-2 mt-2" style="border: 2px solid #3B4253; padding: 10px; height: 200px;">
                            <img id="image3" alt="" class="img-fluid" style="width: 100%; height: 95%;" onclick="openPopup(this.src);">
                            <p class="image-message" style="display: none;">No images available</p>
                        </div>
                    </div>
            </div>
    <div class="row">
    <div class="col-md-4 col-12">
        <div class="mb-2 mt-2" style="border: 2px solid #3B4253; padding: 10px; height: 200px;">
            <img id="image4" alt="" class="img-fluid" style="width: 100%; height: 95%;" onclick="openPopup(this.src);">
            <p class="image-message" style="display: none;">No images available</p>
        </div>
    </div>

    <div class="col-md-4 col-12">
        <div class="mb-2 mt-2" style="border: 2px solid #3B4253; padding: 10px; height: 200px;">
            <img id="image5" alt="" class="img-fluid" style="width: 100%; height: 95%;" onclick="openPopup(this.src);">
            <p class="image-message" style="display: none;">No images available</p>
        </div>
    </div>

    <div class="col-md-4 col-12">
        <div class="mb-2 mt-2" style="border: 2px solid #3B4253; padding: 10px; height: 200px;">
            <img id="image6" alt="" class="img-fluid" style="width: 100%; height: 95%;" onclick="openPopup(this.src);">
            <p class="image-message" style="display: none;">No images available</p>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4 col-12">
        <div class="mb-2 mt-2" style="border: 2px solid #3B4253; padding: 10px; height: 200px;">
            <img id="image7" alt="" class="img-fluid" style="width: 100%; height: 95%;" onclick="openPopup(this.src);">
            <p class="image-message" style="display: none;">No images available</p>
        </div>
    </div>

    <div class="col-md-4 col-12">
        <div class="mb-2 mt-2" style="border: 2px solid #3B4253; padding: 10px; height: 200px;">
            <img id="image8" alt="" class="img-fluid" style="width: 100%; height: 95%;" onclick="openPopup(this.src);">
            <p class="image-message" style="display: none;">No images available</p>
        </div>
    </div>

    <div class="col-md-4 col-12">
        <div class="mb-2 mt-2" style="border: 2px solid #3B4253; padding: 10px; height: 200px;">
            <img id="image9" alt="" class="img-fluid" style="width: 100%; height: 95%;" onclick="openPopup(this.src);">
            <p class="image-message" style="display: none;">No images available</p>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4 col-12">
        <div class="mb-2 mt-2" style="border: 2px solid #3B4253; padding: 10px; height: 200px;">
            <img id="image10" alt="" class="img-fluid" style="width: 100%; height: 95%;" onclick="openPopup(this.src);">
            <p class="image-message" style="display: none;">No images available</p>
        </div>
    </div>

    <div class="col-md-4 col-12">
        <div class="mb-2 mt-2" style="border: 2px solid #3B4253; padding: 10px; height: 200px;">
            <img id="image11" alt="" class="img-fluid" style="width: 100%; height: 95%;" onclick="openPopup(this.src);">
            <p class="image-message" style="display: none;">No images available</p>
        </div>
    </div>

    <div class="col-md-4 col-12">
        <div class="mb-2 mt-2" style="border: 2px solid #3B4253; padding: 10px; height: 200px;">
            <img id="image12" alt="" class="img-fluid" style="width: 100%; height: 95%;" onclick="openPopup(this.src);">
            <p class="image-message" style="display: none;">No images available</p>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4 col-12">
        <div class="mb-2 mt-2" style="border: 2px solid #3B4253; padding: 10px; height: 200px;">
            <img id="image13" alt="" class="img-fluid" style="width: 100%; height: 95%;" onclick="openPopup(this.src);">
            <p class="image-message" style="display: none;">No images available</p>
        </div>
    </div>

    <div class="col-md-4 col-12">
        <div class="mb-2 mt-2" style="border: 2px solid #3B4253; padding: 10px; height: 200px;">
            <img id="image14" alt="" class="img-fluid" style="width: 100%; height: 95%;" onclick="openPopup(this.src);">
            <p class="image-message" style="display: none;">No images available</p>
        </div>
    </div>

    <div class="col-md-4 col-12">
        <div class="mb-2 mt-2" style="border: 2px solid #3B4253; padding: 10px; height: 200px;">
            <img id="image15" alt="" class="img-fluid" style="width: 100%; height: 95%;" onclick="openPopup(this.src);">
            <p class="image-message" style="display: none;">No images available</p>
        </div>
    </div>
</div>
 </div>
    </div>
</div>

              
              
             </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>




<section id="input-group-buttons">
  <form id="filterForm" method="GET" action="{{ route('searchthredd') }}">
    <div class="row">
      <div class="col-md-8 mb-0 mt-2">
        <div class="input-group">
          <input
            type="text"
            class="form-control"
            name="invoiceNumber2"
            placeholder="Invoice Number"
            value="{{request('invoiceNumber2')}}"
            aria-describedby="button-addon2"
            @if(request('invoiceNumber2')) autofocus @endif
          />

          <input
            type="text"
            class="form-control"
            name="vehicleNumber2"
            placeholder="Vehicle Number"
            value="{{request('vehicleNumber2')}}"
            aria-describedby="button-addon2"
            @if(request('vehicleNumber2')) autofocus @endif
          />

          <input
            type="text"
            class="form-control flatpickr-basic"
            name="searchDate2"
            placeholder="Search Date"
          />
          <button class="btn btn-primary" type="submit">Search</button>
        </div>
      </div>
    </div>
  </form>
</section>


 <div class="content-body"> 
      <!-- Bootstrap Validation -->
      <div class="row mt-1 mb-0">
  <div class="col-12">
    <div class="card">   
      <div class="table-responsive">
            @if ($booksthreed->isEmpty())
                    <p>No matching records found </p>
                    @else
        <table class="table table-hover">
          <thead>
            <tr>
            <th>Invoice Number</th>
              <th>Vehicle Name</th>
              <th>Vehicle Number</th>
              <th>Customer Name </th>
              <th>Phone Number</th>
              <th>Start Date</th>
              <th>End Date</th>
              <th>Destination</th>
              <th>Vehicle Photo</th>
              <th>Action</th>
              
              
            </tr>
          </thead>
          <tbody>
            @foreach($booksthreed as $items)
            <tr data-invbk="{{$items->invoice_number}}">
              <td>{{$items->invoice_number}}</td>
              <td>{{$items->vehicle_name}}</td>
              <td>{{$items->vehicle_number}}</td>
              
              <td>{{$items->customer_name}}</td>
              <td>{{$items->mobile}}</td>
              <td>{{$items->start_date}}</td>
              <td>{{$items->end_date}}</td>
              <td>{{$items->vehicle_pickup_location}}</td>
              {{-- <td>{{$items->uploadImage_url}}</td> --}}
              <td>
                <div class="avatar-group">
                  @foreach(explode(',', $items->uploadImage_url) as $imageUrl)
                  @if ($imageUrl)
                  <div
                    data-bs-toggle="tooltip"
                    data-popup="tooltip-custom"
                    data-bs-placement="top"
                    class="avatar pull-up my-0"
                    title=""
                  >
                    <img
                      src="{{ asset('storage/' . $imageUrl) }}"
                      alt="Avatar"
                      height="30"
                      width="30"
                    />
                  </div>
                  @endif
                  @endforeach
                </div>
              </td>
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
                        data-invbk="{{$items->invoice_number}}"
                        data-vn="{{$items->vehicle_number}}"
                        data-im="{{$items->uploadImage_url}}"
                    >
                      <i data-feather="edit-2" class="me-50"></i>
                      <span>Assign Employee</span>
                    </a>
                    <a class="dropdown-item" href="#">
                      <i data-feather="trash" class="me-50"></i>
                      <span>Delete</span>
                    </a>
                  </div>
                </div>
              </td>
             </tr>
        @endforeach          
          </tbody>
        </table>
        @endif
      </div>
    </div>
  </div>
</div>
</div>


<div class="mt-5">
<h5>Trip Details</h5>
<section id="input-group-buttons">
                 
          <form id="filterForm" method="GET" action="{{ route('searchsecond') }}">
    <div class="row">
      <div class="col-md-8 mb-0 mt-2">
        <div class="input-group">
          <input
            type="text"
            class="form-control"
            name="getsearch"
            value="{{request('getsearch')}}"
            placeholder="Invoice number/vehicle number"
            aria-describedby="button-addon2"
             @if(request('getsearch')) autofocus @endif
          />

         
          <button class="btn btn-primary" type="submit">Search</button>
        </div>
      </div>
    </div>
  </form>
            
  
<div class="content-body">
      <div class="row mt-1 mb-2"  >
  <div class="col-14">
    <div class="card">   
      <div class="table-responsive">
        @if ($booksecond->isEmpty())
                    <p>No matching records found </p>
                    @else
        <table class="table table-hover">
          <thead>
            <tr>
              
              <th>Invoice Number</th>
              <th>Status</th>
              <th>Vehicle Name</th>
              <th>Vehicle Number</th>
              <th>Customer Name </th>
              <th>Phone Number</th>
              <th>Destination</th>
              <th>Start Date</th>
              <th>End Date</th>
              <th>Vehicle Photo</th>
              <th>Start Mileage</th>
              <th>End Mileage</th>
              <th>Start Fuel Leval</th>
              <th>End Fuel Leval</th>
              
             


            </tr>
          </thead>
          <tbody>
            @foreach($booksecond as $items)
            <tr>
              <td>{{$items->invoice_number}}</td>

                <td>
                    @if($items->status=='pending')
                        <span class="badge rounded-pill badge-light-danger me-1">{{$items->status}} payment</span>
                    @elseif($items->status=='booked')
                        <span class="badge rounded-pill badge-light-primary me-1">{{$items->status}}</span>
                    @elseif($items->status=='completed')
                        <span class="badge rounded-pill badge-light-success me-1">{{$items->status}}</span>
                        @else
                    <span class="badge rounded-pill badge-light-info me-1">{{$items->status}}</span>
                    @endif
              
            </td>

              
              <td>{{$items->vehicle_name}}</td>
              <td>{{$items->vehicle_number}}</td>
              <td>{{$items->customer_name}}</td>
              <td>{{$items->mobile}}</td>
              <td>{{$items->vehicle_pickup_location}}</td>
              <td>{{$items->start_date}}</td>
              <td>{{$items->end_date}}</td>
               <td>
                <div class="avatar-group">
                  @foreach(explode(',', $items->uploadImage_url) as $imageUrl)
                  @if ($imageUrl)
                  <div
                    data-bs-toggle="tooltip"
                    data-popup="tooltip-custom"
                    data-bs-placement="top"
                    class="avatar pull-up my-0"
                    title=""
                  >
                    <img
                      src="{{ asset('storage/' . $imageUrl) }}"
                      alt="Avatar"
                      height="30"
                      width="30"
                    />
                  </div>
                  @endif
                  @endforeach
                </div>
              </td>
              <td>{{$items->s_mileage}}</td>
              <td>{{$items->e_mileage}}</td>
              <td>{{$items->fual}}</td>
              <td>{{$items->end_fual}}</td>
              
              </tr>
              @endforeach
              </tbody>
        

        </table>
        @endif
      </div>
    </div>
  </div>
</div> 






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
      

<form action="{{route('assign-employee')}}" method="post">
                @csrf
<div class="col-md-4 col-12">
                <div class="mb-3">
                <label for="lname" class="form-label">Invoice Number </label>
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
                <label for="lname" class="form-label">vehicle Number </label>
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
<input type="hidden" id="selectedImageUrl" name="selectedImageUrl">
          <div class="mb-1">

                <div class="col-11 ">
                  <label class="form-label " for="large-select">Choose Employee</label>
                  
                    <select class="select2-size-lg form-select" id="empdrop" name="empdrop">
                      
                      
                    </select>
                  

           <div class="form-check form-check-inline mb-1 mt-2">
    <label class="form-check-label" for="inlineCheckbox1">Get End Miledge</label>
    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" name="checkb[1]" value="get_end_mileage" checked />
</div>
<div class="mt-1 md-2">
    <textarea class="form-control" id="taskDesc1" rows="2" name="taskDesc[1]" placeholder="Description for image upload"></textarea>
    <span id="textareaErrorMessage1" class="text-danger"></span>
</div>

<div class="form-check form-check-inline mb-1">
    <label class="form-check-label" for="inlineCheckbox2">Get Fual Level</label>
    <input class="form-check-input" type="checkbox" id="inlineCheckbox2" name="checkb[2]" value="get_end_gas" />
</div>
<div class="mt-1 md-2">
    <textarea class="form-control" id="taskDesc2" rows="2" name="taskDesc[2]" placeholder="Description for mileage"></textarea>
    <span id="textareaErrorMessage2" class="text-danger"></span>
</div>

                <div class="mb-1 mt-2">
              <button type="submit" class="btn btn-primary" id="askValue">submit</button>
              <button type="reset" class="btn btn-primary">Clear</button>
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
