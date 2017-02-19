<!DOCTYPE html>
<html>
  <head>
    @include('admin.head')
  </head>
  <body>
      <div class="container">
        @include('admin.menu')

        <form action="/admin/medias" method="POST" enctype="multipart/form-data">
          {{ csrf_field() }}
          <input type="file" name="media" value=""></input>
        </form>

        @include('admin.footer')
      </div>
  </body>
</html>
