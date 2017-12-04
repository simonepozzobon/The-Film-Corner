@extends('layouts.teacher')
@section('title', 'Profile')
@section('content')
  <div id="main" class="container">
    @include('components.apps.heading_simple', ['title' => 'Profile'])
    <teacher-profile
      students="{{ $students }}"
      notifications="{{ $notifications }}"
      user="{{ Auth::guard('teacher')->user() }}"
      user_type="{{ get_class(Auth::guard('teacher')->user()) }}"
    />
  </div>
@endsection
@section('scripts')
  <script src="{{ mix('js/teacher-profile.js') }}"></script>
@endsection
