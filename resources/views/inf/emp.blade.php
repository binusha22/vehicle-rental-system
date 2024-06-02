@extends('layouts.lay')
@section('title','Managment Dashboard')
@section('script')
 <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        var typingTimer; // Timer identifier
        var doneTypingInterval = 200; // Time in milliseconds (0.2 seconds)

        // Listen for input and keyup events on the input field
        $('#vnumber').on('input keyup', function () {
            clearTimeout(typingTimer); // Clear the previous timer

            // Start a new timer
            typingTimer = setTimeout(function () {
                // Get the value entered by the user
                var inputValue = $('#vnumber').val().trim();

                // Check if the input value is empty
                if (inputValue === '') {
                    $('#suggestionList').hide(); // Hide the suggestion list
                    $('.timeline-item').css('opacity', '1');
                } else {
                    // Make an AJAX request to fetch suggestion data
                    $.ajax({
                        type: "GET",
                        url: "/get-vehicle-suggestions", // Endpoint to fetch suggestions from
                        data: { query: inputValue }, // Send the input value to the server
                        success: function (response) {
                            console.log(response);
                            // Update the suggestion list with the received data
                            updateSuggestionList(response);
                        },
                        error: function (error) {
                            console.error('Error fetching suggestions:', error);
                        }
                    });
                }
            }, doneTypingInterval);
        });

        // Function to update the suggestion list with received data
        function updateSuggestionList(suggestions) {
            var suggestionList = $('#suggestionList');
            suggestionList.empty(); // Clear previous suggestions

            // Append new suggestions to the suggestion list
            suggestions.forEach(function (suggestion) {
                var listItem = $('<li class="list-group-item"></li>').text(suggestion);
                listItem.on('click', function () {
                    $('#vnumber').val(suggestion); // Set the value of the input field

                    // Make an AJAX request to fetch the status of the vehicle
                    $.ajax({
                        type: "GET",
                        url: "/get-vehicle-status", // Endpoint to fetch vehicle status
                        data: { vnumber: suggestion }, // Send the input value to the server
                        success: function (status) {
                            console.log('Vehicle Status:', status);
                            // Update the opacity of timeline items based on the status
                            updateTimelineOpacity(status);
                        },
                        error: function (error) {
                            console.error('Error fetching vehicle status:', error);
                        }
                    });
                    suggestionList.hide(); // Hide the suggestion list
                });
                suggestionList.append(listItem);
            });

            // Show the suggestion list
            suggestionList.show();
        }

        // Function to update the opacity of timeline items based on the vehicle status
        function updateTimelineOpacity(status) {
            // Reset opacity for all timeline items
            $('.timeline-item').css('opacity', '0.2');

            // Set opacity based on the status
            if (status === 'Yard in') {
                $('.timeline-item').eq(0).css('opacity', '5'); // Yard In
            } else if (status === 'Trip_out') {
                $('.timeline-item').eq(1).css('opacity', '5'); // Trip Out
            } else if (status === 'Body_Wash_out') {
                $('.timeline-item').eq(2).css('opacity', '5'); // Body Wash Out
            } else if (status === 'Service_out') {
                $('.timeline-item').eq(3).css('opacity', '5'); // Service Out
            } else if (status === 'Garage_out') {
                $('.timeline-item').eq(4).css('opacity', '5'); // Garage Out
            }
            // Add conditions for other statuses and update opacity accordingly
        }

        // Hide suggestion list when clicking anywhere on the page except the list and input field
        $(document).on('click', function (event) {
            var clickedElement = $(event.target);
            var suggestionList = $('#suggestionList');
            var inputField = $('#vnumber');

            if (!clickedElement.closest(suggestionList).length && !clickedElement.is(inputField)) {
                suggestionList.hide(); // Hide the suggestion list
            }
        });
    });
</script>





@endsection
@section('content')

   

