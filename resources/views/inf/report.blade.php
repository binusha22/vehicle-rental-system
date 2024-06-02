@extends('layouts.lay')
@section('title','Vehicle Booking')
@section('style')
{{-- <style>
 .titel{Margin-bottom:50px}

 /* .white-border {
    border: 2px solid #acacac;
    padding: 10px;
    border-radius: 5px;
    
  } */

    .icon-container {
      display: flex;
      justify-content: center;
      align-items: center;
      width: 100%;
      height: 100%;
    }




    body {
            margin: 10px;
            padding: 10px;
            font-family: sans-serif;
        }
       
       
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            /* margin-left: 20px;
            margin-Right: 20px; */
        }
        table thead th {
            height: 28px;
            text-align: left;
            font-size: 16px;
            font-family: sans-serif;
        }
        table, th, td {
            border: 3px solid #ddd;
            padding: 8px;
            font-size: 16px;
        }

        .heading {
            font-size: 24px;
            margin-top: 12px;
            margin-bottom: 12px;
            font-family: sans-serif;
        }
        .small-heading {
            font-size: 18px;
            font-family: sans-serif;
        }
        .total-heading {
            font-size: 18px;
            font-weight: 700;
            font-family: sans-serif;
        }
        .order-details tbody tr td:nth-child(1) {
            width: 20%;
        }
        .order-details tbody tr td:nth-child(3) {
            width: 20%;
        }

        .text-start {
            text-align: left;
        }
        .text-end {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .company-data span {
            margin-bottom: 4px;
            display: inline-block;
            font-family: sans-serif;
            font-size: 14px;
            font-weight: 400;
        }
        .no-border {
            border: 1px solid #fff !important;
        }
        .bg-blue {
            background-color: #414ab1;
            color: #fff;
        }
  </style> --}}


@endsection
@section('content')


 
<div class="content-body">
<section id="input-group-basic" >
<div class="row mt-4">

 <!-- 01. Vehicle Income Report -->
 <div class="col-md-3">
        <div class="card" style="border: 2px solid #7b68ee; height: 380px;"> 
          <div class="card-body" style="display: flex; flex-direction: column; justify-content: center; align-items: center; height: 100%;">
            
          <div class="text-center">  
              <h3 style="font-weight: bold;">01. Vehicle Income Report</h3>
            </div>

            <div class="icon-container mt-4" style="margin-top: 1rem;">
    <i class="fa-solid fa-car" style="font-size: 6rem;"></i>
</div>


            <div class="text-center mt-2 mb-2" style="margin-top: 0.5rem; margin-bottom: 0.5rem;"> 
              <p class="card-text item-description">
                This report provides a comprehensive overview of income generated from vehicle-related activities within a specified time period.
              </p>
            </div>
          </div>

          <div class="d-flex justify-content-center pt-1" style="text-align: center;">
            <button type="button" class="btn btn-primary btn-cart move-cart" href="javascript:;" data-bs-target="#Report1" data-bs-toggle="modal">
              <i data-feather="download"></i>
              <span class="add-to-cart">Get The Report</span>
            </button>
          </div>
        </div>
      </div>


     <!-- 02. Employe Salary Report -->
      <div class="col-md-3">
        <div class="card" style="border: 2px solid #7b68ee; height: 380px;"> 
          <div class="card-body" style="display: flex; flex-direction: column; justify-content: center; align-items: center; height: 100%;">
            
          <div class="text-center" style="margin-top: 28px;">  
              <h3 style="font-weight: bold;">02. Employe Salary Report</h3>
            </div>

            <div class="icon-container mt-3" style="margin-top: 1rem;">
              <i data-feather="users" style="width: 100px; height: 100px;"></i>
            </div>

            <div class="text-center mt-2 mb-2" style="margin-top: 0.5rem; margin-bottom: 0.5rem;"> 
              <p class="card-text item-description">
              The Employee Salary Report provides a salary payments made to employees within a specified period, facilitating transparent payroll management.            </div>
          </div>

          <div class="d-flex justify-content-center pt-1" style="text-align: center;">
            <button type="button" class="btn btn-primary btn-cart move-cart" href="javascript:;" data-bs-target="#Report2" data-bs-toggle="modal">
              <i data-feather="download"></i>
              <span class="add-to-cart">Get The Report</span>
            </button>
          </div>
        </div>
      </div>

