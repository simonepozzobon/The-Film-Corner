<!DOCTYPE html>
<html>
  <head>
    @include('admin.head')
  </head>
  <body>
    <div class="container">
      @include('admin.menu')
      <br>
      <div><h1>Edit Post: {{ $post->title }}</h1></div>

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
          <label for="media_id">Featured Image</label>
          <br>
          @if ($medias)
            {{-- Modal Trigger --}}
            <button type="button" class="btn btn-small btn-primary" data-toggle="modal" data-target="#featuredImage">Select Image</button>

            {{-- Modal Box --}}
            <div class="modal fade" id="featuredImage" tabindex="-1" role="dialog" aria-labelledby="featuredImageLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="featuredImageLabel">Select Featured Image</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    {{-- Content --}}
                    <select class="form-control image-picker" name="media_id" id="media_id">
                      @foreach ($medias as $media)
                        <option data-img-src="{{ Storage::disk('local')->url($media->icon) }}" data-img-alt="{{ $media->id }}" value="{{ $media->id }}">{{ $media->title }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close and Save</button>
                  </div>
                </div>
              </div>
            </div>
          @else
            You need to upload an image first!!
          @endif
        </div>

        <div class="form-group">
          <label for="user_id">Author</label>
          @if ($users)
            <select name="user_id" class="form-control" id="user_id">
              @foreach ($users as $user)

                <option value="{{ $user->id }}">{{ $user->name }}</option>

              @endforeach
            </select>
          @else
            You need to create a user first!!
          @endif
        </div>
        {{ csrf_field() }}
        {{ method_field('PUT') }}

        <button type="submit" class="btn btn-success" value="Submit">Save</button>

      </form>

      @include('admin.footer')
    </div>
  </body>
</html>
