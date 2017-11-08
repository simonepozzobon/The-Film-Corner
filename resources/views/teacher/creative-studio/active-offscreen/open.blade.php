@extends('layouts.teacher', ['type' => 'app'])
@section('title', $app->title)
@section('stylesheets')
  <link href="http://vjs.zencdn.net/5.8.8/video-js.css" rel="stylesheet">
  <style media="screen">
    #video-library {
      overflow-y: scroll;
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
              Scene
            </div>
            <div id="video-player" class="box-body">
              <div class="embed-responsive embed-responsive-16by9">
                <video id="video-main" class="embed-responsive-item video-js" controls preload="auto" width="640" height="264">
                    <source src="{{ $session->main_video }}" type="video/mp4">
                </video>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="box yellow">
            <div class="box-header">
              Library
            </div>
            <div id="video-library" class="box-body">
              @foreach ($app->videos()->get() as $key => $video)
                <div class="row">
                  <div class="col-md-2">
                    <img src="{{ Storage::disk('local')->url($video->img) }}" width="57">
                  </div>
                  <div class="col-md-8">
                    <p class="p-2">{{ $video->title }}</p>
                  </div>
                  <div class="col-md-2">
                    <button class="change-video btn btn-yellow" data-video-src="{{ Storage::disk('local')->url($video->src) }}">
                      <i class="fa fa-plus" aria-hidden="true"></i>
                    </button>
                  </div>
                </div>
              @endforeach
            </div>
          </div>
        </div>
      </div>
      <div class="row mt">
        <div class="col">
          <div class="box orange">
            <div class="box-btns pt">
              <div class="btn-group">
                <button id="play" type="button" name="button" class="btn btn-orange">
                  <i class="fa fa-play" aria-hidden="true"></i>
                </button>
                <button id="pause" type="button" name="button" class="btn btn-orange">
                  <i class="fa fa-pause" aria-hidden="true"></i>
                </button>
                <button id="stop" type="button" name="button" class="btn btn-orange">
                  <i class="fa fa-stop" aria-hidden="true"></i>
                </button>
                <button id="rewind" type="button" name="button" class="btn btn-orange">
                  <i class="fa fa-backward" aria-hidden="true"></i>
                </button>
                <button id="forward" type="button" name="button" class="btn btn-orange">
                  <i class="fa fa-forward" aria-hidden="true"></i>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row mt">
        <div class="col-md-8">
          <div class="box green">
            <div class="box-header">
              Upload your offscreen video
            </div>
            <div class="box-body">
              <form id="uploadForm" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                {{ method_field('POST') }}
                <div class="form-group">
                  <input id="media" type="file" name="media" class="form-control">
                </div>
                <input id="videoRef" type="hidden" name="video_ref" value="21">
                <div class="container-fluid d-flex justify-content-around">
                  <button type="submit" name="button" class="btn btn-green"><i class="fa fa-upload" aria-hidden="true"></i> Upload</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="box blue">
            <div class="box-header">
              Video Uploaded
            </div>
            <div class="box-body">
              <div id="no-video" class="{{ $app_session->videos()->count() == 0 || $app_session->videos()->count() == null ? '' : 'd-none' }}">
                <span class="alert alert-warning d-block text-center">No video uploaded yet!</span>
              </div>
              <table id="videos" class="table table-hover {{ $app_session->videos()->count() > 0 ? '' : 'd-none' }}">
                <thead>
                  <th>Video</th>
                  <th></th>
                </thead>
                <tbody>
                  @foreach ($app_session->videos()->get() as $key => $video)
                    <tr id="video-{{ $video->id }}" class="video-uploaded">
                        <td><img src="{{ Storage::disk('local')->url($video->img) }}" width="57" class="img-fluid"></td>
                        <td>
                         <input id="video-id-src" type="hidden" name="" value="{{ $video->src }}">
                         <div class="btn-group">
                            <button type="button" class="btn btn-blue" onclick="videoPlay('{{ $video->src }}')"><i class="fa fa-play" aria-hidden="true"></i></button>
                            <button type="button" class="btn btn-blue" onclick="videoDelete({{ $video->id }})"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                          </div>
                        </td>
                     </tr>
                  @endforeach
                </tbody>
              </table>
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
  <script src="{{ asset('plugins/videojs/video.js') }}"></script>

  <script type="text/javascript">
    var AppSession = new TfcSessions();

    $(document).ready( libraryResize );
    document.getElementById('video-main').addEventListener('onresize', libraryResize);

    function libraryResize()
    {
        var video_player = document.getElementById('video-main').offsetHeight;
        $('#video-library').height(video_player);
    }

    var player = videojs('video-main', {
      controlBar: {
        playToggle: false,
        volumeMenuButton: false,
        fullscreenToggle: false,
      }
    });

    var videos = [];
    $('.video-uploaded').each(function(index, video) {
        var img_src = $(this).find('img').attr('src'),
            video_src = $(this).find('input').val(),
            new_video = {
              'img' : img_src,
              'video' : video_src
            };

            videos.push(new_video);
            localStorage.setItem('app-10-video-uploaded', JSON.stringify(videos));
        console.log('img', img_src);
        console.log('src', video_src);
    });
    console.log(videos);

    player.muted(true);

    player.ready(function() {
      $('.change-video').on('click', function(event) {
        event.preventDefault();
        player.pause();
        player.src($(this).data('video-src'));
        localStorage.setItem('app-10-video', $(this).data('video-src'));
        player.load();
      });
    });

    $('#play').on('click', function() {
      player.play();
    });

    $('#pause').on('click', function() {
      player.pause();
    });

    $('#stop').on('click', function() {
      player.pause().currentTime(0);
    });

    $('#rewind').on('click', function() {
      var time = player.currentTime();
      player.currentTime(time-5);
    });

    $('#forward').on('click', function() {
      var time = player.currentTime();
      player.currentTime(time+5);
    });

    $(document).ready(function()
    {
      var token = '{{ $app_session->token }}';

      $('form#uploadForm').submit(function(event) {
        event.preventDefault();


        var formData = new FormData();
        formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
        formData.append('media', $('#media')[0].files[0]);
        formData.append('video_ref', $('#videoRef').val());
        formData.append('session', token);

        $.ajax({
          type: 'post',
          url:  '{{ route('teacher.creative-studio.upload', [$app_category, $app->slug]) }}',
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          data: formData,
          processData: false,
          contentType: false,
          success: function (response) {
            console.log(response);
            $('#no-video').addClass('d-none');
            $('#videos').removeClass('d-none');
            var data = '';
            data += '<tr id="video-'+response.video_id+'">';
            data +=    '<td><img src="'+response.img+'" width="57" class="img-fluid"></td>';
            data +=    '<td>';
            data +=     '<input id="video-id-src" type="hidden" name="" value="'+response.src+'">';
            data +=     '<div class="btn-group">';
            data +=        '<button type="button" class="btn btn-blue" onclick="videoPlay(\''+response.src+'\')"><i class="fa fa-play" aria-hidden="true"></i></button>';
            data +=        '<button type="button" class="btn btn-blue" onclick="videoDelete('+response.video_id+')"><i class="fa fa-trash-o" aria-hidden="true"></i></button>';
            data +=      '</div>';
            data +=    '</td>';
            data += '</tr>';
            $('#videos').append(data);

            // add previous videos
            var video = {
                'img' : response.img,
                'video' : response.src
            };

            videos.push(video);
            localStorage.setItem('app-10-video-uploaded', JSON.stringify(videos));

          },
          error: function (errors) {
            console.log(errors);
          }
        });
      });
    }
    );
  </script>
@endsection
