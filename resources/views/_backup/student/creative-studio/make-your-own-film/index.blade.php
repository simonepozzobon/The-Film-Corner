@extends('layouts.student', ['type' => 'app'])
@section('title', $app->title)
@section('stylesheets')

@endsection
@section('content')
  <div class="container-fluid">
    @php
      $options = [
        'save' => false,
        'close-warning' => false,
      ];
    @endphp
    @include('components.apps.heading_info', ['app' => $app, 'type' => 'student', 'options' => $options])
    <div id="app">
      <div class="row mt">
        <div class="col">
          <div class="box blue">
            <div class="box-header">
              {{ GeneralText::field('submission') }}
            </div>
            <div class="box-body">
                <div id="uploads">
                  <upload-form
                    csrf_field="{{ csrf_token() }}"
                    app_id="{{ $app->id }}"
                    color="blue"
                    :has_title="true"
                    route="{{ route('student.creative-studio.upload', [$app_category, $app->slug]) }}">
                  </upload-form>
                </div>
                <div id="response">

                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('scripts')
  <script src="{{ mix('js/upload.js') }}"></script>
  <script>
    var AppSession = new TfcSessions();
    var session = AppSession.initSession({{ $app->id }});

    $('body').on('session-loaded', function(e, session){
      console.log('sessione caricata '+session.token);
      $('#session-token').attr('value', session.token)
    });
  </script>
@endsection
