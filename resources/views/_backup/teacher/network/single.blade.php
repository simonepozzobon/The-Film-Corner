@extends('layouts.teacher')
@section('title', $item->title)
@section('content')
  <div id="main" class="container">
    <div class="row mt">
      <div class="col">
        <div class="box blue">
          <div class="box-header">
            {{ $item->title }}
          </div>
          <div class="box-body">
            @if ($item->media_type == 'image')
              <img src="{{ $item->featured_media }}" alt="" class="img-fluid w-100">
            @elseif ($item->media_type == 'video')
              <video class="embed-responsive-item video-js w-100" controls preload="auto" width="640" height="264">
                  <source src="{{ $item->featured_media }}" type="video/mp4">
              </video>
            @endif
          </div>
        </div>
      </div>
    </div>
    <div class="row mt">
      <div class="col">
        <div class="box green">
          <div class="box-header">
            {{ GeneralText::field('notes') }}
          </div>
          <div class="box-body">
            {{ $item->notes }}
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-8 offset-md-2">
        <comment-new
            csrf_field="{{ csrf_token() }}"
            user_type="{{ get_class(Auth::guard('teacher')->user()) }}"
            user="{{ Auth::guard('teacher')->user() }}"
            commentable_type="App\SharedSession"
            commentable_id="{{ $item->id }}"
        ></comment-new>
        <comment-list
            comments="{{ $comments }}"
            user_type="{{ get_class(Auth::guard('teacher')->user()) }}"
            user="{{ Auth::guard('teacher')->user() }}"></comment-list>
      </div>
    </div>
  </div>
@endsection
@section('scripts')
  <script src="{{ mix('js/network-single.js') }}"></script>
@endsection
