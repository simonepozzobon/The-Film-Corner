<!DOCTYPE html>
<html>
  <head>
    @include('admin.head')
  </head>
  <body>
    <div class="container">
      @include('admin.menu')

      <h1>Create a new post</h1>
      {{ Html::ul($errors->all()) }}

      {!! Form::open(['url' => 'admin/posts']) !!}

      <div class="form-group">
        {{ Form::label('title', 'Title') }}
        {{ Form::text('title', Input::old('title'), ['class' => 'form-control']) }}
      </div>

      <div class="form-group">
        {{ Form::label('content', 'Content') }}
        {{ Form::text('content', Input::old('content'), ['class' => 'form-control']) }}
      </div>

      <div class="form-group">
        {{ Form::label('content', 'Content') }}
        {{ Form::text('content', Input::old('content'), ['class' => 'form-control']) }}
      </div>

        {{ Form::submit('Create Post', ['class' => 'btn btn-primary']) }}

      {!! Form::close() !!}

    </div>

    @include('admin.footer')
  </body>
</html>
