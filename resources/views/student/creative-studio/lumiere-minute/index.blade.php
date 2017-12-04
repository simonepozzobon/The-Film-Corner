@extends('layouts.student', ['type' => 'app'])
@section('title', $app->title)
@section('stylesheets')

@endsection
@section('content')
  <div class="container-fluid">
    @include('components.apps.heading_info', ['app' => $app, 'type' => 'student'])
    <div id="app">
      <div class="row mt">
        <div class="col">
          <div class="box blue">
            <div class="box-header">
              Submission
            </div>
            <div id="response" class="box-body">
              <form id="uploadForm" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                {{ method_field('POST') }}
                <div class="form-group">
                  <input id="media" type="file" name="media" class="form-control">
                </div>
                <input id="videoRef" type="hidden" name="video_ref" value="21">
                <div class="container-fluid d-flex justify-content-around">
                  <button type="submit" name="button" class="btn btn-blue"><i class="fa fa-upload" aria-hidden="true"></i> Upload</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('scripts')
  <script>
    var AppSession = new TfcSessions();
    var session = AppSession.initSession({{ $app->id }});

    $('body').on('session-loaded', function(e, session){
      console.log('sessione caricata '+session.token);

      $('form#uploadForm').submit(function(event) {
        event.preventDefault();
        $(this).addClass('disable');

        var formData = new FormData();
        formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
        formData.append('media', $('#media')[0].files[0]);
        formData.append('session', session.token);

        $.ajax({
          type: 'post',
          url:  '{{ route('student.creative-studio.upload', [$app_category, $app->slug]) }}',
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          data: formData,
          processData: false,
          contentType: false,
          success: function (response) {
            console.log(response);
            $('#error').remove();
            $('#uploadForm').remove();
            var data = '';
            data += '<h3 class="text-center pb-4 text-success">Your video has been sent!</h3>';
            data += '<h6 class="text-center pb-4 text-success">One last step, give it a title and save it!</h6>';
            $('#response').append(data);

            var video = {
                'img' : response.img,
                'video' : response.src
            };

            localStorage.setItem('app-16-video', JSON.stringify(video));
          },
          error: function (errors) {
            console.log(errors);
            $('#error').remove();
            var data = '';
            data += '<h6 id="error" class="text-center py-4 text-danger">'+errors.responseJSON.msg+'</h6>'
            $('#response').append(data);
          }
        });
      });
    });
  </script>
@endsection
