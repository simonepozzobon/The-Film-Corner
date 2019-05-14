@extends('layouts.student', ['type' => 'app'])
@section('title', $app->title)
@section('stylesheets')
@endsection
@section('content')
    <div class="container-fluid">
        @include('components.apps.heading_info', ['app' => $app, 'type' => 'student'])
        <div id="soundscapes">
            <soundscapes
                ref="app"
                preview_text="{{ GeneralText::field('your_scene') }}"
                library_text="{{ GeneralText::field('library') }}"
                random_image="{{ $random_image }}"
                library_audio="{{ $app->audios()->get() }}"
                library_media="{{ $app->medias()->get() }}"
            >
            </soundscapes>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ mix('js/soundscapes.js') }}"></script>
    <script>
        var AppSession = new TfcSessions();
        var session = AppSession.initSession({{ $app->id }});

        resizeLibrary();
        player = document.getElementById('player');
        player.addEventListener('onresize', resizeLibrary);

        function resizeLibrary()
        {
            var video_player = document.getElementById('player').offsetHeight - 42;
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
