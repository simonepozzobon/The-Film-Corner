@extends('layouts.conference')
@section('title')
  The Film Corner - International Conference
@endsection
@section('stylesheets')
  <link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endsection
@section('content')
  <div class="block-subtitle mt-5">
    <h4>Apply</h4>
  </div>
  <div class="block-text">
    <p class="text-justify">
      <form class="" action="" method="">
        {{ csrf_field() }}
        {{ method_field('POST') }}
        <div class="form-group">
          <label for="">Name:</label>
          <input type="text" name="name" class="form-control">
        </div>
        <div class="form-group">
          <label for="">Surname:</label>
          <input type="text" name="name" class="form-control">
        </div>
        <div class="form-group">
          <label for="">Institution:</label>
          <input type="text" name="name" class="form-control">
        </div>
        <div class="form-group">
          <label for="">Role:</label>
          <input type="text" name="name" class="form-control">
        </div>
        <div class="form-group">
          <label for="">E-mail:</label>
          <input type="text" name="name" class="form-control">
        </div>
        <div class="form-group">
          <label for="">Notes:</label>
          <input type="text" name="name" class="form-control">
        </div>
      </form>
    </p>
  </div>  
@endsection
