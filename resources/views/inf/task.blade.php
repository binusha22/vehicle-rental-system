@extends('layouts.lay')
@section('title','Employee task')
@section('style')
<style>
    #modalImage {
  max-width: 100%;
  height: auto;

}
.addMargin{
    margin-right: 10px;
  }
</style>
<style>
        /* Loader CSS */
        #loader {
            border: 16px solid #f3f3f3; /* Light grey */
            border-top: 16px solid #3498db; /* Blue */
            border-radius: 50%;
            width: 120px;
            height: 120px;
            animation: spin 2s linear infinite;
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 999; /* Sit on top */
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
@endsection

@section('content')
<div id="loader" style="display:none;"></div>

<!-- Modal -->
<!-- Modal -->
<!-- Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-body">
        <div id="carousel-wrap" class="carousel slide" data-bs-ride="carousel" data-bs-wrap="false">
          <div class="carousel-inner" role="listbox">
            <!-- Carousel items will be dynamically added here -->
          </div>
          <a class="carousel-control-prev" data-bs-target="#carousel-wrap" role="button" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
          </a>
          <a class="carousel-control-next" data-bs-target="#carousel-wrap" role="button" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
          </a>
        </div>
      </div>
    </div>
  </div>
</div>




@if(session('s'))
    <div class="toastqq" id="toastqq">{{session('s')}}</div>
@endif

<!-- Include toast notification for failure -->
@if(session('f'))
    <div class="toastHH" id="toastHH">{{session('f')}}</div>
@endif
@if($tasks->isEmpty())
    <div class="alert alert-info" role="alert">
        You have No other tasks.
    </div>
@else
@foreach($tasks as $tak)


