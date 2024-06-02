@extends('layouts.lay')
@section('title','User-Registration')

@section('style')
<link rel="apple-touch-icon" href="{{asset('app-assets/images/ico/apple-icon-120.html')}}">
    <link rel="shortcut icon" type="image/x-icon" href="https://pixinvent.com/demo/vuexy-html-bootstrap-admin-template/app-assets/images/ico/favicon.ico">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/vendors.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/fonts/font-awesome/css/font-awesome.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/extensions/jstree.min.css')}}">
    <!-- END: Vendor CSS-->
    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/bootstrap-extended.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/core/menu/menu-types/vertical-menu.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/colors.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/components.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/themes/dark-layout.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/themes/bordered-layout.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/themes/semi-dark-layout.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/plugins/forms/pickers/form-flat-pickr.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/plugins/forms/pickers/form-pickadate.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/pickers/pickadate/pickadate.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css')}}">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/core/menu/menu-types/vertical-menu.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/plugins/extensions/ext-component-tree.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/pages/app-file-manager.min.css')}}">
    <!-- END: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/pages/authentication.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/forms/select/select2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/plugins/forms/form-validation.css')}}">
    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/style.css')}}">
    <!-- END: Custom CSS-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        .showHand{
            cursor: pointer;
        }
        .setMargin{
          margin-left: 5px;
        }
    </style>
@endsection


@section('script')
<!-- BEGIN: Vendor JS-->
<script src="{{asset('app-assets/vendors/js/vendors.min.js')}}"></script>
   <script src="{{asset('app-assets/js/scripts/pages/auth-login.js')}}"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="{{asset('app-assets/vendors/js/extensions/jstree.min.js')}}"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="{{asset('app-assets/js/core/app-menu.min.js')}}"></script>
    <script src="{{asset('app-assets/js/core/app.min.js')}}"></script>
    <script src="{{asset('app-assets/js/scripts/customizer.min.js')}}"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <script src="{{asset('app-assets/js/scripts/pages/app-file-manager.min.js')}}"></script>
    <!-- END: Page JS-->
    <script src="{{asset('app-assets/vendors/js/pickers/pickadate/picker.js')}}"></script>
    <script src="{{asset('app-assets/vendors/js/pickers/pickadate/picker.date.js')}}"></script>
    <script src="{{asset('app-assets/vendors/js/pickers/pickadate/picker.time.js')}}"></script>
    <script src="{{asset('app-assets/vendors/js/pickers/pickadate/legacy.js')}}"></script>
    <script src="{{asset('app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js')}}"></script>
    <script src="{{asset('app-assets/js/scripts/forms/pickers/form-pickers.min.js')}}"></script>
    {{-- drop down --}}
    <script src="{{asset('app-assets/vendors/js/forms/select/select2.full.min.js')}}"></script>
    <script src="{{asset('app-assets/js/scripts/forms/form-select2.min.js')}}"></script> 

    <script>
      $(window).on('load',  function(){
        if (feather) {
          feather.replace({ width: 14, height: 14 });
        }
      })
    </script>
@endsection
@section('content')

<!-- Login basic -->
<div class="card col-md-6 col-12">
      <div class="card-body">
        
        <p class="card-text mb-2">Please sign-up to your account here</p>

        <form class="auth-login-form mt-2" action="{{route('register-user')}}" method="POST">
            @if(Session::has('s'))
            <div class="alert alert-sucess">
                {{Session::get('s')}}
            </div>
            
            @endif
            @if(Session::has('f'))
            <div class="alert alert-sucess">
                {{Session::get('f')}}
            </div>
            @endif
            @csrf
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
          <div class="mb-1">
            <label class="form-label" for="type">Status Select</label>
            <select class="form-select showHand" id="type" name="type">
                <option value="admin">Admin</option>
                <option value="user">User</option>
                <option value="emp">Employee</option>
            </select>
          </div>
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
          <!-- <div class="mb-1">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="remember" name="remember" tabindex="3" {{ old('remember') ? 'checked' : '' }}>
              <label class="form-check-label" for="remember"> Remember Me </label>
            </div>
          </div> -->
          <button class="btn btn-primary w-100 mt-1" tabindex="4">Submit</button>
        </form>

        

        
      </div>
    </div>
    <!-- /Login basic -->
    

        

      

@endsection



