@extends('layouts.teacher', ['type' => 'app'])
@section('title', $app->title)
@section('stylesheets')
  <link rel="stylesheet" href="{{ asset('css/app/2.1/video-js.css') }}">
  <link rel="stylesheet" href="{{ mix('css/app/2.1/timeline.css') }}">
  <style media="screen">
    #video-editor button.vjs-big-play-button {
      display: none;
    }

    .scrollable {
      height: 460px;
      overflow: scroll;
    }

    #video-library {
      overflow-y: scroll;
    }
  </style>
@endsection
@section('content')
  <div class="container-fluid">
    @include('components.apps.heading_info', ['app' => $app])
    @include('components.apps.sidebar-menu', ['app' => $app, 'type' => 'teacher'])
    <div id="app" ng-app="App" ng-cloak ng-controller="videoController">
      <div class="row mt">
        <div class="col-md-8">
          <div class="box blue">
            <div class="box-header">
              Preview
            </div>
            <div id="video-player" class="box-body">
              <vjs-video-container id="video-editor" vjs-ratio="16:9" vjs-media="mediaToggle">
                <video class="video-js vjs-default-skin" controls preload="auto" >
                  <source src="{{ $random_video }}" type="video/mp4">
                </video>
              </vjs-video-container>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="box yellow">
            <div class="box-header">
              Library
            </div>
            <div id="video-library" class="box-body">
              <div class="active" id="library">
                @foreach ($elements as $key => $element)
                  <div class="row">
                    <div class="col-md-2">
                      <h3><i class="fa fa-file-audio-o"></i></h3>
                    </div>
                    <div class="col-md-8">
                      <p class="p-2">{{ $element->title }}</p>
                    </div>
                    <div class="col-md-2" ng-controller="toolController">
                      <button ng-click="addElement('{{ $element->id }}','{{ $element->title }}', '{{ $element->duration }}', '{{ urlencode($element->src) }}')" class="btn btn-secondary btn-yellow" data-toggle="tooltip" data-placement="top" title="Add To Timeline">
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
      <div class="row mt">
        <div class="col">
          <div class="box orange">
            <div class="box-btns pt">
              <div class="btn-group">
                <button type="button" name="button" class="btn btn-secondary btn-orange" ng-click="editorPlay()">
                  <i class="fa fa-play" aria-hidden="true"></i> Play
                </button>
                <button type="button" name="button" class="btn btn-secondary btn-orange" ng-click="editorPause()">
                  <i class="fa fa-pause" aria-hidden="true"></i> Pause
                </button>
                <button type="button" name="button" class="btn btn-secondary btn-orange" ng-click="editorStop()">
                  <i class="fa fa-stop" aria-hidden="true"></i> Stop
                </button>
              </div>
              <div class="btn-group">
                <button type="button" name="button" class="btn btn-secondary btn-orange" ng-click="editorRewind()">
                  <i class="fa fa-backward" aria-hidden="true"></i> Rewind
                </button>
                <button type="button" name="button" class="btn btn-secondary btn-orange" ng-click="editorForward()">
                  <i class="fa fa-forward" aria-hidden="true"></i> Forward
                </button>
              </div>

              <button type="button" name="button" class="btn btn-secondary btn-orange">
                <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Add Note
              </button>
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
                  tick-change="onTickChange(tick);"
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
        </div>
      </div>
    </div>
  </div>
@endsection
@section('scripts')
  <script src="{{ asset('plugins/any-resize-event.min.js') }}"></script>
  <script type="text/javascript">
    var AppSession = new TfcSessions();
    AppSession.initSession({{ $app->id }});

    video_player = document.getElementById('video-player');
    video_player.addEventListener('onresize', function(){
        var video_player = document.getElementById('video-player').offsetHeight - 95;
        $('#video-library').height(video_player);
    });

    $('body').on('session-loaded', function(e, session){
      console.log('sessione caricata '+session.token);
    });
  </script>
  <script src="{{ mix('js/app/sound-studio.js') }}"></script>
@endsection
