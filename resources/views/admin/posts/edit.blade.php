@extends('layouts.admin')
@section('title')
 Edit Post - {{ $post->title }}
@endsection
@section('page-title', "$post->title")
@section('stylesheets')
  <script src="//cloud.tinymce.com/stable/tinymce.min.js?apiKey=qecr5wd0wdcbodk88lbyo28f9rwd2zpg9kqvq6cgle2fkal7"></script>
  <script type="text/javascript">
    tinymce.init({
      selector: 'textarea.content',
      plugins: 'link',
      menubar: false,

    });
  </script>
  <link rel="stylesheet" href="{{ asset('admin-assets/css/select2.min.css') }}">
@endsection
@section('content')
      <form action="/admin/posts/{{ $post->id }}" method="POST">
        {{ csrf_field() }}
        {{ method_field('PUT') }}
        <div class="container">
          <div class="row">
            {{-- left --}}
            <div class="col-8">
              <div class="form-group">
                <label for="title">Title</label>
                <input name="title" value="{{ $post->title }}" type="text"class="form-control" id="title" placeholder="title of the post">
              </div>
              <div class="form-group">
                <label for="content">Content</label>
                <textarea name="content" value="{{ $post->content }}" class="form-control content" id="content" placeholder="content of the post" rows="8">{{ $post->content }}</textarea>
              </div>
            </div>
            {{-- right --}}
            <div class="col-4">
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
                            <option data-img-src="/img/helpers/null-image.svg" data-img-alt="No Image" value="">Null</option>
                            @foreach ($medias as $media)
                              @if ($media->id == $post->media_id)
                                <option data-img-src="{{ Storage::disk('local')->url($media->icon) }}" selected="selected" data-img-alt="{{ $media->id }}" value="{{ $media->id }}">{{ $media->title }}</option>
                              @else
                                <option data-img-src="{{ Storage::disk('local')->url($media->icon) }}" data-img-alt="{{ $media->id }}" value="{{ $media->id }}">{{ $media->title }}</option>
                              @endif
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
                @if (isset($admins))
                  <select name="user_id" class="form-control" id="user_id">
                    @foreach ($admins as $admin)

                      <option value="{{ $admin->id }}">{{ $admin->name }}</option>

                    @endforeach
                  </select>
                @else
                  You need to create a user first!!
                @endif
              </div>

              {{-- Slug --}}
              <div class="form-group">
                <label for="slug">Slug</label>
                <textarea name="slug" value="{{ $post->slug }}" class="form-control" rows="1" minlenght="5" maxlength="255">{{ $post->slug }}</textarea>
              </div>

              {{-- Category selection --}}
              <div class="form-group">
                <label for="category_id">Category</label>
                @if ($categories)
                  <select class="form-control" name="category_id" id="category_id">
                    @foreach ($categories as $category)

                      <option value="{{ $category->id }}">{{ $category->name }}</option>

                    @endforeach
                  </select>
                @else
                  You need to create a category first!!
                @endif
              </div>

              <div class="form-group">
                <label for="tags">Tags:</label>
                <select class="form-control select2-multi" name="tags[]" multiple="multiple">
                  @foreach ($tags as $tag)
                    <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                  @endforeach
                </select>
              </div>

              <button type="submit" class="btn btn-primary btn-block mt-4" value="Submit">Save</button>
            </div>
          </div>
        </div>

      </form>

@endsection
@section('scripts')
  <script src="{{ asset('admin-assets/js/select2.full.min.js') }}"></script>
  <script type="text/javascript">
    $('.select2-multi').select2();
    var tags = {{ $tagsForThisPost }}
    $('.select2-multi').select2().val(tags).trigger('change');
  </script>
@endsection
