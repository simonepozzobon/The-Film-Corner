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

      <div class="clearfix">
        <a class="btn btn-small btn-success float-right" href="{{ url('admin/media/create') }}">Add Media</a>
      </div>

      <br>

      <div class="clearfix">
        <table class="table table-striped table-bordered">
          <thead>
            <tr>
              <td>Id</td>
              <td>Title</td>
              <td>Media</td>
              <td>Preview</td>
              <td>Delete</td>
            </tr>
          </thead>

          @foreach ($medias as $media)
            <tr>
              {{-- show media --}}
              <td>{{ $media->id }}</td>
              <td>{{ $media->title }}</td>
              <td><img width="200" class="img-thumbnail mx-auto d-block" src="{{ Storage::disk('local')->url($media->url) }}"></td>
              {{-- Preview --}}
              <td><a class="btn btn-small btn-success" href="/media/{{ $media->id }}">Preview</a></td>

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

      @include('admin.footer')
    </div>
  </body>
</html>
