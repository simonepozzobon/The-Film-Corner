@extends('layouts.teacher', ['type' => 'app'])
@section('title', 'Make Your Own Film')
@section('stylesheets')
  <link href="http://vjs.zencdn.net/5.8.8/video-js.css" rel="stylesheet">
@endsection
@section('content')
  <section id="title" class="pt-5">
    <div class="title sp-center pt-5 pb-5">
      {{ $app->title }}
      <h2 class="p-2 block-title">{{ $app_category->name }}</h2>
    </div>
  </section>
  @include('components.apps.sidebar-menu', ['app' => $app, 'type' => 'teacher', 'student' => $is_student])
  <div class="row row-custom">
    <div id="help" class="col-6 container-fluid px-5 d-inline-block float-left">
        <div class="container-fluid pl-2 pr-2">
          <div class="row">
            <div class="col" style="background-color: #a6dbe2; color: #252525">
              <h3 class="pl-2 pr-2 pt-4 pb-2">Examples</h3>
            </div>
          </div>
          <div class="row pb-5">
            <div class="col pt-5 pb-5" style="background-color: #d9f5fc; color: #252525">
              <p class="pl-2">
                Examples of pictures and clips related to each app with a short explanations
              </p>
            </div>
          </div>
          <div class="row" style="background-color: #e9c845; color: #252525">
            <div class="col">
              <h3 class="pl-2 pr-2 pt-4 pb-2">References</h3>
            </div>
          </div>
          <div class="row mb-5" style="background-color: #f5db5e; color: #252525">
            <div class="col pt-5 pb-5">
              <p class="pl-2">
                <ul>
                  <li>lista 1</li>
                  <li>lista 2</li>
                  <li>altro elemento</li>
                </ul>
              </p>
            </div>
          </div>
          <div class="row pb-5">
            @foreach ($app_category->keywords as $key => $keyword)
              <h5><span class="badge badge-default mb-2 mr-2" data-toggle="modal" data-target="#keywordModal-{{ $keyword->id }}">{{ $keyword->name }}</span></h5>
              <div class="modal fade" id="keywordModal-{{ $keyword->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">{{ $keyword->name }}</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="fa fa-times" aria-hidden="true"></i>
                      </button>
                    </div>
                    <div class="modal-body">
                      {{ $keyword->description }}
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Close</button>
                    </div>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>
    </div>
    <div id="app" class="col-12 px-5 d-inline-block float-left">
      <div class="row">
        <div class="col-md-8">
          <div class="row">
            <div class="col">
              <div class="box container-fluid mb-4">
                <div class="row">
                  <div class="col dark-blue py-3 px-5">
                    <h3>Create your atmosphere</h3>
                  </div>
                </div>
                <div class="row">
                  <div class="col blue p-5">
                    <div class="embed-responsive embed-responsive-16by9">
                      <video id="video" class="embed-responsive-item video-js" controls preload="auto" width="640" height="264">
                          <source src="{{ $session->video }}" type="video/mp4">
                      </video>
                    </div>
                    <div id="waveform"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <div class="box container-fluid mb-4">
                <div class="row">
                  <div class="col orange p-5">
                    <div class="col d-flex justify-content-around">
                      {{-- Control Bar --}}
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
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="box container-fluid mb-4">
            <div class="row">
              <div class="col dark-yellow py-3 px-5">
                <h3>library</h3>
              </div>
            </div>
            <div class="row">
              <div class="col yellow p-5">
                <ul class="list-unstyled">
                  <li class="pb-3">
                    <div class="d-flex justify-content-between">
                      <p id="audio-title-1" class="d-block">Title of the audio - Scene 1</p>
                      <input id="audio-src-1" type="hidden" name="src" value="indirizzo audio">
                      <a id="audio-1" href="#" class="btn btn-secondary btn-yellow"><i class="fa fa-plus" aria-hidden="true"></i></a>
                    </div>
                  </li>
                  <li class="pb-3">
                    <div class="d-flex justify-content-between">
                      <p id="audio-title-1" class="d-block">Title of the audio - Scene 2</p>
                      <input id="audio-src-1" type="hidden" name="src" value="indirizzo audio">
                      <a id="audio-1" href="#" class="btn btn-secondary btn-yellow"><i class="fa fa-plus" aria-hidden="true"></i></a>
                    </div>
                  </li>
                  <li class="pb-3">
                    <div class="d-flex justify-content-between">
                      <p id="audio-title-1" class="d-block">Title of the audio - Scene 3</p>
                      <input id="audio-src-1" type="hidden" name="src" value="indirizzo audio">
                      <a id="audio-1" href="#" class="btn btn-secondary btn-yellow"><i class="fa fa-plus" aria-hidden="true"></i></a>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col">
          <div class="box container-fluid mb-4">
            <div class="row">
              <div class="col dark-green py-3 px-5">
                <h3>Why you choose this soundtrack?</h3>
              </div>
            </div>
            <div class="row">
              <div class="col green p-5">
                <textarea id="notes" name="notes" rows="8" class="form-control input-green">{{ $session->notes }}</textarea>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection
@section('scripts')
  <script src="{{ asset('plugins/videojs/video.js') }}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/wavesurfer.js/1.2.3/wavesurfer.min.js"></script>
  <script>
    var AppSession = new TfcSessions();

    // Video Init
    var player = videojs('video', {
      controlBar: {
        playToggle: false,
        volumeMenuButton: false,
        fullscreenToggle: false,
      }
    });
    player.muted(true);

    // Audio Init
    var wavesurfer = WaveSurfer.create({
      container: '#waveform',
      waveColor: '#252525',
      progressColor: 'purple',
      splitChannels: true,
      height: 64
    });

    // Load audio file
    var src = '{{ $session->audio }}'
    wavesurfer.load(src);
    $.cookie('tfc-audio', JSON.stringify(src));

    // Video and Audio Players Controller
    $('#play').on('click', function() {
      player.play();
      wavesurfer.play();
    });

    $('#pause').on('click', function() {
      player.pause();
      wavesurfer.pause();
    });

    $('#stop').on('click', function() {
      player.pause().currentTime(0);
      wavesurfer.pause();
      wavesurfer.seekTo(0);
    });

    $('#rewind').on('click', function() {
      var time = player.currentTime();
      console.log(time);
      player.currentTime(time-5);
      wavesurfer.skipBackward(5);
    });

    $('#forward').on('click', function() {
      var time = player.currentTime();
      player.currentTime(time+5);
      wavesurfer.skipForward(5);
      });

  </script>
@endsection
