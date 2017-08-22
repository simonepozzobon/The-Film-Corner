import angular from 'angular';

import jQuery from 'jquery';

// VideoJS
require('video.js/dist/video.js');

// Angular VideoJS
require('vjs-video/dist/vjs-video.js');

// dropzone
// require('dropzone/dist/dropzone.js');

// Angular Media Timeline
require('angular-media-timeline/timeline.js');

'use strict';

// Define the service
angular.module('appService', [])
  .factory('Feedback', function($http, CSRF_TOKEN) {
    return {
      send: function(feedbackData) {
        return $http({
              method: 'POST',
              url: 'feedback/feedback-api',
              data: feedbackData,
              headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        });
      }
    }
  })
  .factory('Video', function($http, CSRF_TOKEN, Timeline){

    return {
      send : function(timelines, counter) {
          var media = [];

          for (var i = 0; i < timelines.length; i++) {
            var edit = {
              session:    timelines[i].session,
              file:       timelines[i].file,
              id:         timelines[i].id,
              media_url:  timelines[i].media_url,
              start:      timelines[i].lines[0].events[0].start,
              duration:   timelines[i].lines[0].events[0].duration,
            }
            media.push(edit);
          }

          // console.log('---------');
          // console.log('Dati da inviare');
          // console.log(media);
          // console.log('---------');

          // Ricompone la timelines
          if (typeof(session) == 'undefined' && counter == 0) {
            for (var i = 0; i < timelines.length; i++) {
              var timeline = {
                session:    timelines[i].session,
                file:       timelines[i].file,
                id:         timelines[i].id,
                name:       timelines[i].name,
                media_url:  timelines[i].media_url,
                data:       { id : timelines[i].data.id },
                lines:  [{
                    events: [{
                        name :      timelines[i].lines[0].events.name,
                        data :      { id : timelines[i].lines[0].events[0].data.id },
                        start :     timelines[i].lines[0].events[0].start,
                        duration :  timelines[i].lines[0].events[0].duration
                    }]
                }]
              };
              Timeline.addTimeline(timeline);
            }
          }


          return $http({
            method: 'POST',
            url: '/video-edit/video-edit-api', //url: "{{ route('categories.index') }}",
            data: media,
          });
      },
    }
  }).factory('Timeline', function(){
    var timelines = [];
    var k = [];
    return {

      getTimelines: function ($scope) {

        // Verifico se c'è un oggetto all'inizio
        var lenght = null;
        var start = false;
        for (var i = 0; i < timelines.length; i++) {
          if (timelines[i].lines[0].events[0].start == 0) {
            start = true;
          }
          lenght = i+1;
        }

        // prendo l'inizio
        if (lenght > 0) {

          var distance = timelines[0].lines[0].events[0].start;

          for (var i = 0; i < timelines.length; i++) {
            if (timelines[i].lines[0].events[0].start < distance) {
              distance = timelines[i].lines[0].events[0].start;
            }
          }
          $scope.$broadcast('startReset', distance);
        }

        return timelines;
      },

      // getTimelinesOrdered: function() {
        // // ordino gli oggetti nella timeline
        // var timelinesOrdered = timelines.sort((a,b) => a.lines[0].events[0].start - b.lines[0].events[0].start);
        // return timelinesOrdered;
      // },

      addTimeline: function (timeline) {
        timelines.push(timeline);
      },

      // Convert ticks on seconds
      tToS: function (t) {
        var s = t * 5 / 100;
        return s;
      },

      // getCurrentPos: function () {
      // }
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


// Define the upload Controller
angular.module('uploadCtrl', [])
  .controller('uploadController', ['$scope', '$window', '$compile', function($scope, $window, $compile, $http, Video) {
    // models


    $scope.uploadForm = function() {
      console.log('---------');
      console.log('Session token');
      console.log($('#token').val());
      console.log('---------');

      // Preparo i dati da inviare sotto forma di form
      var formData = new FormData();
      formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
      formData.append('media', $('#media')[0].files[0]);
      formData.append('session', $('#token').val());

      // prendo il nome della cateogria e lo slug dell'applicazione
      var app_category = $('#app_category').val();
      var app_slug = $('#app_slug').val();

      // effettuo l'invio ajax
      $.ajax({
        type: 'post',
        url:  '/teacher/creative-studio/'+app_category+'/'+app_slug+'/upload',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          console.log(response);
          var data = $('<tr>' +
                          '<td class="align-middle">' +
                            '<img src="'+response.img+'" width="57">' +
                          '</td>' +
                          '<td class="align-middle">'+response.name+'</td>' +
                          '<td class="align-middle" ng-controller="toolController">' +
                            '<div class="btn-group">' +
                              '<button ng-click="addElement(\''+response.video_id+'\',\''+response.name+'\', \''+response.duration+'\', \''+response.src+'\')" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Add To Timeline">' +
                                '<i class="fa fa-plus" aria-hidden="true"></i>' +
                              '</button>' +
                            '</div>' +
                          '</td>' +
                        '</tr>').appendTo('#uploads');

          $compile(data)($scope);
          $scope.$apply();
        },
        error: function (errors) {
          console.log(errors);
        }
      });


      console.log('invio dati');
      console.log($('#media')[0].files[0]);
    }

  }]);

// Define the video controller
angular.module('videoCtrl', ['vjs.video'])
  .controller('videoController', ['$scope', '$window', 'Timeline', 'Video', function ($scope, $window, Timeline, Video) {

    // Inizializzo la sessione
        var init = $window.timelines;
        var counter = 0;

        if (typeof session == 'undefined') {
          // console.log('non trovata');
          // Rigenera Il video
          Video.send(init, counter).then(function successCallback(response) {
            // console.log('-------------');
            // console.log('Init working?');
            // console.log(response);
            // console.log('-------------');
            // Timeline.getTimelines($scope);
            $scope.mediaToggle = {
              sources: [
                {
                  src: '/'+response.data,
                  type: 'video/mp4'
                }
              ]
            };
            counter = 1;
            // console.log('------');
            // console.log('Contatore');
            // console.log(counter);
            // console.log('------');
          });

        }


        $scope.$on('timelineChanged', function(e, timeline) {
          console.log('-----');
          console.log('timelineChanged Event Before Send');
          console.log(timeline);
          console.log('-----');

          var timelines = Timeline.getTimelines($scope);
          
          Video.send(timelines).then(function successCallback(response) {
            console.log(timelines);
            console.log(response.data);
            console.log('-------');
            console.log('DEBUG');
            console.log(response);
            console.log('-------');
            $scope.mediaToggle = {
              sources: [
                {
                  src: '/'+response.data,
                  type: 'video/mp4'
                }
              ]
            }
          });
        });

        //listen for when the vjs-media object changes
        $scope.$on('vjsVideoReady', function (e, videoData) {

          // if (videoData.player.id() == 'vjs_video_3') {
            $scope.editorPlay = function() {
              videoData.player.trigger('loadstart');
              var media = Timeline.getTimelines($scope);
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

angular.module('mediaTimelineCtrl', ['mt.media-timeline'])
    .controller('DemoMediaTimelineController', function ($scope, Timeline) {
    $scope.tick = 0;
    $scope.disable = false;
    $scope.timelines = Timeline.getTimelines($scope);

    // this force start always from the first position
    $scope.$on('startReset', function(e, distance) {
      $scope.$apply(function() {
        $scope.tick = distance;
      });
    });

    $scope.$on('editorPlay', function(e, data) {
      $scope.$apply(function() {
        $scope.tick = data.time * 100 / 5;
      });
    });

    $scope.onTickChange = function (tick) {
      console.log(tick);
    };

    $scope.onEventStartChange = function (timelineData, eventData, newStartTick) {
      // convert tick to s
      var newStartTime = Timeline.tToS(newStartTick);
      var data = {
        timelineData: timelineData,
        eventData:    eventData,
        newStartTime: newStartTime,
        newStartTick: newStartTick
      };
      Timeline.getTimelines($scope);
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

    $scope.changeTick = function (ticks){
      $scope.tick = ticks;
    };


    });

angular.module('toolCtrl', [])
  .controller('toolController', function($scope, Timeline) {

    // Aggiunge un elemento dalla libreria alla timeline
    $scope.addElement = function(id, title, duration, url) {
      var d = (duration * 100) / 5;
      if (typeof session == 'undefined') {
        console.log('non trovata');
        var token = $window.token;
      } else {
        var token = session.token;
      }

      var expPath = 'storage/video/sessions/'+token+'/tfc_video_session.mp4';
      var timeline = {
        session:    token,
        file:       expPath,
        id:         (new Date()).getTime(),
        name:       title,
        media_url:  url,
        data:       { id : title+'-guid' },
        lines:  [{
            events: [{
                name :      'animation'+id,
                data :      { id : 'animation'+id+'-guid' },
                start :     0,
                duration :  d
            }]
        }]
      };
      Timeline.addTimeline(timeline);
      Timeline.getTimelines($scope);
      $scope.$emit('timelineChanged', timeline);
    }
});

angular.module('feedbackCtrl', [])
  .controller('feedbackController', function($scope, $http, Feedback){
    $scope.feedbackData = {};

    $scope.setPositive = function() {
      $scope.feedbackData.status = 'positive';
    };

    $scope.setNegative = function() {
      $scope.feedbackData.status = 'negative';
    }

    $scope.sendFeedback = function() {
      console.log($scope.feedbackData);
      Feedback.send($scope.feedbackData);
    };

});


// Define the Application
var App =
angular.module('App', [
          'mainCtrl',
          'videoCtrl',
          'uploadCtrl',
          'mediaTimelineCtrl',
          'toolCtrl',
          'feedbackCtrl',
          'appService',
        ])
        .constant("CSRF_TOKEN", '{{ csrf_token() }}');
