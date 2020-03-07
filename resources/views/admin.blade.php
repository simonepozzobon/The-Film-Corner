@extends('layouts.admin')
@section('title')
    Admin Panel
@endsection
@section('stylesheets')
@endsection
@section('content')
    <div id="admin">
        <admin-template></admin-template>
    </div>
    <div id="bus"></div>
@endsection
@section('scripts')
    <script src="{{ asset('backend/js/admin.js') }}"></script>
@endsection