<!-- 03 Owner Payment Report -->
<div class="col-md-3">
        <div class="card" style="border: 2px solid #7b68ee; height: 380px;"> 
          <div class="card-body" style="display: flex; flex-direction: column; justify-content: center; align-items: center; height: 100%;">
            
          <div class="text-center" >  
              <h3 style="font-weight: bold;">03. Owner Payment Report</h3>
            </div>

            <div class="icon-container mt-2" style="margin-top: 2rem;">
           <i class="fa-solid fa-address-book" style="font-size: 6rem;"></i>
           </div>
            
            <div class="text-center mt-3 mb-2" style="margin-top: 0.5rem; margin-bottom: 0.5rem;"> 
              <p class="card-text item-description">
              The Vehicle Owner Payment Report offers insights into payments made to vehicle owners  within a specified period              </p>
            </div>
          </div>

          <div class="d-flex justify-content-center pt-1" style="text-align: center;">
            <button type="button" class="btn btn-primary btn-cart move-cart" href="javascript:;" data-bs-target="#Report3" data-bs-toggle="modal">
              <i data-feather="download"></i>
              <span class="add-to-cart">Get The Report</span>
            </button>
          </div>
        </div>
      </div>

  <!-- 04. Customer Payment Report -->
  <div class="col-md-3">
        <div class="card" style="border: 2px solid #7b68ee; height: 380px;"> 
          <div class="card-body" style="display: flex; flex-direction: column; justify-content: center; align-items: center; height: 100%;">
            
          <div class="text-center">  
              <h3 style="font-weight: bold;">04. Customer Payment Report</h3>
            </div>

            <div class="icon-container mt-2" style="margin-top: 1rem;">
           <i class="fa-solid fa-person-circle-check" style="font-size: 6rem;"></i>
           </div>

            <div class="text-center mt-3 mb-2" style="margin-top: 0.5rem; margin-bottom: 0.5rem;"> 
              <p class="card-text item-description">
              The Customer Payment Report offers a detailed summary of all payments received from customers within a specified time frame.
              </p>
            </div>
          </div>

          <div class="d-flex justify-content-center pt-1" style="text-align: center;">
            <button type="button" class="btn btn-primary btn-cart move-cart" href="javascript:;" data-bs-target="#Report4" data-bs-toggle="modal" >
              <i data-feather="download"></i>
              <span class="add-to-cart">Get The Report</span>
            </button>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>



 <!-- 01. Vehicle Income Report popup --> 
<div class="modal fade" id="Report1" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
    <div class="modal-content">
    <div class="modal-header bg-transparent">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="text-center mb-2" >
          <h1 class="mb-1">Vehicle Income Report</h1>
        </div> 

        <div style="position: right: 0; width: 100%; border-top: 2px solid; border-image: linear-gradient(to right, #f8f8ff 5%, #7b68ee 90%) 2;"></div>


      <div class="modal-body pb-5 px-sm-5 pt-50">
  <form id="editUserForm" class="row gy-1 pt-75 white-border mt-3" onsubmit="return false">
    <div class="col-12 col-md-6">
            <label class="form-label" for="modalEditUserStatus">Vehicle Number</label>
            <select
              id="vnumber_vehicle_income"
              name="modalEditUserStatus"
              class="form-select"
              aria-label="Default select example"
            >
              <option value="">Select</option>

              @foreach($vehicleNumbers as $vn)
              <option value="{{$vn->vehicle_number}}">{{$vn->vehicle_number}}</option>
              @endforeach
              

              
            </select>
          </div>

          <div class="col-12 col-md-6">
            <label class="form-label" for="modalEditUserStatus">Vehicle Name</label>
            <select
              id="vname_vehicle_income"
              name="modalEditUserStatus"
              class="form-select"
              aria-label="Default select example"
            >
            <option value="">Select</option>
              
              @foreach($vehicleNumbers as $vname)
              <option value="{{$vname->vehicle_number}}">{{$vname->brand}} {{$vname->model}}</option>
              @endforeach
            </select>
          </div>


          <div class="col-12 col-md-6">
            <label class="form-label" for="large-select">Start Date</label>
              <div class="input-group">
                <input
                    type="text"
                    id="start_date_vehicle_income"
                    name="start_date"
                    class="form-control flatpickr-basic"
                    placeholder="Search Date"
                    
                  />
                </div>
              </div>

              <div class="col-12 col-md-6">
              <label class="form-label" for="large-select">End Date</label>
              <div class="input-group">
                <input
                    type="text"
                    id="end_date_vehicle_income"
                    name="end_date"
                    
                    class="form-control flatpickr-basic"
                    placeholder="Search Date"
                  />
                </div>
              </div>

         
        </form>


      

      
