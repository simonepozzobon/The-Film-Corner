@extends('layouts.teacher')
@section('title', 'Network')
@section('content')
  <div id="main" class="container">
    @include('components.apps.heading_only', ['title' => 'Network'])
    <div class="row">
      @foreach ($items as $key => $item)
        <div class="col-md-4">
          <div class="box {{ $item->colors[0] }} mt">
            <div class="box-header">
              {{ $item->title }}
            </div>
            <div class="box-body">
              <h6 class="d-inline-block"><span class="badge badge-default">{{ $item->app_category }}</span></h6>
              <h6 class="d-inline-block"><span class="badge badge-default">{{ $item->app_name }}</span></h6>
                {{ $item->notes }}
            </div>
            <div class="box-body">
              <network-icons
                  views="{{ $item->views }}"
                  comments="{{ $item->comments }}"
                  likes="{{ $item->likes }}"
                  liked="{{ $item->liked }}"
                  user="{{ Auth::guard('teacher')->user() }}"
                  user_type="{{ get_class(Auth::guard('teacher')->user()) }}"
                  likeable_type="App\SharedSession"
                  likeable_id="{{ $item->id }}"
              ></network-icons>
            </div>
            <div class="box-btns">
              <a href="{{ route('teacher.network.single', $item->token) }}" class="btn btn-block btn-{{ $item->colors[0] }}">View</a>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>
@endsection
@section('scripts')
  <script src="{{ mix('js/network.js') }}"></script>
@endsection
