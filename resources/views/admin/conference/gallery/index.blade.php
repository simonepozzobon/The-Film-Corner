@extends('layouts.admin')
@section('title', 'Conference Gallery')
@section('content')
  <div class="container">
    <form class="" action="{{ route('admin.conference.gallery.store') }}" method="post" enctype="multipart/form-data">
      <div class="box green">
          {{ csrf_field() }}
          {{ method_field('POST') }}
          <div class="box-header">
            Add image to the gallery
          </div>
          <div class="box-body">
            <div class="form-group">
              <input id="media" type="file" class="form-control" name="media">
            </div>
          </div>
          <div class="box-btns">
            <button type="submit" name="button" class="btn btn-green"><i class="fa fa-plus"></i> Add</button>
          </div>
      </div>
    </form>
    <div class="box orange mt">
      <div class="box-header">
        Gallery
      </div>
      <div class="box-body">
        <div class="row">
          @foreach ($images as $key => $img)
            <div class="col-md-4">
              <img class="img-fluid" src="{{ Storage::disk('local')->url($img->thumb) }}">
            </div>
          @endforeach
        </div>
      </div>
      <div class="box-btns">
        {{-- btns --}}
      </div>
    </div>
  </div>
@endsection