<div style="margin-bottom: 5px;">
    <!-- User Timeline Card -->
    <div class="col-lg-12">
        <div class="card card-user-timeline">
            <div class="row">
                <div class="card-body col-lg-6">
                    <div class="mb-2 gap-4">
                        <h4 class="">Task Number: <span id="taskNumber">{{$tak->id}}</span></h4>
                        <h5 class="">vehicle Number: <span id="taskNumber" style="color: yellow;">{{$tak->vehicle_number}}</span></h5>
                        @if($tak->task_type == 'get_end_mileage')
                        <h2 class="d-none" value="{{ $tak->inv }}" name="{{ $tak->inv }}">{{ $tak->inv }}</h2>
                        <button type="button" class="btn-primary mt-1 ml-0 getImagesBtn" data-invoice="{{$tak->inv}}" style="width: 25px; height: 25px; border-radius: 5px;" data-bs-toggle="modal" data-bs-target="#imageModal"><i data-feather="camera"></i></button>

                        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
                        <script>
                            $(document).ready(function(){
                                $('.getImagesBtn').click(function(){
                                    var invoiceNumber = $(this).data('invoice');
                                    console.log(invoiceNumber);
                                    $.ajax({
                                        url: '/fetch-images', // Replace with your route for fetching images
                                        type: 'GET',
                                        data: {invoice: invoiceNumber},
                                        success: function(response){
                                            console.log("res "+response);
                                            //Clear existing images
                                            $('#carousel-wrap .carousel-inner').empty();
                                            //Append fetched images to the carousel
                                            response.forEach(function(imageUrl){
                                                $('#carousel-wrap .carousel-inner').append('<div class="carousel-item"><img src="/storage/'+imageUrl+'" class="d-block w-100" alt="Image"></div>');
                                            });
                                            // Activate the first carousel item
                                            $('#carousel-wrap .carousel-inner .carousel-item').first().addClass('active');
                                        }
                                    });
                                });
                            });
                        </script>

                    @endif
                      
                      @if($tak->task_type=='get_end_gas')  

                        <h2 class="d-none" value="{{ $tak->inv }}" name="{{ $tak->inv }}">{{ $tak->inv }}</h2>
                        <button type="button" class="btn-warning mt-1 ml-0 getGasBtn" data-invoice="{{$tak->inv}}" style="width: 25px; height: 25px; border-radius: 5px;" data-bs-toggle="modal" data-bs-target="#imageModal"><i data-feather="camera"></i></button>
                        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
                        <script>
                            $(document).ready(function(){
                                $('.getGasBtn').click(function(){
                                    var invoiceNumber = $(this).data('invoice');
                                    console.log(invoiceNumber);
                                    $.ajax({
                                        url: '/fetch-gas-image', // Replace with your route for fetching images
                                        type: 'GET',
                                        data: {invoice: invoiceNumber},
                                        success: function(response){
                                            console.log("res of gas "+response);
                                            //Clear existing images
                                            $('#carousel-wrap .carousel-inner').empty();
                                            //Append the fetched image to the carousel
                                            $('#carousel-wrap .carousel-inner').append('<div class="carousel-item active"><img src="/storage/' + response + '" class="d-block w-100" alt="Image"></div>');
                                        }
                                    });
                                });
                            });
                        </script>
                      @endif
                       
                        
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="d-flex flex-row">
                            <div class="user-info">
                                <h5 class="mb-0">To, {{$tak->name}}</h5>
                                <small class="text-muted">Uploaded on {{$tak->date}} at </small>
                            </div>
                        </div>
                    </div>
                    <p class="card-text mb-2">
                        {{$tak->task_desc}}
                    </p>
                </div>
                <input type="hidden" name="section_id" value="{{$tak->id}}">
               
                
                <div class="card-body col-lg-5" style="border-left: px solid black;">
                
                <form action="{{ route('set_taks') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <!-- Add a hidden input to store the section ID -->
                    <input type="hidden" name="task_id" value="{{$tak->id}}">
                    <input type="hidden" name="task_type" value="{{$tak->task_type}}">
                    <input type="hidden" name="section_id" value="{{$tak->inv}}">
                    <div class="row">
                        <div class="mb-0">
                           
                        </div>
                        @if($tak->task_type=='get_mileage')
                        <div class="col-sm-6 col-12">
                            <div class="mb-2">
                                <label class="form-label" for="miledge">Mileage</label>
                                <input type="number" id="miledge" class="form-control" placeholder="Mileage" name="miledge" />
                                <span class="text-danger">@error('miledge'){{$message}}@enderror</span>
                            </div>
                        </div>
                         @endif
                         @if($tak->task_type=='get_end_mileage')
                        <div class="col-sm-6 col-12">
                            <div class="mb-2">
                                <label class="form-label" for="miledge">End Mileage</label>
                                <input type="number" id="miledge" class="form-control" placeholder="Mileage" name="endmiledge" />
                                <span class="text-danger">@error('endmiledge'){{$message}}@enderror</span>
                            </div>
                        </div>
                         @endif
                        @if($tak->task_type=='get_gas')
                        <div class="col-sm-6 col-12">
                            <div class="mb-2">
                                <label class="form-label" for="gaslevel">Gas Level</label>
                                <input type="number" id="gaslevel" class="form-control" placeholder="Gas Level" name="gas" />
                                <span class="text-danger">@error('gas'){{$message}}@enderror</span>
                            </div>
                        </div>
                        <div class="form-group" style="margin-top: 5px;">
                                <label for="image1" class="d-block mb-0">Choose Image </label>
                                <input type="file" class="form-control-file" id="imageGas" name="imageGas">
                                <span class="text-danger">@error('imageGas'){{$message}}@enderror</span>
                            </div>

                        
                        @endif
                        @if($tak->task_type=='get_end_gas')

                        <div class="col-sm-6 col-12">
                            <div class="mb-2">
                                <label class="form-label" for="gaslevel">End Gas Level</label>
                                <input type="number" id="gaslevel" class="form-control" placeholder="Gas Level" name="endgas" />
                                <span class="text-danger">@error('endgas'){{$message}}@enderror</span>
                            </div>
                        </div>
                        @endif
                        
                        @if($tak->task_type=='ready_vehicle'|| $tak->task_type=='normal')
                        </div>
                        <button type="submit" class="btn btn-primary mt-1" >Complete</button>
                        
                    @else
                   
                    </div>
                    <button type="submit" class="btn btn-primary mt-1" >Upload Data</button>
                    @endif
                    
                </form>

                
                </div>
                
                

            </div>
        </div>
    </div>
    <!--/ User Timeline Card -->
