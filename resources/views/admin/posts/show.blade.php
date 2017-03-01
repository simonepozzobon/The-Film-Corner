@extends('layouts.admin')

@section('title')
   Post - {{ $post->title }}
@endsection

@section('content')
  <div class="row">
    <div class="col-8">
      <div class="featured-image">
        <img class="img-fluid" src="{{ Storage::disk('local')->url($post->featuredImage->tablet) }}">
      </div>
      <h1 class="mt-4">{{ $post->title }}</h1>
      <p class="mt-4">{!! $post->content !!}</p>
    </div>
    <div class="col-4">
      <div class="card">
        <h3 class="card-header">Post Details</h3>
        <div class="card-block">
          <div class="card-text">
            <table class="table">
              <thead>
                <th>Created At:</th>
              </thead>
              <tbody>
                <td>{{ $post->created_at }}</td>
              </tbody>
            </table>
            <table class="table">
              <thead>
                <th>Updated At:</th>
              </thead>
              <tbody>
                <td>{{ $post->updated_at }}</td>
              </tbody>
            </table>
            <div class="row">
              <div class="col">
                <a class="btn btn-small btn-info btn-block" href="/admin/posts/{{ $post->id }}/edit">Edit</a>
              </div>
              <div class="col">
                <form action="/admin/posts/{{ $post->id }}" method="POST">
                  {{ csrf_field() }}
                  {{ method_field('DELETE') }}

                  {{-- Trigger for Modal --}}
                  <button type="button" class="btn btn-small btn-danger btn-block" data-toggle="modal" data-target="#delete">Delete</button>

                  {{-- Modal --}}
                  <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="delete" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="deleteLabel">Delete Post</h5>
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
                  {{-- End Modal --}}

                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
