@extends('layouts.lay')
@section('title','user register')
@section('style')
<style>
  .setMargin{
    margin-top: 6rem;
  }
  .setWidth:hover{

    width: 100% !important;
  }
</style>

  
@endsection

@section('script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function(){
    $('#check1').click(function(){
        $('#check2').prop('checked', false);
    });

    $('#check2').click(function(){
        $('#check1').prop('checked', false);
    });
});
</script>
<script>
$(document).ready(function(){
    $('#check3').click(function(){
        $('#check4').prop('checked', false);
    });

    $('#check4').click(function(){
        $('#check3').prop('checked', false);
    });
});
</script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Get all the edit buttons
      const editUserForm = document.getElementById('editUserForm');
        const uid = document.getElementById('uid');
        const editButtons = document.querySelectorAll('.edit-user-btn');

        // Add click event listener to each edit button
        editButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                // Get the user id from the data attribute
                const userId = button.getAttribute('data-user-id');
                const username = button.getAttribute('data-user-u');
                const fname = button.getAttribute('data-user-f');
                const lname = button.getAttribute('data-user-l');
                const role = button.getAttribute('data-user-t');
                const email = button.getAttribute('data-user-e');
                const leave = button.getAttribute('data-user-ml');

                // Update the User ID input field in the modal
                const userIdInput = document.getElementById('userIdInput');
                const fname1 = document.getElementById('fname2');
                const lname1 = document.getElementById('lname2');
                const username1 = document.getElementById('username2');
                const email1 = document.getElementById('email2');
                const leave1 = document.getElementById('leave2');
                const role1 = document.getElementById('type2');

                uid.value = userId;
                userIdInput.value = userId;
                fname1.value = fname;
                lname1.value = lname;
                username1.value = username;
                email1.value = email;
                leave1.value = leave;
                role1.value = role;
                editUserForm.action = `/admin/users_update/${userId}`;
            });
        });
    });
</script>
<script>
  function viewMsg(){
    alert('comming soon');
  }
</script>
@endsection
@section('content')

@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    
    
    <section id="multiple-column-form">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Register User Here</h4>
        </div>
        @if(Session::has('s'))
            <div class="toastqq" id="toastqq">{{session('s')}}</div>
            @endif
            @if(Session::has('f'))
            <div class="toastHH" id="toastHH">{{session('f')}}</div>
            @endif
        <div class="card-body">
          <form class="form" action="{{route('register-user')}}" method="POST">
          
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
                    placeholder="john"
                    
                    tabindex="1"
                    autofocus
                  />
                    <span class="text-danger">@error('fname'){{$message}}@enderror</span>
                </div>
              </div>
              <div class="col-md-6 col-12">
                <div class="mb-1">
                <label for="lname" class="form-label">Last Name</label>
                    <input
                      type="text"
                      class="form-control"
                      id="lname"
                      name="lname"
                      value="{{old('lname')}}"
                      placeholder="waruna"
                      
                      tabindex="1"
                      autofocus
                      />
                      <span class="text-danger">@error('lname'){{$message}}@enderror</span>
                </div>
              </div>
              <div class="col-md-6 col-12">
                <div class="mb-1">
                <label for="email" class="form-label">Email</label>
            <input
              type="text"
              class="form-control"
              id="email"
              name="email"
              value="{{old('email')}}"
              placeholder="john@example.com"
              aria-describedby="login-email"
              tabindex="1"
              autofocus
            />
            <span class="text-danger">@error('email'){{$message}}@enderror</span>
                </div>
              </div>
              <div class="col-md-6 col-12">
                <div class="mb-1">
                <label for="username" class="form-label">Username</label>
            <input
              type="text"
              class="form-control"
              id="username"
              name="username"
              placeholder="john@waruna12"
              value="{{old('username')}}"
              tabindex="1"
              autofocus
            />
            <span class="text-danger">@error('username'){{$message}}@enderror</span>
                </div>
              </div>
              <div class="col-md-6 col-12">
                <div class="mb-1">
                <div class="d-flex justify-content-between">
              <label class="form-label" for="login-password">Password</label>
              
            </div>
            <div class="input-group input-group-merge form-password-toggle">
              <input
                type="password"
                class="form-control form-control-merge"
                id="password"
                name="password"
                value="{{old('password')}}"
                tabindex="2"
                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                aria-describedby="login-password"
              />
              <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
            </div>
            <span class="text-danger">@error('password'){{$message}}@enderror</span>
                </div>
              </div>
              <div class="col-md-6 col-12">
                <div class="mb-1">
                <label class="form-label" for="type">Status Select</label>
                    <select class="form-select showHand" id="type" name="type">
                        <option value="admin">Admin</option>
                        <option value="manegment">Manegment</option>
                        <option value="employee">Employee</option>
                    </select>
                </div>
              </div>
              <div class="col-md-6 col-12">
                <div class="mb-1">
                <label for="username" class="form-label">Monthly Leaves</label>
            <input
              type="text"
              class="form-control"
              id="leave"
              name="leave"
              placeholder="******"
              value="{{old('leave')}}"
              tabindex="1"
              autofocus
            />
            <span class="text-danger">@error('leave'){{$message}}@enderror</span>
                </div>
              </div>
              <div class="col-12">
              <button class="btn btn-primary w-40 mt-1" tabindex="4">Submit</button>
                <button type="reset" class="btn btn-outline-secondary w-40 mt-1">Reset</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
       

        <div class="content-header row">
          <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
              <div class="col-12">
                <h2 class="content-header-title float-start mb-0">User Details</h2>
                <div class="breadcrumb-wrapper">
                  
                </div>
              </div>
            </div>
          </div>
          <div class="content-header-right text-md-end col-md-3 col-12 d-md-block d-none">
            
          </div>
        </div>
       


