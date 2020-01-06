@extends('layouts.admin')
@section('title', 'Audio')
@section('content')
<div id="app" class="container">
  <div class="row">
    <div class="col">
      <div class="box blue">
        <div class="box-header">
          <h3>Nuovo Audio</h3>
        </div>
        <div class="box-body">
          <audio-form-upload
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
          <h3>Audio Caricati</h3>
        </div>
        <div class="box-body">
          <audio-crud
            items="{{ $audios }}"
            token="{{ csrf_token() }}"
          />
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('scripts')
  <script src="{{ mix('js/admin/audio.js') }}"></script>
@endsection
