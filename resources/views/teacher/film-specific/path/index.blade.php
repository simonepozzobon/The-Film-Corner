@extends('layouts.teacher')
@section('title', 'Editing')
@section('content')
  <section id="title" class="pt-5">
    <div class="title sp-center pt-5 pb-5">
      {{ $app_category->name }}
      <h2 class="p-2 block-title">{{ $app_category->section->name }}</h2>
    </div>
  </section>
  <section id="breadcrumbs pr-5 pl-5 pb-5">
    <div class="row">
      <div class="col pr-5 pl-5">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('teacher') }}">Studios</a></li>
          <li class="breadcrumb-item"><a href="{{ route('teacher') }}/{{ $app_category->section->slug }}">{{ $app_category->section->name }}</a></li>
          <li class="breadcrumb-item active">{{ $app_category->name }}</li>
        </ol>
      </div>
    </div>
  </section>
  <section id="main" class="pb-5 pr-5 pl-5">
    <div class="row no-gutters">
      <div class="col">
        <div class="box container-fluid mb-4">
          <div class="row">
            <div class="col dark-blue py-3 px-5">
              <h3 class="d-inline-block">Info</h3>
              <h3 class="d-inline-block float-right mt-4 mr-2"><a data-toggle="collapse" href="#info-text" aria-expanded="false" aria-controls="collapseExample" class="text-blue"><i class="fa fa-minus"></i></a><h3>
            </div>
          </div>
          <div class="row {{ isset($visited) ? 'collapse' : 'collapse.show' }}" id="info-text">
            <div class="col blue p-5">
              <p class="pl-2">
                {!! $app_category->description !!}
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row no-gutters">
      <div class="col-md-3">
        <div class="row">
          <div class="col">
            <div class="box container-fluid mb-4">
              <div class="row">
                <div class="col dark-green py-3 px-5">
                  <h3>Examples</h3>
                </div>
              </div>
              <div class="row">
                <div class="col green p-5">
                  <p>Examples of pictures and clips related to each app with a short explanations</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        {{-- <div class="row">
          <div class="col">
            <div class="box container-fluid mb-4">
              <div class="row">
                <div class="col dark-orange py-3 px-5">
                  <h3>References</h3>
                </div>
              </div>
              <div class="row">
                <div class="col orange p-5">
                  <p class="pl-2">
                    <ul>
                      <li>lista 1</li>
                      <li>lista 2</li>
                      <li>altro elemento</li>
                    </ul>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div> --}}
        <div class="row">
          <div class="col">
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
      <div class="col-md-9">
        <div class="container-fluid pl-5">
          @if ($apps->count() > 0)
            @foreach ($apps as $key => $app)
              <div class="box container-fluid mb-4">
                <div class="row">
                  <div class="col dark-{{ $app->colors }} py-3 px-5">
                    <h3>{{ $app->title }}</h3>
                  </div>
                </div>
                <div class="row">
                  <div class="col {{ $app->colors }} p-5">
                    <p>{{ $app->description }}</p>
                    <div class="d-flex justify-content-around">
                      <div class="">
                        @if ($app->available == 1)
                          <a href="{{ route('teacher.film-specific.app', [$app_category->slug, $app->slug]) }}" class="btn btn-secondary btn-{{ $app->colors }}" >
                            <i class="fa fa-file-o" aria-hidden="true"></i> New
                          </a>
                        @else
                          <a href="" class="btn btn-secondary btn-{{ $app->colors }}" data-toggle="modal" data-target="#fullModal">
                            <i class="fa fa-exclamation-circle" aria-hidden="true"></i> Full
                          </a>
                          <div class="modal fade" id="fullModal" tabindex="-1" role="dialog" aria-labelledby="fullModalWarning" aria-hidden="true">
                             <div class="modal-dialog modal-lg" role="document">
                               <div class="modal-content">
                                 <div class="modal-header">
                                   <h5 class="modal-title" id="fullModalWarning">Your slots are full</h5>
                                   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                     <i class="fa fa-times" aria-hidden="true"></i>
                                   </button>
                                 </div>
                                 <div class="modal-body">
                                   <p class="text-center">Please, remove one of your sessions from this app!</p>
                                 </div>
                                 <div class="modal-footer">
                                   <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Close</button>
                                 </div>
                               </div>
                             </div>
                           </div>
                        @endif
                        <a href="#" onclick="openSessions({{ Auth::guard('teacher')->Id() }}, {{ $app->id }})" class="btn btn-secondary btn-{{ $app->colors }}" >
                          <i class="fa fa-floppy-o" aria-hidden="true"></i> Saved
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            @endforeach
            <div id="modalSession">

            </div>
          @else
            <div class="row">
              <div class="">

              </div>
              <div class="container" style="background-color: #f5db5e; color: #252525">
                <div class="row" style="background-color: #e9c845; color: #252525">
                  <div class="col align-text-bottom">
                    <h3 class="p-2">Oooops</h3>
                  </div>
                </div>
                <div class="row">
                  <div class="col pt-5 pr-5 pb-5">
                    <p class="pl-2">
                      No apps available for now
                    </p>
                  </div>
                </div>
              </div>
            </div>
          @endif
        </div>
      </div>
    </div>
  </section>
