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
  <section id="title" class="pt-5">
    <div class="title sp-center pt-5 pb-5">
      {{ $app->title }}
      <h2 class="p-2 block-title">{{ $app_category->name }}</h2>
    </div>
  </section>
  @include('components.apps.sidebar-menu', ['app' => $app, 'type' => 'teacher', 'student' => $is_student])
  <div class="row row-custom">
    <div id="help" class="col-6 container-fluid px-5 d-inline-block float-left">
        <div class="container-fluid pl-5">
          <div class="row">
            <div class="col" style="background-color: #a6dbe2; color: #252525">
              <h3 class="px-2 pt-4 pb-2">Examples</h3>
            </div>
          </div>
          <div class="row pb-5">
            <div class="col py-5" style="background-color: #d9f5fc; color: #252525">
              <p class="pl-2">
                Examples of pictures and clips related to each app with a short explanations
              </p>
            </div>
          </div>
          <div class="row" style="background-color: #e9c845; color: #252525">
            <div class="col">
              <h3 class="px-2 pt-4 pb-2">References</h3>
            </div>
          </div>
          <div class="row mb-5" style="background-color: #f5db5e; color: #252525">
            <div class="col py-5">
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
      <div class="row">
        <div class="col-md-8">
          <div class="box container-fluid mb-4">
            <div class="row">
              <div class="col dark-blue py-3 px-5">
                <h3>Build your scene</h3>
              </div>
            </div>
            <div class="row">
              <div class="col blue p-5">
                <input id="loadCanvas" type="hidden" name="" value="{{ $session->json_data }}">
                <div id="container-canvas" class="col d-flex justify-content-around">
                  <canvas class="image-editor" id="image-editor" width="2048" height="500"></canvas>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="box container-fluid mb-4">
            <div class="row">
              <div class="col dark-yellow py-3 px-5">
                <h3>Library Characters</h3>
              </div>
            </div>
            <div class="row">
              <div class="col yellow p-5">
                <ul class="assets list-unstyled row">
                  @foreach ($images as $key => $image)
                    <li class="col-md-3">
                      <img src="{{ Storage::disk('local')->url($image->thumb) }}" alt="image asset" width="80" class="img-fluid w-100" data-img-src="{{ Storage::disk('local')->url($image->src) }}"/>
                      <a href="" class="abs-btn btn btn-sm btn-danger d-none"><i class="fa fa-times" aria-hidden="true"></i></a>
                    </li>
                  @endforeach
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="box container-fluid mb-4">
            <div class="row">
              <div class="col dark-orange py-3 px-5">
                <h3>What criteria did you use in your composition?</h3>
              </div>
            </div>
            <div class="row">
              <div class="col orange p-5">
                <textarea id="notes" name="notes" rows="8" class="form-control"></textarea>
              </div>
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
    var canvas = this.__canvas = new fabric.Canvas('image-editor');
    json_data = init(canvas);


    $(document).ready(function($) {
        // canvas.setBackgroundImage('https://i.imgur.com/AR5Mes8.jpg', canvas.renderAll.bind(canvas));
        var json_data = '';

        responsiveCanvas();
        $(window).resize( responsiveCanvas );

        function responsiveCanvas()
        {
            $('.image-editor').each(function() {
              var sizeWidth = ($('#container-canvas').width())-30;
              $(this).attr('width', sizeWidth).width(sizeWidth);
              $('.canvas-container').width(sizeWidth);
            });

            //SAVE JSON DATA
            json_data = saveCanvas(canvas);

            //LOAD JSON DATA
            canvas.loadFromJSON(JSON.parse(json_data), function(obj) {
                canvas.renderAll();
            });
        }


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
                canvas.add(imgInstance).setActiveObject( imgInstance );
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
    });

    function saveCanvas(canvas)
    {
        json_data = JSON.stringify(canvas.toDatalessJSON());
        $.cookie('tfc-canvas', JSON.stringify(json_data));
        return json_data;
    }

    function init(canvas)
    {
        json_data = $('#loadCanvas').val();
        $.cookie('tfc-canvas', JSON.stringify(json_data));

        //LOAD JSON DATA
        canvas.loadFromJSON(JSON.parse(json_data), function(obj) {
            canvas.renderAll();
        });

        return json_data;
    }
  </script>
@endsection
