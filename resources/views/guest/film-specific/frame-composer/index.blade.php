@extends('layouts.guest', ['type' => 'app'])
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
    @include('components.apps.heading_info', ['app' => $app, 'type' => 'guest'])
    <div id="app">
      <div class="row mt">
        <div class="col-md-8">
          <div class="box blue">
            <div class="box-header">
              Frame
            </div>
            <div class="box-body">
              <div id="canvas-wrapper" class="blue" style="height: 30rem">
                <div id="container-canvas">
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
                  </ul>
                </div>
              </nav>
              <div id="libraries" class="library-container tab-content">
                @foreach ($app->mediaCategory()->get() as $key => $library)
                  <div id="{{ Utility::slugify($library->name) }}" class="assets wrapper tab-pane {{ $key == 0 ? 'active' : '' }}" role="tabpanel">
                    <div class="row scroller">
                      @foreach ($library->media_on_sub_category() as $key => $media)
                        <div class="asset col-md-3 col-sm-4 pb-3">
                          <img src="{{ Storage::disk('local')->url($media->thumb) }}" alt="image asset" class="img-fluid" data-img-src="{{ Storage::disk('local')->url($media->src) }}"/>
                          <a href="" class="abs-btn btn btn-sm btn-danger d-none"><i class="fa fa-times"></i></a>
                        </div>
                      @endforeach
                    </div>
                  </div>
                @endforeach
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row mt">
        <div class="col">
          <div class="box orange">
            <div id="controls" class="box-btns pt">
              <a id="deselect" href="#" class="btn btn-orange">Deselect All</a>
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
      </div>
      <div class="row mt">
        <div class="col">
          <div class="box green">
            <div class="box-header">
              Notes
            </div>
            <div class="box-body">
              <textarea id="notes" name="notes" rows="8" class="form-control" placeholder="What criteris did you use in yout composition?"></textarea>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('scripts')
  <script src="{{ asset('plugins/fabric/fabric.min.js') }}"></script>

  <script type="text/javascript">
    var AppSession = new TfcSessions();
    var session = AppSession.initSession({{ $app->id }});

    $(document).ready(function($) {
        libraryResize();
        document.getElementById('canvas-wrapper').addEventListener('onresize', libraryResize);

        var canvas = this.__canvas = new fabric.Canvas('image-editor');
        // canvas.setBackgroundImage('https://i.imgur.com/AR5Mes8.jpg', canvas.renderAll.bind(canvas));

        var json_data = '';

        responsiveCanvas(canvas);
        $(window).resize( function() {
          responsiveCanvas(canvas)
        });

        $('.assets .asset').click(function(e) {
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
      // Save canvas to JSON for future edit
      json_data = JSON.stringify(canvas.toDatalessJSON());
      $.cookie('tfc-canvas', JSON.stringify(json_data));

      // Save image to local storage
      localStorage.setItem('app-1-image', canvas.toDataURL('png'));
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