@extends('layouts.student', ['type' => 'app'])
@section('title', $app->title)
@section('stylesheets')
  <link href="http://vjs.zencdn.net/5.8.8/video-js.css" rel="stylesheet">
  <link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <style media="screen">
    .draggable-container {
      min-width: 4rem;
      min-height: 4rem;
      border: 2px #333 dashed;
    }

    .ui-slider {
      background: #f4c490;
      border: 1px solid #e8a360 !important;
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
      background-color: #f4c490;
      border: 1px solid #e8a360;
    }

    .ui-slider-range {
      background: #e8a360;
    }
  </style>
@endsection
@section('content')
  <div class="container-fluid">
    @include('components.apps.heading_info', ['app' => $app, 'type' => 'student', 'student' => $is_student])
    <div class="row mt">
      <div class="col-md-8">
        <div class="box blue">
          <div class="box-header">
            Your Scene
          </div>
          <div class="box-body">
            <div id="player" class="">
              <img id="image" src="{{ $session->image }}" alt="" class="img-fluid">
              <div id="waveform-1" class="d-none"></div>
              <div id="waveform-2" class="d-none"></div>
              <div id="waveform-3" class="d-none"></div>
              <div id="waveform-4" class="d-none"></div>
              <div id="waveform-5" class="d-none"></div>
              <div id="waveform-6" class="d-none"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="box yellow">
          <div class="box-header">
            Library
          </div>
          <div id="library" class="box-body library">
            <nav class="navbar navbar-toggleable-sm navbar-library yellow">
              <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav" role="tablist">
                    <li class="nav-item">
                      <a class="library-link nav-link active" data-toggle="tab" href="#audio-library">Audio</a>
                    </li>
                    <li class="nav-item">
                      <a class="library-link nav-link" data-toggle="tab" href="#image-library">Image</a>
                    </li>
                </ul>
              </div>
            </nav>
            <div id="libraries" class="library-container tab-content">
              <div id="audio-library" class="assets tab-pane active test" role="tabpanel">
                <div class="row scroller">
                  <div class="col">
                    @foreach ($app->audios()->get() as $key => $audio)
                      @if (Storage::disk('local')->url($audio->src) != json_decode($session->audio_src)->src_1 || Storage::disk('local')->url($audio->src) != json_decode($session->audio_src)->src_2 || Storage::disk('local')->url($audio->src) != json_decode($session->audio_src)->src_3 || Storage::disk('local')->url($audio->src) != json_decode($session->audio_src)->src_4 || Storage::disk('local')->url($audio->src) != json_decode($session->audio_src)->src_5 || Storage::disk('local')->url($audio->src) != json_decode($session->audio_src)->src_6)
                        <div class="asset-audio row" data-audio-src="{{ Storage::disk('local')->url($audio->src) }}">
                          <div class="col-md-2">
                            <h3 class="text-center droppable"><i class="fa fa-file-audio-o"></i></h3>
                          </div>
                          <div class="col-md-10">
                            <p>{{ $audio->title }}</p>
                          </div>
                        </div>
                      @endif
                    @endforeach
                  </div>
                </div>
              </div>
              <div id="image-library" class="assets tab-pane" role="tabpanel">
                <div class="row scroller">
                  <div class="col">
                    @foreach ($app->medias()->get() as $key => $media)
                      <div class="asset-image row align-middle pb-3">
                        <div class="col-md-2 justify-content-middle">
                          <img src="{{ Storage::disk('local')->url($media->thumb) }}" alt="image asset" width="57" class="img-fluid w-100 h-100"/>
                        </div>
                        <div class="col-md-8 justify-content-middle">
                          <p class="align-middle">{{ $media->title }}</p>
                        </div>
                        <div class="col-md-2">
                          <a href="" class="btn btn-secondary btn-yellow" data-image-src="{{ Storage::disk('local')->url($media->landscape) }}"><i class="fa fa-plus" aria-hidden="true"></i></a>
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
          <div class="box-body">
            <div class="row">
              <div id="mixer" class="col">
                <div class="row">
                  <div class="col-md-2">
                    <div class="row">
                      <div class="col">
                        <div id="waveform-1-vol" style="height:100px;" class="mx-auto"></div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col">
                        <div id="waveform-1-container" data-id="1" class="draggable-container mx-auto mt-3 test">
                          @if (json_decode($session->audio_src)->src_1 != null)
                            @foreach ($app->audios()->get() as $key => $audio)
                              @if (Storage::disk('local')->url($audio->src) == json_decode($session->audio_src)->src_1)
                                <div class="asset-audio row pb-3" data-audio-src="{{ Storage::disk('local')->url($audio->src) }}">
                                  <div class="col-md-2">
                                    <h3 class="text-center droppable"><i class="fa fa-file-audio-o"></i></h3>
                                  </div>
                                  <div class="col-md-10">
                                    <p>{{ $audio->title }}</p>
                                  </div>
                                  {{-- <div class="col-md-2">
                                    <a href="" class="btn btn-secondary btn-yellow" data-audio-src="{{ Storage::disk('local')->url(urlencode($audio->src)) }}"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                  </div> --}}
                                </div>
                              @endif
                            @endforeach
                          @endif
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="row">
                      <div class="col">
                        <div id="waveform-2-vol" style="height:100px;" class="mx-auto"></div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col">
                        <div id="waveform-2-container" data-id="2" class="draggable-container mx-auto mt-3 test">
                          {{-- Bookmark --}}
                          @if (json_decode($session->audio_src)->src_2 != null)
                            @foreach ($app->audios()->get() as $key => $audio)
                              @if (Storage::disk('local')->url($audio->src) == json_decode($session->audio_src)->src_2)
                                <div class="asset-audio row pb-3" data-audio-src="{{ Storage::disk('local')->url($audio->src) }}">
                                  <div class="col-md-2">
                                    <h3 class="text-center droppable"><i class="fa fa-file-audio-o"></i></h3>
                                  </div>
                                  <div class="col-md-10">
                                    <p>{{ $audio->title }}</p>
                                  </div>
                                  {{-- <div class="col-md-2">
                                    <a href="" class="btn btn-secondary btn-yellow" data-audio-src="{{ Storage::disk('local')->url(urlencode($audio->src)) }}"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                  </div> --}}
                                </div>
                              @endif
                            @endforeach
                          @endif
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="row">
                      <div class="col">
                        <div id="waveform-3-vol" style="height:100px;" class="mx-auto"></div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col">
                        <div id="waveform-3-container" data-id="3" class="draggable-container mx-auto mt-3 test">
                          {{-- Bookmark --}}
                          @if (json_decode($session->audio_src)->src_3 != null)
                            @foreach ($app->audios()->get() as $key => $audio)
                              @if (Storage::disk('local')->url($audio->src) == json_decode($session->audio_src)->src_3)
                                <div class="asset-audio row pb-3" data-audio-src="{{ Storage::disk('local')->url($audio->src) }}">
                                  <div class="col-md-2">
                                    <h3 class="text-center droppable"><i class="fa fa-file-audio-o"></i></h3>
                                  </div>
                                  <div class="col-md-10">
                                    <p>{{ $audio->title }}</p>
                                  </div>
                                  {{-- <div class="col-md-2">
                                    <a href="" class="btn btn-secondary btn-yellow" data-audio-src="{{ Storage::disk('local')->url(urlencode($audio->src)) }}"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                  </div> --}}
                                </div>
                              @endif
                            @endforeach
                          @endif
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="row">
                      <div class="col">
                        <div id="waveform-4-vol" style="height:100px;" class="mx-auto"></div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col">
                        <div id="waveform-4-container" data-id="4" class="draggable-container mx-auto mt-3 test">
                          {{-- Bookmark --}}
                          @if (json_decode($session->audio_src)->src_4 != null)
                            @foreach ($app->audios()->get() as $key => $audio)
                              @if (Storage::disk('local')->url($audio->src) == json_decode($session->audio_src)->src_4)
                                <div class="asset-audio row pb-3" data-audio-src="{{ Storage::disk('local')->url($audio->src) }}">
                                  <div class="col-md-2">
                                    <h3 class="text-center droppable"><i class="fa fa-file-audio-o"></i></h3>
                                  </div>
                                  <div class="col-md-10">
                                    <p>{{ $audio->title }}</p>
                                  </div>
                                  {{-- <div class="col-md-2">
                                    <a href="" class="btn btn-secondary btn-yellow" data-audio-src="{{ Storage::disk('local')->url(urlencode($audio->src)) }}"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                  </div> --}}
                                </div>
                              @endif
                            @endforeach
                          @endif
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="row">
                      <div class="col">
                        <div id="waveform-5-vol" style="height:100px;" class="mx-auto"></div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col">
                        <div id="waveform-5-container" data-id="5" class="draggable-container mx-auto mt-3 test">
                          {{-- Bookmark --}}
                          @if (json_decode($session->audio_src)->src_5 != null)
                            @foreach ($app->audios()->get() as $key => $audio)
                              @if (Storage::disk('local')->url($audio->src) == json_decode($session->audio_src)->src_5)
                                <div class="asset-audio row pb-3" data-audio-src="{{ Storage::disk('local')->url($audio->src) }}">
                                  <div class="col-md-2">
                                    <h3 class="text-center droppable"><i class="fa fa-file-audio-o"></i></h3>
                                  </div>
                                  <div class="col-md-10">
                                    <p>{{ $audio->title }}</p>
                                  </div>
                                  {{-- <div class="col-md-2">
                                    <a href="" class="btn btn-secondary btn-yellow" data-audio-src="{{ Storage::disk('local')->url(urlencode($audio->src)) }}"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                  </div> --}}
                                </div>
                              @endif
                            @endforeach
                          @endif
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="row">
                      <div class="col">
                        <div id="waveform-6-vol" style="height:100px;" class="mx-auto"></div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col">
                        <div id="waveform-6-container" data-id="6" class="draggable-container mx-auto mt-3 test">
                          {{-- Ciao --}}
                          @if (json_decode($session->audio_src)->src_6 != null)
                            @foreach ($app->audios()->get() as $key => $audio)
                              @if (Storage::disk('local')->url($audio->src) == json_decode($session->audio_src)->src_6)
                                <div class="asset-audio row pb-3" data-audio-src="{{ Storage::disk('local')->url($audio->src) }}">
                                  <div class="col-md-2">
                                    <h3 class="text-center droppable"><i class="fa fa-file-audio-o"></i></h3>
                                  </div>
                                  <div class="col-md-10">
                                    <p>{{ $audio->title }}</p>
                                  </div>
                                  {{-- <div class="col-md-2">
                                    <a href="" class="btn btn-secondary btn-yellow" data-audio-src="{{ Storage::disk('local')->url(urlencode($audio->src)) }}"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                  </div> --}}
                                </div>
                              @endif
                            @endforeach
                          @endif
                        </div>
                      </div>
                    </div>
                  </div>
                </div>


              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  @if ($app_session->teacher_shared == 1)
    @include('components.apps.student_chat', ['app_session' => $app_session])
  @endif
