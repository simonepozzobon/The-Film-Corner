@extends('layouts.guest', ['type' => 'app'])
@section('title', $app->title)
@section('stylesheets')
  <link href="//vjs.zencdn.net/5.8.8/video-js.css" rel="stylesheet">
@endsection
@section('content')
  <div class="container-fluid">
    @include('components.apps.heading_info', ['app' => $app, 'type' => 'guest'])
    <div id="app">
      <div class="row mt">
        <div class="col-md-8">
          <div class="box blue">
            <div class="box-header">
              {{ GeneralText::field('scene') }}
            </div>
            <div id="video-player" class="box-body">
              <div class="embed-responsive embed-responsive-16by9">
                <video id="video-main" class="embed-responsive-item video-js" controls preload="auto" width="640" height="264">
                    <source src="{{ $random_video }}" type="video/mp4">
                </video>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="box yellow">
            <div class="box-header">
              {{ GeneralText::field('library') }}
            </div>
            <div class="box-body library">
              <nav class="navbar navbar-expand-sm navbar-library yellow">
                <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                  <ul class="navbar-nav" role="tablist">
                    <li class="nav-item">
                      <a class="library-link nav-link active" data-toggle="tab" href="#video-library">{{ GeneralText::field('video') }}</a>
                    </li>
                  </ul>
                </div>
              </nav>
              <div id="libraries" class="library-container tab-content">
                <div id="video-library" class="assets tab-pane active" role="tabpanel">
                  <div class="row scroller">
                    <div class="col">
                      @foreach ($app->videos()->get() as $key => $video)
                        <div class="row">
                          <div class="col-md-2">
                            <img src="{{ Storage::disk('local')->url($video->img) }}" width="57">
                          </div>
                          <div class="col-md-8">
                            <p class="p-2">{{ $video->title }}</p>
                          </div>
                          <div class="col-md-2">
                            <button class="change-video btn btn-yellow" data-video-src="{{ Storage::disk('local')->url($video->src) }}">
                              <i class="fa fa-plus" aria-hidden="true"></i>
                            </button>
                          </div>
                        </div>
                      @endforeach
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row mt">
        <div class="col">
          <div class="box orange">
            <div class="box-btns pt">
              <div class="btn-group">
                <button id="play" type="button" name="button" class="btn btn-orange">
                  <i class="fa fa-play" aria-hidden="true"></i>
                </button>
                <button id="pause" type="button" name="button" class="btn btn-orange">
                  <i class="fa fa-pause" aria-hidden="true"></i>
                </button>
                <button id="stop" type="button" name="button" class="btn btn-orange">
                  <i class="fa fa-stop" aria-hidden="true"></i>
                </button>
                <button id="rewind" type="button" name="button" class="btn btn-orange">
                  <i class="fa fa-backward" aria-hidden="true"></i>
                </button>
                <button id="forward" type="button" name="button" class="btn btn-orange">
                  <i class="fa fa-forward" aria-hidden="true"></i>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row mt">
        <div id="uploads" class="col-md-8">
          <div class="box green">
            <div class="box-header">
              Upload your offscreen video
            </div>
            <div class="box-body">
              <upload-form
                  csrf_field="{{ csrf_token() }}"
                  app_id="{{ $app->id }}"
                  color="green"
                  route="{{ route('guest.creative-studio.upload', [$app_category, $app->slug]) }}">
              </upload-form>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="box blue">
            <div class="box-header">
              Video Uploaded
            </div>
            <div class="box-body">
              <div id="no-video">
                <span class="alert alert-warning d-block text-center">No video uploaded yet!</span>
              </div>
              <table id="videos" class="table table-hover d-none">

              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('scripts')
  <script src="{{ mix('js/upload.js') }}"></script>
  <script src="{{ asset('plugins/videojs/video.js') }}"></script>

  <script type="text/javascript">
    var AppSession = new TfcSessions();
    var session = AppSession.initSession({{ $app->id }});

    $(document).ready( libraryResize );
    document.getElementById('video-main').addEventListener('onresize', libraryResize);

    function libraryResize()
    {
        var video_player = document.getElementById('video-main').offsetHeight - 42;
        $('#libraries').height(video_player);

        var libraryEl = document.getElementById('libraries');

        // creo l'evento personalizzato che verrà triggerato dalla funzione libraryResize
        var event = document.createEvent('HTMLEvents');
        event.initEvent('library-resized', true, true);

        // target can be any Element or other EventTarget.
        libraryEl.dispatchEvent(event);
    }


    var player = videojs('video-main', {
      controlBar: {
        playToggle: false,
        volumeMenuButton: false,
        fullscreenToggle: false,
      }
    });

    var videos = [];

    // player.muted(true);

    player.ready(function() {
      $('.change-video').on('click', function(event) {
        event.preventDefault();
        player.pause();
        player.src($(this).data('video-src'));
        localStorage.setItem('app-10-video', $(this).data('video-src'));
        player.load();
      });
    });

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

    $('body').on('session-loaded', function(e, session) {
      console.log('sessione caricata '+session.token);
      $('#session-token').attr('value', session.token)

      // save the video src
      localStorage.setItem('app-10-video', $('#video-main source').attr('src'));
    });
  </script>
@endsection
