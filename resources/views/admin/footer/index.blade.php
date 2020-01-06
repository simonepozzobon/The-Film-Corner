@extends('layouts.admin')
@section('title', 'Footer')
@section('content')
  <div id="app">
    <main-panel />
  </div>
@endsection
@section('scripts')
  <script src="{{ mix('js/admin/footer.js') }}"></script>
@endsection
