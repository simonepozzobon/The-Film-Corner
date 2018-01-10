@extends('layouts.guest', ['type' => 'app'])
@section('title', $app->title)
@section('stylesheets')
  <link href="http://vjs.zencdn.net/5.8.8/video-js.css" rel="stylesheet">
@endsection
@section('content')
  <div class="container-fluid">
    @include('components.apps.heading_info', ['app' => $app, 'type' => 'guest', 'student' => $is_student])
    <div id="app">
      <div class="row mt">
        <div class="col-md-6">
          <div class="box blue">
            <div class="box-header">
              First Image
            </div>
            <div class="box-body">
              <img id="img-left" src="{{ $session->images[0] }}" alt="" class="img-fluid">
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="box yellow">
            <div class="box-header">
              Second Image
            </div>
            <div class="box-body">
              <img id="img-right" src="{{ $session->images[1] }}" alt="" class="img-fluid">
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row mt">
      <div class="col">
        <div class="box orange">
          <div class="box-btns pt">
            <button id="reload" type="button" name="button" class="btn btn-secondary btn-orange">
              <i class="fa fa-refresh" aria-hidden="true"></i> Change images
            </button>
          </div>
        </div>
      </div>
    </div>
    <div class="row mt">
      <div class="col">
        <div class="box green">
          <div class="box-header">
            Notes
          </div>
          <div class="box-body">
            <textarea id="notes" name="notes" rows="8" class="form-control" placeholder="What are the differences between two pictures?">{{ $session->notes }}</textarea>
          </div>
        </div>
      </div>
    </div>
  </div>
  @if ($is_student)
    @include('components.apps.chat', ['app_session' => $app_session])
  @endif
@endsection
@section('scripts')
  <script src="{{ mix('js/guest-chat.js') }}"></script>

  <script type="text/javascript">
    var AppSession = new TfcSessions();

    var string = '{{ $library }}',
        images = JSON.parse(string.replace(/&quot;/g,'"'));
        lenght = Object.keys(images).length;
        console.log(lenght);

    $('#reload').on('click', function() {
      // Reload Pictures
      var left_id = Math.floor(Math.random() * lenght),
          right_id = Math.floor(Math.random() * lenght);

      while (left_id == right_id) {
        right_id = Math.floor(Math.random() * lenght);
      }

      $('#img-left').attr('src', images[left_id]);
      $('#img-right').attr('src', images[right_id]);
    });
  </script>
@endsection