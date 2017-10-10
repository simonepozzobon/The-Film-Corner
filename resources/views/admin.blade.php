@extends('layouts.admin')
@section('title', 'Panel')
@section('content')
<div id="app">
  <div class="row">
    <div class="col">
      <div class="box container-fluid mb-4">
        <div class="row">
          <div class="col dark-blue py-3 px-5">
            <h3>Welcome</h3>
          </div>
        </div>
        <div class="row">
          <div class="col blue p-5">
            <video-form-upload diocane="diocat">
            </video-form-upload>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('scripts')
  {{-- <script type="text/javascript">


  </script> --}}
  <script src="{{ mix('js/admin/test.js') }}"></script>
@endsection