</div>
@endforeach
@endif
<!-- Edit User Modal -->

{{-- upload task --}}

@if ($uploadTask->isEmpty())
   
@else

@foreach($uploadTask as $up)
<div style="margin-bottom: 5px;">
    <!-- User Timeline Card -->
    <div class="col-lg-12">
        <div class="card card-user-timeline">
            <div class="row">
                <div class="card-body col-lg-6">
                    <div class="mb-2 gap-4">
                        <h4 class="">Task Number: <span id="taskNumber">{{$up->id}}</span></h4>
                        <h5 class="">vehicle Number: <span id="taskNumber" style="color: yellow;">{{$up->vehicle_number}}</span></h5>
                        
                      
                        
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="d-flex flex-row">
                            <div class="user-info">
                                <h5 class="mb-0">To, {{$up->name}}</h5>
                                <small class="text-muted">Uploaded on {{$up->date}} at </small>
                            </div>
                        </div>
                    </div>
                    <p class="card-text mb-2">
                        {{$up->task_desc}}
                    </p>
                </div>
                <input type="hidden" name="section_id" value="{{$up->id}}">
               
                
                <div class="card-body col-lg-5" style="border-left: px solid black;">
                
                <form action="{{ route('upload_images') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <!-- Add a hidden input to store the section ID -->
                    <input type="hidden" name="task_id" value="{{$up->id}}">
                    <input type="hidden" name="task_type" value="{{$up->task_type}}">
                    <input type="hidden" name="section_id" value="{{$up->inv}}">
                    <div class="row">
                        <div class="mb-0">
                           
                        </div>
                        
                        @if($up->task_type=='upload_images')
                        <div class="col-12" style="max-height: 150px; overflow-y: auto;">
                            <div class="form-group">
                                <label for="image1" class="d-block mb-0">Choose Image 01</label>
                                <input type="file" class="form-control-file" id="image1" name="image1">
                                <span class="text-danger">@error('image1'){{$message}}@enderror</span>
                            </div>
                            <div class="form-group">
                                <label for="image2" class="d-block mb-0">Choose Image 02</label>
                                <input type="file" class="form-control-file" id="image2" name="image2">
                                <span class="text-danger">@error('image2'){{$message}}@enderror</span>
                            </div>
                            <div class="form-group">
                                <label for="image3" class="d-block mb-0">Choose Image 03</label>
                                <input type="file" class="form-control-file" id="image3" name="image3">
                                <span class="text-danger">@error('image3'){{$message}}@enderror</span>
                            </div>
                            <!-- Additional groups -->
                            <div class="form-group">
                                <label for="image4" class="d-block mb-0">Choose Image 04</label>
                                <input type="file" class="form-control-file" id="image4" name="image4">
                                <span class="text-danger">@error('image4'){{$message}}@enderror</span>
                            </div>
                            <!-- Add more groups up to 15 -->
                            <div class="form-group">
                                <label for="image5" class="d-block mb-0">Choose Image 05</label>
                                <input type="file" class="form-control-file" id="image5" name="image5">
                                <span class="text-danger">@error('image5'){{$message}}@enderror</span>
                            </div>
                            <!-- Add more groups up to 15 -->
                            <div class="form-group">
                                <label for="image6" class="d-block mb-0">Choose Image 06</label>
                                <input type="file" class="form-control-file" id="image6" name="image6">
                                <span class="text-danger">@error('image6'){{$message}}@enderror</span>
                            </div>
                            <!-- Add more groups up to 15 -->
                            <div class="form-group">
                                <label for="image7" class="d-block mb-0">Choose Image 07</label>
                                <input type="file" class="form-control-file" id="image7" name="image7">
                                <span class="text-danger">@error('image7'){{$message}}@enderror</span>
                            </div>
                            <!-- Add more groups up to 15 -->
                            <div class="form-group">
                                <label for="image8" class="d-block mb-0">Choose Image 08</label>
                                <input type="file" class="form-control-file" id="image8" name="image8">
                                <span class="text-danger">@error('image8'){{$message}}@enderror</span>
                            </div>
                            <!-- Add more groups up to 15 -->
                            <div class="form-group">
                                <label for="image9" class="d-block mb-0">Choose Image 09</label>
                                <input type="file" class="form-control-file" id="image9" name="image9">
                                <span class="text-danger">@error('image9'){{$message}}@enderror</span>
                            </div>
                            <!-- Add more groups up to 15 -->
                            <div class="form-group">
                                <label for="image10" class="d-block mb-0">Choose Image 10</label>
                                <input type="file" class="form-control-file" id="image10" name="image10">
                                <span class="text-danger">@error('image10'){{$message}}@enderror</span>
                            </div>
                            <!-- Add more groups up to 15 -->
                            <div class="form-group">
                                <label for="image11" class="d-block mb-0">Choose Image 11</label>
                                <input type="file" class="form-control-file" id="image11" name="image11">
                                <span class="text-danger">@error('image11'){{$message}}@enderror</span>
                            </div>
                            <!-- Add more groups up to 15 -->
                            <div class="form-group">
                                <label for="image12" class="d-block mb-0">Choose Image 12</label>
                                <input type="file" class="form-control-file" id="image12" name="image12">
                                <span class="text-danger">@error('image12'){{$message}}@enderror</span>
                            </div>
                            <!-- Add more groups up to 15 -->
                            <div class="form-group">
                                <label for="image13" class="d-block mb-0">Choose Image 13</label>
                                <input type="file" class="form-control-file" id="image13" name="image13">
                                <span class="text-danger">@error('image13'){{$message}}@enderror</span>
                            </div>
                            <!-- Add more groups up to 15 -->
                            <div class="form-group">
                                <label for="image14" class="d-block mb-0">Choose Image 14</label>
                                <input type="file" class="form-control-file" id="image14" name="image14">
                                <span class="text-danger">@error('image14'){{$message}}@enderror</span>
                            </div>
                            <!-- Add more groups up to 15 -->
                            <div class="form-group">
                                <label for="image15" class="d-block mb-0">Choose Image 15</label>
                                <input type="file" class="form-control-file" id="image15" name="image15">
                                <span class="text-danger">@error('image15'){{$message}}@enderror</span>
                            </div>
                        </div>
                        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
                        <script>
                              document.addEventListener('DOMContentLoaded', function() {
                                  // Loop through each file input
                                  for (let i = 1; i <= 15; i++) {
                                      let inputElement = document.getElementById(`image${i}`);
                                      if (inputElement) {
                                          inputElement.addEventListener('change', function(event) {
                                              handleFileSelect(event, inputElement);
                                          });
                                      }
                                  }
                              });

                              function handleFileSelect(event, inputElement) {
                                  const file = event.target.files[0];
                                  if (!file) return;

                                  const reader = new FileReader();
                                  reader.readAsDataURL(file);
                                  reader.onload = function(e) {
                                      const img = new Image();
                                      img.src = e.target.result;
                                      img.onload = function() {
                                          const canvas = document.createElement('canvas');
                                          const maxSize = 1000; // Specify the maximum size for the image
                                          let width = img.width;
                                          let height = img.height;

                                          if (width > height) {
                                              if (width > maxSize) {
                                                  height = Math.round((height *= maxSize / width));
                                                  width = maxSize;
                                              }
                                          } else {
                                              if (height > maxSize) {
                                                  width = Math.round((width *= maxSize / height));
                                                  height = maxSize;
                                              }
                                          }

                                          canvas.width = width;
                                          canvas.height = height;
                                          const ctx = canvas.getContext('2d');
                                          ctx.drawImage(img, 0, 0, width, height);

                                          canvas.toBlob(function(blob) {
                                              const resizedFile = new File([blob], file.name, {
                                                  type: file.type,
                                                  lastModified: Date.now()
                                              });

                                              // Create a new FileList object
                                              const dataTransfer = new DataTransfer();
                                              dataTransfer.items.add(resizedFile);
                                              inputElement.files = dataTransfer.files;
                                          }, file.type, 0.8); // Adjust the quality as needed
                                      }
                                  };
                              }
                            </script>

                        @endif
                        
                   
                    </div>
                    <button type="submit" class="btn btn-primary mt-1" >Upload Data</button>
                    
                    
                </form>

                
                </div>
                
                

            </div>
        </div>
    </div>
    <!--/ User Timeline Card -->
