@extends('layouts.teacher', ['type' => 'app'])
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

      #library {
        overflow-y: scroll;
      }
  </style>
@endsection
@section('content')
<div class="container-fluid">
  @include('components.apps.heading_info', ['app' => $app])
  @include('components.apps.sidebar-menu', ['app' => $app, 'type' => 'teacher'])
  <div id="app">
    <div class="row mt">
      <div class="col-md-8">
        <div class="box blue">
          <div class="box-header">
            Character
          </div>
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
            Library
          </div>
          <div id="library" class="box-body">
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
            <div class="btns pr-4">
              <a id="deselect" href="#" class="btn btn-orange">Deselect All</a>
            </div>
            <div class="btns pr-4">
              <a id="back" href="#" class="btn btn-orange">Move Back</a>
              <a id="backward" href="#" class="btn btn-orange">Move Backward</a>
              <a id="forward" href="#" class="btn btn-orange">Move Forward</a>
              <a id="front" href="#" class="btn btn-orange">Move To Front</a>
            </div>
            <div class="btns">
              <a id="destroy" href="#" class="btn btn-orange">Remove</a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row mt">
      <div class="col">
        <div class="box green">
          <div class="box-header">
            Notes
          </div>
          <div class="box-body">
            <textarea id="notes" name="notes" rows="8" class="form-control" placeholder="Describe your character"></textarea>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('scripts')
  <script src="{{ asset('plugins/any-resize-event.min.js') }}"></script>
  <script src="{{ asset('plugins/fabric/fabric.min.js') }}"></script>
  <script type="text/javascript">
    var AppSession = new TfcSessions();
    var session = AppSession.initSession({{ $app->id }});

    video_player = document.getElementById('canvas-wrapper');
    video_player.addEventListener('onresize', function(){
        var video_player = document.getElementById('canvas-wrapper').offsetHeight - 63;
        $('#library').height(video_player);
    });

    $(document).ready(function($) {
        var canvas = this.__canvas = new fabric.Canvas('image-editor');
        // canvas.setBackgroundImage('https://i.imgur.com/AR5Mes8.jpg', canvas.renderAll.bind(canvas));

        var json_data = '';

        responsiveCanvas(canvas);
        $(window).resize( function() {
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
      // Save canvas to JSON for future edit
      json_data = JSON.stringify(canvas.toDatalessJSON());
      localStorage.setItem('app-13-json', JSON.stringify(json_data));
      // $.cookie('tfc-canvas', JSON.stringify(json_data));

      // Save image to local storage
      localStorage.setItem('app-13-image', canvas.toDataURL('png'));
      return json_data;
    }

    function responsiveCanvas(canvas)
    {
        var sizeWidth = document.getElementById('container-canvas').offsetWidth;
        var sizeHeight = document.getElementById('canvas-wrapper').offsetHeight;
        canvas.setWidth(sizeWidth).setHeight(sizeHeight);

        //SAVE JSON DATA
        json_data = JSON.stringify(canvas.toDatalessJSON());

        //LOAD JSON DATA
        canvas.loadFromJSON(JSON.parse(json_data), function(obj) {
            canvas.renderAll();
        });

        return canvas;
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
          src = decodeURI(obj._element.currentSrc),
          baseUrlPattern = /^https?:\/\/[a-z\:0-9.]+/,
          result = '',
          match = baseUrlPattern.exec(src);

      if (match != null) {
          result = match[0];
      }

      if (result.length > 0) {
          src = src.replace(result, "");
      }

      // find the item on library
      var el = $('[data-img-src="'+src+'"]'),

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
      canvas.on(eventName, function(){
        saveCanvas(canvas)
      });
    }

  </script>
@endsection
