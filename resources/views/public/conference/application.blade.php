@extends('layouts.conference', ['active' => 'application'])
@section('title')
  The Film Corner - International Conference
@endsection
@section('stylesheets')
  <link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endsection
@section('content')
  <div class="block-subtitle mt-5">
    <h4>Online Application</h4>
  </div>
  <div class="block-text">
    <p class="text-justify">
      <form class="" action="" method="">
        {{ csrf_field() }}
        {{ method_field('POST') }}
        <div class="row">
          <div class="form-group col-md-6">
            <div class="row">
              <label class="col-sm-2 col-form-label">Name</label>
              <div class="col-sm-10">
                <input type="text" name="name" class="form-control">
              </div>
            </div>
          </div>
          <div class="form-group col-md-6">
            <div class="row">
              <label class="col-sm-2 col-form-label">Surname</label>
              <div class="col-sm-10">
                <input type="text" name="name" class="form-control">
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="form-group col-md-6">
            <div class="row">
              <label class="col-sm-2 col-form-label">E-mail</label>
              <div class="col-sm-10">
                <input type="text" name="name" class="form-control">
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="form-group col-md-6">
            <div class="row">
              <label class="col-sm-2 col-form-label">Institution</label>
              <div class="col-sm-10">
                <input type="text" name="name" class="form-control">
              </div>
            </div>
          </div>
          <div class="form-group col-md-6">
            <div class="row">
              <label class="col-sm-2 col-form-label">Role</label>
              <div class="col-sm-10">
                <input type="text" name="name" class="form-control">
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="form-group col-md-12">
            <div class="row">
              <label class="col-sm-1 col-form-label">Notes</label>
              <div class="col-sm-11">
                <textarea name="name" rows="8" class="form-control"></textarea>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4 offset-md-4 pt-5">
          <button type="submit" name="button" class="btn btn-primary btn-block">
            <i class="fa fa-check" aria-hidden="true"></i> Apply
          </button>
        </div>
      </form>
    </p>
  </div>
@endsection