</div>
@endforeach
@endif




















{{-- service task show here --}}
@if ($staksData->isEmpty())
     <div class="alert alert-info" role="alert">
        You have No sub tasks from vehicle maintains.
    </div>
@else
@foreach ($staksData as $staks)

{{-- start --}}
<div style="margin-bottom: 5px;">
    <!-- User Timeline Card -->
    <div class="col-lg-12">
        <div class="card card-user-timeline">
            <div class="row">
                <div class="card-body col-lg-6">
                    <div class="mb-2 d-flex gap-4">
                        <h4 class="">Task Number(Service): <span id="taskNumber">{{$staks->id}}</span></h4>
                    </div>


                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="d-flex flex-row">
                            <div class="user-info">
                                <h5 class="mb-0">To, {{$staks->emp_name}}</h5>
                                <small class="text-muted">Uploaded on {{$staks->date}} at </small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4 col-12">
                        <div class="mb-1">
                            <label for="lname" class="form-label">Vehicle Name</label>
                            <input
                              type="text"
                              class="form-control"
                              id="lname"
                              name="vname"
                              value="{{$staks->vname}}"
                              readonly
                              placeholder=""
                            />
                            <span class="text-danger"></span>
                        </div>
                    </div>

                    <div class="col-md-4 col-12">
                        <div class="mb-1">
                            <label for="lname" class="form-label">Vehicle Number</label>
                            <input
                              type="text"
                              class="form-control"
                              id="lname"
                              name=""
                              value="{{$staks->vnumber}}"
                              placeholder=""
                              readonly
                            />
                        </div>
                    </div>

                    <div class="col-md-4 col-12">
                        <div class="mb-1">
                            <label for="lname" class="form-label">Date</label>
                            <input
                            readonly
                              type="text"
                              class="form-control"
                              id="lname"
                              name=""
                              value="{{$staks->date}}"
                              placeholder=""
                            />
                        </div>
                    </div>

