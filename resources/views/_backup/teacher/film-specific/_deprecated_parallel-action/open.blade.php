@extends('layouts.teacher', ['type' => 'app'])
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
    @include('components.apps.heading_info', ['app' => $app, 'type' => 'teacher', 'student' => $is_student])
    <div id="app" ng-app="App" ng-cloak ng-controller="videoController">
      <div class="row mt">
        <div class="col-md-8">
          <div class="box blue">
            <div class="box-header">
              {{ GeneralText::field('preview') }}
            </div>
            <div id="video-player" class="box-body">
              <vjs-video-container id="video-editor" vjs-ratio="16:9" vjs-media="mediaToggle">
                <video class="video-js vjs-default-skin" controls preload="auto" >
                </video>
              </vjs-video-container>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="box yellow">
            <div class="box-header">
              {{ GeneralText::field('library') }}
            </div>
            <div id="video-library" class="box-body library">
              <nav class="navbar navbar-expand-sm navbar-library yellow">
                <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                  <ul class="navbar-nav" role="tablist">
                    <li class="nav-item">
                      <a class="library-link nav-link active" data-toggle="tab" href="#video-editor-library">Video</a>
                    </li>
                  </ul>
                </div>
              </nav>
              <div id="libraries" class="library-container">
                <div id="video-editor-library" class="assets active">
                  <div class="row scroller">
                    <div class="col">
                      @foreach ($elements as $key => $element)
                        <div class="row">
                          <div class="col-md-2">
                            <img src="{{ Storage::disk('local')->url($element->img) }}" width="57">
                          </div>
                          <div class="col-md-8">
                            <p class="p-2">{{ $element->title }}</p>
                          </div>
                          <div class="col-md-2" ng-controller="toolController">
                            <button class="btn btn-secondary btn-yellow" ng-click="addElement('{{ $element->id }}','{{ $element->title }}', '{{ $element->duration }}', '{{ urlencode($element->src) }}')" data-toggle="tooltip" data-placement="top" title="Add To Timeline">
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
              {{-- Control Bar --}}
              <div class="btn-group mr-1">
                <button type="button" name="button" class="btn btn-secondary btn-orange" ng-click="editorPlay()">
                  <i class="fa fa-play" aria-hidden="true"></i>
                </button>
                <button type="button" name="button" class="btn btn-secondary btn-orange" ng-click="editorPause()">
                  <i class="fa fa-pause" aria-hidden="true"></i>
                </button>
                <button type="button" name="button" class="btn btn-secondary btn-orange" ng-click="editorStop()">
                  <i class="fa fa-stop" aria-hidden="true"></i>
                </button>
                <button type="button" name="button" class="btn btn-secondary btn-orange" ng-click="editorRewind()">
                  <i class="fa fa-backward" aria-hidden="true"></i>
                </button>
                <button type="button" name="button" class="btn btn-secondary btn-orange" ng-click="editorForward()">
                  <i class="fa fa-forward" aria-hidden="true"></i>
                </button>
              </div>

              {{-- <button type="button" name="button" class="btn btn-secondary btn-orange">
                <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Add Note
              </button> --}}
            </div>
          </div>
        </div>
      </div>
      <div class="row mt">
        <div class="col">
          <div class="box green">
            <div class="box-body">
              <div ng-controller="DemoMediaTimelineController">
                <mt-timelines data="timelines" style="height: 200px;" tick="tick" is-disable="enable"
                  tick-change="onTickChange(tick)"
                  point-move="onPointMove(timelineData, eventData, pointData, newTick)"
                  point-click="onPointClick(timelineData, eventData, pointData)"
                  multiplepointevent-selected="onMultiplePointEventSelected(timelineData, eventData)"
                  event-startchange="onEventStartChange(timelineData, eventData, newStartTick)"
                  event-durationchange="onEventDurationChange(timelineData, eventData, newDuration)"
                  event-click="onEventClick(timelineData, eventData)"
                  tick-ratio="25">
                </mt-timelines>
              </div>
            </div>
          </div>
          <div class="box blue mt">
            <div class="box-header">
              {{ GeneralText::field('notes') }}
            </div>
            <div class="box-body">
              <div class="form-group">
                <textarea id="notes" name="notes" rows="8" class="form-control" placeholder="{{ GeneralText::field('parallel_action_desc') }}">{{ $session->notes }}</textarea>
              </div>
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
  <script src="{{ mix('js/teacher-chat.js') }}"></script>
  <script type="text/javascript">
    var AppSession = new TfcSessions();

    // Pass the variable to angular JS for init
    var timelines = {!! $timelines !!};
    var token = '{{ $token }}';

    resizeLibrary();
    video_player = document.getElementById('video-player');
    video_player.addEventListener('onresize', resizeLibrary);

    console.log('---------');
    console.log('Logging all\'inizio');
    console.log(timelines);
    console.log('---------');

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
  <script src="{{ mix('js/app/intercut-crosscutting.js') }}"></script>
@endsection
