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
            <div id="video-library" class="box-body library">
              <nav class="navbar navbar-toggleable-sm navbar-library yellow">
                <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                  <ul class="navbar-nav" role="tablist">
                    <li class="nav-item">
                      <a class="library-link nav-link active" data-toggle="tab" href="#library-video">Video</a>
                    </li>
                    <li class="nav-item">
                      <a class="library-link nav-link" data-toggle="tab" href="#upload">Uploads</a>
                    </li>
                  </ul>
                </div>
              </nav>
              <div id="libraries" class="library-container tab-content">
                <div id="library-video" class="assets tab-pane active" role="tabpanel">
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
                            <button class="btn btn-yellow" ng-click="addElement('{{ $element->id }}','{{ $element->title }}', '{{ $element->duration }}', '{{ urlencode($element->src) }}')" data-toggle="tooltip" data-placement="top" title="Add To Timeline">
                              <i class="fa fa-plus" aria-hidden="true"></i>
                            </button>
                          </div>
                        </div>
                      @endforeach
                    </div>
                  </div>
                </div>
                <div id="upload" class="assets tab-pane" role="tabpanel">
                  <div class="row scroller">
                    <div class="col">
                      <form id="uploadForm" method="post" enctype="multipart/form-data" ng-submit="uploadForm()" ng-controller="uploadController">
                        {{ csrf_field() }}
                        {{ method_field('POST') }}
                        <input id="token" type="hidden" name="session_token" ng-model="session_token" value="">
                        <input id="app_category" type="hidden" name="app_category" ng-model="app_category" value="{{ $app_category->id }}">
                        <input id="app_slug" type="hidden" name="app_slug" ng-model="app_slug" value="{{ $app->slug }}">
                        <div class="form-group">
                          <input id="media" type="file" name="media" class="form-control" ng-model="media">
                        </div>
                        <div class="container-fluid d-flex justify-content-around">
                          <button type="submit" class="btn btn-yellow"><i class="fa fa-upload" aria-hidden="true"></i> Upload</button>
                        </div>
                      </form>
                      <div class="container-fluid pt-4">
                        <table id="uploads" class="table table-hover">
                          <thead>
                            <th>Preview</th>
                            <th>Title</th>
                            <th>Tools</th>
                          </thead>
                          <tbody>

                          </tbody>
                        </table>
                      </div>
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
          <div class="box blue mt">
            <div class="box-header">
              Notes
            </div>
            <div class="box-body">
              <div class="form-group">
                <textarea id="notes" name="notes" rows="8" class="form-control" placeholder="Describe what your work and your choices...">{{ $session->notes }}</textarea>
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
  <script src="{{ asset('plugins/any-resize-event.min.js') }}"></script>
  <script src="{{ mix('js/teacher-chat.js') }}"></script>
  <script type="text/javascript">
    var AppSession = new TfcSessions();

    resizeLibrary();
    video_player = document.getElementById('video-player');
    video_player.addEventListener('onresize', resizeLibrary);


    // Pass the variable to angular JS for init
    @isset($timelines)
      var timelines = {!! $timelines !!};
    @endisset
    var timelines = '';
    var token = '{{ $token }}';
    $('#token').val(token);
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
