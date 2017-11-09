@extends('layouts.student', ['type' => 'app'])
@section('title', $app->title)
@section('stylesheets')

@endsection
@section('content')
  <div class="container-fluid">
    @include('components.apps.heading_info', ['app' => $app])
    @include('components.apps.sidebar-menu', ['app' => $app, 'type' => 'student', 'student' => $is_student])
    <div id="app">
      <div class="row">
        <div class="col-md-8">
          <form class="" action="" method="">
            <div id="storyboard" class="row">
              @foreach ($session as $key => $story)
                <div id="frame-container-{{ $story->order }}" class="col-md-6 mt story">
                  <div class="box blue">
                    <div class="box-header">
                      Frame {{ $story->order }}
                      <input type="hidden" name="frame_title" value="Frame {{ $story->order }}">
                    </div>
                    <div class="box-body">
                      <img id="frame-img-{{ $story->order }}" src="{{ $story->img }}" class="img-fluid">
                      <div class="form-group pt">
                        <textarea id="frame-{{ $story->order }}" name="frame-{{ $story->order }}" class="form-control" rows="8">{{ $story->description }}</textarea>
                        <p id="frame-content-{{ $story->order }}" class="invisible"></p>
                      </div>
                    </div>
                    <div class="box-btns">
                      <a onclick="save({{ $story->order }})" class="btn btn-blue"><i class="fa fa-floppy-o" aria-hidden="true"></i></a>
                      <a onclick="edit({{ $story->order }})" class="btn btn-blue"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                      <a onclick="destroy({{ $story->order }})" class="btn btn-blue"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                    </div>
                  </div>
                </div>
              @endforeach
            </div>
          </form>
        </div>
        <div class="col-md-4 mt">
          <div class="box yellow">
            <div class="box-header">
              Library
            </div>
            <div class="box-body">
              <form id="uploadForm" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                {{ method_field('POST') }}
                <div class="d-flex justify-content-between">
                  <input id="media" type="file" name="media" class="form-control">
                  <button id="upload" type="submit" name="button" class="btn btn-yellow"><i class="fa fa-upload" aria-hidden="true"></i></button>
                </div>
              </form>
              <ul id="assets" class="assets row mt list-unstyled">
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

      });

      $('form#uploadForm').submit(function(e) {
        e.preventDefault();

        var formData = new FormData();
        formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
        formData.append('media', $('#media')[0].files[0]);
        formData.append('session_token', session[0].token);

        $.ajax({
          type: 'post',
          url:  '{{ route('student.creative-studio.upload.img', [$app_category, $app->slug]) }}',
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          data: formData,
          processData: false,
          contentType: false,
          success: function (response) {
            console.log(response);

            var data = '';
            data += '<li class="col-md-3 asset">';
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
