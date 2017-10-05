@extends('layouts.teacher', ['type' => 'app'])
@section('title', 'Frame Crop')
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

    .feedback-popup {
      position: fixed;
      z-index: 2;
      margin-left: -1rem;
      top: 25%;
      transform: translateY(-50%);
    }
  </style>
@endsection
@section('content')
  @include('components.apps.sidebar-menu', ['app' => $app, 'type' => 'teacher])
  <div class="p-5">
  </div>
  <div class="row row-custom">
    <div id="help" class="col-6 container-fluid px-5 d-inline-block float-left">
        <div class="container-fluid pl-2 pr-2">
          <div class="row">
            <div class="col" style="background-color: #a6dbe2; color: #252525">
              <h3 class="pl-2 pr-2 pt-4 pb-2">Examples</h3>
            </div>
          </div>
          <div class="row pb-5">
            <div class="col pt-5 pb-5" style="background-color: #d9f5fc; color: #252525">
              <p class="pl-2">
                Examples of pictures and clips related to each app with a short explanations
              </p>
            </div>
          </div>
          <div class="row" style="background-color: #e9c845; color: #252525">
            <div class="col">
              <h3 class="pl-2 pr-2 pt-4 pb-2">References</h3>
            </div>
          </div>
          <div class="row mb-5" style="background-color: #f5db5e; color: #252525">
            <div class="col pt-5 pb-5">
              <p class="pl-2">
                <ul>
                  <li>lista 1</li>
                  <li>lista 2</li>
                  <li>altro elemento</li>
                </ul>
              </p>
            </div>
          </div>
          <div class="row pb-5">
            @foreach ($app_category->keywords as $key => $keyword)
              <h5><span class="badge badge-default mb-2 mr-2" data-toggle="modal" data-target="#keywordModal-{{ $keyword->id }}">{{ $keyword->name }}</span></h5>
              <div class="modal fade" id="keywordModal-{{ $keyword->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">{{ $keyword->name }}</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="fa fa-times" aria-hidden="true"></i>
                      </button>
                    </div>
                    <div class="modal-body">
                      {{ $keyword->description }}
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Close</button>
                    </div>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>
    </div>
    <div id="app" class="col-12 px-5 d-inline-block float-left">
      <div class="row" style="background-color: {{ $app->colors[1] }}; color: #252525">
        <div class="col">
          <div class="d-flex justify-content-start">
            <div class="mr-auto"><h3 class="ml-2 pt-4 pb-1">{{ $app->title }}</h3></div>
          </div>
        </div>
      </div>
      <div class="row" style="background-color: {{ $app->colors[0] }}; color: #252525">
        <div class="col">
          <div class="clearfix pt-5 pb-5">
            <div class="row">
              <div class="col-md-8 offset-md-2">
                <div id="photosphere"></div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4 p-5 offset-md-4 text-center">
                <button id="capture" type="button" name="button" class="btn btn-secondary btn-lg" style="background-color: {{ $app->colors[1] }}; color: #252525; border: none;"><i class="fa fa-camera" aria-hidden="true"></i> Capture Frame</button>
              </div>
            </div>
          </div>
          <div class="row">
            <form class="" action="" method="">
              <div id="rendered">
                @foreach ($session as $key => $frame)
                  <div id="frame-container-'+counter+'" class="frames col-md-4 p-5 d-inline-block">
                    <div class="row">
                      <div class="col bg-faded">
                          <div class="container p-4">
                            <h3 class="frame-title text-center">Frame {{ $key }}</h3>
                            <input type="hidden" name="frame-title" value="Frame {{ $frame->order }}">
                            <img src="{{ $frame->img }}" class="img-fluid">
                            <div class="form-group pt-3">
                              <textarea id="frame-{{ $key }}" name="frame-{{ $key }}" class="form-control" rows="8">{{ $frame->description }}</textarea>
                              <p id="frame-content-{{ $key }}" class="invisible">{{ $frame->description }}</p>
                            </div>
                            <div class="btn-group btn-block">
                            <a onclick="save({{ $key }})" class="btn btn-primary w-50 text-white"><i class="fa fa-floppy-o" aria-hidden="true"></i></a>
                            <a onclick="edit({{ $key }})" class="btn btn-info w-50 text-white"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                            <a onclick="destroy({{ $key }})" class="btn btn-danger w-50 text-white"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
            </form>
          </div>
        </div>
      </div>
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
  <script src="{{ asset('plugins/photo-sphere/photo-sphere-viewer.js') }}"></script>
  <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
    var AppSession = new TfcSessions();

    var PSV = new PhotoSphereViewer({
      panorama: '{{ asset('img/frame-test/louvre.jpg') }}',
      container: 'photosphere',
      loading_img: 'http://photo-sphere-viewer.js.org/assets/photosphere-logo.gif',
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
      var elem = '<div id="frame-container-'+counter+'" class="col-md-4 p-5 d-inline-block">';
      elem += '<div class="row">';
      elem +=   '<div class="frame col bg-faded">';
      elem +=     '<div class="container p-4">';
      elem +=       '<h3 class="frame-title text-center">Frame '+counter+'</h3>';
      elem +=       '<input type="hidden" name="frame-title" value="Frame '+counter+'">';
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
