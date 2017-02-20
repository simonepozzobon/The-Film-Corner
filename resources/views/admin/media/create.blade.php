<!DOCTYPE html>
<html>
  <head>
    @include('admin.head')
  </head>
  <body>
      <div class="container">
        @include('admin.menu')
        <br>
        <form action="/admin/media" method="POST" enctype="multipart/form-data">
          {{ csrf_field() }}
          <div class="form-group">
            <label for="title">Title</label>
            <input name="title" value="{{ old('title') }}" type="text" class="form-control" id="title" placeholder="title of the media">
          </div>
          <div class="form-group">
            <label for="alt">Alt Text</label>
            <input name="alt" value="{{ old('alt') }}" type="text" class="form-control" id="alt" placeholder="alternative text">
          </div>
          <div class="form-group">
            <label for="title">File</label>
            <input type="file" name="media" class="form-control" value=""></input>
          </div>
          <button type="submit" class="btn btn-success">Upload</button>
        </form>

        @include('admin.footer')
      </div>
  </body>
</html>
