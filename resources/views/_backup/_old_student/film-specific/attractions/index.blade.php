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
  <section id="title" class="pt-5">
    <div class="title sp-center pt-5 pb-5">
      {{ $app->title }}
      <h2 class="p-2 block-title">{{ $app_category->name }}</h2>
    </div>
  </section>
  @include('components.apps.sidebar-menu', ['app' => $app, 'type' => 'student'])
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
      <div class="row">
        <div class="col-12">
          <div class="row">
            <div class="col-md-6">
              <div class="box container-fluid mb-4">
                <div class="row">
                  <div class="col dark-blue py-3 px-5">
                    <h3>First Image</h3>
                  </div>
                </div>
                <div class="row">
                  <div class="col blue p-5">
                    <div id="div1" class="sortable container border no-padding">
                      <span class="placeholder">Drop Here</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="box container-fluid mb-4">
                <div class="row">
                  <div class="col dark-yellow py-3 px-5">
                    <h3>Second Image</h3>
                  </div>
                </div>
                <div class="row">
                  <div class="col yellow p-5">
                    <div id="div2" class="sortable container border no-padding">
                      <span class="placeholder">Drop Here</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <div class="box container-fluid mb-4">
                <div class="green p-5 d-flex justify-content-around">
                  <ul id="library" class="sortable list-inline">
                    <li class="list-unstyled list-inline-item"><img src="{{ asset('img/test-app/1.png') }}" class="img-fluid"></li>
                    <li class="list-unstyled list-inline-item"><img src="{{ asset('img/test-app/2.png') }}" class="img-fluid"></li>
                    <li class="list-unstyled list-inline-item"><img src="{{ asset('img/test-app/3.png') }}" class="img-fluid"></li>
                    <li class="list-unstyled list-inline-item"><img src="{{ asset('img/test-app/4.png') }}" class="img-fluid"></li>
                  </ul>
                </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <div class="box container-fluid mb-4">
            <div class="row">
              <div class="col dark-orange py-3 px-5">
                <h3>Notes</h3>
              </div>
            </div>
            <div class="row">
              <div class="col orange p-5">
                <textarea id="notes" name="notes" rows="8" class="form-control"></textarea>
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
    AppSession.initSession({{ $app->id }});

    $('#library, #div1, #div2').sortable({
      connectWith: ".sortable",
      update: function(event, ui) {
        var countL = countLImg();
        var countR = countRImg();

        if (countL > 1) {
          var data = $('#div1 li').last();
          $('#library').append(data);
        }
        if (countR > 1) {
          var data = $('#div2 li').last();
          $('#library').append(data);
        }
      }
    });

    function countLImg() {
      var count = 0;
      $('#div1 li').each(function() {
        count = count + 1;
      });
      return count;
    }

    function countRImg() {
      var count = 0;
      $('#div2 li').each(function() {
        count = count + 1;
      });
      return count;
    }

  </script>
@endsection
