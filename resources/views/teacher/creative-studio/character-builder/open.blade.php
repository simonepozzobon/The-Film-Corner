@extends('layouts.teacher', ['type' => 'app'])
@section('title', $app->title)
@section('stylesheets')
@endsection
@section('content')
    <div class="container-fluid">
        @include('components.apps.heading_info', ['app' => $app, 'type' => 'teacher', 'student' => $is_student])
        <div id="character-builder">
            <character-builder
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
            </character-builder>
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

        var token = '{{ $app_session->token }}'
        $('#session-token').attr('value', token)

        function init(canvas)
        {
            json_data = $('#loadCanvas').val();
            $.cookie('tfc-canvas', JSON.stringify(json_data));

            //LOAD JSON DATA on canvas
            canvas.loadFromJSON(JSON.parse(json_data), function(obj) {
                canvas.renderAll();
                canvas.forEachObject(function(obj) {
                    console.log(obj);
                    var src = cleanUrl(obj),
                        el = $('[data-img-src="'+src+'"]'),
                        asset = el.parent();

                    asset.children('a').removeClass('d-none');
                    asset.data('image-image-obj', obj);
                })
            });

            return json_data;
        }
    </script>
    <script src="{{ mix('js/character-builder.js') }}"></script>
@endsection
