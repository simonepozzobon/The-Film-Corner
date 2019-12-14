@extends('layouts.admin')
@section('title', "Teacher $teacher->name")
@section('page-title', "$teacher->name")
@section('content')
    <div class="row">
      <div class="col-md-8">
        <div class="card">
          <h3 class="card-header">Teacher Informations</h3>
          <div class="card-block">
            <div class="card-text">
              <div class="row">
                <div class="col-md-6">
                  @if ($teacher->profile_img)
                    <img class="img-circle mx-auto d-block" src="{{ Storage::disk('local')->url($teacher->profile_img) }}" alt="Teacher - {{ $teacher->name }}" width="220">
                  @else
                    <img class="mx-auto d-block" src="{{ url('/') }}/img/helpers/null-image.png" width="220">
                  @endif
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
          <h3 class="card-header">Stats</h3>
          <div class="card-block">
            <div class="card-text">
              stats
            </div>
          </div>
        </div>
        <div class="card mt-4">
          <h3 class="card-header">Students Assigned</h3>
          <div class="card-block">
            <div class="card-text">
              <table class="table table-hover">
                <thead>
                  <th>Name</th>
                  <th>Email</th>
                  <th>View</th>
                </thead>
                <tbody>
                  @foreach ($students as $student)
                    <tr>
                      <td>{{ $student->name }}</td>
                      <td>{{ $student->email }}</td>
                      <td><button type="button" name="button" class="btn btn-info btn-small">View</button></td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="card mt-4">
          <h3 class="card-header">Add New Student</h3>
          <div class="card-block">
            <div class="card-text">
              @if ($students_num >= $teacher->students_slots)
                {{-- Limite raggiunto --}}
                <span class="alert alert-warning d-block">Ask to increase accounts available or remove one of them</span>
              @else
                <form action="{{ route('teacher.store.student', $teacher->id) }}" method="post">
                  {{ csrf_field() }}
                  {{ method_field('POST') }}
                  <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="form-control" placeholder="Name of the student">
                  </div>
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="student@email.com">
                  </div>
                  <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" value="{{ old('password') }}" class="form-control" placeholder="123456">
                  </div>
                  <hr>
                  <button type="submit" name="button" class="btn btn-block btn-primary mt-3">Add Student</button>
                </form>
              @endif
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card">
          <h3 class="card-header">Account Details</h3>
          <div class="card-block">
            <div class="card-text">
              @if ($teacher->status == true)
                <span class="alert alert-success d-block">Active</span>
              @else
                <span class="alert alert-danger d-block">Deactivated</span>
              @endif
              <table class="table">
                <thead>
                  <th>Max</th>
                  <th>Assigned</th>
                </thead>
                <tbody>
                  <td class="">
                    @if ($teacher->students_slots == 0)
                      infinite
                    @else
                      {{ $teacher->students_slots }}
                    @endif
                  </td>
                  <td>
                    {{ $students_num }}
                  </td>
                </tbody>
              </table>
              <table class="table">
                <thead><th>Created At:</th></thead>
                <tbody><td>{{ $teacher->created_at }}</td></tbody>
              </table>
              <table class="table">
                <thead><th>Updated At:</th></thead>
                <tbody><td>{{ $teacher->updated_at }}</td></tbody>
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
        <div class="card mt-4">
          <h3 class="card-header">School Informations</h3>
          <div class="card-block">
            <div class="card-text">
              <table class="table">
                <thead><th>Name</th></thead>
                <tbody><tr><td>{{ $teacher->school->name }}</td></tr></tbody>
              </table>
              <table class="table">
                <thead><th>Address</th></thead>
                <tbody><tr><td>{{ $teacher->school->address }}</td></tr></tbody>
              </table>
              <table class="table">
                <thead><th>City</th></thead>
                <tbody><tr><td>{{ $teacher->school->city }}</td></tr></tbody>
              </table>
              <table class="table">
                <thead>
                  <th>Postal Code</th>
                  <th>Country</th>
                </thead>
                <tbody>
                  <tr>
                    <td>{{ $teacher->school->postal_code }}</td>
                    <td>{{ $teacher->school->country }}</td>
                  </tr>
                </tbody>
              </table>
              <a class="btn btn-info btn-block mt-4" href="/admin/schools/{{ $teacher->school->id }}/edit">Edit School</a>
            </div>
          </div>
        </div>
      </div>
    </div>
@endsection
