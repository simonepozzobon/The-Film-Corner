@extends('layouts.teacher')
@section('title', 'Profile')
@section('content')
  <div id="main" class="container">
    @include('components.apps.heading_simple', ['title' => 'Profile'])
    <teacher-profile students="{{ $students }}" notifications="{{ $notifications }}"/>
  </div>
@endsection
@section('scripts')
  <script src="{{ mix('js/teacher-profile.js') }}"></script>
@endsection
