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
    <div id="photosphere" class="">
      {{-- <iframe id="contenuto" allowfullscreen="true" scrolling="no" src="{{ url('/plugins/vrview') }}/index.html?image={{ asset('img/frame-test/louvre.jpg') }}&amp;is_stereo=false&amp;" style="border: 0px;"></iframe> --}}
    </div>
  </div>
  <div class="row">
    <div class="col-md-4 offset-md-4">
      <button id="capture" type="button" name="button" class="btn btn-primary btn-block">Capture Frame</button>
    </div>
  </div>
  <div class="row">
    <div id="rendered" class="col-md-12">

    </div>
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
  <script src="{{ asset('plugins/photo-sphere/photo-sphere-viewer.min.js') }}"></script>
  <script>
    var PSV = new PhotoSphereViewer({
      panorama: '{{ asset('img/frame-test/louvre.jpg') }}',
      container: 'photosphere',
      loading_img: 'http://photo-sphere-viewer.js.org/assets/photosphere-logo.gif',
      navbar: 'zoom fullscreen',
      min_fov: 50, //min zoom
      max_fov: 179, //max zoom
      default_fov: 50,
      time_anim: false,
      size: {
        height: 500
      }
    });
  </script>

  <script src="{{ asset('plugins/html2canvas/html2canvas.js') }}"></script>


  <script type="text/javascript">
  var element = $('#photosphere');
  $('#capture').on('click', function(e) {
    e.preventDefault();
    html2canvas(element, {
      onrendered: function(canvas) {
        $('#rendered').html(canvas);
      }
    });
  });
  </script>
@endsection
