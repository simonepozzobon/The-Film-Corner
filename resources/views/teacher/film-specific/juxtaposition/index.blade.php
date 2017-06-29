@extends('layouts.teacher', ['type' => 'app'])
@section('content')
  @include('components.apps.sidebar-menu', ['app' => $app])
  <div class="clearfix" ng-app="App" ng-cloak ng-controller="videoController">
    <div class="row">
      <div class="col-md-6">
        <vjs-video-container id="video-left" vjs-ratio="16:9" vjs-media="mediaToggle">
          <video class="video-js vjs-default-skin" controls preload="auto" >
             <source src="http://vjs.zencdn.net/v/oceans.mp4" type="video/mp4">
          </video>
        </vjs-video-container>
      </div>
      <div class="col-md-6">
        <vjs-video-container id="video-right" vjs-ratio="16:9" vjs-media="mediaToggle">
          <video class="video-js vjs-default-skin" controls preload="auto" >
             <source src="http://vjs.zencdn.net/v/oceans.mp4" type="video/mp4">
          </video>
        </vjs-video-container>
      </div>
    </div>
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
          <button type="button" name="button" class="btn btn-secondary" ng-click="editorRewind()">
            <i class="fa fa-backward" aria-hidden="true"></i> Rewind
          </button>
          <button type="button" name="button" class="btn btn-secondary" ng-click="editorForward()">
            <i class="fa fa-forward" aria-hidden="true"></i> Forward
          </button>
        </div>

        <button type="button" name="button" class="btn btn-secondary">
          <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Add Note
        </button>

        <button type="button" name="button" class="btn btn-secondary disabled">
          <i class="fa fa-save" aria-hidden="true"></i> Save
        </button>

        <button type="button" name="button" class="btn btn-secondary disabled">
          <i class="fa fa-share-square-o" aria-hidden="true"></i> Share
        </button>
      </div>
    </div>
  </div>
@endsection
@section('scripts')
   <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
   <link href="http://vjs.zencdn.net/5.8.8/video-js.css" rel="stylesheet">
   <script src="http://vjs.zencdn.net/5.8.8/video.js"></script>
   <script src="//raw.githubusercontent.com/LonnyGomes/vjs-video/master/dist/vjs-video.js"></script>

   <script type="text/javascript">

   // Define the video controller
   angular.module('videoCtrl', ['vjs.video'])
     .controller('videoController', ['$scope', function ($scope) {
           //listen for when the vjs-media object changes
           $scope.$on('vjsVideoReady', function (e, videoData) {

               $scope.editorPlay = function() {
                 console.log(videoData);
                 videoData.player.trigger('loadstart');
                 videoData.player.play();
               };

               $scope.editorPause = function() {
                 videoData.player.pause();
               };

               $scope.editorStop = function() {
                 videoData.player.pause();
                 videoData.player.currentTime(0);
               }

               $scope.editorRewind = function() {
                 videoData.player.pause();
                 var now = videoData.player.currentTime();
                 videoData.player.currentTime(now - 2);
               }

               $scope.editorForward = function() {
                 videoData.player.pause();
                 var now = videoData.player.currentTime();
                 videoData.player.currentTime(now + 2);
               }

               videoData.player.on('timeupdate', function () {
                 var time = {
                   time: this.currentTime()
                 };
                 $scope.$broadcast('editorPlay', time);
               });
             //}
           });
       }]);


   // Define the Application
   var App =
   angular.module('App', [
             'videoCtrl',
           ])
           .constant("CSRF_TOKEN", '{{ csrf_token() }}');
   </script>
@endsection
