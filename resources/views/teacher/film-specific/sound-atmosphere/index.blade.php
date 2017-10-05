@extends('layouts.teacher', ['type' => 'app'])
@section('title', 'Make Your Own Film')
@section('stylesheets')
  <link href="http://vjs.zencdn.net/5.8.8/video-js.css" rel="stylesheet">
@endsection
@section('content')
  @include('components.apps.sidebar-menu', ['app' => $app, 'type' => 'teacher'])
  <div class="p-5">
  </div>
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
      <div class="row" style="background-color: {{ $app->colors[1] }}; color: #252525">
        <div class="col">
          <div class="d-flex justify-content-start">
            <div class="mr-auto"><h3 class="ml-2 pt-4 pb-1">{{ $app->title }}</h3></div>
          </div>
        </div>
      </div>
      <div class="row" style="background-color: {{ $app->colors[0] }}; color: #252525">
        <div class="col">
          <div class="clearfix pt-5 pb-5">
            <div class="row pb-5">
              <div class="col-md-8">
                <div class="row pb-5">
                  <div class="col">
                    <div class="container-fluid frame bg-faded p-4">
                      <div class="embed-responsive embed-responsive-16by9">
                        <video id="video" class="embed-responsive-item video-js" controls preload="auto" width="640" height="264">
                            <source src="http://vjs.zencdn.net/v/oceans.mp4" type="video/mp4">
                        </video>
                      </div>
                      <div class="row">
                        <div class="col">
                          <div id="waveform"></div>
                        </div>
                      </div>
                      <div class="row py-4">
                        <div class="col d-flex justify-content-around">
                          {{-- Control Bar --}}
                          <div class="btn-group">
                            <button id="play" type="button" name="button" class="btn btn-secondary">
                              <i class="fa fa-play" aria-hidden="true"></i>
                            </button>
                            <button id="pause" type="button" name="button" class="btn btn-secondary">
                              <i class="fa fa-pause" aria-hidden="true"></i>
                            </button>
                            <button id="stop" type="button" name="button" class="btn btn-secondary">
                              <i class="fa fa-stop" aria-hidden="true"></i>
                            </button>
                            <button id="rewind" type="button" name="button" class="btn btn-secondary">
                              <i class="fa fa-backward" aria-hidden="true"></i>
                            </button>
                            <button id="forward" type="button" name="button" class="btn btn-secondary">
                              <i class="fa fa-forward" aria-hidden="true"></i>
                            </button>
                          </div>

                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row pb-5">
                  <div class="col">
                    <div class="container-fluid frame bg-faded p-4">
                      <h3 class="text-center pb-4">Describe the scenario</h3>
                      <textarea id="notes" name="notes" rows="8" class="form-control"></textarea>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="container-fluid frame bg-faded p-4">
                  <h3 class="text-center pb-4">Library</h3>
                  <ul class="list-unstyled">
                    <li class="pb-3">
                      <div class="d-flex justify-content-between">
                        <p id="audio-title-1" class="d-block">Title of the audio - Scene 1</p>
                        <input id="audio-src-1" type="hidden" name="src" value="indirizzo audio">
                        <a id="audio-1" href="#" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i></a>
                      </div>
                    </li>
                    <li class="pb-3">
                      <div class="d-flex justify-content-between">
                        <p id="audio-title-1" class="d-block">Title of the audio - Scene 2</p>
                        <input id="audio-src-1" type="hidden" name="src" value="indirizzo audio">
                        <a id="audio-1" href="#" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i></a>
                      </div>
                    </li>
                    <li class="pb-3">
                      <div class="d-flex justify-content-between">
                        <p id="audio-title-1" class="d-block">Title of the audio - Scene 3</p>
                        <input id="audio-src-1" type="hidden" name="src" value="indirizzo audio">
                        <a id="audio-1" href="#" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i></a>
                      </div>
                    </li>
                  </ul>
                </div>
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
    var session = AppSession.initSession({{ $app->id }});

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

    $('body').on('session-loaded', function(e, session){
      console.log('sessione caricata '+session.token);

      // Load audio file
      var src = 'https://wavesurfer-js.org/example/split-channels/stereo.mp3'
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

    });
  </script>
@endsection
