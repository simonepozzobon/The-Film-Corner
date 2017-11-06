@extends('layouts.teacher', ['type' => 'app'])
@section('title', 'Soundscapes')
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
  <section id="title" class="pt-5">
    <div class="title sp-center pt-5 pb-5">
      {{ $app->title }}
      <h2 class="p-2 block-title">{{ $app_category->name }}</h2>
    </div>
  </section>
  @include('components.apps.sidebar-menu', ['app' => $app, 'type' => 'teacher'])
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
                    <h3>Your scene</h3>
                  </div>
                </div>
                <div class="row">
                  <div id="player" class="col blue p-5">
                    <img id="image" src="{{ $random_image }}" alt="" class="img-fluid">
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
          </div>
        </div>
        <div class="col-md-4">
          <div class="box container-fluid mb-4">
            <div class="row">
              <div class="col dark-yellow py-3 px-5">
                <h3>Library</h3>
              </div>
            </div>
            <div class="row">
              <div id="library" class="col yellow p-5">
                <nav class="navbar navbar-toggleable-sm navbar-light pb-sm-5">
                  <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                  </button>
                  <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav mx-auto">
                        <li class="nav-item">
                          <a class="nav-link" data-toggle="collapse" href="" aria-expanded="false" data-target="#audio-library" aria-controls="#audio-library">Audio</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" data-toggle="collapse" href="" aria-expanded="false" data-target="#image-library" aria-controls="#image-library">Images</a>
                        </li>
                    </ul>
                  </div>
                </nav>
                <div id="libraries">
                    <div id="audio-library" class="collapse show test" data-show="true" role="tabpanel">
                      @foreach ($app->audios()->get() as $key => $audio)
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
                      @endforeach
                    </div>
                    <div id="image-library" class="collapse" role="tabpanel">
                      @foreach ($app->medias()->get() as $key => $media)
                        <div class="asset-image row pb-3 align-middle">
                          <div class="col-md-2 justify-content-middle">
                            <img src="{{ Storage::disk('local')->url($media->thumb) }}" alt="image asset" width="57" class="img-fluid w-100"/>
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
      <div class="row">
        <div class="col">
          <div class="box container-fluid mb-4">
            <div class="row">
              <div class="col orange p-5">
                <div class="col d-flex justify-content-around pb-4">
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
                <div id="mixer" class="container-fluid d-flex justify-content-around">
                  <div class="container">
                    <div class="row">
                      <div class="col">
                        <div id="waveform-1-vol" style="height:100px;" class="mx-auto"></div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col">
                        <div id="waveform-1-container" data-id="1" class="draggable-container mx-auto mt-3 test">
                          {{-- Bookmark --}}
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="container">
                    <div class="row">
                      <div class="col">
                        <div id="waveform-2-vol" style="height:100px;" class="mx-auto"></div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col">
                        <div id="waveform-2-container" data-id="2" class="draggable-container mx-auto mt-3 test">
                          {{-- Bookmark --}}
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="container">
                    <div class="row">
                      <div class="col">
                        <div id="waveform-3-vol" style="height:100px;" class="mx-auto"></div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col">
                        <div id="waveform-3-container" data-id="3" class="draggable-container mx-auto mt-3 test">
                          {{-- Bookmark --}}
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="container">
                    <div class="row">
                      <div class="col">
                        <div id="waveform-4-vol" style="height:100px;" class="mx-auto"></div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col">
                        <div id="waveform-4-container" data-id="4" class="draggable-container mx-auto mt-3 test">
                          {{-- Bookmark --}}
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="container">
                    <div class="row">
                      <div class="col">
                        <div id="waveform-5-vol" style="height:100px;" class="mx-auto"></div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col">
                        <div id="waveform-5-container" data-id="5" class="draggable-container mx-auto mt-3 test">
                          {{-- Bookmark --}}
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="container">
                    <div class="row">
                      <div class="col">
                        <div id="waveform-6-vol" style="height:100px;" class="mx-auto"></div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col">
                        <div id="waveform-6-container" data-id="6" class="draggable-container mx-auto mt-3 test">
                          {{-- Ciao --}}
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
      <div class="row">
        <div class="col">
          <div class="box container-fluid mb-4">
            <div class="row">
              <div class="col dark-green py-3 px-5">
                <h3>Take your notes</h3>
              </div>
            </div>
            <div class="row">
              <div class="col green p-5">
                <textarea id="notes" name="notes" rows="8" class="form-control"></textarea>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection
@section('scripts')
  <script src="https://cdn.jsdelivr.net/npm/@shopify/draggable@1.0.0-beta.3/lib/draggable.bundle.js"></script>
  {{-- <script src="https://cdn.jsdelivr.net/npm/@shopify/draggable@1.0.0-beta.3/lib/draggable.bundle.legacy.js"></script> --}}
  <script src="{{ asset('plugins/any-resize-event.min.js') }}"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/wavesurfer.js/1.2.3/wavesurfer.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/wavesurfer.js/1.2.3/plugin/wavesurfer.regions.min.js"></script>
  <script>
    var AppSession = new TfcSessions();
    var session = AppSession.initSession({{ $app->id }});

    player = document.getElementById('player');
    player.addEventListener('onresize', function(){
        var player = document.getElementById('player').offsetHeight - 95;
        $('#library').height(player);
    });

    const droppable = new Draggable.Droppable(document.querySelectorAll('.test'), {
      draggable: '.asset-audio',
      droppable: '.test'
    });

    var srcs = [null, null, null, null, null, null];

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

    // Set loops
    players[0].on('ready', function () {
        setLoops(players[0]);
        console.log('player 0 pronto');
    });
    players[1].on('ready', function () {
        setLoops(players[1]);
        console.log('player 1 pronto');
    });
    players[2].on('ready', function () {
        setLoops(players[2]);
        console.log('player 2 pronto');
    });
    players[3].on('ready', function () {
        setLoops(players[3]);
        console.log('player 3 pronto');
    });
    players[4].on('ready', function () {
        setLoops(players[4]);
        console.log('player 4 pronto');
    });
    players[5].on('ready', function () {
        setLoops(players[5]);
        console.log('player 5 pronto');
    });

    $( "#waveform-1-vol" ).slider({
      orientation: "vertical",
      range: "min",
      min: 0,
      max: 100,
      value: 0,
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
      value: 0,
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
      value: 0,
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
      value: 0,
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
      value: 0,
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
      value: 0,
      slide: function( event, ui ) {
          vols[5] = ui.value/100;
          players[5].setVolume(vols[5]);
          saveVol(vols);
      }
    });

    // Mixer Init
    var vols = [0, 0, 0, 0, 0, 0];

    $('body').on('session-loaded', function(e, session){
      console.log('sessione caricata '+session.token);

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

    }); // end of session loaded

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
  </script>
@endsection
