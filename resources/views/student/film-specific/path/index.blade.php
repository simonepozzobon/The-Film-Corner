@extends('layouts.student')
@section('title', 'Film Specific')
@section('content')
  <div class="container">
    @include('components.apps.heading', ['route' => route('student'), 'app_category' => $app_category])
    <div class="row mt">
      <div class="col col-md-4">
        <div class="box green">
          <div class="box-header">
            Examples
          </div>
          <div class="box-body">
            Examples of pictures and clips related to each app with a short explanations
          </div>
        </div>
        <div class="box last orange mt">
          <div class="box-header">
            References
          </div>
          <div class="box-body">
            <ul>
              <li>lista 1</li>
              <li>lista 2</li>
              <li>altro elemento</li>
            </ul>
          </div>
        </div>
      </div>
      <div class="col-md-8">
        @if ($apps->count() > 0)
          @foreach ($apps as $key => $app)
            <div class="box {{ $app->colors }} {{ $key == 0 ? '' : 'mt' }}">
              <div class="box-header">
                {{ $app->title }}
              </div>
              <div class="box-body">
                {{ $app->description }}
              </div>
              <div class="box-btns">
                @if ($app->available == 1)
                  <a href="{{ route('student.film-specific.app', [$app_category->slug, $app->slug]) }}" class="btn btn-{{ $app->colors }}" >
                    <i class="fa fa-file-o" aria-hidden="true"></i> New
                  </a>
                @else
                  <a href="" class="btn btn-{{ $app->colors }}" data-toggle="modal" data-target="#fullModal">
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
                <a href="#" onclick="openSessions({{ Auth::guard('student')->Id() }}, {{ $app->id }}, '{{ $app->colors }}')" class="btn btn-{{ $app->colors }}" >
                  <i class="fa fa-floppy-o" aria-hidden="true"></i> Saved
                </a>
              </div>
            </div>
          @endforeach
          <div id="modalSession"></div>
        @else
          <div class="box yellow">
            <div class="box-header">
              Ooops!
            </div>
            <div class="box-body">
              No apps available...
            </div>
          </div>
        @endif
      </div>
    </div>
  </div>
@endsection
@section('scripts')
<script type="text/javascript">
  function openSessions(studentId, appId, color) {
    $.ajax({
      type: 'GET',
      url:  '/student/session/'+studentId+'/'+appId,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
      },
      success: function (response) {
        console.log(response);
          var dataLenght = Object.keys(response.sessions).length;
          var data = ''
          data += '<div class="modal fade" id="sessionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">';
          data +=   '<div class="modal-dialog modal-lg" role="document">';
          data +=     '<div class="modal-content '+color+'">';
          data +=       '<div class="modal-header">';
          data +=         '<h5 class="modal-title" id="exampleModalLabel">'+response.app['title']+'</h5>';
          data +=         '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
          data +=           '<i class="fa fa-times" aria-hidden="true"></i>';
          data +=         '</button>';
          data +=       '</div>';
          data +=       '<div class="modal-body">';
          data +=         '<table class="table table-hover">';
          data +=           '<tbody>';

          for (var i = 0; i < dataLenght; i++) {

            data += '<tr class="align-middle">';
            data +=   '<td class="align-middle">';
            data +=     response.sessions[i]['title'];
            data +=   '</td>';
            data +=   '<td class="align-middle">';
            data +=     response.sessions[i]['created_at'];
            data +=   '</td>';
            data +=   '<td class="align-middle">';
            data +=     '<div class="btn-group">';
            data +=       '<a href="/student/film-specific/'+response.category+'/'+response.app['slug']+'/'+response.sessions[i]['token']+'" class="btn btn-'+color+'"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Open</a>';
            data +=       '<a href="#" id="share-session" onclick="shareSession('+studentId+', '+appId+', \''+response.sessions[i]['token']+'\')" class="btn btn-'+color+'"><i class="fa fa-share-alt" aria-hidden="true"></i> Share</a>';
            data +=       '<a class="btn btn-'+color+'"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</a>';
            data +=     '</div>';
            data +=   '</td>';
            data += '</tr>';

          }

          data +=           '</tbody>';
          data +=         '</table>';
          data +=       '</div>';
          data +=       '<div class="modal-footer">';
          data +=         '<button type="button" class="btn btn-'+color+'" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Close</button>';
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

  function shareSession(studentId, appId, sessionToken)
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

    data +=         '<h4 class="text-center">Are You Sure?</h4>'
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
        url:  '{{ route('student.session.share') }}',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        data: {
          '_token'  : $('input[name=_token]').val(),
          'student_id' : studentId,
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
      console.log(studentId);
      console.log(appId);
      console.log(sessionToken);
      console.log('--------');
  }
</script>
@endsection