@foreach ($staks->svalues as $index => $svalue)
    @if($svalue->type=='SERVICE')
    <form action="{{route('set_submit_service')}}" method="post">
        @csrf
        <input type="hidden" name="tid" value="{{ $svalue->id }}">
        <input type="hidden" name="mtid" value="{{ $staks->id }}">
        <div class="col-md-4 col-12">
            <div class="mb-1">
                <label for="lname" class="form-label">Cost</label>
                <input
                  type="text"
                  class="form-control"
                  id="lname"
                  name="cost"
                  value=""
                  placeholder="Rs: 0000.00"
                />
            </div>
            <span class="text-danger">@error('cost'){{$message}}@enderror</span>
        </div>

        <div class="col-md-4 mb-1 mt-2 md-2 ">
            <textarea
                class="form-control"
                id="exampleFormControlTextarea1"
                rows="3"
                name="desc"
                placeholder="Description"
            ></textarea>
            <span class="text-danger">@error('desc'){{$message}}@enderror</span>
        </div>
        <button type="submit" class="btn btn-primary mt-1" style="padding: 5px;">To Set</button>
    </form>
    @else
    {{-- Loop through svalues --}}
  
        {{-- Check if it's the first svalue of a new type --}}
        @if ($index === 0 || $svalue->type !== $staks->svalues[$index - 1]->type)
    {{-- Display the submit button for the type --}}
    <form action="{{ route('set_submit') }}" method="post" onsubmit="return confirm('Are you sure you want to perform this action?');">
        @csrf
        
        <div class="mt-3 position-static">
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton{{ $index }}" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                {{ $svalue->type }}
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $index }}" style="max-height: 200px;overflow: auto;">
                {{-- Display options for the current type --}}
                @foreach ($staks->svalues->where('type', $svalue->type) as $subValue)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="checkbox_{{ $subValue->id }}" name="checkboxes[{{ $svalue->type }}][]" value="{{ $subValue->id }}">
                        <label class="form-check-label" for="checkbox_{{ $subValue->id }}">{{ $subValue->checked_value }}</label>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
        {{-- Hidden input for svalue id --}}
        <input type="hidden" name="tid" value="{{ $svalue->id }}">
        {{-- Submit button --}}
        <button type="submit" class="btn btn-success" style="margin-top: 5px;">Submit Here</button>
    </form>
