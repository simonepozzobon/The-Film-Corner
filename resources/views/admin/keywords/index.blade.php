@extends('layouts.admin')
@section('title', 'title')
@section('content')
  <div id="app" class="container">
    <keywords-list words="{{ $words }}" categories="{{ $categories }}"></keywords-list>
  </div>
@endsection
@section('scripts')
  <script src="{{ mix('js/admin/keywords.js') }}"></script>
@endsection
