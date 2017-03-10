@extends('layouts.admin')
@section('title', 'Posts')
@section('page-title', 'Posts list')
@section('content')
    <div class="clearfix">
      <div class="row">
        <div class="col-md-8">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>Id</th>
                <th>Title</th>
                <th>Image</th>
                <th>Category</th>
                <th>Content</th>
                <th>Author</th>
                <th>Preview</th>
              </tr>
            </thead>
            @foreach ($posts as $post)
              <tr>
                <td>{{ $post->id }}</td>
                <td>{{ $post->title }}</td>
                <td>
                  @if (isset($post->featuredImage->icon))
                    <img width="57" class="mx-auto d-block" src="{{ Storage::disk('local')->url($post->featuredImage->icon) }}">
                  @else
                    <p class="text-warning text-center">No Img</p>
                  @endif
                </td>
                <td>
                  @if ($post->category_id)
                    {{ $post->category->name }}
                  @else
                    uncategorized
                  @endif
                </td>
                <td>{{ substr(strip_tags($post->content), 0, 50) }}{{ strlen(strip_tags($post->content)) > 50 ? '...' : "" }}</td>
                <td>{{ $post->author->name }}</td>
                <td><a class="btn btn-small btn-info" href="/admin/posts/{{ $post->id }}">Preview</a></td>
              </tr>
            @endforeach
          </table>
        </div>
        <div class="col-md-4">
          <div class="card">
            <h3 class="card-header">New Post</h3>
            <div class="card-block">
              <div class="card-text">
                <a class="btn btn-small btn-primary btn-block" href="{{ url('admin/posts/create') }}">Add Post</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
@endsection
