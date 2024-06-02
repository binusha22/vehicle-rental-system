@extends('layouts.lay')
@section('title','Car Registration')
@section('style')
<style>
        .hidden {
            display: none;
        }
        .showB{
          display: block;
        }
    </style>
@endsection

@section('script')
<script>
       
        

       
        document.addEventListener('DOMContentLoaded', function() {
            // Select the first checkbox by default
            var checkbox1 = document.getElementById('radio1');
            radio1.checked = true;
        });
        // function toggleDiv2() {
        //     var div = document.getElementById('myDiv');
        //     div.classList.toggle('hidden');
        // }
    </script>
<script>
    var radio1 = document.getElementById('radio1');
    var radio2 = document.getElementById('radio2');
    var div = document.getElementById('myDiv');

    radio1.addEventListener('change', toggleDiv);
    radio2.addEventListener('change', toggleDiv);

    function toggleDiv() {
        // Check the state of the radio buttons and toggle visibility accordingly
        if (radio2.checked) {
            div.classList.remove('hidden');
            
        } else {
            div.classList.add('hidden');
            
        }
    }

    // Trigger the event initially to set the initial visibility state
    toggleDiv();
</script>

  <script src="{{asset('app-assets/js/scripts/pages/app-user-list.min.js')}}"> </script>
    <script src="{{asset('app-assets/vendors/js/forms/select/select2.full.min.js')}}"> </script>
    <script src="{{asset('app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js')}}"> </script>
    <script src="{{asset('app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js')}}"> </script>
    <script src="{{asset('app-assets/vendors/js/tables/datatable/datatables.buttons.min.js')}}"> </script>
    <script src="{{asset('app-assets/vendors/js/tables/datatable/buttons.print.min.js')}}"> </script>



<script>
  document.addEventListener('DOMContentLoaded', function () {
    
  });
</script>
{{-- get brand in popup --}}
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const catSelect = document.getElementById('lgg');
        const modelSelect = document.getElementById('lg');

        catSelect.addEventListener('change', function () {
            const selectedBrandId = this.value;
            if (selectedBrandId) {
                // Enable the model dropdown
                modelSelect.disabled = false;
                // Clear existing options in the model dropdown
                modelSelect.innerHTML = "";

                // Add a default "Select" option
                const defaultOption = document.createElement('option');
                defaultOption.text = 'Select Brand';
                defaultOption.value = '0';
                defaultOption.disabled = true;
                defaultOption.selected = true;
                modelSelect.add(defaultOption);

                // Make an AJAX request to fetch models based on the selected category
                fetch(`/get-vcat/${selectedBrandId}`)
                    .then(response => response.json())
                    .then(models => {
                        // Populate the model dropdown with fetched data
                        if (models.length > 0) {
                            models.forEach(model => {
                                const option = document.createElement('option');
                                option.value = model.brand;
                                option.text = model.brand;
                                modelSelect.add(option);
                            });
                        } else {
                            // If no models are found, disable the model dropdown
                            modelSelect.disabled = true;
                            modelSelect.innerHTML = "";
                            const noDataOption = document.createElement('option');
                            noDataOption.text = 'Select Brand';
                            noDataOption.value = '0';
                            noDataOption.disabled = true;
                            noDataOption.selected = true;
                            modelSelect.add(noDataOption);
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching models:', error);
                        // In case of an error, disable the model dropdown and reset it
                        modelSelect.disabled = true;
                        modelSelect.innerHTML = "";
                        const errorOption = document.createElement('option');
                        errorOption.text = 'Select Brand';
                        errorOption.value = '0';
                        errorOption.disabled = true;
                        errorOption.selected = true;
                        modelSelect.add(errorOption);
                    });
            } else {
                // If no category is selected, disable the model dropdown and remove options
                modelSelect.disabled = true;
                modelSelect.innerHTML = "";
                const defaultOption = document.createElement('option');
                defaultOption.text = 'Select Brand';
                defaultOption.value = '0';
                defaultOption.disabled = true;
                defaultOption.selected = true;
                modelSelect.add(defaultOption);
            }
        });
    });
</script>
<!---retrive brand brands---->
<script>
      function loadCategory_Brands() {
        // Make an AJAX request to fetch brands from the server
        loadCat();
        // fetch('{{ route('load-brand') }}')
        //     .then(response => response.json())
        //     .then(data => {
        //         // Populate the dropdown with retrieved brands
        //         const brandSelect = document.getElementById('lg');
        //         brandSelect.innerHTML = ""; // Clear existing options

        //         data.forEach(brand => {
        //             const option = document.createElement('option');
        //             option.value = brand.brand;
        //             option.text = brand.addnewcat; // Replace 'name' with the actual column name in your database
        //             brandSelect.add(option);


        //         });
        //     })
        //     .catch(error => console.error('Error fetching brands:', error));
    }


