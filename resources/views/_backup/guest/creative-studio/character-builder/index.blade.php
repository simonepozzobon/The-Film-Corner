@extends('layouts.guest', ['type' => 'app'])
@section('title', $app->title)
@section('stylesheets')
@endsection
@section('content')
    <div class="container-fluid">
        @include('components.apps.heading_info', ['app' => $app, 'type' => 'guest'])
        <div id="character-builder">
            <character-builder
                libraries="{{ $elements }}"
                character_text="{{ GeneralText::field('character') }}"
                library_text="{{ GeneralText::field('library') }}"
                deselect_all_text="{{ GeneralText::field('deselect_all') }}"
                move_back_text="{{ GeneralText::field('move_back') }}"
                move_backward_text="{{ GeneralText::field('move_backward') }}"
                move_forward_text="{{ GeneralText::field('move_forward') }}"
                move_to_front_text="{{ GeneralText::field('move_to_front') }}"
                remove_text="{{ GeneralText::field('remove') }}"
                notes_text="{{ GeneralText::field('notes') }}"
                character_builder_desc="{{ GeneralText::field('character_builder_desc') }}"
            >
            </character-builder>
            <input id="session-token" type="text" value="" hidden>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ mix('js/upload.js') }}"></script>
    <script type="text/javascript">
        var AppSession = new TfcSessions();
        var session = AppSession.initSession({{ $app->id }});

        $('body').on('session-loaded', function(e, session) {
            $('#session-token').attr('value', session.token)
        });
    </script>
    <script src="{{ mix('js/character-builder.js') }}"></script>
@endsection
