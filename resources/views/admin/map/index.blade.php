@extends('layouts.admin')
@section('title', 'Map Settings')
@section('page-title', 'Map Settings')
@section('stylesheets')
  <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="//ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.js"></script>
  <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular.min.js"></script>
  <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular-animate.min.js"></script>
  <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular-aria.min.js"></script>
  <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular-messages.min.js"></script>
  <script src="//maps.googleapis.com/maps/api/js?key=AIzaSyBMuYp_fLHyQ-vkDFpJzLdS6WoU_uYSBHs"
  async defer></script>
  <style media="screen">
    #map {
      height: 100%;
    }

    .map__container {
      height: 400px;
    }
  </style>
@endsection
@section('content')
<div class="clearfix" ng-app="pointsApp" ng-controller="mainController" ng-cloak>
  <div class="row">
    <div class="col-md-8 map__container">
      <div id="map"></div>
    </div>
    <div class="col-md-4">
      <h3 class="bg-faded p-3">Select City</h3>
      <div class="collapse navbar-collapse d-block" id="navbarSupportedContent">
        <ul class="nav flex-column" ng-repeat="city in cities">
          <li class="nav-item d-block">
            <a href="#" class="nav-link" ng-click="setMapCenter(city.id, 'cities')">@{{ city.name }}</a>
          </li>
        </ul>
      </div>
    </div>
  </div>
  <div class="row mt-4">
    <div class="col-md-8 w-100">
      <h3 class="bg-faded p-3">Points</h3>
      <button type="button" name="button" class="btn btn-success mt-3 mb-3" data-toggle="modal" data-target="#mapCreate">
        <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Add
      </button>

      <div class="modal fade" id="mapCreate" tabindex="-1" role="dialog" aria-labelledby="mapCreateTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <form ng-submit="submitPoint()" method="post">
              {{ csrf_field() }}
              {{ method_field('post') }}
              <div class="modal-header">
                <h5 class="modal-title" id="mapCreateTitle">Add New Point</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <h3 class="bg-faded p-3">Title</h3>
                <div class="form-group">
                  <input type="text" name="name" class="form-control" ng-model="pointData.title">
                </div>
                <h3 class="bg-faded p-3">Location</h3>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="lat">Lat</label>
                      <input type="text" name="lat" ng-model="pointData.lat" class="form-control">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="lng">Long</label>
                      <input type="text" name="lng" ng-model="pointData.lng" class="form-control">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="city_id">City</label>
                      <select class="form-control" name="city_id" ng-model="pointData.city_id">
                        <option ng-repeat="city in cities" value="@{{ city.id }}">@{{ city.name }}</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                        <label for="place_name">POI name</label>
                        <input type="text" name="place_name" ng-model="pointData.place_name" class="form-control">
                    </div>
                  </div>
                </div>
                <h3 class="bg-faded p-3">Film Informations</h3>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="genre">Genre</label>
                      <input type="text" name="genre" ng-model="pointData.genre" class="form-control">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="director">Director</label>
                      <input type="text" name="director" ng-model="pointData.director" class="form-control">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="actors">Actors</label>
                  <input type="text" name="actors" ng-model="pointData.actors" class="form-control">
                </div>
                <div class="form-group">
                  <label for="video_link">Url Video</label>
                  <input type="text" name="video_link" ng-model="pointData.video_link" class="form-control">
                </div>
                <div class="form-group">
                  <label for="sinossi">Sinossi</label>
                  <textarea name="sinossi" ng-model="pointData.sinossi" rows="8" class="form-control"></textarea>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-trash" aria-hidden="true"></i> Close</button>
                <button type="submit" class="btn btn-success"><i class="fa fa-save" aria-hidden="true"></i> Save</button>
              </div>
            </form>
          </div>
        </div>
      </div>

      <table class="table table-hover">
        <thead>
          <th>Id</th>
          <th>Name</th>
          <th>City</th>
          <th>Tools</th>
        </thead>
        <tbody>
          <tr ng-repeat="point in points">
            <td class="align-middle w-25">@{{ point.id }}</td>
            <td class="align-middle w-25">@{{ point.title }}</td>
            <td class="align-middle w-25">@{{ point.city_nome }}</td>
            <td class="align-middle w-25">
              <div class="btn-group">
                {{-- View Tool --}}
                <button class="btn btn-md btn-warning" ng-click="setMapCenter(point.id, 'points')"><i class="fa fa-eye" aria-hidden="true"></i> View</button>
                {{-- Edit Tool --}}
                <button class="btn btn-md btn-info" data-toggle="modal" data-target="#pointEdit" ng-click="getPoint(point.id)"><i class="fa fa-edit" aria-hidden="true"></i> Edit</button>
                {{-- Delete Tool --}}
                <button class="btn btn-md btn-danger" ng-click="deletePoint(point.id)"><i class="fa fa-trash" aria-hidden="true"></i> Delete</button>

                <div class="modal fade" id="pointEdit" tabindex="-1" role="dialog" aria-labelledby="pointEditTitle" aria-hidden="true">
                  <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                      <form ng-submit="editPoint(pointData.id)" method="put">
                        {{ csrf_field() }}
                        {{ method_field('put') }}
                        <div class="modal-header">
                          <h5 class="modal-title" id="pointEditTitle">Edit Point</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <h3 class="bg-faded p-3">Title</h3>
                          <p>@{{ point.title }}</p>
                          <div class="form-group">
                            <input type="text" name="title" ng-model="pointData.title" class="form-control">
                          </div>
                          <h3 class="bg-faded p-3">Location</h3>
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <p>@{{ point.lat }}</p>
                                <label for="lat">Lat</label>
                                <input type="text" name="lat" ng-model="pointData.lat" class="form-control">
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="lng">Long</label>
                                <input type="text" name="lng" ng-model="pointData.lng" class="form-control">
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="city_id">City</label>
                                <select class="form-control" name="city_id" ng-model="pointData.city_id">
                                  <option ng-repeat="city in cities" value="@{{ city.id }}">@{{ city.name }}</option>
                                </select>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                  <label for="place_name">POI name</label>
                                  <input type="text" name="place_name" ng-model="pointData.place_name" class="form-control">
                              </div>
                            </div>
                          </div>
                          <h3 class="bg-faded p-3">Film Informations</h3>
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="genre">Genre</label>
                                <input type="text" name="genre" ng-model="pointData.genre" class="form-control">
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="director">Director</label>
                                <input type="text" name="director" ng-model="pointData.director" class="form-control">
                              </div>
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="actors">Actors</label>
                            <input type="text" name="actors" ng-model="pointData.actors" class="form-control">
                          </div>
                          <div class="form-group">
                            <label for="video_link">Url Video</label>
                            <input type="text" name="video_link" ng-model="pointData.video_link" class="form-control">
                          </div>
                          <div class="form-group">
                            <label for="sinossi">Sinossi</label>
                            <textarea name="sinossi" ng-model="pointData.sinossi" rows="8" class="form-control"></textarea>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-trash" aria-hidden="true"></i> Close</button>
                          <button type="submit" class="btn btn-success"><i class="fa fa-save" aria-hidden="true"></i> Save</button>
                        </div>
                      </form>
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
</div>
@endsection
@section('scripts')
  <script type="text/javascript">
    // Define the service
    angular.module('mapService', [])
            .factory('Point', function($http, CSRF_TOKEN){
              // Get all the category
              return {
                get : function()
                {
                  return $http.get('{{ route('api.map.index') }}');
                },

                save : function(point)
                {
                  return $http({
                    method: 'POST',
                    url: '{{ route('api.map.store') }}',
                    data: $.param(point),
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                  });
                },

                update : function (point, id)
                {
                  return $http({
                    method: 'PUT',
                    url: '{{ route('api.map.index') }}/'+id,
                    data: $.param(point),
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                  });
                },

                delete : function (id)
                {
                  return $http({
                    method: 'DELETE',
                    url: '{{ route('api.map.index') }}/'+id
                  });
                }
              }
            });

    // Define the controller
    angular.module('mainCtrl', [])
            .controller('mainController', function($scope, $http, Point) {
              // models
              $scope.map; // Initialize map
              $scope.pointData = {} // Initialize the object
              // Sorting Table
              $scope.sortType     = 'id'; // set the default sort type
              $scope.sortReverse  = false;
              $scope.marker;
              $scope.lat;
              $scope.lng;

              // get function from factory of the Point service
              Point.get().then(function(response) {
                  $scope.cities = response.data.cities;
                  $scope.points = response.data.points;
                  $scope.points_city = response.data.points_city;
                  generateMap();
                });
              function generateMap ()
              {
                  // Create a map object and specify the DOM element for display.
                  $scope.map = new google.maps.Map(document.getElementById('map'), {
                    center: {lat: 45.464167, lng: 9.190027},
                    scrollwheel: false,
                    zoom: 14,
                    disableDefaultUI: true,
                    zoomControl: true,
                    streetViewControl: false,
                    mapTypeControlOptions: {
                      mapTypeIds: ['roadmap']
                    }
                  });

                  $scope.map.setOptions({
                    styles: [
                      // Hide Features
                      {
                        featureType: 'poi.business',
                        stylers: [{visibility: 'off'}]
                      },
                      {
                        featureType: 'transit',
                        elementType: 'labels.icon',
                        stylers: [{visibility: 'off'}]
                      },
                      {
                        featureType: 'road.arterial',
                        elementType: 'labels.icon',
                        stylers: [{visibility: 'off'}]
                      },
                      {
                        featureType: 'road.highway',
                        elementType: 'labels.icon',
                        stylers: [{visibility: 'off'}]
                      },
                    ]
                  });

                  angular.forEach($scope.points, function(point, key){
                    var marker = new google.maps.Marker({
                        position: {lat: point.lat, lng: point.lng},
                        map: $scope.map
                      });
                  });

                  function placeMarker(location) {
                    if ( marker ) {
                      marker.setPosition(location);
                    } else {
                      var marker = new google.maps.Marker({
                        position: location,
                        map: $scope.map
                      });
                    }
                  }

                  google.maps.event.addListener($scope.map, 'click', function(event) {
                    $scope.pointData.lat = event.latLng.lat();
                    $scope.pointData.lng = event.latLng.lng();
                    placeMarker(event.latLng);
                    $('#mapCreate').modal('show');
                  });

              }

              $scope.setMapCenter = function (id, type)
              {
                if (type == 'cities') {
                  console.log($scope.cities);
                  angular.forEach($scope.cities, function (city, key)
                  {
                    console.log(parsefloat(city.lng));
                    if (city.id == id) {
                      $scope.map.setZoom(14);
                      var _lat = parsefloat(city.lat);
                      var _lng = parsefloat(city.lng)
                      $scope.map.setCenter({lat: city.lat, lng: city.lng});
                    }
                  });
                }
                if (type == 'points') {
                  angular.forEach($scope.points, function (point, key)
                  {
                    if (point.id == id) {
                      $scope.map.setZoom(14);
                      $scope.map.setCenter({lat: point.lat, lng: point.lng});
                    }
                  });
                }
              }

              // Create new point
              $scope.submitPoint = function ()
              {
                  console.log($scope.pointData);
                  Point.save($scope.pointData)
                          .then(function successCallback(response) {
                            jQuery(function() {
                              jQuery('#mapCreate').modal('hide');
                            });
                            Point.get().then(function(response) {
                              $scope.cities = response.data.cities;
                              $scope.points = response.data.points;
                              generateMap();
                            });
                          }, function errorCallback(response) {
                            console.log(response);
                          });
              };

              // Get Point with id
              $scope.getPoint = function (id)
              {
                $http.get('{{ route('api.map.index') }}/'+id+'/edit')
                  .then(function(response) {
                    console.log(response.data);
                    $scope.pointData = response.data.point;
                    $scope.cities = response.data.cities;
                  });
              }

              // Edit Point
              $scope.editPoint = function (id)
              {
                console.log($scope.pointData);
                Point.update($scope.pointData, id)
                    .then(
                      function successCallback(response)
                      {
                        jQuery(function() {
                         jQuery('#pointEdit').modal('hide');
                        });
                         Point.get().then(function (response) {
                           $scope.cities = response.data.cities;
                           $scope.points = response.data.points;
                           $scope.points_city = response.data.points_city;
                           generateMap();
                         });
                      },
                      function errorCallback(response)
                      {
                       console.log(response);
                      }
                    );
              }

              // Delete Point
              $scope.deletePoint = function (id)
              {
                  console.log(id);
                  Point.delete(id)
                       .then(
                         function successCallback(response)
                         {
                            Point.get().then(function (response) {
                              $scope.cities = response.data.cities;
                              $scope.points = response.data.points;
                              $scope.points_city = response.data.points_city;
                              generateMap();
                            });
                         },
                         function errorCallback(response)
                         {
                          console.log(response);
                         }
                       );
              }

            });

    // Define the Application
    var pointsApp =
    angular.module('pointsApp', [
              'mainCtrl',
              'mapService',
            ])
            .constant("CSRF_TOKEN", '{{ csrf_token() }}');
  </script>
@endsection
