@extends('layouts.admin')
@section('title')
  Tags
@endsection
@section('page-title')
  Tags
@endsection
@section('content')
      <div class="clearfix">
        <div class="container">
          <div class="row">
            <div class="col-md-8">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Edit</th>
                    <th>Delete</th>
                  </tr>
                </thead>
                <tbody>
                @foreach ($tags as $tag)
                  <tr>
                    <td>{{ $tag->id }}</td>
                    <td>{{ $tag->name }}</td>
                    <td><a class="btn btn-small btn-info" href="tags/{{ $tag->id }}/edit">Edit</a></td>
                    <td>
                      <form action="/admin/tags/{{ $tag->id }}" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}

                        {{-- Modal Trigger --}}
                        <button type="button" class="btn btn-small btn-danger" data-toggle="modal" data-target="#delete" name="button">Delete</button>

                        {{-- Modal --}}
                        <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="deleteLabel" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="deleteLabel">Delete Categories</h5>
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
              </tbody>
              </table>
            </div>

            <div class="col-md-4">
              <div class="card">
                <h3 class="card-header">New Tag</h3>
                <div class="card-block">
                  <div class="card-text">
                    <form action="{{ route('tags.store') }}" method="POST">
                      {{ csrf_field() }}
                      {{ method_field('POST') }}

                      <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control" placeholder="Name of the tag">
                      </div>

                        <button type="submit" name="button" class="btn btn-small btn-primary btn-block mt-4">Save</button>

                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
@endsection
