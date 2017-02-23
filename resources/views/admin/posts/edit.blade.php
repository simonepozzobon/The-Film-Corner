<!DOCTYPE html>
<html>
  <head>
    @include('admin.head')
  </head>
  <body>
    <div class="container">
      @include('admin.menu')
      <div><h1>{{ $post->title }}</h1></div>

      <div>
      @if (session('status'))
          <div class="alert alert-success">
            {{ session('status') }}
          </div>
      @endif
      </div>

      <form action="/admin/posts/{{ $post->id }}" method="POST">
        <div class="form-group">
          <label for="title">Title</label>
          <input name="title" value="{{ $post->title }}" type="text"class="form-control" id="title" placeholder="title of the post">
        </div>

        <div class="form-group">
          <label for="content">Content</label>
          <textarea name="content" value="{{ $post->content }}" class="form-control" id="content" placeholder="content of the post" rows="8">{{ $post->content }}</textarea>
        </div>

        <div class="form-group">
          <label for="media_id">Featured_image</label>
          <input name="media_id" value="{{ $post->media_id }}" type="text" class="form-control" id="media_id" placeholder="media id">
        </div>

        <div class="form-group">
          <label for="user_id">Author</label>
          <input name="user_id" value="{{ $post->user_id }}" type="text" class="form-control" id="user_id" placeholder="author id">
        </div>
        {{ csrf_field() }}
        {{ method_field('PUT') }}

        <button type="submit" class="btn btn-success" value="Submit">Save</button>

      </form>

      @include('admin.footer')
    </div>
  </body>
</html>
