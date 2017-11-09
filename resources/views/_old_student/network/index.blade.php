@extends('layouts.student')
@section('content')
  <section id="breadcrumbs mt-5 pt-5 px-5">
    <div class="row pt-5">
      <div class="col pt-5 px-5">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="#">Network</a></li>
        </ol>
      </div>
    </div>
  </section>
  <section id="main" class="pb-5 px-5">
    <div class="row">
      @foreach ($items as $key => $item)
        <div class="box col-md-4 mb-5">
          <div class="container-fluid">
            <div class="row">
              <div class="col {{ $item->colors[0] }}">
                @if ($item->media_type == 'image')
                  <img src="{{ $item->featured_media }}" alt="" class="img-fluid w-100">
                @elseif ($item->media_type == 'video')
                  <video class="embed-responsive-item video-js w-100" controls preload="auto" width="640" height="264">
                      <source src="{{ $item->featured_media }}" type="video/mp4">
                  </video>
                @endif
              </div>
            </div>
            <div class="row">
              <div class="col {{ $item->colors[1] }} py-3 px-5" >
                <h3>{{ $item->title }}</h3>
              </div>
            </div>
            <div class="row">
              <div class="col {{ $item->colors[0] }} px-5 pt-3 pb-5">
                <span class="badge badge-default mb-3">{{ $item->app_category }}</span>
                <span class="badge badge-default mb-3">{{ $item->app_name }}</span>
                <p>{{ $item->notes }}</p>
                <div class="">
                  <i class="fa fa-eye" aria-hidden="true"></i>
                  <i class="fa fa-heart" aria-hidden="true"></i>
                  <i class="fa fa-comment" aria-hidden="true"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </secion>
@endsection