<div class="row match-height">
  <!-- Congratulations Card -->
  <div class="col-12 col-md-4 col-lg-12" >
    <div class="card card-congratulations" style="background: red;">
    <div class="card-body text-center h-15 ">
        <!-- <img
          src="../../../app-assets/images/elements/decore-left.png"
          class="congratulations-img-left"
          alt="card-img-left"
        /> -->
        <img
          src="../../../app-assets/images/elements/decore-left.png"
          class="congratulations-img-right"
          alt="card-img-right"
        />
        
        <div class="text-center">
          <h1 class="mb-1 text-white">Welcome Avotas Auto Fleet</h1>
          <!-- <p class="card-text m-auto w-75">
            You have done <strong>57.6%</strong> more sales today. Check your new badge in your profile.
          </p> -->
        </div>
      </div>
    </div>
  </div>
  <!--/ Congratulations Card -->

  

<!-- Stats Vertical Card -->
<div class="row mt-2">
    
    <div style="max-width: 160px;" class="col-xl-0 col-md-5 col-sm-6">
      <div class="card text-center">
        <div class="card-body">
          <div class="avatar bg-light-warning p-50 mb-1">
            <div class="avatar-content">
              <i data-feather="users" class="font-medium-5"></i>
            </div>
          </div>
          <h2 class="fw-bolder">{{$countOfCustomers}}</h2>
          <p class="card-text">Registerd <br> Custommer</p>
        </div>
      </div>
    </div>

    <div class="col-xl-2 col-md-4 col-sm-6">
      <div class="card text-center">
        <div class="card-body">
          <div class="avatar bg-light-success p-50 mb-1">
            <div class="avatar-content">
              <i data-feather="users" class="font-medium-5"></i>
            </div>
          </div>
          <h2 class="fw-bolder">{{$countOfUser}}</h2>
          <p class="card-text">Registerd Employee</p>
        </div>
      </div>
    </div>

    <div style="max-width: 140px;"class="col-xl-0 col-md-4 col-sm-6">
      <div class="card text-center">
        <div class="card-body">
          <div class="avatar bg-light-danger p-50 mb-1">
            <div class="avatar-content">
              <i data-feather="book-open" class="font-medium-5"></i>
            </div>
          </div>
          <h2 class="fw-bolder">{{$countOfRecords}}</h2>
          <p class="card-text">Monthly Booking</p>
        </div>
      </div>
    </div>

    <div class="col-xl-2 col-md-4 col-sm-6">
      <div class="card text-center">
        <div class="card-body">
          <div class="avatar bg-light-info p-50 mb-1">
            <div class="avatar-content">
              <i data-feather="truck" class="font-medium-5"></i>
            </div>
          </div>
          <h2 class="fw-bolder">{{$countOfVehic}}</h2>
          <p class="card-text">Registerd vehicle</p>
        </div>
      </div>
    </div>

    <div class="col-xl-2 col-md-4 col-sm-6">
      <div class="card text-center">
        <div class="card-body">
          <div class="avatar bg-light-primary p-50 mb-1">
            <div class="avatar-content">
              <i data-feather="corner-right-down" class="font-medium-5"></i>
            </div>
          </div>
          <h2 class="fw-bolder">{{$countOfVehicIN}}</h2>
          <p class="card-text">Yard In Vehicle</p>
        </div>
      </div>
    </div>

    <div class="col-xl-2 col-md-4 col-sm-6">
      <div class="card text-center">
        <div class="card-body">
          <div class="avatar bg-light-success p-50 mb-1">
            <div class="avatar-content">
              <i data-feather="corner-right-up" class="font-medium-5"></i>
            </div>
          </div>
          <h2 class="fw-bolder">{{$countOfVehicOUT}}</h2>
          <p class="card-text">Yard Out Vehicle</p>
        </div>
      </div>
    </div>

    </div>





 
  <!-- Timeline Starts -->