<!-- Hoverable rows start -->
<div class="row" id="table-hover-row">
  <div class="col-12">
    <div class="card">
      
      <div class="card-body">
        
      </div>
      <div class="table-responsive" style="max-height:450px">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>User Id</th>
              <th>Fullname</th>
              <th>Username</th>
              <th>Job role</th>
              <th>Monthly Leaves</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach($data as $data)
            <tr>
              <td>
                
                <span class="fw-bold">{{$data->id}}</span>
              </td>
              <td>
                
                <span class="fw-bold">{{$data->fname}}  {{$data->lname}}</span>
              </td>
              <td>{{$data->username}}</td>
              <td>
              {{$data->type}}
              </td>
              <td>
                @if($data->mleave==null)
                 <span class="badge rounded-pill badge-light-primary me-1">No leave</span>
              @else
              <span class="badge rounded-pill badge-light-primary me-1">
               
              {{$data->mleave}}
              
              
              </span>
              @endif
            </td>
              <td>
                <div class="dropdown">
                  <button type="button" class="btn btn-sm dropdown-toggle hide-arrow py-0" data-bs-toggle="dropdown">
                    <i data-feather="more-vertical"></i>
                  </button>
                  <div class="dropdown-menu dropdown-menu-end">
                    <button class="dropdown-item edit-user-btn setWidth" href="#"

                     data-user-id="{{ $data->id }}" 
                     data-user-f="{{ $data->fname }}" 
                     data-user-l="{{ $data->lname }}" 
                     data-user-u="{{ $data->username }}" 
                     data-user-t="{{ $data->type }}" 
                     data-user-ml="{{ $data->mleave }}" 
                     data-user-e="{{ $data->email }}" 
                     data-bs-toggle="modal" data-bs-target="#editUser">
                      <i data-feather="edit-2" class="me-50"></i>
                      <span>Edit</span>
                  </button>
                  <form action="{{ route('delete_user', ['id' => $data->id]) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="dropdown-item setWidth" href="#" >
                      <i data-feather="trash" class="me-50"></i>
                      <span>Delete</span>
                    </button>
                  </form>
                  </div>
                </div>
              </td>
            </tr>
            @endforeach
            
            
          </tbody>
        </table>
      </div>
    </div>
 
