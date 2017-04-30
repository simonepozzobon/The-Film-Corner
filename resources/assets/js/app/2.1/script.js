import angular from 'angular';

// // Video Playe Videogular
// require('videogular/dist/videogular/videogular.js');
// require('videogular/dist/controls/vg-controls.js');
// require('videogular/dist/poster/vg-poster.js');
// require('videogular-overlay-play');
// require('videogular-buffering');

// VideoJS
require('video.js/dist/video.js');

// Angular VideoJS
require('vjs-video/dist/vjs-video.js');

// dropzone
require('dropzone/dist/dropzone.js');

// Angular Media Timeline
require('angular-media-timeline/timeline.js')

'use strict';

// Define the service
angular.module('appService', [])
  .factory('Video', function($http, CSRF_TOKEN){

    // Get all the category
    return {
      get : function() {
        return $http.get('test/api');
      },

      save : function(videoData) {
          return $http({
            method: 'POST',
            url: '', //url: "{{ route('categories.index') }}",
            data: $.param(videoData),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
          });
      },

      destroy : function(id) {
          return $http({
            method: 'DELETE',
            url: '' //url: "{{ route('categories.index') }}/"+id
          });
      }



    }
  }).factory('Timeline', function(){
    var timelines = [];
    return {

      getTimelines: function() {
        return timelines;
      },

      addTimeline: function (timeline) {
        timelines.push(timeline);
      },

      tToS: function (t) {
        var s = t * 5 / 100;
        return s;
      }

    }
  });

// Define the controller
angular.module('mainCtrl', [])
  .controller('mainController', function($scope, $http, Video) {
    // models
    $scope.videoData = {} // Initialize the object

    // get function from factory of the Video service
    // Video.get().then(function(response) {
    //     $scope.categories = response.data;
    //   });

  });

// Define the video controller
angular.module('videoCtrl', ['vjs.video'])
  .controller('videoController', ['$scope', 'Timeline', function ($scope, Timeline) {

        $scope.mediaToggle = {
            sources: [
                {
                    src: 'http://static.videogular.com/assets/videos/videogular.mp4',
                    type: 'video/mp4'
                }
            ],
        };

        $scope.$on('timelineChanged', function(e, timeline) {
          console.log(timeline);
        });

        //listen for when the vjs-media object changes
        $scope.$on('vjsVideoReady', function (e, videoData) {
          if (videoData.player.id() == 'vjs_video_3') {

            $scope.editorPlay = function() {
              videoData.player.play();
            };

            $scope.editorPause = function() {
              videoData.player.pause();
            };

            $scope.editorStop = function() {
              videoData.player.pause();
              videoData.player.currentTime(0);
            }

            videoData.player.on('timeupdate', function () {
              var time = {
                time: this.currentTime()
              };
              $scope.$broadcast('editorPlay', time);
            });
          }
        });
    }]);

angular.module('mediaTimelineCtrl', ['mt.media-timeline'])
    .controller('DemoMediaTimelineController', function ($scope, Timeline) {
    $scope.tick = 0;
    $scope.disable = false;
    $scope.timelines = Timeline.getTimelines();

    $scope.$on('editorPlay', function(e, data) {
      $scope.$apply(function() {
        $scope.tick = data.time * 100 / 5;
      });
    });

    $scope.onTickChange = function (tick) {
      console.log(tick);
    };

    // $scope.onPointMove = function (timelineData, eventData, pointData, newTick) {
    //   console.log('onPointMove');
    //   console.log(timelineData);
    //   console.log(eventData);
    //   console.log(pointData);
    //   console.log(newTick);
    //   console.log('------');
    // };

    // $scope.onPointClick = function (timelineData, eventData, pointData) {
    //   console.log('onPointClick');
    //   console.log(timelineData);
    //   console.log(eventData);
    //   console.log(pointData);
    //   console.log('------');
    // };

    // $scope.onMultiplePointEventSelected = function (timelineData, eventData) {
    //   console.log('onMultiplePointEventSelected');
    //   console.log(timelineData);
    //   console.log(eventData);
    //   console.log('------');
    // };

    $scope.onEventStartChange = function (timelineData, eventData, newStartTick) {
      // convert tick to s
      var newStartTime = Timeline.tToS(newStartTick);
      var data = {
        timelineData: timelineData,
        eventData:    eventData,
        newStartTime: newStartTime,
        newStartTick: newStartTick
      };
      $scope.$emit('timelineChanged', data);
    };

    $scope.onEventDurationChange = function (timelineData, eventData, newDuration) {
      // convert tick to s
      var newDurationS = Timeline.tToS(newDuration);
      var data = {
        timelineData: timelineData,
        eventData:    eventData,
        newDuration:  newDuration,
        newDurationS: newDurationS
      };
      $scope.$emit('timelineChanged', data);
    };

    // $scope.onEventClick = function (timelineData, eventData){
    //   console.log('onEventClick');
    //   console.log(timelineData);
    //   console.log(eventData);
    //   console.log('------');
    // };

    $scope.changeTick = function (ticks){
      $scope.tick = ticks;
    };


    });

angular.module('toolCtrl', [])
  .controller('toolController', function($scope, Timeline) {
    $scope.addElement = function(id, title, duration, url) {
      var d = (duration * 100) / 5;
      var timeline = {
        name: title,
        data: { id : title+'-guid' },
        lines: [{
          events: [{
            name: 'animation'+id,
            data : { id : 'animation'+id+'-guid' },
            start : 0,
            duration : d
          }]
        }],
        video_url: url,
      }
      Timeline.addTimeline(timeline);
      $scope.$emit('timelineChanged', timeline);
    }
  });


// Define the Application
var App =
angular.module('App', [
          'mainCtrl',
          'videoCtrl',
          'mediaTimelineCtrl',
          'toolCtrl',
          'appService',
        ])
        .constant("CSRF_TOKEN", '{{ csrf_token() }}');
