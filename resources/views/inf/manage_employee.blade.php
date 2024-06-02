@extends('layouts.lay')
@section('title','Manage Employee')
@section('style')
<style>
 .titel{Margin-bottom:40px}
</style>
@endsection
@section('script')
<script>
    $(document).ready(function() {
        // Attach event listener to dynamically created elements
        $(document).on("click", ".attendence", function() {
            var cusname = $(this).attr('data-cus'); // Use attr() to get data attribute value
            var cusid = $(this).attr('data-cusid'); 
            $("#getEmpname").val(cusname);
            $("#getEmpId").val(cusid);

            
        });
    });
</script>

{{-- get total ot --}}
<!-- Add this script in your blade view -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function () {
        // Attach event listeners to dropdowns and date pickers
        $('#sal-end-date').change(fetchData);

        function fetchData() {
            var empname = $('#Employee-name').val();
            var s_date = $('#sal-start-date').val();
            var e_date = $('#sal-end-date').val();

            // Make AJAX request without pagination parameters
            $.ajax({
                url: '{{ route('get-attendance') }}',
                type: 'GET',
                data: {
                    employee_name: empname,
                    start_date: s_date,
                    end_date: e_date
                },
                success: function (response) {
                    // Handle the response and update the table
                    updateTable(response);
                },
                error: function (error) {
                    console.log(error);
                }
            });
        }

        function updateTable(response) {
           

            
                // Set the values of input fields based on the response
                $('#Empname').val(response.employeeName);
                $('#monthlyOt').val(response.monthlyOt);
                $('#totalLeaves').val(response.leave);
                $('#EmpnId').val(response.uid);
                $('#gotLeaves').val(response.grantedLeaves);
                $('#restLeaves').val(response.restof);
            
        }
    });
</script>
{{-- get data from leave request table and set data in inputs --}}
<script>
    $(document).ready(function () {
    $(document).on("click", ".leaveRequest", function () {
        var name = $(this).data('name');
        var leaveid= $(this).data('luid');
        var td= $(this).data('td');
        var fd = $(this).data('fd');
        var req_leaves = $(this).data('req_leaves');
        var reason = $(this).data('reason');

        // console.log("Name:", name);
        // console.log("From Date:", fd);
        // console.log("To Date:", td);
        // console.log("Requested Leaves:", req_leaves);
        // console.log("Reason:", reason);
        // console.log("user id:", leaveid);

        // Assign values to input fields
        $("#req_empname").val(name);
        $("#req_s_date").val(fd);
        $("#req_e_date").val(td);
        $("#req_leaves").val(req_leaves);
        $("#req_reason").val(reason);
        $("#luid").val(leaveid);
    });
});

</script>

{{-- submit/deny leave section --}}
<script>
  document.getElementById("submitButton").addEventListener("click", function() {
    // Set the action URL for submitting the form
    document.getElementById("leaveForm").action = "{{ route('submit_leave') }}";

    // Submit the form
    document.getElementById("leaveForm").submit();
});


