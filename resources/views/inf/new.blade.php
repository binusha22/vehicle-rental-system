@extends('layouts.lay')
@section('title','Employee task')
@section('style')
<style>
    .form-label {
        font-size: 14px; /* Change this value to adjust the font size */
    }
</style>
@endsection

@section('content')
      <form action="{{route('sumbit-test')}}" method="post">
        @csrf
        <div class="col-md-6 mb-1 mt-3">
              <label class="form-label">start</label>
              <input type="text" class="form-control modal-edit-tax-id" id="modalEditTaxID" name="st">
            </div>
            <div class="col-md-6 mb-1 mt-3">
              <label class="form-label">end</label>
              <input type="text" class="form-control modal-edit-tax-id" id="modalEditTaxID" name="ed">
            </div>

            <button type="submit">ok</button>
        </form>
@endsection
@section('script')







@endsection
