@extends('layouts.lay')
@section('title','POS customer_registration')
@section('script')
{{-- <script>
document.addEventListener('DOMContentLoaded', function() {
    const selectElement = document.getElementById('large-select');
    const nicInput = document.getElementById('nicInput');
    const passportInput = document.getElementById('passportInput');

    // Add event listener to the select element
    selectElement.addEventListener('change', function() {
        // Check the selected value
        if (selectElement.value === 'nic') {
            // Show NIC input and hide passport input
            nicInput.style.display = 'block';
            passportInput.style.display = 'none';
        } else if (selectElement.value === 'passport') {
            // Show passport input and hide NIC input
            nicInput.style.display = 'none';
            passportInput.style.display = 'block';hhhhhh
        }
    });
});

</script> --}}
@endsection
@section('style')
<style>
  .titel{Margin-botton:40px}
</style>
@endsection
@section('content')
@if(session('success'))
    <div class="toastqq" id="toastqq">{{session('success')}}</div>
@endif

<!-- Include toast notification for failure -->
@if(session('fail'))
    <div class="toastHH" id="toastHH">{{session('fail')}}</div>
@endif
<section class="bs-validation">


    <section id="multiple-column-form">
      <div class="row mt-1">
        <div class="col-12">
          <div class="card">
        
             <div class="card-body">
              <h4 class="card-title">Customer Register</h4>
              <form class="form"method="post" action="{{ route('save_customer') }}">
              @if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif    
                 @csrf
                <div class="row">
                  <div class="col-md-6 col-12">
                    <div class="mb-1">
                    <label for="fname" class="form-label">First Name</label>
                      <input
                        type="text"
                        class="form-control"
                        id="fname"
                        name="fname"
                        value="{{old('fname')}}"
                        placeholder="waruna"
                        
                       
                      />
                        <span class="text-danger"></span>
                    </div>
                  </div>
    
                  <div class="col-md-6 col-12">
                    <div class="mb-1">
                    <label for="lname" class="form-label">Last Name </label>
                        <input
                          type="text"
                          class="form-control"
                          id="lname"
                          name="lname"
                          value="{{old('lname')}}"
                          placeholder="Madusanka"
                          
                         
                          />
                          <span class="text-danger"></span>
                    </div>
                  </div>
  
    
                  <div class="col-md-6 mb-1">
                    <label class="form-label" for="fp-default">Date Of Birth</label>
                    <input type="text" id="fp-default" class="form-control flatpickr-basic" placeholder="YYYY-MM-DD" name="dob" value="{{old('dob')}}" />
                  </div>
    
                  <div class="col-md-6 mb-1">
                     
                    <label for="lname" class="form-label">Whatsapp Mobile Number</label>
                        <input
                          type="number"
                          class="form-control"
                          id="whatsappnumber"
                          name="whatsappnumber"
                          value="{{old('whatsappnumber')}}"
                          placeholder="0779875432"
                          
                          
                          />

                    </div>
                    
                  
                  <div class="col-md-6 col-12">
                    <div class="mb-1" id="nicInput">
                        <label class="form-label" for="large-select">Id Number</label>
                      
                        <input
                          type="text"
                          class="form-control"
                          id="idnumber"
                          name="idnumber"
                          value="{{old('idnumber')}}"
                          placeholder="97065432v"
                          
                          
                          />

                          <span class="text-danger"></span>
                    </div>

                    <div class="mb-1" id="passportInput" >
                    <label for="lname" class="form-label">passport Number</label>
                        <input
                          type="text"
                          class="form-control"
                          id="passportnumber"
                          name="passportnumber"
                          value="{{old('passportnumber')}}"
                          placeholder="N123456"
                          
                          
                          />
                          <span class="text-danger"></span>
                    </div>
                    <div class="mb-1" >
                    
                        <label for="lname" class="form-label">Liecence Number</label>
                        <input
                          type="text"
                          class="form-control"
                          id="liecencenumber"
                          name="liecencenumber"
                          value="{{old('liecencenumber')}}"
                          placeholder="97065432"
                          
                          
                          />

                          <span class="text-danger"></span>
                    </div>
                     <div class="mb-1">
                    <label for="fname" class="form-label">Address</label>
                      <input
                        type="text"
                        class="form-control"
                        id="address"
                        name="address"
                        value="{{old('address')}}"
                        placeholder="No 301,Colombo"
                        
                        
                      />
                        <span class="text-danger"></span>
                    </div>

                    <div class="mb-1">
                    <label for="fname" class="form-label">Address <span style="color: red;">(</span>Optional<span style="color: red;">)</span></label>
                      <input
                        type="text"
                        class="form-control"
                        id="address_op"
                        name="address_op"
                        value="{{old('address_op')}}"
                        placeholder="No 301,Colombo"
                        
                        
                      />
                        <span class="text-danger"></span>
                    </div>
                  </div>
    
                  <div class="col-md-6 col-12">
                    <div class="mb-1">
                    <label for="lname" class="form-label">Telephone Number</label>
                        <input
                          type="number"
                          class="form-control"
                          id="phonenumber"
                          name="phonenumber"
                          value="{{old('phonenumber')}}"
                          placeholder="0779875432"
                          
                          
                          />
                          <span class="text-danger"></span>
                    </div>

                    <div class="mb-1">
                    <label for="lname" class="form-label">Telephone Number <span style="color: red;">(</span>Optional<span style="color: red;">)</span></label>
                        <input
                          type="number"
                          class="form-control"
                          id="phonenumber_op"
                          name="phonenumber_op"
                          value="{{old('phonenumber_op')}}"
                          placeholder="0779875432"
                          
                          
                          />
                          <span class="text-danger"></span>
                    </div>

                    <div class="col-md-6 mb-1">
                    <label class="form-label" for="large-select">Select (Vip or Non-vip)</label>
                    
                      <select class="select2-size-lg form-select" id="large-select" name="vip_or_nonvip">
                        <option value="vip">Vip</option>
                        <option value="non-vip">Non-vip</option>
                      </select>
                    
                  </div>
                  </div>

                

                  {{-- <div class="col-md-6 col-12">
                    <div class="mb-1">
                    
                          <span class="text-danger"></span>
                    </div> --}}

                  <div class="col-md-6 mb-1">
                    <label class="form-label" for="fp-default">Register Date</label>
                    <input type="text" id="fp-default" class="form-control flatpickr-basic" placeholder="YYYY-MM-DD" name="regDate" value="{{old('regDate')}}" />
                  </div>
   
                  
    
  
    
                    <div class="col-12" style="text-align: center;">
                      <button class="btn btn-primary w-15 mt-1 mr-6" tabindex="4">Submit</button>
                      <button type="reset" class="btn btn-outline-secondary w-15 mt-1">Reset</button>
                    </div>
    
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>


    <div class="row" id="table-hover-row">
      
      <form action="{{ route('customer_registration') }}" method="GET">
    @csrf
    <section id="input-group-buttons">              
        <div class="row">
            <div class="col-md-4 mb-1">
                <div class="input-group">
                    <input
                        type="text"
                        class="form-control w-15"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search Customer"
                        aria-describedby="button-addon2"
                        @if(request('search')) autofocus @endif


                    />
                    <button  type="submit" class="btn btn-primary">Search</button>
                </div>
            </div>
            
            
        </div>
    </section>
