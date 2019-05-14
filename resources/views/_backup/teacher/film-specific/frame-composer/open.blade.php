@extends('layouts.teacher', ['type' => 'app'])
@section('stylesheets')
@endsection
@section('content')
    <div class="container-fluid">
        @include('components.apps.heading_info', ['app' => $app, 'type' => 'teacher', 'student' => $is_student])
        <div id="frame-composer">
            <frame-composer
                libraries="{{ $elements }}"
                :open="true"
                session="{{ $session->json_data }}"
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
            </frame-composer>
            <input id="session-token" type="text" value="" hidden>
        </div>
    </div>
    @if ($is_student)
        @include('components.apps.chat', ['app_session' => $app_session])
    @endif
@endsection
@section('scripts')
    <script src="{{ mix('js/teacher-chat.js') }}"></script>
    <script type="text/javascript">
        var AppSession = new TfcSessions();
        AppSession.openSession('{{ $app_session->token }}', {{ $app->id }});
    </script>
    <script src="{{ mix('js/frame-composer.js') }}"></script>
@endsection
