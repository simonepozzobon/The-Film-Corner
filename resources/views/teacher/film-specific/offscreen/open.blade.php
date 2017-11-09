@extends('layouts.teacher', ['type' => 'app'])
@section('title', $app->title)
@section('stylesheets')
  <link href="http://vjs.zencdn.net/5.8.8/video-js.css" rel="stylesheet">
  <style media="screen">
    #video-library {
      overflow-y: scroll;
    }
  </style>
@endsection
@section('content')
  <div class="container-fluid">
    @include('components.apps.heading_info', ['app' => $app])
    @include('components.apps.sidebar-menu', ['app' => $app, 'type' => 'teacher', 'student' => $is_student])
    <div id="app">
      <div class="row mt">
        <div class="col-md-8">
          <div class="box blue">
            <div class="box-header">
              Video
            </div>
            <div id="video-player" class="box-body">
              <div class="embed-responsive embed-responsive-16by9">
                <video id="video" class="embed-responsive-item video-js" controls preload="auto" width="640" height="264">
                    <source src="{{ $session->video }}" type="video/mp4">
                </video>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="box yellow">
            <div class="box-header">
              Library
            </div>
            <div id="video-library" class="box-body">
              @foreach ($app->videos()->get() as $key => $video)
                <div class="row">
                  <div class="col-md-2">
                    <img src="{{ Storage::disk('local')->url($video->img) }}" width="57">
                  </div>
                  <div class="col-md-8">
                    <p class="p-2">{{ $video->title }}</p>
                  </div>
                  <div class="col-md-2">
                    <button class="change-video btn btn-secondary btn-yellow" data-video-src="{{ Storage::disk('local')->url($video->src) }}">
                      <i class="fa fa-plus" aria-hidden="true"></i>
                    </button>
                  </div>
                </div>
              @endforeach
            </div>
          </div>
        </div>
      </div>
      <div class="row mt">
        <div class="col">
          <div class="box orange">
            <div class="box-btns pt">
              <div class="btn-group">
                <button id="play" type="button" name="button" class="btn btn-secondary btn-orange">
                  <i class="fa fa-play" aria-hidden="true"></i>
                </button>
                <button id="pause" type="button" name="button" class="btn btn-secondary btn-orange">
                  <i class="fa fa-pause" aria-hidden="true"></i>
                </button>
                <button id="stop" type="button" name="button" class="btn btn-secondary btn-orange">
                  <i class="fa fa-stop" aria-hidden="true"></i>
                </button>
                <button id="rewind" type="button" name="button" class="btn btn-secondary btn-orange">
                  <i class="fa fa-backward" aria-hidden="true"></i>
                </button>
                <button id="forward" type="button" name="button" class="btn btn-secondary btn-orange">
                  <i class="fa fa-forward" aria-hidden="true"></i>
                </button>
              </div>
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
              <textarea id="notes" name="notes" rows="8" class="form-control" placeholder="Describe what is happening outside the screen">{{ $session->notes }}</textarea>
            </div>
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
  <script src="{{ mix('js/teacher-chat.js') }}"></script>
  <script src="{{ asset('plugins/any-resize-event.min.js') }}"></script>
  <script src="{{ asset('plugins/videojs/video.js') }}"></script>

  <script type="text/javascript">
    var AppSession = new TfcSessions();
    // AppSession.initSession({{ $app->id }});

    $(document).ready( libraryResize );
    document.getElementById('video-player').addEventListener('onresize', libraryResize);

    function libraryResize()
    {
        var video_player = document.getElementById('video-player').offsetHeight - 63;
        $('#video-library').height(video_player);
    }

    var player = videojs('video', {
      controlBar: {
        playToggle: false,
        volumeMenuButton: false,
        fullscreenToggle: false,
      }
    });

    player.muted(true);

    player.ready(function() {
      $('.change-video').on('click', function(event) {
        event.preventDefault();
        player.pause();
        player.src($(this).data('video-src'));
        player.load();
      });
    })

    $('#play').on('click', function() {
      player.play();
    });

    $('#pause').on('click', function() {
      player.pause();
    });

    $('#stop').on('click', function() {
      player.pause().currentTime(0);
    });

    $('#rewind').on('click', function() {
      var time = player.currentTime();
      player.currentTime(time-5);
    });

    $('#forward').on('click', function() {
      var time = player.currentTime();
      player.currentTime(time+5);
    });

  </script>
@endsection
