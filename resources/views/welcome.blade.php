@extends('layouts.main')
@section('title')
  Home Page
@endsection
@section('content')
        <section class="hero home">
        <div class="flex-center position-ref full-height">

            <div class="content">
                <div class="logo">
                  <img src="/img/logo.png">
                </div>
                <div class="title m-b-md">
                    The Film Corner
                </div>

                <div class="links">
                  <a href="#">The Project</a>
                  <a href="#">Partners</a>
                  <a href="#">Apps</a>
                  <a href="#">Resources</a>
                  <a href="#">Login</a>
                </div>
            </div>
        </div>
        <section>
          <div class="title sp-center">
            News
          </div>
          @if (count($posts)===0)
            <h1>No posts to show</h1>
          @endif
          <div class="grid">
            @foreach ($posts as $post)
              <div class="grid-item">
                <div class="overlay"></div>
                <img class="" src="{{ Storage::disk('local')->url($post->featuredImage->url) }}">
                <a href="/post/{{ $post->id }}">
                <div class="grid-caption">
                  <h1>{{ $post->title }}</h1>
                  <p>{{ $post->category->name }}</p>
                </div>
                </a>
              </div>
            @endforeach
          </div>
        </section>
@endsection
