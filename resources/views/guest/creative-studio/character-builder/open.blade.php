@extends('layouts.guest', ['type' => 'app'])
@section('title', $app->title)
@section('stylesheets')
  <style media="screen">
      canvas {
        border: 2px dashed #252525;
      }

      .abs-btn {
        position: absolute;
        top: -5%;
        right: 5%;
      }
  </style>
@endsection
@section('content')
  <div class="container-fluid">
    @include('components.apps.heading_info', ['app' => $app, 'type' => 'guest', 'student' => $is_student])
    <div id="app">
      <div class="row mt">
        <div class="col-md-8">
          <div class="box blue">
            <div class="box-header">
              {{ GeneralText::field('character') }}
            </div>
            <input id="loadCanvas" type="hidden" name="" value="{{ $session->json_data }}">
            <div id="canvas-wrapper" class="box-body" style="min-height: 30rem">
              <div id="container-canvas">
                <canvas class="image-editor" id="image-editor"></canvas>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="box yellow">
            <div class="box-header">
              {{ GeneralText::field('library') }}
            </div>
            <div class="box-body library">
              <nav class="navbar navbar-toggleable-sm navbar-library yellow">
                <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                  <ul class="navbar-nav" role="tablist">
                    @foreach ($app->mediaCategory()->get() as $key => $library)
                      <li class="nav-item">
                        <a class="library-link nav-link {{ $key == 0 ? 'active' : '' }}" data-toggle="tab" href="#{{ Utility::slugify($library->name) }}">{{ $library->name }}</a>
                      </li>
                    @endforeach
                    <li class="nav-item">
                      <a class="library-link nav-link" data-toggle="tab" href="#upload-library">{{ GeneralText::field('uploads') }}</a>
                    </li>
                  </ul>
                </div>
              </nav>
              <div id="libraries" class="library-container tab-content">
                @foreach ($app->mediaCategory()->get() as $key => $library)
                  <div id="{{ Utility::slugify($library->name) }}" class="assets wrapper tab-pane {{ $key == 0 ? 'active' : '' }}" role="tabpanel">
                    <div class="row scroller">
                      @foreach ($library->medias()->get() as $key => $media)
                        <div class="asset col-md-3 col-sm-4 pb-3">
                          <img src="{{ Storage::disk('local')->url($media->thumb) }}" alt="image asset" class="img-fluid" data-img-src="{{ Storage::disk('local')->url($media->src) }}"/>
                          <a href="" class="abs-btn btn btn-sm btn-danger d-none"><i class="fa fa-times"></i></a>
                        </div>
                      @endforeach
                    </div>
                  </div>
                @endforeach
                <div id="upload-library" class="assets wrapper tab-pane" role="tabpanel">
                  <div class="row scroller">
                    <div class="col">
                      <form id="uploadForm" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        {{ method_field('POST') }}
                        <input id="app_category" type="hidden" name="app_category" value="{{ $app_category->slug }}">
                        <input id="app_slug" type="hidden" name="app_slug" value="{{ $app->slug }}">
                        <div class="form-group">
                          <input id="media" type="file" name="media" class="form-control">
                        </div>
                        <div class="container-fluid d-flex justify-content-around">
                          <button id="upload-this-media" type="submit" class="btn btn-yellow"><i class="fa fa-upload" aria-hidden="true"></i> {{ GeneralText::field('upload') }}</button>
                        </div>
                      </form>
                      <div id="uploads" class="assets">

                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row mt">
        <div class="col">
          <div class="box orange">
            <div class="box-btns pt">
              <div class="btns pr-4">
                <a id="deselect" href="#" class="btn btn-orange">{{ GeneralText::field('deselect_all') }}</a>
              </div>
              <div class="btns pr-4">
                <a id="back" href="#" class="btn btn-orange">{{ GeneralText::field('move_back') }}</a>
                <a id="backward" href="#" class="btn btn-orange">{{ GeneralText::field('move_backward') }}</a>
                <a id="forward" href="#" class="btn btn-orange">{{ GeneralText::field('move_forward') }}</a>
                <a id="front" href="#" class="btn btn-orange">{{ GeneralText::field('move_to_front') }}</a>
              </div>
              <div class="btns">
                <a id="destroy" href="#" class="btn btn-orange">{{ GeneralText::field('remove') }}</a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row mt">
        <div class="col">
          <div class="box green">
            <div class="box-header">
              {{ GeneralText::field('notes') }}
            </div>
            <div class="box-body">
              <textarea id="notes" name="notes" rows="8" class="form-control" placeholder="{{ GeneralText::field('character_builder_desc') }}">{{ $session->notes }}</textarea>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  @if ($is_student)
    @include('components.apps.chat', ['app_session' => $app_session])
  @endif
