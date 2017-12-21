@extends('layouts.admin')
@section('title', 'Teachers')
@section('content')
  <div id="teachers" class="container">
    <teachers />
  </div>
@endsection
@section('scripts')
  <script src="{{ mix('js/admin/teachers.js') }}"></script>
@endsection
