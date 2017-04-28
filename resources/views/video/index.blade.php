@extends('layouts.main')
@section('title')
  Video Test
@endsection
@section('stylesheets')
  <link rel="stylesheet" href="{{ mix('css/app/2.1/style.css') }}">
  {{-- <link rel="stylesheet" href="{{ mix('css/app/2.1/timeline-main.css') }}"> --}}
  <link rel="stylesheet" href="{{ mix('css/app/2.1/timeline.css') }}">
  <link rel="stylesheet" href="{{ mix('css/app/2.1/dropzone.css') }}">
@endsection
@section('content')
  <div class="pt-5">

  </div>
  <div class="clearfix pt-5 pb-5 pl-3 pr-3" ng-app="App" ng-cloak>
    <div class="row">
      <div class="col-md-8">
        <div ng-controller="videoController as controller">
      		<videogular vg-theme="controller.config.theme">
      			<vg-media vg-src="controller.config.sources"
      					vg-tracks="controller.config.tracks">
      			</vg-media>

      			<vg-controls>
      				<vg-play-pause-button></vg-play-pause-button>
      				<vg-time-display>@{{ currentTime | date:"mm:ss" }}</vg-time-display>
      				<vg-scrub-bar>
      					<vg-scrub-bar-current-time></vg-scrub-bar-current-time>
      				</vg-scrub-bar>
      				<vg-time-display>@{{ timeLeft | date:'mm:ss' }}</vg-time-display>
      				<vg-volume>
      					<vg-mute-button></vg-mute-button>
      					<vg-volume-bar></vg-volume-bar>
      				</vg-volume>
      				<vg-fullscreen-button></vg-fullscreen-button>
      			</vg-controls>

      			<vg-overlay-play></vg-overlay-play>
      			<vg-poster vg-url='controller.config.plugins.poster'></vg-poster>
      		</videogular>
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
                  <th>Id</th>
                  <th>Preview</th>
                  <th>Title</th>
                  <th>Tools</th>
                </thead>
                <tbody>
                  @foreach ($elements as $key => $element)
                    <tr>
                      <td class="align-middle">{{ $element->id }}</td>
                      <td class="align-middle">
                        <img src="{{ Storage::disk('local')->url($element->thumb) }}" width="57">
                      </td>
                      <td class="align-middle">{{ $element->title }}</td>
                      <td class="align-middle">
                        <div class="btn-group">
                          <a href="#" class="btn btn-info">
                            <i class="fa fa-eye" aria-hidden="true"></i> Preview
                          </a>
                          <a href="#" class="btn btn-primary">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add Media
                          </a>
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
            tick-ratio="30";></mt-timelines>
          <button ng-click="addTimeline()">Add timeline</button>
      	</div>
      </div>
    </div>
  </div>
@endsection
@section('scripts')
  <script src="{{ mix('js/app/2.1/script.js') }}"></script>
@endsection
