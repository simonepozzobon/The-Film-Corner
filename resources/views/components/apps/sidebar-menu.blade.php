<div class="feedback-popup mt-4">
  <div class="d-block m-1 pl-2">
    <a class="text-white text-align-center btn btn-info btn-lg" data-toggle="modal" data-target="#info">
      <i class="fa fa-question" aria-hidden="true"></i>
    </a>
  </div>
  <div class="d-block m-1">
    <a class="text-white text-align-center btn btn-primary btn-lg" data-toggle="modal" data-target="#saveSession">
      <i class="fa fa-floppy-o" aria-hidden="true"></i>
    </a>
  </div>
  <div class="d-block m-1">
    <a class="text-white text-align-center btn btn-danger btn-lg" data-toggle="modal" data-target="#close">
      <i class="fa fa-times" aria-hidden="true"></i>
    </a>
  </div>
</div>
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
        <h4 class="text-center">Are you sure</h4>
        <p class="text-center">
          Do you want to exit without save?
        </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Cancel</button>
        <a class="btn btn-danger text-white" href="{{ route('teacher.film-specific.index', $app->category->slug) }}"><i class="fa fa-sign-out" aria-hidden="true"></i> Close Without Save</a>
      </div>
    </div>
  </div>
</div>