<div class="table-responsive mb-2 mt-4" style="max-height: 500px;overflow-y: auto;">
     <table class="table table-hover" id="vehicleIncometTable">
        <thead>
            
            <tr class="bg-blue">
                <th>Vehicle Number</th>
                <th>Income</th>
            </tr>
        </thead>
        <tbody id="vehicleIncometTableBody">
            <tr>
                <td width="25%"></td>
                <td width="20%" class="fw-bold"></td>
            </tr>

            
            
        </tbody>
    </table>
    </div>
     <label class="form-label" id="vehicleIncometTableLable"></label>
    </div>
    </div>


    </div>
  </div>
</div>
<!--/ Edit User Modal -->
{{-- vehicle Income payment report --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#vnumber_vehicle_income').change(function() {
        var number = $(this).val();

        if (number) {
            $.ajax({
                url: '/vehicle-income-report',
                type: 'GET',
                data: {
                    vnumber: number,
                },
                dataType: 'json', // Specify the expected response data type
                success: function(response) {
                    // Clear the table body
                    $('#vehicleIncometTableBody').empty();

                    var totalAmount = 0;
                    // Populate the table with the fetched data
                    $.each(response.data, function(index, data) {
                        var amount = parseFloat(data.final_amount) || 0;
                        totalAmount += amount;

                        var row = '<tr>' +
                            '<td width="20%">' + data.vehicle_number + '</td>' +
                            '<td width="20%" class="fw-bold">' + data.final_amount + '</td>' +
                            '</tr>';
                        $('#vehicleIncometTableBody').append(row);
                    });

                    // Update the total amount display
                    $('#vehicleIncometTableLable').text('Total Amount: ' + totalAmount.toFixed(2));

                    // Set the dropdown value for vehicle name
                    if (response.vname) {
                        console.log(response.vname);
                        $('#vname_vehicle_income').val(response.vname);
                    }
                },
                error: function(error) {
                    console.log('Error:', error);
                }
            });
        } else {
            // Clear the table body if no customer is selected
            $('#vehicleIncometTableBody').empty();

            var row = '<tr>' +
                '<td width="20%" colspan="5">No data found</td>' +
                '</tr>';
            $('#vehicleIncometTableBody').append(row);
            $('#vehicleIncometTableLable').text('Total Amount: 0');
        }
    });
});
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#vname_vehicle_income').change(function() {
        var number = $(this).val();

        if (number) {
            $.ajax({
                url: '/vehicle-income-report',
                type: 'GET',
                data: {
                    vnumber: number,
                },
                dataType: 'json', // Specify the expected response data type
                success: function(response) {
                    // Clear the table body
                    $('#vehicleIncometTableBody').empty();

                    var totalAmount = 0;
                    // Populate the table with the fetched data
                    $.each(response.data,function(index, data) {
                        var amount = parseFloat(data.final_amount) || 0;
                        totalAmount += amount;

                        var row = '<tr>' +
                            '<td width="20%">' + data.vehicle_number + '</td>' +
                            '<td width="20%" class="fw-bold">' + data.final_amount + '</td>' +
                            '</tr>';
                        $('#vehicleIncometTableBody').append(row);
                    });

                    // Update the total amount display
                    $('#vehicleIncometTableLable').text('Total Amount: ' + totalAmount.toFixed(2));
                },
                error: function(error) {
                    console.log('Error:', error);
                }
            });
        } else {
            // Clear the table body if no customer is selected
            $('#vehicleIncometTableBody').empty();

            var row = '<tr>' +
                       '<td width="20%" colspan="5">no data found</td>' +
                        '</tr>';
                        $('#vehicleIncometTableBody').append(row);
            $('#vehicleIncometTableLable').text('Total Amount: 0');
        }
    });
});
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#end_date_vehicle_income').change(function() {
        var number = $('#vnumber_vehicle_income').val();
        var sdate =$('#start_date_vehicle_income').val();
        var edate =$('#end_date_vehicle_income').val();

        if (number) {
            $.ajax({
                url: '/vehicle-income-report-datewise',
                type: 'GET',
                data: {
                    vnumber: number,
                    startDate:sdate,
                    endDate:edate
                },
                dataType: 'json', // Specify the expected response data type
                success: function(response) {
                    // Clear the table body
                    $('#vehicleIncometTableBody').empty();

                    var totalAmount = 0;
                    // Populate the table with the fetched data
                    $.each(response.data,function(index, data) {
                        var amount = parseFloat(data.final_amount) || 0;
                        totalAmount += amount;

                        var row = '<tr>' +
                            '<td width="20%">' + data.vehicle_number + '</td>' +
                            '<td width="20%" class="fw-bold">' + data.final_amount + '</td>' +
                            '</tr>';
                        $('#vehicleIncometTableBody').append(row);
                    });

                    // Update the total amount display
                    $('#vehicleIncometTableLable').text('Total Amount: ' + totalAmount.toFixed(2));
                },
                error: function(error) {
                    console.log('Error:', error);
                }
            });
        } else {
            // Clear the table body if no customer is selected
            $('#vehicleIncometTableBody').empty();

            var row = '<tr>' +
                       '<td width="20%" colspan="5">no data found</td>' +
                        '</tr>';
                        $('#vehicleIncometTableBody').append(row);
            $('#vehicleIncometTableLable').text('Total Amount: 0');
        }
    });
});
</script>


