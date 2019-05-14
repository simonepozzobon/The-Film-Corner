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
        <div class="col-md-8">
          <div class="box blue">
            <div class="box-header">
              {{ GeneralText::field('scene') }}
            </div>
            <div id="video-player" class="box-body">
              <div class="embed-responsive embed-responsive-16by9">
                <video id="video-main" class="embed-responsive-item video-js" controls preload="auto" width="640" height="264">
                    <source src="{{ $session->main_video }}" type="video/mp4">
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
              <table id="upload-assets" class="table table-hover">
                  @foreach ($app_session->videos()->get() as $key => $video)
                    <tr id="video-{{ $video->id }}" class="video-uploaded">
                        <td><img src="{{ Storage::disk('local')->url($video->img) }}" width="57" class="img-fluid"></td>
                        <td>
                         <input id="video-id-src" type="hidden" name="" value="{{ $video->src }}">
                         <div class="btn-group">
                            <button type="button" class="btn btn-blue" onclick="videoPlay('{{ $video->src }}')"><i class="fa fa-play" aria-hidden="true"></i></button>
                            <button type="button" class="btn btn-blue" onclick="videoDelete({{ $video->id }})"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                          </div>
                        </td>
                     </tr>
                  @endforeach
              </table>
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
  <script src="{{ mix('js/upload.js') }}"></script>
  <script src="{{ mix('js/guest-chat.js') }}"></script>
  <script src="{{ asset('plugins/videojs/video.js') }}"></script>

  <script type="text/javascript">
    var AppSession = new TfcSessions();

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
    $('.video-uploaded').each(function(index, video) {
        var img_src = $(this).find('img').attr('src'),
            video_src = $(this).find('input').val(),
            new_video = {
              'img' : img_src,
              'video' : video_src
            };

            videos.push(new_video);
            localStorage.setItem('app-10-video-uploaded', JSON.stringify(videos));
        console.log('img', img_src);
        console.log('src', video_src);
    });
    console.log(videos);

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

    $(document).ready(function()
    {
      var token = '{{ $app_session->token }}';
      $('#session-token').attr('value', token)
    }
    );
  </script>
@endsection
