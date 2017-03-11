@extends('layouts.admin')
@section('title')
 Edit Teacher - {{ $teacher->name }}
@endsection
@section('page-title', "$teacher->name")
@section('stylesheets')
  <script src="//cloud.tinymce.com/stable/tinymce.min.js?apiKey=qecr5wd0wdcbodk88lbyo28f9rwd2zpg9kqvq6cgle2fkal7"></script>
  <script type="text/javascript">
    tinymce.init({
      selector: 'textarea.content',
      plugins: 'link lists',
      menubar: false,
    });
  </script>
  <link rel="stylesheet" href="{{ asset('admin-assets/css/select2.min.css') }}">
@endsection
@section('content')
  <div class="clearfix">
    <form action="/admin/teachers/{{ $teacher->id }}" method="post" enctype="multipart/form-data">
      {{ csrf_field() }}
      {{ method_field('PUT') }}
      <div class="row">
        <div class="col-md-8">
          <div class="card">
            <h3 class="card-header">Teacher Informations</h3>
            <div class="card-block">
              <div class="card-text">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      @if ($teacher->profile_img)
                        <img class="img-circle mx-auto d-block" src="{{ Storage::disk('local')->url($teacher->profile_img) }}" alt="Teacher - {{ $teacher->name }}" width="230">
                      @else
                        <img class="mx-auto d-block" src="{{ url('/') }}/img/helpers/null-image.png" width="230">
                      @endif
                    </div>
                    <div class="form-group mt-4">
                      <label for="media">Change Profile Picture</label>
                      <input type="file" name="media" class="form-control"></input>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="name">Name</label>
                      <input type="text" name="name" value="{{ $teacher->name }}" class="form-control">
                    </div>
                    <div class="form-group">
                      <label for="email">Email</label>
                      <input type="email" name="email" value="{{ $teacher->email }}" class="form-control">
                    </div>
                    <div class="form-group">
                      <label for="password">Password</label>
                      <input type="password" name="password" value="{{ $teacher->password }}" class="form-control">
                    </div>
                    <div class="form-group">
                      <label for="school_id">School:</label>
                      @if ($schools)
                        <select class="form-control" name="school_id">
                          @foreach ($schools as $school)
                            <option value="{{ $school->id }}">{{ $school->name }} - {{ $school->city }} - {{ $school->country }}</option>
                          @endforeach
                        </select>
                      @else
                        You need to create a School first!!
                      @endif
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card">
            <h3 class="card-header">Account Details</h3>
            <div class="card-block">
              <div class="card-text">
                <table class="table">
                  <thead><th>Created At:</th></thead>
                  <tbody><td>{{ $teacher->created_at }}</td></tbody>
                </table>
                <table class="table">
                  <thead><th>Updated At:</th></thead>
                  <tbody><td>{{ $teacher->updated_at }}</td></tbody>
                </table>
                <hr>
                <button type="submit" name="button" class="btn btn-small btn-block btn-primary mt-3">Save</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
@endsection
