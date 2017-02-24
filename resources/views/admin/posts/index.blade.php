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
            <td>Image</td>
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
            <td><img width="57" class="mx-auto d-block" src="{{ Storage::disk('local')->url($post->featuredImage->icon) }}"></td>
            <td>{{ $post->author->name }}</td>

            {{-- show post --}}
            <td><a class="btn btn-small btn-success" href="/post/{{ $post->id }}">Preview</a></td>

            {{-- edit post --}}
            <td><a class="btn btn-small btn-info" href="/admin/posts/{{ $post->id }}/edit">Edit</a></td>

            <td>
              <form action="/admin/posts/{{ $post->id }}" method="POST">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}

                {{-- Trigger for Modal --}}
                <button type="button" class="btn btn-small btn-danger" data-toggle="modal" data-target="#delete">Delete</button>

                {{-- Modal --}}
                <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="delete" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="deleteLabel">Delete Post</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        Are you sure?
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-small btn-danger" value="Submit">Delete</button>
                      </div>
                    </div>
                  </div>
                </div>
                {{-- End Modal --}}

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
