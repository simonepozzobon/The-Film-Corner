@extends('layouts.student', ['type' => 'app'])
@section('stylesheets')
<style media="screen">
  .slot {
    border: 2px dashed #252525;
  }
</style>
@endsection
@section('content')
  <div class="container-fluid">
    @include('components.apps.heading_info', ['app' => $app, 'type' => 'student', 'student' => $is_student])
    <div id="app">
      <div class="row mt">
        <div class="col">
          <div class="box blue">
            <div class="box-header">
              {{ GeneralText::field('ideas') }}
            </div>
            <div class="box-body">
              <div class="row">
                <div class="col-md-2">
                  <div id="slot-1" class="slot">
                    <input id="slot-1-in" type="hidden" name="slot-1" value="">
                  </div>
                </div>
                <div class="col-md-2">
                  <div id="slot-2" class="slot">
                    <input id="slot-2-in" type="hidden" name="slot-2" value="">
                  </div>
                </div>
                <div class="col-md-2">
                  <div id="slot-3" class="slot">
                    <input id="slot-3-in" type="hidden" name="slot-3" value="">
                  </div>
                </div>
                <div class="col-md-2">
                  <div id="slot-4" class="slot">
                    <input id="slot-4-in" type="hidden" name="slot-4" value="">
                  </div>
                </div>
                <div class="col-md-2">
                  <div id="slot-5" class="slot">
                    <input id="slot-5-in" type="hidden" name="slot-5" value="">
                  </div>
                </div>
                <div class="col-md-2">
                  <div id="slot-6" class="slot">
                    <input id="slot-6-in" type="hidden" name="slot-6" value="">
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
              <button id="reload" class="btn btn-secondary btn-orange"><i class="fa fa-refresh" aria-hidden="true"></i> {{ GeneralText::field('reload') }}</button>
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
              <textarea id="notes" name="notes" rows="8" class="form-control" placeholder="{{ GeneralText::field('storytelling_desc') }}">{{ $session->notes }}</textarea>
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
  <script type="text/javascript">
    var AppSession = new TfcSessions();

    // Load the libraries
    var libraries = JSON.parse('{!! $images !!}');
    init(libraries);

    $('#reload').on('click', function(e){
      e.preventDefault();
      loadImgs(libraries);
    });

    function init(libraries)
    {
      var s1 = {!! $session->slot_1 !!};
      var s2 = {!! $session->slot_2 !!};
      var s3 = {!! $session->slot_3 !!};
      var s4 = {!! $session->slot_4 !!};
      var s5 = {!! $session->slot_5 !!};
      var s6 = {!! $session->slot_6 !!};

      $('#slot-1').append('<img class="asset img-fluid w-100" src="'+libraries[0][s1]+'">').children('input').val(s1);
      $('#slot-2').append('<img class="asset img-fluid w-100" src="'+libraries[1][s2]+'">').children('input').val(s2);
      $('#slot-3').append('<img class="asset img-fluid w-100" src="'+libraries[2][s3]+'">').children('input').val(s3);
      $('#slot-4').append('<img class="asset img-fluid w-100" src="'+libraries[3][s4]+'">').children('input').val(s4);
      $('#slot-5').append('<img class="asset img-fluid w-100" src="'+libraries[4][s5]+'">').children('input').val(s5);
      $('#slot-6').append('<img class="asset img-fluid w-100" src="'+libraries[5][s6]+'">').children('input').val(s6);

    }

    function loadImgs(libraries)
    {
        var s1 = Math.floor(Math.random() * libraries[0].length);
        var s2 = Math.floor(Math.random() * libraries[1].length);
        var s3 = Math.floor(Math.random() * libraries[2].length);
        var s4 = Math.floor(Math.random() * libraries[3].length);
        var s5 = Math.floor(Math.random() * libraries[4].length);
        var s6 = Math.floor(Math.random() * libraries[5].length);

        // Remove previous images
        $('.asset').remove();


        // Append Images
        $('#slot-1').append('<img class="asset img-fluid w-100" src="'+libraries[0][s1]+'">').children('input').val(s1);
        $('#slot-2').append('<img class="asset img-fluid w-100" src="'+libraries[1][s2]+'">').children('input').val(s2);
        $('#slot-3').append('<img class="asset img-fluid w-100" src="'+libraries[2][s3]+'">').children('input').val(s3);
        $('#slot-4').append('<img class="asset img-fluid w-100" src="'+libraries[3][s4]+'">').children('input').val(s4);
        $('#slot-5').append('<img class="asset img-fluid w-100" src="'+libraries[4][s5]+'">').children('input').val(s5);
        $('#slot-6').append('<img class="asset img-fluid w-100" src="'+libraries[5][s6]+'">').children('input').val(s6);

    }

  </script>
@endsection
