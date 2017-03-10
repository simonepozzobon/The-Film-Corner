@extends('layouts.admin')
@section('title', 'Categories')
@section('page-title', 'Categories')
@section('content')
      <div class="clearfix">
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
              @foreach ($categories as $category)
                <tr>
                  <td class="align-middle">{{ $category->id }}</td>
                  <td class="align-middle">{{ $category->name }}</td>
                  <td class="align-middle"><a class="btn btn-small btn-info" href="categories/{{ $category->id }}/edit">Edit</a></td>
                  <td class="align-middle">
                    <form action="/admin/categories/{{ $category->id }}" method="POST">
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
              <h3 class="card-header">New Category</h3>
              <div class="card-block">
                <div class="card-text">
                  <form action="/admin/categories" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('POST') }}

                    <div class="form-group">
                      <label for="name">Name:</label>
                      <input type="text" name="name" value="{{ old('name') }}" class="form-control" placeholder="Name of the category">
                    </div>

                      <button type="submit" name="button" class="btn btn-small btn-primary btn-block mt-4">Save</button>

                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
@endsection
