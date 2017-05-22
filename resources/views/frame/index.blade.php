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
    <div id="vrview" class="w-100 h-100"></div>
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
  {{-- <script src="//storage.googleapis.com/vrview/2.0/build/vrview.min.js"></script>
  <script type="text/javascript">
    window.addEventListener('load', onVrViewLoad)
      function onVrViewLoad() {
        var vrView = new VRView.Player('#vrview', {
          image: '{{ asset('img/frame-test/louvre.jpg') }}',
          is_stereo: false
        });
      }
  </script> --}}

  <link rel="stylesheet" href="{{ asset('plugins/photo-sphere/photo-sphere-viewer.min.css') }}">

  <script src="{{ asset('plugins/three.js/three.js') }}"></script>
  <script src="{{ asset('plugins/D.js/D.min.js') }}"></script>
  <script src="{{ asset('/plugins/uevent/uevent.js') }}"></script>
  <script src="{{ asset('/plugins/doT/doT.min.js') }}"></script>
  <script src="{{ asset('plugins/three.js/CanvasRenderer.js') }}"></script>
  <script src="{{ asset('plugins/three.js/Projector.js') }}"></script>
  {{-- <script src="http://photo-sphere-viewer.js.org/dist/three.js-examples/examples/js/renderers/CanvasRenderer.js"></script> --}}
  {{-- <script src="http://photo-sphere-viewer.js.org/dist/three.js-examples/examples/js/renderers/Projector.js"></script> --}}
  <script src="{{ asset('plugins/photo-sphere/photo-sphere-viewer.min.js') }}"></script>
  <script src="{{ asset('plugins/html2canvas/html2canvas.js') }}"></script>

  <script type="text/javascript">
    var PSV = new PhotoSphereViewer({
      panorama: '{{ asset('img/frame-test/louvre.jpg') }}',
      container: 'vrview',
      size: {
        height: 500
      }
    });

  //   // var PSV = new PhotoSphereViewer({
  //   // panorama: 'http://photo-sphere-viewer.js.org/assets/Bryce-Canyon-National-Park-Mark-Doliner.jpg',
  //   // container: 'vrview',
  //   // caption: 'Bryce Canyon National Park <b>&copy; Mark Doliner</b>',
  //   // loading_img: 'http://photo-sphere-viewer.js.org/assets/photosphere-logo.gif',
  //   // navbar: 'autorotate zoom download caption fullscreen',
  //   // default_fov: 70,
  //   // mousewheel: false,
  //   // size: {
  //   //   height: 500
  //   // }
  // });
  </script>

  <script type="text/javascript">
  //var body = $('#vrview iframe').contents().find('body');
  var element = $('#vrview iframe');

  console.log(element);

  $('#capture').on('click', function(e){
    e.preventDefault();
    alert('triggeres');
    html2canvas(element[0], {
      onrendered: function(canvas) {
        $('#rendered').html(canvas);
        //document.body.appendChild(canvas);
      }
    });
  });



  </script>
@endsection
