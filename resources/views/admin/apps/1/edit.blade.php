@extends('layouts.admin')
@section('title', "Frame - $frame->name")
@section('page-title', "Frame - $frame->name")
@section('stylesheets')
<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/angular_material/1.1.0/angular-material.min.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/angular.js/1.6.3/angular.js"></script>
{{-- <script src="//maxiruani.github.io/mr-image/js/mr-image.min.js"></script> --}}
<!-- Angular Material Library -->
<script src="//ajax.googleapis.com/ajax/libs/angular_material/1.1.0/angular-material.min.js"></script>
<script type="text/javascript">
  var compApp = angular
      .module('compApp', ['common.fabric','common.fabric.utilities','common.fabric.constants']) // Name of the module
      .config(function($interpolateProvider) {
        $interpolateProvider.startSymbol('/%');
        $interpolateProvider.endSymbol('%/');
      }) // Config the module
      .controller('AppCtrl', ['$scope', 'Fabric', 'FabricConstants', 'Keypress', function($scope, Fabric, FabricConstants, Keypress) {

        $scope.fabric = {};
        $scope.FabricConstants = FabricConstants;

        // Properties of the model
        var image = {
          src : '{{ Storage::disk('local')->url($frame->frame) }}',
        };

        var message = {
          type: 'success',
          content: 'Ciao'
        };

        // assign them to $scope (Models)
        $scope.image = image;
        $scope.message = message;


        var canvas = new fabric.Canvas('fabric');

        // create a rectangle object
        var rect = new fabric.Rect({
          left: 100,
          top: 100,
          fill: 'red',
          width: 20,
          height: 20
        });

        // "add" rectangle onto canvas
        canvas.add(rect);

      }]); // Define the controller;
 </script>
@endsection
@section('content')
<div class="clearfix" ng-app="compApp" ng-controller="AppCtrl">
  <div class="mb-3">
    <span class='alert alert-/%message.type%/ d-block'>/%message.content%/</span>
  </div>
  <div class="row">
    <div class="col-md-8">
      <div class="card">
        <h3 class="card-header">Frame Image</h3>
        <div class="card-block">
          <div class="card-text image-wrapper">
            <div class="image-container">
              <input type="text" ng-model="message.content">
              <div class="row">
                {{-- <table class="table">
                  <thead>
                    <tr>
                      <th ng-click="sortData('name')">Name</th>
                      <th ng-click="sortData('like')">Like</th>
                      <th>Dislikes</th>
                      <th>Like/dislike</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr ng-repeat="technologia in technologies | orderBy:sortColumn">
                      <td>/%technologia.name | uppercase%/</td>
                      <td>/%technologia.like%/</td>
                      <td>/%technologia.dislike%/</td>
                      <td>
                        <input type="button" value="like" ng-click='incrementLikes(technologia)' class="btn btn-small">
                        <input type="button" value="dislike" ng-click='incrementDislikes(technologia)' class="btn btn-small">
                      </td>
                    </tr>
                  </tbody>
                </table> --}}
              </div>
              <div id="fabric">
                <canvas id="canvas" width="300" height="300"></canvas>
              </div>

              {{-- <img ng-src="/%image.src%/"> --}}
              {{-- <img src="{{ Storage::disk('local')->url($frame->frame) }}" alt="{{ $frame->name }}" width="500"> --}}
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
                <input type="text" ng-model="xPos" name="" class="form-control" placeholder="x">
                <input type="text" ng-model="yPos" name="" class="form-control" placeholder="y">
                /% scale.x %/, /% scale.y %/
                <a href="#" ng-click="scale()">Vai</a>
                <a href="#" ng-click="clear()">Clear</a>
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
@endsection
