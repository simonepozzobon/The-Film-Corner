@extends('layouts.main')
@section('title', 'timeline test')
@section('content')
  <div id="timeline" class="container">
    <div class="row">
      <div class="col-md-8">
        <video-preview></video-preview>
      </div>
      <div class="col-md-4">
        Library
      </div>
    </div>
    <timeline></timeline>
  </div>
@endsection
@section('scripts')
  <script src="{{ mix('js/timeline.js') }}"></script>
@endsection
