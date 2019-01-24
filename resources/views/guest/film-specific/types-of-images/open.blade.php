@extends('layouts.guest', ['type' => 'app'])
@section('title', $app->title)
@section('stylesheets')
  <link href="//vjs.zencdn.net/5.8.8/video-js.css" rel="stylesheet">
@endsection
@section('content')
  <div class="container-fluid">
    @include('components.apps.heading_info', ['app' => $app, 'type' => 'guest', 'student' => $is_student])
    <div id="app">
      <div class="row mt">
        <div class="col-md-6">
          <div class="box blue">
            <div class="box-header">
              {{ GeneralText::field('first_image') }}
            </div>
            <div class="box-body">
              <img id="img-left" src="{{ $session->images[0] }}" alt="" class="img-fluid">
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="box yellow">
            <div class="box-header">
              {{ GeneralText::field('second_image') }}
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
            <textarea id="notes" name="notes" rows="8" class="form-control" placeholder="{{ GeneralText::field('type_of_images_desc') }}">{{ $session->notes }}</textarea>
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

    var string = '',
        images = {!! $media_couples !!};
        lenght = images.length;
        console.log('quante immagini', lenght);

    $('#reload').on('click', function() {
      // Reload Pictures
      var idx = Math.floor(Math.random() * lenght),
          left_id = images[idx].left.id,
          right_id = images[idx].right.id;
          console.log(images[idx].left, images[idx].right)
      $('#img-left').attr('src', images[idx].left.src);
      $('#img-right').attr('src', images[idx].right.src);
    });
  </script>
@endsection
