@extends('layouts.teacher')
@section('content')
<main id="main">
  <section class="pb-5 px-5">
    <div class="mt-5 pt-5"></div>
    <div class="row">
      @foreach ($items as $key => $item)
        <div class="box col-md-4 mb-5">
          <div class="container-fluid">
            <div class="row">
              <div class="col {{ $item->colors[1] }} py-3 px-5" >
                <h3>{{ $item->title }}</h3>
              </div>
            </div>
            <div class="row">
              <div class="col {{ $item->colors[0] }} px-5 pt-3 pb-5">
                <h6 class="d-inline-block"><span class="badge badge-default mb-3">{{ $item->app_category }}</span></h6>
                <h6 class="d-inline-block"><span class="badge badge-default mb-3">{{ $item->app_name }}</span></h6>
                <p>{{ $item->notes }}</p>

                <network-icons
                    comments="{{ $item->comments }}"
                ></network-icons>

                <div class="row">
                  <div class="col d-flex justify-content-around">
                    <a href="{{ route('teacher.network.single', $item->token) }}" class="btn btn-secondary btn-block btn-{{ $item->colors[0] }}">View</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </secion>
</main>
@endsection
@section('scripts')
  <script src="{{ mix('js/network.js') }}"></script>
@endsection
