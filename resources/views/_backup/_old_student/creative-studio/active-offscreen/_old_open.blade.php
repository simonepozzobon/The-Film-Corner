@extends('layouts.student', ['type' => 'app'])
@section('stylesheets')
  <link href="//vjs.zencdn.net/5.8.8/video-js.css" rel="stylesheet">
@endsection
@section('content')
  @include('components.apps.sidebar-menu', ['app' => $app, 'type' => 'student'])
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
            <div class="row">
              <div class="col-md-8">
                <div class="embed-responsive embed-responsive-16by9">
                  <video id="video-left" class="embed-responsive-item video-js" controls preload="auto" width="640" height="264">
                      <source src="//vjs.zencdn.net/v/oceans.mp4" type="video/mp4">
                  </video>
                </div>
              </div>
              <div class="col-md-4">
                <div class="frame container-fluid bg-faded p-4">
                  <h6>Library</h6>
                  <table class="table table-hover">
                    <tbody>
                      <tr>
                        <td><img src="{{ asset('img/helpers/null-image.png') }}" class="img-fluid" width="57"></td>
                        <td>
                          <button type="button" name="button" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i></button>
                        </td>
                      </tr>
                      <tr>
                        <td><img src="{{ asset('img/helpers/null-image.png') }}" class="img-fluid" width="57"></td>
                        <td>
                          <button type="button" name="button" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i></button>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div class="row py-4">
              <div class="col-md-8 d-flex justify-content-around">
                {{-- Control Bar --}}
                  <div class="btn-group">
                    <button id="play" type="button" name="button" class="btn btn-secondary">
                      <i class="fa fa-play" aria-hidden="true"></i>
                    </button>
                    <button id="pause" type="button" name="button" class="btn btn-secondary">
                      <i class="fa fa-pause" aria-hidden="true"></i>
                    </button>
                    <button id="stop" type="button" name="button" class="btn btn-secondary">
                      <i class="fa fa-stop" aria-hidden="true"></i>
                    </button>
                    <button id="rewind" type="button" name="button" class="btn btn-secondary">
                      <i class="fa fa-backward" aria-hidden="true"></i>
                    </button>
                    <button id="forward" type="button" name="button" class="btn btn-secondary">
                      <i class="fa fa-forward" aria-hidden="true"></i>
                    </button>
                  </div>

              </div>
            </div>
            <div class="row">
              <div class="col-md-8">
                <div class="frame container-fluid bg-faded p-4">
                  <h3 class="text-center pb-4">Upload your offscreen video</h3>
                  <div class="row pb-5">
                    <div class="col-md-4 offset-md-4">
                      <form id="uploadForm" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        {{ method_field('POST') }}
                        <div class="form-group">
                          <input id="media" type="file" name="media" class="form-control">
                        </div>
                        <input id="videoRef" type="hidden" name="video_ref" value="21">
                        <div class="container-fluid d-flex justify-content-around">
                          <button type="submit" name="button" class="btn btn-primary"><i class="fa fa-upload" aria-hidden="true"></i> Upload</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="frame container-fluid bg-faded p-4">
                  <h3 class="text-center pb-4">Video Uploaded</h3>
                  <div id="no-video" class="pb-5 {{ $app_session->videos()->count() == 0 || $app_session->videos()->count() == null ? '' : 'd-none' }}">
                    <span class="alert alert-warning d-block text-center">No video uploaded yet!</span>
                  </div>
                  <table id="videos" class="table table-hover {{ $app_session->videos()->count() > 0 ? '' : 'd-none' }}">
                    <thead>
                      <th>Video</th>
                      <th></th>
                    </thead>
                    <tbody>
                      @foreach ($app_session->videos()->get() as $key => $video)
                        <tr id="video-{{ $video->id }}">
                            <td><img src="{{ Storage::disk('local')->url($video->img) }}" width="57" class="img-fluid"></td>
                            <td>
                             <input id="video-id-src" type="hidden" name="" value="{{ $video->src }}">
                             <div class="btn-group">
                                <button type="button" class="btn btn-primary" onclick="videoPlay('{{ $video->src }}')"><i class="fa fa-play" aria-hidden="true"></i></button>
                                <button type="button" class="btn btn-danger" onclick="videoDelete({{ $video->id }})"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
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
    </div>
  </div>
@endsection
@section('scripts')
   <script src="{{ asset('plugins/videojs/video.js') }}"></script>

  <script type="text/javascript">
    var AppSession = new TfcSessions();

    var player = videojs('video-left', {
      controlBar: {
        playToggle: false,
        volumeMenuButton: false,
        fullscreenToggle: false,
      }
    });

    player.muted(true);

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
      var session = $.parseJSON($.cookie('tfc-sessions'));

      $('form#uploadForm').submit(function(event) {
        event.preventDefault();

        var formData = new FormData();
        formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
        formData.append('media', $('#media')[0].files[0]);
        formData.append('video_ref', $('#videoRef').val());
        formData.append('session', session[0].token);

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
            $('#no-video').addClass('d-none');
            $('#videos').removeClass('d-none');
            var data = '';
            data += '<tr id="video-'+response.video_id+'">';
            data +=    '<td><img src="'+response.img+'" width="57" class="img-fluid"></td>';
            data +=    '<td>';
            data +=     '<input id="video-id-src" type="hidden" name="" value="'+response.src+'">';
            data +=     '<div class="btn-group">';
            data +=        '<button type="button" class="btn btn-primary" onclick="videoPlay(\''+response.src+'\')"><i class="fa fa-play" aria-hidden="true"></i></button>';
            data +=        '<button type="button" class="btn btn-danger" onclick="videoDelete('+response.video_id+')"><i class="fa fa-trash-o" aria-hidden="true"></i></button>';
            data +=      '</div>';
            data +=    '</td>';
            data += '</tr>';
            $('#videos').append(data);
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
