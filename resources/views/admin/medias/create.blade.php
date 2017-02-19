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
          <input type="file" name="media" value=""></input>
          <button type="submit" class="btn btn-success ">Upload</button>
        </form>

        @include('admin.footer')
      </div>
  </body>
</html>