// load category
   function loadCat() {
    // Make an AJAX request to fetch brands from the server
    fetch('{{ route('load-cat') }}')
        .then(response => response.json())
        .then(data => {
            // Populate the dropdown with retrieved brands
            const brandSelect = document.getElementById('lgg');
            brandSelect.innerHTML = ""; // Clear existing options
            const defaultOption = document.createElement('option');
                defaultOption.text = 'Select Category';
                defaultOption.value = '0';
                brandSelect.add(defaultOption);
            // Create a Set to keep track of added options
            const addedOptions = new Set();

            data.forEach(brand => {
                if (!addedOptions.has(brand.addnewcat)) {
                    const option = document.createElement('option');
                    option.value = brand.addnewcat;
                    option.text = brand.addnewcat; // Replace 'name' with the actual column name in your database
                    brandSelect.add(option);
                    // Add the option value to the Set
                    addedOptions.add(brand.addnewcat);
                }
            });
        })
        .catch(error => console.error('Error fetching brands:', error));
}


    </script>
    <!-- load model data in form -->
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const brandSelect = document.getElementById('brand-select');
        const modelSelect = document.getElementById('model-select');
        const catSelect = document.getElementById('addVcat-select');

        brandSelect.addEventListener('change', function () {
            const selectedBrandId = this.value;
            const selectedCat = catSelect.value;

            if (selectedBrandId) {
                // Enable the model dropdown
                modelSelect.disabled = false;
                // Clear existing options in the model dropdown
                modelSelect.innerHTML = "";

                // Add a default "Select" option
                const defaultOption = document.createElement('option');
                defaultOption.text = 'Select Model';
                defaultOption.value = '';
                defaultOption.disabled = true;
                defaultOption.selected = true;
                modelSelect.add(defaultOption);

                // Make an AJAX request to fetch models based on the selected brand and category
                fetch(`/get-models/${selectedBrandId}/${selectedCat}`)
                    .then(response => response.json())
                    .then(models => {
                        // Populate the model dropdown with fetched data
                        models.forEach(model => {
                            const option = document.createElement('option');
                            option.value = model.model;
                            option.text = model.model;
                            modelSelect.add(option);
                        });
                    })
                    .catch(error => console.error('Error fetching models:', error));
            } else {
                // If no brand is selected, disable the model dropdown and remove options
                modelSelect.disabled = true;
                modelSelect.innerHTML = "";
            }
        });
    });
</script>

{{-- get brand data from category --}}
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const catSelect = document.getElementById('addVcat-select');
        const modelSelect = document.getElementById('brand-select');

        catSelect.addEventListener('change', function () {
            const selectedBrandId = this.value;
            if (selectedBrandId) {
                // Enable the model dropdown
                modelSelect.disabled = false;
                // Clear existing options in the model dropdown
                modelSelect.innerHTML = "";

                // Add a default "Select" option
                const defaultOption = document.createElement('option');
                defaultOption.text = 'Select Brand';
                defaultOption.value = '0';
                defaultOption.disabled = true;
                defaultOption.selected = true;
                modelSelect.add(defaultOption);

                // Make an AJAX request to fetch models based on the selected category
                fetch(`/get-vcat/${selectedBrandId}`)
                    .then(response => response.json())
                    .then(models => {
                        // Populate the model dropdown with fetched data
                        if (models.length > 0) {
                            models.forEach(model => {
                                const option = document.createElement('option');
                                option.value = model.brand;
                                option.text = model.brand;
                                modelSelect.add(option);
                            });
                        } else {
                            // If no models are found, disable the model dropdown
                            modelSelect.disabled = true;
                            modelSelect.innerHTML = "";
                            const noDataOption = document.createElement('option');
                            noDataOption.text = 'Select Brand';
                            noDataOption.value = '0';
                            noDataOption.disabled = true;
                            noDataOption.selected = true;
                            modelSelect.add(noDataOption);
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching models:', error);
                        // In case of an error, disable the model dropdown and reset it
                        modelSelect.disabled = true;
                        modelSelect.innerHTML = "";
                        const errorOption = document.createElement('option');
                        errorOption.text = 'Select Brand';
                        errorOption.value = '0';
                        errorOption.disabled = true;
                        errorOption.selected = true;
                        modelSelect.add(errorOption);
                    });
            } else {
                // If no category is selected, disable the model dropdown and remove options
                modelSelect.disabled = true;
                modelSelect.innerHTML = "";
                const defaultOption = document.createElement('option');
                defaultOption.text = 'Select Brand';
                defaultOption.value = '0';
                defaultOption.disabled = true;
                defaultOption.selected = true;
                modelSelect.add(defaultOption);
            }
        });
    });
</script>


