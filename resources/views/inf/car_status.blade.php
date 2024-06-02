@extends('layouts.lay')
@section('title','Vehicle Status')
@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function () {
    const vinumber = document.getElementById('vehicle_number');
    const vname = document.getElementById('vehicle_name');
    const vid = document.getElementById('vehicle_id');
    const outMile = document.getElementById('out_mileage');
    vinumber.addEventListener('change', function () {
        const selectedvehicleid = this.value;
        if (selectedvehicleid) {
            // Make an AJAX request to fetch data based on the selected vehicle ID
            fetch(`/get-data/${selectedvehicleid}`)
                .then(response => response.json())
                .then(vehicleData => {
                    // Assuming the response includes 'vehicle_number', 'id', and 'brand' properties
                    vname.value = vehicleData[0].vehicle_name; // Set vname with the value of 'brand'
                    vid.value = vehicleData[0].vehicle_reg_id; // Set vid with the value of 'id'
                    outMile.value=vehicleData[0].mielage;
                })
                .catch(error => console.error('Error fetching vehicle data:', error));
        } else {
            // Clear the values when no vehicle is selected
            vname.value = "";
            vid.value = "";
            outMile.value = "";
        }
    });
});
</script>
<!-- second script for get data  -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
    const vinumber = document.getElementById('vehicle_number2');
    const vname = document.getElementById('vehicle_name2');
    const vid = document.getElementById('vehicle_id2');
    
    vinumber.addEventListener('change', function () {
        const selectedvehicleid = this.value;
        if (selectedvehicleid) {
            // Make an AJAX request to fetch data based on the selected vehicle ID
            fetch(`/get-data/${selectedvehicleid}`)
                .then(response => response.json())
                .then(vehicleData => {
                    // Assuming the response includes 'vehicle_number', 'id', and 'brand' properties
                    vname.value = vehicleData[0].vehicle_name; // Set vname with the value of 'brand'
                    vid.value = vehicleData[0].vehicle_reg_id; // Set vid with the value of 'id'
                    
                })
                .catch(error => console.error('Error fetching vehicle data:', error));
        } else {
            // Clear the values when no vehicle is selected
            vname.value = "";
            vid.value = "";
            
        }
    });
});
</script>

