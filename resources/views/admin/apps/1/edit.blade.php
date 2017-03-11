@extends('layouts.admin')
@section('title', "Frame - $frame->name")
@section('page-title', "Frame - $frame->name")
@section('stylesheets')
<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/angular_material/1.1.0/angular-material.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.6.3/angular.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.6.3/angular-resource.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.6.3/angular-animate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.6.3/angular-aria.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.6.3/angular-messages.min.js"></script>

<!-- Angular Material Library -->
<script src="//ajax.googleapis.com/ajax/libs/angular_material/1.1.0/angular-material.min.js"></script>

@endsection
@section('content')
<div class="clearfix" ng-cloak="" ng-app="MyApp">
  <div class="row">
    <div class="col-md-8">
      <div class="card">
        <h3 class="card-header">Frame Image</h3>
        <div class="card-block">
          <div class="card-text image-wrapper">
            <div class="image-container">
              <canvas id="Canvas" width="500" height="500">
              </canvas>
              <img src="{{ Storage::disk('local')->url($frame->frame) }}" alt="{{ $frame->name }}" width="500">
            </div>
          </div>
        </div>
      </div>
      <div class="card mt-4">
        <h3 class="card-header">Description</h3>
        <div class="card-block">
          <div class="card-text">
            <p class="lead">
              {!! $frame->description !!}
            </p>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card">
        <h3 class="card-header">Frame Details</h3>
        <div class="card-block">
          <div class="card-text">
            <div class="row">
              <div class="col">
                <div ng-controller="AppCtrl" class="sliderdemoBasicUsage" >
                  <md-content style="margin: 16px; padding:16px">

                    <h3>
                      Edit
                    </h3>

                    <md-slider-container>
                      <span>R</span>
                      <md-slider flex="" min="0" max="255" ng-model="color.red" aria-label="red" id="red-slider">
                      </md-slider>
                      <md-input-container>
                        <input flex="" type="number" ng-model="color.red" aria-label="red" aria-controls="red-slider">
                      </md-input-container>
                    </md-slider-container>

                    <md-slider-container>
                      <span>G</span>
                      <md-slider flex="" ng-model="color.green" min="0" max="255" aria-label="green" id="green-slider" class="md-accent">
                      </md-slider>
                      <md-input-container>
                        <input flex="" type="number" ng-model="color.green" aria-label="green" aria-controls="green-slider">
                      </md-input-container>
                    </md-slider-container>

                    <md-slider-container>
                      <span class="md-body-1">B</span>
                      <md-slider flex="" ng-model="color.blue" min="0" max="255" aria-label="blue" id="blue-slider" class="md-primary">
                      </md-slider>
                      <md-input-container>
                        <input flex="" type="number" ng-model="color.blue" aria-label="blue" aria-controls="blue-slider">
                      </md-input-container>
                    </md-slider-container>
                  </md-content>
                </div>
              </div>
            </div>
            <table class="table table-hover">
              <thead><th>Created at:</th></thead>
              <tbody><tr><td>{{ $frame->created_at }}</td></tr></tbody>
            </table>
            <table class="table table-hover">
              <thead><th>Updated at:</th></thead>
              <tbody><tr><td>{{ $frame->updated_at }}</td></tr></tbody>
            </table>
            <div class="row">
              <div class="col">
                <a href="{{ route('app_1.update', $frame->id) }}" class="btn btn-primary btn-block">Save</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
angular.module('MyApp',['ngMaterial', 'ngMessages'])
      .config(function($mdIconProvider) {
       $mdIconProvider
         .iconSet('device', 'img/icons/sets/device-icons.svg', 24);
      })
      .controller('AppCtrl', function($scope) {

      $scope.color = {
       red: Math.floor(Math.random() * 255),
       green: Math.floor(Math.random() * 255),
       blue: Math.floor(Math.random() * 255)
      };

      $scope.rating1 = 3;
      $scope.rating2 = 2;
      $scope.rating3 = 4;

      $scope.disabled1 = Math.floor(Math.random() * 100);
      $scope.disabled2 = 0;
      $scope.disabled3 = 70;

      $scope.invert = Math.floor(Math.random() * 100);

      $scope.isDisabled = true;
});
 </script>
@endsection