<script>
    // Add event listener to the edit button using jQuery 
    $('.edit-user-btn').click(function() {
        // Clear the selected value of brand-select1
        $('#addVcat-select1').val('');
        
        // Remove any disabled attribute from model-select1
        $('#brand-select1').prop('disabled', true);
        $('#model-select1').prop('disabled', true);
        
        // Check if the "Select Model" option already exists, if not, append it
        if ($('#model-select1 option[value=""]').length === 0) {
            $('#model-select1').append($('<option>', {
                value: '',
                text: 'Select Model',
                selected: true
            }));
        } else {
            // If the option exists, just set it as selected
            $('#model-select1').val('');
        }
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const brandSelect = document.getElementById('brand-select1');
        const modelSelect = document.getElementById('model-select1');
        const catSelect = document.getElementById('addVcat-select1');
        brandSelect.addEventListener('change', function () {
            const selectedBrandId = this.value;
            const selectedCat = catSelect.value;
       if (selectedBrandId) {
                // Enable the model dropdown
                modelSelect.disabled = false;
            // Clear existing options in the model dropdown
            modelSelect.innerHTML = "";
             const defaultOption = document.createElement('option');
            defaultOption.text = 'Select Model';
            defaultOption.disabled = true;
            defaultOption.selected = true;
            modelSelect.add(defaultOption);
            // Make an AJAX request to fetch models based on the selected brand
            fetch(`/get-models/${selectedBrandId}/${selectedCat}`)
                .then(response => response.json())
                .then(models => {
                    // Populate the model dropdown with fetched data
                    models.forEach(model => {
                        const option = document.createElement('option');
                        option.value = model.model;
                        option.text = model.model;
                        modelSelect.add(option);
                    });
                })
                .catch(error => console.error('Error fetching models:', error));
              } else {
                // If no brand is selected, disable the model dropdown
                modelSelect.disabled = true;
                modelSelect.innerHTML = "";
            }
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const catSelect = document.getElementById('addVcat-select1');
        const modelSelect = document.getElementById('brand-select1');
        const uniqueValues = new Set(); // Set to store unique values

        catSelect.addEventListener('change', function () {
            const selectedBrandId = this.value;
            if (selectedBrandId) {
                // Enable the model dropdown
                modelSelect.disabled = false;
                // Clear existing options in the model dropdown
                modelSelect.innerHTML = "";

                // Add a default "Select" option
                const defaultOption = document.createElement('option');
                defaultOption.text = 'Select Brand';
                defaultOption.value = '0';
                defaultOption.disabled = true;
                defaultOption.selected = true;
                modelSelect.add(defaultOption);

                // Make an AJAX request to fetch models based on the selected brand
                fetch(`/get-vcat/${selectedBrandId}`)
                    .then(response => response.json())
                    .then(models => {
                        // Populate the model dropdown with fetched data
                        if (models.length > 0) {
                            models.forEach(model => {
                                // Check if the value is not already in the set
                                
                                    const option = document.createElement('option');
                                    option.value = model.brand;
                                    option.text = model.brand;
                                    modelSelect.add(option);
                                    // Add the value to the set
                                    uniqueValues.add(model.brand);
                                
                            });
                        } else {
                            // If no models are found, disable the model dropdown
                            modelSelect.disabled = true;
                            modelSelect.innerHTML = "";
                            const noDataOption = document.createElement('option');
                            noDataOption.text = 'Select Brand';
                            noDataOption.value = '0';
                            noDataOption.disabled = true;
                            noDataOption.selected = true;
                            modelSelect.add(noDataOption);
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching models:', error);
                        // In case of an error, disable the model dropdown and reset it
                        modelSelect.disabled = true;
                        modelSelect.innerHTML = "";
                        const errorOption = document.createElement('option');
                        errorOption.text = 'Select Brand';
                        errorOption.value = '0';
                        errorOption.disabled = true;
                        errorOption.selected = true;
                        modelSelect.add(errorOption);
                    });
            } else {
                // If no brand is selected, disable the model dropdown and remove options
                modelSelect.disabled = true;
                modelSelect.innerHTML = "";
                const defaultOption = document.createElement('option');
                defaultOption.text = 'Select Brand';
                defaultOption.value = '0';
                defaultOption.disabled = true;
                defaultOption.selected = true;
                modelSelect.add(defaultOption);
                // Clear the set
                
            }
        });
    });
</script>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const editVehicleForm = document.getElementById('editVehicleForm');
        const vid = document.getElementById('vid');
        const editButtons = document.querySelectorAll('.vehicle-button');
        const myDivhide = document.getElementById('myDivhide');
        const radio1 = document.getElementById('radiopop1');
        const radio2 = document.getElementById('radiopop2');

        radio1.addEventListener('change', function () {
            if (radio1.checked) {
                myDivhide.classList.add('hidden');
            } else {
                myDivhide.classList.remove('hidden');
            }
        });

        radio2.addEventListener('change', function () {
            if (radio2.checked) {
                myDivhide.classList.remove('hidden');
            } else {
                myDivhide.classList.add('hidden');
            }
        });

        // Add click event listener to each edit button
        editButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                // Get data attributes
                const getVid = button.getAttribute('data-v-id');
                const getOwnertype = button.getAttribute('data-owner-type');
                const brand = button.getAttribute('data-brand');
                const model = button.getAttribute('data-getmodel');
                const year = button.getAttribute('data-year');
                const vehicle_number = button.getAttribute('data-vehicle_number');
                const milelage = button.getAttribute('data-milelage');
                const chasis = button.getAttribute('data-chasis');
                const engine_number = button.getAttribute('data-engine_number');
                const vehicle_color = button.getAttribute('data-vehicle_color');
                const lice_start = button.getAttribute('data-lice_start');
                const lice_end = button.getAttribute('data-lice_end');
                const insu_start = button.getAttribute('data-insu_start');
                const insu_end = button.getAttribute('data-insu_end');
                const registerdate = button.getAttribute('data-registerdate');
                const owner_fname = button.getAttribute('data-owner_fname');
                const owner_id = button.getAttribute('data-owner_id');
                const address = button.getAttribute('data-address');
                const owner_phone_number = button.getAttribute('data-owner_phone_number');
                const vcat =button.getAttribute('data-vcat');

                // Update form fields

                vid.value = getVid;  owner_agreed_miledge
                document.getElementById('vIdInput').value = getVid;
                //document.getElementById('brand-select1').value = brand;
                document.getElementById('showVact').value = vcat;
                document.getElementById('showModel').value = model;
                document.getElementById('showBrand').value = brand;
                document.getElementById('year').value = year;
                document.getElementById('vehicle_number').value = vehicle_number;
                document.getElementById('address2').value = address;
                document.getElementById('chasis').value = chasis;
                document.getElementById('engine_number').value = engine_number;
                document.getElementById('vehicle_color').value = vehicle_color;
                document.getElementById('lice_start').value = lice_start;
                document.getElementById('lice_end').value = lice_end;
                document.getElementById('insu_start').value = insu_start;
                document.getElementById('insu_end').value = insu_end;
                document.getElementById('registerdate').value = registerdate;
                document.getElementById('owner_fname').value = owner_fname;
                document.getElementById('owner_id2').value = owner_id;
                document.getElementById('owner_phone_number2').value = owner_phone_number;

                // Check radio buttons based on owner type
                if (getOwnertype === 'Company Owner') {
                    radio1.checked = true;
                    myDivhide.classList.add('hidden');
                } else {
                    radio2.checked = true;
                    myDivhide.classList.remove('hidden');
                }


                // Update form action
                editVehicleForm.action = `/vehicle_update/${getVid}`;
            });
        });
    });
