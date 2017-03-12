@extends('layouts.admin')
@section('title', 'Angular Test')
@section('page-title', 'Angular Test')
@section('stylesheets')
  <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/angular_material/1.1.0/angular-material.min.css">


  <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
  <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular.min.js"></script>
  <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular-animate.min.js"></script>
  <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular-aria.min.js"></script>
  <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular-messages.min.js"></script>

  <!-- Angular Material Library -->
  <script src="//ajax.googleapis.com/ajax/libs/angular_material/1.1.0/angular-material.min.js"></script>
@endsection
@section('content')
  <div class="clearfix" ng-app="adminApp" ng-controller="mainController" ng-cloak>
    <div class="row">
      <div class="col-md-8">
        <table class="table table-hover">
          <thead>
            <th>Id</th>
            <th>Name</th>
          </thead>
          <tbody>
            <tr ng-repeat="admin in admins">
              <td>/% admin.id %/</td>
              <td>/% admin.name %/</td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="col-md-4">
        <md-content layout-padding layout-wrap>
          <md-toolbar>
              <h2 class="md-flex md-headline">
                <span>Add Category</span>
              </h2>
          </md-toolbar>
          <!--Note: for scrollShrink to work, the toolbar must be a sibling of a md-content element, placed before it.-->
          <md-content>
              <md-switch ng-model="" aria-label="">
                  Test
              </md-switch>
          </md-content>
        </md-content>
        </div>
      </div>
    </div>

  </div>
@endsection
@section('scripts')
  <script type="text/javascript">
    // Define the service
    angular.module('adminService', [])
            .factory('Admin', function($http){
              // Get all the admin
              return {
                get : function() {
                  return $http.get('test/api');
                },
              }
            });

    // Define the controller
    angular.module('mainCtrl', [])
            .controller('mainController', function($scope, $http, Admin) {
              $scope.adminData = {} // Initialize the object

              // get function from factory of the Admin service
              Admin.get().then(function(response) {
                  $scope.admins = response.data;
                });


            });

    // Define the Application
    var adminApp =
    angular.module('adminApp', [
              'mainCtrl',
              'adminService',
              'ngMaterial',
            ])
            .config(function($interpolateProvider) {
              $interpolateProvider.startSymbol('/%');
              $interpolateProvider.endSymbol('%/');
            });
  </script>
@endsection
