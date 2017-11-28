@extends('layouts.teacher', ['type' => 'app'])
@section('title', $app->title)
@section('stylesheets')
  <link href="http://vjs.zencdn.net/5.8.8/video-js.css" rel="stylesheet">
@endsection
@section('content')
  <div class="container-fluid">
    @include('components.apps.heading_info', ['app' => $app, 'type' => 'teacher', 'student' => $is_student])
    <div class="row mt">
      <div class="col-md-8">
        <div class="box blue">
          <div class="box-header">
            Create your atmosphere
          </div>
          <div class="box-body">
            <div class="embed-responsive embed-responsive-16by9">
              <video id="video" class="embed-responsive-item video-js" controls preload="auto" width="640" height="264">
                  <source src="{{ $session->video }}" type="video/mp4">
              </video>
            </div>
            <div id="waveform"></div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="box yellow">
          <div class="box-header">
            Library
          </div>
          <div class="box-body">
            <nav class="navbar navbar-toggleable-sm navbar-light">
              <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                      <a class="nav-link" data-toggle="collapse" href="" aria-expanded="false" data-target="#video-library" aria-controls="#video-library">Video</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" data-toggle="collapse" href="" aria-expanded="false" data-target="#audio-library" aria-controls="#audio-library">Audio</a>
                    </li>
                </ul>
              </div>
            </nav>
            <div id="libraries">
                <div id="video-library" class="collapse show" data-show="true" role="tabpanel">
                  @foreach ($app->videos()->get() as $key => $video)
                    <div class="asset-video row pb-3">
                      <div class="col-md-2">
                        <img src="{{ Storage::disk('local')->url($video->img) }}" alt="image asset" width="57" class="img-fluid w-100"/>
                      </div>
                      <div class="col-md-8">
                        <p>{{ $video->title }}</p>
                      </div>
                      <div class="col-md-2">
                        <a href="" class="btn btn-yellow" data-video-src="{{ Storage::disk('local')->url($video->src) }}"><i class="fa fa-plus" aria-hidden="true"></i></a>
                      </div>
                    </div>
                  @endforeach
                </div>
                <div id="audio-library" class="collapse" role="tabpanel">
                  @foreach ($app->audios()->get() as $key => $audio)
                    <div class="asset-audio row pb-3 align-middle">
                      <div class="col-md-2 justify-content-middle">
                        <h3 class="text-center"><i class="fa fa-file-audio-o"></i></h3>
                      </div>
                      <div class="col-md-8 justify-content-middle">
                        <p class="align-middle">{{ $audio->title }}</p>
                      </div>
                      <div class="col-md-2">
                        <a href="" class="btn btn-yellow" data-audio-src="{{ Storage::disk('local')->url($audio->src) }}"><i class="fa fa-plus" aria-hidden="true"></i></a>
                      </div>
                    </div>
                  @endforeach
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
            <textarea id="notes" name="notes" rows="8" class="form-control input-green" placeholder="Why you choose this soundtrack?">{{ $session->notes }}</textarea>
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
  <script src="{{ asset('plugins/videojs/video.js') }}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/wavesurfer.js/1.2.3/wavesurfer.min.js"></script>
  <script>
    var AppSession = new TfcSessions();

    // Video Init
    var video = videojs('video', {
        controlBar: {
            playToggle: false,
            volumeMenuButton: false,
            fullscreenToggle: false,
        }
    });
    video.muted(true);

    // Audio Init
    var audio = WaveSurfer.create({
        container: '#waveform',
        waveColor: '#252525',
        progressColor: 'purple',
        splitChannels: true,
        height: 64
    });
    console.log('ci siamo');

    // Load audio file
    var src = '{{ $session->audio }}';
    console.log(src);
    audio.load(src);

    localStorage.setItem('app-8-video', video.src());
    localStorage.setItem('app-8-audio', src);

    // Video and Audio Players Controller
    $('#play').on('click', function() {
        video.play();
        audio.play();
    });

    $('#pause').on('click', function() {
        video.pause();
        audio.pause();
    });

    $('#stop').on('click', function() {
        video.pause().currentTime(0);
        if (audio.isPlaying()) {
          audio.stop();
          audio.seekTo(0);
        }
    });

    $('#rewind').on('click', function() {
        var time = video.currentTime();
        console.log(time);
        video.currentTime(time-5);
        audio.skipBackward(5);
    });

    $('#forward').on('click', function() {
        var time = video.currentTime();
        video.currentTime(time+5);
        audio.skipForward(5);
    });

    $('.asset-video').find('a').on('click', function(e) {
        e.preventDefault();
        var video_src = $(this).data('video-src');
        video.pause();
        video.src($(this).data('video-src'));
        localStorage.setItem('app-8-video', $(this).data('video-src'));
        video.load();
    });

    $('.asset-audio').find('a').on('click', function(e) {
        e.preventDefault();
        var audio_src = $(this).data('audio-src');
        if (audio.isPlaying()) {
          audio.stop();
        }
        audio.load(audio_src);
        localStorage.setItem('app-8-audio', audio_src);
    });

  </script>
@endsection