</script>

{{-- get model value to controller --}}
<script>
    $(document).ready(function() {
        // When the form is submitted
        $('form').submit(function() {
            // Get the value of the <p> tag
            var modelValue = $('#showModel').text();
            // Set the value of the hidden input field
            $('#model_value_input').val(modelValue);
        });
    });
</script>
<script>
    // Add event listener to brand-select1
    document.getElementById('brand-select1').addEventListener('change', function() {
        var selectedBrand = this.value; // Get the selected brand
        document.getElementById('showBrand').value = 'No Previous Brand'; // Set the selected brand in showBrand
    });

    // Add event listener to model-select1
    document.getElementById('model-select1').addEventListener('change', function() {
        var selectedModel = this.value; // Get the selected model
        document.getElementById('showModel').value = 'No Previous Model'; // Set the selected model in showModel
    });
    document.getElementById('addVcat-select1').addEventListener('change', function() {
        var selectedModel = this.value; // Get the selected model
        document.getElementById('showVact').value = 'No Previous Category'; // Set the selected model in showModel
    });
</script>
@endsection

@section('content')
@if(session('success'))
    <div class="toastqq" id="toastqq">{{session('success')}}</div>
@endif

<!-- Include toast notification for failure -->
@if(session('error'))
    <div class="toastHH" id="toastHH">{{session('error')}}</div>
@endif
@if(session('s'))
    <div class="toastqq" id="toastqq">{{session('s')}}</div>
@endif

<!-- Include toast notification for failure -->
@if(session('f'))
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
<div class="content-body"><!-- Validation -->
  <section class="bs-validation">
    <div class="row">
      <!-- Bootstrap Validation -->
      <div class="col-md-6 col-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Vehicles Register</h4>

            
          </div>
          <div class="card-body">
            <form class="needs-validation" method="post" action="{{route('vehicle-register')}}">
              @csrf
              <div class="mb-1">
                <div class="col-12">
                  <label class="form-label" for="addVcat-select">Select Vehicles Category</label>
                  
                    <select class="select2-size-lg form-select" id="addVcat-select" name="addVcat">
                    <option value="">Select Category</option>
                        @foreach($vdata as $vvd)
                      <option value="{{$vvd->vcat}}">{{$vvd->vcat}}</option>
                      
                      @endforeach
                    </select>
                  
                </div>
                
              </div>

            <div class="mb-1">
                <div class="col-12">
                  <label class="form-label" for="brand-select">Select Vehicles Brand</label>
                  
                    <select class="select2-size-lg form-select" id="brand-select" name="brand" disabled>
                    <option value="0">Select Brand</option>
                        {{-- @foreach($branddata as $da)
                      <option value="{{$da->brand}}">{{$da->brand}}</option>
                      
                      @endforeach --}}
                    </select>
                  
                </div>
                
              </div>

              <div class="mb-1">
                <div class="col-12">
                  <label class="form-label" for="model-select">Select Vehicles Model</label>
                  
                    <select class="select2-size-lg form-select" id="model-select" name="model" disabled>
                      <option value="">Select</option>
                      
                    </select>
                  
                </div>
               
              </div>

              <div class="mb-1">
                <label class="form-label" for="basic-addon-name">Vehicles Year</label>
  
                <input
                  type="text"
                  id="basic-addon-name"
                  class="form-control"
                  placeholder="2024"
                  name="year"
                  value="{{old('year')}}"
                  aria-label="Name"
                  aria-describedby="basic-addon-name"
                 
                />
               
              </div>


              <div class="mb-1">
                <label class="form-label" for="basic-addon-name">Vehicles Number</label>
  
                <input
                  type="text"
                  id="basic-addon-name"
                  class="form-control"
                  placeholder="ABC-5432"
                  aria-label="Name"
                  name="vehicle_number"
                  value="{{old('vehicle_number')}}"
                  aria-describedby="basic-addon-name"
                  
                />
                
              </div>

              <div class="mb-1">
                <label class="form-label" for="basic-addon-name">Mileage</label>
  
                <input
                  type="text"
                  id="basic-addon-name"
                  class="form-control"
                  placeholder="28383 KM"
                  name="mielage"
                  value="{{old('mielage')}}"
                  aria-label="Name"
                  aria-describedby="basic-addon-name"
                  
                />
                
              </div>

              <div class="mb-1">
                <label class="form-label" for="basic-addon-name">Chasis Number</label>
  
                <input
                  type="text"
                  id="basic-addon-name"
                  class="form-control"
                  placeholder="B283831234"
                  name="chasis"
                  value="{{old('chasis')}}"
                  aria-label="Name"
                  aria-describedby="basic-addon-name"
                  
                />
                
              </div>
              <div class="mb-1">
                <label class="form-label" for="basic-addon-name">Engine Number</label>
  
                <input
                  type="text"
                  id="basic-addon-name"
                  class="form-control"
                  placeholder="B283831234"
                  name="engine_number"
                  value="{{old('engine_number')}}"
                  aria-label="Name"
                  aria-describedby="basic-addon-name"
                  
                />
                
              </div>
             <div class="mb-1">
                <label class="form-label" for="basic-addon-name">color</label>
  
                <input
                  type="text"
                  id="basic-addon-name"
                  class="form-control"
                  placeholder="blue"
                  name="vehicle_color"
                  value="{{old('vehicle_color')}}"
                  aria-label="Name"
                  aria-describedby="basic-addon-name"
                  
                />
                
              </div>
              <label>License</label>
              <div class="col-md-4 mb-1">
                <label class="form-label" for="fp-default">start</label>
                <input type="text" id="fp-default" class="form-control flatpickr-basic" name="lice_start"  value="{{old('lice_start')}}"placeholder="YYYY-MM-DD" />

                <label class="form-label" for="fp-default">End</label>
                <input type="text" id="fp-default" class="form-control flatpickr-basic" name="lice_end" value="{{old('lice_end')}}"placeholder="YYYY-MM-DD" />
              </div>

              <label>Insurance</label>
              <div class="col-md-4 mb-1">
                <label class="form-label" for="fp-default">start</label>
                <input type="text" id="fp-default" class="form-control flatpickr-basic" name="insu_start"value="{{old('insu_start')}}"placeholder="YYYY-MM-DD" />

                <label class="form-label" for="fp-default">End</label>
                <input type="text" id="fp-default" class="form-control flatpickr-basic" name="insu_end"value="{{old('insu_end')}}"placeholder="YYYY-MM-DD" />
              </div>
              <div class="col-md-12 mb-1">
                <label class="form-label" for="fp-default">Vehicle register Date</label>
                <input type="text" id="fp-default" class="form-control flatpickr-basic" name="registerdate" value="{{old('registerdate')}}"placeholder="YYYY-MM-DD" />
              </div>
              <div class="mb-1">
                <label class="form-label" class="d-block">Owner</label>
                <div class="form-check my-50">
                  <input
                    type="radio"
                    id="radio1"
                    value="Company Owner"
                    name="owner_type"
                    class="form-check-input"
                    
                  />
                  <label class="form-check-label" for="radio1">Company Owner</label>
                </div>
                <div class="form-check">
                  <input
                    type="radio"
                    id="radio2"
                    value="other Owner"
                    name="owner_type"

                    class="form-check-input"
                    
                  />
                  <label class="form-check-label" for="radio2">Other Owner</label>
                </div>
              </div>
             
              
              <div id="myDiv" class="hidden">
                
              <div class="mb-1">
                <label class="form-label" for="basic-addon-name">Owner Full Name</label>
  
                <input
                  type="text"
                  id="basic-addon-name"
                  class="form-control"
                  placeholder="Owner Name"
                  aria-label="Name"
                  name="owner_fname"
                  value="{{old('owner_fname')}}"
                  aria-describedby="basic-addon-name"
                  
                />
              </div>
