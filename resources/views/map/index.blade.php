@extends('layouts.main')
@section('title', 'Spot Map')
@section('stylesheets')
  <link rel="stylesheet" href="{{ asset('css/maps/style.css') }}">
  <style media="screen">
  /* Always set the map height explicitly to define the size of the div
    * element that contains the map. */
   #map {
     height: 100%;
   }
   /* Optional: Makes the sample page fill the window. */
   html, body {
     height: 100%;
     margin: 0;
     padding: 0;
   }
  </style>
@endsection
@section('content')
  <div class="map-wrapper">
    <div id="map"></div>
  </div>
@endsection
@section('scripts')
  <script>
      function initMap() {
        // Create a map object and specify the DOM element for display.
        var map = new google.maps.Map(document.getElementById('map'), {
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

        map.setOptions({
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
              stylers: [{color: '#d59563'}]
            },
            {
              featureType: 'water',
              elementType: 'geometry',
              stylers: [{color: '#FFE47D'}]
            },
            {
              featureType: 'water',
              elementType: 'labels.text.fill',
              stylers: [{color: '#515c6d'}]
            },
            {
              featureType: 'water',
              elementType: 'labels.text.stroke',
              stylers: [{color: '#17263c'}]
            }
          ]
        });
      }


      // Resize Window
      function setSize(a) {
        var h = a-140;
        $('.map-wrapper').height(h);
      };

      var h = $(window).height();
      setSize(h);

      $(window).resize(function() {
        var h = $(window).height();
        setSize(h);
      });

    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBMuYp_fLHyQ-vkDFpJzLdS6WoU_uYSBHs&callback=initMap"
    async defer></script>
@endsection
