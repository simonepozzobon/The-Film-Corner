@extends('layouts.admin')

@section('title', 'Panel')

@section('page-title', 'Admin Panel')

@section('content')
      <div class="clearfix">
        <p class="mt-4">Welcome to the admin panel of The Film Corner Project</p>
        <div class="row mt-4">
          <div class="col">
            <div class="card">
              <h3 class="card-header">Start Creating A New Post</h3>
              <div class="card-block">
                <div class="card-text">
                  <a href="{{ url('admin/posts/create') }}" class="btn btn-block btn-info">Create New Post</a>
                </div>
              </div>
            </div>

          </div>
          <div class="col">
            <div class="card">
              <h3 class="card-header">Start Uploading A New Image</h3>
              <div class="card-block">
                <div class="card-text">
                  <a href="{{ url('admin/media') }}" class="btn btn-block btn-info">Upload New Image</a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row mt-4">
          <div class="col">
            <div class="card">
              <h3 class="card-header">Start Creating A New User</h3>
              <div class="card-block">
                <div class="card-text">
                  <a href="{{ url('admin/users') }}" class="btn btn-block btn-info">Create A New User</a>
                </div>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="card">
              <h3 class="card-header">Start Creating A New Category</h3>
              <div class="card-block">
                <div class="card-text">
                  <a href="{{ url('admin/categories') }}" class="btn btn-block btn-info">Create A New Category</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
@endsection
