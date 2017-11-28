@extends('layouts.teacher', ['type' => 'app'])
@section('title', $app->title)
@section('stylesheets')
<style media="screen">
  .slot {
    border: 2px dashed #252525;
  }
</style>
@endsection
@section('content')
  <div class="container-fluid">
    @include('components.apps.heading_info', ['app' => $app, 'type' => 'teacher'])
    <div id="app">
      <div class="row mt">
        <div class="col">
          <div class="box blue">
            <div class="box-header">
              Ideas
            </div>
            <div class="box-body">
              <div class="row">
                <div class="col-md-3">
                  <div id="slot-1" class="slot">
                    <input id="slot-1-in" type="hidden" name="slot-1" value="">
                  </div>
                </div>
                <div class="col-md-3">
                  <div id="slot-2" class="slot">
                    <input id="slot-2-in" type="hidden" name="slot-2" value="">
                  </div>
                </div>
                <div class="col-md-3">
                  <div id="slot-3" class="slot">
                    <input id="slot-3-in" type="hidden" name="slot-3" value="">
                  </div>
                </div>
                <div class="col-md-3">
                  <div id="slot-4" class="slot">
                    <input id="slot-4-in" type="hidden" name="slot-4" value="">
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
              <button id="reload" class="btn btn-secondary btn-orange"><i class="fa fa-refresh" aria-hidden="true"></i> Reload</button>
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
              <textarea id="notes" name="notes" rows="8" class="form-control" placeholder="Write your story..."></textarea>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('scripts')
  <script type="text/javascript">
    var AppSession = new TfcSessions(),
        session = AppSession.initSession({{ $app->id }});

    // Load the libraries
    var libraries = JSON.parse('{!! $images !!}');

    loadImgs(libraries);

    $('#reload').on('click', function(e){
      e.preventDefault();
      loadImgs(libraries);
    });

    function loadImgs(libraries)
    {


        var s1 = Math.floor(Math.random() * libraries[0].length);
        var s2 = Math.floor(Math.random() * libraries[1].length);
        var s3 = Math.floor(Math.random() * libraries[2].length);
        var s4 = Math.floor(Math.random() * libraries[3].length);

        // Remove previous images
        $('.asset').remove();


        // Append Images
        $('#slot-1').append('<img class="asset img-fluid w-100" src="'+libraries[0][s1]+'">').children('input').val(s1);
        $('#slot-2').append('<img class="asset img-fluid w-100" src="'+libraries[1][s2]+'">').children('input').val(s2);
        $('#slot-3').append('<img class="asset img-fluid w-100" src="'+libraries[2][s3]+'">').children('input').val(s3);
        $('#slot-4').append('<img class="asset img-fluid w-100" src="'+libraries[3][s4]+'">').children('input').val(s4);

    }

  </script>
@endsection
