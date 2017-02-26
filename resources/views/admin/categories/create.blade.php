<!DOCTYPE html>
<html>
  <head>
    @include('admin.head')
  </head>
  <body>
    <div class="container">
      @include('admin.menu')
      <br>
      <div class="clearfix">
        <h1>Create a new category</h1>
      </div>
      <form action="/admin/categories" method="POST">
        {{ csrf_field() }}
        {{ method_field('POST') }}

        <div class="form-group">
          <label for="name">Category Name</label>
          <input type="text" name="name" value="{{ old('name') }}" class="form-control" placeholder="Name of the category">
        </div>
        <button type="submit" name="button" class="btn btn-small btn-success">Save</button>
      </form>

    </div>
    @include('admin.footer')
  </body>
</html>
