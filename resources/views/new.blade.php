@extends('layouts.main')
@section('title')
    The Film Corner
@endsection
@section('stylesheets')
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endsection
@section('content')
    <main id="home">
        <main-template></main-template>
    </main>
@endsection
@section('scripts')
    <script src="{{ mix('js/home.js') }}"></script>
@endsection
