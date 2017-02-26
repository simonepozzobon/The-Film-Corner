<!DOCTYPE html>
<html>
  <head>
    @include('admin.head')
  </head>
  <body>
    <div class="container">
      @include('admin.menu')
      <br>
      <h1>Create a new post</h1>
      @if (count($errors) > 0)
        <ul>
          @foreach ($errors as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>

      @endif
      <br>
      <form action="/admin/posts" method="POST">
        <div class="container">
          <div class="row">
            <div class="col-8">
              <div class="form-group">
                <label for="title">Title</label>
                <input name="title" value="{{ old('title') }}" type="text"class="form-control" id="title" placeholder="title of the post">
              </div>

              <div class="form-group">
                <label for="content">Content</label>
                <textarea name="content" value="{{ old('content') }}" class="form-control" id="content" placeholder="content of the post" rows="8"></textarea>
              </div>
            </div>
            <div class="col-4">
              {{-- Featured Image --}}
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

              {{-- Author --}}
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

              {{-- Category selection --}}
              {{-- <div class="form-group">
                <label for="categories">Categories</label>
                @if ($categories)
                  <select multiple class="form-control" name="categories" id="categories">
                    @foreach ($categories as $category)

                      <option value="{{ $category->id }}">{{ $category->name }}</option>

                    @endforeach
                  </select>
                @else
                  You need to create a category first!!
                @endif
              </div> --}}

            </div>
          </div>
        </div>
      {{ csrf_field() }}
      {{ method_field('POST') }}

      <button type="submit" class="btn btn-success" value="Submit">Save</button>

      </form>

    </div>

    @include('admin.footer')
  </body>
</html>
