@extends('layouts.admin')
@section('title', 'Users')
@section('page-title', 'Users')
@section ('content')
      <div class="clearfix">
        <div class="row">
          <div class="col-8">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>Id</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>View</th>
                </tr>
              </thead>

              @foreach ($users as $user)
                <tr>
                  <td>{{ $user->id }}</td>
                  <td>{{ $user->name }}</td>
                  <td>{{ $user->email }}</td>
                  <td><a class="btn btn-small btn-info" href="users/{{ $user->id }}">View</a></td>
                </tr>
              @endforeach
            </table>
          </div>
          <div class="col-4">
            <div class="card">
              <h3 class="card-header">New User</h3>
              <div class="card-block">
                <div class="card-text">
                  <form action="/admin/users" method="POST">
                    <div class="form-group">
                      <label for="name">Name:</label>
                      <input name="name" value="{{ old('name') }}" type="text"class="form-control" id="name" placeholder="Name of the user">
                    </div>

                    <div class="form-group">
                      <label for="email">Email:</label>
                      <input name="email" type="email" value="{{ old('email') }}" class="form-control" id="content" placeholder="user@email.com">
                    </div>

                    <div class="form-group">
                      <label for="password">Password:</label>
                      <input name="password" value="{{ old('password') }}" type="password" class="form-control" id="password" placeholder="password">
                    </div>
                    {{ csrf_field() }}
                    {{ method_field('POST') }}

                    <button type="submit" class="btn btn-primary btn-block mt-4" value="Submit">Save</button>

                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
@endsection
