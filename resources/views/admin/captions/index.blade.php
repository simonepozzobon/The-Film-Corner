@extends('layouts.admin')
@section('title', 'Captions')
@section('content')
    <div id="app" class="container">
        <captions-crud />
    </div>
@endsection
@section('scripts')
    <script src="{{ mix('js/admin/captions.js') }}"></script>
@endsection
