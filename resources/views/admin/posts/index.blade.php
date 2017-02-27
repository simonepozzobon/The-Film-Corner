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
    </div>
    <br>

    <div class="clearfix">
      <div class="row">
        <div class="col-8">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>Id</th>
                <th>Title</th>
                <th>Image</th>
                <th>Category</th>
                <th>Author</th>
                <th>Preview</th>
              </tr>
            </thead>
            @foreach ($posts as $post)
              <tr>
                <td>{{ $post->id }}</td>
                <td>{{ $post->title }}</td>
                <td><img width="57" class="mx-auto d-block" src="{{ Storage::disk('local')->url($post->featuredImage->icon) }}"></td>
                <td>
                  @if ($post->category_id)
                    {{ $post->category->name }}
                  @else
                    uncategorized
                  @endif
                </td>
                <td>{{ $post->author->name }}</td>
                <td><a class="btn btn-small btn-info" href="/admin/posts/{{ $post->id }}">Preview</a></td>
              </tr>
            @endforeach
          </table>
        </div>
        <div class="col-4">
          <div class="card">
            <h3 class="card-header">New Post</h3>
            <div class="card-block">
              <div class="card-text">
                <a class="btn btn-small btn-success btn-block" href="{{ url('admin/posts/create') }}">Add Post</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    @include('admin.footer')
  </div>
</body>
</html>
