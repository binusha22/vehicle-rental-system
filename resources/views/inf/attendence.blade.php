@extends('layouts.lay')
@section('title','Employee Attendence')
@section('script')
<!-- <script>
    document.addEventListener('DOMContentLoaded', function () {
    const name = document.getElementById('name');
    const uid = document.getElementById('user_id');
    
    
    name.addEventListener('change', function () {
        const selectedname = this.value;
        if (selectedname) {
            // Make an AJAX request to fetch data based on the selected vehicle ID
            fetch(`/get-data/${selectedname}`)
                .then(response => response.json())
                .then(user => {
                    // Assuming the response includes 'vehicle_number', 'id', and 'brand' properties
                    vname.value = `${user[0].brand}  ${vehicleData[0].model}`; // Set vname with the value of 'brand'
                    vid.value = user[0].id; // Set vid with the value of 'id'
                    
                })
                .catch(error => console.error('Error fetching vehicle data:', error));
        } else {
            // Clear the values when no vehicle is selected
            vname.value = "";
            vid.value = "";
            
        }
    });
});
</script> -->
@endsection
@section('content')

<h2>
Employee Attendence</h2>
@if(Session::has('s1'))
            <div class="toastqq" id="toastqq">{{session('s1')}}</div>
            @endif
            @if(Session::has('f1'))
            <div class="toastHH" id="toastHH">{{session('f1')}}</div>
            @endif

            @if(Session::has('s'))
            <div class="toastqq" id="toastqq">{{session('s')}}</div>
            @endif
            @if(Session::has('f'))
            <div class="toastHH" id="toastHH">{{session('f')}}</div>
            @endif
<section>
<div class="content-body"><section id="input-group-basic">
  <div class="row mt-4">

<!-- Sizing -->
<div class="col-md-6">
      <div class="card">
        <div class="card-header ">
          <h4 class="card-title ">Employee In Time</h4>
        </div>
        <div class="card-body">

        <form action="{{route('employee_attendence_in')}}" method="post" >  
          @csrf       
          
          <div class="mb-1">

                <div class="col-11 ">
                  <label class="form-label " for="large-select">Choose Employee</label>
                  
                    <select class="select2-size-lg form-select" id="name" name="name">
                      <option value="">Select</option>
                      @foreach($users as $us)
                      <option value="{{$us->username}}">{{$us->fname}} {{$us->lname}}</option>
                     @endforeach
                    </select>
                    <span class="text-danger">@error('name'){{$message}}@enderror</span>
              <div class="mt-1">
               
                  <label class="form-label" for="fp-range">Date</label>
                  <input
                    type="text"
                    id="fp-range"
                    name="in_date"
                    class="form-control flatpickr-basic"
                    placeholder="YYYY-MM-DD"
                  />
                </div>
                <span class="text-danger">@error('in_date'){{$message}}@enderror</span>

                
                <div class="mb-1 mt-5">
              <button type="submit" class="btn btn-primary">submit</button>
              <button type="submit" class="btn btn-primary">Clear</button>
              </div>
             </div>
           </div>
        </form>
      </div>
   </div>
</div>

    <!-- Employee out Time -->

    <div class="col-md-6">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Employee Out Time </h4>
        </div>
        <div class="card-body">

        <form action="{{ route('emp-check-out') }}" method="post">
          @csrf        
          <div class="mb-1">

                <div class="col-11 ">
                  <label class="form-label " for="large-select">Choose Employee</label>
                  
                  <select class="select2-size-lg form-select" id="large-select" name="name2">
                      <option value="">Select</option>
                      @foreach($users as $us)
                      <option value="{{$us->username}}">{{$us->fname}} {{$us->lname}}</option>
                      @endforeach
                    </select>
                    <span class="text-danger">@error('name2'){{$message}}@enderror</span>

              <div class="mt-1">
               
                  <label class="form-label" for="fp-range">Date</label>
                  <input
                    type="text"
                    id="fp-range"
                    name="out_date"
                    class="form-control flatpickr-basic"
                    placeholder="YYYY-MM-DD"
                  />
                </div>
                <span class="text-danger">@error('out_date'){{$message}}@enderror</span>
                <div class=" mt-1 ">
                  
                <textarea
                  class="form-control"
                  name="desc"
                  id=""
                  rows="1"
                  placeholder="Description"
                ></textarea>
                

                </div>
                <span class="text-danger">@error('desc'){{$message}}@enderror</span>
                               
                <div class="mb-1 mt-5">
              <button type="submit" class="btn btn-primary">submit</button>
              <button type="submit" class="btn btn-primary">Clear</button>
              </div>
             </div>
           </div>
        </form>
      </div>
   </div>
</div>
</section>

@endsection