@extends('layouts.main')
@section('title')
  {{$post->title}}
@endsection
@section('content')
<section class="hero" style="background: url({{ Storage::disk('local')->url($post->featuredImage->big) }});">
  <div class="flex-center position-ref full-height">
  </div>
</section>
<section class="mt-5">
  <div class="container">
    <div class="col-md-10 offset-md-1">
      <div class="title sp-center">
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
        <p class="mt-4">{{$post->content}}</p>
      </div>
    </div>
  </div>
</section>
@endsection
