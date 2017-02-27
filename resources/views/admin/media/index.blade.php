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
        <h1>Media</h1>
      </div>
      @if (session('status'))
        <div class="alert alert-success">
          {{ session('status') }}
        </div>
      @endif

      <br>

      <div class="clearfix">
        <div class="container">
          <div class="row">
            <div class="col-8">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>Id</th>
                    <th>Title</th>
                    <th>Media</th>
                    <th>Delete</th>
                  </tr>
                </thead>

                @foreach ($medias as $media)
                  <tr>
                    {{-- show media --}}
                    <td>{{ $media->id }}</td>
                    <td>{{ $media->title }}</td>
                    <td><img width="57" class="mx-auto d-block" src="{{ Storage::disk('local')->url($media->icon) }}"></td>

                    <td>
                      <form action="/admin/media/{{ $media->id }}" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <button type="submit" class="btn btn-small btn-danger" value="Submit">Delete</button>
                      </form>
                    </td>
                  </tr>
                @endforeach

              </table>
            </div>
            <div class="col-4">
              <div class="card">
                <h3 class="card-header">
                  New Image
                </h3>
                <div class="card-block">
                  <div class="card-text">
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
                        <input type="file" name="media" class="form-control"></input>
                      </div>
                      <button type="submit" class="btn btn-primary btn-block mt-4">Upload</button>
                    </form>
                  </div>
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