<!-- 01.  Employe Salary Report popup --> 
<div class="modal fade" id="Report2" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
    <div class="modal-content">
    <div class="modal-header bg-transparent">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="text-center mb-2" >
          <h1 class="mb-1"> Employe Salary Report</h1>
        </div> 

        <div style="position: right: 0; width: 100%; border-top: 2px solid; border-image: linear-gradient(to right, #f8f8ff 5%, #7b68ee 90%) 2;"></div>


      <div class="modal-body pb-5 px-sm-5 pt-50">
  <form id="editUserForm" class="row gy-1 pt-75 white-border mt-3" onsubmit="return false">
    
          <div class="col-12 col-md-6">
            <label class="form-label" for="modalEditUserStatus">Employe Name</label>
            <select
              id="emp_salary_names"
              name="modalEditUserStatus"
              class="form-select"
              aria-label="Default select example"
            >
            <option value="">Select</option>
            @foreach($empNames as $emp)
              <option value="{{$emp->id}}">{{$emp->fname}} {{$emp->lname}}</option>
            @endforeach
            </select>
          </div>


          <div class="col-12 col-md-6">
            <label class="form-label" for="large-select">Start Date</label>
              <div class="input-group">
                <input
                    type="text"
                    id="start_date_emp_salary"
                    name="start_date"
                    class="form-control flatpickr-basic"
                    placeholder="Search Date"
                    
                  />
                </div>
              </div>

              <div class="col-12 col-md-6">
              <label class="form-label" for="large-select">End Date</label>
              <div class="input-group">
                <input
                    type="text"
                    id="end_date_emp_salary"
                    name="end_date"
                    
                    class="form-control flatpickr-basic"
                    placeholder="Search Date"
                  />
                </div>
              </div>

          
        </form>


      

      
<div class="table-responsive mb-2 mt-4" style="max-height: 500px;overflow-y: auto;">
     <table class="table table-hover" id="empSalaryTable">
        <thead>
            
            <tr class="bg-blue">
                <th>Employe Name</th>
                <th>Get Leave </th>
                <th>OT Hours</th>
                <th>Salary</th>
            </tr>
        </thead>
        <tbody id="empSalaryTableBody">
            <tr>
                <td width="35%"></td>
                <td width="20%"></td>
                <td width="20%"></td>
                <td width="25%" class="fw-bold"></td>
            </tr>

        </tbody>
    </table>
    </div>
    </div>
    </div>


    </div>
  </div>
