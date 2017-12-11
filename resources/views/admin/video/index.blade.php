@extends('layouts.admin')
@section('title', 'Video')
@section('content')
<div id="app" class="container">
  <div class="row">
    <div class="col">
      <div class="box blue">
        <div class="box-header">
          <h3>Nuovo Video</h3>
        </div>
        <div class="box-body">
          <video-form-upload
            action=""
            method="POST"
            token="{{ csrf_token() }}"
            options="{{ $categories }}"
            sections="{{ $sections }}"
            app_categories="{{ $app_categories }}"
            apps="{{ $apps }}"
          />
        </div>
      </div>
      <div class="box orange mt">
        <div class="box-header">
          <h3>Video Caricati</h3>
        </div>
        <div class="box-body">
          <video-crud
            items="{{ $videos }}"
            token="{{ csrf_token() }}"
          />
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('scripts')
  <script src="{{ mix('js/admin/video.js') }}"></script>
@endsection
