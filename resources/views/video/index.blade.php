@extends('layouts.main')
@section('title')
  Video Test
@endsection
@section('stylesheets')
  {{-- <link rel="stylesheet" href="{{ mix('css/app/2.1/style.css') }}"> --}}
  <link rel="stylesheet" href="{{ asset('css/app/2.1/video-js.css') }}">
  {{-- <link rel="stylesheet" href="{{ mix('css/app/2.1/timeline-main.css') }}"> --}}
  <link rel="stylesheet" href="{{ mix('css/app/2.1/timeline.css') }}">
  <link rel="stylesheet" href="{{ mix('css/app/2.1/dropzone.css') }}">
  <style media="screen">
    #video-editor button.vjs-play-control.vjs-control.vjs-button.vjs-paused,
    #video-editor button.vjs-play-control.vjs-control.vjs-button.vjs-playing
    {
      display: none;
    }
    #video-editor button.vjs-big-play-button {
      display: none;
    }
  </style>
@endsection
@section('content')
  <div class="pt-5">
  </div>
  <div class="clearfix pt-5">
    session_id: {{ $session_id }}
  </div>
  <div class="clearfix pt-5 pb-5 pl-3 pr-3" ng-app="App" ng-cloak ng-controller="videoController">
    <div class="row">
      <div class="col-md-8" >
        <vjs-video-container id="video-editor" vjs-ratio="16:9" vjs-media="mediaToggle" >
          <video class="video-js vjs-default-skin" controls preload="auto" >
          </video>
        </vjs-video-container>
        <div class="clearfix">
          <div class="row">
            <div class="col mt-3">
              {{-- Control Bar --}}
              <div class="btn-group">
                <button type="button" name="button" class="btn btn-secondary" ng-click="editorPlay()">
                  <i class="fa fa-play" aria-hidden="true"></i> Play
                </button>
                <button type="button" name="button" class="btn btn-secondary" ng-click="editorPause()">
                  <i class="fa fa-pause" aria-hidden="true"></i> Pause
                </button>
                <button type="button" name="button" class="btn btn-secondary" ng-click="editorStop()">
                  <i class="fa fa-stop" aria-hidden="true"></i> Stop
                </button>
              </div>


              <div class="btn-group">
                <button type="button" name="button" class="btn btn-secondary">
                  <i class="fa fa-backward" aria-hidden="true"></i> Rewind
                </button>
                <button type="button" name="button" class="btn btn-secondary">
                  <i class="fa fa-forward" aria-hidden="true"></i> Forward
                </button>
              </div>

              <button type="button" name="button" class="btn btn-secondary">
                <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Add Note
              </button>

              <button type="button" name="button" class="btn btn-secondary">
                <i class="fa fa-save" aria-hidden="true"></i> Save
              </button>

              <button type="button" name="button" class="btn btn-secondary">
                <i class="fa fa-share-square-o" aria-hidden="true"></i> Share
              </button>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        {{-- Nav Tabs --}}
        <ul class="nav nav-tabs" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#library" role="tab">Library</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#upload" role="tab">Upload</a>
          </li>
        </ul>
        {{-- Tabs Content --}}
        <div class="tab-content">
          <div class="tab-pane active pt-3" id="library" role="tabpanel">
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
                          <button type="button" class="btn btn-info" data-toggle="modal" data-target="#preview-{{ $element->id }}" data-toggle="tooltip" data-placement="top" title="Preview">
                            <i class="fa fa-eye" aria-hidden="true"></i>
                          </button>
                          <button ng-click="addElement('{{ $element->id }}','{{ $element->title }}', '{{ $element->duration }}', '{{ $element->path }}')" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Add To Timeline">
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
                                <button id="modalClose-{{ $element->id }}" type="button" class="btn btn-primary" ng-click="addElement('{{ $session_id }}','{{ $element->id }}','{{ $element->title }}', '{{ $element->duration }}', '{{ $element->path }}')" data-dismiss="modal">
                                  Add to timeline
                                </button>
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
          <div class="tab-pane pt-3" id="upload" role="tabpanel">
            <form class="dropzone" action="{{ route('video-test.upload') }}" method="post" enctype="multipart/form-data">
              {{ csrf_field() }}
              {{ method_field('POST') }}
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="row mt-3">
      <div class="col">
        <div ng-controller="DemoMediaTimelineController">
      		<mt-timelines data="timelines" style="height: 200px;" tick="tick" is-disable="enable"
            tick-change="onTickChange(tick);"
            point-move="onPointMove(timelineData, eventData, pointData, newTick)"
            point-click="onPointClick(timelineData, eventData, pointData)"
            multiplepointevent-selected="onMultiplePointEventSelected(timelineData, eventData)"
            event-startchange="onEventStartChange(timelineData, eventData, newStartTick)"
            event-durationchange="onEventDurationChange(timelineData, eventData, newDuration)"
            event-click="onEventClick(timelineData, eventData)"
            tick-ratio="25";></mt-timelines>
      	</div>
      </div>
    </div>
  </div>
@endsection
@section('scripts')
  <script>
    (function () {
      jQuery('[data-toggle="tooltip"]').tooltip();
    })
  </script>
  <script src="{{ mix('js/app/2.1/script.js') }}"></script>
@endsection
