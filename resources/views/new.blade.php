@extends('layouts.main')
@section('title')
    The Film Corner
@endsection
@section('stylesheets')
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endsection
@section('content')
    <div id="home">
        <main-template></main-template>
    </div>
@endsection
@section('scripts')
    <script src="{{ mix('js/home.js') }}"></script>
@endsection