</div>
<!--/ Edit User Modal -->
{{-- empployee salary section report --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#emp_salary_names').change(function() {
        var name = $(this).val();

        if (name) {
            $.ajax({
                url: '/salary-report',
                type: 'GET',
                data: {
                    empName: name,
                },
                dataType: 'json',
                success: function(response) {
                    // Clear the table body
                    $('#empSalaryTableBody').empty();

                    if (response.data && response.data.length > 0) {
                        // Populate the table with the fetched data
                        $.each(response.data, function(index, data) {
                            var row = '<tr>' +
                                '<td width="20%">' + data.name + '</td>' +
                                '<td width="20%" class="fw-bold">' + data.grant_leaves + '</td>' +
                                '<td width="20%" class="fw-bold">' + data.ot_hours + '</td>' +
                                '<td width="20%" class="fw-bold">' + data.salary + '</td>' +
                                '</tr>';
                            $('#empSalaryTableBody').append(row);
                        });
                    } else {
                        // Display "no data found" message
                        var row = '<tr>' +
                            '<td width="20%" colspan="4">No data found</td>' +
                            '</tr>';
                        $('#empSalaryTableBody').append(row);
                    }
                },
                error: function(error) {
                    console.log('Error:', error);
                    // Clear the table body and display error message if request fails
                    $('#empSalaryTableBody').empty();
                    var row = '<tr>' +
                        '<td width="20%" colspan="4">Error loading data</td>' +
                        '</tr>';
                    $('#empSalaryTableBody').append(row);
                }
            });
        } else {
            // Clear the table body if no name is selected
            $('#empSalaryTableBody').empty();
            var row = '<tr>' +
                '<td width="20%" colspan="4">No data found</td>' +
                '</tr>';
            $('#empSalaryTableBody').append(row);
        }
    });
});
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#end_date_emp_salary').change(function() {
        var edate = $(this).val();
        var sdate =$('#start_date_emp_salary').val();
        var uid =$('#emp_salary_names').val();

        if (edate) {
            $.ajax({
                url: '/salary-report-datewise',
                type: 'GET',
                data: {
                    empName: uid,
                    startDate:sdate,
                    endDate:edate
                },
                dataType: 'json', // Specify the expected response data type
                success: function(response) {
                    // Clear the table body
                    $('#empSalaryTableBody').empty();

                    var totalAmount = 0;
                    // Populate the table with the fetched data
                    $.each(response.data,function(index, data) {
                        

                        var row = '<tr>' +
                            '<td width="20%">' + data.name + '</td>' +
                            '<td width="20%" class="fw-bold">' + data.grant_leaves + '</td>' +
                            '<td width="20%" class="fw-bold">' + data.ot_hours + '</td>' +
                            '<td width="20%" class="fw-bold">' + data.salary + '</td>' +
                            '</tr>';
                        $('#empSalaryTableBody').append(row);
                    });

                    
                },
                error: function(error) {
                    console.log('Error:', error);
                }
            });
        } else {
            // Clear the table body if no customer is selected
            $('#empSalaryTableBody').empty();

            var row = '<tr>' +
                       '<td width="20%" colspan="5">no data found</td>' +
                        '</tr>';
             $('#empSalaryTableBody').append(row);
            
        }
    });
});
</script>




<!-- 01. Vehicle Owner Payment Report popup --> 
<div class="modal fade" id="Report3" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
    <div class="modal-content">
    <div class="modal-header bg-transparent">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="text-center mb-2" >
          <h1 class="mb-1"> Vehicle Owner Payment Report</h1>
        </div> 

        <div style="position: right: 0; width: 100%; border-top: 2px solid; border-image: linear-gradient(to right, #f8f8ff 5%, #7b68ee 90%) 2;"></div>


      <div class="modal-body pb-5 px-sm-5 pt-50">
  <form id="editUserForm" class="row gy-1 pt-75 white-border mt-3" onsubmit="return false">
    <div class="col-12 col-md-6">
            <label class="form-label" for="modalEditUserStatus">Vehicle Number</label>
            <select
              id="ownerPay_vnumber"
              name="modalEditUserStatus"
              class="form-select"
              aria-label="Default select example"
            >
              <option value="">Select</option>
              @foreach($vehicleNumbers as $vn)
              <option value="{{$vn->vehicle_number}}">{{$vn->vehicle_number}}</option>
              @endforeach

              
            </select>
          </div>

          <div class="col-12 col-md-6">
            <label class="form-label" for="modalEditUserStatus">Owner Name</label>
            <select
              id="ownerPayNames"
              name="modalEditUserStatus"
              class="form-select"
              aria-label="Default select example"
            >
            <option value="">Select</option>
            @foreach($ownersNames as $owner)
              <option value="{{$owner->owner_name}}">{{$owner->owner_name}}</option>
            @endforeach
            </select>
          </div>


          <div class="col-12 col-md-6">
            <label class="form-label" for="large-select">Start Date</label>
              <div class="input-group">
                <input
                    type="text"
                    id="start_date_owner_pay"
                    name="start_date"
                    class="form-control flatpickr-basic"
                    placeholder="Search Date"
                    
                  />
                </div>
              </div>

              <div class="col-12 col-md-6">
              <label class="form-label" for="large-select">End Date</label>
              <div class="input-group">
                <input
                    type="text"
                    id="end_date_owner_pay"
                    name="end_date"
                    
                    class="form-control flatpickr-basic"
                    placeholder="Search Date"
                  />
                </div>
              </div>

        
        </form>


      

      
