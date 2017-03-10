@extends('layouts.admin')
@section('title', 'Media')
@section('page-title', 'Media')
@section('content')
      <div class="clearfix">
        <div class="container">
          <div class="row">
            <div class="col-md-8">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>Id</th>
                    <th>Title</th>
                    <th>Media</th>
                    <th>Delete</th>
                  </tr>
                </thead>

                @foreach ($medias as $media)
                  <tr>
                    {{-- show media --}}
                    <td class="align-middle">{{ $media->id }}</td>
                    <td class="align-middle">{{ $media->title }}</td>
                    <td class="align-middle"><img width="57" class="mx-auto d-block" src="{{ Storage::disk('local')->url($media->icon) }}"></td>

                    <td class="align-middle">
                      <form action="/admin/media/{{ $media->id }}" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}

                        {{-- Modal Trigger --}}
                        <button type="button" class="btn btn-small btn-danger" data-toggle="modal" data-target="#delete" name="button">Delete</button>

                        {{-- Modal --}}
                        <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="deleteLabel" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="deleteLabel">Delete Media</h5>
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
                      </form>
                    </td>
                  </tr>
                @endforeach

              </table>
            </div>
            <div class="col-md-4">
              <div class="card">
                <h3 class="card-header">
                  New Image
                </h3>
                <div class="card-block">
                  <div class="card-text">
                    <form action="/admin/media" method="POST" enctype="multipart/form-data">
                      {{ csrf_field() }}
                      <div class="form-group">
                        <label for="title">Title</label>
                        <input name="title" value="{{ old('title') }}" type="text" class="form-control" id="title" placeholder="title of the media">
                      </div>
                      <div class="form-group">
                        <label for="alt">Alt Text</label>
                        <input name="alt" value="{{ old('alt') }}" type="text" class="form-control" id="alt" placeholder="alternative text">
                      </div>
                      <div class="form-group">
                        <label for="title">File</label>
                        <input type="file" name="media" class="form-control"></input>
                      </div>
                      <button type="submit" class="btn btn-primary btn-block mt-4">Upload</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>


      </div>
@endsection
