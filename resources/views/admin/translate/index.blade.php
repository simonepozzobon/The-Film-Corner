@extends('layouts.admin')
@section('title', 'Translate')
@section('content')
  <div id="app" class="container">
      <translate-panel/>
  </div>
@endsection
@section('scripts')
  <script src="{{ mix('js/admin/translate.js') }}"></script>
@endsection
