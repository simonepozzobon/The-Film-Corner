import angular from 'angular';

// Video Playe Videogular
require('videogular/dist/videogular/videogular.js');
require('videogular/dist/controls/vg-controls.js');
require('videogular/dist/poster/vg-poster.js');
require('videogular-overlay-play');
require('videogular-buffering');

// Angular Media Timeline
require('angular-media-timeline/timeline.js')

'use strict';

// Define the service
angular.module('appService', [])
  .factory('Category', function($http, CSRF_TOKEN){
    // Get all the category
    return {
      get : function() {
        return $http.get('test/api');
      },

      save : function(categoryData) {
          return $http({
            method: 'POST',
            url: '', //url: "{{ route('categories.index') }}",
            data: $.param(categoryData),
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
  });

// Define the controller
angular.module('mainCtrl', [])
  .controller('mainController', function($scope, $http, Category) {
    // models
    $scope.categoryData = {} // Initialize the object

    // get function from factory of the Category service
    // Category.get().then(function(response) {
    //     $scope.categories = response.data;
    //   });

  });

// Define the video controller
angular.module('videoCtrl', [
    "ngSanitize",
    "com.2fdevs.videogular",
    "com.2fdevs.videogular.plugins.controls",
    "com.2fdevs.videogular.plugins.overlayplay",
    "com.2fdevs.videogular.plugins.poster"
  ])
  .controller('videoController', ["$sce", function ($sce) {
			this.config = {
				sources: [
					{src: $sce.trustAsResourceUrl("http://static.videogular.com/assets/videos/videogular.mp4"), type: "video/mp4"},
					{src: $sce.trustAsResourceUrl("http://static.videogular.com/assets/videos/videogular.webm"), type: "video/webm"},
					{src: $sce.trustAsResourceUrl("http://static.videogular.com/assets/videos/videogular.ogg"), type: "video/ogg"}
				],
				tracks: [
					{
						src: "http://www.videogular.com/assets/subs/pale-blue-dot.vtt",
						kind: "subtitles",
						srclang: "en",
						label: "English",
						default: "true"
					}
				],
				theme: "css/app/2.1/style.css",
				plugins: {
					poster: "http://www.videogular.com/assets/images/videogular.png"
				}
			};
      console.log($sce);
		}]
  );

angular.module('mt.demo', ['mt.media-timeline'])
    .controller('DemoMediaTimelineController', function ($scope) {
    $scope.tick = 200;
    $scope.disable = false;
    $scope.addTimeline = function () {
      var timeline = {
            name : 'timeline2-name',
            data : { id : 'timeline2-guid' },
            lines : [
                {
                  events :
                  [
                    {
                      name : 'animation3',
                      data : { id : 'animation3-guid' },
                      start : 100,
                      duration : 100
                    },
                    {
                      name : 'animation4',
                      data : { id : 'animation4-guid' },
                      start : 500,
                      duration : 450
                    }
                  ]
                }, {
                  name : 'multiAnimation3',
                  points :
                  [
                    {
                      tick : 10,
                      id : 'guid3',
                    },
                    {
                      tick : 210,
                      id : 'guid4',
                    }
                  ]
                }
              ]
            };
      $scope.timelines.push(timeline);
    };

    $scope.timelines =
        [
          {
            name : 'timeline2-name',
            data : { id : 'timeline2-guid' },
            lines : [
                {
                  events :
                  [
                    {
                      name : 'animation3',
                      data : { id : 'animation3-guid' },
                      start : 100,
                      duration : 100
                    },
                    {
                      name : 'animation4',
                      data : { id : 'animation4-guid' },
                      start : 500,
                      duration : 450
                    }
                  ]
                }, {
                  name : 'multiAnimation3',
                  points :
                  [
                    {
                      tick : 10,
                      id : 'guid3',
                    },
                    {
                      tick : 210,
                      id : 'guid4',
                    }
                  ]
                }
              ]
          }
        ];

      $scope.onTickChange = function (tick) {
        console.log(tick);
      };

      $scope.onPointMove = function (timelineData, eventData, pointData, newTick) {
        console.log('onPointMove');
        console.log(timelineData);
        console.log(eventData);
        console.log(pointData);
        console.log(newTick);
        console.log('------');
      };

      $scope.onPointClick = function (timelineData, eventData, pointData) {
        console.log('onPointClick');
        console.log(timelineData);
        console.log(eventData);
        console.log(pointData);
        console.log('------');
      };

      $scope.onMultiplePointEventSelected = function (timelineData, eventData) {
        console.log('onMultiplePointEventSelected');
        console.log(timelineData);
        console.log(eventData);
        console.log('------');
      };

      $scope.onEventStartChange = function (timelineData, eventData, newStartTick) {
        console.log('onEventStartChange');
        console.log(timelineData);
        console.log(eventData);
        console.log(newStartTick);
        console.log('------');
      };

      $scope.onEventDurationChange = function (timelineData, eventData, newDuration) {
        console.log('onEventDurationChange');
        console.log(timelineData);
        console.log(eventData);
        console.log(newDuration);
        console.log('------');
      };

      $scope.onEventClick = function (timelineData, eventData){
        console.log('onEventClick');
        console.log(timelineData);
        console.log(eventData);
        console.log('------');
      };

      $scope.changeTick = function (){
        $scope.tick = 100;
      };
    });

// Define the Application
var App =
angular.module('App', [
          'mainCtrl',
          'videoCtrl',
          'mt.demo',
          'appService',
        ])
        .constant("CSRF_TOKEN", '{{ csrf_token() }}');