<div class="table-responsive mb-2 mt-4" style="max-height: 500px;overflow-y: auto;">
     <table class="table table-hover" id="ownerPaymentTable">
        <thead>
            
            <tr class="bg-blue">
                <th>Vehicle Number</th>
                <th>Owner Name</th>
                <th>Mileage</th>
                <th>Payment Date</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody id="ownerPaymentTableBody">
        <tr>
                <td width="25%"></td>
                <td width="35%">
                     
                </td>
                <td width="20%"></td>
                <td></td>
                <td width="25%" class="fw-bold"></td>
            </tr>

            
        </tbody>
    </table>
    </div>
    <label class="form-label" id="ownerreportTotal"></label>
    </div>
    </div>


    </div>
  </div>
</div>
<!--/ Edit User Modal -->
{{-- vehicle owner payment report --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#ownerPay_vnumber').change(function() {
        var number = $(this).val();

        if (number) {
            $.ajax({
                url: '/owner-payment-report',
                type: 'GET',
                data: {
                    vnumber: number,
                },
                dataType: 'json', // Specify the expected response data type
                success: function(response) {
                    // Clear the table body
                    $('#ownerPaymentTableBody').empty();

                    var totalAmount = 0;
                    // Populate the table with the fetched data
                    $.each(response.data,function(index, data) {
                        var amount = parseFloat(data.monthly_amount) || 0;
                        totalAmount += amount;

                        var row = '<tr>' +
                            '<td width="20%">' + data.vnumber + '</td>' +
                            '<td width="35%">' + data.owner_name + '</td>' +
                            '<td width="25%">' + data.new_mile + '</td>' +
                            '<td width="20%" class="fw-bold">' + data.previous_pay_date + '</td>' +
                            '<td width="20%" class="fw-bold">' + data.monthly_amount + '</td>' +
                            '</tr>';
                        $('#ownerPaymentTableBody').append(row);
                    });

                    // Update the total amount display
                    $('#ownerreportTotal').text('Total Amount: ' + totalAmount.toFixed(2));
                },
                error: function(error) {
                    console.log('Error:', error);
                }
            });
        } else {
            // Clear the table body if no customer is selected
            $('#ownerPaymentTableBody').empty();

            var row = '<tr>' +
                       '<td width="20%" colspan="5">no data found</td>' +
                        '</tr>';
                        $('#ownerPaymentTableBody').append(row);
            $('#ownerreportTotal').text('Total Amount: 0');
        }
    });
});
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#ownerPayNames').change(function() {
        var name = $(this).val();
        var number=$('#ownerPay_vnumber').val();

        if (name) {
            $.ajax({
                url: '/owner-payment-report',
                type: 'GET',
                data: {
                    name: name,
                    vnumber: number
                },
                dataType: 'json', // Specify the expected response data type
                success: function(response) {
                    // Clear the table body
                    $('#ownerPaymentTableBody').empty();

                    var totalAmount = 0;
                    // Populate the table with the fetched data
                    $.each(response.data,function(index, data) {
                        var amount = parseFloat(data.monthly_amount) || 0;
                        totalAmount += amount;

                        var row = '<tr>' +
                            '<td width="20%">' + data.vnumber + '</td>' +
                            '<td width="35%">' + data.owner_name + '</td>' +
                            '<td width="25%">' + data.new_mile + '</td>' +
                            '<td width="20%" class="fw-bold">' + data.previous_pay_date + '</td>' +
                            '<td width="20%" class="fw-bold">' + data.monthly_amount + '</td>' +
                            '</tr>';
                        $('#ownerPaymentTableBody').append(row);
                    });

                    // Update the total amount display
                    $('#ownerreportTotal').text('Total Amount: ' + totalAmount.toFixed(2));
                },
                error: function(error) {
                    console.log('Error:', error);
                }
            });
        } else {
            // Clear the table body if no customer is selected
            $('#ownerPaymentTableBody').empty();

            var row = '<tr>' +
                       '<td width="20%" colspan="5">no data found</td>' +
                        '</tr>';
                        $('#ownerPaymentTableBody').append(row);
            $('#ownerreportTotal').text('Total Amount: 0');
        }
    });
});
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#end_date_owner_pay').change(function() {
        var edate = $(this).val();
        var sdate = $('#start_date_owner_pay').val();
        var name = $('#ownerPayNames').val();
        var number=$('#ownerPay_vnumber').val();

        if (name) {
            $.ajax({
                url: '/owner-payment-report-datewise',
                type: 'GET',
                data: {
                    name: name,
                    vnumber: number,
                    startDate:sdate,
                    endDate:edate
                },
                dataType: 'json', // Specify the expected response data type
                success: function(response) {
                    // Clear the table body
                    $('#ownerPaymentTableBody').empty();

                    var totalAmount = 0;
                    // Populate the table with the fetched data
                    $.each(response.data,function(index, data) {
                        var amount = parseFloat(data.monthly_amount) || 0;
                        totalAmount += amount;

                        var row = '<tr>' +
                            '<td width="20%">' + data.vnumber + '</td>' +
                            '<td width="35%">' + data.owner_name + '</td>' +
                            '<td width="25%">' + data.new_mile + '</td>' +
                            '<td width="20%" class="fw-bold">' + data.previous_pay_date + '</td>' +
                            '<td width="20%" class="fw-bold">' + data.monthly_amount + '</td>' +
                            '</tr>';
                        $('#ownerPaymentTableBody').append(row);
                    });

                    // Update the total amount display
                    $('#ownerreportTotal').text('Total Amount: ' + totalAmount.toFixed(2));
                },
                error: function(error) {
                    console.log('Error:', error);
                }
            });
        } else {
            // Clear the table body if no customer is selected
            $('#ownerPaymentTableBody').empty();

            var row = '<tr>' +
                       '<td width="20%" colspan="5">no data found</td>' +
                        '</tr>';
                        $('#ownerPaymentTableBody').append(row);
            $('#ownerreportTotal').text('Total Amount: 0');
        }
    });
});
</script>



