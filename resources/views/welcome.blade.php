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
        <svg class="arrows">
							<path class="a1" d="M0 0 L15 16 L30 0"></path>
							<path class="a2" d="M0 10 L15 26 L30 10"></path>
							<path class="a3" d="M0 20 L15 36 L30 20"></path>
				</svg>
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
                <div class="grid-caption">
                  <h1>{{ $post->title }}</h1>
                  <p>{{ $post->content }}</p>
                </div>
              </div>
            @endforeach
          </div>
        </section>
@endsection
