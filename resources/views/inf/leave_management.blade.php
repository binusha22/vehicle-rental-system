@extends('layouts.lay')
@section('title','request leave here')
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
<h3 class="titel">Leave Management</h3>


<br>




    <div class="content-body"> 
      <!-- Bootstrap Validation -->
      <div class="row mt-1 mb-0"  id="basic-table">
  <div class="col-12">
    <div class="card">   
      <div class="table-responsive">
      <table class="table table-hover text-center">

          <thead>
          <tr>
              <th>This Month Leaves</th>
              <th>Current taken Leaves</th>
 
            </tr>
          </thead>
          

          <tbody>
             <td><span class="rounded-pill">{{$leave}}</span></td>
              <td><span class="rounded-pill">{{$grant}}</span></td>


<!-- badge bg-primary rounded-pill ms-auto -->
          </tbody>

        </table>
      </div>
    </div>
  </div>




  <section id="multiple-column-form">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Request a Leave</h4>
        </div>
        
          
       
        <div class="card-body">
          <form class="form" action="{{route('send_leave_request')}}" method="post">
            @csrf
            <input
                type="hidden"
                id="uid"
                class="form-control"
                placeholder=""
                value="{{$userId}}"
                name="uid"
                
                 />
            <div class="row">
              <div class="col-md-6 col-12">
                <div class="mb-1">
                <label class="form-label" for="name">Name</label>
                <div>
                <input
                type="text"
                id="name"
                class="form-control"
                placeholder=""
                value="{{$name}}"
                name="name"
                readonly
                 />
                </div>

                

                </div>
              </div>
              <div class="col-md-3 col-12">
                <div class="mb-1">
                  <label class="form-label" for="last-name-column">Start Date</label>
                  <input
                    type="text"
                    id="start_date"
                    class="form-control flatpickr-basic"
                    name="start_date"
                    placeholder="selecte start date"
                  />
                </div>
              </div>
              <div class="col-md-3 col-12">
                <div class="mb-1">
                  <label class="form-label" for="city-column">End Date</label>
                  <input
                    type="text"
                    id="end_date"
                    class="form-control flatpickr-basic"
                    name="end_date"
                    placeholder="selecte end date"
                  />
                </div>
              </div>
              <div class="col-md-6 col-12">
                <div class="mb-1">
                  <label class="form-label" for="country-floating">Reason</label>
                  <textarea
                  data-length="20"
                  class="form-control char-textarea"
                  id="reason"
                  rows="3"
                  name="reason"
                  placeholder=""
                  style="height: 100px"
                ></textarea>
                </div>
              </div>
            
         
      
     
         

        
          
              

              
              <div class="col-12">
                <button type="submit" class="btn btn-primary me-1">Submit</button>
                
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>


<div class="row mt-0" id="basic-table">
  <div class="content-body">
    <div class="row mt-0" id="dark-table">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h5>Your leave request details</h5>
          </div>
          <div class="col-12">
            <div class="card">   
              <div class="table-responsive">
                <table class="table table-hover">
                  <thead id="requestSubmitedDetailsHead">
                    <tr>
                      <th>Employee Name</th>
                      <th>Start date</th>
                      <th>End date</th>
                      <th>Reason</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody id="requestSubmitedDetailsBody">
                    @foreach($leavesSubitted as $ls)
                      <tr>
                        <td>{{ $ls->name }}</td>
                        <td>{{ $ls->fromDate }}</td>
                        <td>{{ $ls->toDate }}</td>
                        <td>{{ $ls->reason }}</td>
                        <td>
                          @if($ls->status == "denied")
                            <span class="badge rounded-pill badge-light-danger me-1">{{ $ls->status }}</span>
                          @elseif($ls->status == "pending")
                            <span class="badge rounded-pill badge-light-info me-1">{{ $ls->status }}</span>
                          @elseif($ls->status == "submitted")
                            <span class="badge rounded-pill badge-light-success me-1">{{ $ls->status }}</span>
                          @endif
                        </td>
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
@endsection