@extends('layouts.teacher')
@section('title', 'Profile')
@section('content')
  <div id="main" class="container">
    @php
      $profile = GeneralText::field('profile');
      $translation = [
        'activities' => GeneralText::field('activities'),
        'network' => GeneralText::field('network'),
        'students' => GeneralText::field('students'),
      ];
      $translation = json_encode($translation);
    @endphp
    @include('components.apps.heading_simple', ['title' => $profile])
    <teacher-profile
      students="{{ $students }}"
      notifications="{{ $sessions }}"
      user="{{ Auth::guard('teacher')->user() }}"
      user_type="{{ get_class(Auth::guard('teacher')->user()) }}"
      shared_sessions="{{ $shared_sessions }}"
      translation="{{ $translation }}"
    />
  </div>
@endsection
@section('scripts')
  <script src="{{ mix('js/teacher-profile.js') }}"></script>
@endsection
