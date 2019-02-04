@extends('layouts.guest')
@section('title', 'Film Specific')
@section('content')
  <div class="container">
    @include('components.apps.heading', ['route' => route('guest'), 'app_category' => $app_category, 'apps' => $apps])
    <div class="row mt">
      <div class="col col-md-4">
        <div class="glossary">
          @foreach ($app_category->keywords()->get() as $key => $keyword)
            <div class="badge badge-{{ $app_category->color_class }}" data-toggle="modal" data-target="#glossary-{{$keyword->id}}">{{ $keyword->name }}</div>
          @endforeach
        </div>
        @foreach ($app_category->keywords()->get() as $key => $keyword)
          <div class="modal fade" id="glossary-{{ $keyword->id }}" tabindex="-1" role="dialog" aria-labelledby="{{ $keyword->id }}Label" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="{{ $keyword->id }}Label">{{ $keyword->name }}</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  {!! $keyword->description !!}
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-check"></i> Okay</button>
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>
      <div class="col-md-8">
        @if ($apps->count() > 0)
          @foreach ($apps as $key => $app)
            <div id="{{ $app->slug }}" class="box {{ $app->colors }} {{ $key == 0 ? '' : 'mt' }}">
              <div class="box-header">
                <div class="title">
                  {{ $app->title }}
                </div>
                <div class="btns">
                  @if ($app->available == 1)
                    <a href="{{ route('guest.film-specific.app', [$app_category->slug, $app->slug]) }}" class="btn btn-{{ $app->colors }}" data-toggle="tooltip" data-placement="top" title="{{ GeneralText::field('new') }}">
                      <i class="fa fa-file-o" aria-hidden="true"></i>
                    </a>
                  @else
                    <a href="" class="btn btn-{{ $app->colors }}" data-toggle="modal" data-target="#fullModal">
                      <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
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
                  {{-- <a href="#" onclick="openSessions({{ Auth::guard('guest')->Id() }}, {{ $app->id }}, '{{ $app->colors }}')" class="btn btn-{{ $app->colors }}" >
                    <i class="fa fa-folder-open-o" aria-hidden="true"></i>
                  </a> --}}
                </div>
              </div>
              <div class="box-body">
                <div class="short-description">
                  {{ substr(strip_tags($app->description), 0, 200) }}{{ strlen(strip_tags($app->description)) > 200 ? '...' : "" }}
                </div>
                <div class="long-description d-none">
                  {!! $app->description !!}
                </div>
              </div>
              <div class="box-btns">
                <a href="#{{ $app->slug }}" class="read-more" data-id="{{ $app->slug }}">{{ GeneralText::field('read_more') }}</a>
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
<script>
  $(document.body).on('click', '.read-more', function(event) {
    console.log('read-more cliccato');
    event.preventDefault();
    var id = event.target.dataset.id,
        el = $('#'+id),
        short_description = el.find('.short-description'),
        long_description = el.find('.long-description');

    short_description.addClass('d-none');
    long_description.removeClass('d-none');
    $(this).html('{{ GeneralText::field('read_less') }}').removeClass('read-more').addClass('read-less');
  });

  $(document.body).on('click', '.read-less', function(event) {
    console.log('read-less cliccato');
    event.preventDefault();
    var id = event.target.dataset.id,
        el = $('#'+id),
        short_description = el.find('.short-description'),
        long_description = el.find('.long-description');

    long_description.addClass('d-none');
    short_description.removeClass('d-none');
    $(this).html('{{ GeneralText::field('read_more') }}').removeClass('read-less').addClass('read-more');
  })

  function openSessions(guestId, appId, color) {
    $.ajax({
      type: 'GET',
      url:  '/guest/session/'+guestId+'/'+appId,
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
            data +=       '<a href="/guest/film-specific/'+response.category+'/'+response.app['slug']+'/'+response.sessions[i]['token']+'" class="btn btn-'+color+'"><i class="fa fa-folder-open-o" aria-hidden="true"></i> {{ GeneralText::field('open') }}</a>';
            data +=       '<a href="#" id="share-session" onclick="shareSession('+guestId+', '+appId+', \''+response.sessions[i]['token']+'\')" class="btn btn-'+color+'"><i class="fa fa-share-alt" aria-hidden="true"></i> {{ GeneralText::field('share') }}</a>';
            data +=       '<a href="#" id="delete-session" onclick="deleteSession(\''+response.sessions[i]['token']+'\')" class="btn btn-'+color+'"><i class="fa fa-trash-o" aria-hidden="true"></i> {{ GeneralText::field('delete') }}</a>';
            data +=     '</div>';
            data +=   '</td>';
            data += '</tr>';

          }

          data +=           '</tbody>';
          data +=         '</table>';
          data +=       '</div>';
          data +=       '<div class="modal-footer">';
          data +=         '<button type="button" class="btn btn-'+color+'" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> {{ GeneralText::field('close') }}</button>';
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

  function shareSession(guestId, appId, sessionToken)
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
    data +=         '<button id="share-confirm" type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-share-alt" aria-hidden="true"></i> {{ GeneralText::field('share') }}</button>';
    data +=         '<button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> {{ GeneralText::field('close') }}</button>';
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
        url:  '{{ route('guest.session.share') }}',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        data: {
          '_token'  : $('input[name=_token]').val(),
          'guest_id' : guestId,
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
      console.log(guestId);
      console.log(appId);
      console.log(sessionToken);
      console.log('--------');
  }

  function deleteSession(sessionToken)
  {
    var formData = {
      '_token'  : '{{ csrf_token() }}',
      'token' : sessionToken
    };

    console.log(formData);

    $.ajax({
      type: 'POST',
      url:  '{{ route('guest.session.delete') }}',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
      },
      data: formData,
      success: function (response) {
        console.log(response);
        // Remove previous modal
        $('#sessionModal').modal('hide');
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();
      },
      error: function (xhr, status) {
          console.log(xhr);
          console.log(status);
      }
    });
  }
</script>
@endsection