<div class="mb-1">
                <label class="form-label" for="basic-addon-name">Address</label>
  
                <input
                  type="text"
                  id="basic-addon-name"
                  class="form-control"
                  placeholder="Owner Address"
                  aria-label="Name"
                  name="address"
                  value="{{old('address')}}"
                  aria-describedby="basic-addon-name"
                  
                />
              </div>
              <div class="mb-1">
                <label class="form-label" for="owner_id">ID Number</label>
  
                <input
                  type="text"
                  id="owner_id"
                  class="form-control"
                  placeholder="48877222v"
                  name="owner_id"
                  value="{{old('owner_id')}}"
                  aria-describedby="owner_id"
                 
                />
                
              </div>

              <div class="mb-1">
                <label class="form-label" for="basic-addon-name">Phone Number</label>
  
                <input
                  type="number"
                  id="basic-addon-name"
                  class="form-control"
                  name="owner_phone_number"
                  value="{{old('owner_phone_number')}}"
                  placeholder="0770923423"
                  aria-label="Name"
                  aria-describedby="basic-addon-name"
                  
                />
                
              </div>
              <div class="mb-1">
                <label class="form-label" for="basic-addon-name">Agreed Miledge</label>
  
                <input
                  type="number"
                  id="basic-addon-name"
                  class="form-control"
                  name="agreed_miledge"
                  value="{{old('agreed_miledge')}}"
                  placeholder="12345"
                  aria-label="Name"
                  aria-describedby="basic-addon-name"
                  
                />
                
              </div>
              <div class="mb-1">
                <label class="form-label" for="basic-addon-name">Agreed Payment</label>
  
                <input
                  type="number"
                  id="basic-addon-name"
                  class="form-control"
                  name="agreed_payment"
                  value="{{old('agreed_payment')}}"
                  placeholder="Rs."
                  aria-label="Name"
                  aria-describedby="basic-addon-name"
                  
                />
                
              </div>
              
        
      </div>

              
            <button class="btn btn-primary " id="submitShort">Submit</button>
            </form>
          </div>
        </div>
      </div>
      <!-- /Bootstrap Validation -->
  
      <!-- jQuery Validation -->
      <div class="col-md-6 col-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Vehicles Category / Brand / Model </h4>
          </div>
          <div class="card-body">
            <form class="form form-vertical" method="post" action="{{route('add-cat')}}">
              @csrf
              <div class="row">
                <div class="col-12">
                  <div class="mb-1">
                    <label class="form-label" for="first-name-vertical">Vehicles Category</label>
                    <input
                      type="text"
                      
                      id="first-name-vertical"
                      class="form-control"
                      name="vcat"
                      value="{{old('vcat')}}"
                      placeholder="Car"
                    />
                    <span class="text-danger">@error('vcat'){{$message}}@enderror</span>
                  </div>
                </div>
               
                
                <div class="col-12">
                <button class="btn btn-primary  " >Add</button>
                  
                </div>
              </div>
            </form><br>

                {{-- Vehicles brand section --}}
           
            <form class="form form-vertical" method="post" action="{{route('add-brand')}}">
              @csrf
              <div class="row">
                <div class="col-12">
                  <div class="mb-1">
                    <label class="form-label" for="first-name-vertical">Vehicles Brand</label>
                    <input
                      type="text"
                      
                      id="first-name-vertical"
                      class="form-control"
                      name="brand"
                      value="{{old('brand')}}"
                      placeholder="BMW"
                    />
                    <span class="text-danger">@error('brand'){{$message}}@enderror</span>
                  </div>
                </div>
               <div class="col-12">
                  <div class="mb-1">
                    <label class="form-label" for="first-name-vertical">Vehicles Category</label>
                    <select class="select2-size-lg form-select" id="" name="addnewcat">
                    <option value="">Select Category</option>
                        @foreach($vdata as $vvd)
                      <option value="{{$vvd->vcat}}">{{$vvd->vcat}}</option>
                      
                      @endforeach
                    </select>
                    <span class="text-danger">@error('addnewcat'){{$message}}@enderror</span>
                  </div>
                </div>
                
                <div class="col-12">
                <button type="submit" class="btn btn-primary  " >Add</button>
                  
                </div>
              </div>
            </form><br>
            
            {{-- Vehicles Model section --}}

            <form class="form form-vertical" method="post" action="{{route('add-model')}}">
            @csrf
              <div class="row">
                <div class="col-12">
                  <div class="mb-1">
                    <label class="form-label" for="first-name-vertical">Vehicles Model</label>
                    <input
                      type="text"
                      id="first-name-vertical"
                      class="form-control"
                      name="modelget"
                      value="{{old('modelget')}}"
                      placeholder="Minicooper"
                    />
                    <span class="text-danger">@error('modelget'){{$message}}@enderror</span>
                  </div>
                </div>
               
                
                <div class="col-3">
                  <div class="add-task">
                    <button  type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#new-task-modal" onclick="loadCategory_Brands();">
                      Add
                    </button>
                    
                  </div> 
                 
                  <div class="modal modal-slide-in sidebar-todo-modal fade" id="new-task-modal">
                    <div class="modal-dialog sidebar-lg">
                      <div class="modal-content p-0">


                        <form id="form-modal-todo" class="todo-modal needs-validation" novalidate onsubmit="return false">




                          <div class="modal-header align-items-center mb-1">
                            <h5 class="modal-title">Add Coresponding Vehicles Category/ Brand</h5>
                            <div class="todo-item-action d-flex align-items-center justify-content-between ms-auto">
                              <span class="todo-item-favorite cursor-pointer me-75"
                                ></i
                              ></span>
                              <i data-feather="x" class="cursor-pointer" data-bs-dismiss="modal" stroke-width="3"></i>
                            </div>
                          </div>
                          <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                            <div class="action-tags">
                              
                              <div class="col-12">
                                <label class="form-label" for="lgg">Select Vehicles Category</label>
                                
                                  <select class="select2-size-lg form-select" id="lgg" name="vcat2">
                                    
                                    
                                  </select>
                                
                              </div>
                              
                              <div class="col-12">
                                <label class="form-label" for="lg">Select Vehicles Brand</label>
                                
                                  <select class="select2-size-lg form-select" id="lg" name="brand2"disabled>
                                    <option value="">Select</option>
                                    
                                  </select>
                                
                              </div>

                              
                              
                            </div>
                            <br>
                            <div class="col-12">
                              <button type="submit" class="btn btn-primary">Add</button>
                              
                            </div>
                          </div>
                        </form>




                      </div>
                    </div>
                  </div>

                  
                
                </div>
              </div>

              

              
            </form>





            
          </div>
        </div>
      </div>

      <div class="row" id="table-hover-row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title">Vehicles Details</h4>
            </div>
            <div class="table-responsive">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>Vehicles</th>
                    <th>Vehicles Number</th>
                    <th>Chasis Number</th>
                    <th>Color</th>
                    <th>Engine Number</th>
                    <th>Mileage</th>
                    <th>Owner</th>
                    <th>Owner Address</th>
                    <th>Vehicle Register Date</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                @foreach($data as $item)
                  <tr>
                    <td>
                      <span class="fw-bold">{{$item->brand}} {{$item->model}} {{$item->year}}</span>
                    </td>
                    <td>{{$item->vehicle_number}}</td>
                    <td>{{$item->chasis}}</td>
                    <td>{{$item->vehicle_color}}</td>
                    <td>{{$item->engine_number}}</td>
                    <td>{{$item->mielage}}</td>
                    
                    <td>
                        @if($item->owner_type=='Company Owner')
                            {{$item->owner_type}}
                        @else
                            {{$item->owner_fname}}
                        @endif
                        
                    </td>
                    <td>
                        @if($item->owner_type=='Company Owner')
                            No address
                        @else
                            {{$item->address}}
                        @endif
                        
                    </td>
                    <td>{{$item->registerdate}}</td>
                    <td>
                      <div class="dropdown">
                        <button type="button" class="btn btn-sm dropdown-toggle hide-arrow py-0" data-bs-toggle="dropdown">
                          <i data-feather="more-vertical"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                          <button class="dropdown-item edit-user-btn vehicle-button setWidth" href="#"
                         data-v-id="{{ $item->id }}" 
                         data-brand="{{ $item->brand}}" 
                         data-vcat="{{ $item->vcat}}" 
                         data-getmodel="{{ $item->model}}" 
                         data-year="{{ $item->year}}" 
                         data-vehicle_number="{{ $item->vehicle_number}}" 
                         data-milelage="{{ $item->mielage}}" 
                         data-chasis="{{ $item->chasis}}" 
                         data-engine_number="{{ $item->engine_number}}" 
                         data-vehicle_color="{{ $item->vehicle_color}}" 
                         data-lice_start="{{ $item->lice_start}}" 
                         data-lice_end="{{ $item->lice_end}}" 
                         data-insu_start="{{ $item->insu_start}}" 
                         data-insu_end="{{ $item->insu_end}}" 
                         data-registerdate="{{ $item->registerdate}}" 
                         data-owner_fname="{{ $item->owner_fname}}" 
                         data-owner_id="{{ $item->owner_id}}" 
                         data-owner_phone_number="{{ $item->owner_phone_number}}" 
                         data-owner-type="{{ $item->owner_type}}" 
                        data-address="{{ $item->address}}"
                        
                         data-bs-toggle="modal" data-bs-target="#editVehicle">
                      <i data-feather="edit-2" class="me-50"></i>
                      <span>Edit</span>
                  </button>
                    <form action="{{ route('setvehicledelete', ['id' => $item->id]) }}" method="post">

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
        </div>
      </div>

      <!-- /jQuery Validation -->
    </div>
  </section>
