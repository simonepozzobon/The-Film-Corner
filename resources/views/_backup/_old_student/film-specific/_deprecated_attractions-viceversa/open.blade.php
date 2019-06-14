@extends('layouts.student', ['type' => 'app'])
@section('stylesheets')
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <style media="screen">
  .border {
    width: 384px;
    height: 216px;
    border: 3px dashed rgba(37, 37, 37, 0.15);
    border-radius: 0.5rem;
    overflow: hidden;
  }
  .no-padding {
    padding: 0;
  }
  #library img {
    padding-bottom: 1rem;
  }
  #div1 img, #div2 img {
    width: 100%;
    height: 100%;
  }
  .placeholder {
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
    font-size: 1.5rem;
    font-weight: 700;
    color: rgba(37, 37, 37, 0.15);
  }
  </style>
@endsection
@section('content')
  @include('components.apps.sidebar-menu', ['app' => $app, 'type' => 'student', 'student' => $is_student])
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
            <div class="row">
              <div class="col-md-8">
                <div class="row pb-4">
                  <div class="col">
                    <div class="frame container bg-faded p-4">
                      <h3 class="text-center">Describe {{ $session->emotion }}</h3>
                      <input type="hidden" name="emotion" value="{{ $session->emotion }}">
                    </div>
                  </div>
                </div>
                <div class="row pb-4">
                  <div class="col-md-6">
                    <div id="div1" class="sortable container border no-padding">
                      <img src="{{ $session->imgL }}" class="img-fluid">
                      <span class="placeholder">Drop Here</span>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div id="div2" class="sortable container border no-padding">
                      <img src="{{ $session->imgR }}" class="img-fluid">
                      <span class="placeholder">Drop Here</span>
                    </div>
                  </div>
                </div>
                <div class="row pb-4">
                  <div class="col">
                    <div class="frame container bg-faded p-4">
                      <textarea id="notes" name="notes" rows="8" class="form-control">{{ $session->notes }}</textarea>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="frame container bg-faded p-4">
                  <h3 class="text-center">Pick an image</h3>
                  <ul id="library" class="row sortable no-padding">
                    <img src="{{ asset('img/test-app/1.png') }}" class="img-fluid">
                    <img src="{{ asset('img/test-app/2.png') }}" class="img-fluid">
                    <img src="{{ asset('img/test-app/3.png') }}" class="img-fluid">
                    <img src="{{ asset('img/test-app/4.png') }}" class="img-fluid">
                  </ul>
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
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script type="text/javascript">
    var AppSession = new TfcSessions();

    $('#library, #div1, #div2').sortable({
      connectWith: ".sortable",
      update: function(event, ui) {
        var countL = countLImg();
        var countR = countRImg();

        if (countL > 1) {
          var data = $('#div1 img').last();
          $('#library').append(data);
        }
        if (countR > 1) {
          var data = $('#div2 img').last();
          $('#library').append(data);
        }
      }
    });

    function countLImg() {
      var count = 0;
      $('#div1 img').each(function() {
        count = count + 1;
      });
      return count;
    }

    function countRImg() {
      var count = 0;
      $('#div2 img').each(function() {
        count = count + 1;
      });
      return count;
    }

  </script>
@endsection