@endsection
@section('scripts')
<script type="text/javascript">
  function openSessions(teacherId, appId) {
    $.ajax({
      type: 'GET',
      url:  '/teacher/session/'+teacherId+'/'+appId,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
      },
      success: function (response) {
        console.log(response);
          var dataLenght = Object.keys(response.sessions).length;
          var data = ''
          data += '<div class="modal fade" id="sessionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">';
          data +=   '<div class="modal-dialog modal-lg" role="document">';
          data +=     '<div class="modal-content">';
          data +=       '<div class="modal-header">';
          data +=         '<h5 class="modal-title" id="exampleModalLabel">'+response.app['title']+'</h5>';
          data +=         '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
          data +=           '<i class="fa fa-times" aria-hidden="true"></i>';
          data +=         '</button>';
          data +=       '</div>';
          data +=       '<div class="modal-body">';
          data +=         '<table class="table table-hover">';
          data +=           '<thead>';
          data +=             '<th>id</th>';
          data +=             '<th>date</th>';
          data +=             '<th></th>';
          data +=           '</thead>';
          data +=           '<tbody>';

          for (var i = 0; i < dataLenght; i++) {

            data += '<tr>';
            data +=   '<td>';
            data +=     response.sessions[i]['title'];
            data +=   '</td>';
            data +=   '<td>';
            data +=     response.sessions[i]['created_at'];
            data +=   '</td>';
            data +=   '<td>';
            data +=     '<div class="btn-group">';
            data +=       '<a href="/teacher/film-specific/'+response.category+'/'+response.app['slug']+'/'+response.sessions[i]['token']+'" class="btn btn-primary text-white"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Open</a>';
            data +=       '<a href="#" id="share-session" onclick="shareSession('+teacherId+', '+appId+', \''+response.sessions[i]['token']+'\')" class="btn btn-success text-white"><i class="fa fa-share-alt" aria-hidden="true"></i> Share</a>';
            data +=       '<a class="btn btn-danger text-white"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</a>';
            data +=     '</div>';
            data +=   '</td>';
            data += '</tr>';

          }

          data +=           '</tbody>';
          data +=         '</table>';
          data +=       '</div>';
          data +=       '<div class="modal-footer">';
          data +=         '<button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Close</button>';
          data +=       '</div>';
          data +=     '</div>';
          data +=   '</div>';
          data += '</div>';

          $('#modalSession').html(data);
          $('#sessionModal').modal('show');
      },
      error: function (xhr, status) {
          console.log(xhr);
          console.log(status);
      }
    });
  }

  function shareSession(teacherId, appId, sessionToken)
  {
    // Remove previous modal
    $('#sessionModal').modal('hide');
    $('body').removeClass('modal-open');
    $('.modal-backdrop').remove();

    var data = ''
    data += '<div class="modal fade" id="sessionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">';
    data +=   '<div class="modal-dialog modal-lg" role="document">';
    data +=     '<div class="modal-content">';
    data +=       '<div class="modal-header">';
    data +=         '<h5 class="modal-title" id="exampleModalLabel">Share your work</h5>';
    data +=         '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
    data +=           '<i class="fa fa-times" aria-hidden="true"></i>';
    data +=         '</button>';
    data +=       '</div>';
    data +=       '<div class="modal-body">';

    data +=         '<h4 class="text-center">Are You Shure?</h4>'
    data +=         '<p class="text-center">'
    data +=           'This will make your work public!'
    data +=           '{{ csrf_field() }}';
    data +=         '</p>';

    data +=       '</div>';
    data +=       '<div class="modal-footer">';
    data +=         '<button id="share-confirm" type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-share-alt" aria-hidden="true"></i> Share</button>';
    data +=         '<button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Close</button>';
    data +=       '</div>';
    data +=     '</div>';
    data +=   '</div>';
    data += '</div>';

    $('#modalSession').html(data);
    $('#sessionModal').modal('show');

    $('#share-confirm').on('click', function(e){
      // e.preventDefault();
      $.ajax({
        type: 'POST',
        url:  '{{ route('teacher.session.share') }}',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        data: {
          '_token'  : $('input[name=_token]').val(),
          'teacher_id' : teacherId,
          'app_id' : appId,
          'token' : sessionToken
        },
        success: function (response) {
          console.log(response);
        },
        error: function (xhr, status) {
            console.log(xhr);
            console.log(status);
        }
      });
    });
      console.log('--------');
      console.log('DATA TO SHARE');
      console.log(teacherId);
      console.log(appId);
      console.log(sessionToken);
      console.log('--------');
  }
</script>
@endsection