@endsection
@section('scripts')
  <script src="{{ mix('js/teacher-chat.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/@shopify/draggable@1.0.0-beta.3/lib/draggable.bundle.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/wavesurfer.js/1.2.3/wavesurfer.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/wavesurfer.js/1.2.3/plugin/wavesurfer.regions.min.js"></script>
  <script>
    var AppSession = new TfcSessions();

    resizeLibrary();
    player = document.getElementById('player');
    player.addEventListener('onresize', resizeLibrary);

    const droppable = new Draggable.Droppable(document.querySelectorAll('.test'), {
      draggable: '.asset-audio',
      droppable: '.test'
    });

    var srcs = [null, null, null, null, null, null];

    // Audio Init
    var players = [
      WaveSurfer.create({
        container: '#waveform-1'
      }),
      WaveSurfer.create({
        container: '#waveform-2'
      }),
      WaveSurfer.create({
        container: '#waveform-3'
      }),
      WaveSurfer.create({
        container: '#waveform-4'
      }),
      WaveSurfer.create({
        container: '#waveform-5'
      }),
      WaveSurfer.create({
        container: '#waveform-6'
      })
    ];

    var session_vol = JSON.parse({!! json_encode($session->audio_vol) !!});

    // Set loops & init vols
    players[0].on('ready', function () {
        setLoops(players[0]);
        players[0].setVolume(session_vol.vol_1);
        console.log('player 0 pronto');
    });
    players[1].on('ready', function () {
        setLoops(players[1]);
        players[1].setVolume(session_vol.vol_2);
        console.log('player 1 pronto');
    });
    players[2].on('ready', function () {
        setLoops(players[2]);
        players[2].setVolume(session_vol.vol_3);
        console.log('player 2 pronto');
    });
    players[3].on('ready', function () {
        setLoops(players[3]);
        players[3].setVolume(session_vol.vol_3);
        console.log('player 3 pronto');
    });
    players[4].on('ready', function () {
        setLoops(players[4]);
        players[4].setVolume(session_vol.vol_4);
        console.log('player 4 pronto');
    });
    players[5].on('ready', function () {
        setLoops(players[5]);
        players[5].setVolume(session_vol.vol_5);
        console.log('player 5 pronto');
    });


    // Mixer Init

    var vol_1 = session_vol.vol_1;
    var vol_2 = session_vol.vol_2;
    var vol_3 = session_vol.vol_3;
    var vol_4 = session_vol.vol_4;
    var vol_5 = session_vol.vol_5;
    var vol_6 = session_vol.vol_6;

    $( "#waveform-1-vol" ).slider({
      orientation: "vertical",
      range: "min",
      min: 0,
      max: 100,
      value: vol_1 * 100,
      slide: function( event, ui ) {
          vols[0] = ui.value/100;
          players[0].setVolume(vols[0]);
          saveVol(vols);
      }
    });
    $( "#waveform-2-vol" ).slider({
      orientation: "vertical",
      range: "min",
      min: 0,
      max: 100,
      value: vol_2 * 100,
      slide: function( event, ui ) {
          vols[1] = ui.value/100;
          players[1].setVolume(vols[1]);
          saveVol(vols);
      }
    });
    $( "#waveform-3-vol" ).slider({
      orientation: "vertical",
      range: "min",
      min: 0,
      max: 100,
      value: vol_3 * 100,
      slide: function( event, ui ) {
          vols[2] = ui.value/100;
          players[2].setVolume(vols[2]);
          saveVol(vols);
      }
    });
    $( "#waveform-4-vol" ).slider({
      orientation: "vertical",
      range: "min",
      min: 0,
      max: 100,
      value: vol_4 * 100,
      slide: function( event, ui ) {
          vols[3] = ui.value/100;
          players[3].setVolume(vols[3]);
          saveVol(vols);
      }
    });
    $( "#waveform-5-vol" ).slider({
      orientation: "vertical",
      range: "min",
      min: 0,
      max: 100,
      value: vol_5 * 100,
      slide: function( event, ui ) {
          vols[4] = ui.value/100;
          players[4].setVolume(vols[4]);
          saveVol(vols);
      }
    });
    $( "#waveform-6-vol" ).slider({
      orientation: "vertical",
      range: "min",
      min: 0,
      max: 100,
      value: vol_6 * 100,
      slide: function( event, ui ) {
          vols[5] = ui.value/100;
          players[5].setVolume(vols[5]);
          saveVol(vols);
      }
    });

    // Mixer Init
    var vols = [0, 0, 0, 0, 0, 0];

    // Load audio file
    droppable.on('drag:stop', (dragEvent) => {

      // Fermo il player
      stop();

      // Cambio la sorgente
      if ($(dragEvent.sourceContainer).hasClass('draggable-container')) {
        srcs[dragEvent.sourceContainer.dataset.id - 1] = null;
        saveSrcs();
        loadPlayers();
      }
      // Salvo le sorgenti
      var el = dragEvent.source;
      if (el.parentNode.dataset.id) {
        var index = el.parentNode.dataset.id - 1
        srcs[index] = el.dataset.audioSrc;
        saveSrcs();
        loadPlayers();
      }
    });

    // Video and Audio Players Controller
    $('#play').on('click', play);
    $('#pause').on('click', pause);
    $('#stop').on('click', stop);
    $('#rewind').on('click', rewind);
    $('#forward').on('click', forward);

    $('.asset-image').find('a').on('click', function(e) {
      e.preventDefault();
      $('#image').attr('src', $(this).data('image-src'));
      localStorage.setItem('app-9-img');
    });

    function saveVol(vols)
    {
        var vol = {
          'vol_1' : vols[0],
          'vol_2' : vols[1],
          'vol_3' : vols[2],
          'vol_4' : vols[3],
          'vol_5' : vols[4],
          'vol_6' : vols[5],
        };
        localStorage.setItem('app-9-vol', JSON.stringify(vol));
    }

    function saveSrcs()
    {

      var src = {
        'src_1' : srcs[0],
        'src_2' : srcs[1],
        'src_3' : srcs[2],
        'src_4' : srcs[3],
        'src_5' : srcs[4],
        'src_6' : srcs[5],
      };
      console.log(srcs);
      localStorage.setItem('app-9-audio', JSON.stringify(src));
      localStorage.setItem('app-9-img', $('#image').attr('src'));
    }

    function loadPlayers()
    {
      for (var i = 0; i < players.length; i++) {
        if (srcs[i] != null) {
          players[i].load(srcs[i]);
          setLoops(players[i]);
          console.log('player '+i+' loaded');
          // console.log(srcs);
        }
      }
    }

    function setLoops(mediable)
    {
        if (typeof(mediable) != 'undefined') {
          var duration = mediable.getDuration();
          mediable.addRegion({
              start: 0, // time in seconds
              end: duration, // time in seconds
              loop: true, //activate loop
              color: 'hsla(100, 100%, 30%, 0.1)'
          });
        }
    }

    function play()
    {
      for (var i = 0; i < players.length; i++) {
        if (srcs[i] != null) {
          players[i].play()
        }
        // console.log(srcs[i]);
      }
    }

    function pause()
    {
      for (var i = 0; i < players.length; i++) {
        if (srcs[i] != null) {
          players[i].pause()
        }
      }
    }

    function stop()
    {
      for (var i = 0; i < players.length; i++) {
        if (srcs[i] != null) {
          if (players[i].isPlaying()) {
              players[i].stop();
              players[i].seekTo(0);
          }
        }
      }
    }

    function rewind()
    {
      for (var i = 0; i < players.length; i++) {
        if (srcs[i] != null) {
          players[i].skipBackward(5);
        }
      }
    }

    function forward()
    {
      for (var i = 0; i < players.length; i++) {
        if (srcs[i] != null) {
          players[i].skipForward(5);
        }
      }
    }

    function resizeLibrary()
    {
        var video_player = document.getElementById('player').offsetHeight - 42;
        $('#libraries').height(video_player);

        var libraryEl = document.getElementById('libraries');

        // creo l'evento personalizzato che verrà triggerato dalla funzione libraryResize
        var event = document.createEvent('HTMLEvents');
        event.initEvent('library-resized', true, true);

        // target can be any Element or other EventTarget.
        libraryEl.dispatchEvent(event);
    }
  </script>
@endsection
