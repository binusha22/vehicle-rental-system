    <!-- BEGIN: Header-->
   


    <nav class="header-navbar navbar navbar-expand-lg align-items-center floating-nav navbar-dark navbar-shadow container-xxl">
      <div class="navbar-container d-flex content">
        <div class="bookmark-wrapper d-flex align-items-center">
          <ul class="nav navbar-nav d-xl-none">
            <li class="nav-item"><a class="nav-link menu-toggle" href="#"><i class="ficon" data-feather="menu"></i></a></li>
          
          </ul>
         <a href="{{url('open-test')}}" style="color: whitesmoke;"> test miledge here</a>
          
        </div>
        <ul class="nav navbar-nav align-items-center ms-auto">
          
          <li class="nav-item d-none d-lg-block"><a class="nav-link nav-link-style"><i class="ficon" data-feather="sun"></i></a></li>
          <!-- <li class="nav-item nav-search"><a class="nav-link nav-link-search"><i class="ficon" data-feather="search"></i></a>
            <div class="search-input">
              <div class="search-input-icon"><i data-feather="search"></i></div>
              <input class="form-control input" type="text" placeholder="Explore Vuexy..." tabindex="-1" data-search="search">
              <div class="search-input-close"><i data-feather="x"></i></div>
              <ul class="search-list search-list-main"></ul>
            </div>
          </li> -->
          @if(session('type') == 'admin' || session('type') == 'manegment')
         
<li class="nav-item dropdown dropdown-notification me-25"><a class="nav-link" href="#" data-bs-toggle="dropdown"><i class="ficon" data-feather="bell"></i><span class="badge rounded-pill bg-danger badge-up">{{ $notificationCount }}</span></a>
            <ul class="dropdown-menu dropdown-menu-media dropdown-menu-end">
              <li class="dropdown-menu-header">
                <div class="dropdown-header d-flex">
                  <h4 class="notification-title mb-0 me-auto">Notifications</h4>
                  <div class="badge rounded-pill badge-light-primary">{{ $notificationCount }} New</div>
                </div>
              </li>
              <li class="scrollable-container media-list">
                @forelse($notificationsFromSession as $notification)
             @if(session('type') == 'admin' || session('type') == 'manegment')
                <a class="d-flex" href="#">
                  <div class="list-item d-flex align-items-start">
                    <div class="me-1">
                      <div class="avatar bg-light-success">
                        <div class="avatar-content"><i class="avatar-icon" data-feather="bell"></i></div>
                      </div>
                    </div>
                    <div class="list-item-body flex-grow-1">
                        @if($notification->source === 'liecence_renew')
                      <p class="media-heading">
                        <span class="fw-bolder">This {{$notification->vehicle_number}} car has liecense expiration soon on {{$notification->expire_date}}</span></p><small class="notification-text"> Date {{ $notification->created_at->toDateString() }}</small>
                        @elseif($notification->source === 'InsuRenew')
                        <p class="media-heading">
                        <span class="fw-bolder">This {{$notification->vehicle_number}} car has insuareance expiration soon on {{$notification->expire_date}}</span></p><small class="notification-text"> Date {{ $notification->created_at->toDateString() }}</small>
                        @endif
                    </div>
                  </div>
                </a>
                @endif
            @empty
                @if(session('type') == 'admin' || session('type') == 'manegment')
                    <p>No notifications</p>
                @else
                    <p>No notifications for regular users</p>
                @endif
            @endforelse
              </li>
              <li class="dropdown-menu-footer"><a class="btn btn-primary w-100" href="#">Show all notifications</a></li>
            </ul>
          </li>

          {{-- birthday notifications --}}
          <li class="nav-item dropdown dropdown-notification me-25"><a class="nav-link" href="#" data-bs-toggle="dropdown"><i class="ficon" data-feather="users"></i><span class="badge rounded-pill bg-danger badge-up">{{ $birthnotificationCount }}</span></a>
            <ul class="dropdown-menu dropdown-menu-media dropdown-menu-end">
              <li class="dropdown-menu-header">
                <div class="dropdown-header d-flex">
                  <h4 class="notification-title mb-0 me-auto">Notifications</h4>
                  <div class="badge rounded-pill badge-light-primary">{{ $birthnotificationCount }} New</div>
                </div>
              </li>
              <li class="scrollable-container media-list">
                @forelse($notificationsBirthday as $notification)
             @if(session('type') == 'admin' || session('type') == 'manegment')
                <a class="d-flex" href="#">
                  <div class="list-item d-flex align-items-start">
                    <div class="me-1">
                      <div class="avatar" style="background-color: pink;">
                        <div class="avatar-content"><i class="avatar-icon" data-feather="gift"></i></div>
                      </div>
                    </div>
                    <div class="list-item-body flex-grow-1">
                        
                      <p class="media-heading">
                        <span class="fw-bolder">Your Customer {{$notification->fname}} {{$notification->lname}} has upcoming birthday soon on {{$notification->dob}}</span></p><small class="notification-text"> Date {{ $notification->created_at->toDateString() }}</small>
                        
                    </div>
                  </div>
                </a>
                @endif
            @empty
                @if(session('type') == 'admin')
                    <p>No notifications</p>
                @else
                    <p>No notifications for regular users</p>
                @endif
            @endforelse
              </li>
              <li class="dropdown-menu-footer"><a class="btn btn-primary w-100" href="#">Show all notifications</a></li>
            </ul>
          </li>
