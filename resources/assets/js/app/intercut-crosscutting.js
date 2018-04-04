import angular from 'angular'

import $ from 'jquery'

// VideoJS
require('video.js/dist/video.js')

// Angular VideoJS
require('vjs-video/dist/vjs-video.js')

// dropzone
// require('dropzone/dist/dropzone.js');

// Angular Media Timeline
require('angular-media-timeline/timeline.js')

'use strict'

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
        })
      }
    }
  })
  .factory('Video', function($http, CSRF_TOKEN, Timeline){

    return {
      send : function(timelines, counter) {
        var media = []

        //check if timelines has a lenght
        for (var i = 0; i < timelines.length; i++) {
          var edit = {
            session:    timelines[i].session,
            file:       timelines[i].file,
            id:         timelines[i].id,
            media_url:  timelines[i].media_url,
            start:      timelines[i].lines[0].events[0].start,
            duration:   timelines[i].lines[0].events[0].duration,
          }
          media.push(edit)
        }

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
            }
            Timeline.addTimeline(timeline)
          }
        }


        return $http({
          method: 'POST',
          url: '/api/v1/video-edit', //url: "{{ route('categories.index') }}",
          data: media,
        })
      },
    }
  }).factory('Timeline', function(){
    var timelines = []
    var k = []
    return {

      getTimelines: function ($scope) {

        // Verifico se c'è un oggetto all'inizio
        var lenght = null
        var start = false
        for (var i = 0; i < timelines.length; i++) {
          if (timelines[i].lines[0].events[0].start == 0) {
            start = true
          }
          lenght = i+1
        }

        // prendo l'inizio
        if (lenght > 0) {

          var distance = timelines[0].lines[0].events[0].start

          for (var i = 0; i < timelines.length; i++) {
            if (timelines[i].lines[0].events[0].start < distance) {
              distance = timelines[i].lines[0].events[0].start
            }
          }
          $scope.$broadcast('startReset', distance)
        }

        return timelines
      },

      // getTimelinesOrdered: function() {
      // // ordino gli oggetti nella timeline
      // var timelinesOrdered = timelines.sort((a,b) => a.lines[0].events[0].start - b.lines[0].events[0].start);
      // return timelinesOrdered;
      // },

      addTimeline: function (timeline) {
        timelines.push(timeline)
      },

      // Convert ticks on seconds
      tToS: function (t) {
        var s = t * 5 / 100
        return s
      },

      // getCurrentPos: function () {
      // }
    }
  })

// Define the controller
angular.module('mainCtrl', [])
  .controller('mainController', function($scope, $http, Video) {
    // models
    $scope.videoData = {} // Initialize the object

    // get function from factory of the Video service
    // Video.get().then(function(response) {
    //     $scope.categories = response.data;
    //   });

  })


// Define the upload Controller
angular.module('uploadCtrl', [])
  .controller('uploadController', ['$scope', '$window', '$compile', function($scope, $window, $compile, $http, Video) {
    // models
    var element = $window.document.getElementById('upload-assets')
    element.addEventListener('new-video-on-library', function(e) {
      var data = $(e.detail).appendTo('#upload-assets')
      $compile(data)($scope)
      $scope.$apply()
    })
  }])

