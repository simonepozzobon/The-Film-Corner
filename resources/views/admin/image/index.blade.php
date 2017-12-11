@extends('layouts.admin')
@section('title', 'Images')
@section('content')
<div id="app" class="container">
  <div class="row">
    <div class="col">
      <div class="box blue">
        <div class="box-header">
          <h3>Nuova Immagine</h3>
        </div>
        <div class="box-body">
          <image-form-upload
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
          <h3>Immagini Caricati</h3>
        </div>
        <div class="box-body">
          <image-crud items="{{ $medias }}" token="{{ csrf_token() }}"></image-crud>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('scripts')
  <script src="{{ mix('js/admin/image.js') }}"></script>
@endsection
