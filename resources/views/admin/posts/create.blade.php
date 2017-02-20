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

      <form action="/admin/posts" method="POST">
      <div class="form-group">
        <label for="title">Title</label>
        <input name="title" value="{{ old('title') }}" type="text"class="form-control" id="title" placeholder="title of the post">
      </div>

      <div class="form-group">
        <label for="content">Content</label>
        <textarea name="content" value="{{ old('content') }}" class="form-control" id="content" placeholder="content of the post" rows="8"></textarea>
      </div>

      <div class="form-group">
        <label for="media_id">Featured_image</label>
        <input name="media_id" value="{{ old('media_id') }}" type="text" class="form-control" id="media_id" placeholder="media id">
      </div>

      <div class="form-group">
        <label for="user_id">Title</label>
        <input name="user_id" value="{{ old('user_id') }}" type="text" class="form-control" id="user_id" placeholder="author id">
      </div>
      {{ csrf_field() }}
      {{ method_field('POST') }}

      <button type="submit" class="btn btn-success" value="Submit">Save</button>

      </form>

    </div>

    @include('admin.footer')
  </body>
</html>
