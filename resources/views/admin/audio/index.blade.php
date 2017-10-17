@extends('layouts.admin')
@section('title', 'Audio')
@section('content')
<div id="app">
  <div class="row">
    <div class="col">
      <div class="box container-fluid mb-4">
        <div class="row">
          <div class="col dark-blue py-3 px-5">
            <h3>Nuovo Audio</h3>
          </div>
        </div>
        <div class="row">
          <div class="col blue p-5">
            <audio-form-upload
                action=""
                method="POST"
                token="{{ csrf_token() }}"
                options="{{ $categories }}"
                sections="{{ $sections }}"
                app_categories="{{ $app_categories }}"
                apps="{{ $apps }}"
              >
            </audio-form-upload>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col">
      <div class="box container-fluid mb-4">
        <div class="row">
          <div class="col dark-orange py-3 px-5">
            <h3>Audio Caricati</h3>
          </div>
        </div>
        <div class="row">
          <div class="col orange p-5">
            <audio-crud items="{{ $audios }}" token="{{ csrf_token() }}"></audio-crud>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('scripts')
  <script src="{{ mix('js/admin/audio.js') }}"></script>
@endsection
