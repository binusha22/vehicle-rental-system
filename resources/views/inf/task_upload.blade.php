@extends('layouts.lay')
@section('title','Employee task')
@section('style')

@endsection

@section('content')

<!-- Loop through each booking record to display images -->
@foreach($bookings as $booking)
    <div class="row">
        <!-- Debug: Output image URLs -->
        
        <!-- Split the image URLs by comma and loop through them -->
        @foreach(explode(',', $booking->uploadImage_url) as $imageUrl)
            <!-- Debug: Output each image URL -->
            
            <!-- Check if the URL is not empty or not null -->
            @if ($imageUrl)
                <!-- Display each image using an HTML <img> tag -->
                <div class="col-md-6">
                    <img src="{{ asset('storage/' . $imageUrl) }}" alt="Image" class="img-fluid" width="400" height="300" style="margin: 5px;">
                </div>
            @endif
        @endforeach
    </div>
@endforeach





@endsection
