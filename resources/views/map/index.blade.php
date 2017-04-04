@extends('layouts.main')
@section('title', 'Spot Map')
@section('stylesheets')
  <link rel="stylesheet" href="{{ asset('css/maps/style.css') }}">
@endsection
@section('content')
  <div class="map-wrapper">
    {!! $map !!}
  </div>
@endsection
