@extends('layouts.guest')
@section('title', 'Profile')
@section('content')
  <div id="main" class="container">
    @include('components.apps.heading_simple', ['title' => 'Profile'])
    <div class="box green">
      <div class="box-body">
        Not available for guest user!
      </div>
    </div>
  </div>
@endsection
@section('scripts')
  <script src="{{ mix('js/teacher-profile.js') }}"></script>
@endsection
