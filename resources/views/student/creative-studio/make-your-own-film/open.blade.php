@extends('layouts.student', ['type' => 'app'])
@section('title', 'Make Your Own Film')
@section('stylesheets')
  <link href="//vjs.zencdn.net/5.8.8/video-js.css" rel="stylesheet">
@endsection
@section('content')
  <div class="container-fluid">
    @php
      $options = [
        'save' => false,
        'close-warning' => false,
      ];
    @endphp
    @include('components.apps.heading_info', ['app' => $app, 'type' => 'student', 'student' => $is_student, 'options' => $options])
    <div id="app">
      <div class="row mt">
        <div class="col">
          <div class="box blue">
            <div class="box-header">
              {{ GeneralText::field('your_submission') }}
            </div>
            <div class="box-body">
              @foreach ($app_session->videos()->get() as $key => $video)
                <div class="row">
                  <div class="col">
                    <div class="embed-responsive embed-responsive-16by9">
                      <video id="video" class="embed-responsive-item video-js" controls preload="auto" width="640" height="264">
                          <source src="{{ Storage::disk('local')->url($video->src) }}" type="video/mp4">
                      </video>
                    </div>
                  </div>
                </div>
              @endforeach
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  @if ($app_session->teacher_shared == 1)
    @include('components.apps.chat', ['app_session' => $app_session])
  @endif
@endsection
@section('scripts')
  <script src="{{ mix('js/teacher-chat.js') }}"></script>
  <script src="{{ asset('plugins/videojs/video.js') }}"></script>
  <script>
    var AppSession = new TfcSessions();
    var player = videojs('video');
  </script>
@endsection
