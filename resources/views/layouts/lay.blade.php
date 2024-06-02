<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="loading dark-layout" lang="en" data-layout="dark-layout" data-textdirection="ltr">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
    <title>@yield('title','POS')</title>
    
    <link rel="apple-touch-icon" href="{{asset('app-assets/images/ico/apple-icon-120.html')}}">
    <link rel="shortcut icon" type="image/x-icon" href="https://pixinvent.com/demo/vuexy-html-bootstrap-admin-template/app-assets/images/ico/favicon.ico">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">
   
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.3.2/firebase.js"></script>
<script>
    var firebaseConfig = {
        apiKey: "AIzaSyB5hNs3jVfFa0wCAmOM6NYj3nOH1OkcK-M",
  authDomain: "avotas-4baef.firebaseapp.com",
  projectId: "avotas-4baef",
  storageBucket: "avotas-4baef.appspot.com",
  messagingSenderId: "1075691338592",
  appId: "1:1075691338592:web:01e83b377c656d82463c05",
  measurementId: "G-SCGJWFC8C8"
    };
    firebase.initializeApp(firebaseConfig);
    const messaging = firebase.messaging();
    function startFCM() {
        messaging
            .requestPermission()
            .then(function () {
                return messaging.getToken()
            })
            .then(function (response) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '{{ route("store.token") }}',
                    type: 'POST',
                    data: {
                        token: response
                    },
                    dataType: 'JSON',
                    success: function (response) {
                        alert('Token stored.');
                    },
                    error: function (error) {
                        alert(error);
                    },
                });
            }).catch(function (error) {
                alert(error);
            });
    }
    messaging.onMessage(function (payload) {
        const title = payload.notification.title;
        const options = {
            body: payload.notification.body,
            icon: payload.notification.icon,
        };
        new Notification(title, options);
    });
