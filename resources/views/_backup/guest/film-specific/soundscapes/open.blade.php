@extends('layouts.guest', ['type' => 'app'])
@section('title', $app->title)
@section('stylesheets')
@endsection
@section('content')
    <div class="container-fluid">
        @include('components.apps.heading_info', ['app' => $app, 'type' => 'guest', 'student' => $is_student])
        <div id="soundscapes">
            <soundscapes
                ref="app"
                preview_text="{{ GeneralText::field('your_scene') }}"
                library_text="{{ GeneralText::field('library') }}"
                random_image="{{ $session->image }}"
                library_audio="{{ $app->audios()->get() }}"
                library_media="{{ $app->medias()->get() }}"
                :open="true"
                vol="{{$session->audio_vol}}"
                src="{{$session->audio_src}}"
            >
            </soundscapes>
        </div>
    </div>
    @if ($is_student)
        @include('components.apps.chat', ['app_session' => $app_session])
    @endif
@endsection
@section('scripts')
    <script src="{{ mix('js/guest-chat.js') }}"></script>
    <script>
        var AppSession = new TfcSessions();
    </script>
    <script src="{{ mix('js/soundscapes.js') }}"></script>
@endsection
