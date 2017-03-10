@extends('layouts.admin')
@section('title', "Partner $partner->name - Preview")
@section('page-title', "$partner->name - Preview")
@section('content')
  <div class="clearfix">
    <div class="row">
      <div class="col-md-8">
          <div class="card">
            <h3 class="card-header">Partner Informations</h3>
            <div class="card-block">
              <div class="card-text">
                <div class="row">
                  <div class="col-md-5">
                    <img width="250" class="" src="{{ Storage::disk('local')->url($partner->logo_url) }}">
                  </div>
                  <div class="col-md-7">
                    <table class="table">
                      <thead><th>Location</th></thead>
                      <tbody><tr><td>{{ $partner->location }}</td></tr></tbody>
                    </table>
                    <table class="table">
                      <thead><th>Url</th></thead>
                      <tbody><tr><td><a href="{{ $partner->url }}" target="_blank">{{ $partner->url }}</a></td></tr></tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <div class="row mt-4">
          <div class="col">
            <div class="card">
              <h3 class="card-header">Description</h3>
              <div class="card-block">
                <div class="card-text">
                  {!! $partner->description !!}
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card">
          <h3 class="card-header">Partner Details</h3>
          <div class="card-block">
            <div class="card-text">
              <dl class="dl-horizontal">
                <label><b>Created At:</b></label>
                <p>{{ $partner->created_at }}</p>
              </dl>
              <dl class="dl-horizontal">
                <label><b>Updated At:</b></label>
                <p>{{ $partner->updated_at }}</p>
              </dl>
              <hr>
              <div class="row">
                <div class="col">
                  <a class="btn btn-small btn-info btn-block" href="{{ route('partners.edit', $partner->id) }}">Edit</a>
                </div>
                <div class="col">
                  <form action="{{ route('partners.destroy', $partner->id) }}" method="POST">
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
