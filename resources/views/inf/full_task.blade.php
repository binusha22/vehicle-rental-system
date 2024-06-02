@extends('layouts.lay')
@section('title','Employee Task management')
@section('style')
<style>
 .titel{Margin-bottom:40px}
</style>
@endsection
@section('content')
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
    $(document).ready(function () {
        // Event listener for clicking the "Assign Employee" link
        $(document).on('click', '#fetchDesc', function () {
            var tid = $(this).data('tid'); // Get the task ID from data-tid attribute
           
            // Make AJAX request to fetch description
            $.ajax({
                url: '/fetch-description/' + tid, // Adjust the URL based on your route
                type: 'GET',
                data: { tt: tid },
                success: function (response) {
                    console.log(response.task_desc);
                    $('#descID').val(response.taskid);
                    $('#taskDesc3').val(response.task_desc);
                },
                error: function (error) {
                    console.log(error);
                }
            });
        });      
    });
</script>

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
<h1 class="titel">Employee Task management </h1>

   
<section id="input-group-buttons">
<h4>Emplyee Task Assing</h4>

<div class="mb-0 mt-2">
<div class="card">
        <div class="card-body">
<form action="{{route('insert_normal_task')}}" method="post">
  @csrf
          <div class="row">
            <div class="col-md-3 mb-1  ">
            <label class="form-label" for="large-select">Select Emplyee</label>
              <div class="input-group">
                    <select class="select2-size-lg form-select" name="selctedEmp">
                    <option value="">Select</option>
                    @foreach($activeUsers as $au)
                    <option value="{{$au->user_id}}">{{$au->name}}</option>
                    @endforeach
                  </select>

              </div>
            </div>

            
            <div class="col-md-3 mb-1 ">
            <label class="form-label" for="large-select">Select Date</label>
              <div class="input-group">
                <input
                    type="text"
                    id=""
                    name="getDate"
                    class="form-control flatpickr-basic"
                    placeholder="Search Date"
                  />
                </div>
              </div>

            
     
     
     
      
          <div class=" mt-1 md-2 ">
                  <textarea
                  class="form-control"
                  id=""
                  name="Description"
                  rows="5"
                  placeholder="Description"
                ></textarea>
            </div>
           

            <div class="mt-3" id="buttonContainer" >
              <button type="submit" class="btn btn-primary">Submit</button>
              
            </div>
</div></form>
            </div>
            </div> 
  </section> 


  
     <div class="row mt-4">
     
            <div class="col-md-3 mb-1  ">
                    <div class="input-group">
                    <select class="select2-size-lg form-select" id="activeusers">
                    <option value="">Select</option>
                    @foreach($activeUsers as $au)
                    <option value="{{$au->user_id}}">{{$au->name}}</option>
                    
                    @endforeach
                    <option value="3">kamal</option>
                  </select>

                    
              </div>
            </div>

            
            <div class="col-md-3 mb-1 ">
            <div class="input-group">
                <input
                    type="text"
                    id="add_Date"
                    class="form-control flatpickr-basic"
                    placeholder="Search Date"
                  />

                    
                </div>
              </div>


   <div class="content-body">
    <div class="row mt-1 mb-2" id="basic-table">
        <div class="col-12">
            <div class="card">
                <div class="table-responsive" style="max-height: 600px; overflow-y: auto;width: 100%;">
  <table class="table table-hover">
    <thead>
      <tr>
        <th>Emplyee Name</th>
        <th>Date</th>
        <th>Task Type</th>
        <th>Description</th>
        <th>Task Status</th>
      </tr>
    </thead>
    <tbody id="taskShowBody">
      @forelse($task as $ts)
      <tr>
        <td>{{$ts->name}}</td>
        <td>{{$ts->date}}</td>
        <td>{{$ts->task_type}}</td>
        <td>
          <div class="d-flex justify-content- pt-0">
            <a href="javascript:;" class="btn btn-primary" style="width: 150px; height: 30px; display: flex; align-items: center; justify-content: center;" data-bs-target="#editUser" data-bs-toggle="modal"
              id="fetchDesc" 
              data-tid="{{$ts->id}}">
              Click here
            </a>
          </div>
        </td>
        <td>
          @if($ts->status=="uncomplete")
          <span class="badge rounded-pill badge-light-warning me-1">{{$ts->status}}</span>
          @else
          <span class="badge rounded-pill badge-light-success me-1">{{$ts->status}}</span>
          @endif
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="4" class="text-center">No data found</td>
      </tr>
      @endforelse
    </tbody>
  </table>
</div>

            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
  $(document).ready(function () {
    // Event handler for date change
    $('#add_Date').change(function () {
      var date1 = $(this).val();
      var emp = $('#activeusers').val();
      
      $.ajax({
        type: "GET",
        url: "{{ route('fetch_task_of_employee') }}",
        data: {
          name: emp,
          date: date1
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
      $('#taskShowBody').empty();

      // Check if data is empty
      if (data.length === 0) {
        var noDataMessage = `
          <tr>
            <td colspan="4" class="text-center">No data found</td>
          </tr>
        `;
        $('#taskShowBody').append(noDataMessage);
      } else {
        // Append data rows
        data.forEach(function (item) {
          var statusBadge = item.status === "uncomplete" 
            ? '<span class="badge rounded-pill badge-light-warning me-1">' + item.status + '</span>' 
            : '<span class="badge rounded-pill badge-light-success me-1">' + item.status + '</span>';
            
          var rowData = `
            <tr>
              <td>${item.name}</td>
              <td>${item.date}</td>
              <td>${item.task_type}</td>
              <td>
                <div class="d-flex justify-content- pt-0">
                  <a href="javascript:;" class="btn btn-primary" style="width: 150px; height: 30px; display: flex; align-items: center; justify-content: center;" data-bs-target="#editUser" data-bs-toggle="modal"
                  id="fetchDesc" 
                  data-tid="${item.id}">
                  Click here
                  </a>
                </div>
              </td>
              <td>${statusBadge}</td>
            </tr>
          `;
          $('#taskShowBody').append(rowData);
        });
      }
    }
  });
</script>




               


<div class="modal fade" id="editUser" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
    <div class="modal-content">
      <div class="modal-header bg-transparent">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body pb-5 px-sm-5 pt-50">
        <div class="tab-pane" id="vertical-pill-6" role="tabpanel" aria-labelledby="stacked-pill-6" aria-expanded="false">
          <div class="card">
            <h4>Description</h4>
           <div class="mt-1 md-2">
            <form method="post" action="{{route('edit_task_description')}}">
              @csrf
              <input type="text" class="d-none" name="descID" id="descID">
          <textarea class="form-control" id="taskDesc3" rows="2" name="taskDesc3" placeholder="Description for ready vehicle"></textarea>
          <button type="submit" class="btn btn-primary mt-1">Edit</button>
          </form>
          <span id="textareaErrorMessage3" class="text-danger"></span>
      </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection