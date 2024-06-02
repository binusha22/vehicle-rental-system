@extends('layouts.lay')
@section('title','Vehicle Maintain & Service')
@section('script')
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function() {
        $('.status-button').click(function() {
            var staksId = $(this).data('staks-id');
            console.log(staksId);
            $.ajax({
                url: '/get-svalues-data',
                method: 'GET',
                data: { staks_id: staksId },
                success: function(response) {
                    // Clear existing accordion items
                    $('#accordionMargin').empty();

                    // Initialize an array to store unique types
                    var uniqueTypes = [];

                    // Loop through the response data to find unique types
                    response.svaluesData.forEach(function(item) {
                        if (!uniqueTypes.includes(item.type)) {
                            uniqueTypes.push(item.type);
                        }
                    });

                    // Loop through unique types and generate accordion items
                    uniqueTypes.forEach(function(type, index) {
                        // Filter svaluesData for items with the current type
                        var itemsWithType = response.svaluesData.filter(function(item) {
                            return item.type === type;
                        });

                        // Generate accordion header for the current type
                        var accordionHeader = '<h2 style="border:1px solid grey;margin-bottom:5px;"class="accordion-header" id="headingMargin' + index + '">' +
                                                '<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accordionMargin' + index + '" aria-expanded="false" aria-controls="accordionMargin' + index + '">' +
                                                  type +
                                                '</button>' +
                                              '</h2>';

                        // Generate accordion body for items with the current type
                        var accordionBody = '<div id="accordionMargin' + index + '" class="accordion-collapse collapse"  aria-labelledby="headingMargin' + index + '" data-bs-parent="#accordionMargin">' +
                                                '<div class="accordion-body" >' +
                                                    '<table class="table text-nowrap text-center border-bottom">' +
                                                        '<thead>' +
                                                            '<tr>' +
                                                                '<th><span>Check list</span></th>' +
                                                                '<th><span>Status</span></th>' +
                                                            '</tr>' +
                                                        '</thead>' +
                                                        '<tbody>';

                        itemsWithType.forEach(function(item) {
                            // Generate table row for each item
                          var badgeClass = item.status === 'complete' ? 'badge-light-success' : 'badge-light-warning';
                          var addd = item.status === 'complete' ? 'd' : '';
                            accordionBody += '<tr>' +
                                                '<td><span>' + item.checked_value + '</span></td>' +
                                                '<td><span class="badge rounded-pill ' + badgeClass +' me-1">' + item.status+addd+'</span></td>' +
                                            '</tr>';
                        });

                        // Close accordion body and append to the accordion container
                        accordionBody += '</tbody></table></div></div>';
                        $('#accordionMargin').append(accordionHeader + accordionBody);
                    });
                },
                error: function(xhr) {
                    console.error('Error:', xhr.responseText);
                }
            });
        });
    });
</script>


{{-- //get vehicle names --}}
<script>
    $(document).ready(function() {
        $('#vnumber').change(function() {
            var selectedVehicleNumber = $(this).val();
            
            // Fetch the CSRF token from the meta tag
            var token = $('meta[name="csrf-token"]').attr('content');
            
            $.ajax({
                url: "{{ route('get_vehicle_names') }}",
                type: "POST",
                data: { vnumber: selectedVehicleNumber },
                headers: {
                    'X-CSRF-TOKEN': token // Include CSRF token in the headers
                },
                success: function(response) {
                    $('#vname').val(response.vehicleName);
                },
                error: function(xhr) {
                    console.error('Error:', xhr.responseText);
                }
            });
        });
    });
</script>
<script>
    $(document).ready(function() {
    $('#vnumber2').change(function() {
        var selectedVehicleNumber = $(this).val();
        
        //

        // Fetch the CSRF token from the meta tag
        var token = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: "{{ route('get_vehicle_names_for') }}",
            type: "POST",
            data: { vnumber2: selectedVehicleNumber },
            headers: {
                'X-CSRF-TOKEN': token // Include CSRF token in the headers
            },
            success: function(response) {
                $('#vname2').val(response.vehicleName);
                 
        $('#vn2').val('');
        $("#cost2").val('');
                $("#desc2").val('');
                $("#date2").val('');
            },
            error: function(xhr) {
                console.error('Error:', xhr.responseText);
            }
        });
    });
});

</script>

<script>
  // Function to handle the "Select All" checkbox within each tab
  function handleSelectAll(tabId, selectAllId) {
    // Get all checkboxes within the specified tab
    var checkboxes = document.querySelectorAll('#' + tabId + ' input[type="checkbox"]');
    var selectAllCheckbox = document.getElementById(selectAllId);

    // Loop through each checkbox and check/uncheck based on the state of the "Select All" checkbox
    checkboxes.forEach(function(checkbox) {
      checkbox.checked = selectAllCheckbox.checked;
    });
  }
</script>

<script>
    $(document).ready(function () {
        try {
            $(document).on("click", ".data-row", function () {
                var number = $(this).data('vm');
                var name = $(this).data('vn');
                var cost = $(this).data('cost');
                var des = $(this).data('des');
                var date = $(this).data('date');
                var id = $(this).data('id');

                // Set the input values
                $("#vname2").val(name);
                $("#cost2").val(cost);
                $("#desc2").val(des);
                $("#date2").val(date);
                $("#id").val(id);
                $("#vn2").val(number);
                // Set the selected option to the default value
                $("#vnumber2").val('');

                // Trigger the change event on the select element
                $("#vnumber2").trigger('change');
            });
        } catch (error) {
            console.error("An error occurred:", error);
            // Handle the error gracefully, such as displaying an error message to the user
        }
    });
</script>


<script>
    $(document).ready(function () {
        // When the form is submitted
        $('form').submit(function (event) {
            // Prevent the default form submission behavior
            event.preventDefault();

            // Get the value of vn2 input field
            var vn2Value = $('#vn2').val();

            // If vn2 is empty, get the value from vnumber2 select dropdown
            if (!vn2Value.trim()) {
                vn2Value = $('#vnumber2').val();
            }

            // Update the value of vn2 input field
            $('#vn2').val(vn2Value);

            // Submit the form
            $(this).unbind('submit').submit();
        });
    });
</script>
@endsection
@section('style')
<style>
 .titel{Margin-bottom:40px}

 .nav-pills .nav-link {
    border: 0.25px solid #6A6B6A;
    border-radius: 0.5rem; 
    margin-right: 6px;
  }

  #buttonContainer button {
    margin-right: 10px; /* Adjust this value as needed */
}
.select2-size-lg {
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    /* Add additional styling as needed */
}

/* Set max-height to limit visible options and enable scrolling */
#vnumber {
    max-height: 150px; /* Adjust height as needed */
    overflow-y: auto;
}
</style>

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
@if(Session::has('s'))
            <div class="toastqq" id="toastqq">{{session('s')}}</div>
            @endif
            @if(Session::has('f'))
            <div class="toastHH" id="toastHH">{{session('f')}}</div>
            @endif

<h3 class="titel">Vehicles Routine Inspection & Service</h3>



<div class="col-md-12 mt-4">
<div class="card">
<div class="card-body">

<div class="content-body"><section id="input-group-basic">
  <div class="row mt-0">

<div class="col-md-6">
      <div class="">
        <div class="card-body">

<form action="{{route('save-checkbox-data')}}" method="post">
  @csrf
     <div class="mb-0">
    <div class="mb-1">  
        <label class="form-label" for="large-select">Vehicle Number</label>
        <select class="select2-size-lg form-select" id="vnumber" name="vnumber">
          <option value="">select</option>
            @foreach($vehicleNumbers as $vn)
                <option value="{{$vn}}">{{$vn}}</option>
            @endforeach
        </select>
    </div>
</div> 

    
              <div class="mb-0">
    <div class="mb-1">
        <label class="form-label" for="vname">Vehicle Name</label>
        <input
            type="text"
            class="form-control"
            id="vname"
            name="vname"
            placeholder=""
        />
    </div>
</div>
              </div>
            </div>
          </div>


            <div class="col-md-6">
            <div class="">
             <div class="card-body">
              
             <div class="mb-0">
                <div class="mb-1">  
                  <label class="form-label " for="large-select">Select Employee</label>
                  
                    <select class="select2-size-lg form-select" id="large-select" name="emp">
                      
                      <option value="">select</option>
                      @foreach($employees as $em)
                      <option value="{{$em->user_id}}">{{$em->name}}</option>
                      @endforeach
                    </select>
              </div>
              </div>    

              <div class="mb-0">
                <div class=" mb-1">
                  <label class="form-label" for="fp-range">Date</label>
                  <input
                    type="text"
                    id="fp-range"
                    class="form-control flatpickr-basic"
                    placeholder="YYYY-MM-DD"
                    name="adate"
                  />
                </div>
                </div>

             </div>
                 
            </div>
           </div>
          </div>
         </div>
        </div>
       </div>
      </div>


    <!-- Vertical Pills Start -->
    <div class="col-12 col-lg-12 ">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-md-3 col-sm-12 ">
              <ul class="nav nav-pills flex-column">

            
                <li class="nav-item mt-0 mb-1">
                  <a
                    class="nav-link active"
                    id="stacked-pill-1"
                    data-bs-toggle="pill"
                    href="#vertical-pill-1"
                    aria-expanded="true"
                  >
                   EXTERIORS
                  </a>
                </li>
                
                <li class="nav-item mb-1">
                  <a
                    class="nav-link"
                    id="stacked-pill-2"
                    data-bs-toggle="pill"
                    href="#vertical-pill-2"
                    aria-expanded="false"
                  >
                  LIGHTS
                  </a>
                </li>


                <li class="nav-item mb-1">
                  <a
                    class="nav-link"
                    id="stacked-pill-3"
                    data-bs-toggle="pill"
                    href="#vertical-pill-3"
                    aria-expanded="false"
                  >
                   OPERATING PERFORMANCE  
                  </a>
                </li>

                <li class="nav-item mb-1">
                  <a
                    class="nav-link"
                    id="stacked-pill-4"
                    data-bs-toggle="pill"
                    href="#vertical-pill-4"
                    aria-expanded="false"
                  >
                   INTERIORS
                  </a>
                </li>

                <li class="nav-item mb-1">
                  <a
                    class="nav-link"
                    id="stacked-pill-5"
                    data-bs-toggle="pill"
                    href="#vertical-pill-5"
                    aria-expanded="false"
                  >
                    INDICATORS & GAUGES
                  </a>
                </li>

                <li class="nav-item mb-1">
                  <a
                    class="nav-link"
                    id="stacked-pill-6"
                    data-bs-toggle="pill"
                    href="#vertical-pill-6"
                    aria-expanded="false"
                  >
                    INTERIOR CONTROLS
                  </a>
                </li>

                <li class="nav-item mb-1">
                  <a
                    class="nav-link"
                    id="stacked-pill-7"
                    data-bs-toggle="pill"
                    href="#vertical-pill-7"
                    aria-expanded="false"
                  >
                  LUGGAGE BOOT
                  </a>
                </li>

                <li class="nav-item mb-1">
                  <a
                    class="nav-link"
                    id="stacked-pill-8"
                    data-bs-toggle="pill"
                    href="#vertical-pill-8"
                    aria-expanded="false"
                  >
                   TYRES
                  </a>
                </li>

                <li class="nav-item mb-1">
                  <a
                    class="nav-link"
                    id="stacked-pill-9"
                    data-bs-toggle="pill"
                    href="#vertical-pill-9"
                    aria-expanded="false"
                  >
                   BODY WASH
                  </a>
                </li>

                <li class="nav-item mb-1">
                  <a
                    class="nav-link"
                    id="stacked-pill-11"
                    data-bs-toggle="pill"
                    href="#vertical-pill-11"
                    aria-expanded="false"
                  >
                   SERVICE
                  </a>
                </li>
              </ul>

              
             <div class="mt-4 mb-0 d-flex justify-content-center" id="buttonContainer">
             <button type="submit" class="btn btn-success" style="width: 300px;">Submit Routine Inspection</button>
              </div>

              <div class="mt-1 mb-5 d-flex justify-content-center" id="buttonContainer">
             <button type="reset" class="btn btn-primary" style="width: 300px;">Clear All</button>
              </div>

            </div>
          



            <div class="col-md-8 col-sm-12  ">
              <div class="tab-content ">

                <div
                  role="tabpanel"
                  class="tab-pane active"
                  id="vertical-pill-1"
                  aria-labelledby="stacked-pill-1"
                  aria-expanded="true"
                >

                 <div class="card">
      <div class="table-responsive">

        <table class="table text-nowrap text-center border-bottom">
        <thead>
            <tr>
              <th class="text-start">Type</th>
              <th> Check or Not</th> 
            </tr>
        </thead>


          <tbody>
            <tr>
            <td class="text-start">Select All</td>
              <td>
                <div class="form-check d-flex justify-content-center">
                  <input class="form-check-input" value="select" type="checkbox" id="vs1" onclick="handleSelectAll('vertical-pill-1', 'vs1')"/>
                </div>
              </td>
            </tr>


              <td class="text-start">01. GENERAL APPERANCE</td>
              <td>
                <div class="form-check d-flex justify-content-center">
                  <input class="form-check-input" name="checkboxes[EXTERIORS][]" value="GENERAL APPERANCE" type="checkbox" id="defaultCheck1" />
                </div>
              </td>
            </tr>

            <tr>
              <td class="text-start">02. PAINT/COLOUR</td>
              <td>
                <div class="form-check d-flex justify-content-center">
                  <input class="form-check-input" name="checkboxes[EXTERIORS][]" value="PAINT/COLOUR" type="checkbox" id="defaultCheck1" />
                </div>
              </td>
            </tr>

            <tr>
              <td class="text-start">03. BUFFER FRONT</td>
              <td>
                <div class="form-check d-flex justify-content-center">
                  <input class="form-check-input" name="checkboxes[EXTERIORS][]" value="BUFFER FRONT" type="checkbox" id="defaultCheck1" />
                </div>
              </td>
            </tr>

            <tr>
              <td class="text-start">04 BUFFER REAR</td>
              <td>
                <div class="form-check d-flex justify-content-center">
                  <input class="form-check-input" name="checkboxes[EXTERIORS][]" value="BUFFER REAR" type="checkbox" id="defaultCheck1" />
                </div>
              </td>
            </tr>

            <tr>
              <td class="text-start">05. FRONT FENDER RIGHT</td>
              <td>
                <div class="form-check d-flex justify-content-center">
                  <input class="form-check-input" name="checkboxes[EXTERIORS][]" value="FRONT FENDER RIGHT" type="checkbox" id="defaultCheck1" />
                </div>
              </td>
            </tr>

            <tr>
              <td class="text-start">06. FRONT FENDER LEFT</td>
              <td>
                <div class="form-check d-flex justify-content-center">
                  <input class="form-check-input" name="checkboxes[EXTERIORS][]" value="FRONT FENDER LEFT" type="checkbox" id="defaultCheck1" />
                </div>
              </td>
            </tr>

            <tr>
              <td class="text-start">07. REAR FENDER RIGHT</td>
              <td>
                <div class="form-check d-flex justify-content-center">
                  <input class="form-check-input" name="checkboxes[EXTERIORS][]" value="REAR FENDER RIGHT" type="checkbox" id="defaultCheck1" />
                </div>
              </td>
            </tr>

            <tr>
              <td class="text-start">08. REAR FENDER LEFT</td>
              <td>
                <div class="form-check d-flex justify-content-center">
                  <input class="form-check-input" name="checkboxes[EXTERIORS][]" value=" REAR FENDER LEFT" type="checkbox" id="defaultCheck1" />
                </div>
              </td>
            </tr>

            <tr>
              <td class="text-start">09. WINDSCREEN</td>
              <td>
                <div class="form-check d-flex justify-content-center">
                  <input class="form-check-input" name="checkboxes[EXTERIORS][]" value="WINDSCREEN" type="checkbox" id="defaultCheck1" />
                </div>
              </td>
            </tr>

            <tr>
              <td class="text-start">10. REAR GLASS</td>
              <td>
                <div class="form-check d-flex justify-content-center">
                  <input class="form-check-input" name="checkboxes[EXTERIORS][]" value="REAR GLASS" type="checkbox" id="defaultCheck1" />
                </div>
              </td>
            </tr>

            <tr>
              <td class="text-start">11. DOOR GLASSES</td>
              <td>
                <div class="form-check d-flex justify-content-center">
                  <input class="form-check-input" name="checkboxes[EXTERIORS][]" value="DOOR GLASSES" type="checkbox" id="defaultCheck1" />
                </div>
              </td>
            </tr>

            <tr>
              <td class="text-start">12.OUT DOOR HANDLES</td>
              <td>
                <div class="form-check d-flex justify-content-center">
                  <input class="form-check-input" name="checkboxes[EXTERIORS][]" value="OUT DOOR HANDLES" type="checkbox" id="defaultCheck1" />
                </div>
              </td>
            </tr>

            <tr>
              <td class="text-start">13. RUBBER MOLDING</td>
              <td>
                <div class="form-check d-flex justify-content-center">
                  <input class="form-check-input" name="checkboxes[EXTERIORS][]" value="RUBBER MOLDING" type="checkbox" id="defaultCheck1" />
                </div>
              </td>
            </tr>

            <tr>
              <td class="text-start">14. NUMBER PLATES</td>
              <td>
                <div class="form-check d-flex justify-content-center">
                  <input class="form-check-input" name="checkboxes[EXTERIORS][]" value="NUMBER PLATES" type="checkbox" id="defaultCheck1" />
                </div>
              </td>
            </tr>

            <tr>
              <td class="text-start">15. DOOR STICKERS</td>
              <td>
                <div class="form-check d-flex justify-content-center">
                  <input class="form-check-input" name="checkboxes[EXTERIORS][]" value="DOOR STICKERS" type="checkbox" id="defaultCheck1" />
                </div>
              </td>
            </tr>

            <tr>
              <td class="text-start">16. WING MIRRORS</td>
              <td>
                <div class="form-check d-flex justify-content-center">
                  <input class="form-check-input" name="checkboxes[EXTERIORS][]" value="WING MIRRORS" type="checkbox" id="defaultCheck1" />
                </div>
              </td>
            </tr>

            <tr>
              <td class="text-start">17. HUB CAPS</td>
              <td>
                <div class="form-check d-flex justify-content-center">
                  <input class="form-check-input" name="checkboxes[EXTERIORS][]" value="HUB CAPS" type="checkbox" id="defaultCheck1" />
                </div>
              </td>
            </tr>

            <tr>
              <td class="text-start">18. MUD FLAPS</td>
              <td>
                <div class="form-check d-flex justify-content-center">
                  <input class="form-check-input" name="checkboxes[EXTERIORS][]" value="MUD FLAPS" type="checkbox" id="defaultCheck1" />
                </div>
                </td>
               </tr>
            </tbody>
           </table>
           </div>
           </div>
          </div>


                <div
                  class="tab-pane"
                  id="vertical-pill-2"
                  role="tabpanel"
                  aria-labelledby="stacked-pill-2"
                  aria-expanded="false"
                >

      <div class="card">
      <div class="table-responsive">

        <table class="table text-nowrap text-center border-bottom">
        <thead>
            <tr>
              <th class="text-start">Type</th>
              <th> Check or Not</th> 
            </tr>
        </thead>


          <tbody>
          <tr>
          <td class="text-start">Select All</td>
              <td>
                <div class="form-check d-flex justify-content-center">
                  <input class="form-check-input"  value="select" type="checkbox" id="vs2" onclick="handleSelectAll('vertical-pill-2', 'vs2')"/>
                </div>
              </td>
            </tr>


            <tr>
              <td class="text-start">19. HEAD</td>
              <td>
                <div class="form-check d-flex justify-content-center">
                  <input class="form-check-input" name="checkboxes[LIGHTS][]" value="HEAD" type="checkbox" id="defaultCheck1" />
                </div>
              </td>
            </tr>

            <tr>
              <td class="text-start">20. DIM</td>
              <td>
                <div class="form-check d-flex justify-content-center">
                  <input class="form-check-input" name="checkboxes[LIGHTS][]" value="DIM" type="checkbox" id="defaultCheck1" />
                </div>
              </td>
            </tr>

            <tr>
              <td class="text-start">21. PARKING FRONT</td>
              <td>
                <div class="form-check d-flex justify-content-center">
                  <input class="form-check-input" name="checkboxes[LIGHTS][]" value="PARKING FRONT" type="checkbox" id="defaultCheck1" />
                </div>
              </td>
            </tr>

            <tr>
              <td class="text-start">22. PARKING REAR</td>
              <td>
                <div class="form-check d-flex justify-content-center">
                  <input class="form-check-input" name="checkboxes[LIGHTS][]" value="PARKING REAR" type="checkbox" id="defaultCheck1" />
                </div>
              </td>
            </tr>

            <tr>
              <td class="text-start">23. TRAFICATORS FRONT</td>
              <td>
                <div class="form-check d-flex justify-content-center">
                  <input class="form-check-input" name="checkboxes[LIGHTS][]" value="TRAFICATORS FRONT" type="checkbox" id="defaultCheck1" />
                </div>
              </td>
            </tr>

            <tr>
              <td class="text-start">24. TRAFICATORS REAR</td>
              <td>
                <div class="form-check d-flex justify-content-center">
                  <input class="form-check-input" name="checkboxes[LIGHTS][]" value="TRAFICATORS REAR" type="checkbox" id="defaultCheck1" />
                </div>
              </td>
            </tr>

            <tr>
              <td class="text-start">25. BRAKE</td>
              <td>
                <div class="form-check d-flex justify-content-center">
                  <input class="form-check-input" name="checkboxes[LIGHTS][]" value="BRAKE" type="checkbox" id="defaultCheck1" />
                </div>
              </td>
            </tr>

            <tr>
              <td class="text-start">26. REVERSE</td>
              <td>
                <div class="form-check d-flex justify-content-center">
                  <input class="form-check-input" name="checkboxes[LIGHTS][]" value="REVERSE" type="checkbox" id="defaultCheck1" />
                </div>
              </td>
            </tr>

            <tr>
              <td class="text-start">27. HOOD/INTERIORS</td>
              <td>
                <div class="form-check d-flex justify-content-center">
                  <input class="form-check-input" name="checkboxes[LIGHTS][]" value="HOOD/INTERIORS" type="checkbox" id="defaultCheck1" />
                </div>
                </td>
               </tr>
            </tbody>
          </table>
        </div>
       </div>
    </div>
      
      

                <div
                  class="tab-pane"
                  id="vertical-pill-3"
                  role="tabpanel"
                  aria-labelledby="stacked-pill-3"
                  aria-expanded="false"
                >

                <div class="card">
      <div class="table-responsive">

        <table class="table text-nowrap text-center border-bottom">
        <thead>
            <tr>
              <th class="text-start">Type</th>
              <th> Check or Not</th> 
            </tr>
        </thead>


          <tbody>
          <tr>
          <td class="text-start">Select All</td>
              <td>
                <div class="form-check d-flex justify-content-center">
                  <input class="form-check-input"  value="select" type="checkbox" id="vs3" 
                  onclick="handleSelectAll('vertical-pill-3', 'vs3')"/>
                </div>
              </td>
            </tr>

            <tr>
              <td class="text-start">28. ENGINE</td>
              <td>
                <div class="form-check d-flex justify-content-center">
                  <input class="form-check-input" name="checkboxes[OPERATING PERFORMANCE][]" value="ENGINE" type="checkbox" id="defaultCheck1" />
                </div>
              </td>
            </tr>

            <tr>
              <td class="text-start">29. TRANSMISSION</td>
              <td>
                <div class="form-check d-flex justify-content-center">
                  <input class="form-check-input" name="checkboxes[OPERATING PERFORMANCE][]" value="TRANSMISSION" type="checkbox" id="defaultCheck1" />
                </div>
              </td>
            </tr>

            <tr>
              <td class="text-start">30. STEERING</td>
              <td>
                <div class="form-check d-flex justify-content-center">
                  <input class="form-check-input" name="checkboxes[OPERATING PERFORMANCE][]" value="STEERING" type="checkbox" id="defaultCheck1" />
                </div>
              </td>
            </tr>

            <tr>
              <td class="text-start">31. BRAKES FOOT</td>
              <td>
                <div class="form-check d-flex justify-content-center">
                  <input class="form-check-input" name="checkboxes[OPERATING PERFORMANCE][]" value="BRAKES FOOT" type="checkbox" id="defaultCheck1" />
                </div>
              </td>
            </tr>

            <tr>
              <td class="text-start">32. BRAKES PARKING</td>
              <td>
                <div class="form-check d-flex justify-content-center">
                  <input class="form-check-input" name="checkboxes[OPERATING PERFORMANCE][]" value="BRAKES PARKING" type="checkbox" id="defaultCheck1" />
                </div>
              </td>
            </tr>

            <tr>
              <td class="text-start">33. SUSPENSION FRONT</td>
              <td>
                <div class="form-check d-flex justify-content-center">
                  <input class="form-check-input" name="checkboxes[OPERATING PERFORMANCE][]" value="SUSPENSION FRONT" type="checkbox" id="defaultCheck1" />
                </div>
              </td>
            </tr>

            <tr>
              <td class="text-start">34. SUSPENSION REAR</td>
              <td>
                <div class="form-check d-flex justify-content-center">
                  <input class="form-check-input" name="checkboxes[OPERATING PERFORMANCE][]" value="SUSPENSION REAR" type="checkbox" id="defaultCheck1" />
                </div>
              </td>
            </tr>

            <tr>
              <td class="text-start">35. AIRCONDITIONER</td>
              <td>
                <div class="form-check d-flex justify-content-center">
                  <input class="form-check-input" name="checkboxes[OPERATING PERFORMANCE][]" value="AIRCONDITIONER" type="checkbox" id="defaultCheck1" />
                </div>
              </td>
            </tr>

            <tr>
              <td class="text-start">36. DRIVE BELTS (A/C,P/S,ALTERNATOR)</td>
              <td>
                <div class="form-check d-flex justify-content-center">
                  <input class="form-check-input" name="checkboxes[OPERATING PERFORMANCE][]" value="DRIVE BELTS (A/C,P/S,ALTERNATOR)" type="checkbox" id="defaultCheck1" />
                </div>
              </td>
            </tr>

            <tr>
              <td class="text-start">37. RADIATOR (COOLER) FANS</td>
              <td>
                <div class="form-check d-flex justify-content-center">
                  <input class="form-check-input" name="checkboxes[OPERATING PERFORMANCE][]" value="RADIATOR (COOLER) FANS" type="checkbox" id="defaultCheck1" />
                </div>
              </td>
            </tr>

            <tr>
              <td class="text-start">38. BRAKE PADS & SHOES</td>
              <td>
                <div class="form-check d-flex justify-content-center">
                  <input class="form-check-input" name="checkboxes[OPERATING PERFORMANCE][]" value="BRAKE PADS & SHOES" type="checkbox" id="defaultCheck1" />
                </div>
              </td>
            </tr>

            <tr>
              <td class="text-start">39. CLUTCH</td>
              <td>
                <div class="form-check d-flex justify-content-center">
                  <input class="form-check-input" name="checkboxes[OPERATING PERFORMANCE][]" value="CLUTCH" type="checkbox" id="defaultCheck1" />
                </div>
              </td>
            </tr>
            </tbody>
           </table>
           </div>
           </div>
          </div>


          
          <div
                  class="tab-pane"
                  id="vertical-pill-4"
                  role="tabpanel"
                  aria-labelledby="stacked-pill-4"
                  aria-expanded="false"
                >

                <div class="card">
      <div class="table-responsive">

        <table class="table text-nowrap text-center border-bottom">
        <thead>
            <tr>
              <th class="text-start">Type</th>
              <th> Check or Not</th> 
            </tr>
        </thead>


          <tbody>
          <tr>
            <td class="text-start">Select All</td>
              <td>
                <div class="form-check d-flex justify-content-center">
                  <input class="form-check-input" value="select" type="checkbox" id="vs4" 
                  onclick="handleSelectAll('vertical-pill-4', 'vs4')"/>
                </div>
              </td>
            </tr>

            <tr>
              <td class="text-start">40. FRONT SEATS</td>
              <td>
                <div class="form-check d-flex justify-content-center">
                  <input class="form-check-input" name="checkboxes[INTERIORS ][]" value="FRONT SEATS" type="checkbox" id="defaultCheck1" />
                </div>
              </td>
            </tr>

            <tr>
              <td class="text-start">41. REAR SEATS</td>
              <td>
                <div class="form-check d-flex justify-content-center">
                  <input class="form-check-input" name="checkboxes[INTERIORS ][]" value="REAR SEATS" type="checkbox" id="defaultCheck1" />
                </div>
              </td>
            </tr>

            <tr>
              <td class="text-start">42. HOOD LINING</td>
              <td>
                <div class="form-check d-flex justify-content-center">
                  <input class="form-check-input" name="checkboxes[INTERIORS ][]" value="HOOD LINING" type="checkbox" id="defaultCheck1" />
                </div>
              </td>
            </tr>

            <tr>
              <td class="text-start">43. DOOR UPHOLSTERY</td>
              <td>
                <div class="form-check d-flex justify-content-center">
                  <input class="form-check-input" name="checkboxes[INTERIORS ][]" value="DOOR UPHOLSTERY" type="checkbox" id="defaultCheck1" />
                </div>
              </td>
            </tr>

            <tr>
              <td class="text-start">44. DOOR HANDLES</td>
              <td>
                <div class="form-check d-flex justify-content-center">
                  <input class="form-check-input" name="checkboxes[INTERIORS ][]" value="DOOR HANDLES" type="checkbox" id="defaultCheck1" />
                </div>
              </td>
            </tr>

            <tr>
              <td class="text-start">45. DOOR WINDER HANDLES</td>
              <td>
                <div class="form-check d-flex justify-content-center">
                  <input class="form-check-input" name="checkboxes[INTERIORS ][]" value="DOOR WINDER HANDLES" type="checkbox" id="defaultCheck1" />
                </div>
              </td>
            </tr>

            <tr>
              <td class="text-start">46. REAR VIEW MIRROR</td>
              <td>
                <div class="form-check d-flex justify-content-center">
                  <input class="form-check-input" name="checkboxes[INTERIORS ][]" value="REAR VIEW MIRROR" type="checkbox" id="defaultCheck1" />
                </div>
              </td>
            </tr>

            <tr>
              <td class="text-start">47. SEAT BELTS REAR</td>
              <td>
                <div class="form-check d-flex justify-content-center">
                  <input class="form-check-input" name="checkboxes[INTERIORS ][]" value="SEAT BELTS REAR" type="checkbox" id="defaultCheck1" />
                </div>
              </td>
            </tr>

            <tr>
              <td class="text-start">48. SEAT BELTS FRONT</td>
              <td>
                <div class="form-check d-flex justify-content-center">
                  <input class="form-check-input" name="checkboxes[INTERIORS ][]" value="SEAT BELTS FRONT" type="checkbox" id="defaultCheck1" />
                </div>
              </td>
            </tr>

            <tr>
              <td class="text-start">49. SEAT COVERS</td>
              <td>
                <div class="form-check d-flex justify-content-center">
                  <input class="form-check-input" name="checkboxes[INTERIORS ][]" value="SEAT COVERS" type="checkbox" id="defaultCheck1" />
                </div>
              </td>
            </tr>

            <tr>
              <td class="text-start">50. SUN VISORS</td>
              <td>
                <div class="form-check d-flex justify-content-center">
                  <input class="form-check-input" name="checkboxes[INTERIORS ][]" value="SUN VISORS" type="checkbox" id="defaultCheck1" />
                </div>
              </td>
            </tr>

            <tr>
              <td class="text-start">51. RUBBER MATS</td>
              <td>
                <div class="form-check d-flex justify-content-center">
                  <input class="form-check-input" name="checkboxes[INTERIORS ][]" value="RUBBER MATS" type="checkbox" id="defaultCheck1" />
                </div>
              </td>
            </tr>

            <tr>
              <td class="text-start">52. CURTAINS/HEAD REST</td>
              <td>
                <div class="form-check d-flex justify-content-center">
                  <input class="form-check-input" name="checkboxes[INTERIORS ][]" value="CURTAINS/HEAD REST" type="checkbox" id="defaultCheck1" />
                </div>
              </td>
            </tr>
            </tbody>
           </table>
           </div>
           </div>
          </div>

          <div
                  class="tab-pane"
                  id="vertical-pill-5"
                  role="tabpanel"
                  aria-labelledby="stacked-pill-5"
                  aria-expanded="false"
                >

      <div class="card">
      <div class="table-responsive">

        <table class="table text-nowrap text-center border-bottom">
        <thead>
            <tr>
              <th class="text-start">Type</th>
              <th> Check or Not</th> 
            </tr>
        </thead>


          <tbody>
          <tr>
            <td class="text-start">Select All</td>
              <td>
                <div class="form-check d-flex justify-content-center">
                  <input class="form-check-input" value="select" type="checkbox" id="vs5" 
                  onclick="handleSelectAll('vertical-pill-5', 'vs5')"/>
                </div>
              </td>
            </tr>


            <tr>
              <td class="text-start">53. ODO METER</td>
              <td>
                <div class="form-check d-flex justify-content-center">
                  <input class="form-check-input" name="checkboxes[INDICATORS & GAUGES][]" value="ODO METER" type="checkbox" id="defaultCheck1" />
                </div>
              </td>
            </tr>

            <tr>
              <td class="text-start">54. PETROL/DIESEL</td>
              <td>
                <div class="form-check d-flex justify-content-center">
                  <input class="form-check-input" name="checkboxes[INDICATORS & GAUGES][]" value="PETROL/DIESEL" type="checkbox" id="defaultCheck1" />
                </div>
              </td>
            </tr>

            <tr>
              <td class="text-start">55. OIL PRESSURE</td>
              <td>
                <div class="form-check d-flex justify-content-center">
                  <input class="form-check-input" name="checkboxes[INDICATORS & GAUGES][]" value="OIL PRESSURE" type="checkbox" id="defaultCheck1" />
                </div>
              </td>
            </tr>

            <tr>
              <td class="text-start">56. TEMPERATURE</td>
              <td>
                <div class="form-check d-flex justify-content-center">
                  <input class="form-check-input" name="checkboxes[INDICATORS & GAUGES][]" value="TEMPERATURE" type="checkbox" id="defaultCheck1" />
                </div>
              </td>
            </tr>

            <tr>
              <td class="text-start">57. TRAFFICATORS</td>
              <td>
                <div class="form-check d-flex justify-content-center">
                  <input class="form-check-input" name="checkboxes[INDICATORS & GAUGES][]" value="TRAFFICATORS" type="checkbox" id="defaultCheck1" />
                </div>
              </td>
            </tr>

            <tr>
              <td class="text-start">58. RADIO</td>
              <td>
                <div class="form-check d-flex justify-content-center">
                  <input class="form-check-input" name="checkboxes[INDICATORS & GAUGES][]" value="RADIO" type="checkbox" id="defaultCheck1" />
                </div>
              </td>
            </tr>

            <tr>
              <td class="text-start">59. CASSETE/CD/VCD/DVD</td>
              <td>
                <div class="form-check d-flex justify-content-center">
                  <input class="form-check-input" name="checkboxes[INDICATORS & GAUGES][]" value="CASSETE/CD/VCD/DVD" type="checkbox" id="defaultCheck1" />
                </div>
              </td>
            </tr>
            </tbody>
          </table>
        </div>
       </div>
    </div>


              <div
                  class="tab-pane"
                  id="vertical-pill-6"
                  role="tabpanel"
                  aria-labelledby="stacked-pill-6"
                  aria-expanded="false"
                >

      <div class="card">
      <div class="table-responsive">

        <table class="table text-nowrap text-center border-bottom">
        <thead>
            <tr>
              <th class="text-start">Type</th>
              <th> Check or Not</th> 
            </tr>
        </thead>


          <tbody>
          <tr>
            <td class="text-start">Select All</td>
              <td>
                <div class="form-check d-flex justify-content-center">
                  <input class="form-check-input" value="select" type="checkbox" id="vs6" 
                  onclick="handleSelectAll('vertical-pill-6', 'vs6')"/>
                </div>
              </td>
            </tr>

            <tr>
              <td class="text-start">60. STARTER SWITCH</td>
              <td>
                <div class="form-check d-flex justify-content-center">
                  <input class="form-check-input" name="checkboxes[INTERIOR CONTROLS][]" value="STARTER SWITCH" type="checkbox" id="defaultCheck1" />
                </div>
              </td>
            </tr>

            <tr>
              <td class="text-start">61. HORN</td>
              <td>
                <div class="form-check d-flex justify-content-center">
                  <input class="form-check-input" name="checkboxes[INTERIOR CONTROLS][]" value="HORN" type="checkbox" id="defaultCheck1" />
                </div>
              </td>
            </tr>

            <tr>
              <td class="text-start">62. WIPER</td>
              <td>
                <div class="form-check d-flex justify-content-center">
                  <input class="form-check-input" name="checkboxes[INTERIOR CONTROLS][]" value="WIPER" type="checkbox" id="defaultCheck1" />
                </div>
              </td>
            </tr>

            <tr>
              <td class="text-start">63. WIPER WASHER</td>
              <td>
                <div class="form-check d-flex justify-content-center">
                  <input class="form-check-input" name="checkboxes[INTERIOR CONTROLS][]" value="WIPER WASHER" type="checkbox" id="defaultCheck1" />
                </div>
              </td>
            </tr>
            </tbody>
          </table>
        </div>
       </div>
    </div>


    <div
                  class="tab-pane"
                  id="vertical-pill-7"
                  role="tabpanel"
                  aria-labelledby="stacked-pill-7"
                  aria-expanded="false"
                >

      <div class="card">
      <div class="table-responsive">

        <table class="table text-nowrap text-center border-bottom">
        <thead>
            <tr>
              <th class="text-start">Type</th>
              <th> Check or Not</th> 
            </tr>
        </thead>


          <tbody>
          <tr>
            <td class="text-start">Select All</td>
              <td>
                <div class="form-check d-flex justify-content-center">
                  <input class="form-check-input"  value="select" type="checkbox" id="vs7" 
                  onclick="handleSelectAll('vertical-pill-7', 'vs7')"/>
                </div>
              </td>
            </tr>


            <tr>
              <td class="text-start">64. JACK</td>
              <td>
                <div class="form-check d-flex justify-content-center">
                  <input class="form-check-input" name="checkboxes[LUGGAGE BOOT][]" value="JACK" type="checkbox" id="defaultCheck1" />
                </div>
              </td>
            </tr>

            <tr>
              <td class="text-start">65. WHEEL BRACE</td>
              <td>
                <div class="form-check d-flex justify-content-center">
                  <input class="form-check-input" name="checkboxes[LUGGAGE BOOT][]" value="WHEEL BRACE" type="checkbox" id="defaultCheck1" />
                </div>
              </td>
            </tr>

            <tr>
              <td class="text-start">66. TOOL KIT</td>
              <td>
                <div class="form-check d-flex justify-content-center">
                  <input class="form-check-input" name="checkboxes[LUGGAGE BOOT][]" value="TOOL KIT" type="checkbox" id="defaultCheck1" />
                </div>
              </td>
            </tr>

            <tr>
              <td class="text-start">67. FIRST AID BOX</td>
              <td>
                <div class="form-check d-flex justify-content-center">
                  <input class="form-check-input" name="checkboxes[LUGGAGE BOOT][]" value="FIRST AID BOX" type="checkbox" id="defaultCheck1" />
                </div>
              </td>
            </tr>

            <tr>
              <td class="text-start">68. FIRE EXINGUISER</td>
              <td>
                <div class="form-check d-flex justify-content-center">
                  <input class="form-check-input" name="checkboxes[LUGGAGE BOOT][]" value="FIRE EXINGUISER" type="checkbox" id="defaultCheck1" />
                </div>
              </td>
            </tr>
            </tbody>
          </table>
        </div>
       </div>
    </div>


             <div
                  class="tab-pane"
                  id="vertical-pill-8"
                  role="tabpanel"
                  aria-labelledby="stacked-pill-8"
                  aria-expanded="false"
                >

      <div class="card">
      <div class="table-responsive">

        <table class="table text-nowrap text-center border-bottom">
        <thead>
            <tr>
              <th class="text-start">Type</th>
              <th> Check or Not</th> 
            </tr>
        </thead>


          <tbody>
          <tr>
            <td class="text-start">Select All</td>
              <td>
                <div class="form-check d-flex justify-content-center">
                  <input class="form-check-input"  value="select" type="checkbox" id="vs8" 
                  onclick="handleSelectAll('vertical-pill-8', 'vs8')"/>
                </div>
              </td>
            </tr>


            <tr>
              <td class="text-start">69. FRONT RIGHT</td>
              <td>
                <div class="form-check d-flex justify-content-center">
                  <input class="form-check-input" name="checkboxes[TYRES][]" value="FRONT RIGHT" type="checkbox" id="defaultCheck1" />
                </div>
              </td>
            </tr>

            <tr>
              <td class="text-start">70. FRONT LEFT</td>
              <td>
                <div class="form-check d-flex justify-content-center">
                  <input class="form-check-input" name="checkboxes[TYRES][]" value="FRONT LEFT" type="checkbox" id="defaultCheck1" />
                </div>
              </td>
            </tr>

            <tr>
              <td class="text-start">71. REAR RIGHT</td>
              <td>
                <div class="form-check d-flex justify-content-center">
                  <input class="form-check-input" name="checkboxes[TYRES][]" value="REAR RIGHT" type="checkbox" id="defaultCheck1" />
                </div>
              </td>
            </tr>

            <tr>
              <td class="text-start">72. REAR LEFT</td>
              <td>
                <div class="form-check d-flex justify-content-center">
                  <input class="form-check-input" name="checkboxes[TYRES][]" value="REAR LEFT" type="checkbox" id="defaultCheck1" />
                </div>
              </td>
            </tr>

            <tr>
              <td class="text-start">73. SPARE</td>
              <td>
                <div class="form-check d-flex justify-content-center">
                  <input class="form-check-input" name="checkboxes[TYRES][]" value="SPARE" type="checkbox" id="defaultCheck1" />
                </div>
              </td>
            </tr>

            <tr>
              <td class="text-start">74. BATTERY</td>
              <td>
                <div class="form-check d-flex justify-content-center">
                  <input class="form-check-input" name="checkboxes[TYRES][]" value="BATTERY" type="checkbox" id="defaultCheck1" />
                </div>
              </td>
            </tr>
            </tbody>
          </table>
        </div>
       </div>
    </div>


              <div
                  class="tab-pane"
                  id="vertical-pill-9"
                  role="tabpanel"
                  aria-labelledby="stacked-pill-9"
                  aria-expanded="false"
                >

      <div class="card">
      <div class="table-responsive">

        <table class="table text-nowrap text-center border-bottom">
        <thead>
            <tr>
              <th class="text-start">Type</th>
              <th> Check or Not</th> 
            </tr>
        </thead>


          <tbody>
          
            <tr>
              <td class="text-start">75. BODY WASH</td>
              <td>
                <div class="form-check d-flex justify-content-center">
                  <input class="form-check-input" name="checkboxes[BODY WASH][]" value="BODY WASH" type="checkbox" id="defaultCheck1" />
                </div>
              </td>
            </tr>
            </tbody>
          </table>
        </div>
       </div>
    </div>


 <div
                  class="tab-pane"
                  id="vertical-pill-11"
                  role="tabpanel"
                  aria-labelledby="stacked-pill-11"
                  aria-expanded="false"
                >

      <div class="card">
      <div class="table-responsive">

        <table class="table text-nowrap text-center border-bottom">
        <thead>
            <tr>
              <th class="text-start">Type</th>
              <th> Check or Not</th> 
            </tr>
        </thead>


          <tbody>
          
            <tr>
              <td class="text-start">76. service</td>
              <td>
                <div class="form-check d-flex justify-content-center">
                  <input class="form-check-input" name="checkboxes[SERVICE][]" value="SERVICE" type="checkbox" id="defaultCheck1" />
                </div>
              </td>
            </tr>
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
</div>
</form>


<div class="mt-4">
<h5> Mechanic Submit Vehicle Details</h5>

                 
         <div class="row">
    <div class="col-md-3 mb-0">
        <form action="{{ route('car_maintain') }}" method="GET">
            <div class="input-group">
                <input
                    type="text"
                    class="form-control"
                    name="search"
                    placeholder="Search Vehicles Number"
                    aria-describedby="button-addon2"
                    value="{{ request('search') }}"
                    @if(request('search')) autofocus @endif
                />
                <span class="input-group-text"><i data-feather="search" type="submit"></i></span>
            </div>
        </form>
    </div>
</div>

<div class="content-body">
    <div class="row mt-1 mb-0" id="basic-table">
        <div class="col-8">
            <div class="card">
                <div class="table-responsive" style="max-width: 300px;overflow-y: auto;">
                    @if ($services->isEmpty())
                    <p>No data available</p>
                    @else
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Vehicle Number</th>
                                <th>Vehicle Name</th>
                                <th>Date</th>
                                <th>Cost</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($services as $service)
                            <tr class="data-row" 
            data-vm="{{ $service->vnumber }}" 
            data-vn="{{ $service->vname }}" 
            data-date="{{ $service->date }}" 
            data-cost="{{ $service->cost }}" 
            data-des="{{ $service->des }}" 
            data-id="{{ $service->id }}">
                                <td>{{ $service->vnumber }}</td>
                                <td>{{ $service->vname }}</td>
                                <td>{{ $service->date }}</td>
                                <td>{{ $service->cost }}</td>
                                <td>{{ $service->des }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

 
<div class="col-md-12 mt-0">
<div class="card">
<div class="card-body">

<div class="content-body"><section id="input-group-basic">
  <div class="row mt-0">

<div class="col-md-6">
      <div class="">
        <div class="card-body">

        <form action="{{route('send_service_data')}}" method="post">
          @csrf
          
              <div class="mb-0">

    <div class="mb-1">  
        <label class="form-label" for="large-select">Vehicle Number</label>
        <select class="select2-size-lg form-select" id="vnumber2" name="vnumber2">
            <option value="">select</option>
            @foreach($vehicleNumbers as $vn)
                <option value="{{ $vn }}" >{{ $vn }}</option>
            @endforeach
        </select>

    </div>
</div> 

    
              <div class="mb-0">
    <div class="mb-1">
        <label class="form-label" for="vname2">Vehicle Number(from table)</label>
        <input
            type="text"
            class="form-control"
            id="vn2"
            name="vn2"
            placeholder=""
            readonly
        />
         <input
            type="hidden"
            class="form-control"
            id="id"
            name="id"
            placeholder=""
        />
    </div>
</div>
 <div class="mb-0">
    <div class="mb-1">
        <label class="form-label" for="vname2">Vehicle Name</label>
        <input
            type="text"
            class="form-control"
            id="vname2"
            name="vname2"
            placeholder=""
        />
    </div>
</div>
            
              

              <div class="mb-0">
                <div class=" mb-1">
                  <label class="form-label" for="date2">Date</label>
                  <input
                    type="text"
                    id="date2"
                    name="date2"
                    class="form-control flatpickr-basic"
                    placeholder="YYYY-MM-DD"
                  />
                </div>
                </div>


                <div class="mb-0">
                <div class=" mb-1">
              <label class="form-label" for="cost2">Cost(LKR)</label>
              <input
                type="text"
                class="form-control"
                id="cost2"
                name="cost2"
                placeholder="Rs.0000.00"
              />
              </div>
            </div>
          
        </div>
      </div>
    </div>


  <div class="col-md-6">
      <div class="">
        <div class="card-body">

        
          <div class=" mt-1 md-2 ">
                  <textarea
                  class="form-control"
                  id="desc2"
                  name="desc2"
                  rows="7"
                  placeholder="Description"
                ></textarea>
            </div>

            <div class="mt-4" id="buttonContainer" >
              <button type="submit" class="btn btn-primary">Submit</button>
              <button type="reset" class="btn btn-primary">Cancel</button>
            </div>

         </form>   
        </div>
      </div>
    </div>
  </div>
</div>

  </div>
  </div>
  </div>





<div class="mt-5">
<h5>Vehicles Routine Inspection Details</h5>

<section id="input-group-buttons">
                 
          <div class="row">
            <div class="col-md-3 mb-0 ">
              <form action="{{ route('car_maintain') }}" method="GET">
            <div class="input-group">
                <input
                    type="text"
                    class="form-control"
                    name="searchsecond"
                    placeholder="Search Vehicles Number"
                    aria-describedby="button-addon2"
                    value="{{ request('searchsecond') }}"
                    @if(request('searchsecond')) autofocus @endif
                />
                <span class="input-group-text"><i data-feather="search" type="submit"></i></span>
            </div>
        </form>
            </div>
          
  
<div class="content-body">
      <div class="row mt-1 mb-2"  id="basic-table">
  <div class="col-5">
    <div class="card">   
      <div class="table-responsive" style="max-width: 300px;overflow-y: auto;">
        @if ($staksData->isEmpty())
                    <p>No data available</p>
                    @else
        <table class="table table-hover">
          <thead>
            <tr>
              <th>Vehicle Number</th>
              <th>Date</th>
              <th>Inspection Status</th>
              
          
            </tr>
          </thead>
          <tbody>
            @foreach($staksData as $st)
            <tr>
              
            
              <td>{{$st->vnumber}}</td>
              <td>{{$st->date}}</td>
              <td>
                <div class="d-flex justify-content-center pt-0">
                <a href="javascript:;" class="btn btn-primary status-button" style="width: 100px; height: 20px; display: flex; align-items: center; justify-content: center;" data-bs-target="#editUser" data-bs-toggle="modal" data-staks-id="{{$st->id}}">
                Status
                </a>
                </div>

             </td>
              
          </tr>
          @endforeach
          </tbody>
        </table>
        @endif
      </div>
    </div>
  </div>
</div> 
</div>


<!-- Edit User Modal -->
<div class="modal fade" id="editUser" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
    <div class="modal-content">
      <div class="modal-header bg-transparent">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body pb-5 px-sm-5 pt-50">
       
{{--  --}}

        <div class="accordion accordion-margin" id="accordionMargin">
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingMarginOne">
                <button
                  class="accordion-button collapsed"
                  type="button"
                  data-bs-toggle="collapse"
                  data-bs-target="#accordionMarginOne"
                  aria-expanded="false"
                  aria-controls="accordionMarginOne"
                >
                  
                </button>
              </h2>
              <div
                id="accordionMarginOne"
                class="accordion-collapse collapse"
                aria-labelledby="headingMarginOne"
                data-bs-parent="#accordionMargin"
              >
                <div class="accordion-body">
                  <table class="table text-nowrap text-center border-bottom" id="svalues-table">
                        <thead>
                            <tr>
                              <th>
                                <span>Check list</span>
                              </th>
                              <th>
                                <span> status</span>
                              </th>
                            </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>
                                <span> Biscuit jelly beans macaroon danish pudding.</span>
                            </td>
                            <td>
                              <span class="badge rounded-pill badge-light-warning me-1">Pending</span>
                            </td>
                          </tr>
                        </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
{{--  --}}
      </div>
    </div>
  </div>
</div>
<!-- End User Modal -->






     
<div class="mt-2">
<h5>Vehicle Service Details</h5>

<section id="input-group-buttons">
                 
          <div class="row">
            <div class="col-md-3 mb-0 ">
              <form action="{{ route('car_maintain') }}" method="GET">
            <div class="input-group">
                <input
                    type="text"
                    class="form-control"
                    name="searchthredd"
                    placeholder="Search Vehicles Number"
                    aria-describedby="button-addon2"
                    value="{{ request('searchthredd') }}"
                    @if(request('searchthredd')) autofocus @endif
                />
                <span class="input-group-text"><i data-feather="search" type="submit"></i></span>
            </div>
        </form>
            </div>
          
  
<div class="content-body">
      <div class="row mt-1 mb-2"  id="basic-table">
  <div class="col-8">
    <div class="card">   
      <div class="table-responsive" style="max-width: 500px;overflow-y: auto;">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>Vehicle Number</th>
              <th>Vehicle Name</th>
              <th>Date</th>
              <th>Cost</th>
              <th>Discription</th>
          
            </tr>
          </thead>
          <tbody>
            @if ($ssecond->isEmpty())
            <tr>
              <td>no data available</td>
              
            </tr>
            @else
            @foreach($ssecond as $sc)
          <tr>  
              <td>{{$sc->vnumber}}</td>
                <td>{{$sc->vname}}</td>  
                <td>{{$sc->date}}</td> 
                <td>{{$sc->cost}}</td>
                <td>{{$sc->des}}</td> 

              </tr>
            @endforeach 
            @endif 
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div> 
</div>










@endsection
