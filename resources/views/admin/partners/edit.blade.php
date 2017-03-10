@extends('layouts.admin')
@section('title')
 Edit Partner - {{ $partner->name }}
@endsection
@section('page-title', "$partner->name (edit)")
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
    <form action="/admin/partners/{{ $partner->id }}" method="post" enctype="multipart/form-data">
      {{ csrf_field() }}
      {{ method_field('PUT') }}
      <div class="row">
        <div class="col-md-8">
          <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" value="{{ $partner->name }}" class="form-control">
          </div>
          <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" rows="16" class="content form-control">{{ $partner->description }}</textarea>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label for="location">Location</label>
            <input type="text" name="location" value="{{ $partner->location }}" class="form-control">
          </div>
          <div class="form-group">
            <label for="id_tag">ID tag HTML</label>
            <input type="text" name="id_tag" value="{{ $partner->id_tag }}" class="form-control">
          </div>
          <div class="form-group">
            <label for="url">Url</label>
            <input type="text" name="url" value="{{ $partner->url }}" class="form-control">
          </div>
          <div class="form-group">
            <label for="">Actual Image</label>
            <img width="200" class="mx-auto form-control" src="{{ Storage::disk('local')->url($partner->logo_url) }}">
          </div>
          <div class="form-group">
            <label for="media">Change Logo</label>
            <input type="file" name="media" class="form-control"></input>
          </div>
          <hr>
          <button type="submit" name="button" class="btn btn-small btn-block btn-primary mt-3">Save</button>
        </div>
      </div>
    </form>
  </div>
@endsection
