@extends('layouts.student', ['type' => 'app'])
@section('title', $app->title)
@section('stylesheets')
  <link href="http://vjs.zencdn.net/5.8.8/video-js.css" rel="stylesheet">
@endsection
@section('content')
  <div class="container-fluid">
    @include('components.apps.heading_info', ['app' => $app, 'type' => 'student'])
    <div id="app">
      <div class="row mt">
        <div class="col-md-6">
          <div class="box blue">
            <div class="box-header">
              {{ GeneralText::field('first_image') }}
            </div>
            <div class="box-body">
              <img id="img-left" src="{{ $left }}" alt="" class="img-fluid">
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="box yellow">
            <div class="box-header">
              {{ GeneralText::field('second_image') }}
            </div>
            <div class="box-body">
              <img id="img-right" src="{{ $right }}" alt="" class="img-fluid">
            </div>
          </div>
        </div>
      </div>
      <div class="row mt">
        <div class="col">
          <div class="box orange">
            <div class="box-btns pt">
              <button id="reload" type="button" name="button" class="btn btn-secondary btn-orange">
                <i class="fa fa-refresh" aria-hidden="true"></i> {{ GeneralText::field('change_images') }}
              </button>
            </div>
          </div>
        </div>
      </div>
      <div class="row mt">
        <div class="col">
          <div class="box green">
            <div class="box-header">
              {{ GeneralText::field('notes') }}
            </div>
            <div class="box-body">
              <textarea id="notes" name="notes" rows="8" class="form-control" placeholder="{{ GeneralText::field('type_of_images_desc') }}"></textarea>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('scripts')
  <script type="text/javascript">
    var AppSession = new TfcSessions();
    AppSession.initSession({{ $app->id }});

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
