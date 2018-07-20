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
    <form class="" action="" method="">
      <div id="rendered"></div>
    </form>
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
  <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
    var PSV = new PhotoSphereViewer({
      panorama: '{{ asset('img/frame-test/louvre.jpg') }}',
      container: 'photosphere',
      loading_img: '//photo-sphere-viewer.js.org/assets/photosphere-logo.gif',
      navbar: 'zoom fullscreen',
      min_fov: 30, //max zoom
      max_fov: 80, //min zoom
      default_fov: 70,
      time_anim: false,
      move_inertia: false,
      size: {
        height: 500
      }
    });

    var counter = 0

    $('#capture').on('click', function(e) {
      e.preventDefault();
      var element = $('#photosphere .psv-container .psv-canvas-container canvas.psv-canvas').first();
      var img = PSV.render();
      counter = counter + 1;
      var elem = '<div id="frame-container-'+counter+'" class="frames col-md-4 p-5 d-inline-block">';
      elem += '<div class="row">';
      elem +=   '<div class="col bg-faded">';
      elem +=     '<div class="container p-4">';
      elem +=       '<h3 class="text-center">Frame '+counter+'</h3>';
      elem +=       '<img src="'+img+'" class="img-fluid">';
      elem +=       '<div class="form-group pt-3">';
      elem +=         '<textarea id="frame-'+counter+'" name="frame-'+counter+'" class="form-control" rows="8"></textarea>';
      elem +=         '<p id="frame-content-'+counter+'" class="invisible"></p>';
      elem +=       '</div>';
      elem +=       '<div class="btn-group btn-block">';
      elem +=         '<a onclick="save('+counter+')" class="btn btn-primary w-50 text-white"><i class="fa fa-floppy-o" aria-hidden="true"></i></a>';
      elem +=         '<a onclick="edit('+counter+')" class="btn btn-info w-50 text-white"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
      elem +=         '<a onclick="destroy('+counter+')" class="btn btn-danger w-50 text-white"><i class="fa fa-trash-o" aria-hidden="true"></i></a>';
      elem +=       '</div>';
      elem +=     '</div>';
      elem +=   '</div>';
      elem += '</div>';
      elem += '</div>';
      $('#rendered').append(elem);
    });

    function save(id) {
      var elem = $('#frame-'+id);
      var container = $('#frame-content-'+id);
      var content = elem.val();
      container.html(content);
      elem.hide();
      container.removeClass('invisible');
    }

    function edit(id) {
      var elem = $('#frame-'+id);
      var container = $('#frame-content-'+id);
      container.addClass('invisible');
      elem.show();
    }

    function destroy(id) {
      $('#frame-container-'+id).remove();
    }

    $('#rendered').sortable();
  </script>


@endsection