<section>
    <div class="content-body">
        <section id="input-group-basic">
            <div class="row mt-4">
                <div class="col-md-5" style="padding-left: 28px;padding-right: 28px;">
                    <div class="row">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Tracker</h4>
                                <div class="col-md-8 mb-1">
                                    <div class="input-group">
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="vnumber"
                                            name="vnumber"
                                            value=""
                                            placeholder="LP-0987"
                                            value=""
                                        />
                                        <span class="input-group-text" id="searchButton"><i data-feather="search"></i></span>
                                    </div>
                                    <!-- Add the suggestion list below the input -->
                                    <div id="suggestionContainer" style="position: relative;">
                                        <ul id="suggestionList" class="list-group" style="display: none; position: absolute; top: 100%; left: 0; z-index: 1000;"></ul>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <ul class="timeline">
                                    <li class="timeline-item">
                                        <span class="timeline-point">
                                            <i data-feather="chevron-down"></i>
                                        </span>
                                        <div class="timeline-event">
                                            <div class="d-flex justify-content-between flex-sm-row flex-column mb-sm-0 mb-1">
                                                <h6>Yard In</h6>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="timeline-item">
                                        <span class="timeline-point timeline-point-info">
                                            <i data-feather="chevron-up"></i>
                                        </span>
                                        <div class="timeline-event">
                                            <div class="d-flex justify-content-between align-items-center mb-50">
                                                <h6>Trip Out</h6>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="timeline-item">
                                        <span class="timeline-point timeline-point-success">
                                            <i data-feather="file-text"></i>
                                        </span>
                                        <div class="timeline-event">
                                            <div class="d-flex justify-content-between flex-sm-row flex-column mb-sm-0 mb-1">
                                                <h6>Body Wash Out</h6>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="timeline-item">
                                        <span class="timeline-point timeline-point-warning">
                                            <i data-feather="map-pin"></i>
                                        </span>
                                        <div class="timeline-event">
                                            <div class="d-flex justify-content-between flex-sm-row flex-column mb-sm-0 mb-1">
                                                <h6 class="mb-50">Service Out</h6>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="timeline-item">
                                        <span class="timeline-point timeline-point-danger">
                                            <i data-feather="shopping-bag"></i>
                                        </span>
                                        <div class="timeline-event">
                                            <div class="d-flex justify-content-between flex-sm-row flex-column mb-sm-0 mb-1">
                                                <h6>Garage Out</h6>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Support Tracker Card -->
                <div class="col-lg-7 col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between pb-0">
                            <h4 class="card-title">Requested Bookings</h4>
                            <div class="dropdown chart-dropdown">
                                <button
                                    class="btn btn-sm border-0 dropdown-toggle p-50"
                                    type="button"
                                    id="dropdownItem4"
                                    data-bs-toggle="dropdown"
                                    aria-haspopup="true"
                                    aria-expanded="false"
                                >
                                    Last 7 Days
                                </button>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownItem4">
                                    <a class="dropdown-item" href="#">Last 28 Days</a>
                                    <a class="dropdown-item" href="#">Last Month</a>
                                    <a class="dropdown-item" href="#">Last Year</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            {{-- <div class="row">
                                <div class="col-sm-1 col-12 d-flex flex-column flex-wrap text-center">
                                    <h1 class="font-large-3 fw-bolder mt-2 mb-0">163</h1>
                                    <p class="card-text">Registered Vehicle</p>
                                </div>
                                <div class="col-sm-10 col-12 d-flex justify-content-center">
                                    <div id="support-tracker-chart"></div>
                                </div>
                            </div> --}}
                            <div class="d-flex justify-content-between">
                                {{-- <div class="text-center">
                                    <p class="card-text mb-50 mt-5">Yard In Vehicle </p>
                                    <span class="font-large-2 fw-bold">29</span>
                                </div>
                                <div class="text-center">
                                    <p class="card-text mb-50 mt-5">Yard Out Vehicle</p>
                                    <span class="font-large-2 fw-bold">63</span>
                                </div>
                                <div class="text-center">
                                    <p class="card-text mb-50 mt-5">Booking Vehicle </p>
                                    <span class="font-large-2 fw-bold">10</span>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</section>



    

@endsection
