@extends('layouts.teacher')
@section('content')
  <main id="main">
    <section id="breadcrumbs mt-5 pt-5 px-5">
      <div class="row pt-5">
        <div class="col pt-5 px-5">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('teacher.network.index') }}">Network</a></li>
          </ol>
        </div>
      </div>
    </section>
    <section>
      <article class="">
        <div class="row">
          <div class="col-md-8">
            <div class="box container-fluid px-5 mb-4">
              <div class="row">
                <div class="col dark-blue py-3 px-5">
                  <h3>{{ $item->title }}</h3>
                </div>
              </div>
              <div class="row">
                <div class="col blue p-5">
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
          <div class="col-md-4">
            <div class="box container-fluid pr-5 mb-4">
              <div class="row">
                <div class="col dark-yellow py-3 px-5">
                  <h3>Notes</h3>
                </div>
              </div>
              <div class="row">
                <div class="col yellow p-5">
                  <p>{{ $item->notes }}</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col">
            <div class="box container-fluid px-5 mb-4">
              <div class="row">
                <div class="col dark-orange py-3 px-5">
                  <h3>Comments</h3>
                </div>
              </div>
              <div class="row">
                <div class="col orange p-5">
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
                      user="{{ Auth::guard('teacher')->user() }}"
                  ></comment-list>

                </div>
              </div>
            </div>
          </div>
        </div>
      </article>
    </section>
  </main>
@endsection
@section('scripts')
  <script src="{{ mix('js/network-single.js') }}"></script>
@endsection
