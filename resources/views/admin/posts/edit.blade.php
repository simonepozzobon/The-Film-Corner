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

      <form action="/admin/posts/{{ $post->id }}" method="POST">
        <div class="form-group">
          <label for="title">Title</label>
          <input name="title" value="{{ old('title') }}" type="text"class="form-control" id="title" placeholder="title of the post">
        </div>

        <div class="form-group">
          <label for="content">Content</label>
          <textarea name="content" value="{{ old('content') }}" class="form-control" id="content" placeholder="content of the post" rows="8"></textarea>
        </div>

        <div class="form-group">
          <label for="user_id">Title</label>
          <input name="user_id" value="{{ old('user_id') }}" type="text" class="form-control" id="user_id" placeholder="author id">
        </div>

        {{ method_field('PUT') }}
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <button type="submit" class="btn btn-success" value="Submit">Save</button>

      </form>

      @include('admin.footer')
    </div>
  </body>
</html>