<!-- 01. Customer Payment Report popup --> 
<div class="modal fade" id="Report4" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
    <div class="modal-content">
    <div class="modal-header bg-transparent">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="text-center mb-2" >
          <h1 class="mb-1">Customer Payment Report</h1>
        </div> 

        <div style="position: right: 0; width: 100%; border-top: 2px solid; border-image: linear-gradient(to right, #f8f8ff 5%, #7b68ee 90%) 2;"></div>


      <div class="modal-body pb-5 px-sm-5 pt-50">
  <form id="editUserForm" class="row gy-1 pt-75 white-border mt-3" onsubmit="return false">
    
          <div class="col-12 col-md-6">
            <label class="form-label" for="modalEditUserStatus">Customer Name</label>
            <select
              id="cusname_report_name"
              name="cusname_report_name"
              class="form-select"
              aria-label="Default select example"
            >
            <option value="">select</option>
            @foreach($customerNames as $cn)
              <option value="{{$cn->cus_id}}">{{$cn->name}}</option>
              @endforeach
            </select>

          </div>


          <div class="col-12 col-md-6">
            <label class="form-label" for="large-select">Start Date</label>
              <div class="input-group">
                <input
                    type="text"
                    id="start_date_cus_report"
                    name="start_date_cus_report"
                    class="form-control flatpickr-basic"
                    placeholder="Search Date"
                    
                  />
                </div>
              </div>

              <div class="col-12 col-md-6">
              <label class="form-label" for="large-select">End Date</label>
              <div class="input-group">
                <input
                    type="text"
                    id="end_date_cus_report"
                    name="end_date_cus_report"
                    
                    class="form-control flatpickr-basic"
                    placeholder="Search Date"
                  />
                </div>
              </div>

         
        </form>


      

      
