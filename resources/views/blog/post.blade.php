@extends('layouts.main')
@section('title')
  {{$post->title}}
@endsection
@include('layouts.main._menu')
@section('content')
<section class="mt-2">
  <div class="container">
    <div class="col-md-10 offset-md-1">
      <ol class="breadcrumb mt-3">
        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
        <li class="breadcrumb-item active">{{ $post->title }}</li>
      </ol>
      <div class="featured-image" style="background: url({{ Storage::disk('local')->url($post->featuredImage->tablet) }}) center center no-repeat;">
        <div class="image-dimension">
        </div>
        <div class="title single-post-title sp-center mt-5">
          {{$post->title}}
        </div>
      </div>
      <div class="clearfix">
        <p class="mt-4">{!! $post->content !!}</p>
      </div>
      <hr>
      <div class="tags">
        @foreach ($post->tags as $tag)
          <span class="badge badge-default">{{ $tag->name }}</span>
        @endforeach
      </div>
    </div>
  </div>
</section>
@endsection
