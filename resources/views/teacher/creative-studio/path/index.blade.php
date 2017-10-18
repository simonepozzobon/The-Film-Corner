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
                The first step in the world of cinematographic language concerns, of course, framing. We are all more or less familiar with this word, but maybe we have never taken the time to ask ourselves what framing really is. How could we define it? Try to give a definition of framing and write it in the grid below.
                <br><br>
                We decided to start with framing because, like great philosopher and cinema scholar Christian Metz once said, framing is “the minimum meaningful unit of cinematographic language”. To put it simply, framing is where everything starts. In fact, framing is the aspect of cinematographic language with the oldest roots. The laws that underpin the composition of framing go back to photography and, centuries earlier, to geometry. But even before then, they go back to pictorial arts: after all, what is a painting if not the product of an artist who, with his/her own eyes, observes a portion of reality and tries to reproduce it from his/her own point of view? Isn’t a painting, in its own way, a first example of framing? Also, if we think of great figurative artists in art history, we realize how the action of framing is indissolubly linked with the quest for beauty: for centuries, in fact, framing couldn’t be considered as such if it wasn’t beautiful and harmonious.
                <br><br>
                (EXAMPLES OF FRAMES)
                <br><br>
                The ancestral character of cinematographic framing can be found in the first films that followed the birth of cinema in 1895. In the early days filmmakers used a single camera, they fixed it in one position and shot a single long shot of what was happening in front of it. Consequently, the viewer experienced the whole film (normally only a couple of minutes) from a single point of view (or perspective).
                <br><br>
                (LINK)
                <br><br>
                Ever since, cinema and its artists have gradually learnt to create increasingly beautiful, harmonious and meaningful frames, able to evoke emotions and feelings. Directors like Stanley Kubrick, Andreij Tarkovskij and Luchino Visconti made of visual composition the focal part of their art.
                <br><br>
                (EXAMPLES)
                <br><br>
                Take a few minutes and imagine being a director, armed with lens, in a very crowded environment. Picture being in a very crowded ballroom and wanting to focus on a couple of dancers in the very middle of the dance floor. How many frames can you imagine using? Would you like to film the dancers close up or farther away? Which angles can you use to film them? Would the camera be still or would it be moving? And if it were indeed moving, what direction would it go? The same the dancers are going, or a different one? Think about it and, with the help of your friends, list every way in which you could film the dancing couple.
                <br><br>
                In this section of the platform we’ll explore two fundamental aspects that rotate around the concept of framing: its composition and the disposition of the elements in space, the complex relationship between the camera’s lens and the subjects of the frame, the infinite possibilities cinema has to approach the subject of its art: reality.
                <br><br>
                Enjoy your journey in this first section of The Film Corner!
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
                <div class="col dark-blue py-3 px-5">
                  <h3>Examples</h3>
                </div>
              </div>
              <div class="row">
                <div class="col blue p-5">
                  <p>Examples of pictures and clips related to each app with a short explanations</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col">
            <div class="box container-fluid mb-4">
              <div class="row">
                <div class="col dark-yellow py-3 px-5">
                  <h3>References</h3>
                </div>
              </div>
              <div class="row">
                <div class="col yellow p-5">
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
        </div>
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
            data +=       '<a href="/teacher/creative-studio/'+response.category+'/'+response.app['slug']+'/'+response.sessions[i]['token']+'" class="btn btn-primary text-white"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Open</a>';
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
    data +=         '<button id="share-confirm" type="button" class="btn btn-primary" edata-dismiss="modal"><i class="fa fa-share-alt" aria-hidden="true"></i> Share</button>';
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
