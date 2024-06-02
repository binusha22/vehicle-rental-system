@extends('layouts.lay')
@section('title','Vehicle Insurence Renew')
@section('style')
<style>
 .titel{Margin-bottom:40px}
</style>
@section('content')
@if(Session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" data-bs-delay="3000">
        {{ Session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">x</button>
    </div>
@endif

@if(Session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert" data-bs-delay="3000">
        {{ Session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">x</button>
    </div>
@endif

  <h3 class="titel">Vehicle Insurence Renew</h3>
  


  <section id="input-group-buttons">
                 
  <form action="/vehicle-insuarence-renew" method="get">
    <div class="row">
        <div class="col-md-3">
            <div class="input-group">
                <input
                    name="search2"
                    id="search2"
                    type="text"
                    class="form-control"
                    placeholder="Search Vehicles Number"
                    aria-describedby="button-addon2"
                    value="{{ $search }}"
                />
                <span class="input-group-text">
                    <button type="submit" style="background: none; border: none; padding: 0; cursor: pointer;">
                        <i data-feather="search" style="color: #fff; font-size: 20px;"></i>
                    </button>
                </span>
            </div>
        </div>
    </div>
</form>
          
            
   <div class="content-body"> 
      <!-- Bootstrap Validation -->
      <div class="row mt-1 mb-2" id="basic-table">
        <div class="col-12">
            <div class="card">
                <div class="table-responsive t1">
                    <table class="table table-hover" id="vehiclesTable">
                        <thead>
                            <tr>
                            <th>ID</th>
                                <th>Vehicle Name</th>
                                <th>Vehicle Number</th>
                                <th>Renew Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($vehicles as $vehicle)
                            <tr class="vehicle-row" data-id="{{ $vehicle->id }}" data-name="{{ $vehicle->brand}} {{ $vehicle->model}}" data-number="{{ $vehicle->vehicle_number }}">
                                <td>{{ $vehicle->id }}</td>
                                <td>{{ $vehicle->brand}} {{ $vehicle->model}}</td>
                                <td>{{ $vehicle->vehicle_number }}</td>
                                <td>{{ $vehicle->expire_date}}</td>
                                
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3">No vehicles found  <a href="/vehicle-insuarence-renew" > <b><span style="color:red;">Refresh</span></b></a></td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
            </div>
        </div>
    </div>

    <form method="post" action="/vehicle-insuarence-renew-data-insert">
    @csrf
    <div class="col-md-5 mb-1">
            <label class="form-label"  >ID</label>
            <input
                type="text"
                id="vehicle_id"
                class="form-control"
               
                readonly
                name="vehicle_id"
                aria-describedby="basic-addon-name"
            />
        <span class="text-danger">@error('vehicle_id'){{$message}}@enderror</span>
</div>

    <div class="col-md-5 mb-1">
        <!-- <div class="col-5">
            <label class="form-label" for="vehicle-name-select">Select Vehicle Name</label>
            <select class="select2-size-lg form-select" id="vehicle-name-select">
                <option value="square">Toyota</option>
                <option value="rectangle">BMD</option>
                <option value="rombo">Audi</option>
                <option value="romboid">Nissan</option>
            </select>
        </div> -->
        <label class="form-label" for="basic-addon-name">Vehicle Name</label>
  
                <input
                  type="text"
                  id="vehicle_name"
                  class="form-control"
                  placeholder="Audi Q2"
                  aria-label="Name"
                  name="vehicle_name"
                  aria-describedby="basic-addon-name"
                  
                />
                <span class="text-danger">@error('vehicle_name'){{$message}}@enderror</span>
    </div>
    
    <div class="col-md-5 mb-1">
        <!-- <div class="col-5">
            <label class="form-label" for="vehicle-number-select">Vehicles Number</label>
            <select class="select2-size-lg form-select" id="vehicle-number-select">
                <option value="square">CMB 1245</option>
                <option value="rectangle">EWQ 5222</option>
                <option value="rombo">KT 5599</option>
                <option value="romboid">HN 7896</option>
            </select>
        </div> -->
        <label class="form-label" for="basic-addon-name">Vehicle Number</label>
  
                <input
                  type="text"
                  id="vehicle_number"
                  class="form-control"
                  placeholder="ABC-5432"
                  aria-label="Name"
                  name="vehicle_number"
                  aria-describedby="basic-addon-name"
                  
                />
                <span class="text-danger">@error('vehicle_number'){{$message}}@enderror</span>
    </div>
            
    <div class="mb-0">
        <div class="col-md-5 mb-1">
            <label class="form-label" for="renewed_date">insuarence start date</label>
            
            <input type="text" id="renewed_date" class="form-control flatpickr-basic" name="renewed_date" placeholder="YYYY-MM-DD" />
        </div>
        <span class="text-danger">@error('renewed_date'){{$message}}@enderror</span>
    </div>
    
    <div class="mb-2">
        <div class="col-md-5 mb-1">
            <label class="form-label" for="expire_date">insuarence End date</label>
            
            <input type="text" id="expire_date" class="form-control flatpickr-basic" name="expire_date" placeholder="YYYY-MM-DD" />
        </div>
        <span class="text-danger">@error('expire_date'){{$message}}@enderror</span>
    </div>
    
    <div class="mb-1">
        <button type="submit" class="btn btn-primary">Submit</button>
        <button type="submit" class="btn btn-primary">Cancel</button>
    </div>
</form>
              
    <!-- <TABLE>-->
    <div class="row mt-3" id="basic-table" >
    <div class="content-body">
        <div class="row mt-2" id="dark-table">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Vehicle License Renew Summary</h5>
                    </div>
                    <div class="col-12">
                        <div class="card">
                            <div class="table-responsive t1">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Vehicle Name</th>
                                            <th>Vehicle Number</th>
                                            <th>Renew Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($renewSummery as $renew)
                                        <tr>
                                            <td>{{ $vehicle->brand}} {{ $vehicle->model}}</td>
                                            <td>{{$renew->vehicle_number}}</td>
                                            <td>{{$renew->expire_date}}</td>
                                        </tr>
                                       @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
      <!-- /Bootstrap Validation -->
      
      <!-- jQuery Validation -->

     

      <!-- /jQuery Validation -->
      
    </div>
  </section>
</div>



  
@endsection
@section('script')
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function() {
        $(".vehicle-row").click(function() {
            var id = $(this).data('id');
            var name = $(this).data('name');
            var number = $(this).data('number');
            

            $("#vehicle_id").val(id);
            $("#vehicle_name").val(name);
            $("#vehicle_number").val(number);
            
        });
    });
</script>
@endsection
