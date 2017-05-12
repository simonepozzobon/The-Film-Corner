@extends('layouts.admin')
@section('title')
  Video Library
@endsection
@section('page-title')
  Video Library
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
  <div class="clearfix" ng-app="videoLibraryApp" ng-controller="mainController" ng-cloak>
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
                <tr ng-repeat="video in videos">
                  <td class="align-middle">@{{ video.id }}</td>
                  <td class="align-middle">@{{ video.title }}</td>
                  <td class="align-middle">
                    <img ng-src="{{ url('/') }}/storage/@{{ video.thumb }}" width="57">
                  </td>
                  <td class="align-middle">@{{ video.duration }}s</td>
                  <td class="align-middle">
                    <div class="btn-group">
                      <button href="#" class="btn btn-info" data-toggle="modal" data-target="#editModal">
                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit
                      </button>
                      <button href="#" class="btn btn-danger" ng-click="deleteVideo(video.id)">
                        <i class="fa fa-trash" aria-hidden="true"></i> Delete
                      </button>
                    </div>

                    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">Edit Video</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            ...
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Save changes</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </td>
                </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="col-md-4">
        <div class="container-fluid bg-faded p-4">
          <h3>Add Video</h3>
          <hr>
          <form class="" action="{{ route('video-api-library.store') }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            {{ method_field('POST') }}
            <div class="form-group">
              <h5>Title</h5>
              <input type="text" name="title" class="form-control">
            </div>
            <div class="form-group">
              <h5>File</h5>
              <input type="file" name="video" class="form-control">
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
    angular.module('videoService', [])
            .factory('Video', function($http, CSRF_TOKEN){
              // Get all the category
              return {
                get : function() {
                  return $http.get('{{ route('video-api-library.index') }}');
                },

                save : function(videoData) {
                  console.log('cosa sto salvando '+ $.param(videoData));
                    return $http({
                      method: 'POST',
                      url: '{{ route('video-api-library.store') }}',
                      data: $.param(videoData),
                      headers: {'Content-Type': 'multipart/form-data'}
                    });
                },

                update : function(videoData, id) {
                  console.log($.param(videoData));
                    return $http({
                      method: 'PUT',
                      url: '{{ route('video-api-library.index') }}/'+id,
                      data: $.param(videoData),
                      headers: {'Content-Type': 'multipart/form-data'}
                    });
                },

                destroy : function(id) {
                    return $http({
                      method: 'DELETE',
                      url: '{{ route('video-api-library.index') }}/'+id
                    });
                }
              }
            });

    // Define the controller
    angular.module('mainCtrl', [])
            .controller('mainController', function($scope, $http, Video) {
              // models
              $scope.videoData = {} // Initialize the object
              // Sorting Table
              $scope.sortType     = 'id'; // set the default sort type
              $scope.sortReverse  = false;

              // get function from factory of the Video service
              Video.get().then(function(response) {
                  $scope.videos = response.data.videos;
                  console.log($scope.videos);
                });

              $scope.getFile = function(element) {
                console.log(element);
              };

              $scope.submitVideo = function() {
                $scope.videoData.video = $scope.param.file;
                Video.save($scope.videoData).then(function successCallback(response) {
                  Video.get().then(function(response) {
                    $scope.videos = response.data.videos;
                  });
                }, function errorCallback(response) {
                  console.log('errors '+response);
                });
              };

              $scope.deleteVideo = function(id) {
                Video.destroy(id).then(function successCallback(response) {
                  Video.get().then(function(response) {
                    $scope.videos = response.data.videos;
                  });
                }, function errorCallback(response) {
                  console.log('errors '+response);
                });
              }

            });

    // Define the Application
    var videoLibraryApp =
    angular.module('videoLibraryApp', [
              'mainCtrl',
              'videoService',
            ])
            .constant("CSRF_TOKEN", '{{ csrf_token() }}');

    videoLibraryApp.directive('file', function(){
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
