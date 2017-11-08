@extends('layouts.teacher', ['type' => 'app'])
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
    @include('components.apps.heading_only', ['title' => $app->title])
    @include('components.apps.sidebar-menu', ['app' => $app, 'type' => 'teacher', 'student' => $is_student])
    <div id="app">
      <div class="row mt">
        <div class="col-md-8">
          <div class="box blue">
            <div class="box-header">
              Frame
            </div>
            <div class="box-body">
              <input id="loadCanvas" type="hidden" name="" value="{{ $session->json_data }}">
              <div id="canvas-wrapper" class="blue" style="height: 30rem">
                <div id="container-canvas" class="">
                  <canvas class="image-editor" id="image-editor"></canvas>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="box yellow">
            <div class="box-header">
              Library
            </div>
            <div class="box-body">
              <nav class="navbar navbar-toggleable-sm navbar-light navbar-library">
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
                      <li class="asset col-md-3 col-sm-4 pb-3 d-inline-block">
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
        <div class="box orange">
          <div id="controls" class="box-btns pt">
            <a id="deselect" href="#" class="btn btn-secondary btn-orange">Deselect All</a>
            <div class="btn-group">
              <a id="back" href="#" class="btn btn-orange">Move Back</a>
              <a id="backward" href="#" class="btn btn-orange">Move Backward</a>
              <a id="forward" href="#" class="btn btn-orange">Move Forward</a>
              <a id="front" href="#" class="btn btn-orange">Move To Front</a>
            </div>
            <a id="destroy" href="#" class="btn btn-orange">Remove</a>
          </div>
        </div>
      </div>
      <div class="row mt">
        <div class="box green">
          <div class="box-header">
            Notes
          </div>
          <div class="box-body">
            <textarea id="notes" name="notes" rows="8" class="form-control" placeholder="What criteris did you use in yout composition?">{{ $session->notes }}</textarea>
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
  <script src="{{ mix('js/teacher-chat.js') }}"></script>

  <script type="text/javascript">
    var AppSession = new TfcSessions();
    AppSession.openSession('{{ $app_session->token }}', {{ $app->id }});

    var canvas = this.__canvas = new fabric.Canvas('image-editor');
    json_data = init(canvas);


    $(document).ready(function($) {
        // canvas.setBackgroundImage('https://i.imgur.com/AR5Mes8.jpg', canvas.renderAll.bind(canvas));
        var json_data = '';

        responsiveCanvas(canvas);
        $(window).resize(function() {
          responsiveCanvas(canvas)
        });

        $('.assets li').click(function(e) {
            e.preventDefault();
            var $this = $(this);
            var image_obj = $this.data('image-image-obj');
            var parent = $this.closest('li');

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
        });
        $('#back').on('click', function () {
          back(canvas);
        });
        $('#backward').on('click', function () {
          backward(canvas);
        });
        $('#forward').on('click', function () {
          forward(canvas);
        });
        $('#front').on('click', function () {
          front(canvas)
        });
        $('#destroy').on('click', function () {
          destroy(canvas);
        });
    });

    function saveCanvas(canvas)
    {
        json_data = JSON.stringify(canvas.toDatalessJSON());
        $.cookie('tfc-canvas', JSON.stringify(json_data));

        // Save image to local storage
        localStorage.setItem('app-1-image', canvas.toDataURL('png'));

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
  </script>
@endsection
