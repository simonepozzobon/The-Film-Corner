@extends('layouts.guest', ['type' => 'app'])
@section('title', $app->title)
@section('stylesheets')
  <link rel="stylesheet" href="{{ asset('css/app/2.1/video-js.css') }}">
  <link rel="stylesheet" href="{{ mix('css/app/2.1/timeline.css') }}">
  <style media="screen">
    #video-editor button.vjs-big-play-button {
      display: none;
    }
  </style>
@endsection
@section('content')
  <div class="container-fluid">
      @include('components.apps.heading_info', ['app' => $app, 'type' => 'guest'])
      <div id="timeline">
          <div class="row mt">
              <div class="col-md-8">
                  <div class="box blue">
                      <div class="box-header">
                          {{ GeneralText::field('preview') }}
                      </div>
                      <div id="video-player" class="box-body">
                          <video-preview
                              ref="videoPreview"
                          ></video-preview>
                      </div>
                  </div>
              </div>
              <div class="col-md-4">
                  <library
                      title="{{ GeneralText::field('library') }}"
                      video-text="{{ GeneralText::field('video') }}"
                      elements="{{ $elements }}"
                  ></library>
              </div>
          </div>
          <control-bar></control-bar>
          <timeline></timeline>
          <div class="row mt">
              <div class="col">
                  <div class="box blue">
                      <div class="box-header">
                          {{ GeneralText::field('notes') }}
                      </div>
                      <div class="box-body">
                          <div class="form-group">
                              <textarea id="notes" name="notes" rows="8" class="form-control" placeholder="{{ GeneralText::field('parallel_action_desc') }}"></textarea>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
@endsection
@section('scripts')
  <script src="{{ mix('js/timeline.js') }}"></script>
  <script type="text/javascript">
    var AppSession = new TfcSessions();
    AppSession.initSession({{ $app->id }});

    resizeLibrary();
    video_player = document.getElementById('video-player');
    video_player.addEventListener('onresize', resizeLibrary);

    $('body').on('session-loaded', function(e, session){
      console.log('sessione caricata '+session.token);
    });

    function resizeLibrary()
    {
        var video_player = document.getElementById('video-player').offsetHeight - 106;
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
