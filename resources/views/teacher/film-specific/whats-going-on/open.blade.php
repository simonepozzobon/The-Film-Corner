@extends('layouts.teacher', ['type' => 'app'])
@section('title', $app->title)
@section('stylesheets')
@endsection
@section('content')
  <div class="container-fluid">
    @include('components.apps.heading_only', ['title' => $app->title])
    @include('components.apps.sidebar-menu', ['app' => $app, 'type' => 'teacher', 'student' => $is_student])
    <div class="row mt">
      <div class="col-md-8">
        <div class="box blue">
          <div class="box-header">
            Audio Track
          </div>
          <div class="box-body">
            <div id="waveform"></div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="box yellow">
          <div class="box-header">
            Library
          </div>
          <div class="box-body">
            <ul class="list-unstyled">
              @foreach ($app->audios()->get() as $key => $audio)
                <li class="pb-3">
                  <div class="d-flex justify-content-between">
                    <p id="audio-title-{{ $audio->id }}" class="d-block">{{ $audio->title }}</p>
                    <a id="audio-{{ $audio->id }}" href="#" class="add-audio btn btn-secondary btn-yellow" data-audio-src="{{ Storage::disk('local')->url($audio->src) }}"><i class="fa fa-plus" aria-hidden="true"></i></a>
                  </div>
                </li>
              @endforeach
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="row mt">
      <div class="col">
        <div class="box orange">
          <div class="box-btns pt">
            <button class="btn btn-orange" onclick="player.playPause()">
              <i class="fa fa-play" aria-hidden="true"></i> Play
            </button>
          </div>
        </div>
      </div>
    </div>
    <div class="row mt">
      <div class="col">
        <div class="box green">
          <div class="box-header">
            Notes
          </div>
          <div class="box-body">
            <textarea id="notes" name="notes" rows="8" class="form-control" placeholder="Listen to the audioclip and try to guess what’s happening">{{ $session->notes }}</textarea>
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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/wavesurfer.js/1.2.3/wavesurfer.min.js"></script>
  <script>
    var AppSession = new TfcSessions();

    var player = WaveSurfer.create({
      container: '#waveform',
      waveColor: '#252525',
      progressColor: 'purple',
      splitChannels: true,
      height: 64
    });

    var src = '{{ $session->audio }}'
    player.load(src);
    localStorage.setItem('app-7-audio', src);
    // $.cookie('tfc-audio', JSON.stringify(src));

    $('.add-audio').on('click', function () {
        var audio_src = $(this).data('audio-src');
        if (player.isPlaying()) {
          player.stop();
        }
        console.log(audio_src);
        player.load(audio_src);
        localStorage.setItem('app-7-audio', audio_src);
    });

  </script>
@endsection