document.getElementById("denyButton").addEventListener("click", function() {
    // Set the action URL for denying the form
    document.getElementById("leaveForm").action = "{{ route('deny_leave') }}";

    // Submit the form
    document.getElementById("leaveForm").submit();
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
<h2 class="titel">Manage Employee</h2>


<section id="input-group-buttons">
                 
          <div class="row">
            <div class="col-md-3 mb-1 ">
              <div class="input-group">
              <select class="select2-size-lg form-select" id="attendenceEmp">
                    <option value="">Select</option>
                    @foreach($users as $us)
                    <option value="{{$us->id}}">{{$us->fname}} {{$us->lname}}</option>
                    @endforeach
                  </select>
              
                
              </div>
            </div>
            
            <div class="col-md-3 mb-1 ">
              <div class="input-group">
                <input
                    type="text"
                    id="getAttendenceDate"
                    class="form-control flatpickr-basic"
                    placeholder="Search Date"
                  />
                  
                </div>
              </div>
            </div>
   </section>


   <div class="row mt-0"  id="basic-table">
  <div class="content-body ">
  <div class="row mt-0" id="dark-table">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h5>Emplyee Working Details</h5>
      </div>
      
<div class="col-12">
    <div class="card">   
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Employee Name</th>
                        <th>On Time</th>
                        <th>Off Time</th>
                        <th>OT Hours</th>
                        <th>Date</th>
                        <th>Reason</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="attendenceBody">
                    @foreach($data as $data)
                    <tr class="attendence" data-cus="{{$data->name}}" data-cusid="{{$data->id}}">
                        <td>{{$data->name}}</td>
                        <td>{{$data->in_time}}</td>
                        <td>{{$data->out_time}}</td>
                        <td>{{$data->ot}}</td>
                        <td>{{$data->in_date}}</td>
                        <td>{{$data->desc}}</td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn btn-sm dropdown-toggle hide-arrow py-0" data-bs-toggle="dropdown">
                                    <i>Click</i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="#" class="btn btn-outline-primary" data-bs-target="#edit-2" data-bs-toggle="modal">
                                        
                                        <span>Edit</span>
                                    </a>
                                </div>
                            </div>
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

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
  $(document).ready(function () {
    // Event handler for date change
    $('#getAttendenceDate').change(function () {
      var date1 = $(this).val();
      var emp = $('#attendenceEmp').val();
      

      $.ajax({
        type: "GET",
        url: "{{ route('fetch_attendence_of_emp') }}",
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
      $('#attendenceBody').empty();

      // Check if data is empty
      if (data.length === 0) {
        var noDataMessage = `
          <tr>
            <td colspan="7" class="text-center">No data found</td>
          </tr>
        `;
        $('#attendenceBody').append(noDataMessage);
      } else {
        // Append data rows
        data.forEach(function (item) {
          var rowData = `
            <tr class="attendence" data-cus="${item.name}" data-cusid="${item.id}">
              <td>${item.name}</td>
              <td>${item.in_time}</td>
              <td>${item.out_time}</td>
              <td>${item.ot}</td>
              <td>${item.in_date}</td>
              <td>${item.desc}</td>
              <td>
                <div class="dropdown">
                  <button type="button" class="btn btn-sm dropdown-toggle hide-arrow py-0" data-bs-toggle="dropdown">
                    <i>Click</i>
                  </button>
                  <div class="dropdown-menu dropdown-menu-end">
                    <a class="dropdown-item" href="#" class="btn btn-outline-primary" data-bs-target="#edit-2" data-bs-toggle="modal">
                      
                      <span>Edit</span>
                    </a>
                  </div>
                </div>
              </td>
            </tr>
          `;
          $('#attendenceBody').append(rowData);
        });
      }
    }
  });
</script>


 
<!-- POPUP -->
<div class="modal fade" id="edit-2" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
      <div class="modal-content">
        <div class="modal-header bg-transparent">
          <button type="button"  class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body pb-5 px-sm-5 pt-50 ">
          <h2 class="mb-4" style="border-bottom: 1px solid #ccc; padding-bottom: 10px;">Edit Details</h2>
                  
          <form action="{{route('update_ot')}}" method="post">
          @csrf 
          <input
                type="hidden"
                class="form-control"
                id="getEmpId"
                name="getEmpId"
                
              />
          <div class="row">
            <div class="col-md-6 mb-1  ">
            <label class="form-label" for="large-select">Employee Name </label>
              <input
                type="text"
                class="form-control"
                id="getEmpname"
                name="getEmpname"
                placeholder="saman kumara"
              />
            </div>

            
            <div class="col-md-6 mb-1 ">
            <div class="mb-0">
              <label class="form-label" for="basic-default-name">Date</label>
              <input
                    type="text"
                    id="fp-range"
                    name="addDate"
                    class="form-control flatpickr-basic"
                    placeholder="Add Date"
                  />
                 
                </div>
            </div>
            </div>
        <div class="col-md-6 mb-1 ">
            <div class="mb-0">
              <label class="form-label" for="basic-default-name">OT Hours</label>
              <input
                type="text"
                class="form-control"
                id="basic-default-name"
                name="newOT"
                placeholder="h."
              />
            </div>
            </div>
              <div class="mt-2 mb-3">
              <button type="submit" class="btn btn-primary">Update</button>
              </div>

           </div>
         </form>
        </div>
      </div>
    </div>
  </div>
<!-- POP END  -->


<h3 class="titel mt-4 mb-2" style="color: #7367F0;">Employee Salary Section</h3>
<section id="input-group-buttons">
                 
          <div class="row mt-1">
            <div class="col-md-3 mb-1">
            <div class="input-group">
                    <select class="select2-size-lg form-select" id="Employee-name" name="Employee-name">
                      <option value="">select </option>
                    @foreach($users as $us)
                    <option value="{{$us->id}}">{{$us->fname}} {{$us->lname}}</option>
                    @endforeach
                    
                  </select>
             
                
              </div>
            </div>
            
            <div class="col-md-3 mb-1 ">
              <div class="input-group">
                <input
                    type="text"
                    id="sal-start-date"
                    name="sal-start-date"
                    class="form-control flatpickr-basic"
                    placeholder="Start Date"
                  />
                  
                </div>
              </div>

              <div class="col-md-3 mb-1 ">
              <div class="input-group">
                <input
                    type="text"
                    id="sal-end-date"
                    name="sal-end-date"
                    class="form-control flatpickr-basic"
                    placeholder="End Date"
                  />
                  
                </div>
              </div>
            </div>
   </section>


   <div class="row mt-0"  id="basic-table">
  <div class="content-body ">
  <div class="row mt-0" id="dark-table">
  <div class="col-12">
    <div class="card">
      
        
      <div class="card-header">
        <h5>Monthly OT & Leave Details</h5>
      </div>
      <form action="{{route('inset_salary')}}" method="post">
        @csrf
      <div class="card-body">
        <div class="row">
          <div class="col-md-3 col-12">
            <label class="form-label" for="basic-default-name">Employee Name</label>
              <div class="input-group">
              <input
                type="text"
                class="form-control"
                id="Empname"
                name="Empname"
                placeholder="waruna"
                readonly
              />
              </div>
            </div>
            <div class="col-md-3 col-12">
            <label class="form-label" for="basic-default-name">Employee ID</label>
              <div class="input-group">
              <input
                type="text"
                class="form-control"
                id="EmpnId"
                name="EmpnId"
                placeholder="0"
                readonly
              />
              </div>
            </div>
            <div class="col-md-3 col-12">
            <label class="form-label" for="basic-default-name">Monthly Over Time</label>
              <div class="input-group">
              <input
                type="text"
                class="form-control"
                id="monthlyOt"
                name="monthlyOt"
                placeholder="000000"
              />
              </div>
            </div>
        <div class="col-md-3 col-12">
            <label class="form-label" for="basic-default-name">Toal Monthly Leaves</label>
              <div class="input-group">
              <input
                type="text"
                class="form-control"
                id="totalLeaves"
                name="totalLeaves"
                placeholder="00"
              />
              </div>
            </div>
<div class="col-md-3 col-12">
            <label class="form-label" for="basic-default-name">Granded Leaves</label>
              <div class="input-group">
              <input
                type="text"
                class="form-control"
                id="gotLeaves"
                name="gotLeaves"
                placeholder="00"
              />
              </div>
            </div>
            <div class="col-md-3 col-12">
            <label class="form-label" for="basic-default-name">rest of the Leaves</label>
              <div class="input-group">
              <input
                type="text"
                class="form-control"
                id="restLeaves"
                name="restLeaves"
                placeholder="00"
              />
              </div>
            </div>
        <div class="col-md-3 col-12">
            <label class="form-label" for="basic-default-name">Monthly Salary(LKR)</label>
              <div class="input-group">
              <input
                type="text"
                class="form-control"
                id="basic-default-name"
                name="mSalary"
                placeholder="Rs."
              />
              </div>
            </div>

            <div class="col-md-3 col-12">
              <label class="form-label" for="basic-default-name">Date</label>
              <div class="input-group">
                <input
                    type="text"
                    id="fp-range"
                    name="salDate"
                    class="form-control flatpickr-basic"
                    placeholder=" Date"
                  />
                 
                </div>
              </div>


          </div>
          <button type="submit" class="btn btn-primary" style="margin-top: 10px;">Submit</button>
      </form>
      </div>
          
     </div>
    </div>
   </div>
  </div>
 </div>

 
             

 <section id="input-group-buttons">
                 
                 <div class="row mt-1">
                   <div class="col-md-3 mb-1">
                   <div class="input-group">
                           <select class="select2-size-lg form-select" id="salaryEmp">
                           <option value="">Select</option>
                           @foreach($users as $us)
                    <option value="{{$us->id}}">{{$us->fname}} {{$us->lname}}</option>
                    @endforeach
                         </select>
                    
                      
                     </div>
                   </div>
                   
                   <div class="col-md-3 mb-1 ">
                     <div class="input-group">
                       <input
                           type="text"
                           id="getSalaryDate"
                           class="form-control flatpickr-basic"
                           placeholder="Date"
                         />
                         
                       </div>
                     </div>
                   </div>
          </section>
       
       
          <div class="row mt-0"  id="basic-table">
         <div class="content-body ">
         <div class="row mt-0" id="dark-table">
         <div class="col-12">
           <div class="card">
             <div class="card-header">
               <h5>Monthly Salary Details</Details></h5>
             </div>
             
       <div class="col-12">
    <div class="card">   
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Employee Name</th>
                        <th>Date</th>
                        <th>Monthly Salary</th>
                    </tr>
                </thead>
                <tbody id="salaryBody">
                    @foreach($salary as $sd)
                    <tr>
                        <td>{{$sd->name}}</td>
                        <td>{{$sd->addDate}}</td>
                        <td>{{$sd->salary}}</td>
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

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
  $(document).ready(function () {
    // Event handler for date change
    $('#getSalaryDate').change(function () {
      var date1 = $(this).val();
      var emp = $('#salaryEmp').val();
      console.log("Date from dropdown: " + date1);
      console.log("Employee ID: " + emp);

      $.ajax({
        type: "GET",
        url: "{{ route('fetch_salary_of_emp') }}",
        data: {
          name: emp,
          date: date1
        },
        success: function (response) {
          //console.log(response);
          updateUI(response);
        },
        error: function (error) {
          console.log(error);
        }
      });
    });

    function updateUI(data) {
      // Clear previous data from the table
      $('#salaryBody').empty();

      // Check if data is empty
      if (data.length === 0) {
        var noDataMessage = `
          <tr>
            <td colspan="3" class="text-center">No data found</td>
          </tr>
        `;
        $('#salaryBody').append(noDataMessage);
      } else {
        // Append data rows
        data.forEach(function (item) {
          var rowData = `
            <tr>
              <td>${item.name}</td>
              <td>${item.addDate}</td>
              <td>${item.salary}</td>
            </tr>
          `;
          $('#salaryBody').append(rowData);
        });
      }
    }
  });
</script>














<h3 class="titel mt-4 mb-2" style="color: #7367F0;">Employee Leave Section</h3>

<section id="input-group-buttons">
                 
          <div class="row">
            <div class="col-md-3 mb-1 ">
              <div class="input-group">
              <select class="select2-size-lg form-select" id="getEmpidInleavSec">
                           <option value="">Select</option>
                            @foreach($users as $us)
                    <option value="{{$us->id}}">{{$us->fname}} {{$us->lname}}</option>
                    @endforeach
                    
                         </select>
              
                
              </div>
            </div>
            
          
   </section>


   <div class="row mt-0"  id="basic-table">
  <div class="content-body ">
  <div class="row mt-0" id="dark-table">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h5>Emplyee Leave Request</h5>
      </div>
      
<div class="col-12">
    <div class="card">   
      <div class="table-responsive">
        <table class="table table-hover">
          <thead id="leaveRequestHead">
            <tr>
              <th>Employee Name</th>
              <th>Start Date</th>
              <th>End Date</th>
              <th>Amount of Leave</th>
              <th>Number Of Requested Leave</th>
              <th>Granted Leave</th>
              <th>Rest of Leave</th>
              <th>Reason</th>
            </tr>
          </thead>
          <tbody id="leaveRequestBody">
            @foreach($leaves as $le)
            <tr class="leaveRequest" 
              data-name="{{$le->name}}"
              data-fromDate="{{$le->fromDate}}"
              data-fd="{{$le->fromDate}}"
              data-td="{{$le->toDate}}"
              data-luid="{{$le->id}}"
              data-req_leaves="{{$le->req_leaves}}"
              data-reason="{{$le->reason}}">
              <td>{{$le->name}}</td>
              <td>{{$le->fromDate}}</td>
              <td>{{$le->toDate}}</td>
              <td>{{$le->leaves}}</td>
              <td>{{$le->req_leaves}}</td>
              <td>{{$le->grantedLeaves}}</td>
              <td>{{$le->restLeaves}}</td>
              <td>{{$le->reason}}</td>
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
 
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
  $(document).ready(function () {
    // Event delegation for dynamically updated rows
    $(document).on("click", ".leaveRequest", function () {
      var name = $(this).data('name');
      var leaveid = $(this).data('luid');
      var td = $(this).data('td');
      var fd = $(this).data('fd');
      var req_leaves = $(this).data('req_leaves');
      var reason = $(this).data('reason');

      // Assign values to input fields
      $("#req_empname").val(name);
      $("#req_s_date").val(fd);
      $("#req_e_date").val(td);
      $("#req_leaves").val(req_leaves);
      $("#req_reason").val(reason);
      $("#luid").val(leaveid);
    });

    // AJAX request for filtering data
    $('#getEmpidInleavSec').change(function () {
      var name = $(this).val();
      console.log("val from dropdown: " + name);

      $.ajax({
        type: "GET",
        url: "{{ route('fetch_submited_data') }}",
        data: {
          name: name
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
      $('#leaveRequestBody').empty();

      // Check if data is empty
      if (data.length === 0) {
        var noDataMessage = `
          <tr>
            <td colspan="8" class="text-center">No data found</td>
          </tr>
        `;
        $('#leaveRequestBody').append(noDataMessage);
      } else {
        // Append data rows
        data.forEach(function (item) {
          var rowData = `
            <tr class="leaveRequest"
              data-name="${item.name}"
              data-fromDate="${item.fromDate}"
              data-fd="${item.fromDate}"
              data-td="${item.toDate}"
              data-luid="${item.id}"
              data-req_leaves="${item.req_leaves}"
              data-reason="${item.reason}">
              <td>${item.name}</td>
              <td>${item.fromDate}</td>
              <td>${item.toDate}</td>
              <td>${item.leaves}</td>
              <td>${item.req_leaves}</td>
              <td>${item.grantedLeaves}</td>
              <td>${item.restLeaves}</td>
              <td>${item.reason}</td>
            </tr>
          `;
          $('#leaveRequestBody').append(rowData);
        });
      }
    }
  });
</script>

 


 <section id="multiple-column-form">
  <div class="row mt-1">
    <div class="col-12">
     <form class="form" id="leaveForm" action="" method="post">
                     
             @csrf 
             <input
                    type="hidden"
                    class="form-control"
                    id="luid"
                    name="luid"
                    
                    
                   
                  />

            <div class="row">
              <div class="col-md-3 col-12">
                <div class="mb-1">
                <label for="fname" class="form-label">Employee Name</label>
                  <input
                    type="text"
                    class="form-control"
                    id="req_empname"
                    name="req_empname"
                    value=""
                    placeholder="Mr/Mis"
                    
                   
                  />
                    <span class="text-danger"></span>
                </div>
              </div>

              <div class="col-md-3 col-12">
                <div class="mb-1">
                <label class="form-label" for="fp-range">Start date</label>
                  <input
                    type="text"
                    id="req_s_date"
                    name="req_s_date"
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
                    id="req_e_date"
                    name="req_e_date"
                    class="form-control flatpickr-basic"
                    placeholder="YYYY-MM-DD"
                  />
                </div>
                </div>


              <div class="col-md-3 col-12">
                <div class="mb-1">
                <label for="username" class="form-label">Number of Request Leaves</label>
            <input
              type="text"
              class="form-control"
              id="req_leaves"
              name="req_leaves"
              placeholder="Days"
              value=""
             
            />
            <span class="text-danger"></span>
                </div>
              </div>


              <div class="col-md-3 col-12">
                <div class="mb-1">
                <label for="lname" class="form-label">Reson</label>
                    <input
                      type="text"
                      class="form-control"
                      id="req_reason"
                      name="req_reason"
                      value=""
                      placeholder="Type..."
                      
                      
                      />
                      <span class="text-danger"></span>
                </div>
              </div>

              <div class="col-12 mb-4">
            <button type="button" id="submitButton" class="btn btn-primary">Submit</button>
            <button type="button" id="denyButton" class="btn btn-primary">Deny</button>
        </div>

            </div>
          </form>
        </div>
     </div>
</section>




<section id="input-group-buttons">
                 
          <div class="row">
            <div class="col-md-3 mb-1 ">
              <div class="input-group">
              <select class="select2-size-lg form-select" id="requestSubmitEmp">
                           <option value="">Seleect</option>
                            @foreach($users as $us)
                    <option value="{{$us->id}}">{{$us->fname}} {{$us->lname}}</option>
                    @endforeach
                         </select>
              
                
              </div>
            </div>
            
            
   </section>


  <div class="row mt-0" id="basic-table">
  <div class="content-body">
    <div class="row mt-0" id="dark-table">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h5>Employee Leave Details</h5>
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

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
  $(document).ready(function () {
    $('#requestSubmitEmp').change(function () {
      var name = $(this).val();
      console.log("val from dropdown: " + name);

      $.ajax({
        type: "GET",
        url: "{{ route('fetch_submited_data') }}",
        data: {
          name: name
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
      $('#requestSubmitedDetailsBody').empty();

      // Check if data is empty
      if (data.length === 0) {
        var noDataMessage = `
          <tr>
            <td colspan="5" class="text-center">No data found</td>
          </tr>
        `;
        $('#requestSubmitedDetailsBody').append(noDataMessage);
      } else {
        // Append data rows
        data.forEach(function (item) {
          var statusBadgeClass;
          if (item.status === "denied") {
            statusBadgeClass = "badge-light-danger";
          } else if (item.status === "pending") {
            statusBadgeClass = "badge-light-info";
          } else if (item.status === "submitted") {
            statusBadgeClass = "badge-light-success";
          }

          var rowData = `
            <tr>
              <td>${item.name}</td>
              <td>${item.fromDate}</td>
              <td>${item.toDate}</td>
              <td>${item.reason}</td>
              <td><span class="badge rounded-pill ${statusBadgeClass} me-1">${item.status}</span></td>
            </tr>
          `;
          $('#requestSubmitedDetailsBody').append(rowData);
        });
      }
    }
  });
</script>




@endsection
