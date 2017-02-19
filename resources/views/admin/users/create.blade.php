<!DOCTYPE html>
<html>
  <head>
    @include('admin.head')
  </head>
  <body>
    <div class="container">
      @include('admin.menu')

      <h1>Create a new user</h1>
      @if (count($errors) > 0)
        <ul>
          @foreach ($errors as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>

      @endif

      <form action="/admin/users" method="POST">
      <div class="form-group">
        <label for="name">Name</label>
        <input name="name" value="{{ old('name') }}" type="text"class="form-control" id="name" placeholder="Name of the user">
      </div>

      <div class="form-group">
        <label for="email">Email</label>
        <input name="email" value="{{ old('email') }}" class="form-control" id="content" placeholder="user@email.com">
      </div>

      <div class="form-group">
        <label for="password">Password</label>
        <input name="password" value="{{ old('password') }}" type="text" class="form-control" id="password" placeholder="password">
      </div>
      {{ csrf_field() }}
      {{ method_field('POST') }}

      <button type="submit" class="btn btn-success" value="Submit">Save</button>

      </form>

    </div>

    @include('admin.footer')
  </body>
</html>
