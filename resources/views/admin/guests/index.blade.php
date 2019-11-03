@extends('layouts.admin')
@section('title', 'Teachers')
@section('content')
  <div id="guests" class="container">
    <guests />
  </div>
@endsection
@section('scripts')
  <script src="{{ mix('js/admin/guests.js') }}"></script>
@endsection
