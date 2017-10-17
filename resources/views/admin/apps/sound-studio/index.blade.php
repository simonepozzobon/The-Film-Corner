@extends('layouts.admin')
@section('title')
  Audio Library
@endsection
@section('page-title')
  Audio Library
@endsection
@section('stylesheets')
  <meta name="csrf-token" content="{{ csrf_token() }}">
  {{-- JQuery --}}
  <script src="{{ asset('/js/jquery-3.2.0.min.js') }}">

  </script>
  {{-- Angular --}}
  <script src="{{ asset('/js/dev-libraries/angular.js') }}"></script>
  <script src="{{ asset('/js/dev-libraries/angular-animate.js') }}"></script>
  <script src="{{ asset('/js/dev-libraries/angular-aria.js') }}"></script>
  <script src="{{ asset('/js/dev-libraries/angular-messages.js') }}"></script>
@endsection
@section('content')
  <div class="clearfix" ng-app="audioLibrary" ng-controller="mainController" ng-cloak>
    <div class="row">
      <div class="col-md-8">
        <div class="container-fluid bg-faded p-4">
          <table class="table table-hover">
            <thead>
              <th>Id</th>
              <th>Title</th>
              <th>Preview</th>
              <th>Duration</th>
              <th>Tools</th>
            </thead>
            <tbody>
                <tr ng-repeat="audio in audios">
                  <td class="align-middle">@{{ audio.id }}</td>
                  <td class="align-middle">@{{ audio.title }}</td>
                  <td class="align-middle">
                    <img ng-src="{{ url('/') }}/storage/@{{ audio.thumb }}" width="57">
                  </td>
                  <td class="align-middle">@{{ audio.duration }}s</td>
                  <td class="align-middle">
                    <div class="btn-group">
                      <button href="#" class="btn btn-danger" ng-click="deleteAudio(audio.id)">
                        <i class="fa fa-trash" aria-hidden="true"></i> Delete
                      </button>
                    </div>
                  </td>
                </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="col-md-4">
        <div class="container-fluid bg-faded p-4">
          <h3>Add Audio</h3>
          <hr>
          <form class="" action="{{ route('app.sound-studio.store') }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            {{ method_field('POST') }}
            <div class="form-group">
              <h5>Title</h5>
              <input type="text" name="title" class="form-control">
            </div>
            <div class="form-group">
              <h5>File</h5>
              <input type="file" name="audio" class="form-control">
            </div>
            <button type="submit" name="button" class="btn btn-primary">
              <i class="fa fa-floppy-o" aria-hidden="true"></i> Send
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('scripts')
  <script type="text/javascript">
  // Define the service
    angular.module('audioService', [])
            .factory('Audio', function($http, CSRF_TOKEN){
              // Get all the category
              return {
                get : function() {
                  return $http.get('{{ route('app.sound-studio.index') }}');
                },

                save : function(audioData) {
                  console.log('cosa sto salvando '+ $.param(audioData));
                    return $http({
                      method: 'POST',
                      url: '{{ route('app.sound-studio.store') }}',
                      data: $.param(audioData),
                      headers: {'Content-Type': 'multipart/form-data'}
                    });
                },

                update : function(audioData, id) {
                  console.log($.param(audioData));
                    return $http({
                      method: 'PUT',
                      url: '{{ route('app.sound-studio.index') }}/'+id,
                      data: $.param(audioData),
                      headers: {'Content-Type': 'multipart/form-data'}
                    });
                },

                destroy : function(id) {
                    return $http({
                      method: 'DELETE',
                      url: 'sound-studio/audio-api-delete/'+id,
                    });
                }
              }
            });

    // Define the controller
    angular.module('mainCtrl', [])
            .controller('mainController', function($scope, $http, Audio) {
              // models
              $scope.audioData = {} // Initialize the object
              // Sorting Table
              $scope.sortType     = 'id'; // set the default sort type
              $scope.sortReverse  = false;

              // get function from factory of the Audio service
              Audio.get().then(function(response) {
                  $scope.audios = response.data.audios;
                  console.log($scope.audios);
                });

              $scope.getFile = function(element) {
                console.log(element);
              };

              $scope.submitAudio = function() {
                $scope.audioData.audio = $scope.param.file;
                Audio.save($scope.audioData).then(function successCallback(response) {
                  Audio.get().then(function(response) {
                    $scope.audios = response.data.audios;
                  });
                }, function errorCallback(response) {
                  console.log('errors '+response);
                });
              };

              $scope.deleteAudio = function(id) {
                Audio.destroy(id).then(function successCallback(response) {
                  Audio.get().then(function(response) {
                    $scope.audios = response.data.audios;
                  });
                }, function errorCallback(response) {
                  console.log('errors '+response);
                });
              }

            });

    // Define the Application
    var audioLibrary =
    angular.module('audioLibrary', [
              'mainCtrl',
              'audioService',
            ])
            .constant("CSRF_TOKEN", '{{ csrf_token() }}');

    audioLibrary.directive('file', function(){
                return {
                    scope: {
                        file: '='
                    },
                    link: function(scope, el, attrs){
                        el.bind('change', function(event){
                            var files = event.target.files;
                            var file = files[0];
                            scope.file = file ? file.name : undefined;
                            scope.$apply();
                        });
                    }
                };
            });
  </script>
@endsection
