@extends('layouts.student', ['type' => 'app'])
@section('title', 'Make Your Own Film')
@section('stylesheets')
  <link href="http://vjs.zencdn.net/5.8.8/video-js.css" rel="stylesheet">
  <link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <style media="screen">
  .ui-slider {
    background: #e6e6e6;
    border: none;
    height: 1em;
  }
  .ui-slider-handle {
    margin-left: .1em !important;
    cursor: -webkit-grab;
    cursor: grab;
  }

  .ui-widget.ui-widget-content {
    border: none;
  }

  .ui-slider-handle.ui-corner-all {
    border-radius: 50%;
  }

  .ui-state-default, .ui-widget-content .ui-state-default {
    background-color: {{ $app->colors[1] }};
    border: none;
  }

  .ui-slider-range {
    background: {{ $app->colors[0] }};
  }
  </style>
@endsection
@section('content')
  @include('components.apps.sidebar-menu', ['app' => $app, 'type' => 'student'])
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
                            <source src="{{ $session->video }}" type="video/mp4">
                        </video>
                      </div>
                      <div class="rowpt-4">
                        <div class="col">
                          <div id="waveform-1" class="d-none"></div>
                          <div id="waveform-2" class="d-none"></div>
                          <div id="waveform-3" class="d-none"></div>
                          <div id="waveform-4" class="d-none"></div>
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
                      <div class="row pt-4">
                        <div class="col-md-6 offset-md-3">
                          <div id="mixer" class="container-fluid d-flex justify-content-around">
                            <div id="waveform-1-vol" style="height:100px;" class="mx-2"></div>
                            <div id="waveform-2-vol" style="height:100px;" class="mx-2"></div>
                            <div id="waveform-3-vol" style="height:100px;" class="mx-2"></div>
                            <div id="waveform-4-vol" style="height:100px;" class="mx-2"></div>
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
                      <textarea id="notes" name="notes" rows="8" class="form-control">{{ $session->notes }}</textarea>
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
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/wavesurfer.js/1.2.3/wavesurfer.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/wavesurfer.js/1.2.3/plugin/wavesurfer.regions.min.js"></script>
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
    var wavesurfer_1 = WaveSurfer.create({
      container: '#waveform-1'
    });
    var wavesurfer_2 = WaveSurfer.create({
      container: '#waveform-2'
    });
    var wavesurfer_3 = WaveSurfer.create({
      container: '#waveform-3'
    });
    var wavesurfer_4 = WaveSurfer.create({
      container: '#waveform-4'
    });

    // Set loops
    wavesurfer_1.on('ready', function () {
        var duration = wavesurfer_1.getDuration();
        wavesurfer_1.addRegion({
            start: 0, // time in seconds
            end: duration, // time in seconds
            loop: true, //activate loop
            color: 'hsla(100, 100%, 30%, 0.1)'
        });
    });
    wavesurfer_2.on('ready', function () {
        var duration = wavesurfer_2.getDuration();
        wavesurfer_2.addRegion({
            start: 0, // time in seconds
            end: duration, // time in seconds
            loop: true, //activate loop
            color: 'hsla(100, 100%, 30%, 0.1)'
        });
    });
    wavesurfer_3.on('ready', function () {
        var duration = wavesurfer_3.getDuration();
        wavesurfer_3.addRegion({
            start: 0, // time in seconds
            end: duration, // time in seconds
            loop: true, //activate loop
            color: 'hsla(100, 100%, 30%, 0.1)'
        });
    });
    wavesurfer_4.on('ready', function () {
        var duration = wavesurfer_4.getDuration();
        wavesurfer_4.addRegion({
            start: 0, // time in seconds
            end: duration, // time in seconds
            loop: true, //activate loop
            color: 'hsla(100, 100%, 30%, 0.1)'
        });
    });


    // Mixer Init
    var vol_1 = {{ $session->audio_vol->vol_1 }};
    var vol_2 = {{ $session->audio_vol->vol_2 }};
    var vol_3 = {{ $session->audio_vol->vol_3 }};
    var vol_4 = {{ $session->audio_vol->vol_4 }};

    $( "#waveform-1-vol" ).slider({
      orientation: "vertical",
      range: "min",
      min: 0,
      max: 100,
      value: vol_1*100,
      slide: function( event, ui ) {
          vol_1 = ui.value/100;
          wavesurfer_1.setVolume(vol_1);
          saveVol(vol_1, vol_2, vol_3, vol_4);
      }
    });
    $( "#waveform-2-vol" ).slider({
      orientation: "vertical",
      range: "min",
      min: 0,
      max: 100,
      value: vol_2*100,
      slide: function( event, ui ) {
          vol_2 = ui.value/100;
          wavesurfer_2.setVolume(vol_2);
          saveVol(vol_1, vol_2, vol_3, vol_4);
      }
    });
    $( "#waveform-3-vol" ).slider({
      orientation: "vertical",
      range: "min",
      min: 0,
      max: 100,
      value: vol_3*100,
      slide: function( event, ui ) {
          vol_3 = ui.value/100;
          wavesurfer_3.setVolume(vol_3);
          saveVol(vol_1, vol_2, vol_3, vol_4);
      }
    });
    $( "#waveform-4-vol" ).slider({
      orientation: "vertical",
      range: "min",
      min: 0,
      max: 100,
      value: vol_4*100,
      slide: function( event, ui ) {
          vol_4 = ui.value/100;
          wavesurfer_4.setVolume(vol_4);
          saveVol(vol_1, vol_2, vol_3, vol_4);
      }
    });

    $('body').on('session-loaded', function(e, session){
      console.log('sessione caricata '+session.token);

      // Load audio file
      var src_1 = '{{ $session->audio_src->src_1 }}'; //musica
      var src_2 = '{{ $session->audio_src->src_2 }}'; // Dialogo
      var src_3 = '{{ $session->audio_src->src_3 }}'; // Sottofondo Spiaggia
      var src_4 = '{{ $session->audio_src->src_4 }}'; // Versi gabbiani
      wavesurfer_1.load(src_1);
      wavesurfer_2.load(src_2);
      wavesurfer_3.load(src_3);
      wavesurfer_4.load(src_4);

      var src = {
        'src_1' : src_1,
        'src_2' : src_2,
        'src_3' : src_3,
        'src_4' : src_4
      };

      $.cookie('tfc-audio-src', JSON.stringify(src));

      // Video and Audio Players Controller
      $('#play').on('click', function() {
        player.play();
        wavesurfer_1.play();
        wavesurfer_2.play();
        wavesurfer_3.play();
        wavesurfer_4.play();
      });

      $('#pause').on('click', function() {
        player.pause();
        wavesurfer_1.pause();
        wavesurfer_2.pause();
        wavesurfer_3.pause();
        wavesurfer_4.pause();
      });

      $('#stop').on('click', function() {
        player.pause().currentTime(0);
        wavesurfer_1.pause();
        wavesurfer_2.pause();
        wavesurfer_3.pause();
        wavesurfer_4.pause();
        wavesurfer_1.seekTo(0);
        wavesurfer_2.seekTo(0);
        wavesurfer_3.seekTo(0);
        wavesurfer_4.seekTo(0);
      });

      $('#rewind').on('click', function() {
        var time = player.currentTime();
        player.currentTime(time-5);
        wavesurfer_1.skipBackward(5);
        wavesurfer_2.skipBackward(5);
        wavesurfer_3.skipBackward(5);
        wavesurfer_4.skipBackward(5);
      });

      $('#forward').on('click', function() {
        var time = player.currentTime();
        player.currentTime(time+5);
        wavesurfer_1.skipForward(5);
        wavesurfer_2.skipForward(5);
        wavesurfer_3.skipForward(5);
        wavesurfer_4.skipForward(5);
      });
    });

    function saveVol(vol_1, vol_2, vol_3, vol_4)
    {
        var vol = {
          'vol_1' : vol_1,
          'vol_2' : vol_2,
          'vol_3' : vol_3,
          'vol_4' : vol_4,
        };
        $.cookie('tfc-audio-vol', JSON.stringify(vol));
    }
  </script>
@endsection
