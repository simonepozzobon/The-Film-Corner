@extends('layouts.main')
@section('title', 'Frame Counter')
@section('stylesheets')
  <style media="screen">
    #vrview {
      width: 100%;
      height: auto;
    }

    #vrview iframe {
      width: 100%;
      height: 100%;
    }
  </style>
@endsection
@section('content')
  <div class="p-5">

  </div>
  <div class="clearfix pt-5 pb-5">
    <div class="row">
      <div class="col-md-8 offset-md-2">
        <div id="photosphere"></div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4 p-5 offset-md-4">
        <button id="capture" type="button" name="button" class="btn btn-primary btn-block">Capture Frame</button>
      </div>
    </div>
  </div>
  </div>
  <div class="row">
    <div id="rendered"></div>
  </div>
@endsection
@section('scripts')
  <link rel="stylesheet" href="{{ asset('plugins/photo-sphere/photo-sphere-viewer.min.css') }}">
  <script src="{{ asset('plugins/three.js/three.js') }}"></script>
  <script src="{{ asset('plugins/D.js/D.js') }}"></script>
  <script src="{{ asset('plugins/doT/doT.js') }}"></script>
  <script src="{{ asset('plugins/uevent/uevent.js') }}"></script>
  <script src="{{ asset('plugins/three.js/CanvasRenderer.js') }}"></script>
  <script src="{{ asset('plugins/three.js/Projector.js') }}"></script>
  <script src="{{ asset('plugins/photo-sphere/photo-sphere-viewer.js') }}"></script>

  <script>
    var PSV = new PhotoSphereViewer({
      panorama: '{{ asset('img/frame-test/louvre.jpg') }}',
      container: 'photosphere',
      loading_img: 'http://photo-sphere-viewer.js.org/assets/photosphere-logo.gif',
      navbar: 'zoom fullscreen',
      min_fov: 30, //max zoom
      max_fov: 80, //min zoom
      default_fov: 70,
      time_anim: false,
      size: {
        height: 500
      }
    });


    $('#capture').on('click', function(e) {
      e.preventDefault();
      var element = $('#photosphere .psv-container .psv-canvas-container canvas.psv-canvas').first();
      var img = PSV.render();
      $('#rendered').append('<div class="col-md-4 p-4 d-inline-block"><img src="'+img+'" class="img-fluid"></div>')
    });
  </script>


@endsection