</script>


    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/vendors.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/fonts/font-awesome/css/font-awesome.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/extensions/jstree.min.css')}}">
    <!-- END: Vendor CSS-->
    @notifyCss


    <script src="https://js.pusher.com/beams/1.0/push-notifications-cdn.js"></script>
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.css">

    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/plugins/forms/pickers/form-pickadate.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/pickers/pickadate/pickadate.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css')}}">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/core/menu/menu-types/vertical-menu.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/plugins/extensions/ext-component-tree.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/pages/app-file-manager.min.css')}}">
    <!-- END: Page CSS-->
    @yield('style')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" rel="stylesheet">
    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/style.css')}}">
    <!-- END: Custom CSS-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Latest compiled and minified CSS -->
    <!-- <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script> -->
    <style>

  .toastqq {
    position: fixed;
    top: 50px;
    right: 50px; /* Adjust this value to set the distance from the right edge */
    transform: translateX(100%); /* Start off-screen */
    color: white;
    padding: 15px 20px;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    z-index: 9999;
    opacity: 0;
    transition: opacity 0.5s ease-in-out, transform 0.5s ease-in-out;
    max-width: 90%; /* Set maximum width */
    width: 300px; /* Set default width */
   background: #4776E6;  /* fallback for old browsers */
background: -webkit-linear-gradient(to right, #8E54E9, #4776E6);  /* Chrome 10-25, Safari 5.1-6 */
background: linear-gradient(to right, #8E54E9, #4776E6); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */


}

.toastHH {
    position: fixed;
    top: 50px;
    right: 50px; /* Adjust this value to set the distance from the right edge */
    transform: translateX(100%); /* Start off-screen */
    color: white;
    padding: 15px 20px;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    z-index: 9999;
    opacity: 0;
    transition: opacity 0.5s ease-in-out, transform 0.5s ease-in-out;
    max-width: 90%; /* Set maximum width */
    width: 300px; /* Set default width */
   background: #D31027;  /* fallback for old browsers */
background: -webkit-linear-gradient(to right, #EA384D, #D31027);  /* Chrome 10-25, Safari 5.1-6 */
background: linear-gradient(to right, #EA384D, #D31027); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */



}
@media (max-width: 600px) {
    .toastHH {
        width: 70%; /* Adjust width for smaller screens */
    }
    .toastqq {
        width: 70%; /* Adjust width for smaller screens */
    }
}
.show {
    opacity: 1;
    transform: translateX(0); /* Move onto the screen */
}
.setWidth:hover{

    width: 100% !important;
  }
  </style>
  
<style>
        .brand-text {
            font-size: 3em; /* Adjust the font size as needed */
            font-weight: bold;
        }

        .avotas {
            
            color: black;
        }

        .autofleet {
            
            color: red;
        }
    </style>

  </head>
  <!-- END: Head-->

  <!-- BEGIN: Body-->
  <body class="vertical-layout vertical-menu-modern content-left-sidebar navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="content-left-sidebar">
  
 

    @include('layouts.header')

     @if(Session::has('s'))
 <div class="toastqq" id="toastqq">{{session('s')}}</div>
@endif

@if(Session::has('f'))
<div class="toastHH" id="toastHH">{{session('f')}}</div>
                
@endif
     
    <!-- BEGIN: Main Menu-->
    <div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true">
      <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
          <li class="nav-item me-auto"><a class="navbar-brand" href="index-2.html"><span class="brand-logo">
            </span>
              <h2 class="brand-text">
    <span class="avotas">Avotas</span><br>
    <span class="autofleet">autofleet</span>
</h2>
          </a></li>
          <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pe-0" data-bs-toggle="collapse"><i class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i><i class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary" data-feather="disc" data-ticon="disc"></i></a></li>
        </ul>
      </div>
      <div class="shadow-bottom"></div>
      <div class="main-menu-content" style="margin-top:50px;">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
@if(session('type')=='admin')

        <li class=" nav-item nav-item {{ request()->is('admin/dashboard') ? 'active' : '' }}"><a class="d-flex align-items-center" href="{{route('admin.dashboard')}}"><i class="fa-solid fa-user-tie"></i><span class="menu-title text-truncate" data-i18n="Form Layout">Admin DashBoard</span></a>
        </li>
        <li class="nav-item has-submenu">
            <a class="d-flex align-items-center" href="#">
                <i class="fa-solid fa-warehouse"></i>
                <span class="menu-title text-truncate" data-i18n="Form Elements">Registration</span>
            </a>
            <ul class="menu-content">
                
                <li>
                    <a class="d-flex align-items-center {{ request()->is('admin/register') ? 'active' : '' }}" href="{{route('admin.register')}}">
                        <i data-feather="circle"></i>
                        <span class="menu-item text-truncate" data-i18n="Input Mask">User Registraion</span>
                    </a>
                </li>
                <li>
                    <a class="d-flex align-items-center {{ request()->is('car_registration') ? 'active' : '' }}" href="{{route('car_registration')}}">
                        <i data-feather="circle"></i>
                        <span class="menu-item text-truncate" data-i18n="Textarea">Car Registration</span>
                    </a>
                </li>
                <li>
                    <a class="d-flex align-items-center {{ request()->is('customer_registration') ? 'active' : '' }}" href="{{ route('customer_registration') }}">
                        <i data-feather="circle"></i>
                        <span class="menu-item text-truncate" data-i18n="Textarea">Customer Registraion</span>
                    </a>
                </li>
            </ul>
        </li>

<li class="nav-item has-submenu">
    <a class="d-flex align-items-center" href="#">
        <i class="fa-solid fa-warehouse"></i>
        <span class="menu-title text-truncate" data-i18n="Form Elements">Vehicle Maintain</span>
    </a>
    <ul class="menu-content">
        <li>
            <a class="d-flex align-items-center {{ request()->is('vehicle-liecence-renew') ? 'active' : '' }}" href="{{ route('vehicle-liecence-renew') }}">
                <i data-feather="circle"></i>
                <span class="menu-item text-truncate" data-i18n="Input Groups">Liecense Renew</span>
            </a>
        </li>
        <li>
            <a class="d-flex align-items-center {{ request()->is('vehicle-insuarence-renew') ? 'active' : '' }}" href="{{ route('vehicle-insuarence-renew') }}">
                <i data-feather="circle"></i>
                <span class="menu-item text-truncate" data-i18n="Input Mask">Insurance Renew</span>
            </a>
        </li>
        <li>
            <a class="d-flex align-items-center {{ request()->is('car_maintain') ? 'active' : '' }}" href="{{route('car_maintain')}}">
                <i data-feather="circle"></i>
                <span class="menu-item text-truncate" data-i18n="Input Mask">Vehicle Maintain & Fees</span>
            </a>
        </li>
        
    </ul>
</li>
<li class="nav-item has-submenu">
    <a class="d-flex align-items-center" href="#">
        <i class="fa-solid fa-warehouse"></i>
        <span class="menu-title text-truncate" data-i18n="Form Elements">Booking & Status</span>
    </a>
    <ul class="menu-content">
        
        <li>
            <a class="d-flex align-items-center {{ request()->is('booking') ? 'active' : '' }}" href="{{ route('booking') }}">
                <i data-feather="circle"></i>
                <span class="menu-item text-truncate" data-i18n="Input Mask">Booking</span>
            </a>
        </li>
        <li>
            <a class="d-flex align-items-center {{ request()->is('get-invoice') ? 'active' : '' }}" href="/get-invoice">
                <i data-feather="circle"></i>
                <span class="menu-item text-truncate" data-i18n="Input Mask">Invoices</span>
            </a>
        </li>
        <li>
            <a class="d-flex align-items-center {{ request()->is('tripdetails') ? 'active' : '' }}" href="{{route('tripdetails')}}">
                <i data-feather="circle"></i>
                <span class="menu-item text-truncate" data-i18n="Textarea">Ongoing Booking</span>
            </a>
        </li>
        <li>
            <a class="d-flex align-items-center {{ request()->is('vehicle-replacement') ? 'active' : '' }}" href="{{ route('vehicle_replacement_page') }}">
                <i data-feather="circle"></i>
                <span class="menu-item text-truncate" data-i18n="Textarea">Booking Replacement</span>
            </a>
        </li>
    </ul>
</li>


<li class="nav-item {{ request()->is('vehicle-status') ? 'active' : '' }}" >
    <a class="d-flex align-items-center" href="{{ route('vehicle-status') }}">
        <i class="fa-solid fa-person-circle-check"></i>
        <span class="menu-title text-truncate" data-i18n="Form Layout">Vehicle Status</span>
    </a>
</li>
<li class="nav-item has-submenu">
    <a class="d-flex align-items-center" href="#">
        <i class="fa-solid fa-warehouse"></i>
        <span class="menu-title text-truncate" data-i18n="Form Elements">Employee Management</span>
    </a>
    <ul class="menu-content">
        <li>
            <a class="d-flex align-items-center {{ request()->is('employee-attendence') ? 'active' : '' }}" href="{{route('employee-attendence')}}">
                <i data-feather="circle"></i>
                <span class="menu-item text-truncate" data-i18n="Input Groups">Employee Attendence</span>
            </a>
        </li>
        <li>
            <a class="d-flex align-items-center {{ request()->is('manage_employee') ? 'active' : '' }}" href="{{route('manage_employee')}}">
                <i data-feather="circle"></i>
                <span class="menu-item text-truncate" data-i18n="Input Mask">Manage Employee</span>
            </a>
        </li>
        <li>
            <a class="d-flex align-items-center{{ request()->is('assign_normal_task') ? 'active' : '' }}" href="{{route('assign_normal_task')}}">
                <i data-feather="circle"></i>
                <span class="menu-item text-truncate" data-i18n="Input Mask">Assign Task</span>
            </a>
        </li>
        
    </ul>
</li>
    
        <li class=" nav-item"><a class="d-flex align-items-center" href="#"><i class="fa-solid fa-warehouse"></i><span class="menu-title text-truncate" data-i18n="Form Elements">Payments</span></a>
            <ul class="menu-content">
              
              <li><a class="d-flex align-items-center {{ request()->is('customer-payments') ? 'active' : '' }}" href="{{route('customer-payments')}}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Input Groups">Customer Payments</span></a>
              </li>
              <li><a class="d-flex align-items-center {{ request()->is('owner_pay') ? 'active' : '' }}" href="{{route('owner_pay')}}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Input Groups">Owner Payments</span></a>
              </li> 
            

              
            </ul>
          </li>
        <li class=" nav-item {{ request()->is('reports') ? 'active' : '' }}"><a class="d-flex align-items-center " href="{{route('reports')}}"><i class="fa-solid fa-book-open"></i><span class="menu-title text-truncate" data-i18n="Form Layout">Report</span></a>
        </li>  
          <li class="nav-item" style="opacity: 0;">
                <a class="d-flex align-items-center" href="">
                <i class="fa-solid fa-book-open"></i>
                <span class="menu-title text-truncate" data-i18n="Form Layout">Report 2</span>
            </a>
        </li>


@elseif(session('type')=='employee')

            <li class=" nav-item {{ request()->is('show_task') ? 'active' : '' }}"><a class="d-flex align-items-center" href="{{route('show_task')}}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Input Groups">Show Taks</span></a>
        </li> 
        <li class="nav-item {{ request()->is('reuest_leave') ? 'active' : '' }}">
            <a class="d-flex align-items-center" href="{{ route('reuest_leave') }}">
                <i class="fa-solid fa-receipt"></i>
                <span class="menu-title text-truncate" data-i18n="Form Layout">Leave Request</span>
            </a>
        </li>
        <li class="nav-item {{ request()->is('fetch_overtime') ? 'active' : '' }}">
            <a class="d-flex align-items-center" href="{{ route('fetch_overtime') }}">
                <i class="fa-solid fa-receipt"></i>
                <span class="menu-title text-truncate" data-i18n="Form Layout">Display Overtime</span>
            </a>
        </li>
@else 
        
        <li class=" nav-item nav-item {{ request()->is('manegment-dashboard') ? 'active' : '' }}"><a class="d-flex align-items-center" href="{{route('manegment-dashboard')}}"><i class="fa-solid fa-user-tie"></i><span class="menu-title text-truncate" data-i18n="Form Layout">Dash Board</span></a>
        </li>
        <li class="nav-item has-submenu">
            <a class="d-flex align-items-center" href="#">
                <i class="fa-solid fa-warehouse"></i>
                <span class="menu-title text-truncate" data-i18n="Form Elements">Registration</span>
            </a>
            <ul class="menu-content">
                
                <li>
                    <a class="d-flex align-items-center {{ request()->is('car_registration') ? 'active' : '' }}" href="{{route('car_registration')}}">
                        <i data-feather="circle"></i>
                        <span class="menu-item text-truncate" data-i18n="Textarea">Car Registration</span>
                    </a>
                </li>
                <li>
                    <a class="d-flex align-items-center {{ request()->is('customer_registration') ? 'active' : '' }}" href="{{ route('customer_registration') }}">
                        <i data-feather="circle"></i>
                        <span class="menu-item text-truncate" data-i18n="Textarea">Customer Registraion</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item has-submenu">
    <a class="d-flex align-items-center" href="#">
        <i class="fa-solid fa-warehouse"></i>
        <span class="menu-title text-truncate" data-i18n="Form Elements">Vehicle Maintain</span>
    </a>
    <ul class="menu-content">
        <li>
            <a class="d-flex align-items-center {{ request()->is('vehicle-liecence-renew') ? 'active' : '' }}" href="{{ route('vehicle-liecence-renew') }}">
                <i data-feather="circle"></i>
                <span class="menu-item text-truncate" data-i18n="Input Groups">Liecense Renew</span>
            </a>
        </li>
        <li>
            <a class="d-flex align-items-center {{ request()->is('vehicle-insuarence-renew') ? 'active' : '' }}" href="{{ route('vehicle-insuarence-renew') }}">
                <i data-feather="circle"></i>
                <span class="menu-item text-truncate" data-i18n="Input Mask">Insurance Renew</span>
            </a>
        </li>
        <li>
            <a class="d-flex align-items-center {{ request()->is('car_maintain') ? 'active' : '' }}" href="{{route('car_maintain')}}">
                <i data-feather="circle"></i>
                <span class="menu-item text-truncate" data-i18n="Input Mask">Vehicle Maintain & Fees</span>
            </a>
        </li>
        
    </ul>
</li>
         
        
<li class="nav-item has-submenu">
    <a class="d-flex align-items-center" href="#">
        <i class="fa-solid fa-warehouse"></i>
        <span class="menu-title text-truncate" data-i18n="Form Elements">Booking & Status</span>
    </a>
    <ul class="menu-content">
        
        <li>
            <a class="d-flex align-items-center {{ request()->is('booking') ? 'active' : '' }}" href="{{ route('booking') }}">
                <i data-feather="circle"></i>
                <span class="menu-item text-truncate" data-i18n="Input Mask">Booking</span>
            </a>
        </li>
        <li>
            <a class="d-flex align-items-center {{ request()->is('get-invoice') ? 'active' : '' }}" href="/get-invoice">
                <i data-feather="circle"></i>
                <span class="menu-item text-truncate" data-i18n="Input Mask">Invoices</span>
            </a>
        </li>
        <li>
            <a class="d-flex align-items-center {{ request()->is('tripdetails') ? 'active' : '' }}" href="{{route('tripdetails')}}">
                <i data-feather="circle"></i>
                <span class="menu-item text-truncate" data-i18n="Textarea">Ongoing Booking</span>
            </a>
        </li>
        <li>
            <a class="d-flex align-items-center {{ request()->is('vehicle-replacement') ? 'active' : '' }}" href="{{ route('vehicle_replacement_page') }}">
                <i data-feather="circle"></i>
                <span class="menu-item text-truncate" data-i18n="Textarea">Booking Replacement</span>
            </a>
        </li>
    </ul>
</li>

<li class="nav-item {{ request()->is('vehicle-status') ? 'active' : '' }}" >
    <a class="d-flex align-items-center" href="{{ route('vehicle-status') }}">
        <i class="fa-solid fa-person-circle-check"></i>
        <span class="menu-title text-truncate" data-i18n="Form Layout">Vehicle Status</span>
    </a>
</li>

<li class="nav-item has-submenu">
    <a class="d-flex align-items-center" href="#">
        <i class="fa-solid fa-warehouse"></i>
        <span class="menu-title text-truncate" data-i18n="Form Elements">Employee Management</span>
    </a>
    <ul class="menu-content">
        <li>
            <a class="d-flex align-items-center {{ request()->is('employee-attendence') ? 'active' : '' }}" href="{{route('employee-attendence')}}">
                <i data-feather="circle"></i>
                <span class="menu-item text-truncate" data-i18n="Input Groups">Employee Attendence</span>
            </a>
        </li>
        <li>
            <a class="d-flex align-items-center {{ request()->is('manage_employee') ? 'active' : '' }}" href="{{route('manage_employee')}}">
                <i data-feather="circle"></i>
                <span class="menu-item text-truncate" data-i18n="Input Mask">Manage Employee</span>
            </a>
        </li>
        <li>
            <a class="d-flex align-items-center{{ request()->is('assign_normal_task') ? 'active' : '' }}" href="{{route('assign_normal_task')}}">
                <i data-feather="circle"></i>
                <span class="menu-item text-truncate" data-i18n="Input Mask">Assign Task</span>
            </a>
        </li>
        <li>
            <a class="d-flex align-items-center{{ request()->is('reuest_leave') ? 'active' : '' }}" href="{{ route('reuest_leave') }}">
                <i data-feather="circle"></i>
                <span class="menu-item text-truncate" data-i18n="Input Mask">Request Leave</span>
            </a>
        </li>
        <li>
            <a class="d-flex align-items-center{{ request()->is('show_task') ? 'active' : '' }}" href="{{route('show_task')}}">
                <i data-feather="circle"></i>
                <span class="menu-item text-truncate" data-i18n="Input Mask">Show Task</span>
            </a>
        </li>
    </ul>
</li>
 
        <li class=" nav-item"><a class="d-flex align-items-center" href="#"><i class="fa-solid fa-warehouse"></i><span class="menu-title text-truncate" data-i18n="Form Elements">Payments</span></a>
            <ul class="menu-content">
              
              <li><a class="d-flex align-items-center {{ request()->is('customer-payments') ? 'active' : '' }}" href="{{route('customer-payments')}}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Input Groups">Customer Payments</span></a>
              </li>
              <li><a class="d-flex align-items-center {{ request()->is('owner_pay') ? 'active' : '' }}" href="{{route('owner_pay')}}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Input Groups">Owner Payments</span></a>
              </li> 
            

              
            </ul>
          </li>
        <li class=" nav-item {{ request()->is('reports') ? 'active' : '' }}"><a class="d-flex align-items-center " href="{{route('reports')}}"><i class="fa-solid fa-book-open"></i><span class="menu-title text-truncate" data-i18n="Form Layout">Report</span></a>
        </li> 
          <li class="nav-item" style="opacity: 0;">
                <a class="d-flex align-items-center" href="">
                <i class="fa-solid fa-book-open"></i>
                <span class="menu-title text-truncate" data-i18n="Form Layout">Report 2</span>
            </a>
        </li>



@endif
        
          

        </ul>
        
      </div>
    </div>
    <!-- END: Main Menu-->

  <!-- BEGIN: Content-->
  <div class="app-content content">
      <div class="content-overlay"></div>
      <div class="header-navbar-shadow"></div>
      <div class="content-wrapper container-xxl p-0 " >

      @yield('content')
      
      </div>
    </div>
    </div>
</div>
   
@yield('content2')


    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>
    
    @include('layouts.footer')
    
    <!-- BEGIN: Vendor JS-->
    <script src="{{asset('app-assets/vendors/js/vendors.min.js')}}"></script>
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
    {{-- <script src="{{asset('app-assets/vendors/js/forms/select/select2.full.min.js')}}"></script>
    <script src="{{asset('app-assets/js/scripts/forms/form-select2.min.js')}}"></script> --}}
    
    


    <script>
      $(window).on('load',  function(){
        if (feather) {
          feather.replace({ width: 14, height: 14 });
        }
      })
    </script>
    @notifyJs
    @yield('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
    var toast = document.getElementById('toastqq');

    // Show the toast
    toast.classList.add('show');

    // Hide the toast after 5 seconds (5000 milliseconds)
    setTimeout(function() {
        toast.classList.remove('show');
    }, 5000);
});

    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
    var toast = document.getElementById('toastHH');

    // Show the toast
    toast.classList.add('show');

    // Hide the toast after 5 seconds (5000 milliseconds)
    setTimeout(function() {
        toast.classList.remove('show');
    }, 5000);
});

    </script>


  </body>
  {{-- <script>
        if (!!window.EventSource) {
            var source = new EventSource("/user-status-stream");

            source.onmessage = function(event) {
                var users = JSON.parse(event.data);
                var loggedInList = document.getElementById("logged-in-users");
                // var loggedOutList = document.getElementById("logged-out-users");

                loggedInList.innerHTML = "";
               

                users.forEach(function(user) {
                    var listItem = document.createElement("li");
                    listItem.textContent = user.fname;
                    loggedInList.appendChild(listItem);
                     
                });
            };
        } else {
            alert("Your browser does not support Server-Sent Events.");
        }
    </script> --}}
  <!-- END: Body-->
</html>