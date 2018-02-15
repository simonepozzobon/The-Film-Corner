@extends('layouts.student')
@section('title', 'Network')
@section('content')
  <div id="main" class="container">
    @include('components.apps.heading_simple', ['title' => 'Network'])
    <div class="row">
      @foreach ($items as $key => $item)
        <div class="col-md-4">
          <div class="box {{ $item->colors[0] }} mt">
            <div class="box-header">
              {{ $item->title }}
            </div>
            <div class="box-body">
              <h6 class=""><span class="badge badge-dark-{{ $item->colors[0] }}">{{ $item->app_category }}</span></h6>
              <h6 class=""><span class="badge badge-dark-{{ $item->colors[0] }}">{{ $item->app_name }}</span></h6>
                <p>{{ substr(strip_tags($item->notes), 0, 400) }}{{ strlen(strip_tags($item->notes)) > 400 ? '...' : "" }}</p>
            </div>
            <div class="box-body">
              <network-icons
                  views="{{ $item->views }}"
                  comments="{{ $item->comments }}"
                  likes="{{ $item->likes }}"
                  liked="{{ $item->liked }}"
                  user="{{ Auth::guard('student')->user() }}"
                  user_type="{{ get_class(Auth::guard('student')->user()) }}"
                  likeable_type="App\SharedSession"
                  likeable_id="{{ $item->id }}"
              ></network-icons>
            </div>
            <div class="box-btns">
              <a href="{{ route('student.network.single', $item->token) }}" class="btn btn-block btn-{{ $item->colors[0] }}">View</a>
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
