<html>
  <head>
    @include('admin.head')
  </head>
<body>

  <div class="container">
    @include('admin.menu')
    <br>
    <div class="clearfix">
      <h1>Posts</h1>
    </div>

    <div>
    @if (session('status'))
        <div class="alert alert-success">
          {{ session('status') }}
        </div>
    @endif
    <div>

    <div class="clearfix">
      <a class="btn btn-small btn-success float-right" href="{{ url('admin/posts/create') }}">Add Post</a>
    </div>

    <br>

    <div class="clearfix">
      <table class="table table-striped table-bordered">
        <thead>
          <tr>
            <td>Id</td>
            <td>Title</td>
            <td>Content</td>
            <td>User</td>
            <td>Preview</td>
            <td>Edit</td>
            <td>Delete</td>
          </tr>
        </thead>

        @foreach ($posts as $post)
          <tr>
            <!-- Show Post -->
            <td>{{ $post->id }}</td>
            <td>{{ $post->title }}</td>
            <td>{{ $post->content }}</td>
            <td>{{ $post->author->name }}</td>

            {{-- show post --}}
            <td><a class="btn btn-small btn-success" href="/post/{{ $post->id }}">Preview</a></td>

            {{-- edit post --}}
            <td><a class="btn btn-small btn-info" href="/admin/posts/{{ $post->id }}/edit">Edit</a></td>

            <td>
              <form action="/admin/posts/{{ $post->id }}" method="POST">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <button type="submit" class="btn btn-small btn-danger" value="Submit">Delete</button>
              </form>
            </td>
          </tr>
        @endforeach

      </table>
    </div>
    @include('admin.footer')
  </div>
</body>
</html>
