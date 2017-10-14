@extends('layouts.student', ['type' => 'app'])
@section('title', 'Intercut - Cross Cutting')
@section('stylesheets')
  {{-- <link rel="stylesheet" href="{{ mix('css/app/2.1/style.css') }}"> --}}
  <link rel="stylesheet" href="{{ asset('css/app/2.1/video-js.css') }}">
  {{-- <link rel="stylesheet" href="{{ mix('css/app/2.1/timeline-main.css') }}"> --}}
  <link rel="stylesheet" href="{{ mix('css/app/2.1/timeline.css') }}">
  {{-- <link rel="stylesheet" href="{{ mix('css/app/2.1/dropzone.css') }}"> --}}
  <style media="screen">
    #video-editor button.vjs-big-play-button {
      display: none;
    }

    .scrollable {
      height: 460px;
      overflow: scroll;
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
  @include('components.apps.sidebar-menu', ['app' => $app, 'type' => 'student', 'student' => $is_student])
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
              <div class="col blue p-5">
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
              <div class="col yellow p-5">
                {{-- Library --}}
                  <div class="active pt-3" id="library">
                    <table class="table table-hover">
                      <thead>
                        <th>Preview</th>
                        <th>Title</th>
                        <th>Tools</th>
                      </thead>
                      <tbody>
                        @foreach ($elements as $key => $element)
                          <tr>
                            <td class="align-middle">
                              <img src="{{ Storage::disk('local')->url($element->thumb) }}" width="57">
                            </td>
                            <td class="align-middle">{{ $element->title }}</td>
                            <td class="align-middle" ng-controller="toolController">
                              <div class="btn-group">
                                {{-- Trigger Modal --}}
                                <button type="button" class="btn btn-secondary btn-yellow" data-toggle="modal" data-target="#preview-{{ $element->id }}" data-toggle="tooltip" data-placement="top" title="Preview">
                                  <i class="fa fa-eye" aria-hidden="true"></i>
                                </button>
                                {{-- <button ng-click="addElement('{{ $session_id }}','{{ $media_url }}','{{ $element->id }}','{{ $element->title }}', '{{ $element->duration }}', '{{ $element->path }}')" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Add To Timeline"> --}}
                                <button class="btn btn-secondary btn-yellow" ng-click="addElement('{{ $element->id }}','{{ $element->title }}', '{{ $element->duration }}', '{{ $element->path }}')" data-toggle="tooltip" data-placement="top" title="Add To Timeline">
                                  <i class="fa fa-plus" aria-hidden="true"></i>
                                </button>
                              </div>

                              {{-- Modal Preview --}}
                              <div class="modal fade" id="preview-{{ $element->id }}" tabindex="-1" role="dialog" aria-labelledby="modalPreview-{{ $element->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="modalPreview-{{ $element->id }}">{{ $element->title }} - Preview</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="modal-body">
                                      <vjs-video-container vjs-ratio="16:9">
                                          <video class="video-js vjs-default-skin" controls preload="auto" poster="{{ Storage::disk('local')->url($element->thumb) }}">
                                              <source src="{{ Storage::disk('local')->url($element->path) }}" type="video/mp4">
                                          </video>
                                      </vjs-video-container>
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                      {{-- <button id="modalClose-{{ $element->id }}" type="button" class="btn btn-primary" ng-click="addElement('{{ $session_id }}','{{ $media_url }}','{{ $element->id }}','{{ $element->title }}', '{{ $element->duration }}', '{{ $element->path }}')" data-dismiss="modal">
                                        Add to timeline
                                      </button> --}}
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </td>
                          </tr>
                        @endforeach
                      </tbody>
                    </table>
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
  <script type="text/javascript">
    var AppSession = new TfcSessions();

    // Pass the variable to angular JS for init
    var timelines = {!! $session !!};
    var token = '{{ $token }}';

    console.log('---------');
    console.log('Logging all\'inizio');
    console.log(timelines);
    console.log('---------');

  </script>
  <script src="{{ mix('js/app/intercut-crosscutting.js') }}"></script>
@endsection
