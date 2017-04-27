@extends('layouts.main')
@section('title')
  Video Test
@endsection
@section('stylesheets')
  <link rel="stylesheet" href="{{ mix('css/app/2.1/style.css') }}">
  {{-- <link rel="stylesheet" href="{{ mix('css/app/2.1/timeline-main.css') }}"> --}}
  <link rel="stylesheet" href="{{ mix('css/app/2.1/timeline.css') }}">
@endsection
@section('content')
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
        Settings
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
