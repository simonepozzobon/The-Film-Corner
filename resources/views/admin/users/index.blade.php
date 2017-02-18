<!DOCTYPE html>
<html>
  <head>
    @include('admin.head')
  </head>
  <body>
    <div class="container">
      @include('admin.menu')
      <br>
      <div class="clearfix">
        <h1>Users</h1>
      </div>

      @if (session('status'))
          <div class="alert alert-success">
            {{ session('status') }}
          </div>
      @endif

      <div class="clearfix">
        <a class="btn btn-small btn-success float-right" href="{{ url('admin/users/create') }}">Add User</a>
      </div>

      <br>

      <div class="clearfix">
        <table class="table table-striped table-bordered">
          <thead>
            <tr>
              <td>Id</td>
              <td>Name</td>
              <td>Email</td>
              <td>Edit</td>
              <td>Delete</td>
            </tr>
          </thead>

          @foreach ($users as $user)
            <tr>
              <td>{{ $user->id }}</td>
              <td>{{ $user->name }}</td>
              <td>{{ $user->email }}</td>
              {{-- edit user --}}
              <td><a class="btn btn-small btn-info" href="users/{{ $user->id }}/edit">Edit</a></td>
              <td>
                <form action="/admin/users/{{ $user->id }}" method="POST">
                  {{ method_field('DELETE') }}
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  <button type="submit" class="btn btn-small btn-danger" value="Submit">Delete</button>
                </form>
              </td>
            </tr>
          @endforeach

        </table>
      </div>


    </div>
  </body>
</html>
