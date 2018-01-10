@extends('layouts.guest', ['type' => 'app'])
@section('title', $app->title)
@section('stylesheets')
  <link href="http://vjs.zencdn.net/5.8.8/video-js.css" rel="stylesheet">
@endsection
@section('content')
  <div class="container-fluid">
    @include('components.apps.heading_info', ['app' => $app, 'type' => 'guest', 'student' => $is_student])
    <div class="row mt">
      <div class="col-md-6">
        <div class="box blue">
          <div class="box-header">
            {{ GeneralText::field('first_video') }}
          </div>
          <div id="video-player-left" class="box-body">
            <div class="embed-responsive embed-responsive-16by9">
              <video id="video-left" class="embed-responsive-item video-js" controls preload="auto" width="640" height="264">
                  <source src="{{ $session->videoL }}" type="video/mp4">
              </video>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="box yellow">
          <div class="box-header">
            {{ GeneralText::field('second_video') }}
          </div>
          <div id="video-player-right" class="box-body">
            <div class="embed-responsive embed-responsive-16by9">
              <video id="video-right" class="embed-responsive-item video-js" controls preload="auto">
                  <source src="{{ $session->videoR }}" type="video/mp4">
              </video>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row mt">
      <div class="col">
        <div class="box orange">
          <div class="box-btns pt">
            <div class="btn-group pr-4">
              <button id="reload" type="button" name="button" class="btn btn-secondary btn-orange">
                <i class="fa fa-refresh" aria-hidden="true"></i>
              </button>
            </div>
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
            {{ GeneralText::field('notes') }}
          </div>
          <div class="box-body">
            <textarea id="notes" name="notes" rows="8" class="form-control">{{ $session->notes }}</textarea>
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
  <script src="{{ asset('plugins/videojs/video.js') }}"></script>
  <script src="{{ mix('js/guest-chat.js') }}"></script>

  <script type="text/javascript">
    var AppSession = new TfcSessions();

    var string = '{{ $library }}',
        videos = JSON.parse(string.replace(/&quot;/g,'"'));
        lenght = Object.keys(videos).length;
        console.log(videos);

    var left = videojs('video-left', {
        controlBar: {
          playToggle: false,
          volumeMenuButton: false,
          fullscreenToggle: false,
        }
    });

    var right = videojs('video-right', {
        controlBar: {
          playToggle: false,
          volumeMenuButton: false,
          fullscreenToggle: false,
        }
    });

    left.ready(function() {
        localStorage.setItem('app-6-video-left', left.src());
    });

    right.ready(function() {
        localStorage.setItem('app-6-video-right', right.src());
    });

    $('#play').on('click', function() {
        left.play();
        right.play();
    });

    $('#pause').on('click', function() {
        left.pause();
        right.pause();
    });

    $('#stop').on('click', function() {
        left.pause().currentTime(0);
        right.pause().currentTime(0);
    });

    $('#rewind').on('click', function() {
        var time = left.currentTime();
        left.currentTime(time-5);
        right.currentTime(time-5);
    });

    $('#forward').on('click', function() {
        var time = left.currentTime();
        left.currentTime(time+5);
        right.currentTime(time+5);
    });

    $('#reload').on('click', function() {
      var left_id = Math.floor(Math.random() * lenght),
          right_id = Math.floor(Math.random() * lenght);

      while (left_id == right_id) {
        right_id = Math.floor(Math.random() * lenght);
      }

      left.pause();
      right.pause();
      left.src(videos[left_id]);
      right.src(videos[right_id]);
      left.load();
      right.load();
      localStorage.setItem('app-6-video-left', left.src());
      localStorage.setItem('app-6-video-right', right.src());
    });

    $('#reload-left').on('click', function() {
      var cache_video = localStorage.getItem('app-6-video-right'),
          clean_path = getPath(cache_video),
          decoded_uri = decodeURI(clean_path);

      var foundIndex = videos.findIndex((video) => {
        return video == decoded_uri;
      });

      var left_id = Math.floor(Math.random() * lenght);
      while (left_id == foundIndex) {
        right_id = Math.floor(Math.random() * lenght);
      }

      left.pause();
      right.pause();
      left.src(videos[left_id]);
      left.load();
      localStorage.setItem('app-6-video-left', left.src());

    })

    $('#reload-right').on('click', function() {
      var cache_video = localStorage.getItem('app-6-video-left'),
          clean_path = getPath(cache_video),
          decoded_uri = decodeURI(clean_path);

      var foundIndex = videos.findIndex((video) => {
        return video == decoded_uri;
      });

      var right_id = Math.floor(Math.random() * lenght);
      while (right_id == foundIndex) {
        left_id = Math.floor(Math.random() * lenght);
      }

      left.pause();
      right.pause();
      right.src(videos[right_id]);
      right.load();
      localStorage.cdsetItem('app-6-video-right', right.src());

    })

    function getPath(url) {
      var a = document.createElement('a');
      a.href = url;
      return a.pathname.substr(0,1) === '/' ? a.pathname : '/' + a.pathname;
    }

  </script>
@endsection
