@extends('layouts.conference', ['active' => 'speakers'])
@section('title')
  The Film Corner - International Conference
@endsection
@section('stylesheets')
  <link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endsection
@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-10 offset-md-1">
        <div class="block-subtitle mt-5">
          <h4>Schedule Draft</h4>
        </div>
      </div>
    </div>
  </div>
@endsection