// Define the video controller
angular.module('videoCtrl', ['vjs.video'])
  .controller('videoController', ['$scope', '$window', 'Timeline', 'Video', function ($scope, $window, Timeline, Video) {

    // Inizializzo la sessione
    var init = $window.timelines
    // console.log(init)
    var counter = 0

    if (typeof session == 'undefined' && typeof init != 'undefined') {

      // Rigenera Il video
      Video.send(init, counter).then(function successCallback(response) {
        localStorage.setItem('app-'+response.data.app+'-video')
        $scope.mediaToggle = {
          sources: [
            {
              src: '/'+response.data.export,
              type: 'video/mp4'
            }
          ]
        }
        counter = 1
      })

    }


    $scope.$on('timelineChanged', function(e, timeline) {
      // console.log('-----')
      // console.log('timelineChanged Event Before Send')
      // console.log(timeline)
      // console.log('-----')

      var timelines = Timeline.getTimelines($scope)
      // if (typeof session == 'undefined') {
      //   console.log('non trovata la sessions');
      //   timelines = $window.timelines;
      // }
      Video.send(timelines).then(function successCallback(response) {
        // console.log(timelines)
        // console.log('-------')
        // console.log('DEBUG')
        // console.log(response)
        // console.log('-------')
        localStorage.setItem('app-'+response.data.app+'-video', response.data.export)
        // localStorage.setItem('tfc-video-editing', '/'+response.data.export)
        $scope.mediaToggle = {
          sources: [
            {
              src: '/'+response.data.export,
              type: 'video/mp4'
            }
          ]
        }
      })
    })

    //listen for when the vjs-media object changes
    $scope.$on('vjsVideoReady', function (e, videoData) {

      // if (videoData.player.id() == 'vjs_video_3') {
      $scope.editorPlay = function() {
        videoData.player.trigger('loadstart')
        var media = Timeline.getTimelines($scope)
        videoData.player.play()
      }

      $scope.editorPause = function() {
        videoData.player.pause()
      }

      $scope.editorStop = function() {
        videoData.player.pause()
        videoData.player.currentTime(0)
      }

      $scope.editorRewind = function() {
        videoData.player.pause()
        var now = videoData.player.currentTime()
        videoData.player.currentTime(now - 2)
      }

      $scope.editorForward = function() {
        videoData.player.pause()
        var now = videoData.player.currentTime()
        videoData.player.currentTime(now + 2)
      }

      videoData.player.on('timeupdate', function () {
        var time = {
          time: this.currentTime()
        }
        $scope.$broadcast('editorPlay', time)
      })
      //}
    })
  }])

angular.module('mediaTimelineCtrl', ['mt.media-timeline'])
  .controller('DemoMediaTimelineController', function ($scope, Timeline) {
    $scope.tick = 0
    $scope.disable = false
    $scope.timelines = Timeline.getTimelines($scope)

    // this force start always from the first position
    $scope.$on('startReset', function(e, distance) {
      $scope.$apply(function() {
        $scope.tick = distance
      })
    })

    $scope.$on('editorPlay', function(e, data) {
      $scope.$apply(function() {
        $scope.tick = data.time * 100 / 5
      })
    })

    $scope.onTickChange = function (tick) {
      // console.log(tick)
    }

    $scope.onEventStartChange = function (timelineData, eventData, newStartTick) {
      // convert tick to s
      var newStartTime = Timeline.tToS(newStartTick)
      var data = {
        timelineData: timelineData,
        eventData:    eventData,
        newStartTime: newStartTime,
        newStartTick: newStartTick
      }
      Timeline.getTimelines($scope)
      $scope.$emit('timelineChanged', data)
    }

    $scope.onEventDurationChange = function (timelineData, eventData, newDuration) {
      // convert tick to s
      var newDurationS = Timeline.tToS(newDuration)
      var data = {
        timelineData: timelineData,
        eventData:    eventData,
        newDuration:  newDuration,
        newDurationS: newDurationS
      }
      $scope.$emit('timelineChanged', data)
    }

    $scope.changeTick = function (ticks){
      $scope.tick = ticks
    }


  })

angular.module('toolCtrl', [])
  .controller('toolController', function($scope, $window, Timeline) {

    // Aggiunge un elemento dalla libreria alla timeline
    $scope.addElement = function(id, title, duration, url) {
      // console.log('addding element to angularjs')
      console.log(id)
      console.log(title)
      console.log(duration)
      console.log(url)
      var d = (duration * 100) / 5
      if (typeof session == 'undefined') {
        // console.log('non trovata')
        var token = $window.token
      } else {
        var token = session.token
      }

      var expPath = 'storage/video/sessions/'+token+'/tfc_video_session.mp4'
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
      }
      Timeline.addTimeline(timeline)
      Timeline.getTimelines($scope)
      $scope.$emit('timelineChanged', timeline)
    }
  })

angular.module('feedbackCtrl', [])
  .controller('feedbackController', function($scope, $http, Feedback){
    $scope.feedbackData = {}

    $scope.setPositive = function() {
      $scope.feedbackData.status = 'positive'
    }

    $scope.setNegative = function() {
      $scope.feedbackData.status = 'negative'
    }

    $scope.sendFeedback = function() {
      // console.log($scope.feedbackData)
      Feedback.send($scope.feedbackData)
    }

  })


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
  .constant('CSRF_TOKEN', '{{ csrf_token() }}')
