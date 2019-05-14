@extends('layouts.guest')
@section('title', 'Profile')
@section('content')
  <div id="main" class="container">
    @php
      $profile = GeneralText::field('profile');
    @endphp
    @include('components.apps.heading_simple', ['title' => $profile])
    <div class="box green mt">
      <div class="box-body">
        Not available for guests!
      </div>
    </div>
  </div>
@endsection
@section('scripts')
  <script src="{{ mix('js/teacher-profile.js') }}"></script>
@endsection
