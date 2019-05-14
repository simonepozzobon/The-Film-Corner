@extends('layouts.teacher', ['type' => 'app'])
@section('title', $app->title)
@section('stylesheets')

@endsection
@section('content')
  <div class="container-fluid">
    @include('components.apps.heading_info', ['app' => $app, 'type' => 'teacher'])
    <div id="app">
      <div class="row mt">
        <div class="col-md-8">
          <form class="" action="" method="">
            <div id="storyboard" class="row">
            </div>
          </form>
        </div>
        <div class="col-md-4">
          <div class="box yellow">
            <div class="box-header">
              {{ GeneralText::field('library') }}
            </div>
            <div class="box-body library">
              <nav class="navbar navbar-expand-sm navbar-library yellow">
                <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                  <ul class="navbar-nav" role="tablist">
                    <li class="nav-item">
                      <a class="library-link nav-link active" data-toggle="tab" href="#uploads">{{ GeneralText::field('upload') }}</a>
                    </li>
                  </ul>
                </div>
              </nav>
              <div id="libraries" class="library-container tab-content">
                <div id="uploads" class="assets tab-pane active" role="tabpanel">
                    <div class="row scroller">
                        <div class="col">
                            <upload-form
                                csrf_field="{{ csrf_token() }}"
                                app_id="{{ $app->id }}"
                                route="{{ route('teacher.creative-studio.upload.img', [$app_category, $app->slug]) }}">
                            </upload-form>
                            <ul id="upload-assets" class="pt-3 assets row list-unstyled">
                    		  @foreach ($app->medias()->get() as $key => $media)
                    			@if ($media->category_id == 2)
                    			  <li class="col-md-3 asset">
                    				<img src="{{ Storage::disk('local')->url($media->src) }}" class="img-fluid w-100">
                    			  </li>
                    			@endif
                    		  @endforeach
                    		</ul>
                        </div>
                    </div>
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
    <script src="{{ mix('js/upload.js') }}"></script>
    <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        var AppSession = new TfcSessions();
        var session = AppSession.initSession({{ $app->id }});


        $('#storyboard').sortable();
        var counter = 0;

        var token = null;
        $('body').on('session-loaded', function(e, session) {
            console.log('sessione caricata '+session.token);
            token = session.token
            $('#session-token').val(session.token)

            resizeLibrary();
            var session = $.parseJSON($.cookie('tfc-sessions'));

            // Storyboard appen frame
            $('#upload-assets').on('click', 'li', function(e){
                e.preventDefault();
                if (counter <= 9) {
                  counter++;

                  var src = $(this).children('img').attr('src');

                  var data = '';
                  data +='<div id="frame-container-'+counter+'" class="col-md-6 mt story">';
                  data +=  '<div class="box blue">';
                  data +=    '<div class="box-header">';
                  data +=      'Frame '+counter+'';
                  data +=      '<input type="hidden" name="frame_title" value="Frame '+counter+'">';;
                  data +=    '</div>';
                  data +=    '<div class="box-body">';
                  data +=      '<img id="frame-img-'+counter+'" src="'+src+'" class="img-fluid">';
                  data +=      '<div class="form-group pt">';
                  data +=        '<textarea id="frame-'+counter+'" name="frame-'+counter+'" class="form-control" rows="8"></textarea>';
                  data +=        '<p id="frame-content-'+counter+'" class="invisible"></p>';
                  data +=      '</div>';
                  data +=    '</div>';
                  data +=    '<div class="box-btns">';
                  data +=      '<a onclick="save('+counter+')" class="btn btn-blue"><i class="fa fa-floppy-o" aria-hidden="true"></i></a>';
                  data +=      '<a onclick="edit('+counter+')" class="btn btn-blue"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
                  data +=      '<a onclick="destroy('+counter+')" class="btn btn-blue"><i class="fa fa-trash-o" aria-hidden="true"></i></a>';
                  data +=    '</div>';
                  data +=  '</div>';
                  data +='</div>';

                  $('#storyboard').append(data);
                } else {
                  alert('limit reached');
                }

            });

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

        function resizeLibrary() {
            var libraryEl = document.getElementById('libraries');

            // creo l'evento personalizzato che verrà triggerato dalla funzione libraryResize
            var event = document.createEvent('HTMLEvents');
            event.initEvent('library-resized', true, true);

            // target can be any Element or other EventTarget.
            libraryEl.dispatchEvent(event);
        }

    </script>
@endsection