@else

<li class="nav-item dropdown dropdown-notification me-25">
    <a class="nav-link" href="#" data-bs-toggle="dropdown">
        <i class="ficon" data-feather="bell"></i>
        <span class="badge rounded-pill bg-dark badge-up">{{ $notificationTaskCount }}</span>
    </a>
    <ul class="dropdown-menu dropdown-menu-media dropdown-menu-end">
        <li class="dropdown-menu-header">
            <div class="dropdown-header d-flex">
                <h4 class="notification-title mb-0 me-auto">Notifications</h4>
                <div class="badge rounded-pill badge-light-primary">{{ $notificationTaskCount }} New </div>
            </div>
        </li>
        <li class="scrollable-container media-list">
            @forelse($notificationsTask as $notification)
                
                    <a class="d-flex" href="#">
                        <div class="list-item d-flex align-items-start">
                            <div class="me-1">
                                <div class="avatar bg-light-info">
                                    <div class="avatar-content"><i class="avatar-icon" data-feather="bell"></i></div>
                                </div>
                            </div>
                            <div class="list-item-body flex-grow-1">
                                @if($notification->source === 'task')
                                    <p class="media-heading">
                                        <span class="fw-bolder">You have new task under Task Number :{{$notification->id}} </span>
                                    </p>
                                    {{-- <small class="notification-text"> Date {{ $notification->created_at->toDateString() }}</small> --}}
                                @elseif($notification->source === 'stask')
                                    <p class="media-heading">
                                        <span class="fw-bolder">You have new Service task under Task Number :{{$notification->id}} </span>
                                    </p>
                                    {{-- <small class="notification-text"> Date {{ $notification->created_at->toDateString() }}</small> --}}
                                @endif
                            </div>
                        </div>
                    </a>
                
            @empty
               
                    <p>No notifications</p>
                
            @endforelse
        </li>
        <li class="dropdown-menu-footer"><a class="btn btn-primary w-100" href="#">Show all notifications</a></li>
    </ul>
</li>

@endif













 
          <li class="nav-item dropdown dropdown-user"><a class="nav-link dropdown-toggle dropdown-user-link" id="dropdown-user" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <div class="user-nav d-sm-flex d-none">
              
        @if(session()->has('fname'))
                <span class="user-name fw-bolder">{{ session('fname') }}</span>
                @endif
                @if(session()->has('type'))
                <span class="user-status">{{ session('type') }}</span>
                @endif  
              </div><span class="avatar">
                {{-- <img class="round" src="../../../app-assets/images/portrait/small/avatar-s-11.jpg" alt="avatar" height="40" width="40"> --}}
                <div class="round" style="width: 40px;height: 40px;align-content: center;margin: 0px;"><h2 style="align-items: center;align-self: center;margin: 0px;font-size: 20px;align-content: center;margin-top: 5px;">{{ ucfirst(substr(session('fname'), 0, 1)) }}
</h2></div>
                <span class="avatar-status-online"></span></span></a>
            <div class="dropdown-menu dropdown-menu-end " aria-labelledby="dropdown-user" style="width: auto;">
                
               
                
                <a id="logout-button" class="dropdown-item" href="{{route('logout')}}"><i class="me-50" data-feather="power"></i> Logout</a>
                <a class="dropdown-item" href="#" onclick="startFCM()"><i class="me-50" data-feather="box"></i> Allow Notifications</a> 
            </div>
          </li>
        </ul>
      </div>
    </nav>
    
    <!-- END: Header-->