@endif

    
@endif

    
@endforeach
@if ($staks->svalues->where('status', 'uncomplete')->isEmpty())
    <!-- Show message when there are no uncompleted tasks -->
    <p>No uncompleted checkups found. Please complete the task with below button</p>
    <form action="{{ route('set_submit_task') }}" method="post" id="checkboxForm{{$staks->id}}">
    @csrf
    <input type="hidden" name="idtask" value="{{ $staks->id }}">
    <div class="col-12">
        <div class="d-flex align-items-center mt-1">
            <div class="form-check form-switch form-check-primary">
                <input type="checkbox" class="form-check-input" id="customSwitch{{$staks->id}}" onchange="submitHere('{{$staks->id}}')" />
                <label class="form-check-label" for="customSwitch{{$staks->id}}">
                    <span class="switch-icon-left"><i data-feather="check"></i></span>
                    <span class="switch-icon-right"><i data-feather="x"></i></span>
                </label>
            </div>
        </div>
    </div>
</form>
@endif


                
          
            </div>
        </div>
    </div>
    
</div>

{{-- end --}}
@endforeach
@endif


@endsection
@section('script')

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
    function submitForm() {
        var formData = new FormData(document.getElementById('submitForm')); // Get form data
        $.ajax({
            url: '{{ route("set_submit") }}',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                // Handle success response
                alert(response.message); // Show a message with the response
                // Optionally, you can update UI or show a message here
            },
            error: function(xhr, status, error) {
                // Handle error
                console.error(error);
                // Optionally, you can show an error message here
            }
        });
    }
</script>

{{-- <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
  $('#getImages').on('click', function() {
    $('#carousel-wrap .carousel-inner').empty(); // Clear existing carousel items

    @foreach(explode(',', $tak->imageUrl) as $index => $imageUrl)
      $('#carousel-wrap .carousel-inner').append(`
        <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
          <img class="img-fluid" src="{{ asset('storage/' . $imageUrl) }}" alt="Slide {{ $index + 1 }}" style="width:100%;height:auto;">
        </div>
      `);
    @endforeach
  });
</script> --}}
<!-- JavaScript code -->
<!-- JavaScript code -->
<!-- JavaScript code -->
<!-- JavaScript code -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const uploadButtons = document.querySelectorAll(".upload-here");

        uploadButtons.forEach(function (button) {
            button.addEventListener("click", function () {
                // Get the invoice number associated with the button
                const invoiceNumber = this.getAttribute("data-task-id");
                
                // Log the invoice number
                console.log("Invoice Number:", invoiceNumber);

                // Set the invoice number into the input field with id 'inv'
                document.getElementById("invr").value = invoiceNumber;

                // Other logic related to the button click
            });
        });
    });
</script>


<script>
    function submitHere(staksId) {
        document.getElementById('checkboxForm' + staksId).submit();
    }
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
        $(document).ready(function() {
            const loader = $("#loader");

            $("form").on("submit", function() {
                loader.show(); // Show the loader
                // Allow the form to be submitted normally
            });
        });
    </script>

@endsection