</form>


<div class="row" id="table-hover-row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Customer Details</h4>
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Date Of Birth</th>
                            <th>Id Number</th>
                            <th>Passport Number</th>
                            <th>Liecence Number</th>
                            <th>Telephone Number</th>
                            <th>Whats app Number</th>
                            <th>Telephone Number(additional)</th>
                            <th>Address</th>
                            <th>Address(additional)</th>
                            <th>Vip/Normal</th>
                            <th>Register Date</th>      
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($customer as $customer)
                        <tr>
                            <td>{{$customer->fname}}</td>
                            <td>{{$customer->lname}}</td>
                            <td>{{$customer->dob}}</td>
                            <td>{{$customer->idnumber}}</td>
                            <td>{{$customer->passportnumber }}</td>
                            <td>{{$customer->liecencenumber }}</td>
                            <td>{{$customer->phonenumber}}</td>
                            <td>{{$customer->whatsappnumber}}</td>
                            <td>{{$customer->mobile_op}}</td>
                            <td>{{$customer->address}}</td>
                            <td>{{$customer->address}}</td>
                            <td>{{$customer->vip_or_nonvip}}</td>
                            <td>{{$customer->regDate}}</td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn btn-sm dropdown-toggle hide-arrow py-0" data-bs-toggle="dropdown">
                                        <i data-feather="more-vertical"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a class="dropdown-item" href="#">
                                            <i data-feather="edit-2" class="me-50"></i>
                                            <span>still building</span>
                                        </a>
                                        {{-- <a class="dropdown-item" href="#">
                                            <i data-feather="trash" class="me-50"></i>
                                            <span>Delete</span>
                                        </a>
                                        <a class="dropdown-item" href="#">
                                            <i data-feather="edit-2" class="me-50"></i>
                                            <span>Edit</span>
                                        </a>
                                        <a class="dropdown-item" href="#">
                                            <i data-feather="trash" class="me-50"></i>
                                            <span>Delete</span>
                                        </a> --}}
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9">No data available</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

    


@endsection