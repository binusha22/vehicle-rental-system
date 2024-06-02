@extends('layouts.lay')
@section('title','Display Overtime')
@section('style')
<style>
 .titel{Margin-bottom:50px
</style>
@endsection
@section('content')

<h3 class="titel mt-4 mb-2" style="color: #7367F0;">Employee Overtime Section</h3>
<section id="input-group-buttons">
                 
          <div class="row mt-1">
            <div class="col-md-1 mb-1">
            <div class="input-group">
                    {{-- <select class="select2-size-lg form-select" id="Employee-name" name="Employee-name">
                      <option value="">select </option>
                    @foreach($users as $us)
                    <option value="{{$us->id}}">{{$us->fname}} {{$us->lname}}</option>
                    @endforeach
                    
                  </select> --}}
                  <input
                type="text"
                class="form-control"
                id="Employee-name"
                name="Employee-name"
                placeholder="waruna"
                value="{{$userId}}"
                readonly
              />
             
                
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
      <form >
       
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
        

          </div>
          
      </form>
      </div>
          
     </div>
    </div>
   </div>
  </div>
 </div>

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
@endsection