@endsection
@section('scripts')
  <script src="{{ asset('plugins/fabric/fabric.min.js') }}"></script>
  <script src="{{ mix('js/guest-chat.js') }}"></script>

  <script type="text/javascript">
    var AppSession = new TfcSessions();
    AppSession.openSession('{{ $app_session->token }}', {{ $app->id }});
    libraryResize();
    document.getElementById('canvas-wrapper').addEventListener('onresize', libraryResize);

    var canvas = this.__canvas = new fabric.Canvas('image-editor');
    json_data = init(canvas);

    video_player = document.getElementById('canvas-wrapper');
    video_player.addEventListener('onresize', function(){
        var video_player = document.getElementById('canvas-wrapper').offsetHeight - 63;
        $('#library').height(video_player);
    });

    $('form#uploadForm').submit(function(event) {
      event.preventDefault();
      console.log(session.token);
      var formData = new FormData();
      formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
      formData.append('media', $('#media')[0].files[0]);
      formData.append('session_token', session.token);

      var app_category = $('#app_category').val();
      var app_slug = $('#app_slug').val();

      console.log($('#media')[0].files[0]);

      axios.post('{{ route('guest.creative-studio.upload.img', [$app_category, $app->slug]) }}', formData)
        .then(response => {
          console.log(response);
          var data = '';
          data += '<div class="asset col-md-3 col-sm-4 pb-3">'
          data +=   '<img src="'+response.data.img+'" alt="image asset" class="img-fluid" data-img-src="'+response.data.img+'"/>'
          data +=   '<a href="" class="abs-btn btn btn-sm btn-danger d-none"><i class="fa fa-times"></i></a>'
          data += '</div>'
          $('#uploads').append(data);
        });
    })

    $(document).ready(function($) {
        // canvas.setBackgroundImage('https://i.imgur.com/AR5Mes8.jpg', canvas.renderAll.bind(canvas));
        var json_data = '';

        responsiveCanvas(canvas);
        $(window).resize(function() {
          responsiveCanvas(canvas)
        });

        $('body').on('click', '.assets .asset', function(e) {
            e.preventDefault();
            var $this = $(this);
            var image_obj = $this.data('image-image-obj');
            var parent = $this.closest('.asset');

            if( !image_obj ) {
              var $image = $(this).find('img');
              var width = $image.prop('naturalWidth');
              var height = $image.prop('naturalHeight');
              var imgInstance = new fabric.Image($image[0], {
                width  : height,
                height : width,
                transparentCorners : false,
              })
              .setSrc($this.find('img').data('img-src'), function() {
                parent.children('a').removeClass('d-none')
                $this.data('image-image-obj', imgInstance);

                // constrain object to maximum canvas size
                var _width = document.getElementById('container-canvas').offsetWidth - 30;
                if (_width < imgInstance.getScaledWidth()) {
                  imgInstance.scaleToWidth(_width);
                }

                canvas.add(imgInstance).setActiveObject( imgInstance );
                imgInstance.center();
                saveCanvas(canvas);
              });
            } else {
              // rimuove gli oggetti dal canvas e la classe "selected"
              parent.children('a').addClass('d-none');
              $this.data('image-image-obj', false);
              canvas.remove(image_obj);

              // salvo in json
              saveCanvas(canvas);
            }
        });

        /**
         * Observe Events on Canvas
         */

        observe('object:added', canvas);
        observe('object:removed', canvas);
        observe('object:modified', canvas);
        observe('object:rotating', canvas);
        observe('object:scaling', canvas);
        observe('object:moving', canvas);
        observe('object:selected', canvas);

        /**
         * Controls
         */

        $('#deselect').on('click', function () {
          deselect(canvas);
          saveCanvas(canvas);
        });
        $('#back').on('click', function () {
          back(canvas);
          saveCanvas(canvas);
        });
        $('#backward').on('click', function () {
          backward(canvas);
          saveCanvas(canvas);
        });
        $('#forward').on('click', function () {
          forward(canvas);
          saveCanvas(canvas);
        });
        $('#front').on('click', function () {
          front(canvas)
          saveCanvas(canvas);
        });
        $('#destroy').on('click', function () {
          destroy(canvas);
          saveCanvas(canvas);
        });
    });

    function saveCanvas(canvas)
    {
        json_data = JSON.stringify(canvas.toDatalessJSON());
        localStorage.setItem('app-13-json', JSON.stringify(json_data));

        // Save image to local storage
        localStorage.setItem('app-13-image', canvas.toDataURL('png'));

        return json_data;
    }

    function responsiveCanvas()
    {
        var sizeWidth = document.getElementById('container-canvas').offsetWidth;
        var sizeHeight = document.getElementById('canvas-wrapper').offsetHeight;
        canvas.setWidth(sizeWidth).setHeight(sizeHeight);

        //SAVE JSON DATA
        json_data = saveCanvas(canvas);

        //LOAD JSON DATA
        canvas.loadFromJSON(JSON.parse(json_data), function(obj) {
            canvas.renderAll();
        });
    }


    function deselect(canvas)
    {
      canvas.discardActiveObject();
    }

    function back(canvas)
    {
      var obj = canvas.getActiveObject();
      canvas.sendToBack(obj);
      canvas.discardActiveObject();
    }

    function backward(canvas)
    {
      var obj = canvas.getActiveObject();
      canvas.sendBackwards(obj);
      canvas.discardActiveObject();
    }

    function forward(canvas)
    {
      var obj = canvas.getActiveObject();
      canvas.bringForward(obj);
      canvas.discardActiveObject();
    }

    function front(canvas)
    {
      var obj = canvas.getActiveObject();
      canvas.bringToFront(obj);
      canvas.discardActiveObject();
    }

    function destroy(canvas)
    {
      // get the selcted obj
      var obj = canvas.getActiveObject(),

      // decode the uri and remove baseurl
          src = cleanUrl(obj),

      // find the item on library
          el = $('[data-img-src="'+src+'"]'),

      // remove red button and remove object data
          asset = el.parent();

      asset.children('a').addClass('d-none');
      asset.data('image-image-obj', false);

      // deselect all
      canvas.discardActiveObject();

      // finally remove the object
      canvas.remove(obj);
    }

    function observe(eventName, canvas)
    {
      canvas.on(eventName, function() {
        saveCanvas(canvas)
      });
    }

    function init(canvas)
    {
        json_data = $('#loadCanvas').val();
        $.cookie('tfc-canvas', JSON.stringify(json_data));

        //LOAD JSON DATA on canvas
        canvas.loadFromJSON(JSON.parse(json_data), function(obj) {
            canvas.renderAll();
            canvas.forEachObject(function(obj) {
                console.log(obj);
                var src = cleanUrl(obj),
                    el = $('[data-img-src="'+src+'"]'),
                    asset = el.parent();

                asset.children('a').removeClass('d-none');
                asset.data('image-image-obj', obj);
            })
        });

        return json_data;
    }

    function cleanUrl(obj)
    {
      var src = decodeURI(obj._element.currentSrc),
          baseUrlPattern = /^https?:\/\/[a-z\:0-9.]+/,
          result = '',
          match = baseUrlPattern.exec(src);

      if (match != null) {
          result = match[0];
      }

      if (result.length > 0) {
          src = src.replace(result, "");
      }

      return src;
    }

    function libraryResize()
    {
        var video_player = document.getElementById('canvas-wrapper').offsetHeight - 42;
        $('#libraries').height(video_player);

        var libraryEl = document.getElementById('libraries');

        // creo l'evento personalizzato che verrà triggerato dalla funzione libraryResize
        var event = document.createEvent('HTMLEvents');
        event.initEvent('library-resized', true, true);

        // target can be any Element or other EventTarget.
        libraryEl.dispatchEvent(event);
    }
  </script>
@endsection
