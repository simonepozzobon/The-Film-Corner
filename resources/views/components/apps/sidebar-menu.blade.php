@php
  if (!isset($student)) {
    $student = false;
  }
@endphp
<div class="sidebar-menu">
  @if ($student == false)
      <div id="save-btn" class="button">
        <a class="text-white text-align-center btn btn-primary btn-lg" data-toggle="modal" data-target="#saveSession">
          <i class="fa fa-floppy-o" aria-hidden="true"></i>
        </a>
      </div>
      @if (isset($app_session) && $app_session->teacher_shared == 1)
        <div id="comment-btn" class="button">
          <a class="text-white text-align-center btn btn-warning btn-lg" data-toggle="collapse" data-target="#chat">
            <i class="fa fa-comment-o" aria-hidden="true"></i>
            {{-- <span id="alert-messages" class="badge badge-pill badge-danger">!</span> --}}
          </a>
        </div>
      @endif
  @else
      <div id="approve-btn" class="button">
        <a class="text-white text-align-center btn btn-success btn-lg" data-toggle="modal" data-target="#saveSession">
          <i class="fa fa-check" aria-hidden="true"></i>
        </a>
      </div>
      <div id="comment-btn" class="button">
        <a class="text-white text-align-center btn btn-warning btn-lg" data-toggle="collapse" data-target="#chat">
          <i class="fa fa-comment-o" aria-hidden="true"></i>
          {{-- <span id="alert-messages" class="badge badge-pill badge-danger">!</span> --}}
        </a>
      </div>
  @endif
  <div id="close-btn" class="button">
    <a class="text-white text-align-center btn btn-danger btn-lg" data-toggle="modal" data-target="#close">
      <i class="fa fa-sign-out" aria-hidden="true"></i>
    </a>
  </div>
</div>
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
        <form>
          {{ csrf_field() }}
          {{ method_field('POST') }}

          <div class="modal-body">
            <div class="form-group">
              <label for="">Title:</label>
              <input type="text" name="title" class="form-control">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Cancel</button>
            <button type="button" class="btn btn-primary" onclick="AppSession.updateSession({{ $app->id }})"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</button>
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
          Usaved progress will be losed.<br>
          If you want, go back and save them.
        </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Cancel</button>
        <a class="btn btn-danger text-white" href="{{ url('/') }}/{{ $type }}/{{ $app->category->section->slug }}/{{ $app->category->slug }}"><i class="fa fa-sign-out" aria-hidden="true"></i> Close</a>
      </div>
    </div>
  </div>
</div>
