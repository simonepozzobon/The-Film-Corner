@extends('layouts.student', ['type' => 'app'])
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
    @include('components.apps.sidebar-menu', ['app' => $app, 'type' => 'student', 'student' => $is_student])
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
              <div class="active pt-3" id="library">
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
      <div class="row mt">
        <div class="col">
          <div class="box orange">
            <div class="box-btns pt">
              {{-- Control Bar --}}
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
        </div>
      </div>
    </div>
  </div>
  @if ($is_student)
    @include('components.apps.student_chat', ['app_session' => $app_session])
  @endif
@endsection
@section('scripts')
  <script src="{{ mix('js/teacher-chat.js') }}"></script>
  <script src="{{ asset('plugins/any-resize-event.min.js') }}"></script>
  <script type="text/javascript">
    var AppSession = new TfcSessions();

    // Pass the variable to angular JS for init
    var timelines = {!! $session !!};
    var token = '{{ $token }}';

    video_player = document.getElementById('video-player');
    video_player.addEventListener('onresize', function(){
        var video_player = document.getElementById('video-player').offsetHeight - 95;
        $('#video-library').height(video_player);
    });

    console.log('---------');
    console.log('Logging all\'inizio');
    console.log(timelines);
    console.log('---------');

  </script>
  <script src="{{ mix('js/app/intercut-crosscutting.js') }}"></script>
@endsection
