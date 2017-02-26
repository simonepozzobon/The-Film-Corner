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
        <h1>Categories</h1>
      </div>
      @if (session('status'))
          <div class="alert alert-success">
            {{ session('status') }}
          </div>
      @endif
      <div class="clearfix">
        <a class="btn btn-small btn-success float-right" href="{{ url('admin/categories/create') }}">Add Category</a>
      </div>
      <br>
      <div class="clearfix">
        <table class="table table-striped table-bordered">
          <thead>
            <tr>
              <td>Id</td>
              <td>Name</td>
              <td>Edit</td>
              <td>Delete</td>
            </tr>
          </thead>

          @foreach ($categories as $category)
            <tr>
              <td>{{ $category->id }}</td>
              <td>{{ $category->name }}</td>
              <td><a class="btn btn-small btn-info" href="categories/{{ $category->id }}/edit">Edit</a></td>
              <td>
                <form action="/admin/categories/{{ $category->id }}" method="POST">
                  {{ csrf_field() }}
                  {{ method_field('DELETE') }}

                  {{-- Modal Trigger --}}
                  <button type="button" class="btn btn-small btn-danger" data-toggle="modal" data-target="#delete" name="button">Delete</button>

                  {{-- Modal --}}
                  <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="deleteLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="deleteLabel">Delete Categories</h5>
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
                </form>
              </td>
            </tr>
          @endforeach

        </table>

      </div>


    </div>
    @include('admin.footer')
  </body>
</html>
