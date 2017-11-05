@extends('layouts.teacher', ['type' => 'app'])
@section('title', $app->title)
@section('stylesheets')
  {{-- <link rel="stylesheet" href="{{ mix('css/app/2.1/style.css') }}"> --}}
  <link rel="stylesheet" href="{{ asset('css/app/2.1/video-js.css') }}">
  {{-- <link rel="stylesheet" href="{{ mix('css/app/2.1/timeline-main.css') }}"> --}}
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
  <section id="title" class="pt-5">
    <div class="title sp-center pt-5 pb-5">
      {{ $app->title }}
      <h2 class="p-2 block-title">{{ $app_category->name }}</h2>
    </div>
  </section>
  @include('components.apps.sidebar-menu', ['app' => $app, 'type' => 'teacher'])
  <div class="row row-custom">
    <div id="help" class="col-6 container-fluid px-5 d-inline-block float-left">
        <div class="container-fluid pl-5">
          <div class="row">
            <div class="col" style="background-color: #a6dbe2; color: #252525">
              <h3 class="px-2 pt-4 pb-2">Examples</h3>
            </div>
          </div>
          <div class="row pb-5">
            <div class="col py-5" style="background-color: #d9f5fc; color: #252525">
              <p class="pl-2">
                Examples of pictures and clips related to each app with a short explanations
              </p>
            </div>
          </div>
          <div class="row" style="background-color: #e9c845; color: #252525">
            <div class="col">
              <h3 class="px-2 pt-4 pb-2">References</h3>
            </div>
          </div>
          <div class="row mb-5" style="background-color: #f5db5e; color: #252525">
            <div class="col py-5">
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
    <div id="app" class="col-12 px-5 d-inline-block float-left" ng-app="App" ng-cloak ng-controller="videoController">
      <div class="row">
        <div class="col-md-8">
          <div class="box container-fluid mb-4">
            <div class="row">
              <div class="col dark-blue py-3 px-5">
                <h3>Preview</h3>
              </div>
            </div>
            <div class="row">
              <div id="video-player" class="col blue p-5">
                <vjs-video-container id="video-editor" vjs-ratio="16:9" vjs-media="mediaToggle">
                  <video class="video-js vjs-default-skin" controls preload="auto" >
                     {{-- <source src="{{ $media_url }}" type="video/mp4"> --}}
                  </video>
                </vjs-video-container>
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
              <div id="video-library" class="col yellow p-5">
                <nav class="navbar navbar-toggleable-sm navbar-light pb-sm-5">
                  <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                  </button>
                  <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav mx-auto">
                      <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#library-video" aria-expanded="false" aria-controls="">Video</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#upload" aria-expanded="false" aria-controls="">Upload</a>
                      </li>
                    </ul>
                  </div>
                </nav>
                {{-- Library --}}
                  <div class="collapse show" id="library-video" role="tabpanel" show="true">
                    {{-- Library --}}
                      @foreach ($elements as $key => $element)
                        <div class="row pb-3">
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
                  <div class="collapse pt-3" id="upload" role="tabpanel">
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
                        <button type="submit" class="btn btn-secondary btn-yellow"><i class="fa fa-upload" aria-hidden="true"></i> Upload</button>
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
      <div class="row">
        <div class="col-12">
          <div class="box container-fluid mb-4">
            <div class="row">
              <div class="col orange p-5">
                <div class="d-flex justify-content-around">
                  <div class="">
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
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <div class="box container-fluid">
            <div class="row">
              <div class="col green p-5">
                <div ng-controller="DemoMediaTimelineController">
                  <mt-timelines data="timelines" style="height: 200px;" tick="tick" is-disable="enable"
                    tick-change="onTickChange(tick);"
                    point-move="onPointMove(timelineData, eventData, pointData, newTick)"
                    point-click="onPointClick(timelineData, eventData, pointData)"
                    multiplepointevent-selected="onMultiplePointEventSelected(timelineData, eventData)"
                    event-startchange="onEventStartChange(timelineData, eventData, newStartTick)"
                    event-durationchange="onEventDurationChange(timelineData, eventData, newDuration)"
                    event-click="onEventClick(timelineData, eventData)"
                    tick-ratio="25";>
                  </mt-timelines>
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
      $('#token').val(session.token);
    });
  </script>
  <script src="{{ mix('js/app/intercut-crosscutting.js') }}"></script>
@endsection
