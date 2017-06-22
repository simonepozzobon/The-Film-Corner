@extends('layouts.teacher')
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
  <div class="feedback-popup mt-4">
    <div class="d-block m-1 pl-2">
      <a class="text-white text-align-center btn btn-info btn-lg" data-toggle="modal" data-target="#positiveFeedback">
        <i class="fa fa-question" aria-hidden="true"></i>
      </a>
    </div>
    <div class="d-block m-1">
      <a class="text-white text-align-center btn btn-primary btn-lg" data-toggle="modal" data-target="#saveSession">
        <i class="fa fa-floppy-o" aria-hidden="true"></i>
      </a>
    </div>
    <div class="d-block m-1">
      <a class="text-white text-align-center btn btn-danger btn-lg" data-toggle="modal" data-target="#close">
        <i class="fa fa-times" aria-hidden="true"></i>
      </a>
    </div>
  </div>
  <div class="modal fade" id="saveSession" tabindex="-1" role="dialog" aria-labelledby="saveModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="saveModalLabel">Save {{ $app->title }}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <i class="fa fa-times" aria-hidden="true"></i>
          </button>
        </div>
        <form>
          {{ csrf_field() }}
          {{ method_field('POST') }}

          <div class="modal-body">
            <div class="form-group">
              <label for="">Title:</label>
              <input type="text" name="title" class="form-control">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Cancel</button>
            <button type="button" class="btn btn-primary" onclick="updateSession({{ $app->id }})"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="modal fade" id="close" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Close {{ $app->title }}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <i class="fa fa-times" aria-hidden="true"></i>
          </button>
        </div>
        <div class="modal-body">
          <h4 class="text-center">Are you sure</h4>
          <p class="text-center">
            Do you want to exit without save?
          </p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Cancel</button>
          <a class="btn btn-danger text-white" href="{{ route('teacher.film-specific.index', $app->category->slug) }}"><i class="fa fa-sign-out" aria-hidden="true"></i> Close Without Save</a>
        </div>
      </div>
    </div>
  </div>
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
        <button id="capture" type="button" name="button" class="btn btn-primary btn-block"><i class="fa fa-camera" aria-hidden="true"></i> Capture Frame</button>
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
    initSession({{ $app->id }})
    function initSession(id)
    {

        var data = {
          '_token'  : $('input[name=_token]').val(),
          'app_id'  : id,
        };

        // Genero la sessione
        $.ajax({
          type: 'post',
          url:  '/teacher/session/new',
          headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
          },
          data: data,
          success: function (response) {
            var sessions = [];

            if ($.cookie('tfc-sessions')) {
              sessions = [];
            }

            var session = {
              'app_id': id,
              'token': response.token
            };

            sessions.push(session);
            $.cookie('tfc-sessions', JSON.stringify(sessions));
            console.log($.parseJSON($.cookie('tfc-sessions')));
          },
          error: function (xhr, status) {
              console.log(xhr);
              console.log(status);
          }
        });


    }

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
      var elem = '<div id="frame-container-'+counter+'" class="frames col-md-4 p-5 d-inline-block">';
      elem += '<div class="row">';
      elem +=   '<div class="col bg-faded">';
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

    function updateSession(id) {

      var sessions = $.parseJSON($.cookie('tfc-sessions'));
      var count = Object.keys(sessions).length;
      var token = null;

      for (var i = 0; i < count; i++) {
        if (sessions[i].app_id == {{ $app->id }}) {
          token = sessions[i].token;
        }
      }

      var frames = [];
      $('.frames').each(function(k){
        var frame = {
          'text': $(this).find('textarea').val(),
          'order': k,
          'base64': $(this).find('img').attr('src')
        };
        frames.push(frame);
      });

      console.log(frames);

      var data = {
        '_token'  : $('input[name=_token]').val(),
        'app_id'  : id,
        'token'   : token,
        'title'   : $('input[name="title"]').val(),
        'frames'  : frames
      };

      $.ajax({
        type: 'post',
        url:  '/teacher/session/update',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        data: data,
        success: function (response) {
          console.log(response);
          $('#saveSession').modal('hide');
        },
        error: function (xhr, status) {
            console.log(xhr);
            console.log(status);
        }
      });
    }
  </script>


@endsection
