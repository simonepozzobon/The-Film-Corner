@extends('layouts.teacher', ['type' => 'app'])
@section('title', 'Frame Crop')
@section('stylesheets')

@endsection
@section('content')
  <section id="title" class="pt-5">
    <div class="title sp-center pt-5 pb-5">
      {{ $app->title }}
      <h2 class="p-2 block-title">{{ $app_category->name }}</h2>
    </div>
  </section>
  @include('components.apps.sidebar-menu', ['app' => $app, 'type' => 'teacher'])
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
      <div class="row">
        <div class="col-md-8">
          <form class="" action="" method="">
            <div id="storyboard" class="row">
              @foreach ($session as $key => $story)
                <div id="frame-container-{{ $story->order }}" class="col-md-6 story">
                  <div class="box container-fluid mb-4">
                    <div class="row">
                      <div class="col dark-blue py-3 px-5">
                        <h3>Frame {{ $story->order }}</h3>
                        <input type="hidden" name="frame_title" value="Frame {{ $story->order }}">
                      </div>
                    </div>
                    <div class="row">
                      <div class="col blue p-5">
                        <img id="frame-img-{{ $story->order }}" src="{{ $story->img }}" class="img-fluid">
                        <div class="form-group pt-3">;
                          <textarea id="frame-{{ $story->order }}" name="frame-{{ $story->order }}" class="form-control" rows="8">{{ $story->description }}</textarea>
                          <p id="frame-content-{{ $story->order }}" class="invisible"></p>
                        </div>
                        <div class=" d-flex justify-content-around">
                          <div class="btn-group">
                            <a onclick="save({{ $story->order }})" class="btn btn-secondary btn-blue"><i class="fa fa-floppy-o" aria-hidden="true"></i></a>
                            <a onclick="edit({{ $story->order }})" class="btn btn-secondary btn-blue"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                            <a onclick="destroy({{ $story->order }})" class="btn btn-secondary btn-blue"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              @endforeach
            </div>
          </form>
        </div>
        <div class="col-md-4">
          <div class="box container-fluid mb-4">
            <div class="row">
              <div class="col dark-yellow py-3 px-5">
                <h3>Library</h3>
              </div>
            </div>
            <div class="row">
              <div class="col yellow p-5">
                <form id="uploadForm" method="post" enctype="multipart/form-data">
                  {{ csrf_field() }}
                  {{ method_field('POST') }}
                  <div class="d-flex justify-content-between pb-4">
                    <input id="media" type="file" name="media" class="form-control">
                    <button id="upload" type="submit" name="button" class="btn btn-secondary btn-yellow"><i class="fa fa-upload" aria-hidden="true"></i></button>
                  </div>
                </form>
                <ul id="assets" class="assets row list-unstyled">
                  <li class="col-md-3 pb-4 asset">
                    <img src="{{ asset('img/helpers/apps/storyboard/story_1.png') }}" class="img-fluid w-100">
                  </li>
                  <li class="col-md-3 pb-4 asset">
                    <img src="{{ asset('img/helpers/apps/storyboard/story_2.png') }}" class="img-fluid w-100">
                  </li>
                  <li class="col-md-3 pb-4 asset">
                    <img src="{{ asset('img/helpers/apps/storyboard/story_3.png') }}" class="img-fluid w-100">
                  </li>
                  <li class="col-md-3 pb-4 asset">
                    <img src="{{ asset('img/helpers/apps/storyboard/story_4.png') }}" class="img-fluid w-100">
                  </li>
                  <li class="col-md-3 pb-4 asset">
                    <img src="{{ asset('img/helpers/apps/storyboard/story_5.png') }}" class="img-fluid w-100">
                  </li>
                  <li class="col-md-3 pb-4 asset">
                    <img src="{{ asset('img/helpers/apps/storyboard/story_6.png') }}" class="img-fluid w-100">
                  </li>
                  <li class="col-md-3 pb-4 asset">
                    <img src="{{ asset('img/helpers/apps/storyboard/story_7.png') }}" class="img-fluid w-100">
                  </li>
                  <li class="col-md-3 pb-4 asset">
                    <img src="{{ asset('img/helpers/apps/storyboard/story_8.png') }}" class="img-fluid w-100">
                  </li>
                </ul>
              </div>
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
  <script src="{{ mix('js/teacher-chat.js') }}"></script>
  <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
    var AppSession = new TfcSessions();

    $('#storyboard').sortable();
    var counter = 0;

    $(document).ready(function(){

      var session = $.parseJSON($.cookie('tfc-sessions'));

      // Storyboard appen frame
      $('#assets').on('click', 'li', function(e){
          e.preventDefault();
          counter++;

          var src = $(this).children('img').attr('src');

          var data = '';
          data += '<div id="frame-container-'+counter+'" class="col-md-6 story">';
          data +=   '<div class="box container-fluid mb-4">';
          data +=     '<div class="row">';
          data +=       '<div class="col dark-blue py-3 px-5">';
          data +=         '<h3>Frame '+counter+'</h3>';
          data +=         '<input type="hidden" name="frame_title" value="Frame 1">';
          data +=       '</div>';
          data +=     '</div>';
          data +=     '<div class="row">';
          data +=       '<div class="col blue p-5">';
          data +=         '<img id="frame-img-'+counter+'" src="'+src+'" class="img-fluid">';
          data +=         '<div class="form-group pt-3">';;
          data +=           '<textarea id="frame-'+counter+'" name="frame-'+counter+'" class="form-control" rows="8"></textarea>';
          data +=           '<p id="frame-content-'+counter+'" class="invisible"></p>';
          data +=         '</div>';
          data +=         '<div class=" d-flex justify-content-around">';
          data +=           '<div class="btn-group">';
          data +=             '<a onclick="save('+counter+')" class="btn btn-secondary btn-blue"><i class="fa fa-floppy-o" aria-hidden="true"></i></a>';
          data +=             '<a onclick="edit('+counter+')" class="btn btn-secondary btn-blue"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
          data +=             '<a onclick="destroy('+counter+')" class="btn btn-secondary btn-blue"><i class="fa fa-trash-o" aria-hidden="true"></i></a>';
          data +=           '</div>';
          data +=         '</div>';
          data +=       '</div>';
          data +=     '</div>';
          data +=   '</div>';
          data += '</div>';

          $('#storyboard').append(data);

      });

      $('form#uploadForm').submit(function(e) {
        e.preventDefault();

        var formData = new FormData();
        formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
        formData.append('media', $('#media')[0].files[0]);
        formData.append('session_token', session[0].token);

        $.ajax({
          type: 'post',
          url:  '{{ route('teacher.creative-studio.upload.img', [$app_category, $app->slug]) }}',
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          data: formData,
          processData: false,
          contentType: false,
          success: function (response) {
            console.log(response);

            var data = '';
            data += '<li class="col-md-3 pb-4 asset">';
            data +=  '<img src="'+response.img+'" class="img-fluid w-100">';
            data += '</li>';

            $('#assets').prepend(data);
          },
          error: function (errors) {
            console.log(errors);
          }
        });
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

  </script>
@endsection
