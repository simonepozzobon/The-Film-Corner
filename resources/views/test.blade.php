@extends('layouts.admin')
@section('title', 'Angular Test')
@section('page-title', 'Angular Test')
@section('stylesheets')
  <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/angular_material/1.1.0/angular-material.min.css">


  <script src="//ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.js"></script>
  <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular.min.js"></script>
  <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular-animate.min.js"></script>
  <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular-aria.min.js"></script>
  <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular-messages.min.js"></script>

  <!-- Angular Material Library -->
  <script src="//ajax.googleapis.com/ajax/libs/angular_material/1.1.0/angular-material.min.js"></script>
@endsection
@section('content')
  <div class="clearfix" ng-app="categoryApp" ng-controller="mainController" ng-cloak>
    <div class="row">
      <div class="col-md-8">
        <table class="table table-hover">
          <thead>
            <th>Id</th>
            <th>Name</th>
            <th>Delete</th>
          </thead>
          <tbody>
            <tr ng-repeat="category in categories">
              <td>/% category.id %/</td>
              <td>/% category.name %/</td>
              <td><a href="" ng-click="deleteCategory(category.id)" class="btn btn-danger">Delete</a></td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="col-md-4">
        <div class="card">
          <h3 class="card-header">New Category</h3>
          <div class="card-block">
            <div class="card-text">
              <form ng-submit="submitCategory()" method="post">
                {{ csrf_field() }}
                <md-input-container class="md-block">
                  <label>Name</label>
                  <input required name="name" class="form-control" ng-model="categoryData.name">
                  <div ng-messages="projectForm.name.$error">
                     <div ng-message="required">This is required.</div>
                  </div>
                </md-input-container>
                <button type="submit" name="button" class="btn btn-primary btn-block">Save</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('scripts')
  <script type="text/javascript">
    // Define the service
    angular.module('categoryService', [])
            .factory('Category', function($http, CSRF_TOKEN){
              // Get all the category
              return {
                get : function() {
                  return $http.get('test/api');
                },

                save : function(categoryData) {
                    return $http({
                      method: 'POST',
                      url: '{{ route('api.categories.store') }}',
                      data: $.param(categoryData),
                      headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                    });
                },

                destroy : function(id) {
                    return $http({
                      method: 'DELETE',
                      url: '{{ route('api.categories.index') }}/'+id
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
              Category.get().then(function(response) {
                  $scope.categories = response.data;
                });

              $scope.submitCategory = function() {
                Category.save($scope.categoryData)
                        .then(function successCallback(response) {
                          Category.get().then(function(response) {
                            $scope.categories = response.data;
                          });
                        }, function errorCallback(response) {
                          console.log(response);
                        });
              };

              $scope.deleteCategory = function(id) {
                console.log(id);
                Category.destroy(id)
                        .then(function successCallback(response) {
                          Category.get().then(function(response) {
                            $scope.categories = response.data;
                          });
                        }, function errorCallback(response) {
                          console.log(response);
                        });
              };

            });

    // Define the Application
    var categoryApp =
    angular.module('categoryApp', [
              'mainCtrl',
              'categoryService',
              'ngMaterial',
            ])
            .constant("CSRF_TOKEN", '{{ csrf_token() }}')
            .config(function($interpolateProvider) {
              $interpolateProvider.startSymbol('/%');
              $interpolateProvider.endSymbol('%/');
            });
  </script>
@endsection