<!-- Hoverable rows end -->
           <!-- Edit User Modal -->
<div class="modal fade" id="editUser" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user col-md-12">
    <div class="modal-content">
      <div class="modal-header bg-transparent">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body pb-5 px-sm-5 pt-50">
        <div class="text-center mb-2">
          <h1 class="mb-1">Edit User Information</h1>
          
        </div>
        <form action="{{ route('users_update', ['id' => 0]) }}" method="post" id="editUserForm">
          <input type="hidden" id="uid" name="uid" value="">
          @csrf
          @method('PUT')
          <div class="col-12 col-md-6">
            <label class="form-label" for="">User Id : </label>
            <input type="text" id="userIdInput" name="userIdInput" class="form-control" value="" >
          </div>
          <div class="col-12 col-md-6">
            <label class="form-label" for="modalEditUserFirstName">First Name</label>
            <input
              type="text"
              id="fname2"
              name="fname2"
              class="form-control"
              placeholder="waruna"
              value=""
              
            />
          </div>
          <div class="col-12 col-md-6">
            <label class="form-label" for="modalEditUserLastName">Last Name</label>
            <input
              type="text"
              id="lname2"
              name="lname2"
              class="form-control"
              placeholder="madushanka"
              value=""
              data-msg="Please enter your last name"
            />
          </div>
          <div class="col-12 col-md-6">
            <label class="form-label" for="modalEditUserName">Username</label>
            <input style="margin-left: 10px;" class="form-check-input" type="radio" id="check1" name="check2" value="keep" checked />
            <label class="form-label" for="check1">Keep :</label>
            <input class="form-check-input" type="radio" id="check2" name="check2" value="new" />
            <label class="form-label" for="check1">New :</label>
            <input
              type="text"
              id="username2"
              name="username2"
              class="form-control"
              value=""
              placeholder="waruna.candu.007"
            />
          </div>
          <div class="col-12 col-md-6">
            <label class="form-label" for="modalEditUserEmail">Email:</label>
            <input style="margin-left: 10px;" class="form-check-input" type="radio" id="check3" name="check" value="keep" checked />
            <label class="form-label" for="check1">Keep :</label>
            <input class="form-check-input" type="radio" id="check4" name="check" value="new" />
            <label class="form-label" for="check1">New :</label>
            <input
              type="text"
              id="email2"
              name="email2"
              class="form-control"
              
              placeholder="waruna@domain.com"
            />
          </div>
           <div class="col-md-6 col-12">
                <div class="mb-1">
                <div class="d-flex justify-content-between">
              <label class="form-label" for="login-password">Password</label>
              
            </div>
            <div class="input-group input-group-merge form-password-toggle">
              <input
                type="password"
                class="form-control form-control-merge"
                id="password2"
                name="password2"
                value=""
                tabindex="2"
                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                aria-describedby="login-password"
              />
              <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
            </div>
            
                </div>
              </div>
          <div class="col-12 col-md-6">
            <label class="form-label" for="modalEditUserStatus">Status</label>
            <select
              id="type2"
              name="type2"
              class="form-select"
              aria-label="Default select example"
            >
              <option value="admin">Admin</option>
                        <option value="manegment">Manegment</option>
                        <option value="employee">Employee</option>
              
            </select>
          </div>
          <div class="col-12 col-md-6">
            <label class="form-label" for="modalEditTaxID">Monthly leave</label>
            <input
              type="text"
              id="leave2"
              name="leave2"
              class="form-control modal-edit-tax-id"
              placeholder="2"
             
            />
          </div>
          
          <div class="col-12 text-center mt-2 pt-50">
            <button type="submit" class="btn btn-primary me-1">Submit</button>
            <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">
              Discard
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!--/ Edit User Modal -->


@endsection

