@extends('layouts.admin')
@section('title')
  Teacher {{ $teacher->name }}
@endsection
@section('page-title')
  Edit Teacher - {{ $teacher->name }}
@endsection
@section('content')
    <div class="row">
      <div class="col-md-8">
        <div class="card">
          <h3 class="card-header">Teacher Informations</h3>
          <div class="card-block">
            <div class="card-text">
              <div class="row">
                <div class="col-md-6">
                  <img class="img-circle m-x-auto d-block" src="/img/logo.png" alt="Teacher - {{ $teacher->name }}" style="width: 100%">
                </div>
                <div class="col-md-6">
                  <table class="table">
                    <thead><th>Name</th></thead>
                    <tbody><tr><td>{{ $teacher->name }}</td></tr></tbody>
                  </table>
                  <table class="table">
                    <thead><th>Email</th></thead>
                    <tbody><tr><td>{{ $teacher->email }}</td></tr></tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card mt-4">
          <h3 class="card-header">School Informations</h3>
          <div class="card-block">
            <div class="card-text">
              <table class="table">
                <thead>
                  <th>Name</th>
                  <th>Address</th>
                  <th>City</th>
                  <th>Postal Code</th>
                  <th>Country</th>
                </thead>
                <tbody>
                  <tr>
                    <td>{{ $teacher->school->name }}</td>
                    <td>{{ $teacher->school->address }}</td>
                    <td>{{ $teacher->school->city }}</td>
                    <td>{{ $teacher->school->postal_code }}</td>
                    <td>{{ $teacher->school->country }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="card mt-4">
          <h3 class="card-header">Students Assigned</h3>
          <div class="card-block">
            <div class="card-text">
              <table class="table table-hover">
                <thead>
                  <th>Id</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>View</th>
                </thead>
                <tbody>
                  <tr>
                    <td>1</td>
                    <td>Gianni</td>
                    <td>student@email.com</td>
                    <td><button type="button" name="button" class="btn btn-info btn-small">View</button></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card">
          <h3 class="card-header">Account Details</h3>
          <div class="card-block">
            <div class="card-text">
              <table class="table">
                <thead>
                  <th>Created At:</th>
                </thead>
                <tbody>
                  <td>{{ $teacher->created_at }}</td>
                </tbody>
              </table>
              <table class="table">
                <thead>
                  <th>Updated At:</th>
                </thead>
                <tbody>
                  <td>{{ $teacher->updated_at }}</td>
                </tbody>
              </table>
              <div class="row">
                <div class="col">
                  <a class="btn btn-small btn-info btn-block" href="/admin/teachers/{{ $teacher->id }}/edit">Edit</a>
                </div>
                <div class="col">
                  <form action="/admin/teachers/{{ $teacher->id }}" method="POST">
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
@endsection