<script>
    $(document).ready(function () {
        $('#searchForm').submit(function (e) {
            e.preventDefault(); // Prevent the default form submission

            // Get form data
            var formData = $(this).serialize();

            // Send AJAX request to the new search route
            $.ajax({
                url: '/search', // Updated to the new search route
                type: 'GET',
                data: formData,
                success: function (data) {
                    // Update the content on success
                    $('#table-section').html(data);
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });
    });
</script>
@endsection
@section('content')

            
        @if(session('s1'))
    <div class="toastqq" id="toastqq">{{session('s1')}}</div>
@endif

<!-- Include toast notification for failure -->
@if(session('f1'))
    <div class="toastHH" id="toastHH">{{session('f1')}}</div>
@endif
 @if(session('s'))
    <div class="toastqq" id="toastqq">{{session('s')}}</div>
@endif

<!-- Include toast notification for failure -->
@if(session('f'))
    <div class="toastHH" id="toastHH">{{session('f')}}</div>
@endif
<h2>
Vehicle Status
</h2>

<section>

<div class="content-body"><section id="input-group-basic">
  <div class="row mt-4">

<!-- Sizing -->
<div class="col-md-6">
      <div class="card">
        <div class="card-header ">
          <h4 class="card-title ">Vehicle Out</h4>
        </div>
        
        <div class="card-body">

        <form action="{{route('vehicle-status-out-vehicle')}}" method="post">         
        @csrf
          <div class="mb-1">

          
                <div class="col-11 ">
                
                  <label class="form-label " for="large-select">Choose Vehicle Number</label>
                  
                    <select class="select2-size-lg form-select" id="vehicle_number" name="vehicle_number">
                    <option value="">select vehicle number</option>
                    @foreach($data as $dt)
                    <option value="{{$dt->vehicle_number}}">{{$dt->vehicle_number}}</option>
                     @endforeach
                    </select>
                  
                    <div class="mt-1">
                    
                    <label class="form-label" for="large-select">Vehicle ID</label>
                      <input
                         type="text"
                         class="form-control"
                         placeholder="0"
                         name="vehicle_id"
                         id="vehicle_id"
                         aria-label=""
                         aria-describedby="basic-addon6"
                         />
                    </div>
                    <span class="text-danger">@error('vehicle_id'){{$message}}@enderror</span>
                    <div class="mt-1">
                    
                    <label class="form-label" for="large-select">Vehicle Name</label>
                      <input
                         type="text"
                         class="form-control"
                         placeholder="toyota camry"
                         name="vehicle_name"
                         id="vehicle_name"
                         aria-label=""
                         aria-describedby="basic-addon6"
                         />
                    </div>
                    <span class="text-danger">@error('vehicle_name'){{$message}}@enderror</span>
                    <div class="mt-1">
                    
               <label class="form-label" for="large-select">Type The Mileage</label>
                 <input
                    type="text"
                    class="form-control"
                    name="out_mileage"
                    id="out_mileage"
                    placeholder=""
                    aria-label=""
                    aria-describedby="basic-addon6"
                    />
               </div>
               <span class="text-danger">@error('out_mileage'){{$message}}@enderror</span>        
              <div class="mt-1">
               
                  <label class="form-label" for="fp-range">Out Date</label>
                  <input type="text" id="" class="form-control flatpickr-basic" name="out_date" placeholder="YYYY-MM-DD" />
                </div>
                <span class="text-danger">@error('out_date'){{$message}}@enderror</span> 
                <div class=" mt-1 ">
                  <label class="form-label" for="large-select">Reason</label>
                  
                    <select class="select2-size-lg form-select" id="large-select" name="reason">
                    <option value="">select</option>
                      <option value="Trip_out">Trip out</option>
                      <option value="Body_Wash_out">Body Wash out</option>
                      <option value="Service_out">Service out</option>
                      <option value="Garage_out">Garage out</option>
                    
                    </select>
                </div>
                <span class="text-danger">@error('reason'){{$message}}@enderror</span>

                               
                <div class="mb-1 mt-5">
              <button type="submit" class="btn btn-primary">submit</button>
              <!-- <button type="submit" class="btn btn-primary">Clear</button> -->
              </div>
             </div>
           </div>
        </form>
      </div>
   </div>
</div>


    <!-- Employee In Time -->

    <div class="col-md-6">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Vehicle IN </h4>
        </div>
       
        <div class="card-body">

        <form action="{{route('vehicle-status-in-vehicle')}}" method="post">         
        @csrf

          <div class="mb-1">

          
                <div class="col-11 ">
                
                  <label class="form-label " for="large-select">Choose Vehicle Number</label>
                  
                    <select class="select2-size-lg form-select" id="vehicle_number2" name="vehicle_number2">
                    <option value="">select vehicle number</option>
                    @foreach($dataOut as $dt)
                    <option value="{{$dt->vehicle_number}}">{{$dt->vehicle_number}}</option>
                     @endforeach
                    </select>
                  
                    <div class="mt-1">
                    
                    <label class="form-label" for="large-select">Vehicle ID</label>
                      <input
                         type="text"
                         class="form-control"
                         placeholder="0"
                         name="vehicle_id2"
                         id="vehicle_id2"
                         aria-label=""
                         aria-describedby="basic-addon6"
                         />
                    </div>
                    <span class="text-danger">@error('vehicle_id2'){{$message}}@enderror</span>
                    <div class="mt-1">
                    
                    <label class="form-label" for="large-select">Vehicle Name</label>
                      <input
                         type="text"
                         class="form-control"
                         placeholder="toyota camry"
                         name="vehicle_name2"
                         id="vehicle_name2"
                         aria-label=""
                         aria-describedby="basic-addon6"
                         />
                    </div>
                    <span class="text-danger">@error('vehicle_name2'){{$message}}@enderror</span>
                    <div class="mt-1">
                    
               <label class="form-label" for="large-select">Type The New Mileage</label>
                 <input
                    type="text"
                    class="form-control"
                    name="in_mileage2"
                    id="in_mileage2"
                    placeholder=""
                    aria-label=""
                    aria-describedby="basic-addon6"
                    />
               </div>
               <span class="text-danger">@error('in_mileage2'){{$message}}@enderror</span>           
              <div class="mt-1">
               
                  <label class="form-label" for="fp-range">In Date</label>
                  <input type="text" id="" class="form-control flatpickr-basic" name="in_date" placeholder="YYYY-MM-DD" />
                </div>
                <span class="text-danger">@error('in_date'){{$message}}@enderror</span>  
                <div class=" mt-1 ">
                  <label class="form-label" for="large-select">Reason</label>
                  
                    <select class="select2-size-lg form-select" id="large-select" name="reason2">
                    <option value="">select</option>
                      <option value="Yard in">Yard in</option>
                      <
                    
                    </select>
                </div>
                <span class="text-danger">@error('reason2'){{$message}}@enderror</span>  
                               
                <div class="mb-1 mt-5">
              <button type="submit" class="btn btn-primary">submit</button>
              <!-- <button type="submit" class="btn btn-primary">Clear</button> -->
              </div>
             </div>
           </div>
        </form>
      </div>
   </div>
</div>

      <div class=" mt-1 " style="width: 200px;">
                  
                    <select class="select2-size-lg form-select" id="filter_reason" name="filter_reason">
                    <option value="">select</option>
                      <option value="Yard in">Yard in</option>
                      <option value="Trip_out">Trip out</option>
                      <option value="Body_Wash_out">Body Wash out</option>
                      <option value="Service_out">Service_out</option>
                    <option value="Garage_out">Garage_out</option>
                    </select>
                </div>

<div class="mt-1">
<h5>Vehicle Status Details</h5>
<section id="input-group-buttons">
                 <form action="/vehicle-status#basic-table" method="get">
                  @csrf
          <div class="row">
            <div class="col-md-3 mb-1">
              <div class="input-group">
              <input
                    name="search"
                    id="search"
                    type="text"
                    class="form-control"
                    placeholder="Search Vehicles Number"
                    aria-describedby="button-addon2"
                    value="{{ $search }}"
                />
                <span class="input-group-text">
                    
                </span>
              </div>
            </div>
            
            <div class="col-md-3 mb-1 ">
              <div class="input-group">
              <input type="text" id="renewed_date" class="form-control flatpickr-basic" name="renewed_date" placeholder="search date" />
              <button type="submit" class="btn btn-primary">submit</button>
                </div>

              </div>
            </div>
          </div>

          </form>


 </section>


 <div class="content-body"> 
      <!-- Bootstrap Validation -->
      <div class="row mt-0 mb-0"  id="basic-table">
  <div class="col-12">
    <div class="card">   
      <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
        <table class="table table-hover" >
          <thead>
            <tr>
              <th>Vehicle Number</th>
              <th>Vehicle Name</th>
              <th>Out Date</th>
              <th>Out Milage</th>
              <th>In Date</th>
              <th>In Milage</th>
              <th>Reason</th>
              
            </tr>
          </thead>
          <tbody id="vehicleStatusShowBody">
            @forelse($vehicleStatus as $data)
            <tr>
              <td>{{$data->vehicle_number}}</td>
              <td>{{$data->vehicle_name}}</td>
              <td>{{$data->out_date}}</td>
              <td>{{$data->out_mileage}}</td>
              <td>{{$data->in_date}}</td>
              <td>{{$data->in_mileage}}</td>
              <td>{{$data->reason}}</td>
              </tr>
              @empty
                            <tr>
                                <td colspan="3">No vehicles found  <a href="/vehicle-status" > <b><span style="color:red;">Refresh</span></b></a></td>
                            </tr>
                            @endforelse 


         </tbody>
        </table>
      </div>
      
    </div>
    {{$vehicleStatus->links('pagination.custom')}}
  </div>
</div>
</div>

            
</section>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#filter_reason').change(function() {
        var reason = $(this).val();
        console.log("Input reason: " + reason);

        if (reason) {
            $.ajax({
                url: '/get_vehicle_reason',
                type: 'GET',
                data: {
                    reason: reason,
                },
                dataType: 'json', // Specify the expected response data type
                success: function(response) {
                    console.log("Response data:", response);

                    // Clear the table body
                    $('#vehicleStatusShowBody').empty();

                    // Check if the response contains data
                    if (response.data && response.data.length > 0) {
                        $.each(response.data, function(index, data) {
                            var row = '<tr>' +
                                '<td width="20%">' + data.vehicle_number + '</td>' +
                                '<td width="20%" class="fw-bold">' + data.vehicle_name + '</td>' +
                                '<td width="20%" class="fw-bold">' + data.out_date + '</td>' +
                                '<td width="20%" class="fw-bold">' + data.out_mileage + '</td>' +
                                '<td width="20%" class="fw-bold">' + data.in_date + '</td>' +
                                '<td width="20%" class="fw-bold">' + data.in_mileage + '</td>' +
                                '<td width="20%" class="fw-bold">' + data.reason + '</td>' +
                                '</tr>';
                            $('#vehicleStatusShowBody').append(row);
                        });
                    } else {
                        var row = '<tr>' +
                            '<td width="20%" colspan="7">No data found</td>' +
                            '</tr>';
                        $('#vehicleStatusShowBody').append(row);
                    }
                },
                error: function(error) {
                    console.log('Error:', error);
                }
            });
        } else {
            // Clear the table body if no reason is selected
            $('#vehicleStatusShowBody').empty();

            var row = '<tr>' +
                '<td width="20%" colspan="7">No data found</td>' +
                '</tr>';
            $('#vehicleStatusShowBody').append(row);
        }
    });
});
</script>

@endsection