<div class="table-responsive mb-2 mt-4" style="max-height: 500px;overflow-y: auto;">
     <table class="table table-hover" id="customerReport">
        <thead>
            <tr class="bg-blue">
                <th>Invoice Number</th>
                <th>Customer Name</th>
                <th>Payment Date</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody id="customerReportBody">
            <tr>
                <td width="20%"></td>
                <td width="35%">
                    
                </td>
                <td width="25%"></td>
                <td width="20%" class="fw-bold"></td>
            </tr>

            
        </tbody>
    </table>

    </div>
    <label class="form-label" id="cusreportTotal"></label>
    </div>
    </div>
        

    </div>
  </div>
</div>
<!--/ Edit User Modal -->





{{-- get data to customer report --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#cusname_report_name').change(function() {
        var customerId = $(this).val();

        if (customerId) {
            $.ajax({
                url: '/customer-payments-report',
                type: 'GET',
                data: {
                    cusid: customerId
                },
                dataType: 'json', // Specify the expected response data type
                success: function(response) {
                    // Clear the table body
                    $('#customerReportBody').empty();

                    var totalAmount = 0;
                    // Populate the table with the fetched data
                    $.each(response.payments, function(index, payment) {
                        var amount = parseFloat(payment.final_amount) || 0;
                        totalAmount += amount;

                        var row = '<tr>' +
                            '<td width="20%">' + payment.invoice_number + '</td>' +
                            '<td width="35%">' + payment.customer_name + '</td>' +
                            '<td width="25%">' + payment.payment_date + '</td>' +
                            '<td width="20%" class="fw-bold">' + payment.final_amount + '</td>' +
                            '</tr>';
                        $('#customerReportBody').append(row);
                    });

                    // Update the total amount display
                    $('#cusreportTotal').text('Total Amount: ' + totalAmount.toFixed(2));
                },
                error: function(error) {
                    console.log('Error:', error);
                }
            });
        } else {
            // Clear the table body if no customer is selected
            $('#customerReportBody').empty();

            var row = '<tr>' +
                       '<td width="20%" colspan="4">no data found</td>' +
                        '</tr>';
                        $('#customerReportBody').append(row);
            $('#cusreportTotal').text('Total Amount: 0');
        }
    });
});
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#end_date_cus_report').change(function() {
        var end_date = $(this).val();
        var customerId = $('#cusname_report_name').val();
        var start_date = $('#start_date_cus_report').val();

        if (customerId) {
            $.ajax({
                url: '/customer-payments-report-datewise',
                type: 'GET',
                data: {
                    cusid: customerId,
                    sdate:start_date,
                    edate:end_date
                },
                dataType: 'json', // Specify the expected response data type
                success: function(response) {
                    // Clear the table body
                    $('#customerReportBody').empty();

                    var totalAmount = 0;
                    // Populate the table with the fetched data
                    $.each(response.payments, function(index, payment) {
                        var amount = parseFloat(payment.final_amount) || 0;
                        totalAmount += amount;

                        var row = '<tr>' +
                            '<td width="20%">' + payment.invoice_number + '</td>' +
                            '<td width="35%">' + payment.customer_name + '</td>' +
                            '<td width="25%">' + payment.payment_date + '</td>' +
                            '<td width="20%" class="fw-bold">' + payment.final_amount + '</td>' +
                            '</tr>';
                        $('#customerReportBody').append(row);
                    });

                    // Update the total amount display
                    $('#cusreportTotal').text('Total Amount: ' + totalAmount.toFixed(2));
                },
                error: function(error) {
                    console.log('Error:', error);
                }
            });
        } else {
            // Clear the table body if no customer is selected
            $('#customerReportBody').empty();

            var row = '<tr>' +
                       '<td width="20%" colspan="4">no data found</td>' +
                        '</tr>';
                        $('#customerReportBody').append(row);
            $('#cusreportTotal').text('Total Amount: 0');
        }
    });
});
</script>


{{-- vehicle owner payment --}}
@endsection