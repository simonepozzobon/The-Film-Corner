@extends('layouts.teacher', ['type' => 'app'])
@section('title', $app->title)
@section('stylesheets')
@endsection
@section('content')
    <div class="container-fluid">
        @include('components.apps.heading_info', ['app' => $app, 'type' => 'teacher'])
        <div id="character-builder">
            <character-builder
                libraries="{{ $app->mediaCategory()->get() }}"
                library_text="{{ GeneralText::field('library') }}"
                deselect_all_text="{{ GeneralText::field('deselect_all') }}"
                move_back_text="{{ GeneralText::field('move_back') }}"
                move_backward_text="{{ GeneralText::field('move_backward') }}"
                move_forward_text="{{ GeneralText::field('move_forward') }}"
                move_to_front_text="{{ GeneralText::field('move_to_front') }}"
                remove_text="{{ GeneralText::field('remove') }}"
                notes_text="{{ GeneralText::field('notes') }}"
            >
            </character-builder>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        var AppSession = new TfcSessions();
        var session = AppSession.initSession({{ $app->id }});

        $('body').on('session-loaded', function(e, session) {
            $('#session-token').attr('value', session.token)
        });

        function saveCanvas(canvas)
        {
            // Save canvas to JSON for future edit
            json_data = JSON.stringify(canvas.toDatalessJSON());
            localStorage.setItem('app-13-json', JSON.stringify(json_data));
            // $.cookie('tfc-canvas', JSON.stringify(json_data));

            // Save image to local storage
            localStorage.setItem('app-13-image', canvas.toDataURL('png'));
            return json_data;
        }
    </script>
    <script src="{{ mix('js/character-builder.js') }}"></script>
@endsection
