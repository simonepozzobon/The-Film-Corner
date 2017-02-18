<html>
  <head>
    @include('admin.head')
  </head>
<body>

  <div class="container">
    @include('admin.menu')

    <h1>Tutti i post</h1>

    @if (Session::has('message'))
     <!-- verficare questa parte del codice su laravel -->
    @endif

    <a class="btn btn-small btn-success pull-right" href="{{ url('admin/posts/create') }}">Add Post</a>

    <table class="table table-striped table-bordered">
      <thead>
        <tr>
          <td>Id</td>
          <td>Title</td>
          <td>Content</td>
          <td>User</td>
        </tr>
      </thead>

      @foreach ($posts as $post)
        <tr>
          <!-- Show Post -->
          <td>{{ $post->id }}</td>
          <td>{{ $post->title }}</td>
          <td>{{ $post->content }}</td>
          <td>{{ $post->author->name }}</td>

          <!-- delete post -->


          <!-- show post -->
          <td><a class="btn btn-small btn-success" href="/post/{{ $post->id }}">Preview</a></td>

          <!-- edit post -->
          <td><a class="btn btn-small btn-info" href="{{ url('admin/posts/edit') }}">Edit</a></td>

        </tr>
      @endforeach

    </table>
    @include('admin.footer')
  </div>
</body>
</html>
