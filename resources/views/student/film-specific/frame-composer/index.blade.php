@extends('layouts.student', ['type' => 'app'])
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
  @include('components.apps.sidebar-menu', ['app' => $app])
  <div class="p-5">
  </div>
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
      <div class="row" style="background-color: {{ $app->colors[1] }}; color: #252525">
        <div class="col">
          <div class="d-flex justify-content-start">
            <div class="mr-auto"><h3 class="ml-2 pt-4 pb-1">{{ $app->title }}</h3></div>
          </div>
        </div>
      </div>
      <div class="row" style="background-color: {{ $app->colors[0] }}; color: #252525">
        <div class="col">
          <div class="clearfix p-5">

            <div class="row pb-5">
              <div class="col-md-8">
                <div class="frame container-fluid bg-faded p-4">
                  <h3 class="text-center pb-4">Build Your Scene</h3>
                  <div class="row pb-5">
                    <div id="container-canvas" class="col d-flex justify-content-around">
                      <canvas class="image-editor" id="image-editor" width="2048" height="500"></canvas>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="frame container-fluid bg-faded p-4">
                  <h3 class="text-center pb-4">Items</h3>
                  <ul class="assets list-unstyled row">
            				<li class="col-md-3"><img src="{{ asset('img/helpers/apps/character-builder/men.png') }}" alt="image asset" width="80" class="img-fluid w-100"/>
                      <a href="" class="abs-btn btn btn-sm btn-danger d-none"><i class="fa fa-times" aria-hidden="true"></i></a>
                    </li>
            				<li class="col-md-3"><img src="{{ asset('img/helpers/apps/character-builder/dress.png') }}" alt="image asset" width="80" class="img-fluid w-100"/>
                      <a href="" class="abs-btn btn btn-sm btn-danger d-none"><i class="fa fa-times" aria-hidden="true"></i></a>
                    </li>
            				<li class="col-md-3"><img src="{{ asset('img/helpers/apps/character-builder/trouser.png') }}" alt="image asset" width="80" class="img-fluid w-100"/>
                      <a href="" class="abs-btn btn btn-sm btn-danger d-none"><i class="fa fa-times" aria-hidden="true"></i></a>
                    </li>
            				<li class="col-md-3"><img src="{{ asset('img/helpers/apps/character-builder/head_1.png') }}" alt="image asset" width="80" class="img-fluid w-100"/>
                      <a href="" class="abs-btn btn btn-sm btn-danger d-none"><i class="fa fa-times" aria-hidden="true"></i></a>
                    </li>
            				<li class="col-md-3"><img src="{{ asset('img/helpers/apps/character-builder/head_2.png') }}" alt="image asset" width="80" class="img-fluid w-100"/>
                      <a href="" class="abs-btn btn btn-sm btn-danger d-none"><i class="fa fa-times" aria-hidden="true"></i></a>
                    </li>
            			</ul>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col">
                <div class="container-fluid frame bg-faded p-4">
                  <textarea id="notes" name="notes" rows="8" class="form-control"></textarea>
                </div>
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
    var session = AppSession.initSession({{ $app->id }});




    $(document).ready(function($) {
        var canvas = this.__canvas = new fabric.Canvas('image-editor');
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
            json_data = JSON.stringify(canvas.toDatalessJSON());

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
              // var width = $image.width() / $image.height() * canvas.height / 3;
              var width = $image.prop('naturalWidth');
              // var height = $image.height() / $image.width() * width;
              var height = $image.prop('naturalHeight');
              var imgInstance = new fabric.Image($image[0], {
                width  : width,
                height : height,
                transparentCorners : false,
              });
              parent.children('a').removeClass('d-none')
              $this.data('image-image-obj', imgInstance);
              canvas.add(imgInstance).setActiveObject( imgInstance );

              // salvo in json
              saveCanvas(canvas);
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
      // Save canvas to JSON for future edit
      json_data = JSON.stringify(canvas.toDatalessJSON());
      $.cookie('tfc-canvas', JSON.stringify(json_data));

      // Save image to local storage
      localStorage.setItem('app-1-image', canvas.toDataURL('png'));

      return json_data;
    }
  </script>
@endsection
