<!DOCTYPE html>
<html>
  <head>
    @include('admin.head')
  </head>
  <body>
    <div class="container">
      @include('admin.menu')
      <h1>Create a new post</h1>

      {!! Form::open(['url' => 'admin/posts']) !!}

      <div class="form-group">
        {{ Form::label('name', 'Name') }}
      </div>


      {!! Form::close() !!}

    </div>
  </body>
</html>
