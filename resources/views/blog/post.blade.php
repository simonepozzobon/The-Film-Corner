@extends('layouts.main')
@section('title')
  {{$post->title}}
@endsection
@section('content')
<section class="mt-2">
  <div class="container">
    <div class="col-md-10 offset-md-1">
      <div class="featured-image" style="background: url({{ Storage::disk('local')->url($post->featuredImage->big) }}) center center no-repeat;">
        <div class="image-dimension">

        </div>
      </div>
      <div class="title sp-center mt-5">
        {{$post->title}}
      </div>
      <ol class="breadcrumb mt-5">
        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
        <li class="breadcrumb-item active">{{ $post->title }}</li>
      </ol>
      <div class="clearfix">
        <h4 class="mt-4">Scritto da {{$post->author->name}}</h4>
      </div>
      <div class="clearfix">
        <p class="mt-4">{!! $post->content !!}</p>
      </div>
    </div>
  </div>
</section>
@endsection
