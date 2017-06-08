@extends('layouts.conference', ['active' => 'accomodation'])
@section('title')
  The Film Corner - International Conference
@endsection
@section('stylesheets')
  <link rel="stylesheet" href="{{ asset('css/home.css') }}">
  <style media="screen">
  #map-novotel, #map-ibis {
    height: 100%;
  }
  </style>
@endsection
@section('content')
  <div class="block-subtitle mt-5">
    <h4>Accomodations</h4>
  </div>
  <div class="block-text mb-5">
    <div class="row">
      <div class="col-md-4">
        <div id="map-novotel" style="height: 200px"></div>
      </div>
      <div class="col-md-8">
        <p class="text-justify">
          <h5>Novotel Milano Nord Cà Granda <i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i></h5>
          Viale Suzzani 13, Milano
          <br>
          MM Cà Granda
          <br>
          Reservation: <a href="mailto:H1140-FO@accor.com">H1140-FO@accor.com</a>
          <br>
          <em>(please specify: “Richiesta prenotazione The Film Corner”)</em>
          <br>
        </p>
      </div>
    </div>
    <p class="text-justify">
      <div class="row">
        <div class="col-md-4">
          <div id="map-ibis" style="height: 200px;"></div>
        </div>
        <div class="col-md-8">
          <h5>Hotel Ibis Cà Granda <i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i></h5>
          Viale Suzzani 13, Milano
          <br>
          MM Cà Granda
          <br>
          Reservation: <a href="mailto:h1135@accor.com">h1135@accor.com</a>
          <br>
          <em>(please specify: “Richiesta prenotazione The Film Corner”)</em>
        </div>
      </div>
    </p>
  </div>
@endsection
@section('scripts')
  <script src="//maps.googleapis.com/maps/api/js?key=AIzaSyCWWjzGK-o2GBGAPabC1nm6AETotrd53TQ&callback=initMap"
  async defer></script>
  <script>
    var map1;
    var map2;
    function initMap() {
      var myLatLng1 = {lat: 45.506713, lng: 9.196565};
      var myLatLng2 = {lat: 45.506713, lng: 9.196565};
      map1 = new google.maps.Map(document.getElementById('map-novotel'), {
        center: myLatLng1,
        zoom: 16
      });
      map2 = new google.maps.Map(document.getElementById('map-ibis'), {
        center: myLatLng2,
        zoom: 16
      });

      var marker1 = new google.maps.Marker({
        position: myLatLng1,
        map: map1,
        title: 'Novotel Milano Nord Cà Granda'
      });

      var marker2 = new google.maps.Marker({
        position: myLatLng2,
        map: map2,
        title: 'Hotel Ibis Cà Granda'
      });

      var style = [
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
        // Styles Features
        {elementType: 'geometry', stylers: [{color: '#FFF5D6'}]},
        {elementType: 'labels.text.stroke', stylers: [{color: '#FFF5D6'}]},
        {elementType: 'labels.text.fill', stylers: [{color: '#FAD86A'}]},
        {
          featureType: 'administrative.locality',
          elementType: 'labels.text.fill',
          stylers: [{color: '#FAD86A'}]
        },
        {
          featureType: 'poi',
          elementType: 'labels.text.fill',
          stylers: [{color: '#FAD86A'}]
        },
        {
          featureType: 'poi.park',
          elementType: 'geometry',
          stylers: [{color: '#F8E9B0'}]
        },
        {
          featureType: 'poi.park',
          elementType: 'labels.text.fill',
          stylers: [{color: '#FAD86A'}]
        },
        {
          featureType: 'road',
          elementType: 'geometry',
          stylers: [{color: '#F8E9B0'}]
        },
        {
          featureType: 'road',
          elementType: 'geometry.stroke',
          stylers: [{color: '#F8E9B0'}]
        },
        {
          featureType: 'road',
          elementType: 'labels.text.fill',
          stylers: [{color: '#FAD86A'}]
        },
        {
          featureType: 'road.highway',
          elementType: 'geometry',
          stylers: [{color: '#FAD86A'}]
        },
        {
          featureType: 'road.highway',
          elementType: 'geometry.stroke',
          stylers: [{color: '#F8E9B0'}]
        },
        {
          featureType: 'road.highway',
          elementType: 'labels.text.fill',
          stylers: [{color: '#FAD86A'}]
        },
        {
          featureType: 'transit',
          elementType: 'geometry',
          stylers: [{color: '#F8E9B0'}]
        },
        {
          featureType: 'transit.station',
          elementType: 'labels.text.fill',
          stylers: [{color: '#FAD86A'}]
        },
        {
          featureType: 'water',
          elementType: 'geometry',
          stylers: [{color: '#FFE47D'}]
        },
        {
          featureType: 'water',
          elementType: 'labels.text.fill',
          stylers: [{color: '#FAD86A'}]
        },
        {
          featureType: 'water',
          elementType: 'labels.text.stroke',
          stylers: [{color: '#FFF5D6'}]
        }
      ];

      map1.setOptions({
        styles: style
      });

      map2.setOptions({
        styles: style
      });


    }
  </script>
@endsection
