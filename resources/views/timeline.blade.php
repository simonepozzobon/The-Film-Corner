@extends('layouts.main')
@section('title', 'timeline test')
@section('content')
  <div id="timeline" class="py-5">
    <timeline></timeline>
  </div>
@endsection
@section('scripts')
  <script src="{{ mix('js/timeline.js') }}"></script>
@endsection
