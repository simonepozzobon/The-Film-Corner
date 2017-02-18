<!DOCTYPE html>
<html>
  <head>
    @include('admin.head')
  </head>
  <body>
    <div class="container">
      <div><h1>{{ $post->title }}</h1></div>

      <div>
      @if (session('status'))
          <div class="alert alert-success">
            {{ session('status') }}
          </div>
      @endif
      <div>

      {{ Form::model($post, array('route' => array('admin.posts.update', $post->id), 'method' => 'PUT')) }}
      {{ Form::close() }}
      ciao
      @include('admin.footer')
    </div>
  </body>
</html>
