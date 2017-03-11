@extends('layouts.admin')
@section('title', 'Frame Painter')
@section('page-title', 'Frame Painter')
@section('stylesheets')
  <script src="//cloud.tinymce.com/stable/tinymce.min.js?apiKey=qecr5wd0wdcbodk88lbyo28f9rwd2zpg9kqvq6cgle2fkal7"></script>
  <script type="text/javascript">
    tinymce.init({
      selector: 'textarea.content',
      plugins: 'link',
      menubar: false,

    });
  </script>
@endsection
@section('content')
  <div class="clearfix">
    <div class="row">
      <div class="col-md-8">
        <table class="table table-hover">
          <thead>
            <th>Id</th>
            <th>Frame</th>
            <th>Name</th>
            <th>Description</th>
            <th>View</th>
          </thead>
          <tbody>
            @foreach ($frames as $frame)
              <tr>
                <td class="align-middle">{{ $frame->id }}</td>
                <td class="align-middle"><img src="{{ Storage::disk('local')->url($frame->frame) }}" alt="{{ $frame->name }}" width="57"></td>
                <td class="align-middle">{{ $frame->name }}</td>
                <td class="align-middle">{{ substr(strip_tags($frame->description), 0, 50) }}{{ strlen(strip_tags($frame->description)) > 50 ? '...' : "" }}</td>
                <td class="align-middle"><a href="{{ route('app_1.show', $frame->id) }}" class="btn btn-info">View</a></td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="col-md-4">
        <div class="card">
          <h3 class="card-header">Add New Frame</h3>
          <div class="card-block">
            <div class="card-text">
              <form class="" action="{{ route('app_1.store') }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                {{ method_field('POST') }}
                <div class="form-group">
                  <label for="frame">Frame Image</label>
                  <input type="file" name="frame" class="form-control">
                </div>
                <div class="form-group">
                  <label for="name">Name:</label>
                  <input type="text" name="name" value="{{ old('name') }}" class="form-control" placeholder="Name of the frame">
                </div>
                <div class="form-group">
                  <label for="description">Description</label>
                  <textarea name="description" rows="8" class="form-control content"></textarea>
                </div>
                <hr>
                <button type="submit" name="button" class="btn btn-primary btn-block">Add New Frame</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
