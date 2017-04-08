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

  <script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBMuYp_fLHyQ-vkDFpJzLdS6WoU_uYSBHs&callback=initMap"
    async defer></script>
@endsection
@section('content')
  <div class="map-wrapper">
    <div id="map"></div>
    @foreach ($points as $key => $point)
      <div class="modal fade" id="map-{{ $point->id }}" tabindex="-1" role="dialog" aria-labelledby="map-{{ $point->id }}Title" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h3 class="modal-title text-uppercase" id="map-{{ $point->id }}Title">{{ $point->title }}</h3>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="container">
              <div class="row p-3">
                <div id="video-box-{{ $point->id }}"class="col">
                  <h4>Video</h4>
                  <div id="player-{{ $point->id }}"></div>
                </div>
              </div>
              <div class="row p-3">
                <div class="col-md-7">
                  <h4>Sinossi</h4>
                  <p class="text-justify">
                    {{ $point->sinossi }}
                    <br>
                    <br>
                    <a href="{{ $point->info_link }}" target="_blank">More info</a>
                  </p>
                </div>
                <div class="col-md-3">
                  <h4>Place</h4>
                  <p class="text-capitalize">{{ $point->place_name }}</p>
                  <h4>City</h4>
                  <p class="text-capitalize">{{ $point->city->name }}</p>
                  <h4>Director</h4>
                  <p class="text-capitalize">{{ $point->director }}</p>
                  <h4>Actors</h4>
                  <p class="text-capitalize">{{ $point->actors }}</p>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-trash" aria-hidden="true"></i> Close</button>
            </div>
          </div>
        </div>
      </div>
    @endforeach
  </div>
@endsection
@section('scripts')
  <script>
      // Setting locations

      var locations = [];

      @foreach ($points as $key => $point)
        locations.push(
          {
            'position' : {lat: {{ $point->lat }}, lng: {{ $point->lng }}},
            'point_id' : {{ $point->id }},
            'video_id' : '{{ $point->video_id }}'
          }
        );
      @endforeach

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
            position: location.position,
            icon: icon,
          });
        });

        markers.map(function(marker, i) {
          return marker.addListener('click', function() {
            var videoId = locations[i].video_id;
            var id = locations[i].point_id;
            $('#map-'+id).on('show.bs.modal', function (e) {
              generateVideo(id, videoId);
            });
            $('#map-'+id).modal('show');
          });
        });

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

        // 2. This code loads the IFrame Player API code asynchronously.
        var tag = document.createElement('script');

        tag.src = "https://www.youtube.com/iframe_api";
        var firstScriptTag = document.getElementsByTagName('script')[0];
        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

        // 3. This function creates an <iframe> (and YouTube player)
        //    after the API code downloads.
        var player;

        function generateVideo(id, video)
        {
          player = new YT.Player('player-'+id, {
            height: '360',
            width: '100%',
            videoId: video,
          });
        }

    </script>
@endsection
