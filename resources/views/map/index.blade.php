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
      // Setting locations
      var locations = [
        @foreach ($points as $key => $point)
          {lat: {{ $point->lat }}, lng: {{ $point->lng }}},
        @endforeach
      ];

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

        var icon = {
            path: "M11,0 L11,0 C5.19971429,0 0.5,4.69628571 0.5,10.4884286 C0.5,15.6012857 3.39885714,22.4104286 11,30 L11,30 C18.6011429,22.4104286 21.5,15.6012857 21.5,10.4884286 C21.5,4.69628571 16.8002857,0 11,0 Z M11,13.1802857 C8.83271429,13.1802857 7.07685714,11.4274286 7.07685714,9.26442857 C7.07685714,7.10357143 8.83314286,5.349 11,5.349 C13.1668571,5.349 14.9197143,7.10357143 14.9197143,9.26442857 C14.9197143,11.4274286 13.1672857,13.1802857 11,13.1802857 Z",
            fillColor: '#F9555B',
            fillOpacity: 0.7,
            anchor: new google.maps.Point(0,0),
            strokeWeight: 0,
            scale: 1,
        }

        var markers = locations.map(function(location, i) {
          return new google.maps.Marker({
            position: location,
            icon: icon,
          });
        });

        console.log(markers);

        var markerCluster = new MarkerClusterer(map, markers,
            {imagePath: '{{ asset('/map_assets/clusters/m') }}'});

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
          ]
        });

      } //end init

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
    <script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBMuYp_fLHyQ-vkDFpJzLdS6WoU_uYSBHs&callback=initMap"
    async defer></script>
@endsection
