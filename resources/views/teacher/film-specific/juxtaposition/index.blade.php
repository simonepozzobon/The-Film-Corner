@extends('layouts.teacher', ['type' => 'app'])
@section('content')
  @include('components.apps.sidebar-menu', ['app' => $app, ])
  <div class="p-5">
  </div>
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
    <div id="app" class="col-12 px-5 d-inline-block float-left">
      <div class="row" style="background-color: {{ $app->colors[1] }}; color: #252525">
        <div class="col">
          <div class="d-flex justify-content-start">
            <div class="mr-auto"><h3 class="ml-2 pt-4 pb-1">{{ $app->title }}</h3></div>
          </div>
        </div>
      </div>
      <div class="row" style="background-color: {{ $app->colors[0] }}; color: #252525">
        <div class="col">
          <div class="clearfix p-5" ng-app="App" ng-cloak ng-controller="videoController">
            <div class="row">
              <div class="col-md-6">
                <video id="video-left" class="video-js vjs-default-skin" controls preload="auto" aspect-ratio="16:9" vjs-video>
                    <source src="http://vjs.zencdn.net/v/oceans.mp4" type="video/mp4">
                </video>
              </div>
              <div class="col-md-6">
                <video id="video-right" class="video-js vjs-default-skin" controls preload="auto" aspect-ratio="16:9" vjs-video>
                    <source src="http://vjs.zencdn.net/v/oceans.mp4" type="video/mp4">
                </video>
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
        </div>
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
