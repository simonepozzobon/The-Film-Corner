@extends('layouts.teacher', ['type' => 'app'])
@section('stylesheets')
<style media="screen">
  .slot {
    border: 2px dashed #252525;
  }
</style>
@endsection
@section('content')
  @include('components.apps.sidebar-menu', ['app' => $app])
  <div class="p-5">
  </div>
  <div class="row row-custom">
    <div id="help" class="col-6 container-fluid px-5 d-inline-block float-left">
        <div class="container-fluid pl-5">
          <div class="row">
            <div class="col" style="background-color: #a6dbe2; color: #252525">
              <h3 class="px-2 pt-4 pb-2">Examples</h3>
            </div>
          </div>
          <div class="row pb-5">
            <div class="col py-5" style="background-color: #d9f5fc; color: #252525">
              <p class="pl-2">
                Examples of pictures and clips related to each app with a short explanations
              </p>
            </div>
          </div>
          <div class="row" style="background-color: #e9c845; color: #252525">
            <div class="col">
              <h3 class="px-2 pt-4 pb-2">References</h3>
            </div>
          </div>
          <div class="row mb-5" style="background-color: #f5db5e; color: #252525">
            <div class="col py-5">
              <p class="pl-2">
                <ul>
                  <li>lista 1</li>
                  <li>lista 2</li>
                  <li>altro elemento</li>
                </ul>
              </p>
            </div>
          </div>
          <div class="row pb-5">
            @foreach ($app_category->keywords as $key => $keyword)
              <h5><span class="badge badge-default mb-2 mr-2" data-toggle="modal" data-target="#keywordModal-{{ $keyword->id }}">{{ $keyword->name }}</span></h5>
              <div class="modal fade" id="keywordModal-{{ $keyword->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">{{ $keyword->name }}</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="fa fa-times" aria-hidden="true"></i>
                      </button>
                    </div>
                    <div class="modal-body">
                      {{ $keyword->description }}
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Close</button>
                    </div>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>
    </div>
    <div id="app" class="col-12 px-5 d-inline-block float-left">
      <div class="row" style="background-color: {{ $app->colors[1] }}; color: #252525">
        <div class="col">
          <div class="d-flex justify-content-start">
            <div class="mr-auto"><h3 class="ml-2 pt-4 pb-1">{{ $app->title }}</h3></div>
          </div>
        </div>
      </div>
      <div class="row" style="background-color: {{ $app->colors[0] }}; color: #252525">
        <div class="col">
          <div class="clearfix p-5">

            <div class="row pb-5">
              <div class="col">
                <div class="container-fluid frame bg-faded p-4">
                  <h3 class="text-center pb-4">Main Frame</h3>
                  <div class="row pb-5">
                    <div class="col-md-3">
                      <div id="slot-1" class="container-fluid p-4 slot">
                        <input id="slot-1-in" type="hidden" name="slot-1" value="">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div id="slot-2" class="container-fluid p-4 slot">
                        <input id="slot-2-in" type="hidden" name="slot-2" value="">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div id="slot-3" class="container-fluid p-4 slot">
                        <input id="slot-3-in" type="hidden" name="slot-3" value="">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div id="slot-4" class="container-fluid p-4 slot">
                        <input id="slot-4-in" type="hidden" name="slot-4" value="">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col d-flex justify-content-around">
                      <button id="reload" class="btn btn-primary"><i class="fa fa-refresh" aria-hidden="true"></i> Reload</button>
                    </div>
                  </div>
                </div>

              </div>
            </div>

            <div class="row">
              <div class="col">
                <div class="frame container-fluid bg-faded p-4">
                  <h3 class="text-center pb-4">Write your story</h3>
                  <textarea id="notes" name="notes" rows="8" class="form-control"></textarea>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('scripts')
  <script type="text/javascript">
    var AppSession = new TfcSessions();
    var session = AppSession.initSession({{ $app->id }});

    loadImgs();

    $('#reload').on('click', function(e){
      e.preventDefault();
      loadImgs();
    });

    function loadImgs()
    {
        var s1 = Math.floor((Math.random() * 4) + 1);
        var s2 = Math.floor((Math.random() * 4) + 1);
        var s3 = Math.floor((Math.random() * 4) + 1);
        var s4 = Math.floor((Math.random() * 4) + 1);

        // Remove previous images
        $('.asset').remove();


        // Append Images
        $('#slot-1').append('<img class="asset img-fluid w-100" src="{{ url('/img/helpers/apps/storytelling') }}/char_'+s1+'.png">').children('input').val(s1);
        $('#slot-2').append('<img class="asset img-fluid w-100" src="{{ url('/img/helpers/apps/storytelling') }}/object_1_'+s1+'.png">').children('input').val(s2);
        $('#slot-3').append('<img class="asset img-fluid w-100" src="{{ url('/img/helpers/apps/storytelling') }}/object_2_'+s1+'.png">').children('input').val(s3);
        $('#slot-4').append('<img class="asset img-fluid w-100" src="{{ url('/img/helpers/apps/storytelling') }}/land_'+s1+'.png">').children('input').val(s4);

    }

  </script>
@endsection