</div>


 <!-- Edit User Modal -->
<div class="modal fade" id="editVehicle" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user col-md-12">
    <div class="modal-content">
      <div class="modal-header bg-transparent">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body pb-5 px-sm-5 pt-50">
        <div class="text-center mb-2">
          <h1 class="mb-1">Edit Vehicle Information</h1>
          
        </div>
        <form action="{{ route('vehicle_update', ['id' => 0]) }}" method="post" id="editVehicleForm">
          <input type="hidden" id="vid" name="vid" value="">
          <input type="hidden" name="model_value" id="model_value_input" value="" />
          @csrf
          @method('PUT')
          <div class="col-12 ">
            <label class="form-label" for="">Vehicle Id : </label>
            <input type="text" id="vIdInput" name="vIdInput" class="form-control" value="" >
          </div>
          <div class="mb-1">
                <div class="col-12">
                  <label class="form-label" for="brand-select">Show vehicle category <span style="color: red;">(</span>previous<span style="color: red;">)</span></label>
                  
                  {{-- <p id="showBrand" name="showBrand" style="border-left: 1px solid blue;"></p> --}}
                  <input type="text" id="showVact" name="showVact" class="form-control" readonly>
                  
                </div>
                
              </div>
              <div class="mb-1">
                <div class="col-12">
                  <label class="form-label" for="brand-select">Show vehicle brand <span style="color: red;">(</span>previous<span style="color: red;">)</span></label>
                  
                  {{-- <p id="showBrand" name="showBrand" style="border-left: 1px solid blue;"></p> --}}
                  <input type="text" id="showBrand" name="showBrand" class="form-control" readonly>
                  
                </div>
                
              </div>
              <div class="mb-1">
                <div class="col-12">
                  <label class="form-label" for="brand-select">Show vehicle model <span style="color: red;">(</span>previous<span style="color: red;">)</span></label>
                  
                  {{-- <p id="showModel" style="border-left: 1px solid blue;"></p> --}}
                  <input type="text" id="showModel" name="showModel" class="form-control"  readonly>

                  
                </div>
                
              </div>
              <div class="mb-1">
                <div class="col-12">
                  <label class="form-label" for="addVcat-select">Select Vehicles Category</label>
                  
                    <select class="select2-size-lg form-select" id="addVcat-select1" name="addVcat2">
                    <option value="">Select Category</option>
                        @foreach($vdata as $vvd)
                      <option value="{{$vvd->vcat}}">{{$vvd->vcat}}</option>
                      
                      @endforeach
                    </select>
                  
                </div>
                
              </div>
              <div class="mb-1">
                <div class="col-12">
                  <label class="form-label" for="brand-select">Select Vehicles Brand<span style="color: green;">(</span>add new brand here<span style="color: green;">)</span></label>
                  
                    <select class="select2-size-lg form-select" id="brand-select1" name="brand">
                    <option value="">Select Brand</option>
                        {{-- @foreach($branddata as $da)
                      <option value="{{$da->brand}}">{{$da->brand}}</option>
                      
                      @endforeach --}}
                    </select>

                  
                </div>
                
              </div>
              <div class="mb-1">
                <div class="col-12">
                  <label class="form-label" for="model-select">Select Vehicles Model<span style="color: green;">(</span>add new model here<span style="color: green;">)</span></label>
                  
                    <select class="select2-size-lg form-select" id="model-select1" name="model2" >
                      
                      
                    </select>
                  
                </div>
               
              </div>

              <div class="mb-1">
                <label class="form-label" for="basic-addon-name">Vehicles Year</label>
  
                <input
                  type="text"
                  id="year"
                  class="form-control"
                  placeholder="2024"
                  name="year"
                  value="{{old('year')}}"
                  aria-label="Name"
                  aria-describedby="basic-addon-name"
                 
                />
               
              </div>


              <div class="mb-1">
                <label class="form-label" for="basic-addon-name">Vehicles Number</label>
  
                <input
                  type="text"
                  id="vehicle_number"
                  class="form-control"
                  placeholder="ABC-5432"
                  aria-label="Name"
                  name="vehicle_number"
                  value="{{old('vehicle_number')}}"
                  aria-describedby="basic-addon-name"
                  readonly
                />
                
              </div>

              <div class="mb-1">
                <label class="form-label" for="basic-addon-name">Chasis Number</label>
  
                <input
                  type="text"
                  id="chasis"
                  class="form-control"
                  placeholder="B283831234"
                  name="chasis"
                  aria-label="Name"
                  aria-describedby="basic-addon-name"
                  
                />
                
              </div>
              <div class="mb-1">
                <label class="form-label" for="basic-addon-name">Engine Number</label>
  
                <input
                  type="text"
                  id="engine_number"
                  class="form-control"
                  placeholder="B283831234"
                  name="engine_number"
                  aria-label="Name"
                  aria-describedby="basic-addon-name"
                  
                />
                
              </div>
             <div class="mb-1">
                <label class="form-label" for="basic-addon-name">color</label>
  
                <input
                  type="text"
                  id="vehicle_color"
                  class="form-control"
                  placeholder="blue"
                  name="vehicle_color"
                  aria-label="Name"
                  aria-describedby="basic-addon-name"
                  
                />
                
              </div>
              <label>License</label>
              <div class="col-md-4 mb-1">
                <label class="form-label" for="lice_start">start</label>
                <input type="text" id="lice_start" class="form-control flatpickr-basic" name="lice_start" placeholder="YYYY-MM-DD" />

                <label class="form-label" for="lice_end">End</label>
                <input type="text" id="lice_end" class="form-control flatpickr-basic" name="lice_end" placeholder="YYYY-MM-DD" />
              </div>

              <label>Insurance</label>
              <div class="col-md-4 mb-1">
                <label class="form-label" for="insu_start">start</label>
                <input type="text" id="insu_start" class="form-control flatpickr-basic" name="insu_start"placeholder="YYYY-MM-DD" />

                <label class="form-label" for="insu_end">End</label>
                <input type="text" id="insu_end" class="form-control flatpickr-basic" name="insu_end"placeholder="YYYY-MM-DD" />
              </div>
              <div class="col-md-12 mb-1">
                <label class="form-label" for="registerdate">Vehicle register Date</label>
                <input type="text" id="registerdate" class="form-control flatpickr-basic" name="registerdate" placeholder="YYYY-MM-DD" />
              </div>
              <div class="mb-1">
                <label class="form-label" class="d-block">Owner</label>
                <div class="form-check my-50">
                  <input
                    type="radio"
                    id="radiopop1"
                    value="Company Owner"
                    name="owner_type"
                    class="form-check-input"
                    
                  />
                  <label class="form-check-label" for="radio1">Company Owner</label>
                </div>
                <div class="form-check">
                  <input
                    type="radio"
                    id="radiopop2"
                    value="other Owner"
                    name="owner_type"

                    class="form-check-input"
                    
                  />
                  <label class="form-check-label" for="radio2">Other Owner</label>
                </div>
              </div>
             
              
              <div id="myDivhide" class="hidden">
                
              <div class="mb-1">
                <label class="form-label" for="basic-addon-name">Owner Full Name</label>
  
                <input
                  type="text"
                  id="owner_fname"
                  class="form-control"
                  placeholder="Owner Name"
                  aria-label="Name"
                  name="owner_fname"
                  aria-describedby="basic-addon-name"
                  
                />
              </div>

              <div class="mb-1">
                <label class="form-label" for="owner_id">ID Number</label>
  
                <input
                  type="text"
                  id="owner_id2"
                  class="form-control"
                  placeholder="48877222v"
                  name="owner_id"
                  
                  aria-describedby="owner_id"
                 
                />
                
              </div>
                <div class="mb-1">
                <label class="form-label" for="owner_id">Address</label>
  
                <input
                  type="text"
                  id="address2"
                  class="form-control"
                  placeholder="48877222v"
                  name="address2"
                  
                  aria-describedby="owner_id"
                 
                />
                
              </div>
              <div class="mb-1">
                <label class="form-label" for="basic-addon-name">Phone Number</label>
  
                <input
                  type="number"
                  id="owner_phone_number2"
                  class="form-control"
                  name="owner_phone_number"
                  placeholder="0770923423"
                  aria-label="Name"
                  aria-describedby="basic-addon-name"
                  
                />
                
              </div>
              <div class="mb-1">
                <label class="form-label" for="basic-addon-name">Agreed Miledge</label>
  
                <input
                  type="number"
                  id="owner_agreed_miledge"
                  class="form-control"
                  name="owner_agreed_miledge"
                  value="{{old('owner_agreed_miledge')}}"
                  placeholder="12345"
                  aria-label="Name"
                  aria-describedby="basic-addon-name"
                  
                />
                
              </div>
              <div class="mb-1">
                <label class="form-label" for="basic-addon-name">Agreed Payment</label>
  
                <input
                  type="number"
                  id="owner_agreed_payment"
                  class="form-control"
                  name="owner_agreed_payment"
                  value="{{old('owner_agreed_payment')}}"
                  placeholder="Rs."
                  aria-label="Name"
                  aria-describedby="basic-addon-name"
                  
                />
                
              </div>
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

