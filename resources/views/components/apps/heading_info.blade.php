@php
  if (!isset($student)) {
    $student = false;
  }
@endphp
  <div class="row mt">
    <div class="col">
      <div class="title-wrapper bg-faded">
        <div class="icons-left">
          <div id="close-btn" class="icon exit" data-toggle="tooltip" data-html="true" title="Close App">
            <a href="#" data-toggle="modal" data-target="#close"><i class="fa fa-window-close text-danger"></i></a>
          </div>
          @if ($student == false)
            <div id="save-btn" class="icon save" data-toggle="tooltip" data-html="true" title="Save This Session">
              <a href="#" data-toggle="modal" data-target="#saveSession"><i class="fa fa-floppy-o text-primary"></i></a>
            </div>
            @if (isset($app_session) && $app_session->teacher_shared == 1)
            <div id="comment-btn" class="icon comment" data-toggle="tooltip" data-html="true" title="Open Chat">
              <a href="#" data-toggle="collapse" data-target="#chat"><i class="fa fa-comment-o text-warning"></i></a>
            </div>
            @endif
          @else
            <div id="approve-btn" class="icon approve" data-toggle="tooltip" data-html="true" title="Approve this session and make it available to share">
              <a href="#" data-toggle="modal" data-target="#saveSession"><i class="fa fa-thumbs-o-up text-success"></i></a>
            </div>
            <div id="comment-btn" class="icon comment" data-toggle="tooltip" data-html="true" title="Open Chat">
              <a href="#" data-toggle="modal" data-target="#close"><i class="fa fa-comment-o text-warning"></i></a>
            </div>
          @endif
        </div>
        <div class="title">
          {{ $app->title }}
        </div>
        <div class="icons-right">
          {{-- Se ci sono esempi, fa vedere il pulsante per gli esempi --}}
          @if ($app->examples()['count'] > 0)
            <div id="example-btn" class="icon" data-toggle="tooltip" data-html="true" title="Show Examples">
              <a href="#" data-toggle="modal" data-target="#examples"><i class="fa fa-lightbulb-o"></i></a>
            </div>
          @endif
          <div id="help-btn" class="icon" data-toggle="tooltip" data-html="true" title="Help">
            <a id="read-more-icon"><i class="fa fa-question"></i></a>
          </div>
          <div id="print-btn" class="icon" data-toggle="tooltip" data-html="true" title="Print">
            <a><i class="fa fa-print"></i></a>
          </div>
        </div>
      </div>
      <div id="app-info" class="title-description">
        <div class="content no-padding">
          <div id="short-description" class="short-description">
            {{ substr(strip_tags($app->description), 0, 200) }}{{ strlen(strip_tags($app->description)) > 200 ? '...' : "" }}
          </div>
          <div id="long-description" class="long-description d-none">
            {!! $app->description !!}
          </div>
        </div>
        <div class="btns">
            <a id="read-more-btn" href="#{{ $app->slug }}" class="read-more" data-id="{{ $app->slug }}">Read More</a>
        </div>
        <script type="text/javascript">
          var button = document.getElementById('read-more-btn'),
              icon = document.getElementById('read-more-icon'),
              shortDesc = document.getElementById('short-description'),
              longDesc = document.getElementById('long-description'),
              opened = false;

          button.addEventListener('click', toggleDescription, false);
          icon.addEventListener('click', toggleDescription, false);

          function toggleDescription()
          {
            if (opened)
            {
                longDesc.classList.remove('d-none');
                shortDesc.classList.add('d-none');
                button.innerHTML = 'Read Less'
            }

            else
            {
                shortDesc.classList.remove('d-none');
                longDesc.classList.add('d-none');
                button.innerHTML = 'Read More';
            }

            opened = !opened;
          }

        </script>
      </div>
    </div>
  </div>
  @if ($app->examples()['count'] > 0)
    <div class="modal fade" id="examples" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Examples</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <i class="fa fa-times" aria-hidden="true"></i>
            </button>
          </div>
          <div class="modal-body">
            @foreach ($app->examples() as $key => $examples)
              @if ($key == 'videos')
                @foreach ($examples as $key => $example)
                  <div class="video-example embed-responsive embed-responsive-16by9">
                    <video class="embed-responsive-item" controls>
                      <source src="{{ Storage::disk('local')->url($example->src) }}" type="video/mp4">
                    </video>
                  </div>
                @endforeach
              @elseif ($key == 'images')
                @foreach ($examples as $key => $example)
                  <div class="image-example">
                    <img src="{{ Storage::disk('local')->url($example->src) }}" alt="" class="img-fluid">
                  </div>
                @endforeach
              @elseif ($key == 'audios')
                @foreach ($examples as $key => $example)
                  <div class="audio-example embed-responsive">
                    <audio class="embed-responsive-item" controls>
                      <source src="{{ Storage::disk('local')->url($example->src) }}" type="audio/wav">
                    </audio>
                  </div>
                @endforeach
              @endif
            @endforeach
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-check" aria-hidden="true"></i> Okay</button>
          </div>
        </div>
      </div>
    </div>
  @endif

  @if ($student == false)
    <div class="modal fade" id="saveSession" tabindex="-1" role="dialog" aria-labelledby="saveModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="saveModalLabel">Save {{ $app->title }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <i class="fa fa-times" aria-hidden="true"></i>
            </button>
          </div>

            <div class="modal-body">
              <form>
              {{ csrf_field() }}
              {{ method_field('POST') }}
              <div class="form-group">
                <label for="">Title:</label>
                <input type="text" name="title" class="form-control">
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Cancel</button>
              <button type="button" class="btn btn-primary" onclick="AppSession.updateSession({{ $app->id }})"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</button>
              </form>
            </div>
        </div>
      </div>
    </div>
  @elseif ($student == true && isset($app_session))
    <div class="modal fade" id="saveSession" tabindex="-1" role="dialog" aria-labelledby="saveModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="saveModalLabel">Save {{ $app->title }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <i class="fa fa-times" aria-hidden="true"></i>
            </button>
          </div>
          <form class="" action="{{ route('teacher.session.share') }}" method="POST">
            {{ csrf_field() }}
            {{ method_field('POST') }}

            <div class="modal-body">
              Are you sure?
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Cancel</button>
              <button type="button" class="btn btn-primary" type="submit"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  @endif
  <div class="modal fade" id="close" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Close {{ $app->title }}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <i class="fa fa-times" aria-hidden="true"></i>
          </button>
        </div>
        <div class="modal-body">
          <h4 class="text-center">Pay attention</h4>
          <p class="text-center">
            Unsaved progress will be losed.<br>
            If you want, go back and save them.
          </p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fa fa-undo" aria-hidden="true"></i> Cancel</button>
          <a class="btn btn-danger text-white" href="{{ url('/') }}/{{ $type }}/{{ $app->category->section->slug }}/{{ $app->category->slug }}"><i class="fa fa-sign-out" aria-hidden="true"></i> Close</a>
        </div>
      </div>
    </div>
  </div>
