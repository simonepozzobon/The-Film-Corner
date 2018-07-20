@extends('layouts.guest', ['type' => 'app'])
@section('title', $app->title)
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
  <div class="container-fluid">
    @include('components.apps.heading_info', ['app' => $app, 'type' => 'guest'])
    <div id="app">
      <div class="row mt">
        <div class="col-md-8">
          <div class="box blue">
            <div class="box-header">
              {{ GeneralText::field('scene') }}
            </div>
            <div class="box-body">
              <div id="photosphere"></div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="box yellow">
            <div class="box-header">
              {{ GeneralText::field('library') }}
            </div>
            <div class="box-body">
              <nav class="navbar navbar-toggleable-sm navbar-light">
                <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                  <ul class="navbar-nav mx-auto">
                    @foreach ($app->mediaCategory()->get() as $key => $library)
                      <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#{{ Utility::slugify($library->name) }}" aria-expanded="false" aria-controls="{{ Utility::slugify($library->name) }}">{{ $library->name }}</a>
                      </li>
                    @endforeach
                  </ul>
                </div>
              </nav>
              <div id="libraries">
                @foreach ($app->mediaCategory()->get() as $key => $library)
                  <ul id="{{ Utility::slugify($library->name) }}" class="assets list-unstyled row collapse {{ $key == 0 ? 'show' : '' }}" role="tabpanel">
                    @foreach ($library->media_on_sub_category() as $key => $media)
                      <li class="asset col-md-2 col-sm-4 pb-3 d-inline-block">
                        <img src="{{ Storage::disk('local')->url($media->thumb) }}" alt="image asset" width="80" class="img-fluid w-100" data-img-src="{{ Storage::disk('local')->url($media->src) }}"/>
                        <a href="" class="abs-btn btn btn-sm btn-danger d-none"><i class="fa fa-times" aria-hidden="true"></i></a>
                      </li>
                    @endforeach
                  </ul>
                @endforeach
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row mt">
        <div class="col">
          <div class="box orange">
            <div class="box-btns pt">
              <button id="capture" type="button" name="button" class="btn btn-secondary btn-orange" ><i class="fa fa-camera" aria-hidden="true"></i> {{ GeneralText::field('snap') }}</button>
              <button type="button" name="button" class="btn btn-secondary btn-orange" data-toggle="modal" data-target="#clear-all"><i class="fa fa-trash-o"></i> {{ GeneralText::field('clear_all') }}</button>
            </div>
          </div>
        </div>
      </div>
      <div id="rendered" class="row">

      </div>
      <div class="modal fade" id="clear-all" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">{{ GeneralText::field('clear_all') }}</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <i class="fa fa-times" aria-hidden="true"></i>
              </button>
            </div>
            <div class="modal-body">
              <h4 class="text-center">Pay attention</h4>
              <p class="text-center">
                Are you shure you want to reset your work?<br>
                This action can't be undone.
              </p>
            </div>
            <div class="modal-footer">
              <button id="clear-all-confirm" class="btn btn-danger text-white" href="#"><i class="fa fa-trash-o" aria-hidden="true"></i> {{ GeneralText::field('clear_all') }}</button>
              <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> {{ GeneralText::field('cancel') }}</button>
            </div>
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
    AppSession.initSession({{ $app->id }});

    var PSV = new PhotoSphereViewer({
      panorama: '{{ asset('img/helpers/null-image.png') }}',
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

    $('.asset').on('click', function() {
      var src = $(this).find('img').data('img-src');
      PSV.setPanorama(src);
      localStorage.setItem('app-2-image', src);
    })

    var counter = 0;

    $('#capture').on('click', function(event) {
      snapshot(event);
    });


    function snapshot(e)
    {
        if (counter <= 9) {
            e.preventDefault();
            var element = $('#photosphere .psv-container .psv-canvas-container canvas.psv-canvas').first();
            var img = PSV.render();
            counter = counter + 1;
            var elem = '';
            elem +='<div id="frame-container-'+counter+'" class="snap col-md-4 mt">';
            elem +=  '<div class="box green">';
            elem +=    '<div class="box-header">';
            elem +=      'Frame '+counter+'';
            elem +=      '<input type="hidden" name="frame-title" value="Frame '+counter+'">';
            elem +=    '</div>';
            elem +=    '<div class="box-body">';
            elem +=      '<img src="'+img+'" class="img-fluid">';
            elem +=      '<div class="form-group pt-3">';
            elem +=        '<textarea id="frame-'+counter+'" name="frame-'+counter+'" class="form-control" rows="8"></textarea>';
            elem +=        '<p id="frame-content-'+counter+'" class="d-none"></p>';
            elem +=      '</div>';
            elem +=    '</div>';
            elem +=    '<div class="box-btns">';
            elem +=      '<a onclick="save('+counter+')" class="btn btn-green text-white"><i class="fa fa-floppy-o" aria-hidden="true"></i></a>';
            elem +=      '<a onclick="edit('+counter+')" class="btn btn-green text-white"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
            elem +=      '<a onclick="destroy('+counter+')" class="btn btn-green text-white"><i class="fa fa-trash-o" aria-hidden="true"></i></a>';
            elem +=    '</div>';
            elem +=  '</div>';
            elem +='</div>';

            $('#rendered').append(elem);
        } else {
            alert('limit reached');
        }
    }

    function save(id)
    {
        var elem = $('#frame-'+id);
        var container = $('#frame-content-'+id);
        var content = elem.val();
        container.html(content);
        elem.hide();
        container.removeClass('d-none');
    }

    function edit(id)
    {
        var elem = $('#frame-'+id);
        var container = $('#frame-content-'+id);
        container.addClass('d-none');
        elem.show();
    }

    function destroy(id)
    {
        $('#frame-container-'+id).remove();
    }

    $('#rendered').sortable();

    $('#clear-all-confirm').on('click', function(e) {
        e.preventDefault();
        $('.snap').remove();
        $('#clear-all').modal('toggle');
        counter = 0;
    });

  </script>
@endsection
