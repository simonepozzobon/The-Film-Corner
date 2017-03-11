@extends('layouts.admin')
@section('title', "Frame - $frame->name")
@section('page-title', "Frame - $frame->name")
@section('content')
<div class="clearfix">
  <div class="row">
    <div class="col-md-8">
      <div class="card">
        <h3 class="card-header">Frame Image</h3>
        <div class="card-block">
          <div class="card-text">
            <img src="{{ Storage::disk('local')->url($frame->frame) }}" alt="{{ $frame->name }}" width="500">
          </div>
        </div>
      </div>
      <div class="card mt-4">
        <h3 class="card-header">Description</h3>
        <div class="card-block">
          <div class="card-text">
            <p class="lead">
              {!! $frame->description !!}
            </p>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card">
        <h3 class="card-header">Frame Details</h3>
        <div class="card-block">
          <div class="card-text">
            <table class="table table-hover">
              <thead><th>Created at:</th></thead>
              <tbody><tr><td>{{ $frame->created_at }}</td></tr></tbody>
            </table>
            <table class="table table-hover">
              <thead><th>Updated at:</th></thead>
              <tbody><tr><td>{{ $frame->updated_at }}</td></tr></tbody>
            </table>
            <div class="row">
              <div class="col">
                <a href="{{ route('app_1.edit', $frame->id) }}" class="btn btn-info btn-block">Edit</a>
              </div>
              <div class="col">
                <form action="{{ route('app_1.destroy', $frame->id) }}" method="POST">
                  {{ csrf_field() }}
                  {{ method_field('DELETE') }}

                  {{-- Trigger for Modal --}}
                  <button type="button" class="btn btn-small btn-danger btn-block" data-toggle="modal" data-target="#delete">Delete</button>

                  {{-- Modal --}}
                  <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="delete" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="deleteLabel">Delete Post</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          Are you sure?
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-small btn-danger" value="Submit">Delete</button>
                        </div>
                      </div>
                    </div>
                  </div>
                  {{-- End Modal --}}

                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
