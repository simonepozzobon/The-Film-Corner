@extends('layouts.teacher', ['type' => 'app'])
@section('title', $app->title)
@section('stylesheets')
@endsection
@section('content')
  <div class="container-fluid">
    @include('components.apps.heading_info', ['app' => $app, 'type' => 'teacher', 'student' => $is_student])
    <div class="row mt">
      <div class="col-md-8">
        <div class="box blue">
          <div class="box-header">
            {{ GeneralText::field('audio_track') }}
          </div>
          <div class="box-body">
            <div id="waveform"></div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="box yellow">
          <div class="box-header">
            {{ GeneralText::field('library') }}
          </div>
          <div class="box-body library">
            <nav class="navbar navbar-toggleable-sm navbar-library yellow">
              <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav" role="tablist">
                  <li class="nav-item">
                    <a class="library-link nav-link active" data-toggle="tab" href="#audio-library">{{ GeneralText::field('audio') }}</a>
                  </li>
                </ul>
              </div>
            </nav>
            <div id="libraries" class="library-container tab-content">
              <div id="audio-library" class="assets tab-pane active" role="tabpanel">
                <div class="row scroller">
                  <div class="col">
                    @foreach ($app->audios()->get() as $key => $audio)
                      <div class="row pb-3">
                        <div class="col-md-8">
                            <p id="audio-title-{{ $audio->id }}" class="d-block">{{ $audio->title }}</p>
                        </div>
                        <div class="col-md-4">
                          <a id="audio-{{ $audio->id }}" href="#" class="add-audio btn btn-secondary btn-yellow" data-audio-src="{{ Storage::disk('local')->url($audio->src) }}"><i class="fa fa-plus" aria-hidden="true"></i></a>
                        </div>
                      </div>
                    @endforeach
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row mt">
      <div class="col">
        <div class="box orange">
          <div class="box-btns pt">
            <button class="btn btn-orange" onclick="player.playPause()">
              <i class="fa fa-play" aria-hidden="true"></i> {{ GeneralText::field('play') }}
            </button>
          </div>
        </div>
      </div>
    </div>
    <div class="row mt">
      <div class="col">
        <div class="box green">
          <div class="box-header">
            {{ GeneralText::field('notes') }}
          </div>
          <div class="box-body">
            <textarea id="notes" name="notes" rows="8" class="form-control" placeholder="{{ GeneralText::field('whats_going_on_desc') }}">{{ $session->notes }}</textarea>
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

    libraryResize();

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

    function libraryResize()
    {
        var video_player = document.getElementById('waveform').offsetHeight + 128;
        $('#libraries').height(video_player);

        var libraryEl = document.getElementById('libraries');

        // creo l'evento personalizzato che verrà triggerato dalla funzione libraryResize
        var event = document.createEvent('HTMLEvents');
        event.initEvent('library-resized', true, true);

        // target can be any Element or other EventTarget.
        libraryEl.dispatchEvent(event);
    }

  </script>
@endsection
