<!DOCTYPE html>
<html>
  <head>
    @include('admin.head')
  </head>
  <body>
    <div class="container">
      @include('admin.menu')

      <h1>Create a new post</h1>
      @if (count($errors) > 0)
        <ul>
          @foreach ($errors as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>

      @endif

      {!! Form::open(['url' => 'admin/posts']) !!}

      <div class="form-group">
        {{ Form::label('title', 'Title') }}
        {{ Form::text('title', Input::old('title'), ['class' => 'form-control']) }}
      </div>

      <div class="form-group">
        {{ Form::label('content', 'Content') }}
        {{ Form::textarea('content', Input::old('content'), ['class' => 'form-control']) }}
      </div>

      <div class="form-group">
        {{ Form::label('user_id', 'Author Id') }}
        {{ Form::text('user_id', Input::old('user_id'), ['class' => 'form-control']) }}
      </div>

        {{ Form::submit('Create Post', ['class' => 'btn btn-primary']) }}

      {!! Form::close() !!}

    </div>

    @include('admin.footer')
  </body>
</html>
