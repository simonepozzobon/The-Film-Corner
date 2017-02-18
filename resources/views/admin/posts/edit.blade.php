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
      </div>

      ciao

      @include('admin.footer')
    </div>
  </body>
</html>
