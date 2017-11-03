@extends('layouts.teacher', ['type' => 'app'])
@section('stylesheets')
  <link href="http://vjs.zencdn.net/5.8.8/video-js.css" rel="stylesheet">
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
        <div class="col-12">
          <div class="row">
            <div class="col-md-6">
              <div class="box container-fluid mb-4">
                <div class="row">
                  <div class="col dark-blue py-3 px-5">
                    <h3>First Video</h3>
                  </div>
                </div>
                <div class="row">
                  <div id="video-player-left" class="col blue p-5">
                    <div class="embed-responsive embed-responsive-16by9">
                      <video id="video-left" class="embed-responsive-item video-js" controls preload="auto" width="640" height="264">
                          <source src="{{ $left }}" type="video/mp4">
                      </video>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="box container-fluid mb-4">
                <div class="row">
                  <div class="col dark-yellow py-3 px-5">
                    <h3>Second Video</h3>
                  </div>
                </div>
                <div class="row">
                  <div id="video-player-right" class="col yellow p-5">
                    <div class="embed-responsive embed-responsive-16by9">
                      <video id="video-right" class="embed-responsive-item video-js" controls preload="auto">
                          <source src="{{ $right }}" type="video/mp4">
                      </video>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col">
          <div class="box container-fluid mb-4">
            <div class="row">
              <div class="col orange p-5">
                <div class="col d-flex justify-content-center">
                  {{-- Control Bar --}}
                  <div class="btn-group pr-4">
                    <button id="reload" type="button" name="button" class="btn btn-secondary btn-orange">
                      <i class="fa fa-refresh" aria-hidden="true"></i>
                    </button>
                  </div>
                  <div class="btn-group">
                    <button id="play" type="button" name="button" class="btn btn-secondary btn-orange">
                      <i class="fa fa-play" aria-hidden="true"></i>
                    </button>
                    <button id="pause" type="button" name="button" class="btn btn-secondary btn-orange">
                      <i class="fa fa-pause" aria-hidden="true"></i>
                    </button>
                    <button id="stop" type="button" name="button" class="btn btn-secondary btn-orange">
                      <i class="fa fa-stop" aria-hidden="true"></i>
                    </button>
                    <button id="rewind" type="button" name="button" class="btn btn-secondary btn-orange">
                      <i class="fa fa-backward" aria-hidden="true"></i>
                    </button>
                    <button id="forward" type="button" name="button" class="btn btn-secondary btn-orange">
                      <i class="fa fa-forward" aria-hidden="true"></i>
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <div class="box container-fluid mb-4">
            <div class="row">
              <div class="col dark-green py-3 px-5">
                <h3>Notes</h3>
              </div>
            </div>
            <div class="row">
              <div class="col green p-5">
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
  <script src="{{ asset('plugins/videojs/video.js') }}"></script>
  <script type="text/javascript">
    var AppSession = new TfcSessions();
    AppSession.initSession({{ $app->id }});

    var string = '{{ $library }}',
        videos = JSON.parse(string.replace(/&quot;/g,'"'));
        lenght = Object.keys(videos).length;
        console.log(lenght);

    var left = videojs('video-left', {
        controlBar: {
          playToggle: false,
          volumeMenuButton: false,
          fullscreenToggle: false,
        }
    });

    var right = videojs('video-right', {
        controlBar: {
          playToggle: false,
          volumeMenuButton: false,
          fullscreenToggle: false,
        }
    });

    left.ready(function() {
        localStorage.setItem('app-6-video-left', left.src());
    });

    right.ready(function() {
        localStorage.setItem('app-6-video-right', right.src());
    });

    $('#play').on('click', function() {
        left.play();
        right.play();
    });

    $('#pause').on('click', function() {
        left.pause();
        right.pause();
    });

    $('#stop').on('click', function() {
        left.pause().currentTime(0);
        right.pause().currentTime(0);
    });

    $('#rewind').on('click', function() {
        var time = left.currentTime();
        left.currentTime(time-5);
        right.currentTime(time-5);
    });

    $('#forward').on('click', function() {
        var time = left.currentTime();
        left.currentTime(time+5);
        right.currentTime(time+5);
    });

    $('#reload').on('click', function() {
        var left_id = Math.floor(Math.random() * lenght),
            right_id = Math.floor(Math.random() * lenght);

        while (left_id == right_id) {
          right_id = Math.floor(Math.random() * lenght);
        }

        left.pause();
        right.pause();
        left.src(videos[left_id]);
        right.src(videos[right_id]);
        left.load();
        right.load();
        localStorage.setItem('app-6-video-left', left.src());
        localStorage.setItem('app-6-video-right', right.src());

    });

  </script>
@endsection
